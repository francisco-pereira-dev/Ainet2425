<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Mail\OrderCompleted;
use App\Models\Order;
use App\Models\ItemOrder;
use Illuminate\Support\Facades\Auth;
use App\Models\ShippingCost; 

class OrderController extends Controller
{
    /**
     * Lista as encomendas com status 'preparing'
     */
    public function pending()
    {
        $user = auth()->user();

        $orders = Order::where('status', 'pending')
            ->when(
                // Se não for board ou employee, filtra só pelo member_id do próprio user
                ! ($user->isBoard() || $user->isEmployee()),
                fn($q) => $q->where('member_id', $user->id)
            )
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('orders.pending', compact('orders'));
    }

    /**
     * Lista as encomendas concluídas
     */
    public function completed()
    {
        $user = auth()->user();

        $orders = Order::where('status', 'completed')
            ->when(
                ! ($user->isBoard() || $user->isEmployee()),
                fn($q) => $q->where('member_id', $user->id)
            )
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('orders.completed', compact('orders'));
    }

    /**
     * Marcar encomenda como concluída (não altera aqui o fluxo de store)
     */
    public function complete(Order $order)
    {
        
        foreach ($order->items as $item) {
            if ($item->product->stock < $item->quantity) {
                return redirect()->back()->with('error', 'Produto sem stock suficiente: ' . $item->product->name);
            }
        }

        foreach ($order->items as $item) {
            $item->product->decrement('stock', $item->quantity);
        }

        // Gera o PDF
        $pdf = Pdf::loadView('pdf.receipt', compact('order'));
        $filename = 'order_' . $order->id . '.pdf';


        // Grava em 'storage/app/private/receipts/order_X.pdf'
        Storage::put('receipts/'.$filename, $pdf->output());

        // Atualiza o BD
        $order->update([
            'status'      => 'completed',
            'pdf_receipt' => $filename,
        ]);

        if ($order->member && $order->member->email) {
            Mail::to($order->member->email)->send(new OrderCompleted($order));
        }

        return redirect()->route('orders.pending')->with('success', 'Encomenda marcada como concluída.');
    }

    /**
     * Cancelar encomenda
     */
    public function cancel(Request $request, Order $order)
    {
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
        ]);

        $order->update([
            'status' => 'canceled',
            'cancel_reason' => $request->cancel_reason,
        ]);

        return redirect()->route('orders.pending')->with('success', 'Encomenda cancelada com sucesso.');
    }

    /**
     * Criar nova encomenda a partir do carrinho
     */
    
    public function store(Request $request)
    {
        $request->validate([
            'nif'     => 'nullable|string|max:20',
            'address' => 'required|string|max:255',
        ]);

        $cart = session('cart',[]);
        if (empty($cart)) {
            return redirect()->route('cart.index')
                             ->with('error','O carrinho está vazio.');
        }

        $user = Auth::user();
        $total = 0;
        foreach ($cart as $item) {
            $price = $item['price'];
            if (!empty($item['discount'])) {
                $price *= (1 - $item['discount']/100);
            }
            $total += $price * $item['quantity'];
        }
        /** @var ShippingCost|null $cfg */
        $cfg = ShippingCost::where('min_value_threshold', '<=', $total)
                           ->where('max_value_threshold', '>',  $total)
                           ->first();

        $shippingCost = $cfg
            ? $cfg->shipping_cost
            : 0;
        $finalTotal   = $total + $shippingCost;

        if (! $user->isMember()) {
            return redirect()->route('cart.index')
                             ->with('error','Só membros podem efetuar compras.');
        }
        if (! $user->card || $user->card->balance < $finalTotal) {
            return redirect()->route('cart.index')
                             ->with('error','Saldo insuficiente.');
        }

        // cria encomenda
        $order = Order::create([
            'member_id'        => $user->id,
            'date'             => now()->toDateString(),
            'total_items'      => $total,
            'shipping_cost'    => $shippingCost,
            'total'            => $finalTotal,
            'nif'              => $request->nif,
            'delivery_address' => $request->address,
            'status'           => 'pending',
        ]);

        // itens
        foreach ($cart as $pid => $item) {
            $unit = $item['price'] * (1 - ($item['discount']??0)/100);
            ItemOrder::create([
                'order_id'   => $order->id,
                'product_id' => $pid,
                'quantity'   => $item['quantity'],
                'unit_price' => $unit,
                'discount'   => $item['discount'] ?? 0,
                'subtotal'   => $unit * $item['quantity'],
            ]);
        }

        // debita saldo e limpa carrinho
        $card = $user->card;
        $card->balance -= $finalTotal;
        $card->save();
        session()->forget('cart');

        // feedback
        return redirect()->route('orders.completed')
                         ->with('info','A encomenda está pendente; será processada em breve.');
    }
}

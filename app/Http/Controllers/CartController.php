<?php

namespace App\Http\Controllers;
use App\Models\ShippingCost;
use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = session()->get('cart', []);
        $total = 0;

        // calcula subtotal dos produtos
        foreach ($cart as $item) {
            $price = $item['price'];
            if (!empty($item['discount'])) {
                $price *= (1 - $item['discount'] / 100);
            }
            $total += $price * $item['quantity'];
        }

        // busca a regra de portes adequada
        $regra = ShippingCost::where('min_value_threshold', '<=', $total)
                            ->where('max_value_threshold', '>',  $total)
                            ->first();
        $shippingCost = $regra ? $regra->shipping_cost : 0;

        // soma o total final
        $finalTotal = $total + $shippingCost;

        // envia TUDO para a view
        return view('cart.index', compact('cart', 'total', 'shippingCost', 'finalTotal'));
    }

    public function add(Request $request, $id)
    {

        $product = Product::findOrFail($id);

        // Garante que a quantidade recebida é um número válido (mínimo 1)
        $quantity = max((int) $request->input('quantity', 1), 1);

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['quantity']+= $quantity;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'discount' => $product->discount,
                'discount_min_qty' => $product->discount_min_qty,
                'stock' => $product->stock,
                'quantity' => $quantity,
            ];
        }
        session(['cart' => $cart]);
        return back()->with('success','Produto adicionado ao carrinho!');
    }

    public function update(Request $request, $id)
    {
        $cart = session('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['quantity'] = max(1, (int)$request->quantity);
            session(['cart' => $cart]);
        }
        return redirect()->route('cart.index')->with('success','Carrinho atualizado.');
    }

    public function remove($id)
    {
        $cart = session('cart', []);
        unset($cart[$id]);
        session(['cart'=>$cart]);
        return redirect()->route('cart.index')->with('success','Produto removido do carrinho.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success','Carrinho limpo.');
    }
}

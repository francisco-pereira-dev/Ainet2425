<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\ItemOrder;
use App\Models\Card;
use App\Models\Operation;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function dashboard()
    {
        $totalVendas = Order::sum('total');
        $numVendas = Order::count();

        $vendasPorMes = Order::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as mes'),
                DB::raw('SUM(total) as total')
            )
            ->groupBy('mes')
            ->orderBy('mes', 'desc')
            ->limit(12)
            ->get()->reverse();

        // ALTERAÇÃO: Top Produtos mostra nome ou "Desconhecido"
        $topProdutos = DB::table('items_orders')
            ->join('products', 'items_orders.product_id', '=', 'products.id')
            ->select('products.name', DB::raw('SUM(items_orders.quantity) as total_qty'))
            ->groupBy('products.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();


        $topCategorias = DB::table('items_orders')
            ->join('products', 'items_orders.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(items_orders.quantity) as total_qty'))
            ->groupBy('categories.name')
            ->orderByDesc('total_qty')
            ->limit(5)
            ->get();

        $totalMembros = User::count();
        $saldoTotal = Card::sum('balance');
        $mediaEncomenda = Order::avg('total');
        $pendentes = Order::where('status', 'pending')->count();
        $concluidas = Order::where('status', 'completed')->count();

        $pagamentos = Operation::select('payment_type', DB::raw('COUNT(*) as count'))
            ->groupBy('payment_type')
            ->get();

        $stockBaixo = Product::whereColumn('stock', '<', 'stock_lower_limit')->get();

        $chartVendas = new \ConsoleTVs\Charts\Classes\Chartjs\Chart();
        $chartVendas->labels($vendasPorMes->pluck('mes')->toArray());
        $chartVendas->dataset('Vendas por Mês', 'line', $vendasPorMes->pluck('total')->toArray())
            ->color('#4ade80')->backgroundColor('#bbf7d0');

        $chartCategorias = new \ConsoleTVs\Charts\Classes\Chartjs\Chart();
        $chartCategorias->labels($topCategorias->pluck('name')->toArray());
        $chartCategorias->dataset('Vendas por Categoria', 'pie', $topCategorias->pluck('total_qty')->toArray())
            ->backgroundColor(['#60a5fa', '#818cf8', '#f472b6', '#facc15', '#34d399']);

        return view('statistics.dashboard', compact(
            'totalVendas','numVendas','topProdutos','topCategorias','totalMembros',
            'saldoTotal','mediaEncomenda','pendentes','concluidas','pagamentos','stockBaixo',
            'chartVendas','chartCategorias'
        ));
    }

    public function export()
    {
        // 1) Carrega a relação correta:
        $orders = Order::with('member')->get();

        $filename = 'orders_' . now()->format('Ymd_His') . '.csv';
        $handle   = fopen($filename, 'w+');

        // 2) Cabeçalho do CSV (colunas)
        fputcsv($handle, ['ID', 'Membro', 'Total', 'Status', 'Data']);

        foreach ($orders as $order) {
            fputcsv($handle, [
                $order->id,
                // usa member (e não user)
                $order->member->name      ?? '',
                number_format($order->total, 2, '.', ''),
                ucfirst($order->status),
                $order->created_at->toDateTimeString(),
            ]);
        }

        fclose($handle);

        return response()
            ->download($filename)
            ->deleteFileAfterSend(true);
    }
}

@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Estatísticas do Clube</h1>

    {{-- Cards de resumo --}}
    <div class="row g-3 mb-5">
        <div class="col-6 col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="fw-semibold">Vendas Totais</div>
                    <div class="h4 text-success pt-2">€{{ number_format($totalVendas, 2, ',', '.') }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="fw-semibold">N.º de Vendas</div>
                    <div class="h4 pt-2">{{ $numVendas }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="fw-semibold">Membros</div>
                    <div class="h4 pt-2">{{ $totalMembros }}</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card shadow-sm">
                <div class="card-body text-center">
                    <div class="fw-semibold">Saldo Total em Cartões</div>
                    <div class="h4 text-primary pt-2">€{{ number_format($saldoTotal, 2, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Gráficos lado a lado --}}
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="mb-0">Vendas por Mês</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px;">
                        {!! $chartVendas->container() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="mb-0">Distribuição por Categoria</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 300px;">
                        {!! $chartCategorias->container() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Listas de top produtos e categorias --}}
    <div class="row g-4 mb-5">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="mb-0">Top Produtos</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        @foreach($topProdutos as $item)
                            <li>
                                {{ $item->name ?? 'Desconhecido' }} — {{ $item->total_qty }} vendas
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-header">
                    <h5 class="mb-0">Top Categorias</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        @foreach($topCategorias as $cat)
                            <li>• {{ $cat->name }} — {{ $cat->total_qty }} vendas</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Botão de exportação --}}
    <div class="text-end">
        <a href="{{ route('statistics.export') }}" class="btn btn-outline-primary">
            Exportar encomendas (CSV)
        </a>
    </div>
</div>
@endsection

@push('scripts')
    @if(isset($chartVendas))
        {!! $chartVendas->script() !!}
    @endif
    @if(isset($chartCategorias))
        {!! $chartCategorias->script() !!}
    @endif
@endpush

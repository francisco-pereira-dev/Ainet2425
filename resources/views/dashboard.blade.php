@extends('layouts.app')

@section('content')
<div class="container py-5 max-w-3xl mx-auto">
    <h1 class="mb-6 text-2xl font-bold text-center text-gray-800">Painel de Controlo</h1>

    <div class="space-y-5">

        {{-- Perfil --}}
        <div class="bg-white shadow-sm rounded p-4">
            <h2 class="text-lg font-semibold text-gray-800">Perfil</h2>
            <p class="text-sm text-gray-600 mb-2">Ver e editar os teus dados pessoais.</p>
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Aceder</a>
        </div>

        {{-- Catálogo --}}
        <div class="bg-white shadow-sm rounded p-4">
            <h2 class="text-lg font-semibold text-gray-800">Catálogo</h2>
            <p class="text-sm text-gray-600 mb-2">Explora e compra os produtos disponíveis.</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary">Aceder</a>
        </div>

        {{-- Cartão Virtual --}}
        <div class="bg-white shadow-sm rounded p-4">
            <h2 class="text-lg font-semibold text-gray-800">Cartão Virtual</h2>
            <p class="text-sm text-gray-600 mb-2">Consultar saldo e histórico de operações.</p>
            <a href="{{ route('card.show') }}" class="btn btn-primary">Aceder</a>
        </div>

        {{-- Gerir Categorias --}}
        @if(auth()->user()->isEmployee() || auth()->user()->isBoard())
        <div class="bg-white shadow-sm rounded p-4">
            <h2 class="text-lg font-semibold text-green-600">Gerir Categoria</h2>
            <p class="text-sm text-gray-600 mb-2">Visualiza, adiciona ou edita Categorias do catálogo.</p>
            <a href="{{ route('categories.index') }}" class="btn btn-primary">Aceder</a>
        </div>
        @endif

        {{-- Gerir Produtos --}}
        @if(auth()->user()->isEmployee() || auth()->user()->isBoard())
        <div class="bg-white shadow-sm rounded p-4">
            <h2 class="text-lg font-semibold text-green-600">Gerir Produtos</h2>
            <p class="text-sm text-gray-600 mb-2">Visualiza, adiciona ou edita os produtos do catálogo.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Aceder</a>
        </div>
        @endif


        {{-- Encomendas Concluídas --}}
        <div class="bg-white shadow-sm rounded p-4">
            <h2 class="text-lg font-semibold text-gray-800">Encomendas Concluídas</h2>
            <p class="text-sm text-gray-600 mb-2">Consulta o teu histórico de encomendas.</p>
            <a href="{{ route('orders.completed') }}" class="btn btn-primary">Aceder</a>
        </div>

        {{-- Encomendas Pendentes (funcionário ou direção) --}}
        @if(auth()->user()->isEmployee() || auth()->user()->isBoard())
        <div class="bg-white shadow-sm rounded p-4">
            <h2 class="text-lg font-semibold text-gray-800">Encomendas Pendentes</h2>
            <p class="text-sm text-gray-600 mb-2">Visualiza e processa encomendas por concluir.</p>
            <a href="{{ route('orders.pending') }}" class="btn btn-primary">Aceder</a>
        </div>
        @endif

        {{-- Membership Fee e Custos de Envio (direção) --}}
        @if(auth()->user()->isBoard())
        <div class="bg-white shadow-sm rounded p-4">
            <h2 class="text-lg font-semibold text-yellow-600">Mensalidade (Membership Fee)</h2>
            <p class="text-sm text-gray-600 mb-2">Define o valor mensal pago pelos membros.</p>
            <a href="{{ route('settings.membership.edit') }}" class="btn btn-primary">Aceder</a>
        </div>

        <div class="bg-white shadow-sm rounded p-4">
            <h2 class="text-lg font-semibold text-pink-600">Custos de Envio</h2>
            <p class="text-sm text-gray-600 mb-2">Gerir thresholds e valores de envio.</p>
            <a href="{{ route('shipping-costs.index') }}" class="btn btn-primary">Aceder</a>
        </div>
        @endif

        {{-- Estatísticas (direção) --}}
        @if(auth()->user()->isBoard())
        <div class="bg-white shadow-sm rounded p-4">
            <h2 class="text-lg font-semibold text-yellow-600">Estatísticas</h2>
            <p class="text-sm text-gray-600 mb-2">Acede às estatísticas gerais.</p>
            <a href="{{ route('statistics.dashboard') }}" class="btn btn-primary">Aceder</a>
        </div>
        @endif

    </div>
</div>
@endsection

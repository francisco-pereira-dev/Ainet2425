@extends('layouts.app')
@php 
use Illuminate\Support\Facades\Storage; 
@endphp

@section('content')
    @if(session('success'))
        <!-- Modal Overlay -->
        <div id="popup-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center; z-index: 50;">
            <div style="background-color: white; padding: 2rem; border-radius: 0.5rem; text-align: center; max-width: 400px;">
                <h2 class="text-lg font-semibold mb-3">Produto adicionado ao carrinho!</h2>
                <div class="flex justify-center gap-8">
                    <a href="{{ route('catalog.index') }}"
                    class="bg-gray-300 px-3 py-2 rounded hover:bg-gray-400">
                    Continuar Compras
                    </a>
                    <a href="{{ route('cart.index') }}"
                    class="text-lg font-semibold mb-3">
                    Ir para o Carrinho
                    </a>
                </div>
            </div>
        </div>

        <script>
            setTimeout(() => {
                const modal = document.getElementById('popup-overlay');
                if (modal) modal.style.display = 'none';
            }, 5000);
        </script>
    @endif
<div class="container">
    <h2 class="mb-4 text-center">Catálogo de Produtos</h2>

    {{-- Filtros --}}
    <form method="GET" class="row mb-4">
        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="">Todas as Categorias</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <select name="sort" class="form-select">
                <option value="">Ordenar por</option>
                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nome</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Preço (↑)</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Preço (↓)</option>
            </select>
        </div>
        <div class="col-md-4 d-grid">
            <button type="submit" class="btn btn-primary">Aplicar</button>
        </div>
    </form>

    {{-- Lista de Produtos --}}
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($products as $product)
        @php
            $hasDiscount = $product->discount && $product->discount_min_qty;
            $discountedPrice = $hasDiscount ? $product->price - $product->discount : $product->price;
        @endphp

        <div class="col">
            <div class="card h-100 shadow-sm position-relative">
                {{-- Badge de desconto --}}
                @if($hasDiscount)
                    <span class="position-absolute top-0 start-0 bg-danger text-white px-2 py-1 rounded-end">
                        Promoção
                    </span>
                @endif

                {{-- Badge de esgotado --}}
                @if($product->stock <= 0)
                    <span class="position-absolute top-0 end-0 bg-dark text-white px-2 py-1 rounded-start">
                        Esgotado
                    </span>
                @endif

                {{-- Imagem: fixar altura e usar object-fit --}}
                @if ($product->photo && Storage::disk('public')->exists('products/' . $product->photo))
                {{-- Dentro do teu card Blade --}}
                <div class="overflow-hidden rounded-t">
                <img
                    src="{{ asset('storage/products/' . $product->photo) }}"
                    alt="{{ $product->name }}"
                    class="w-full h-48 object-cover"
                    style="object-fit: cover; max-height: 200px;"
                >
                </div>
                @else
                <div class="text-center text-muted py-4">
                    Sem imagem
                </div>
                @endif

                {{-- Conteúdo do Card --}}

                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-muted">{{ $product->description }}</p>
                        <p class="card-text"><strong>Categoria:</strong> {{ $product->category->name }}</p>

                        @if($hasDiscount)
                            <p class="text-danger mb-1">Desconto: -{{ number_format($product->discount, 2) }}€ a partir de {{ $product->discount_min_qty }} unidades</p>
                            <p class="mb-1"><del>{{ number_format($product->price, 2) }}€</del></p>
                            <p class="text-success fw-bold">{{ number_format($discountedPrice, 2) }}€</p>
                        @else
                            <p class="fw-bold">{{ number_format($product->price, 2) }}€</p>
                        @endif
                    </div>

                    <div class="mt-3">
                        <form method="POST" action="{{ route('cart.add', $product->id) }}">
                            @csrf
                            <div class="input-group">
                                <input type="number" name="quantity" class="form-control" min="1" value="1"
                                    style="max-width: 80px;" @if($product->stock <= 0) disabled @endif>
                                <button type="submit" class="btn btn-primary"
                                        @if($product->stock <= 0) disabled @endif>
                                    Adicionar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>


<div class="d-flex justify-content-center mt-4">
    {{ $products->onEachSide(1)->links('pagination::bootstrap-5') }}
</div>

@endsection
@php
    use Illuminate\Support\Facades\Storage;
@endphp
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Produtos</h1>

        <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Novo Produto</a>
        <form action="{{ route('products.index') }}" method="GET" class="mb-4 d-flex align-items-center gap-3">
            <label for="category" class="form-label mb-0">Filtrar por Categoria:</label>
            <select name="category" id="category" class="form-select w-auto" onchange="this.form.submit()">
                <option value="">Todas</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @if ($categoryId)
                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary btn-sm">Limpar filtro</a>
            @endif
        </form>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Preço</th>
                    <th>Stock</th>
                    <th>Imagem</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @php
                    use Illuminate\Support\Facades\File;

                    $productImages = File::files(public_path('storage/products'));
                @endphp

                @foreach ($products as $index => $product)
                    @php
                        $imagePath = isset($productImages[$index]) ? 'storage/products/' . $productImages[$index]->getFilename() : null;
                    @endphp
                    <tr>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>{{ number_format($product->price, 2) }} €</td>

                        <td>
                            @if ($product->stock < $product->stock_lower_limit)
                                <span class="text-danger fw-bold">
                                    {{ $product->stock }}  Baixo
                                </span>
                            @elseif ($product->stock > $product->stock_upper_limit)
                                <span class="text-warning fw-bold">
                                    {{ $product->stock }}  Excedido
                                </span>
                            @else
                                {{ $product->stock }}
                            @endif
                        </td>

                        <td>
                            @if($product->photo && Storage::disk('public')->exists('products/' . $product->photo))
                                <img 
                                src="{{ asset('storage/products/' . $product->photo) }}"
                                alt="{{ $product->name }}"
                                width="60"
                                >
                            @else
                                N/A
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-primary">Editar</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Editar Produto</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('products.update', $product) }}"
          method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">Nome</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name',$product->name) }}" required>
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Categoria</label>
                <select name="category_id" class="form-select" required>
                    <option value="">Escolha...</option>
                    @foreach($categories as $cat)
                    <option
                      value="{{ $cat->id }}"
                      @selected(old('category_id',$product->category_id)==$cat->id)
                    >{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-md-4">
                <label class="form-label">Preço (€)</label>
                <input type="number" step="0.01" name="price"
                       class="form-control"
                       value="{{ old('price',$product->price) }}" required>
            </div>
            <div class="mb-3 col-md-4">
                <label class="form-label">Stock</label>
                <input type="number" name="stock"
                       class="form-control"
                       value="{{ old('stock',$product->stock) }}" required>
            </div>
            <div class="mb-3 col-md-4">
                <label class="form-label">Foto Atual</label><br>

                @if($product->photo)
                <img
                    src="{{ asset('storage/products/' . $product->photo) }}"
                    alt="Foto atual de {{ $product->name }}"
                    width="80"
                    class="img-thumbnail mb-2"
                >
                @endif

                <input
                    type="file"
                    name="photo"
                    class="form-control"
                    accept="image/*"
                >
                
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="description" rows="3"
                      class="form-control" required
            >{{ old('description',$product->description) }}</textarea>
        </div>

        <div class="row">
            <div class="mb-3 col-md-4">
                <label class="form-label">Qtd. Mín. p/ Desconto</label>
                <input type="number" name="discount_min_qty"
                       class="form-control"
                       value="{{ old('discount_min_qty',$product->discount_min_qty) }}">
            </div>
            <div class="mb-3 col-md-4">
                <label class="form-label">Desconto (€)</label>
                <input type="number" step="0.01" name="discount"
                       class="form-control"
                       value="{{ old('discount',$product->discount) }}">
            </div>
            <div class="mb-3 col-md-4">
                <label class="form-label">Limite Inferior Stock</label>
                <input type="number" name="stock_lower_limit"
                       class="form-control"
                       value="{{ old('stock_lower_limit',$product->stock_lower_limit) }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Limite Superior Stock</label>
            <input type="number" name="stock_upper_limit"
                   class="form-control"
                   value="{{ old('stock_upper_limit',$product->stock_upper_limit) }}" required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Atualizar Produto</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection

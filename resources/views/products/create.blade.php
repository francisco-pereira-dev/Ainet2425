@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Criar Produto</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Note o enctype --}}
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="mb-3 col-md-6">
                <label class="form-label">Nome</label>
                <input type="text" name="name"
                       class="form-control" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3 col-md-6">
                <label class="form-label">Categoria</label>
                <select name="category_id" class="form-select" required>
                    <option value="">Escolha...</option>
                    @foreach($categories as $cat)
                    <option 
                      value="{{ $cat->id }}"
                      @selected(old('category_id')==$cat->id)
                    >{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="mb-3 col-md-4">
                <label class="form-label">Preço (€)</label>
                <input type="number" step="0.01" name="price"
                       class="form-control" value="{{ old('price') }}" required>
            </div>
            <div class="mb-3 col-md-4">
                <label class="form-label">Stock</label>
                <input type="number" name="stock"
                       class="form-control" value="{{ old('stock') }}" required>
            </div>
            <div class="mb-3 col-md-4">
                <label class="form-label">Foto</label>
                <input type="file" name="photo"
                       class="form-control" accept="image/*">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="description" class="form-control" rows="3"
                      required>{{ old('description') }}</textarea>
        </div>

        <div class="row">
            <div class="mb-3 col-md-4">
                <label class="form-label">Qtd. Mín. p/ Desconto</label>
                <input type="number" name="discount_min_qty"
                       class="form-control" value="{{ old('discount_min_qty') }}">
            </div>
            <div class="mb-3 col-md-4">
                <label class="form-label">Desconto (€)</label>
                <input type="number" step="0.01" name="discount"
                       class="form-control" value="{{ old('discount') }}">
            </div>
            <div class="mb-3 col-md-4">
                <label class="form-label">Limite Inferior Stock</label>
                <input type="number" name="stock_lower_limit"
                       class="form-control" value="{{ old('stock_lower_limit') }}" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Limite Superior Stock</label>
            <input type="number" name="stock_upper_limit"
                   class="form-control" value="{{ old('stock_upper_limit') }}" required>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Criar Produto</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection

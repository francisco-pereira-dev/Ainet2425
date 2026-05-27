<div class="row">
    <div class="mb-3 col-md-6">
        <label for="name" class="form-label">Nome</label>
        <input type="text" class="form-control" name="name" value="{{ old('name', $product->name ?? '') }}" required>
    </div>

    <div class="mb-3 col-md-6">
        <label for="category_id" class="form-label">Categoria</label>
        <select name="category_id" class="form-select" required>
            <option value="">Escolher...</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="row">
    <div class="mb-3 col-md-4">
        <label for="price" class="form-label">Preço (€)</label>
        <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price', $product->price ?? '') }}" required>
    </div>

    <div class="mb-3 col-md-4">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" class="form-control" name="stock" value="{{ old('stock', $product->stock ?? '') }}" required>
    </div>

    <div class="mb-3 col-md-4">
        <label for="photo" class="form-label">Foto (URL ou nome de ficheiro)</label>
        <input type="text" class="form-control" name="photo" value="{{ old('photo', $product->photo ?? '') }}">
    </div>
</div>

<div class="row">
    <div class="mb-3 col-md-4">
        <label for="discount" class="form-label">Desconto (€)</label>
        <input type="number" step="0.01" class="form-control" name="discount" value="{{ old('discount', $product->discount ?? '') }}">
    </div>

    <div class="mb-3 col-md-4">
        <label for="discount_min_qty" class="form-label">Qtd. Mín. p/ Desconto</label>
        <input type="number" class="form-control" name="discount_min_qty" value="{{ old('discount_min_qty', $product->discount_min_qty ?? '') }}">
    </div>

    <div class="mb-3 col-md-4">
        <label for="description" class="form-label">Descrição</label>
        <textarea class="form-control" name="description" rows="2">{{ old('description', $product->description ?? '') }}</textarea>
    </div>
</div>

<div class="row">
    <div class="mb-3 col-md-6">
        <label for="stock_lower_limit" class="form-label">Stock Mínimo</label>
        <input type="number" class="form-control" name="stock_lower_limit" value="{{ old('stock_lower_limit', $product->stock_lower_limit ?? '') }}">
    </div>

    <div class="mb-3 col-md-6">
        <label for="stock_upper_limit" class="form-label">Stock Máximo</label>
        <input type="number" class="form-control" name="stock_upper_limit" value="{{ old('stock_upper_limit', $product->stock_upper_limit ?? '') }}">
    </div>
</div>

@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-md">
    <h1 class="text-2xl font-bold mb-4">Editar Categoria</h1>

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $e)<li>{{$e}}</li>@endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('categories.update', $category) }}"
          method="POST"
          enctype="multipart/form-data">
      @csrf @method('PUT')

      <div class="mb-4">
        <label class="block mb-1">Nome</label>
        <input type="text" name="name"
               class="w-full border rounded p-2"
               value="{{ old('name',$category->name) }}" required>
      </div>

      <div class="mb-4">
        <label class="block mb-1">Imagem atual</label><br>
        @if($category->image)
          <img src="{{ asset('storage/categories/'.$category->image) }}"
               width="100" class="mb-2 rounded">
        @endif
        <input type="file" name="image"
               class="w-full border rounded p-2"
               accept="image/*">
      </div>

      <button class="btn btn-primary w-full py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
        Atualizar
      </button>
    </form>
</div>
@endsection
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-md">
    <h1 class="text-2xl font-bold mb-4">Nova Categoria</h1>

    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach($errors->all() as $e)<li>{{$e}}</li>@endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('categories.store') }}"
          method="POST"
          enctype="multipart/form-data">
      @csrf

      <div class="mb-4">
        <label class="block mb-1">Nome</label>
        <input type="text" name="name"
               class="w-full border rounded p-2"
               value="{{ old('name') }}" required>
      </div>

      <div class="mb-4">
        <label class="block mb-1">Imagem (opcional)</label>
        <input type="file" name="image"
               class="w-full border rounded p-2"
               accept="image/*">
      </div>

      <button class="btn btn-primary w-full py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
        Guardar
      </button>
    </form>
</div>
@endsection
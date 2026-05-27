@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-3xl font-bold mb-0">Categorias</h1>
        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            Nova Categoria
        </a>
    </div>

    @if(session('success'))
      <div class="alert alert-success shadow rounded mb-4 text-center" style="font-size:1.2em;">
          {{ session('success') }}
      </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      @php use Illuminate\Support\Facades\Storage; @endphp
      @foreach($categories as $category)
      <div class="bg-white rounded-lg shadow-md p-4 text-center">
        @if($category->image
             && Storage::disk('public')->exists('categories/'.$category->image))
          <img src="{{ asset('storage/categories/'.$category->image) }}"
               class="w-40 h-40 object-cover rounded mx-auto mb-4">
        @else
          <div class="w-40 h-40 bg-gray-100 rounded mx-auto mb-4
                      flex items-center justify-center text-gray-500">
            Sem imagem
          </div>
        @endif

        <h2 class="text-lg font-semibold mb-2">{{ $category->name }}</h2>
        <div class="d-flex justify-content-center gap-2">
              <a href="{{ route('categories.edit', $category) }}" class="btn btn-success btn-sm px-3">Editar</a>
              <form action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Confirmar eliminação?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger btn-sm px-3">Eliminar</button>
              </form>
          </div>

      </div>
      @endforeach
    </div>
</div>
@endsection
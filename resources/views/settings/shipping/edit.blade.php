@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6 max-w-md">
    <h1 class="text-2xl font-bold mb-4">Editar Custo de Envio</h1>

    <form action="{{ route('shipping-costs.update', $shippingCost) }}" method="POST" class="bg-white p-4 shadow rounded">
        @csrf
        @method('PUT')

        <label class="block mb-2 font-semibold">Valor mínimo (€)</label>
        <input type="number" step="0.01" name="min_value_threshold" value="{{ $shippingCost->min_value_threshold }}" class="border rounded w-full p-2 mb-4" required>
        <br>
        <label class="block mb-2 font-semibold">Valor máximo (€)</label>
        <input type="number" step="0.01" name="max_value_threshold" value="{{ $shippingCost->max_value_threshold }}" class="border rounded w-full p-2 mb-4" required>
        <br>
        <label class="block mb-2 font-semibold">Custo de envio (€)</label>
        <input type="number" step="0.01" name="shipping_cost" value="{{ $shippingCost->shipping_cost }}" class="border rounded w-full p-2 mb-4" required>
        <br>
        <button type="submit" class="btn btn-primary w-full py-2 px-4 bg-blue-600 text-white rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
            Atualizar
        </button>
    </form>
</div>
@endsection
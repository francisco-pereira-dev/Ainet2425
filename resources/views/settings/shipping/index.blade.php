@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-2xl font-bold mb-0">Custos de Envio</h1>
        <a href="{{ route('shipping-costs.create') }}" class="btn btn-primary">
            Adicionar Custo
        </a>
    </div>


    @if (session('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">{{ session('success') }}</div>
    @endif

    

    <table class="table-auto w-full mt-4 bg-white shadow rounded">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2">Valor Mínimo</th>
                <th class="px-4 py-2">Custo de Envio</th>
                <th class="px-4 py-2">Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($costs as $cost)
                <tr>
                    <td class="border px-4 py-2">{{ $cost->min_value_threshold }} €</td>
                    <td class="border px-4 py-2">{{ $cost->shipping_cost }} €</td>
                    <td class="border px-4 py-2 flex gap-2 justify-center">
                        <a href="{{ route('shipping-costs.edit', $cost) }}" class="btn btn-success btn-sm w-100 mb-2">Editar</a> 
                        <form action="{{ route('shipping-costs.destroy', $cost) }}" method="POST" onsubmit="return confirm('Tens a certeza?')">
                            @csrf
                            @method('DELETE')
                            
                            <button type="submit" class="btn btn-danger btn-sm w-100">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
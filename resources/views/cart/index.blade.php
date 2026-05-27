@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Carrinho de Compras</h1><br>

    @if (count($cart) === 0)
        <p class="text-gray-600">O seu carrinho está vazio.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 text-left">Produto</th>
                        <th class="py-2 px-4 text-center">Quantidade</th>
                        <th class="py-2 px-4 text-center">Preço Unitário</th>
                        <th class="py-2 px-4 text-center">Subtotal</th>
                        <th class="py-2 px-4 text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach ($cart as $id => $item)
                        @php
                            $price = $item['price'];
                            if (isset($item['discount']) && $item['discount']) {
                                $price *= (1 - $item['discount'] / 100);
                            }
                            $subtotal = $price * $item['quantity'];
                            $total += $subtotal;
                        @endphp

                        <tr class="border-t">
                            <td class="py-2 px-4">
                                <div class="font-semibold">{{ $item['name'] }}</div>
                                @if($item['stock'] == 0)
                                    <span class="text-xs text-red-600">Produto fora de stock – entrega pode demorar</span>
                                @endif
                            </td>
                            <td class="py-2 px-4 text-center">{{ $item['quantity'] }}</td>
                            <td class="py-2 px-4 text-center">€{{ number_format($price, 2) }}</td>
                            <td class="py-2 px-4 text-center">€{{ number_format($subtotal, 2) }}</td>
                            <td class="py-2 px-4 text-center">
                                <form action="{{ route('cart.remove', ['id' => $id]) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Remover</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div><br>
        <div class="mt-6 text-right">
            <div class="mt-6 text-right space-y-1">
                <div class="text-base">
                    Subtotal produtos: <strong>€{{ number_format($total, 2, ',', '.') }}</strong>
                </div>
                <div class="text-base">
                    Portes: <strong>€{{ number_format($shippingCost, 2, ',', '.') }}</strong>
                </div>
                <div class="text-lg font-semibold">
                    Total: <strong>€{{ number_format($finalTotal, 2, ',', '.') }}</strong>
                </div>
            </div>
        </div>
        <div class="mt-4">
        <form action="{{ route('orders.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700">NIF</label>
                <input
                    type="text"
                    name="nif"
                    value="{{ old('nif', auth()->check() ? auth()->user()->nif : '') }}"
                    class="mt-1 p-2 border rounded w-full"
                >
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Morada de Entrega</label>
                <input
                    name="address"
                    value="{{ old('address', auth()->check() ? auth()->user()->default_delivery_address : '') }}"
                    class="mt-1 p-2 border rounded w-full"
                >
            </div><br>

            <button type="submit" class="btn btn-primary">
                Confirmar Compra
            </button>
        </form>
    </div>

    @endif
    <br>
    <div class="mt-8">
        <a href="{{ route('catalog.index') }}" class="text-blue-600 hover:underline">&larr; Voltar ao Catálogo</a>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-3xl font-bold mb-0">Histórico de Operações</h1>
        <a href="{{ route('card.show') }}" class="btn btn-primary">Voltar</a>
    </div>

    @if($operations->isNotEmpty())
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Data</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Tipo</th>
                        <th class="py-3 px-4 text-right text-sm font-semibold text-gray-700">Valor</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Método</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-gray-700">Referência</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($operations as $op)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 text-sm text-gray-800">{{ $op->date }}</td>
                            <td class="py-2 px-4 text-sm text-gray-800">
                                {{ $op->type === 'credit' ? 'Carregamento'
                                  : ($op->type === 'debit' ? 'Débito' : ucfirst($op->type)) }}
                            </td>
                            <td class="py-2 px-4 text-sm text-gray-800 text-right">
                                €{{ number_format($op->value, 2, ',', '.') }}
                            </td>
                            <td class="py-2 px-4 text-sm text-gray-800">{{ $op->payment_type ?? '-' }}</td>
                            <td class="py-2 px-4 text-sm text-gray-800">{{ $op->payment_reference ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="py-6 text-left text-gray-500">
            Sem operações registadas.
        </div>
    @endif
</div>
@endsection
{{-- resources/views/orders/pending.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h1 class="mb-4">Encomendas Pendentes</h1>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif


  <div class="table-responsive">
    <table class="table table-striped table-bordered align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Membro</th>
          <th>Total (€)</th>
          <th>Data</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        @forelse ($orders as $order)
          <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->member->name }}</td>
            <td>€{{ number_format($order->total, 2, ',', '.') }}</td>
            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            <td class="d-flex gap-2">
              <form action="{{ route('orders.complete', $order) }}" method="POST">
                @csrf
                <button class="btn btn-sm btn-success"
                        onclick="return confirm('Confirmar conclusão?')">
                  Concluir
                </button>
              </form>
              <form action="{{ route('orders.cancel', $order) }}" method="POST">
                @csrf
                <input type="hidden" name="cancel_reason" value="Cancelado manualmente pelo admin">
                <button class="btn btn-sm btn-danger"
                        onclick="return confirm('Cancelar encomenda?')">
                  Cancelar
                </button>
              </form>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center text-muted py-3">
              Nenhuma encomenda pendente.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Paginação rodapé, centrada --}}
  <div class="d-flex justify-content-center mt-3">
    {!! $orders->links('pagination::bootstrap-5') !!}
  </div>
</div>
@endsection
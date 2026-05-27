{{-- resources/views/orders/completed.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container py-4">
  <h1 class="mb-4">Encomendas Concluídas</h1>

  {{-- Flash messages --}}
  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif
  @if (session('info'))
    <div class="alert alert-info">
      {{ session('info') }}
    </div>
  @endif

  {{-- Tabela de encomendas --}}
  <div class="table-responsive">
    <table class="table table-striped table-bordered align-middle mb-0">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Cliente</th>
          <th>Data</th>
          <th>Total</th>
          <th>Recibo</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $order)
          <tr>
            <td>{{ $order->id }}</td>
            <td>{{ $order->member->name ?? 'N/A' }}</td>
            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
            <td>€{{ number_format($order->total, 2, ',', '.') }}</td>
            <td>
              @if($order->pdf_receipt)
                <a href="{{ route('receipts.view', $order->pdf_receipt) }}" target="_blank">
                  Ver Recibo
                </a>
              @else
                <span class="text-muted">Não disponível</span>
              @endif
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="5" class="text-center text-muted py-4">
              Nenhuma encomenda concluída.
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Paginação em baixo --}}
  <div class="d-flex justify-content-center mt-3">
    {!! $orders->links('pagination::bootstrap-5') !!}
  </div>
</div>
@endsection
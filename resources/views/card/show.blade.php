@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
  <h2 class="text-2xl font-bold mb-4">Cartão Virtual</h2>

  @if($card)
    <p class="mb-2">
      <span class="font-semibold">Número:</span>
      {{ $card->card_number }}
    </p>
    <p class="mb-2">
      <span class="font-semibold">Titular:</span>
      {{ auth()->user()->name }}
    </p>
    <p class="mb-6">
      <span class="font-semibold">Saldo:</span>
      {{ number_format($card->balance, 2, ',', '.') }} €
    </p>

    <div class="flex justify-end gap-4">
      <a href="{{ route('card.topup.form') }}"
         class="btn btn-primary">
        Carregar Saldo
      </a>
      <a href="{{ route('card.history') }}"
         class="btn btn-secondary">
        Ver Histórico
      </a>
    </div>
  @else
    <p class="text-red-500">Não existe cartão associado ao seu perfil.</p>
  @endif
</div>
@endsection
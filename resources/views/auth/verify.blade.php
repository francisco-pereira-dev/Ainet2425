@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-6">
        <div class="card p-4 text-center shadow-sm">
            <h2 class="mb-3">Verifique o seu endereço de email</h2>

            @if (session('resent'))
                <div class="alert alert-success">
                    Um novo link de verificação foi enviado para o seu email.
                </div>
            @endif

            <p class="mb-3">
                Antes de continuar, por favor verifique o seu email clicando no link que lhe enviámos.
                <br>
                Se não recebeu o email, pode pedir outro.
            </p>

            <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-primary">Reenviar Email de Verificação</button>
            </form>
        </div>
    </div>
</div>
@endsection

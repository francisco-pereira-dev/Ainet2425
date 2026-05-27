@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1>Bem-vindo ao Grocery Club</h1>
    <p class="lead">A sua loja exclusiva de produtos gourmet.</p>

    <div class="mt-4">
        @auth
            <a href="{{ route('catalog.index') }}" class="btn btn-primary m-2">Ver Catálogo</a>
            <a href="{{ route('dashboard') }}" class="btn btn-primary m-2">Ir para o Painel</a>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary m-2">Entrar</a>
            <a href="{{ route('register') }}" class="btn btn-outline-primary m-2">Registar-se</a>
            <a href="{{ route('catalog.index') }}" class="btn btn-secondary m-2">Ver Catálogo como Visitante</a>
        @endauth
    </div>
</div>
@endsection
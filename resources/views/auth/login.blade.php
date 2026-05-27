@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-4">
        <div class="card p-4">
            <h3 class="mb-4 text-center">Login</h3>

            {{-- Mensagem de sucesso (ex: password alterada) --}}
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            {{-- Mensagens de erro --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" class="form-control" name="email"
                           value="{{ old('email') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Senha</label>
                    <input id="password" type="password" class="form-control" name="password" required>
                </div>

                <div class="mb-3 form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Lembrar-me</label>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-primary">Entrar</button>
                </div>

                <div class="text-center">
                    <a href="{{ route('password.request') }}">Esqueceu-se da sua password?</a>
                </div>



            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-5">
        <div class="card p-4 shadow-sm">
            <h3 class="mb-4 text-center">Recuperar Password</h3>

            {{-- Mensagem de sucesso --}}
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            {{-- Erros --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $erro)
                            <li>{{ $erro }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" class="form-control" name="email"
                           value="{{ old('email') }}" required autofocus>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">
                        Enviar Link de Recuperação
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

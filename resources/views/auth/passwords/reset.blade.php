@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-5">
        <div class="card p-4 shadow-sm">
            <h3 class="mb-4 text-center">Nova Password</h3>

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

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

                <div class="mb-3">
                    <label for="password" class="form-label">Nova Password</label>
                    <input id="password" type="password" class="form-control" name="password" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar Password</label>
                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Repor Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Perfil de Utilizador</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Nome -->
        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input type="text" class="form-control" name="name"
                value="{{ old('name', auth()->user()->name) }}"
                @if(auth()->user()->isEmployee()) disabled @endif>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input class="form-control" type="email" value="{{ auth()->user()->email }}" disabled>
        </div>

        <!-- Género -->
        <div class="mb-3">
            <label class="form-label">Género</label>
            <select class="form-select" name="gender" @if(auth()->user()->isEmployee()) disabled @endif>
                <option value="M" {{ old('gender', auth()->user()->gender) == 'M' ? 'selected' : '' }}>Masculino</option>
                <option value="F" {{ old('gender', auth()->user()->gender) == 'F' ? 'selected' : '' }}>Feminino</option>
            </select>
        </div>

        @if(auth()->user()->isMember() || auth()->user()->isBoard())
            <!-- Endereço -->
            <div class="mb-3">
                <label class="form-label">Endereço</label>
                <input type="text" name="default_delivery_address" class="form-control"
                    value="{{ old('default_delivery_address', auth()->user()->default_delivery_address) }}">
            </div>

            <!-- NIF -->
            <div class="mb-3">
                <label class="form-label">NIF</label>
                <input type="text" name="nif" class="form-control"
                    value="{{ old('nif', auth()->user()->nif) }}">
            </div>

            <!-- Tipo de Pagamento -->
            <div class="mb-3">
                <label class="form-label">Método de Pagamento</label>
                <select name="default_payment_type" class="form-select">
                    <option value="">-- Selecionar --</option>
                    <option value="Visa" {{ old('default_payment_type', auth()->user()->default_payment_type) == 'Visa' ? 'selected' : '' }}>Visa</option>
                    <option value="PayPal" {{ old('default_payment_type', auth()->user()->default_payment_type) == 'PayPal' ? 'selected' : '' }}>PayPal</option>
                    <option value="MB WAY" {{ old('default_payment_type', auth()->user()->default_payment_type) == 'MB WAY' ? 'selected' : '' }}>MB WAY</option>
                </select>
            </div>

            <!-- Referência -->
            <div class="mb-3">
                <label class="form-label">Referência de Pagamento</label>
                <input type="text" name="default_payment_reference" class="form-control"
                    value="{{ old('default_payment_reference', auth()->user()->default_payment_reference) }}">
            </div>
        @endif

        <!-- Foto atual -->
        @if(auth()->user()->photo)
        <div class="mb-3">
            <label class="form-label">Foto Atual:</label><br>
            <img
            src="{{ asset('storage/users/' . auth()->user()->photo) }}"
            alt="Foto de Perfil"
            width="120"
            style="object-fit:cover;border-radius:50%;"
            >
        </div>
        @endif

        <!-- Foto -->
        <div class="mb-3">
            <label class="form-label">Foto</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label">Nova Password</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Guardar Alterações</button>
    </form>
</div>
@endsection

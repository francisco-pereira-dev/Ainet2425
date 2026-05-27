@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-md-7">
        <div class="card p-4">
            <h3 class="mb-4 text-center">Criar Conta</h3>


            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="name" class="form-label">Nome</label>
                        <input id="name" type="text"
                            class="form-control @error('name') is-invalid @enderror"
                            name="name" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="password" class="form-label">Senha</label>
                        <input id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password" required>
                        @error('password')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                        <input id="password_confirmation" type="password"
                            class="form-control @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" required>
                        @error('password_confirmation')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="gender" class="form-label">Género</label>
                        <select name="gender" id="gender"
                                class="form-select @error('gender') is-invalid @enderror" required>
                            <option value="">Escolher...</option>
                            <option value="M" {{ old('gender') == 'M' ? 'selected' : '' }}>Masculino</option>
                            <option value="F" {{ old('gender') == 'F' ? 'selected' : '' }}>Feminino</option>
                        </select>
                        @error('gender')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="nif" class="form-label">NIF (opcional)</label>
                        <input id="nif" type="text"
                            class="form-control @error('nif') is-invalid @enderror"
                            name="nif" value="{{ old('nif') }}">
                        @error('nif')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="default_delivery_address" class="form-label">Morada de Entrega (opcional)</label>
                    <input id="default_delivery_address" type="text"
                        class="form-control @error('default_delivery_address') is-invalid @enderror"
                        name="default_delivery_address" value="{{ old('default_delivery_address') }}">
                    @error('default_delivery_address')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label for="default_payment_type" class="form-label">Tipo de Pagamento (opcional)</label>
                        <select name="default_payment_type" id="default_payment_type"
                                class="form-select @error('default_payment_type') is-invalid @enderror">
                            <option value="">Escolher...</option>
                            <option value="Visa" {{ old('default_payment_type') == 'Visa' ? 'selected' : '' }}>Visa</option>
                            <option value="PayPal" {{ old('default_payment_type') == 'PayPal' ? 'selected' : '' }}>PayPal</option>
                            <option value="MB WAY" {{ old('default_payment_type') == 'MB WAY' ? 'selected' : '' }}>MB WAY</option>
                        </select>
                        @error('default_payment_type')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3 col-md-6">
                        <label for="default_payment_reference" class="form-label">Referência de Pagamento (opcional)</label>
                        <input id="default_payment_reference" type="text"
                            class="form-control @error('default_payment_reference') is-invalid @enderror"
                            name="default_payment_reference" value="{{ old('default_payment_reference') }}">
                        @error('default_payment_reference')
                            <span class="invalid-feedback d-block" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Foto de Perfil (opcional)</label>
                    <input type="file"
                        class="form-control @error('photo') is-invalid @enderror"
                        name="photo" id="photo">
                    @error('photo')
                        <span class="invalid-feedback d-block" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Registar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

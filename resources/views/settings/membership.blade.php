@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-xl py-5">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h2 class="card-title mb-4 text-center fw-bold text-primary">Editar Quota de Membro</h2>

            @if (session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('settings.membership.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="membership_fee" class="form-label">Valor da Quota (€)</label>
                    <input type="number" step="0.01" name="membership_fee" id="membership_fee" 
                        class="form-control @error('membership_fee') is-invalid @enderror" 
                        value="{{ old('membership_fee', $setting->membership_fee) }}" required>

                    @error('membership_fee')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success fw-bold">
                         Guardar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

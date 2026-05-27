@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-2xl font-bold mb-4">Carregar Cartão Virtual</h1>
    </div>
            <form method="POST" action="{{ route('card.topup') }}">
                @csrf
                <label>Valor a carregar (€):</label>
                <input type="number" min="1" max="1000" name="value" value="{{ old('value') }}" required class="input mb-3"><br>

                <label>Método de pagamento:</label>
                <select name="payment_type" id="payment_type" class="input mb-3" required>
                    <option value="">Escolha...</option>
                    <option value="Visa" {{ old('payment_type') == 'Visa' ? 'selected' : '' }}>Visa</option>
                    <option value="PayPal" {{ old('payment_type') == 'PayPal' ? 'selected' : '' }}>PayPal</option>
                    <option value="MB WAY" {{ old('payment_type') == 'MB WAY' ? 'selected' : '' }}>MB WAY</option>
                </select><br>

                <div id="visa_fields" style="display: none;">
                    <label>Número Visa:</label>
                    <input type="text" id="visa_number" maxlength="16" class="input mb-3" value="{{ old('payment_reference') }}">
                    <label>CVC:</label>
                    <input type="text" name="cvc" maxlength="3" class="input mb-3" value="{{ old('cvc') }}">
                </div>
                <div id="paypal_fields" style="display: none;">
                    <label>Email PayPal:</label>
                    <input type="email" id="paypal_email" class="input mb-3" value="{{ old('payment_reference') }}">
                </div>
                <div id="mbway_fields" style="display: none;">
                    <label>Número MB WAY:</label>
                    <input type="text" id="mbway_number" maxlength="9" class="input mb-3" value="{{ old('payment_reference') }}">
                </div>
                <!-- O campo escondido que será enviado -->
                <input type="hidden" name="payment_reference" id="payment_reference_hidden" value="{{ old('payment_reference') }}">


                @error('payment_reference') <div style="color:red;">{{ $message }}</div>@enderror
                @error('cvc') <div class="text-red-500">{{ $message }}</div> @enderror

                <button type="submit" class="btn btn-primary mt-3">Carregar</button>
                <a href="{{ route('card.show') }}" class="btn btn-secondary mt-3">Voltar</a>
            </form>
</div>

<script>
    function updatePaymentFields() {
    var type = document.getElementById('payment_type').value;
    document.getElementById('visa_fields').style.display = type === 'Visa' ? 'block' : 'none';
    document.getElementById('paypal_fields').style.display = type === 'PayPal' ? 'block' : 'none';
    document.getElementById('mbway_fields').style.display = type === 'MB WAY' ? 'block' : 'none';
}

// Sempre que o utilizador escrever, copia para o hidden:
function updateHiddenReference() {
    var type = document.getElementById('payment_type').value;
    var value = '';
    if (type === 'Visa') {
        value = document.getElementById('visa_number').value;
    } else if (type === 'PayPal') {
        value = document.getElementById('paypal_email').value;
    } else if (type === 'MB WAY') {
        value = document.getElementById('mbway_number').value;
    }
    document.getElementById('payment_reference_hidden').value = value;
}

// Atualiza ao carregar:
document.addEventListener('DOMContentLoaded', function() {
    updatePaymentFields();
    updateHiddenReference();
    document.getElementById('payment_type').addEventListener('change', function() {
        updatePaymentFields();
        updateHiddenReference();
    });
    // Liga eventos aos inputs:
    document.getElementById('visa_number').addEventListener('input', updateHiddenReference);
    document.getElementById('paypal_email').addEventListener('input', updateHiddenReference);
    document.getElementById('mbway_number').addEventListener('input', updateHiddenReference);
});


</script>
@endsection
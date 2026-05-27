<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Operation;
use App\Models\Card;
use App\Services\Payment;
use Carbon\Carbon;

class CardController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $card = Card::find($user->id);

        if (!$card) {
            $card = Card::create([
                'id' => $user->id, // <-- Só assim a FK não falha!
                'card_number' => rand(100000, 999999),
                'balance' => 0
            ]);
        }

        return view('card.show', compact('card'));
    }

    public function history()
    {
        $user = Auth::user();
        $card = Card::find($user->id);

        $operations = $card ? $card->operations()->orderByDesc('date')->get() : collect();

        return view('card.history', compact('card', 'operations'));
    }

    public function showTopUpForm()
    {
        return view('card.topup');
    }

    public function topUp(Request $request)
    {
        $request->validate([
            'value' => 'required|numeric|min:1|max:1000',
            'payment_type' => 'required|in:Visa,PayPal,MB WAY',
            'payment_reference' => [
                'required',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->payment_type == 'Visa') {
                        if (!preg_match('/^\d{16}$/', $value) || !preg_match('/^\d{3}$/', $request->cvc)) {
                            $fail('Número de cartão Visa (16 dígitos) ou CVC (3 dígitos) inválido.');
                        }
                    }
                    if ($request->payment_type == 'PayPal') {
                        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                            $fail('Email PayPal inválido.');
                        }
                    }
                    if ($request->payment_type == 'MB WAY') {
                        if (!preg_match('/^9\d{8}$/', $value)) {
                            $fail('Número MB WAY inválido.');
                        }
                    }
                }
            ],
            'cvc' => 'nullable|required_if:payment_type,Visa|digits:3'
        ]);

        $user = Auth::user();
        $card = \App\Models\Card::find($user->id);

        // Cria o cartão se não existir (obrigatório na tua BD)
        if (!$card) {
            $card = \App\Models\Card::create([
                'id' => $user->id,
                'card_number' => rand(100000, 999999),
                'balance' => 0
            ]);
        }

        // --- Simulação do pagamento ---
        $ok = false;
        if ($request->payment_type == 'Visa') {
            $ok = \App\Services\Payment::payWithVisa($request->payment_reference, $request->cvc);
        } elseif ($request->payment_type == 'PayPal') {
            $ok = \App\Services\Payment::payWithPaypal($request->payment_reference);
        } elseif ($request->payment_type == 'MB WAY') {
            $ok = \App\Services\Payment::payWithMBway($request->payment_reference);
        }

        if (!$ok) {
            return back()->withErrors(['payment_reference' => 'O pagamento foi recusado.']);
        }

        // --- Atualiza saldo e regista operação ---
        DB::transaction(function() use ($card, $request) {
            $card->balance += $request->value;
            $card->save();

            \App\Models\Operation::create([
                'card_id' => $card->id,
                'type' => 'credit',
                'value' => $request->value,
                'date' => \Carbon\Carbon::now()->toDateString(),
                'credit_type' => 'payment',
                'payment_type' => $request->payment_type, // Tem de ser Visa, PayPal ou MB WAY
                'payment_reference' => $request->payment_reference
            ]);
        });

        return redirect()->route('card.show')->with('alert-msg', 'Saldo carregado com sucesso!');
    }

}

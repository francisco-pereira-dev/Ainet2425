<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'blocked',
        'gender',
        'photo',
        'nif',
        'default_delivery_address',
        'default_payment_type',
        'default_payment_reference',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'blocked' => 'boolean',
    ];

    /**
     * Cartão virtual do utilizador.
     * O id do cartão é o mesmo que o id do user.
     */
    public function card()
    {
        return $this->hasOne(\App\Models\Card::class, 'id', 'id');
    }

    public function isMember()
    {
        return $this->type === 'member';
    }

    public function isBoard()
    {
        return $this->type === 'board';
    }

    public function isEmployee()
    {
        return $this->type === 'employee';
    }
    public function getSessionCard()
    {
        $cardId = session('card_id_for_user_'.$this->id);
        return $cardId ? \App\Models\Card::find($cardId) : null;
    }
}

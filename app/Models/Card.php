<?php

namespace App\Models;
use App\Models\Operation;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    // O id deste modelo corresponde ao id do utilizador
    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = ['id', 'card_number', 'balance'];

    /**
     * Utilizador associado a este cartão.
     * A coluna cards.id é foreign key para users.id
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'id', 'id');
    }
    
    public function operations()
    {
        return $this->hasMany(Operation::class, 'card_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Card;
use App\Models\Order;

class Operation extends Model
{
    protected $fillable = [
        'card_id', 'type', 'value', 'date',
        'debit_type', 'credit_type', 'payment_type',
        'payment_reference', 'order_id'
    ];

    public $timestamps = false;

    public function card()
    {
        return $this->belongsTo(Card::class);
    }
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}

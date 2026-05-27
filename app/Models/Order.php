<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{

    protected $fillable = [
        'member_id',
        'date',
        'total_items',
        'shipping_cost',
        'total',
        'nif',
        'delivery_address',
        'status',
        'pdf_receipt',
        'cancel_reason'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Relação com o membro (utilizador)
    public function member()
    {
        return $this->belongsTo(User::class, 'member_id');
    }

    // Relação com os items da encomenda
    public function items(): HasMany
    {
        return $this->hasMany(ItemOrder::class, 'order_id');
    }

    // Para associar operações (opcional, se precisares)
    public function operations()
    {
        return $this->hasMany(Operation::class);
    }
}

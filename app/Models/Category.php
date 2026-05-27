<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Category extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'image',
        'custom'
    ];

    // Relacionamento com os produtos (uma categoria pode ter vários produtos)


    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
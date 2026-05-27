<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;


class Product extends Model
{
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'stock',
        'description',
        'photo',
        'discount_min_qty',
        'discount',
        'stock_lower_limit',
        'stock_upper_limit',
    ];

    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}



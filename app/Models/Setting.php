<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    protected $table = 'settings'; // nome da tabela
    protected $fillable = ['membership_fee']; // campos que podem ser alterados
}

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Exemplo de rota API
Route::get('/ping', function () {
    return response()->json(['status' => 'ok']);
});

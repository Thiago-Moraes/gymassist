<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FichaTreinoController;

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/fichas-treino', [FichaTreinoController::class, 'store']);

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Infrastructure\Http\Controllers\FichaTreinoController as DDDFichaTreinoController;
use App\Http\Controllers\FichaTreinoController as HttpFichaTreinoController;
use App\Infrastructure\Http\Controllers\AlunoController;

Route::get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/fichas-treino', [DDDFichaTreinoController::class, 'store']);
Route::post('/fichas/suggest', [DDDFichaTreinoController::class, 'suggest']);
Route::resource('/alunos', AlunoController::class);

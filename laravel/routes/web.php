<?php

use App\Http\Controllers\CpfController;
use App\Http\Controllers\AnotherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('buscaCpf'); 
});

Route::prefix('cpf')->group(function () {
    Route::post('/', [CpfController::class, 'buscar'])->name('cpf');
    Route::get('/{cpf}', [CpfController::class, 'index']);
});

Route::controller(AnotherController::class)->group(function () {
    Route::get('/another', 'index');
    Route::get('/another/{texto}', 'index');
});
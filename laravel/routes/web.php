<?php

use App\Http\Controllers\CpfController;
use App\Http\Controllers\AnotherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('buscaCpf'); 
});

Route::prefix('cpf')->group(function () {
    Route::post('/', [CpfController::class, 'buscar'])->name('cpf.buscar');
    Route::get('/{cpf}', [CpfController::class, 'index']);  
});

Route::controller(AnotherController::class)->group(function () {
    Route::get('/another', 'index');
    Route::get('/another/{texto}', 'index');
});

Route::get('/cadastro', function () {
    return view('cadastrarCpf'); 
})->name('cpf.cadastro');

Route::prefix('cpf.cadastro')->group(function () {
    Route::post('/efetuar-cadastro', [CpfController::class, 'create'])->name('efetuar-cadastro');
});
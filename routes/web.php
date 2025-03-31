<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UbicacionesController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});



Route::get('/mapa', function () {
    return view('map.index');
});

Route::apiResource('ubicaciones', UbicacionesController::class);
Route::get('/ubicaciones/buscar/{busqueda}', [UbicacionesController::class, 'buscarUbicaciones']);

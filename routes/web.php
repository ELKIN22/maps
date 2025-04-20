<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UbicacionesController;
use App\Http\Controllers\TipoUbiController;

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});



Route::get('/', function () {
    return view('map.index');
});


Route::get('/ubicaciones/buscar/{busqueda}', [UbicacionesController::class, 'buscarUbicaciones']);
Route::get('/ubicaciones/getPaginate', [UbicacionesController::class, 'index']);

Route::get('/tipoUbi/all', [TipoUbiController::class, 'index']);


Route::resource('ubicaciones', UbicacionesController::class)->only([
    'show', 'store', 'update', 'destroy'
]);

Route::get('/ubicaciones', function () {
    return view('ubicaciones.index');
})->name('ubicaciones.index');

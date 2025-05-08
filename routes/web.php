<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UbicacionesController;
use App\Http\Controllers\TipoUbiController;


/*
|--------------------------------------------------------------------------
| Rutas Autenticadas
|--------------------------------------------------------------------------
|
| Estas rutas requieren que el usuario esté autenticado.
| Utilizan el middleware de auth:sanctum, la sesión de Jetstream y la verificación de email.
|
*/

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/ubicaciones', function () {
        return view('ubicaciones.index');
    })->name('ubicaciones.index');

    Route::prefix('ubicaciones')->name('ubicaciones.')->group(function () {
        Route::get('/getPaginate', [UbicacionesController::class, 'index']);
    
        Route::get('/{ubicacion}/gallery', [UbicacionesController::class, 'galleryIndex'])->name('gallery.index');
        Route::post('/{ubicacion}/gallery', [UbicacionesController::class, 'galleryStore'])->name('gallery.store');
        Route::delete('/{ubicacion}/gallery/{imagen}', [UbicacionesController::class, 'galleryDestroy'])->name('gallery.destroy');
        Route::put('/{ubicacion}/gallery/reorder', [UbicacionesController::class, 'galleryReorder'])->name('gallery.reorder');
    });

    Route::resource('ubicaciones', UbicacionesController::class)->only([
        'store', 'update', 'destroy'
    ]);
});


/*
|--------------------------------------------------------------------------
| Rutas Públicas
|--------------------------------------------------------------------------
|
| Estas rutas son accesibles para cualquier usuario.
|
*/

Route::get('/', function () {
    return view('map.index');
});
Route::get('/tipoUbi/all', [TipoUbiController::class, 'index']);
Route::get('ubicaciones/buscar/{busqueda}', [UbicacionesController::class, 'buscarUbicaciones']);
Route::get('ubicaciones/{ubicacion}', [UbicacionesController::class, 'show'])->name('ubicaciones.show');

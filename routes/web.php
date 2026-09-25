<?php

use App\Http\Controllers\AccesoController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\DispositivoController;
use App\Http\Controllers\EventoController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::inertia('/', 'Welcome')->name('home');

// Dispositivos
Route::resource('dispositivos', DispositivoController::class);

// Eventos
Route::resource('eventos', EventoController::class);

// Alertas
Route::resource('alertas', AlertaController::class);
Route::patch('alertas/{alerta}/leer', [AlertaController::class, 'marcarLeida'])
    ->name('alertas.leer');

// Accesos (logs: sin edit/update por ser registros históricos)
Route::resource('accesos', AccesoController::class)->except(['edit', 'update']);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\PagoController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Todas estas rutas requieren login
Route::middleware(['auth'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('facturas/{factura}/abonar', [FacturaController::class, 'abonar'])->name('facturas.abonar');

    Route::resource('productos',   ProductoController::class);
    Route::resource('clientes',    ClienteController::class);
    Route::resource('empleados',   EmpleadoController::class);
    Route::resource('facturas',    FacturaController::class);
    Route::resource('metodopagos', MetodoPagoController::class);
    Route::resource('pagos',       PagoController::class);

});
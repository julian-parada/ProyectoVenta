<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

Route::get('/', function () {
    return view('auth.login');
});

// Rutas de autenticación MANUALES (sin Auth::routes())
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

// Todas estas rutas requieren login
Route::middleware(['auth', 'prevent-back'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('facturas/{factura}/abonar', [FacturaController::class, 'abonar'])->name('facturas.abonar');

    Route::resource('productos', ProductoController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('empleados', EmpleadoController::class);
    Route::resource('facturas', FacturaController::class);
    Route::resource('metodopagos', MetodoPagoController::class);
    Route::resource('pagos', PagoController::class);
    Route::patch('/productos/{producto}/toggle-status', [ProductoController::class, 'toggleStatus'])
        ->name('productos.toggle-status');

    Route::patch('/clientes/{cliente}/toggle-status', [ClienteController::class, 'toggleStatus'])
        ->name('clientes.toggle-status');
});
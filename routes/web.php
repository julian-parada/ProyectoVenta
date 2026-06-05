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

Route::get('/404', function () {
    return response()->view('errors.404', [], 404);
});
Route::get('/403', function () {
    return response()->view('errors.403', [], 403);
});
Route::get('/419', function () {
    return response()->view('errors.419', [], 419);
});
Route::get('/500', function () {
    return response()->view('errors.500', [], 500);
});
Route::get('/503', function () {
    return response()->view('errors.503', [], 503);
});


// PDF por factura
Route::get('facturas/{id}/pdf', [FacturaController::class, 'imprimirPdf'])
    ->name('facturas.pdf');

// Excel por factura
Route::get('facturas/{id}/excel', [FacturaController::class, 'exportarExcel'])
    ->name('facturas.excel');

// Excel general de todas las facturas
Route::get('facturas-excel', [FacturaController::class, 'exportarExcelGeneral'])
    ->name('facturas.excel.general');

    Route::get('clientes/pdf', [ClienteController::class, 'exportarPdf'])
    ->name('clientes.pdf');

Route::get('clientes/excel', [ClienteController::class, 'exportarExcel'])
    ->name('clientes.excel');

    Route::get('productos/pdf', [ProductoController::class, 'exportarPdf'])
    ->name('productos.pdf');

Route::get('productos/excel', [ProductoController::class, 'exportarExcel'])
    ->name('productos.excel');

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
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/change-password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::put('/profile/change-password', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.update-password');
});
<?php

use Illuminate\Support\Facades\Route;

// Controllers de Auth
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

// Controllers de la app
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\MetodoPagoController;
use App\Http\Controllers\PagoController;


Route::get('/', function () {
    return view('auth.login');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('register', 'showRegistrationForm')->name('register');
    Route::post('register', 'register');
});

/*
|--------------------------------------------------------------------------
| Recuperación de contraseña
|--------------------------------------------------------------------------
*/
Route::controller(ForgotPasswordController::class)->group(function () {
    Route::get('password/reset', 'showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'sendResetLinkEmail')->name('password.email');
});

Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('password/reset/{token}', 'showResetForm')->name('password.reset');
    Route::post('password/reset', 'reset')->name('password.update');
});

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

    // Home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Perfil
    Route::controller(ProfileController::class)->prefix('profile')->group(function () {
        Route::get('/', 'edit')->name('profile.edit');
        Route::put('/', 'update')->name('profile.update');
        Route::get('/change-password', 'changePassword')->name('profile.change-password');
        Route::put('/change-password', 'updatePassword')->name('profile.update-password');
    });

    // Recursos
    Route::resource('productos', ProductoController::class);
    Route::resource('clientes', ClienteController::class);
    Route::resource('empleados', EmpleadoController::class);
    Route::resource('facturas', FacturaController::class);
    Route::resource('metodopagos', MetodoPagoController::class);
    Route::resource('pagos', PagoController::class);

    // Acciones adicionales de productos
    Route::patch('/productos/{producto}/toggle-status', [ProductoController::class, 'toggleStatus'])
        ->name('productos.toggle-status');

    // Acciones adicionales de clientes
    Route::patch('/clientes/{cliente}/toggle-status', [ClienteController::class, 'toggleStatus'])
        ->name('clientes.toggle-status');

    // Acciones adicionales de facturas
    Route::post('facturas/{factura}/abonar', [FacturaController::class, 'abonar'])
        ->name('facturas.abonar');
});
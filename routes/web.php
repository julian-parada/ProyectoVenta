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

/*
|--------------------------------------------------------------------------
| Ruta raíz
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('auth.login'));

/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
*/
Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->name('logout');
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

/*
|--------------------------------------------------------------------------
| Rutas de error
|--------------------------------------------------------------------------
*/
Route::get('/error/403', fn() => response()->view('errors.403', [], 403))->name('error.403');
Route::get('/error/404', fn() => response()->view('errors.404', [], 404))->name('error.404');
Route::get('/error/419', fn() => response()->view('errors.419', [], 419))->name('error.419');
Route::get('/error/500', fn() => response()->view('errors.500', [], 500))->name('error.500');
Route::get('/error/503', fn() => response()->view('errors.503', [], 503))->name('error.503');

/*
|--------------------------------------------------------------------------
| Rutas protegidas (requieren login)
|--------------------------------------------------------------------------
*/
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
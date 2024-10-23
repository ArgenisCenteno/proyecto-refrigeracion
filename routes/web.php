<?php

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\ConductorController;
use App\Http\Controllers\CuentaPorCobrarController;
use App\Http\Controllers\PasajeroController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\SectorController;
use App\Http\Controllers\TramiteController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ViajeController;
use App\Models\CuentaPorCobrar;
use App\Models\Tramite;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // Obtener 6 productos de la base de datos
    return view('welcome');
});

    Route::resource('sectores', App\Http\Controllers\SectorController::class);
    Route::resource('usuarios', App\Http\Controllers\UserController::class);
    Route::resource('servicios', App\Http\Controllers\ServicioController::class);
    Route::resource('vehiculos', VehicleController::class);
    Route::resource('conductores', ConductorController::class);
    Route::resource('pasajeros', PasajeroController::class);
    Route::resource('tramites', TramiteController::class);
    Route::resource('reportes', ReporteController::class);

    Route::post('/viajes/exportar', [ReporteController::class, 'exportarExcel'])->name('reportes.exportarExcel');
    Route::post('/exportar-cuentas-por-cobrar', [ReporteController::class, 'exportarCuentasPorCobrarExcel'])->name('cuentasPorCobrar.exportarExcel');
    Route::post('/exportar-pagos', [ReporteController::class, 'exportarPagosExcel'])->name('pagos.exportarExcel');

    Route::get('/home-page', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::put('/viajes/{id}/cancelar', [ViajeController::class, 'cancelar'])->name('viajes.cancelar');

    Route::resource('sectores', App\Http\Controllers\SectorController::class);
    Route::resource('usuarios', App\Http\Controllers\UserController::class);
    Route::resource('servicios', App\Http\Controllers\ServicioController::class);
    Route::resource('vehiculos', VehicleController::class);
    Route::resource('conductores', ConductorController::class);
    Route::resource('pasajeros', PasajeroController::class);
    Route::resource('tramites', TramiteController::class);
    Route::resource('reportes', ReporteController::class);
    Route::resource('viajes', ViajeController::class); // Asegúrate de que el controlador de viajes esté accesible

    Route::post('/viajes/exportar', [ReporteController::class, 'exportarExcel'])->name('reportes.exportarExcel');
    Route::post('/exportar-cuentas-por-cobrar', [ReporteController::class, 'exportarCuentasPorCobrarExcel'])->name('cuentasPorCobrar.exportarExcel');
    Route::post('/exportar-pagos', [ReporteController::class, 'exportarPagosExcel'])->name('pagos.exportarExcel');

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::put('/viajes/{id}/cancelar', [ViajeController::class, 'cancelar'])->name('viajes.cancelar');

    Route::resource('cuentasPorCobrar', CuentaPorCobrarController::class); // Asegúrate de que el controlador de cuentas por cobrar esté accesible
    Route::get('/home-user', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/pagar/{id}', [App\Http\Controllers\CuentaPorCobrarController::class, 'iniciarPago'])->name('pagar');


// Ruta de inicio de sesión
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/register', [LoginController::class, 'register'])->name('register');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Auth::routes();


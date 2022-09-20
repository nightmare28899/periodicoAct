<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Clientes;
use App\Http\Livewire\Tarifas;
use App\Http\Livewire\Rutas;
use App\Http\Livewire\Tiros;
use App\Http\Livewire\VistaFactura;
use App\Http\Livewire\CancelarFactura;
use App\Http\Livewire\ClienteBuscador;
use App\Http\Livewire\Factura;
use App\Http\Livewire\GenerarR;
use App\Http\Livewire\Historial;
use App\Http\Livewire\Facturas;
use App\Http\Livewire\SuscripcionBuscador;
use App\Http\Livewire\PDFPago;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/cliente', Clientes::class)->name('cliente');
    Route::get('/tiro', Tiros::class);
    Route::get('/tarifa', Tarifas::class);
    Route::get('/ruta', Rutas::class);
    //rutas remisiones
    Route::get('/tiros/remision', function() {
        return view('livewire.tiros.generarRemision');
    });
    Route::get('/factura/{cliente_id}/{idTipo}', Factura::class);
    Route::get('/vistaPrevia/{id}', VistaFactura::class);
    Route::get('/cancelarFactura/{id}', CancelarFactura::class);
    Route::get('/crearVenta', ClienteBuscador::class)->name('CrearVenta');
    Route::get('/crearSuscripcion', SuscripcionBuscador::class)->name('CrearSuscripcion');
    Route::get('/remisiones', GenerarR::class);
    Route::get('/historialR', Historial::class);
    Route::get('/PDFPago', PDFPago::class)->name('PDFPago');
    Route::get('/Facturas', Facturas::class)->name('Facturas');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

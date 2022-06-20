<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Clientes;
use App\Http\Livewire\Tarifas;
use App\Http\Livewire\Rutas;
use App\Http\Livewire\Tiros;
use App\Http\Livewire\Remisiones;
use App\Http\Livewire\Remisiones\RmCliente;
use App\Http\Livewire\VistaPrevia;
use App\Http\Controllers\UserController;

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
    Route::get('/cliente', Clientes::class);
    Route::get('/tiro', Tiros::class);/*
    Route::get('/tiro/PDF', \App\Http\Livewire\Tiros::class)->name('tiropdf'); */
    Route::get('/tarifa', Tarifas::class);
    Route::get('/ruta', Rutas::class);
    //rutas remisiones
    Route::get('/remision/ventaP/cliente', RmCliente::class);
    Route::get('/remision', Remisiones::class);
    Route::get('/tiros/remision', function() {
        return view('livewire.tiros.generarRemision');
    });

    /* Route::get('/', [UserController::class, 'index']); */
    /* Route::get('/tiro/vistaPrevia', [Tiros::class, 'remision'])->name('download-pdf'); */
    /* Route::get('/tiro/vistaPrevia', VistaPrevia::class)->name('vista-previa'); */

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

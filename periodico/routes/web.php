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
    /* dd( \Crisvegadev\Facturama\Invoice::create([
        "Serie" => "R",
        "Currency" => "MXN",
        "ExpeditionPlace" => "78116",
        "PaymentConditions" => "CREDITO A SIETE DIAS",
        "Folio" => "100",
        "CfdiType" => "I",
        "PaymentForm" => "03",
        "PaymentMethod" => "PUE",
        "Receiver" => [
            "Rfc" => "RSS2202108U5",
            "Name" => "RADIAL SOFTWARE SOLUTIONS",
            "CfdiUse" => "P01"
        ],
        "Items" => [
            [
                "ProductCode" => "10101504",
                "IdentificationNumber" => "EDL",
                "Description" => "Estudios de viabilidad",
                "Unit" => "NO APLICA",
                "UnitCode" => "MTS",
                "UnitPrice" => 50.0,
                "Quantity" => 2.0,
                "Subtotal" => 100.0,
                "Taxes" => [
                    [
                        "Total" => 16.0,
                        "Name" => "IVA",
                        "Base" => 100.0,
                        "Rate" => 0.16,
                        "IsRetention" => false
                    ]
                ],
                "Total" => 116.0
            ],
            [
                "ProductCode" => "10101504",
                "IdentificationNumber" => "001",
                "Description" => "SERVICIO DE COLOCACION",
                "Unit" => "NO APLICA",
                "UnitCode" => "E49",
                "UnitPrice" => 100.0,
                "Quantity" => 15.0,
                "Subtotal" => 1500.0,
                "Discount" => 0.0,
                "Taxes" => [
                    [
                      "Total" => 240.0,
                      "Name" => "IVA",
                      "Base" => 1500.0,
                      "Rate" => 0.16,
                      "IsRetention" => false
                    ]
              ],
              "Total" => 1740.0
            ]
        ]
    ])); */
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
    // Route::get('/vistaPrevia', [Tiros::class, 'vistaprevia']);
    /* Route::get('/tiro/vistaPrevia', VistaPrevia::class)->name('vista-previa'); */

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

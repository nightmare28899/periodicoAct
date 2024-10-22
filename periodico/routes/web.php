<?php

use App\Http\Livewire\AgregarDiasSuscripcion;
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
use App\Http\Livewire\HistorialF;
use App\Http\Livewire\SuscripcionBuscador;
use App\Http\Livewire\PDFVenta;
use App\Http\Livewire\PDFSuscripcion;
use App\Http\Livewire\PDFTiro;
use App\Http\Livewire\PDFPago;
use App\Http\Livewire\PDFRemision;
use App\Http\Livewire\PdfRemisionesP;
use App\Http\Livewire\ReportePDFrelacionCR;
use App\Http\Livewire\ReporteRelacionCR;
use App\Http\Livewire\FacturaPPD;
use App\Http\Livewire\FacturarPPD;
use App\Http\Livewire\PdfSuscripcionReporteVencimiento;
use App\Http\Livewire\SuscripcionReporteFechas;
use App\Http\Livewire\SuspencionDeContrato;
use App\Http\Livewire\SuscripcionSuspendidaReporte;
use App\Http\Livewire\VistaFacturaPPD;
use App\Http\Livewire\HistorialSuscripciones;
use App\Http\Livewire\HistorialComplementoPago;
use App\Http\Livewire\VistaPreviaComplemento;
use App\Http\Livewire\CancelarFacturaComplemento;
use App\Http\Livewire\CancelarVentas;
use App\Http\Livewire\CancelarVentaPDF;
use App\Http\Livewire\ReporteVentaPFacturas;
use App\Http\Livewire\ReporteSaldos;
use App\Http\Livewire\HistorialVentas;
use App\Http\Livewire\RemisionesRangoPorFecha;
use App\Http\Livewire\RemisionesRangoPdfview;
use App\Http\Livewire\Ventas\Devolver;
use App\Http\Livewire\Ventas\RegistroDevoluciones;
use App\Http\Livewire\Ventas\PDFViewDevolucion;
use App\Http\Livewire\Invoices\SomeInvoices;
use App\Http\Livewire\Complementopago\MakeComplement;

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
    Route::get('/tiros/remision', function () {
        return view('livewire.tiros.generarRemision');
    });
    Route::get('/factura/{cliente_id}/{idTipo}/{id}', Factura::class);
    Route::get('/vistaPrevia/{id}', VistaFactura::class);
    Route::get('/cancelarFactura/{id}/{idTipo}', CancelarFactura::class);
    Route::get('/crearVenta', ClienteBuscador::class)->name('CrearVenta');
    Route::get('/crearSuscripcion', SuscripcionBuscador::class)->name('CrearSuscripcion');
    Route::get('/remisiones', GenerarR::class);
    Route::get('/historialR/{editar}', Historial::class);
    Route::get('/Facturas', Facturas::class)->name('Facturas');
    Route::get('/historialF', HistorialF::class)->name('historialF');
    Route::get('/PDFVenta', PDFVenta::class)->name('PDFVenta');
    Route::get('/PDFSuscripcion', PDFSuscripcion::class)->name('PDFSuscripcion');
    Route::get('/PDFTiro', PDFTiro::class)->name('PDFTiro');
    Route::get('/PDFPago', PDFPago::class)->name('PDFPago');
    Route::get('/PDFRemision', PDFRemision::class)->name('PDFRemision');
    Route::get('/PDFRemisionesP', PdfRemisionesP::class)->name('PDFRemisionesP');
    Route::get('/FacturarPPD/{cliente_id}/{idTipo}', FacturarPPD::class)->name('FacturarPPD');
    Route::get('/vistaPrevia/{id}', VistaFactura::class);
    Route::get('/agregarDiasSuscripcion', AgregarDiasSuscripcion::class)->name('agregarDiasSuscripcion');
    Route::get('/suspenderSuscripcion', SuspencionDeContrato::class)->name('suspenderSuscripcion');
    Route::get('/reporte-relacionCR', ReporteRelacionCR::class)->name('reporte-relacionCR');
    Route::get('/PDFReporteRCR', ReportePDFrelacionCR::class)->name('PDFReporteRCR');
    Route::get('/reporteSuscripcionSuspendida', SuscripcionSuspendidaReporte::class)->name('reporteSuscripcionSuspendida');
    Route::get('/reporteSuscripcionVencimiento', SuscripcionReporteFechas::class)->name('reporteSuscripcionVencimiento');
    Route::get('/PDFSuscripcionVencimiento', PdfSuscripcionReporteVencimiento::class)->name('PDFSuscripcionVencimiento');
    Route::get('/historialSuscripciones', HistorialSuscripciones::class)->name('historialSuscripciones');
    Route::get('/historialVentas', HistorialVentas::class)->name('historialVentas');
    Route::get('/historialComplementoPago', HistorialComplementoPago::class)->name('historialComplementoPago');
    Route::get('/vistaPreviaComplemento/{id}', VistaFacturaPPD::class);
    Route::get('/CancelarFacturaComplemento/{id}/{idCliente}', CancelarFacturaComplemento::class);
    Route::get('/CancelarVenta/{tipo}', CancelarVentas::class);
    Route::get('/CancelarSuscripciones/{tipo}', CancelarVentas::class);
    Route::get('/FacturasPPD', FacturaPPD::class)->name('FacturasPPD');
    Route::get('/vistaPreviaComplemento/{id}', VistaPreviaComplemento::class)->name('vistaPreviaPPD');
    Route::get('/CancelarVentaPDF', CancelarVentaPDF::class)->name('CancelarVentaPDF');
    Route::get('/reportVentaPFacturas', ReporteVentaPFacturas::class)->name('reportVentaPFacturas');
    Route::get('/reporteSaldos', ReporteSaldos::class)->name('reporteSaldos');
    Route::get('/remisionesRangoFecha', RemisionesRangoPorFecha::class)->name('remisionesRangoFecha');
    Route::get('/remisionesRangoPdfview', RemisionesRangoPdfview::class)->name('remisionesRangoPdfview');
    Route::get('/devolverVentas/{id}', Devolver::class)->name('devolverVentas');
    Route::get('/devolucionInforme', RegistroDevoluciones::class)->name('devolucionInforme');
    Route::get('/PDFDevolucionView', PDFViewDevolucion::class)->name('PDFDevolucionView');
    Route::get('/someInvoices/{type}', SomeInvoices::class)->name('someInvoices');
    Route::get('/makeComplemento/{id}', MakeComplement::class)->name('makeComplemento');

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

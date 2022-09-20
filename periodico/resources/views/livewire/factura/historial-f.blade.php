<div class="w-2/3 mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Listado de facturas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <br>
                <table class="table-auto w-full text-center">
                    <thead>
                        <tr class="text-white bg-gray-500">
                            <th class="px-4 py-2 w-20">Fecha</th>
                            <th class="px-4 py-2 w-20">Tipo</th>
                            <th class="px-4 py-2 w-20">Cliente</th>
                            <th class="px-4 py-2 w-20">Ejemplares</th>
                            <th class="px-4 py-2 w-20">Total</th>
                            <th class="px-4 py-2 w-20">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($invoices) > 0)
                            @foreach ($invoices as $invoice)
                                <tr>
                                    <td class="border">
                                        {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                                    <td class="border">
                                        {{ substr($invoice->idTipo, 0, 6) == 'suscri' ? 'Suscripción' : 'Venta/Cliente' }}
                                    </td>
                                    <td class="border">{{ $invoice->cliente }}</td>
                                    <td class="border">{{ $invoice->quantity }}</td>
                                    <td class="border">${{ $invoice->total }} {{ $invoice->currency }}</td>
                                    <td class="border">
                                        <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                            href="{{ url('vistaPrevia/' . $invoice->invoice_id) }}">Ver PDF</a>
                                        @if ($invoice->status == 'cancelada')
                                            <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-green-500 hover:bg-green-600 rounded-lg focus:shadow-outline"
                                                disabled>Factura
                                                cancelada</a>
                                        @else
                                            <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-red-500 hover:bg-red-600 rounded-lg focus:shadow-outline"
                                                href="{{ url('cancelarFactura/' . $invoice->invoice_id) }}">Cancelar
                                                factura</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="border">No hay facturas</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

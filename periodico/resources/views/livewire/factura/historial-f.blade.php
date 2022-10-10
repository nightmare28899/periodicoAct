<div class="w-3/5 mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Historial de facturas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <div class="w-64">
                        <h4>Elige la fecha:</h4>
                        <x-jet-input class="w-full" type="date" wire:model="fechaFactura"></x-jet-input>
                    </div>
                    <div class="w-64 p-6">
                        <input type="text"
                               class=" text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                               name="search" id="search" placeholder="Buscar Cliente" wire:model="query" autocomplete="off"/>

                        @if (!empty($query))

                            <div class="fixed top-0 right-0 bottom-0 left-0" wire:click="resetear"></div>

                            <div class="absolute z-10 list-group bg-white rounded-t-none shadow-lg">

                                @if (!empty($clientesBuscados))

                                    @foreach ($clientesBuscados as $i => $buscado)
                                        <div wire:click="selectContact({{ $i }})"
                                             class="list-item list-none p-2 hover:text-white hover:bg-blue-600 cursor-pointer">
                                            {{ $buscado['nombre'] }}
                                        </div>
                                    @endforeach
                                @else
                                    <div class="list-item list-none p-2">No hay resultado</div>
                                @endif
                            </div>

                        @endif
                    </div>
                </div>
                <br>

                @if ($invoices)
                <div class="text-center overflow-x">
                    <div class="overflow-x-auto w-full">
                        <table class="table-auto border-separate border-spacing-2 border border-dark">
                            <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2">Fecha</th>
                                <th class="px-4 py-2">Tipo</th>
                                <th class="px-4 py-2">Cliente</th>
                                <th class="px-4 py-2">Ejemplares</th>
                                <th class="px-4 py-2">Total</th>
                                <th class="px-4 py-2">Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoices as $invoice)
                                    <tr>
                                        <td class="px-4 py-2 border border-dark">
                                            {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                                        <td class="border">
                                            {{ substr($invoice->idTipo, 0, 6) == 'suscri' ? 'Suscripción' : 'Venta/Cliente' }}
                                        </td>
                                        <td class="px-4 py-2 border border-dark">{{ $invoice->cliente }}</td>
                                        <td class="px-4 py-2 border border-dark">{{ $invoice->quantity }}</td>
                                        <td class="px-4 py-2 border border-dark">${{ $invoice->total }} {{ $invoice->currency }}</td>
                                        <td class="px-4 py-2 border border-dark">
                                            <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                               href="{{ url('vistaPrevia/' . $invoice->invoice_id) }}">Ver PDF</a>
                                            @if ($invoice->status == 'cancelada')
                                                <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-red-500 hover:bg-red-600 rounded-lg focus:shadow-outline"
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
                                    <td colspan="13" class="border">No hay facturas</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

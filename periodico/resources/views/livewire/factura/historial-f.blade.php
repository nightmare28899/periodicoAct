<div class="w-2/3 mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Historial de Facturas') }}
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
                    <div class="w-64 ml-5 pt-6">
                        <input type="text"
                            class=" text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full"
                            name="search" id="search" placeholder="Buscar Cliente" wire:model="query"
                            autocomplete="off" />
                    </div>
                </div>
                <br>

                @if ($invoices)
                    <div class="text-center overflow-x">
                        <div class="overflow-x-auto w-full">
                            <table class="table-auto border-separate border-spacing-2 border border-dark">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 uppercase">Id</th>
                                        <th class="px-4 py-2 uppercase">Fecha</th>
                                        <th class="px-4 py-2 uppercase">Tipo</th>
                                        <th class="px-4 py-2 uppercase">Cliente</th>
                                        <th class="px-4 py-2 uppercase">Ejemplares</th>
                                        <th class="px-4 py-2 uppercase">Total</th>
                                        <th class="px-4 py-2 uppercase">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <td class="px-4 py-2 border border-dark">{{ $invoice->id }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}
                                            </td>
                                            <td class="border">
                                                {{ substr($invoice->idTipo, 0, 6) == 'suscri' ? 'Suscripción' : 'Venta/Cliente' }}
                                            </td>
                                            <td class="px-4 py-2 border border-dark">{{ $invoice->cliente }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $invoice->quantity }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                {{ sprintf('$ %s', number_format($invoice->total, 2)) }}
                                                {{ $invoice->currency }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                    href="{{ url('vistaPrevia/' . $invoice->invoice_id) }}">Ver PDF</a>
                                                @if ($invoice->status == 'cancelada')
                                                    <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-red-500 hover:bg-red-600 rounded-lg focus:shadow-outline"
                                                        disabled>Factura
                                                        cancelada</a>
                                                @else
                                                    <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-red-500 hover:bg-red-600 rounded-lg focus:shadow-outline"
                                                        href="{{ url('cancelarFactura/' . $invoice->invoice_id . '/cancelar') }}">Cancelar
                                                        factura</a>
                                                @endif

                                                @if ($invoice->status == 'CREDITO')
                                                    <x-jet-dropdown align="right" width="48">
                                                        <x-slot name="trigger">

                                                            <span class="inline-flex rounded-md">
                                                                <button type="button"
                                                                    class="btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                                    Acciones

                                                                    <svg class="ml-2 -mr-0.5 h-4 w-4"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        viewBox="0 0 20 20" fill="currentColor">
                                                                        <path fill-rule="evenodd"
                                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                            clip-rule="evenodd" />
                                                                    </svg>
                                                                </button>
                                                            </span>
                                                        </x-slot>

                                                        <x-slot name="content">
                                                            <div class="border-t border-gray-200"></div>
                                                            <button wire:click="complementpay({{ $invoice->id }})"
                                                                class="px-2 w-full py-1 cursor-pointer hover:bg-sky-600 hover:text-white">
                                                                Complemento de pago
                                                            </button>
                                                            <div class="border-t border-gray-200"></div>
                                                        </x-slot>
                                                    </x-jet-dropdown>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <br>
                    {{ $invoices->links('livewire.custom-pagination') }}
                @else
                    <div>
                        <p colspan="13" class="border">No hay facturas</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

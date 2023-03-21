<div class="w-11/12 mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Listado de Facturas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <div class="w-64">
                        <h4>Elige la fecha:</h4>
                        <x-jet-input class="w-full" type="date" wire:model="fechaRemision" />
                    </div>
                    <div class="w-64 ml-5 pt-6">
                        <input type="text"
                            class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full"
                            name="search" id="search" placeholder="Buscar nombre o id" wire:model="query"
                            autocomplete="off" />
                    </div>
                    <div class="w-64 ml-5 pt-4">
                        <button class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                            wire:click="someInvoices">Varias Facturas</button>
                    </div>
                </div>
                <br>

                @if ($invoices)
                    <div class="text-center overflow-x">
                        <div class="overflow-x-auto w-full">
                            <table class="table-auto border-separate border-spacing-2 border border-dark">
                                <thead>
                                    <tr class='bg-gray-100'>
                                        <th class='px-4 py-2 uppercase'>Id</th>
                                        <th class='px-4 py-2 uppercase'>Fecha</th>
                                        <th class='px-6 py-2 uppercase'>Tipo</th>
                                        <th class='px-4 py-2 uppercase'>Cliente</th>
                                        <th class='px-4 py-2 uppercase'>Entregar</th>
                                        <th class='px-4 py-2 uppercase'>Devuelto</th>
                                        <th class='px-4 py-2 uppercase'>Faltante</th>
                                        <th class='px-4 py-2 uppercase'>Venta</th>
                                        <th class='px-4 py-2 uppercase'>Precio</th>
                                        <th class='px-4 py-2 uppercase'>Importe</th>
                                        <th class='px-6 py-2 uppercase'>Dia</th>
                                        <th class='px-6 py-2 uppercase'>Nombre Ruta</th>
                                        <th class='px-6 py-2 uppercase'>Tipo</th>
                                        <th class="px-6 py-2 uppercase">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($invoices as $invoice)
                                        <tr>
                                            <td class='px-4 py-2 border border-dark'>
                                                {{ $invoice->id }}</td>
                                            <td class='px-4 py-2 border border-dark'>
                                                {{ \Carbon\Carbon::parse($invoice->fecha)->format('d/m/Y') }}</td>
                                            <td class='px-4 py-2 border border-dark'>
                                                {{ Str::substr($invoice->idTipo, 0, 5) }}</td>
                                            <td class='px-4 py-2 border border-dark'>
                                                {{ $invoice->cliente ? $invoice->cliente : $invoice->razon_social }}
                                            </td>
                                            <td class='px-4 py-2 border border-dark'>{{ $invoice->entregar }}</td>
                                            <td class='px-4 py-2 border border-dark'>{{ $invoice->devuelto }}</td>
                                            <td class='px-4 py-2 border border-dark'>{{ $invoice->faltante }}</td>
                                            <td class='px-4 py-2 border border-dark'>{{ $invoice->venta }}</td>
                                            <td class='px-4 py-2 border border-dark'>
                                                {{ sprintf('$ %s', number_format($invoice->precio, 2)) }}
                                            </td>
                                            <td class='px-4 py-2 border border-dark'>
                                                {{ sprintf('$ %s', number_format($invoice->importe, 2)) }}
                                            </td>
                                            <td class='px-4 py-2 border border-dark'>{{ $invoice->dia }}</td>
                                            <td class='px-4 py-2 border border-dark'>{{ $invoice->nombreruta }}</td>
                                            <td class='px-4 py-2 border border-dark'>{{ $invoice->tipo }}</td>
                                            <td class='px-4 py-2 border border-dark'>
                                                <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                    href="{{ url('factura/' . $invoice->cliente_id . '/' . $invoice->idTipo) }}">Facturar</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <br>
                        {{ $invoices->links('livewire.custom-pagination') }}
                    </div>
                @else
                    <div class="text-center">
                        <h3>No hay facturas para mostrar</h3>
                    </div>
                @endif
            </div>
        </div>
    </div>

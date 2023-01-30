<div class="container mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Listado de Facturas PPD') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    {{-- <div class="w-64">
                        <h4>Elige la fecha:</h4>
                        <x-jet-input class="w-full" type="date" wire:model="fechaRemision"></x-jet-input>
                    </div> --}}
                    <div class="w-64 ml-5 pt-6">
                        <input type="text"
                            class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full"
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
                                    <tr class='bg-gray-100'>
                                        <th class='px-4 py-2 uppercase'>Fecha</th>
                                        <th class='px-6 py-2 uppercase'>id</th>
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
                                        @if ($invoice->clasificacion == 'CRÉDITO' && $invoice->status == 'CREDITO' && $invoice->status != 'facturado')
                                            <tr>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ \Carbon\Carbon::parse($invoice->fecha)->format('d/m/Y') }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $invoice->idTipo }}</td>
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
                                                <td class='px-4 py-2 border border-dark'>{{ $invoice->nombreruta }}
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>{{ $invoice->tipo }}</td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                        href="{{ url('FacturarPPD/' . $invoice->cliente_id . '/' . $invoice->idTipo) }}">Facturar</a>
                                                </td>
                                            </tr>
                                            {{-- @elseif ($invoice->status == 'facturado' && $invoice->clasificacion == 'CRÉDITO')
                                            <tr>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ \Carbon\Carbon::parse($invoice->fecha)->format('d/m/Y') }}</td>
                                                <td class='px-4 py-2'>{{ $invoice->idTipo }}</td>
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
                                                <td class='px-4 py-2 border border-dark'>{{ $invoice->nombreruta }}
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>{{ $invoice->tipo }}</td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                        disabled>Facturado</a>
                                                </td>
                                            </tr>
                                        @elseif ($invoice->status == 'cancelado' && $invoice->clasificacion == 'CRÉDITO')
                                            <tr>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ \Carbon\Carbon::parse($invoice->fecha)->format('d/m/Y') }}</td>
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
                                                <td class='px-4 py-2 border border-dark'>{{ $invoice->nombreruta }}
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>{{ $invoice->tipo }}</td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-red-500 hover:bg-red-600 rounded-lg focus:shadow-outline"
                                                        disabled>Cancelado</a>
                                                </td>
                                            </tr> --}}
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @if ($invoice->clasificacion == 'CRÉDITO' && $invoice->status == 'CREDITO' && $invoice->status != 'facturado')
                        {{ $invoices->links('livewire.custom-pagination') }}
                    @endif
                @else
                    <div class="text-center">
                        <h1 class="text-2xl text-black font-bold">No hay registros</h1>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

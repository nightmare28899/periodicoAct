<div class="container mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Listado de facturas PPD') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <div class="w-64">
                        <h4>Elige la fecha:</h4>
                        <x-jet-input class="w-full" type="date" wire:model="fechaRemision"></x-jet-input>
                    </div>
                    <div class="w-64 ml-5 pt-6">
                        <input type="text"
                            class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                            name="search" placeholder="Buscar por ID cliente" wire:model="idCliente"
                            autocomplete="off" />
                    </div>
                    <div class="w-64 ml-5 pt-6">
                        <input type="text"
                            class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                            name="search" id="search" placeholder="Buscar Cliente" wire:model="query"
                            autocomplete="off" />

                        @if (!empty($query))

                            <div class="fixed top-0 right-0 bottom-0 left-0" wire:click="resetear"></div>

                            <div class="absolute z-10 list-group bg-white rounded-t-none shadow-lg">

                                @if (!empty($clientesBuscados))

                                    @foreach ($clientesBuscados as $i => $buscado)
                                        <div wire:click="selectContact({{ $i }})"
                                            class="list-item list-none p-2 hover:text-white hover:bg-blue-600 cursor-pointer w-full">
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

                @if ($tiros)
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
                                    @foreach ($tiros as $tiro)
                                        @if ($tiro->clasificacion == 'CRÉDITO' && $tiro->status == 'CREDITO')
                                            <tr>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ \Carbon\Carbon::parse($tiro->fecha)->format('d/m/Y') }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->idTipo }}</td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ $tiro->cliente ? $tiro->cliente : $tiro->razon_social }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->entregar }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->devuelto }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->faltante }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->venta }}</td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ sprintf('$ %s', number_format($tiro->precio, 2)) }}
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ sprintf('$ %s', number_format($tiro->importe, 2)) }}
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->dia }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->nombreruta }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->tipo }}</td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                        href="{{ url('FacturarPPD/' . $tiro->cliente_id . '/' . $tiro->idTipo) }}">Facturar</a>
                                                </td>
                                            </tr>
                                        @elseif ($tiro->status == 'facturado' && $tiro->clasificacion == 'CRÉDITO')
                                            <tr>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ \Carbon\Carbon::parse($tiro->fecha)->format('d/m/Y') }}</td>
                                                <td class='px-4 py-2'>{{ $tiro->idTipo }}</td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ $tiro->cliente ? $tiro->cliente : $tiro->razon_social }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->entregar }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->devuelto }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->faltante }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->venta }}</td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ sprintf('$ %s', number_format($tiro->precio, 2)) }}
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ sprintf('$ %s', number_format($tiro->importe, 2)) }}
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->dia }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->nombreruta }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->tipo }}</td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                        disabled>Facturado</a>
                                                </td>
                                            </tr>
                                        @elseif ($tiro->status == 'cancelado' && $tiro->clasificacion == 'CRÉDITO')
                                            <tr>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ \Carbon\Carbon::parse($tiro->fecha)->format('d/m/Y') }}</td>
                                                {{-- <td class='px-4 py-2'>{{ $tiro->idTipo }}</td> --}}
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ $tiro->cliente ? $tiro->cliente : $tiro->razon_social }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->entregar }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->devuelto }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->faltante }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->venta }}</td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ sprintf('$ %s', number_format($tiro->precio, 2)) }}
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ sprintf('$ %s', number_format($tiro->importe, 2)) }}
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->dia }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->nombreruta }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $tiro->tipo }}</td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-red-500 hover:bg-red-600 rounded-lg focus:shadow-outline"
                                                        disabled>Cancelado</a>
                                                </td>
                                            </tr>
                                            {{-- @elseif (count($tiros) > 0 && $tiro->status != 'Pagado')
                                        <td colspan="13" class="text-center font-bold">No tiene facturas</td>
                                        @break($tiro->status != 'Pagado') --}}
                                        @endif
                                    @endforeach

                                </tbody>

                            </table>

                        </div>
                    </div>
                @else
                    <div class="text-center">
                        <h1 class="text-2xl text-black font-bold">No hay registros</h1>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

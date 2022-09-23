<div class="w-2/3 mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Listado de facturas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="w-1/2 p-2">
                    <input type="text"
                           class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full"
                           name="search" id="search" placeholder="Buscar Cliente" wire:model="query"
                           wire:keydown.escape="resetear" wire:keydown.tab="resetear"
                           wire:keydown.arrow-up="decrementHighlight" wire:keydown.arrow-down="incrementHighlight"
                           wire:keydown.enter="selectContact" autocomplete="off" />

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
                <br>
                @if (count($tiros) > 0)
                    <div class="text-center overflow-x">
                        <div class="overflow-x-auto w-full">
                            <table class="table-auto border-solid border-2 border-dark">
                                <thead>
                                    <tr class='bg-gray-100'>
                                        <th class='px-4 py-2'>Fecha</th>
                                        {{-- <th class="px-6 py-2">idTipo</th> --}}
                                        <th class='px-4 py-2'>Cliente</th>
                                        <th class='px-4 py-2'>Entregar</th>
                                        <th class='px-4 py-2'>Devuelto</th>
                                        <th class='px-4 py-2'>Faltante</th>
                                        <th class='px-4 py-2'>Venta</th>
                                        <th class='px-4 py-2'>Precio</th>
                                        <th class='px-4 py-2'>Importe</th>
                                        <th class='px-6 py-2'>Dia</th>
                                        <th class='px-6 py-2'>Nombre Ruta</th>
                                        <th class='px-6 py-2'>Tipo</th>
                                        <th class="px-6 py-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tiros as $tiro)
                                        @if ($tiro->status == 'Pagado')
                                            <tr>
                                                <td class='px-4 py-2'>
                                                    {{ \Carbon\Carbon::parse($tiro->fecha)->format('d/m/Y') }}</td>
                                                {{-- <td class='px-4 py-2'>{{ $tiro->idTipo }}</td> --}}
                                                <td class='px-4 py-2'>
                                                    {{ $tiro->cliente ? $tiro->cliente : $tiro->razon_social }}</td>
                                                <td class='px-4 py-2'>{{ $tiro->entregar }}</td>
                                                <td class='px-4 py-2'>{{ $tiro->devuelto }}</td>
                                                <td class='px-4 py-2'>{{ $tiro->faltante }}</td>
                                                <td class='px-4 py-2'>{{ $tiro->venta }}</td>
                                                <td class='px-4 py-2'>
                                                    {{ sprintf('$ %s', number_format($tiro->precio)) }}
                                                </td>
                                                <td class='px-4 py-2'>
                                                    {{ sprintf('$ %s', number_format($tiro->importe)) }}
                                                </td>
                                                <td class='px-4 py-2'>{{ $tiro->dia }}</td>
                                                <td class='px-4 py-2'>{{ $tiro->nombreruta }}</td>
                                                <td class='px-4 py-2'>{{ $tiro->tipo }}</td>
                                                <td><a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                        href="{{ url('factura/' . $tiro->cliente_id . '/' . $tiro->idTipo) }}">Facturar</a>
                                                </td>
                                            </tr>
                                        @elseif ($tiro->status == 'facturado')
                                            <tr>
                                                <td class='px-4 py-2'>
                                                    {{ \Carbon\Carbon::parse($tiro->fecha)->format('d/m/Y') }}</td>
                                                {{-- <td class='px-4 py-2'>{{ $tiro->idTipo }}</td> --}}
                                                <td class='px-4 py-2'>
                                                    {{ $tiro->cliente ? $tiro->cliente : $tiro->razon_social }}</td>
                                                <td class='px-4 py-2'>{{ $tiro->entregar }}</td>
                                                <td class='px-4 py-2'>{{ $tiro->devuelto }}</td>
                                                <td class='px-4 py-2'>{{ $tiro->faltante }}</td>
                                                <td class='px-4 py-2'>{{ $tiro->venta }}</td>
                                                <td class='px-4 py-2'>
                                                    {{ sprintf('$ %s', number_format($tiro->precio)) }}
                                                </td>
                                                <td class='px-4 py-2'>
                                                    {{ sprintf('$ %s', number_format($tiro->importe)) }}
                                                </td>
                                                <td class='px-4 py-2'>{{ $tiro->dia }}</td>
                                                <td class='px-4 py-2'>{{ $tiro->nombreruta }}</td>
                                                <td class='px-4 py-2'>{{ $tiro->tipo }}</td>
                                                <td><a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                        disabled>Facturado</a>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td></td>
                                            </tr>
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

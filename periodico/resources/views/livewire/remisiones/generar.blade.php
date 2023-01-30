<div class="mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Lista de Remisiones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="grid justify-items-start">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4 justify-self-center">
                <div class="flex">
                    {{-- <div class="flex-none mx-1">
                        <h4>Elige la fecha:</h4>
                        <x-jet-input type="date" wire:model="fechaRemision"></x-jet-input>
                    </div> --}}
                    <div class="flex-none">
                        <h4>Busca el cliente:</h4>
                        <input type="text"
                            class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                            name="search" id="search" placeholder="Buscar Cliente" wire:model="query"
                            autocomplete="off" />
                    </div>
                    <br>
                    <div class="flex-none mx-1">
                        <h4>Desde:</h4>
                        <x-jet-input type="date" wire:model="de"></x-jet-input>
                    </div>
                    <div class="flex-none mx-1">
                        <h4>Hasta:</h4>
                        <x-jet-input type="date" wire:model="hasta"></x-jet-input>
                    </div>
                    <div class="flex-none mx-1">
                        <h4>Ruta:</h4>
                        <select
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                            style="width: 11rem;" wire:model="rutaSeleccionada">
                            <option value='Todos' selected>TODOS</option>
                            @foreach ($ruta as $rut)
                                <option value='{{ $rut['nombreruta'] }}'>
                                    {{ $rut['nombreruta'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-none mx-1">
                        <h4>Tipo</h4>
                        <select
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                            style="width: 11rem;" wire:model="tipoSeleccionada">
                            <option value='todos'>TODOS</option>
                            <option value='venta'>
                                Venta/Cliente
                            </option>
                            <option value='suscripcion'>
                                Suscripción
                            </option>
                        </select>
                    </div>
                    <div class="pt-6 ml-2">
                        <div>
                            <button wire:click="descargaTodasRemisiones" id="tiro" wire:loading.attr="disabled"
                                class="p-2 bg-green-500 rounded-md text-white hover:bg-green-700">
                                <svg wire:loading wire:target="descargaTodasRemisiones"
                                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4">
                                    </circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Generar Todas
                            </button>
                        </div>
                    </div>
                    <div class="mt-6 ml-2">
                        <button wire:click="descargaRemision" id="tiro" wire:loading.attr="disabled"
                            class="p-2 bg-green-500 rounded-md text-white hover:bg-green-700">
                            <svg wire:loading wire:target="descargaRemision"
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Generar Seleccion
                        </button>
                    </div>
                </div>
                <br>
                <div class="text-center overflow-x">
                    <div class="overflow-x-auto">
                        <table class="table-auto border-separate border-spacing-2 border border-dark w-full">
                            <thead>
                                <tr class='bg-gray-100'>
                                    <th class='px-4 py-2 uppercase'>Selecciona</th>
                                    <th class='px-4 py-2 uppercase'>Cliente</th>
                                    <th class='px-4 py-2 uppercase'>Entregar</th>
                                    <th class='px-4 py-2 uppercase'>Devuelto</th>
                                    <th class='px-4 py-2 uppercase'>Faltante</th>
                                    <th class='px-4 py-2 uppercase'>Venta</th>
                                    <th class='px-4 py-2 uppercase'>Precio</th>
                                    <th class='px-4 py-2 uppercase'>Importe</th>
                                    {{-- <th class='px-6 py-2 uppercase'>Dia</th> --}}
                                    <th class='px-6 py-2 uppercase'>Nombre Ruta</th>
                                    <th class='px-6 py-2 uppercase'>Tipo</th>
                                    <th class='px-6 py-2 uppercase'>Fecha Inicio</th>
                                    <th class='px-6 py-2 uppercase'>Fecha Fin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($ventaCopia)
                                    @foreach ($ventaCopia as $result)
                                        @if (/* $result->{$diaS} != 0 &&  */ $result->estado == 'Activo' && $result->remisionStatus == 'Pendiente'/*  ||  $result->remisionStatus == 'Cancelada' */)
                                            <tr>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <input wire:model="clienteSeleccionado" type="checkbox"
                                                        value={{ $result->idVenta }}>
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ $result->nombre ? $result->nombre : $result->razon_social }}
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ $result->lunes + $result->martes + $result->miércoles + $result->jueves + $result->viernes + $result->sábado + $result->domingo }}
                                                    <b>periód.</b>
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>{{ $devuelto }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $faltante }}</td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ $result->lunes + $result->martes + $result->miércoles + $result->jueves + $result->viernes + $result->sábado + $result->domingo }}
                                                    <b>periód.</b>
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <b>Domingo:</b>
                                                    {{ sprintf('$ %s', number_format($result->dominical, 2)) }},
                                                    <b>Ordinario:</b>
                                                    {{ sprintf('$ %s', number_format($result->ordinario, 2)) }}
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ sprintf('$ %s', number_format($result->total, 2)) }}
                                                </td>
                                                {{-- <td class='px-4 py-2 border border-dark'>{{ $diaS }}</td> --}}
                                                <td class='px-4 py-2 border border-dark'>{{ $result->nombreruta }}
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>{{ $result->tiporuta }}</td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <div class="form-group">
                                                        <label class="text-black"
                                                            for="Física">{{ \Carbon\Carbon::parse($result->desde)->format('d/m/Y') }}</label>
                                                    </div>
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ \Carbon\Carbon::parse($result->hasta)->format('d/m/Y') }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
                                    </tr>
                                @endif
                                @if ($suscripcionCopia)
                                    @foreach ($suscripcionCopia as $suscri)
                                        @if ($suscri->remisionStatus != 'Remisionado' && $suscri->estado != 'Cancelada')
                                            <tr>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <input wire:model="clienteSeleccionado" type="checkbox"
                                                        value={{ $suscri->idSuscripcion }}>
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ $suscri->nombre ? $suscri->nombre : $suscri->razon_social }}
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>{{ $suscri->cantEjemplares }}
                                                    <b>periód.</b>
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>{{ $devuelto }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $faltante }}</td>
                                                <td class='px-4 py-2 border border-dark'>{{ $suscri->cantEjemplares }}
                                                    <b>periód.</b>
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ sprintf('$ %s', number_format($suscri->importe / $suscri->cantEjemplares, 2)) }}
                                                </td>
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    {{ sprintf('$ %s', number_format($suscri->importe, 2)) }}
                                                </td>{{--
                                                <td class='px-4 py-2 border border-dark'>{{ $diaS }}</td> --}}
                                                <td class='px-4 py-2 border border-dark'>{{ $suscri->nombreruta }}
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>{{ $suscri->tiporuta }}</td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <div class="form-group">
                                                        <label
                                                            class="text-black">{{ \Carbon\Carbon::parse($suscri->fechaInicio)->format('d/m/Y') }}</label>
                                                    </div>
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <div class="form-group">
                                                        <label
                                                            class="text-black">{{ \Carbon\Carbon::parse($suscri->fechaFin)->format('d/m/Y') }}</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @else
                                    <tr>
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

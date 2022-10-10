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
                    <div class="flex-none mx-1">
                        <h4>Elige la fecha:</h4>
                        <x-jet-input type="date" wire:model="fechaRemision"></x-jet-input>
                    </div>
                    <div class="flex-none">
                        <h4>Busca el cliente:</h4>
                        <input type="text"
                               class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                               name="search" id="search" placeholder="Buscar Cliente" wire:model="query" autocomplete="off"/>

                        @if (!empty($query))

                            <div class="fixed top-0 right-0 bottom-0 left-0" wire:click="resetear"></div>

                            <div class="absolute z-10 list-group bg-white rounded-t-none shadow-lg w-26">

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
                            <option value='venta'>
                                Venta/Cliente
                            </option>
                            <option value='suscripcion'>
                                Suscripción
                            </option>
                        </select>
                    </div>
                    <div class="flex-none pt-1">
                        <div>
                            <button wire:click="descargaTodasRemisiones" id="tiro" wire:loading.attr="disabled"
                                    class="p-2 bg-green-500 rounded-md text-white hover:bg-green-700">
                                <svg wire:loading wire:target="descargaTodasRemisiones"
                                     class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                     xmlns="http://www.w3.org/2000/svg"
                                     fill="none" viewBox="0 0 24 24">
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
                        <div class="mt-1">
                            <button wire:click="descargaRemision" id="tiro" wire:loading.attr="disabled"
                                    class="p-2 bg-green-500 rounded-md text-white hover:bg-green-700">
                                <svg wire:loading wire:target="descargaRemision"
                                     class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                     xmlns="http://www.w3.org/2000/svg"
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
                </div>
                <br>
                <div class="text-center overflow-x">
                    <div class="overflow-x-auto">
                        <table class="table-auto border-solid border-2 border-dark">
                            <thead>
                            <tr class='text-white bg-gray-500'>
                                <th class='px-4 py-2'>Fecha</th>
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
                            </tr>
                            </thead>
                            <tbody>
                            @if (count($this->ventaCopia) > 0)
                                @foreach ($ventaCopia as $result)
                                    @if ($result->{$diaS} != 0)
                                        <tr>
                                            <td class='px-4 py-2'>
                                                <div class="form-group">
                                                    <input wire:model="clienteSeleccionado" type="checkbox"
                                                           value={{ $result->idVenta }}>
                                                    <label class="text-black"
                                                           for="Física">{{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</label>
                                                </div>
                                            </td>
                                            <td class='px-4 py-2'>
                                                {{ $result->nombre ? $result->nombre : $result->razon_social }}</td>
                                            <td class='px-4 py-2'>{{ $result->{$diaS} }}</td>
                                            <td class='px-4 py-2'>{{ $devuelto }}</td>
                                            <td class='px-4 py-2'>{{ $faltante }}</td>
                                            <td class='px-4 py-2'>{{ $result->{$diaS} }}</td>
                                            <td class='px-4 py-2'>
                                                ${{ $diaS == 'domingo' ? $result->dominical : $result->ordinario }}
                                            </td>
                                            <td class='px-4 py-2'>
                                                ${{ ($diaS == 'domingo' ? $result->dominical : $result->ordinario) * $result->{$diaS} }}
                                            </td>
                                            <td class='px-4 py-2'>{{ $diaS }}</td>
                                            <td class='px-4 py-2'>{{ $result->nombreruta }}</td>
                                            <td class='px-4 py-2'>{{ $result->tiporuta }}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="11" class="text-center">
                                                No tiene ventas para este dia
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            @else
                                <tr>
                                </tr>
                            @endif
                            @if (count($suscripcionCopia) > 0)
                                @foreach ($suscripcionCopia as $suscri)
                                    @if ($suscri->{$diaS} != 0)
                                        <tr>
                                            <td class='px-4 py-2'>
                                                <div class="form-group">
                                                    <input wire:model="clienteSeleccionado" type="checkbox"
                                                           value={{ $suscri->idSuscripcion }}>
                                                    <label class="text-black"
                                                           for="Física">{{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</label>
                                                </div>
                                            </td>
                                            <td class='px-4 py-2'>
                                                {{ $suscri->nombre ? $suscri->nombre : $suscri->razon_social }}</td>
                                            <td class='px-4 py-2'>{{ $suscri->cantEjemplares }}</td>
                                            <td class='px-4 py-2'>{{ $devuelto }}</td>
                                            <td class='px-4 py-2'>{{ $faltante }}</td>
                                            <td class='px-4 py-2'>{{ $suscri->cantEjemplares }}</td>
                                            <td class='px-4 py-2'>
                                                ${{ $suscri->tarifa == 'Base' ? 330 : 300 }}
                                            </td>
                                            <td class='px-4 py-2'>
                                                ${{ $suscri->importe }}
                                            </td>
                                            <td class='px-4 py-2'>{{ $diaS }}</td>
                                            <td class='px-4 py-2'>{{ $suscri->nombreruta }}</td>
                                            <td class='px-4 py-2'>{{ $suscri->tiporuta }}</td>
                                        </tr>
                                    @else
                                        <tr>
                                            <td colspan="11" class="text-center">
                                                No tiene suscripcion
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

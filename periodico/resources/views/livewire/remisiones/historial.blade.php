<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Historial de Remisiones') }}
        </h2>
    </x-slot>

    <div class="py-12 mx-auto px-4 container">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <div class="w-64">
                <input type="text"
                       class=" text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full"
                       name="search" id="search" placeholder="Buscar Cliente" wire:model="query"
                       wire:keydown.escape="resetear" wire:keydown.tab="resetear"
                       wire:keydown.arrow-up="decrementHighlight" wire:keydown.arrow-down="incrementHighlight"
                       wire:keydown.enter="selectContact"/>

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
            <br>
            @if (count($tiros) > 0)
                <div class="text-center overflow-x">
                    <div class="overflow-x-auto">
                        <table class="table-auto border-solid border-2 border-dark w-full">
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
                                    <td class='px-4 py-2'>{{ sprintf('$ %s', number_format($tiro->precio)) }}
                                    </td>
                                    <td class='px-4 py-2'>{{ sprintf('$ %s', number_format($tiro->importe)) }}
                                    </td>
                                    <td class='px-4 py-2'>{{ $tiro->dia }}</td>
                                    <td class='px-4 py-2'>{{ $tiro->nombreruta }}</td>
                                    <td class='px-4 py-2'>{{ $tiro->tipo }}</td>
                                    {{-- checa esto agrega el estado al tiro para poder cambiar el boton segun el estdo --}}
                                    @if ($tiro->precio == 330 || $tiro->precio == 300)
                                        <td>
                                            @if ($tiro->estado == 'Activo')
                                                <button wire:click="pausarRemision({{ $tiro->cliente_id }})"
                                                        class="px-2 py-1 cursor-pointer bg-red-500 hover:bg-red-600 text-white my-2 rounded-lg">
                                                    Pausar
                                                    suscripción
                                                </button>
                                            @elseif ($tiro->estado == 'Pausado')
                                                <button wire:click="pausarRemision({{ $tiro->cliente_id }})"
                                                        class="px-2 py-1 cursor-pointer bg-sky-500 hover:bg-sky-600 text-white my-2 rounded-lg">
                                                    Activar
                                                    suscripción
                                                </button>
                                            @endif

                                            @if ($tiro->status == 'Pagado' && substr($tiro->idTipo, 0, 6) == 'suscri')
                                                <button
                                                    class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                    disabled>Pagado
                                                </button>
                                                <button
                                                    wire:click="generarPDF({{ $tiro->cliente_id }}, '{{ $tiro->idTipo }}')"
                                                    class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                >Ver PDF
                                                </button>
                                            @elseif ($tiro->status == 'Pagado' && substr($tiro->idTipo, 0, 5) == 'venta')
                                                <button
                                                    class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                    disabled>Pagado
                                                </button>
                                                <button
                                                    wire:click="generarPDF({{ $tiro->cliente_id }}, '{{ $tiro->idTipo }}')"
                                                    class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                >Ver PDF
                                                </button>
                                            @else
                                                <button
                                                    wire:click="pagar({{ $tiro->cliente_id }}, '{{ $tiro->idTipo }}')"
                                                    class="inline-flex
                                                            items-center h-10 px-4 m-2 text-sm text-white
                                                            transition-colors duration-150 bg-indigo-500
                                                            hover:bg-indigo-600 rounded-lg
                                                            focus:shadow-outline">Pagar
                                                </button>
                                            @endif
                                        </td>
                                    @else
                                        <td>
                                            <button wire:click="editarRemision({{ $tiro->id }})"
                                                    class="px-2 py-2 cursor-pointer bg-sky-500 hover:bg-sky-600 text-white my-2 rounded-lg">
                                                Editar
                                            </button>

                                            @if ($tiro->status == 'Pagado')
                                                <button
                                                    class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                    disabled>Pagado
                                                </button>
                                            @else
                                                <button
                                                    wire:click="pagar({{ $tiro->cliente_id }}, '{{ $tiro->idTipo }}')"
                                                    class="inline-flex
                                                            items-center h-10 px-4 m-2 text-sm text-white
                                                            transition-colors duration-150 bg-indigo-500
                                                            hover:bg-indigo-600 rounded-lg
                                                            focus:shadow-outline"
                                                    target="_blank">Pagar
                                                </button>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
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

    {{-- MODAL EDITAR DEVUELTOS --}}
    <x-jet-dialog-modal wire:model="modalEditar">

        <x-slot name="title">
            <div class="flex sm:px-6">
                <h1 class="mb-3 text-2xl text-black font-bold ml-3">Editar devueltos</h1>
                <button type="button" wire:click="cerrarEditar" wire:loading.attr="disabled"
                        class="mb-3 text-gray-400 bg-transparent hover:bg-red-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-red-600 dark:hover:text-white"
                        data-modal-toggle="defaultModal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <hr>
        </x-slot>

        <x-slot name="content">
            <div class="mb-3">
                <label for="exampleFormControlInput2" class="block text-black text-sm font-bold mb-2">Cantidad de
                    devueltos:</label>
                <input type="number"
                       class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('nombre') border-red-500 @enderror"
                       id="devuelto" wire:model.defer="devuelto" placeholder="Cantidad" min="0"/>
            </div>
            @if ($devuelto == 0 || ($devuelto > 0 && $entregar > 0))
                <p>devuelto: {{ $devuelto }}</p>
                <p>entregar: {{ $entregar }}</p>
                <button wire:click.prevent="updateDevueltos" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    <svg wire:loading wire:target="updateDevueltos" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Devolver
                </button>
            @elseif ($entregar == 0 && $devuelto > 0)
                <p>devuelto: {{ $devuelto }}</p>
                <p>entregar: {{ $entregar }}</p>
                <button wire:click.prevent="updateDevueltos" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    <svg wire:loading wire:target="updateDevueltos" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Cancelar devolución
                </button>
            @endif
        </x-slot>

        <x-slot name="footer">

        </x-slot>

    </x-jet-dialog-modal>
</div>

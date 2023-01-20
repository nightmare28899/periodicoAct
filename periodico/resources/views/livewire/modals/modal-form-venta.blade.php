<x-jet-dialog-modal wire:model="modalV">

    <x-slot name="title">
        <div class="flex sm:px-6">
            <h1 class="mb-3 text-2xl text-black font-bold ml-3">Crear Venta</h1>
            <button type="button" wire:click="$set('modalV', false)" wire:loading.attr="disabled"
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
        <div class="relative">
            <style>
                .highlight {
                    background-color: #89caf5;
                }
            </style>

            <div class="w-full flex">
                <div class="w-full">
                    <input type="text"
                        class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                        name="search" id="search" placeholder="Buscar Cliente" wire:model="query"
                        autocomplete="off" />
                    @if (!empty($query))

                        <div class="fixed top-0 right-0 bottom-0 left-0" wire:click="resetear"></div>

                        <div class="absolute z-10 list-group bg-white rounded-t-none shadow-lg" style="width: 49%;">

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
                <div class="w-full ml-2">
                    {{-- <input type="number" min="0" max="1000"
                        class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                        wire:keydown.enter="showInformation" wire:model.defer="ventaEncontrada"
                        placeholder="Escribe el id de la venta" /> --}}
                        <select wire:model="ventaEncontrada" wire:click="editarVenta()" class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase">
                            <option>{{ $ventas != null ? 'Selecciona una venta' : 'No tiene ventas' }}</option>
                            @foreach ($ventas as $venta)
                                <option value="{{ $venta->id??null }}">{{ $venta->id??null }}</option>
                            @endforeach
                        </select>
                </div>
            </div>

            @if ($clienteSeleccionado != null)
                {{-- @php
                            $clienteSeleccionado = (object) $clienteSeleccionado;
                        @endphp --}}
                <div class="flex w-full mt-2 space-x-4">
                    <div class="px-2 w-full">
                        <b>R.F.C.: <br> <input type="text" style="height: 1.7rem;"
                                value="{{ $clienteSeleccionado['rfc_input'] }}"
                                class="border-0 rounded-md bg-gray-200 w-full" disabled></b>
                    </div>
                    <div class="px-2 w-full">
                        <b>Nombre: <br> <input type="text" style="height: 1.7rem;"
                                value="{{ $clienteSeleccionado['nombre'] }}"
                                class="border-0 rounded-md bg-gray-200 w-full" disabled></b>
                    </div>
                </div>
                <div class="flex w-full mt-2 space-x-4">
                    <div class="px-2 w-full">
                        <b>Razón Social: <br> <input type="text" style="height: 1.7rem;"
                                value="{{ $clienteSeleccionado['razon_social'] }}"
                                class="border-0 rounded-md bg-gray-200 w-full" disabled></b>
                    </div>
                    <div class="px-2 w-full">
                        <b>Estado: <br> <input type="text" style="height: 1.7rem;"
                                value="{{ $clienteSeleccionado['estado'] }}"
                                class="border-0 rounded-md bg-gray-200 w-full" disabled></b>
                    </div>
                </div>
                <div class="flex w-full mt-2 space-x-4">
                    <div class="px-2 w-full">
                        <b>Regimen Fiscal: <br> <input type="text" style="height: 1.7rem;"
                                value="{{ $clienteSeleccionado['regimen_fiscal'] }}"
                                class="border-0 rounded-md bg-gray-200 w-full" disabled></b>
                    </div>
                    <div class="px-2 w-full">
                        <b>Telefono: <br> <input type="text" style="height: 1.7rem;"
                                value="{{ $clienteSeleccionado['telefono'] }}"
                                class="border-0 rounded-md bg-gray-200 w-full" disabled></b>
                    </div>
                </div>
                <div class="flex w-full mt-2 space-x-4">
                    <div class="px-2 w-full">
                        <b>E-mail: <br> <input type="text" style="height: 1.7rem;"
                                value="{{ $clienteSeleccionado['email'] }}"
                                class="border-0 rounded-md bg-gray-200 w-full" disabled></b>
                    </div>
                    <div class="px-2 w-full">
                        <b>Clasificación: <br> <input type="text" style="height: 1.7rem;"
                                value="{{ $clienteSeleccionado['clasificacion'] }}"
                                class="border-0 rounded-md bg-gray-200 w-full" disabled></b>
                    </div>
                </div>
                <div class="flex w-full mt-2 space-x-4">
                    <div class="px-2 w-full">
                        <b>País: <br> <input type="text" style="height: 1.7rem;"
                                value="{{ $clienteSeleccionado['pais'] }}"
                                class="border-0 rounded-md bg-gray-200 w-full" disabled></b>
                    </div>
                    <div class="px-2 w-full">
                    </div>
                </div>
            @else
                <div></div>
            @endif

            <div class="flex w-full">
                <div class="w-full p-2">
                    <p class="font-bold">Desde:</p>
                    <x-jet-input class="w-full" type="date" wire:model="desde">
                    </x-jet-input>
                </div>
                <div class="w-full p-2">
                    <p class="font-bold">Hasta:</p>
                    <x-jet-input class="w-full" type="date" wire:model="hasta">
                    </x-jet-input>
                </div>
            </div>
            <div class="flex w-full">
                <div class="w-full p-2">
                    <label for="lunesVentas" class="block text-black text-sm font-bold mb-2">Lunes:</label>
                    <input type="number" min="0" max="1000"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('lunesVentas') border-red-500 @enderror"
                        id="lunesVentas" wire:model="lunesVentas" placeholder="Escribe la cantidad" />
                    @error('lunesVentas')
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-full p-2">
                    <label for="martesVentas" class="block text-black text-sm font-bold mb-2">Martes:</label>
                    <input type="number" min="0" max="1000"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('martesVentas') border-red-500 @enderror"
                        id="martesVentas" wire:model="martesVentas" placeholder="Escribe la cantidad" />
                    @error('martesVentas')
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="flex w-full">
                <div class="w-full p-2">
                    <label for="miercolesVentas" class="block text-black text-sm font-bold mb-2">Miércoles:</label>
                    <input type="number" min="0" max="1000"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('miercolesVentas') border-red-500 @enderror"
                        id="miercolesVentas" wire:model="miercolesVentas" placeholder="Escribe la cantidad" />
                    @error('miercolesVentas')
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-full p-2">
                    <label for="juevesVentas" class="block text-black text-sm font-bold mb-2">Jueves:</label>
                    <input type="number" min="0" max="1000"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('juevesVentas') border-red-500 @enderror"
                        id="juevesVentas" wire:model="juevesVentas" placeholder="Escribe la cantidad" />
                    @error('juevesVentas')
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="flex w-full">
                <div class="w-full p-2">
                    <label for="viernesVentas" class="block text-black text-sm font-bold mb-2">Viernes:</label>
                    <input type="number" min="0" max="1000"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('viernesVentas') border-red-500 @enderror"
                        id="viernesVentas" wire:model="viernesVentas" placeholder="Escribe la cantidad" />
                    @error('viernesVentas')
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-full p-2">
                    <label for="sabadoVentas" class="block text-black text-sm font-bold mb-2">Sábado:</label>
                    <input type="number" min="0" max="1000"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('sabadoVentas') border-red-500 @enderror"
                        id="sabadoVentas" wire:model="sabadoVentas" placeholder="Escribe la cantidad" />
                    @error('sabadoVentas')
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="flex w-full">
                <div class="w-full p-2">
                    <label for="domingoVentas" class="block text-black text-sm font-bold mb-2">Domingo:</label>
                    <input type="number" min="0" max="1000"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('domingo') border-red-500 @enderror"
                        id="domingoVentas" wire:model="domingoVentas" placeholder="Escribe la cantidad" />
                    @error('domingoVentas')
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-full">
                    <p class="pt-12 ml-2"><b>Total de la venta:</b> {{ $total ? sprintf('$ %s', number_format($total, 2)) : 0 }}</p>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <div class="flex px-4 sm:px-6 mt-5 space-x-4">
            <div class="w-1/2">
                <x-jet-secondary-button wire:click.prevent="abrirModalDomicilio" type="button"
                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    <svg wire:loading wire:target="abrirModalDomicilio"
                        class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Domicilio
                </x-jet-secondary-button>
            </div>

            <div class="w-1/2">
                @if ($editEnabled == true)
                    <x-jet-secondary-button wire:click.prevent="actualizarVenta" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        <svg wire:loading wire:target="actualizarVenta"
                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        actualizar
                    </x-jet-secondary-button>
                @else
                    <x-jet-secondary-button wire:click.prevent="crearVenta" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        <svg wire:loading wire:target="crearVenta" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Crear
                    </x-jet-secondary-button>
                @endif
            </div>
        </div>
    </x-slot>

</x-jet-dialog-modal>

{{-- MODAL ERRORES --}}
<x-jet-dialog-modal wire:model="modalErrors">

    <x-slot name="title">
        {{-- <h1 class="font-bold text-red-500">Errores</h1> --}}
    </x-slot>

    <x-slot name="content">
        <div class="px-4 mb-4 text-center" flex-grow>
            <img class="mx-auto" src="/img/error.png" width="100px" height="100px" alt="logo error">
            <br>
            <p class="font-bold mt-5 text-red-700">{!! nl2br($d) !!}</p>
            <br>
        </div>
    </x-slot>

    <x-slot name="footer">
    </x-slot>

</x-jet-dialog-modal>

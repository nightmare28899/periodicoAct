<x-jet-dialog-modal wire:model="modalV" maxWidth="5xl">

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
        <div class="px-4 mb-6" flex-grow>
            <div class="flex">
                <div class="w-1/2 px-2">
                    <p class="font-bold">Selecciona el cliente</p>
                </div>
            </div>
            <div class="flex">
                <div class="w-1/2 p-2">
                    <select
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('clasificacion') border-red-500 @enderror"
                        wire:model="clienteSeleccionado" style="width: 100%">
                        <option value='' style="display: none;">Selecciona un cliente</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                        @endforeach
                        @error('clienteSeleccionado')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </select>
                </div>
            </div>
            @foreach ($dataClient as $data)
                <div class="flex mt-2">
                    <div class="w-1/2 px-2">
                        <p class="font-bold">FACTURAR A:</p>
                        <b class="">Clave: <input type="text" style="height: 1.7rem; margin-left: 2.4rem;"
                                value="{{ $loop->iteration }}" class="border-0 bg-gray-200" disabled></b>
                    </div>
                    <div class="w-1/2 px-2">
                        <br>
                        <b>R.F.C.: <input type="text" style="height: 1.7rem; margin-left: 1.8rem;"
                                value="{{ $data->rfc_input }}" class="border-0 bg-gray-200" disabled></b>
                    </div>
                    <div class="w-1/2 px-2">
                        <br>
                        <b>Nombre: <input type="text" style="height: 1.7rem; margin-left: 1.2rem;"
                                value="{{ $data->nombre }}" class="border-0 bg-gray-200" disabled></b>
                    </div>
                </div>
                <div class="flex mt-1">
                    <div class="w-1/2 px-2">
                        <b>Calle: <input type="text" style="height: 1.7rem; margin-left: 2.6rem;"
                                value="{{ $data->calle }}" class="border-0 bg-gray-200" disabled></b>
                    </div>
                    <div class="w-1/2 px-2">
                        <b>No. Int: <input type="text" style="height: 1.7rem; margin-left: 1.3rem;"
                                value="{{ $data->noint }}" class="border-0 bg-gray-200" disabled></b>
                    </div>
                    <div class="w-1/2 px-2">
                        <b>No. Ext.: <input type="text" style="height: 1.7rem; margin-left: 1.2rem;"
                                value="{{ $data->noext }}" class="border-0 bg-gray-200" disabled></b>
                    </div>
                </div>
                <div class="flex mt-1">
                    <div class="w-1/2 px-2">
                        <b>Colonia: <input type="text" style="height: 1.7rem; margin-left: 1.4rem;"
                                value="{{ $data->colonia }}" class="border-0 bg-gray-200" disabled></b>
                    </div>
                    <div class="w-1/2 px-2">
                        <b>C.P.: <input type="text" style="height: 1.7rem; margin-left: 2.5rem;"
                                value="{{ $data->cp }}" class="border-0 bg-gray-200" disabled></b>
                    </div>
                    <div class="w-1/2 px-2">
                        <b>Localidad: <input type="text" style="height: 1.7rem; margin-left: 0.4rem;"
                                value="{{ $data->localidad }}" class="border-0 bg-gray-200" disabled></b>
                    </div>
                </div>
                <div class="flex mt-1">

                    <div class="w-1/2 px-2">
                        <b>Municipio: <input type="text" style="height: 1.7rem; margin-left: 0.5rem;"
                                value="{{ $data->municipio }}" class="border-0 bg-gray-200" disabled></b>
                    </div>
                    <div class="w-1/2 px-2">
                        <b>Estado: <input type="text" style="height: 1.7rem; margin-left: 1.1rem;"
                                value="{{ $data->estado }}" class="border-0 bg-gray-200" disabled></b>
                    </div>
                    <div class="w-1/2 px-2">
                        <b>País: <input type="text" style="height: 1.7rem; margin-left: 2.9rem;"
                                value="{{ $data->pais }}" class="border-0 bg-gray-200" disabled></b>
                    </div>
                </div>
                <div class="flex mt-1">
                    <div class="w-1/2 px-2">
                        <b>E-mail: <input type="text" style="height: 1.7rem; margin-left: 1.8rem;"
                                value="{{ $data->email }}" class="border-0 bg-gray-200" disabled></b>
                    </div>
                    <div class="w-1/2 px-2">
                        <b>Tel: <input type="text" style="height: 1.7rem; margin-left: 2.9rem;"
                                value="{{ $data->telefono }}" class="border-0 bg-gray-200" disabled></b>
                    </div>
                    <div class="w-1/2 p-2"></div>
                </div>
            @endforeach
            <div class="flex">
                <div class="w-1/2 p-2">
                    <p class="font-bold">Desde:</p>
                    <x-jet-input class="w-full" type="date" wire:model="desde">
                    </x-jet-input>
                </div>
                <div class="w-1/2 p-2">
                    <p class="font-bold">Hasta:</p>
                    <x-jet-input class="w-full" type="date" wire:model="hasta">
                    </x-jet-input>
                </div>
                <div class="w-1/2"></div>
            </div>
            <div class="flex">
                <div class="w-1/2 p-2">
                    <label for="lunes"
                        class="block text-black text-sm font-bold mb-2">Lunes(Opcional):</label>
                    <input type="number" min="0"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('lunes') border-red-500 @enderror"
                        id="lunes" wire:model="lunesVentas" placeholder="Escribe la cantidad" />
                    @error('lunes')
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/2 p-2">
                    <label for="martes"
                        class="block text-black text-sm font-bold mb-2">Martes(Opcional):</label>
                    <input type="number" min="0"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('martes') border-red-500 @enderror"
                        id="martes" wire:model="martesVentas" placeholder="Escribe la cantidad" />
                    @error('martes')
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/2"></div>
            </div>
            <div class="flex">
                <div class="w-1/2 p-2">
                    <label for="miércoles"
                        class="block text-black text-sm font-bold mb-2">Miércoles(Opcional):</label>
                    <input type="number" min="0"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('miércoles') border-red-500 @enderror"
                        id="miércoles" wire:model="miercolesVentas" placeholder="Escribe la cantidad" />
                    @error('miércoles')
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/2 p-2">
                    <label for="jueves"
                        class="block text-black text-sm font-bold mb-2">Jueves(Opcional):</label>
                    <input type="number" min="0"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('jueves') border-red-500 @enderror"
                        id="jueves" wire:model="juevesVentas" placeholder="Escribe la cantidad" />
                    @error('jueves')
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/2"></div>
            </div>
            <div class="flex">
                <div class="w-1/2 p-2">
                    <label for="viernes"
                        class="block text-black text-sm font-bold mb-2">Viernes(Opcional):</label>
                    <input type="number" min="0"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('viernes') border-red-500 @enderror"
                        id="viernes" wire:model="viernesVentas" placeholder="Escribe la cantidad" />
                    @error('viernes')
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/2 p-2">
                    <label for="sábado"
                        class="block text-black text-sm font-bold mb-2">Sábado(Opcional):</label>
                    <input type="number" min="0"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('sábado') border-red-500 @enderror"
                        id="sábado" wire:model="sabadoVentas" placeholder="Escribe la cantidad" />
                    @error('sábado')
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/2"></div>
            </div>
            <div class="flex">
                <div class="w-1/2 p-2">
                    <label for="domingo"
                        class="block text-black text-sm font-bold mb-2">Domingo(Opcional):</label>
                    <input type="number" min="0"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('domingo') border-red-500 @enderror"
                        id="domingo" wire:model="domingoVentas" placeholder="Escribe la cantidad" />
                    @error('domingo')
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/2"></div>
                <div class="w-1/2"></div>
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        @if ($editEnabled == true)
        <div class="flex-auto w-full px-4 sm:px-6">
            <x-jet-secondary-button wire:click.prevent="limpiarVentaModal" type="button"
                class="inline-flex items-center w-full justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition ml-3">
                <svg wire:loading wire:target="limpiarVentaModal" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Cancelar
            </x-jet-secondary-button>
        </div>
        @endif
        <div class="flex-auto w-full px-4 sm:px-6">
            <x-jet-secondary-button wire:click.prevent="editarVenta" type="button"
                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                <svg wire:loading wire:target="editarVenta" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Editar
            </x-jet-secondary-button>
        </div>
        <div class="flex-auto w-full px-4 sm:px-6">
            @if ($editEnabled == true)
            <x-jet-secondary-button wire:click.prevent="actualizarVenta" type="button"
                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                <svg wire:loading wire:target="actualizarVenta" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4">
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
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Crear
            </x-jet-secondary-button>
            @endif
        </div>

    </x-slot>

</x-jet-dialog-modal>

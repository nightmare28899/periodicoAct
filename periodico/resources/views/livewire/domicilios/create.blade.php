<x-jet-dialog-modal wire:model="clienteModalOpen">

    <x-slot name="title">
        <div class="flex sm:px-6">
            <h1 class="mb-3 text-2xl text-black font-bold ml-3">Datos del Domicilio</h1>
            <button type="button" wire:click="$set('clienteModalOpen', false)" wire:loading.attr="disabled"
                class="mb-3 text-gray-400 bg-transparent hover:bg-red-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-red-600 dark:hover:text-white"
                data-modal-toggle="defaultModal">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
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
                <div class="w-1/2 p-2">
                    <label for="exampleFormControlInput2"
                        class="block text-black text-sm font-bold mb-2">Calle:</label>
                    <input type="text"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        id="calle" wire:model.defer="calle" placeholder="Escribe tu Calle" />
                    @error('calle')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/2 p-2">
                    <label for="exampleFormControlInput2"
                        class="block text-black text-sm font-bold mb-2">No
                        Int.(Opcional):</label>
                    <input type="number"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        id="noint" wire:model.defer="noint" placeholder="Escribe tu No.Int" />
                    @error('noint')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex">
                <div class="w-1/2 p-2">
                    <label for="exampleFormControlInput2"
                        class="block text-black text-sm font-bold mb-2">No.
                        Ext.:</label>
                    <input type="number"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        id="noext" wire:model.defer="noext" placeholder="Escribe tu No. Ext" />
                    @error('noext')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/2 p-2">
                    <label for="exampleFormControlInput2"
                        class="block text-black text-sm font-bold mb-2">Colonia:</label>
                    <input type="text"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        id="colonia" wire:model.defer="colonia" placeholder="Escribe tu Colonia" />
                    @error('colonia')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex">
                <div class="w-1/2 p-2">
                    <label for="exampleFormControlInput2"
                        class="block text-black text-sm font-bold mb-2">Código
                        Postal:</label>
                    <input type="number"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        id="cp" wire:model.defer="cp" placeholder="Escribe tu Código Postal" />
                    @error('cp')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/2 p-2">
                    <label for="exampleFormControlInput2"
                        class="block text-black text-sm font-bold mb-2">Localidad:</label>
                    <input type="text"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        id="localidad" wire:model.defer="localidad"
                        placeholder="Escribe tu Localidad" />
                    @error('localidad')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex">
                <div class="w-1/2 p-2">
                    <label for="exampleFormControlInput2"
                        class="block text-black text-sm font-bold mb-2">Municipio:</label>
                    <input type="text"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        id="municipio" wire:model.defer="municipio"
                        placeholder="Escribe tu Municipio" />
                    @error('municipio')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/2 p-2">
                    <label for="exampleFormControlInput1"
                        class="block text-black text-sm font-bold mb-2">Ruta</label>
                    <select
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        wire:model.defer="ruta_id" id="ruta" style="width: 100%">
                        <option value=''>Escoge una opción</option>
                        @foreach ($rutas as $id => $ruta)
                            <option value={{ $id }}>
                                {{ $ruta }}
                            </option>
                        @endforeach
                    </select>
                    @error('clasificacion')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex">
                <div class="w-1/2 p-2">
                    <label for="exampleFormControlInput1"
                        class="block text-black text-sm font-bold mb-2">Tarifa</label>
                    <select
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        wire:model.defer="tarifa_id" style="width: 100%">
                        <option value=''>Escoge una opción</option>
                        @foreach ($tarifas as $tarifa)
                            <option value={{ $tarifa }}>
                                {{ $tarifa }}
                            </option>
                        @endforeach
                    </select>
                    @error('clasificacion')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/2 p-2">
                    <label for="exampleFormControlInput2"
                        class="block text-black text-sm font-bold mb-2">Referencia:</label>
                    <textarea type="text" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        rows="3" cols="50" id="referencia" wire:model.defer="referencia"
                        placeholder="Escribe tu Referencia"> </textarea>
                    @error('referencia')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">
        <div class="flex flex-row justify-end px-6 bg-gray-100 text-right">
            <x-jet-secondary-button
                class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition ml-3"
                wire:click="$set('clienteModalOpen', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
        </div>

        <div class="flex flex-row justify-end px-6 bg-gray-100 text-right">
            <button wire:click.prevent="create()" type="button"
                class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-bold text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                Anterior
            </button>
        </div>

        <div class="flex flex-row justify-end px-6 bg-gray-100 text-right">
            <button wire:click.prevent="openEjemplarModal()" type="button"
                class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-bold text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                Siguiente
            </button>
        </div>

    </x-slot>

</x-jet-dialog-modal> 
<x-jet-dialog-modal wire:model="modalFormDom" maxWidth="5xl">

    <x-slot name="title">
        <div class="flex sm:px-6">
            <h1 class="mb-3 text-2xl text-black font-bold ml-3">Crear Domicilio</h1>
            <button type="button" wire:click="$set('modalFormDom', false)" wire:loading.attr="disabled"
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
        <div class="flex">
            <div class="w-1/2 p-2">
                <label for="calle" class="block text-black text-sm font-bold mb-2">Calle:</label>
                <input type="text"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('calle') border-red-500 @enderror"
                    id="calle" wire:model.defer="calle" placeholder="Escribe tu calle" />
                @error('calle')
                    <span
                        class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                @enderror
            </div>
            <div class="w-1/2 p-2">
                <label for="noint" class="block text-black text-sm font-bold mb-2">No. Int.:</label>
                <input type="number" min="0"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('noint') border-red-500 @enderror"
                    id="noint" wire:model.defer="noint" placeholder="Escribe tu Colonia" min="0" />
                @error('noint')
                    <span
                        class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex">
            <div class="w-1/2 p-2">
                <label for="noext" class="block text-black text-sm font-bold mb-2">No. Ext.:</label>
                <input type="number" min="0"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('noext') border-red-500 @enderror"
                    id="noext" wire:model.defer="noext" placeholder="Escribe tu Colonia" />
                @error('noext')
                    <span
                        class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                @enderror
            </div>
            <div class="w-1/2 p-2">
                <label for="colonia" class="block text-black text-sm font-bold mb-2">Colonia:</label>
                <input type="text"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('colonia') border-red-500 @enderror"
                    id="colonia" wire:model.defer="colonia" placeholder="Escribe tu Colonia" />
                @error('colonia')
                    <span
                        class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex">
            <div class="w-1/2 p-2">
                <label for="cp" class="block text-black text-sm font-bold mb-2">C.P.:</label>
                <input type="number" min="0"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('cp') border-red-500 @enderror"
                    id="cp" wire:model.defer="cp" placeholder="Escribe tu Colonia" />
                @error('cp')
                    <span
                        class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                @enderror
            </div>
            <div class="w-1/2 p-2">
                <label for="localidad" class="block text-black text-sm font-bold mb-2">Localidad:</label>
                <input type="text"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('localidad') border-red-500 @enderror"
                    id="localidad" wire:model.defer="localidad" placeholder="Escribe tu Colonia" />
                @error('localidad')
                    <span
                        class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex">
            <div class="w-1/2 p-2">
                <label for="municipio" class="block text-black text-sm font-bold mb-2">Municipio:</label>
                <input type="text"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('municipio') border-red-500 @enderror"
                    id="municipio" wire:model.defer="municipio" placeholder="Escribe tu Colonia" />
                @error('municipio')
                    <span
                        class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                @enderror
            </div>
            <div class="w-1/2 p-2">
                <label for="ejemplar" class="block text-black text-sm font-bold mb-2">Ejemplar:</label>
                <input type="number" min="0"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('ejemplar') border-red-500 @enderror"
                    id="ejemplar" wire:model.defer="ejemplar" placeholder="Escribe tu Colonia" />
                @error('ejemplar')
                    <span
                        class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="flex">
            <div class="w-1/2 p-2">
                <label for="cp" class="block text-black text-sm font-bold mb-2">Referencia:</label>
                <input type="text"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('referencia') border-red-500 @enderror"
                    id="referencia" wire:model.defer="referencia" placeholder="Escribe tu Colonia" />
                @error('referencia')
                    <span
                        class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                @enderror
            </div>
            <div class="w-1/2 p-2">
                <label for="localidad" class="block text-black text-sm font-bold mb-2">Localidad:</label>
                <input type="number" min="0"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('localidad') border-red-500 @enderror"
                    id="localidad" wire:model.defer="localidad" placeholder="Escribe tu Colonia" />
                @error('localidad')
                    <span
                        class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                @enderror
            </div>
        </div>

    </x-slot>

    <x-slot name="footer">
        <div class="flex-auto w-64 px-4 sm:px-6">
            {{-- <button wire:click.prevent="openModalAnterior()" type="button"
                class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-bold text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                Anterior
            </button> --}}
        </div>

        <div class="flex-auto w-64 px-4 sm:px-6">
            <button wire:click.prevent="store" type="button"
                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                <svg wire:loading wire:target="store" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Crear
            </button>
        </div>
    </x-slot>

</x-jet-dialog-modal>

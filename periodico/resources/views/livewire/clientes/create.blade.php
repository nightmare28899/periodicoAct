<x-jet-dialog-modal wire:model="isModalOpen">

    <x-slot name="title">
        <div class="flex sm:px-6">
            <h1 class="mb-3 text-2xl text-black font-bold ml-3">Datos del Cliente</h1>
            <button type="button" wire:click="$set('isModalOpen', false)" wire:loading.attr="disabled"
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
        <div class="px-4 mb-4" flex-grow>
            <div class="flex">
                <div class="w-1/2 p-2">
                    <label for="exampleFormControlInput1"
                        class="block text-black text-sm font-bold mb-2">Clasificación</label>
                    <select
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        wire:model.defer="clasificacion" style="width: 100%">
                        <option value=''>Escoge una opción</option>
                        @foreach ($data as $datas)
                            <option value={{ $datas }}>
                                {{ $datas }}
                            </option>
                        @endforeach
                    </select>
                    @error('clasificacion')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/2 p-2">
                    <label class="text-black font-bold text-sm">RFC</label><br>
                    <div class="form-group">
                        <input wire:model="rfc" name="rfc" type="radio" id="Física" value="Física" checked>
                        @error('rfc')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                        <label class="text-black" for="Física">Física</label>
                    </div>
                    <div class="form-group">
                        <input wire:model="rfc" name="rfc" type="radio" id="Moral" value="Moral"
                            {{ $rfc == 'Moral' ? 'checked' : '' }}>
                        @error('rfc')
                            <span class="error text-danger">{{ $message }}</span>
                        @enderror
                        <label class="text-black" for="Moral">Moral</label>
                    </div>
                </div>
            </div>
            <div class="flex">
                <div class="w-1/2 p-2" id="RFCF">
                    @if ($rfc == 'Física')
                        <label for='Física' class='block text-gray-700 text-sm font-bold mb-2'>Escribe tu
                            RFC:</label>
                        <input type='text' name='rfc_input'
                            class='border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5'
                            maxlength='13' placeholder='Escribe tu RFC (son 13 digitos)'
                            wire:model.defer='rfc_input'>
                        @error('rfc_input')
                            <span class='text-red-500'>{{ $message }}</span>
                        @enderror
                    @else
                        <label for='Moral' class='block text-gray-700 text-sm font-bold mb-2'>Escribe tu
                            RFC:</label>
                        <input type='text' name='rfc_input'
                            class='border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5'
                            maxlength='12' placeholder='Escribe tu RFC (son 12 digitos)'
                            wire:model.defer='rfc_input'>
                        @error('rfc_input')
                            <span class='text-red-500'>{{ $message }}</span>
                        @enderror
                    @endif
                </div>
                <div class="w-1/2 p-2">
                    <label for="exampleFormControlInput2"
                        class="block text-black text-sm font-bold mb-2">Nombre:</label>
                    <input type="text"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        id="nombre" wire:model.defer="nombre" placeholder="Escribe tu Nombre" />
                    @error('nombre')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex">
                <div class="w-1/2 p-2">
                    <label for="exampleFormControlInput2"
                        class="block text-black text-sm font-bold mb-2">Estado:</label>
                    <input type="text"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        id="estado" wire:model.defer="estado" placeholder="Escribe tu Estado" />
                    @error('estado')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/2 p-2">
                    <label for="exampleFormControlInput2"
                        class="block text-black text-sm font-bold mb-2">País:</label>
                    <input type="text"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        id="pais" wire:model.defer="pais" placeholder="Escribe tu País" />
                    @error('pais')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex">
                <div class="w-1/2 p-2">
                    <label for="exampleFormControlInput2"
                        class="block text-black text-sm font-bold mb-2">E-mail:</label>
                    <input type="email"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        id="email" wire:model.defer="email" placeholder="Escribe tu Correo" />
                    @error('email')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/2 p-2">
                    <label for="exampleFormControlInput2" class="block text-black text-sm font-bold mb-2">E-mail
                        de Cobranza:</label>
                    <input type="email"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        id="email_cobranza" wire:model.defer="email_cobranza" placeholder="Escribe tu Correo" />
                    @error('email_cobranza')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex">
                <div class="w-1/2 p-2">
                    <label for="exampleFormControlInput2"
                        class="block text-black text-sm font-bold mb-2">Teléfono:</label>
                    <input type="number"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        id="telefono" wire:model.defer="telefono" placeholder="Escribe tu Teléfono" />
                    @error('telefono')
                        <span class="text-red-500">{{ $message }}</span>
                    @enderror
                </div>
                <div class="w-1/2 p-2">
                    <label for="exampleFormControlInput2"
                        class="block text-black text-sm font-bold mb-2">Régimen
                        Fiscal:</label>
                    <input type="text"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        id="regimen_fiscal" wire:model.defer="regimen_fiscal"
                        placeholder="Escribe tu Régimen Fiscal" />
                    @error('regimen_fiscal')
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
                wire:click="$set('isModalOpen', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
        </div>

        <div class="px-4 sm:px-6 sm:flex sm:flex-row-reverse">
            <button wire:click.prevent="openClientModal()" type="button"
                class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-bold text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                Siguiente
            </button>
        </div>

    </x-slot>

</x-jet-dialog-modal>
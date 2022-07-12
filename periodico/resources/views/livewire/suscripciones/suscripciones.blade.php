<x-jet-dialog-modal wire:model="suscripciones" maxWidth="6xl">

    <x-slot name="title">
        <div class="flex sm:px-6">
            <h1 class="mb-3 text-2xl text-black font-bold ml-3">Suscripciones</h1>
            <button type="button" wire:click="$set('suscripciones', false)" wire:loading.attr="disabled"
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
        <div class="px-4 mb-4" flex-grow>
            <div class="flex">
                <div class="w-1/2 px-2">
                    <p class="font-bold">La suscripción es para el cliente</p>
                </div>
                <div class="w-1/2">
                    <p class="font-bold">Fecha: <input type="text" style="height: 1.7rem;" value="{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}" class="border-0" disabled></p>
                </div>
            </div>
            <div class="flex">
                <div class="w-1/2 p-2">
                    <select
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('clasificacion') border-red-500 @enderror"
                        wire:model.defer="clienteSeleccionado" style="width: 100%">
                        <option value=''>Selecciona un cliente</option>
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-1/2 p-2">
                    <input type="checkbox" name="" id=""> Aplicar oferta
                </div>
            </div>
            <div class="flex">
                <div class="w-1/2 px-2">
                    <p>Suscripción:</p>
                    <p class="font-bold"><input type="radio"> Normal</p>
                </div>
                <div class="w-1/2">
                    <br>
                    <p class="font-bold"><input type="radio"> Semanal</p> 
                </div>
                <div class="border-l-4 border-black ... px-2"></div>
                <div class="w-1/2">
                    <p>La suscripción es una:</p>
                    <p class="font-bold"><input type="radio"> Apertura</p> 
                </div>
                <div class="w-1/2">
                    <br>
                    <p class="font-bold"><input type="radio"> Renovación</p> 
                </div>
                <div class="w-1/2">
                    <br>
                    <p class="font-bold"><input type="radio"> Reactviación</p> 
                </div>
            </div>
            <div class="flex mt-2">
                <div class="w-1/2 px-2">
                    <p class="font-bold">FACTURAR A:</p>
                    <b>Clave: <input type="text" style="height: 1.7rem;" class="border-0" disabled></b>
                </div>
                <div class="w-1/2 px-2">
                    <br>
                    <b>R.F.C.: <input type="text" style="height: 1.7rem;" class="border-0" disabled></b>
                </div>
                <div class="w-1/2 px-2">
                    <br>
                    <b>Nombre: <input type="text" style="height: 1.7rem;" class="border-0" disabled></b>
                </div>
            </div>
            <div class="flex">
                <div class="w-1/2 px-2">
                    <b>Calle: <input type="text" style="height: 1.7rem;" class="border-0" disabled></b>
                </div>
                <div class="w-1/2 px-2">
                    <b>No. Int: <input type="text" style="height: 1.7rem;" class="border-0" disabled></b>
                </div>
                <div class="w-1/2 px-2">
                    <b>No. Ext.: <input type="text" style="height: 1.7rem;" class="border-0" disabled></b>
                </div>
            </div>
            <div class="flex">
                <div class="w-1/2 px-2">
                    <b>Colonia: <input type="text" style="height: 1.7rem;" class="border-0" disabled></b>
                </div>
                <div class="w-1/2 px-2">
                    <b>C.P.: <input type="text" style="height: 1.7rem;" class="border-0" disabled></b>
                </div>
            </div>
            <div class="flex">
                <div class="w-1/2 px-2">
                    <b>Localidad: <input type="text" style="height: 1.7rem;" class="border-0" disabled></b>
                </div>
                <div class="w-1/2 px-2">
                    <b>Municipio: <input type="text" style="height: 1.7rem;" class="border-0" disabled></b>
                </div>
            </div>
            <div class="flex">
                <div class="w-1/2 px-2">
                    <b>Estado: <input type="text" style="height: 1.7rem;" class="border-0" disabled></b>
                </div>
                <div class="w-1/2 px-2">
                    <b>País: <input type="text" style="height: 1.7rem;" class="border-0" disabled></b>
                </div>
            </div>
            <div class="flex">
                <div class="w-1/2 px-2">
                    <b>E-mail: <input type="text" style="height: 1.7rem;" class="border-0" disabled></b>
                </div>
                <div class="w-1/2 px-2">
                    <b>C.P.: <input type="text" style="height: 1.7rem;" class="border-0" disabled></b>
                </div>
            </div>
        </div>
    </x-slot>

    <x-slot name="footer">

    </x-slot>

</x-jet-dialog-modal>

<x-jet-dialog-modal wire:model="detallesModalOpen">

    <x-slot name="title">
        <div class="flex sm:px-6">
            <h1 class="mb-3 text-2xl text-black font-bold ml-3">Datos del Cliente</h1>
            <button type="button" wire:click="$set('detallesModalOpen', false)" wire:loading.attr="disabled"
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
        <a class="container max-w-sm rounded-lg shadow-md dark:bg-gray-800">
            <h5 class="mb-2 text-2xl tracking-tight text-gray-900 dark:text-black text-center"><b>Cliente:</b>
                {{ $nombre }}</h5>
            <div class="flex p-6">
                <div>
                    <p class="font-normal text-gray-600 text-lg">Datos del Domicilio:</p>
                    <p class="font-normal text-gray-500">
                        <b>Calle:</b> {{ $calle }} <br>
                        <b>No. Interior:</b> {{ $noint }} <br>
                        <b>No. Exterior:</b> {{ $noext }} <br>
                        <b>Colonia:</b> {{ $colonia }} <br>
                        <b>Código Postal:</b> {{ $cp }} <br>
                        <b>Estado:</b> {{ $estado }} <br>
                        <b>País:</b> {{ $pais }} <br>
                        <b>Referencia:</b> {{ $referencia }} <br>
                        <b>Teléfono:</b> {{ $telefono }} <br>
                        <b>Correo Electrónico:</b> {{ $email }} <br>
                        <b>Correo Electrónico Cobranza:</b> {{ $email_cobranza }} <br>
                    </p>
                </div>

                <div>
                    <p class="font-normal text-gray-600 text-lg">Cantidad de Ejemplares:</p>
                    <p class="font-normal text-gray-500">
                        <b>Lunes:</b> {{ $lunes }} <br>
                        <b>Martes:</b> {{ $martes }} <br>
                        <b>Miércoles:</b> {{ $miércoles }} <br>
                        <b>Jueves:</b> {{ $jueves }} <br>
                        <b>Viernes:</b> {{ $viernes }} <br>
                        <b>Sábado:</b> {{ $sábado }} <br>
                        <b>Domingo:</b> {{ $domingo }} <br>
                    </p>
                </div>
            </div>
        </a>
    </x-slot>

    <x-slot name="footer">
        {{-- <div class="flex-auto w-64 px-4 sm:px-6">
            <x-jet-secondary-button
                class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition ml-3 w-full"
                wire:click="$set('detallesModalOpen', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>
        </div> --}}
    </x-slot>

</x-jet-dialog-modal>
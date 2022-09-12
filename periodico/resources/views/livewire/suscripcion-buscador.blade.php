<x-jet-dialog-modal wire:model="suscripcion" maxWidth="4xl">
    <x-slot name="title">
        <div class="flex sm:px-6">
            <h1 class="mb-3 text-2xl text-black font-bold ml-3">Crear Suscripción</h1>
            <button type="button" wire:click="returnClienteView" wire:loading.attr="disabled"
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
        <style>
            .highlight {
                background-color: #89caf5;
            }
        </style>
        {{-- The best athlete wants his opponent at his best. --}}
        <div class="">
            <input type="text"
                class=" text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full"
                name="search" id="search" placeholder="Buscar Cliente" wire:model="query"
                wire:keydown.escape="resetear" wire:keydown.tab="resetear"
                wire:keydown.arrow-up="decrementHighlight" wire:keydown.arrow-down="incrementHighlight"
                wire:keydown.enter="selectContact" />
        </div>

        {{-- <div wire:loading class="list-group bg-white w-full rounded-t-none shadow-lg">
                    <div class="list-item list-none p-2">Buscando...</div>
                </div> --}}

        @if (!empty($query))

            <div class="fixed top-0 right-0 bottom-0 left-0" wire:click="resetear"></div>

            <div class="absolute z-10 list-group bg-white w-full rounded-t-none shadow-lg">

                @if (!empty($clientesBuscados))

                    @foreach ($clientesBuscados as $i => $buscado)
                        <div wire:model.defer="clienteSeleccionado"
                            class="list-item list-none p-2
                                    {{ $highlightIndex === $i ? 'highlight' : '' }}">
                            {{ $buscado['razon_social'] }}</div>
                    @endforeach
                @else
                    <div class="list-item list-none p-2">No hay resultado</div>
                @endif
            </div>

        @endif


    </x-slot>

    <x-slot name="footer">
        <div class="mt-5 pt-4">
            <button wire:click.prevent="suscripciones"
                class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-md">
                <svg wire:loading wire:target="suscripciones"
                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10"
                        stroke="currentColor" stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Guardar contrato
            </button>
            {{-- <button
                class="px-4 py-2 text-white bg-green-500 hover:bg-green-600 rounded-md">Nuevo</button> --}}
            <button class="px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded-md"
                wire:click.prevent="borrar()">Borrar</button>
            {{-- <button class="px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded-md">Salir</button> --}}
        </div>
    </x-slot>

</x-jet-dialog-modal>

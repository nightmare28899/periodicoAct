<x-jet-dialog-modal wire:model="modalDomSubs" maxWidth="5xl">
    <x-slot name="title">
        <div class="flex sm:px-6">
            <h1 class="mb-3 text-2xl text-black font-bold ml-3">Listado de Domicilios</h1>
            <button type="button" wire:click="$set('modalDomSubs', false)" wire:loading.attr="disabled"
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
        <div class="flex justify-between">
            <div>

            </div>
            <div>
                <button class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-md"
                    wire:click="modalCrearDom">Agregar</button>
            </div>
        </div>
        <p class="text-center font-bold text-xl">No hay domicilios registrados</p>

    </x-slot>
    <x-slot name="footer">

    </x-slot>
    </x-jet-dialog-mod>

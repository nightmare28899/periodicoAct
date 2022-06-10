<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <br>
        <br>
        <br>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
                @csrf
                <div class="pt-5 pb-4 sm:pb-4">
                    <div class="flex sm:px-6">
                        <h1 class="mb-3 text-2xl text-black font-bold ml-3">Datos de Tarifa</h1>
                        <button type="button" wire:click="closeModalPopover()"
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
                    <hr class="mb-2 w-full" />
                    <div class="container mx-auto align-middle">
                        <div class="px-4 mb-4" flex-grow>
                            <div class="flex">
                                <div class="w-1/2 p-2">
                                    <label for="exampleFormControlInput2"
                                        class="block text-black text-sm font-bold mb-2">Tipo:</label>
                                    <input type="text"
                                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        id="tipo" wire:model="tipo" placeholder="Escribe el tipo" />
                                    @error('tipo')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-1/2 p-2">
                                    <label for="exampleFormControlInput2"
                                        class="block text-black text-sm font-bold mb-2">Ordinario:</label>
                                    <input type="number"
                                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        id="ordinario" wire:model="ordinario" placeholder="Ordinario" />
                                    @error('ordinario')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-1/2 p-2">
                                    <div class="mb-4">
                                        <label for="exampleFormControlInput2"
                                            class="block text-black text-sm font-bold mb-2">Dominical:</label>
                                        <input type="number"
                                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                            id="dominical" wire:model="dominical" placeholder="Dominical" />
                                        @error('dominical')
                                            <span class="text-red-500">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mb-2" />
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="basis-1/4">
                        <button wire:click.prevent="store()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            <svg wire:loading wire:target="store" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Guardar
                        </button>
                    </span>
                    <span class="basis-1/2"></span>
                    <span class="basis-1/4">
                        <button wire:click="closeModalPopover()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-red-600 hover:bg-red-700 ext-base leading-6 font-bold text-white shadow-sm focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Cancelar
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>

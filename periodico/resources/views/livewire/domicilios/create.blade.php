<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <br>
        <br>
        <br>
        <div class="inline-block align-bottom bg-white dark:bg-gray-700 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
                @csrf
                <div class="dark:bg-gray-700 pt-5 pb-4 sm:pb-4">
                    <div class="flex sm:px-6">
                        <h1 class="mb-3 ml-2 text-2xl text-white font-bold">Datos del Domicilio</h1>
                        <button type="button" wire:click="closeModalPopover()"
                            class="mb-3 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
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
                    <div class="container md:flex">
                        <div class="px-4 mb-6" flex-grow>
                            <div class="flex">
                                <div class="w-1/2 p-2">
                                    <label for="exampleFormControlInput2"
                                        class="block text-gray-300 text-sm font-bold mb-2">Calle:</label>
                                    <input type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        id="calle" wire:model.defer="calle" placeholder="Escribe tu Calle" />
                                    @error('calle')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-1/2 p-2">
                                    <label for="exampleFormControlInput2"
                                        class="block text-gray-300 text-sm font-bold mb-2">No
                                        Int.(Opcional):</label>
                                    <input type="number"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        id="noint" wire:model.defer="noint" placeholder="Escribe tu No.Int" />
                                    @error('noint')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-1/2 p-2">
                                    <label for="exampleFormControlInput2"
                                        class="block text-gray-300 text-sm font-bold mb-2">No.
                                        Ext.:</label>
                                    <input type="number"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        id="noext" wire:model.defer="noext" placeholder="Escribe tu No. Ext" />
                                    @error('noext')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-1/2 p-2">
                                    <label for="exampleFormControlInput2"
                                        class="block text-gray-300 text-sm font-bold mb-2">Colonia:</label>
                                    <input type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        id="colonia" wire:model.defer="colonia" placeholder="Escribe tu Colonia" />
                                    @error('colonia')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-1/2 p-2">
                                    <label for="exampleFormControlInput2"
                                        class="block text-gray-300 text-sm font-bold mb-2">Código
                                        Postal:</label>
                                    <input type="number"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        id="cp" wire:model.defer="cp" placeholder="Escribe tu Código Postal" />
                                    @error('cp')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-1/2 p-2">
                                    <label for="exampleFormControlInput2"
                                        class="block text-gray-300 text-sm font-bold mb-2">Localidad:</label>
                                    <input type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
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
                                        class="block text-gray-300 text-sm font-bold mb-2">Municipio:</label>
                                    <input type="text"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        id="municipio" wire:model.defer="municipio"
                                        placeholder="Escribe tu Municipio" />
                                    @error('municipio')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-1/2 p-2">
                                    <label for="exampleFormControlInput1"
                                        class="block text-gray-300 text-sm font-bold mb-2">Ruta</label>
                                    <select
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
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
                                        class="block text-gray-300 text-sm font-bold mb-2">Tarifa</label>
                                    <select
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
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
                                        class="block text-gray-300 text-sm font-bold mb-2">Referencia:</label>
                                    <textarea type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"
                                        rows="3" cols="50" id="referencia" wire:model.defer="referencia"
                                        placeholder="Escribe tu Referencia"> </textarea>
                                    @error('referencia')
                                        <span class="text-red-500">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mb-2" />
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse dark:bg-gray-700">
                    <span class="basis-1/4">
                        <button wire:click.prevent="openEjemplarModal()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-bold text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Siguiente
                        </button>
                    </span>
                    <span class="basis-1/4 mr-2">
                        <button wire:click.prevent="create()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-bold text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Anterior
                        </button>
                    </span>
                    <span class="basis-1/3"></span>
                    <span class="basis-1/4">
                        <button wire:click="closeModalPopover()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-red-600 hover:bg-red-700 text-base leading-6 font-bold text-white shadow-sm focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Cancelar
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>
</div>

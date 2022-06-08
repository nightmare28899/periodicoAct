<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <br>
        <br>
        <br>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
                @csrf
                <div class="pt-5 pb-4 sm:pb-4">
                    <div class="flex sm:px-6">
                        <h1 class="mb-3 text-2xl text-black font-bold ml-3">Datos del Cliente</h1>
                        <button type="button" wire:click="closeModalPopover()"
                            class="mb-3 text-gray-400 bg-transparent hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-red-600 dark:hover:text-white"
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
                                        <input wire:model="rfc" name="rfc" type="radio" id="Física"
                                            value="Física" checked>
                                        @error('rfc')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                        <label class="text-black" for="Física">Física</label>
                                    </div>
                                    <div class="form-group">
                                        <input wire:model="rfc" name="rfc" type="radio" id="Moral"
                                            value="Moral" {{ $rfc == 'Moral' ? 'checked' : '' }}>
                                        @error('rfc')
                                            <span class="error text-danger">{{ $message }}</span>
                                        @enderror
                                        <label class="text-black" for="Moral">Moral</label>
                                    </div>
                                </div>
                            </div>
                            <div class="flex">
                                <div class="w-1/2 p-2" id="RFCF">
                                    @if($rfc == "Física")
                                        <label for='Física' class='block text-gray-700 text-sm font-bold mb-2'>Escribe tu RFC:</label> 
                                        <input type='text' name='rfc_input' class='border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5' maxlength='13' placeholder='Escribe tu RFC (son 13 digitos)' wire:model.defer='rfc_input'> 
                                        @error('rfc_input') 
                                            <span class='text-red-500'>{{ $message }}</span> 
                                        @enderror
                                    @else
                                        <label for='Moral' class='block text-gray-700 text-sm font-bold mb-2'>Escribe tu RFC:</label> 
                                        <input type='text' name='rfc_input' class='border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5' maxlength='12' placeholder='Escribe tu RFC (son 12 digitos)' wire:model.defer='rfc_input'> 
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
                                    <label for="exampleFormControlInput2"
                                        class="block text-black text-sm font-bold mb-2">E-mail
                                        de Cobranza:</label>
                                    <input type="email"
                                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        id="email_cobranza" wire:model.defer="email_cobranza"
                                        placeholder="Escribe tu Correo" />
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
                    </div>
                </div>
                <hr class="mb-2" />
                <div class="px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse bg-white">
                    <span class="basis-1/4">
                        <button wire:click.prevent="openClientModal()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-bold text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Siguiente
                        </button>
                    </span>
                    <span class="basis-1/2"></span>
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
    {{-- <script>
        document.getElementById('Física').addEventListener('click', function(e) {
            const status = document.getElementById('Física').checked;
            console.log(status);
            const value = document.getElementById('Física').value;
            console.log(value + ' ' + status);
            if (status == true && value == 'Física') {
                console.log('Física');
                const input = document.getElementById("RFCF").innerHTML =
                    "<label for='Física' class='block text-gray-700 text-sm font-bold mb-2'>Escribe tu RFC:</label> <input type='text' name='rfc_input' id='rfc_input' class='border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5' maxlength='13' placeholder='Escribe tu RFC (son 13 digitos)' wire:model.defer='rfc_input'> @error('rfc_input') <span class='text-red-500'>{{ $message }}</span> @enderror";
                document.getElementById("RFCF").innerHTML = input;
            }

        });
        document.getElementById('Moral').addEventListener('click', function(e) {
            const status = document.getElementById('Moral').checked;
            console.log(status);
            const value = document.getElementById('Moral').value;
            console.log(value + ' ' + status);
            if (status == true && value == 'Moral') {
                console.log('Moral');
                const input = document.getElementById("RFCF").innerHTML =
                    "<label for='Moral' class='block text-gray-700 text-sm font-bold mb-2'>Escribe tu RFC:</label> <input type='text' name='rfc_input' id='rfc_input' class='border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5' maxlength='12' placeholder='Escribe tu RFC (son 12 digitos)'>";
                document.getElementById("RFCF").innerHTML = input;
            }
        });
    </script> --}}
</div>

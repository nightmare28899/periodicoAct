<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <form>
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <h1 class="mb-3 text-2xl text-black font-bold">Datos del Cliente</h1>
                    <div class="mb-4">
                        <label for="exampleFormControlInput1"
                            class="block text-gray-700 text-sm font-bold mb-2">Clasificación</label>
                        {{-- <select type="select"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="clasificacion" placeholder="Clasificación" wire:model.defer="clasificacion"> --}}
                        <select
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
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
                    <div class="mb-4">
                        {{-- <label for="exampleFormControlInput2"
                                class="block text-gray-700 text-sm font-bold mb-2">RFC:</label>
                            <input type="text"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="rfc" wire:model.defer="rfc" placeholder="rfc" />
                            @error('rfc')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror --}}

                        <label>RFC</label><br>
                        <div class="form-group">
                            <input wire:model.defer="rfc" name="rfc" type="radio" id="Física" value="Física" />
                            @error('rfc')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                            <label for="Física">Física</label>
                        </div>
                        <div class="form-group">
                            <input wire:model.defer="rfc" name="rfc" type="radio" id="Moral" value="Moral" />
                            @error('rfc')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror
                            <label for="Moral">Moral</label>
                        </div>


                    </div>
                    <div class="mb-4" id="RFCF">
                        {{-- <label for="exampleFormControlInput2"
                                class="block text-gray-700 text-sm font-bold mb-2">Escribe tu RFC:</label>
                            <input type="text"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="rfc_input" wire:model.defer="rfc_input" placeholder="Escribe tu RFC" />
                            @error('rfc_input')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror --}}
                        <label for='Física' class='block text-gray-700 text-sm font-bold mb-2'>Escribe tu RFC:</label>
                        <input type='text' name='rfc_input' id='rfc_input'
                            class='shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline'
                            maxlength='13' placeholder='Escribe tu RFC (son 13 digitos)' wire:model.defer='rfc_input'>
                        @error('rfc_input')
                            <span class='text-red-500'>{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="exampleFormControlInput2"
                            class="block text-gray-700 text-sm font-bold mb-2">Nombre:</label>
                        <input type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="nombre" wire:model.defer="nombre" placeholder="Escribe tu Nombre" />
                        @error('nombre')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="exampleFormControlInput2"
                            class="block text-gray-700 text-sm font-bold mb-2">Estado:</label>
                        <input type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="estado" wire:model.defer="estado" placeholder="Escribe tu Estado" />
                        @error('estado')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="exampleFormControlInput2"
                            class="block text-gray-700 text-sm font-bold mb-2">Pais:</label>
                        <input type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="pais" wire:model.defer="pais" placeholder="Escribe tu Pais" />
                        @error('pais')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="exampleFormControlInput2"
                            class="block text-gray-700 text-sm font-bold mb-2">E-mail:</label>
                        <input type="email"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="email" wire:model.defer="email" placeholder="Escribe tu Correo" />
                        @error('email')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">E-mail
                            de Cobranza:</label>
                        <input type="email"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="email_cobranza" wire:model.defer="email_cobranza" placeholder="Escribe tu Correo" />
                        @error('email_cobranza')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="exampleFormControlInput2"
                            class="block text-gray-700 text-sm font-bold mb-2">Telefono:</label>
                        <input type="number"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="telefono" wire:model.defer="telefono" placeholder="Escribe tu Telefono" />
                        @error('telefono')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="exampleFormControlInput2" class="block text-gray-700 text-sm font-bold mb-2">Regimen
                            Fiscal:</label>
                        <input type="text"
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="regimen_fiscal" wire:model.defer="regimen_fiscal"
                            placeholder="Escribe tu Regimen Fiscal" />
                        @error('regimen_fiscal')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    {{-- <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button wire:click.prevent="store()" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-red-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Guardar
                        </button>
                    </span> --}}
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
            const value = document.getElementById('Física').value;
            console.log(value + ' ' + status);
            if (status == true && value == 'Física') {
                console.log('Física');
                const input = document.getElementById("RFCF").innerHTML =
                    "<label for='Física' class='block text-gray-700 text-sm font-bold mb-2'>Escribe tu RFC:</label> <input type='text' name='rfc_input' id='rfc_input' class='shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline' maxlength='13' placeholder='Escribe tu RFC (son 13 digitos)' wire:model.defer='rfc_input'> @error('rfc_input') <span class='text-red-500'>{{ $message }}</span> @enderror";
                document.getElementById("RFCF").innerHTML = input;
            }

        });
        document.getElementById('Moral').addEventListener('click', function(e) {
            const status = document.getElementById('Moral').checked;
            const value = document.getElementById('Moral').value;
            console.log(value + ' ' + status);
            if (status == true && value == 'Moral') {
                console.log('Moral');
                const input = document.getElementById("RFCF").innerHTML =
                    "<label for='Moral' class='block text-gray-700 text-sm font-bold mb-2'>Escribe tu RFC:</label> <input type='text' name='rfc_input' id='rfc_input' class='shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline' maxlength='12' placeholder='Escribe tu RFC (son 12 digitos)'>";
                document.getElementById("RFCF").innerHTML = input;
            }
        });
    </script> --}}
</div>

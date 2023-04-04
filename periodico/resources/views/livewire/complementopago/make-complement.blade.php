<div class="w-2/3 mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Complemento de pago') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="mt-5 pt-5 mx-auto">
                    <p class="pt-5 text-dark">Activar cliente Génerico <input wire:model="activarCG" type="checkbox"></p>
                    <h2 class="text-center mb-5 pb-5 text-xl">Datos fiscales</h2>

                    <div class="flex mt-2 justify-center text-dark">
                        <div class=" px-2">
                            <b>RFC: <input type="text" value="{{ $client->rfc_input }}" class="border-0 bg-gray-200"
                                    disabled></b>
                        </div>
                        <div class=" px-2">
                            <b>REGIMEN FISCAL: <input type="text" value="{{ $client->regimen_fiscal }}"
                                    class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-2 justify-center text-dark">
                        <div class=" px-2">
                            <b>CODIGO POSTAL: <input type="text" value="{{ $domicilio->cp }}"
                                    class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class=" px-2">
                            <b>RAZON SOCIAL: <input type="text" value="{{ $client->razon_social }}"
                                    class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-2 justify-center text-dark">
                        <div class=" px-2">
                            <b>COLONIA: <input type="text" value="{{ $domicilio->colonia }}"
                                    class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class=" px-2">
                            <b>CALLE: <input type="text" value="{{ $domicilio->calle }}" class="border-0 bg-gray-200"
                                    disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-2 justify-center text-dark">
                        <div class=" px-2">
                            <b>ESTADO: <input type="text" value="{{ $client->estado }}" class="border-0 bg-gray-200"
                                    disabled></b>
                        </div>
                        <div class=" px-2">
                            <b>PAIS: <input type="text" value="{{ $client->pais }}" class="border-0 bg-gray-200"
                                    disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-2 justify-center text-dark">
                        <div class=" px-2">
                            <b>NO. EXTERIOR: <input type="text" value="{{ $domicilio->noext }}"
                                    class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class=" px-2">
                            <b>NO. INTERIOR: <input type="text" value="{{ $domicilio->noint }}"
                                    class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                </div>

                <br>
                <br>

                <div class="flex mt-2 justify-between px-5 border-2">
                    <h1 class="text-xl font-bold mt-5 text-dark">Datos Fiscales:</h1>
                    <button wire:click="modalEdit()"
                        class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base font-bold text-white shadow-sm hover:bg-indigo-700">
                        Agregar/Editar
                    </button>
                </div>

                <br>

                <div class="flex mt-1.5 text-dark">
                    <div class="w-32 px-2">
                        <label for="tipoFactura">Tipo Factura:</label><br>
                        <select name="tipoFactura" class="input-generic-style" id="tipoFactura"
                            wire:model="tipoFactura">
                            <option selected style="display: none">Escoge</option>
                            <option value="PUE">PUE</option>
                            <option value="PPD">PPD</option>
                        </select>
                    </div>
                    <div class="w-1/2 px-2">
                        <label for="PaymentForm">Forma de pago:</label> <br>
                        <select name="PaymentForm" id="PaymentForm" wire:model="PaymentForm"
                            class="input-generic-style">
                            <option selected style="display: none">Elegir una opción</option>
                            <option value="01">01 - Efectivo</option>
                            <option value="02">02 - Cheque nominativo</option>
                            <option value="03">03 - Transferencia electrónica de fondos</option>
                            <option value="04">04 - Tarjeta de crédito</option>
                            <option value="05">05 - Monedero electrónico</option>
                            <option value="06">06 - Dinero electrónico</option>
                            <option value="08">08 - Vales de despensa</option>
                            <option value="12">12 - Dación en pago</option>
                            <option value="13">13 - Pago por subrogación</option>
                            <option value="14">14 - Pago por consignación</option>
                            <option value="15">15 - Condonación</option>
                            <option value="17">17 - Compensación</option>
                            <option value="23">23 - Novación</option>
                            <option value="24">24 - Confusión</option>
                            <option value="25">25 - Remisión de deuda</option>
                            <option value="26">26 - Prescripción o caducidad</option>
                            <option value="27">27 - A satisfacción del acreedor</option>
                            <option value="28">28 - Tarjeta de débito</option>
                            <option value="29">29 - Tarjeta de servicios</option>
                            <option value="30">30 - Aplicación de anticipos</option>
                            <option value="31">31 - Intermediario pagos</option>
                            <option value="99">99 - Por definir</option>
                        </select>
                    </div>
                </div>

                <div class="grid justify-items-end mt-5 mr-2">

                    <label>Cantidad a pagar:</label>
                    <div class="mt-2">
                        <input type="text" class="border-0 bg-gray-200"
                            value="{{ sprintf('$ %s', number_format($invoice->total, 2)) }}" disabled>
                    </div>
                    <div class="mt-5">
                        <input type="text" class="border-0 bg-gray-200" placeholder="Coloca la cantidad a pagar"
                            wire:model="amountPay">
                    </div>
                    <div>
                        <button wire:click="complementoDePago"
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base font-bold text-white shadow-sm hover:bg-green-700">
                            <svg wire:loading wire:target="facturar" class="animate-spin -ml-1 mr-3 h-5 w-5 text-dark"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Generar Factura
                        </button>
                    </div>
                </div>

                {{-- MODAL EDITAR DOMICILIO --}}
                <x-jet-dialog-modal wire:model="modalAgregar">

                    <x-slot name="title">
                        <div class="flex justify-between">
                            <div>
                                <h1 class="text-xl font-bold text-dark ml-6">Actualizar datos fiscales</h1>
                            </div>
                            <div>
                                <button wire:click="modalAgregar = false"
                                    class="text-gray-400 hover:text-gray-500 focus:outline-none focus:text-gray-500 transition ease-in-out duration-150">
                                    <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </x-slot>

                    <x-slot name="content">
                        <div class="p-4 mb-4 bg-white overflow-hidden"
                            flex-grow>
                            <div class="flex">
                                <div class="w-1/2 p-2">
                                    <label for="rfcInput" class="label-generic-style">RFC</label>
                                    <input type='text' name='rfcInput'
                                        class='border border-gray-300 input-generic-style  text-gray-900 t input-generic-styleext-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('rfcInput') border-red-500 @enderror'
                                        placeholder='Escribe tu RFC' wire:model.defer='rfcInput'>
                                    @error('rfcInput')
                                        <span
                                            class='text-dark bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2'>{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-1/2 p-2">
                                    <label for='cpInput' class='label-generic-style'>Código
                                        Postal:</label>
                                    <input type='number' name='cpInput'
                                        class='border border-gray-300 input-generic-style  text-gray-900 te input-generic-stylext-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('cpInput') border-red-500 @enderror'
                                        placeholder='Escribe tu Código Postal' wire:model.defer='cpInput'>
                                    @error('cpInput')
                                        <span
                                            class='text-dark bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2'>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="flex">
                                <div class="w-1/2 p-2">
                                    <label for='colInput' class='label-generic-style'>Colonia:</label>
                                    <input type='text' name='colInput'
                                        class='border border-gray-300 input-generic-style  text-gray-900 t input-generic-styleext-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('colInput') border-red-500 @enderror'
                                        placeholder='Escribe tu colonia' wire:model.defer='colInput'>
                                    @error('colInput')
                                        <span
                                            class='text-dark bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2'>{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-1/2 p-2">
                                    <label for="estadoInput" class="label-generic-style">Estado:</label>
                                    <input type="text"
                                        class="border border-gray-300 input-generic-style text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('estadoInput') border-red-500 @enderror"
                                        id="estadoInput" wire:model.defer="estadoInput"
                                        placeholder="Escribe tu estado" />
                                    @error('estadoInput')
                                        <span
                                            class="text-dark bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-1/2 p-2">
                                    <label for="noextInput" class="label-generic-style">No.
                                        Exterior:</label>
                                    <input type="text"
                                        class="border border-gray-300 input-generic-style text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('noextInput') border-red-500 @enderror"
                                        id="noextInput" wire:model.defer="noextInput"
                                        placeholder="Escribe tu noext" />
                                    @error('noextInput')
                                        <span
                                            class="text-dark bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-1/2 p-2">
                                    <label for="nointInput" class="label-generic-style">No.
                                        Interior:</label>
                                    <input type="text"
                                        class="border border-gray-300 input-generic-style text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('pais') border-red-500 @enderror"
                                        id="nointInput" wire:model.defer="nointInput"
                                        placeholder="Escribe tu noint" />
                                    @error('nointInput')
                                        <span
                                            class="text-dark bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-1/2 p-2">
                                    <label for="regimenfisInput" class="label-generic-style">Regimen
                                        Fiscal:</label>
                                    <input type="text"
                                        class="border border-gray-300 input-generic-style text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('regimenfisInput') border-red-500 @enderror"
                                        id="regimenfisInput" wire:model.defer="regimenfisInput"
                                        placeholder="Escribe tu regimen fiscal" />
                                    @error('regimenfisInput')
                                        <span
                                            class="text-dark bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-1/2 p-2">
                                    <label for="razonsInput" class="label-generic-style">Razón
                                        Social:</label>
                                    <input type="text"
                                        class="border border-gray-300 input-generic-style text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('razonsInput') border-red-500 @enderror"
                                        id="razonsInput" wire:model.defer="razonsInput"
                                        placeholder="Escribe tu razón social" />
                                    @error('razonsInput')
                                        <span
                                            class="text-dark bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-1/2 p-2">
                                    <label for="calleInput" class="label-generic-style">Calle:</label>
                                    <input type="text"
                                        class="border border-gray-300 input-generic-style text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('calleInput') border-red-500 @enderror"
                                        id="calleInput" wire:model.defer="calleInput"
                                        placeholder="Escribe tu calle" />
                                    @error('calleInput')
                                        <span
                                            class="text-dark bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="w-1/2 p-2">
                                    <label for="paisInput" class="label-generic-style">País:</label>
                                    <input type="text"
                                        class="border border-gray-300 input-generic-style text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('paisInput') border-red-500 @enderror"
                                        id="paisInput" wire:model.defer="paisInput" placeholder="Escribe tu país" />
                                    @error('paisInput')
                                        <span
                                            class="text-dark bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </x-slot>

                    <x-slot name="footer">
                        <div class="w-72">
                        </div>
                        <div class="flex-auto w-64 p-4 sm:px-6 float-right">
                            <button wire:click.prevent="update" type="button"
                                class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-base leading-6 font-bold shadow-sm focus:outline-none text-white focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                <svg wire:loading wire:target="editar"
                                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-dark"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4">
                                    </circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Actualizar
                            </button>
                        </div>
                    </x-slot>

                </x-jet-dialog-modal>


                {{-- MODAL ERRORES --}}
                <x-jet-dialog-modal wire:model="modalErrors">

                    <x-slot name="title">
                        {{-- <h1 class="font-bold text-red-500">Errores</h1> --}}
                    </x-slot>

                    <x-slot name="content">
                        <div class="px-4 mb-4 text-center" flex-grow>
                            <img class="mx-auto" src="/img/error.png" width="100px" height="100px"
                                alt="logo error">
                            <br>
                            <p class="font-bold mt-5 text-red-700">{!! nl2br($d) !!}</p>
                            <br>
                        </div>
                    </x-slot>

                    <x-slot name="footer">
                    </x-slot>

                </x-jet-dialog-modal>

            </div>
        </div>
    </div>
</div>

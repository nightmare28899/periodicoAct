<div class="container mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Factura') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div>
                    <p class="pt-5">Activar cliente Génerico <input wire:model="activarCG" type="checkbox"></p>
                    <h1 class="font-bold text-4xl text-center py-5">Facturación</h1>
                    {{-- <p class="font-bold">FACTURAR A:</p> --}}
                    <div class="flex mt-2 justify-center">
                        <div class="w-1/2">
                        </div>
                        <div class="w-1/2">
                        </div>
                        <div class="w-1/2">
                        </div>
                        <div class="w-1/2 text-center border-2 p-3 shadow">
                            {{-- Nombre: <br> --}}
                            <img src="/img/users.png" width="195px" alt="">
                            <p class="text-center"> {{ $cliente->nombre }} {{ $cliente->email }} <br>
                                <b>Tel:</b> +52 {{ $cliente->telefono }}
                            </p>

                        </div>
                        <div class="w-1/2">
                        </div>
                        <div class="w-1/2">
                        </div>
                        <div class="w-1/2">
                        </div>
                    </div>
                    <br>
                    <div class="flex mt-2 justify-between px-5 border-2">
                        <h1 class="text-xl font-bold mt-5">Datos Fiscales:</h1>
                        <button wire:click="modalEdit()"
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base font-bold text-white shadow-sm hover:bg-indigo-700">
                            Agregar/Editar
                        </button>
                    </div>

                    <div class="flex mt-2 justify-center">
                        <div class=" px-2">
                            <b>RFC: <input type="text" value="{{ $cliente->rfc_input }}" class="border-0 bg-gray-200"
                                    disabled></b>
                        </div>
                        <div class=" px-2">
                            <b>REGIMEN FISCAL: <input type="text" value="{{ $cliente->regimen_fiscal }}"
                                    class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-2 justify-center">
                        <div class=" px-2">
                            <b>CODIGO POSTAL: <input type="text" value="{{ $domicilio->cp }}"
                                    class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class=" px-2">
                            <b>RAZON SOCIAL: <input type="text" value="{{ $cliente->razon_social }}"
                                    class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-2 justify-center">
                        <div class=" px-2">
                            <b>COLONIA: <input type="text" value="{{ $domicilio->colonia }}"
                                    class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class=" px-2">
                            <b>CALLE: <input type="text" value="{{ $domicilio->calle }}" class="border-0 bg-gray-200"
                                    disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-2 justify-center">
                        <div class=" px-2">
                            <b>ESTADO: <input type="text" value="{{ $cliente->estado }}"
                                    class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class=" px-2">
                            <b>PAIS: <input type="text" value="{{ $cliente->pais }}" class="border-0 bg-gray-200"
                                    disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-2 justify-center">
                        <div class=" px-2">
                            <b>NO. EXTERIOR: <input type="text" value="{{ $domicilio->noext }}"
                                    class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class=" px-2">
                            <b>NO. INTERIOR: <input type="text" value="{{ $domicilio->noint }}"
                                    class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>

                    <br>
                    <div class="flex mt-1 mt-1.5">
                        <div class="w-1/2 px-2">
                            <label for="">Tipo Factura:</label><br>
                            <select name="" id="" wire:model="tipoFactura">
                                <option value="PUE">PUE</option>
                            </select>
                        </div>
                        <div class="w-1/2 px-2">
                            <label for="">Forma de pago:</label>
                            <select name="" id="" wire:model="PaymentForm" class="input-generic-style"
                                wire:loading.attr="disabled" wire:target="facturar">
                                <option selected style="display: none">Elegir una opcion</option>
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
                        <div class="w-1/2 px-2">
                            <label for="">CFDI:</label>
                            <select name="" id="" wire:model="cfdiUse" class="input-generic-style"
                                wire:loading.attr="disabled" wire:target="facturar">
                                <option selected style="display: none">Elegir una opcion</option>
                                <option value="G01">G01 Adquisición de mercancías.</option>
                                <option value="G02">G02 Devoluciones, descuentos o bonificaciones.</option>
                                <option value="G03">G03 Gastos en general.</option>
                                <option value="I01">I01 Construcciones.</option>
                                <option value="I02">I02 Mobiliario y equipo de oficina por inversiones.</option>
                                <option value="I03">I03 Equipo de transporte.</option>
                                <option value="I04">I04 Equipo de computo y accesorios.</option>
                                <option value="I05">I05 Dados, troqueles, moldes, matrices y herramental.</option>
                                <option value="I06">I06 Comunicaciones telefónicas.</option>
                                <option value="I07">I07 Comunicaciones satelitales.</option>
                                <option value="I08">I08 Otra maquinaria y equipo.</option>
                                <option value="D01">D01 Honorarios médicos, dentales y gastos hospitalarios.
                                </option>
                                <option value="D02">D02 Gastos médicos por incapacidad o discapacidad.</option>
                                <option value="D03">D03 Gastos funerales.</option>
                                <option value="D04">D04 Donativos.</option>
                                <option value="D05">D05 Intereses reales efectivamente pagados por créditos
                                    hipotecarios (casa habitación).</option>
                                <option value="D06">D06 Aportaciones voluntarias al SAR.</option>
                                <option value="D07">D07 Primas por seguros de gastos médicos.</option>
                                <option value="D08">D08 Gastos de transportación escolar obligatoria.</option>
                                <option value="D09">D09 Depósitos en cuentas para el ahorro, primas que tengan como
                                    base planes de pensiones.</option>
                                <option value="D10">D10 Pagos por servicios educativos (colegiaturas).</option>
                                <option value="S01">S01 Sin efectos fiscales.</option>
                                <option value="CP01">CP01 Pagos.</option>
                                <option value="CN01">CN01 Nómina.</option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div class="flex mt-1">
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2">
                            <label for="">Cant. Ejemplares:</label>
                            @if (substr($idTipo, 0, 6) == 'suscri')
                                <input type="text" class="border-0 bg-gray-200"
                                    value="{{ $suscripcion->cantEjemplares }}" disabled>
                            @else
                                <input type="text" class="border-0 bg-gray-200" value="{{ $tiro->entregar }}"
                                    disabled>
                            @endif
                        </div>
                    </div>
                    <div class="flex mt-1">
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2">
                            <label for="">Importe:</label>
                            @if (substr($idTipo, 0, 6) == 'suscri')
                                <input type="text" class="border-0 bg-gray-200"
                                    value="{{  sprintf('$ %s', number_format($suscripcion->importe)) }}" disabled>
                            @else
                                <input type="text" class="border-0 bg-gray-200" value="{{  sprintf('$ %s', number_format($tiro->importe)) }}"
                                    disabled>
                            @endif
                        </div>
                    </div>
                    <div class="flex mt-1">
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2">
                            <label for="">Descuento:</label>
                            @if (substr($idTipo, 0, 6) == 'suscri')
                                <input type="text" class="border-0 bg-gray-200"
                                    value="{{ $suscripcion->descuento }}" disabled>
                            @else
                                <input type="text" class="border-0 bg-gray-200" value="0" disabled>
                            @endif
                        </div>
                    </div>
                    <div class="flex mt-1">
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2">
                            <label for="">Total:</label>
                            @if (substr($idTipo, 0, 6) == 'suscri')
                                <input type="text" class="border-0 bg-gray-200" value="{{  sprintf('$ %s', number_format($suscripcion->total)) }}"
                                    disabled>
                            @else
                                <input type="text" class="border-0 bg-gray-200" value="{{  sprintf('$ %s', number_format($tiro->importe)) }}"
                                    disabled>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="flex-none mx-1" style="width: 88%;"></div>
                    <div class="flex-none mx-1">
                        <button wire:click="facturar"
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base font-bold text-white shadow-sm hover:bg-green-700">
                            <svg wire:loading wire:target="facturar"
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
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
            </div>
        </div>

        {{-- MODAL EDITAR DOMICILIO --}}
        <x-jet-dialog-modal wire:model="modalAgregar">

            <x-slot name="title">
                <div class="flex sm:px-6">
                    <h1 class="mb-3 text-2xl text-black font-bold ml-3">Datos Fiscales</h1>
                    <button type="button" wire:click="$set('modalAgregar', false)" wire:loading.attr="disabled"
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
                            <label for="rfcInput" class="text-black font-bold text-sm">RFC</label><br>
                            <input type='text' name='rfcInput'
                                class='border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('rfcInput') border-red-500 @enderror'
                                placeholder='Escribe tu RFC' wire:model.defer='rfcInput'>
                            @error('rfcInput')
                                <span
                                    class='text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2'>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-1/2 p-2">
                            <label for='cpInput' class='block text-gray-700 text-sm font-bold mb-2'>Código
                                Postal:</label>
                            <input type='number' name='cpInput'
                                class='border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('cpInput') border-red-500 @enderror'
                                placeholder='Escribe tu Código Postal' wire:model.defer='cpInput'>
                            @error('cpInput')
                                <span
                                    class='text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2'>{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex">
                        <div class="w-1/2 p-2">
                            <label for='colInput' class='block text-gray-700 text-sm font-bold mb-2'>Colonia:</label>
                            <input type='text' name='colInput'
                                class='border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('colInput') border-red-500 @enderror'
                                maxlength='12' placeholder='Escribe tu colonia' wire:model.defer='colInput'>
                            @error('colInput')
                                <span
                                    class='text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2'>{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-1/2 p-2">
                            <label for="estadoInput" class="block text-black text-sm font-bold mb-2">Estado:</label>
                            <input type="text"
                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('estadoInput') border-red-500 @enderror"
                                id="estadoInput" wire:model.defer="estadoInput" placeholder="Escribe tu estado" />
                            @error('estadoInput')
                                <span
                                    class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-1/2 p-2">
                            <label for="noextInput" class="block text-black text-sm font-bold mb-2">No.
                                Exterior:</label>
                            <input type="number"
                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('noextInput') border-red-500 @enderror"
                                id="noextInput" wire:model.defer="noextInput" placeholder="Escribe tu noext" />
                            @error('noextInput')
                                <span
                                    class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-1/2 p-2">
                            <label for="nointInput" class="block text-black text-sm font-bold mb-2">No.
                                Interior:</label>
                            <input type="number"
                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('pais') border-red-500 @enderror"
                                id="nointInput" wire:model.defer="nointInput" placeholder="Escribe tu noint" />
                            @error('nointInput')
                                <span
                                    class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-1/2 p-2">
                            <label for="regimenfisInput" class="block text-black text-sm font-bold mb-2">Regimen
                                Fiscal:</label>
                            <input type="number"
                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('regimenfisInput') border-red-500 @enderror"
                                id="regimenfisInput" wire:model.defer="regimenfisInput"
                                placeholder="Escribe tu regimen fiscal" />
                            @error('regimenfisInput')
                                <span
                                    class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-1/2 p-2">
                            <label for="razonsInput" class="block text-black text-sm font-bold mb-2">Razón
                                Social:</label>
                            <input type="text"
                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('razonsInput') border-red-500 @enderror"
                                id="razonsInput" wire:model.defer="razonsInput"
                                placeholder="Escribe tu razón social" />
                            @error('razonsInput')
                                <span
                                    class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-1/2 p-2">
                            <label for="calleInput" class="block text-black text-sm font-bold mb-2">Calle:</label>
                            <input type="text" maxlength="10"
                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('calleInput') border-red-500 @enderror"
                                id="calleInput" wire:model.defer="calleInput" placeholder="Escribe tu calle" />
                            @error('calleInput')
                                <span
                                    class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-1/2 p-2">
                            <label for="paisInput" class="block text-black text-sm font-bold mb-2">País:</label>
                            <input type="text"
                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('paisInput') border-red-500 @enderror"
                                id="paisInput" wire:model.defer="paisInput" placeholder="Escribe tu país" />
                            @error('paisInput')
                                <span
                                    class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex-auto w-64 px-4 sm:px-6">
                    {{-- <button wire:click.prevent="editarModal" type="button"
                class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-bold text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                <svg wire:loading wire:target="editarModal" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Editar
            </button> --}}
                </div>

                <div class="flex-auto w-64 px-4 sm:px-6">
                    <button wire:click.prevent="editar" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-base leading-6 font-bold shadow-sm text-white focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        <svg wire:loading wire:target="editar" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
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
                    <img class="mx-auto" src="/img/error.png" width="100px" height="100px" alt="logo error">
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

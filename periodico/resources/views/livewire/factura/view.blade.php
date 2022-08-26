<div class="container mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Lista de facturas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div>
                    <p class="pt-5">Activar cliente Génerico <input type="checkbox"></p>
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
                        <h1 class="text-xl font-bold mt-5">Datos para facturar:</h1>
                        <button wire:click="facturar"
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base font-bold text-white shadow-sm hover:bg-indigo-700">
                            Actualizar
                        </button>
                    </div>

                    <div class="flex mt-2 justify-center">
                        <div class=" px-2">
                            <b>RFC: <input type="text" value="{{ $cliente->rfc_input }}"
                                class="border-0 bg-gray-200" disabled></b>
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
                            <b>RAZON SOCIAL: <input type="text" value="{{ $cliente->rfc }}"
                                class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-2 justify-center">
                        <div class=" px-2">
                            <b>COLONIA: <input type="text" value="{{ $domicilio->colonia }}"
                                class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class=" px-2">
                            <b>CALLE: <input type="text" value="{{ $domicilio->calle }}"
                                class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-2 justify-center">
                        <div class=" px-2">
                            <b>ESTADO: <input type="text" value="{{ $cliente->estado }}"
                                class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class=" px-2">
                            <b>PAIS: <input type="text" value="{{ $cliente->pais }}"
                                class="border-0 bg-gray-200" disabled></b>
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
                            <select name="" id="" wire:model="paymentMethod" class="input-generic-style"
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
                            <input type="text" class="border-0 bg-gray-200" value="{{ $suscripcion->cantEjemplares }}" disabled>
                        </div>
                    </div>                    
                    <div class="flex mt-1">
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2">
                            <label for="">Importe:</label>
                            <input type="text" class="border-0 bg-gray-200" value="{{ $suscripcion->importe }}" disabled>
                        </div>
                    </div>
                    <div class="flex mt-1">
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2">
                            <label for="">Descuento:</label>
                            <input type="text" class="border-0 bg-gray-200" value="{{ $suscripcion->descuento }}" disabled>
                        </div>
                    </div>
                    <div class="flex mt-1">
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2"></div>
                        <div class="w-1/2 px-2">
                            <label for="">Total:</label>
                            <input type="text" class="border-0 bg-gray-200" value="{{ $suscripcion->total }}" disabled>
                        </div>
                    </div>
                </div>
                <div class="flex">
                    <div class="flex-none mx-1" style="width: 88%;"></div>
                    <div class="flex-none mx-1">
                        <button wire:click="facturar"
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base font-bold text-white shadow-sm hover:bg-green-700">
                            Generar Factura
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

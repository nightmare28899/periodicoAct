<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Varias Facturas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-9/12 mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg">
                <div class="flex flex-col">
                    <div class="inline-block min-w-full align-middle">
                        <div class="w-full justify-end p-6 items-center">
                            <p class="pt-5 text-dark">Activar cliente Génerico <input wire:model="activarCG"
                                    type="checkbox"></p>
                            <div class="w-64 mx-auto">
                                <div class="w-full">
                                    <x-jet-input type="search" id="query" name="query"
                                        placeholder="Escoge el cliente" wire:model="query" autocomplete="off" />

                                    @if (!empty($query))

                                        <div class="fixed top-0 right-0 bottom-0 left-0" wire:click="resetear"></div>

                                        <div class="absolute z-10 list-group bg-white rounded-md shadow-lg"
                                            style="width: 14.1rem;">

                                            @if (!empty($clientesBuscados))

                                                @foreach ($clientesBuscados as $i => $buscado)
                                                    <div wire:click="selectContact({{ $i }})"
                                                        class="list-item list-none p-2 hover:text-white rounded-md  hover:bg-blue-600 cursor-pointer">
                                                        {{ $buscado['nombre'] }}
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="list-item list-none p-2">No hay resultado</div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="flex mt-5 justify-between px-5 border-2">
                                <h1 class="text-xl font-bold mt-5 text-dark">Datos Fiscales:</h1>
                                <button wire:click="modalEdit()"
                                    class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-indigo-600 text-base font-bold text-white shadow-sm hover:bg-indigo-700">
                                    Agregar/Editar
                                </button>
                            </div>

                            <div class="flex mt-2 justify-center text-dark">
                                <div class=" px-2">
                                    <b>RFC: <input type="text"
                                            value="{{ !empty($clienteBarraBuscadora) ? $clienteBarraBuscadora['rfc_input'] : '' }}"
                                            class="border-0 bg-gray-200" disabled></b>
                                </div>
                                <div class="px-2">
                                    <b>REGIMEN FISCAL: <input type="text"
                                            value="{{ !empty($clienteBarraBuscadora) ? $clienteBarraBuscadora['regimen_fiscal'] : '' }}"
                                            class="border-0 bg-gray-200" disabled></b>
                                </div>
                            </div>
                            <div class="flex mt-2 justify-center text-dark">
                                <div class="px-2">
                                    <b>CODIGO POSTAL: <input type="text"
                                            value="{{ !empty($address) ? $address->cp : '' }}"
                                            class="border-0 bg-gray-200" disabled></b>
                                </div>
                                <div class=" px-2">
                                    <b>RAZON SOCIAL: <input type="text"
                                            value="{{ !empty($clienteBarraBuscadora) ? $clienteBarraBuscadora['razon_social'] : '' }}"
                                            class="border-0 bg-gray-200" disabled></b>
                                </div>
                            </div>
                            <div class="flex mt-2 justify-center text-dark">
                                <div class="px-2">
                                    <b>COLONIA: <input type="text"
                                            value="{{ !empty($address) ? $address->colonia : '' }}"
                                            class="border-0 bg-gray-200" disabled></b>
                                </div>
                                <div class="px-2">
                                    <b>CALLE: <input type="text"
                                            value="{{ !empty($address) ? $address->calle : '' }}"
                                            class="border-0 bg-gray-200" disabled></b>
                                </div>
                            </div>
                            <div class="flex mt-2 justify-center text-dark">
                                <div class="px-2">
                                    <b>ESTADO: <input type="text"
                                            value="{{ !empty($clienteBarraBuscadora) ? $clienteBarraBuscadora['estado'] : '' }}"
                                            class="border-0 bg-gray-200" disabled></b>
                                </div>
                                <div class="px-2">
                                    <b>PAIS: <input type="text"
                                            value="{{ !empty($clienteBarraBuscadora) ? $clienteBarraBuscadora['pais'] : '' }}"
                                            class="border-0 bg-gray-200" disabled></b>
                                </div>
                            </div>
                            <div class="flex mt-2 justify-center text-dark">
                                <div class="px-2">
                                    <b>NO. EXTERIOR: <input type="text"
                                            value="{{ !empty($address) ? $address->noext : '' }}"
                                            class="border-0 bg-gray-200" disabled></b>
                                </div>
                                <div class="px-2">
                                    <b>NO. INTERIOR: <input type="text"
                                            value="{{ !empty($address) ? $address->noint : '' }}"
                                            class="border-0 bg-gray-200" disabled></b>
                                </div>
                            </div>

                            <div class="pt-5 mt-5">
                                <select
                                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                    wire:model="rutaSeleccionada">
                                    <option value="">Selecciona una Ruta</option>
                                    @foreach ($rutas as $ruta)
                                        <option value="{{ $ruta->id }}">{{ $ruta->nombreruta }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="shadow-md sm:rounded-lg mt-5">

                                <div class="inline-block min-w-full align-middle">
                                    <div class="overflow-auto h-96">
                                        <table
                                            class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700 text-center">
                                            <thead
                                                class="table-auto border-separate border-spacing-2 border border-dark sticky top-0">
                                                <tr class='bg-gray-100'>
                                                    <th scope="col"
                                                        class="py-3 px-6 text-xs font-medium tracking-wider uppercase">
                                                        Seleccionar
                                                    </th>
                                                    <th scope="col"
                                                        class="py-3 px-6 text-xs font-medium tracking-wider uppercase">
                                                        CLIENTE
                                                    </th>
                                                    <th scope="col"
                                                        class="py-3 px-6 text-xs font-medium tracking-wider uppercase">
                                                        ENTREGAR
                                                    </th>
                                                    <th scope="col"
                                                        class="py-3 px-6 text-xs font-medium tracking-wider uppercase">
                                                        PRECIO
                                                    </th>
                                                    <th scope="col"
                                                        class="py-3 px-6 text-xs font-medium tracking-wider uppercase">
                                                        IMPORTE
                                                    </th>
                                                    <th scope="col"
                                                        class="py-3 px-6 text-xs font-medium tracking-wider uppercase">
                                                        NOMBRE RUTA
                                                    </th>
                                                    <th scope="col"
                                                        class="py-3 px-6 text-xs font-medium tracking-wider uppercase">
                                                        TIPO
                                                    </th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                @if ($ventas)
                                                    @foreach ($ventas as $venta)
                                                        @if ($venta['precio'] != 0 && $venta['importe'] != '0')
                                                            <tr class="hover:bg-gray-100">
                                                                <td
                                                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap text-dark">
                                                                    <input type="checkbox" name="order_id"
                                                                        wire:model.defer="odersSelected"
                                                                        value="{{ $venta['id'] }}">
                                                                </td>
                                                                <td
                                                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap text-dark">
                                                                    {{ $venta['cliente'] }}
                                                                </td>
                                                                <td
                                                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap text-dark">
                                                                    {{ $venta['entregar'] }}
                                                                </td>
                                                                <td
                                                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap text-dark">
                                                                    {{ sprintf('$ %s', number_format($venta['precio'], 2)) }}
                                                                </td>
                                                                <td
                                                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap text-dark">
                                                                    {{ sprintf('$ %s', number_format($venta['importe'], 2)) }}
                                                                </td>
                                                                <td
                                                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap text-dark">
                                                                    {{ $venta['nombreruta'] }}
                                                                </td>
                                                                <td
                                                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap text-dark">
                                                                    {{ $venta['idTipo'] }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if ($suscripciones)
                                                    @foreach ($suscripciones as $venta)
                                                        @if ($venta['precio'] != 0 && $venta['importe'] != '0')
                                                            <tr class="hover:bg-gray-100">
                                                                <td
                                                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap text-dark">
                                                                    <input type="checkbox" name="order_id"
                                                                        wire:model.defer="odersSelected"
                                                                        value="{{ $venta['id'] }}">
                                                                </td>
                                                                <td
                                                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap text-dark">
                                                                    {{ $venta['cliente'] }}
                                                                </td>
                                                                <td
                                                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap text-dark">
                                                                    {{ $venta['entregar'] }}
                                                                </td>
                                                                <td
                                                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap text-dark">
                                                                    {{ sprintf('$ %s', number_format($venta['precio'], 2)) }}
                                                                </td>
                                                                <td
                                                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap text-dark">
                                                                    {{ sprintf('$ %s', number_format($venta['importe'], 2)) }}
                                                                </td>
                                                                <td
                                                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap text-dark">
                                                                    {{ $venta['nombreruta'] }}
                                                                </td>
                                                                <td
                                                                    class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap text-dark">
                                                                    {{ $venta['idTipo'] }}
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="flex mt-1.5 text-dark mt-5 pt-5">
                                <div class="w-64 px-2">
                                    <label for="tipoFactura">Tipo Factura:</label><br>
                                    <select name="tipoFactura" class="input-generic-style" id="tipoFactura">
                                        <option value="{{ $tipoFactura == 'PUE' ? 'PUE' : 'PPD' }}">
                                            {{ $tipoFactura == 'PUE' ? 'PUE' : 'PPD' }}</option>
                                    </select>
                                </div>
                                <div class="w-auto px-2 text-dark">
                                    <label for="PaymentForm">Forma de pago:</label>
                                    <select name="PaymentForm" id="PaymentForm" wire:model="PaymentForm"
                                        class="input-generic-style" wire:loading.attr="disabled"
                                        wire:target="facturar">
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
                                <div class="w-auto px-2 text-dark">
                                    <label for="CFDI">CFDI:</label>
                                    <select name="CFDI" id="CFDI" wire:model="cfdiUse"
                                        wire:loading.attr="disabled" wire:target="cfdi">
                                        <option selected style="display: none">Elegir una opción</option>
                                        <option value="G01">G01 Adquisición de mercancías.</option>
                                        <option value="G02">G02 Devoluciones, descuentos o bonificaciones.</option>
                                        <option value="G03">G03 Gastos en general.</option>
                                        <option value="I01">I01 Construcciones.</option>
                                        <option value="I02">I02 Mobiliario y equipo de oficina por inversiones.
                                        </option>
                                        <option value="I03">I03 Equipo de transporte.</option>
                                        <option value="I04">I04 Equipo de computo y accesorios.</option>
                                        <option value="I05">I05 Dados, troqueles, moldes, matrices y herramental.
                                        </option>
                                        <option value="I06">I06 Comunicaciones telefónicas.</option>
                                        <option value="I07">I07 Comunicaciones satelitales.</option>
                                        <option value="I08">I08 Otra maquinaria y equipo.</option>
                                        <option value="D01">D01 Honorarios médicos, dentales y gastos hospitalarios.
                                        </option>
                                        <option value="D02">D02 Gastos médicos por incapacidad o discapacidad.
                                        </option>
                                        <option value="D03">D03 Gastos funerales.</option>
                                        <option value="D04">D04 Donativos.</option>
                                        <option value="D05">D05 Intereses reales efectivamente pagados por créditos
                                            hipotecarios (casa habitación).</option>
                                        <option value="D06">D06 Aportaciones voluntarias al SAR.</option>
                                        <option value="D07">D07 Primas por seguros de gastos médicos.</option>
                                        <option value="D08">D08 Gastos de transportación escolar obligatoria.
                                        </option>
                                        <option value="D09">D09 Depósitos en cuentas para el ahorro, primas que
                                            tengan como
                                            base planes de pensiones.</option>
                                        <option value="D10">D10 Pagos por servicios educativos (colegiaturas).
                                        </option>
                                        <option value="S01">S01 Sin efectos fiscales.</option>
                                        <option value="CP01">CP01 Pagos.</option>
                                        <option value="CN01">CN01 Nómina.</option>
                                    </select>
                                </div>
                            </div>

                            <div class="flex">
                                <div class="w-auto px-2 mt-7 text-dark">
                                    <label for="concepto">Concepto:</label> <br>
                                    <textarea wire:model="concepto" class="input-generic-style" name="concepto" id="concepto" cols="30"
                                        rows="3" placeholder="Escribe el concepto"></textarea>
                                </div>
                            </div>
                            <div class="flex">
                                <div class="flex-none mx-1" style="width: 84%;"></div>
                                <div class="flex-none mx-1">
                                    <button wire:click="facturar"
                                        class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base font-bold text-white shadow-sm hover:bg-green-700">
                                        <svg wire:loading wire:target="facturar"
                                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-dark"
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODAL EDITAR DOMICILIO --}}
    <x-jet-dialog-modal wire:model="modalAgregar">

        <x-slot name="title">
            {{-- <div class="flex sm:px-6">
                    <h1 class="mb-3 text-2xl text-dark font-bold ml-3">Datos Fiscales</h1>
                    <button type="button" wire:click="$set('modalAgregar', false)" wire:loading.attr="disabled"
                        class="mb-3 text-gray-400 bg-transparent hover:bg-red-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-red-600 dark:hover:text-dark"
                        data-modal-toggle="defaultModal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <hr> --}}
        </x-slot>

        <x-slot name="content">
            <div flex-grow>
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
                            id="estadoInput" wire:model.defer="estadoInput" placeholder="Escribe tu estado" />
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
                            id="noextInput" wire:model.defer="noextInput" placeholder="Escribe tu noext" />
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
                            id="nointInput" wire:model.defer="nointInput" placeholder="Escribe tu noint" />
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
                            id="razonsInput" wire:model.defer="razonsInput" placeholder="Escribe tu razón social" />
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
                            id="calleInput" wire:model.defer="calleInput" placeholder="Escribe tu calle" />
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


                <div class="flex float-end">
                    <div class="w-1/2"></div>
                    <div class="w-1/2"></div>
                    <div class="w-1/2"></div>
                    <div class="w-1/2">
                        <button wire:click.prevent="editar" type="button"
                        class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline">
                        <svg wire:loading wire:target="editar" class="animate-spin -ml-1 mr-3 h-5 w-5 text-dark"
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
                </div>

            </div>
        </x-slot>

        <x-slot name="footer">
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

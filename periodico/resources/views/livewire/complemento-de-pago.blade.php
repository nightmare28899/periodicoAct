<div class="w-1/2 mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Complemento de pago') }}
        </h2>
    </x-slot>
    {{-- To attain knowledge, add things every day; To attain wisdom, subtract things every day. --}}

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex flex-col">
                    <p class="pt-5">Activar cliente Génerico <input wire:model="activarCG" type="checkbox"></p>
                    <div class="flex flex-row">
                        <div class="flex flex-col mr-3">
                            <label for="forma_pago">Forma de pago</label>
                            <select wire:model="forma_pago" class="border border-gray-400 p-2 rounded">
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
                        <div class="flex flex-col mr-3">
                            <label for="fecha">Moneda</label>
                            <input type="text" wire:model="moneda" placeholder="Busca el cliente"
                                class="border border-gray-400 p-2 rounded" disabled>
                        </div>
                    </div>
                    <div class="flex flex-row mt-3">
                        <div class="flex flex-col mr-3">
                            <label for="fecha">Selecciona tu cliente</label>
                            <input type="text" wire:model="query" placeholder="Busca el cliente"
                                class="border border-gray-400 p-2 rounded">

                            @if (!empty($query))

                                <div class="fixed top-0 right-0 bottom-0 left-0" wire:click="resetear"></div>

                                <div class="absolute z-10 list-group bg-white rounded-t-none shadow-lg"
                                    style="margin-top: 4.5rem;">

                                    @if (!empty($clientesBuscados))

                                        @foreach ($clientesBuscados as $i => $buscado)
                                            <div wire:click="selectContact({{ $i }})"
                                                class="list-item list-none p-2 hover:text-white hover:bg-blue-600 cursor-pointer w-full">
                                                {{ $buscado['nombre'] }}
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="list-item list-none p-2">No hay resultado</div>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col mr-3">
                            <label for="fecha">Fecha de pago</label>
                            <input type="date" wire:model="fecha" class="border border-gray-400 p-2 rounded">
                        </div>
                    </div>
                    <div class="flex flex-row mt-3">
                        <div class="flex flex-col mr-3 w-full">
                            <label for="fecha">Factura a pagar</label>
                            <select wire:model="facturaSeleccionada" class="border border-gray-400 p-2 rounded">
                                <option selected style="display: none">Elegir una opcion</option>
                                @foreach ($invoices as $invoice)
                                    <option value="{{ $invoice->id }}" selected> {{ $loop->index + 1 }}.-
                                        {{ $invoice->uuid }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="flex mt-3">
                        <div class="flex flex-col mr-3 w-1/2">
                            <label for="monto">Monto a pagar</label>
                            <input type="number" min="0" placeholder="Escribe el monto"
                                wire:model.defer="montoIngresado" class="border border-gray-400 p-2 rounded">
                        </div>
                        <div class="flex flex-col mr-3 mt-6 w-64">
                            <button wire:click="addFactura"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <svg wire:loading wire:target="addFactura"
                                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4">
                                    </circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Agregar factura</button>
                        </div>
                    </div>
                    <div class="">
                        <p>Facturas agregadas</p>
                        <table class="table-auto border-separate border-spacing-2 border border-dark text-center uppercase">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 w-20 uppercase">Serie</th>
                                    <th class="px-4 py-2 w-100 uppercase">Folio Fiscal</th>
                                    <th class="px-4 py-2 w-20 uppercase">Id</th>
                                    <th class="px-4 py-2 w-20 uppercase">Monto</th>
                                    <th class="px-4 py-2 w-20 uppercase">Pago</th>
                                    <th class="px-4 py-2 w-20 uppercase">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($invoicesId)
                                    @foreach ($invoicesId as $invoice)
                                        <tr>
                                            <td class="border px-4 py-2">{{ $invoice['serie'] }}</td>
                                            <td class="border px-4 py-2">{{ $invoice['uuid'] }}</td>
                                            <td class="border px-4 py-2">{{ $invoice['id'] }}</td>
                                            @if ($montosIngresados)
                                                <td class="border px-4 py-2">{{ $montosIngresados[$loop->index] }}</td>
                                            @endif
                                            <td class="border px-4 py-2">{{ $invoice['total'] }}</td>
                                            <td class="border px-4 py-2"><button
                                                    wire:click="remover({{ $invoice['id'] }})"
                                                    class="px-2 w-full py-1 cursor-pointer bg-red-500 hover:bg-red-600 text-white border-2">
                                                    <svg wire:loading wire:target="remover"
                                                        class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12"
                                                            r="10" stroke="currentColor" stroke-width="4">
                                                        </circle>
                                                        <path class="opacity-75" fill="currentColor"
                                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                        </path>
                                                    </svg>
                                                    Remover</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="w-1/2">
                        <button
                            class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                            wire:click.prevent="complementoDePago">
                            <svg wire:loading wire:target="complementoDePago"
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Generar complemento de pago
                        </button>
                    </div>
                </div>
            </div>
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

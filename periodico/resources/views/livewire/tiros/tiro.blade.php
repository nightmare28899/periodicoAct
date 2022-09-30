<div class="container mx-auto">
    <style>
        table,
        td,
        th,
        tr {
            border: 1px solid;
            padding: 4px 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Generar Tiro') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <div class="flex-none mt-1">
                        <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                        <x-jet-input class="w-full" type="date" wire:model="from">
                        </x-jet-input>
                    </div>
                    <div class="flex-none mt-1 ml-3">
                        <label for="fecha" class="block text-sm font-medium text-gray-700">Ruta</label>
                        <select
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                            style="width: 11rem;" wire:model="rutaSeleccionada">
                            <option value='Todos' selected>TODOS</option>
                            @foreach ($ruta as $rut)
                                <option value='{{ $rut['nombreruta'] }}'>
                                    {{ $rut['nombreruta'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-initial mx-1 mt-4" style="width: 80%;">
                        {{-- <input wire:model.defer='keyWord' wire:keydown.enter="busqueda" type="text"
                            class=" text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full"
                            name="search" id="search" placeholder="Buscar Tiro"> --}}
                    </div>
                    {{-- <div class="flex-initial ml-3 mt-4" style="width: 10%;">
                        <button wire:click="historialFactura" wire:loading.attr="disabled"
                            class="p-2 bg-green-500 rounded-md text-white hover:bg-green-700 ">
                            <svg wire:loading wire:target="historialFactura"
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Historial de Facturas
                        </button>
                    </div> --}}
                    <div class="flex-initial ml-3 mt-4" style="width: 10%;">
                        <button wire:click="showModal" wire:loading.attr="disabled"
                                class="p-2 bg-green-500 rounded-md text-white hover:bg-green-700 ">
                            <svg wire:loading wire:target="showModal" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Generar Tiro
                        </button>
                    </div>
                </div>
                <br>
                @if (session()->has('message'))
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                         role="alert">
                        <div class="flex">
                            <div>
                                <p class="text-sm">{{ session('message') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <table class="table-auto w-full text-center">
                    <thead>
                    <tr class="text-white bg-gray-500">
                        <th class="px-4 py-2 w-20">Ruta</th>
                        <th class="px-4 py-2 w-20">Día</th>
                        <th class="px-4 py-2 w-20">Tipo</th>
                        <th class="px-4 py-2 w-20">Cliente</th>
                        <th class="px-4 py-2 w-20">Dirección</th>
                        <th class="px-4 py-2 w-20">Referencia</th>
                        <th class="px-4 py-2 w-20">Ejemplares</th>
                        <th class="px-4 py-2 w-20">Fecha</th>
                        {{-- <th class="px-4 py-2 w-20">Acciones</th> --}}
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($ventas as $result)
                        @if ($result->{$diaS} != 0)
                            <tr>
                                <td class="border">{{ $result->nombreruta }}, Tipo: {{ $result->tiporuta }}, Repartidor: {{ $result->repartidor }}, Cobrador: {{ $result->cobrador }}</td>
                                <td class="border">{{ $diaS }} </td>
                                <td class="border">Venta/Cliente</td>
                                @if ($result->nombre)
                                    <td class="border">{{ $result->nombre }}</td>
                                @else
                                    <td class="border">{{ $result->razon_social }}</td>
                                @endif
                                <td class="border">Calle: {{ $result->calle }} <br>
                                    No. Ext:
                                    {{ $result->noext }}, CP: {{ $result->cp }}, <br> Localidad:
                                    {{ $result->localidad }}, Municipio: {{ $result->municipio }}
                                </td>
                                <td class="border">{{ $result->referencia }}</td>
                                <td class="border">{{ $result->{$diaS} }}</td>
                                <td class="border">
                                    {{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</td>
                            </tr>
                        @else
                            <tr>

                            </tr>
                        @endif
                    @endforeach

                    @foreach ($suscripcion as $suscrip)
                        @if (($suscrip->{$diaS} != 0 && $suscrip->estado == 'Activo') || $suscrip->contrato == 'Cortesía')
                            <tr>
                                <td class="border">{{ $suscrip->nombreruta }}, Tipo: {{ $suscrip->tiporuta }}, Repartidor: {{ $suscrip->repartidor }}, Cobrador: {{ $suscrip->cobrador }}</td>
                                <td class="border">{{ $diaS }} </td>
                                <td>Suscripción</td>
                                <td class="border">{{ $suscrip->nombre }}</td>
                                <td class="border">Calle: {{ $suscrip->calle }} <br>
                                    No. Ext:
                                    {{ $suscrip->noext }}, CP: {{ $suscrip->cp }}, <br> Localidad:
                                    {{ $suscrip->localidad }}, Ciudad: {{ $suscrip->ciudad }}
                                </td>
                                <td wire:model="referencia" class="border">{{ $suscrip->referencia }}</td>
                                <td class="border">{{ $suscrip->{$diaS} != 0 ? $suscrip->cantEjemplares : 0 }}</td>
                                <td wire:model="fecha" class="border">
                                    {{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</td>
                                {{-- <td class="border">Calle: {{ $domsubs[$key]->calle }} <br>
                                    No. Ext:
                                    {{ $domsubs[$key]->noext }}, CP: {{ $domsubs[$key]->cp }}, <br> Localidad:
                                    {{ $domsubs[$key]->localidad }}, Ciudad: {{ $domsubs[$key]->ciudad }}
                                </td>
                                <td wire:model="referencia" class="border">{{ $domsubs[$key]->referencia }}</td> --}}

                            </tr>
                        @else
                            <tr>

                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
                <br>
                {{-- {{ $resultado->links() }} --}}
                <br>
            </div>
        </div>

        {{-- DATOS DEL TIRO --}}
        <x-jet-dialog-modal wire:model="showingModal">

            <x-slot name="title">
                <div class="flex sm:px-6">
                    <h1 class="mb-3 text-2xl text-black font-bold ml-3">Datos del Tiro</h1>
                    <button type="button" wire:click="$set('showingModal', false)" wire:loading.attr="disabled"
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
                <br>
                <div class="text-center">
                    <div class="flex justify-center">
                        <div class="">
                            <p class="font-bold text-sm"> Fecha seleccionada para el tiro: <br>
                                {{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }} </p>
                        </div>
                        <div class="ml-20">
                            <button wire:click="descarga" id="tiro" wire:loading.attr="disabled"
                                    class="p-2 bg-green-500 rounded-md text-white hover:bg-green-700">
                                <svg wire:loading wire:target="descarga"
                                     class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4">
                                    </circle>
                                    <path class="opacity-75" fill="currentColor"
                                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Descargar
                                Tiro
                            </button>
                        </div>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
        {{-- <div class="flex-auto w-64 px-4 sm:px-6">
            <button wire:click="historialRemision" id="tiro" wire:loading.attr="disabled"
                class="p-2 bg-blue-500 rounded-md text-white hover:bg-blue-700">
                <svg wire:loading wire:target="historialRemision"
                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10"
                        stroke="currentColor" stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Historial de Remisiones</button> --}}
    </div>
    {{-- <div class="flex-auto w-64 px-4 sm:px-6">
        <button wire:click="generarRemision" id="tiro" wire:loading.attr="disabled"
            class="p-2 bg-blue-500 rounded-md text-white hover:bg-blue-700">
            <svg wire:loading wire:target="generarRemision"
                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10"
                    stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>Generar
            Remisiones del Tiro</button>
    </div> --}}
    </x-slot>

    </x-jet-dialog-modal>

    {{-- MODAL HISTORIAL DE FACTURAS --}}
    <x-jet-dialog-modal wire:model="modalHistorialFactura" maxWidth="6xl">

        <x-slot name="title">
            <div class="flex sm:px-6">
                <h1 class="mb-3 text-2xl text-black font-bold ml-3">Historial de facturas</h1>
                <button type="button" wire:click="$set('showingModal', false)" wire:loading.attr="disabled"
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
            <table class="table-auto w-full text-center">
                <thead>
                <tr class="text-white bg-gray-500">
                    <th class="px-4 py-2 w-20">Fecha</th>
                    <th class="px-4 py-2 w-20">Tipo</th>
                    <th class="px-4 py-2 w-20">Cliente</th>
                    <th class="px-4 py-2 w-20">Ejemplares</th>
                    <th class="px-4 py-2 w-20">Total</th>
                    <th class="px-4 py-2 w-20">Acciones</th>
                </tr>
                </thead>
                <tbody>
                @if (count($invoices) > 0)
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td class="border">
                                {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y') }}</td>
                            <td class="border">
                                {{ substr($invoice->idTipo, 0, 6) == 'suscri' ? 'Suscripción' : 'Venta/Cliente' }}
                            </td>
                            <td class="border">{{ $invoice->cliente }}</td>
                            <td class="border">{{ $invoice->quantity }}</td>
                            <td class="border">${{ $invoice->total }} {{ $invoice->currency }}</td>
                            <td class="border">
                                <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                   href="{{ url('vistaPrevia/' . $invoice->invoice_id) }}">Ver PDF</a>
                                @if ($invoice->status == 'cancelada')
                                    <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-green-500 hover:bg-green-600 rounded-lg focus:shadow-outline"
                                       disabled>Factura
                                        cancelada</a>
                                @else
                                    <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-red-500 hover:bg-red-600 rounded-lg focus:shadow-outline"
                                       href="{{ url('cancelarFactura/' . $invoice->invoice_id) }}">Cancelar
                                        factura</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="border">No hay facturas</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </x-slot>

        <x-slot name="footer">
        </x-slot>

    </x-jet-dialog-modal>
</div>
</div>

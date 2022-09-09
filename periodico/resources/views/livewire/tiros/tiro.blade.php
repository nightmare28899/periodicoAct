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
                    <div class="flex-none mx-1 mt-3">
                        <div class="antialiased sans-serif">
                            <div>
                                <div class="container mx-auto px-4">
                                    <div class="mb-5 w-64">
                                        <div class="relative">
                                            <div class="grid mt-1">
                                                <x-jet-input class="w-full" type="date" wire:model="from">
                                                </x-jet-input>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-initial mx-1 mt-4" style="width: 80%;">
                        {{-- <input wire:model.defer='keyWord' wire:keydown.enter="busqueda" type="text"
                            class=" text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full"
                            name="search" id="search" placeholder="Buscar Tiro"> --}}
                    </div>
                    <div class="flex-initial ml-3 mt-4" style="width: 10%;">
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
                    </div>
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
                            <th class="px-4 py-2 w-20">Tipo</th>
                            <th class="px-4 py-2 w-20">Cliente</th>
                            <th class="px-4 py-2 w-20">Día</th>
                            <th class="px-4 py-2 w-20">Dirección</th>
                            <th class="px-4 py-2 w-20">Referencia</th>
                            <th class="px-4 py-2 w-20">Ejemplares</th>
                            {{-- <th class="px-4 py-2 w-20">Fecha</th> --}}
                            {{-- <th class="px-4 py-2 w-20">Acciones</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $result)
                            @if ($result->{$diaS} != 0)
                                <tr>
                                    <td class="border">Venta/Cliente</td>
                                    @if ($result->nombre)
                                        <td class="border">{{ $result->nombre }}</td>
                                    @else
                                        <td class="border">{{ $result->razon_social }}</td>
                                    @endif
                                    <td class="border">{{ $diaS }} </td>
                                    <td class="border">Calle: {{ $result->calle }} <br>
                                        No. Ext:
                                        {{ $result->noext }}, CP: {{ $result->cp }}, <br> Localidad:
                                        {{ $result->localidad }}, Municipio: {{ $result->municipio }}
                                    </td>
                                    <td class="border">{{ $result->referencia }}</td>
                                    <td class="border">{{ $result->{$diaS} }}</td>
                                    {{-- <td class="border">
                                        {{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</td> --}}
                                </tr>
                            @else
                                <tr>

                                </tr>
                            @endif
                        @endforeach

                        @foreach ($suscripcion as $suscrip)
                            @if (($suscrip->{$diaS} != 0 && $suscrip->estado == 'Activo') || $suscrip->contrato == 'Cortesía')
                                <tr>
                                    <td>Suscripción</td>
                                    <td class="border">{{ $suscrip->nombre }}</td>
                                    <td class="border">{{ $diaS }} </td>
                                    <td class="border">Calle: {{ $suscrip->calle }} <br>
                                        No. Ext:
                                        {{ $suscrip->noext }}, CP: {{ $suscrip->cp }}, <br> Localidad:
                                        {{ $suscrip->localidad }}, Ciudad: {{ $suscrip->ciudad }}
                                    </td>
                                    <td wire:model="referencia" class="border">{{ $suscrip->referencia }}</td>
                                    <td class="border">{{ $suscrip->{$diaS} != 0 ? $suscrip->cantEjemplares : 0 }}</td>
                                    {{-- <td class="border">Calle: {{ $domsubs[$key]->calle }} <br>
                                        No. Ext:
                                        {{ $domsubs[$key]->noext }}, CP: {{ $domsubs[$key]->cp }}, <br> Localidad:
                                        {{ $domsubs[$key]->localidad }}, Ciudad: {{ $domsubs[$key]->ciudad }}
                                    </td>
                                    <td wire:model="referencia" class="border">{{ $domsubs[$key]->referencia }}</td> --}}
                                    {{-- <td wire:model="fecha" class="border">
                                        {{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</td> --}}
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
                                Tiro</button>
                        </div>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex-auto w-64 px-4 sm:px-6">
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
                        Historial de Remisiones</button>
                </div>
                <div class="flex-auto w-64 px-4 sm:px-6">
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
                </div>
            </x-slot>

        </x-jet-dialog-modal>
        {{-- MODAL DATOS DE LA REMISIÓN --}}
        <x-jet-dialog-modal wire:model="modalRemision" maxWidth="6xl">

            <x-slot name="title">
                <div class="flex sm:px-6">
                    <h1 class="mb-3 text-2xl text-black font-bold ml-3">Datos de la Remisión</h1>
                    <button type="button" wire:click="hideModalRemision" wire:loading.attr="disabled"
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
                <div class="flex">
                    <h4 class="flex-initial" style="width: 11rem;">Desde:</h4>
                    <h4 class="flex-initial" style="width: 11rem;">Hasta:</h4>
                    <h4 class="flex-initial" style="width: 11rem;">Ruta:</h4>
                    <h4 class="flex-initial">Tipo</h4>
                </div>
                <div class="container w-full">

                    <x-jet-input type="date" wire:model="de"></x-jet-input>
                    <x-jet-input type="date" wire:model="hasta"></x-jet-input>

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
                    <select
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                        style="width: 11rem;" wire:model="tipoSeleccionada">
                        <option value='venta'>
                            Venta/Cliente
                        </option>
                        <option value='suscripcion'>
                            Suscripción
                        </option>
                    </select>
                </div>
                <br>
                <div class="text-center overflow-x">
                    <div class="overflow-x-auto w-full">
                        <table class="table-auto">
                            <thead>
                                <tr class='text-white bg-gray-500'>
                                    <th class='px-4 py-2'>Fecha</th>
                                    <th class='px-4 py-2'>Cliente</th>
                                    <th class='px-4 py-2'>Entregar</th>
                                    <th class='px-4 py-2'>Devuelto</th>
                                    <th class='px-4 py-2'>Faltante</th>
                                    <th class='px-4 py-2'>Venta</th>
                                    <th class='px-4 py-2'>Precio</th>
                                    <th class='px-4 py-2'>Importe</th>
                                    <th class='px-6 py-2'>Dia</th>
                                    <th class='px-6 py-2'>Nombre Ruta</th>
                                    <th class='px-6 py-2'>Tipo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ventaCopia as $result)
                                    @if ($result->{$diaS} != 0)
                                        <tr>
                                            <td class='px-4 py-2'>
                                                <div class="form-group">
                                                    <input wire:model="clienteSeleccionado" type="checkbox"
                                                        value={{ $result->idVenta }}>
                                                    <label class="text-black"
                                                        for="Física">{{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</label>
                                                </div>
                                            </td>
                                            <td class='px-4 py-2'>
                                                {{ $result->nombre ? $result->nombre : $result->razon_social }}</td>
                                            <td class='px-4 py-2'>{{ $result->{$diaS} }}</td>
                                            <td class='px-4 py-2'>{{ $devuelto }}</td>
                                            <td class='px-4 py-2'>{{ $faltante }}</td>
                                            <td class='px-4 py-2'>{{ $result->{$diaS} }}</td>
                                            <td class='px-4 py-2'>
                                                ${{ $diaS == 'domingo' ? $result->dominical : $result->ordinario }}
                                            </td>
                                            <td class='px-4 py-2'>
                                                ${{ ($diaS == 'domingo' ? $result->dominical : $result->ordinario) * $result->{$diaS} }}
                                            </td>
                                            <td class='px-4 py-2'>{{ $diaS }}</td>
                                            <td class='px-4 py-2'>{{ $result->nombreruta }}</td>
                                            <td class='px-4 py-2'>{{ $result->tiporuta }}</td>
                                        </tr>
                                    @else
                                        <tr>

                                        </tr>
                                    @endif
                                @endforeach
                                @foreach ($suscripcionCopia as $suscri)
                                    @if ($suscri->{$diaS} != 0)
                                        <tr>
                                            <td class='px-4 py-2'>
                                                <div class="form-group">
                                                    <input wire:model="clienteSeleccionado" type="checkbox"
                                                        value={{ $suscri->idSuscripcion }}>
                                                    <label class="text-black"
                                                        for="Física">{{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</label>
                                                </div>
                                            </td>
                                            <td class='px-4 py-2'>
                                                {{ $suscri->nombre ? $suscri->nombre : $suscri->razon_social }}</td>
                                            <td class='px-4 py-2'>{{ $suscri->cantEjemplares }}</td>
                                            <td class='px-4 py-2'>{{ $devuelto }}</td>
                                            <td class='px-4 py-2'>{{ $faltante }}</td>
                                            <td class='px-4 py-2'>{{ $suscri->cantEjemplares }}</td>
                                            <td class='px-4 py-2'>
                                                ${{ $suscri->tarifa == 'Base' ? 330 : 300 }}
                                            </td>
                                            <td class='px-4 py-2'>
                                                ${{ $suscri->importe }}
                                            </td>
                                            <td class='px-4 py-2'>{{ $diaS }}</td>
                                            <td class='px-4 py-2'>{{ $suscri->nombreruta }}</td>
                                            <td class='px-4 py-2'>{{ $suscri->tiporuta }}</td>

                                        </tr>
                                    @else
                                        <tr>

                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">

                <div class="flex-auto w-64 px-4 sm:px-6">
                    <x-jet-secondary-button
                        class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition ml-3 float-left"
                        wire:click="hideModalRemision" wire:loading.attr="disabled">
                        {{ __('Cancelar') }}
                    </x-jet-secondary-button>
                </div>
                <div class="flex-auto w-32 px-4 sm:px-6">
                    <button wire:click="descargaTodasRemisiones" id="tiro" wire:loading.attr="disabled"
                        class="p-2 bg-green-500 rounded-md text-white hover:bg-green-700">
                        <svg wire:loading wire:target="descargaTodasRemisiones"
                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>Generar Todas
                    </button>
                </div>
                <div class="flex-auto w-32 px-4 sm:px-6">
                    <button wire:click="descargaRemision" id="tiro" wire:loading.attr="disabled"
                        class="p-2 bg-green-500 rounded-md text-white hover:bg-green-700">
                        <svg wire:loading wire:target="descargaRemision"
                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>Generar Seleccion
                    </button>
                </div>

            </x-slot>

        </x-jet-dialog-modal>
        {{-- MODAL HISTORIAL DE REMISIÓN --}}
        <x-jet-dialog-modal wire:model="modalHistorial" maxWidth="7xl">

            <x-slot name="title">
                <div class="flex sm:px-6">
                    <h1 class="mb-3 text-2xl text-black font-bold ml-3">Historial</h1>
                    <button type="button" wire:click="cerrarHistorial" wire:loading.attr="disabled"
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
                <br>
                @if (count($tiros) > 0)
                    <div class="text-center overflow-x">
                        <div class="overflow-x-auto w-full">
                            <table class="table-auto">
                                <thead>
                                    <tr class='bg-gray-100'>
                                        <th class='px-4 py-2'>Fecha</th>
                                        {{-- <th class="px-6 py-2">idTipo</th> --}}
                                        <th class='px-4 py-2'>Cliente</th>
                                        <th class='px-4 py-2'>Entregar</th>
                                        <th class='px-4 py-2'>Devuelto</th>
                                        <th class='px-4 py-2'>Faltante</th>
                                        <th class='px-4 py-2'>Venta</th>
                                        <th class='px-4 py-2'>Precio</th>
                                        <th class='px-4 py-2'>Importe</th>
                                        <th class='px-6 py-2'>Dia</th>
                                        <th class='px-6 py-2'>Nombre Ruta</th>
                                        <th class='px-6 py-2'>Tipo</th>
                                        <th class="px-6 py-2">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tiros as $tiro)
                                        <tr>
                                            <td class='px-4 py-2'>
                                                {{ \Carbon\Carbon::parse($tiro->fecha)->format('d/m/Y') }}</td>
                                            {{-- <td class='px-4 py-2'>{{ $tiro->idTipo }}</td> --}}
                                            <td class='px-4 py-2'>
                                                {{ $tiro->cliente ? $tiro->cliente : $tiro->razon_social }}</td>
                                            <td class='px-4 py-2'>{{ $tiro->entregar }}</td>
                                            <td class='px-4 py-2'>{{ $tiro->devuelto }}</td>
                                            <td class='px-4 py-2'>{{ $tiro->faltante }}</td>
                                            <td class='px-4 py-2'>{{ $tiro->venta }}</td>
                                            <td class='px-4 py-2'>${{ $tiro->precio }}</td>
                                            <td class='px-4 py-2'>${{ $tiro->importe }}</td>
                                            <td class='px-4 py-2'>{{ $tiro->dia }}</td>
                                            <td class='px-4 py-2'>{{ $tiro->nombreruta }}</td>
                                            <td class='px-4 py-2'>{{ $tiro->tipo }}</td>
                                            {{-- checa esto agrega el estado al tiro para poder cambiar el boton segun el estdo --}}
                                            @if ($tiro->precio == 330 || $tiro->precio == 300)
                                                <td>
                                                    @if ($tiro->estado == 'Activo')
                                                        <button wire:click="pausarRemision({{ $tiro->cliente_id }})"
                                                            class="px-2 w-full py-1 cursor-pointer bg-red-500 hover:bg-red-600 text-white my-2 rounded-lg">Pausar
                                                            suscripción</button>
                                                    @elseif ($tiro->estado == 'Pausado')
                                                        <button wire:click="pausarRemision({{ $tiro->cliente_id }})"
                                                            class="px-2 w-full py-1 cursor-pointer bg-sky-500 hover:bg-sky-600 text-white my-2 rounded-lg">Activar
                                                            suscripción</button>
                                                    @endif

                                                    {{-- @if ($tiro->status $tiro->status == 'facturado')
                                                        <button
                                                            class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                            disabled>Facturado</button>
                                                    @else --}}
                                                        <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                            href="{{ url('factura/' . $tiro->cliente_id . '/' . $tiro->idTipo) }}">Factura</a>
                                                    {{-- @endif --}}
                                                </td>
                                            @else
                                                <td>
                                                    <button wire:click="editarRemision({{ $tiro->id }})"
                                                        class="px-2 w-full py-1 cursor-pointer bg-sky-500 hover:bg-sky-600 text-white my-2 rounded-lg">Editar</button>

                                                    {{-- @if ($tiro->status == 'facturado')
                                                        <button
                                                            class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                            disabled>Facturado</button>
                                                    @else --}}
                                                        <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                            href="{{ url('factura/' . $tiro->cliente_id . '/' . $tiro->idTipo) }}">Factura</a>
                                                    {{-- @endif --}}
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="text-center">
                        <h1 class="text-2xl text-black font-bold">No hay registros</h1>
                    </div>
                @endif
            </x-slot>

            <x-slot name="footer">

            </x-slot>

        </x-jet-dialog-modal>
        {{-- MODAL EDITAR DEVUELTOS --}}
        <x-jet-dialog-modal wire:model="modalEditar">

            <x-slot name="title">
                <div class="flex sm:px-6">
                    <h1 class="mb-3 text-2xl text-black font-bold ml-3">Editar devueltos</h1>
                    <button type="button" wire:click="cerrarEditar" wire:loading.attr="disabled"
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
                <div class="mb-3">
                    <label for="exampleFormControlInput2" class="block text-black text-sm font-bold mb-2">Cantidad de
                        devueltos:</label>
                    <input type="number"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('nombre') border-red-500 @enderror"
                        id="devuelto" wire:model.defer="devuelto" placeholder="Cantidad" min="0" />
                </div>
                @if ($devuelto == 0 || ($devuelto > 0 && $entregar > 0))
                    <p>devuelto: {{ $devuelto }}</p>
                    <p>entregar: {{ $entregar }}</p>
                    <button wire:click.prevent="updateDevueltos" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        <svg wire:loading wire:target="updateDevueltos"
                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Devolver
                    </button>
                @elseif ($entregar == 0 && $devuelto > 0)
                    <p>devuelto: {{ $devuelto }}</p>
                    <p>entregar: {{ $entregar }}</p>
                    <button wire:click.prevent="updateDevueltos" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        <svg wire:loading wire:target="updateDevueltos"
                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Cancelar devolución
                    </button>
                @endif
            </x-slot>

            <x-slot name="footer">

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
                                        {{-- @if ($tiroStatus[0]->status == 'cancelado')
                                            <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-green-500 hover:bg-green-600 rounded-lg focus:shadow-outline"
                                                disabled>Factura
                                                cancelada</a>
                                        @else --}}
                                            <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-red-500 hover:bg-red-600 rounded-lg focus:shadow-outline"
                                                href="{{ url('vistaPrevia/' . $invoice->invoice_id) }}">Cancelar
                                                factura</a>
                                        {{-- @endif --}}
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

<div class="container mx-auto">
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
                                                <x-jet-input class="w-full" type="date" wire:model="from"
                                                    placeholder="Desde"></x-jet-input>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-initial mx-1 mt-4" style="width: 100%;">
                        <input wire:model='keyWord' type="text"
                            class=" text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full"
                            name="search" id="search" placeholder="Buscar Tiro">
                    </div>
                    <div class="flex-initial ml-3 mt-4" style="width: 10%;">
                        {{-- <a href="{{ route('download-pdf') }}" --}}
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
                        {{-- <div wire:click="showModal" wire:loading.attr="disabled"
                            class="p-4 text-gray-900 cursor-pointer">
                            Open modal
                        </div> --}}
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

                {{-- <livewire:custom-modal :wire:key="'custom-modal-'.time()"> --}}

                <table class="table-auto w-full text-center">
                    <thead>
                        <tr class="bg-gray-500 text-white">
                            <th class="px-4 py-2 w-20">No.</th>
                            <th class="px-4 py-2 w-20">Cliente</th>
                            <th class="px-4 py-2 w-20">Día</th>
                            <th class="px-4 py-2 w-20">Ejemplares</th>
                            <th class="px-4 py-2 w-20">Domicilio</th>
                            <th class="px-4 py-2 w-20">Referencia</th>
                            <th class="px-4 py-2 w-20">Fecha</th>
                            {{-- <th class="px-4 py-2 w-20">Acciones</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($resultado as $result)
                            <tr>
                                <td class="border">{{ $loop->iteration }}</td>
                                <td class="border">{{ $result->nombre }}</td>
                                <td class="border">{{ $diaS }} </td>
                                <td class="border">{{ $result->{$diaS} }}</td>
                                <td class="border" wire:model="domicilio">Calle: {{ $result->calle }} <br>
                                    No. Ext:
                                    {{ $result->noext }}, CP: {{ $result->cp }}, <br> Localidad:
                                    {{ $result->localidad }}, Municipio: {{ $result->municipio }}
                                </td>
                                <td wire:model="referencia" class="border">{{ $result->referencia }}</td>
                                <td wire:model="fecha" class="border">
                                    {{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</td>
                                {{-- <td class="border px-4 py-2 flex-nowrap pt-2">
                                    <input type="button"
                                        class="btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 bg-blue-400 font-medium rounded-md text-white hover:bg-blue-600 focus:outline-none transition cursor-pointer"
                                        name="imprimir" value="Imprimir" onclick="window.print();">
                                </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                {{-- {{ $resultado->links() }} --}}
                <br>
            </div>
        </div>

        <div>
            <x-jet-dialog-modal wire:model="showingModal">

                <x-slot name="title">
                    <div class="flex sm:px-6">
                        <h1 class="mb-3 text-2xl text-black font-bold ml-3">Datos del Tiro</h1>
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
                    <br>
                    <div class="text-center">
                        <div class="flex justify-center">
                            <div class="">
                                <p class="font-bold text-sm"> Fecha seleccionada para el tiro: <br>
                                    {{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }} </p>
                                <p class="font-bold text-sm" style="margin-top: 15px;">Cantidad de registros:
                                    {{ count($resultado) }}</p>
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
                    {{-- <script>
                        document.getElementById('tiro').addEventListener('click', function(e) {
                            e.preventDefault();
                            setTimeout(function() {
                                const loader = document.getElementById('loader').style.display = 'none';
                            }, 1500);
                        });
                    </script>

                    @if ($isGenerateTiro)
                        <div id="loader">
                            @include('livewire.tiros.tiro-p-d-f')
                        </div>
                    @endif --}}
                </x-slot>

                <x-slot name="footer">
                    <div class="flex-auto w-64">
                        <x-jet-secondary-button
                            class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition ml-3 float-left"
                            wire:click="$set('showingModal', false)" wire:loading.attr="disabled">
                            {{ __('Cancelar') }}
                        </x-jet-secondary-button>
                    </div>
                    <div class="flex-auto w-64">
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
        </div>
        <div>
            <x-jet-dialog-modal wire:model="modalRemision">

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
                    <br>
                    <div class="text-center overflow-x">
                        <div class="overflow-x-auto w-full">
                            <table class="table-auto">
                                <thead>
                                    <tr class='bg-gray-100'>
                                        <th class='px-4 py-2'>Fecha</th>
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
                                    @foreach ($resultado as $result)
                                        <tr>
                                            <td>
                                                <div class="form-group">
                                                    <input wire:model="clienteSeleccionado"
                                                         type="checkbox" value={{ $result->id }}>
                                                    <label class="text-black"
                                                        for="Física">{{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</label>
                                                </div>
                                            </td>
                                            <td>{{ $result->{$diaS} }}</td>
                                            <td>0</td>
                                            <td>0</td>
                                            <td>{{ $result->{$diaS} }}</td>
                                            <td>{{ $diaS == 'domingo' ? $result->dominical : $result->ordinario }}</td>
                                            <td>{{ ($diaS == 'domingo' ? $result->dominical : $result->ordinario) * $result->{$diaS} }}</td>
                                            <td>{{ $diaS }}</td>
                                            <td>{{ $result->nombreruta }}</td>
                                            <td>{{ $result->tiporuta }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="footer">
                    <div class="flex-auto w-64">
                        <x-jet-secondary-button
                            class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition ml-3 float-left"
                            wire:click="hideModalRemision" wire:loading.attr="disabled">
                            {{ __('Cancelar') }}
                        </x-jet-secondary-button>
                    </div>
                    <div class="flex-auto w-64">
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
                            </svg>Descargar PDF
                        </button>
                    </div>

                </x-slot>


            </x-jet-dialog-modal>
        </div>
    </div>
</div>

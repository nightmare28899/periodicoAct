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
                        <button wire:click="showModal" id="tiro" wire:loading.attr="disabled"
                            class="p-2 bg-green-500 rounded-md text-white hover:bg-green-700 ">Generar
                            Tiro</button>
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


                <script>
                    document.getElementById('tiro').addEventListener('click', function(e) {
                        e.preventDefault();
                        setTimeout(function() {
                            const loader = document.getElementById('loader').style.display = 'none';
                        }, 1500);
                    });
                </script>

                {{-- este es el loader --}}
                @if ($isGenerateTiro)
                    <div id="loader">
                        @include('livewire.tiros.tiro-p-d-f')
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
                                <td wire:model="fecha" class="border">{{ $dateF }}</td>
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

        <x-jet-dialog-modal wire:model="showingModal">

            <x-slot name="title">

            </x-slot>

            <x-slot name="content">
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
                                <td class="border" wire:model="domicilio">Calle: {{ $result->calle }}
                                    <br>
                                    No. Ext:
                                    {{ $result->noext }}, CP: {{ $result->cp }}, <br> Localidad:
                                    {{ $result->localidad }}, Municipio: {{ $result->municipio }}
                                </td>
                                <td wire:model="referencia" class="border">{{ $result->referencia }}</td>
                                <td wire:model="fecha" class="border">{{ $dateF }}</td>
                                {{-- <td class="border px-4 py-2 flex-nowrap pt-2">
                                                <input type="button"
                                                    class="btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 bg-blue-400 font-medium rounded-md text-white hover:bg-blue-600 focus:outline-none transition cursor-pointer"
                                                    name="imprimir" value="Imprimir" onclick="window.print();">
                                            </td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </x-slot>

            <x-slot name="footer">
                {{-- <x-jet-secondary-button wire:click="$set('showingModal', false)" wire:loading.attr="disabled">
                        {{ __('Cancel')  }}
                     </x-jet-secondary-button> --}}
            </x-slot>


        </x-jet-dialog-modal>

    </div>
</div>

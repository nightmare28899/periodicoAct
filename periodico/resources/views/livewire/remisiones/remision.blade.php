<div class="container mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Remisión de Venta Periódico ') }}
        </h2>
    </x-slot>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <div class="flex-none mx-1 mt-3">
                        <div class="antialiased sans-serif">
                            <div>
                                <div class="container mx-auto px-4">
                                    <div class="">
                                        <div class="flex" style="width: 100%;">
                                            <div class="grid mt-1 mr-2">
                                                <x-jet-input class="w-full" type="date" wire:model="from"
                                                    placeholder="Desde"></x-jet-input>
                                            </div>
                                            <div class="grid mt-1">
                                                <x-jet-input class="w-full" type="date" wire:model="to"
                                                    placeholder="Hasta"></x-jet-input>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-initial mx-1 mt-4 mr-4" style="width: 68%;">
                        <input wire:model='keyWord' type="text"
                            class=" text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full"
                            name="search" id="search" placeholder="Buscar Remisión">
                    </div>
                    <div class="flex-initial x-1 mt-4">
                        <button wire:click="search"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            venta
                        </button>
                    </div>
                </div>
                <div class="card">
                    <br>
                    <div class="flex items-end pt-4 px-4 sm:block sm:p-0">
                        <div
                            class="inline-block align-bottom rounded-lg text-left overflow-hidden border-2 shadow-md w-2/5">
                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 mt-8">
                                <h5
                                    class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-black text-center">
                                    Datos
                                    del cliente:
                                </h5>
                                <div class="flex p-6">
                                    <div>
                                        {{-- <p class="font-normal text-gray-600 text-lg">Datos del Domicilio:</p> --}}
                                        <p class="font-normal text-gray-500">
                                            <b>Clave:</b> <br>
                                            <b>Nombre:</b> <br>
                                            <b>Calle:</b> <br>
                                            <b>Colonia:</b> <br>
                                            <b>C.P.:</b> <br>
                                            <b>Localidad:</b> <br>
                                            <b>Estado:</b> <br>
                                            <b>R.F.C.:</b> <br>
                                            <b>N. Ext:</b> <br>
                                            <b>Municipio:</b> <br>
                                            <b>País:</b> <br>
                                            <b>N. Int:</b>
                                        </p>
                                    </div>

                                    {{-- <div>
                                        <p class="font-normal text-gray-600 text-lg">Cantidad de Ejemplares:</p>
                                        <p class="font-normal text-gray-500">
                                            <b>Lunes:</b> {{ $lunes }} <br>
                                            <b>Martes:</b> {{ $martes }} <br>
                                            <b>Miércoles:</b> {{ $miércoles }} <br>
                                            <b>Jueves:</b> {{ $jueves }} <br>
                                            <b>Viernes:</b> {{ $viernes }} <br>
                                            <b>Sábado:</b> {{ $sábado }} <br>
                                            <b>Domingo:</b> {{ $domingo }} <br>
                                        </p>
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
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
                        <tr class="bg-gray-500 text-white">
                            <th class="px-4 py-2 w-20">Fecha:</th>
                            <th class="px-4 py-2 w-20">Entrada:</th>
                            <th class="px-4 py-2 w-20">Devolución:</th>
                            <th class="px-4 py-2 w-20">Falta:</th>
                            <th class="px-4 py-2 w-20">Venta</th>
                            <th class="px-4 py-2 w-20">Precio</th>
                            <th class="px-4 py-2 w-20">Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($resultado as $result)
                            <tr>
                                <td class="border">{{ $loop->iteration }}</td>
                                <td class="border">{{ $result->nombre }}</td>
                                <td class="border">{{ $dia }}</td>
                                @if ($dia == 'lunes')
                                    <td class="border">{{ $result->martes }}</td>
                                @elseIf ($dia == 'martes')
                                    <td class="border">{{ $result->miércoles }}</td>
                                @elseIf ($dia == 'miércoles')
                                    <td class="border">{{ $result->jueves }}</td>
                                @elseIf ($dia == 'jueves')
                                    <td class="border">{{ $result->viernes }}</td>
                                @elseIf ($dia == 'viernes')
                                    <td class="border">{{ $result->sábado }}</td>
                                @elseIf ($dia == 'sábado')
                                    <td class="border">{{ $result->lunes }}</td>
                                @endif
                                <td class="border">Calle: {{ $result->calle }} <br> No. Ext:
                                    {{ $result->noext }}, CP: {{ $result->cp }}, <br> Localidad:
                                    {{ $result->localidad }}, Municipio: {{ $result->municipio }}
                                </td>
                                <td class="border">{{ $result->referencia }}</td>
                                <td class="border">{{ $dateF }}</td>
                                <td class="border px-4 py-2 flex-nowrap pt-2">
                                    <input type="button"
                                        class="btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 bg-blue-400 font-medium rounded-md text-white hover:bg-blue-600 focus:outline-none transition cursor-pointer"
                                        name="imprimir" value="Imprimir" onclick="window.print();">
                                </td>
                            </tr>
                        @endforeach --}}
                    </tbody>
                </table>
                <br>
                {{-- {{ $resultado->links() }} --}}
                <br>
            </div>
        </div>
    </div>
</div>

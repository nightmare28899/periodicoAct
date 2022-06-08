<div class="container mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Remisión Venta/Periódico Cliente') }}
        </h2>
    </x-slot>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <p class="text-sm mt-3"><b>NO. REMISION: <k class="text-red-500 font-bold"> 1 </k> </b> </p>
                    <p class="text-sm mt-3" style="margin-left: 22rem"><b>FECHA:</b>
                        <k class="text-red-500 font-bold"> {{ $fechaHoy }} </k>
                    </p>
                </div>
                <div class="">
                    <div class="flex">
                        <p class="text-sm font-bold mt-6">CLIENTE</p>
                        <p class="text-sm mt-6" style="margin-left: 24rem"> <b>Cliente Ruta:</b> @foreach ($data as $item)
                                {{ $item->tipo }}
                            @endforeach
                        </p>
                        </p>
                    </div>

                    <div class="flex-initial mx-1 mt-4 mr-4" style="width: 40%;">
                        <select
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            id="select" wire:model="clienteSeleccionado" style="width: 100%">
                            <option value=''>Escoge una opción</option>
                            @foreach ($clientes as $cliente)
                                <option value={{ $cliente['id'] }}>
                                    {{ $cliente['nombre'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('clasificacion')
                            <span class="text-red-500">{{ $message }}</span>
                        @enderror
                    </div>
                    {{-- <div class="flex-initial mx-1 mt-4 mr-4" style="width: 40%;">
                        <input wire:model='keyWord' type="number"
                            class=" text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full"
                            name="search" id="search" placeholder="Buscar Clave Cliente">
                    </div> --}}
                    {{-- <div class="flex-initial x-1 mt-4">
                        <button wire:click="search"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Por Ruta
                        </button>
                    </div> --}}
                </div>
                <div class="card">
                    <br>
                    <div class="flex-initial mx-1 mt-4">
                        <div
                            class="inline-block align-bottom rounded-lg text-left overflow-hidden border-2 shadow-md w-2/5">
                            <div class="bg-white px-4 pt-3 pb-4 sm:p-6 sm:pb-4 mt-2">
                                <h5
                                    class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-black text-center">
                                    Datos
                                    del cliente:
                                </h5>
                                <div class="p-6">
                                    <div class="mx-auto align-center">
                                        {{-- <p class="font-normal text-gray-600 text-lg">Datos del Domicilio:</p> --}}
                                        @foreach ($data as $item)
                                            <div class="container">
                                                <div class="px-4 mb-6" flex-grow>
                                                    <div class="flex">
                                                        <div class="w-1/2 p-2">
                                                            <p class="font-normal text-gray-500">
                                                                <b>Clave:</b> {{ $item->id }} <br>
                                                                <b>Nombre:</b> {{ $item->nombre }} <br>
                                                                <b>Calle:</b> {{ $item->calle }} <br>
                                                                <b>Colonia:</b> {{ $item->colonia }} <br>
                                                                <b>C.P.:</b> {{ $item->cp }} <br>
                                                                <b>Localidad:</b> {{ $item->localidad }}
                                                            </p>
                                                        </div>
                                                        <div class="w-1/2 p-2">
                                                            <p class="font-normal text-gray-500">
                                                                <b>Estado:</b> {{ $item->estado }} <br>
                                                                <b>R.F.C.:</b> {{ $item->rfc_input }} <br>
                                                                <b>N. Ext:</b> {{ $item->noext }} <br>
                                                                <b>Municipio:</b> {{ $item->municipio }} <br>
                                                                <b>País:</b> {{ $item->pais }} <br>
                                                                <b>N. Int: </b> {{ $item->noint }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <br>
                <p class="mb-3 text-sm font-bold">CONCEPTO</p>
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

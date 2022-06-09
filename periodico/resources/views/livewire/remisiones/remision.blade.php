<div class="container mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Historial Remisiónes') }}
        </h2>
    </x-slot>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <h1 class="font-bold">Remisiones registradas</h1>
                <h2 class="text-sm font-bold ml-3">Filtrar remisiones de</h2>

                <div class="flex">
                    <div class="flex-none mx-1 mt-3">
                        <div class="antialiased sans-serif">
                            <div>
                                <div class="container mx-auto px-4">
                                    <div class="">
                                        <div class="flex" style="width: 100%;">

                                            <div class="grid mt-1">
                                                <div class="form-group">
                                                    <input type="radio">
                                                    <label for="">Venta periódico</label>
                                                </div>
                                            </div>


                                            <div class="grid mt-1 ml-3">
                                                <div class="form-group">
                                                    <input type="radio">
                                                    <label for="">Suscripciones</label>
                                                </div>
                                            </div>

                                            <div class="grid mt-1 ml-3">
                                                <div class="form-group">
                                                    <input type="radio">
                                                    <label for="">Ambas</label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex-initial mx-1 mr-4">
                        <button
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base text-white shadow-sm hover:bg-blue-700"
                            title="Recargar total de remisiones">Actualizar Remisiones</button>
                    </div>
                    <div class="flex-initial x-1 mt-4">
                        <x-jet-dropdown align="right" width="48">
                            <x-slot name="trigger">

                                <span class="inline-flex rounded-md">
                                    <button type="button"
                                        class="btn inline-flex items-center px-3 py-2 border border-slate-800 text-sm leading-4 font-medium rounded-md text-gray-700 hover:text-gray-400 focus:outline-none transition">
                                        NUEVA REMISION

                                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </span>
                            </x-slot>

                            <x-slot name="content" class="w-full text-center">
                                <a href="{{ url('remision/ventaP/cliente') }}"><button
                                        class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Venta/P') }}</button></a>
                                <a href="{{ url('tiro') }}"><button
                                        class="btn px-2 w-full py-1 cursor-pointer text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition">{{ __('Suscipción') }}</button></a>
                            </x-slot>
                        </x-jet-dropdown>
                    </div>
                </div>
                <div>
                    <h2>Buscar remision por:</h2>
                    <div style="width: 51%;">
                        <input wire:model='keyWord' type="text"
                            class=" text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full"
                            name="search" id="search"
                            placeholder="Buscar por Remision, cliente, nombre, rfc, factura, calle, municipio, estado">
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
                        <tr class="bg-gray-500 text-white">
                            <th class="px-4 py-2 w-20">REMISIÓN:</th>
                            <th class="px-4 py-2 w-20">FECHA:</th>
                            <th class="px-4 py-2 w-20">PAGO:</th>
                            <th class="px-4 py-2 w-20">CANTIDAD:</th>
                            <th class="px-4 py-2 w-20">TOTAL</th>
                            <th class="px-4 py-2 w-20">FACTURA</th>
                            <th class="px-4 py-2 w-20">SERIE</th>
                            <th class="px-4 py-2 w-20">CONCEPTO</th>
                            <th class="px-4 py-2 w-20">CLIENTE</th>
                            <th class="px-4 py-2 w-20">NOMBRE</th>
                            <th class="px-4 py-2 w-20">RFC</th>
                            <th class="px-4 py-2 w-20">CONTRATO</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
                <br>
                {{-- {{ $resultado->links() }} --}}
                <br>
                
                <h2>REGISTROS:</h2>

                Búsquedas pór fecha 
            </div>
        </div>
    </div>
</div>

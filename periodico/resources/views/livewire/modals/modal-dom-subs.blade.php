<x-jet-dialog-modal wire:model="modalDomSubs" maxWidth="6xl">
    <x-slot name="title">
        <div class="flex sm:px-6">
            <h1 class="mb-3 text-2xl text-black font-bold ml-3">Listado de Domicilios</h1>
            <button type="button" wire:click="$set('modalDomSubs', false)" wire:loading.attr="disabled"
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
        <div class="flex justify-between">
            <div>

            </div>
            <div>
                <button class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-md"
                    wire:click="modalCrearDom">Agregar</button>
            </div>
        </div>
        @if (count($domiciliosSubs) > 0)
            <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-3">
                <table class="w-full text-md text-left text-gray-500 dark:text-gray-400 uppercase">
                    <thead class="text-md text-gray-700 uppercase bg-gray-700">
                        <tr class="bg-gray-500 text-white uppercase">
                            <th scope="col" class="py-3 px-6">
                                Calle
                            </th>
                            <th scope="col" class="py-3 px-6">
                                #Int
                            </th>
                            <th scope="col" class="py-3 px-6">
                                #Ext
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Colonia
                            </th>
                            <th scope="col" class="py-3 px-6">
                                C.P.
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Localidad
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Ciudad
                            </th>
                            {{-- <th scope="col" class="py-3 px-6">
                                #Ejemp
                            </th> --}}
                            <th scope="col" class="py-3 px-6">
                                Referencia
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Ruta
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($domiciliosSubs as $domicilio)
                            @if ($domicilio->cliente_id == $clienteSeleccionado['id'])
                                <tr
                                    class="bg-white text-black hover:text-white hover:bg-blue-500 text-center cursor-pointer">
                                    <td class="border" wire:click="datoSeleccionado({{ $domicilio->id }})">
                                        {{ $domicilio->calle }}</td>
                                    <td class="border" wire:click="datoSeleccionado({{ $domicilio->id }})">
                                        {{ $domicilio->noint }}</td>
                                    <td class="border" wire:click="datoSeleccionado({{ $domicilio->id }})">
                                        {{ $domicilio->noext }}</td>
                                    <td class="border" wire:click="datoSeleccionado({{ $domicilio->id }})">
                                        {{ $domicilio->colonia }}</td>
                                    <td class="border" wire:click="datoSeleccionado({{ $domicilio->id }})">
                                        {{ $domicilio->cp }}</td>
                                    <td class="border" wire:click="datoSeleccionado({{ $domicilio->id }})">
                                        {{ $domicilio->localidad }}</td>
                                    <td class="border" wire:click="datoSeleccionado({{ $domicilio->id }})">
                                        {{ $domicilio->ciudad }}</td>
                                    <td class="border" wire:click="datoSeleccionado({{ $domicilio->id }})">
                                        {{ $domicilio->referencia }}</td>
                                    <td class="border" wire:click="datoSeleccionado({{ $domicilio->id }})">
                                        {{ $domicilio->nombreruta  }}</td>
                                    <td class="border"><button
                                            class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-md"
                                            wire:click="editarDomicilioSubs({{ $domicilio->id }})">Editar</button><br>
                                        <button class="px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded-md"
                                            wire:click="eliminarSubs({{ $domicilio->id }})">Borrar</button>
                                    </td>
                                </tr>
                            @else
                                <tr>

                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-center font-bold text-xl">No hay domicilios registrados</p>
        @endif

    </x-slot>
    <x-slot name="footer">

    </x-slot>
    </x-jet-dialog-mod>

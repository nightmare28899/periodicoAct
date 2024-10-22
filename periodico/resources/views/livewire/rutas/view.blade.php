<div class="w-2/3 mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Lista de Rutas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <div class="flex-initial mx-1 mt-4" style="width: 100%;">
                        <input wire:model='keyWord' type="text"
                            class=" text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                            name="search" id="search" placeholder="Buscar Ruta">
                    </div>
                    <div class="flex-none mx-1">
                        <button wire:click="create"
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base font-bold text-white shadow-sm hover:bg-green-700">
                            Crear ruta
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

                @if ($isModalOpen)
                    @include('livewire.rutas.create')
                @endif
                <table class="table-auto border-separate border-spacing-2 border border-dark w-full text-center uppercase">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 w-20 uppercase">No.</th>
                            <th class="px-4 py-2 w-20 uppercase">Nombre</th>
                            <th class="px-4 py-2 w-20 uppercase">Tipo</th>
                            <th class="px-4 py-2 w-20 uppercase">Repartidor</th>
                            <th class="px-4 py-2 w-20 uppercase">Cobrador</th>
                            <th class="px-4 py-2 w-20 uppercase">Ctaespecial</th>
                            <th class="px-4 py-2 w-20 uppercase">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rutas as $ruta)
                            <tr>
                                <td class="px-4 py-2 border border-dark">{{ $ruta->id }}</td>
                                <td class="px-4 py-2 border border-dark">{{ $ruta->nombreruta }}</td>
                                <td class="px-4 py-2 border border-dark">{{ $ruta->tiporuta }}</td>
                                <td class="px-4 py-2 border border-dark">{{ $ruta->repartidor }}</td>
                                <td class="px-4 py-2 border border-dark">{{ $ruta->cobrador }}</td>
                                <td class="px-4 py-2 border border-dark">{{ $ruta->ctaespecial }}</td>
                                <td class="px-4 py-2 border border-dark flex-nowrap pt-2">
                                    <x-jet-dropdown align="right" width="48">
                                        <x-slot name="trigger">

                                            <span class="inline-flex rounded-md">
                                                <button type="button"
                                                    class="btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                    Acciones

                                                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                </button>
                                            </span>
                                        </x-slot>

                                        <x-slot name="content">

                                            <button wire:click="edit({{ $ruta->id }})"
                                                class="px-2 w-full py-1 cursor-pointer hover:bg-sky-600 hover:text-white">Editar</button>

                                            <div class="border-t border-gray-100"></div>

                                            {{-- <button wire:click="delete({{ $ruta->id }})"
                                                class="px-2 w-full py-1 cursor-pointer hover:bg-red-600 hover:text-white">Eliminar</button> --}}

                                        </x-slot>
                                    </x-jet-dropdown>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                {{ $rutas->links('livewire.custom-pagination') }}
                <br>
                <br>
            </div>
        </div>

    </div>
</div>

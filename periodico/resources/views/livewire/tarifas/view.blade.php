<div class="w-2/3 mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Lista de Tarifas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <div class="flex-initial mx-1 mt-4" style="width: 100%;">
                        <input wire:model='keyWord' type="text"
                            class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                            name="search" id="search" placeholder="Buscar Tarifa">
                    </div>
                    <div class="flex-none mx-1">
                        <button wire:click="create"
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base font-bold text-white shadow-sm hover:bg-green-700">
                            Crear tarifa
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
                    @include('livewire.tarifas.create')
                @endif
                <table class="table-auto border-separate border-spacing-2 border border-dark w-full text-center uppercase">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 w-20 uppercase">No.</th>
                            <th class="px-4 py-2 w-20 uppercas">Tipo</th>
                            <th class="px-4 py-2 w-20 uppercas">Ordinario</th>
                            <th class="px-4 py-2 w-20 uppercas">Dominical</th>
                            <th class="px-4 py-2 w-20 uppercas">Fecha creación</th>
                            <th class="px-4 py-2 w-20 uppercas">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tarifas as $tarifa)
                            <tr>
                                <td class="px-4 py-2 border border-dark">{{ $tarifa->id }}</td>
                                <td class="px-4 py-2 border border-dark">{{ $tarifa->tipo }}</td>
                                <td class="px-4 py-2 border border-dark">{{ sprintf('$ %s', number_format($tarifa->ordinario, 2)) }}</td>
                                <td class="px-4 py-2 border border-dark">{{ sprintf('$ %s', number_format($tarifa->dominical, 2)) }}</td>
                                <td class="px-4 py-2 border border-dark">{{ $tarifa->created_at }}</td>
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

                                            <button wire:click="edit({{ $tarifa->id }})"
                                                class="px-2 w-full py-1 cursor-pointer hover:bg-sky-600 hover:text-white">Editar</button>

                                            <div class="border-t border-gray-100"></div>

                                            {{-- <button wire:click="delete({{ $tarifa->id }})"
                                                class="px-2 w-full py-1 cursor-pointer hover:bg-red-600 hover:text-white">Eliminar</button> --}}

                                        </x-slot>
                                    </x-jet-dropdown>

                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <br>
                {{ $tarifas->links('livewire.custom-pagination') }}
                <br>
                <br>
            </div>
        </div>

    </div>

</div>

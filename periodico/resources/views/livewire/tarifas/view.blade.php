<div class="container mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Lista de Tarifas') }}
        </h2>
    </x-slot>

    {{-- <x-slot name="header">
		<h2 class="text-center">Laravel 9 Livewire CRUD Demo</h2>
	</x-slot> --}}
    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <div class="flex-initial mx-1 mt-4" style="width: 100%;">
                        <input wire:model='keyWord' type="text"
                            class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full"
                            name="search" id="search" placeholder="Buscar Tarifa">
                    </div>
                    <div class="flex-none mx-1">
                        <a href="{{ url('cliente') }}"><button
                                class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">{{ __('Cliente') }}</button></a>
                    </div>
                    <div class="flex-none mx-1">
                        <a href="{{ url('ruta') }}"><button
                                class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">{{ __('Ruta') }}</button></a>
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

                {{-- @if ($isModalOpen)
                    @include('livewire.tarifas.create')
                @endif --}}
                <table class="table-auto w-full text-center">
                    <thead>
                        <tr class="bg-gray-500 text-white">
                            <th class="px-4 py-2 w-20">No.</th>
                            <th class="px-4 py-2 w-20">Tipo</th>
                            <th class="px-4 py-2 w-20">Ordinario</th>
                            <th class="px-4 py-2 w-20">Dominical</th>
                            <th class="px-4 py-2 w-20">Fecha creación</th>
                            <th class="px-4 py-2 w-20">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tarifas as $tarifa)
                            <tr>
                                <td class="border">{{ $tarifa->id }}</td>
                                <td class="border">{{ $tarifa->tipo }}</td>
                                <td class="border">{{ $tarifa->ordinario }}</td>
                                <td class="border">{{ $tarifa->dominical }}</td>
                                <td class="border">{{ $tarifa->created_at }}</td>
                                <td class="border px-4 py-2 flex-nowrap pt-2">
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
                {{ $tarifas->links() }}
                <br>
                <br>
            </div>
        </div>

        <x-jet-dialog-modal wire:model="showingModal">

            <x-slot name="title">
                <div class="flex sm:px-6">
                    <h1 class="mb-3 text-2xl text-black font-bold ml-3">Datos de Tarifa</h1>
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
                <div class="px-4 mb-4" flex-grow>
                    <div class="flex">
                        <div class="w-1/2 p-2">
                            <label for="exampleFormControlInput2"
                                class="block text-black text-sm font-bold mb-2">Tipo:</label>
                            <input type="text"
                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                id="tipo" wire:model="tipo" placeholder="Escribe el tipo" />
                            @error('tipo')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="w-1/2 p-2">
                            <label for="exampleFormControlInput2"
                                class="block text-black text-sm font-bold mb-2">Ordinario:</label>
                            <input type="number"
                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                id="ordinario" wire:model="ordinario" placeholder="Ordinario" />
                            @error('ordinario')
                                <span class="text-red-500">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex">
                        <div class="w-1/2 p-2">
                            <div class="mb-4">
                                <label for="exampleFormControlInput2"
                                    class="block text-black text-sm font-bold mb-2">Dominical:</label>
                                <input type="number"
                                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    id="dominical" wire:model="dominical" placeholder="Dominical" />
                                @error('dominical')
                                    <span class="text-red-500">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex flex-row justify-end px-6 bg-gray-100 text-right">
                    <x-jet-secondary-button
                        class="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 active:bg-red-600 disabled:opacity-25 transition ml-3"
                        wire:click="$set('showingModal', false)" wire:loading.attr="disabled">
                        {{ __('Cancel') }}
                    </x-jet-secondary-button>
                </div>

                <div class="px-4 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="basis-1/4">
                        @if ($status == 'updated')
                            <button wire:click.prevent="update()" type="button"
                                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                <svg wire:loading wire:target="update" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Editar
                            </button>
                        @else
                            <button wire:click.prevent="store()" type="button"
                                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                                <svg wire:loading wire:target="store" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Crear
                            </button>
                        @endif
                    </span>
                </div>

            </x-slot>

        </x-jet-dialog-modal>

    </div>

</div>

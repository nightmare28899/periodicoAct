<div class="container mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Lista de Clientes') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <div class="flex-initial mx-1 mt-4" style="width: 100%;">
                        {{--<input wire:model='keyWord' type="text"
                            class=" text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full"
                            name="search" id="search" placeholder="Buscar Cliente">--}}
                        <input type="text"
                               class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full"
                               name="search" placeholder="Buscar Cliente por nombre o id" wire:model="query"
                               wire:keydown.escape="resetear" wire:keydown.tab="resetear"
                               wire:keydown.arrow-up="decrementHighlight" wire:keydown.arrow-down="incrementHighlight"
                               wire:keydown.enter="selectContact" autocomplete="off" />
                    </div>
                    <div class="flex-none mx-1">
                        {{-- <a href="{{ route('CrearSuscripcion') }}" class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">Generar suscripción</a> --}}
                        <button wire:click="modalSuscripciones"
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">
                            Generar Suscripción
                        </button>
                    </div>
                    <div class="flex-none mx-1">
                        {{-- <a class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700" href="{{ route('CrearVenta') }}">Generar ventas</a> --}}
                        <button wire:click="modalVentas"
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">
                            Generar Venta
                        </button>
                    </div>
                    {{-- <div class="flex-none mx-1">
                        <a href="{{ url('tarifa') }}"><button
                                class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">{{ __('Tarifa') }}</button></a>
                    </div>
                    <div class="flex-none mx-1">
                        <a href="{{ url('ruta') }}"><button
                                class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">{{ __('Ruta') }}</button></a>
                    </div> --}}
                    <div class="flex-none mx-1">
                        <button wire:click="create"
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base font-bold text-white shadow-sm hover:bg-green-700">
                            Crear Cliente
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
                    @include('livewire.clientes.create')
                @endif
                @if ($ejemplarModalOpen)
                    @include('livewire.ejemplares.create')
                @endif
                @if ($detallesModalOpen)
                    @include('livewire.clientes.detalles')
                @endif
                @if ($suscripciones)
                    @include('livewire.suscripciones.suscripciones')
                @endif
                @if ($modalDomSubs)
                    @include('livewire.modals.modal-dom-subs')
                @endif
                @if ($modalFormDom)
                    @include('livewire.modals.modal-form-subs')
                @endif
                @if ($modalV)
                    @include('livewire.modals.modal-form-venta')
                @endif
                @if ($clienteModalOpen)
                    @include('livewire.domicilios.create')
                @endif

                <div class="overflow-x-auto w-full">

                    <table class="table-auto w-full text-center">
                        <thead>
                            <tr class="bg-gray-500 text-white">
                                <th class="px-4 py-2 w-20">No.</th>
                                <th class="px-4 py-2 w-20">Clasificación</th>
                                <th class="px-4 py-2 w-20">RFC</th>
                                <th class="px-4 py-2 w-20">RFC Escrito</th>
                                <th class="px-4 py-2 w-20">Nombre</th>
                                <th class="px-4 py-2 w-20">Estado</th>
                                <th class="px-4 py-2 w-20">País</th>
                                <th class="px-4 py-2 w-20">Email</th>
                                <th class="px-4 py-2 w-20">Email Cobranza</th>
                                <th class="px-4 py-2 w-20">Teléfono</th>
                                <th class="px-4 py-2 w-20">Régimen Fiscal</th>
                                <th class="px-4 py-2 w-20">Razón Social</th>
                                <th class="px-4 py-2 w-20">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                             @if ($clientes)
                                @foreach ($clientes as $cliente)
                                    <tr>
                                        <td class="border">{{ $loop->iteration }}</td>
                                        <td class="border">{{ $cliente->clasificacion }}</td>
                                        <td class="border">{{ $cliente->rfc }}</td>
                                        <td class="border">{{ $cliente->rfc_input }}</td>
                                        <td class="border">{{ $cliente->nombre }}</td>
                                        <td class="border">{{ $cliente->estado }}</td>
                                        <td class="border">{{ $cliente->pais }}</td>
                                        <td class="border">{{ $cliente->email }}</td>
                                        <td class="border">{{ $cliente->email_cobranza }}</td>
                                        <td class="border">{{ $cliente->telefono }}</td>
                                        <td class="border">{{ $cliente->regimen_fiscal }}</td>
                                        <td class="border">{{ $cliente->razon_social }}</td>
                                        <td class="border px-4 py-2 flex-nowrap pt-2">
                                            <x-jet-dropdown align="right" width="48">
                                                <x-slot name="trigger">

                                                    <span class="inline-flex rounded-md">
                                                        <button type="button"
                                                            class="btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                            Acciones

                                                            <svg class="ml-2 -mr-0.5 h-4 w-4"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </span>
                                                </x-slot>

                                                <x-slot name="content">

                                                    {{-- <button wire:click="detalles({{ $cliente->id }})"
                                                    class="px-2 w-full py-1 cursor-pointer hover:bg-green-600 hover:text-white">Detalles</button> --}}

                                                    {{-- <div class="border-t border-gray-200"></div> --}}

                                                    <button wire:click="edit({{ $cliente->id }})"
                                                        class="px-2 w-full py-1 cursor-pointer hover:bg-sky-600 hover:text-white">Editar</button>

                                                    {{-- <div class="border-t border-gray-200"></div> --}}

                                                    {{-- <button wire:click="delete({{ $cliente->id }})"
                                                    class="px-2 w-full py-1 cursor-pointer hover:bg-red-600 hover:text-white">
                                                    <svg wire:loading wire:target="delete"
                                                        class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24">
                                                        <circle class="opacity-25" cx="12" cy="12"
                                                            r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor"
                                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                        </path>
                                                    </svg>
                                                    Eliminar
                                                </button> --}}
                                                </x-slot>
                                            </x-jet-dropdown>
                                        </td>
                                    </tr>
                                @endforeach
                             @else
                                <tr>
                                    <td colspan="13" class="border text-center">No hay registros</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <br>
                    <br>
                    {{--@if (count($clientes) > 0)
                        {{ $clientes->links() }}
                    @endif--}}
                    <br>
                    <br>
                </div>
                <br>
                <br>
                <br>
            </div>
        </div>
    </div>
</div>

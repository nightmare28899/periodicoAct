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
                        <input type="text"
                            class="text-slate-600 relative bg-white text-base shadow outline-none focus:outline-none focus:ring w-full rounded-md"
                            name="search" placeholder="Buscar Cliente por Nombre o ID" wire:model="clientesQuery"
                            autocomplete="off" />
                    </div>
                    <div class="flex-none mx-1">
                        <button wire:click="modalSuscripciones"
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">
                            <svg wire:loading wire:target="modalSuscripciones"
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Generar Suscripción
                        </button>
                    </div>
                    <div class="flex-none mx-1">
                        <button wire:click="modalVentas"
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">
                            <svg wire:loading wire:target="modalVentas"
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Generar Venta
                        </button>
                    </div>
                    <div class="flex-none mx-1">
                        <button wire:click="create"
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base font-bold text-white shadow-sm hover:bg-green-700">
                            <svg wire:loading wire:target="create"
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
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

                    <table class="table-auto border-separate border-spacing-2 border border-dark text-center">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 w-20 uppercase">ID</th>
                                <th class="px-4 py-2 w-20 uppercase">Clasificación</th>
                                <th class="px-4 py-2 w-20 uppercase">Persona</th>
                                <th class="px-4 py-2 w-20 uppercase">RFC</th>
                                <th class="px-4 py-2 w-20 uppercase">Nombre</th>
                                <th class="px-4 py-2 w-20 uppercase">Estado</th>
                                <th class="px-4 py-2 w-20 uppercase">País</th>
                                <th class="px-4 py-2 w-20 uppercase">Email</th>
                                <th class="px-4 py-2 w-20 uppercase">Email Cobranza</th>
                                <th class="px-4 py-2 w-20 uppercase">Teléfono</th>
                                <th class="px-4 py-2 w-20 uppercase">Régimen Fiscal</th>
                                <th class="px-4 py-2 w-20 uppercase">Razón Social</th>
                                <th class="px-4 py-2 w-20 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($clientes)
                                @foreach ($clientes as $cliente)
                                    <tr>
                                        <td class="px-4 py-2 border border-dark">{{ $cliente->id }}</td>
                                        <td class="px-4 py-2 border border-dark">{{ $cliente->clasificacion }}</td>
                                        <td class="px-4 py-2 border border-dark">{{ $cliente->rfc }}</td>
                                        <td class="px-4 py-2 border border-dark">{{ $cliente->rfc_input }}</td>
                                        <td class="px-4 py-2 border border-dark">{{ $cliente->nombre }}</td>
                                        <td class="px-4 py-2 border border-dark">{{ $cliente->estado }}</td>
                                        <td class="px-4 py-2 border border-dark">{{ $cliente->pais }}</td>
                                        <td class="px-4 py-2 border border-dark">{{ $cliente->email }}</td>
                                        <td class="px-4 py-2 border border-dark">{{ $cliente->email_cobranza }}</td>
                                        <td class="px-4 py-2 border border-dark">{{ $cliente->telefono }}</td>
                                        <td class="px-4 py-2 border border-dark">{{ $cliente->regimen_fiscal }}</td>
                                        <td class="px-4 py-2 border border-dark">{{ $cliente->razon_social }}</td>
                                        <td class="px-4 py-2 border border-dark flex-nowrap pt-2">
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
                                                    <button wire:click="edit({{ $cliente->id }})"
                                                        class="px-2 w-full py-1 cursor-pointer hover:bg-sky-600 hover:text-white">Editar</button>
                                                </x-slot>
                                            </x-jet-dropdown>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="13" class="border text-center font-bold">Busca Registros</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <br>
                    <br>
                    @if (count($clientes) > 0)
                        {{ $clientes->links('livewire.custom-pagination') }}
                    @endif
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

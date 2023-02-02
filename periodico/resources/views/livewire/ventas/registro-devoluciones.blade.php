<div class="container w-2/3 mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Informe Devoluciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <div>
                        <x-jet-input type="date" wire:model="desde"></x-jet-input>
                    </div>
                    <div class="ml-3">
                        <x-jet-input type="date" wire:model="hasta"></x-jet-input>
                    </div>
                    <div class="ml-3">
                        <select class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5" wire:model="rutaSeleccionada">
                            <option value="">Selecciona una ruta</option>
                            @foreach ($rutas as $ruta)
                                <option value="{{ $ruta->nombreruta }}">{{ $ruta->nombreruta }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ml-3">
                        <x-jet-input type="text" wire:model="folioDev" placeholder="Coloca el Folio"></x-jet-input>
                    </div>
                    <div class="ml-3">
                        <button wire:click="seleccionado"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full">
                            <svg wire:loading wire:target="seleccionado"
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Generar Selección
                        </button>
                    </div>
                </div>
                <div class="text-center overflow-x mt-3">
                    <div class="overflow-x-auto">
                        <table class="table-auto border-separate border-spacing-2 border border-dark w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 uppercase">Selecciona</th>
                                    <th class="px-4 py-2 uppercase">Ruta</th>
                                    <th class="px-4 py-2 uppercase">Periodo</th>
                                    <th class="px-4 py-2 uppercase">Cliente</th>
                                    <th class="px-4 py-2 uppercase">Devoluciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($devolucionVenta) > 0)
                                    @foreach ($devolucionVenta as $result)
                                        <tr>
                                            <td class="px-4 py-2 border border-dark">
                                                <input type="checkbox" wire:model.defer="seleccionados"
                                                    value="{{ $result->id }}">
                                            </td>
                                            <td class="px-4 py-2 border border-dark">{{ $result->ruta }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $result->fechaInicio }} - {{ $result->fechaFin }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $result->nombre }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                {{ $result->devoluciones }}
                                            </td>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>
        @if ($devolucionVenta)
            {{ $devolucionVenta->links('livewire.custom-pagination') }}
        @endif
    </div>

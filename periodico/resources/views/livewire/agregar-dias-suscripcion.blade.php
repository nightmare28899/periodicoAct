<div class="w-1/2 mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Agregar días al contrato') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                <p>Cambio de fecha de finalización del contrato</p>
                <div class="flex">
                    <div class="flex-initial mx-1 mt-4">
                        <p>N. Contrato</p>
                    </div>
                    <div class="flex-none mx-1">
                        <input type="text"
                            class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                            name="search" placeholder="Buscar por ID" wire:model="query" autocomplete="off" />
                    </div>
                </div>
                <div>
                    <p>Datos del contrato:</p>
                    @if (count($suscripciones) > 0)
                        <div class="flex mt-2 space-x-4 w-full">
                            <div class="px-2 w-full">
                                <b>Cliente: <input type="text" style="height: 1.7rem;"
                                        value="{{ $suscripciones[0]['nombre'] ? $suscripcionBuscada[0]['nombre'] : $suscripcionBuscada[0]['razon_social'] }}"
                                        class="border-0 w-1/2 bg-gray-200" disabled></b>
                            </div>
                        </div>
                        <div class="flex mt-2 space-x-4">
                            <div class="px-2">
                                <b>Periodo: <input type="text" style="height: 1.7rem;"
                                        value="{{ $suscripciones[0]['periodo'] }}"
                                        class="border-0 bg-gray-200 w-32" disabled>DE: <input type="text"
                                        style="height: 1.7rem;" value="{{ \Carbon\Carbon::parse($suscripciones[0]['fechaInicio'])->format('d/m/Y') }}"
                                        class="border-0 bg-gray-200 w-32" disabled>
                                    AL:
                                    <input type="text" style="height: 1.7rem;"
                                        value="{{ \Carbon\Carbon::parse($suscripciones[0]['fechaFin'])->format('d/m/Y') }}"
                                        class="border-0 w-32 bg-gray-200" disabled></b>
                            </div>
                        </div>
                        <div class="flex mt-2 space-x-4">
                            <div class="px-2">
                                <b>Ejemplares: <input type="text" style="height: 1.7rem;"
                                        value="{{ $suscripciones[0]['cantEjemplares'] }}"
                                        class="border-0 bg-gray-200" disabled></b>
                            </div>
                        </div>
                        <div class="flex mt-2 space-x-4">
                            <div class="px-2">
                                <b>Importe: <input type="text" style="height: 1.7rem;"
                                        value="{{ sprintf('$ %s', number_format($suscripciones[0]['importe'], 2)) }}"
                                        class="border-0 bg-gray-200" disabled></b>
                            </div>
                        </div>
                    @endif
                </div>
                <div>
                    <p>Indica los días a aumentar o a disminuir</p>
                    <div class="flex mt-2 space-x-4">
                        <div class="form-group">
                            <input wire:model.defer="incremento" name="rfc" type="radio" id="aumentar"
                                value="aumentar" checked>
                            <label class="text-black" for="aumentar">Aumentar días</label>
                        </div>
                        <div class="form-group">
                            <input wire:model.defer="incremento" name="rfc" type="radio" id="disminuir"
                                value="disminuir" {{ $incremento == 'disminuir' ? 'checked' : '' }}>
                            <label class="text-black" for="disminuir">Disminuir días</label>
                        </div>
                    </div>
                    <div class="flex mt-2 space-x-4">
                        <div>Días a aumentar al contrato o disminuir</div>
                        <input type="number" style="height: 1.7rem;" wire:model="dias" class="border-0 bg-gray-200">
                    </div>
                    <div class="flex mt-2 space-x-4">
                        <p>Fecha final a entrega aumentando {{ $dias ? $dias : 0 }} días <input type="text"
                                style="height: 1.7rem;" value="{{ $date ? \Carbon\Carbon::parse($date)->format('d/m/Y')  : '' }}" class="border-0 bg-gray-200" disabled></p>
                    </div>
                </div>
                <div class="flex mt-2 space-x-4">
                    <div class="px-2">
                        <button type="button" wire:click.prevent="guardar"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <svg wire:loading wire:target="guardar" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Guardar cambios
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

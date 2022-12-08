<div class="w-1/2 mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Suspender suscripción') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                <p>Suspender temporalmente un contrato</p>
                <div class="flex">
                    <div class="flex-initial mx-1 mt-4">
                        <p>N. Contrato</p>
                    </div>
                    <div class="flex-none mx-1">
                        <input type="text"
                            class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                            name="search" placeholder="Buscar" wire:model="query" autocomplete="off" />
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
                                        value="{{ $suscripciones[0]['periodo'] }}" class="border-0 bg-gray-200 w-32"
                                        disabled>DE: <input type="text" style="height: 1.7rem;"
                                        value="{{ \Carbon\Carbon::parse($suscripciones[0]['fechaInicio'])->format('d/m/Y') }}"
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
                                        value="{{ $suscripciones[0]['cantEjemplares'] }}" class="border-0 bg-gray-200"
                                        disabled></b>
                            </div>
                        </div>
                        <div class="flex mt-2 space-x-4">
                            <div class="px-2">
                                <b>Importe: <input type="text" style="height: 1.7rem;"
                                        value="{{ sprintf('$ %s', number_format($suscripciones[0]['importe'])) }}"
                                        class="border-0 bg-gray-200" disabled></b>
                            </div>
                        </div>
                        <div class="flex mt-2 space-x-4">
                            <div class="px-2">
                                <b>Fin Entrega: <input type="text" style="height: 1.7rem;"
                                        value="{{ \Carbon\Carbon::parse($suscripciones[0]['fechaFin'])->format('d/m/Y') }}"
                                        class="border-0 bg-gray-200 text-red-600" disabled></b>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="mt-5 border-2 p-2">
                    <p>Fechas para la suspensión</p>
                    <div class="flex">
                        <div class="flex mt-2 space-x-4">
                            <div class="px-2">
                                <b>DEL: <x-jet-input type="date" wire:model="del"
                                        class="w-64 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block uppercase">
                                    </x-jet-input>
                                    @error('del')
                                        <span
                                            class='text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2'>{{ 'El campo es obligatorio' }}</span></b>
                                @enderror
                            </div>
                        </div>
                        <div class="flex mt-2 space-x-4">
                            <div class="px-2">
                                <b>AL: <x-jet-input type="date" wire:model="al"
                                        class="w-64 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block uppercase">
                                    </x-jet-input>
                                    @error('al')
                                        <span
                                            class='text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2'>{{ 'El campo es obligatorio' }}</span></b>
                                @enderror
                                </b>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="flex mt-3">Reponer los dias que se suspende el contrato
                            <select
                                class="ml-3 border w-32 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block uppercase"
                                wire:model="reponerDias">
                                <option value="si">Si</option>
                                <option value="no">No</option>
                            </select>
                        </p>
                    </div>

                    <div>
                        <div class="form-group">
                            @if ($reponerDias == 'si')
                                <input wire:model="radioOptions" name="reponer" type="radio" id="reponer"
                                    value="reponer" checked>
                            @else
                                <input wire:model="radioOptions" name="reponer" type="radio" id="reponer"
                                    value="reponer" disabled>
                            @endif
                            <label class="text-black" for="reponer">Reponer al termino del periodo del contrato</label>
                        </div>
                        <div class="form-group">
                            @if ($reponerDias == 'si')
                                <input wire:model="radioOptions" name="indicar" type="radio" id="indica"
                                    value="indicar">
                            @else
                                <input wire:model="radioOptions" name="indicar" type="radio" id="indica"
                                    value="indicar" disabled>
                            @endif
                            <label class="text-black" for="indicar">Indica la fecha de reposición</label>
                        </div>
                        <p>Fecha de resposición</p>
                        <div class="flex">
                            <div class="flex mt-2 space-x-4">
                                <div class="px-2">
                                    @if ($estado == true)
                                        <x-jet-input type="date" wire:model="fechaReposicion"
                                            class="border uppercase border-gray-300 w-64">
                                        </x-jet-input>
                                        @error('fechaReposicion')
                                            <span
                                                class='text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2'>{{ 'El campo es obligatorio' }}</span></b>
                                        @enderror
                                    @else
                                        <x-jet-input type="date" wire:model="fechaReposicion"
                                            class="w-64 uppercase" disabled>
                                        </x-jet-input>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3 p-3 border-2">
                    <p>Motivo para la suspension</p>
                    <p>Escribe el motivo</p>
                    <textarea wire:model="motivo" style="margin-left: 2rem;"
                        class="border-0 bg-gray-200 @error('motivo') border-red-500 @enderror" rows="2"
                        placeholder="Coloca un motivo" cols="50"></textarea>
                    @error('motivo')
                        <span
                            class='text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2'>{{ 'El campo es obligatorio' }}</span></b>
                    @enderror
                </div>

                <div class="flex mt-2 space-x-4">
                    <div class="px-2">
                        <button type="button" wire:click.prevent="suspender"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <svg wire:loading wire:target="suspender"
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Suspender contrato
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

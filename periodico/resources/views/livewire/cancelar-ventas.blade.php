<div class="container mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ $tipo === 'suscripciones' ? __('Cancelar Suscripciones') : __('Cancelar Ventas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex mb-5">
                    <div class="w-72 mt-6">
                        <input type="text"
                            class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                            name="search" id="search" placeholder="Busca por nombre o id"
                            wire:model="clienteSeleccionado" autocomplete="off" />
                    </div>
                </div>
                <div class="text-center overflow-x">
                    <div class="overflow-x-auto">
                        <table class="table-auto border-separate border-spacing-2 border border-dark w-full uppercase">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 uppercase">Id</th>
                                    <th class="px-4 py-2 uppercase">Cliente</th>
                                    <th class="px-4 py-2 uppercase">Nombre</th>
                                    <th class="px-4 py-2 uppercase">Lunes</th>
                                    <th class="px-4 py-2 uppercase">Martes</th>
                                    <th class="px-4 py-2 uppercase">Miércoles</th>
                                    <th class="px-4 py-2 uppercase">Jueves</th>
                                    <th class="px-4 py-2 uppercase">Viernes</th>
                                    <th class="px-4 py-2 uppercase">Sábado</th>
                                    <th class="px-4 py-2 uppercase">Domingo</th>
                                    <th class="px-4 py-2 uppercase">Status</th>
                                    <th class="px-4 py-2 uppercase">Total</th>
                                    <th class="px-4 py-2 uppercase">Fecha Inicio</th>
                                    <th class="px-4 py-2 uppercase">Fecha Fin</th>
                                    <th class="px-4 py-2 w-20">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($ventas) > 0)
                                    @foreach ($ventas as $result)
                                        <tr>
                                            <td class="px-4 py-2 border border-dark">{{ $result->id }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $result->cliente_id }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $result->nombre }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $tipo == 'suscripciones' && $result->lunes != 0 ? $result->cantEjemplares : $result->lunes }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $tipo == 'suscripciones' && $result->martes != 0 ? $result->cantEjemplares : $result->martes }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $tipo == 'suscripciones' && $result->miércoles != 0 ? $result->cantEjemplares : $result->miércoles }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $tipo == 'suscripciones' && $result->jueves != 0 ? $result->cantEjemplares : $result->jueves }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $tipo == 'suscripciones' && $result->viernes != 0 ? $result->cantEjemplares : $result->viernes }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $tipo == 'suscripciones' && $result->sábado != 0 ? $result->cantEjemplares : $result->sábado }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $tipo == 'suscripciones' && $result->domingo != 0 ? $result->cantEjemplares : $result->domingo }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $tipo == 'suscripciones' && $result->estado == 'sin pagar' ? 'Activo' : $result->estado }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                {{ sprintf('$ %s', number_format($result->total, 2)) }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                {{ \Carbon\Carbon::parse($result->desde)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                {{ \Carbon\Carbon::parse($result->hasta)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                @if ($result->estado != 'Cancelada')
                                                    <button
                                                        wire:click="cancelarVenta('{{ $tipo == 'ventas' ? $result->idVenta : $result->idSuscripcion }}')"
                                                        class="px-2 py-1 cursor-pointer bg-red-500 hover:bg-red-600 text-white my-2 rounded-lg">
                                                        <svg wire:loading wire:target="cancelarVenta('{{ $tipo == 'ventas' ? $result->idVenta : $result->idSuscripcion }}')"
                                                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24">
                                                            <circle class="opacity-25" cx="12" cy="12"
                                                                r="10" stroke="currentColor" stroke-width="4">
                                                            </circle>
                                                            <path class="opacity-75" fill="currentColor"
                                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                            </path>
                                                        </svg>
                                                        {{ $tipo === 'suscripciones' ? 'Cancelar suscripción' : 'Cancelar venta' }}
                                                    </button>
                                                @else
                                                    <button
                                                        class="px-2 py-1 cursor-pointer bg-green-500 hover:bg-green-600 text-white my-2 rounded-lg">
                                                        {{ $tipo === 'suscripciones' ? 'Suscripción cancelada' : 'Venta cancelada' }}
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <br>
                {{ $ventas->links('livewire.custom-pagination') }}
            </div>
        </div>
    </div>

</div>

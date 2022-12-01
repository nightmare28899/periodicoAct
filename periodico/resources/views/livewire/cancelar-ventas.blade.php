<div class="container mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ $tipo === 'suscripciones' ? __('Historial de suscripciones') : __('Historial de ventas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex mb-5">
                    <div class="w-72 mt-6">
                        <input type="text"
                            class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                            name="search" id="search" placeholder="Buscar Cliente: nombre o id" wire:model="clienteSeleccionado"
                            autocomplete="off" />
                    </div>
                </div>
                <div class="text-center overflow-x">
                    <div class="overflow-x-auto">
                        <table class="table-auto border-separate border-spacing-2 border border-dark w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 uppercase">Id</th>
                                    <th class="px-4 py-2 uppercase">Cliente</th>
                                    <th class="px-4 py-2 uppercase">Nombre</th>
                                    <th class="px-4 py-2 uppercase">Entregar</th>
                                    <th class="px-4 py-2 uppercase">Devuelto</th>
                                    <th class="px-4 py-2 uppercase">Precio</th>
                                    <th class="px-4 py-2 uppercase">Status</th>
                                    <th class="px-4 py-2 uppercase">Total</th>
                                    <th class="px-4 py-2 uppercase">Fecha</th>
                                    <th class="px-4 py-2 w-20">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($ventas) > 0)
                                    @foreach ($ventas as $result)
                                        <tr>
                                            <td class="px-4 py-2 border border-dark">{{ $result->id }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $result->cliente_id }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $result->cliente }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $result->entregar }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $result->devuelto }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                {{ $tipo === 'suscripciones' ? $result->importe / $result->entregar : $result->importe }}
                                            </td>
                                            <td class="px-4 py-2 border border-dark">{{ $result->status }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $result->importe }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                {{ \Carbon\Carbon::parse($result->fecha)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                @if ($result->status != 'Cancelado')
                                                    <button
                                                        wire:click="canlcelarVenta('{{ $tipo === 'suscripciones' ? $result->idSuscripcion : $result->idVenta }}')"
                                                        class="px-2 py-1 cursor-pointer bg-red-500 hover:bg-red-600 text-white my-2 rounded-lg">
                                                        {{ $tipo === 'suscripciones' ? 'Cancelar suscripción' : 'Cancelar venta' }}
                                                    </button>
                                                @else
                                                    <button
                                                        class="px-2 py-1 cursor-pointer bg-green-500 hover:bg-green-600 text-white my-2 rounded-lg">
                                                        {{ $tipo === 'suscripciones' ? 'Suscripción cancelada' : 'Venta cancelada' }}
                                                    </button>
                                                    <button
                                                        wire:click="verPDF('{{ $tipo == 'ventas' ? $result->idVenta : $result->idSuscripcion }}')"
                                                        class="px-2 py-1 cursor-pointer bg-blue-500 hover:bg-blue-600 text-white my-2 rounded-lg">
                                                        {{ 'Ver PDF' }}
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
            </div>
        </div>
    </div>

</div>

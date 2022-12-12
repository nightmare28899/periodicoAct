<div class="container mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Historial de Suscripciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex-initial mx-1 mt-4 mb-3">
                    <input type="text"
                        class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-64 uppercase"
                        name="search" placeholder="Buscar por cliente" wire:model="query" autocomplete="off" />

                    <select wire:model="estatusPago"
                        class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-64 uppercase">
                        <option style="display: none;">Escoge una opcion</option>
                        <option value="Todas">Todas</option>
                        <option value="Pagado">Pagado</option>
                        <option value="facturado">Facturado</option>
                        <option value="sin pagar">Sin pagar</option>
                    </select>

                    <label for="fechaInicio">Del</label>
                    <x-jet-input type="date" wire:model="de"></x-jet-input>


                    <label for="fechaFin">Hasta</label>
                    <x-jet-input type="date" wire:model="hasta"></x-jet-input>

                </div>
                <div class="flex-initial mx-1 mt-4 mb-3">

                </div>
                <div class="text-center overflow-x">
                    <div class="overflow-x-auto w-full">
                        <table class="table-auto border-separate border-spacing-2 border border-dark uppercase">
                            <thead>
                                <tr class='bg-gray-100'>
                                    <th class='px-4 py-2 uppercase'>Contrato</th>
                                    <th class='px-4 py-2 uppercase'>Cliente</th>
                                    <th class='px-6 py-2 uppercase'>Nombre</th>
                                    <th class='px-4 py-2 uppercase'>Calle</th>
                                    <th class='px-4 py-2 uppercase'># No Int</th>
                                    <th class='px-4 py-2 uppercase'># Ext</th>
                                    <th class='px-4 py-2 uppercase'>Colonia</th>
                                    <th class='px-4 py-2 uppercase'>Ejemplares</th>
                                    <th class='px-4 py-2 uppercase'>Periodo</th>
                                    <th class='px-4 py-2 uppercase'>Estado</th>
                                    <th class='px-4 py-2 uppercase'>Fecha Inicial</th>
                                    <th class='px-6 py-2 uppercase'>Fecha Fin</th>
                                    <th class="px-6 py-2 uppercase">Pagado</th>
                                    <th class="px-6 py-2 uppercase">Fecha</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if ($suscripciones)
                                    @foreach ($suscripciones as $suscripcion)
                                        <tr>
                                            <td class='px-4 py-2 border border-dark'>{{ $suscripcion->id }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $suscripcion->cliente_id }}</td>
                                            <td class='px-4 py-2 border border-dark'>{{ $suscripcion->nombre }}</td>
                                            <td class='px-4 py-2 border border-dark'>{{ $suscripcion->calle }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $suscripcion->noint }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $suscripcion->enoxt }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $suscripcion->colonia }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $suscripcion->cantEjemplares }}
                                            </td>
                                            <td class="px-4 py-2 border border-dark">{{ $suscripcion->periodo }}</td>
                                            <td
                                                class="px-4 py-2 border border-dark text-white {{ $suscripcion->estado == 'Activo' ? 'bg-green-500' : ($suscripcion->estado == 'Suspendida' ? 'bg-red-500' : '') }}">
                                                {{ $suscripcion->estado == 'Suspendida' ? 'Inactivo' : 'Activo' }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $suscripcion->fechaInicio }}
                                            </td>
                                            <td class="px-4 py-2 border border-dark">{{ $suscripcion->fechaFin }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                {{ $suscripcion->status }}
                                            </td>
                                            <td class="px-4 py-2 border border-dark">
                                                {{ \Carbon\Carbon::parse($suscripcion->created_at)->format('Y-m-d') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                @if ($suscripcionSuspendida)
                                    @foreach ($suscripcionSuspendida as $suscripcion)
                                        <tr>
                                            <td class='px-4 py-2 border border-dark'>{{ $suscripcion->id }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $suscripcion->cliente_id }}
                                            </td>
                                            <td class='px-4 py-2 border border-dark'>{{ $suscripcion->nombre }}</td>
                                            <td class='px-4 py-2 border border-dark'>{{ $suscripcion->calle }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $suscripcion->noint }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $suscripcion->enoxt }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $suscripcion->colonia }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $suscripcion->cantEjemplares }}
                                            </td>
                                            <td class="px-4 py-2 border border-dark">{{ $suscripcion->periodo }}</td>
                                            <td class="px-4 py-2 border border-dark bg-orange-500 text-white">
                                                {{ $suscripcion->estado }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $suscripcion->fechaInicio }}
                                            </td>
                                            <td class="px-4 py-2 border border-dark">
                                                {{ \Carbon\Carbon::parse($suscripcion->fechaFin)->format('Y-m-d') }}
                                            </td>
                                            <td class="px-4 py-2 border border-dark">
                                                {{ $suscripcion->status }}
                                            </td>
                                            <td class="px-4 py-2 border border-dark">
                                                {{ \Carbon\Carbon::parse($suscripcion->created_at)->format('Y-m-d') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <p>REGISTROS: {{ count($suscripciones) + count($suscripcionSuspendida) }}</p>
            </div>
        </div>
    </div>
</div>
</div>

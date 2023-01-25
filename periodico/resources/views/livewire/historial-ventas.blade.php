<div class="container mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Historial de Ventas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex-initial mx-1 mt-4 mb-3">
                    <input type="text"
                        class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-64 uppercase"
                        name="search" placeholder="nombre o id client/contra" wire:model="query" autocomplete="off" />

                    <select wire:model="estatusPago"
                        class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-64 uppercase">
                        <option style="display: none;">Escoge una opcion</option>
                        <option value="Todas">Todas</option>
                        <option value="Activo">Activo</option>
                        {{-- <option value="sin pagar">Sin pagar</option> --}}
                        <option value="Cancelada">Cancelada</option>
                    </select>

                    <label for="fechaInicio">Del</label>
                    <x-jet-input type="date" wire:model="desde"></x-jet-input>


                    <label for="fechaFin">Hasta</label>
                    <x-jet-input type="date" wire:model="hasta"></x-jet-input>

                    <label>Ruta:</label>
                    <select
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                        style="width: 11rem;" wire:model="rutaSeleccionada">
                        <option value='Todos' selected>TODOS</option>
                        @foreach ($ruta as $rut)
                            <option value='{{ $rut['nombreruta'] }}'>
                                {{ $rut['nombreruta'] }}
                            </option>
                        @endforeach
                    </select>

                </div>

                <div class="text-center overflow-x">
                    <div class="overflow-x-auto w-full">
                        <table class="table-auto border-separate border-spacing-2 border border-dark uppercase">
                            <thead>
                                <tr class='bg-gray-100'>
                                    <th class='px-4 py-2 uppercase'>Contrato</th>
                                    <th class='px-4 py-2 uppercase'>Cliente</th>
                                    <th class='px-6 py-2 uppercase'>Nombre</th>
                                    <th class='px-6 py-2 uppercase'>Ruta</th>
                                    {{-- <th class='px-4 py-2 uppercase'>Fecha Inicio</th>
                                    <th class='px-4 py-2 uppercase'>Fecha Fin</th> --}}
                                    <th class='px-4 py-2 uppercase'>Lunes</th>
                                    <th class='px-4 py-2 uppercase'>Martes</th>
                                    <th class='px-4 py-2 uppercase'>Miércoles</th>
                                    <th class='px-4 py-2 uppercase'>Jueves</th>
                                    <th class='px-4 py-2 uppercase'>Viernes</th>
                                    <th class='px-4 py-2 uppercase'>Sábado</th>
                                    <th class='px-4 py-2 uppercase'>Domingo</th>
                                    <th class='px-4 py-2 uppercase'>Total</th>
                                    <th class='px-4 py-2 uppercase'>Estado</th>
                                </tr>
                            </thead>

                            <tbody>
                                @if ($ventas)
                                    @foreach ($ventas as $venta)
                                        <tr>
                                            <td class='px-4 py-2 border border-dark'>{{ $venta->id }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $venta->cliente_id }}</td>
                                            <td class='px-4 py-2 border border-dark'>{{ $venta->nombre }}</td>
                                            <td class='px-4 py-2 border border-dark'>{{ $venta->nombreruta }}</td>
                                            {{-- <td class="px-4 py-2 border border-dark">
                                                {{ \Carbon\Carbon::parse($venta->desde)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                {{ \Carbon\Carbon::parse($venta->hasta)->format('d/m/Y') }}</td> --}}
                                            <td class="px-4 py-2 border border-dark">{{ $venta->lunes }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $venta->martes }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $venta->miércoles }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $venta->jueves }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $venta->viernes }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $venta->sábado }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $venta->domingo }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                {{ sprintf('$ %s', number_format($venta->total, 2)) }}</td>
                                            <td
                                                class="px-4 py-2 border border-dark text-white {{ $venta->estado == 'Cancelada' ? 'bg-red-500' : ($venta->estado == 'Activo' ? 'bg-green-500' : 'bg-gray-500') }}">
                                                {{ $venta->estado }}</td>
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
</div>

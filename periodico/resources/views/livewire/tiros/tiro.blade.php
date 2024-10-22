<div class="container mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Generar Tiro') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <div class="flex-none mt-1">
                        <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                        <x-jet-input class="w-full" type="date" wire:model="from">
                        </x-jet-input>
                    </div>
                    <div class="flex-none mt-1 ml-3">
                        <label for="fecha" class="block text-sm font-medium text-gray-700">Ruta</label>
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
                    <div class="flex-initial ml-3 mx-1 mt-7" style="width: 80%;">
                        <x-jet-button class="bg-green-500 hover:bg-green-600" wire:click="regresarQuitados">
                            {{ __('Regresar quitados') }}
                        </x-jet-button>
                    </div>
                    <div class="flex-initial ml-3 mt-4" style="width: 10%;">
                        <button wire:click="descarga" wire:loading.attr="disabled"
                            class="p-2 bg-green-500 rounded-md text-white hover:bg-green-700 ">
                            <svg wire:loading wire:target="descarga" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Generar Tiro
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
                <div class="text-center overflow-x">
                    <div class="overflow-x-auto">
                        <table class="table-auto border-separate border-spacing-2 border border-dark w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 uppercase">num</th>
                                    <th class="px-4 py-2 uppercase">Ruta</th>
                                    <th class="px-4 py-2 uppercase">Día</th>
                                    <th class="px-4 py-2 uppercase">Tipo</th>
                                    <th class="px-4 py-2 uppercase">Cliente</th>
                                    <th class="px-4 py-2 uppercase">Dirección</th>
                                    <th class="px-4 py-2 uppercase">Referencia</th>
                                    <th class="px-4 py-2 uppercase">Ejemplares</th>
                                    <th class="px-4 py-2 uppercase">Fecha</th>
                                    <th class="px-4 py-2 w-20">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum_ejemplares = 0; ?>
                                <?php $ventasClientes = 0; ?>
                                <?php $contador = 1; ?>
                                @foreach ($ventas as $result)
                                    @if ($result->{$diaS} != 0 && $result->estado != 'Cancelada' && $result->tiroStatus != 'Cancelada')
                                        <tr>
                                            <td class="px-4 py-2 border border-dark">{{ $contador }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $result->nombreruta }}, Tipo:
                                                {{ $result->tiporuta }}, Repartidor: {{ $result->repartidor }},
                                                Cobrador: {{ $result->cobrador }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $diaS }} </td>
                                            <td class="px-4 py-2 border border-dark">Venta/Cliente</td>
                                            @if ($result->rfc == 'Física')
                                                <td class="px-4 py-2 border border-dark">{{ $result->nombre }}</td>
                                            @else
                                                <td class="px-4 py-2 border border-dark">{{ $result->razon_social }}
                                                </td>
                                            @endif
                                            <td class="px-4 py-2 border border-dark">Calle: {{ $result->calle }} <br>
                                                No. Ext:
                                                {{ $result->noext }}, CP: {{ $result->cp }}, <br> Localidad:
                                                {{ $result->localidad }}, Municipio: {{ $result->municipio }}
                                            </td>
                                            <td class="px-4 py-2 border border-dark">{{ $result->referencia }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $result->{$diaS} }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                {{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                <button wire:click="pausarVenta('{{ $result->idVenta }}')"
                                                    class="px-2 py-1 cursor-pointer bg-red-500 hover:bg-red-600 text-white my-2 rounded-lg">
                                                    Quitar
                                                </button>
                                            </td>
                                        </tr>
                                        <?php $sum_ejemplares += $result->{$diaS}; ?>
                                        <?php $ventasClientes = $contador; ?>
                                        <?php $contador++; ?>
                                    @else
                                        <tr>

                                        </tr>
                                    @endif
                                @endforeach

                                <?php $sum_ejemplaressus = 0; ?>
                                <?php $suscripcionesClientes = 0; ?>
                                @foreach ($suscripcion as $suscrip)
                                    @if ((/* $suscrip->{$diaS} != 0 && */ $suscrip->tiroStatus != 'Cancelada' && $suscrip->estado != 'Cancelada') /* &&
                                     $suscrip->remisionStatus === 'Remisionado' */ ||
                                        $suscrip->contrato === 'Cortesía')
                                        <tr>
                                            <td class="px-4 py-2 border border-dark">{{ $contador }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $suscrip->nombreruta }}, Tipo:
                                                {{ $suscrip->tiporuta }}, Repartidor: {{ $suscrip->repartidor }},
                                                Cobrador: {{ $suscrip->cobrador }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $diaS }} </td>
                                            <td class="px-4 py-2 border border-dark">Suscripción</td>
                                            <td class="px-4 py-2 border border-dark">{{ $suscrip->nombre }}</td>
                                            <td class="px-4 py-2 border border-dark">Calle: {{ $suscrip->calle }} <br>
                                                No. Ext:
                                                {{ $suscrip->noext }}, CP: {{ $suscrip->cp }}, <br> Localidad:
                                                {{ $suscrip->localidad }}, Ciudad: {{ $suscrip->ciudad }}
                                            </td>
                                            <td wire:model="referencia" class="px-4 py-2 border border-dark">
                                                {{ $suscrip->referencia }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                {{ $suscrip->{$diaS} != 0 ? $suscrip->cantEjemplares : 0 }}</td>
                                            <td wire:model="fecha" class="px-4 py-2 border border-dark">
                                                {{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                <button wire:click="pausarSuscripcion('{{ $suscrip->idSuscripcion }}')"
                                                    class="px-2 py-1 cursor-pointer bg-red-500 hover:bg-red-600 text-white my-2 rounded-lg">
                                                    Quitar
                                                </button>
                                            </td>
                                        </tr>
                                        <?php $sum_ejemplaressus += $suscrip->cantEjemplares; ?>
                                        <?php $suscripcionesClientes = $loop->index + 1; ?>
                                        <?php $contador++; ?>
                                    @else
                                        <tr>

                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <p class="uppercase">Total vta. periodico &nbsp;&nbsp;&nbsp; <b>#ejemp: {{ $sum_ejemplares }}
                            &nbsp;&nbsp; clientes: {{ $ventasClientes }}</b> </p>
                    <p class="uppercase">Total vta. suscripciones &nbsp;&nbsp;&nbsp; <b>#ejemp:
                            {{ $sum_ejemplaressus }} &nbsp;&nbsp; clientes: {{ $suscripcionesClientes }}</b> </p>
                    <p class="uppercase text-blue-700">Totales <b class="text-red-700">ejemplares</b>
                        {{ $sum_ejemplares + $sum_ejemplaressus }} <b class="text-red-700">clientes</b>
                        {{ $ventasClientes + $suscripcionesClientes }}</p>
                </div>
                <br>
                {{-- {{ $resultado->links() }} --}}
                <br>
            </div>
        </div>
    </div>
</div>
</div>

<div class="container w-2/3 mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Devolver venta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <table
                    class="table-auto border-separate border-spacing-2 border border-dark w-full text-center">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 w-20 uppercase">Fecha</th>
                            <th class="px-4 py-2 w-20 uppercase">Día</th>
                            <th class="px-4 py-2 w-20 uppercase">Entregados</th>
                            <th class="px-4 py-2 w-20 uppercase">Devol.</th>
                            <th class="px-4 py-2 w-20 uppercase">Restantes</th>
                            <th class="px-4 py-2 w-20 uppercase">Precio</th>
                            <th class="px-4 py-2 w-20 uppercase">Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totales = 0; ?>
                        <?php $importe = 0; ?>
                        <?php $devueltos = 0; ?>
                        <?php $cantDevolverTotales = 0; ?>
                        @foreach ($fechas as $pos => $data)
                            <tr>
                                <td class="px-4 py-2 border border-dark">{{ $data }}</td>
                                <td class="px-4 py-2 border border-dark">{{ $dias[$pos] }}
                                    <b>{{ $dias[$pos] == 'domingo' ? '(DOM)' : '(ORD)' }}</b>
                                </td>
                                <td class="px-4 py-2 border border-dark">{{ $ventas[$dias[$pos]] }}</td>
                                <td class="px-4 py-2 border border-dark flex">
                                    <input wire:model.defer="cantDevolver.{{ $pos }}.{{ $dias[$pos] }}"
                                        class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full"
                                        min="0" type="number">
                                </td>
                                <td class="px-4 py-2 border border-dark">
                                    @if (count($cantDevolver) > 0)
                                        {{ $ventas[$dias[$pos]] - $cantDevolver[$pos][$dias[$pos]] }}
                                    @endif
                                </td>
                                <td class="px-4 py-2 border border-dark">
                                    {{ $dias[$pos] == 'domingo' ? sprintf('$ %s', number_format($ventas['dominical'], 2)) : sprintf('$ %s', number_format($ventas['ordinario'], 2)) }}
                                </td>
                                <td class="px-4 py-2 border border-dark">
                                    @if (count($cantDevolver) > 0)
                                        {{ $dias[$pos] == 'domingo' ? sprintf('$ %s', number_format($ventas['dominical'] * ($ventas[$dias[$pos]] - $cantDevolver[$pos][$dias[$pos]]), 2)) : sprintf('$ %s', number_format($ventas['ordinario'] * ($ventas[$dias[$pos]] - $cantDevolver[$pos][$dias[$pos]]), 2)) }}
                                    @else
                                        {{ $dias[$pos] == 'domingo' ? sprintf('$ %s', number_format($ventas['dominical'] * $ventas[$dias[$pos]], 2)) : sprintf('$ %s', number_format($ventas['ordinario'] * $ventas[$dias[$pos]], 2)) }}
                                    @endif
                                </td>
                            </tr>
                            <?php $totales += $ventas[$dias[$pos]]; ?>

                            @if (count($cantDevolver) > 0)
                                <?php $calculoImporte = $cantDevolverTotales += $dias[$pos] == 'domingo' ? $ventas['dominical'] * ($ventas[$dias[$pos]] - $cantDevolver[$pos][$dias[$pos]]) : $ventas['ordinario'] * ($ventas[$dias[$pos]] - $cantDevolver[$pos][$dias[$pos]]); ?>
                            @endif

                            <?php $importe += $dias[$pos] == 'domingo' ? $ventas['dominical'] * $ventas[$dias[$pos]] : $ventas['ordinario'] * $ventas[$dias[$pos]]; ?>
                            @if (count($cantDevolver) > 0)
                                <?php $devueltos += $cantDevolver[$pos][$dias[$pos]]; ?>
                            @endif
                        @endforeach
                        <tr>
                            <td class="px-4 py-2 border border-dark">TOTALES</td>
                            <td class="px-4 py-2 border border-dark"></td>
                            <td class="px-4 py-2 border border-dark">{{ $totales }}</td>
                            <td class="px-4 py-2 border border-dark"> {{ $devueltos }}</td>
                            <td class="px-4 py-2 border border-dark"></td>
                            <td class="px-4 py-2 border border-dark">IMPORTE</td>
                            <td class="px-4 py-2 border border-dark">
                                @if (count($cantDevolver) > 0)
                                    {{ sprintf('$ %s', number_format($cantDevolverTotales, 2)) }}
                                    <input name="invisible" id="invisible" type="hidden" value="{{ $cantDevolverTotales }}">
                                @else
                                    {{ sprintf('$ %s', number_format($importe, 2)) }}
                                @endif
                            </td>
                        </tr>

                        <td class="px-4 py-2 border border-dark"></td>
                        <td class="px-4 py-2 border border-dark"></td>
                        <td class="px-4 py-2 border border-dark"></td>
                        <td class="px-4 py-2 border border-dark"></td>
                        <td class="px-4 py-2 border border-dark"></td>
                        <td class="px-4 py-2 border border-dark">
                            <div class="mb-3">
                                <button wire:click="calcular"
                                    class="btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-500 focus:outline-none transition">
                                    <svg wire:loading wire:target="calcular"
                                        class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4">
                                        </circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Calcular</button>
                            </div>

                            <button wire:click="confirmar({{ $cantDevolverTotales }})"
                                class="btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-500 focus:outline-none transition">
                                <svg wire:loading wire:target="devolver"
                                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4">
                                    </circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Devolver</button>
                        </td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- i need to create a modal --}}
    <x-jet-dialog-modal wire:model="modalConfirmar">
        <x-slot name="title">
            <div class="flex sm:px-6">
                <h1 class="mb-3 text-2xl text-black font-bold ml-3"></h1>
                <button type="button" wire:click="$set('modalConfirmar', false)" wire:loading.attr="disabled"
                    class="mb-3 text-gray-400 bg-transparent hover:bg-red-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-red-600 dark:hover:text-white"
                    data-modal-toggle="defaultModal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <hr>
        </x-slot>
        <x-slot name="content">
            <div class="text-center">
                <h2><b>¿Estás seguro de que deseas hacer la devolución ?</b></h2>
                <div class="flex justify-center mt-5">
                    <div class="space-between">
                        <button
                            class="btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-500 focus:outline-none transition"
                            wire:click="$set('modalConfirmar', false)">
                            Cancelar</button>
                        <button wire:click="confirmar"
                            class="btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-500 focus:outline-none transition">
                            Confirmar</button>
                    </div>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
        </x-slot>
        </x-jet-dialog-model>


</div>

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
                    class="table-auto border-separate border-spacing-2 border border-dark w-full text-center uppercase">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 w-20 uppercase">Fecha</th>
                            <th class="px-4 py-2 w-20 uppercase">Día</th>
                            <th class="px-4 py-2 w-20 uppercase">Entregados</th>
                            <th class="px-4 py-2 w-20 uppercase">Devol.</th>
                            <th class="px-4 py-2 w-20 uppercase">Falt.</th>
                            <th class="px-4 py-2 w-20 uppercase">Precio</th>
                            <th class="px-4 py-2 w-20 uppercase">Importe</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totales = 0; ?>
                        <?php $importe = 0; ?>
                        @foreach ($fechas as $pos => $data)
                            <tr>
                                <td class="px-4 py-2 border border-dark">{{ $data }}</td>
                                <td class="px-4 py-2 border border-dark">{{ $dias[$pos] }}
                                    <b>{{ $dias[$pos] == 'domingo' ? '(DOM)' : '(ORD)' }}</b>
                                </td>
                                <td class="px-4 py-2 border border-dark">{{ $ventas[$dias[$pos]] }}</td>
                                <td class="px-4 py-2 border border-dark">
                                    <x-jet-input min="0" type="number" placeholder="Coloca la cantidad">
                                    </x-jet-input>
                                </td>
                                <td class="px-4 py-2 border border-dark"></td>
                                <td class="px-4 py-2 border border-dark">
                                    {{ $dias[$pos] == 'domingo' ? sprintf('$ %s', number_format($ventas['dominical'], 2)) : sprintf('$ %s', number_format($ventas['ordinario'], 2)) }}
                                </td>
                                <td class="px-4 py-2 border border-dark">
                                    {{ $dias[$pos] == 'domingo' ? sprintf('$ %s', number_format($ventas['dominical'] * $ventas[$dias[$pos]], 2)) : sprintf('$ %s', number_format($ventas['ordinario'] * $ventas[$dias[$pos]], 2)) }}
                                </td>
                            </tr>
                            <?php $totales += $ventas[$dias[$pos]]; ?>
                            <?php $importe += $dias[$pos] == 'domingo' ? $ventas['dominical'] * $ventas[$dias[$pos]] : $ventas['ordinario'] * $ventas[$dias[$pos]]; ?>
                        @endforeach
                        <tr>
                            <td class="px-4 py-2 border border-dark">TOTALES</td>
                            <td class="px-4 py-2 border border-dark"></td>
                            <td class="px-4 py-2 border border-dark">{{ $totales }}</td>
                            <td class="px-4 py-2 border border-dark"></td>
                            <td class="px-4 py-2 border border-dark"></td>
                            <td class="px-4 py-2 border border-dark">IMPORTE</td>
                            <td class="px-4 py-2 border border-dark">{{ sprintf('$ %s', number_format($importe, 2)) }}
                            </td>
                        </tr>
                        <td>
                        <td class="px-4 py-2 border border-dark"></td>
                        <td class="px-4 py-2 border border-dark"></td>
                        <td class="px-4 py-2 border border-dark"></td>
                        <td class="px-4 py-2 border border-dark"></td>
                        <td class="px-4 py-2 border border-dark"></td>
                        <td class="px-4 py-2 border border-dark">
                            <button
                                class="btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-500 hover:text-gray-700 focus:outline-none transition">Devolver</button>
                        </td>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="w-4/6 mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Reporte relación cliente ruta') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex mb-5">
                    <div class="w-1/2">
                        <h4>Ruta:</h4>
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
                    <div class="w-1/2">
                        <button wire:click="generarPDF" wire:loading.attr="disabled"
                            class="p-2 bg-green-500 rounded-md text-white hover:bg-green-700 float-right">
                            <svg wire:loading wire:target="generarPDF"
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Generar PDF
                        </button>
                    </div>
                </div>

                <p>HORA: {{ $time }}</p>
                <h3 class="text-center font-bold">LA VOZ DE MICHOACAN S.A. DE C.V.</h3>
                <h3 class="font-bold">RELACION DE CLIENTES POR RUTA: {{ $rutaSeleccionada }} </h3>
                <h3>MORELIA, MICHOACAN {{ $diaS }} {{ $date }}</h3>

                <div class="mx-auto text-center">
                    <table class="table-auto border-separate border-spacing-2 border border-dark">
                        <thead>
                            <tr class='bg-gray-100'>
                                <th class='px-4 py-2 uppercase'>CLAVE</th>
                                <th class='px-4 py-2 uppercase'>CLIENTE</th>
                                <th class='px-4 py-2 uppercase'>POBLACION</th>
                                <th class='px-4 py-2 uppercase'>REF. DE ENTREGA</th>
                                <th class='px-4 py-2 uppercase'>L</th>
                                <th class='px-4 py-2 uppercase'>M</th>
                                <th class='px-4 py-2 uppercase'>M</th>
                                <th class='px-4 py-2 uppercase'>J</th>
                                <th class='px-4 py-2 uppercase'>V</th>
                                <th class='px-4 py-2 uppercase'>S</th>
                                <th class='px-4 py-2 uppercase'>D</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sum_lunes = 0; ?>
                            <?php $sum_martes = 0; ?>
                            <?php $sum_miercoles = 0; ?>
                            <?php $sum_jueves = 0; ?>
                            <?php $sum_viernes = 0; ?>
                            <?php $sum_sabado = 0; ?>
                            <?php $sum_domingo = 0; ?>
                            @foreach ($ventas as $result)
                                <tr>
                                    <td class='px-4 py-2 border border-dark'>
                                        {{ $result['id'] }}
                                    </td>
                                    <td class='px-4 py-2 border border-dark'>
                                        {{ $result['nombre'] }}
                                    </td>
                                    <td class='px-4 py-2 border border-dark'>{{ $result['localidad'] }}</td>
                                    <td class='px-4 py-2 border border-dark'>
                                        {{ $result['referencia'] }}
                                    </td>
                                    <td class='px-4 py-2 border border-dark'>{{ $result->lunes }}</td>
                                    <td class='px-4 py-2 border border-dark'>{{ $result->martes }}</td>
                                    <td class='px-4 py-2 border border-dark'>{{ $result->miércoles }}</td>
                                    <td class='px-4 py-2 border border-dark'>{{ $result->jueves }}</td>
                                    <td class='px-4 py-2 border border-dark'>{{ $result->viernes }}</td>
                                    <td class='px-4 py-2 border border-dark'>{{ $result->sábado }}</td>
                                    <td class='px-4 py-2 border border-dark'>{{ $result->domingo }}</td>
                                </tr>
                                <?php $sum_lunes += $result->lunes; ?>
                                <?php $sum_martes += $result->martes; ?>
                                <?php $sum_miercoles += $result->miércoles; ?>
                                <?php $sum_jueves += $result->jueves; ?>
                                <?php $sum_viernes += $result->viernes; ?>
                                <?php $sum_sabado += $result->sábado; ?>
                                <?php $sum_domingo += $result->domingo; ?>
                            @endforeach
                            @foreach ($suscripciones as $susc)
                                <tr>
                                    <td class='px-4 py-2 border border-dark'>
                                        {{ $susc['id'] }}
                                    </td>
                                    <td class='px-4 py-2 border border-dark'>
                                        {{ $susc['nombre'] }}
                                    </td>
                                    <td class='px-4 py-2 border border-dark'>{{ $susc['localidad'] }}</td>
                                    <td class='px-4 py-2 border border-dark'>
                                        {{ $susc['referencia'] }}
                                    </td>
                                    <td class='px-4 py-2 border border-dark'>{{ $susc->lunes == 1 ? $susc->cantEjemplares : 0 }}</td>
                                    <td class='px-4 py-2 border border-dark'>{{ $susc->martes == 1 ? $susc->cantEjemplares : 0 }}</td>
                                    <td class='px-4 py-2 border border-dark'>{{ $susc->miércoles == 1 ? $susc->cantEjemplares : 0 }}</td>
                                    <td class='px-4 py-2 border border-dark'>{{ $susc->jueves == 1 ? $susc->cantEjemplares : 0 }}</td>
                                    <td class='px-4 py-2 border border-dark'>{{ $susc->viernes == 1 ? $susc->cantEjemplares : 0 }}</td>
                                    <td class='px-4 py-2 border border-dark'>{{ $susc->sábado == 1 ? $susc->cantEjemplares : 0 }}</td>
                                    <td class='px-4 py-2 border border-dark'>{{ $susc->domingo == 1 ? $susc->cantEjemplares : 0 }}</td>
                                </tr>
                                <?php $sum_lunes += $susc->lunes == 1 ? $susc->cantEjemplares : 0; ?>
                                <?php $sum_martes += $susc->martes == 1 ? $susc->cantEjemplares : 0; ?>
                                <?php $sum_miercoles += $susc->miércoles == 1 ? $susc->cantEjemplares : 0; ?>
                                <?php $sum_jueves += $susc->jueves == 1 ? $susc->cantEjemplares : 0; ?>
                                <?php $sum_viernes += $susc->viernes == 1 ? $susc->cantEjemplares : 0; ?>
                                <?php $sum_sabado += $susc->sábado == 1 ? $susc->cantEjemplares : 0; ?>
                                <?php $sum_domingo += $susc->domingo == 1 ? $susc->cantEjemplares : 0; ?>
                            @endforeach
                        </tbody>
                        <thead>
                            <tr>
                                <th class='px-4 py-2 uppercase'>{{ count($ventas) + count($suscripciones) }}</th>
                                <th class='px-4 py-2 uppercase'>Totales</th>
                                <th class='px-4 py-2 uppercase'></th>
                                <th class='px-4 py-2 uppercase'></th>
                                <th class='px-4 py-2 uppercase'>{{ $sum_lunes }}</th>
                                <th class='px-4 py-2 uppercase'>{{ $sum_martes }}</th>
                                <th class='px-4 py-2 uppercase'>{{ $sum_miercoles }}</th>
                                <th class='px-4 py-2 uppercase'>{{ $sum_jueves }}</th>
                                <th class='px-4 py-2 uppercase'>{{ $sum_viernes }}</th>
                                <th class='px-4 py-2 uppercase'>{{ $sum_sabado }}</th>
                                <th class='px-4 py-2 uppercase'>{{ $sum_domingo }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>

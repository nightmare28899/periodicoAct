<div>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }
    </style>
    {{-- In work, do what you enjoy. --}}
    <div class="mx-auto mt-3">
        <table class="table-auto border-separate border-spacing-2 border border-dark text-center uppercase" style="width: 100%; text-align: center;">
            <thead>
                <tr class='bg-gray-100'>
                    <th class='px-4 py-2 uppercase'>No. contrato</th>
                    <th class='px-4 py-2 uppercase'>cliente</th>
                    <th class='px-4 py-2 uppercase'>nombre</th>
                    <th class='px-4 py-2 uppercase'>fecha vencimiento</th>
                    <th class='px-4 py-2 uppercase'>Periodo</th>
                    <th class='px-4 py-2 uppercase'>ejemplar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($suscripcion as $susc)
                    <tr>
                        <td class='px-4 py-2 border border-dark'>
                            {{ $susc['id'] }}
                        </td>
                        <td class='px-4 py-2 border border-dark'>
                            {{ $susc['cliente_id'] }}
                        </td>
                        <td class='px-4 py-2 border border-dark'>{{ $susc['nombre'] }}</td>
                        <td class='px-4 py-2 border border-dark'>
                            {{ \Carbon\Carbon::parse($susc['fechaFin'])->format('d/m/Y') }}
                        </td>
                        <td class='px-4 py-2 border border-dark'>
                            {{ $susc['periodo'] }}
                        </td>
                        <td class='px-4 py-2 border border-dark'>
                            {{ $susc['cantEjemplares'] }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="uppercase font-bold">Total de contratos: {{ count($suscripcion) }}</p>
    </div>
</div>

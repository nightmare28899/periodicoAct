<style>
    table,
    th,
        {
        border: 1px solid;
        padding: 4px 6px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    .centrado {
        text-align: center;
    }

    #movido {
        position: absolute;
        left: 1320px;
        margin-top: -45px;
    }
</style>
<p>HORA: {{ $time }}</p>
<h3 class="centrado">LA VOZ DE MICHOACAN S.A. DE C.V.</h3>
<h3>RELACION DE CLIENTES POR RUTA: {{ $ruta }} </h3>
<h3>MORELIA, MICHOACÁN {{ $diaS }} {{ $date }}</h3>

<table class="centrado" style="text-transform: uppercase;">
    <thead>
        <tr>
            <th>CLAVE</th>
            <th>CLIENTE</th>
            <th>POBLACION</th>
            <th>REF. DE ENTREGA</th>
            <th>L</th>
            <th>M</th>
            <th>M</th>
            <th>J</th>
            <th>V</th>
            <th>S</th>
            <th>D</th>
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
                <td>
                    {{ $result['id'] }}
                </td>
                <td>
                    {{ $result['nombre'] }}
                </td>
                <td>{{ $result['localidad'] }}</td>
                <td>
                    {{ $result['referencia'] }}
                </td>
                <td>{{ $result->lunes }}</td>
                <td>{{ $result->martes }}</td>
                <td>{{ $result->miércoles }}</td>
                <td>{{ $result->jueves }}</td>
                <td>{{ $result->viernes }}</td>
                <td>{{ $result->sábado }}</td>
                <td>{{ $result->domingo }}</td>
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
            <th>{{ count($ventas) + count($suscripciones) }}</th>
            <th>Totales</th>
            <th></th>
            <th></th>
            <th>{{ $sum_lunes }}</th>
            <th>{{ $sum_martes }}</th>
            <th>{{ $sum_miercoles }}</th>
            <th>{{ $sum_jueves }}</th>
            <th>{{ $sum_viernes }}</th>
            <th>{{ $sum_sabado }}</th>
            <th>{{ $sum_domingo }}</th>
        </tr>
    </thead>
</table>

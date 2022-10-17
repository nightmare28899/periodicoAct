<style>
    table,
    tr,
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
<h3>MORELIA, MICHOACAN {{ $diaS }} {{ $date }}</h3>

<table class="centrado">
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
        @endforeach
    </tbody>
</table>

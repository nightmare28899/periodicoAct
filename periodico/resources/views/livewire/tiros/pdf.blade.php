<style>
    table,
    td,
    th {
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
<h3>Lista del Tiro, del
    dia: {{ $diaS }}</h3>
    @if($filtro != '')
        @if(count($ventas) > 0)
            <h3>De la ruta: {{$ventas[0]['nombreruta']}} </h3>
        @elseif (count($suscripcion) > 0)
            <h3>De la ruta: {{$suscripcion[0]['nombreruta']}}</h3>
        @endif
    @endif
<h3 id="movido">Fecha: {{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</h3>
<table class="a centrado">
    <thead>
    <tr class="bg-gray-500 text-white">
        <th>Ruta</th>
        <th>Día</th>
        <th>Tipo</th>
        <th>Cliente</th>
        <th>Dirección</th>
        <th>Referencia</th>
        <th>Ejemplares</th>
        <th>Fecha</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($ventas as $result)
        @if ($result->{$diaS} != 0)
            <tr>
                <td>{{ $result->nombreruta }}, Tipo: {{ $result->tiporuta }}, Repartidor: {{ $result->repartidor }},
                    Cobrador: {{ $result->cobrador }}</td>
                <td>{{ $diaS }} </td>
                <td>Venta/Cliente</td>
                @if ($result->nombre)
                    <td class="border">{{ $result->nombre }}</td>
                @else
                    <td class="border">{{ $result->razon_social }}</td>
                @endif
                <td>Calle: {{ $result->calle }}
                    <br>
                    No. Ext:
                    {{ $result->noext }}, CP: {{ $result->cp }}, <br> Localidad:
                    {{ $result->localidad }}, Municipio: {{ $result->municipio }}
                </td>
                <td>{{ $result->referencia }}</td>
                <td>{{ $result->{$diaS} }}</td>
                <td>{{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</td>
            </tr>
        @endif
    @endforeach
    @foreach ($suscripcion as $suscri)
        @if ($suscri->{$diaS} != 0)
            <tr>
                <td class="border">{{ $suscri->nombreruta }}, Tipo: {{ $suscri->tiporuta }},
                    Repartidor: {{ $suscri->repartidor }}, Cobrador: {{ $suscri->cobrador }}</td>
                <td class="border">{{ $diaS }} </td>
                <td>Suscripción</td>
                <td class="border">{{ $suscri->nombre }}</td>
                <td class="border">Calle: {{ $suscri->calle }} <br>
                    No. Ext:
                    {{ $suscri->noext }}, CP: {{ $suscri->cp }}, <br> Localidad:
                    {{ $suscri->localidad }}, Ciudad: {{ $suscri->ciudad }}
                </td>
                <td wire:model="referencia" class="border">{{ $suscri->referencia }}</td>
                <td class="border">{{ $suscri->{$diaS} != 0 ? $suscri->cantEjemplares : 0 }}</td>
                <td>{{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</td>
            </tr>
        @endif
    @endforeach
    </tbody>
</table>

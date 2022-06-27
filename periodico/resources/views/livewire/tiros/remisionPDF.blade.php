<style>
    .a {
        border-collapse: separate;
    }

    .b {
        border-collapse: collapse;
    }

    tr,
    td,
    th {
        border: 1px solid grey;
    }

    .centrado {
        text-align: center;
    }

    #movido {
        position: absolute;
        left: 460px;
        margin-top: -7px;
    }
    #movido2 {
        position: absolute;
        left: 460px;
        margin-top: -40px;
    }
</style>
<h5 style="padding-top: -12; margin-top: -12;">LA VOZ DE MICHOACAN S.A. DE C.V. Av Periodismo José Tocavén Lavín 1270
    Col. Agustín Arriaga Rivera.</h5>
<h5 style="padding-top: -12; margin-top: -12;">C.P. 58190, Morelia Michoacán, México Tel: (443) 322 56 00 Fax Ext. 1038
</h5>
<h5 style="padding-top: -12; margin-top: -12;">RFC: VMI-600516-JG7, REG. EDO. 124026-9.</h5>
<h3 style="background-color: rgb(187, 230, 238); padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;">remisionado de suscripciones
</h3>
<p id="movido"><b>RUTA</b>
    @foreach ($resultado as $result)
        {{ $result->nombreruta }}
</p>
<h3 style="background-color: rgb(187, 230, 238); text-transform: uppercase;" class="padding-top: -52; margin-top: -52;">remision
    
        {{ $result->id }}
</h3>
<p id="movido2" style="text-transform: uppercase;"><b>fecha</b> {{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</p>
<p class="text-transform: uppercase;"><b>cliente</b> {{ $result->nombre }}</p>
<p class="text-transform: uppercase;"><b>rfc</b> {{ $result->rfc }}</p>
<p class="text-transform: uppercase;"><b>calle</b> {{ $result->calle }}</p>
<p class="text-transform: uppercase;"><b>colonia</b> {{ $result->colonia }}</p>
<p class="text-transform: uppercase;"><b>municipio</b> {{ $result->municipio }}</p>
<p class="text-transform: uppercase;"><b>estado</b> {{ $result->estado }}</p>
<p class="text-transform: uppercase;"><b>num. ext</b> {{ $result->noext }}</p>
<p class="text-transform: uppercase;"><b>num. int</b> {{ $result->noint }}</p>
<p class="text-transform: uppercase;"><b>c.p.</b> {{ $result->cp }}</p>
<p class="text-transform: uppercase;"><b>pais</b> {{ $result->pais }}</p>
@endforeach
<table class="table-auto">
    <thead>
        <tr class='bg-gray-100'>
            <th class='px-4 py-2'>Fecha</th>
            <th class='px-4 py-2'>Entregar</th>
            <th class='px-4 py-2'>Devuelto</th>
            <th class='px-4 py-2'>Faltante</th>
            <th class='px-4 py-2'>Venta</th>
            <th class='px-4 py-2'>Precio</th>
            <th class='px-4 py-2'>Importe</th>
            <th class='px-6 py-2'>Dia</th>
            <th class='px-6 py-2'>Nombre Ruta</th>
            <th class='px-6 py-2'>Tipo</th>
        </tr>
    </thead>
    <tbody class="centrado">
        @foreach ($resultado as $result)
            <tr>
                <td>
                    <div class="form-group">
                        <label class="text-black"
                            for="Física">{{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</label>
                    </div>
                </td>
                <td>{{ $result->{$diaS} }}</td>
                <td>0</td>
                <td>0</td>
                <td>{{ $result->{$diaS} }}</td>
                <td>{{ $diaS == 'domingo' ? $result->dominical : $result->ordinario }}
                </td>
                <td>{{ ($diaS == 'domingo' ? $result->dominical : $result->ordinario) * $result->{$diaS} }}
                </td>
                <td>{{ $diaS }}</td>
                <td>{{ $result->nombreruta }}</td>
                <td>{{ $result->tiporuta }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

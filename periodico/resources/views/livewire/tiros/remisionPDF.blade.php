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
</style>
<h5 style="padding-top: -12; margin-top: -12;">LA VOZ DE MICHOACAN S.A. DE C.V. Av Periodismo José Tocavén Lavín 1270 Col. Agustín Arriaga Rivera.</h5>
<h5 style="padding-top: -12; margin-top: -12;">C.P. 58190, Morelia Michoacán, México Tel: (443) 322 56 00 Fax Ext. 1038</h5>
<h5 style="padding-top: -12; margin-top: -12;">RFC: VMI-600516-JG7, REG. EDO. 124026-9.</h5>
<h3 style="margin-right: 25px; padding-top: -12; margin-top: -12; background-color: rgb(144, 144, 240);">REMISIONADO DEL TIRO</h3>
<h3 style="font-weight: bold;">RUTA @foreach ($resultado as $result){{ $result->nombreruta }} @endforeach</h3>
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
    <tbody>
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

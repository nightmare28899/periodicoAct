<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        /* .a {
            border-collapse: separate;
        }

        .b {
            border-collapse: collapse;
        } */

        /* tr,
        td,
        th {
            border: 1px solid grey;
        } */

        .centrado {
            text-align: center;
        }

        #movido {
            position: absolute;
            left: 460px;
            margin-top: -6px;
        }

        #movido2 {
            position: absolute;
            left: 460px;
            margin-top: -4px;
        }

        #movido3 {
            position: absolute;
            left: 460px;
            margin-top: 0px;
        }

        #movido4 {
            position: absolute;
            left: 460px;
            margin-top: 0px;
        }

        #movido5 {
            position: absolute;
            left: 460px;
            margin-top: 0px;
        }

        #movido6 {
            position: absolute;
            left: 460px;
            margin-top: 0px;
        }

        #movido7 {
            position: absolute;
            left: 460px;
            margin-top: 0px;
        }
    </style>
</head>

<body>
    <div style="margin-bottom: 1px; background-color:rgba(31,113,186,255); height: 40px;">
        <img src="img/logo.jpe" alt="logo la voz" height="36px">
    </div>
    <br>
    <h5 style="padding-top: -12; margin-top: -12;">LA VOZ DE MICHOACAN S.A. DE C.V. Av Periodismo José Tocavén Lavín 1270
        Col. Agustín Arriaga Rivera.</h5>
    <h5 style="padding-top: -12; margin-top: -12;">C.P. 58190, Morelia Michoacán, México Tel: (443) 322 56 00 Fax Ext.
        1038
    </h5>
    <h5 style="padding-top: -12; margin-top: -12; margin-bottom: -12;">RFC: VMI-600516-JG7, REG. EDO. 124026-9.</h5>
    <h3
        style="background-color: rgb(187, 230, 238); padding-bottom: -10; margin-bottom: -10; text-transform: uppercase; font-size: 16px;">
        remisionado de clientes
    </h3>
    <p id="movido" style="font-size: 16px;"><b>RUTA</b>
        @foreach ($resultado as $result)
            {{ $result->nombreruta }}
    </p>
    <h3
        style="background-color: rgb(187, 230, 238); text-transform: uppercase; padding-bottom: -12; margin-bottom: -12; font-size: 16px;">
        remision
        {{ $result->id }}
    </h3>
    <p id="movido2" style="text-transform: uppercase; font-size: 16px;"><b>fecha</b>
        {{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</p>
    <p style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>cliente</b>
        {{ $result->nombre }}</p>
    <p id="movido3" style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>rfc</b>
        {{ $result->rfc }}</p>
    <p style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>calle</b>
        {{ $result->calle }}</p>
    <p id="movido4" style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>colonia</b>
        {{ $result->colonia }}</p>
    <p style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>municipio</b>
        {{ $result->municipio }}</p>
    <p id="movido5" style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>estado</b>
        {{ $result->estado }}</p>
    <p style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>num. ext</b>
        {{ $result->noext }}</p>
    <p id="movido6" style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>num. int</b>
        {{ $result->noint }}</p>
    <p style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>c.p.</b>
        {{ $result->cp }}</p>
    <p id="movido7" style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>pais</b>
        {{ $result->pais }}</p>
    <div style="padding-top: 8px;">
        <p
            style="text-transform: uppercase; border: 1px solid black; text-align: center; padding-bottom: -1; margin-bottom: -1;">
            concepto</p>
    </div>
    <table>
        <thead style="text-transform: uppercase; background-color: rgb(187, 230, 238);">
            <tr>
                <th class='px-4 py-2' style="width: 140px; font-size: 14px;">cant.</th>
                <th class='px-4 py-2' style="width: 266px; font-size: 14px;">concepto</th>
                <th class='px-4 py-2' style="width: 140px; font-size: 14px;">val. unitario</th>
                <th class='px-4 py-2' style="width: 140px; font-size: 14px;">importe</th>
            </tr>
        </thead>
        <tbody class="centrado">
            <tr>
                <td>{{ $result->{$diaS} }}</td>
                <td>
                    <div class="form-group">
                        <label class="text-black" for="Física"> Periodo:
                            {{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}, Ejemplares:
                            {{ $result->{$diaS} }} </label>
                    </div>
                </td>
                <td>{{ $diaS == 'domingo' ? $result->dominical : $result->ordinario }}</td>
                <td>{{ ($diaS == 'domingo' ? $result->dominical : $result->ordinario) * $result->{$diaS} }}</td>
            </tr>
        </tbody>
    </table>
    <hr>
    <table>
        <tbody class="centrado">
            <tr>
                <td></td>
                <td></td>
                <td>IMPORTE</td>
                <td>{{ ($diaS == 'domingo' ? $result->dominical : $result->ordinario) * $result->{$diaS} }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>DESCUENTO</td>
                <td>0</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>SUBTOTAL</td>
                <td>{{ ($diaS == 'domingo' ? $result->dominical : $result->ordinario) * $result->{$diaS} }}</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>IVA</td>
                <td>0</td>
            </tr>
        </tbody>
        <thead>
            <tr style="text-transform: uppercase; background-color: rgb(187, 230, 238);">
                <th class='px-4 py-2' style="width: 140px; font-size: 14px;">totales</th>
                <th class='px-4 py-2' style="width: 266px; font-size: 14px;">{{ $result->{$diaS} }}</th>
                <th class='px-4 py-2' style="width: 140px; font-size: 14px;">neto</th>
                <th class='px-4 py-2' style="width: 140px; font-size: 14px;">{{ ($diaS == 'domingo' ? $result->dominical : $result->ordinario) * $result->{$diaS} }}</th>
            </tr>
        </thead>
    </table>
    @endforeach
</body>

</html>

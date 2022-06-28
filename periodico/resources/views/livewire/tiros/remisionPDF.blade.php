<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .a {
            border-collapse: separate;
        }

        .b {
            border-collapse: collapse;
        }

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
            margin-top: -7px;
        }

        #movido2 {
            position: absolute;
            left: 460px;
            margin-top: -5px;
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
    <h5 style="padding-top: -12; margin-top: -12;">LA VOZ DE MICHOACAN S.A. DE C.V. Av Periodismo José Tocavén Lavín 1270
        Col. Agustín Arriaga Rivera.</h5>
    <h5 style="padding-top: -12; margin-top: -12;">C.P. 58190, Morelia Michoacán, México Tel: (443) 322 56 00 Fax Ext.
        1038
    </h5>
    <h5 style="padding-top: -12; margin-top: -12; margin-bottom: -12;">RFC: VMI-600516-JG7, REG. EDO. 124026-9.</h5>
    <h3
        style="background-color: rgb(187, 230, 238); padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;">
        remisionado de clientes
    </h3>
    <p id="movido"><b>RUTA</b>
        @foreach ($resultado as $result)
            {{ $result->nombreruta }}
    </p>
    <h3
        style="background-color: rgb(187, 230, 238); text-transform: uppercase; padding-bottom: -12; margin-bottom: -12;">
        remision
        {{ $result->id }}
    </h3>
    <p id="movido2" style="text-transform: uppercase;"><b>fecha</b>
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
        <thead>
            <tr style="text-transform: uppercase; background-color: rgb(187, 230, 238);">
                <th class='px-4 py-2' style="width: 100%;">cant.</th>
                <th class='px-4 py-2' style="width: 440px;">concepto</th>
                <th class='px-4 py-2' style="width: 100%;">val. unitario</th>
                <th class='px-4 py-2' style="width: 100%;">importe</th>
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
            @endforeach
        </tbody>
    </table>
    <hr>

</body>

</html>

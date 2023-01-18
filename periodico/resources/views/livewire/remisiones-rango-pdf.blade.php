<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-size: 14.5px;
        }

        .page-break {
            page-break-after: always;
        }

        header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
        }

        th,
        td {
            border: .3px solid gray;
        }

        .centrado {
            text-align: center;
        }

        #movido {
            position: absolute;
            left: 430px;
            margin-top: -6px;
        }

        #movido2 {
            position: absolute;
            left: 430px;
            margin-top: -4px;
        }

        #movido3 {
            position: absolute;
            left: 430px;
            margin-top: 0px;
        }

        #movido4 {
            position: absolute;
            left: 430px;
            margin-top: 0px;
        }

        #movido5 {
            position: absolute;
            left: 430px;
            margin-top: 0px;
        }

        #movido6 {
            position: absolute;
            left: 430px;
            margin-top: 0px;
        }

        #movido7 {
            position: absolute;
            left: 430px;
            margin-top: 0px;
        }
    </style>
</head>

<body>
    @foreach ($ventas as $key => $result)
        <div style="margin-bottom: 1px; background-color:rgba(31,113,186,255); height: 40px;">
            <img src="img/logo.jpe" alt="logo la voz" height="36px">
        </div>
        <br>
        <main>
            <h5 style="padding-top: -12; margin-top: -12;">LA VOZ DE MICHOACAN S.A. DE C.V. Av Periodismo José Tocavén
                Lavín
                1270
                Col. Agustín Arriaga Rivera.</h5>
            <h5 style="padding-top: -12; margin-top: -12;">C.P. 58190, Morelia Michoacán, México Tel: (443) 322 56 00
                Fax
                Ext.
                1038 &nbsp;&nbsp;&nbsp;&nbsp; RFC: VMI-600516-JG7, REG. EDO. 124026-9.
            </h5>
            {{-- <h5 style="padding-top: -12; margin-top: -12; margin-bottom: -12;">
                </h5> --}}
            <h3
                style="background-color: rgb(187, 230, 238); padding-bottom: -10; margin-bottom: -10; text-transform: uppercase; font-size: 16px; padding-top: -12; margin-top: -12;">
                remisionado de venta periodico
            </h3>
            <p id="movido" style="font-size: 16px;"><b>RUTA</b>
                {{ $result['nombreruta'] }}
            </p>
            <h3
                style="background-color: rgb(187, 230, 238); text-transform: uppercase; padding-bottom: -12; margin-bottom: -12; font-size: 16px;">
                remision
                {{ $result->id }}
            </h3>
            <p id="movido2" style="text-transform: uppercase; font-size: 16px;"><b>fecha</b>
                {{ \Carbon\Carbon::parse($result['fecha'])->format('d/m/Y') }}</p>
            <p style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>cliente:</b>
                {{ $result['nombre'] }}</p>
            <p id="movido3" style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>rfc:</b>
                {{ $result['rfc_input'] }}</p>
            <p style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>calle:</b>
                {{ $result['calle'] }}</p>
            <p id="movido4" style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;">
                <b>colonia:</b>
                {{ $result['colonia'] }}
            </p>
            <p style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>municipio:</b>
                {{ $result['municipio'] }}</p>
            <p id="movido5" style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>estado:</b>
                {{ $result['estado'] }}</p>
            <p style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>num. ext:</b>
                {{ $result['noext'] }}</p>
            <p id="movido6" style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>num.
                    int:</b>
                {{ $result['noint'] }}</p>
            <p style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>c.p.:</b>
                {{ $result['cp'] }}</p>
            <p id="movido7" style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>pais:</b>
                {{ $result['pais'] }}</p>
            <table style="margin-top: 15px; font-size: 12px;">
                <thead style="background-color: rgb(187, 230, 238); text-transform: uppercase;">
                    <tr>
                        <th style="width: 90px;">fecha</th>
                        <th style="width: 90px;">dia</th>
                        <th style="width: 90px;">entregados</th>
                        <th style="width: 85px;">devol.</th>
                        <th style="width: 85px;">falt.</th>
                        <th style="width: 110px;">precio</th>
                        <th style="width: 110px;">importe</th>
                    </tr>
                </thead>
                <tbody class="centrado">
                    <?php $totales = 0; ?>
                    <?php $importe = 0; ?>
                    @foreach ($entreFechas as $key => $fecha)
                        <tr>
                            <td>{{ $fecha }}</td>
                            <td>{{ $diasEntreFechas[$key] == 'domingo' ? 'DOM' : 'ORD' }}</td>
                            <td>{{ $result[$diasEntreFechas[$key]] }}</td>
                            <td></td>
                            <td></td>
                            <td>{{ $diasEntreFechas[$key] == 'domingo' ? number_format($result['dominical'], 2) : number_format($result['ordinario'], 2) }}
                            </td>
                            <td>{{ $diasEntreFechas[$key] == 'domingo' ? number_format($result['dominical'] * $result[$diasEntreFechas[$key]], 2) : number_format($result['ordinario'] * $result[$diasEntreFechas[$key]], 2) }}
                            </td>
                        </tr>
                        <?php $totales += $result[$diasEntreFechas[$key]]; ?>
                        <?php $importe += $diasEntreFechas[$key] == 'domingo' ? $result['dominical'] * $result[$diasEntreFechas[$key]] : $result['ordinario'] * $result[$diasEntreFechas[$key]]; ?>
                    @endforeach
                    <tr>
                        <td>TOTALES</td>
                        <td></td>
                        <td>{{ $totales }}</td>
                        <td></td>
                        <td></td>
                        <td>IMPORTE</td>
                        <td>{{ number_format($importe, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </main>
        <div class="page-break"></div>
    @endforeach
</body>

</html>

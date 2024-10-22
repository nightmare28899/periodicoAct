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

        /* header {
            position: fixed;
            top: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
        } */

        th,
        td {
            border-top: .3px solid gray;
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

        #movido8 {
            position: absolute;
            left: 130px;
            margin-top: 0px;
            width: 100px;
        }

        #movido9 {
            position: absolute;
            left: 250px;
            margin-top: 0px;
            width: 100px;
        }

        #movido10 {
            position: absolute;
            left: 370px;
            margin-top: 0px;
            width: 100px;
        }

        #movido11 {
            position: absolute;
            left: 370px;
            margin-top: 0px;
            width: 100px;
        }

        #movido12 {
            position: absolute;
            left: 510px;
            margin-top: 0px;
            width: 100px;
        }

        #movido13 {
            position: absolute;
            left: 510px;
            margin-top: 0px;
            width: 100px;
        }
    </style>
</head>

<body>
    @foreach ($ventas as $key => $result)
        <div style="margin-bottom: 1px; background-color:rgba(31,113,186,255); height: 40px;">
            <img src="img/logo.jpe" alt="logo la voz" height="36px">
        </div>
        <hr style="color: brown; margin-bottom: 5px;">
        <main>
            <h5 style="padding-top: -2; margin-top: -2;">LA VOZ DE MICHOACAN S.A. DE C.V. Av Periodismo José Tocavén
                Lavín
                1270
                Col. Agustín Arriaga Rivera. C.P. 58190, <br> Morelia Michoacán, México Tel: (443) 322 56 00
                Fax
                Ext.
                1038 &nbsp;&nbsp;&nbsp;&nbsp; RFC: VMI-600516-JG7, REG. EDO. 124026-9.
            </h5>
            <h3
                style="background-color: rgb(205, 212, 224); padding-bottom: -10; margin-bottom: -10; text-transform: uppercase; font-size: 16px; padding-top: -12; margin-top: -12;">
                remisionado de venta periodico
            </h3>
            <p id="movido" style="font-size: 16px; text-transform: uppercase;">
                <b>remision</b>
                {{ $idTiroSig != null ? $idTiroSig[$key]['id'] : $result['id'] }}
            </p>
            <h3
                style="text-transform: uppercase; padding-bottom: -12; margin-bottom: -12; font-size: 16px;">
                <b>RUTA</b>
                {{ $result['nombreruta'] }}
            </h3>
            <p id="movido2" style="text-transform: uppercase; font-size: 16px;"><b>fecha</b>
                {{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</p>
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
                {{ $result['localidad'] }}</p>
            <p style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>num. ext:</b>
                {{ $result['noext'] }}</p>
            <p id="movido6" style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>num.
                    int:</b>
                {{ $result['noint'] }}</p>
            <p style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>c.p.:</b>
                {{ $result['cp'] }}</p>
            <p id="movido7" style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>pais:</b>
                {{ $result['pais'] }}</p>

            <table style="margin-top: 15px; padding-top: 15px; font-size: 12px;">
                <thead style="background-color: rgb(205, 212, 224); text-transform: uppercase;">
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
                    {{-- <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Descuento</td>
                        <td>{{ number_format(0, 2) }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Subtotal</td>
                        <td>{{ number_format($importe, 2) }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>IVA</td>
                        <td>{{ number_format(0, 2) }}</td>
                    </tr> --}}
                    <br><br><br>{{-- <br><br> --}}
                    <p style="padding-bottom: -12; margin-bottom: -12; border-top: 0.5px solid black;">
                        &nbsp; Firma cobrador &nbsp;</p>
                    <p id="movido8" style="padding-bottom: -8; margin-bottom: -8; border-top: 0.5px solid black;">
                        &nbsp;Fecha cobro&nbsp;</p>
                    <p id="movido9" style="padding-bottom: -8; margin-bottom: -8; border-top: 0.5px solid black;">
                        &nbsp;Firma cliente&nbsp;</p>

                    <p id="movido10">DEV.</p>
                    <p id="movido11" style="border-top: 0.5px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</p>

                    <p id="movido12">NETO</p>
                    <p id="movido13" style="border-top: 0.5px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;</p>
                </tbody>
            </table>
        </main>
        <div class="page-break"></div>
    @endforeach
    @foreach ($suscripcion as $key => $result)
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
                1038
            </h5>
            <h5 style="padding-top: -12; margin-top: -12; margin-bottom: -12;">RFC: VMI-600516-JG7, REG. EDO. 124026-9.
            </h5>
            <h3
                style="background-color: rgb(187, 230, 238); padding-bottom: -10; margin-bottom: -10; text-transform: uppercase; font-size: 16px;">
                remisionado de clientes
            </h3>
            <p id="movido" style="font-size: 16px;"><b>RUTA</b>
                {{ $result['nombreruta'] }}
            </p>
            <h3
                style="background-color: rgb(187, 230, 238); text-transform: uppercase; padding-bottom: -12; margin-bottom: -12; font-size: 16px;">
                remision
                {{ $idTiroSig != null ? $idTiroSig[$key]['id'] : 1 }}
            </h3>
            <p id="movido2" style="text-transform: uppercase; font-size: 16px;"><b>fecha</b>
                {{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</p>
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
            <p style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>ciudad:</b>
                {{ $result['ciudad'] }}</p>
            <p id="movido5" style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;">
                <b>estado:</b>
                {{ $result['estado'] }}
            </p>
            <p style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>num. ext:</b>
                {{ $result['noext'] }}</p>
            <p id="movido6" style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>num.
                    int:</b>
                {{ $result['noint'] }}</p>
            <p style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>c.p.:</b>
                {{ $result['cp'] }}</p>
            <p id="movido7" style="padding-bottom: -12; margin-bottom: -12; text-transform: uppercase;"><b>pais:</b>
                {{ $result['pais'] }}</p>
            <div style="padding-top: 8px;">
                <p
                    style="text-transform: uppercase; border: 1px solid black; text-align: center; padding-bottom: -1; margin-bottom: -1;">
                    concepto</p>
            </div>

            <table style="text-transform: uppercase;">
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
                        <td>{{ $result['cantEjemplares'] }}</td>
                        <td>
                            <div class="form-group">
                                <label class="text-black" for="Física"> Periodo:
                                    Del: {{ \Carbon\Carbon::parse($de)->format('d/m/Y') }} Hasta:
                                    {{ \Carbon\Carbon::parse($hasta)->format('d/m/Y') }}, Ejemplares:
                                    {{ $result->cantEjemplares }}, Tipo:
                                    {{ $result['contrato'] }} </label>
                            </div>
                        </td>
                        <td>{{ sprintf('$ %s', number_format($result['importe'] / $result['cantEjemplares'], 2)) }}
                        </td>
                        <td>{{ sprintf('$ %s', number_format($result['importe'], 2)) }}</td>
                    </tr>
                </tbody>
            </table>
            <hr>
            <table style="text-transform: uppercase;">
                <tbody class="centrado">
                    <tr>
                        <td></td>
                        <td></td>
                        <td>IMPORTE</td>
                        <td>{{ sprintf('$ %s', number_format($result['importe'], 2)) }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>DESCUENTO</td>
                        <td>{{ sprintf('$ %s', number_format($result['descuento'], 2)) }}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td>SUBTOTAL</td>
                        <td>{{ sprintf('$ %s', number_format($result['total'], 2)) }}</td>
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
                        <th class='px-4 py-2' style="width: 266px; font-size: 14px;">{{ $result['cantEjemplares'] }}
                        </th>
                        <th class='px-4 py-2' style="width: 140px; font-size: 14px;">neto</th>
                        <th class='px-4 py-2' style="width: 140px; font-size: 14px;">
                            {{ sprintf('$ %s', number_format($result['total'], 2)) }}</th>
                    </tr>
                </thead>
            </table>
        </main>
        <div class="page-break"></div>
    @endforeach
    {{-- @endif --}}
</body>

</html>

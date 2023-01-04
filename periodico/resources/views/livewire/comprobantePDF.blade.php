<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-size: 11px;
        }

        .container {
            width: 90%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 5rem;
        }
        .move1 {
            position: absolute;
            margin-left: 11rem;
            margin-top: -12px;
        }
        .firma {
            position: absolute;
            margin-left: 24rem;
            margin-top: -12px;
            border-top: 1px solid black;
            width: 200px;
            text-align: center;
        }
        .elaboro {
            position: absolute;
            margin-left: 44rem;
            margin-top: -12px;
            border-top: 1px solid black;
            width: 200px;
            text-align: center;
        }
        .centrado {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h5>LA VOZ DE MICHOACÁN S.A. DE C.V. Av. Periodismo José Tocavén Lavin 1270 Col. Agustín Arriaga Rivera. C.P.
            58190,
            Morelia Michoacán, México Tel: (443) 322 56 00
            Fax Ext. 1038 RFC: VMI-600516-JG7, REG. EDO. 124026-9.</h5>

        <table style="text-transform: uppercase;">
            <thead style="text-transform: uppercase; background-color: rgb(187, 230, 238);">
                <tr>
                    <th class='px-4 py-2' style="width: 100px;">CONTRATO</th>
                    <th class='px-4 py-2' style="width: 100px;">ID SUSCRIPCION</th>
                    <th class='px-4 py-2' style="width: 100px;"></th>
                    <th class='px-4 py-2' style="width: 200px;">TIPO  SUSCRIPCION</th>
                    <th class='px-4 py-2' style="width: 200px;">FECHA  06/09/2022</th>
                </tr>
            </thead>
            <tbody class="">
                <tr>
                    <td>FACTURA A:</td>
                    <td>ID: {{ $idSuscripcionSig }}</td>
                    <td></td>
                    <td>RFC: {{ $cliente['rfc_input'] }}</td>
                    <td>RUTA: {{ $ruta[0]['nombreruta'] }}</td>
                </tr>
            </tbody>
        </table>

        <p><b>NOMBRE:</b></p>
        <p class="move1">{{ $cliente['nombre'] ? $cliente['nombre'] : $cliente['razon_social'] }}</p>
        <p><b>CALLE:</b></p>
        <p class="move1">{{ $domicilio[0]['calle'] }}</p>
        <p><b>COLONIA:</b></p>
        <p class="move1">{{ $domicilio[0]['colonia'] }}</p>
        <p><b>CIUDAD:</b></p>
        <p class="move1">{{ $domicilio[0]['ciudad'] }}</p>
        <p><b>ESTADO:</b></p>
        <p class="move1">{{ $cliente['estado'] }}</p>
        <p><b>E-MAIL:</b></p>
        <p class="move1">{{ $cliente['email'] }}</p>
        <p><b>TEL:</b></p>
        <p class="move1">{{ $cliente['telefono'] }}</p>
        <p><b>NUM EXT:</b></p>
        <p class="move1">{{ $domicilio[0]['noext'] }}</p>
        <p><b>NUM INT:</b></p>
        <p class="move1">{{ $domicilio[0]['noint'] }}</p>
        <p><b>C.P.:</b></p>
        <p class="move1">{{ $domicilio[0]['cp'] }}</p>
        <p><b>PAIS:</b></p>
        <p class="move1">{{ $cliente['pais'] }}</p>

        <p class="centrado" style="background-color: rgb(187, 230, 238);"><b>DOMICILIO DE ENTREGA</b></p>
        <table style="text-transform: uppercase;">
            <thead style="text-transform: uppercase; border: .5px solid black">
                <tr>
                    <th class='px-4 py-2' style="width: 70px;">N° EJEM</th>
                    <th class='px-4 py-2' style="width: 90px;">CALLE</th>
                    <th class='px-4 py-2' style="width: 85px;">N° INT</th>
                    <th class='px-4 py-2' style="width: 90px;">N° EXT</th>
                    <th class='px-4 py-2' style="width: 90px;">C.P.</th>
                    <th class="px-4 py-2" style="width: 90px;">COLONIA</th>
                    <th class="px-4 py-2" style="width: 90px;">CIUDAD</th>
                    <th class="px-4 py-2" style="width: 90px;">REFERENCIA</th>
                </tr>
            </thead>
            <tbody class="centrado">
                <tr>
                    <td>{{ $cantEjemplares }}</td>
                    <td>{{ $domicilio[0]['calle'] }}</td>
                    <td>{{ $domicilio[0]['noint'] }}</td>
                    <td>{{ $domicilio[0]['noext'] }}</td>
                    <td>{{ $domicilio[0]['cp'] }}</td>
                    <td>{{ $domicilio[0]['colonia'] }}</td>
                    <td>{{ $domicilio[0]['ciudad'] }}</td>
                    <td>{{ $domicilio[0]['referencia'] }}</td>
                </tr>
            </tbody>
        </table>

        <p class="centrado" style="background-color: rgb(187, 230, 238); margin-top: 15px;"><b>OTROS DATOS</b></p>
        <table style="text-transform: uppercase;">
            <thead>
                <tr>
                    <th class='px-4 py-2' style="width: 100px;">APERTURA {{ $esUnaSuscripcion == 'Apertura' ? 'X' : '' }}</th>
                    <th class='px-4 py-2' style="width: 100px;">RENOVACIÓN {{ $esUnaSuscripcion == 'Renovación' ? 'X' : '' }}</th>
                    <th class='px-4 py-2' style="width: 100px;">REACTIVACIÓN {{ $esUnaSuscripcion == 'Reactivación' ? 'X' : '' }}</th>
                    <th>PERIODO: {{ $periodo }}</th>
                    <th class='px-4 py-2' style="width: 100px;">DEL: {{ $desde }}</th>
                    <th class='px-4 py-2' style="width: 100px;">AL: {{ $hasta }}</th>
                </tr>
            </thead>
        </table>

        {{-- <p><b>LUGAR DE COBRO:</b></p>
        <p class="move1">DOMICILIO DE ENTREGA</p> --}}
        <p><b>MOT. DESCUENTO:</b></p>
        <p class="move1">0</p>
        <p><b>FORMA DE PAGO:</b></p>
        <p Class="move1">EFECTIVO</p>

        <br>
        <p><b>IMPORTE</b></p>
        <p class="move1">{{ sprintf('$ %s', number_format($total, 2)) }}</p>
        <p><b>DESCUENTO</b></p>
        <p class="move1">0</p>
        <p><b>SUBTOTAL</b></p>
        <p class="move1">{{ sprintf('$ %s', number_format($total, 2)) }}</p>
        <p><b>IVA</b></p>
        <p class="move1">0</p>
        <p><b>TOTAL</b></p>
        <p class="move1">{{ sprintf('$ %s', number_format($total, 2)) }}</p>

        <p><b>OBSERVACIONES:</b></p>
        <p class="move1">{{ $observaciones }}</p>

        <p class="firma">Firma del cliente</p>
        <p class="elaboro">Elaboró</p>

    </div>
</body>

</html>

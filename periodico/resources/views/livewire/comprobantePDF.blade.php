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

        <table>
            <thead style="text-transform: uppercase; background-color: rgb(187, 230, 238);">
                <tr>
                    <th class='px-4 py-2' style="width: 100px;">CONTRATO</th>
                    <th class='px-4 py-2' style="width: 100px;">ID VENTA</th>
                    <th class='px-4 py-2' style="width: 100px;"></th>
                    <th class='px-4 py-2' style="width: 200px;">TIPO  VENTA</th>
                    <th class='px-4 py-2' style="width: 200px;">FECHA  06/09/2022</th>
                </tr>
            </thead>
            <tbody class="">
                <tr>
                    <td>FACTURA A:</td>
                    <td>CLIENTE: {{ $cliente['id'] }}</td>
                    <td></td>
                    <td>RFC: {{ $cliente['rfc_input'] }}</td>
                    <td>RUTA:</td>
                </tr>
            </tbody>
        </table>

        <p><b>NOMBRE:</b></p>
        <p class="move1">{{ $cliente['nombre'] ? $cliente['nombre'] : $cliente['razon_social'] }}</p>
        <p><b>CALLE:</b></p>
        <p class="move1">{{ $cliente['calle'] }}</p>
        <p><b>COLONIA:</b></p>
        <p class="move1">{{ $cliente['colonia'] }}</p>
        <p><b>CIUDAD:</b></p>
        <p class="move1">{{ $cliente['municipio'] }}</p>
        <p><b>ESTADO:</b></p>
        <p class="move1">{{ $cliente['estado'] }}</p>
        <p><b>E-MAIL:</b></p>
        <p class="move1">{{ $cliente['email'] }}</p>
        <p><b>TEL:</b></p>
        <p class="move1">{{ $cliente['telefono'] }}</p>
        <p><b>NUM EXT:</b></p>
        <p class="move1">{{ $cliente['noext'] }}</p>
        <p><b>NUM INT:</b></p>
        <p class="move1">{{ $cliente['noint'] }}</p>
        <p><b>C.P.:</b></p>
        <p class="move1">{{ $cliente['cp'] }}</p>
        <p><b>PAIS:</b></p>
        <p class="move1">{{ $cliente['pais'] }}</p>

        <p class="centrado" style="background-color: rgb(187, 230, 238);"><b>DOMICILIO DE ENTREGA</b></p>
        <table>
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
                    <td>{{ $lunes + $martes + $miercoles + $jueves + $viernes + $sabado + $domingo }}</td>
                    <td>{{ $cliente['calle'] }}</td>
                    <td>{{ $cliente['noint'] }}</td>
                    <td>{{ $cliente['noext'] }}</td>
                    <td>{{ $cliente['cp'] }}</td>
                    <td>{{ $cliente['colonia'] }}</td>
                    <td>{{ $cliente['municipio'] }}</td>
                    <td>{{ $cliente['referencia'] }}</td>
                </tr>
            </tbody>
        </table>

        <p class="centrado" style="background-color: rgb(187, 230, 238); margin-top: 15px;"><b>OTROS DATOS</b></p>
        <table>
            <thead>
                <tr>
                    <th class='px-4 py-2' style="width: 100px;">DEL: {{ $desde }}</th>
                    <th class='px-4 py-2' style="width: 100px;">AL: {{ $hasta }}</th>
                    <th class='px-4 py-2' style="width: 50px;">DIAS</th>
                    <th class='px-4 py-2' style="width: 50px;">LUNES <br> {{-- {{ $lunes ? 'Si' : 'No' }} --}} {{ $lunesTotal = $lunes ? $lunes * $cliente['ordinario'] : 0 }}</th>
                    <th class='px-4 py-2' style="width: 50px;">MARTES {{-- {{ $martes ? 'Si' : 'No' }} --}} {{ $martesTotal =  $martes ? $martes * $cliente['ordinario'] : 0 }}</th>
                    <th class='px-4 py-2' style="width: 50px;">MIÉRCOLES {{-- {{ $miercoles ? 'Si' : 'No' }} --}} {{ $miercolesTotal = $miercoles ? $miercoles * $cliente['ordinario'] : 0}}</th>
                    <th class='px-4 py-2' style="width: 50px;">JUEVES {{-- {{ $jueves ? 'Si' : 'No' }}  --}}{{ $juevesTotal = $jueves ? $jueves * $cliente['ordinario'] : 0 }}</th>
                    <th class="px-4 py-2" style="width: 50px;">VIERNES {{-- {{ $viernes ? 'Si' : 'No' }} --}} {{ $viernesTotal = $viernes ? $viernes * $cliente['ordinario'] : 0 }}</th>
                    <th class="px-4 py-2" style="width: 50px;">SÁBADO {{-- {{ $sabado ? 'Si' : 'No' }} --}} {{ $sabadoTotal = $sabado ? $sabado * $cliente['ordinario'] : 0 }}</th>
                    <th class="px-4 py-2" style="width: 50px;">DOMINGO {{-- {{ $domingo ? 'Si' : 'No' }} --}} {{ $domingoTotal = $domingo ? $domingo * $cliente['dominical'] : 0 }}</th>
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
        <p class="move1">{{ sprintf('$ %s', number_format((int)$lunesTotal + (int)$martesTotal + (int)$miercolesTotal + (int)$juevesTotal + (int)$viernesTotal + (int)$sabadoTotal + (int)$domingoTotal, 2)) }}</p>
        <p><b>DESCUENTO</b></p>
        <p class="move1">0</p>
        <p><b>SUBTOTAL</b></p>
        <p class="move1">1790</p>
        <p><b>IVA</b></p>
        <p class="move1">0</p>
        <p><b>TOTAL</b></p>
        <p class="move1">1790</p>

        <p><b>OBSERVACIONES:</b></p>
        <p class="move1">PRUEBA</p>

        <p class="firma">Firma del cliente</p>
        <p class="elaboro">Elaboró</p>

    </div>
</body>

</html>

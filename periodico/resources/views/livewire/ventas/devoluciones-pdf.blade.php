<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body {
            font-size: 12.5px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .page-break {
            page-break-after: always;
        }

        th,
        td {
            border-top: .3px solid gray;
        }

        .centrado {
            text-align: center;
        }

        #movido {
            position: absolute;
            left: 19rem;
            margin-top: -1.72rem;
        }

        #movido2 {
            position: absolute;
            left: 35rem;
            margin-top: -1.72rem;
        }

        #movido3 {
            position: absolute;
            left: 17rem;
            margin-top: -1.7rem;
        }

        #movido4 {
            position: absolute;
            left: 1rem;
            margin-top: -1.7rem;
        }

        #movido5 {
            position: absolute;
            left: 17rem;
            margin-top: -1.6rem;
        }

        #movido6 {
            position: absolute;
            left: 33rem;
            margin-top: -1.6rem;
        }

        #movido7 {
            position: absolute;
            left: 1rem;
            margin-top: 3rem;
        }

        #movido8 {
            position: absolute;
            left: 17rem;
            margin-top: 3rem;
        }
    </style>
</head>

<body>
    <div style="background-color:rgba(31,113,186,255); height: 40px;">
        <img src="img/logo.jpe" alt="logo la voz" height="36px">
    </div>
    <hr style="color: brown;">
    <main>
        <h2 class="centrado" style="margin-top: -5px;">FORMATO DE INGRESO A CAJA</h2>

        <p><strong>RUTA</strong></p>
        <p id="movido"><strong>PERIODO</strong></p>
        <p id="movido2"><strong>FOLIO VALE DEV.</strong></p>

        <div style="margin-top: -25px;">
            <p>{{ $ruta[0]['id'] }} {{ $ruta[0]['repartidor'] }}</p>
            <p id="movido3">{{ $desde }} {{ $hasta }} <b
                    style="margin-left: 11rem;">{{ $folio }}</b></p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>REMISION</th>
                    @foreach ($fechas as $data)
                        <th>{{ \Carbon\Carbon::parse($data)->format('m-d') }}</th>
                    @endforeach
                    <th>DEVOLS.</th>
                    <th>IMPORTE</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php $sumaTotal = 0; ?>
                <?php $devolucion = 0; ?>
                @foreach ($devolucionVenta as $dev)
                    <tr>
                        <th>{{ $dev->idRemision }}</th>
                        @foreach (explode(',', $dev->devoluciones) as $info)
                            <th>{{ $info }}</th>
                            <?php $total += $info; ?>
                        @endforeach
                        <th>{{ $total }}</th>
                        <th>{{ number_format($dev->importe, 2) }}</th>
                    </tr>
                    <?php $sumaTotal += $dev->importe; ?>
                    <?php $devolucion += $total; ?>
                @endforeach
            </tbody>
            <br>
            <tbody>
                <tr>
                    <th>DEV. REMISIONES</th>
                    <?php $total = 0; ?>
                    @foreach ((array) $finalData as $data)
                        <th>{{ $data }}</th>
                        <?php $total += $data; ?>
                    @endforeach
                    <th>{{ $devolucion }}</th>
                    <th>{{ number_format($sumaTotal, 2) }}</th>
                </tr>
            </tbody>
            <br>
            <thead>
                <tr>
                    <th>DEV. FISICA</th>
                    <?php $total = 0; ?>
                    @foreach ((array) $finalData as $data)
                        <th>{{ $data }}</th>
                        <?php $total += $data; ?>
                    @endforeach
                    <th>{{ $devolucion }}</th>
                    <th>{{ number_format(0, 2) }}</th>
                </tr>
            </thead>
            <br>
            <thead>
                <tr>
                    <th>DIFERENCIA</th>
                    <?php $total = 0; ?>
                    @foreach ((array) $finalData as $data)
                        <th>0</th>
                    @endforeach
                    <th>0</th>
                    <th>0</th>
                </tr>
            </thead>
        </table>

        <p><strong>No. remisiones {{ count($devolucionVenta) }}</strong></p>
        <p id="movido5"><strong>TOTAL A LIQUIDAR</strong></p>
        <p id="movido6"><strong>{{ number_format($sumaTotal, 2) }}</strong></p>

        <p id="movido7" style="border-top: 1px solid black; font-size: 12px;"><b>ELABORO(Nombre y firma)</b></p>
        <p id="movido8" style="border-top: 1px solid black; font-size: 12px;"><b>ENTREGA(Nombre y firma)
                CHOFER/CIRCULACIÓN</b></p>

    </main>
</body>

</html>

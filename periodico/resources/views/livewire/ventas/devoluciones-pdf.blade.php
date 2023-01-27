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
            <p>{{ $ruta->id }} {{ $ruta->repartidor }}</p>
            <p id="movido3">{{ $desde }} {{ $hasta }} <b style="margin-left: 11.5rem;">{{ $folio }}</b></p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>REMISION</th>
                    @foreach ($fechas as $fecha)
                        <th>{{ \Carbon\Carbon::parse($fecha)->format('m-d') }}</th>
                    @endforeach
                    <th>DEVOLS.</th>
                    <th>IMPORTE</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th>{{ $idRemision }}</th>
                    <?php $total = 0; ?>
                    @foreach ($devoluciones as $dev)
                        <th>{{ $dev }}</th>
                        <?php $total += $dev; ?>
                    @endforeach
                    <th>{{ $total }}</th>
                    <th>{{ number_format($importe, 2) }}</th>
                </tr>
            </tbody>
            <br>
            <tbody>
                <tr>
                    <th>DEV. REMISIONES</th>
                    <?php $total = 0; ?>
                    @foreach ($devoluciones as $dev)
                        <th>{{ $dev }}</th>
                        <?php $total += $dev; ?>
                    @endforeach
                    <th>{{ $total }}</th>
                    <th>{{ number_format($importe, 2) }}</th>
                </tr>
            </tbody>
            <br>
            <thead>
                <tr>
                    <th>DEV. FISICA</th>
                    <?php $total = 0; ?>
                    @foreach ($devoluciones as $dev)
                        <th>{{ $dev }}</th>
                        <?php $total += $dev; ?>
                    @endforeach
                    <th>{{ $total }}</th>
                    <th>0.00</th>
                </tr>
            </thead>
            <br>
            <thead>
                <tr>
                    <th>DIFERENCIA</th>
                    @foreach ($devoluciones as $dev)
                        <th>0</th>
                    @endforeach
                    <th>0</th>
                    <th>{{ number_format($importe, 2) }}</th>
                </tr>
            </thead>
        </table>

        <p><strong>No. remisiones {{ $cantidad }}</strong></p>
        <p id="movido5"><strong>TOTAL A LIQUIDAR</strong></p>
        <p id="movido6"><strong>{{ number_format($importe, 2) }}</strong></p>

        <p id="movido7" style="border-top: 1px solid black; font-size: 12px;"><b>ELABORO(Nombre y firma)</b></p>
        <p id="movido8" style="border-top: 1px solid black; font-size: 12px;"><b>ENTREGA(Nombre y firma) CHOFER/CIRCULACIÓN</b></p>

    </main>
</body>

</html>

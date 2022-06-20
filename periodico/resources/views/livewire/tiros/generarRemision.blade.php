<div>
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
        .centrado{
             text-align: center;
        }
    </style>
    <h1>Remisiónes</h1>
    <table class="a centrado">
        <thead>
            <tr class="bg-gray-500 text-white">
                <th class="px-4 py-2 w-20">FECHA</th>
                <th class="px-4 py-2 w-20">ENTREGADOS</th>
                <th class="px-4 py-2 w-20">DEVUELTOS</th>
                <th class="px-4 py-2 w-20">FALTANTES</th>
                <th class="px-4 py-2 w-20">VENTA</th>
                <th class="px-4 py-2 w-20">PRECIO</th>
                <th class="px-4 py-2 w-20">IMPORTE</th>
                <th class="px-4 py-2 w-20">DIAS</th>
                <th class="px-4 py-2 w-20">NOMBRE RUTA</th>
                <th class="px-4 py-2 w-20">TIPO</th>
            </tr>
        </thead>
        <tbody>
           <p>{{ $dateF }}</p>
        </tbody>
    </table>
</div>
   <style>
       table,
       td,
       th {
           border: 1px solid;
           padding: 4px 6px ;
       }

       table {
           width: 100%;
           border-collapse: collapse;
       }

       .centrado {
           text-align: center;
       }
   </style>
   <h1>Lista del Tiro</h1>
   <table class="a centrado">
       <thead>
           <tr class="bg-gray-500 text-white">
               <th class="px-4 py-2 w-20">Tipo</th>
               <th>Cliente</th>
               <th>Día</thlass=>
               <th>Ejemplares</thclass=>
               <th>Domicilio</thclass=>
               <th>Referencia</thclass=>
               <th>Fecha</thclass=>
           </tr>
       </thead>
       <tbody>
           @foreach ($ventas as $result)
               @if ($result->{$diaS} != 0)
                   <tr>
                       <td>Venta/Cliente</td>
                       <td>{{ $result->nombre }}</td>
                       <td>{{ $diaS }} </td>
                       <td>{{ $result->{$diaS} }}</td>
                       <td>Calle: {{ $result->calle }}
                           <br>
                           No. Ext:
                           {{ $result->noext }}, CP: {{ $result->cp }}, <br> Localidad:
                           {{ $result->localidad }}, Municipio: {{ $result->municipio }}
                       </td>
                       <td>{{ $result->referencia }}</td>
                       <td>{{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</td>
                   </tr>
               @endif
           @endforeach
           @foreach ($suscripcion as $suscri)
               @if ($suscri->{$diaS} != 0 && $suscri->ejemplares != 0)
                   <tr>
                       <td>Suscripción</td>
                       <td>{{ $suscri->nombre }}</td>
                       <td>{{ $diaS }} </td>
                       <td>{{ $suscri->{$diaS} != 0 ? $suscri->ejemplares : 0 }}</td>
                       <td>Calle: {{ $suscri->calle }}
                           <br>
                           No. Ext:
                           {{ $suscri->noext }}, CP: {{ $suscri->cp }}, <br> Localidad:
                           {{ $suscri->localidad }}, Municipio: {{ $suscri->ciudad }}
                       </td>
                       <td>{{ $suscri->referencia }}</td>
                       <td>{{ \Carbon\Carbon::parse($dateF)->format('d/m/Y') }}</td>
                   </tr>
               @endif
           @endforeach
       </tbody>
   </table>

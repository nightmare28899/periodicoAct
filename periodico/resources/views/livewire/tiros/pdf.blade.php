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
   <h1>Lista del Tiro</h1>
   <table class="a centrado">
       <thead>
           <tr class="bg-gray-500 text-white">
               <th class="px-4 py-2 w-20">No.</th>
               <th class="px-4 py-2 w-20">Cliente</th>
               <th class="px-4 py-2 w-20">Día</th>
               <th class="px-4 py-2 w-20">Ejemplares</th>
               <th class="px-4 py-2 w-20">Domicilio</th>
               <th class="px-4 py-2 w-20">Referencia</th>
               <th class="px-4 py-2 w-20">Fecha</th>
           </tr>
       </thead>
       <tbody>
           @foreach ($resultado as $result)
               <tr>
                   <td>{{ $loop->iteration }}</td>
                   <td>{{ $result->nombre }}</td>
                   <td>{{ $diaS }} </td>
                   <td>{{ $result->{$diaS} }}</td>
                   <td wire:model="domicilio">Calle: {{ $result->calle }}
                       <br>
                       No. Ext:
                       {{ $result->noext }}, CP: {{ $result->cp }}, <br> Localidad:
                       {{ $result->localidad }}, Municipio: {{ $result->municipio }}
                   </td>
                   <td wire:model="referencia">{{ $result->referencia }}</td>
                   <td wire:model="fecha">{{ \Carbon\Carbon::parse($dateF)->format('d/m/Y')}}</td>
               </tr>
           @endforeach
       </tbody>
   </table>

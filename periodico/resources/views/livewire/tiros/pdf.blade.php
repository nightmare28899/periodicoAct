
    <table class="table-auto w-full text-center">
        <h1>Lista del Tiro</h1>
        <thead>
            <tr class="bg-gray-500 text-white">
                <th class="px-4 py-2 w-20">No.</th>
                <th class="px-4 py-2 w-20">Cliente</th>
                <th class="px-4 py-2 w-20">Día</th>
                <th class="px-4 py-2 w-20">Ejemplares</th>
                <th class="px-4 py-2 w-20">Domicilio</th>
                <th class="px-4 py-2 w-20">Referencia</th>
                <th class="px-4 py-2 w-20">Fecha</th>
                {{-- <th class="px-4 py-2 w-20">Acciones</th> --}}
            </tr>
        </thead>
        <tbody>
            @foreach ($resultado as $result)
                <tr>
                    <td class="border">{{ $loop->iteration }}</td>
                    <td class="border">{{ $result->nombre }}</td>
                    <td class="border">{{ $diaS }} </td>
                    <td class="border">{{ $result->{$diaS} }}</td>
                    <td class="border" wire:model="domicilio">Calle: {{ $result->calle }}
                        <br>
                        No. Ext:
                        {{ $result->noext }}, CP: {{ $result->cp }}, <br> Localidad:
                        {{ $result->localidad }}, Municipio: {{ $result->municipio }}
                    </td>
                    <td wire:model="referencia" class="border">{{ $result->referencia }}</td>
                    <td wire:model="fecha" class="border">{{ $dateF }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


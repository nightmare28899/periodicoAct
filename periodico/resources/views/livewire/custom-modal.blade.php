<div>
   
    <div wire:click="showModal" wire:loading.attr="disabled" class="p-4 text-gray-900 cursor-pointer"> 
        Open modal
    </div>

    <x-jet-dialog-modal wire:model="showingModal" >
        
        <x-slot name="title">
            
        </x-slot>


        <x-slot name="content">

            <table class="table-auto w-full text-center">
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
                            <td class="border" wire:model="domicilio">Calle: {{ $result->calle }} <br>
                                No. Ext:
                                {{ $result->noext }}, CP: {{ $result->cp }}, <br> Localidad:
                                {{ $result->localidad }}, Municipio: {{ $result->municipio }}
                            </td>
                            <td wire:model="referencia" class="border">{{ $result->referencia }}</td>
                            <td wire:model="fecha" class="border">{{ $dateF }}</td>
                            {{-- <td class="border px-4 py-2 flex-nowrap pt-2">
                                <input type="button"
                                    class="btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 bg-blue-400 font-medium rounded-md text-white hover:bg-blue-600 focus:outline-none transition cursor-pointer"
                                    name="imprimir" value="Imprimir" onclick="window.print();">
                            </td> --}}
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </x-slot>


        <x-slot name="footer">
            {{-- <x-jet-secondary-button wire:click="$set('showingModal', false)" wire:loading.attr="disabled">
                {{ __('Cancel')  }}
             </x-jet-secondary-button> --}}
        </x-slot>

    </x-jet-dialog-modal>

    

</div>
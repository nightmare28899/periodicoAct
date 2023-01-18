<div class="px-6 w-full mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Reporte Remisiones Rango Fecha') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex-initial mx-1 mt-4 mb-3">

                    <label for="fechaInicio">Del</label>
                    <x-jet-input type="date" wire:model="de"></x-jet-input>


                    <label for="fechaFin">Hasta</label>
                    <x-jet-input type="date" wire:model="hasta"></x-jet-input>

                </div>
                <div class="text-center overflow-x">
                    <div class="overflow-x-auto w-full">
                        <table class="table-auto border-separate border-spacing-2 border border-dark uppercase">
                            <thead>
                                <tr class='bg-gray-100'>
                                    <th scope="col" class="py-3 px-6">id</th>
                                    <th scope="col" class="py-3 px-6">Fecha incio</th>
                                    <th scope="col" class="py-3 px-6">Fecha fin</th>
                                    <th scope="col" class="py-3 px-6">Remisiones id</th>
                                    {{-- <th scope="col" class="py-3 px-6">Dias</th> --}}
                                    <th scope="col" class="py-3 px-6">Fecha registro</th>
                                    <th scope="col" class="py-3 px-6">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($remisionesData as $data)
                                    <tr>
                                        <td class='px-4 py-2 border border-dark'>
                                            {{ $data->id }}
                                        </td>
                                        <td class='px-4 py-2 border border-dark'>
                                            {{ \Carbon\Carbon::parse($data->fechaInicio)->format('d/m/Y') }}</td>
                                        <td class='px-4 py-2 border border-dark'>
                                            {{ \Carbon\Carbon::parse($data->fechaFin)->format('d/m/Y') }}</td>
                                        <td class='px-4 py-2 border border-dark'>{{ $data->remisiones_id }}</td>
                                        {{-- <td class='px-4 py-2 border border-dark'>{{ $data->dias }}</td> --}}
                                        <td class='px-4 py-2 border border-dark'>{{ $data->diaAlta }}</td>
                                        <td class='px-4 py-2 border border-dark'>
                                            <button wire:click="verPDF({{ $data->id }})"
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                                <svg wire:loading wire:target="verPDF({{ $data->id }})"
                                                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                                    xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24">
                                                    <circle class="opacity-25" cx="12" cy="12"
                                                        r="10" stroke="currentColor" stroke-width="4">
                                                    </circle>
                                                    <path class="opacity-75" fill="currentColor"
                                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                    </path>
                                                </svg>
                                                Ver PDF
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

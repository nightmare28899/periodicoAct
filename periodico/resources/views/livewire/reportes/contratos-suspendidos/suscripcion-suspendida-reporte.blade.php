<div class="mx-auto" style="width: 26%;">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Reporte Suscripciones Suspendidas') }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div>
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <p>Visualización de contrato suspendidos</p>
                <div class="flex-initial mx-1 mt-4 mb-3">
                    <input type="text"
                        class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-64 uppercase"
                        name="search" placeholder="Buscar contrato" wire:model="query"
                        autocomplete="off" />
                </div>

                <div class="mx-auto text-center">
                    <table class="table-auto border-separate border-spacing-2 border border-dark uppercase">
                        <thead>
                            <tr class='bg-gray-100'>
                                <th class='px-4 py-2 uppercase'>CONTRATO</th>
                                <th class='px-4 py-2 uppercase'>INICIO</th>
                                <th class='px-4 py-2 uppercase'>FIN</th>
                                <th class='px-4 py-2 uppercase'>MOTIVO</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suscripcionSus as $susc)
                                <tr>
                                    <td class='px-4 py-2 border border-dark'>
                                        {{ $susc['id'] }}
                                    </td>
                                    <td class='px-4 py-2 border border-dark'>
                                        {{ \Carbon\Carbon::parse($susc['del'])->format('d/m/Y') }}
                                    </td>
                                    <td class='px-4 py-2 border border-dark'>{{ \Carbon\Carbon::parse($susc['al'])->format('d/m/Y') }}</td>
                                    <td class='px-4 py-2 border border-dark'>
                                        {{ $susc['motivo'] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $suscripcionSus->links('livewirer.custom-pagination') }}
        </div>
    </div>

<div class="container w-1/2 mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Reporte Saldos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex mb-3">
                    <div class="flex-none mx-1">
                        <h4>Elige la fecha:</h4>
                        <x-jet-input type="date" wire:model="picker"></x-jet-input>
                    </div>
                    <div class="flex-none mx-1 mt-6">
                        <button wire:click.prevent="downloadExcel" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-base leading-6 font-bold shadow-sm text-white focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            <svg wire:loading wire:target="downloadExcel"
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Descargar EXCEL
                        </button>
                    </div>
                </div>
                <div class="text-center overflow-x">
                    <div class="overflow-x-auto w-full">
                        <table class="table-auto border-separate border-spacing-2 border border-dark uppercase">
                            <thead>
                                <tr class='bg-gray-100'>
                                    <th scope="col" class="py-3 px-6">Fecha FC</th>
                                    <th scope="col" class="py-3 px-6">Folio interno</th>
                                    <th scope="col" class="py-3 px-6">rfc</th>
                                    <th scope="col" class="py-3 px-6">total</th>
                                    <th scope="col" class="py-3 px-6">Forma pago</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0; ?>
                                @foreach ($tiros as $tiro)
                                    @if ($tiro->clasificacion == 'CRÉDITO' && $tiro->status == 'CREDITO')
                                        <tr>
                                            <td class='px-4 py-2 border border-dark'>
                                                {{ $tiro->status == 'cancelada' ? \Carbon\Carbon::parse($invo->invoice_date)->format('d/m/Y') : '' }}</td>
                                            <td class='px-4 py-2 border border-dark'>{{ $tiro->idTipo }}</td>
                                            <td class='px-4 py-2 border border-dark'>{{ $tiro->rfc_input }}</td>
                                            <td class='px-4 py-2 border border-dark'>{{ $tiro->importe }}</td>
                                            <td class='px-4 py-2 border border-dark'>{{ 'PPD' }}</td>
                                        </tr>
                                        @if ($tiro->status != 'Cancelado')
                                            <?php $total += $tiro->importe; ?>
                                        @endif
                                    @endif
                                @endforeach
                            </tbody>
                            <thead>
                                <tr class="text-black">
                                    <th class='px-4 py-2 uppercase'>Suma</th>
                                    <th class='px-4 py-2 uppercase'></th>
                                    <th class='px-4 py-2 uppercase'></th>
                                    <th class='px-4 py-2 uppercase'></th>
                                    <th class='px-4 py-2 uppercase'>{{ sprintf('$ %s', number_format($total, 2)) }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

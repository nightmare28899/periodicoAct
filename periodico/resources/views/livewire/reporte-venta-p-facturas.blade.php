<div class="container w-3/5 mx-auto">
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Reporte Facturas') }}
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
                    <div class="flex-none mx-1">
                        <h4>Tipo:</h4>
                        <select
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                            style="width: 11rem;" wire:model="tipo">
                            <option value='venta' selected>Venta</option>
                            <option value="suscri">Suscripción</option>
                        </select>
                    </div>
                    <div class="flex-none mx-1 mt-6">
                        <button wire:click.prevent="downloadExcel" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-blue-500 hover:bg-blue-600 text-base leading-6 font-bold shadow-sm text-white focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            <svg wire:loading wire:target="downloadExcel" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
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
                <div class="relative">
                    <table class="w-full text-md text-gray-500 dark:text-gray-40 text-center">
                        <thead class="text-md text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr class="bg-gray-500 text-white uppercase">
                                <th scope="col" class="py-3 px-6">Fecha FC</th>
                                <th scope="col" class="py-3 px-6">Folio interno</th>
                                <th scope="col" class="py-3 px-6">Uuid</th>
                                <th scope="col" class="py-3 px-6">rfc</th>
                                <th scope="col" class="py-3 px-6">total</th>
                                <th scope="col" class="py-3 px-6">Forma pago</th>
                                <th scope="col" class="py-3 px-6">Fecha pago</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0; ?>
                            @foreach ($invoices as $invo)
                                <tr class="bg-white text-black">
                                    <td class="border">
                                        {{ $invo->status == 'cancelada' ? \Carbon\Carbon::parse($invo->invoice_date)->format('d/m/Y') : '' }}
                                    </td>
                                    <td class="border">
                                        {{ $invo->serie }}</td>
                                    <td class="border">
                                        {{ $invo->uuid }}</td>
                                    <td class="border">
                                        {{ $invo->rfc_input }}</td>
                                    <td class="border">
                                        {{ sprintf('$ %s', number_format($invo->total)) }}</td>
                                    <td class="border">
                                        {{ substr($invo->paymentMethod, 0, 3) }}</td>
                                    <td class="border">
                                        {{ \Carbon\Carbon::parse($invo->created_at)->translatedFormat('l jS \\de F Y h:i:s A') }}
                                    </td>
                                </tr>
                                @if ($invo->status != 'cancelada')
                                    <?php $total += $invo->total; ?>
                                @endif
                            @endforeach
                        </tbody>
                        <thead>
                            <tr class="text-black">
                                <th class='px-4 py-2 uppercase'>Suma</th>
                                <th class='px-4 py-2 uppercase'></th>
                                <th class='px-4 py-2 uppercase'></th>
                                <th class='px-4 py-2 uppercase'></th>
                                <th class='px-4 py-2 uppercase'>{{ sprintf('$ %s', number_format($total)) }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

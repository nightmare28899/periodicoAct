<div class="w-2/3 mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Historial de Complementos de Pago') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="text-center overflow-x">
                    <div class="overflow-x-auto w-full">
                        <table class="table-auto border-separate border-spacing-2 border border-dark uppercase">
                            <thead>
                                <tr class='bg-gray-100'>
                                    <th class='px-4 py-2 uppercase'>id</th>
                                    <th class="px-4 py-2 uppercase">Nombre</th>
                                    <th class='px-4 py-2 uppercase'>factura id</th>
                                    <th class='px-4 py-2 uppercase'>uuid</th>
                                    <th class='px-6 py-2 uppercase'>fecha pago</th>
                                    <th class='px-4 py-2 uppercase'>fecha</th>
                                    <th class='px-4 py-2 uppercase'>acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($complemento_pago as $complemento)
                                    <tr>
                                        <td class='border px-4 py-2'>{{ $complemento->id }}</td>
                                        <td class='border px-4 py-2'>{{ $complemento->nombre }}</td>
                                        <td class='border px-4 py-2'>{{ $complemento->invoice_id }}</td>
                                        <td class='border px-4 py-2'>{{ $complemento->uuid }}</td>
                                        <td class='border px-6 py-2'>
                                            {{ \Carbon\Carbon::parse($complemento->fecha_pago)->format('Y-m-d') }}</td>
                                        <td class='border px-4 py-2'>
                                            {{ \Carbon\Carbon::parse($complemento->created_at)->format('Y-m-d') }}</td>
                                        <td class="border px-4 py-2">
                                            <a href="{{ url('vistaPreviaComplemento/' . $complemento->invoice_id) }}"
                                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Ver
                                                PDF</a>
                                            @if ($complemento->status == 'cancelada')
                                                <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-red-500 hover:bg-red-600 rounded-lg focus:shadow-outline"
                                                    disabled>Factura
                                                    cancelada</a>
                                            @else
                                                <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-red-500 hover:bg-red-600 rounded-lg focus:shadow-outline"
                                                    href="{{ url('CancelarFacturaComplemento/' . $complemento->invoice_id . '/' . $complemento->cliente_id) }}">Cancelar
                                                    factura</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{ $complemento_pago->links('livewire.custom-pagination') }}
            </div>
        </div>
    </div>

<div class="container w-2/3 mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Devoluciones') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <button
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full">
                        Generar informe general
                    </button>
                </div>
                <div class="text-center overflow-x mt-3">
                    <div class="overflow-x-auto">
                        <table class="table-auto border-separate border-spacing-2 border border-dark w-full uppercase">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 uppercase">Id</th>
                                    <th class="px-4 py-2 uppercase">Cliente</th>
                                    <th class="px-4 py-2 uppercase">Fechas</th>
                                    <th class="px-4 py-2 uppercase">Devoluciones</th>
                                    <th class="px-4 py-2 w-20">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (count($devolucionVenta) > 0)
                                    @foreach ($devolucionVenta as $result)
                                        <tr class="uppercase">
                                            <td class="px-4 py-2 border border-dark">{{ $result->id }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $result->nombre }}</td>
                                            <td class="px-4 py-2 border border-dark">{{ $result->fechas }}</td>
                                            <td class="px-4 py-2 border border-dark">
                                                {{ $result->devoluciones }}
                                            </td>
                                            <td>
                                                <div class="flex justify-center">
                                                    <button wire:click="delete({{ $result->id }})"
                                                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full">
                                                        Ver PDF
                                                    </button>
                                                </div>
                                            </td>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <br>
        {{ $devolucionVenta->links('livewire.custom-pagination') }}
    </div>
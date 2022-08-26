<div class="container mx-auto">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">
            {{ __('Lista de facturas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <div class="flex-none mx-1" style="width: 88%;"></div>
                    <div class="flex-none mx-1">
                        <button wire:click="create"
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base font-bold text-white shadow-sm hover:bg-green-700">
                            Generar Factura
                        </button>
                    </div>
                </div>
                <div>
                    <div class="flex mt-2">
                        <div class="w-1/2 px-2">
                            <p class="font-bold">FACTURAR A:</p>
                            <b>Clave: <input type="text" style="height: 1.7rem; margin-left: 2.4rem;"
                                    value="{{ $cliente->id }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <br>
                            <b>R.F.C.: <input type="text" style="height: 1.7rem; margin-left: 1.8rem;"
                                    value="{{ $cliente->rfc_input }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <br>
                            <b>Nombre: <input type="text" style="height: 1.7rem; margin-left: 1.8rem;"
                                    value="{{ $cliente->nombre }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-1">
                        <div class="w-1/2 px-2">
                            <b>Calle: <input type="text" style="height: 1.7rem; margin-left: 2.6rem;"
                                    value="{{ $domicilio->calle }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <b>No. Int: <input type="text" style="height: 1.7rem; margin-left: 1.3rem;"
                                    value="{{ $domicilio->noint }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <b>No. Ext.: <input type="text" style="height: 1.7rem; margin-left: 1.8rem;"
                                    value="{{ $domicilio->noext }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-1">
                        <div class="w-1/2 px-2">
                            <b>Colonia: <input type="text" style="height: 1.7rem; margin-left: 1.4rem;"
                                    value="{{ $domicilio->colonia }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <b>C.P.: <input type="text" style="height: 1.7rem; margin-left: 2.6rem;"
                                    value="{{ $domicilio->cp }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <b>Localidad: <input type="text" style="height: 1.7rem; margin-left: 1rem;"
                                    value="{{ $domicilio->localidad }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-1">
                        <div class="w-1/2 px-2">
                            <b>Estado: <input type="text" style="height: 1.7rem; margin-left: 1.8rem;"
                                    value="{{ $cliente->estado }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <b>País: <input type="text" style="height: 1.7rem; margin-left: 2.5rem;"
                                    value="{{ $cliente->pais }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <b>Municipio: <input type="text" style="height: 1.7rem; margin-left: 1rem;"
                                    value="{{ $domicilio->ciudad }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-1">
                        <div class="w-1/2 px-2">
                            <b>E-mail: <input type="text" style="height: 1.7rem; margin-left: 1.8rem; width: 300px;"
                                    value="{{ $cliente->email }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <b>Tel: <input type="text" style="height: 1.7rem; margin-left: 3rem;"
                                    value="{{ $cliente->telefono }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            {{-- <b>Tel: <input type="text" style="height: 1.7rem; margin-left: 4.1rem;"
                                    value="{{ $cliente->telefono }}" class="border-0 bg-gray-200" disabled></b> --}}
                        </div>
                    </div>

                    <div class="flex mt-2">
                        <div class="w-1/2 px-2">
                            <p class="font-bold">Suscripción</p>
                            <b>Clave: <input type="text" style="height: 1.7rem; margin-left: 2.4rem;"
                                    value="{{ $suscripcion->id }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <br>
                            <b>R.F.C.: <input type="text" style="height: 1.7rem; margin-left: 1.8rem;"
                                    value="{{ $cliente->rfc_input }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <br>
                            <b>Nombre: <input type="text" style="height: 1.7rem; margin-left: 1.8rem;"
                                    value="{{ $cliente->nombre }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-1">
                        <div class="w-1/2 px-2">
                            <b>Calle: <input type="text" style="height: 1.7rem; margin-left: 2.6rem;"
                                    value="{{ $domicilio->calle }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <b>No. Int: <input type="text" style="height: 1.7rem; margin-left: 1.3rem;"
                                    value="{{ $domicilio->noint }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <b>No. Ext.: <input type="text" style="height: 1.7rem; margin-left: 1.8rem;"
                                    value="{{ $domicilio->noext }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-1">
                        <div class="w-1/2 px-2">
                            <b>Colonia: <input type="text" style="height: 1.7rem; margin-left: 1.4rem;"
                                    value="{{ $domicilio->colonia }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <b>C.P.: <input type="text" style="height: 1.7rem; margin-left: 2.6rem;"
                                    value="{{ $domicilio->cp }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <b>Localidad: <input type="text" style="height: 1.7rem; margin-left: 1rem;"
                                    value="{{ $domicilio->localidad }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

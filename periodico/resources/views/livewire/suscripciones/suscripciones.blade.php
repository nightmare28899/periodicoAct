<x-jet-dialog-modal wire:model="suscripciones" maxWidth="6xl">

    <x-slot name="title">
        <div class="flex sm:px-6">
            <h1 class="mb-3 text-2xl text-black font-bold ml-3">Suscripciones</h1>
            <button type="button" wire:click="$set('suscripciones', false)" wire:loading.attr="disabled"
                class="mb-3 text-gray-400 bg-transparent hover:bg-red-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-red-600 dark:hover:text-white"
                data-modal-toggle="defaultModal">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        <hr>
    </x-slot>

    <x-slot name="content">
        @if (count($clientes) > 0)
            <div class="px-4 mb-4" flex-grow>
                <div class="flex">
                    <div class="w-1/2 px-2">
                        <p class="font-bold">La suscripción es para el cliente</p>
                    </div>
                    <div class="w-1/2">
                        <p class="font-bold">Fecha: <input type="text" style="height: 1.7rem; margin-left: 2.4rem;"
                                value="{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}" class="border-0 bg-gray-200"
                                disabled>
                        </p>
                    </div>
                </div>
                <div class="flex">
                    <div class="w-1/2 p-2">
                        <select
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('clasificacion') border-red-500 @enderror"
                            wire:model="clienteSeleccionado" style="width: 100%">
                            <option value=''>Selecciona un cliente</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                            @endforeach
                            @error('clienteSeleccionado')
                                <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </select>
                    </div>
                    <div class="w-1/2 p-2">
                        <input type="checkbox" name="oferta" wire:model="oferta"> Aplicar oferta
                    </div>
                </div>
                <div class="flex">
                    <div class="w-1/2 px-2">
                        <p>Suscripción:</p>
                        <p class="font-bold"><input wire:model.defer="tipoSubscripcion" name="tipoSubscripcion"
                                id="Normal" value="Normal" type="radio" checked> <label class="text-black"
                                for="Normal">Normal</label></p>
                    </div>
                    <div class="w-1/2">
                        <br>
                        <p class="font-bold"><input wire:model.defer="tipoSubscripcion" name="tipoSubscripcion"
                                id="Semanal" value="Semanal" type="radio"
                                {{ $tipoSubscripcion == 'Semanal' ? 'checked' : '' }}>
                            <label class="text-black" for="Semanal">Semanal</label>
                        </p>
                    </div>
                    <div class="border-l-4 border-black ... px-2"></div>
                    <div class="w-1/2">
                        <p>La suscripción es una:</p>
                        <p class="font-bold"><input wire:model.lazy="subscripcionEs" type="radio"
                                name="subscripcionEs" value="Apertura" checked> <label for="Apertura">Apertura</label>
                        </p>
                    </div>
                    <div class="w-1/2">
                        <br>
                        <p class="font-bold"><input wire:model="subscripcionEs" type="radio" name="subscripcionEs"
                                value="Renovación" {{ $subscripcionEs == 'Renovación' ? 'checked' : '' }}> <label
                                for="Renovación">Renovación</label></p>
                    </div>
                    <div class="w-1/2">
                        <br>
                        <p class="font-bold"><input wire:model.lazy="subscripcionEs" type="radio"
                                name="subscripcionEs" value="Reactivación"
                                {{ $subscripcionEs == 'Reactivación' ? 'checked' : '' }}> <label
                                for="Reactivación">Reactivación</label></p>
                    </div>
                </div>
                @foreach ($dataClient as $data)
                    <div class="flex mt-2">
                        <div class="w-1/2 px-2">
                            <p class="font-bold">FACTURAR A:</p>
                            <b class="">Clave: <input type="text" style="height: 1.7rem; margin-left: 2.4rem;"
                                    value="{{ $loop->iteration }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <br>
                            <b>R.F.C.: <input type="text" style="height: 1.7rem; margin-left: 1.8rem;"
                                    value="{{ $data->rfc_input }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <br>
                            <b>Nombre: <input type="text" style="height: 1.7rem; margin-left: 1.8rem;"
                                    value="{{ $data->nombre }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-1">
                        <div class="w-1/2 px-2">
                            <b>Calle: <input type="text" style="height: 1.7rem; margin-left: 2.6rem;"
                                    value="{{ $data->calle }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <b>No. Int: <input type="text" style="height: 1.7rem; margin-left: 1.3rem;"
                                    value="{{ $data->noint }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <b>No. Ext.: <input type="text" style="height: 1.7rem; margin-left: 1.8rem;"
                                    value="{{ $data->noext }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-1">
                        <div class="w-1/2 px-2">
                            <b>Colonia: <input type="text" style="height: 1.7rem; margin-left: 1.4rem;"
                                    value="{{ $data->colonia }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <b>C.P.: <input type="text" style="height: 1.7rem; margin-left: 3.2rem;"
                                    value="{{ $data->cp }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-1">
                        <div class="w-1/2 px-2">
                            <b>Localidad: <input type="text" style="height: 1.7rem; margin-left: 0.5rem;"
                                    value="{{ $data->localidad }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <b>Municipio: <input type="text" style="height: 1.7rem; margin-left: 0.6rem;"
                                    value="{{ $data->municipio }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-1">
                        <div class="w-1/2 px-2">
                            <b>Estado: <input type="text" style="height: 1.7rem; margin-left: 1.8rem;"
                                    value="{{ $data->estado }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <b>País: <input type="text" style="height: 1.7rem; margin-left: 3.1rem;"
                                    value="{{ $data->pais }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                    <div class="flex mt-1">
                        <div class="w-1/2 px-2">
                            <b>E-mail: <input type="text" style="height: 1.7rem; margin-left: 1.8rem;"
                                    value="{{ $data->email }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                        <div class="w-1/2 px-2">
                            <b>Tel: <input type="text" style="height: 1.7rem; margin-left: 3.6rem;"
                                    value="{{ $data->telefono }}" class="border-0 bg-gray-200" disabled></b>
                        </div>
                    </div>
                @endforeach
                <div class="flex mt-5">
                    <div class="w-2/5 px-2">
                        <p>TARIFA</p>
                        <select
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('clasificacion') border-red-500 @enderror"
                            wire:model="tarifaSeleccionada" style="width: 100%">
                            <option value=''>Selecciona una tarifa</option>
                            <option value="Base">Base</option>
                            <option value="Ejecutiva">Ejecutiva</option>
                        </select>
                        @error('tarifaSeleccionada')
                            <span class="text-red-500 text-xs italic">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="w-2/5 px-2">
                        <p>EJEMPLARES</p>
                        <input type="number" class="border-0 bg-gray-200" style="height: 1.7rem; margin-top: 5px;"
                            name="cantEjem" wire:model="cantEjem" min="0">
                        @error('cantEjem')
                            <span class="text-red-500 text-xs italic">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="w-2/5 px-2">
                        <p>PRECIO</p>
                        <input type="radio" name="precio" wire:model="precio" value="Normal" checked> Normal
                        <input type="radio" name="precio" wire:model="precio" value="Pronto_pago"> Pronto pago
                    </div>
                    <div class="w-1/2 px-2">
                        <p>CONTRATO PARA</p>
                        <input type="radio" name="contrato" wire:model="contrato" value="Suscripción" checked>
                        Suscripción
                        <input type="radio" name="contrato" wire:model="contrato" value="Cortesía"
                            {{ $contrato == 'Cortesía' ? 'checked' : '' }}> Cortesía
                        <input type="radio" name="contrato" wire:model="contrato" value="Intercambio"> Intercambio
                    </div>
                </div>
                <div class="flex mt-2">
                    <div class="w-1/5 px-2">
                        <p class="mt-3">TIPO SUSCRIPCIÓN</p>
                        <p class="mt-4">PERIODO</p>
                        <p class="mt-5">DÍAS</p>
                    </div>
                    <div class="w-1/4 px-2">
                        <select
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('tipoSuscripcionSeleccionada') border-red-500 @enderror"
                            wire:model.defer="tipoSuscripcionSeleccionada" style="width: 80%">
                            <option value=''>Selecciona una opción</option>
                            <option value='Impresa'>Impresa</option>
                            <option value='Internet'>Internet</option>
                        </select>
                        @error('tipoSuscripcionSeleccionada')
                            <span class="text-red-500 text-xs italic">
                                {{ $message }}
                            </span>
                        @enderror
                        <select
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mt-1 @error('periodoSuscripcionSeleccionada') border-red-500 @enderror"
                            wire:model="periodoSuscripcionSeleccionada" style="width: 80%">
                            <option value="">...</option>
                            <option value='esco'>Escoger manualmente</option>
                            <option value='Mensual'>Mensual</option>
                            <option value='Trimestral'>Trimestral</option>
                            <option value='Semestral'>Semestral</option>
                            <option value='Anual'>Anual</option>
                        </select>
                        @error('periodoSuscripcionSeleccionada')
                            <span class="text-red-500 text-xs italic">
                                {{ $message }}
                            </span>
                        @enderror
                        <select
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mt-1 @error('diasSuscripcionSeleccionada') border-red-500 @enderror"
                            wire:model="diasSuscripcionSeleccionada" style="width: 80%">
                            <option value="">...</option>
                            <option value="esc_man">Escoger manualmente</option>
                            <option value="l_v">Lunes a viernes</option>
                            <option value='l_d'>Lunes a Domingo</option>
                        </select>
                        @error('diasSuscripcionSeleccionada')
                            <span class="text-red-500 text-xs italic">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="w-3/5 px-2">
                        <p class="mt-3">#DÍAS PARA PAGAR</p>
                        <p class="mt-3 mr-3 flex"><kbd class="mt-2">DEL:</kbd>
                            @if ($modificarFecha)
                                <x-jet-input class="w-2/5" type="date" wire:model="from">
                                </x-jet-input>
                            @else
                                <x-jet-input class="w-2/5" type="date" wire:model="from" disabled>
                                </x-jet-input>
                            @endif
                            <kbd class="ml-3 mt-2">AL:</kbd>
                            @if ($modificarFecha)
                                <x-jet-input class="w-2/5" type="date" wire:model="to">
                                </x-jet-input>
                            @else
                                <x-jet-input class="w-2/5" type="date" wire:model="to" disabled>
                                </x-jet-input>
                            @endif
                        </p>
                        <div class="mt-2">
                            @if ($allow == false)
                                <input type="checkbox" name="lunes" wire:model.defer="lunes" disabled> Lunes
                                <input type="checkbox" name="martes" wire:model.defer="martes" disabled> Martes
                                <input type="checkbox" name="miércoles" wire:model.defer="miércoles" disabled>
                                Miércoles
                                <input type="checkbox" name="jueves" wire:model.defer="jueves" disabled> Jueves
                                <input type="checkbox" name="viernes" wire:model.defer="viernes" disabled> Viernes
                                <input type="checkbox" name="sábado" wire:model.defer="sábado" disabled> Sábado
                                <input type="checkbox" name="domingo" wire:model.defer="domingo" disabled> Domingo
                            @else
                                <input type="checkbox" name="lunes" wire:model.defer="lunes"> Lunes
                                <input type="checkbox" name="martes" wire:model.defer="martes"> Martes
                                <input type="checkbox" name="miércoles" wire:model.defer="miércoles"> Miércoles
                                <input type="checkbox" name="jueves" wire:model.defer="jueves"> Jueves
                                <input type="checkbox" name="viernes" wire:model.defer="viernes"> Viernes
                                <input type="checkbox" name="sábado" wire:model.defer="sábado"> Sábado
                                <input type="checkbox" name="domingo" wire:model.defer="domingo"> Domingo
                            @endif
                        </div>
                    </div>
                </div>
                <div class="flex mt-2">
                    <div class="w-full">
                        <b class="uppercase">domicilio de entrega</b>
                        <button class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-md"
                            wire:click="modalCrearDomSubs">Lista</button>
                        <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-3">
                            <table class="w-full text-md text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-md text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr class="bg-gray-500 text-white uppercase">
                                        <th scope="col" class="py-3 px-6">Calle</th>
                                        <th scope="col" class="py-3 px-6">#Int</th>
                                        <th scope="col" class="py-3 px-6">#Ext</th>
                                        <th scope="col" class="py-3 px-6">Colonia</th>
                                        <th scope="col" class="py-3 px-6">C.P.</th>
                                        <th scope="col" class="py-3 px-6">Localidad</th>
                                        <th scope="col" class="py-3 px-6">Ciudad</th>
                                        {{-- <th scope="col" class="py-3 px-6">#Ejem</th> --}}
                                        <th scope="col" class="py-3 px-6">Referencia</th>
                                        <th scope="col" class="py-3 px-6">Ruta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($domicilioSeleccionado)
                                        @foreach ($domicilioSeleccionado as $dom)
                                            @php
                                                $dom = (object) $dom;
                                            @endphp
                                            {{-- <pre>{{ var_dump($dom) }}</pre><br><br> --}}
                                            <tr
                                                class="bg-white text-black hover:text-white dark:hover:bg-gray-600 text-center cursor-pointer">
                                                <td class="border"
                                                    wire:click="eliminarDatoSeleccionado({{ $dom->id }})">
                                                    {{ $dom->calle }}</td>
                                                <td class="border"
                                                    wire:click="eliminarDatoSeleccionado({{ $dom->id }})">
                                                    {{ $dom->noint }}</td>
                                                <td class="border"
                                                    wire:click="eliminarDatoSeleccionado({{ $dom->id }})">
                                                    {{ $dom->noext }}</td>
                                                <td class="border"
                                                    wire:click="eliminarDatoSeleccionado({{ $dom->id }})">
                                                    {{ $dom->colonia }}</td>
                                                <td class="border"
                                                    wire:click="eliminarDatoSeleccionado({{ $dom->id }})">
                                                    {{ $dom->cp }}</td>
                                                <td class="border"
                                                    wire:click="eliminarDatoSeleccionado({{ $dom->id }})">
                                                    {{ $dom->localidad }}</td>
                                                <td class="border"
                                                    wire:click="eliminarDatoSeleccionado({{ $dom->id }})">
                                                    {{ $dom->ciudad }}</td>
                                                {{-- <td class="border">
                                                    <input type="number" class="text-black"
                                                        placeholder="coloca la cantidad"
                                                        wire:model="cantDom.{{ $dom->id }}" min="0">
                                                </td> --}}
                                                <td class="border"
                                                    wire:click="eliminarDatoSeleccionado({{ $dom->id }})">
                                                    {{ $dom->referencia }}</td>
                                                <td class="border"
                                                    wire:click="eliminarDatoSeleccionado({{ $dom->id }})">
                                                    {{ $dom->nombreruta }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="flex mt-3">
                    @if ($oferta != false)
                        <div class="w-2/5 px-2 flex">
                            DESCUENTO FINAL <input type="number" style="height: 1.7rem; margin-left: 1.3rem;"
                                placeholder="Coloca la cantidad" name="descuento" wire:model="descuento"
                                min="0" class="border-0 bg-gray-200">
                        </div>
                    @endif
                </div>
                <div class="mt-3">
                    <div class="w-2/5 px-2 flex">
                        OBSERVACIONES(Opcional)
                        <textarea style="margin-left: 2rem;" class="border-0 bg-gray-200" rows="2" wire:model.defer="observacion"
                            placeholder="Coloca una descripción" cols="50"></textarea>
                    </div>
                </div>
                <div class="flex">
                    <div class="w-1/4 px-2">
                        <p class="mt-2 flex">IMPORTE <input type="number" class="border-0 bg-gray-200"
                                style="height: 1.7rem; margin-left: 5.9rem;" value="{{ $total }}" disabled>
                        </p>
                        <p class="mt-2 flex">DESCUENTO <input type="number" class="border-0 bg-gray-200"
                                style="height: 1.7rem; margin-left: 4.3rem;" value="{{ $descuento }}" disabled>
                        </p>
                        <p class="mt-2 flex">SUBTOTAL <input type="number" class="border-0 bg-gray-200"
                                style="height: 1.7rem; margin-left: 5.1rem;" value="{{ $total }}" disabled>
                        </p>
                        <p class="mt-2 flex">IVA <input type="number" class="border-0 bg-gray-200"
                                style="height: 1.7rem; margin-left: 8.5rem;" value="{{ $iva }}" disabled>
                        </p>
                        <p class="mt-2 flex">TOTAL <input type="number" class="border-0 bg-gray-200"
                                style="height: 1.7rem; margin-left: 7rem;" value="{{ $totalDesc }}" disabled></p>
                    </div>
                    <div class="w-1/2 px-2 ml-5" style="margin-left: 400px;">
                        {{-- <p>FORMA DE PAGO</p>
                        <select
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('clasificacion') border-red-500 @enderror"
                            wire:model.defer="formaPagoSeleccionada" style="width: 50%">
                            <option value=''>Selecciona una forma</option>
                            @foreach ($formaPago as $forma)
                                <option value="{{ $forma }}">{{ $forma }}</option>
                            @endforeach
                        </select>
                        @error('formaPagoSeleccionada')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror --}}
                        <br>
                        <br>
                        <br>
                        <br>
                        <div class="mt-5 pt-4">
                            <button wire:click.prevent="suscripciones()"
                                class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-md">
                                <svg wire:loading wire:target="suscripciones()"
                                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4">
                                    </circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Guardar contrato
                            </button>
                            {{-- <button
                                class="px-4 py-2 text-white bg-green-500 hover:bg-green-600 rounded-md">Nuevo</button> --}}
                            <button class="px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded-md"
                                wire:click.prevent="borrar()">Borrar</button>
                            {{-- <button class="px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded-md">Salir</button> --}}
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center">
                <h1 class="text-2xl text-black font-bold">No hay clientes registrados</h1>
            </div>
        @endif
    </x-slot>

    <x-slot name="footer">

    </x-slot>

</x-jet-dialog-modal>

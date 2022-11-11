<div>
    {{-- The whole world belongs to you. --}}
    <div class="flex m-5">
        <div class="flex-auto">
            <select
                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                wire:model.defer="motivo">
                <option value="" style="display: none;">Selecciona una opción</option>
                <option value="01">Comprobante emitido con errores con relación</option>
                <option value="02">Comprobante emitido con errores sin relación</option>
                <option value="03">No se llevó a cabo la operación</option>
                <option value="04">Operación nominativa relacionada con una factura global</option>
            </select>
        </div>
        <div class="flex-auto">
            <button wire:click="cancelar" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Cancelar Factura
            </button>
        </div>
    </div>
    <iframe src="{{ $facturama }}" width="100%" height="1000px" frameborder="0"></iframe>
</div>

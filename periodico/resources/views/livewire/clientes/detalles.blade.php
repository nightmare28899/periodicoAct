<div class="fixed z-10 inset-0 overflow-y-auto ease-out duration-400">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity">
            <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <br>
        <br>
        <br>
        <div class="inline-block align-bottom rounded-lg text-left overflow-hidden shadow-xl transform transition-all w-2/5"
            role="dialog" aria-modal="true" aria-labelledby="modal-headline">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 mt-8">

                <a class="container max-w-sm rounded-lg shadow-md dark:bg-gray-800">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-black text-center">Datos
                        del cliente:
                        {{ $nombre }}</h5>
                    <div class="flex p-6">
                        <div>
                            <p class="font-normal text-gray-600 text-lg">Datos del Domicilio:</p>
                            <p class="font-normal text-gray-500">
                                <b>Calle:</b> {{ $calle }} <br>
                                <b>No. Interior:</b> {{ $noint }} <br>
                                <b>No. Exterior:</b> {{ $noext }} <br>
                                <b>Colonia:</b> {{ $colonia }} <br>
                                <b>Código Postal:</b> {{ $cp }} <br>
                                <b>Estado:</b> {{ $estado }} <br>
                                <b>País:</b> {{ $pais }} <br>
                                <b>Referencia:</b> {{ $referencia }} <br>
                                <b>Teléfono:</b> {{ $telefono }} <br>
                                <b>Correo Electrónico:</b> {{ $email }} <br>
                                <b>Correo Electrónico Cobranza:</b> {{ $email_cobranza }} <br>
                            </p>
                        </div>

                        <div>
                            <p class="font-normal text-gray-600 text-lg">Cantidad de Ejemplares:</p>
                            <p class="font-normal text-gray-500">
                                <b>Lunes:</b> {{ $lunes }} <br>
                                <b>Martes:</b> {{ $martes }} <br>
                                <b>Miércoles:</b> {{ $miércoles }} <br>
                                <b>Jueves:</b> {{ $jueves }} <br>
                                <b>Viernes:</b> {{ $viernes }} <br>
                                <b>Sábado:</b> {{ $sábado }} <br>
                                <b>Domingo:</b> {{ $domingo }} <br>
                            </p>
                        </div>
                    </div>
                </a>
                <span>
                    <button wire:click="closeDetallesModal()" type="button"
                        class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-red-600 hover:bg-red-700 text-base leading-6 font-bold text-white shadow-sm focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        Cerrar
                    </button>
                </span>
            </div>
        </div>
    </div>
</div>

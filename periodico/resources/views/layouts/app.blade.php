<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body class="font-sans antialiased">
    <x-jet-banner />

    <div class="min-h-screen bg-gray-100">
        @livewire('navigation-menu')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        window.addEventListener('alert', event => {
            /* alert(event.detail.message); */
            /* console.log(event.detail.message); */
            switch (event.detail.message) {
                case '¡Cliente creado correctamente!':
                case '¡Ruta creada correctamente!':
                case '¡Tarifa creada correctamente!':
                case '¡Tiro generado exitosamente!':
                case '¡Remisión generada exitosamente!':
                case '¡Se generó exitosamente la devolución!':
                case '¡Ajuste realizado!':
                case '¡Domicilio creado exitosamente!':
                case '¡Suscripción generada correctamente!':
                case '¡Venta generada exitosamente!':
                case '¡Renovación generada!':
                case '¡Se creo exitosamente la factura!':
                case '¡Se cancelo la factura!':
                case '¡Se realizo el pago!':
                case '¡Si tiene ventas!':
                case '¡Si tiene suscripciones!':
                case '¡Domicilio creado correctamente!':
                case '¡Días agregados exitosamente!':
                case '¡Se agregaron con éxito!':
                case '¡Suspendida correctamente!':
                case '¡Si tiene facturas!':
                case '¡Se regresaron correctamente!':
                    toastr.success(event.detail.message, '¡Exito!');
                    break;
                case '¡Cliente eliminado correctamente!':
                case '¡Debes seleccionar un elemento primero!':
                case '¡Debes seleccionar solo un elemento a la vez!':
                case '¡Debes escoger una fecha primero!':
                case '¡No puedes devolver más cantidad de la que hay!':
                case '¡Seleccione un cliente!':
                case '¡No puedes poner cero!':
                case '¡Selecciona un cliente!':
                case '¡No puedes escoger el mismo domicilio!':
                case '¡No puedes aplicar un descuento mayora la cantidad!':
                case 'Domicilio eliminado correctamente!':
                case '¡Seleccione un domicilio!':
                case '¡Debes seleccionar y buscar un cliente primero!':
                case '¡Debes escoger por lo menos un día!':
                case '¡Falta ingresar la fecha hasta!':
                case '¡Primero escribe el nombre!':
                case '¡No hay registros de esa fecha!':
                case '¡Debes ingresar un valor!':
                case '¡Primero coloca ejemplares!':
                case '¡No puedes poner una cantidad mayor a los ejemplares!':
                case '¡Debes colocar la cantidad en los domicilios!':
                case '¡El cliente ya tiene una suscripción!':
                case '¡Selecciona un cliente primero!':
                case '¡No hay datos registrados!':
                case '¡La cantidad de ejemplares no puede ser mayor a la cantidad de ejemplares existentes!':
                case '¡Debes ingresar la cantidad de ejemplares primero!':
                case '¡Ya existe esa remisión!':
                case '¡Rellena todos los campos!':
                case '¡Ocurrio un error al crear la factura!':
                case '¡Primero escoge el motivo!':
                case '¡No hay ventas para generar la remisión!':
                case '¡No hay suscripciones para generar la remisión!':
                case '¡Selecciona un cliente primero!':
                case '¡No tiene ventas!':
                case '¡No tiene suscripciones!':
                case '¡Debes seleccionar la fecha!':
                case '¡El cliente no tiene domicilio!':
                case '¡No tiene ventas!':
                case '¡No puedes capturar 0 periodicos!':
                case '¡Llena todos los campos!':
                case '¡Esa suscripción ya está suspendida!':
                case '¡No dejes los campos vacios!':
                case '¡No puedes escoger la misma factura!':
                case '¡No tiene facturas!':
                case '¡No tiene domicilio!':
                    toastr.error(event.detail.message, '¡Alerta!');
                    break;
                case '¡El cliente no tiene ningúna venta registrada!':
                case '¡El cliente no tiene suscripciones!':
                    toastr.warning(event.detail.message, '¡Alerta!');
                    break;
                case '¡Cliente actualizado correctamente!':
                case '¡Ruta actualizada correctamente!':
                case '¡Tarifa actualizada correctamente!':
                case '¡Domicilio actualizado correctamente!':
                case '¡Venta actualizada exitosamente!':
                    toastr.info(event.detail.message, '¡Actualizado!');
                    break;
                default:
                    /* toastr.warning(event.detail.message, 'Error'); */
                    break;
            }
        });
    </script>
</body>

</html>

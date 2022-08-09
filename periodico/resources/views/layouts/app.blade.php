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

            console.log(event.detail.message);
            switch (event.detail.message) {
                case '¡Cliente Creado Correctamente!' | '¡Ruta Creada Correctamente!' |
                '¡Tarifa Creada Correctamente!' | '¡Remisión generada exitosamente!' |
                '¡Tiro generado exitosamente!' | '¡Se generó exitosamente la devolución!' | '¡Ajuste realizado!' |
                '¡Domicilio creado exitosamente!' | '¡Suscripción generada correctamente!':
                    toastr.success(event.detail.message, '¡Exito!');
                    break;
                case '¡Cliente Eliminado Correctamente!' | '¡Debes seleccionar un elemento primero!' |
                '¡Debes seleccionar solo un elemento a la vez!' | '¡Debes escoger una fecha primero!' |
                '¡No puedes devolver más cantidad de la que hay!' | '¡Seleccione un cliente!' |
                '¡No puedes poner cero!' | '¡Selecciona un cliente!', '¡No puedes escoger el mismo domicilio!',
                '¡No puedes aplicar un descuento mayora la cantidad!', 'Domicilio Eliminado Correctamente!',
                '¡Seleccione un domicilio!', '¡Debes seleccionar un cliente primero!':
                    toastr.error(event.detail.message, '¡Alerta!');
                    break;
                case 'warning':
                    toastr.warning(event.detail.message, event.detail.title);
                    break;
                case '¡Cliente Actualizado Correctamente!' | '¡Ruta Actualizada Correctamente!' |
                '¡Tarifa Actualizada Correctamente!':
                    toastr.info(event.detail.message, '¡Actualizado!');
                    break;
                default:
                    toastr.success(event.detail.message, event.detail.title);
                    break;
            }
        });
    </script>
</body>

</html>

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
            if (event.detail.message == '¡Cliente Creado Correctamente!') {
                toastr.success(event.detail.message, '¡Exito!');
            } else if (event.detail.message == '¡Cliente Eliminado Correctamente!') {
                toastr.error(event.detail.message, '¡Alerta!');
            } else if (event.detail.message == '¡Cliente Actualizado Correctamente!') {
                toastr.info(event.detail.message, '¡Actualizado!');
            } else if (event.detail.message == '¡Ruta Creada Correctamente!') {
                toastr.success(event.detail.message, '¡Exito!');
            } else if (event.detail.message == '¡Ruta Actualizada Correctamente!') {
                toastr.info(event.detail.message, '¡Actualizado!');
            } else if(event.detail.message == '¡Tarifa Creada Correctamente!') {
                toastr.success(event.detail.message, '¡Exito!');
            } else if(event.detail.message == '¡Tarifa Actualizada Correctamente!') {
                toastr.info(event.detail.message, '¡Actualizado!');
            } else if(event.detail.message == '¡Debes seleccionar un elemento primero!') {
                toastr.error(event.detail.message, '¡Error!');
            } else if(event.detail.message == '¡Remisión generada exitosamente!') {
                toastr.success(event.detail.message, '¡Exito!');
            } else if(event.detail.message == '¡Tiro generado exitosamente!') {
                toastr.success(event.detail.message, '¡Exito!');
            } else if(event.detail.message == '¡Debes escoger una fecha primero!') {
                toastr.error(event.detail.message, '¡Error!');
            } else if(event.detail.message == '¡Debes seleccionar solo un elemento a la vez!') {
                toastr.error(event.detail.message, '¡Error!');
            } else if(event.detail.message == '¡Se generó exitosamente la devolución!' ) {
                toastr.success(event.detail.message, '¡Exito!');
            } else if(event.detail.message == '¡No puedes devolver más cantidad de la que hay!') {
                toastr.error(event.detail.message, '¡Error!');
            } else if(event.detail.message == '¡Ajuste realizado!') {
                toastr.success(event.detail.message, '¡Exito!');
            }

            
        });
    </script>
</body>

</html>

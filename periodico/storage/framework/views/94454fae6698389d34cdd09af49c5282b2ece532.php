<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="<?php echo e(mix('css/app.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <?php echo \Livewire\Livewire::styles(); ?>


    <!-- Scripts -->
    <script src="<?php echo e(mix('js/app.js')); ?>" defer></script>
</head>

<body class="font-sans antialiased">
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.banner','data' => []] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-banner'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <div class="min-h-screen bg-gray-100">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('navigation-menu')->html();
} elseif ($_instance->childHasBeenRendered('lPzSgjY')) {
    $componentId = $_instance->getRenderedChildComponentId('lPzSgjY');
    $componentTag = $_instance->getRenderedChildComponentTagName('lPzSgjY');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('lPzSgjY');
} else {
    $response = \Livewire\Livewire::mount('navigation-menu');
    $html = $response->html();
    $_instance->logRenderedChild('lPzSgjY', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

        <!-- Page Heading -->
        <?php if(isset($header)): ?>
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <?php echo e($header); ?>

                </div>
            </header>
        <?php endif; ?>

        <!-- Page Content -->
        <main>
            <?php echo e($slot); ?>

        </main>
    </div>

    <?php echo $__env->yieldPushContent('modals'); ?>

    <?php echo \Livewire\Livewire::scripts(); ?>


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
                case '¡Suscripción cancelada correctamente!':
                case '¡Venta cancelada correctamente!':
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
                case '¡El monto ingresado es mayor al total de la factura!':
                case '¡Selecciona una factura primero!':
                case '¡Llena todos los campos!':
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
<?php /**PATH C:\Users\Nightmare28899\Documents\GitHub\periodicoAct\periodico\resources\views/layouts/app.blade.php ENDPATH**/ ?>
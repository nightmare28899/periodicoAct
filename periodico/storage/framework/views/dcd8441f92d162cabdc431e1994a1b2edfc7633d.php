<div class="container mx-auto">
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-black leading-tight">
            <?php echo e(__('Generar Tiro')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <div class="flex-none mt-1">
                        <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha</label>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['class' => 'w-full','type' => 'date','wire:model' => 'from']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-full','type' => 'date','wire:model' => 'from']); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    <div class="flex-none mt-1 ml-3">
                        <label for="fecha" class="block text-sm font-medium text-gray-700">Ruta</label>
                        <select
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                            style="width: 11rem;" wire:model="rutaSeleccionada">
                            <option value='Todos' selected>TODOS</option>
                            <?php $__currentLoopData = $ruta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rut): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value='<?php echo e($rut['nombreruta']); ?>'>
                                    <?php echo e($rut['nombreruta']); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="flex-initial ml-3 mx-1 mt-7" style="width: 80%;">
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.button','data' => ['class' => 'bg-green-500 hover:bg-green-600','wire:click' => 'regresarQuitados']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'bg-green-500 hover:bg-green-600','wire:click' => 'regresarQuitados']); ?>
                            <?php echo e(__('Regresar quitados')); ?>

                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    <div class="flex-initial ml-3 mt-4" style="width: 10%;">
                        <button wire:click="descarga" wire:loading.attr="disabled"
                            class="p-2 bg-green-500 rounded-md text-white hover:bg-green-700 ">
                            <svg wire:loading wire:target="descarga" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Generar Tiro
                        </button>
                    </div>
                </div>
                <br>
                <?php if(session()->has('message')): ?>
                    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3"
                        role="alert">
                        <div class="flex">
                            <div>
                                <p class="text-sm"><?php echo e(session('message')); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="text-center overflow-x">
                    <div class="overflow-x-auto">
                        <table class="table-auto border-separate border-spacing-2 border border-dark w-full uppercase">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 uppercase">Ruta</th>
                                    <th class="px-4 py-2 uppercase">Día</th>
                                    <th class="px-4 py-2 uppercase">Tipo</th>
                                    <th class="px-4 py-2 uppercase">Cliente</th>
                                    <th class="px-4 py-2 uppercase">Dirección</th>
                                    <th class="px-4 py-2 uppercase">Referencia</th>
                                    <th class="px-4 py-2 uppercase">Ejemplares</th>
                                    <th class="px-4 py-2 uppercase">Fecha</th>
                                    <th class="px-4 py-2 w-20">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sum_ejemplares = 0; ?>
                                <?php $ventasClientes = 0; ?>
                                <?php $__currentLoopData = $ventas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($result->{$diaS} != 0 && $result->estado == 'Activo' && $result->tiroStatus == 'Activo'): ?>
                                        <tr>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($result->nombreruta); ?>, Tipo:
                                                <?php echo e($result->tiporuta); ?>, Repartidor: <?php echo e($result->repartidor); ?>,
                                                Cobrador: <?php echo e($result->cobrador); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($diaS); ?> </td>
                                            <td class="px-4 py-2 border border-dark">Venta/Cliente</td>
                                            <?php if($result->nombre): ?>
                                                <td class="px-4 py-2 border border-dark"><?php echo e($result->nombre); ?></td>
                                            <?php else: ?>
                                                <td class="px-4 py-2 border border-dark"><?php echo e($result->razon_social); ?>

                                                </td>
                                            <?php endif; ?>
                                            <td class="px-4 py-2 border border-dark">Calle: <?php echo e($result->calle); ?> <br>
                                                No. Ext:
                                                <?php echo e($result->noext); ?>, CP: <?php echo e($result->cp); ?>, <br> Localidad:
                                                <?php echo e($result->localidad); ?>, Municipio: <?php echo e($result->municipio); ?>

                                            </td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($result->referencia); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($result->{$diaS}); ?></td>
                                            <td class="px-4 py-2 border border-dark">
                                                <?php echo e(\Carbon\Carbon::parse($dateF)->format('d/m/Y')); ?></td>
                                            <td class="px-4 py-2 border border-dark">
                                                <button wire:click="pausarVenta('<?php echo e($result->idVenta); ?>')"
                                                    class="px-2 py-1 cursor-pointer bg-red-500 hover:bg-red-600 text-white my-2 rounded-lg">
                                                    Quitar
                                                </button>
                                            </td>
                                        </tr>
                                        <?php $sum_ejemplares += $result->{$diaS}; ?>
                                        <?php $ventasClientes = $loop->index + 1; ?>
                                    <?php else: ?>
                                        <tr>

                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                <?php $sum_ejemplaressus = 0; ?>
                                <?php $suscripcionesClientes = 0; ?>
                                <?php $__currentLoopData = $suscripcion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suscrip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(($suscrip->{$diaS} != 0 &&
                                        $suscrip->tiroStatus === 'Activo' &&
                                        $suscrip->remisionStatus === 'Remisionado') ||
                                        $suscrip->contrato === 'Cortesía'): ?>
                                        <tr>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($suscrip->nombreruta); ?>, Tipo:
                                                <?php echo e($suscrip->tiporuta); ?>, Repartidor: <?php echo e($suscrip->repartidor); ?>,
                                                Cobrador: <?php echo e($suscrip->cobrador); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($diaS); ?> </td>
                                            <td class="px-4 py-2 border border-dark">Suscripción</td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($suscrip->nombre); ?></td>
                                            <td class="px-4 py-2 border border-dark">Calle: <?php echo e($suscrip->calle); ?> <br>
                                                No. Ext:
                                                <?php echo e($suscrip->noext); ?>, CP: <?php echo e($suscrip->cp); ?>, <br> Localidad:
                                                <?php echo e($suscrip->localidad); ?>, Ciudad: <?php echo e($suscrip->ciudad); ?>

                                            </td>
                                            <td wire:model="referencia" class="px-4 py-2 border border-dark">
                                                <?php echo e($suscrip->referencia); ?></td>
                                            <td class="px-4 py-2 border border-dark">
                                                <?php echo e($suscrip->{$diaS} != 0 ? $suscrip->cantEjemplares : 0); ?></td>
                                            <td wire:model="fecha" class="px-4 py-2 border border-dark">
                                                <?php echo e(\Carbon\Carbon::parse($dateF)->format('d/m/Y')); ?></td>
                                            <td class="px-4 py-2 border border-dark">
                                                <button wire:click="pausarSuscripcion('<?php echo e($suscrip->idSuscripcion); ?>')"
                                                    class="px-2 py-1 cursor-pointer bg-red-500 hover:bg-red-600 text-white my-2 rounded-lg">
                                                    Quitar
                                                </button>
                                            </td>
                                        </tr>
                                        <?php $sum_ejemplaressus += $suscrip->cantEjemplares; ?>
                                        <?php $suscripcionesClientes = $loop->index + 1; ?>
                                    <?php else: ?>
                                        <tr>

                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <p class="uppercase">Total vta. periodico &nbsp;&nbsp;&nbsp; <b>#ejemp: <?php echo e($sum_ejemplares); ?>

                            &nbsp;&nbsp; clientes: <?php echo e($ventasClientes); ?></b> </p>
                    <p class="uppercase">Total vta. suscripciones &nbsp;&nbsp;&nbsp; <b>#ejemp:
                            <?php echo e($sum_ejemplaressus); ?> &nbsp;&nbsp; clientes: <?php echo e($suscripcionesClientes); ?></b> </p>
                    <p class="uppercase text-blue-700">Totales <b class="text-red-700">ejemplares</b>
                        <?php echo e($sum_ejemplares + $sum_ejemplaressus); ?> <b class="text-red-700">clientes</b>
                        <?php echo e($ventasClientes + $suscripcionesClientes); ?></p>
                </div>
                <br>
                
                <br>
            </div>
        </div>
    </div>
</div>
</div>
<?php /**PATH C:\Users\Nightmare28899\Documents\GitHub\periodicoAct\periodico\resources\views/livewire/tiros/tiro.blade.php ENDPATH**/ ?>
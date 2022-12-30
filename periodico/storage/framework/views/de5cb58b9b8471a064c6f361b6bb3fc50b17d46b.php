<div class="container mx-auto">
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-black leading-tight">
            <?php echo e(__('Historial de Suscripciones')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex-initial mx-1 mt-4 mb-3">
                    <input type="text"
                        class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-64 uppercase"
                        name="search" placeholder="Buscar por cliente" wire:model="query" autocomplete="off" />

                    <select wire:model="estatusPago"
                        class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-64 uppercase">
                        <option style="display: none;">Escoge una opcion</option>
                        <option value="Todas">Todas</option>
                        <option value="Pagado">Pagado</option>
                        <option value="facturado">Facturado</option>
                        <option value="sin pagar">Sin pagar</option>
                        <option value="cancelado">Cancelado</option>
                    </select>

                    <label for="fechaInicio">Del</label>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'date','wire:model' => 'de']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','wire:model' => 'de']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>


                    <label for="fechaFin">Hasta</label>
                    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'date','wire:model' => 'hasta']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','wire:model' => 'hasta']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                </div>
                <div class="flex-initial mx-1 mt-4 mb-3">

                </div>
                <div class="text-center overflow-x">
                    <div class="overflow-x-auto w-full">
                        <table class="table-auto border-separate border-spacing-2 border border-dark uppercase">
                            <thead>
                                <tr class='bg-gray-100'>
                                    <th class='px-4 py-2 uppercase'>Contrato</th>
                                    <th class='px-4 py-2 uppercase'>Cliente</th>
                                    <th class='px-6 py-2 uppercase'>Nombre</th>
                                    <th class='px-4 py-2 uppercase'>Calle</th>
                                    <th class='px-4 py-2 uppercase'># No Int</th>
                                    <th class='px-4 py-2 uppercase'># Ext</th>
                                    <th class='px-4 py-2 uppercase'>Colonia</th>
                                    <th class='px-4 py-2 uppercase'>Ejemplares</th>
                                    <th class='px-4 py-2 uppercase'>Periodo</th>
                                    <th class='px-4 py-2 uppercase'>Estado</th>
                                    <th class='px-4 py-2 uppercase'>Fecha Inicial</th>
                                    <th class='px-6 py-2 uppercase'>Fecha Fin</th>
                                    <th class="px-6 py-2 uppercase">Pagado</th>
                                    <th class="px-6 py-2 uppercase">Fecha</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if($suscripciones): ?>
                                    <?php $__currentLoopData = $suscripciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suscripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class='px-4 py-2 border border-dark'><?php echo e($suscripcion->id); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($suscripcion->cliente_id); ?></td>
                                            <td class='px-4 py-2 border border-dark'><?php echo e($suscripcion->nombre); ?></td>
                                            <td class='px-4 py-2 border border-dark'><?php echo e($suscripcion->calle); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($suscripcion->noint); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($suscripcion->enoxt); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($suscripcion->colonia); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($suscripcion->cantEjemplares); ?>

                                            </td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($suscripcion->periodo); ?></td>
                                            <td
                                                class="px-4 py-2 border border-dark text-white <?php echo e($suscripcion->estado == 'Activo' ? 'bg-green-500' : ($suscripcion->estado == 'Pausado' || $suscripcion->estado == 'Cancelada' ? 'bg-red-500' : '')); ?>">
                                                <?php echo e($suscripcion->estado == 'Pausado' || $suscripcion->estado == 'Cancelada' ? 'Inactivo' :  'Activo'); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($suscripcion->fechaInicio); ?>

                                            </td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($suscripcion->fechaFin); ?></td>
                                            <td class="px-4 py-2 border border-dark">
                                                <?php echo e($suscripcion->status); ?>

                                            </td>
                                            <td class="px-4 py-2 border border-dark">
                                                <?php echo e(\Carbon\Carbon::parse($suscripcion->created_at)->format('Y-m-d')); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <?php if($suscripcionSuspendida): ?>
                                    <?php $__currentLoopData = $suscripcionSuspendida; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suscripcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class='px-4 py-2 border border-dark'><?php echo e($suscripcion->id); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($suscripcion->cliente_id); ?>

                                            </td>
                                            <td class='px-4 py-2 border border-dark'><?php echo e($suscripcion->nombre); ?></td>
                                            <td class='px-4 py-2 border border-dark'><?php echo e($suscripcion->calle); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($suscripcion->noint); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($suscripcion->enoxt); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($suscripcion->colonia); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($suscripcion->cantEjemplares); ?>

                                            </td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($suscripcion->periodo); ?></td>
                                            <td class="px-4 py-2 border border-dark bg-orange-500 text-white">
                                                Suspendida </td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($suscripcion->fechaInicio); ?>

                                            </td>
                                            <td class="px-4 py-2 border border-dark">
                                                <?php echo e(\Carbon\Carbon::parse($suscripcion->fechaFin)->format('Y-m-d')); ?>

                                            </td>
                                            <td class="px-4 py-2 border border-dark">
                                                <?php echo e($suscripcion->status); ?>

                                            </td>
                                            <td class="px-4 py-2 border border-dark">
                                                <?php echo e(\Carbon\Carbon::parse($suscripcion->created_at)->format('Y-m-d')); ?>

                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <p>REGISTROS: <?php echo e(count($suscripciones) + count($suscripcionSuspendida)); ?></p>
            </div>
        </div>
    </div>
</div>
</div>
<?php /**PATH C:\Users\Nightmare28899\Documents\GitHub\periodicoAct\periodico\resources\views/livewire/historial-suscripciones.blade.php ENDPATH**/ ?>
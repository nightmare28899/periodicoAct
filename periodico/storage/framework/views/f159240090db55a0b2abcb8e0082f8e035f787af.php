<div class="container mx-auto">
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-black leading-tight">
            <?php echo e($tipo === 'suscripciones' ? __('Historial de suscripciones') : __('Historial de ventas')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex mb-5">
                    <div class="w-72 mt-6">
                        <input type="text"
                            class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                            name="search" id="search" placeholder="Buscar Cliente: nombre o id" wire:model="clienteSeleccionado"
                            autocomplete="off" />
                    </div>
                </div>
                <div class="text-center overflow-x">
                    <div class="overflow-x-auto">
                        <table class="table-auto border-separate border-spacing-2 border border-dark w-full uppercase">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-4 py-2 uppercase">Id</th>
                                    <th class="px-4 py-2 uppercase">Cliente</th>
                                    <th class="px-4 py-2 uppercase">Nombre</th>
                                    <th class="px-4 py-2 uppercase">Entregar</th>
                                    <th class="px-4 py-2 uppercase">Devuelto</th>
                                    <th class="px-4 py-2 uppercase">Precio</th>
                                    <th class="px-4 py-2 uppercase">Status</th>
                                    <th class="px-4 py-2 uppercase">Total</th>
                                    <th class="px-4 py-2 uppercase">Fecha</th>
                                    <th class="px-4 py-2 w-20">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(count($ventas) > 0): ?>
                                    <?php $__currentLoopData = $ventas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="uppercase">
                                            <td class="px-4 py-2 border border-dark"><?php echo e($result->id); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($result->cliente_id); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($result->cliente); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($result->entregar); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($result->devuelto); ?></td>
                                            <td class="px-4 py-2 border border-dark">
                                                <?php echo e($tipo === 'suscripciones' ? sprintf('$ %s', number_format($result->importe / $result->entregar, 2)) : sprintf('$ %s', number_format($result->importe, 2))); ?>

                                            </td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($result->status); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e(sprintf('$ %s', number_format($result->importe, 2))); ?></td>
                                            <td class="px-4 py-2 border border-dark">
                                                <?php echo e(\Carbon\Carbon::parse($result->fecha)->format('d/m/Y')); ?></td>
                                            <td class="px-4 py-2 border border-dark">
                                                <?php if($result->status != 'Cancelado'): ?>
                                                    <button
                                                        wire:click="canlcelarVenta('<?php echo e($tipo == 'ventas' ? $result->idVenta : $result->idSuscripcion); ?>')"
                                                        class="px-2 py-1 cursor-pointer bg-red-500 hover:bg-red-600 text-white my-2 rounded-lg">
                                                        <?php echo e($tipo === 'suscripciones' ? 'Cancelar suscripción' : 'Cancelar venta'); ?>

                                                    </button>
                                                <?php else: ?>
                                                    <button
                                                        class="px-2 py-1 cursor-pointer bg-green-500 hover:bg-green-600 text-white my-2 rounded-lg">
                                                        <?php echo e($tipo === 'suscripciones' ? 'Suscripción cancelada' : 'Venta cancelada'); ?>

                                                    </button>
                                                    <button
                                                        wire:click="verPDF('<?php echo e($tipo == 'ventas' ? $result->idVenta : $result->idSuscripcion); ?>')"
                                                        class="px-2 py-1 cursor-pointer bg-blue-500 hover:bg-blue-600 text-white my-2 rounded-lg">
                                                        <?php echo e('Ver PDF'); ?>

                                                    </button>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<?php /**PATH C:\Users\Nightmare28899\Documents\GitHub\periodicoAct\periodico\resources\views/livewire/cancelar-ventas.blade.php ENDPATH**/ ?>
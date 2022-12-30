<div class="w-2/3 mx-auto">
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-black leading-tight">
            <?php echo e(__('Historial de facturas')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <div class="w-64">
                        <h4>Elige la fecha:</h4>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['class' => 'w-full','type' => 'date','wire:model' => 'fechaFactura']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-full','type' => 'date','wire:model' => 'fechaFactura']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    <div class="w-64 ml-5 pt-6">
                        <input type="number"
                            class=" text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                            name="search" placeholder="Buscar por id" wire:model="idCliente" autocomplete="off" min='0'/>
                    </div>
                    <div class="w-64 ml-5 pt-6">
                        <input type="text"
                            class=" text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                            name="search" id="search" placeholder="Buscar Cliente" wire:model="query"
                            autocomplete="off" />

                        <?php if(!empty($query)): ?>

                            <div class="fixed top-0 right-0 bottom-0 left-0" wire:click="resetear"></div>

                            <div class="absolute z-10 list-group bg-white rounded-t-none shadow-lg">

                                <?php if(!empty($clientesBuscados)): ?>

                                    <?php $__currentLoopData = $clientesBuscados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $buscado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div wire:click="selectContact(<?php echo e($i); ?>)"
                                            class="list-item list-none p-2 hover:text-white hover:bg-blue-600 cursor-pointer">
                                            <?php echo e($buscado['nombre']); ?>

                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="list-item list-none p-2">No hay resultado</div>
                                <?php endif; ?>
                            </div>

                        <?php endif; ?>
                    </div>
                </div>
                <br>

                <?php if($invoices): ?>
                    <div class="text-center overflow-x">
                        <div class="overflow-x-auto w-full">
                            <table class="table-auto border-separate border-spacing-2 border border-dark uppercase">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-4 py-2 uppercase">Fecha</th>
                                        <th class="px-4 py-2 uppercase">Tipo</th>
                                        <th class="px-4 py-2 uppercase">Cliente</th>
                                        <th class="px-4 py-2 uppercase">Ejemplares</th>
                                        <th class="px-4 py-2 uppercase">Total</th>
                                        <th class="px-4 py-2 uppercase">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-4 py-2 border border-dark">
                                                <?php echo e(\Carbon\Carbon::parse($invoice->invoice_date)->format('d/m/Y')); ?>

                                            </td>
                                            <td class="border">
                                                <?php echo e(substr($invoice->idTipo, 0, 6) == 'suscri' ? 'Suscripción' : 'Venta/Cliente'); ?>

                                            </td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($invoice->cliente); ?></td>
                                            <td class="px-4 py-2 border border-dark"><?php echo e($invoice->quantity); ?></td>
                                            <td class="px-4 py-2 border border-dark">$<?php echo e($invoice->total); ?>

                                                <?php echo e($invoice->currency); ?></td>
                                            <td class="px-4 py-2 border border-dark">
                                                <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                    href="<?php echo e(url('vistaPrevia/' . $invoice->invoice_id)); ?>">Ver PDF</a>
                                                <?php if($invoice->status == 'cancelada'): ?>
                                                    <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-red-500 hover:bg-red-600 rounded-lg focus:shadow-outline"
                                                        disabled>Factura
                                                        cancelada</a>
                                                <?php else: ?>
                                                    <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-red-500 hover:bg-red-600 rounded-lg focus:shadow-outline"
                                                        href="<?php echo e(url('cancelarFactura/' . $invoice->invoice_id)); ?>">Cancelar
                                                        factura</a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="13" class="border">No hay facturas</td>
                                    </tr>
                <?php endif; ?>
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
</div>
<?php /**PATH C:\Users\Nightmare28899\Documents\GitHub\periodicoAct\periodico\resources\views/livewire/factura/historial-f.blade.php ENDPATH**/ ?>
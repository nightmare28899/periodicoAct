<div class="container mx-auto">
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-black leading-tight">
            <?php echo e(__('Listado de facturas')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <div class="w-64">
                        <h4>Elige la fecha:</h4>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['class' => 'w-full','type' => 'date','wire:model' => 'fechaRemision']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-full','type' => 'date','wire:model' => 'fechaRemision']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    <div class="w-64 ml-5 pt-6">
                        <input type="text"
                            class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                            name="search" placeholder="Buscar por ID cliente" wire:model="idCliente"
                            autocomplete="off" />
                    </div>
                    <div class="w-64 ml-5 pt-6">
                        <input type="text"
                            class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                            name="search" id="search" placeholder="Buscar Cliente" wire:model="query"
                            autocomplete="off" />

                        <?php if(!empty($query)): ?>

                            <div class="fixed top-0 right-0 bottom-0 left-0" wire:click="resetear"></div>

                            <div class="absolute z-10 list-group bg-white rounded-t-none shadow-lg">

                                <?php if(!empty($clientesBuscados)): ?>

                                    <?php $__currentLoopData = $clientesBuscados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $buscado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div wire:click="selectContact(<?php echo e($i); ?>)"
                                            class="list-item list-none p-2 hover:text-white hover:bg-blue-600 cursor-pointer w-full">
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

                <?php if($tiros): ?>
                    <div class="text-center overflow-x">
                        <div class="overflow-x-auto w-full">
                            <table class="table-auto border-separate border-spacing-2 border border-dark uppercase">
                                <thead>
                                    <tr class='bg-gray-100'>
                                        <th class='px-4 py-2 uppercase'>Fecha</th>
                                        <th class='px-6 py-2 uppercase'>id</th>
                                        <th class='px-4 py-2 uppercase'>Cliente</th>
                                        <th class='px-4 py-2 uppercase'>Entregar</th>
                                        <th class='px-4 py-2 uppercase'>Devuelto</th>
                                        <th class='px-4 py-2 uppercase'>Faltante</th>
                                        <th class='px-4 py-2 uppercase'>Venta</th>
                                        <th class='px-4 py-2 uppercase'>Precio</th>
                                        <th class='px-4 py-2 uppercase'>Importe</th>
                                        <th class='px-6 py-2 uppercase'>Dia</th>
                                        <th class='px-6 py-2 uppercase'>Nombre Ruta</th>
                                        <th class='px-6 py-2 uppercase'>Tipo</th>
                                        <th class="px-6 py-2 uppercase">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $__currentLoopData = $tiros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tiro): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($tiro->status == 'Pagado'): ?>
                                            <tr>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <?php echo e(\Carbon\Carbon::parse($tiro->fecha)->format('d/m/Y')); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->idTipo); ?></td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <?php echo e($tiro->cliente ? $tiro->cliente : $tiro->razon_social); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->entregar); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->devuelto); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->faltante); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->venta); ?></td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <?php echo e(sprintf('$ %s', number_format($tiro->precio, 2))); ?>

                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <?php echo e(sprintf('$ %s', number_format($tiro->importe, 2))); ?>

                                                </td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->dia); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->nombreruta); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->tipo); ?></td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                        href="<?php echo e(url('factura/' . $tiro->cliente_id . '/' . $tiro->idTipo)); ?>">Facturar</a>
                                                </td>
                                            </tr>
                                        <?php elseif($tiro->status == 'facturado'): ?>
                                            <tr>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <?php echo e(\Carbon\Carbon::parse($tiro->fecha)->format('d/m/Y')); ?></td>
                                                <td class='px-4 py-2'><?php echo e($tiro->idTipo); ?></td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <?php echo e($tiro->cliente ? $tiro->cliente : $tiro->razon_social); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->entregar); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->devuelto); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->faltante); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->venta); ?></td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <?php echo e(sprintf('$ %s', number_format($tiro->precio, 2))); ?>

                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <?php echo e(sprintf('$ %s', number_format($tiro->importe, 2))); ?>

                                                </td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->dia); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->nombreruta); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->tipo); ?></td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                        disabled>Facturado</a>
                                                </td>
                                            </tr>
                                        <?php elseif($tiro->status == 'cancelado'): ?>
                                            <tr>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <?php echo e(\Carbon\Carbon::parse($tiro->fecha)->format('d/m/Y')); ?></td>
                                                <td class='px-4 py-2'><?php echo e($tiro->idTipo); ?></td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <?php echo e($tiro->cliente ? $tiro->cliente : $tiro->razon_social); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->entregar); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->devuelto); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->faltante); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->venta); ?></td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <?php echo e(sprintf('$ %s', number_format($tiro->precio, 2))); ?>

                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <?php echo e(sprintf('$ %s', number_format($tiro->importe, 2))); ?>

                                                </td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->dia); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->nombreruta); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($tiro->tipo); ?></td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <a class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-red-500 hover:bg-red-600 rounded-lg focus:shadow-outline"
                                                        disabled>Cancelado</a>
                                                </td>
                                            </tr>
                                            
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center">
                        <h1 class="text-2xl text-black font-bold">No hay registros</h1>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Nightmare28899\Documents\GitHub\periodicoAct\periodico\resources\views/livewire/facturasListado.blade.php ENDPATH**/ ?>
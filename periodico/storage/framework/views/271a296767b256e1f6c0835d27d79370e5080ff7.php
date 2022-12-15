<div class="mx-auto">
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-black leading-tight">
            <?php echo e(__('Lista de Remisiones')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="grid justify-items-start">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4 justify-self-center">
                <div class="flex">
                    <div class="flex-none mx-1">
                        <h4>Elige la fecha:</h4>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'date','wire:model' => 'fechaRemision']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','wire:model' => 'fechaRemision']); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                    </div>
                    <div class="flex-none">
                        <h4>Busca el cliente:</h4>
                        <input type="text"
                            class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                            name="search" id="search" placeholder="Buscar Cliente" wire:model="query"
                            autocomplete="off" />
                    </div>
                    <br>
                    <div class="flex-none mx-1">
                        <h4>Desde:</h4>
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
                    </div>
                    <div class="flex-none mx-1">
                        <h4>Hasta:</h4>
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
                    <div class="flex-none mx-1">
                        <h4>Ruta:</h4>
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
                    <div class="flex-none mx-1">
                        <h4>Tipo</h4>
                        <select
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 p-2.5"
                            style="width: 11rem;" wire:model="tipoSeleccionada">
                            <option value='todos'>TODOS</option>
                            <option value='venta'>
                                Venta/Cliente
                            </option>
                            <option value='suscripcion'>
                                Suscripción
                            </option>
                        </select>
                    </div>
                    <div class="flex-none pt-1">
                        <div>
                            <button wire:click="descargaTodasRemisiones" id="tiro" wire:loading.attr="disabled"
                                class="p-2 bg-green-500 rounded-md text-white hover:bg-green-700">
                                <svg wire:loading wire:target="descargaTodasRemisiones"
                                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4">
                                    </circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Generar Todas
                            </button>
                        </div>
                        <div class="mt-1">
                            <button wire:click="descargaRemision" id="tiro" wire:loading.attr="disabled"
                                class="p-2 bg-green-500 rounded-md text-white hover:bg-green-700">
                                <svg wire:loading wire:target="descargaRemision"
                                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="4">
                                    </circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                Generar Seleccion
                            </button>
                        </div>
                    </div>
                </div>
                <br>
                <div class="text-center overflow-x">
                    <div class="overflow-x-auto">
                        <table class="table-auto border-separate border-spacing-2 border border-dark w-full uppercase">
                            <thead>
                                <tr class='bg-gray-100'>
                                    <th class='px-4 py-2 uppercase'>Fecha</th>
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($this->ventaCopia): ?>
                                    <?php $__currentLoopData = $ventaCopia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(/* $result->{$diaS} != 0 &&  */$result->remisionStatus == 'Pendiente'): ?>
                                            <tr>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <div class="form-group">
                                                        <input wire:model="clienteSeleccionado" type="checkbox"
                                                            value=<?php echo e($result->idVenta); ?>>
                                                        <label class="text-black"
                                                            for="Física"><?php echo e(\Carbon\Carbon::parse($result->created_at)->format('d/m/Y')); ?></label>
                                                    </div>
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <?php echo e($result->nombre ? $result->nombre : $result->razon_social); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($result->{$diaS}); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($devuelto); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($faltante); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($result->{$diaS}); ?></td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    $<?php echo e($diaS == 'domingo' ? $result->dominical : $result->ordinario); ?>

                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    $<?php echo e(($diaS == 'domingo' ? $result->dominical : $result->ordinario) * $result->{$diaS}); ?>

                                                </td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($diaS); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($result->nombreruta); ?>

                                                </td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($result->tiporuta); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
                                    </tr>
                                <?php endif; ?>
                                <?php if($suscripcionCopia): ?>
                                    <?php $__currentLoopData = $suscripcionCopia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suscri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($suscri->remisionStatus != 'Remisionado'): ?>
                                            <tr>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <div class="form-group">
                                                        <input wire:model="clienteSeleccionado" type="checkbox"
                                                            value=<?php echo e($suscri->idSuscripcion); ?>>
                                                        <label class="text-black"
                                                            for="Física"><?php echo e(\Carbon\Carbon::parse($suscri->created_at)->format('d/m/Y')); ?></label>
                                                    </div>
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    <?php echo e($suscri->nombre ? $suscri->nombre : $suscri->razon_social); ?>

                                                </td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($suscri->cantEjemplares); ?>

                                                </td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($devuelto); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($faltante); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($suscri->cantEjemplares); ?>

                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    $<?php echo e($suscri->importe / $suscri->cantEjemplares); ?></td>
                                                </td>
                                                <td class='px-4 py-2 border border-dark'>
                                                    $<?php echo e($suscri->importe); ?>

                                                </td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($diaS); ?></td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($suscri->nombreruta); ?>

                                                </td>
                                                <td class='px-4 py-2 border border-dark'><?php echo e($suscri->tiporuta); ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <tr>
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
<?php /**PATH C:\Users\Nightmare28899\Documents\GitHub\periodicoAct\periodico\resources\views/livewire/remisiones/generar.blade.php ENDPATH**/ ?>
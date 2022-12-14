<div class="container mx-auto">
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-black leading-tight">
            <?php echo e(__('Lista de Clientes')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex">
                    <div class="flex-initial mx-1 mt-4" style="width: 100%;">
                        
                        <input type="text"
                               class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                               name="search" placeholder="Buscar Cliente por Nombre o ID" wire:model="query" autocomplete="off" />
                    </div>
                    <div class="flex-none mx-1">
                        
                        <button wire:click="modalSuscripciones"
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">
                            Generar Suscripción
                        </button>
                    </div>
                    <div class="flex-none mx-1">
                        
                        <button wire:click="modalVentas"
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base font-bold text-white shadow-sm hover:bg-blue-700">
                            Generar Venta
                        </button>
                    </div>
                    
                    <div class="flex-none mx-1">
                        <button wire:click="create"
                            class="my-4 inline-flex justify-center rounded-md border border-transparent px-4 py-2 bg-green-600 text-base font-bold text-white shadow-sm hover:bg-green-700">
                            Crear Cliente
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

                <?php if($isModalOpen): ?>
                    <?php echo $__env->make('livewire.clientes.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <?php if($ejemplarModalOpen): ?>
                    <?php echo $__env->make('livewire.ejemplares.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <?php if($detallesModalOpen): ?>
                    <?php echo $__env->make('livewire.clientes.detalles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <?php if($suscripciones): ?>
                    <?php echo $__env->make('livewire.suscripciones.suscripciones', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <?php if($modalDomSubs): ?>
                    <?php echo $__env->make('livewire.modals.modal-dom-subs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <?php if($modalFormDom): ?>
                    <?php echo $__env->make('livewire.modals.modal-form-subs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <?php if($modalV): ?>
                    <?php echo $__env->make('livewire.modals.modal-form-venta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
                <?php if($clienteModalOpen): ?>
                    <?php echo $__env->make('livewire.domicilios.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>

                <div class="overflow-x-auto w-full">

                    <table class="table-auto border-separate border-spacing-2 border border-dark text-center uppercase">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 w-20 uppercase">ID</th>
                                <th class="px-4 py-2 w-20 uppercase">Clasificación</th>
                                <th class="px-4 py-2 w-20 uppercase">Persona</th>
                                <th class="px-4 py-2 w-20 uppercase">RFC</th>
                                <th class="px-4 py-2 w-20 uppercase">Nombre</th>
                                <th class="px-4 py-2 w-20 uppercase">Estado</th>
                                <th class="px-4 py-2 w-20 uppercase">País</th>
                                <th class="px-4 py-2 w-20 uppercase">Email</th>
                                <th class="px-4 py-2 w-20 uppercase">Email Cobranza</th>
                                <th class="px-4 py-2 w-20 uppercase">Teléfono</th>
                                <th class="px-4 py-2 w-20 uppercase">Régimen Fiscal</th>
                                <th class="px-4 py-2 w-20 uppercase">Razón Social</th>
                                <th class="px-4 py-2 w-20 uppercase">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                             <?php if($clientes): ?>
                                <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="px-4 py-2 border border-dark"><?php echo e($cliente->id); ?></td>
                                        <td class="px-4 py-2 border border-dark"><?php echo e($cliente->clasificacion); ?></td>
                                        <td class="px-4 py-2 border border-dark"><?php echo e($cliente->rfc); ?></td>
                                        <td class="px-4 py-2 border border-dark"><?php echo e($cliente->rfc_input); ?></td>
                                        <td class="px-4 py-2 border border-dark"><?php echo e($cliente->nombre); ?></td>
                                        <td class="px-4 py-2 border border-dark"><?php echo e($cliente->estado); ?></td>
                                        <td class="px-4 py-2 border border-dark"><?php echo e($cliente->pais); ?></td>
                                        <td class="px-4 py-2 border border-dark"><?php echo e($cliente->email); ?></td>
                                        <td class="px-4 py-2 border border-dark"><?php echo e($cliente->email_cobranza); ?></td>
                                        <td class="px-4 py-2 border border-dark"><?php echo e($cliente->telefono); ?></td>
                                        <td class="px-4 py-2 border border-dark"><?php echo e($cliente->regimen_fiscal); ?></td>
                                        <td class="px-4 py-2 border border-dark"><?php echo e($cliente->razon_social); ?></td>
                                        <td class="px-4 py-2 border border-dark flex-nowrap pt-2">
                                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dropdown','data' => ['align' => 'right','width' => '48']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-dropdown'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['align' => 'right','width' => '48']); ?>
                                                 <?php $__env->slot('trigger', null, []); ?> 

                                                    <span class="inline-flex rounded-md">
                                                        <button type="button"
                                                            class="btn inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                                                            Acciones

                                                            <svg class="ml-2 -mr-0.5 h-4 w-4"
                                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                        </button>
                                                    </span>
                                                 <?php $__env->endSlot(); ?>

                                                 <?php $__env->slot('content', null, []); ?> 

                                                    

                                                    

                                                    <button wire:click="edit(<?php echo e($cliente->id); ?>)"
                                                        class="px-2 w-full py-1 cursor-pointer hover:bg-sky-600 hover:text-white">Editar</button>

                                                    

                                                    
                                                 <?php $__env->endSlot(); ?>
                                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                             <?php else: ?>
                                <tr>
                                    <td colspan="13" class="border text-center font-bold">Busca Registros</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <br>
                    <br>
                    <?php if(count($clientes) > 0): ?>
                        <?php echo e($clientes->links()); ?>

                    <?php endif; ?>
                    <br>
                    <br>
                </div>
                <br>
                <br>
                <br>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Nightmare28899\Documents\GitHub\periodicoAct\periodico\resources\views/livewire/clientes/view.blade.php ENDPATH**/ ?>
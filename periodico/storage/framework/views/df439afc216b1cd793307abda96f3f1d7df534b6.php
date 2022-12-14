<div>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-black leading-tight">
            <?php echo e($state == 0 ? __('Historial de Remisiones') : __('Editar domicilio de suscripciones activas')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12 mx-auto px-4 container">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <div class="flex">
                <div class="w-64 mr-5">
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
                <div class="w-64 mt-6">
                    <input type="number"
                        class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                        name="search" id="search"
                        placeholder="<?php echo e($state == true ? 'Buscar por id' : 'Buscar Remision por id'); ?>"
                        wire:model="remisionIdSearch" autocomplete="off" min="0" />
                </div>
                <div class="w-64 mt-6 ml-5">
                    <input type="text"
                        class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                        name="search" id="search" placeholder="Buscar Cliente" wire:model="query"
                        autocomplete="off" />
                </div>
            </div>
            <br>
            <?php if($tiros): ?>
                <div class="text-center overflow-x">
                    <div class="overflow-x-auto">
                        <table class="table-auto border-separate border-spacing-2 border border-dark w-full uppercase">
                            <thead>
                                <tr class='bg-gray-100'>
                                    <th class='px-4 py-2 uppercase'>Fecha</th>
                                    
                                    <th class="px-6 py-2 uppercase">Id</th>
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
                                    <?php if($state == 0 && $tiro->estado != 'suspendida'): ?>
                                        <tr>
                                            <td class='px-4 py-2 border border-dark'>
                                                <?php echo e($tiro->estado); ?>

                                                
                                                
                                            <td class='px-4 py-2 border border-dark'><?php echo e($tiro->id); ?></td>
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
                                            
                                            <?php if(substr($tiro->idTipo, 0, 6) == 'suscri'): ?>
                                                <td class="border border-dark">
                                                    <?php if($tiro->clasificacion != 'CRÉDITO'): ?>
                                                        <?php if($tiro->status != 'Cancelado'): ?>
                                                            <?php if($tiro->estado == 'Activo'): ?>
                                                                <button
                                                                    wire:click="pausarRemision('<?php echo e($tiro->idTipo); ?>')"
                                                                    class="px-2 py-1 cursor-pointer bg-red-500 hover:bg-red-600 text-white my-2 rounded-lg">
                                                                    Pausar
                                                                    suscripción
                                                                </button>
                                                            <?php elseif($tiro->estado == 'Pausado'): ?>
                                                                <button
                                                                    wire:click="pausarRemision('<?php echo e($tiro->idTipo); ?>')"
                                                                    class="px-2 py-1 cursor-pointer bg-sky-500 hover:bg-sky-600 text-white my-2 rounded-lg">
                                                                    Activar
                                                                    suscripción
                                                                </button>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <?php if($tiro->status != 'CREDITO' && substr($tiro->idTipo, 0, 6) == 'suscri'): ?>
                                                            <?php if(($tiro->status == 'Pagado' && substr($tiro->idTipo, 0, 6) == 'suscri') ||
                                                                ($tiro->status == 'facturado' && substr($tiro->idTipo, 0, 6) == 'suscri')): ?>
                                                                <button
                                                                    class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                                    disabled>Pagado
                                                                </button>
                                                            <?php else: ?>
                                                                <button
                                                                    wire:click="pagar(<?php echo e($tiro->cliente_id); ?>, '<?php echo e($tiro->idTipo); ?>', '<?php echo e(' '); ?>')"
                                                                    class="inline-flex
                                                            items-center h-10 px-4 m-2 text-sm text-white
                                                            transition-colors duration-150 bg-indigo-500
                                                            hover:bg-indigo-600 rounded-lg
                                                            focus:shadow-outline">Pagar
                                                                </button>
                                                            <?php endif; ?>
                                                        <?php endif; ?>

                                                        <button
                                                            wire:click="generarPDF(<?php echo e($tiro->cliente_id); ?>, '<?php echo e($tiro->idTipo); ?>', '<?php echo e(' '); ?>', <?php echo e($tiro->id); ?>)"
                                                            class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-green-500 hover:bg-green-600 rounded-lg focus:shadow-outline">Ver
                                                            PDF
                                                        </button>
                                                    <?php else: ?>
                                                        <button
                                                            wire:click="generarPDF(<?php echo e($tiro->cliente_id); ?>, '<?php echo e($tiro->idTipo); ?>', '<?php echo e(' '); ?>', <?php echo e($tiro->id); ?>)"
                                                            class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-green-500 hover:bg-green-600 rounded-lg focus:shadow-outline">Ver
                                                            PDF
                                                        </button>
                                                    <?php endif; ?>
                                                    
                                                </td>
                                            <?php else: ?>
                                                <td class="border border-dark">

                                                    

                                                    <?php if($tiro->clasificacion != 'CRÉDITO'): ?>
                                                        <?php if(($tiro->status == 'Pagado' && substr($tiro->idTipo, 0, 5) == 'venta') || $tiro->status == 'facturado'): ?>
                                                            <button
                                                                class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-indigo-500 hover:bg-indigo-600 rounded-lg focus:shadow-outline"
                                                                disabled>Pagado
                                                            </button>
                                                        <?php else: ?>
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
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 20 20" fill="currentColor">
                                                                                <path fill-rule="evenodd"
                                                                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                                                    clip-rule="evenodd" />
                                                                            </svg>
                                                                        </button>
                                                                    </span>
                                                                 <?php $__env->endSlot(); ?>

                                                                 <?php $__env->slot('content', null, []); ?> 
                                                                    <div class="border-t border-gray-200"></div>
                                                                    <button
                                                                        wire:click="editarRemision(<?php echo e($tiro->id); ?>, '<?php echo e($tiro->idTipo); ?>', '<?php echo e($tiro->dia); ?>')"
                                                                        class="px-2 w-full py-1 cursor-pointer hover:bg-sky-600 hover:text-white">
                                                                        Devolver periodicos
                                                                    </button>
                                                                    <div class="border-t border-gray-200"></div>
                                                                    <button
                                                                        wire:click="modalCapturarPeriodicos(<?php echo e($tiro->id); ?>)"
                                                                        class="px-2 w-full py-1 cursor-pointer hover:bg-blue-600 hover:text-white">
                                                                        Capturar periodicos
                                                                    </button>
                                                                    <div class="border-t border-gray-200"></div>
                                                                 <?php $__env->endSlot(); ?>
                                                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                                            <?php if($tiro->estado != 'Cancelado'): ?>
                                                                <button
                                                                    wire:click="pagar(<?php echo e($tiro->cliente_id); ?>, '<?php echo e($tiro->idTipo); ?>', '<?php echo e($tiro->dia); ?>')"
                                                                    class="inline-flex
                                                            items-center h-10 px-4 m-2 text-sm text-white
                                                            transition-colors duration-150 bg-indigo-500
                                                            hover:bg-indigo-600 rounded-lg
                                                            focus:shadow-outline"
                                                                    target="_blank">Pagar
                                                                </button>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <button
                                                            wire:click="editarRemision(<?php echo e($tiro->id); ?>, '<?php echo e($tiro->idTipo); ?>', '<?php echo e($tiro->dia); ?>' )"
                                                            class="px-2 py-2 cursor-pointer bg-sky-500 hover:bg-sky-600 text-white my-2 rounded-lg">
                                                            Editar
                                                        </button>
                                                    <?php endif; ?>

                                                    <button
                                                        wire:click="generarPDF(<?php echo e($tiro->cliente_id); ?>, '<?php echo e($tiro->idTipo); ?>', '<?php echo e($tiro->dia); ?>', <?php echo e($tiro->id); ?>)"
                                                        class="inline-flex items-center h-10 px-4 m-2 text-sm text-white transition-colors duration-150 bg-green-500 hover:bg-green-600 rounded-lg focus:shadow-outline">Ver
                                                        PDF
                                                    </button>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php elseif($state == 1): ?>
                                        <tr>
                                            <td class='px-4 py-2 border border-dark'>
                                                <?php echo e(\Carbon\Carbon::parse($tiro->fecha)->format('d/m/Y')); ?></td>
                                            <td class='px-4 py-2 border border-dark'><?php echo e($tiro->id); ?></td>
                                            
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
                                            
                                            <td class="border border-dark">
                                                <button wire:click="editarDomicilio(<?php echo e($tiro->domicilio_id); ?>)"
                                                    class="inline-flex
                                                            items-center h-10 px-4 m-2 text-sm text-white
                                                            transition-colors duration-150 bg-blue-500
                                                            hover:bg-blue-600 rounded-lg
                                                            focus:shadow-outline">
                                                    Editar domicilio
                                                </button>
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

    
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dialog-modal','data' => ['wire:model' => 'modalDomicilio']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'modalDomicilio']); ?>

         <?php $__env->slot('title', null, []); ?> 
            <div class="flex sm:px-6">
                <h1 class="mb-3 text-2xl text-black font-bold ml-3">Editar domicilio</h1>
                <button type="button" wire:click="$set('modalDomicilio', false)" wire:loading.attr="disabled"
                    class="mb-3 text-gray-400 bg-transparent hover:bg-red-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-red-600 dark:hover:text-white"
                    data-modal-toggle="defaultModal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <hr>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('content', null, []); ?> 
            <div class="flex">
                <div class="w-1/2 p-2">
                    <label for="calle" class="block text-black text-sm font-bold mb-2">Calle:</label>
                    <input type="text"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 <?php $__errorArgs = ['calle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        id="calle" wire:model.defer="calle" placeholder="Escribe tu calle" />
                    <?php $__errorArgs = ['calle'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="w-1/2 p-2">
                    <label for="noint" class="block text-black text-sm font-bold mb-2">No. Int.(Opcional):</label>
                    <input type="text"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 <?php $__errorArgs = ['noint'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        id="noint" wire:model.defer="noint" placeholder="Escribe tu No. Int" min="0" />
                    <?php $__errorArgs = ['noint'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex">
                <div class="w-1/2 p-2">
                    <label for="noext" class="block text-black text-sm font-bold mb-2">No. Ext.:</label>
                    <input type="text" min="0"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 <?php $__errorArgs = ['noext'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        id="noext" wire:model.defer="noext" placeholder="Escribe tu No. Ext" />
                    <?php $__errorArgs = ['noext'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="w-1/2 p-2">
                    <label for="colonia" class="block text-black text-sm font-bold mb-2">Colonia:</label>
                    <input type="text"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 <?php $__errorArgs = ['colonia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        id="colonia" wire:model.defer="colonia" placeholder="Escribe tu Colonia" />
                    <?php $__errorArgs = ['colonia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex">
                <div class="w-1/2 p-2">
                    <label for="cp" class="block text-black text-sm font-bold mb-2">C.P.:</label>
                    <input type="number" min="0"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 <?php $__errorArgs = ['cp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        id="cp" wire:model.defer="cp" placeholder="Escribe tu CP" />
                    <?php $__errorArgs = ['cp'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="w-1/2 p-2">
                    <label for="localidad" class="block text-black text-sm font-bold mb-2">Localidad:</label>
                    <input type="text"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 <?php $__errorArgs = ['localidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        id="localidad" wire:model.defer="localidad" placeholder="Escribe tu Localidad" />
                    <?php $__errorArgs = ['localidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex">
                <div class="w-1/2 p-2">
                    <label for="referencia" class="block text-black text-sm font-bold mb-2">Referencia:</label>
                    <textarea type="text"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 <?php $__errorArgs = ['referencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        id="referencia" wire:model.defer="referencia" placeholder="Escribe una referencia"></textarea>
                    <?php $__errorArgs = ['referencia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="w-1/2 p-2">
                    <label for="ruta" class="block text-black text-sm font-bold mb-2">Ruta:</label>
                    <select
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 <?php $__errorArgs = ['ruta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        wire:model.defer="ruta" id="ruta" style="width: 100%">
                        <option value='' style="display: none;">Escoge una opción</option>
                        <?php $__currentLoopData = $rutas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $ruta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value='<?php echo e($id); ?>'>
                                <?php echo e($ruta); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <?php $__errorArgs = ['ruta'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="flex">
                <div class="w-1/2 p-2">
                    <label for="ciudad" class="block text-black text-sm font-bold mb-2">Ciudad:</label>
                    <input type="text"
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 <?php $__errorArgs = ['ciudad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        id="ciudad" wire:model.defer="ciudad" placeholder="Escribe tu Ciudad" />
                    <?php $__errorArgs = ['ciudad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span
                            class="text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2"><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="w-1/2 p-2">
                    
                </div>
            </div>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('footer', null, []); ?> 
            <div class="flex-auto w-64 px-4 sm:px-6">
                
            </div>

            <div class="flex-auto w-64 px-4 sm:px-6">
                <button wire:click.prevent="actualizarDomicilioSubs" type="button"
                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    <svg wire:loading wire:target="actualizarDomicilioSubs"
                        class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Actualizar
                </button>
            </div>
         <?php $__env->endSlot(); ?>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dialog-modal','data' => ['wire:model' => 'modalEditar']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'modalEditar']); ?>

         <?php $__env->slot('title', null, []); ?> 
            <div class="flex sm:px-6">
                <h1 class="mb-3 text-2xl text-black font-bold ml-3">Editar devueltos</h1>
                <button type="button" wire:click="cerrarEditar" wire:loading.attr="disabled"
                    class="mb-3 text-gray-400 bg-transparent hover:bg-red-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-red-600 dark:hover:text-white"
                    data-modal-toggle="defaultModal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <hr>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('content', null, []); ?> 
            <div class="mb-3">
                <label for="exampleFormControlInput2" class="block text-black text-sm font-bold mb-2">Cantidad de
                    devueltos:</label>
                <input type="number"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    id="devuelto" wire:model.defer="cantDevueltos"
                    placeholder="<?php echo e($entregar == 0 ? 'Introduce la cantidad a regresar a la venta' : 'Cantidad actual: ' . $cantActual . ' Devueltos: ' . $devuelto); ?>"
                    min="0" />
            </div>
            <?php if($devuelto == 0 || ($devuelto > 0 && $entregar > 0)): ?>
                
                <button wire:click.prevent="updateDevueltos" type="button"
                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    <svg wire:loading wire:target="updateDevueltos" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Devolver
                </button>
            <?php elseif($entregar != 0 && $devuelto > 0): ?>
                
                <button wire:click.prevent="updateDevueltos" type="button"
                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    <svg wire:loading wire:target="updateDevueltos" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Devolver
                </button>
            <?php elseif($entregar == 0 && $devuelto > 0): ?>
                <button wire:click.prevent="updateDevueltos" type="button"
                    class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                    <svg wire:loading wire:target="updateDevueltos" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10"
                            stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Cancelar devolución
                </button>
            <?php endif; ?>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('footer', null, []); ?> 

         <?php $__env->endSlot(); ?>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dialog-modal','data' => ['wire:model' => 'modalCapturar']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'modalCapturar']); ?>

         <?php $__env->slot('title', null, []); ?> 
            <div class="flex sm:px-6">
                <h1 class="mb-3 text-2xl text-black font-bold ml-3">Agregar periodicos</h1>
                <button type="button" wire:click="cerrarEditar" wire:loading.attr="disabled"
                    class="mb-3 text-gray-400 bg-transparent hover:bg-red-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-red-600 dark:hover:text-white"
                    data-modal-toggle="defaultModal">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <hr>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('content', null, []); ?> 
            <div class="mb-3">
                <label for="exampleFormControlInput2" class="block text-black text-sm font-bold mb-2">Cantidad de
                    agregados:</label>
                <input type="number"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 <?php $__errorArgs = ['nombre'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                    id="devuelto" wire:model.defer="cantAgregar" placeholder="Actual: <?php echo e($cantActual); ?>"
                    min="0" />
            </div>
            
            <button wire:click.prevent="capturarPeriodicos" type="button"
                class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-blue-600 text-base leading-6 font-bold text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:border-green-700 focus:shadow-outline-green transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                <svg wire:loading wire:target="capturarPeriodicos" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4">
                    </circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                Capturar
            </button>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('footer', null, []); ?> 

         <?php $__env->endSlot(); ?>

     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
</div>
<?php /**PATH C:\Users\Nightmare28899\Documents\GitHub\periodicoAct\periodico\resources\views/livewire/remisiones/historial.blade.php ENDPATH**/ ?>
<div class="w-1/2 mx-auto">
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-black leading-tight">
            <?php echo e(__('Suspender suscripción')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">

                <p>Suspender temporalmente un contrato</p>
                <div class="flex">
                    <div class="flex-initial mx-1 mt-4">
                        <p>N. Contrato</p>
                    </div>
                    <div class="flex-none mx-1">
                        <input type="text"
                            class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring w-full uppercase"
                            name="search" placeholder="Buscar" wire:model="query" autocomplete="off" />
                    </div>
                </div>
                <div>
                    <p>Datos del contrato:</p>
                    <?php if(count($suscripciones) > 0): ?>
                        <div class="flex mt-2 space-x-4 w-full">
                            <div class="px-2 w-full">
                                <b>Cliente: <input type="text" style="height: 1.7rem;"
                                        value="<?php echo e($suscripciones[0]['nombre'] ? $suscripcionBuscada[0]['nombre'] : $suscripcionBuscada[0]['razon_social']); ?>"
                                        class="border-0 w-1/2 bg-gray-200" disabled></b>
                            </div>
                        </div>
                        <div class="flex mt-2 space-x-4">
                            <div class="px-2">
                                <b>Periodo: <input type="text" style="height: 1.7rem;"
                                        value="<?php echo e($suscripciones[0]['periodo']); ?>" class="border-0 bg-gray-200 w-32"
                                        disabled>DE: <input type="text" style="height: 1.7rem;"
                                        value="<?php echo e(\Carbon\Carbon::parse($suscripciones[0]['fechaInicio'])->format('d/m/Y')); ?>"
                                        class="border-0 bg-gray-200 w-32" disabled>
                                    AL:
                                    <input type="text" style="height: 1.7rem;"
                                        value="<?php echo e(\Carbon\Carbon::parse($suscripciones[0]['fechaFin'])->format('d/m/Y')); ?>"
                                        class="border-0 w-32 bg-gray-200" disabled></b>
                            </div>
                        </div>
                        <div class="flex mt-2 space-x-4">
                            <div class="px-2">
                                <b>Ejemplares: <input type="text" style="height: 1.7rem;"
                                        value="<?php echo e($suscripciones[0]['cantEjemplares']); ?>" class="border-0 bg-gray-200"
                                        disabled></b>
                            </div>
                        </div>
                        <div class="flex mt-2 space-x-4">
                            <div class="px-2">
                                <b>Importe: <input type="text" style="height: 1.7rem;"
                                        value="<?php echo e(sprintf('$ %s', number_format($suscripciones[0]['importe'], 2))); ?>"
                                        class="border-0 bg-gray-200" disabled></b>
                            </div>
                        </div>
                        <div class="flex mt-2 space-x-4">
                            <div class="px-2">
                                <b>Fin Entrega: <input type="text" style="height: 1.7rem;"
                                        value="<?php echo e(\Carbon\Carbon::parse($suscripciones[0]['fechaFin'])->format('d/m/Y')); ?>"
                                        class="border-0 bg-gray-200 text-red-600" disabled></b>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="mt-5 border-2 p-2">
                    <p>Fechas para la suspensión</p>
                    <div class="flex">
                        <div class="flex mt-2 space-x-4">
                            <div class="px-2">
                                <b>DEL: <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'date','wire:model' => 'del','class' => 'w-64 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block uppercase']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','wire:model' => 'del','class' => 'w-64 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block uppercase']); ?>
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <?php $__errorArgs = ['del'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span
                                            class='text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2'><?php echo e('El campo es obligatorio'); ?></span></b>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="flex mt-2 space-x-4">
                            <div class="px-2">
                                <b>AL: <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'date','wire:model' => 'al','class' => 'w-64 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block uppercase']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','wire:model' => 'al','class' => 'w-64 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block uppercase']); ?>
                                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <?php $__errorArgs = ['al'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span
                                            class='text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2'><?php echo e('El campo es obligatorio'); ?></span></b>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </b>
                            </div>
                        </div>
                    </div>
                    <div>
                        <p class="flex mt-3">Reponer los dias que se suspende el contrato
                            <select
                                class="ml-3 border w-32 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block uppercase"
                                wire:model="reponerDias">
                                <option value="si">Si</option>
                                <option value="no">No</option>
                            </select>
                        </p>
                    </div>

                    <div>
                        <div class="form-group">
                            <?php if($reponerDias == 'si'): ?>
                                <input wire:model="radioOptions" name="reponer" type="radio" id="reponer"
                                    value="reponer" checked>
                            <?php else: ?>
                                <input wire:model="radioOptions" name="reponer" type="radio" id="reponer"
                                    value="reponer" disabled>
                            <?php endif; ?>
                            <label class="text-black" for="reponer">Reponer al termino del periodo del contrato</label>
                        </div>
                        <div class="form-group">
                            <?php if($reponerDias == 'si'): ?>
                                <input wire:model="radioOptions" name="indicar" type="radio" id="indica"
                                    value="indicar">
                            <?php else: ?>
                                <input wire:model="radioOptions" name="indicar" type="radio" id="indica"
                                    value="indicar" disabled>
                            <?php endif; ?>
                            <label class="text-black" for="indicar">Indica la fecha de reposición</label>
                        </div>
                        <p>Fecha de resposición</p>
                        <div class="flex">
                            <div class="flex mt-2 space-x-4">
                                <div class="px-2">
                                    <?php if($estado == true): ?>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'date','wire:model' => 'fechaReposicion','class' => 'border uppercase border-gray-300 w-64']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','wire:model' => 'fechaReposicion','class' => 'border uppercase border-gray-300 w-64']); ?>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                        <?php $__errorArgs = ['fechaReposicion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span
                                                class='text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2'><?php echo e('El campo es obligatorio'); ?></span></b>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <?php else: ?>
                                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['type' => 'date','wire:model' => 'fechaReposicion','class' => 'w-64 uppercase','disabled' => true]] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'date','wire:model' => 'fechaReposicion','class' => 'w-64 uppercase','disabled' => true]); ?>
                                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-3 p-3 border-2">
                    <p>Motivo para la suspension</p>
                    <p>Escribe el motivo</p>
                    <textarea wire:model="motivo" style="margin-left: 2rem;"
                        class="border-0 bg-gray-200 <?php $__errorArgs = ['motivo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" rows="2"
                        placeholder="Coloca un motivo" cols="50"></textarea>
                    <?php $__errorArgs = ['motivo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span
                            class='text-white bg-red-500 text-sm rounded-lg block w-full p-2.5 text-center my-2'><?php echo e('El campo es obligatorio'); ?></span></b>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="flex mt-2 space-x-4">
                    <div class="px-2">
                        <button type="button" wire:click.prevent="suspender"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            <svg wire:loading wire:target="suspender"
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Suspender contrato
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Nightmare28899\Documents\GitHub\periodicoAct\periodico\resources\views/livewire/suspencion-de-contrato.blade.php ENDPATH**/ ?>
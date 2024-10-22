<?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.dialog-modal','data' => ['wire:model' => 'suscripciones','maxWidth' => '6xl']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-dialog-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'suscripciones','maxWidth' => '6xl']); ?>

     <?php $__env->slot('title', null, []); ?> 
        <div class="flex sm:px-6">
            <h1 class="mb-3 text-2xl text-black font-bold ml-3">Suscripciones</h1>
            <button type="button" wire:click="cerrarModalSuscripciones()" wire:loading.attr="disabled"
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
        <div class="px-4 mb-4" flex-grow>
            <div class="flex">
                <div class="w-1/2 px-2">
                    <p class="font-bold">La suscripción es para el cliente &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ID de la Suscripcion: <?php echo e(isset($idSuscripcionSig) ? $idSuscripcionSig['id'] + 1 : 1); ?></p>
                </div>
                <div class="w-1/2">
                    <p class="font-bold">Fecha: <input type="text" style="height: 1.7rem; margin-left: 2.4rem;"
                            value="<?php echo e(\Carbon\Carbon::parse($date)->format('d/m/Y')); ?>" class="border-0 rounded-md bg-gray-200"
                            disabled>
                    </p>
                </div>
            </div>
            <div class="flex">
                <div class="w-1/2 p-2">
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

                
                <div class="w-1/2 p-2">
                    <?php if($personalizado == true): ?>
                        <input type="number"
                            class="text-slate-600 relative bg-white rounded text-base shadow outline-none focus:outline-none focus:ring"
                            wire:model="costoPerson" name="person" placeholder="Coloca la tarifa">
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex">
                <div class="w-1/2 px-2">
                    <p>Suscripción:</p>
                    <p class="font-bold"><input wire:model.defer="tipoSubscripcion" name="tipoSubscripcion"
                            id="Normal" value="Normal" type="radio" checked> <label class="text-black"
                            for="Normal">Normal</label>
                    </p>
                </div>
                <div class="w-1/2">
                    <br>
                    
                </div>
                <div class="border-l-4 border-black ... px-2"></div>
                <div class="w-1/2">
                    <p>La suscripción es una:</p>
                    <p class="font-bold"><input wire:model.lazy="subscripcionEs" type="radio" name="subscripcionEs"
                            value="Apertura" checked> <label for="Apertura">Apertura</label>
                    </p>
                </div>
                <div class="w-1/2">
                    <br>
                    <p class="font-bold"><input wire:model="subscripcionEs" type="radio" name="subscripcionEs"
                            value="Renovación" <?php echo e($subscripcionEs == 'Renovación' ? 'checked' : ''); ?>>
                        <label for="Renovación">Renovación</label>
                    </p>
                </div>
                <div class="w-1/2">
                    
                </div>
            </div>

            <?php if($clienteSeleccionado != null): ?>
                
                <div class="flex mt-2 space-x-4">
                    <div class="w-full px-2">
                        <b>R.F.C.: <br> <input type="text" style="height: 1.7rem;"
                                value="<?php echo e($clienteSeleccionado['rfc_input']); ?>" class="border-0 bg-gray-200"
                                disabled></b>
                    </div>
                    <div class="w-full px-2">
                        <b>Nombre: <br> <input type="text" style="height: 1.7rem;"
                                value="<?php echo e($clienteSeleccionado['nombre']); ?>" class="border-0 bg-gray-200" disabled></b>
                    </div>
                    <div class="w-full px-2">
                        <b>E-mail: <br> <input type="text" style="height: 1.7rem;"
                                value="<?php echo e($clienteSeleccionado['email']); ?>" class="border-0 bg-gray-200" disabled></b>
                    </div>
                </div>
                <div class="flex mt-2 space-x-4">
                    <div class="w-full px-2">
                        <b>Razón Social: <br> <input type="text" style="height: 1.7rem;"
                                value="<?php echo e($clienteSeleccionado['razon_social']); ?>" class="border-0 bg-gray-200"
                                disabled></b>
                    </div>
                    <div class="w-full px-2">
                        <b>Estado: <br> <input type="text" style="height: 1.7rem;"
                                value="<?php echo e($clienteSeleccionado['estado']); ?>" class="border-0 bg-gray-200"
                                disabled></b>
                    </div>
                    <div class="w-full px-2">
                        <b>Clasificación: <br> <input type="text" style="height: 1.7rem;"
                                value="<?php echo e($clienteSeleccionado['clasificacion']); ?>" class="border-0 bg-gray-200"
                                disabled></b>
                    </div>
                </div>
                <div class="flex mt-2 space-x-4">
                    <div class="w-full px-2">
                        <b>Regimen Fiscal: <br> <input type="text" style="height: 1.7rem;"
                                value="<?php echo e($clienteSeleccionado['regimen_fiscal']); ?>" class="border-0 bg-gray-200"
                                disabled></b>
                    </div>
                    <div class="w-full px-2">
                        <b>Telefono: <br> <input type="text" style="height: 1.7rem;"
                                value="<?php echo e($clienteSeleccionado['telefono']); ?>" class="border-0 bg-gray-200"
                                disabled></b>
                    </div>
                    <div class="w-full px-2">
                        <b>País: <br> <input type="text" style="height: 1.7rem;"
                                value="<?php echo e($clienteSeleccionado['pais']); ?>" class="border-0 bg-gray-200" disabled></b>
                    </div>
                </div>
            <?php else: ?>
                <div></div>
            <?php endif; ?>

            <div class="flex mt-5">
                <div class="w-2/5 px-2">
                    <p>TARIFA</p>
                    <select
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 <?php $__errorArgs = ['clasificacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        wire:model="tarifaSeleccionada" style="width: 100%">
                        <option value='' style="display: none;">Selecciona una tarifa</option>
                        <option value="Base">Base</option>
                        <option value="Ejecutiva">Ejecutiva</option>
                        <option value="Person">Personalizado</option>
                    </select>
                    <?php $__errorArgs = ['tarifaSeleccionada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-500 text-xs italic">
                            <?php echo e($message); ?>

                        </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="w-2/5 px-2">
                    <p>EJEMPLARES</p>
                    <input type="number" class="border-0 rounded-md bg-gray-200" style="height: 1.7rem; margin-top: 5px;"
                        name="cantEjem" wire:model="cantEjem" min="0">
                    <?php $__errorArgs = ['cantEjem'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-500 text-xs italic">
                            <?php echo e($message); ?>

                        </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="w-2/5 px-2">
                    <p>PRECIO</p>
                    <input type="radio" name="precio" wire:model="precio" value="Normal" checked> Normal
                    <input type="radio" name="precio" wire:model="precio" value="Pronto_pago"> Pronto pago
                </div>
                <div class="w-1/2 px-2">
                    <p>CONTRATO PARA</p>
                    <input type="radio" name="contrato" wire:model="contrato" value="Suscripción" checked>
                    Suscripción
                    <input type="radio" name="contrato" wire:model="contrato" value="Cortesía"
                        <?php echo e($contrato == 'Cortesía' ? 'checked' : ''); ?>> Cortesía
                    
                </div>
            </div>
            <div class="flex mt-2">
                <div class="w-1/5 px-2">
                    <p class="mt-3">TIPO SUSCRIPCIÓN</p>
                    <p class="mt-4">PERIODO</p>
                    <p class="mt-5">DÍAS</p>
                </div>
                <div class="w-1/4 px-2">
                    <select
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 <?php $__errorArgs = ['tipoSuscripcionSeleccionada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        wire:model="tipoSuscripcionSeleccionada" style="width: 80%">
                        <option value='' style="display: none;">Selecciona una opción</option>
                        <option value='Impresa'>Impresa</option>
                        <option value='Digital'>Digital</option>
                    </select>
                    <?php $__errorArgs = ['tipoSuscripcionSeleccionada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-500 text-xs italic">
                            <?php echo e($message); ?>

                        </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <select
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mt-1 <?php $__errorArgs = ['periodoSuscripcionSeleccionada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        wire:model="periodoSuscripcionSeleccionada" style="width: 80%">
                        
                        <option value='esco' style="display: none;">Selecciona una opción</option>
                        <option value="Semanal">Otro</option>
                        <option value='Mensual'>Mensual</option>
                        <option value='Trimestral'>Trimestral</option>
                        <option value='Semestral'>Semestral</option>
                        <option value='Anual'>Anual</option>
                    </select>
                    <?php $__errorArgs = ['periodoSuscripcionSeleccionada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-500 text-xs italic">
                            <?php echo e($message); ?>

                        </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <select
                        class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mt-1 <?php $__errorArgs = ['diasSuscripcionSeleccionada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        wire:model="diasSuscripcionSeleccionada" style="width: 80%">
                        
                        <option value="esc_man" style="display: none;">Selecciona una opción</option>
                        <option value="l_v">Lunes a Viernes</option>
                        <option value="l_s">Lunes a Sábado</option>
                        <option value='l_d'>Lunes a Domingo</option>
                    </select>
                    <?php $__errorArgs = ['diasSuscripcionSeleccionada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <span class="text-red-500 text-xs italic">
                            <?php echo e($message); ?>

                        </span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="w-3/5 px-2">
                    <p class="mt-3">#DÍAS INICIO</p>
                    <p class="mt-3 mr-3 flex"><kbd class="mt-2">DEL:</kbd>

                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['class' => 'w-2/5 border-blue-500 @error(\'from\') border-red-500 @enderror','type' => 'date','wire:model' => 'from']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-2/5 border-blue-500 @error(\'from\') border-red-500 @enderror','type' => 'date','wire:model' => 'from']); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        <?php $__errorArgs = ['from'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <span class="text-red-500 text-xs italic">
                                <?php echo e($message); ?>

                            </span>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                        <kbd class="ml-3 mt-2">AL:</kbd>
                        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'jetstream::components.input','data' => ['class' => 'w-2/5','type' => 'date','wire:model' => 'to']] + (isset($attributes) ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('jet-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-2/5','type' => 'date','wire:model' => 'to']); ?>
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>

                    </p>
                    <div class="mt-2">
                        <?php if($allow == false): ?>
                            <input type="checkbox" name="lunes" wire:model.defer="lunes" disabled> Lunes
                            <input type="checkbox" name="martes" wire:model.defer="martes" disabled> Martes
                            <input type="checkbox" name="miércoles" wire:model.defer="miércoles" disabled>
                            Miércoles
                            <input type="checkbox" name="jueves" wire:model.defer="jueves" disabled> Jueves
                            <input type="checkbox" name="viernes" wire:model.defer="viernes" disabled> Viernes
                            <input type="checkbox" name="sábado" wire:model.defer="sábado" disabled> Sábado
                            <input type="checkbox" name="domingo" wire:model.defer="domingo" disabled> Domingo
                        <?php else: ?>
                            <input type="checkbox" name="lunes" wire:model.defer="lunes"> Lunes
                            <input type="checkbox" name="martes" wire:model.defer="martes"> Martes
                            <input type="checkbox" name="miércoles" wire:model.defer="miércoles"> Miércoles
                            <input type="checkbox" name="jueves" wire:model.defer="jueves"> Jueves
                            <input type="checkbox" name="viernes" wire:model.defer="viernes"> Viernes
                            <input type="checkbox" name="sábado" wire:model.defer="sábado"> Sábado
                            <input type="checkbox" name="domingo" wire:model.defer="domingo"> Domingo
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="flex mt-2">
                <div class="w-full">
                    <b class="uppercase">domicilio de entrega</b>
                    <button class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-md"
                        wire:click="modalCrearDomSubs">Lista
                    </button>
                    <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-3">
                        <table class="w-full text-md text-left text-gray-500 dark:text-gray-400 uppercase">
                            <thead
                                class="text-md text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr class="bg-gray-500 text-white uppercase">
                                    <th scope="col" class="py-3 px-6">Calle</th>
                                    <th scope="col" class="py-3 px-6">#Int</th>
                                    <th scope="col" class="py-3 px-6">#Ext</th>
                                    <th scope="col" class="py-3 px-6">Colonia</th>
                                    <th scope="col" class="py-3 px-6">C.P.</th>
                                    <th scope="col" class="py-3 px-6">Localidad</th>
                                    <th scope="col" class="py-3 px-6">Ciudad</th>
                                    
                                    <th scope="col" class="py-3 px-6">Referencia</th>
                                    <th scope="col" class="py-3 px-6">Ruta</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($domicilioSeleccionado): ?>
                                    <?php $__currentLoopData = $domicilioSeleccionado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dom): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $dom = (object) $dom;
                                        ?>
                                        
                                        <tr
                                            class="bg-white text-black hover:text-white dark:hover:bg-gray-600 text-center cursor-pointer">
                                            <td class="border"
                                                wire:click="eliminarDatoSeleccionado(<?php echo e($dom->id); ?>)">
                                                <?php echo e($dom->calle); ?></td>
                                            <td class="border"
                                                wire:click="eliminarDatoSeleccionado(<?php echo e($dom->id); ?>)">
                                                <?php echo e($dom->noint); ?></td>
                                            <td class="border"
                                                wire:click="eliminarDatoSeleccionado(<?php echo e($dom->id); ?>)">
                                                <?php echo e($dom->noext); ?></td>
                                            <td class="border"
                                                wire:click="eliminarDatoSeleccionado(<?php echo e($dom->id); ?>)">
                                                <?php echo e($dom->colonia); ?></td>
                                            <td class="border"
                                                wire:click="eliminarDatoSeleccionado(<?php echo e($dom->id); ?>)">
                                                <?php echo e($dom->cp); ?></td>
                                            <td class="border"
                                                wire:click="eliminarDatoSeleccionado(<?php echo e($dom->id); ?>)">
                                                <?php echo e($dom->localidad); ?></td>
                                            <td class="border"
                                                wire:click="eliminarDatoSeleccionado(<?php echo e($dom->id); ?>)">
                                                <?php echo e($dom->ciudad); ?></td>
                                            
                                            <td class="border"
                                                wire:click="eliminarDatoSeleccionado(<?php echo e($dom->id); ?>)">
                                                <?php echo e($dom->referencia); ?></td>
                                            <td class="border"
                                                wire:click="eliminarDatoSeleccionado(<?php echo e($dom->id); ?>)">
                                                <?php echo e($dom->nombreruta); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div class="mt-3">
                <div class="w-2/5 px-2 flex">
                    OBSERVACIONES(Opcional)
                    <textarea style="margin-left: 2rem;" class="border-0 rounded-md bg-gray-200" rows="2" wire:model.defer="observacion"
                        placeholder="Coloca una descripción" cols="50"></textarea>
                </div>
            </div>
            <div class="flex">
                <div class="w-1/4 px-2">
                    <p class="mt-2 flex">IMPORTE <input class="border-0 rounded-md bg-gray-200 pl-3"
                            style="height: 1.7rem; margin-left: 5.9rem;" value="<?php echo e(sprintf('$ %s', number_format($total, 2))); ?>" disabled>
                    </p>
                    <p class="mt-2 flex">DESCUENTO <input class="border-0 rounded-md bg-gray-200 pl-3"
                            style="height: 1.7rem; margin-left: 4.3rem;" value="<?php echo e(sprintf('$ %s', number_format($descuento, 2))); ?>" disabled>
                    </p>
                    <p class="mt-2 flex">SUBTOTAL <input class="border-0 rounded-md bg-gray-200 pl-3"
                            style="height: 1.7rem; margin-left: 5.1rem;" value="<?php echo e(sprintf('$ %s', number_format($total, 2))); ?>" disabled>
                    </p>
                    <p class="mt-2 flex">IVA <input class="border-0 rounded-md bg-gray-200 pl-3"
                            style="height: 1.7rem; margin-left: 8.5rem;" value="<?php echo e(sprintf('$ %s', number_format($iva, 2))); ?>" disabled>
                    </p>
                    <p class="mt-2 flex">TOTAL <input class="border-0 rounded-md     bg-gray-200 pl-3"
                            style="height: 1.7rem; margin-left: 7rem;" value="<?php echo e(sprintf('$ %s', number_format($totalDesc, 2))); ?>" disabled></p>
                </div>
                <div class="w-1/2 px-2 ml-5" style="margin-left: 400px;">
                    
                    <br>
                    <br>
                    <br>
                    <br>
                    <div class="mt-5 pt-4">
                        <button wire:click.prevent="suscripciones"
                            class="px-4 py-2 text-white bg-blue-500 hover:bg-blue-600 rounded-md">
                            <svg wire:loading wire:target="suscripciones"
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Crear contrato
                        </button>
                        
                        <button class="px-4 py-2 text-white bg-red-500 hover:bg-red-600 rounded-md"
                            wire:click.prevent="borrar()">Borrar
                        </button>
                        
                    </div>
                </div>
            </div>
        </div>

     <?php $__env->endSlot(); ?>

     <?php $__env->slot('footer', null, []); ?> 

     <?php $__env->endSlot(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Nightmare28899\Documents\GitHub\periodicoAct\periodico\resources\views/livewire/suscripciones/suscripciones.blade.php ENDPATH**/ ?>
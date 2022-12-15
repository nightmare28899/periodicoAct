<div class="w-4/6 mx-auto">
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-black leading-tight">
            <?php echo e(__('Reporte relación cliente ruta')); ?>

        </h2>
     <?php $__env->endSlot(); ?>


    <div class="py-12">
        <div class="">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class="flex mb-5">
                    <div class="w-1/2">
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
                    <div class="w-1/2">
                        <button wire:click="generarPDF" wire:loading.attr="disabled"
                            class="p-2 bg-green-500 rounded-md text-white hover:bg-green-700 float-right">
                            <svg wire:loading wire:target="generarPDF"
                                class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            Generar PDF
                        </button>
                    </div>
                </div>

                <p>HORA: <?php echo e($time); ?></p>
                <h3 class="text-center font-bold">LA VOZ DE MICHOACAN S.A. DE C.V.</h3>
                <h3 class="font-bold">RELACION DE CLIENTES POR RUTA: <?php echo e($rutaSeleccionada); ?> </h3>
                <h3>MORELIA, MICHOACAN <?php echo e($diaS); ?> <?php echo e($date); ?></h3>

                <div class="mx-auto text-center">
                    <table class="table-auto border-separate border-spacing-2 border border-dark uppercase">
                        <thead>
                            <tr class='bg-gray-100'>
                                <th class='px-4 py-2 uppercase'>CLAVE</th>
                                <th class='px-4 py-2 uppercase'>CLIENTE</th>
                                <th class='px-4 py-2 uppercase'>POBLACION</th>
                                <th class='px-4 py-2 uppercase'>REF. DE ENTREGA</th>
                                <th class='px-4 py-2 uppercase'>L</th>
                                <th class='px-4 py-2 uppercase'>M</th>
                                <th class='px-4 py-2 uppercase'>M</th>
                                <th class='px-4 py-2 uppercase'>J</th>
                                <th class='px-4 py-2 uppercase'>V</th>
                                <th class='px-4 py-2 uppercase'>S</th>
                                <th class='px-4 py-2 uppercase'>D</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sum_lunes = 0; ?>
                            <?php $sum_martes = 0; ?>
                            <?php $sum_miercoles = 0; ?>
                            <?php $sum_jueves = 0; ?>
                            <?php $sum_viernes = 0; ?>
                            <?php $sum_sabado = 0; ?>
                            <?php $sum_domingo = 0; ?>
                            <?php $__currentLoopData = $ventas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class='px-4 py-2 border border-dark'>
                                        <?php echo e($result['id']); ?>

                                    </td>
                                    <td class='px-4 py-2 border border-dark'>
                                        <?php echo e($result['nombre']); ?>

                                    </td>
                                    <td class='px-4 py-2 border border-dark'><?php echo e($result['localidad']); ?></td>
                                    <td class='px-4 py-2 border border-dark'>
                                        <?php echo e($result['referencia']); ?>

                                    </td>
                                    <td class='px-4 py-2 border border-dark'><?php echo e($result->lunes); ?></td>
                                    <td class='px-4 py-2 border border-dark'><?php echo e($result->martes); ?></td>
                                    <td class='px-4 py-2 border border-dark'><?php echo e($result->miércoles); ?></td>
                                    <td class='px-4 py-2 border border-dark'><?php echo e($result->jueves); ?></td>
                                    <td class='px-4 py-2 border border-dark'><?php echo e($result->viernes); ?></td>
                                    <td class='px-4 py-2 border border-dark'><?php echo e($result->sábado); ?></td>
                                    <td class='px-4 py-2 border border-dark'><?php echo e($result->domingo); ?></td>
                                </tr>
                                <?php $sum_lunes += $result->lunes; ?>
                                <?php $sum_martes += $result->martes; ?>
                                <?php $sum_miercoles += $result->miércoles; ?>
                                <?php $sum_jueves += $result->jueves; ?>
                                <?php $sum_viernes += $result->viernes; ?>
                                <?php $sum_sabado += $result->sábado; ?>
                                <?php $sum_domingo += $result->domingo; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $suscripciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $susc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class='px-4 py-2 border border-dark'>
                                        <?php echo e($susc['id']); ?>

                                    </td>
                                    <td class='px-4 py-2 border border-dark'>
                                        <?php echo e($susc['nombre']); ?>

                                    </td>
                                    <td class='px-4 py-2 border border-dark'><?php echo e($susc['localidad']); ?></td>
                                    <td class='px-4 py-2 border border-dark'>
                                        <?php echo e($susc['referencia']); ?>

                                    </td>
                                    <td class='px-4 py-2 border border-dark'><?php echo e($susc->lunes == 1 ? $susc->cantEjemplares : 0); ?></td>
                                    <td class='px-4 py-2 border border-dark'><?php echo e($susc->martes == 1 ? $susc->cantEjemplares : 0); ?></td>
                                    <td class='px-4 py-2 border border-dark'><?php echo e($susc->miércoles == 1 ? $susc->cantEjemplares : 0); ?></td>
                                    <td class='px-4 py-2 border border-dark'><?php echo e($susc->jueves == 1 ? $susc->cantEjemplares : 0); ?></td>
                                    <td class='px-4 py-2 border border-dark'><?php echo e($susc->viernes == 1 ? $susc->cantEjemplares : 0); ?></td>
                                    <td class='px-4 py-2 border border-dark'><?php echo e($susc->sábado == 1 ? $susc->cantEjemplares : 0); ?></td>
                                    <td class='px-4 py-2 border border-dark'><?php echo e($susc->domingo == 1 ? $susc->cantEjemplares : 0); ?></td>
                                </tr>
                                <?php $sum_lunes += $susc->lunes == 1 ? $susc->cantEjemplares : 0; ?>
                                <?php $sum_martes += $susc->martes == 1 ? $susc->cantEjemplares : 0; ?>
                                <?php $sum_miercoles += $susc->miércoles == 1 ? $susc->cantEjemplares : 0; ?>
                                <?php $sum_jueves += $susc->jueves == 1 ? $susc->cantEjemplares : 0; ?>
                                <?php $sum_viernes += $susc->viernes == 1 ? $susc->cantEjemplares : 0; ?>
                                <?php $sum_sabado += $susc->sábado == 1 ? $susc->cantEjemplares : 0; ?>
                                <?php $sum_domingo += $susc->domingo == 1 ? $susc->cantEjemplares : 0; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <thead>
                            <tr>
                                <th class='px-4 py-2 uppercase'><?php echo e(count($ventas) + count($suscripciones)); ?></th>
                                <th class='px-4 py-2 uppercase'>Totales</th>
                                <th class='px-4 py-2 uppercase'></th>
                                <th class='px-4 py-2 uppercase'></th>
                                <th class='px-4 py-2 uppercase'><?php echo e($sum_lunes); ?></th>
                                <th class='px-4 py-2 uppercase'><?php echo e($sum_martes); ?></th>
                                <th class='px-4 py-2 uppercase'><?php echo e($sum_miercoles); ?></th>
                                <th class='px-4 py-2 uppercase'><?php echo e($sum_jueves); ?></th>
                                <th class='px-4 py-2 uppercase'><?php echo e($sum_viernes); ?></th>
                                <th class='px-4 py-2 uppercase'><?php echo e($sum_sabado); ?></th>
                                <th class='px-4 py-2 uppercase'><?php echo e($sum_domingo); ?></th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
<?php /**PATH C:\Users\Nightmare28899\Documents\GitHub\periodicoAct\periodico\resources\views/livewire/reportes/relacionClienteRuta/reporte-relacion-c-r.blade.php ENDPATH**/ ?>
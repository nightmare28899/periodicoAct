<div class="w-1/2 mx-auto">
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-black leading-tight">
            <?php echo e(__('Reporte suscripcion vencimiento')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
                <div class=" flex">
                    <p>Suscripciones que vencen en:</p>
                    <input type="number" wire:model="fechavence" min="0" placeholder="Ingresa los dias"
                        class="form-input rounded-md shadow-sm mt-1 block mx-5" />
                    <button wire:click="generarReporte"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        <svg wire:loading wire:target="generarReporte"
                            class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Generar</button>
                </div>

                <div class="mx-auto mt-3">
                    <table class="table-auto border-separate border-spacing-2 border border-dark text-center uppercase">
                        <thead>
                            <tr class='bg-gray-100'>
                                <th class='px-4 py-2 uppercase'>No. contrato</th>
                                <th class='px-4 py-2 uppercase'>cliente</th>
                                <th class='px-4 py-2 uppercase'>nombre</th>
                                <th class='px-4 py-2 uppercase'>fecha vencimiento</th>
                                <th class='px-4 py-2 uppercase'>Periodo</th>
                                <th class='px-4 py-2 uppercase'>ejemplar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $suscripcion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $susc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class='px-4 py-2 border border-dark'>
                                        <?php echo e($susc['id']); ?>

                                    </td>
                                    <td class='px-4 py-2 border border-dark'>
                                        <?php echo e($susc['cliente_id']); ?>

                                    </td>
                                    <td class='px-4 py-2 border border-dark'><?php echo e($susc['nombre']); ?></td>
                                    <td class='px-4 py-2 border border-dark'>
                                        <?php echo e(\Carbon\Carbon::parse($susc['fechaFin'])->format('d/m/Y')); ?>

                                    </td>
                                    <td class='px-4 py-2 border border-dark'>
                                        <?php echo e($susc['periodo']); ?>

                                    </td>
                                    <td class='px-4 py-2 border border-dark'>
                                        <?php echo e($susc['cantEjemplares']); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    <p class="uppercase font-bold">Total de contratos: <?php echo e(count($suscripcion)); ?></p>
                </div>
            </div>
        </div>
    </div>
    
</div>
<?php /**PATH C:\Users\Nightmare28899\Documents\GitHub\periodicoAct\periodico\resources\views/livewire/suscripcion-reporte-fechas.blade.php ENDPATH**/ ?>
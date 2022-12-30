<style>
    table,
    td,
    th {
        border: 1px solid;
        padding: 4px 6px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    .centrado {
        text-align: center;
    }

    #movido {
        position: absolute;
        left: 1320px;
        margin-top: -45px;
    }
</style>
<h3>Lista del Tiro, del
    dia: <?php echo e($diaS); ?></h3>
    <?php if($filtro != ''): ?>
        <?php if(count($ventas) > 0): ?>
            <h3>De la ruta: <?php echo e($ventas[0]['nombreruta']); ?> </h3>
        <?php elseif(count($suscripcion) > 0): ?>
            <h3>De la ruta: <?php echo e($suscripcion[0]['nombreruta']); ?></h3>
        <?php endif; ?>
    <?php endif; ?>
<h3 id="movido">Fecha: <?php echo e(\Carbon\Carbon::parse($dateF)->format('d/m/Y')); ?></h3>
<table class="a centrado" style="text-transform: uppercase;">
    <thead>
    <tr class="bg-gray-500 text-white">
        <th>Ruta</th>
        <th>Día</th>
        <th>Tipo</th>
        <th>Cliente</th>
        <th>Dirección</th>
        <th>Referencia</th>
        <th>Ejemplares</th>
        <th>Fecha</th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $ventas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($result->{$diaS} != 0): ?>
            <tr>
                <td><?php echo e($result->nombreruta); ?>, Tipo: <?php echo e($result->tiporuta); ?>, Repartidor: <?php echo e($result->repartidor); ?>,
                    Cobrador: <?php echo e($result->cobrador); ?></td>
                <td><?php echo e($diaS); ?> </td>
                <td>Venta/Cliente</td>
                <?php if($result->nombre): ?>
                    <td class="border"><?php echo e($result->nombre); ?></td>
                <?php else: ?>
                    <td class="border"><?php echo e($result->razon_social); ?></td>
                <?php endif; ?>
                <td>Calle: <?php echo e($result->calle); ?>

                    <br>
                    No. Ext:
                    <?php echo e($result->noext); ?>, CP: <?php echo e($result->cp); ?>, <br> Localidad:
                    <?php echo e($result->localidad); ?>, Municipio: <?php echo e($result->municipio); ?>

                </td>
                <td><?php echo e($result->referencia); ?></td>
                <td><?php echo e($result->{$diaS}); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($dateF)->format('d/m/Y')); ?></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php $__currentLoopData = $suscripcion; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $suscri): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($suscri->{$diaS} != 0 && $suscri->tiroStatus === 'Activo' && $suscri->remisionStatus === 'Remisionado' || $suscri->contrato === 'Cortesía'): ?>
            <tr>
                <td class="border"><?php echo e($suscri->nombreruta); ?>, Tipo: <?php echo e($suscri->tiporuta); ?>,
                    Repartidor: <?php echo e($suscri->repartidor); ?>, Cobrador: <?php echo e($suscri->cobrador); ?></td>
                <td class="border"><?php echo e($diaS); ?> </td>
                <td>Suscripción</td>
                <td class="border"><?php echo e($suscri->nombre); ?></td>
                <td class="border">Calle: <?php echo e($suscri->calle); ?> <br>
                    No. Ext:
                    <?php echo e($suscri->noext); ?>, CP: <?php echo e($suscri->cp); ?>, <br> Localidad:
                    <?php echo e($suscri->localidad); ?>, Ciudad: <?php echo e($suscri->ciudad); ?>

                </td>
                <td wire:model="referencia" class="border"><?php echo e($suscri->referencia); ?></td>
                <td class="border"><?php echo e($suscri->{$diaS} != 0 ? $suscri->cantEjemplares : 0); ?></td>
                <td><?php echo e(\Carbon\Carbon::parse($dateF)->format('d/m/Y')); ?></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH C:\Users\Nightmare28899\Documents\GitHub\periodicoAct\periodico\resources\views/livewire/tiros/pdf.blade.php ENDPATH**/ ?>
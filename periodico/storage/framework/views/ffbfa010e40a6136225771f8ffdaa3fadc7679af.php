<div>
    <?php if($paginator->hasPages()): ?>
        <?php (isset($this->numberOfPaginatorsRendered[$paginator->getPageName()]) ? $this->numberOfPaginatorsRendered[$paginator->getPageName()]++ : ($this->numberOfPaginatorsRendered[$paginator->getPageName()] = 1)); ?>

        <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
            <div class="flex justify-between flex-1 sm:hidden">
                <span>
                    <?php if($paginator->onFirstPage()): ?>
                        <span
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md select-none">
                            <?php echo __('pagination.previous'); ?>

                        </span>
                    <?php else: ?>
                        <button type="button" wire:click="previousPage('<?php echo e($paginator->getPageName()); ?>')"
                            wire:loading.attr="disabled"
                            dusk="previousPage<?php echo e($paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName()); ?>.before"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                            <?php echo __('pagination.previous'); ?>

                        </button>
                    <?php endif; ?>
                </span>

                <span>
                    <?php if($paginator->hasMorePages()): ?>
                        <button type="button" wire:click="nextPage('<?php echo e($paginator->getPageName()); ?>')"
                            wire:loading.attr="disabled"
                            dusk="nextPage<?php echo e($paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName()); ?>.before"
                            class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
                            <?php echo __('pagination.next'); ?>

                        </button>
                    <?php else: ?>
                        <span
                            class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md select-none">
                            <?php echo __('pagination.next'); ?>

                        </span>
                    <?php endif; ?>
                </span>
            </div>

            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-gray-700 leading-5">
                        <span><?php echo __('Mostrando del'); ?></span>
                        <span class="font-medium"><?php echo e($paginator->firstItem()); ?></span>
                        <span><?php echo __('al'); ?></span>
                        <span class="font-medium"><?php echo e($paginator->lastItem()); ?></span>
                        <span><?php echo __('de'); ?></span>
                        <span class="font-medium"><?php echo e($paginator->total()); ?></span>
                        <span><?php echo __('resultados'); ?></span>
                    </p>
                </div>

                <div>
                    <span class="relative z-0 inline-flex rounded-md shadow-sm">
                        <span>
                            
                            <?php if($paginator->onFirstPage()): ?>
                                
                                <span
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-l-lg">

                                    <?php echo __('pagination.previous'); ?>


                                </span>
                            <?php else: ?>
                                
                                <button wire:click="previousPage" wire:loading.attr="disabled" rel="prev"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-white border border-gray-300 leading-5 rounded-l-lg focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 hover:bg-gray-200">

                                    <?php echo __('pagination.previous'); ?>


                                </button>
                            <?php endif; ?>
                        </span>

                        
                        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            
                            <?php if(is_string($element)): ?>
                                <span aria-disabled="true">
                                    <span
                                        class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 select-none"><?php echo e($element); ?></span>
                                </span>
                            <?php endif; ?>

                            
                            <?php if(is_array($element)): ?>
                                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span
                                        wire:key="paginator-<?php echo e($paginator->getPageName()); ?>-<?php echo e($this->numberOfPaginatorsRendered[$paginator->getPageName()]); ?>-page<?php echo e($page); ?>">
                                        <?php if($page == $paginator->currentPage()): ?>
                                            <span aria-current="page">
                                                <span
                                                    class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white border border-gray-300 cursor-default leading-5 select-none bg-blue-600"><?php echo e($page); ?></span>
                                            </span>
                                        <?php else: ?>
                                            <button type="button"
                                                wire:click="gotoPage(<?php echo e($page); ?>, '<?php echo e($paginator->getPageName()); ?>')"
                                                class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-blue-600 bg-white border border-gray-300 leading-5 focus:z-10 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 hover:bg-gray-200"
                                                aria-label="<?php echo e(__('Go to page :page', ['page' => $page])); ?>">
                                                <?php echo e($page); ?>

                                            </button>
                                        <?php endif; ?>
                                    </span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <span>
                            
                            <?php if($paginator->hasMorePages()): ?>
                                
                                <button wire:click="nextPage" wire:loading.attr="disabled" rel="next"
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-white border border-gray-300 leading-5 rounded-r-lg focus:outline-none focus:shadow-outline-blue focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150 hover:bg-gray-200">

                                    <?php echo __('pagination.next'); ?>


                                </button>
                            <?php else: ?>
                                
                                <span
                                    class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-r-lg">

                                    <?php echo __('pagination.next'); ?>


                                </span>
                            <?php endif; ?>
                        </span>
                    </span>
                </div>
            </div>
        </nav>
    <?php endif; ?>
</div>
<?php /**PATH C:\Users\Nightmare28899\Documents\GitHub\periodicoAct\periodico\resources\views/livewire/custom-pagination.blade.php ENDPATH**/ ?>
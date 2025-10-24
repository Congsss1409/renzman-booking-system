

<?php $__env->startSection('title', 'Feedback Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Page Header -->
    <div>
        <h1 class="text-4xl font-bold text-gray-800">Client <span class="text-teal-500">Feedback</span></h1>
        <p class="text-gray-500 mt-1">Review and manage comments and ratings from your clients.</p>
    </div>

    <!-- Feedback Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $feedbacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feedback): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-stone-50 p-6 rounded-2xl shadow-lg border flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex text-xl text-amber-400">
                            <?php for($i = 0; $i < 5; $i++): ?>
                                <?php if($i < $feedback->rating): ?>
                                    <span>★</span> <!-- Filled star -->
                                <?php else: ?>
                                    <span class="text-gray-300">★</span> <!-- Empty star -->
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <div class="text-xs text-gray-500"><?php echo e($feedback->updated_at->format('M d, Y')); ?></div>
                    </div>
                    
                    <p class="font-semibold text-gray-700"><?php echo e($feedback->client_name); ?> for <?php echo e($feedback->service->name ?? 'N/A'); ?></p>
                    <p class="text-sm text-gray-500 mb-4">with <?php echo e($feedback->therapist->name ?? 'N/A'); ?></p>
                    
                    <p class="text-gray-600 italic">"<?php echo e($feedback->feedback); ?>"</p>
                </div>

                <!-- Toggle Switch -->
                <div class="mt-6 pt-4 border-t">
                    <form action="<?php echo e(route('admin.feedback.toggle', $feedback->id)); ?>" method="POST" class="flex items-center justify-between">
                        <?php echo csrf_field(); ?>
                        <label for="show-toggle-<?php echo e($feedback->id); ?>" class="text-sm font-semibold text-gray-700">Show on Landing Page?</label>
                        <button type="submit" 
                                id="show-toggle-<?php echo e($feedback->id); ?>"
                                class="relative inline-flex items-center h-6 rounded-full w-11 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-teal-500 <?php echo e($feedback->show_on_landing ? 'bg-teal-500' : 'bg-gray-200'); ?>">
                            <span class="inline-block w-4 h-4 transform bg-white rounded-full transition-transform <?php echo e($feedback->show_on_landing ? 'translate-x-6' : 'translate-x-1'); ?>"></span>
                        </button>
                    </form>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-12 text-gray-500">
                <p class="font-bold text-lg">No client feedback has been submitted yet.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Pagination Links -->
    <div class="mt-8">
        <?php echo e($feedbacks->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views/admin/feedback.blade.php ENDPATH**/ ?>
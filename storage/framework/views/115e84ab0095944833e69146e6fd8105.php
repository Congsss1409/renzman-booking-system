<?php $__env->startSection('title', 'Branches Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Branches <span class="text-teal-500">Management</span></h1>
            <p class="text-gray-500 mt-1">Add, edit, or manage your branches and their images.</p>
        </div>
        <a href="<?php echo e(route('admin.branches.create')); ?>" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-6 rounded-full shadow-lg transition-transform transform hover:scale-105 whitespace-nowrap">
            + ADD BRANCH
        </a>
    </div>

    <!-- Branches Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-stone-50 rounded-2xl p-6 text-center shadow-lg border hover:shadow-xl transition-shadow duration-300 flex flex-col justify-between">
                <div>
                    <img src="<?php echo e($branch->image_url ?? asset('images/branch-placeholder.svg')); ?>" alt="<?php echo e($branch->name); ?>" class="w-32 h-32 mx-auto rounded-lg mb-4 object-cover border-4 border-white shadow-md">
                    <h3 class="text-xl font-bold text-gray-800"><?php echo e($branch->name); ?></h3>
                    <p class="text-gray-500 mb-2 text-sm"><?php echo e($branch->address ?? 'Address not set'); ?></p>
                </div>
                <div class="mt-6 flex justify-center gap-4">
                    <a href="<?php echo e(route('admin.branches.edit', $branch)); ?>" class="font-semibold bg-cyan-400 text-white py-2 px-8 rounded-full shadow-md transition-transform transform hover:scale-105">EDIT IMAGE</a>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-12 text-gray-500">
                <p class="font-bold text-lg">No branches found.</p>
                <p>Seed some branches or create them from the database.</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination Links -->
    <div class="mt-8">
        <?php echo e($branches->links()); ?>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\andre\Downloads\ccs\renzman-booking-system\resources\views/admin/branches/index.blade.php ENDPATH**/ ?>
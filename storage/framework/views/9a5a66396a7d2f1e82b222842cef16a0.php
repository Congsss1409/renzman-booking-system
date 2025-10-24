

<?php $__env->startSection('title', 'Create Payroll'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Add New Payroll</h1>
            <p class="text-gray-500 mt-1">Create a payroll record. Gross is computed from confirmed bookings.</p>
        </div>
        <a href="<?php echo e(route('admin.payrolls.index')); ?>" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-6 rounded-full shadow-md transition-transform transform hover:scale-105 whitespace-nowrap">
            &larr; Back to List
        </a>
    </div>

    <?php if($errors->any()): ?>
        <div class="mb-4 text-red-600">
            <ul class="list-disc pl-5">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <!-- Add Payroll Form -->
    <form action="<?php echo e(route('admin.payrolls.store')); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>

        <!-- Therapist -->
        <div>
            <label for="therapist_id" class="block text-sm font-semibold text-gray-600 mb-2">Therapist (optional)</label>
            <select id="therapist_id" name="therapist_id" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 bg-white">
                <option value="">-- Unassigned --</option>
                <?php $__currentLoopData = $therapists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($t->id); ?>"><?php echo e($t->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- Period -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="period_start" class="block text-sm font-semibold text-gray-600 mb-2">Period Start</label>
                <input type="date" id="period_start" name="period_start" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" required>
            </div>
            <div>
                <label for="period_end" class="block text-sm font-semibold text-gray-600 mb-2">Period End</label>
                <input type="date" id="period_end" name="period_end" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" required>
            </div>
        </div>

        <!-- Deductions & Status -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label for="deductions" class="block text-sm font-semibold text-gray-600 mb-2">Deductions</label>
                <input type="number" step="0.01" id="deductions" name="deductions" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label for="status" class="block text-sm font-semibold text-gray-600 mb-2">Status</label>
                <select id="status" name="status" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 bg-white">
                    <option value="draft">Draft</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
        </div>

        <p class="text-sm text-gray-500">Gross will be calculated automatically as the sum of confirmed bookings for the selected therapist within the period.</p>

        <!-- Form Actions -->
        <div class="flex justify-end gap-4 pt-4">
            <a href="<?php echo e(route('admin.payrolls.index')); ?>" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-8 rounded-full shadow-md transition-transform transform hover:scale-105">
                Cancel
            </a>
            <button type="submit" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105">
                Create Payroll
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views/payrolls/create.blade.php ENDPATH**/ ?>
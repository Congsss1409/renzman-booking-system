<?php $__env->startSection('title', 'Create Payroll'); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold">Create Payroll</h1>
        <p class="text-gray-500 mt-1">Create a payroll record. Gross is computed from confirmed bookings.</p>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <form action="<?php echo e(route('admin.payrolls.store')); ?>" method="POST" class="space-y-4">
            <?php echo csrf_field(); ?>

            <div>
                <label class="block text-sm font-medium text-gray-700">Therapist (optional)</label>
                <select name="therapist_id" class="mt-1 block w-full rounded border-gray-200">
                    <option value="">-- Unassigned --</option>
                    <?php $__currentLoopData = $therapists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($t->id); ?>"><?php echo e($t->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Period Start</label>
                    <input type="date" name="period_start" class="mt-1 block w-full rounded border-gray-200" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Period End</label>
                    <input type="date" name="period_end" class="mt-1 block w-full rounded border-gray-200" required>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Deductions</label>
                    <input type="number" step="0.01" name="deductions" class="mt-1 block w-full rounded border-gray-200">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="mt-1 block w-full rounded border-gray-200">
                        <option value="draft">Draft</option>
                        <option value="paid">Paid</option>
                    </select>
                </div>
            </div>

            <p class="text-sm text-gray-500">Gross will be calculated automatically as the sum of confirmed bookings for the selected therapist within the period.</p>

            <div class="flex items-center gap-3">
                <button class="bg-teal-600 text-white py-2 px-4 rounded">Create Payroll</button>
                <a href="<?php echo e(route('admin.payrolls.index')); ?>" class="text-gray-600">Cancel</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\andre\Downloads\ccs\renzman-booking-system\resources\views/payrolls/create.blade.php ENDPATH**/ ?>
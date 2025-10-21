

<?php $__env->startSection('title', "Payroll #{$payroll->id}"); ?>

<?php $__env->startSection('content'); ?>
<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold">Payroll #<?php echo e($payroll->id); ?></h1>
        <p class="text-gray-500 mt-1">Details for this payroll record.</p>
    </div>

    <div class="bg-white rounded-2xl shadow p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <h3 class="font-semibold text-gray-700">Summary</h3>
            <div class="mt-4 space-y-2 text-sm text-gray-700">
                <div><span class="font-medium">Therapist:</span> <?php echo e(optional($payroll->therapist)->name ?? '—'); ?></div>
                <div><span class="font-medium">Period:</span> <?php echo e($payroll->period_start->toDateString()); ?> — <?php echo e($payroll->period_end->toDateString()); ?></div>
                <div><span class="font-medium">Gross:</span> ₱<?php echo e(number_format($payroll->gross,2)); ?></div>
                <div><span class="font-medium">Therapist (60%):</span> ₱<?php echo e(number_format($payroll->therapist_share ?? 0,2)); ?></div>
                <div><span class="font-medium">Owner (40%):</span> ₱<?php echo e(number_format($payroll->owner_share ?? 0,2)); ?></div>
                <div><span class="font-medium">Deductions:</span> ₱<?php echo e(number_format($payroll->deductions,2)); ?></div>
                <div><span class="font-medium">Net (to Therapist):</span> ₱<?php echo e(number_format($payroll->net,2)); ?></div>
                <div><span class="font-medium">Status:</span> <?php echo e(ucfirst($payroll->status)); ?></div>
            </div>
            <div class="mt-4">
                <a href="<?php echo e(route('admin.payrolls.export_pdf', $payroll->id)); ?>" class="inline-flex items-center gap-2 bg-cyan-400 text-white py-2 px-4 rounded-full shadow-md hover:bg-cyan-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"/></svg>
                    Export PDF
                </a>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-gray-50 p-4 rounded">
                    <h4 class="font-semibold">Items</h4>
                    <ul class="mt-3 space-y-2 text-sm">
                        <?php $__currentLoopData = $payroll->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="flex items-center justify-between">
                                <div>
                                    <div class="font-medium"><?php echo e($item->description); ?></div>
                                    <div class="text-xs text-gray-500"><?php echo e($item->created_at->toDateString()); ?></div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="text-sm">₱<?php echo e(number_format($item->amount,2)); ?></div>
                                    <form action="<?php echo e(route('admin.payrolls.items.remove', $item->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button class="text-red-500 text-sm">Remove</button>
                                    </form>
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>

                    <form action="<?php echo e(route('admin.payrolls.items.add', $payroll->id)); ?>" method="POST" class="mt-4 space-y-2">
                        <?php echo csrf_field(); ?>
                        <input type="text" name="description" placeholder="Description" class="w-full rounded border-gray-200 p-2" required>
                        <input type="number" step="0.01" name="amount" placeholder="Amount" class="w-full rounded border-gray-200 p-2" required>
                        <div class="mt-2">
                            <button class="bg-teal-600 text-white py-1 px-3 rounded">Add Item</button>
                        </div>
                    </form>
                </div>

                <div class="bg-gray-50 p-4 rounded">
                    <h4 class="font-semibold">Payments</h4>
                    <ul class="mt-3 space-y-2 text-sm">
                        <?php $__currentLoopData = $payroll->payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="flex items-center justify-between">
                                <div>
                                    <div class="font-medium">₱<?php echo e(number_format($payment->amount,2)); ?></div>
                                    <div class="text-xs text-gray-500"><?php echo e(optional($payment->paid_at)->toDateString()); ?> — <?php echo e($payment->method); ?> <?php echo e($payment->reference ? "(#{$payment->reference})" : ''); ?></div>
                                </div>
                                <div class="text-green-600 text-sm">Recorded</div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>

                    <form action="<?php echo e(route('admin.payrolls.payments.add', $payroll->id)); ?>" method="POST" class="mt-4 space-y-2">
                        <?php echo csrf_field(); ?>
                        <input type="number" step="0.01" name="amount" placeholder="Amount" class="w-full rounded border-gray-200 p-2" required>
                        <input type="date" name="paid_at" class="w-full rounded border-gray-200 p-2">
                        <input type="text" name="method" placeholder="Method (e.g. Bank transfer)" class="w-full rounded border-gray-200 p-2">
                        <input type="text" name="reference" placeholder="Reference" class="w-full rounded border-gray-200 p-2">
                        <div class="mt-2">
                            <button class="bg-teal-600 text-white py-1 px-3 rounded">Record Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div>
        <a href="<?php echo e(route('admin.payrolls.index')); ?>" class="text-gray-600">&larr; Back to payrolls</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views/payrolls/show.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', "Payroll #{$payroll->id}"); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Payroll #<?php echo e($payroll->id); ?></h1>
            <p class="text-gray-500 mt-1">Details for this payroll record.</p>
        </div>
        <a href="<?php echo e(route('admin.payrolls.export_pdf', $payroll->id)); ?>" class="font-semibold bg-cyan-400 text-white py-2 px-6 rounded-full shadow-md hover:bg-cyan-500 transition-transform transform hover:scale-105 whitespace-nowrap">Export PDF</a>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-1">
            <h3 class="font-semibold text-gray-700 mb-4">Summary</h3>
            <div class="space-y-2 text-sm text-gray-700">
                <div><span class="font-medium">Therapist:</span> <?php echo e(optional($payroll->therapist)->name ?? '—'); ?></div>
                <div><span class="font-medium">Period:</span> <?php echo e($payroll->period_start->toDateString()); ?> — <?php echo e($payroll->period_end->toDateString()); ?></div>
                <div><span class="font-medium">Gross:</span> ₱<?php echo e(number_format($payroll->gross,2)); ?></div>
                <div><span class="font-medium">Therapist (60%):</span> ₱<?php echo e(number_format($payroll->therapist_share ?? 0,2)); ?></div>
                <div><span class="font-medium">Owner (40%):</span> ₱<?php echo e(number_format($payroll->owner_share ?? 0,2)); ?></div>
                <div><span class="font-medium">Deductions:</span> ₱<?php echo e(number_format($payroll->deductions,2)); ?></div>
                <div><span class="font-medium">Net (to Therapist):</span> ₱<?php echo e(number_format($payroll->net,2)); ?></div>
                <div><span class="font-medium">Status:</span> <?php echo e(ucfirst($payroll->status)); ?></div>
            </div>
        </div>
        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded">
                <h4 class="font-semibold mb-2">Items</h4>
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
                    <select name="service_id" id="service_id" class="w-full rounded border-gray-200 p-2" required>
                        <option value="" disabled selected>Select service</option>
                        <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($service->id); ?>" data-price="<?php echo e($service->price); ?>"><?php echo e($service->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                    <input type="number" step="0.01" name="amount" id="service_amount" placeholder="Amount" class="w-full rounded border-gray-200 p-2" required>
                    <div class="mt-2">
                        <button class="bg-teal-600 text-white py-1 px-3 rounded">Add Item</button>
                    </div>
                    <script>
                        document.addEventListener('DOMContentLoaded', function () {
                            const serviceSelect = document.getElementById('service_id');
                            const amountInput = document.getElementById('service_amount');
                            if (serviceSelect && amountInput) {
                                serviceSelect.addEventListener('change', function () {
                                    const selected = serviceSelect.options[serviceSelect.selectedIndex];
                                    const price = selected.getAttribute('data-price');
                                    if (price) {
                                        amountInput.value = price;
                                    } else {
                                        amountInput.value = '';
                                    }
                                });
                            }
                        });
                    </script>
                </form>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <h4 class="font-semibold mb-2">Payments</h4>
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
    <div class="flex justify-end">
        <a href="<?php echo e(route('admin.payrolls.index')); ?>" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-6 rounded-full shadow-md transition-transform transform hover:scale-105 whitespace-nowrap">&larr; Back to payrolls</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Desktop\renzman-booking-system\resources\views/payrolls/show.blade.php ENDPATH**/ ?>
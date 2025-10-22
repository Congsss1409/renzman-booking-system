<!-- Create Booking Modal -->
<dialog id="createBookingModal" class="p-0 bg-transparent rounded-lg backdrop:bg-black/50">
    <div class="w-full max-w-2xl bg-white rounded-lg shadow-xl">
        <form action="<?php echo e(route('admin.bookings.store')); ?>" method="POST" id="createBookingForm">
            <?php echo csrf_field(); ?>
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800">Create New Booking</h3>
                <p class="mt-1 text-sm text-gray-500">Manually add a new booking to the system.</p>
            </div>

            <div class="p-6 space-y-6">
                <!-- Client Details -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                    <div class="sm:col-span-1">
                        <label for="client_name" class="block text-sm font-medium text-gray-700">Client Name</label>
                        <input type="text" name="client_name" id="client_name" value="<?php echo e(old('client_name')); ?>" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <?php $__errorArgs = ['client_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                     <div class="sm:col-span-1">
                        <label for="client_email" class="block text-sm font-medium text-gray-700">Client Email</label>
                        <input type="email" name="client_email" id="client_email" value="<?php echo e(old('client_email')); ?>" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <?php $__errorArgs = ['client_email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="sm:col-span-1">
                        <label for="client_phone" class="block text-sm font-medium text-gray-700">Client Phone</label>
                        <input type="text" name="client_phone" id="client_phone" value="<?php echo e(old('client_phone')); ?>" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <?php $__errorArgs = ['client_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                
                <hr>

                <!-- Booking Details -->
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <div>
                        <label for="branch_id" class="block text-sm font-medium text-gray-700">Branch</label>
                        <select name="branch_id" id="branch_id" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <option value="">Select a Branch</option>
                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch->id); ?>" <?php echo e(old('branch_id') == $branch->id ? 'selected' : ''); ?>><?php echo e($branch->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                         <?php $__errorArgs = ['branch_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="service_id" class="block text-sm font-medium text-gray-700">Service</label>
                        <select name="service_id" id="service_id" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                             <option value="">Select a Service</option>
                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($service->id); ?>" <?php echo e(old('service_id') == $service->id ? 'selected' : ''); ?>><?php echo e($service->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                         <?php $__errorArgs = ['service_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div>
                        <label for="therapist_id" class="block text-sm font-medium text-gray-700">Therapist</label>
                        <select name="therapist_id" id="therapist_id" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" disabled>
                            <option value="">Select a branch first</option>
                        </select>
                         <?php $__errorArgs = ['therapist_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                     <div>
                        <label for="booking_date" class="block text-sm font-medium text-gray-700">Date & Time</label>
                        <div class="flex gap-2 mt-1">
                            <input type="date" name="booking_date" id="booking_date" value="<?php echo e(old('booking_date')); ?>" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            <input type="time" name="booking_time" id="booking_time" value="<?php echo e(old('booking_time')); ?>" required class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>
                        <?php $__errorArgs = ['booking_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="block mt-1 text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <?php $__errorArgs = ['booking_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="block mt-1 text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-gray-50 flex justify-end gap-3 rounded-b-lg">
                <button type="button" onclick="document.getElementById('createBookingModal').close()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">Cancel</button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700">Create Booking</button>
            </div>
        </form>
    </div>
</dialog>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const branchSelect = document.getElementById('branch_id');
    const therapistSelect = document.getElementById('therapist_id');

    branchSelect.addEventListener('change', function () {
        const branchId = this.value;
        therapistSelect.innerHTML = '<option value="">Loading...</option>';
        therapistSelect.disabled = true;

        if (!branchId) {
            therapistSelect.innerHTML = '<option value="">Select a branch first</option>';
            return;
        }

        fetch(`/admin/branches/${branchId}/therapists`)
            .then(response => response.json())
            .then(data => {
                therapistSelect.innerHTML = '<option value="">Select a Therapist</option>';
                data.forEach(therapist => {
                    const option = document.createElement('option');
                    option.value = therapist.id;
                    option.textContent = therapist.name;
                    therapistSelect.appendChild(option);
                });
                therapistSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error fetching therapists:', error);
                therapistSelect.innerHTML = '<option value="">Could not load therapists</option>';
            });
    });

    // If there were validation errors, the page reloaded. We need to re-trigger
    // the change event if a branch was already selected to populate therapists.
    if (branchSelect.value) {
        branchSelect.dispatchEvent(new Event('change'));
        // And if a therapist was already selected, we try to re-select them.
        const oldTherapistId = "<?php echo e(old('therapist_id')); ?>";
        if (oldTherapistId) {
            // We need a small delay to allow the options to be populated by the fetch call
            setTimeout(() => {
                therapistSelect.value = oldTherapistId;
            }, 500);
        }
    }
    
    // Logic to automatically show modal if there are validation errors from form submission
    <?php if($errors->any()): ?>
        document.getElementById('createBookingModal').showModal();
    <?php endif; ?>
});
</script>
<?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views\admin\create-booking.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Add New Therapist'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Add New Therapist</h1>
            <p class="text-gray-500 mt-1">Fill in the details to add a new member to your team.</p>
        </div>
        <a href="<?php echo e(route('admin.therapists.index')); ?>" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-6 rounded-full shadow-md transition-transform transform hover:scale-105 whitespace-nowrap">
            &larr; Back to List
        </a>
    </div>

    <!-- Add Therapist Form -->
    <form action="<?php echo e(route('admin.therapists.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
        <?php echo csrf_field(); ?>

        <!-- Therapist Name -->
        <div>
            <label for="name" class="block text-sm font-semibold text-gray-600 mb-2">Therapist Name</label>
            <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" required
                   class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"
                   placeholder="e.g., Jane Doe">
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Branch -->
        <div>
            <label for="branch_id" class="block text-sm font-semibold text-gray-600 mb-2">Branch</label>
            <select id="branch_id" name="branch_id" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 appearance-none bg-white">
                <option value="" disabled selected>Select a branch</option>
                <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($branch->id); ?>" <?php echo e(old('branch_id') == $branch->id ? 'selected' : ''); ?>><?php echo e($branch->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['branch_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <!-- Image Upload -->
        <div>
            <label for="image" class="block text-sm font-semibold text-gray-600 mb-2">Therapist Photo (Optional)</label>
            <div x-data="{ imagePreview: null }" class="flex items-center gap-4">
                <img x-show="imagePreview" :src="imagePreview" alt="Image Preview" class="w-20 h-20 rounded-full object-cover border-2 border-gray-300">
                <div x-show="!imagePreview" class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                </div>
                <input type="file" id="image" name="image" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-teal-50 file:text-teal-700
                    hover:file:bg-teal-100"
                    @change="imagePreview = URL.createObjectURL($event.target.files[0])">
            </div>
             <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="text-red-500 text-xs mt-1"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <!-- Form Actions -->
        <div class="flex justify-end gap-4 pt-4">
            <a href="<?php echo e(route('admin.therapists.index')); ?>" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-8 rounded-full shadow-md transition-transform transform hover:scale-105">
                Cancel
            </a>
            <button type="submit" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105">
                Save Therapist
            </button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Account creation fields removed for therapists per project policy.
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\andre\Downloads\ccs\renzman-booking-system\resources\views/admin/create-therapist.blade.php ENDPATH**/ ?>
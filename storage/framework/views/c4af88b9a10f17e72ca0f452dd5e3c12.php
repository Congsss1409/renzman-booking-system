


<?php $__env->startSection('title', 'Edit User'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Edit User</h1>
            <p class="text-gray-500 mt-1">Update the account details for <?php echo e($user->name); ?>.</p>
        </div>
        <a href="<?php echo e(route('admin.users.index')); ?>" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-6 rounded-full shadow-md transition-transform transform hover:scale-105 whitespace-nowrap">
            &larr; Back to List
        </a>
    </div>

    <?php if($errors->any()): ?><div class="p-4 bg-red-100 text-red-800 mb-4">Please fix the errors below.</div><?php endif; ?>

    <form action="<?php echo e(route('admin.users.update', $user)); ?>" method="POST" class="space-y-6">
        <?php echo csrf_field(); ?>

        <div>
            <label class="block text-sm font-semibold">Name</label>
            <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" required>
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <label class="block text-sm font-semibold">Email</label>
            <input type="email" name="email" value="<?php echo e(old('email', $user->email)); ?>" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" required>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold">Password (leave blank to keep)</label>
                <input type="password" name="password" class="w-full mt-1 p-3 border border-gray-300 rounded-lg">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="block text-sm font-semibold">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full mt-1 p-3 border border-gray-300 rounded-lg">
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold">Role</label>
            <select name="role" class="w-full mt-1 p-3 border border-gray-300 rounded-lg">
                <option value="admin" <?php echo e((old('role', $user->role) === 'admin') ? 'selected' : ''); ?>>Admin</option>
            </select>
        </div>

        <div class="flex justify-end gap-4 pt-4">
            <a href="<?php echo e(route('admin.users.index')); ?>" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-8 rounded-full shadow-md transition-transform transform hover:scale-105">Cancel</a>
            <button type="submit" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105">Save Changes</button>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views\admin\users\edit.blade.php ENDPATH**/ ?>
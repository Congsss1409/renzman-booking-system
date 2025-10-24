


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


        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-semibold">First Name</label>
                <input type="text" name="first_name" value="<?php echo e(old('first_name', $user->first_name ?? '')); ?>" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="block text-sm font-semibold">Middle Name</label>
                <input type="text" name="middle_name" value="<?php echo e(old('middle_name', $user->middle_name ?? '')); ?>" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                <?php $__errorArgs = ['middle_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="block text-sm font-semibold">Last Name</label>
                <input type="text" name="last_name" value="<?php echo e(old('last_name', $user->last_name ?? '')); ?>" class="w-full mt-1 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-sm text-red-600"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
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
                <div class="relative">
                    <input type="password" id="password" name="password" class="w-full mt-1 p-3 border border-gray-300 rounded-lg pr-12">
                    <button type="button" id="togglePassword" tabindex="-1" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 focus:outline-none" aria-label="Show or hide password">
                        <!-- Eye (show) icon -->
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16" class="block"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zm0 1a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3z"/></svg>
                        <!-- Eye-slash (hide) icon -->
                        <svg id="eyeSlashIcon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16" class="hidden"><path d="M13.359 11.238C14.06 10.47 14.682 9.607 15.197 8.8a.5.5 0 0 0 0-.6s-3-5.5-8-5.5c-1.357 0-2.591.314-3.68.832l1.46 1.46C5.12 4.668 6.88 3.5 9 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.24.24-.49.47-.75.695zM2.354 1.646a.5.5 0 1 0-.708.708l1.06 1.06C1.94 4.02 1.173 5.13 1.173 8c0 .87.767 1.98 1.533 2.586l-1.06 1.06a.5.5 0 1 0 .708.708l12-12zM8 5.5a2.5 2.5 0 0 0-2.45 2.01l1.06 1.06A1.5 1.5 0 0 1 8 6.5a1.5 1.5 0 0 1 1.39.94l1.06 1.06A2.5 2.5 0 0 0 8 5.5zm0 6c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8c.058-.087.122-.183.195-.288.335-.48.83-1.12 1.465-1.755C4.121 4.668 5.88 3.5 8 3.5c.29 0 .574.02.853.057l1.634 1.634A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.12 12.5 8 12.5z"/></svg>
                    </button>
                </div>
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
                <div class="relative">
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full mt-1 p-3 border border-gray-300 rounded-lg pr-12">
                    <button type="button" id="togglePasswordConfirm" tabindex="-1" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 focus:outline-none" aria-label="Show or hide confirm password">
                        <!-- Eye (show) icon -->
                        <svg id="eyeIconConfirm" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16" class="block"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zm0 1a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3z"/></svg>
                        <!-- Eye-slash (hide) icon -->
                        <svg id="eyeSlashIconConfirm" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16" class="hidden"><path d="M13.359 11.238C14.06 10.47 14.682 9.607 15.197 8.8a.5.5 0 0 0 0-.6s-3-5.5-8-5.5c-1.357 0-2.591.314-3.68.832l1.46 1.46C5.12 4.668 6.88 3.5 9 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.24.24-.49.47-.75.695zM2.354 1.646a.5.5 0 1 0-.708.708l1.06 1.06C1.94 4.02 1.173 5.13 1.173 8c0 .87.767 1.98 1.533 2.586l-1.06 1.06a.5.5 0 1 0 .708.708l12-12zM8 5.5a2.5 2.5 0 0 0-2.45 2.01l1.06 1.06A1.5 1.5 0 0 1 8 6.5a1.5 1.5 0 0 1 1.39.94l1.06 1.06A2.5 2.5 0 0 0 8 5.5zm0 6c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8c.058-.087.122-.183.195-.288.335-.48.83-1.12 1.465-1.755C4.121 4.668 5.88 3.5 8 3.5c.29 0 .574.02.853.057l1.634 1.634A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.12 12.5 8 12.5z"/></svg>
                    </button>
                </div>
            </div>
        </div>



        <div class="flex justify-end gap-4 pt-4">
            <a href="<?php echo e(route('admin.users.index')); ?>" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-8 rounded-full shadow-md transition-transform transform hover:scale-105">Cancel</a>
            <button type="submit" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105">Save Changes</button>
        </div>
    </form>
<script>
    // Password field toggle
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeSlashIcon = document.getElementById('eyeSlashIcon');
    if (togglePassword) {
        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.classList.toggle('hidden', !isPassword);
            eyeSlashIcon.classList.toggle('hidden', isPassword);
        });
    }
    // Confirm password field toggle
    const passwordInputConfirm = document.getElementById('password_confirmation');
    const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
    const eyeIconConfirm = document.getElementById('eyeIconConfirm');
    const eyeSlashIconConfirm = document.getElementById('eyeSlashIconConfirm');
    if (togglePasswordConfirm) {
        togglePasswordConfirm.addEventListener('click', function () {
            const isPassword = passwordInputConfirm.type === 'password';
            passwordInputConfirm.type = isPassword ? 'text' : 'password';
            eyeIconConfirm.classList.toggle('hidden', !isPassword);
            eyeSlashIconConfirm.classList.toggle('hidden', isPassword);
        });
    }
</script>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>
<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center p-8 bg-gray-100">
    <div class="w-full max-w-xl">
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            <div class="p-6 md:p-8">
                <div class="flex items-start gap-4">
                    <div class="flex-shrink-0">
                        <div class="p-3 bg-gradient-to-br from-teal-400 to-cyan-600 rounded-lg text-white">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3m-6 0c0 1.657-1.343 3-3 3s-3-1.343-3-3m6 0v6m0 0H6m6 0h6" />
                            </svg>
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">Two-factor verification</h1>
                        <p class="text-sm text-gray-600">Enter the 6-digit code we sent to your email to complete sign in.</p>
                    </div>
                </div>

                <?php if(session('status')): ?>
                    <div class="mt-4 rounded-md bg-green-50 border border-green-100 p-3 text-green-700"><?php echo e(session('status')); ?></div>
                <?php endif; ?>

                <?php if($errors->any()): ?>
                    <div class="mt-4 rounded-md bg-red-50 border border-red-100 p-3 text-red-700">
                        <ul class="list-disc pl-5 text-sm">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('2fa.verify')); ?>" class="mt-6 grid gap-4">
                    <?php echo csrf_field(); ?>
                    <div>
                        <label for="code" class="block text-sm font-medium text-gray-700">Verification code</label>
                        <input id="code" name="code" inputmode="numeric" pattern="[0-9]*" maxlength="6" value="<?php echo e(old('code')); ?>" required autofocus
                            class="mt-1 block w-full px-4 py-3 border border-gray-200 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-cyan-300 shadow-sm focus:shadow-md transition-shadow duration-150" placeholder="123456">
                    </div>

                    <div class="flex items-center justify-between">
                        <button type="submit" class="px-4 py-2 bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white text-sm font-medium rounded-md shadow">Verify</button>
                        <button type="button" id="resend-btn" class="text-sm text-teal-600 hover:underline">Resend code</button>
                    </div>
                </form>

                <form id="resend-form" method="POST" action="<?php echo e(route('2fa.resend')); ?>" style="display:none;"><?php echo csrf_field(); ?></form>

                <div class="mt-6 text-sm text-gray-600 text-center">
                    <a href="<?php echo e(route('login')); ?>" class="text-teal-600 hover:underline">Back to login</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function(){
            const resendBtn = document.getElementById('resend-btn');
            const resendForm = document.getElementById('resend-form');
            let cooldown = 30; // seconds
            let timerId = null;

            function startCooldown() {
                resendBtn.disabled = true;
                resendBtn.classList.add('opacity-60');
                resendBtn.textContent = `Resend (${cooldown}s)`;
                timerId = setInterval(()=>{
                    cooldown -= 1;
                    if (cooldown <= 0) {
                        clearInterval(timerId);
                        resendBtn.disabled = false;
                        resendBtn.classList.remove('opacity-60');
                        resendBtn.textContent = 'Resend code';
                        cooldown = 30;
                    } else {
                        resendBtn.textContent = `Resend (${cooldown}s)`;
                    }
                }, 1000);
            }

            resendBtn.addEventListener('click', function(e){
                e.preventDefault();
                if (resendBtn.disabled) return;
                resendForm.submit();
                startCooldown();
            });
        })();
    </script>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\andre\Downloads\ccs\renzman-booking-system\resources\views/auth/2fa.blade.php ENDPATH**/ ?>
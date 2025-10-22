<?php $__env->startSection('title', 'Step 5: Verify Your Booking'); ?>

<?php $__env->startSection('content'); ?>
<div class="glass-panel rounded-3xl max-w-6xl mx-auto overflow-hidden shadow-2xl">
    <div class="grid md:grid-cols-2">
        
        <div class="hidden md:block relative">
            <img src="https://placehold.co/800x1200/0d9488/FFFFFF?text=Secure+Your+Spot&font=poppins" class="absolute h-full w-full object-cover" alt="A locked icon representing security">
            <div class="absolute inset-0 bg-teal-800/50"></div>
            <div class="relative z-10 p-12 text-white flex flex-col h-full">
                <div>
                    <h2 class="text-3xl font-bold">Final Confirmation</h2>
                    <p class="mt-2 text-cyan-100">We've sent a 6-digit verification code to your email address to secure your appointment.</p>
                </div>
                <div class="mt-auto text-cyan-200 text-sm">
                    <p>This code will expire in 2 minutes. Please check your inbox (and spam folder).</p>
                </div>
            </div>
        </div>

        <div class="p-8 md:p-12">
            <div class="mb-8">
                <div class="flex justify-between items-center text-sm font-semibold text-black mb-2">
                    <span class="text-black">Step 5/5: Verification</span>
                    <span class="text-black">100%</span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-2.5">
                    <div class="bg-white h-2.5 rounded-full" style="width: 100%"></div>
                </div>
            </div>

            <div class="text-left mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-black">Enter Verification Code</h1>
                <?php
                    $expiresAt = $booking->verification_expires_at ?? \Carbon\Carbon::now()->addMinutes(2);
                ?>
                <p class="mt-2 text-lg text-black">A code has been sent to <?php echo e($booking->client_email); ?>. <span id="countdown" class="text-sm text-gray-800 ml-2">(02:00)</span></p>
                <input type="hidden" id="expiresAt" value="<?php echo e(\Carbon\Carbon::parse($expiresAt)->toIso8601String()); ?>">
                <div id="resendStatus" class="mt-2"></div>
            </div>

            <?php if(session('error')): ?>
                <div class="mb-4 bg-red-500/30 border border-red-400 text-black px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline"><?php echo e(session('error')); ?></span>
                </div>
            <?php endif; ?>
            <?php if(session('success')): ?>
                <div class="mb-4 bg-green-200 border border-green-300 text-black px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline"><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>
             <?php $__errorArgs = ['verification_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="mb-4 bg-red-500/30 border border-red-400 text-black px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline"><?php echo e($message); ?></span>
                </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <form action="<?php echo e(route('booking.store.step-five')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="booking_id" value="<?php echo e($booking->id); ?>">
                <div class="space-y-6 text-black">
                    <div>
                        <label for="verification_code" class="block text-lg font-semibold mb-2 text-black">6-Digit Code</label>
                        <input type="text" name="verification_code" id="verification_code" required
                               class="w-full p-4 bg-white/10 rounded-lg border border-white/30 focus:outline-none focus:ring-2 focus:ring-white text-center text-2xl tracking-[1em] text-black" 
                               placeholder="______" maxlength="6" pattern="[0-9]{6}">
                    </div>
                </div>

                <div class="mt-10 flex justify-between">
                    <a href="<?php echo e(route('booking.create.step-four')); ?>" class="bg-white/20 text-white font-bold py-3 px-10 rounded-full shadow-md hover:bg-white/30 transition-all transform hover:scale-105">
                        &larr; Back
                    </a>
                    <div class="flex items-center gap-4">
                        <button id="resendButton" type="button" class="bg-white/20 text-white font-bold py-3 px-6 rounded-full shadow-md hover:bg-white/30 transition-all transform hover:scale-105">Resend Code</button>
                        <button id="confirmButton" type="submit" class="bg-white text-teal-600 font-bold py-3 px-10 rounded-full shadow-md hover:bg-cyan-100 transition-all transform hover:scale-105">
                            Confirm Booking
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    (function(){
        let expiresAtIso = document.getElementById('expiresAt')?.value;
        const resendStatus = document.getElementById('resendStatus');
        const resendButton = document.getElementById('resendButton');
        // helper to show inline messages
        function showStatus(message, type='info'){
            if(!resendStatus) return;
            const colors = {info: 'text-sm text-gray-700', success: 'text-sm text-green-700', error: 'text-sm text-red-700'};
            resendStatus.innerHTML = `<div class="${colors[type]}">${message}</div>`;
        }
        
        // AJAX resend handler
        if (resendButton) {
            resendButton.addEventListener('click', function(){
                resendButton.disabled = true;
                showStatus('Sending new code...', 'info');
                fetch("<?php echo e(route('booking.resend-code')); ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ booking_id: '<?php echo e($booking->id); ?>' })
                }).then(res => res.json()).then(data => {
                    if (data.success) {
                        // update expiry and reset timer
                        expiresAtIso = data.expires_at;
                        expiresAt.setTime(new Date(expiresAtIso).getTime());
                        if (confirmBtn) confirmBtn.disabled = false;
                        if (codeInput) codeInput.disabled = false;
                        showStatus('A new verification code has been sent.', 'success');
                    } else {
                        showStatus(data.message || 'Failed to resend code.', 'error');
                    }
                }).catch(err => {
                    showStatus('Failed to resend code. Please try again.', 'error');
                }).finally(() => { resendButton.disabled = false; });
            });
        }

        const expiresAt = expiresAtIso ? new Date(expiresAtIso) : null;
        if (!expiresAt) return;
        const countdownEl = document.getElementById('countdown');
        const confirmBtn = document.getElementById('confirmButton');
        const codeInput = document.getElementById('verification_code');

        function update() {
            const now = new Date();
            let diff = Math.floor((expiresAt - now) / 1000);
            if (diff <= 0) {
                countdownEl.textContent = '(Expired)';
                if (confirmBtn) confirmBtn.disabled = true;
                if (codeInput) codeInput.disabled = true;
                // don't clear interval permanently; keep checking in case resend updates expiresAt
                return;
            }
            const minutes = String(Math.floor(diff / 60)).padStart(2, '0');
            const seconds = String(diff % 60).padStart(2, '0');
            countdownEl.textContent = `(${minutes}:${seconds})`;
        }

        update();
        const timer = setInterval(update, 1000);
        // Prevent form submission if expired (extra guard)
        const form = document.querySelector('form[action="<?php echo e(route('booking.store.step-five')); ?>"]');
        if (form) {
            form.addEventListener('submit', function(e){
                const now = new Date();
                if (!expiresAt || now >= expiresAt) {
                    e.preventDefault();
                    showStatus('Your verification code has expired. Please request a new code.', 'error');
                }
            });
        }
    })();
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.Booking', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views\booking\step-five.blade.php ENDPATH**/ ?>
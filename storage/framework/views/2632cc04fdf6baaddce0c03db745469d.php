<?php $__env->startSection('title', 'Share Feedback'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto py-12 px-4">
    <div class="bg-white shadow rounded-2xl overflow-hidden">
        <div class="bg-gradient-to-r from-teal-500 to-cyan-500 text-white text-center py-8 px-6">
            <img src="<?php echo e(asset('images/logo trans.png')); ?>" alt="Renzman" class="mx-auto mb-3 w-20 h-20 object-contain">
            <h1 class="text-2xl font-bold">We'd love your feedback</h1>
            <p class="mt-2 text-sm opacity-90">Tell us about your recent experience so we can keep improving.</p>
        </div>

        <div class="p-8">
            <p class="text-gray-700 mb-6">Hi <strong><?php echo e($booking->client_name); ?></strong>, please rate your recent experience and leave an optional comment below.</p>

            <form action="<?php echo e(route('feedback.store', $booking->feedback_token)); ?>" method="POST" class="space-y-6">
                <?php echo csrf_field(); ?>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>

                    <div class="star-rating flex gap-2 items-center" role="radiogroup" aria-label="Rating">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <input type="radio" name="rating" id="rating-<?php echo e($i); ?>" value="<?php echo e($i); ?>" class="hidden rating-input" <?php echo e(old('rating') == $i ? 'checked' : ''); ?> required>
                            <button type="button" class="star text-gray-300 hover:text-yellow-400 focus:outline-none transition-colors duration-150 transform" data-value="<?php echo e($i); ?>" aria-label="<?php echo e($i); ?> star<?php echo e($i>1 ? 's' : ''); ?>" role="radio" aria-checked="false">
                                <svg class="w-7 h-7" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <!-- filled path (hidden by default) -->
                                    <path class="star-fill" d="M12 .587l3.668 7.431L24 9.75l-6 5.847L19.335 24 12 19.771 4.665 24 6 15.597 0 9.75l8.332-1.732L12 .587z" fill="currentColor" opacity="0" />
                                    <!-- outline path -->
                                    <path class="star-outline" d="M12 .587l3.668 7.431L24 9.75l-6 5.847L19.335 24 12 19.771 4.665 24 6 15.597 0 9.75l8.332-1.732L12 .587z" fill="none" stroke="currentColor" stroke-width="1.2" />
                                </svg>
                            </button>
                        <?php endfor; ?>
                    </div>

                    <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Feedback (optional)</label>
                    <textarea name="feedback" rows="5" class="mt-1 block w-full rounded-lg border border-gray-300 p-3 focus:outline-none focus:ring-2 focus:ring-teal-400" placeholder="Share any comments about your experience..."></textarea>
                    <?php $__errorArgs = ['feedback'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><p class="text-sm text-red-600 mt-2"><?php echo e($message); ?></p><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-teal-400 to-cyan-600 text-white rounded-full font-semibold shadow">Submit Feedback</button>
                    <a href="/" class="text-sm text-gray-500 underline">Skip for now</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const starButtons = Array.from(document.querySelectorAll('.star-rating .star'));
    const radios = Array.from(document.querySelectorAll('.star-rating .rating-input'));
    const radiosByValue = radios.reduce((acc, r) => (acc[r.value] = r, acc), {});

    function setRating(value) {
        // set radio checked
        radios.forEach(r => r.checked = (r.value === String(value)));
        // update visual stars and aria state
        starButtons.forEach(btn => {
            const v = Number(btn.dataset.value);
            const isFilled = v <= value;
            btn.classList.toggle('text-yellow-400', isFilled);
            btn.classList.toggle('text-gray-300', !isFilled);
            btn.classList.toggle('filled', isFilled);
            btn.setAttribute('aria-checked', isFilled ? 'true' : 'false');
        });
        // animate selected star briefly
        const selectedBtn = starButtons.find(b => Number(b.dataset.value) === Number(value));
        if (selectedBtn) {
            selectedBtn.classList.add('animate-pop');
            setTimeout(() => selectedBtn.classList.remove('animate-pop'), 180);
            // focus the selected button for clarity
            selectedBtn.focus();
        }
    }

    starButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const value = Number(btn.dataset.value);
            // check radio explicitly
            const radio = radiosByValue[String(value)];
            if (radio) radio.checked = true;
            setRating(value);
        });
        btn.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                btn.click();
                return;
            }
            if (e.key === 'ArrowLeft' || e.key === 'ArrowDown') {
                e.preventDefault();
                const current = Number(btn.dataset.value);
                const prev = Math.max(1, current - 1);
                setRating(prev);
                document.querySelector('.star[data-value="' + prev + '"]')?.focus();
                return;
            }
            if (e.key === 'ArrowRight' || e.key === 'ArrowUp') {
                e.preventDefault();
                const current = Number(btn.dataset.value);
                const next = Math.min(5, current + 1);
                setRating(next);
                document.querySelector('.star[data-value="' + next + '"]')?.focus();
                return;
            }
        });
        // make button focusable
        btn.setAttribute('tabindex', '0');
    });

    // initialize from old value if present
    const checkedRadio = radios.find(r => r.checked);
    if (checkedRadio) {
        setRating(Number(checkedRadio.value));
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* Star SVG hover/selection animations */
.star svg { transition: transform .15s ease, color .15s ease, fill .12s ease; transform-origin: center; }
.star:hover svg { transform: scale(1.08); }
.star.animate-pop svg { transform: scale(1.18); }
/* Outline by default, fill when selected */
.star svg { fill: none; }
.star.filled svg { fill: currentColor; stroke: currentColor; }
</style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Desktop\renzman-booking-system\resources\views/feedback/create.blade.php ENDPATH**/ ?>
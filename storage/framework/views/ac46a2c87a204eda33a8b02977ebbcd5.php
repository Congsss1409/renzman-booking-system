

<?php $__env->startSection('title', 'Share Feedback'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-3xl mx-auto py-12 px-4">
    <div class="bg-white shadow rounded-lg p-8">
        <h1 class="text-2xl font-bold text-teal-600 mb-4">We'd love your feedback</h1>
        <p class="text-gray-600 mb-6">Hi <?php echo e($booking->client_name); ?>, please rate your recent experience and leave an optional comment.</p>

        <form action="<?php echo e(route('feedback.store', $booking->feedback_token)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Rating</label>
                <select name="rating" required class="mt-1 block w-full border-gray-300 rounded-md">
                    <option value="">Select rating</option>
                    <?php for($i = 1; $i <= 5; $i++): ?>
                        <option value="<?php echo e($i); ?>"><?php echo e($i); ?> star<?php echo e($i > 1 ? 's' : ''); ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Feedback (optional)</label>
                <textarea name="feedback" rows="5" class="mt-1 block w-full border-gray-300 rounded-md"></textarea>
            </div>

            <div class="flex items-center justify-between">
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-md">Submit Feedback</button>
                <a href="/" class="text-sm text-gray-500">Skip for now</a>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Vincen Basa\Desktop\renzman-booking-system\resources\views/feedback/create.blade.php ENDPATH**/ ?>
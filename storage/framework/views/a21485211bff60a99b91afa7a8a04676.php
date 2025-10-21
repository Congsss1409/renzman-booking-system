<?php $__env->startSection('title', 'Booking Confirmed!'); ?>

<?php $__env->startSection('content'); ?>
<div class="glass-panel rounded-3xl max-w-4xl mx-auto p-8 md:p-12 shadow-2xl text-center">
    
    <div class="w-24 h-24 bg-white/20 rounded-full mx-auto flex items-center justify-center">
        <svg class="w-16 h-16 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    </div>

    <div class="mt-8">
        <h1 class="text-4xl md:text-5xl font-bold">Booking Confirmed!</h1>
        <p class="mt-4 text-lg text-cyan-100">Thank you, <?php echo e($booking->client_name); ?>. Your appointment is scheduled.</p>
        <p class="mt-2 text-cyan-200">A confirmation email with your booking details has been sent to <?php echo e($booking->client_email); ?>.</p>
    </div>

    <div class="mt-10 text-left border-t border-white/20 pt-8">
        <h2 class="text-2xl font-bold text-center mb-6">Your Appointment Details</h2>
        <div class="glass-panel rounded-2xl p-6 space-y-4 max-w-md mx-auto">
            <div>
                <span class="font-semibold text-cyan-100">Service:</span>
                <span class="font-bold float-right"><?php echo e($booking->service->name); ?></span>
            </div>
            <div class="border-t border-white/20"></div>
            <div>
                <span class="font-semibold text-cyan-100">Therapist:</span>
                <span class="font-bold float-right"><?php echo e($booking->therapist->name); ?></span>
            </div>
            <div class="border-t border-white/20"></div>
            <div>
                <span class="font-semibold text-cyan-100">Date & Time:</span>
                <span class="font-bold float-right"><?php echo e($booking->start_time->format('M d, Y, h:i A')); ?></span>
            </div>
            <div class="border-t border-white/20"></div>
            <div>
                <span class="font-semibold text-cyan-100">Location:</span>
                <span class="font-bold float-right"><?php echo e($booking->branch->name); ?></span>
            </div>
            <div class="border-t border-white/20"></div>
            <div>
                <span class="font-semibold text-cyan-100">Total Price:</span>
                <span class="font-bold float-right text-xl">₱<?php echo e(number_format($booking->price, 2)); ?></span>
            </div>
        </div>
    </div>
    
    <div class="mt-12">
        <a href="<?php echo e(route('landing')); ?>" class="bg-white text-teal-600 font-bold py-3 px-10 rounded-full shadow-md hover:bg-cyan-100 transition-all transform hover:scale-105">
            ← Back to Homepage
        </a>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.Booking', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Vincen Basa\Desktop\renzman-booking-system\resources\views/booking/success.blade.php ENDPATH**/ ?>
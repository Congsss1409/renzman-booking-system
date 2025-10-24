<?php $__env->startSection('title', 'Step 1: Select Your Service'); ?>

<?php $__env->startSection('content'); ?>
<div class="glass-panel rounded-3xl max-w-6xl mx-auto overflow-hidden shadow-2xl">
    <div class="grid md:grid-cols-2">
        
        <!-- Left Column: Image & Branding -->
        <div class="hidden md:block relative">
            <img src="<?php echo e(asset('images/massage-hands.jpg')); ?>" class="absolute h-full w-full object-cover" alt="Massage hands on back">
            <div class="absolute inset-0 bg-teal-800/50"></div>
            <div class="relative z-10 p-12 text-white flex flex-col h-full">
                <div>
                    <h2 class="text-3xl font-bold">Start Your Journey</h2>
                    <p class="mt-2 text-cyan-100">A seamless booking experience for your path to relaxation and wellness.</p>
                </div>
                <div class="mt-auto text-cyan-200 text-sm">
                    <p>Select your preferred branch and service to begin.</p>
                </div>
            </div>
        </div>

        <!-- Right Column: Form -->
        <div class="p-8 md:p-12">
            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex justify-between items-center text-sm font-semibold text-black mb-2">
                    <span class="text-black">Step 1/5: Service</span>
                    <span class="text-black">20%</span>
                </div>
                <div class="w-full bg-emerald-200/60 rounded-full h-2.5">
                    <div class="bg-emerald-500 h-2.5 rounded-full transition-all duration-300" style="width: 20%"></div>
                </div>
            </div>

            <!-- Form Header -->
            <div class="text-left mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-black">Select Your Service</h1>
                <p class="mt-2 text-lg text-black">Choose from our range of professional treatments.</p>
            </div>

            <?php if($errors->any()): ?>
                <div class="mb-4 bg-red-500/30 border border-red-400 text-black px-4 py-3 rounded-lg relative" role="alert">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <!-- Form Content -->
            <form action="<?php echo e(route('booking.store.step-one')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="space-y-6">
                    <!-- Branch Selection -->
                    <div>
                        <label for="branch_id" class="block text-lg font-semibold mb-2 text-black">1. Choose a Branch</label>
                        <select name="branch_id" id="branch_id" required class="w-full p-4 bg-white/10 rounded-lg border border-white/30 focus:outline-none focus:ring-2 focus:ring-white appearance-none text-black">
                            <option value="" disabled selected class="text-black">Select a branch location</option>
                            <?php $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($branch->id); ?>" class="text-black">
                                    <?php echo e($branch->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>

                    <!-- Service Selection -->
                    <div>
                        <label for="service_id" class="block text-lg font-semibold mb-2 text-black">2. Choose a Service</label>
                        <select name="service_id" id="service_id" required class="w-full p-4 bg-white/10 rounded-lg border border-white/30 focus:outline-none focus:ring-2 focus:ring-white appearance-none text-black">
                            <option value="" disabled selected class="text-black">Select a service</option>
                            <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($service->id); ?>" class="text-black">
                                    <?php echo e($service->name); ?> (<?php echo e($service->duration); ?> mins) - ₱<?php echo e(number_format($service->price, 2)); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="mt-10 flex justify-end">
                    <button type="submit" class="bg-white text-teal-600 font-bold py-3 px-10 rounded-full shadow-md hover:bg-cyan-100 transition-all transform hover:scale-105">
                        Next Step &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.Booking', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views/booking/step-one.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title', 'Our Services'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* Custom styles for the Liquid Glass effect */
    .glass-panel {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .header-glass {
        background: rgba(0, 0, 0, 0.25);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .mobile-nav {
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    .animate-blob { animation: blob 7s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
    .animation-delay-4000 { animation-delay: 4s; }
    @keyframes blob {
	    0% { transform: translate(0px, 0px) scale(1); }
	    33% { transform: translate(30px, -50px) scale(1.1); }
	    66% { transform: translate(-20px, 20px) scale(0.9); }
	    100% { transform: translate(0px, 0px) scale(1); }
    }
</style>

<div class="relative min-h-screen w-full text-black overflow-x-hidden bg-cover bg-center bg-no-repeat" style="background-image: url('<?php echo e(asset('images/store4.jpg')); ?>');">
    
    <!-- Floating decorative blobs -->
    <div class="absolute top-0 -left-20 w-72 h-72 bg-teal-400 rounded-full mix-blend-soft-light filter blur-xl opacity-70 animate-blob"></div>
    <div class="absolute top-0 -right-20 w-72 h-72 bg-cyan-400 rounded-full mix-blend-soft-light filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-8 left-20 w-72 h-72 bg-emerald-400 rounded-full mix-blend-soft-light filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>

    <div class="relative z-10">
        <?php echo $__env->make('partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Main Content -->
                    <main class="container mx-auto px-3 sm:px-6 pt-24 pb-16">
            <div class="glass-panel rounded-3xl p-6 sm:p-8 md:p-12">
                <div class="text-center">
                                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold leading-tight">Our Signature Services</h1>
                                <p class="mt-3 text-sm sm:text-base text-black max-w-xl mx-auto">Discover the perfect treatment to rejuvenate your body and mind.</p>
                </div>

                <div class="mt-12 sm:mt-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    <?php $__empty_1 = true; $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="glass-panel rounded-2xl p-6 sm:p-8 text-center shadow-lg transform hover:-translate-y-2 transition-transform duration-300">
                            <img src="<?php echo e($service->image_url ?? 'https://placehold.co/400x250/FFFFFF/333333?text=' . urlencode($service->name)); ?>" alt="<?php echo e($service->name); ?>" class="w-full h-40 sm:h-48 object-cover rounded-lg mb-4">
                            <h3 class="text-xl sm:text-2xl font-bold"><?php echo e($service->name); ?></h3>
                            <p class="text-black mt-2 text-sm h-16"><?php echo e($service->description); ?></p>
                            <div class="my-4 sm:my-6"><span class="text-3xl sm:text-4xl font-bold">₱<?php echo e(number_format($service->price, 2)); ?></span><span class="text-black">/ <?php echo e($service->duration); ?> mins</span></div>
                            <a href="<?php echo e(route('booking.create.step-one')); ?>" class="mt-4 inline-block glass-btn font-semibold py-3 px-6 sm:px-8 rounded-full transition focus:outline-none focus:ring-2 focus:ring-emerald-400 focus:ring-offset-2">
                                Book This Service
                            </a>
</style>
<style>
    .glass-btn {
        background: rgba(255,255,255,0.18);
        color: #083344;
        border: 1.5px solid rgba(255,255,255,0.32);
        box-shadow: 0 8px 30px rgba(2,6,23,0.10), 0 1.5px 8px rgba(16,185,129,0.10);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        transition: background 0.18s, color 0.18s, box-shadow 0.18s;
    }
    .glass-btn:hover, .glass-btn:focus {
        background: rgba(255,255,255,0.32);
        color: #065f46;
        box-shadow: 0 12px 36px rgba(16,185,129,0.18), 0 2px 12px rgba(2,6,23,0.10);
        border-color: rgba(16,185,129,0.32);
    }
</style>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="col-span-full text-center">Services will be listed here soon.</p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="container mx-auto text-center pb-12 px-4 sm:px-6">
             <div class="glass-panel rounded-2xl p-6 sm:p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                    <div>
                        <h3 class="font-bold text-lg">About Renzman</h3>
                        <p class="text-sm text-black mt-2">Providing top-quality relaxation and wellness services to help you find your peace and rejuvenate your body.</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Quick Links</h3>
                        <ul class="mt-2 space-y-1 text-sm text-black">
                            <li><a href="<?php echo e(route('landing')); ?>#services" class="hover:text-black">Services</a></li>
                            <li><a href="<?php echo e(route('landing')); ?>#branches" class="hover:text-black">Branches</a></li>
                            <li><a href="<?php echo e(route('about')); ?>" class="hover:text-black">About Us</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold text-base sm:text-lg">Contact Us</h3>
                        <ul class="mt-2 space-y-1 text-xs sm:text-sm text-black">
                            <li>Email: renzman@renzman-massage.com</li>
                            <li>Phone: 0932-423-3517/0977-392-6564</li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-white/20 mt-8 pt-6 text-center text-sm text-black">
                   <p>&copy; <?php echo e(date('Y')); ?> Renzman. All rights reserved. <span class="mx-2">|</span> <a href="<?php echo e(url('/login')); ?>" class="hover:text-white underline">Admin Login</a></p>
                </div>
            </div>
            </footer>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views/services.blade.php ENDPATH**/ ?>
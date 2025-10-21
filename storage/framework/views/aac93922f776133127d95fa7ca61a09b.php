<?php $__env->startSection('title', 'Welcome to Renzman'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* Smooth scrolling for anchor navigation and overflow containers */
    html, body { scroll-behavior: smooth; }
    /* Main container for the full-page scroll effect */
    .scroll-container {
        scroll-snap-type: y mandatory;
        overflow-y: scroll;
        height: 100vh;
        scroll-behavior: smooth;
        -webkit-overflow-scrolling: touch; /* momentum scrolling on iOS */
    }
    /* Each section is a snap point */
    .scroll-section {
        scroll-snap-align: start;
        height: 100vh;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 5rem 1rem; /* Adjusted padding for mobile */
    }
    @media (min-width: 640px) {
        .scroll-section {
            padding: 6rem 1.5rem; /* Restore padding for larger screens */
        }
    }
    /* Bouncing animation for the scroll arrow */
    .bounce-animation {
        animation: bounce 2s infinite;
    }
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-20px); }
        60% { transform: translateY(-10px); }
    }
    /* Glassmorphism panel style */
    .glass-panel {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    /* Fixed header glass panel style */
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
</style>

<div class="scroll-container bg-gradient-to-br from-cyan-500 via-teal-500 to-emerald-600 text-white overflow-x-hidden">
    <!-- Header (fixed for all sections) -->
    <header x-data="{ open: false }" class="fixed top-0 left-0 right-0 z-50 p-2 sm:p-4">
        <div class="container mx-auto flex justify-between items-center header-glass rounded-full p-2 px-4 sm:px-6 shadow-lg">
            <a href="<?php echo e(route('landing')); ?>">
                
            <nav class="hidden md:flex items-center space-x-8 text-gray-200">
                <a href="#services" class="hover:text-white transition-colors">Services</a>
                <a href="#branches" class="hover:text-white transition-colors">Branches</a>
                <a href="#testimonials" class="hover:text-white transition-colors">Testimonials</a>
                <a href="<?php echo e(route('about')); ?>" class="hover:text-white transition-colors">About Us</a>
            </nav>
            <a href="<?php echo e(route('booking.create.step-one')); ?>" class="hidden sm:inline-block bg-white text-teal-600 font-bold py-2 px-6 text-sm sm:py-3 sm:px-8 sm:text-base rounded-full shadow-md hover:bg-cyan-100 transition-all transform hover:scale-105">
                Book Now
            </a>
            <div class="md:hidden">
                <button @click="open = !open" class="text-white focus:outline-none">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2" @click.away="open = false" class="md:hidden mt-3 mobile-nav rounded-2xl shadow-lg">
            <a href="#services" @click="open = false" class="block text-center py-3 px-4 text-white hover:bg-white/10 rounded-t-2xl">Services</a>
            <a href="#branches" @click="open = false" class="block text-center py-3 px-4 text-white hover:bg-white/10">Branches</a>
            <a href="#testimonials" @click="open = false" class="block text-center py-3 px-4 text-white hover:bg-white/10">Testimonials</a>
            <a href="<?php echo e(route('about')); ?>" @click="open = false" class="block text-center py-3 px-4 text-white hover:bg-white/10">About Us</a>
            <a href="<?php echo e(route('booking.create.step-one')); ?>" class="block text-center bg-white/20 hover:bg-white/30 text-white font-bold py-4 px-4 rounded-b-2xl">Book Now</a>
        </div>
    </header>

    <!-- Page 1: Hero Section -->
    <section class="scroll-section text-center" style="background-image: url('<?php echo e(asset('images/store1.jpg')); ?>'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 flex flex-col items-center px-4">
            <h1 class="text-3xl sm:text-4xl md:text-6xl font-bold leading-tight drop-shadow-lg">Be Relaxed.<br>Be Rejuvenated. Be Relieved.</h1>
            <p class="mt-4 text-base sm:text-lg md:text-xl max-w-2xl mx-auto text-gray-200 drop-shadow-md">
                Escape the everyday and discover a new level of peace and rejuvenation.
            </p>
            <a href="<?php echo e(route('booking.create.step-one')); ?>" class="mt-8 inline-block bg-white hover:bg-gray-200 text-teal-600 font-bold py-3 px-8 sm:py-4 sm:px-12 rounded-full shadow-xl transition-transform transform hover:scale-105 text-base sm:text-lg">
                Book an Appointment
            </a>
        </div>
        <div class="absolute bottom-8 sm:bottom-10 left-1/2 -translate-x-1/2 z-10">
            <a href="#services" class="flex flex-col items-center bounce-animation">
                <span class="text-sm">Scroll Down</span>
                <svg class="w-5 h-5 sm:w-6 sm:h-6 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </a>
        </div>
    </section>

    <!-- Page 2: Services Section -->
    <section id="services" class="scroll-section" style="background-image: url('<?php echo e(asset('images/store2.jpg')); ?>'); background-size: cover; background-position: center;">
        <div class="container mx-auto h-full flex flex-col justify-center">
            <div class="absolute inset-0 bg-black/40"></div>
            <div class="relative z-10 flex flex-col">
            <div class="text-center mb-4 sm:mb-8">
                <h2 class="text-3xl sm:text-4xl font-bold">Our Signature Services</h2>
                <p class="mt-2 text-cyan-100 px-4">Tailored treatments designed for your ultimate comfort.</p>
            </div>
            <div class="flex-1 overflow-y-auto py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                     <?php $__empty_1 = true; $__currentLoopData = $services->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="glass-panel rounded-2xl p-4 sm:p-6 text-center shadow-lg flex flex-col transform hover:-translate-y-2 transition-transform duration-300">
                            <img src="<?php echo e($service->image_url ?? 'https://placehold.co/400x500/FFFFFF/333333?text=' . urlencode($service->name)); ?>" alt="<?php echo e($service->name); ?>" class="w-full h-40 sm:h-48 object-cover rounded-lg mb-4">
                            <div class="flex-grow flex flex-col">
                                <h3 class="text-lg sm:text-xl font-bold"><?php echo e($service->name); ?></h3>
                                <p class="text-cyan-200 mt-2 text-xs sm:text-sm flex-grow"><?php echo e($service->description); ?></p>
                                <div class="my-4 sm:my-6">
                                    <span class="text-2xl sm:text-3xl font-bold">₱<?php echo e(number_format($service->price, 2)); ?></span>
                                    <span class="text-cyan-100 text-sm">/ <?php echo e($service->duration); ?> mins</span>
                                </div>
                                <a href="<?php echo e(route('booking.create.step-one')); ?>" class="mt-auto inline-block bg-white/20 hover:bg-white/30 font-semibold py-2 px-4 text-sm sm:py-3 sm:px-6 rounded-full transition border border-white/30">
                                    Book This Service
                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="col-span-full text-center">Our services will be listed here soon.</p>
                    <?php endif; ?>
                </div>
                 <?php if(count($services) > 3): ?>
                    <div class="text-center mt-8 sm:mt-12">
                        <a href="<?php echo e(route('services')); ?>" class="font-semibold bg-white/20 hover:bg-white/30 py-2 px-4 rounded-full">View All Services &rarr;</a>
                    </div>
                 <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Page 3: Our Branches Section -->
    <section id="branches" class="scroll-section" style="background-image: url('<?php echo e(asset('images/store3.jpg')); ?>'); background-size: cover; background-position: center;">
        <div class="container mx-auto h-full flex flex-col justify-center">
            <div class="absolute inset-0 bg-black/30"></div>
            <div class="relative z-10 flex flex-col">
            <div class="text-center mb-4 sm:mb-8">
                <h2 class="text-3xl sm:text-4xl font-bold">Visit Our Branches</h2>
                <p class="mt-2 text-cyan-100 px-4">Find a sanctuary near you.</p>
            </div>
            <div class="flex-1 overflow-y-auto py-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                    <?php $__empty_1 = true; $__currentLoopData = $branches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $branch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <a href="https://www.google.com/maps/search/?api=1&query=<?php echo e(urlencode($branch->name . ', ' . $branch->address)); ?>" target="_blank" rel="noopener noreferrer" class="block">
                            <div class="relative rounded overflow-hidden shadow-lg">
                                <img src="<?php echo e($branch->image_url ?? asset('images/branch-placeholder.svg')); ?>" alt="<?php echo e($branch->name); ?>" class="w-full h-64 object-cover">
                                <div class="absolute inset-0 bg-black opacity-25"></div>
                                <div class="absolute bottom-0 left-0 p-4 text-white">
                                    <h3 class="text-xl font-bold"><?php echo e($branch->name); ?></h3>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="col-span-full text-center">Our branches will be listed here soon.</p>
                    <?php endif; ?>
                </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Page 4: Testimonials & Footer Section -->
    <section id="testimonials" class="scroll-section" style="background-image: url('<?php echo e(asset('images/store4.jpg')); ?>'); background-size: cover; background-position: center;">
        <div class="container mx-auto h-full flex flex-col justify-center">
            <div class="absolute inset-0 bg-black/35"></div>
            <div class="relative z-10 flex flex-col">
             <?php if($feedbacks->isNotEmpty()): ?>
                <div class="text-center mb-4 sm:mb-8">
                    <h2 class="text-3xl sm:text-4xl font-bold">What Our Clients Say</h2>
                </div>
                <div class="flex-1 overflow-y-auto py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                        <?php $__currentLoopData = $feedbacks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feedback): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="glass-panel rounded-2xl p-6 sm:p-8 shadow-lg">
                                <div class="flex text-xl sm:text-2xl text-amber-300 mb-4"><?php for($i = 0; $i < 5; $i++): ?><span><?php echo e($i < $feedback->rating ? '★' : '☆'); ?></span><?php endfor; ?></div>
                                <p class="text-cyan-100 italic mb-6 text-sm sm:text-base">"<?php echo e($feedback->feedback); ?>"</p>
                                <div class="text-right">
                                    <p class="font-bold text-sm sm:text-base"><?php echo e($feedback->client_name); ?></p>
                                    <p class="text-xs sm:text-sm text-cyan-200">for <?php echo e($feedback->service->name ?? 'a service'); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Footer -->
            <footer class="w-full mt-auto pt-8 sm:pt-12">
                <div class="glass-panel rounded-2xl p-6 sm:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                        <div>
                            <h3 class="font-bold text-base sm:text-lg">About Renzman</h3>
                            <p class="text-xs sm:text-sm text-cyan-200 mt-2">Providing top-quality relaxation and wellness services to help you find your peace and rejuvenate your body.</p>
                        </div>
                        <div>
                            <h3 class="font-bold text-base sm:text-lg">Quick Links</h3>
                            <ul class="mt-2 space-y-1 text-xs sm:text-sm text-cyan-200">
                                <li><a href="#services" class="hover:text-white">Services</a></li>
                                <li><a href="#branches" class="hover:text-white">Branches</a></li>
                                <li><a href="<?php echo e(route('about')); ?>" class="hover:text-white">About Us</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="font-bold text-base sm:text-lg">Contact Us</h3>
                            <ul class="mt-2 space-y-1 text-xs sm:text-sm text-cyan-200">
                                <li>Email: contact@renzman.com</li>
                                <li>Phone: (02) 8123-4567</li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-t border-white/20 mt-6 sm:mt-8 pt-6 text-center text-xs sm:text-sm text-cyan-200">
                        <p>&copy; <?php echo e(date('Y')); ?> Renzman. All rights reserved.</p>
                    </div>
                </div>
            </footer>
        </div>
    </section>
</div>

<script>
// Smooth programmatic scroll for the scroll-container with controllable duration/easing
(function(){
    const container = document.querySelector('.scroll-container');
    if (!container) return;

    const DURATION = 700; // ms
    const easeInOutCubic = t => t < 0.5 ? 4 * t * t * t : 1 - Math.pow(-2 * t + 2, 3) / 2;

    function animateScrollTo(targetY, duration = DURATION) {
        const startY = container.scrollTop;
        const diff = targetY - startY;
        const startTime = performance.now();

        function step(now) {
            const elapsed = now - startTime;
            const t = Math.min(1, elapsed / duration);
            container.scrollTop = Math.round(startY + diff * easeInOutCubic(t));
            if (t < 1) requestAnimationFrame(step);
        }

        requestAnimationFrame(step);
    }

    // Intercept internal anchor clicks and animate the container instead of jumping
    document.addEventListener('click', function(e){
        const anchor = e.target.closest('a[href^="#"]');
        if (!anchor) return;
        const href = anchor.getAttribute('href');
        if (!href || href === '#') return;
        const id = href.slice(1);
        const target = document.getElementById(id);
        if (!target) return;

        // Only handle targets that are inside the scroll container
        if (!container.contains(target) && target !== container) return;

        e.preventDefault();

        // Compute target scrollTop relative to container
        const containerRect = container.getBoundingClientRect();
        const targetRect = target.getBoundingClientRect();
        const targetY = targetRect.top - containerRect.top + container.scrollTop;

        animateScrollTo(targetY, DURATION);

        // Update the URL hash without jumping
        try { history.replaceState(null, '', href); } catch (err) { /* ignore */ }

        // Focus target after animation completes for accessibility
        setTimeout(() => {
            target.setAttribute('tabindex', '-1');
            target.focus({ preventScroll: true });
        }, DURATION + 20);
    }, false);
})();
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\andre\Downloads\ccs\renzman-booking-system\resources\views/landing.blade.php ENDPATH**/ ?>
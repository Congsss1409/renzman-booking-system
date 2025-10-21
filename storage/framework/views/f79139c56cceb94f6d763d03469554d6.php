<?php $__env->startSection('title', 'About Us'); ?>

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

<div class="relative min-h-screen w-full bg-gradient-to-br from-cyan-500 via-teal-500 to-emerald-600 text-white overflow-x-hidden">
    
    <!-- Header Section -->
    <header x-data="{ open: false }" class="fixed top-0 left-0 right-0 z-50 p-2 sm:p-4">
        <div class="container mx-auto flex justify-between items-center header-glass rounded-full p-2 px-4 sm:px-6 shadow-lg">
            <a href="<?php echo e(route('landing')); ?>"><img src="<?php echo e(asset('images/logo_white.png')); ?>" alt="Renzman Logo" class="h-10 sm:h-12"></a>
            <nav class="hidden md:flex items-center space-x-8 text-gray-200">
                <a href="<?php echo e(route('landing')); ?>" class="hover:text-white transition-colors">Home</a>
                <a href="<?php echo e(route('services')); ?>" class="hover:text-white transition-colors">Services</a>
                <a href="<?php echo e(route('about')); ?>" class="font-bold text-white">About Us</a>
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
        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" @click.away="open = false" class="md:hidden mt-3 mobile-nav rounded-2xl shadow-lg">
            <a href="<?php echo e(route('landing')); ?>" @click="open = false" class="block text-center py-3 px-4 text-white hover:bg-white/10 rounded-t-2xl">Home</a>
            <a href="<?php echo e(route('services')); ?>" @click="open = false" class="block text-center py-3 px-4 text-white hover:bg-white/10">Services</a>
            <a href="<?php echo e(route('about')); ?>" @click="open = false" class="block text-center py-3 px-4 text-white bg-white/10 font-bold">About Us</a>
            <a href="<?php echo e(route('booking.create.step-one')); ?>" class="block text-center bg-white/20 hover:bg-white/30 text-white font-bold py-4 px-4 rounded-b-2xl">Book Now</a>
        </div>
    </header>

    <!-- Floating decorative blobs -->
    <div class="absolute top-0 -left-20 w-72 h-72 bg-teal-400 rounded-full mix-blend-soft-light filter blur-xl opacity-70 animate-blob"></div>
    <div class="absolute top-0 -right-20 w-72 h-72 bg-cyan-400 rounded-full mix-blend-soft-light filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-8 left-20 w-72 h-72 bg-emerald-400 rounded-full mix-blend-soft-light filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>

    <div class="relative z-10">
        <!-- Main Content -->
        <main class="container mx-auto px-4 sm:px-6 pt-28 pb-16">
            <div class="glass-panel rounded-3xl p-6 sm:p-8 md:p-12">
                <div class="text-center max-w-4xl mx-auto">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold">About Renzman</h1>
                    <p class="mt-4 text-base sm:text-lg text-cyan-100">Your trusted partner in relaxation and wellness since our inception.</p>
                </div>

                <div class="mt-12 sm:mt-16 grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
                    <div>
                        <img src="<?php echo e(asset('images/store.jpg')); ?>" alt="A relaxing spa environment" class="rounded-2xl shadow-xl">
                    </div>
                    <div class="glass-panel rounded-2xl p-6 sm:p-8">
                        <h2 class="text-2xl sm:text-3xl font-bold">Our Mission</h2>
                        <p class="mt-4 text-cyan-100 text-sm sm:text-base">
                            At Renzman, our mission is to provide an accessible escape from the stresses of daily life. We believe in the power of touch and the importance of self-care. Our team of expert therapists is dedicated to delivering personalized treatments that not only soothe tired muscles but also restore balance to your mind and spirit.
                        </p>
                        <h2 class="text-2xl sm:text-3xl font-bold mt-6 sm:mt-8">Our Story</h2>
                        <p class="mt-4 text-cyan-100 text-sm sm:text-base">
                            Founded on the principles of quality, care, and community, Renzman started as a small, local massage parlor with a big dream: to make professional wellness services available to everyone. We've grown into a well-loved establishment with multiple branches, yet we've never lost the personal touch that defines us.
                        </p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="container mx-auto text-center pb-12 px-4 sm:px-6">
            <div class="glass-panel rounded-2xl p-6 sm:p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                    <div>
                        <h3 class="font-bold text-lg">About Renzman</h3>
                        <p class="text-sm text-cyan-200 mt-2">Providing top-quality relaxation and wellness services to help you find your peace and rejuvenate your body.</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Quick Links</h3>
                        <ul class="mt-2 space-y-1 text-sm text-cyan-200">
                           <li><a href="<?php echo e(route('landing')); ?>#services" class="hover:text-white">Services</a></li>
                           <li><a href="<?php echo e(route('landing')); ?>#branches" class="hover:text-white">Branches</a></li>
                           <li><a href="<?php echo e(route('about')); ?>" class="hover:text-white">About Us</a></li>
                        </ul>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Contact Us</h3>
                        <ul class="mt-2 space-y-1 text-sm text-cyan-200">
                            <li>Email: contact@renzman.com</li>
                            <li>Phone: (02) 8123-4567</li>
                        </ul>
                    </div>
                </div>
                <div class="border-t border-white/20 mt-8 pt-6 text-center text-sm text-cyan-200">
                    <p>&copy; <?php echo e(date('Y')); ?> Renzman. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\andre\Downloads\ccs\renzman-booking-system\resources\views/about.blade.php ENDPATH**/ ?>
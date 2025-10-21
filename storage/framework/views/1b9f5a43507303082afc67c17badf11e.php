<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Book Your Session'); ?> - Renzman</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            overflow-x: hidden;
        }
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
</head>
<body class="bg-gray-50">

<div class="relative min-h-screen w-full bg-gradient-to-br from-cyan-500 via-teal-500 to-emerald-600 text-white">
    
    <div class="absolute top-0 -left-20 w-72 h-72 bg-teal-400 rounded-full mix-blend-soft-light filter blur-xl opacity-70 animate-blob"></div>
    <div class="absolute top-0 -right-20 w-72 h-72 bg-cyan-400 rounded-full mix-blend-soft-light filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-8 left-20 w-72 h-72 bg-emerald-400 rounded-full mix-blend-soft-light filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>

    <div class="relative z-10">
        <header class="p-4 sticky top-0 z-50">
            <div class="container mx-auto flex justify-between items-center header-glass rounded-full p-2 px-6 shadow-lg">
                <a href="<?php echo e(route('landing')); ?>"><img src="<?php echo e(asset('images/logo_white.png')); ?>" alt="Renzman Logo" class="h-16"></a>
                <nav class="hidden md:flex items-center space-x-8 text-gray-200">
                    <a href="<?php echo e(route('landing')); ?>" class="hover:text-white transition-colors">Home</a>
                    <a href="<?php echo e(route('services')); ?>" class="hover:text-white transition-colors">Services</a>
                    <a href="<?php echo e(route('about')); ?>" class="hover:text-white transition-colors">About Us</a>
                </nav>
                 <a href="<?php echo e(route('landing')); ?>" class="bg-white text-teal-600 font-bold py-3 px-8 rounded-full shadow-md hover:bg-cyan-100 transition-all transform hover:scale-105">
                    Cancel Booking
                </a>
            </div>
        </header>

        <main class="container mx-auto px-6 py-16">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>
</div>

<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\Vincen Basa\Desktop\renzman-booking-system\resources\views/layouts/Booking.blade.php ENDPATH**/ ?>
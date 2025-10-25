<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Renzman Booking'); ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?php echo e(asset('favicon.png')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('favicon.png')); ?>">
    <link rel="apple-touch-icon" href="<?php echo e(asset('favicon.png')); ?>">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <!-- SweetAlert2 -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Poppins Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        /* Prevent iOS Safari from auto-resizing text and improve font smoothing */
        html { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        body { font-family: 'Poppins', sans-serif; -webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale; }
        [x-cloak] { display: none !important; }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="bg-gray-50">

    <?php echo $__env->yieldContent('content'); ?>

    
</body>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Desktop\renzman-booking-system\resources\views/layouts/app.blade.php ENDPATH**/ ?>
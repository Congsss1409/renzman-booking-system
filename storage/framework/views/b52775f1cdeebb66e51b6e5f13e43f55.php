<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Renzman Booking System</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Poppins Font from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Custom Style to apply Poppins Font -->
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-50 via-slate-100 to-gray-200">

    <div class="min-h-screen flex items-center justify-center p-6">
        <div class="w-full max-w-4xl flex rounded-2xl overflow-hidden relative">

            <!-- Background glow / decorative (admin palette) -->
            <div aria-hidden="true" class="absolute inset-0 bg-gradient-to-br from-teal-400 to-cyan-600 opacity-30 blur-3xl"></div>

            <!-- Glass Card -->
            <div class="relative z-10 w-full flex rounded-2xl shadow-2xl overflow-hidden">

                <!-- Left Panel: Image and Welcome Text -->
                <div class="hidden md:flex flex-col justify-center items-center w-1/2 p-12 text-center bg-gradient-to-br from-teal-500 to-cyan-600">
                    <div class="inline-flex items-center justify-center p-2 bg-white/10 rounded-full shadow-2xl border border-white/30">
                        <img src="<?php echo e(asset('images/logo_white.png')); ?>" alt="Renzman Logo" class="w-44 h-44 rounded-full">
                    </div>
                    <h1 class="text-4xl font-bold leading-tight mt-4 text-white/95">Renzman Booking</h1>
                    <p class="text-white/80 mt-2">Management System</p>
                </div>

                <!-- Right Panel: Login Form (Glass - higher contrast) -->
                <div class="w-full md:w-1/2 p-8 sm:p-12 bg-white/60 backdrop-blur-md border border-white/30 text-gray-900">
                    <div class="max-w-md">
                        <h2 class="text-3xl font-bold text-gray-900">Login</h2>
                        <p class="text-gray-700 mt-2 mb-6">Enter your credentials to access the admin panel.</p>

                        <!-- Login Form -->
                        <form action="<?php echo e(route('login.store')); ?>" method="POST" class="space-y-6">
                            <?php echo csrf_field(); ?>

                            <!-- Email Input -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                <input type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus 
                            class="w-full p-3 bg-white border border-gray-200 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-300 shadow-sm focus:shadow-md transition-shadow duration-150">
                            </div>

                            <!-- Password Input -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                                <input type="password" id="password" name="password" required autocomplete="current-password"
                                       class="w-full p-3 bg-white border border-gray-200 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-300 shadow-sm focus:shadow-md transition-shadow duration-150">
                            </div>

                            <!-- Display Login Errors -->
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-3 text-sm rounded-md" role="alert">
                                    <span><?php echo e($message); ?></span>
                                </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center bg-gradient-to-r from-teal-500 to-cyan-600 hover:from-teal-600 hover:to-cyan-700 text-white font-semibold p-3 rounded-lg transition-all duration-200 shadow-sm">
                                LOGIN
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

<?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views/auth/login.blade.php ENDPATH**/ ?>
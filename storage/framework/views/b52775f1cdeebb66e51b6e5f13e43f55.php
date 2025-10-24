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
                                <div class="relative">
                                    <input type="password" id="password" name="password" required autocomplete="current-password"
                                           class="w-full p-3 bg-white border border-gray-200 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-cyan-300 shadow-sm focus:shadow-md transition-shadow duration-150 pr-12">
                                    <button type="button" id="togglePassword" tabindex="-1" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 focus:outline-none" aria-label="Show or hide password">
                                        <!-- Eye (show) icon -->
                                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16" class="block"><path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8z"/><path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zm0 1a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3z"/></svg>
                                        <!-- Eye-slash (hide) icon -->
                                        <svg id="eyeSlashIcon" xmlns="http://www.w3.org/2000/svg" width="22" height="22" fill="currentColor" viewBox="0 0 16 16" class="hidden"><path d="M13.359 11.238C14.06 10.47 14.682 9.607 15.197 8.8a.5.5 0 0 0 0-.6s-3-5.5-8-5.5c-1.357 0-2.591.314-3.68.832l1.46 1.46C5.12 4.668 6.88 3.5 9 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755-.24.24-.49.47-.75.695zM2.354 1.646a.5.5 0 1 0-.708.708l1.06 1.06C1.94 4.02 1.173 5.13 1.173 8c0 .87.767 1.98 1.533 2.586l-1.06 1.06a.5.5 0 1 0 .708.708l12-12zM8 5.5a2.5 2.5 0 0 0-2.45 2.01l1.06 1.06A1.5 1.5 0 0 1 8 6.5a1.5 1.5 0 0 1 1.39.94l1.06 1.06A2.5 2.5 0 0 0 8 5.5zm0 6c-2.12 0-3.879-1.168-5.168-2.457A13.133 13.133 0 0 1 1.172 8c.058-.087.122-.183.195-.288.335-.48.83-1.12 1.465-1.755C4.121 4.668 5.88 3.5 8 3.5c.29 0 .574.02.853.057l1.634 1.634A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.12 12.5 8 12.5z"/></svg>
                                    </button>
                                </div>
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
<script>
    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('togglePassword');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeSlashIcon = document.getElementById('eyeSlashIcon');
    if (togglePassword) {
        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            eyeIcon.classList.toggle('hidden', !isPassword);
            eyeSlashIcon.classList.toggle('hidden', isPassword);
        });
    }
</script>
</html>

<?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views/auth/login.blade.php ENDPATH**/ ?>
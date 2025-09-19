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
<body class="bg-gradient-to-br from-gray-100 to-gray-200">

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-4xl flex rounded-2xl shadow-2xl overflow-hidden bg-white">
            
            <!-- Left Panel: Image and Welcome Text -->
            <div class="hidden md:flex flex-col justify-center items-center w-1/2 p-12 text-center bg-gradient-to-br from-teal-500 to-cyan-600">
                <img src="{{ asset('images/logo_white.png') }}" alt="Renzman Logo" class="w-48 h-48">
                <h1 class="text-4xl font-bold leading-tight mt-4 text-white">Renzman Booking</h1>
                <p class="text-teal-100 mt-2">Management System</p>
            </div>
            
            <!-- Right Panel: Login Form -->
            <div class="w-full md:w-1/2 p-8 sm:p-12">
                <h2 class="text-3xl font-bold text-gray-800">Login</h2>
                <p class="text-gray-500 mt-2 mb-8">Enter your credentials to access the admin panel.</p>
                
                <!-- Login Form -->
                <form action="{{ route('login.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Email Input -->
                    <div>
                        <label for="email" class="block text-gray-600 font-semibold mb-2">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus 
                               class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    </div>
                    
                    <!-- Password Input -->
                    <div>
                        <label for="password" class="block text-gray-600 font-semibold mb-2">Password</label>
                        <input type="password" id="password" name="password" required autocomplete="current-password"
                               class="w-full p-3 bg-gray-50 border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500">
                    </div>
                    
                    <!-- Display Login Errors -->
                    @error('email')
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 text-sm rounded-md" role="alert">
                            <span>{{ $message }}</span>
                        </div>
                    @enderror

                    <!-- Submit Button -->
                    <button type="submit" 
                            class="w-full bg-gradient-to-r from-teal-500 to-cyan-600 text-white font-bold p-3 rounded-lg hover:from-teal-600 hover:to-cyan-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                        LOGIN
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>


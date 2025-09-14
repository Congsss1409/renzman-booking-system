<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Renzman') - Spa & Massage Booking</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|playfair-display:700,800,900&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="font-sans antialiased bg-white text-gray-800">
    
    <div x-data="{ sidebarOpen: false, scrolled: false }" @scroll.window="scrolled = (window.scrollY > 50)">
        <!-- Header/Navigation -->
        <header :class="{'bg-white shadow-md text-gray-800': scrolled, 'bg-transparent text-white': !scrolled}" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    <!-- Logo -->
                    <a href="{{ route('landing') }}" class="flex-shrink-0">
                        <img class="h-10 w-auto" src="{{ asset('images/logo trans.png') }}" alt="Renzman Logo">
                    </a>
                    
                    <!-- Desktop Navigation Links -->
                    <nav class="hidden md:flex items-center space-x-8">
                        <a href="{{ route('landing') }}" class="text-sm font-medium hover:text-indigo-600 transition-colors">Home</a>
                        <a href="{{ route('about') }}" class="text-sm font-medium hover:text-indigo-600 transition-colors">About</a>
                        <a href="{{ route('services') }}" class="text-sm font-medium hover:text-indigo-600 transition-colors">Services</a>
                    </nav>
                    
                    <!-- Desktop Action Button -->
                    <div class="hidden md:block">
                        <a href="{{ route('login') }}" class="inline-block px-5 py-2 text-sm font-semibold text-center text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition-colors">
                            Admin Login
                        </a>
                    </div>

                    <!-- Mobile menu button -->
                    <div class="md:hidden">
                        <button @click="sidebarOpen = true" class="p-2 rounded-md focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Mobile Sidebar -->
        <div x-show="sidebarOpen" x-cloak 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-black bg-opacity-50" @click="sidebarOpen = false">
        </div>
        <aside x-show="sidebarOpen" x-cloak
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="fixed top-0 left-0 h-full w-64 bg-white z-50 p-6">
            <nav class="flex flex-col space-y-4">
                <a href="{{ route('landing') }}" class="text-gray-700 font-medium hover:text-indigo-600">Home</a>
                <a href="{{ route('about') }}" class="text-gray-700 font-medium hover:text-indigo-600">About</a>
                <a href="{{ route('services') }}" class="text-gray-700 font-medium hover:text-indigo-600">Services</a>
                 <hr>
                <a href="{{ route('login') }}" class="inline-block px-5 py-2 text-sm font-semibold text-center text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                    Admin Login
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white">
            <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8 text-center">
                <p>&copy; {{ date('Y') }} Renzman Booking System. All Rights Reserved.</p>
                <p class="text-sm text-gray-400 mt-2">Your journey to relaxation starts here.</p>
            </div>
        </footer>
    </div>
</body>
</html>

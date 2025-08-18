{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Renzman Blind Massage Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-20">
            <a href="{{ route('landing') }}">
                <img src="{{ asset('images/new.png') }}" alt="Renzman Logo" class="h-16">
            </a>
            <nav class="hidden md:flex space-x-8 items-center">
                <a href="{{ route('landing') }}" class="font-medium transition-colors {{ request()->routeIs('landing') ? 'text-emerald-600' : 'text-gray-600 hover:text-emerald-700' }}">Home</a>
                <a href="{{ route('about') }}" class="font-medium transition-colors {{ request()->routeIs('about') ? 'text-emerald-600' : 'text-gray-600 hover:text-emerald-700' }}">About</a>
                <a href="{{ route('services') }}" class="font-medium transition-colors {{ request()->routeIs('services') ? 'text-emerald-600' : 'text-gray-600 hover:text-emerald-700' }}">Services</a>
                <a href="{{ route('booking.create.step-one') }}" class="bg-emerald-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
                    Book Now
                </a>
            </nav>
            <div class="md:hidden">
                <button class="text-gray-600 hover:text-emerald-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} Renzman Blind Massage Therapy. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
      AOS.init({
        duration: 800, // Animation duration in milliseconds
        once: true,    // Whether animation should happen only once - while scrolling down
      });
    </script>

    @if (session('feedback_success'))
        <script>
            Swal.fire({
                title: 'Thank You!',
                text: '{{ session('feedback_success') }}',
                icon: 'success',
                confirmButtonText: 'Great!',
                confirmButtonColor: '#10B981'
            })
        </script>
    @endif
</body>
</html>

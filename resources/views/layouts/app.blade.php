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

    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-20">
            {{-- Logo --}}
            <a href="{{ route('landing') }}">
                <img src="{{ asset('images/logo trans.png') }}" alt="Renzman Logo" class="h-16">
            </a>
            
            {{-- Desktop Navigation --}}
            <nav class="hidden md:flex space-x-8 items-center">
                <a href="{{ route('landing') }}" class="text-gray-600 hover:text-emerald-700 font-medium transition-colors">Home</a>
                <a href="#" class="text-gray-600 hover:text-emerald-700 font-medium transition-colors">About</a>
                <a href="#" class="text-gray-600 hover:text-emerald-700 font-medium transition-colors">Services</a>
                <a href="{{ route('booking.create.step-one') }}" class="bg-emerald-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
                    Book Now
                </a>
            </nav>

            {{-- Mobile Menu Button (functionality can be added later) --}}
            <div class="md:hidden">
                <button class="text-gray-600 hover:text-emerald-700 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>
    </header>

    {{-- Main content area (no padding, allows for full-width views) --}}
    <main>
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
        
        @yield('content')
    </main>

    <footer class="bg-gray-800 text-white">
        <div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8 text-center">
            <p>&copy; {{ date('Y') }} Renzman Blind Massage Therapy. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>

{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Renzman Blind Massage Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- NEW: Add SweetAlert2 library -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    <header class="bg-white shadow-sm">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <a href="/">
                <img src="{{ asset('images/logo trans.png') }}" alt="Renzman Logo" class="h-12">
            </a>
            <nav class="hidden md:flex space-x-6 items-center">
                <a href="/" class="text-gray-600 hover:text-emerald-700">Home</a>
                <a href="#" class="text-gray-600 hover:text-emerald-700">About</a>
                <a href="#" class="text-gray-600 hover:text-emerald-700">Services</a>
                <a href="/booking/step-one" class="bg-emerald-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-emerald-700 transition-colors">Book Now</a>
            </nav>
        </div>
    </header>

    <main class="py-8">
        @yield('content')
    </main>

    <footer class="text-center p-4 mt-8 text-gray-500 text-sm">
        <p>&copy; {{ date('Y') }} Renzman Blind Massage Therapy. All rights reserved.</p>
    </footer>

    {{-- NEW: Script to show the success alert --}}
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

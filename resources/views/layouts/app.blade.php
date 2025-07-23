{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Renzman Blind Massage Booking</title>

    <!-- We are loading Tailwind CSS directly from the CDN. -->
    <!-- This completely bypasses the local build process (Vite/NPM). -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- We will also add our custom font. -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* A simple style block to apply our custom font */
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="antialiased bg-gray-50 text-gray-800">

    <header class="bg-white shadow-sm">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <a href="/">
                <!-- Make sure your logo is in the public/images folder -->
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
        {{-- Content from other pages will be injected here --}}
        @yield('content')
    </main>

    <footer class="text-center p-4 mt-8 text-gray-500 text-sm">
        <p>&copy; {{ date('Y') }} Renzman Blind Massage Therapy. All rights reserved.</p>
    </footer>

</body>
</html>

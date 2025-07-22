<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RENZMAN BLIND MASSAGE')</title>

    @vite('resources/css/app.css')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        /* Define custom colors and fonts based on the new design */
        :root {
            --brand-bg: #F5F4EC; /* Creamy-yellow background */
            --brand-dark: #3D403A; /* Dark olive/charcoal text and footer */
            --brand-green: #6A7B62; /* Muted green for buttons and accents */
            --font-serif: 'Lora', serif;
            --font-sans: 'Inter', sans-serif;
        }
        body { 
            font-family: var(--font-sans);
            background-color: var(--brand-bg);
            color: var(--brand-dark);
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-serif);
        }
        .btn-primary {
            background-color: var(--brand-green);
            color: white;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #556650;
        }
    </style>
</head>
<body class="antialiased">

    <!-- Header & Navigation -->
    <header class="bg-white/80 backdrop-blur-lg sticky top-0 z-50">
        <nav class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="{{ route('landing') }}">
                {{-- IMPORTANT: Place your "logo trans.png" file in the `public/images` folder --}}
                <img src="{{ asset('images/logo trans.png') }}" alt="Renzman Blind Massage Logo" class="h-20 w-40">
            </a>
            <!-- Navigation Links -->
            <ul class="hidden md:flex items-center space-x-5 font-medium tracking-wider text-sm uppercase">
                <li><a href="#" class="hover:text-[var(--brand-green)]">Home</a></li>
                <li><a href="#" class="hover:text-[var(--brand-green)]">About</a></li>
                <li><a href="#" class="hover:text-[var(--brand-green)]">Branches</a></li>
                <li><a href="#" class="hover:text-[var(--brand-green)]">Services</a></li>
                <li><a href="{{ route('booking.stepOne') }}" class="btn-primary px-5 py-2 rounded-full">Book Now</a></li>
            </ul>
            <!-- Mobile Menu Button (optional) -->
            <div class="md:hidden">
                <a href="{{ route('booking.stepOne') }}" class="btn-primary px-5 py-2 rounded-full text-sm">Book Now</a>
            </div>
        </nav>
    </header>

    <main>
        {{-- Page-specific content will be injected here --}}
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-[var(--brand-dark)] text-white">
        <div class="container mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- About -->
            <div>
                <h4 class="font-bold text-lg mb-4">About Renzman</h4>
                <p class="text-gray-300 text-sm">Providing therapeutic massage by certified blind therapists to enhance your well-being.</p>
            </div>
            <!-- Branches -->
            <div>
                <h4 class="font-bold text-lg mb-4">Our Branches</h4>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><a href="#" class="hover:underline">Metro Plaza Malaria</a></li>
                    <li><a href="#" class="hover:underline">Metro Plaza Bagong Silang</a></li>
                    <li><a href="#" class="hover:underline">Zabarte Town Center</a></li>
                    <li><a href="#" class="hover:underline">Metro Plaza Gen Luis</a></li>
                </ul>
            </div>
            <!-- Quick Links -->
            <div>
                <h4 class="font-bold text-lg mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm text-gray-300">
                    <li><a href="#" class="hover:underline">Our Story</a></li>
                    <li><a href="#" class="hover:underline">Services</a></li>
                    <li><a href="{{ route('booking.stepOne') }}" class="hover:underline">Book an Appointment</a></li>
                </ul>
            </div>
            <!-- Social -->
            <div>
                <h4 class="font-bold text-lg mb-4">Follow Us</h4>
                <div class="flex space-x-4">
                    {{-- Placeholder SVG for social icons --}}
                    <a href="#" class="text-gray-300 hover:text-white"><svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.323-1.325z"/></svg></a>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 py-6">
            <p class="text-center text-sm text-gray-400">&copy; {{ date('Y') }} RENZMAN BLIND MASSAGE. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'RENZMAN BLIND MASSAGE') - Booking</title>

    @vite('resources/css/app.css')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:wght@400;700&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --brand-bg: #F5F4EC;
            --brand-dark: #3D403A;
            --brand-green: #6A7B62;
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

    <div class="container mx-auto px-4 md:px-8 py-8 max-w-2xl">
        <header class="text-center mb-8">
            <a href="{{ route('landing') }}">
                {{-- Logo size increased from h-16 to h-20 --}}
                <img src="{{ asset('images/logo trans.png') }}" alt="Renzman Blind Massage Logo" class="h-20">
            </a>
            <h1 class="text-3xl font-bold text-[var(--brand-dark)] mt-4">Book Your Appointment</h1>
        </header>

        <main class="bg-white p-6 md:p-10 rounded-lg shadow-lg">
            @yield('content')
        </main>

        <footer class="text-center mt-8 text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} RENZMAN BLIND MASSAGE. All Rights Reserved.</p>
        </footer>
    </div>

</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Book an Appointment - Renzman</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Simple transition for a smoother feel */
        .transition-all {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        
        <a href="{{ route('landing') }}" class="mb-8">
            <img class="h-12 w-auto" src="{{ asset('images/logo trans.png') }}" alt="Renzman Logo">
        </a>

        <div class="w-full max-w-4xl">
            <!-- Progress Bar -->
            @php
                $steps = [
                    1 => 'Service',
                    2 => 'Therapist',
                    3 => 'Date & Time',
                    4 => 'Details',
                    5 => 'Confirm'
                ];
            @endphp
            <div class="mb-8 px-4">
                <div class="flex items-center">
                    @foreach ($steps as $step => $title)
                        <div class="flex items-center {{ $step <= $currentStep ? 'text-indigo-600' : 'text-gray-400' }} relative">
                            <div class="rounded-full transition-all duration-500 flex items-center justify-center h-10 w-10 border-2 {{ $step <= $currentStep ? 'bg-indigo-600 border-indigo-600 text-white' : 'border-gray-300 bg-white' }}">
                                @if ($step < $currentStep)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                @else
                                    <span>{{ $step }}</span>
                                @endif
                            </div>
                            <div class="absolute top-0 -ml-10 text-center mt-12 w-32 text-xs font-medium uppercase {{ $step <= $currentStep ? 'text-gray-800' : 'text-gray-400' }}">{{ $title }}</div>
                        </div>
                        @if (!$loop->last)
                            <div class="flex-auto border-t-2 transition-all duration-500 {{ $step < $currentStep ? 'border-indigo-600' : 'border-gray-300' }}"></div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Card Content -->
            <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-10">
                @yield('content')
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('landing') }}" class="text-sm text-gray-500 hover:text-indigo-600">Cancel and return to homepage</a>
            </div>
        </div>
    </div>
</body>
</html>

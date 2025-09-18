<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Book an Appointment - Renzman</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 text-gray-800">
    <div class="h-screen w-full bg-white grid grid-cols-1 md:grid-cols-12">
        
        <div class="md:col-span-4 bg-indigo-700 text-white p-8 flex flex-col">
            <a href="{{ route('landing') }}" class="mb-10 block flex-shrink-0">
                <img class="h-10 w-auto" src="{{ asset('images/logo trans.png') }}" alt="Renzman Logo">
            </a>
            
            @php
                $steps = [
                    1 => ['title' => 'Service', 'description' => 'Select a branch and the service you would like to book.'],
                    2 => ['title' => 'Therapist', 'description' => 'Choose from our available professional therapists.'],
                    3 => ['title' => 'Date & Time', 'description' => 'Pick a convenient date and time for your appointment.'],
                    4 => ['title' => 'Your Details', 'description' => 'Please provide your contact information.'],
                    5 => ['title' => 'Confirm & Pay', 'description' => 'Review your booking details and confirm your appointment.']
                ];
            @endphp
            <nav class="space-y-4">
                @foreach ($steps as $step => $details)
                <div class="flex items-start">
                    <div class="flex flex-col items-center mr-4">
                        <div class="flex items-center justify-center w-8 h-8 rounded-full border-2 {{ $step <= $currentStep ? 'bg-white border-white text-indigo-700' : 'border-indigo-400 text-indigo-300' }} transition-all duration-300 flex-shrink-0">
                            @if ($step < $currentStep)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                <span class="font-bold">{{ $step }}</span>
                            @endif
                        </div>
                        @if (!$loop->last)
                            <div class="w-px h-12 bg-indigo-400 mt-2"></div>
                        @endif
                    </div>
                    <div>
                        <p class="font-semibold {{ $step <= $currentStep ? 'text-white' : 'text-indigo-300' }} transition-all duration-300">{{ $details['title'] }}</p>
                        @if ($step == $currentStep)
                            <p class="text-sm text-indigo-200 mt-1">{{ $details['description'] }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </nav>
        </div>

        <div class="md:col-span-8 p-8 flex flex-col">
            <div class="flex-grow overflow-y-auto">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>

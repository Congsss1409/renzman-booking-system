{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- Add CSRF Token for secure JS requests --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Dashboard - Renzman Booking</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Inter', sans-serif; } 
        /* Style for the new row highlight */
        .new-booking-row {
            animation: fadeInAndHighlight 2s ease-out;
        }
        @keyframes fadeInAndHighlight {
            0% { background-color: #a7f3d0; opacity: 0; }
            50% { background-color: #a7f3d0; opacity: 1; }
            100% { background-color: transparent; opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-800 text-white flex flex-col">
            <div class="p-6 text-2xl font-bold border-b border-gray-700">
                Renzman Admin
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-700 !text-white' : '' }}">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.feedback') }}" class="flex items-center px-4 py-2 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.feedback') ? 'bg-emerald-700 !text-white' : '' }}">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" /></svg>
                    Feedback
                </a>
                <a href="{{ route('admin.analytics') }}" class="flex items-center px-4 py-2 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('admin.analytics') ? 'bg-emerald-700 !text-white' : '' }}">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    Analytics
                </a>
            </nav>
            <!-- Logout Button -->
            <div class="p-4 border-t border-gray-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2 rounded-lg text-gray-300 hover:bg-gray-700 hover:text-white">
                        <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-md p-4 flex justify-between items-center">
                <h1 class="text-xl font-semibold">@yield('header')</h1>
                <div class="text-sm text-gray-600">
                    Welcome, <span class="font-semibold">{{ Auth::user()->name }}</span>
                </div>
            </header>
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                @if (session('success'))
                    <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 mb-4" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    {{-- Load Laravel Echo and Pusher JS --}}
    @vite('resources/js/app.js')
    
    {{-- This script will only run if the user is logged in --}}
    @auth
    <script>
        // Listen for new bookings on the private 'admin' channel
        window.Echo.private('admin')
            .listen('BookingCreated', (e) => {
                console.log('New booking received:', e.booking);
                
                // Call a function to add the new booking to the table
                // This function must be defined in the specific view (dashboard.blade.php)
                if (typeof addNewBookingRow === 'function') {
                    addNewBookingRow(e.booking);
                }
            });
    </script>
    @endauth
</body>
</html>

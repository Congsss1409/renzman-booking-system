<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel') - {{ config('app.name', 'Laravel') }}</title>

    <!-- Tailwind CSS & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- SweetAlert2 CSS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- HoldOn.js CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/holdon.js/dist/HoldOn.min.css">

    <!-- Alpine.js -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body { font-family: 'Poppins', sans-serif; }
        [x-cloak] { display: none !important; }
        .sidebar-link.active { background-color: #0d9488; color: white; }
        .sidebar-link.active svg { color: white; }
    </style>
</head>
<body class="bg-gray-100">

    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">
        <!-- Floating hamburger (shows when sidebar is closed on mobile) -->
        <button x-cloak x-show="!sidebarOpen" @click="sidebarOpen = true" class="lg:hidden fixed top-4 left-4 z-50 bg-white text-teal-700 p-2 rounded-full shadow-md focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>

        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 w-64 flex-shrink-0 bg-gradient-to-b from-teal-600 to-cyan-700 text-teal-100 flex flex-col transform transition-transform duration-300 ease-in-out z-30 lg:relative lg:translate-x-0">
            <div class="h-20 flex items-center justify-center text-2xl font-bold text-white">
                <img src="{{ asset('images/logo_white.png') }}" alt="Logo" class="h-16 w-auto">
            </div>
            <!-- Mobile close button inside sidebar -->
            <button @click="sidebarOpen = false" class="lg:hidden absolute top-4 right-4 text-white p-2 rounded-md hover:bg-white/10 focus:outline-none" aria-label="Close sidebar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <nav class="flex-grow px-4">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-lg transition-colors hover:bg-teal-700 @if(request()->routeIs('admin.dashboard')) active @endif">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.therapists.index') }}" class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-lg transition-colors hover:bg-teal-700 @if(request()->routeIs('admin.therapists.*')) active @endif">
                     <svg class="w-6 h-6 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    <span>Therapists</span>
                </a>
                <a href="{{ route('admin.services.index') }}" class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-lg transition-colors hover:bg-teal-700 @if(request()->routeIs('admin.services.*')) active @endif">
                    <svg class="w-6 h-6 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <span>Services</span>
                </a>
                <a href="{{ route('admin.payrolls.index') }}" class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-lg transition-colors hover:bg-teal-700 @if(request()->routeIs('admin.payrolls.*')) active @endif">
                    <svg class="w-6 h-6 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6M9 17H7a2 2 0 01-2-2v-5a2 2 0 012-2h10a2 2 0 012 2v5a2 2 0 01-2 2h-2"></path></svg>
                    <span>Payrolls</span>
                </a>
                <a href="{{ route('admin.feedback') }}" class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-lg transition-colors hover:bg-teal-700 @if(request()->routeIs('admin.feedback')) active @endif">
                    <svg class="w-6 h-6 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    <span>Feedback</span>
                </a>
                @if (Auth::user() && method_exists(Auth::user(), 'isAdmin') && Auth::user()->isAdmin())
                <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-lg transition-colors hover:bg-teal-700 @if(request()->routeIs('admin.users.*')) active @endif">
                    <svg class="w-6 h-6 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A12.073 12.073 0 0112 15c2.042 0 3.966.45 5.121 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    <span>Users</span>
                </a>
                @endif
                <!-- New Branches link -->
                <a href="{{ route('admin.branches.index') }}" class="sidebar-link flex items-center gap-4 px-4 py-3 rounded-lg transition-colors hover:bg-teal-700 @if(request()->routeIs('admin.branches.*')) active @endif">
                    <svg class="w-6 h-6 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Branches</span>
                </a>
            </nav>
            <div class="p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center gap-4 px-4 py-3 rounded-lg transition-colors bg-teal-700 hover:bg-teal-600 text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main content & Header -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="flex justify-between items-center p-6 bg-white border-b-2 border-gray-200 lg:justify-end">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none lg:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <div class="font-semibold">Welcome, {{ Auth::user()->name }}</div>
            </header>
            
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- jQuery & HoldOn.js -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/holdon.js/dist/HoldOn.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // --- SweetAlert2 Toast Notifications ---
            const Toast = Swal.mixin({
                toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true,
                didOpen: (toast) => { toast.addEventListener('mouseenter', Swal.stopTimer); toast.addEventListener('mouseleave', Swal.resumeTimer); }
            });
            @if(session('success'))
                Toast.fire({ icon: 'success', title: '{{ session('success') }}' });
            @endif
            @if(session('error'))
                Toast.fire({ icon: 'error', title: '{{ session('error') }}' });
            @endif
            @if($errors->bookingCreation->any())
                 Swal.fire({ icon: 'error', title: 'Oops...', html: `<p class="mb-2">There were some problems with your input:</p><ul class="text-left list-disc list-inside">@foreach ($errors->bookingCreation->all() as $error)<li>{{ $error }}</li>@endforeach</ul>` });
            @endif

            // --- HoldOn.js Loading Indicator ---
            const loadingOptions = {
                theme: "sk-circle",
                message: 'Please wait...',
                backgroundColor: "#0d9488", // teal-600
                textColor: "white"
            };
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() { HoldOn.open(loadingOptions); });
            });
            document.querySelectorAll('.sidebar-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    if (!this.classList.contains('active')) { HoldOn.open(loadingOptions); }
                });
            });
        });
    </script>
    @stack('scripts')
</body>
</html>


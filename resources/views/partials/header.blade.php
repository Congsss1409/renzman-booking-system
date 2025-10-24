<header x-data="{ open: false }" class="fixed top-0 left-0 right-0 z-50 p-2 sm:p-4">
    <div class="container mx-auto flex justify-between items-center header-glass rounded-2xl p-2 px-4 sm:px-6 shadow-lg">
        <a href="{{ route('landing') }}"><img src="{{ asset('images/logo_white.png') }}" alt="Renzman Logo" class="h-10 sm:h-12"></a>
        <nav class="hidden md:flex items-center space-x-8">
            <a href="{{ route('landing') }}" class="transition-colors px-1 py-1 text-sm {{ request()->routeIs('landing') ? 'font-bold text-white' : 'text-gray-200 hover:text-white' }}" {{ request()->routeIs('landing') ? 'aria-current="page"' : '' }}>Home</a>
            <a href="{{ route('services') }}" class="transition-colors px-1 py-1 text-sm {{ request()->routeIs('services') ? 'font-bold text-white' : 'text-gray-200 hover:text-white' }}" {{ request()->routeIs('services') ? 'aria-current="page"' : '' }}>Services</a>
            <a href="{{ route('about') }}" class="transition-colors px-1 py-1 text-sm {{ request()->routeIs('about') ? 'font-bold text-white' : 'text-gray-200 hover:text-white' }}" {{ request()->routeIs('about') ? 'aria-current="page"' : '' }}>About Us</a>
        </nav>

        <div class="nav-right flex items-center gap-3">
            <a href="{{ route('booking.create.step-one') }}" class="hidden sm:inline-block bg-white text-teal-600 font-bold py-2 px-6 text-sm sm:py-3 sm:px-8 sm:text-base rounded-full shadow-md hover:bg-cyan-100 transition-all transform hover:scale-105">
                Book Now
            </a>

            <!-- Social icons as a list on the navbar -->
            <ul class="hidden md:flex items-center gap-2 m-0 p-0" style="list-style:none;">
                <li>
                    <!-- Desktop social link: show icon + label and match nav spacing -->
                    <a href="https://www.facebook.com/RenzmanBlindMASSAGE" class="flex items-center gap-2 text-white hover:text-white/80 px-3 py-2 rounded-md text-sm font-medium" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M22 12.07C22 6.48 17.52 2 11.93 2S2 6.48 2 12.07C2 17.09 5.66 21.19 10.44 22v-7.03H8.07v-2.9h2.37V9.41c0-2.35 1.39-3.64 3.52-3.64 1.02 0 2.09.18 2.09.18v2.3h-1.18c-1.16 0-1.52.72-1.52 1.46v1.75h2.59l-.41 2.9h-2.18V22C18.34 21.19 22 17.09 22 12.07z" fill="#fff"/></svg>
                        <span>Facebook</span>
                    </a>
                </li>
            </ul>

            <div class="md:hidden">
                <button @click="open = !open" class="text-white focus:outline-none" aria-expanded="false">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" @click.away="open = false" class="md:hidden mt-3 mobile-nav rounded-2xl shadow-lg">
        <a href="{{ route('landing') }}" @click="open = false" class="block text-center py-3 px-4 {{ request()->routeIs('landing') ? 'text-white bg-white/10 font-bold rounded-t-2xl' : 'text-white hover:bg-white/10 rounded-t-2xl' }}" {{ request()->routeIs('landing') ? 'aria-current="page"' : '' }}>Home</a>
        <a href="{{ route('services') }}" @click="open = false" class="block text-center py-3 px-4 {{ request()->routeIs('services') ? 'text-white bg-white/10 font-bold' : 'text-white hover:bg-white/10' }}" {{ request()->routeIs('services') ? 'aria-current="page"' : '' }}>Services</a>
        <a href="{{ route('about') }}" @click="open = false" class="block text-center py-3 px-4 {{ request()->routeIs('about') ? 'text-white bg-white/10 font-bold' : 'text-white hover:bg-white/10' }}">About Us</a>
        <!-- Make Facebook a full-width mobile menu item with label so it lines up with the other options -->
        <a href="https://www.facebook.com/RenzmanBlindMASSAGE" @click="open = false" class="block text-center py-3 px-4 text-white hover:bg-white/10" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
            <span class="inline-flex items-center justify-center gap-2">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M22 12.07C22 6.48 17.52 2 11.93 2S2 6.48 2 12.07C2 17.09 5.66 21.19 10.44 22v-7.03H8.07v-2.9h2.37V9.41c0-2.35 1.39-3.64 3.52-3.64 1.02 0 2.09.18 2.09.18v2.3h-1.18c-1.16 0-1.52.72-1.52 1.46v1.75h2.59l-.41 2.9h-2.18V22C18.34 21.19 22 17.09 22 12.07z" fill="#fff"/></svg>
                <span>Facebook</span>
            </span>
        </a>
        <a href="{{ route('booking.create.step-one') }}" class="block text-center bg-white/20 hover:bg-white/30 text-white font-bold py-4 px-4 rounded-b-2xl">Book Now</a>
    </div>
</header>

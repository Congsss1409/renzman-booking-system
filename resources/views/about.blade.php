@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<style>
    /* Custom styles for the Liquid Glass effect */
    .glass-panel {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .header-glass {
        background: rgba(0, 0, 0, 0.25);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .mobile-nav {
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    .animate-blob { animation: blob 7s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
    .animation-delay-4000 { animation-delay: 4s; }
    @keyframes blob {
	    0% { transform: translate(0px, 0px) scale(1); }
	    33% { transform: translate(30px, -50px) scale(1.1); }
	    66% { transform: translate(-20px, 20px) scale(0.9); }
	    100% { transform: translate(0px, 0px) scale(1); }
    }
</style>

<div class="relative min-h-screen w-full text-black overflow-x-hidden bg-cover bg-center bg-no-repeat" style="background-image: url('{{ asset('images/store4.jpg') }}');">
    
    <!-- Header Section -->
    <header x-data="{ open: false }" class="fixed top-0 left-0 right-0 z-50 p-2 sm:p-4">
        <div class="container mx-auto flex justify-between items-center header-glass rounded-full p-2 px-4 sm:px-6 shadow-lg">
            <a href="{{ route('landing') }}"><img src="{{ asset('images/logo_white.png') }}" alt="Renzman Logo" class="h-10 sm:h-12"></a>
            <nav class="hidden md:flex items-center space-x-8 text-gray-200">
                <a href="{{ route('landing') }}" class="hover:text-white transition-colors">Home</a>
                <a href="{{ route('services') }}" class="hover:text-white transition-colors">Services</a>
                <a href="{{ route('about') }}" class="font-bold text-white">About Us</a>
            </nav>
            <a href="{{ route('booking.create.step-one') }}" class="hidden sm:inline-block bg-white text-teal-600 font-bold py-2 px-6 text-sm sm:py-3 sm:px-8 sm:text-base rounded-full shadow-md hover:bg-cyan-100 transition-all transform hover:scale-105">
                Book Now
            </a>
            <div class="md:hidden">
                <button @click="open = !open" class="text-white focus:outline-none">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                </button>
            </div>
        </div>
        <!-- Mobile Menu -->
        <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" @click.away="open = false" class="md:hidden mt-3 mobile-nav rounded-2xl shadow-lg">
            <a href="{{ route('landing') }}" @click="open = false" class="block text-center py-3 px-4 text-white hover:bg-white/10 rounded-t-2xl">Home</a>
            <a href="{{ route('services') }}" @click="open = false" class="block text-center py-3 px-4 text-white hover:bg-white/10">Services</a>
            <a href="{{ route('about') }}" @click="open = false" class="block text-center py-3 px-4 text-white bg-white/10 font-bold">About Us</a>
            <a href="{{ route('booking.create.step-one') }}" class="block text-center bg-white/20 hover:bg-white/30 text-white font-bold py-4 px-4 rounded-b-2xl">Book Now</a>
        </div>
    </header>

    <!-- Floating decorative blobs -->
    <div class="absolute top-0 -left-20 w-72 h-72 bg-teal-400 rounded-full mix-blend-soft-light filter blur-xl opacity-70 animate-blob"></div>
    <div class="absolute top-0 -right-20 w-72 h-72 bg-cyan-400 rounded-full mix-blend-soft-light filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-8 left-20 w-72 h-72 bg-emerald-400 rounded-full mix-blend-soft-light filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>

    <div class="relative z-10">
        <!-- Main Content -->
        <main class="container mx-auto px-4 sm:px-6 pt-28 pb-16">
            <div class="glass-panel rounded-3xl p-6 sm:p-8 md:p-12">
                <div class="text-center max-w-4xl mx-auto">
                    <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold">About Renzman</h1>
                    <p class="mt-4 text-base sm:text-lg text-black">Your trusted partner in relaxation and wellness since our inception.</p>
                </div>

                <div class="mt-12 sm:mt-16 grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-center">
                    <div>
                        <img src="{{ asset('images/store.jpg') }}" alt="A relaxing spa environment" class="rounded-2xl shadow-xl">
                    </div>
                    <div class="glass-panel rounded-2xl p-6 sm:p-8">
                        <h2 class="text-2xl sm:text-3xl font-bold">Our Mission</h2>
                        <p class="mt-4 text-black text-sm sm:text-base">
                            At Renzman Blind Massage Therapy, our mission is to promote wellness, relaxation, and inclusivity through professional and compassionate massage services. We aim to provide every client with a personalized healing experience that relieves stress, eases body tension, and rejuvenates both mind and spirit. Beyond physical wellness, Renzman also advocates for empowerment and equal opportunity by providing sustainable employment to visually impaired massage therapists, proving that true skill is felt by the hands, not just seen by the eyes.
                        </p>
                        <h2 class="text-2xl sm:text-3xl font-bold mt-6 sm:mt-8">Our Story</h2>
                        <p class="mt-4 text-black text-sm sm:text-base">
                            Renzman began with a simple yet meaningful goal — to create a space where clients can find comfort, while also offering livelihood and dignity to visually impaired individuals. From a small local massage service, Renzman has grown into a recognized and trusted name in wellness, known for its professional care, calming ambiance, and client-centered service. Over the years, we have continuously improved our facilities and technologies, such as adopting an Appointment Management System and mobile application to make booking sessions faster, easier, and more organized. Despite our expansion, our core values of compassion, respect, and accessibility remain at the heart of everything we do.
                        </p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="container mx-auto text-center pb-12 px-4 sm:px-6">
            <div class="glass-panel rounded-2xl p-6 sm:p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                    <div>
                        <h3 class="font-bold text-lg">About Renzman</h3>
                        <p class="text-sm text-black mt-2">Renzman Blind Massage Therapy offers professional and relaxing massage services delivered by skilled visually impaired therapists. Each session is designed to relieve tension, reduce stress, and promote overall well-being. We take pride in providing a welcoming and comfortable environment where clients can unwind and restore balance to both body and mind. Through our commitment to quality service and inclusivity, Renzman continues to promote relaxation, confidence, and empowerment—one soothing massage at a time.
                    </div>
                    <div>
                                <h3 class="font-bold text-lg">Quick Links</h3>
                                <ul class="mt-2 space-y-1 text-sm text-black">
                                    <li><a href="{{ route('landing') }}#services" class="hover:text-black">Services</a></li>
                                    <li><a href="{{ route('landing') }}#branches" class="hover:text-black">Branches</a></li>
                                    <li><a href="{{ route('about') }}" class="hover:text-black">About Us</a></li>
                        </ul>
                    </div>
                     <div>
                            <h3 class="font-bold text-base sm:text-lg">Contact Us</h3>
                            <ul class="mt-2 space-y-1 text-xs sm:text-sm text-cyan-200">
                                <li>Email: renzman@renzman-massage.com</li>
                                <li>Phone: 0932-423-3517/0977-392-6564</li>
                            </ul>
                        </div>
                </div>
                <div class="border-t border-white/20 mt-8 pt-6 text-center text-sm text-black">
                    <p>&copy; {{ date('Y') }} Renzman. All rights reserved.</p>
                </div>
            </div>
        </footer>
    </div>
</div>
@endsection


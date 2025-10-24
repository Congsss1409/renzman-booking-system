@extends('layouts.app')

@section('title', 'Our Services')

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
    
    <!-- Floating decorative blobs -->
    <div class="absolute top-0 -left-20 w-72 h-72 bg-teal-400 rounded-full mix-blend-soft-light filter blur-xl opacity-70 animate-blob"></div>
    <div class="absolute top-0 -right-20 w-72 h-72 bg-cyan-400 rounded-full mix-blend-soft-light filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-8 left-20 w-72 h-72 bg-emerald-400 rounded-full mix-blend-soft-light filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>

    <div class="relative z-10">
        @include('partials.header')

        <!-- Main Content -->
                    <main class="container mx-auto px-3 sm:px-6 pt-24 pb-16">
            <div class="glass-panel rounded-3xl p-6 sm:p-8 md:p-12">
                <div class="text-center">
                                <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold leading-tight">Our Signature Services</h1>
                                <p class="mt-3 text-sm sm:text-base text-black max-w-xl mx-auto">Discover the perfect treatment to rejuvenate your body and mind.</p>
                </div>

                <div class="mt-12 sm:mt-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @forelse($services as $service)
                        <div class="glass-panel rounded-2xl p-6 sm:p-8 text-center shadow-lg transform hover:-translate-y-2 transition-transform duration-300">
                            <img src="{{ $service->image_url ?? 'https://placehold.co/400x250/FFFFFF/333333?text=' . urlencode($service->name) }}" alt="{{ $service->name }}" class="w-full h-40 sm:h-48 object-cover rounded-lg mb-4">
                            <h3 class="text-xl sm:text-2xl font-bold">{{ $service->name }}</h3>
                            <p class="text-black mt-2 text-sm h-16">{{ $service->description }}</p>
                            <div class="my-4 sm:my-6"><span class="text-3xl sm:text-4xl font-bold">₱{{ number_format($service->price, 2) }}</span><span class="text-black">/ {{ $service->duration }} mins</span></div>
                            <a href="{{ route('booking.create.step-one') }}" class="mt-4 inline-block bg-white/20 hover:bg-white/30 font-semibold py-3 px-6 sm:px-8 rounded-full transition border border-white/30">
                                Book This Service
                            </a>
                        </div>
                    @empty
                        <p class="col-span-full text-center">Services will be listed here soon.</p>
                    @endforelse
                </div>
            </div>
        </main>
        
        <!-- Footer -->
        <footer class="container mx-auto text-center pb-12 px-4 sm:px-6">
             <div class="glass-panel rounded-2xl p-6 sm:p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                    <div>
                        <h3 class="font-bold text-lg">About Renzman</h3>
                        <p class="text-sm text-black mt-2">Providing top-quality relaxation and wellness services to help you find your peace and rejuvenate your body.</p>
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
                   <p>&copy; {{ date('Y') }} Renzman. All rights reserved. <span class="mx-2">|</span> <a href="{{ url('/admin/login') }}" class="hover:text-white underline">Admin Login</a></p>
                </div>
            </div>
            </footer>
    </div>
</div>
@endsection


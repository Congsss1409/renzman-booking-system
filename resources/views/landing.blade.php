@extends('layouts.app')

@section('title', 'Welcome to Renzman')

@section('content')
<style>
    /* Main container for the full-page scroll effect */
    .scroll-container {
        scroll-snap-type: y mandatory;
        overflow-y: scroll;
        height: 100vh;
    }
    /* Each section is a snap point */
    .scroll-section {
        scroll-snap-align: start;
        height: 100vh;
        position: relative;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 6rem 1.5rem; /* Add padding for content */
    }
    /* Bouncing animation for the scroll arrow */
    .bounce-animation {
        animation: bounce 2s infinite;
    }
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
        40% { transform: translateY(-20px); }
        60% { transform: translateY(-10px); }
    }
    /* Glassmorphism panel style */
    .glass-panel {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    /* Fixed header glass panel style */
    .header-glass {
        background: rgba(0, 0, 0, 0.25);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
</style>

<div class="scroll-container bg-gradient-to-br from-cyan-500 via-teal-500 to-emerald-600 text-white">
    <!-- Header (fixed for all sections) -->
    <header class="fixed top-0 left-0 right-0 z-50 p-4">
        <div class="container mx-auto flex justify-between items-center header-glass rounded-full p-2 px-6 shadow-lg">
            <img src="{{ asset('images/logo trans.png') }}" alt="Renzman Logo" class="h-10">
            <nav class="hidden md:flex items-center space-x-8 text-gray-200">
                <a href="#services" class="hover:text-white transition-colors">Services</a>
                <a href="#branches" class="hover:text-white transition-colors">Branches</a>
                <a href="#testimonials" class="hover:text-white transition-colors">Testimonials</a>
                <a href="{{ route('about') }}" class="hover:text-white transition-colors">About Us</a>
            </nav>
            <a href="{{ route('booking.create.step-one') }}" class="bg-white text-teal-600 font-bold py-3 px-8 rounded-full shadow-md hover:bg-cyan-100 transition-all transform hover:scale-105">
                Book Now
            </a>
        </div>
    </header>

    <!-- Page 1: Hero Section -->
    <section class="scroll-section text-center" style="background-image: url('{{ asset('images/store1.jpg') }}'); background-size: cover; background-position: center;">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative z-10 flex flex-col items-center">
            <h1 class="text-4xl md:text-6xl font-bold leading-tight drop-shadow-lg">Be Relaxed.<br>Be Rejuvenated. Be Relieved.</h1>
            <p class="mt-4 text-lg md:text-xl max-w-2xl mx-auto text-gray-200 drop-shadow-md">
                Escape the everyday and discover a new level of peace and rejuvenation.
            </p>
            <a href="{{ route('booking.create.step-one') }}" class="mt-8 inline-block bg-white hover:bg-gray-200 text-teal-600 font-bold py-4 px-12 rounded-full shadow-xl transition-transform transform hover:scale-105 text-lg">
                Book an Appointment
            </a>
        </div>
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-10">
            <a href="#services" class="flex flex-col items-center bounce-animation">
                <span>Scroll Down</span>
                <svg class="w-6 h-6 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
            </a>
        </div>
    </section>

    <!-- Page 2: Services Section -->
    <section id="services" class="scroll-section">
        <div class="container mx-auto h-full flex flex-col justify-center">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold">Our Signature Services</h2>
                <p class="mt-2 text-cyan-100">Tailored treatments designed for your ultimate comfort.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                 @forelse($services->take(3) as $service)
                    <div class="glass-panel rounded-2xl p-6 text-center shadow-lg flex flex-col transform hover:-translate-y-2 transition-transform duration-300 overflow-hidden">
                        <img src="{{ $service->image_url ?? 'https://placehold.co/400x500/FFFFFF/333333?text=' . urlencode($service->name) }}" alt="{{ $service->name }}" class="w-full h-64 object-cover rounded-lg mb-4">
                        <div class="flex-grow flex flex-col">
                            <h3 class="text-2xl font-bold">{{ $service->name }}</h3>
                            <p class="text-cyan-200 mt-2 text-sm flex-grow">{{ $service->description }}</p>
                            <div class="my-6">
                                <span class="text-4xl font-bold">₱{{ number_format($service->price, 2) }}</span>
                                <span class="text-cyan-100">/ {{ $service->duration }} mins</span>
                            </div>
                            <a href="{{ route('booking.create.step-one') }}" class="mt-auto inline-block bg-white/20 hover:bg-white/30 font-semibold py-3 px-8 rounded-full transition border border-white/30">
                                Book This Service
                            </a>
                        </div>
                    </div>
                @empty
                    <p class="col-span-full text-center">Our services will be listed here soon.</p>
                @endforelse
            </div>
             @if(count($services) > 3)
                <div class="text-center mt-12">
                    <a href="{{ route('services') }}" class="font-semibold bg-white/20 hover:bg-white/30 py-2 px-4 rounded-full">View All Services &rarr;</a>
                </div>
            @endif
        </div>
    </section>

    <!-- Page 3: Our Branches Section -->
    <section id="branches" class="scroll-section">
        <div class="container mx-auto h-full flex flex-col justify-center">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold">Visit Our Branches</h2>
                <p class="mt-2 text-cyan-100">Find a sanctuary near you.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @forelse($branches as $branch)
                    <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($branch->name . ', ' . $branch->address) }}" target="_blank" rel="noopener noreferrer" class="block">
                        <div class="glass-panel p-8 text-center rounded-lg shadow-md h-full transform hover:-translate-y-2 transition-transform duration-300">
                            <svg class="w-12 h-12 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                            <h3 class="text-xl font-bold">{{ $branch->name }}</h3>
                            <p class="text-cyan-200 mt-2 text-sm">{{ $branch->address }}</p>
                        </div>
                    </a>
                @empty
                    <p class="col-span-full text-center">Our branches will be listed here soon.</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Page 4: Testimonials & Footer Section -->
    <section id="testimonials" class="scroll-section">
        <div class="container mx-auto h-full flex flex-col justify-center">
             @if($feedbacks->isNotEmpty())
                <div class="text-center mb-12">
                    <h2 class="text-4xl font-bold">What Our Clients Say</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($feedbacks as $feedback)
                        <div class="glass-panel rounded-2xl p-8 shadow-lg">
                            <div class="flex text-2xl text-amber-300 mb-4">@for ($i = 0; $i < 5; $i++)<span>{{ $i < $feedback->rating ? '★' : '☆' }}</span>@endfor</div>
                            <p class="text-cyan-100 italic mb-6">"{{ $feedback->feedback }}"</p>
                            <div class="text-right">
                                <p class="font-bold">{{ $feedback->client_name }}</p>
                                <p class="text-sm text-cyan-200">for {{ $feedback->service->name ?? 'a service' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Footer -->
            <footer class="w-full mt-auto pt-12">
                <div class="glass-panel rounded-2xl p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-left">
                        <div>
                            <h3 class="font-bold text-lg">About Renzman</h3>
                            <p class="text-sm text-cyan-200 mt-2">Providing top-quality relaxation and wellness services to help you find your peace and rejuvenate your body.</p>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Quick Links</h3>
                            <ul class="mt-2 space-y-1 text-sm text-cyan-200">
                                <li><a href="#services" class="hover:text-white">Services</a></li>
                                <li><a href="#branches" class="hover:text-white">Branches</a></li>
                                <li><a href="{{ route('about') }}" class="hover:text-white">About Us</a></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">Contact Us</h3>
                            <ul class="mt-2 space-y-1 text-sm text-cyan-200">
                                <li>Email: contact@renzman.com</li>
                                <li>Phone: (02) 8123-4567</li>
                            </ul>
                        </div>
                    </div>
                    <div class="border-t border-white/20 mt-8 pt-6 text-center text-sm text-cyan-200">
                        <p>&copy; {{ date('Y') }} Renzman. All rights reserved.</p>
                    </div>
                </div>
            </footer>
        </div>
    </section>
</div>
@endsection


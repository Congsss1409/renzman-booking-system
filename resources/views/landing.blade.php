@extends('layouts.app')

@section('title', 'Welcome to Renzman')

@section('content')
<style>
    /* Custom styles for the Liquid Glass effect */
    .glass-panel {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 { animation-delay: 2s; }
    .animation-delay-4000 { animation-delay: 4s; }
    @keyframes blob {
	    0% { transform: translate(0px, 0px) scale(1); }
	    33% { transform: translate(30px, -50px) scale(1.1); }
	    66% { transform: translate(-20px, 20px) scale(0.9); }
	    100% { transform: translate(0px, 0px) scale(1); }
    }
</style>

<div class="relative min-h-screen w-full bg-gradient-to-br from-cyan-500 via-teal-500 to-emerald-600 text-white">
    
    <!-- Floating decorative blobs -->
    <div class="absolute top-0 -left-20 w-72 h-72 bg-teal-400 rounded-full mix-blend-soft-light filter blur-xl opacity-70 animate-blob"></div>
    <div class="absolute top-0 -right-20 w-72 h-72 bg-cyan-400 rounded-full mix-blend-soft-light filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
    <div class="absolute -bottom-8 left-20 w-72 h-72 bg-emerald-400 rounded-full mix-blend-soft-light filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>

    <div class="relative z-10">
        <!-- Header Section -->
        <header class="p-4">
            <div class="container mx-auto flex justify-between items-center glass-panel rounded-full p-2 px-6 shadow-lg">
                <img src="{{ asset('images/logo_white.png') }}" alt="Renzman Logo" class="h-10">
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="#services" class="hover:text-cyan-200 transition-colors">Services</a>
                    <a href="#branches" class="hover:text-cyan-200 transition-colors">Branches</a>
                    <a href="#testimonials" class="hover:text-cyan-200 transition-colors">Testimonials</a>
                    <a href="{{ route('about') }}" class="hover:text-cyan-200 transition-colors">About Us</a>
                </nav>
                <a href="{{ route('booking.create.step-one') }}" class="bg-white text-teal-600 font-bold py-2 px-6 rounded-full shadow-md hover:bg-cyan-100 transition-all transform hover:scale-105">
                    Book Now
                </a>
            </div>
        </header>

        <!-- Hero Section -->
        <main class="container mx-auto px-6 py-24 md:py-32 text-center">
            <div class="glass-panel rounded-3xl p-8 md:p-16 shadow-2xl">
                <h1 class="text-4xl md:text-6xl font-bold leading-tight">Your Sanctuary for <br> Relaxation and Wellness.</h1>
                <p class="mt-6 text-lg md:text-xl max-w-2xl mx-auto text-cyan-100">Experience tranquility and rejuvenation with our expert massage therapists. Book your escape today.</p>
                <a href="{{ route('booking.create.step-one') }}" class="mt-10 inline-block bg-white text-teal-600 font-bold py-4 px-10 rounded-full shadow-xl hover:bg-cyan-100 transition-all transform hover:scale-105 text-lg">
                    Schedule Your Session
                </a>
            </div>
        </main>

        <!-- Services Section -->
        <section id="services" class="py-20 px-6">
            <div class="container mx-auto">
                <h2 class="text-4xl font-bold text-center mb-12">Our Signature Services</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @forelse($services as $service)
                        <div class="glass-panel rounded-2xl p-8 text-center shadow-lg transform hover:-translate-y-2 transition-transform duration-300">
                            <h3 class="text-2xl font-bold">{{ $service->name }}</h3>
                            <p class="text-cyan-200 mt-2 text-sm h-16">{{ $service->description }}</p>
                            <div class="my-6"><span class="text-4xl font-bold">₱{{ number_format($service->price, 2) }}</span><span class="text-cyan-100">/ {{ $service->duration }} mins</span></div>
                            <a href="{{ route('booking.create.step-one') }}" class="mt-4 inline-block bg-white/20 hover:bg-white/30 text-white font-semibold py-2 px-6 rounded-full border border-white/50 transition">Book This Service</a>
                        </div>
                    @empty
                        <p class="col-span-full text-center">Services will be listed here soon.</p>
                    @endforelse
                </div>
            </div>
        </section>
        
        <!-- Why Choose Us Section -->
        <section id="why-choose-us" class="py-20 px-6">
            <div class="container mx-auto">
                <h2 class="text-4xl font-bold text-center mb-12">Why Choose Us?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div class="glass-panel rounded-2xl p-8 shadow-lg"><div class="mx-auto bg-white/20 h-20 w-20 rounded-full flex items-center justify-center mb-6"><svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg></div><h3 class="text-2xl font-bold">Expert Therapists</h3><p class="text-cyan-100 mt-2">Our certified therapists are masters of their craft, dedicated to your well-being.</p></div>
                    <div class="glass-panel rounded-2xl p-8 shadow-lg"><div class="mx-auto bg-white/20 h-20 w-20 rounded-full flex items-center justify-center mb-6"><svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></div><h3 class="text-2xl font-bold">Peaceful Ambiance</h3><p class="text-cyan-100 mt-2">Step into our serene environment designed for ultimate relaxation and comfort.</p></div>
                    <div class="glass-panel rounded-2xl p-8 shadow-lg"><div class="mx-auto bg-white/20 h-20 w-20 rounded-full flex items-center justify-center mb-6"><svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg></div><h3 class="text-2xl font-bold">Personalized Treatments</h3><p class="text-cyan-100 mt-2">Every session is tailored to your specific needs for the most effective results.</p></div>
                </div>
            </div>
        </section>

        <!-- Our Branches Section -->
        <section id="branches" class="py-20 px-6">
            <div class="container mx-auto">
                <h2 class="text-4xl font-bold text-center mb-12">Our Branches</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                     @forelse($branches as $branch)
                        <div class="glass-panel rounded-2xl p-8 text-center shadow-lg"><svg class="w-12 h-12 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg><h3 class="text-xl font-bold">{{ $branch->name }}</h3><p class="text-cyan-200 mt-2 text-sm">{{ $branch->address }}</p></div>
                    @empty
                        <p class="col-span-full text-center">Our branches will be listed here soon.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- Testimonials Section -->
        @if($feedbacks->isNotEmpty())
        <section id="testimonials" class="py-20 px-6">
            <div class="container mx-auto">
                <h2 class="text-4xl font-bold text-center mb-12">What Our Clients Say</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($feedbacks as $feedback)
                        <div class="glass-panel rounded-2xl p-8 shadow-lg"><div class="flex text-2xl text-amber-300 mb-4">@for ($i = 0; $i < 5; $i++)<span>{{ $i < $feedback->rating ? '★' : '☆' }}</span>@endfor</div><p class="text-cyan-100 italic mb-6">"{{ $feedback->feedback }}"</p><div class="text-right"><p class="font-bold">{{ $feedback->client_name }}</p><p class="text-sm text-cyan-200">for {{ $feedback->service->name ?? 'a service' }}</p></div></div>
                    @endforeach
                </div>
            </div>
        </section>
        @endif

        <!-- Footer -->
        <footer class="container mx-auto text-center py-12 px-6">
            <div class="glass-panel rounded-full py-4">
                 <p>&copy; {{ date('Y') }} Renzman. All rights reserved.</p>
            </div>
        </footer>
    </div>
</div>
@endsection


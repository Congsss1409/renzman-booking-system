{{-- resources/views/landing.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover" src="{{ asset('images/pic.jpg') }}" alt="Relaxing massage environment">
            <div class="absolute inset-0 bg-emerald-900 bg-opacity-60"></div>
        </div>
        <div class="relative container mx-auto px-4 py-24 sm:py-32 text-center text-white">
            <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold tracking-tight">
                <span class="block">Be Relaxed, Be Rejuvenated, Be Relieved</span>
            </h1>
            <p class="mt-6 max-w-2xl mx-auto text-lg sm:text-xl text-emerald-100">
                Experience the healing power of touch from our certified, visually impaired therapists who possess a uniquely heightened sense of awareness.
            </p>
            <div class="mt-10">
                <a href="{{ route('booking.create.step-one') }}" class="bg-emerald-500 text-white font-bold py-4 px-10 rounded-full text-lg hover:bg-emerald-600 transition-transform transform hover:scale-105 shadow-lg">
                    Book Your Session Now
                </a>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <section class="py-16 sm:py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Why Choose Renzman?</h2>
                <p class="mt-2 text-gray-600">A unique experience dedicated to your well-being.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-6">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 text-emerald-600 mx-auto mb-4">
                        <!-- Icon: Hand -->
                        <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11.5V14m0-2.5v-6a1.5 1.5 0 113 0m-3 6a1.5 1.5 0 00-3 0v2a7.5 7.5 0 0015 0v-5a1.5 1.5 0 00-3 0m-6-3V11m0-5.5v-1a1.5 1.5 0 013 0v1m0 0V11m0-5.5a1.5 1.5 0 013 0v3.5m0 0V11" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Expert Therapists</h3>
                    <p class="mt-2 text-gray-600">Our visually impaired therapists have a heightened sense of touch, allowing for a more intuitive and effective massage.</p>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 text-emerald-600 mx-auto mb-4">
                        <!-- Icon: Heart -->
                        <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.5l1.318-1.182a4.5 4.5 0 116.364 6.364L12 20.25l-7.682-7.682a4.5 4.5 0 010-6.364z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Holistic Benefits</h3>
                    <p class="mt-2 text-gray-600">Our massages provide stress relief, remove back pain, improve sleep, and boost immunity.</p>
                </div>
                <div class="p-6">
                    <div class="flex items-center justify-center h-16 w-16 rounded-full bg-emerald-100 text-emerald-600 mx-auto mb-4">
                        <!-- Icon: Location -->
                        <svg xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Convenient Locations</h3>
                    <p class="mt-2 text-gray-600">With multiple branches across the city, relaxation is always within your reach.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Services Section -->
    <section class="py-16 sm:py-20">
        <div class="container mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Our Popular Services</h2>
                <p class="mt-2 text-gray-600">Find the perfect treatment to suit your needs.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($featuredServices as $service)
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden transform hover:-translate-y-2 transition-transform duration-300">
                    <div class="p-8">
                        <h3 class="text-xl font-bold text-emerald-700">{{ $service->name }}</h3>
                        <p class="mt-2 text-gray-600 h-12">{{ $service->description }}</p>
                        <div class="mt-6 flex justify-between items-center">
                            <span class="text-2xl font-bold text-gray-800">₱{{ number_format($service->price, 2) }}</span>
                            <span class="text-gray-500">{{ $service->duration }} min</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="text-center mt-12">
                <a href="{{ route('booking.create.step-one') }}" class="text-emerald-600 font-semibold hover:text-emerald-800">
                    View All Services & Book Now &rarr;
                </a>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="bg-emerald-700">
        <div class="container mx-auto px-4 py-16 text-center sm:py-20">
            <h2 class="text-3xl font-bold text-white">Ready to Experience True Relaxation?</h2>
            <p class="mt-4 text-lg text-emerald-100 max-w-2xl mx-auto">
                Don't wait to treat yourself. A world of calm and relief is just a few clicks away. Our team is ready to provide you with an unforgettable massage experience.
            </p>
            <div class="mt-8">
                <a href="{{ route('booking.create.step-one') }}" class="bg-white text-emerald-700 font-bold py-4 px-10 rounded-full text-lg hover:bg-emerald-50 transition-colors shadow-lg">
                    Schedule Your Appointment
                </a>
            </div>
        </div>
    </section>
</div>
@endsection

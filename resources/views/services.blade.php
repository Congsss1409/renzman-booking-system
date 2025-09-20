@extends('layouts.app')

@section('title', 'Our Services')

@section('content')
<div class="bg-white">
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-20">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <a href="{{ route('landing') }}">
                <img src="{{ asset('images/logo trans.png') }}" alt="Renzman Logo" class="h-10">
            </a>
            <nav class="hidden md:flex items-center space-x-6 text-gray-700">
                <a href="{{ route('landing') }}" class="hover:text-teal-500 transition-colors">Home</a>
                <a href="{{ route('services') }}" class="font-bold text-teal-600">Services</a>
                <a href="{{ route('about') }}" class="hover:text-teal-500 transition-colors">About Us</a>
            </nav>
            <a href="{{ route('booking.create.step-one') }}" class="bg-teal-500 text-white font-bold py-2 px-6 rounded-full shadow-md hover:bg-teal-600 transition-all transform hover:scale-105">
                Book Now
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-16">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800">Our Signature Services</h1>
            <p class="mt-4 text-lg text-gray-600">Discover the perfect treatment to rejuvenate your body and mind.</p>
        </div>

        <div class="mt-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($services as $service)
                <div class="bg-white rounded-2xl p-8 text-center shadow-lg border hover:shadow-xl hover:-translate-y-2 transition-all duration-300">
                    <h3 class="text-2xl font-bold text-gray-900">{{ $service->name }}</h3>
                    <p class="text-gray-600 mt-2 text-sm h-16">{{ $service->description }}</p>
                    <div class="my-6">
                        <span class="text-4xl font-bold text-teal-600">₱{{ number_format($service->price, 2) }}</span>
                        <span class="text-gray-500">/ {{ $service->duration }} mins</span>
                    </div>
                    <a href="{{ route('booking.create.step-one') }}" class="mt-4 inline-block bg-teal-500 hover:bg-teal-600 text-white font-semibold py-3 px-8 rounded-full transition">
                        Book This Service
                    </a>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500">Services will be listed here soon.</p>
            @endforelse
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-8 mt-16">
        <p>&copy; {{ date('Y') }} Renzman. All rights reserved.</p>
    </footer>
</div>
@endsection

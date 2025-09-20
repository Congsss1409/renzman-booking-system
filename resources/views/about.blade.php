@extends('layouts.app')

@section('title', 'About Us')

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
                <a href="{{ route('services') }}" class="hover:text-teal-500 transition-colors">Services</a>
                <a href="{{ route('about') }}" class="font-bold text-teal-600">About Us</a>
            </nav>
            <a href="{{ route('booking.create.step-one') }}" class="bg-teal-500 text-white font-bold py-2 px-6 rounded-full shadow-md hover:bg-teal-600 transition-all transform hover:scale-105">
                Book Now
            </a>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-6 py-16">
        <div class="text-center max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800">About Renzman</h1>
            <p class="mt-4 text-lg text-gray-600">Your trusted partner in relaxation and wellness since our inception.</p>
        </div>

        <div class="mt-16 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <img src="https://placehold.co/600x400/0d9488/FFFFFF?text=Our+Sanctuary&font=poppins" alt="A relaxing spa environment" class="rounded-2xl shadow-xl">
            </div>
            <div>
                <h2 class="text-3xl font-bold text-gray-800">Our Mission</h2>
                <p class="mt-4 text-gray-600">
                    At Renzman, our mission is to provide an accessible escape from the stresses of daily life. We believe in the power of touch and the importance of self-care. Our team of expert therapists is dedicated to delivering personalized treatments that not only soothe tired muscles but also restore balance to your mind and spirit. We are committed to creating a serene and welcoming environment where every client can find their moment of peace.
                </p>
                <h2 class="text-3xl font-bold text-gray-800 mt-8">Our Story</h2>
                <p class="mt-4 text-gray-600">
                    Founded on the principles of quality, care, and community, Renzman started as a small, local massage parlor with a big dream: to make professional wellness services available to everyone. Through years of dedication and the trust of our loyal clients, we have grown into a well-loved establishment with multiple branches, yet we've never lost the personal touch that defines us.
                </p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-8 mt-16">
        <p>&copy; {{ date('Y') }} Renzman. All rights reserved.</p>
    </footer>
</div>
@endsection
    
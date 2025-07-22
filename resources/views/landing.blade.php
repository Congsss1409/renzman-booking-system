{{-- This view now extends the new 'home' layout file --}}
@extends('layouts.home')

@section('title', 'Welcome to RENZMAN BLIND MASSAGE')

@section('content')
    <!-- Hero Section -->
    <div class="container mx-auto px-6 py-16 md:py-24">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <!-- Text Content -->
            <div class="text-center md:text-left">
                <h1 class="text-4xl lg:text-5xl font-bold leading-tight text-[var(--brand-dark)]">
                    Welcome to Renzman Blind Massage
                </h1>
                <p class="mt-6 text-lg text-gray-600">
                    Discover a unique sense of relaxation and therapy. Our certified blind therapists use their heightened sense of touch to provide an unparalleled massage experience.
                </p>
                <a href="{{ route('booking.stepOne') }}" class="btn-primary mt-8 inline-block px-8 py-3 rounded-full font-bold text-lg">
                    Book a Session
                </a>
            </div>
            <!-- Image -->
            <div>
                {{-- Placeholder image. Replace with a photo from your GDrive --}}
                <img src="{{ asset('images/pic.jpg') }}" alt="Peaceful massage room setting" class="rounded-lg shadow-xl w-150 h-90">
            </div>
        </div>
    </div>

    <!-- What We're Offering Section -->
    <div class="bg-white py-16 md:py-24">
        <div class="container mx-auto px-6">
            <div class="text-center max-w-3xl mx-auto">
                <h2 class="text-3xl lg:text-4xl font-bold">What We're Offering</h2>
                <p class="mt-4 text-gray-600">
                    A range of services designed to meet your specific needs for relaxation and therapeutic relief.
                </p>
            </div>
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Service Card 1 --}}
                <div class="bg-[var(--brand-bg)] p-8 rounded-lg text-center shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-2xl font-bold">Chair Massage</h3>
                    <p class="mt-2 text-gray-600">Perfect for a quick rejuvenation, focusing on the back, neck, and shoulders.</p>
                </div>
                {{-- Service Card 2 --}}
                <div class="bg-[var(--brand-bg)] p-8 rounded-lg text-center shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-2xl font-bold">Bed Massage</h3>
                    <p class="mt-2 text-gray-600">A full-body experience designed for deep relaxation and stress relief.</p>
                </div>
                {{-- Service Card 3 --}}
                <div class="bg-[var(--brand-bg)] p-8 rounded-lg text-center shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <h3 class="text-2xl font-bold">Specialty Therapies</h3>
                    <p class="mt-2 text-gray-600">Includes Ventosa, Hot Stone, and Ear Candling for targeted benefits.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- How It Works Section -->
    <div class="container mx-auto px-6 py-16 md:py-24">
        <div class="text-center max-w-3xl mx-auto">
            <h2 class="text-3xl lg:text-4xl font-bold">How It Works</h2>
            <p class="mt-4 text-gray-600">
                Booking your moment of peace is simple and straightforward.
            </p>
        </div>
        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            {{-- Step 1 --}}
            <div class="p-4">
                <div class="bg-white rounded-full h-16 w-16 flex items-center justify-center mx-auto shadow-md">
                    <span class="text-2xl font-bold text-[var(--brand-green)]">1</span>
                </div>
                <h3 class="mt-6 text-xl font-bold">Choose Your Service</h3>
                <p class="mt-2 text-gray-600">Select from our range of therapeutic massages.</p>
            </div>
            {{-- Step 2 --}}
            <div class="p-4">
                <div class="bg-white rounded-full h-16 w-16 flex items-center justify-center mx-auto shadow-md">
                    <span class="text-2xl font-bold text-[var(--brand-green)]">2</span>
                </div>
                <h3 class="mt-6 text-xl font-bold">Pick a Date & Time</h3>
                <p class="mt-2 text-gray-600">Find a time slot that fits your schedule at your preferred branch.</p>
            </div>
            {{-- Step 3 --}}
            <div class="p-4">
                <div class="bg-white rounded-full h-16 w-16 flex items-center justify-center mx-auto shadow-md">
                    <span class="text-2xl font-bold text-[var(--brand-green)]">3</span>
                </div>
                <h3 class="mt-6 text-xl font-bold">Relax & Rejuvenate</h3>
                <p class="mt-2 text-gray-600">Arrive for your appointment and let our skilled therapists do the rest.</p>
            </div>
        </div>
    </div>

    <!-- Final CTA Section -->
    <div class="bg-white py-16 md:py-24">
        <div class="container mx-auto px-6 text-center">
            <h2 class="text-3xl lg:text-4xl font-bold">Ready for Your Moment of Peace?</h2>
            <a href="{{ route('booking.stepOne') }}" class="btn-primary mt-8 inline-block px-10 py-4 rounded-full font-bold text-xl">
                Book Your Appointment Today
            </a>
        </div>
    </div>
@endsection

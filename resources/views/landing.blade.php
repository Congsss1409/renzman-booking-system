@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <!-- Hero Section -->
    <div class="relative h-screen w-full flex items-center justify-center text-center text-white overflow-hidden">
        <!-- Background Image -->
        <div class="absolute top-0 left-0 w-full h-full bg-cover bg-center" style="background-image: url('{{ asset('images/bed.jpg') }}');"></div>
        
        <!-- Overlay -->
        <div class="absolute top-0 left-0 w-full h-full bg-black opacity-50"></div>
        
        <!-- Content -->
        <div class="relative z-10 px-4">
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-bold tracking-tight" style="font-family: 'Playfair Display', serif;">
                RELAX. REJUVENATE. REFRESH.
            </h1>
            <p class="mt-6 max-w-2xl mx-auto text-lg md:text-xl text-gray-200">
                Escape the hustle and bustle. Discover tranquility and restore your inner peace with our professional massage and spa services.
            </p>
            <div class="mt-10">
                <a href="{{ route('booking.create.step-one') }}" class="inline-block px-10 py-4 text-lg font-semibold text-white bg-indigo-600 rounded-lg shadow-lg hover:bg-indigo-700 transition-transform transform hover:-translate-y-1">
                    Book an Appointment
                </a>
            </div>
        </div>
    </div>

    <!-- Our Services Section -->
    <section id="services" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-4xl font-bold tracking-tight text-gray-900" style="font-family: 'Playfair Display', serif;">Our Services</h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">We offer a variety of services to help you relax and feel your best.</p>
            </div>
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service 1 -->
                <div class="p-8 text-center bg-white rounded-lg shadow-lg">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-indigo-100 rounded-full">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.636 18.364a9 9 0 010-12.728m12.728 0a9 9 0 010 12.728m-9.9-2.829a5 5 0 010-7.07m7.072 0a5 5 0 010 7.07M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-gray-900">Therapeutic Massage</h3>
                    <p class="mt-2 text-gray-600">Relieve stress and muscle tension with our signature therapeutic massage techniques.</p>
                </div>
                <!-- Service 2 -->
                <div class="p-8 text-center bg-white rounded-lg shadow-lg">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-indigo-100 rounded-full">
                       <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-gray-900">Relaxing Facials</h3>
                    <p class="mt-2 text-gray-600">Rejuvenate your skin and achieve a healthy glow with our custom facial treatments.</p>
                </div>
                <!-- Service 3 -->
                <div class="p-8 text-center bg-white rounded-lg shadow-lg">
                    <div class="flex items-center justify-center w-16 h-16 mx-auto bg-indigo-100 rounded-full">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="mt-6 text-xl font-bold text-gray-900">Body Treatments</h3>
                    <p class="mt-2 text-gray-600">Exfoliate, detoxify, and nourish your skin with our luxurious body wraps and scrubs.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="rounded-lg overflow-hidden">
                    <img src="https://placehold.co/600x750/a5b4fc/4f46e5?text=Relaxing+Atmosphere" alt="Spa interior" class="w-full h-full object-cover">
                </div>
                <div>
                    <h2 class="text-4xl font-bold tracking-tight text-gray-900" style="font-family: 'Playfair Display', serif;">The Renzman Experience</h2>
                    <p class="mt-6 text-lg text-gray-600">We are dedicated to providing you with an unparalleled experience of relaxation and wellness. Our mission is to create a serene sanctuary where you can escape the stresses of daily life and find your inner peace.</p>
                    <ul class="mt-8 space-y-4">
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            <span class="ml-3 text-gray-600">Professional and certified therapists.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            <span class="ml-3 text-gray-600">A clean, tranquil, and calming environment.</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                            <span class="ml-3 text-gray-600">High-quality, natural, and organic products.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                 <h2 class="text-4xl font-bold tracking-tight text-gray-900" style="font-family: 'Playfair Display', serif;">Our Gallery</h2>
                <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">A glimpse into our serene and relaxing environment.</p>
            </div>
            <div class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4">
                <img src="https://placehold.co/400x500/c7d2fe/4f46e5?text=Gallery+1" alt="Gallery Image 1" class="rounded-lg object-cover w-full h-full aspect-[4/5] transition-transform duration-300 hover:scale-105">
                <img src="https://placehold.co/400x500/c7d2fe/4f46e5?text=Gallery+2" alt="Gallery Image 2" class="rounded-lg object-cover w-full h-full aspect-[4/5] transition-transform duration-300 hover:scale-105">
                <img src="https://placehold.co/400x500/c7d2fe/4f46e5?text=Gallery+3" alt="Gallery Image 3" class="rounded-lg object-cover w-full h-full aspect-[4/5] transition-transform duration-300 hover:scale-105">
                <img src="https://placehold.co/400x500/c7d2fe/4f46e5?text=Gallery+4" alt="Gallery Image 4" class="rounded-lg object-cover w-full h-full aspect-[4/5] transition-transform duration-300 hover:scale-105">
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                 <h2 class="text-4xl font-bold tracking-tight text-gray-900" style="font-family: 'Playfair Display', serif;">What Our Clients Say</h2>
                 <p class="mt-4 max-w-2xl mx-auto text-lg text-gray-600">We are proud to have the trust and confidence of our clients.</p>
            </div>
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse ($testimonials as $testimonial)
                    <div class="p-8 bg-gray-50 rounded-lg">
                        <p class="text-gray-700">"{{ $testimonial->feedback }}"</p>
                        <div class="flex items-center mt-6">
                            <img src="https://placehold.co/100x100/c7d2fe/4f46e5?text={{ substr($testimonial->client_name, 0, 1) }}" alt="{{ $testimonial->client_name }}" class="w-12 h-12 rounded-full object-cover">
                            <div class="ml-4">
                                <p class="font-bold text-gray-900">{{ $testimonial->client_name }}</p>
                                <div class="flex items-center text-yellow-400">
                                    @for ($i = 0; $i < 5; $i++)
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" /></svg>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="md:col-span-3 text-center text-gray-500">We are still gathering feedback. Check back soon for testimonials from our happy clients!</p>
                @endforelse
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto text-center">
                 <h2 class="text-4xl font-bold tracking-tight text-gray-900" style="font-family: 'Playfair Display', serif;">Frequently Asked Questions</h2>
                 <p class="mt-4 text-lg text-gray-600">Have questions? We have answers. Here are some of the most common questions we receive.</p>
            </div>
            <div x-data="{ open: 1 }" class="mt-12 max-w-3xl mx-auto space-y-4">
                <!-- FAQ 1 -->
                <div class="border border-gray-200 rounded-lg">
                    <button @click="open = (open === 1 ? null : 1)" class="flex items-center justify-between w-full p-6 text-left">
                        <span class="font-semibold text-gray-800">What should I expect on my first visit?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'transform rotate-180': open === 1 }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open === 1" x-collapse class="p-6 pt-0 text-gray-600">
                        <p>On your first visit, you'll be welcomed into our serene environment. We'll have you fill out a brief form to understand your needs and preferences, then your therapist will consult with you before the session begins to ensure a personalized experience.</p>
                    </div>
                </div>
                <!-- FAQ 2 -->
                <div class="border border-gray-200 rounded-lg">
                    <button @click="open = (open === 2 ? null : 2)" class="flex items-center justify-between w-full p-6 text-left">
                        <span class="font-semibold text-gray-800">Do I need to book in advance?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'transform rotate-180': open === 2 }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open === 2" x-collapse class="p-6 pt-0 text-gray-600">
                        <p>We highly recommend booking in advance to secure your preferred time and therapist. Our online booking system is the easiest and fastest way to schedule your appointment. We do accept walk-ins, but availability is not guaranteed.</p>
                    </div>
                </div>
                <!-- FAQ 3 -->
                <div class="border border-gray-200 rounded-lg">
                    <button @click="open = (open === 3 ? null : 3)" class="flex items-center justify-between w-full p-6 text-left">
                        <span class="font-semibold text-gray-800">What is your cancellation policy?</span>
                        <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'transform rotate-180': open === 3 }" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open === 3" x-collapse class="p-6 pt-0 text-gray-600">
                        <p>We kindly request at least 24 hours' notice for any cancellations or rescheduling. This allows us to offer the time slot to another client. Cancellations made with less than 24 hours' notice may be subject to a fee. Please contact us directly for any changes.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


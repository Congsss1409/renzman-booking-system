{{-- resources/views/about.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="relative bg-emerald-700 text-white text-center py-20">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover opacity-20" src="https://images.unsplash.com/photo-1519823551278-64ac92734fb1?q=80&w=1974&auto=format&fit=crop" alt="Abstract background of hands">
        </div>
        <div class="relative container mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-bold">About Renzman Blind Massage</h1>
            <p class="mt-4 text-lg text-emerald-100 max-w-3xl mx-auto">
                Discover our story, our mission, and our commitment to providing an exceptional and inclusive wellness experience.
            </p>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="max-w-4xl mx-auto">
            
            <div class="mb-12" data-aos="fade-up">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Our Story & Mission</h2>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Renzman Blind Massage Therapy was founded on a simple yet powerful principle: the healing power of touch is a sense that can be uniquely perfected. Our founders recognized the exceptional tactile sensitivity that visually impaired individuals often possess and sought to create a professional, empowering environment where these unique talents could flourish.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Our mission is two-fold: to provide our clients with the most intuitive, effective, and deeply relaxing massage therapy available, and to offer meaningful, professional careers for certified visually impaired therapists. Every booking you make supports our commitment to inclusivity and excellence in the wellness industry.
                </p>
            </div>

            <div data-aos="fade-up">
                <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Visit Our Branches</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @forelse ($branches as $index => $branch)
                        <div class="p-6 border rounded-xl shadow-md bg-gray-50 text-center" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                            <h3 class="text-xl font-bold text-emerald-700">{{ $branch->name }}</h3>
                            <p class="mt-2 text-gray-600">{{ $branch->address }}</p>
                        </div>
                    @empty
                        <p class="md:col-span-2 text-center text-gray-500 py-10">Branch information is currently unavailable.</p>
                    @endforelse
                </div>
            </div>

            <div class="text-center mt-16" data-aos="fade-in">
                <a href="{{ route('booking.create.step-one') }}" class="bg-emerald-600 text-white font-bold py-4 px-10 rounded-full text-lg hover:bg-emerald-700 transition-transform transform hover:scale-105 shadow-lg">
                    Ready to Book?
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- resources/views/services.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="bg-white">
    <div class="bg-emerald-700 text-white text-center py-20">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl md:text-5xl font-bold">Our Services</h1>
            <p class="mt-4 text-lg text-emerald-100 max-w-2xl mx-auto">Find the perfect treatment to rejuvenate your body and mind, delivered by our expert visually impaired therapists.</p>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @forelse ($services as $index => $service)
                <div class="p-6 border rounded-xl shadow-md bg-gray-50 hover:shadow-lg transition-shadow duration-300" data-aos="fade-up" data-aos-delay="{{ $index * 50 }}">
                    <div class="flex flex-col h-full">
                        <div class="flex-grow">
                            <div class="flex justify-between items-start">
                                <h2 class="text-2xl font-bold text-gray-800">{{ $service->name }}</h2>
                                <p class="text-xl font-bold text-emerald-600 flex-shrink-0 ml-4">₱{{ number_format($service->price, 2) }}</p>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">{{ $service->duration }} minutes</p>
                            <p class="mt-4 text-gray-600">{{ $service->description }}</p>
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('booking.create.step-one') }}" class="w-full text-center block bg-emerald-100 text-emerald-800 font-bold py-3 px-6 rounded-lg hover:bg-emerald-200 transition-colors">
                                Book This Service
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="md:col-span-2 text-center text-gray-500 py-10">No services are available at this time. Please check back later.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

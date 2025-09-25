@extends('layouts.Booking')

@section('title', 'Step 1: Select Your Service')

@section('content')
<div class="glass-panel rounded-3xl max-w-6xl mx-auto overflow-hidden shadow-2xl">
    <div class="grid md:grid-cols-2">
        
        <!-- Left Column: Image & Branding -->
        <div class="hidden md:block relative">
            <img src="{{ asset('images/services-showcase.jpg') }}" class="absolute h-full w-full object-cover" alt="Woman receiving a relaxing massage">
            <div class="absolute inset-0 bg-teal-800/50"></div>
            <div class="relative z-10 p-12 text-white flex flex-col h-full">
                <div>
                    <h2 class="text-3xl font-bold">Start Your Journey</h2>
                    <p class="mt-2 text-cyan-100">A seamless booking experience for your path to relaxation and wellness.</p>
                </div>
                <div class="mt-auto text-cyan-200 text-sm">
                    <p>Select your preferred branch and service to begin.</p>
                </div>
            </div>
        </div>

        <!-- Right Column: Form -->
        <div class="p-8 md:p-12">
            <!-- Progress Bar -->
            <div class="mb-8">
                <div class="flex justify-between items-center text-sm font-semibold text-cyan-100 mb-2">
                    <span>Step 1/5: Service</span>
                    <span>20%</span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-2.5">
                    <div class="bg-white h-2.5 rounded-full" style="width: 20%"></div>
                </div>
            </div>

            <!-- Form Header -->
            <div class="text-left mb-8">
                <h1 class="text-3xl md:text-4xl font-bold">Select Your Service</h1>
                <p class="mt-2 text-lg text-cyan-100">Choose from our range of professional treatments.</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 bg-red-500/30 border border-red-400 text-white px-4 py-3 rounded-lg relative" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Form Content -->
            <form action="{{ route('booking.store.step-one') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <!-- Branch Selection -->
                    <div>
                        <label for="branch_id" class="block text-lg font-semibold mb-2">1. Choose a Branch</label>
                        <select name="branch_id" id="branch_id" required class="w-full p-4 bg-white/10 rounded-lg border border-white/30 focus:outline-none focus:ring-2 focus:ring-white appearance-none">
                            <option value="" disabled selected class="text-black">Select a branch location</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id', $booking->branch_id ?? '') == $branch->id ? 'selected' : '' }} class="text-black">
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Service Selection -->
                    <div>
                        <label for="service_id" class="block text-lg font-semibold mb-2">2. Choose a Service</label>
                        <select name="service_id" id="service_id" required class="w-full p-4 bg-white/10 rounded-lg border border-white/30 focus:outline-none focus:ring-2 focus:ring-white appearance-none">
                            <option value="" disabled selected class="text-black">Select a service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id', $booking->service_id ?? '') == $service->id ? 'selected' : '' }} class="text-black">
                                    {{ $service->name }} ({{ $service->duration }} mins) - ₱{{ number_format($service->price, 2) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Navigation Buttons -->
                <div class="mt-10 flex justify-end">
                    <button type="submit" class="bg-white text-teal-600 font-bold py-3 px-10 rounded-full shadow-md hover:bg-cyan-100 transition-all transform hover:scale-105">
                        Next Step &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


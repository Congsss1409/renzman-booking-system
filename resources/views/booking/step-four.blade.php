@extends('layouts.Booking')

@section('title', 'Step 4: Your Details')

@section('content')
<div class="glass-panel rounded-3xl max-w-6xl mx-auto overflow-hidden shadow-2xl">
    <div class="grid md:grid-cols-2">
        
        <div class="hidden md:block relative">
            <img src="https://placehold.co/800x1200/0d9488/FFFFFF?text=Final+Details&font=poppins" class="absolute h-full w-full object-cover" alt="A customer happily checking in at the front desk">
            <div class="absolute inset-0 bg-teal-800/50"></div>
            <div class="relative z-10 p-12 text-white flex flex-col h-full">
                <div>
                    <h2 class="text-3xl font-bold">You're Almost Done!</h2>
                    <p class="mt-2 text-cyan-100">Please provide your contact information to finalize and confirm your appointment.</p>
                </div>
                <div class="mt-auto text-cyan-200 text-sm">
                    <p>We'll send a confirmation email and reminders to the address you provide.</p>
                </div>
            </div>
        </div>

        <div class="p-8 md:p-12">
            <div class="mb-8">
                <div class="flex justify-between items-center text-sm font-semibold text-cyan-100 mb-2">
                    <span>Step 4/5: Your Details</span>
                    <span>80%</span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-2.5">
                    <div class="bg-white h-2.5 rounded-full" style="width: 80%"></div>
                </div>
            </div>

            <div class="text-left mb-8">
                <h1 class="text-3xl md:text-4xl font-bold">Enter Your Details</h1>
                <p class="mt-2 text-lg text-cyan-100">This information will be used to confirm your booking.</p>
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

            <form action="{{ route('booking.store.step-four') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="client_name" class="block text-lg font-semibold mb-2">Full Name</label>
                        <input type="text" name="client_name" id="client_name" value="{{ old('client_name', $booking->client_name ?? '') }}" required
                               class="w-full p-4 bg-white/10 rounded-lg border border-white/30 focus:outline-none focus:ring-2 focus:ring-white" placeholder="e.g., Jane Doe">
                    </div>
                    <div>
                        <label for="client_email" class="block text-lg font-semibold mb-2">Email Address</label>
                        <input type="email" name="client_email" id="client_email" value="{{ old('client_email', $booking->client_email ?? '') }}" required
                               class="w-full p-4 bg-white/10 rounded-lg border border-white/30 focus:outline-none focus:ring-2 focus:ring-white" placeholder="you@example.com">
                    </div>
                     <div>
                        <label for="client_phone" class="block text-lg font-semibold mb-2">Phone Number</label>
                        <input type="tel" name="client_phone" id="client_phone" value="{{ old('client_phone', $booking->client_phone ?? '') }}" required
                               class="w-full p-4 bg-white/10 rounded-lg border border-white/30 focus:outline-none focus:ring-2 focus:ring-white" placeholder="e.g., 09171234567">
                    </div>
                </div>

                <div class="mt-10 flex justify-between">
                    <a href="{{ route('booking.create.step-three') }}" class="bg-white/20 text-white font-bold py-3 px-10 rounded-full shadow-md hover:bg-white/30 transition-all transform hover:scale-105">
                        &larr; Back
                    </a>
                    <button type="submit" class="bg-white text-teal-600 font-bold py-3 px-10 rounded-full shadow-md hover:bg-cyan-100 transition-all transform hover:scale-105">
                        Next Step &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
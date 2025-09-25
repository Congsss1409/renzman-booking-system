@extends('layouts.Booking')

@section('title', 'Step 5: Verify Your Booking')

@section('content')
<div class="glass-panel rounded-3xl max-w-6xl mx-auto overflow-hidden shadow-2xl">
    <div class="grid md:grid-cols-2">
        
        <div class="hidden md:block relative">
            <img src="https://placehold.co/800x1200/0d9488/FFFFFF?text=Secure+Your+Spot&font=poppins" class="absolute h-full w-full object-cover" alt="A locked icon representing security">
            <div class="absolute inset-0 bg-teal-800/50"></div>
            <div class="relative z-10 p-12 text-white flex flex-col h-full">
                <div>
                    <h2 class="text-3xl font-bold">Final Confirmation</h2>
                    <p class="mt-2 text-cyan-100">We've sent a 6-digit verification code to your email address to secure your appointment.</p>
                </div>
                <div class="mt-auto text-cyan-200 text-sm">
                    <p>This code will expire in 10 minutes. Please check your inbox (and spam folder).</p>
                </div>
            </div>
        </div>

        <div class="p-8 md:p-12">
            <div class="mb-8">
                <div class="flex justify-between items-center text-sm font-semibold text-cyan-100 mb-2">
                    <span>Step 5/5: Verification</span>
                    <span>100%</span>
                </div>
                <div class="w-full bg-white/20 rounded-full h-2.5">
                    <div class="bg-white h-2.5 rounded-full" style="width: 100%"></div>
                </div>
            </div>

            <div class="text-left mb-8">
                <h1 class="text-3xl md:text-4xl font-bold">Enter Verification Code</h1>
                <p class="mt-2 text-lg text-cyan-100">A code has been sent to {{ $booking->client_email }}.</p>
            </div>

            @if (session('error'))
                <div class="mb-4 bg-red-500/30 border border-red-400 text-white px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
             @error('verification_code')
                <div class="mb-4 bg-red-500/30 border border-red-400 text-white px-4 py-3 rounded-lg relative" role="alert">
                    <span class="block sm:inline">{{ $message }}</span>
                </div>
            @enderror

            <form action="{{ route('booking.store.step-five') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="verification_code" class="block text-lg font-semibold mb-2">6-Digit Code</label>
                        <input type="text" name="verification_code" id="verification_code" required
                               class="w-full p-4 bg-white/10 rounded-lg border border-white/30 focus:outline-none focus:ring-2 focus:ring-white text-center text-2xl tracking-[1em]" 
                               placeholder="______" maxlength="6" pattern="[0-9]{6}">
                    </div>
                </div>

                <div class="mt-10 flex justify-between">
                    <a href="{{ route('booking.create.step-four') }}" class="bg-white/20 text-white font-bold py-3 px-10 rounded-full shadow-md hover:bg-white/30 transition-all transform hover:scale-105">
                        &larr; Back
                    </a>
                    <button type="submit" class="bg-white text-teal-600 font-bold py-3 px-10 rounded-full shadow-md hover:bg-cyan-100 transition-all transform hover:scale-105">
                        Confirm Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
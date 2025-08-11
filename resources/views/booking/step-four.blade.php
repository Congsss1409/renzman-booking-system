{{-- resources/views/booking/step-four.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row">

    <div class="w-full md:w-1/3 bg-emerald-700 text-white p-8 flex flex-col justify-center">
        <div>
            <h1 class="text-3xl font-bold mb-4">Confirm Your Details</h1>
            <p class="text-emerald-100 mb-6">
                Please review your appointment summary and provide your contact information to proceed.
            </p>
            <div class="border-t border-emerald-500 pt-6 space-y-4 text-emerald-200">
                <div class="flex items-center opacity-50">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">1</span>
                    <span>Branch & Service</span>
                </div>
                <div class="flex items-center opacity-50">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">2</span>
                    <span>Choose Therapist</span>
                </div>
                <div class="flex items-center opacity-50">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">3</span>
                    <span>Select Date & Time</span>
                </div>
                <div class="flex items-center">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">4</span>
                    <span>Your Details</span>
                </div>
                <div class="flex items-center opacity-50">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">5</span>
                    <span>Payment</span>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full md:w-2/3 bg-white p-8 lg:p-12 overflow-y-auto">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Step 4: Confirm Your Details</h2>
            
            <div class="bg-gray-50 p-6 rounded-lg border mb-8">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Booking Summary</h3>
                <div class="space-y-3 text-gray-700">
                    <div class="flex justify-between"><span>Branch:</span><span class="font-semibold">{{ $branch->name }}</span></div>
                    <div class="flex justify-between"><span>Service:</span><span class="font-semibold">{{ $service->name }}</span></div>
                    <div class="flex justify-between"><span>Therapist:</span><span class="font-semibold">{{ $therapist->name }}</span></div>
                    <div class="flex justify-between"><span>Date:</span><span class="font-semibold">{{ \Carbon\Carbon::parse($booking->date)->format('F j, Y') }}</span></div>
                    <div class="flex justify-between"><span>Time:</span><span class="font-semibold">{{ $booking->time }}</span></div>
                    <div class="flex justify-between border-t pt-3 mt-3"><span class="text-lg font-bold">Total Price:</span><span class="text-lg font-bold text-emerald-600">₱{{ number_format($service->price, 2) }}</span></div>
                </div>
            </div>

            <form action="{{ route('booking.store.step-four') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="client_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="client_name" id="client_name" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>
                    </div>
                    <div>
                        <label for="client_email" class="block text-sm font-medium text-gray-700">Email Address</label>
                        <input type="email" name="client_email" id="client_email" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>
                    </div>
                    <div>
                        <label for="client_phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="tel" name="client_phone" id="client_phone" class="mt-1 block w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500" required>
                    </div>
                </div>

                <div class="mt-10 flex justify-between items-center border-t pt-6">
                    <a href="{{ route('booking.create.step-three') }}" class="text-gray-600 hover:text-emerald-700 font-semibold">&larr; Go Back</a>
                    <button type="submit" class="bg-emerald-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
                        Proceed to Payment &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- resources/views/booking/step-four.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-2xl">
    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg">
        <h1 class="text-2xl sm:text-3xl font-bold text-center text-emerald-700 mb-8">Step 4: Confirm Your Details</h1>

        <!-- Booking Summary -->
        <div class="bg-gray-50 p-6 rounded-lg border mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Booking Summary</h2>
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

            <div class="mt-8 flex justify-between items-center">
                <a href="{{ route('booking.create.step-three') }}" class="text-gray-600 hover:text-emerald-700">&larr; Back to Date & Time</a>
                <button type="submit" class="bg-emerald-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
                    Proceed to Payment &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

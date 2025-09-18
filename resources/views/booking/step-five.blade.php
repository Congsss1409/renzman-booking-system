@extends('layouts.booking')

@section('content')
<form action="{{ route('booking.store.step-five') }}" method="POST">
    @csrf
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Review & Confirm</h2>
        <p class="text-gray-500">Please confirm your appointment details.</p>
    </div>

    <!-- Booking Summary -->
    <div class="bg-gray-50 border border-gray-200 rounded-lg p-6 space-y-4">
        <div class="flex justify-between items-center">
            <span class="text-gray-600">Service:</span>
            <span class="font-semibold text-gray-900">{{ $service->name }}</span>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-gray-600">Therapist:</span>
            <span class="font-semibold text-gray-900">{{ $therapist->name }}</span>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-gray-600">Location:</span>
            <span class="font-semibold text-gray-900">{{ $branch->name }}</span>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-gray-600">Date & Time:</span>
            <span class="font-semibold text-gray-900">
                {{ \Carbon\Carbon::parse($booking->date . ' ' . $booking->time)->format('F j, Y \a\t h:i A') }}
            </span>
        </div>
        <div class="border-t border-gray-200 my-4"></div>
        <div class="flex justify-between items-center text-xl">
            <span class="text-gray-600 font-medium">Total Price:</span>
            <span class="font-bold text-indigo-600">₱{{ number_format($service->price, 2) }}</span>
        </div>
    </div>

    <!-- Payment Method -->
    <div class="mt-8">
        <h3 class="text-lg font-medium text-gray-900">Payment Method</h3>
        <p class="text-sm text-gray-500 mb-4">Online payments require a 50% downpayment. The rest is payable on-site.</p>
        <div class="space-y-3">
             <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-indigo-500 hover:bg-indigo-50">
                <input type="radio" name="payment_method" value="On-Site" class="h-5 w-5 text-indigo-600 border-gray-300 focus:ring-indigo-500" required checked>
                <div class="ml-4">
                    <span class="font-semibold text-gray-800">Pay On-Site</span>
                    <span class="block text-sm text-gray-500">Pay the full amount in person.</span>
                </div>
            </label>
            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-indigo-500 hover:bg-indigo-50">
                <input type="radio" name="payment_method" value="GCash" class="h-5 w-5 text-indigo-600 border-gray-300 focus:ring-indigo-500" required>
                <div class="ml-4">
                    <span class="font-semibold text-gray-800">Pay with GCash</span>
                    <span class="block text-sm text-gray-500">Downpayment: ₱{{ number_format($service->price * 0.5, 2) }}</span>
                </div>
            </label>
            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-indigo-500 hover:bg-indigo-50">
                <input type="radio" name="payment_method" value="Maya" class="h-5 w-5 text-indigo-600 border-gray-300 focus:ring-indigo-500" required>
                <div class="ml-4">
                    <span class="font-semibold text-gray-800">Pay with Maya</span>
                    <span class="block text-sm text-gray-500">Downpayment: ₱{{ number_format($service->price * 0.5, 2) }}</span>
                </div>
            </label>
        </div>
    </div>
    
    <div class="mt-8 flex items-center justify-between">
        <a href="{{ route('booking.create.step-four') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-500">
            &larr; Back to Details
        </a>
        <button type="submit" class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
            </svg>
            Confirm Booking
        </button>
    </div>
</form>
@endsection

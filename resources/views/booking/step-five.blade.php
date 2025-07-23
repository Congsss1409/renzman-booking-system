{{-- resources/views/booking/step-five.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-2xl">
    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg">
        <h1 class="text-2xl sm:text-3xl font-bold text-center text-emerald-700 mb-8">Step 5: Complete Your Booking</h1>

        <!-- Updated Booking Summary -->
        <div class="bg-gray-50 p-6 rounded-lg border mb-8">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Payment Details</h2>
            <div class="space-y-3 text-gray-700">
                <div class="flex justify-between">
                    <span>Service:</span>
                    <span class="font-semibold">{{ $service->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Total Amount:</span>
                    <span class="font-semibold">₱{{ number_format($service->price, 2) }}</span>
                </div>
                <div class="flex justify-between text-emerald-600">
                    <span class="font-semibold">Required Downpayment (50%):</span>
                    <span class="font-bold">₱{{ number_format($service->price * 0.5, 2) }}</span>
                </div>
                <div class="flex justify-between border-t pt-3 mt-3">
                    <span class="text-lg font-bold">Remaining Balance (Pay On-Site):</span>
                    <span class="text-lg font-bold">₱{{ number_format($service->price * 0.5, 2) }}</span>
                </div>
            </div>
        </div>

        <form action="{{ route('booking.store.step-five') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-gray-700">Choose a Payment Method</h2>

                <!-- GCash Option -->
                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-emerald-500 transition has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-600">
                    <input type="radio" name="payment_method" value="GCash" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500">
                    <span class="ml-4 font-semibold text-lg text-gray-800">Pay Downpayment with GCash</span>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/GCash_logo.svg/1200px-GCash_logo.svg.png" class="h-6 ml-auto" alt="GCash Logo">
                </label>

                <!-- Maya Option -->
                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-emerald-500 transition has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-600">
                    <input type="radio" name="payment_method" value="Maya" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500">
                    <span class="ml-4 font-semibold text-lg text-gray-800">Pay Downpayment with Maya</span>
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Maya_logo.svg/1200px-Maya_logo.svg.png" class="h-8 ml-auto" alt="Maya Logo">
                </label>

                <!-- On-Site Option -->
                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-emerald-500 transition has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-600">
                    <input type="radio" name="payment_method" value="On-Site" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500">
                    <span class="ml-4 font-semibold text-lg text-gray-800">Pay Full Amount On-Site</span>
                </label>
            </div>
            
            @error('payment_method')
                <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror

            <div class="mt-8 flex justify-between items-center">
                <a href="{{ route('booking.create.step-four') }}" class="text-gray-600 hover:text-emerald-700">&larr; Back to Details</a>
                <button type="submit" class="bg-emerald-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
                    Complete Booking
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

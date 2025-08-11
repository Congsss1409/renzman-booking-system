{{-- resources/views/booking/step-five.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row">

    <div class="w-full md:w-1/3 bg-emerald-700 text-white p-8 flex flex-col justify-center">
        <div>
            <h1 class="text-3xl font-bold mb-4">Final Step: Payment</h1>
            <p class="text-emerald-100 mb-6">
                Please select your preferred payment method to secure your booking. A 50% downpayment is required for online payments.
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
                <div class="flex items-center opacity-50">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">4</span>
                    <span>Your Details</span>
                </div>
                <div class="flex items-center">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">5</span>
                    <span>Payment</span>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full md:w-2/3 bg-white p-8 lg:p-12 overflow-y-auto">
        <div class="max-w-2xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Step 5: Complete Your Booking</h2>
            
            <div class="bg-gray-50 p-6 rounded-lg border mb-8">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Payment Details</h3>
                <div class="space-y-3 text-gray-700">
                    <div class="flex justify-between"><span>Total Amount:</span><span class="font-semibold">₱{{ number_format($service->price, 2) }}</span></div>
                    <div class="flex justify-between text-emerald-600"><span class="font-semibold">Required Downpayment (50%):</span><span class="font-bold">₱{{ number_format($service->price * 0.5, 2) }}</span></div>
                    <div class="flex justify-between border-t pt-3 mt-3"><span class="text-lg font-bold">Remaining Balance (Pay On-Site):</span><span class="text-lg font-bold">₱{{ number_format($service->price * 0.5, 2) }}</span></div>
                </div>
            </div>

            <form action="{{ route('booking.store.step-five') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold text-gray-700">Choose a Payment Method</h3>
                    <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-emerald-500 transition has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-600">
                        <input type="radio" name="payment_method" value="GCash" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500">
                        <span class="ml-4 font-semibold text-lg text-gray-800">Pay Downpayment with GCash</span>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a2/GCash_logo.svg/1200px-GCash_logo.svg.png" class="h-6 ml-auto" alt="GCash Logo">
                    </label>
                    <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-emerald-500 transition has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-600">
                        <input type="radio" name="payment_method" value="Maya" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500">
                        <span class="ml-4 font-semibold text-lg text-gray-800">Pay Downpayment with Maya</span>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/9a/Maya_logo.svg/1200px-Maya_logo.svg.png" class="h-8 ml-auto" alt="Maya Logo">
                    </label>
                    <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-emerald-500 transition has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-600">
                        <input type="radio" name="payment_method" value="On-Site" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500">
                        <span class="ml-4 font-semibold text-lg text-gray-800">Pay Full Amount On-Site</span>
                    </label>
                </div>
                
                <div class="mt-10 flex justify-between items-center border-t pt-6">
                    <a href="{{ route('booking.create.step-four') }}" class="text-gray-600 hover:text-emerald-700 font-semibold">&larr; Go Back</a>
                    <button type="submit" class="bg-emerald-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
                        Complete Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.booking')

@section('content')
<form action="{{ route('booking.store.step-four') }}" method="POST">
    @csrf
    <h2 class="text-2xl font-bold text-gray-800">Your Contact Information</h2>
    <p class="mt-2 text-gray-600">We're almost there! Please provide your details below so we can send you a confirmation and keep you updated about your appointment.</p>

    <div class="mt-8 space-y-6">
        <div>
            <label for="client_name" class="block text-sm font-medium text-gray-700">Full Name</label>
            <input type="text" name="client_name" id="client_name" value="{{ old('client_name', $booking->client_name ?? '') }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm py-3 px-4">
            @error('client_name') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="client_email" class="block text-sm font-medium text-gray-700">Email Address</label>
            <input type="email" name="client_email" id="client_email" value="{{ old('client_email', $booking->client_email ?? '') }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm py-3 px-4">
            @error('client_email') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="client_phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input type="tel" name="client_phone" id="client_phone" value="{{ old('client_phone', $booking->client_phone ?? '') }}" required
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm py-3 px-4">
            @error('client_phone') <span class="text-sm text-red-500">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="mt-10 flex items-center justify-between">
        <a href="{{ route('booking.create.step-three') }}" class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-indigo-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Back to Date & Time
        </a>
        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Next: Confirm & Pay
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-3 -mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </button>
    </div>
</form>
@endsection
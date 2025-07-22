@extends('layouts.app')

@section('title', 'Step 4: Confirm Your Appointment')

@section('content')
    <div class="text-center mb-8">
        <div class="bg-[var(--brand-green)] rounded-full h-12 w-12 flex items-center justify-center mx-auto text-white font-bold text-xl">4</div>
        <h2 class="text-2xl font-bold mt-4 text-[var(--brand-dark)]">Confirm Your Appointment</h2>
        <p class="text-gray-600">Please review your details below.</p>
    </div>

    @if(session()->has('booking'))
        <div class="bg-[var(--brand-bg)] border border-gray-200 p-6 rounded-lg mb-8 space-y-3">
            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-3">Booking Summary</h3>
            <p><strong>Location:</strong> {{ session('booking.location') }}</p>
            <p><strong>Service:</strong> {{ session('booking.service_name') }}</p>
            <p><strong>Therapist:</strong> {{ session('booking.therapist_name') }}</p>
            <p><strong>Date:</strong> {{ \Carbon\Carbon::parse(session('booking.date'))->format('F j, Y') }}</p>
            <p><strong>Time:</strong> {{ session('booking.time') }}</p>
            <p class="text-xl font-bold mt-2"><strong>Total:</strong> ₱{{ number_format(session('booking.service_details.price'), 2) }}</p>
        </div>
    @endif

    <form action="{{ route('booking.store') }}" method="POST">
        @csrf
        <div class="space-y-6">
            <div>
                <label for="client_name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                <input type="text" id="client_name" name="client_name" required value="{{ old('client_name') }}"
                       class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[var(--brand-green)] sm:text-lg">
                @error('client_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="client_mobile" class="block text-sm font-medium text-gray-700 mb-1">Mobile Number</label>
                <input type="tel" id="client_mobile" name="client_mobile" required value="{{ old('client_mobile') }}"
                       class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[var(--brand-green)] sm:text-lg">
                @error('client_mobile')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="client_email" class="block text-sm font-medium text-gray-700 mb-1">Email Address (Optional)</label>
                <input type="email" id="client_email" name="client_email" value="{{ old('client_email') }}"
                       placeholder="For email confirmation"
                       class="mt-1 block w-full py-3 px-4 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[var(--brand-green)] sm:text-lg">
                @error('client_email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Payment Placeholder Section --}}
        <div class="mt-8">
             <h3 class="text-lg font-semibold text-gray-800 mb-3">Payment Method</h3>
             <div class="bg-[var(--brand-bg)] border border-gray-200 p-4 rounded-md text-center">
                <p class="text-sm text-gray-600">Secure payment gateway integration (GCash, Maya, etc.) would appear here.</p>
                <p class="text-xs text-gray-500 mt-2">For this prototype, payment is not required to book.</p>
             </div>
        </div>

        <button type="submit" class="w-full btn-primary font-bold py-3 px-4 rounded-md text-lg mt-8">
            Confirm & Book Appointment
        </button>
    </form>
@endsection

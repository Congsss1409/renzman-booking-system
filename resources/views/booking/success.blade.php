@extends('layouts.app')

@section('title', 'Booking Confirmed!')

@section('content')
    <div class="text-center">
        {{-- Success Icon --}}
        <svg class="mx-auto h-16 w-16 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>

        <h2 class="mt-4 text-3xl font-bold text-gray-800">Booking Confirmed!</h2>

        {{-- Check if booking details exist before displaying them --}}
        @if(isset($booking['client_name']))
            <p class="text-gray-600 mt-2">
                Thank you, <strong>{{ $booking['client_name'] }}</strong>. Your appointment is set.
            </p>
        @else
            <p class="text-gray-600 mt-2">
                Thank you! Your appointment is set.
            </p>
        @endif

        {{-- Display final booking summary --}}
        @if(isset($booking))
            <div class="bg-gray-50 border p-6 rounded-lg my-6 text-left space-y-3">
                <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-3">Final Details</h3>
                <p><strong>Location:</strong> {{ $booking['location'] ?? 'N/A' }}</p>
                <p><strong>Service:</strong> {{ $booking['service_name'] ?? 'N/A' }}</p>
                <p><strong>Date & Time:</strong> {{ isset($booking['date']) ? \Carbon\Carbon::parse($booking['date'])->format('F j, Y') : 'N/A' }} at {{ $booking['time'] ?? 'N/A' }}</p>
            </div>
        @endif

        <p class="text-sm text-gray-500">You will receive an SMS and Email confirmation shortly on the number provided.</p>

        <a href="{{ route('booking.stepOne') }}" class="mt-8 inline-block bg-blue-600 text-white font-bold py-3 px-4 rounded-md hover:bg-blue-700 transition-colors duration-200">
            Book Another Appointment
        </a>
    </div>
@endsection

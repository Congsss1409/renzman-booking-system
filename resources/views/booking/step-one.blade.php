@extends('layouts.booking')

@section('content')
<form action="{{ route('booking.store.step-one') }}" method="POST">
    @csrf
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Choose Your Service</h2>
        <p class="text-gray-500">Select a branch and a service to begin.</p>
    </div>

    @if (session('error'))
        <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
            {{ session('error') }}
        </div>
    @endif
    
    <div class="space-y-6">
        <!-- Branch Selection -->
        <div>
            <label for="branch_id" class="block text-sm font-medium text-gray-700 mb-1">Branch</label>
            <select name="branch_id" id="branch_id" required class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="" disabled {{ !isset($booking->branch_id) ? 'selected' : '' }}>Select a branch</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" {{ (isset($booking->branch_id) && $booking->branch_id == $branch->id) ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Service Selection -->
        <div>
            <label for="service_id" class="block text-sm font-medium text-gray-700 mb-1">Service</label>
            <select name="service_id" id="service_id" required class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="" disabled {{ !isset($booking->service_id) ? 'selected' : '' }}>Select a service</option>
                @foreach ($services as $service)
                    <option value="{{ $service->id }}" {{ (isset($booking->service_id) && $booking->service_id == $service->id) ? 'selected' : '' }}>
                        {{ $service->name }} ({{ $service->duration }} mins) - ₱{{ number_format($service->price, 2) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="mt-8 text-right">
        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Next: Choose Therapist
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-3 -mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </button>
    </div>
</form>
@endsection

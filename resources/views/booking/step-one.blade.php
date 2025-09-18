@extends('layouts.booking')

@section('content')
<form action="{{ route('booking.store.step-one') }}" method="POST">
    @csrf
    <h2 class="text-2xl font-bold text-gray-800">Start Your Journey</h2>
    <p class="mt-2 text-gray-600">To begin, please let us know which of our locations you'd like to visit and which of our rejuvenating services you are interested in today.</p>
    
    <div class="mt-8 space-y-6">
        <div>
            <label for="branch_id" class="block text-sm font-medium text-gray-700">Select Branch</label>
            <select name="branch_id" id="branch_id" required
                    class="mt-1 block w-full pl-4 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="" disabled {{ !isset($booking->branch_id) ? 'selected' : '' }}>Please select a branch</option>
                @foreach ($branches as $branch)
                    <option value="{{ $branch->id }}" {{ (isset($booking->branch_id) && $booking->branch_id == $branch->id) ? 'selected' : '' }}>
                        {{ $branch->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="service_id" class="block text-sm font-medium text-gray-700">Select Service</label>
            <select name="service_id" id="service_id" required
                    class="mt-1 block w-full pl-4 pr-10 py-3 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="" disabled {{ !isset($booking->service_id) ? 'selected' : '' }}>Please select a service</option>
                @foreach ($services as $service)
                    <option value="{{ $service->id }}" {{ (isset($booking->service_id) && $booking->service_id == $service->id) ? 'selected' : '' }}>
                        {{ $service->name }} ({{ $service->duration }} mins) - ₱{{ number_format($service->price, 2) }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="mt-10 text-right">
        <button type="submit"
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Next: Choose Therapist
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-3 -mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </button>
    </div>
</form>
@endsection
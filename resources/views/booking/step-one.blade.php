@extends('layouts.app')

@section('title', 'Step 1: Select Location')

@section('content')
    <div class="text-center mb-8">
        <div class="bg-[var(--brand-green)] rounded-full h-12 w-12 flex items-center justify-center mx-auto text-white font-bold text-xl">1</div>
        <h2 class="text-2xl font-bold mt-4 text-[var(--brand-dark)]">Select Your Branch</h2>
        <p class="text-gray-600">Choose your preferred location to begin.</p>
    </div>

    <form action="{{ route('booking.processStepOne') }}" method="POST">
        @csrf

        <div class="mb-6">
            <label for="location" class="sr-only">Our Locations</label>
            <select id="location" name="location" class="mt-1 block w-full py-3 px-4 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-[var(--brand-green)] focus:border-[var(--brand-green)] sm:text-lg">
                @foreach ($locations as $loc)
                    <option value="{{ $loc }}">{{ $loc }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="w-full btn-primary font-bold py-3 px-4 rounded-md text-lg">
            Next: Choose a Service
        </button>
    </form>
@endsection

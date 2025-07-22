@extends('layouts.app')

@section('title', 'Step 3: Select Therapist & Time')

@section('content')
    <div class="text-center mb-8">
        <div class="bg-[var(--brand-green)] rounded-full h-12 w-12 flex items-center justify-center mx-auto text-white font-bold text-xl">3</div>
        <h2 class="text-2xl font-bold mt-4 text-[var(--brand-dark)]">Choose Your Therapist & Time</h2>
        <p class="text-gray-600">Select an available time slot for today.</p>
    </div>

    <form action="{{ route('booking.processStepThree') }}" method="POST">
        @csrf
        <div class="space-y-8">
            {{-- Loop through each therapist --}}
            @foreach ($therapists as $therapist)
                <div>
                    <h3 class="text-xl font-bold text-[var(--brand-dark)]">{{ $therapist['name'] }}</h3>
                    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-3">
                        {{-- Loop through each available time for the therapist --}}
                        @foreach ($therapist['availability'] as $time)
                            <label class="has-[:checked]:bg-[var(--brand-green)] has-[:checked]:text-white has-[:checked]:border-transparent border border-gray-300 rounded-md py-3 px-2 text-center cursor-pointer transition-colors duration-200">
                                <input type="radio" name="therapist_time" value="{{ $therapist['id'] }}|{{ $therapist['name'] }}|{{ $time }}" class="sr-only">
                                <span class="font-medium">{{ $time }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        @error('therapist_time')
            <p class="text-red-500 text-sm mt-4 text-center">{{ $message }}</p>
        @enderror

        <button type="submit" class="w-full btn-primary font-bold py-3 px-4 rounded-md text-lg mt-8">
            Next: Confirm Details
        </button>
    </form>
@endsection

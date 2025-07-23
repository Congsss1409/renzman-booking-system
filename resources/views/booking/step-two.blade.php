{{-- resources/views/booking/step-two.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-2xl">
    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg">
        <h1 class="text-2xl sm:text-3xl font-bold text-center text-emerald-700 mb-2">Step 2: Choose Your Therapist</h1>
        <p class="text-center text-gray-600 mb-8">
            Therapists available at <span class="font-semibold">{{ $branch->name }}</span>
        </p>

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p class="font-bold">Please select a therapist to continue.</p>
            </div>
        @endif

        <form action="{{ route('booking.store.step-two') }}" method="POST">
            @csrf
            <div class="space-y-4">
                @forelse ($therapists as $therapist)
                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-emerald-500 transition has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-600">
                    <input type="radio" name="therapist_id" value="{{ $therapist->id }}" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500"
                        {{ (old('therapist_id', $booking->therapist_id ?? '') == $therapist->id) ? 'checked' : '' }}
                    >
                    <span class="ml-4 font-semibold text-lg text-gray-800">{{ $therapist->name }}</span>
                </label>
                @empty
                <p class="text-center text-gray-500">No therapists are available for this branch.</p>
                @endforelse
            </div>

            <div class="mt-8 flex justify-between items-center">
                <a href="{{ route('booking.create.step-one') }}" class="text-gray-600 hover:text-emerald-700">&larr; Back to Services</a>
                <button type="submit" class="bg-emerald-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
                    Next: Select Date & Time &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

{{-- resources/views/booking/step-two.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col md:flex-row">
    
    <div class="w-full md:w-1/3 bg-emerald-700 text-white p-8 flex flex-col justify-center">
        <div>
            <h1 class="text-3xl font-bold mb-4">Select a Therapist</h1>
            <p class="text-emerald-100 mb-6">
                Choose one of our certified therapists available at your selected branch. You can see their current status to help you decide.
            </p>
            <div class="border-t border-emerald-500 pt-6 space-y-4 text-emerald-200">
                <div class="flex items-center opacity-50">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">1</span>
                    <span>Branch & Service</span>
                </div>
                <div class="flex items-center">
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
                <div class="flex items-center opacity-50">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">5</span>
                    <span>Payment</span>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full md:w-2/3 bg-white p-8 lg:p-12 overflow-y-auto">
        <div class="max-w-3xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-2">Step 2: Choose Your Therapist</h2>
            <p class="text-gray-600 mb-8">
                Therapists available at <span class="font-semibold">{{ $branch->name }}</span>
            </p>

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
                    <p class="font-bold">Please select a therapist to continue.</p>
                </div>
            @endif

            <form action="{{ route('booking.store.step-two') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 border-t pt-4">
                    @forelse ($therapists as $therapist)
                    <label class="relative flex flex-col items-center p-4 border rounded-lg cursor-pointer hover:border-emerald-500 transition has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-600 has-[:checked]:ring-2 has-[:checked]:ring-emerald-500">
                        <input type="radio" name="therapist_id" value="{{ $therapist->id }}" class="absolute top-4 right-4 h-5 w-5 text-emerald-600 focus:ring-emerald-500"
                            {{ (old('therapist_id', $booking->therapist_id ?? '') == $therapist->id) ? 'checked' : '' }}
                        >
                        <img class="w-24 h-24 rounded-full mb-4" src="{{ $therapist->image_url }}" alt="Photo of {{ $therapist->name }}">
                        <span class="font-semibold text-lg text-gray-800 text-center">{{ $therapist->name }}</span>
                        
                        {{-- Status Indicator --}}
                        @if ($therapist->status == 'Available')
                            <div class="mt-2 text-xs font-semibold text-emerald-800 bg-emerald-100 px-2 py-1 rounded-full">
                                Available Now
                            </div>
                        @else
                            <div class="mt-2 text-xs font-semibold text-red-800 bg-red-100 px-2 py-1 rounded-full">
                                In Session
                            </div>
                            <span class="text-xs text-gray-500 mt-1">Free at {{ $therapist->available_at }}</span>
                        @endif
                    </label>
                    @empty
                    <p class="col-span-full text-center text-gray-500">No therapists are available for this branch.</p>
                    @endforelse
                </div>

                <div class="mt-10 flex justify-between items-center border-t pt-6">
                    <a href="{{ route('booking.create.step-one') }}" class="text-gray-600 hover:text-emerald-700 font-semibold">&larr; Go Back</a>
                    <button type="submit" class="bg-emerald-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
                        Next: Select Date & Time &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

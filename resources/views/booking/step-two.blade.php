@extends('layouts.booking')

@section('content')
<form action="{{ route('booking.store.step-two') }}" method="POST">
    @csrf
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Select a Therapist</h2>
        <p class="text-gray-500">Choose from our available professionals at {{ $branch->name }}.</p>
    </div>

    @if (session('error'))
        <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-4">
        @forelse($therapists as $therapist)
            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:border-indigo-500 hover:bg-indigo-50 transition-all">
                <input type="radio" name="therapist_id" value="{{ $therapist->id }}" class="h-5 w-5 text-indigo-600 border-gray-300 focus:ring-indigo-500" required {{ (isset($booking->therapist_id) && $booking->therapist_id == $therapist->id) ? 'checked' : '' }}>
                <div class="ml-4 flex items-center">
                     @if ($therapist->image)
                        <img class="h-16 w-16 rounded-full object-cover" src="{{ Storage::url($therapist->image) }}" alt="{{ $therapist->name }}">
                    @else
                        <span class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center">
                            <svg class="h-10 w-10 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    @endif
                    <div class="ml-4">
                        <span class="text-lg font-semibold text-gray-800">{{ $therapist->name }}</span>
                        @if ($therapist->current_status == 'Available')
                            <span class="block text-sm text-green-600">Available Now</span>
                        @else
                            <span class="block text-sm text-red-600">{{ $therapist->current_status }}</span>
                            @if($therapist->available_at)
                                <span class="block text-xs text-gray-500">Available at {{ $therapist->available_at }}</span>
                            @endif
                        @endif
                    </div>
                </div>
            </label>
        @empty
            <div class="text-center py-10">
                <p class="text-gray-500">No therapists are currently available for this branch.</p>
            </div>
        @endforelse
    </div>
    
    <div class="mt-8 flex items-center justify-between">
        <a href="{{ route('booking.create.step-one') }}" class="text-sm font-medium text-gray-600 hover:text-indigo-500">
            &larr; Back to Services
        </a>
        <button type="submit" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Next: Select Date
            <svg xmlns="http://www.w3.org/2000/svg" class="ml-3 -mr-1 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
            </svg>
        </button>
    </div>
</form>
@endsection

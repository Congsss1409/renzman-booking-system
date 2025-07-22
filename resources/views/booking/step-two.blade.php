@extends('layouts.app')

@section('title', 'Step 2: Select Service')

@section('content')
    <div class="text-center mb-8">
        <div class="bg-[var(--brand-green)] rounded-full h-12 w-12 flex items-center justify-center mx-auto text-white font-bold text-xl">2</div>
        <h2 class="text-2xl font-bold mt-4 text-[var(--brand-dark)]">Choose Your Service</h2>
        @if(session()->has('booking.location'))
            <p class="text-gray-600">
                For branch: <strong>{{ session('booking.location') }}</strong>
            </p>
        @endif
    </div>

    <form action="{{ route('booking.processStepTwo') }}" method="POST">
        @csrf
        <div class="space-y-6">
            @foreach ($services as $category => $service_list)
                <div>
                    <h3 class="text-xl font-bold text-gray-800 border-b pb-2 mb-4">{{ $category }}</h3>
                    <div class="space-y-3">
                        @foreach ($service_list as $name => $details)
                            <label class="flex items-center justify-between p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition-colors duration-200 has-[:checked]:bg-[var(--brand-bg)] has-[:checked]:border-[var(--brand-green)] has-[:checked]:ring-2 has-[:checked]:ring-[var(--brand-green)]">
                                <div>
                                    <span class="font-bold text-lg text-gray-800">{{ $name }}</span>
                                    <span class="block text-sm text-gray-500">{{ $details['duration'] }} mins - ₱{{ number_format($details['price'], 2) }}</span>
                                </div>
                                <input type="radio" name="service" value="{{ $category . '|' . $name }}" required class="h-5 w-5 text-[var(--brand-green)] border-gray-300 focus:ring-[var(--brand-green)]">
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        @error('service')
            <p class="text-red-500 text-sm mt-4 text-center">{{ $message }}</p>
        @enderror

        <button type="submit" class="w-full btn-primary font-bold py-3 px-4 rounded-md text-lg mt-8">
            Next: Select Therapist & Time
        </button>
    </form>
@endsection

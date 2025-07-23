{{-- resources/views/booking/step-one.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 sm:p-6 lg:p-8 max-w-2xl">
    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-lg">
        <h1 class="text-2xl sm:text-3xl font-bold text-center text-emerald-700 mb-8">Step 1: Choose Branch & Service</h1>
        <form action="{{ route('booking.store.step-one') }}" method="POST">
            @csrf
            <div class="mb-8">
                <h2 class="text-xl font-semibold mb-3 text-gray-700">1. Choose a Branch</h2>
                <select name="branch_id" class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition bg-white">
                    <option value="" disabled selected>Select a branch location</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" {{ (old('branch_id', $booking->branch_id ?? '') == $branch->id) ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <h2 class="text-xl font-semibold mb-3 text-gray-700">2. Choose a Service</h2>
                <div class="space-y-4">
                    @foreach ($services as $service)
                    <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-emerald-500 transition has-[:checked]:bg-emerald-50 has-[:checked]:border-emerald-600">
                        <input type="radio" name="service_id" value="{{ $service->id }}" class="h-5 w-5 text-emerald-600 focus:ring-emerald-500"
                            {{ (old('service_id', $booking->service_id ?? '') == $service->id) ? 'checked' : '' }}
                        >
                        <span class="ml-4 flex flex-col">
                            <span class="font-semibold text-lg text-gray-800">{{ $service->name }}</span>
                            <span class="text-gray-600">{{ $service->duration }} minutes</span>
                        </span>
                        <span class="ml-auto font-bold text-xl text-emerald-600">₱{{ number_format($service->price, 2) }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-emerald-600 text-white font-bold py-3 px-6 rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
                    Next: Select Therapist &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

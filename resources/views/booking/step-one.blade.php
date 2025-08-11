{{-- resources/views/booking/step-one.blade.php --}}
@extends('layouts.app')

@section('content')
{{-- We remove the container class to allow the layout to be full-width --}}
<div class="min-h-screen flex flex-col md:flex-row">
    
    <div class="w-full md:w-1/3 bg-emerald-700 text-white p-8 flex flex-col justify-center">
        <div>
            <h1 class="text-3xl font-bold mb-4">Start Your Journey to Relaxation</h1>
            <p class="text-emerald-100 mb-6">
                Please select your preferred branch and the service you would like to book. Our system will then find an available therapist for you.
            </p>
            <div class="border-t border-emerald-500 pt-6 space-y-4 text-emerald-200">
                <div class="flex items-center">
                    <span class="bg-emerald-500 text-white rounded-full h-6 w-6 text-sm flex items-center justify-center font-bold mr-3">1</span>
                    <span>Branch & Service</span>
                </div>
                <div class="flex items-center opacity-50">
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
        <div class="max-w-2xl mx-auto">
            <h2 class="text-2xl font-bold text-gray-800 mb-8">Step 1: Choose Branch & Service</h2>
            
            <form action="{{ route('booking.store.step-one') }}" method="POST">
                @csrf
                <div class="mb-8">
                    <label for="branch_id" class="block text-sm font-medium text-gray-700 mb-2">1. Choose a Branch</label>
                    <select name="branch_id" id="branch_id" required class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition bg-white">
                        <option value="" disabled selected>Select a branch location</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" {{ (old('branch_id', $booking->branch_id ?? '') == $branch->id) ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">2. Choose a Service</label>
                    <div class="space-y-4 max-h-[50vh] overflow-y-auto pr-2 border-t pt-4">
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

                <div class="mt-10 flex justify-end border-t pt-6">
                    <button type="submit" class="bg-emerald-600 text-white font-bold py-3 px-8 rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
                        Next: Select Therapist &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

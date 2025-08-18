{{-- resources/views/admin/create-booking.blade.php --}}
@extends('layouts.admin')

@section('header', 'Create New Booking')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">New Appointment Details</h2>

    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
            <p class="font-bold">Please correct the following errors:</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.bookings.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4">Client Information</h3>
            </div>
            <div>
                <label for="client_name" class="block text-sm font-medium text-gray-700">Client Full Name</label>
                <input type="text" name="client_name" id="client_name" value="{{ old('client_name') }}" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div>
                <label for="client_phone" class="block text-sm font-medium text-gray-700">Client Phone Number</label>
                <input type="tel" name="client_phone" id="client_phone" value="{{ old('client_phone') }}" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
            </div>

            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold text-gray-700 border-b pb-2 mb-4 mt-6">Appointment Details</h3>
            </div>
            <div>
                <label for="branch_id" class="block text-sm font-medium text-gray-700">Branch</label>
                <select name="branch_id" id="branch_id" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                    <option value="">Select a Branch</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="therapist_id" class="block text-sm font-medium text-gray-700">Therapist</label>
                <select name="therapist_id" id="therapist_id" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 bg-white" disabled>
                    <option value="">Select a branch first</option>
                </select>
            </div>
            <div class="md:col-span-2">
                <label for="service_id" class="block text-sm font-medium text-gray-700">Service</label>
                <select name="service_id" id="service_id" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500 bg-white">
                    <option value="">Select a Service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }} ({{ $service->duration }} min)</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="booking_date" class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="booking_date" id="booking_date" value="{{ old('booking_date', now()->format('Y-m-d')) }}" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
            </div>
            <div>
                <label for="booking_time" class="block text-sm font-medium text-gray-700">Time</label>
                <input type="time" name="booking_time" id="booking_time" value="{{ old('booking_time') }}" required class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-4">
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 text-gray-800 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors">
                Cancel
            </a>
            <button type="submit" class="bg-emerald-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
                Create Booking
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const branchSelect = document.getElementById('branch_id');
    const therapistSelect = document.getElementById('therapist_id');
    const dateInput = document.getElementById('booking_date');
    const timeInput = document.getElementById('booking_time');

    // --- Logic for therapist dropdown ---
    branchSelect.addEventListener('change', function () {
        const branchId = this.value;
        therapistSelect.innerHTML = '<option value="">Loading...</option>';
        therapistSelect.disabled = true;

        if (branchId) {
            fetch(`/admin/branches/${branchId}/therapists`)
                .then(response => response.json())
                .then(data => {
                    therapistSelect.innerHTML = '<option value="">Select a Therapist</option>';
                    data.forEach(therapist => {
                        const option = document.createElement('option');
                        option.value = therapist.id;
                        option.textContent = therapist.name;
                        therapistSelect.appendChild(option);
                    });
                    therapistSelect.disabled = false;
                });
        } else {
            therapistSelect.innerHTML = '<option value="">Select a branch first</option>';
        }
    });

    // --- NEW: Logic for dynamic time input ---
    function updateMinTime() {
        const today = new Date();
        const selectedDate = new Date(dateInput.value);
        
        // Check if the selected date is today
        if (selectedDate.toDateString() === today.toDateString()) {
            // Format the current time to HH:MM for the min attribute
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            timeInput.min = `${hours}:${minutes}`;
        } else {
            // If it's a future date, remove the min attribute
            timeInput.min = '';
        }
    }

    // Add event listener to the date input
    dateInput.addEventListener('change', updateMinTime);

    // Run the function once on page load
    updateMinTime();
});
</script>
@endsection

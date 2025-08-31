@extends('layouts.admin')

@section('title', 'Create New Booking')

@section('content')
<div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-4xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Create a New Booking</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Oops!</strong>
            <span class="block sm:inline">There were some problems with your input.</span>
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
            
            <!-- Client Information -->
            <div class="md:col-span-2">
                <h3 class="text-lg font-semibold border-b pb-2 mb-4">Client Details</h3>
            </div>
            <div>
                <label for="client_name" class="block text-sm font-medium text-gray-700">Client Name</label>
                <input type="text" name="client_name" id="client_name" value="{{ old('client_name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
            </div>
            <div>
                <label for="client_email" class="block text-sm font-medium text-gray-700">Client Email</label>
                <input type="email" name="client_email" id="client_email" value="{{ old('client_email') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
            </div>
            <div>
                <label for="client_phone" class="block text-sm font-medium text-gray-700">Client Phone</label>
                <input type="text" name="client_phone" id="client_phone" value="{{ old('client_phone') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
            </div>

            <!-- Booking Details -->
            <div class="md:col-span-2 mt-6">
                <h3 class="text-lg font-semibold border-b pb-2 mb-4">Booking Details</h3>
            </div>
            <div>
                <label for="branch_id" class="block text-sm font-medium text-gray-700">Branch</label>
                <select name="branch_id" id="branch_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                    <option value="">Select a Branch</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="service_id" class="block text-sm font-medium text-gray-700">Service</label>
                <select name="service_id" id="service_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
                    <option value="">Select a Service</option>
                    @foreach($services as $service)
                        <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }} ({{ $service->duration }} mins)</option>
                    @endforeach
                </select>
            </div>
            <div>
                {{-- *** FIX: Therapist dropdown is now dynamic *** --}}
                <label for="therapist_id" class="block text-sm font-medium text-gray-700">Therapist</label>
                <select name="therapist_id" id="therapist_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm" disabled>
                    <option value="">Select a branch first</option>
                </select>
            </div>
            <div>
                <label for="booking_date" class="block text-sm font-medium text-gray-700">Date</label>
                <input type="date" name="booking_date" id="booking_date" value="{{ old('booking_date') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
            </div>
            <div>
                <label for="booking_time" class="block text-sm font-medium text-gray-700">Time</label>
                <input type="time" name="booking_time" id="booking_time" value="{{ old('booking_time') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm">
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md mr-2 hover:bg-gray-300">Cancel</a>
            <button type="submit" class="bg-emerald-600 text-white px-4 py-2 rounded-md hover:bg-emerald-700">Create Booking</button>
        </div>
    </form>
</div>

{{-- *** FIX: Added JavaScript for dynamic therapist dropdown *** --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const branchSelect = document.getElementById('branch_id');
    const therapistSelect = document.getElementById('therapist_id');

    branchSelect.addEventListener('change', function () {
        const branchId = this.value;
        therapistSelect.innerHTML = '<option value="">Loading...</option>';
        therapistSelect.disabled = true;

        if (!branchId) {
            therapistSelect.innerHTML = '<option value="">Select a branch first</option>';
            return;
        }

        // The route name here must match the one in your web.php
        // e.g., Route::get('/branches/{branch}/therapists', [AdminController::class, 'getTherapistsByBranch'])->name('admin.branches.therapists');
        const url = `/admin/branches/${branchId}/therapists`;

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(therapists => {
                therapistSelect.innerHTML = '<option value="">Select a Therapist</option>';
                therapists.forEach(therapist => {
                    const option = document.createElement('option');
                    option.value = therapist.id;
                    option.textContent = therapist.name;
                    therapistSelect.appendChild(option);
                });
                therapistSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error fetching therapists:', error);
                therapistSelect.innerHTML = '<option value="">Could not load therapists</option>';
            });
    });

    // If a branch was already selected (e.g., due to a validation error page reload),
    // trigger the change event to populate the therapists.
    if (branchSelect.value) {
        branchSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection

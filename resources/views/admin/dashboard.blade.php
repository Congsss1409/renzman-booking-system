@extends('layouts.admin')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">All Bookings</h2>
    {{-- This button now opens the modal --}}
    <button id="open-booking-modal" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-lg">
        Create New Booking
    </button>
</div>

<div class="bg-white p-6 rounded-lg shadow-lg">
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    {{-- Sorting headers from our previous implementation --}}
                    @php
                        function render_sortable_header($label, $column_name, $sortBy, $sortOrder) {
                            $order = ($sortBy == $column_name && $sortOrder == 'asc') ? 'desc' : 'asc';
                            $arrow = $sortBy == $column_name ? ($sortOrder == 'asc' ? '▲' : '▼') : '';
                            $url = route('admin.dashboard', ['sort_by' => $column_name, 'sort_order' => $order]);
                            echo "<th class='text-left py-3 px-4 uppercase font-semibold text-sm'><a href='{$url}'>{$label} <span class='text-xs'>{$arrow}</span></a></th>";
                        }
                    @endphp
                    {!! render_sortable_header('Client Name', 'client_name', $sortBy, $sortOrder) !!}
                    {!! render_sortable_header('Service', 'service_name', $sortBy, $sortOrder) !!}
                    {!! render_sortable_header('Therapist', 'therapist_name', $sortBy, $sortOrder) !!}
                    {!! render_sortable_header('Branch', 'branch_name', $sortBy, $sortOrder) !!}
                    {!! render_sortable_header('Date & Time', 'start_time', $sortBy, $sortOrder) !!}
                    {!! render_sortable_header('Status', 'status', $sortBy, $sortOrder) !!}
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                </tr>
            </thead>
            <tbody id="bookings-table-body" class="text-gray-700">
                @forelse ($bookings as $booking)
                    <tr class="border-b hover:bg-gray-100">
                        <td class="py-3 px-4">{{ $booking->client_name }}</td>
                        <td class="py-3 px-4">{{ optional($booking->service)->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4">{{ optional($booking->therapist)->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4">{{ optional($booking->branch)->name ?? 'N/A' }}</td>
                        <td class="py-3 px-4">{{ $booking->start_time->format('M d, Y @ h:i A') }}</td>
                        <td class="py-3 px-4">
                             <span class="px-2 py-1 text-xs font-semibold rounded-full
                                @if($booking->status == 'Confirmed') bg-green-200 text-green-800
                                @elseif($booking->status == 'Completed') bg-blue-200 text-blue-800
                                @elseif($booking->status == 'Cancelled') bg-red-200 text-red-800
                                @else bg-yellow-200 text-yellow-800 @endif">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            {{-- The Edit link has been removed --}}
                            <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800">Cancel</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr id="no-bookings-row">
                        <td colspan="7" class="text-center py-6 text-gray-500">No bookings found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $bookings->appends(request()->query())->links() }}
    </div>
</div>

{{-- MODAL FOR CREATING A NEW BOOKING --}}
<div id="booking-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
        <div class="flex justify-between items-center pb-3 border-b">
            <p class="text-2xl font-bold">Create New Booking</p>
            <button id="close-booking-modal" class="cursor-pointer z-50">
                <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"><path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path></svg>
            </button>
        </div>
        <div class="mt-5">
            <form action="{{ route('admin.bookings.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="client_name" class="block text-sm font-medium text-gray-700">Client Name</label>
                        <input type="text" name="client_name" id="client_name" value="{{ old('client_name') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                        @error('client_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="client_phone" class="block text-sm font-medium text-gray-700">Client Phone</label>
                        <input type="text" name="client_phone" id="client_phone" value="{{ old('client_phone') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                        @error('client_phone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="client_email" class="block text-sm font-medium text-gray-700">Client Email</label>
                        <input type="email" name="client_email" id="client_email" value="{{ old('client_email') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                        @error('client_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="branch_id" class="block text-sm font-medium text-gray-700">Branch</label>
                        <select name="branch_id" id="branch_id_modal" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Select Branch</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>{{ $branch->name }}</option>
                            @endforeach
                        </select>
                        @error('branch_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="therapist_id" class="block text-sm font-medium text-gray-700">Therapist</label>
                        <select name="therapist_id" id="therapist_id_modal" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500" disabled>
                            <option value="">Select branch first</option>
                        </select>
                        @error('therapist_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                     <div class="md:col-span-2">
                        <label for="service_id" class="block text-sm font-medium text-gray-700">Service</label>
                        <select name="service_id" id="service_id_modal" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Select Service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }} ({{$service->duration}} mins)</option>
                            @endforeach
                        </select>
                        @error('service_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                     <div>
                        <label for="booking_date" class="block text-sm font-medium text-gray-700">Date</label>
                        <input type="date" name="booking_date" id="booking_date" value="{{ old('booking_date') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                        @error('booking_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                     <div>
                        <label for="booking_time" class="block text-sm font-medium text-gray-700">Time</label>
                        <input type="time" name="booking_time" id="booking_time" value="{{ old('booking_time') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                        @error('booking_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="mt-6 pt-4 border-t flex justify-end">
                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded-lg">Save Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('booking-modal');
    const openBtn = document.getElementById('open-booking-modal');
    const closeBtn = document.getElementById('close-booking-modal');

    openBtn.addEventListener('click', () => modal.classList.remove('hidden'));
    closeBtn.addEventListener('click', () => modal.classList.add('hidden'));

    modal.addEventListener('click', (e) => {
        if (e.target.id === 'booking-modal') {
            modal.classList.add('hidden');
        }
    });

    @if(session('show_modal') && $errors->any())
        modal.classList.remove('hidden');
    @endif

    const branchSelect = document.getElementById('branch_id_modal');
    const therapistSelect = document.getElementById('therapist_id_modal');
    
    branchSelect.addEventListener('change', function () {
        const branchId = this.value;
        therapistSelect.innerHTML = '<option value="">Loading...</option>';
        therapistSelect.disabled = true;

        if (branchId) {
            fetch(`/admin/branches/${branchId}/therapists`)
                .then(response => response.json())
                .then(data => {
                    therapistSelect.innerHTML = '<option value="">Select Therapist</option>';
                    data.forEach(therapist => {
                        const option = document.createElement('option');
                        option.value = therapist.id;
                        option.textContent = therapist.name;
                        therapistSelect.appendChild(option);
                    });
                    therapistSelect.disabled = false;
                });
        }
    });
});
</script>
@endsection


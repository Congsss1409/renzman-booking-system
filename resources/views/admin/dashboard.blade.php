{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('header', 'Appointments Dashboard')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">All Bookings</h2>
        <a href="{{ route('admin.bookings.create') }}" class="bg-emerald-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-emerald-700 transition-colors shadow-md">
            + New Booking
        </a>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Client & Contact</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Service & Branch</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Date & Time</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Therapist</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Status</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                </tr>
            </thead>
            {{-- Give the table body an ID so we can add rows to it --}}
            <tbody class="text-gray-700" id="booking-table-body">
                @forelse ($bookings as $booking)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">
                            <div class="font-semibold">{{ $booking->client_name }}</div>
                            <div class="text-sm text-gray-500">{{ $booking->client_phone }}</div>
                        </td>
                        <td class="py-3 px-4">
                            <div>{{ $booking->service->name }}</div>
                            <div class="text-sm text-gray-500">at {{ $booking->branch->name ?? 'N/A' }}</div>
                        </td>
                        <td class="py-3 px-4">{{ \Carbon\Carbon::parse($booking->start_time)->format('M j, Y - g:i A') }}</td>
                        <td class="py-3 px-4">{{ $booking->therapist->name ?? 'Not Assigned' }}</td>
                        <td class="py-3 px-4">
                            <span class="bg-emerald-200 text-emerald-800 py-1 px-3 rounded-full text-xs font-semibold">{{ $booking->status }}</span>
                        </td>
                        <td class="py-3 px-4 flex items-center space-x-4">
                            <a href="{{ route('admin.bookings.edit', $booking) }}" class="text-blue-500 hover:text-blue-700 font-semibold">Edit</a>
                            @if($booking->status == 'Confirmed')
                                <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr id="no-bookings-row">
                        <td colspan="6" class="text-center py-4">No bookings have been made yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
function addNewBookingRow(booking) {
    const tableBody = document.getElementById('booking-table-body');
    const noBookingsRow = document.getElementById('no-bookings-row');

    // Remove the "No bookings" message if it exists
    if (noBookingsRow) {
        noBookingsRow.remove();
    }

    // Create a new row element
    const newRow = document.createElement('tr');
    newRow.className = 'border-b hover:bg-gray-50 new-booking-row';

    // Format the date using JavaScript to match the PHP format
    const date = new Date(booking.start_time);
    const formattedDate = date.toLocaleString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
        hour: 'numeric',
        minute: '2-digit',
        hour12: true
    }).replace(',', ' -');

    // Populate the inner HTML of the new row
    newRow.innerHTML = `
        <td class="py-3 px-4">
            <div class="font-semibold">${booking.client_name}</div>
            <div class="text-sm text-gray-500">${booking.client_phone}</div>
        </td>
        <td class="py-3 px-4">
            <div>${booking.service.name}</div>
            <div class="text-sm text-gray-500">at ${booking.branch.name}</div>
        </td>
        <td class="py-3 px-4">${formattedDate}</td>
        <td class="py-3 px-4">${booking.therapist.name}</td>
        <td class="py-3 px-4">
            <span class="bg-emerald-200 text-emerald-800 py-1 px-3 rounded-full text-xs font-semibold">${booking.status}</span>
        </td>
        <td class="py-3 px-4 flex items-center space-x-4">
            <a href="/admin/bookings/${booking.id}/edit" class="text-blue-500 hover:text-blue-700 font-semibold">Edit</a>
            <form action="/admin/bookings/${booking.id}/cancel" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Cancel</button>
            </form>
        </td>
    `;

    // Add the new row to the top of the table
    tableBody.prepend(newRow);
}
</script>
@endsection

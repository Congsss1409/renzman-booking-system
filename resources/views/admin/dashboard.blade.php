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
            <tbody class="text-gray-700">
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
                            @if($booking->status == 'Confirmed')
                                <span class="bg-emerald-200 text-emerald-800 py-1 px-3 rounded-full text-xs font-semibold">{{ $booking->status }}</span>
                            @elseif($booking->status == 'Cancelled')
                                <span class="bg-red-200 text-red-800 py-1 px-3 rounded-full text-xs font-semibold">{{ $booking->status }}</span>
                            @else
                                <span class="bg-gray-200 text-gray-800 py-1 px-3 rounded-full text-xs font-semibold">{{ $booking->status }}</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 flex items-center space-x-4">
                            <a href="{{ route('admin.bookings.edit', $booking) }}" class="text-blue-500 hover:text-blue-700 font-semibold">Edit</a>
                            @if($booking->status == 'Confirmed')
                                <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST" class="cancel-form">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-semibold">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">No bookings have been made yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
// SweetAlert2 confirmation for cancellation
document.querySelectorAll('.cancel-form').forEach(form => {
    form.addEventListener('submit', function (event) {
        event.preventDefault(); // Stop the form from submitting immediately
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#10B981',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit(); // If confirmed, submit the form
            }
        })
    });
});
</script>
@endsection

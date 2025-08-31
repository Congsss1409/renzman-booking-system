@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    {{-- *** FIX: Re-added "Create New Booking" button *** --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">All Bookings</h2>
        <a href="{{ route('admin.bookings.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded">
            Create New Booking
        </a>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Client Name</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Service</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Therapist</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Branch</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Date & Time</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Status</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($bookings as $booking)
                    <tr class="border-b">
                        <td class="py-3 px-4">{{ $booking->client_name }}</td>
                        <td class="py-3 px-4">{{ $booking->service->name }}</td>
                        <td class="py-3 px-4">{{ $booking->therapist->name }}</td>
                        <td class="py-3 px-4">{{ $booking->branch->name }}</td>
                        <td class="py-3 px-4">{{ $booking->start_time->format('M d, Y, g:i A') }}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $booking->status == 'Confirmed' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $booking->status == 'Cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $booking->status == 'Completed' ? 'bg-blue-100 text-blue-800' : '' }}">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                             @if ($booking->status !== 'Cancelled')
                                <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this booking?');">
                                    @csrf
                                    <button type="submit" class="text-red-500 hover:text-red-700">Cancel</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">No bookings found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $bookings->links() }}
    </div>
</div>
@endsection


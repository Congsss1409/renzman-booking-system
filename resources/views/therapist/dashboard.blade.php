{{-- resources/views/therapist/dashboard.blade.php --}}
@extends('layouts.therapist')

@section('header', 'My Upcoming Schedule')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Upcoming Appointments for {{ $therapist->name }}</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Date & Time</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Client Name</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Service</th>
                    <th class="text-left py-3 px-4 uppercase font-semibold text-sm">Branch</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @forelse ($bookings as $booking)
                    <tr class="border-b">
                        <td class="py-3 px-4 font-semibold">{{ $booking->start_time->format('M j, Y - g:i A') }}</td>
                        <td class="py-3 px-4">{{ $booking->client_name }}</td>
                        <td class="py-3 px-4">{{ $booking->service->name }}</td>
                        <td class="py-3 px-4">{{ $booking->branch->name }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-8 text-gray-500">You have no upcoming appointments.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

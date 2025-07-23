{{-- resources/views/admin/analytics.blade.php --}}
@extends('layouts.admin')

@section('header', 'Analytics & Reports')

@section('content')
<div>
    <!-- KPIs Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <h3 class="text-lg font-semibold text-gray-500">Total Bookings</h3>
            <p class="text-4xl font-bold text-emerald-600 mt-2">{{ $totalBookings }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <h3 class="text-lg font-semibold text-gray-500">Total Revenue</h3>
            <p class="text-4xl font-bold text-emerald-600 mt-2">₱{{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow-lg text-center">
            <h3 class="text-lg font-semibold text-gray-500">Average Rating</h3>
            <div class="flex items-center justify-center mt-2">
                <p class="text-4xl font-bold text-emerald-600 mr-2">{{ number_format($averageRating, 2) }}</p>
                <span class="text-2xl text-yellow-400">&#9733;</span>
            </div>
        </div>
    </div>

    <!-- Reports Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Most Popular Services -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Most Popular Services</h3>
            <ul class="space-y-3">
                @forelse($popularServices as $item)
                    <li class="flex justify-between items-center text-gray-700">
                        <span>{{ $item->service->name }}</span>
                        <span class="font-semibold bg-gray-200 px-3 py-1 rounded-full text-sm">{{ $item->total }} bookings</span>
                    </li>
                @empty
                    <p class="text-gray-500">No services have been booked yet.</p>
                @endforelse
            </ul>
        </div>

        <!-- Busiest Therapists -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Busiest Therapists</h3>
            <ul class="space-y-3">
                @forelse($busiestTherapists as $item)
                    <li class="flex justify-between items-center text-gray-700">
                        <span>{{ $item->therapist->name }}</span>
                        <span class="font-semibold bg-gray-200 px-3 py-1 rounded-full text-sm">{{ $item->total }} bookings</span>
                    </li>
                @empty
                    <p class="text-gray-500">No therapists have completed bookings yet.</p>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
    
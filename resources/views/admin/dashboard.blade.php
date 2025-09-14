@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="p-4 sm:p-6 lg:p-8 space-y-8">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">Dashboard</h2>
            <p class="mt-1.5 text-sm text-gray-500">Welcome back, Admin! Here's your business overview. ✨</p>
        </div>
        <div class="mt-4 sm:mt-0">
             <button onclick="document.getElementById('createBookingModal').showModal()" class="inline-flex items-center justify-center w-full px-5 py-3 text-sm font-medium text-white bg-indigo-600 rounded-lg shadow-sm hover:bg-indigo-700 sm:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 -ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                New Booking
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <div class="p-6 bg-white border border-gray-200 rounded-xl">
            <p class="text-sm font-medium text-gray-500">Total Revenue</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">₱{{ number_format($dashboardData['totalRevenue'], 2) }}</p>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-xl">
            <p class="text-sm font-medium text-gray-500">Total Bookings</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $dashboardData['totalBookings'] }}</p>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-xl">
            <p class="text-sm font-medium text-gray-500">Today's Bookings</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $dashboardData['todaysBookings'] }}</p>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-xl">
             <p class="text-sm font-medium text-gray-500">Average Rating</p>
            <p class="mt-2 text-3xl font-bold text-gray-900 flex items-center">
                {{ number_format($dashboardData['averageRating'], 2) }}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 ml-2 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            </p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
        
        <!-- Recent Bookings Table -->
        <div class="lg:col-span-2 bg-white border border-gray-200 rounded-xl">
            <div class="p-4 sm:p-6 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Recent Bookings</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 font-semibold text-left text-gray-600 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-3 font-semibold text-left text-gray-600 uppercase tracking-wider">Service</th>
                            <th class="px-6 py-3 font-semibold text-left text-gray-600 uppercase tracking-wider">Date & Time</th>
                            <th class="px-6 py-3 font-semibold text-left text-gray-600 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($bookings as $booking)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $booking->client_name }}</div>
                                    <div class="text-gray-500">{{ $booking->therapist->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $booking->service->name }}</div>
                                    <div class="text-gray-500">{{ $booking->branch->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-800">{{ $booking->start_time->format('M d, Y, h:i A') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if ($booking->status == 'Confirmed')
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">Confirmed</span>
                                    @else
                                        <span class="inline-flex px-2 text-xs font-semibold leading-5 text-red-800 bg-red-100 rounded-full">Cancelled</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="px-6 py-12 text-center text-gray-500">No bookings found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
             @if ($bookings->hasPages())
                <div class="p-4 border-t border-gray-200">{{ $bookings->links() }}</div>
            @endif
        </div>

        <!-- Bookings per Month Chart -->
        <div class="p-6 bg-white border border-gray-200 rounded-xl">
            <h3 class="text-lg font-semibold text-gray-800">Bookings per Month</h3>
            <div class="mt-4"><canvas id="bookingsByMonthChart"></canvas></div>
        </div>
    </div>
</div>

<!-- Include the modal for creating a booking -->
@include('admin.create-booking')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const brandColor = '#4f46e5'; // Indigo-600

    // Bookings by Month Chart (Bar)
    if (document.getElementById('bookingsByMonthChart')) {
        const bookingsByMonthCtx = document.getElementById('bookingsByMonthChart').getContext('2d');
        new Chart(bookingsByMonthCtx, {
            type: 'bar',
            data: {
                labels: @json($dashboardData['bookingsByMonthLabels']),
                datasets: [{
                    label: 'Bookings',
                    data: @json($dashboardData['bookingsByMonthData']),
                    backgroundColor: brandColor,
                    borderRadius: 4,
                }]
            },
            options: { 
                responsive: true, 
                plugins: { legend: { display: false } }, 
                scales: { y: { beginAtZero: true } } 
            }
        });
    }
});
</script>
@endsection


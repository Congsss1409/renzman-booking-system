@extends('layouts.admin')

@section('title', 'Analytics')

@push('scripts')
    {{-- We use a CDN for Chart.js here for simplicity --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
<div class="p-4 sm:p-6 lg:p-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 sm:text-3xl">Business Analytics</h2>
            <p class="mt-1.5 text-sm text-gray-500">View key metrics and performance charts. 📊</p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 mt-8 sm:grid-cols-2 lg:grid-cols-3">
        <div class="p-6 bg-white border border-gray-200 rounded-xl">
            <p class="text-sm font-medium text-gray-500">Total Revenue</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">₱{{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-xl">
            <p class="text-sm font-medium text-gray-500">Total Bookings</p>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalBookings }}</p>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-xl">
            <p class="text-sm font-medium text-gray-500">Average Rating</p>
            <p class="mt-2 text-3xl font-bold text-gray-900 flex items-center">
                {{ number_format($averageRating, 2) }}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 ml-2 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                </svg>
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-8 mt-8 lg:grid-cols-5">
        
        <div class="lg:col-span-3 p-6 bg-white border border-gray-200 rounded-xl">
            <h3 class="text-lg font-semibold text-gray-800">Bookings per Month</h3>
            <div class="mt-4">
                <canvas id="bookingsByMonthChart"></canvas>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-8">
            <div class="p-6 bg-white border border-gray-200 rounded-xl">
                <h3 class="text-lg font-semibold text-gray-800">Popular Services</h3>
                <div class="mt-4">
                    <canvas id="popularServicesChart"></canvas>
                </div>
            </div>

            <div class="p-6 bg-white border border-gray-200 rounded-xl">
                <h3 class="text-lg font-semibold text-gray-800">Busiest Therapists</h3>
                <div class="mt-4">
                    <canvas id="busiestTherapistsChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const brandColor = '#4f46e5'; // Indigo-600

    // Bookings by Month Chart (Bar)
    const bookingsByMonthCtx = document.getElementById('bookingsByMonthChart').getContext('2d');
    new Chart(bookingsByMonthCtx, {
        type: 'bar',
        data: {
            labels: @json($bookingsByMonthLabels),
            datasets: [{
                label: 'Bookings',
                data: @json($bookingsByMonthData),
                backgroundColor: brandColor,
                borderColor: brandColor,
                borderWidth: 1,
                borderRadius: 4,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e5e7eb' // Gray-200
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Popular Services Chart (Doughnut)
    const popularServicesCtx = document.getElementById('popularServicesChart').getContext('2d');
    new Chart(popularServicesCtx, {
        type: 'doughnut',
        data: {
            labels: @json($popularServicesLabels),
            datasets: [{
                data: @json($popularServicesData),
                backgroundColor: ['#4f46e5', '#6366f1', '#818cf8', '#a5b4fc', '#c7d2fe'],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });

    // Busiest Therapists Chart (Pie)
    const busiestTherapistsCtx = document.getElementById('busiestTherapistsChart').getContext('2d');
    new Chart(busiestTherapistsCtx, {
        type: 'pie',
        data: {
            labels: @json($busiestTherapistsLabels),
            datasets: [{
                data: @json($busiestTherapistsData),
                backgroundColor: ['#4f46e5', '#6366f1', '#818cf8', '#a5b4fc', '#c7d2fe'],
                hoverOffset: 4
            }]
        },
         options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });
});
</script>
@endsection
{{-- resources/views/admin/analytics.blade.php --}}
@extends('layouts.admin')

@section('header', 'Analytics & Reports')

@section('content')
<div>
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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Most Popular Services</h3>
            <canvas id="popularServicesChart"></canvas>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Busiest Therapists</h3>
            <canvas id="busiestTherapistsChart"></canvas>
        </div>
    </div>
</div>

{{-- Add Chart.js library --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Chart for Popular Services ---
    const popularServicesCtx = document.getElementById('popularServicesChart').getContext('2d');
    new Chart(popularServicesCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($popularServicesLabels) !!},
            datasets: [{
                label: 'Number of Bookings',
                data: {!! json_encode($popularServicesData) !!},
                backgroundColor: 'rgba(5, 150, 105, 0.6)',
                borderColor: 'rgba(4, 120, 87, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    // --- Chart for Busiest Therapists ---
    const busiestTherapistsCtx = document.getElementById('busiestTherapistsChart').getContext('2d');
    new Chart(busiestTherapistsCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($busiestTherapistsLabels) !!},
            datasets: [{
                label: 'Number of Bookings',
                data: {!! json_encode($busiestTherapistsData) !!},
                backgroundColor: 'rgba(15, 118, 110, 0.6)',
                borderColor: 'rgba(13, 94, 88, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
</script>
@endsection

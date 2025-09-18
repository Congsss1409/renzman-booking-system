@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Hello {{ Auth::user()->name }}!</h1>
            <p class="text-gray-500">{{ \Carbon\Carbon::now()->format('l, F j, Y') }}</p>
        </div>
        <a href="{{ route('admin.bookings.create') }}" class="bg-indigo-600 text-white font-semibold px-5 py-2.5 rounded-lg hover:bg-indigo-700 transition-colors">
            + New Booking
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-xl border border-gray-200 flex items-center gap-5">
            <div class="bg-blue-100 text-blue-600 p-4 rounded-full"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg></div>
            <div>
                <p class="text-gray-500 font-medium">Total Bookings</p>
                <p class="text-2xl font-bold text-gray-800">{{ $totalBookings }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-200 flex items-center gap-5">
            <div class="bg-green-100 text-green-600 p-4 rounded-full"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
            <div>
                <p class="text-gray-500 font-medium">Completed</p>
                <p class="text-2xl font-bold text-gray-800">{{ $completedBookings }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-200 flex items-center gap-5">
            <div class="bg-yellow-100 text-yellow-600 p-4 rounded-full"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
            <div>
                <p class="text-gray-500 font-medium">Pending</p>
                <p class="text-2xl font-bold text-gray-800">{{ $pendingBookings }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-200 flex items-center gap-5">
            <div class="bg-red-100 text-red-600 p-4 rounded-full"><svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg></div>
            <div>
                <p class="text-gray-500 font-medium">Canceled</p>
                <p class="text-2xl font-bold text-gray-800">{{ $canceledBookings }}</p>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white p-6 rounded-xl border border-gray-200">
            <canvas id="barChart"></canvas>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-200">
            <canvas id="doughnutChart"></canvas>
        </div>
    </div>

    <!-- Recent Bookings and Top Employees -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white p-6 rounded-xl border border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Recent Bookings</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-gray-500 border-b">
                        <tr>
                            <th class="py-3 px-4 font-semibold">Name</th>
                            <th class="py-3 px-4 font-semibold">Service</th>
                            <th class="py-3 px-4 font-semibold">Date</th>
                            <th class="py-3 px-4 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentBookings as $booking)
                        <tr class="border-b">
                            <td class="py-3 px-4 font-semibold text-gray-800">{{ $booking->client_name }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $booking->service->name }}</td>
                            <td class="py-3 px-4 text-gray-600">{{ $booking->start_time->format('M d, Y') }}</td>
                            <td class="py-3 px-4">
                                @if($booking->status == 'Cancelled')
                                    <span class="bg-red-100 text-red-700 text-xs font-semibold px-2.5 py-1 rounded-full">Cancelled</span>
                                @elseif($booking->status == 'Completed' || $booking->end_time < now())
                                    <span class="bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">Completed</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-2.5 py-1 rounded-full">Pending</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-10 text-gray-500">No recent bookings found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-200">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Top Employees</h3>
            <div class="space-y-4">
                @forelse($topTherapists as $therapist)
                <div class="flex items-center gap-4">
                    <img src="{{ $therapist->image ? Illuminate\Support\Facades\Storage::url($therapist->image) : asset('images/admin.png') }}" alt="{{ $therapist->name }}" class="w-12 h-12 rounded-full object-cover">
                    <div>
                        <p class="font-bold text-gray-800">{{ $therapist->name }}</p>
                        <p class="text-sm text-gray-500">{{ $therapist->bookings_count }} Bookings</p>
                    </div>
                </div>
                @empty
                <p class="text-center py-10 text-gray-500">No therapist data available.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Chart.defaults.font.family = "'Poppins', sans-serif";
        
        // Bar Chart - Income
        const barCtx = document.getElementById('barChart')?.getContext('2d');
        if (barCtx) {
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: @json($incomeLabels),
                    datasets: [{
                        label: 'Income',
                        data: @json($incomeData),
                        backgroundColor: '#4f46e5', // indigo-600
                        borderRadius: 5,
                        barThickness: 20,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        title: { display: true, text: 'Monthly Income (PHP)', font: { size: 16, weight: '600' }, color: '#334155', align: 'start', padding: { bottom: 20 } }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            grid: {
                                color: '#e5e7eb'
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
        }

        // Doughnut Chart - Booking Source
        const doughnutCtx = document.getElementById('doughnutChart')?.getContext('2d');
        if (doughnutCtx) {
            new Chart(doughnutCtx, {
                type: 'doughnut',
                data: {
                    labels: @json($sourceLabels),
                    datasets: [{
                        data: @json($sourceData),
                        backgroundColor: ['#4f46e5', '#34d399', '#f59e0b'],
                        borderColor: '#fff',
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { padding: 20 } },
                        title: { display: true, text: 'Booking Source', font: { size: 16, weight: '600' }, color: '#334155', align: 'start', padding: { bottom: 20 } }
                    }
                }
            });
        }
    });
</script>
@endpush


@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Dashboard</h1>
            <p class="text-gray-500 mt-1">Welcome back, here's a summary of your activities.</p>
        </div>
        <button x-data @click="$dispatch('open-modal', 'appointment-modal')" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-6 rounded-full shadow-lg transition-transform transform hover:scale-105 whitespace-nowrap">
            + NEW APPOINTMENT
        </button>
    </div>

    <!-- Dashboard Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-gradient-to-br from-teal-400 to-cyan-600 text-white p-6 rounded-2xl shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start"><h4 class="text-lg font-semibold">Today's Bookings</h4><svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
            <p class="text-6xl font-bold mt-4">{{ $todaysBookings }}</p>
        </div>
        <div class="bg-gradient-to-br from-teal-400 to-cyan-600 text-white p-6 rounded-2xl shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start"><h4 class="text-lg font-semibold">Total Bookings</h4><svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg></div>
            <p class="text-6xl font-bold mt-4">{{ $totalBookings }}</p>
        </div>
        <div class="bg-gradient-to-br from-teal-400 to-cyan-600 text-white p-6 rounded-2xl shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start"><h4 class="text-lg font-semibold">Total Revenue</h4><svg class="w-8 h-8 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01M12 6v-1m0-1V4m0 2.01M12 18v-1m0-1v-1m0 2v1m0 1v1M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg></div>
            <p class="text-5xl font-bold mt-4">₱{{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div class="bg-gradient-to-br from-teal-400 to-cyan-600 text-white p-6 rounded-2xl shadow-xl transform hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start"><h4 class="text-lg font-semibold">Average Rating</h4><svg class="w-8 h-8 opacity-80" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg></div>
            <p class="text-5xl font-bold mt-4">{{ number_format($averageRating, 2) }} <span class="text-yellow-300">★</span></p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
        
        <!-- Left Column: All Bookings Table -->
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-lg">
            <div class="flex flex-col sm:flex-row justify-between items-center mb-4 gap-4">
                <h2 class="text-2xl font-bold text-gray-800">All Bookings</h2>
                <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center">
                    <input type="text" name="search" placeholder="Search bookings..." value="{{ request('search') }}" class="w-full sm:w-64 p-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <button type="submit" class="bg-teal-500 text-white p-2 rounded-r-lg hover:bg-teal-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            @php $sort_by = request('sort_by', 'start_time'); $sort_order = request('sort_order', 'desc'); @endphp
                            <th scope="col" class="px-4 py-3"><a href="{{ route('admin.dashboard', ['sort_by' => 'client_name', 'sort_order' => ($sort_by == 'client_name' && $sort_order == 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center gap-1">Client @if($sort_by == 'client_name')<span class="text-teal-500">{{ $sort_order == 'asc' ? '▲' : '▼' }}</span>@endif</a></th>
                            <th scope="col" class="px-4 py-3">Details</th>
                            <th scope="col" class="px-4 py-3"><a href="{{ route('admin.dashboard', ['sort_by' => 'start_time', 'sort_order' => ($sort_by == 'start_time' && $sort_order == 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center gap-1">Schedule @if($sort_by == 'start_time')<span class="text-teal-500">{{ $sort_order == 'asc' ? '▲' : '▼' }}</span>@endif</a></th>
                            <th scope="col" class="px-4 py-3"><a href="{{ route('admin.dashboard', ['sort_by' => 'created_at', 'sort_order' => ($sort_by == 'created_at' && $sort_order == 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center gap-1">Created @if($sort_by == 'created_at')<span class="text-teal-500">{{ $sort_order == 'asc' ? '▲' : '▼' }}</span>@endif</a></th>
                            <th scope="col" class="px-4 py-3"><a href="{{ route('admin.dashboard', ['sort_by' => 'status', 'sort_order' => ($sort_by == 'status' && $sort_order == 'asc') ? 'desc' : 'asc', 'search' => request('search')]) }}" class="flex items-center gap-1">Status @if($sort_by == 'status')<span class="text-teal-500">{{ $sort_order == 'asc' ? '▲' : '▼' }}</span>@endif</a></th>
                            <th scope="col" class="px-4 py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr class="bg-white border-b hover:bg-gray-50">
                                <td class="px-4 py-4 font-medium text-gray-900">{{ $booking->client_name }}</td>
                                <td class="px-4 py-4"><p class="font-semibold text-xs">{{ $booking->service->name ?? 'N/A' }}</p><p class="text-xs text-gray-500">{{ $booking->therapist->name ?? 'N/A' }} at {{ $booking->branch->name ?? 'N/A' }}</p></td>
                                <td class="px-4 py-4"><p class="text-xs">{{ $booking->start_time->format('M d, Y') }}</p><p class="text-xs text-gray-500">{{ $booking->start_time->format('g:i A') }}</p></td>
                                <td class="px-4 py-4 text-xs text-gray-500">
                                    <p>{{ $booking->created_at->format('M d, Y') }}</p>
                                    <p class="text-gray-400">{{ $booking->created_at->format('g:i A') }}</p>
                                </td>
                                <td class="px-4 py-4"><span class="font-semibold text-xs px-3 py-1 rounded-full {{ $booking->status == 'Confirmed' ? 'bg-green-100 text-green-800' : ($booking->status == 'Cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">{{ $booking->status }}</span></td>
                                <td class="px-4 py-4">
                                    @if($booking->status !== 'Cancelled' && $booking->status !== 'Completed')
                                    <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST" class="cancel-form">
                                        @csrf
                                        <button type="button" class="font-medium text-red-600 hover:underline text-xs cancel-button">Cancel</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="text-center py-12 text-gray-500"><p class="font-bold text-lg">No bookings found.</p><p>Try adjusting your search or filter.</p></td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">{{ $bookings->links() }}</div>
        </div>

        <!-- Right Column: Analytics Sidebar -->
        <div class="space-y-8">
            <div class="bg-white p-6 rounded-2xl shadow-lg">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Top Therapists</h3>
                <div class="space-y-4">
                    @forelse($topTherapists as $therapist)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <img src="{{ $therapist->image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode($therapist->name) . '&color=FFFFFF&background=059669&size=128' }}" alt="{{ $therapist->name }}" class="w-12 h-12 rounded-full object-cover">
                                <div><p class="font-bold text-gray-800">{{ $therapist->name }}</p><p class="text-sm text-gray-500">{{ $therapist->branch->name ?? 'N/A' }}</p></div>
                            </div>
                            <div class="text-right"><p class="font-bold text-lg text-teal-500">{{ $therapist->bookings_count }}</p><p class="text-sm text-gray-500">Bookings</p></div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">No therapist data available.</p>
                    @endforelse
                </div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-lg flex justify-center items-center"><div class="w-full max-w-xs"><canvas id="sourceChart"></canvas></div></div>
        </div>
    </div>
</div>

<!-- New Appointment Modal -->
<div x-data="{ 
        show: {{ $errors->bookingCreation->any() ? 'true' : 'false' }}, 
        branch: '{{ old('branch_id') }}', 
        availableTherapists: [],
        minDateTime: '',
        fetchTherapists() {
            if (this.branch) {
                fetch(`/admin/branches/${this.branch}/therapists`)
                    .then(response => response.json())
                    .then(data => { this.availableTherapists = data; });
            } else { this.availableTherapists = []; }
        },
        setMinDateTime() {
            const now = new Date(new Date().toLocaleString('en-US', { timeZone: 'Asia/Manila' }));
            now.setMinutes(now.getMinutes() + 30); // 30 minute buffer
            let year = now.getFullYear();
            let month = now.getMonth();
            let day = now.getDate();
            let hours = now.getHours();
            
            if (hours >= 21) { // If past 9 PM
                now.setDate(now.getDate() + 1); // Move to next day
                year = now.getFullYear();
                month = now.getMonth();
                day = now.getDate();
                hours = 8; // Set time to 8 AM
            } else if (hours < 8) { // If before 8 AM
                hours = 8; // Set time to 8 AM today
            }

            const pad = (num) => num.toString().padStart(2, '0');
            this.minDateTime = `${year}-${pad(month + 1)}-${pad(day)}T${pad(hours)}:00`;
        }
    }"
     x-init="fetchTherapists(); setMinDateTime()"
     x-show="show"
     x-on:open-modal.window="if ($event.detail === 'appointment-modal') { show = true; setMinDateTime(); }"
     x-on:close-modal.window="show = false"
     x-on:keydown.escape.window="show = false"
     style="display: none;"
     class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center p-4 z-50">

    <div @click.away="show = false" class="bg-white rounded-3xl p-8 w-full max-w-2xl shadow-2xl max-h-[90vh] overflow-y-auto">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Make an Appointment</h2>
        <form action="{{ route('admin.bookings.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="client_name" placeholder="Client Name" value="{{ old('client_name') }}" required class="w-full bg-stone-100 p-4 rounded-full border-none focus:ring-2 focus:ring-teal-400 outline-none">
                <input type="text" name="client_phone" placeholder="Client Phone" value="{{ old('client_phone') }}" required class="w-full bg-stone-100 p-4 rounded-full border-none focus:ring-2 focus:ring-teal-400 outline-none">
                <div class="md:col-span-2"><input type="email" name="client_email" placeholder="Client Email (Optional)" value="{{ old('client_email') }}" class="w-full bg-stone-100 p-4 rounded-full border-none focus:ring-2 focus:ring-teal-400 outline-none"></div>
            </div>
            <h3 class="text-2xl font-bold mt-8 mb-6 text-gray-800">Booking Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="relative bg-stone-100 rounded-full"><select name="branch_id" required x-model="branch" @change="fetchTherapists" class="w-full bg-transparent p-4 rounded-full appearance-none font-semibold text-gray-600 focus:ring-2 focus:ring-teal-400 outline-none"><option value="">SELECT BRANCH</option>@foreach($branches as $branch) <option value="{{ $branch->id }}">{{ $branch->name }}</option> @endforeach</select><div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none"><svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></div></div>
                <div class="relative bg-stone-100 rounded-full"><select name="service_id" required class="w-full bg-transparent p-4 rounded-full appearance-none font-semibold text-gray-600 focus:ring-2 focus:ring-teal-400 outline-none"><option value="">SELECT SERVICE</option>@foreach($services as $service) <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>{{ $service->name }} ({{ $service->duration }} mins)</option> @endforeach</select><div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none"><svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></div></div>
                <div class="relative bg-stone-100 rounded-full"><select name="therapist_id" required :disabled="!branch" class="w-full bg-transparent p-4 rounded-full appearance-none font-semibold text-gray-600 focus:ring-2 focus:ring-teal-400 outline-none disabled:opacity-50"><option value="">SELECT THERAPIST</option><template x-for="therapist in availableTherapists" :key="therapist.id"><option :value="therapist.id" :selected="therapist.id == '{{ old('therapist_id') }}'" x-text="therapist.name"></option></template></select><div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none"><svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></div></div>
                <div class="relative bg-stone-100 rounded-full"><input type="datetime-local" name="start_time" required :min="minDateTime" class="w-full bg-transparent p-4 rounded-full font-semibold text-gray-600 focus:ring-2 focus:ring-teal-400 outline-none"></div>
                <div class="md:col-span-2 relative bg-stone-100 rounded-full"><select name="payment_method" required class="w-full bg-transparent p-4 rounded-full appearance-none font-semibold text-gray-600 focus:ring-2 focus:ring-teal-400 outline-none"><option value="">SELECT PAYMENT</option><option value="On-Site" {{ old('payment_method') == 'On-Site' ? 'selected' : '' }}>On-Site</option><option value="GCash" {{ old('payment_method') == 'GCash' ? 'selected' : '' }}>GCash</option><option value="Maya" {{ old('payment_method') == 'Maya' ? 'selected' : '' }}>Maya</option></select><div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none"><svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg></div></div>
            </div>
            <div class="flex justify-center gap-4 mt-8"><button type="button" @click="show = false" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-8 rounded-full shadow-md transition-transform transform hover:scale-105">CANCEL</button><button type="submit" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 hover:from-teal-500 hover:to-cyan-700 text-white py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105">CONFIRM APPOINTMENT</button></div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    Chart.defaults.font.family = "'Poppins', sans-serif"; Chart.defaults.color = '#64748b';
    const sourceCtx = document.getElementById('sourceChart')?.getContext('2d');
    if (sourceCtx) { new Chart(sourceCtx, { type: 'doughnut', data: { labels: @json($sourceLabels), datasets: [{ label: 'Booking Source', data: @json($sourceData), backgroundColor: ['#2dd4bf', '#22d3ee', '#60a5fa', '#a78bfa', '#f87171'], borderColor: '#FFFFFF', borderWidth: 4, }] }, options: { responsive: true, cutout: '70%', plugins: { legend: { position: 'bottom' }, title: { display: true, text: 'Booking Sources', font: { size: 18, weight: '600' }, padding: { bottom: 20 } } } } }); }
    
    // SweetAlert2 for cancellation confirmation
    const cancelButtons = document.querySelectorAll('.cancel-button');
    cancelButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            Swal.fire({ 
                title: 'Are you sure?', 
                text: "This booking will be cancelled.", 
                icon: 'warning', 
                showCancelButton: true, 
                confirmButtonColor: '#14b8a6', 
                cancelButtonColor: '#d33', 
                confirmButtonText: 'Yes, cancel it!',
                didOpen: () => {
                    // This is a fix for SweetAlert2 focus trapping in modals
                    const sweetAlertModal = document.querySelector('.swal2-container');
                    if (sweetAlertModal) {
                        sweetAlertModal.style.zIndex = '9999';
                    }
                }
            }).then((result) => { 
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Please wait while we cancel the booking.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    form.submit(); 
                } 
            })
        });
    });
});
</script>
@endpush


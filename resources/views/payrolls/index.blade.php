@extends('layouts.admin')

@section('title', 'Payrolls')

@section('content')
<div class="max-w-7xl mx-auto p-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-2xl shadow-lg mb-8">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Payrolls</h1>
                <p class="text-gray-500 mt-1">Manage generated payrolls and create new ones from bookings.</p>
            </div>
            <div class="flex flex-col gap-2 sm:flex-row sm:gap-3 w-full sm:w-auto mt-4 sm:mt-0">
                <a href="{{ route('admin.payrolls.export') }}" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-6 rounded-full shadow-md transition-transform hover:scale-105 whitespace-nowrap w-full sm:w-auto text-center">Export CSV</a>
                <a href="{{ route('admin.payrolls.create') }}" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 text-white py-2 px-6 rounded-full shadow-lg transition-transform hover:scale-105 whitespace-nowrap w-full sm:w-auto text-center">New Payroll</a>
            </div>
        </div>
        <form action="{{ route('admin.payrolls.generate_from_bookings') }}" method="POST" class="flex flex-wrap items-end gap-4">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">Start</label>
                <input type="date" name="period_start" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" required>
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-600 mb-2">End</label>
                <input type="date" name="period_end" class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500" required>
            </div>
            <div>
                <button class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 text-white py-3 px-8 rounded-full shadow-lg transition-transform transform hover:scale-105 whitespace-nowrap">Generate from Bookings</button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-sm text-gray-500">Today's Gross (Completed bookings)</div>
            <div class="text-2xl font-semibold mt-2">₱{{ number_format($grossToday ?? 0, 2) }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-sm text-gray-500">Therapist Share (60%)</div>
            <div class="text-2xl font-semibold mt-2">₱{{ number_format($therapistShareToday ?? 0, 2) }}</div>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <div class="text-sm text-gray-500">Owner Share (40%)</div>
            <div class="text-2xl font-semibold mt-2">₱{{ number_format($ownerShareToday ?? 0, 2) }}</div>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        @forelse($payrolls as $p)
            <div class="bg-white rounded-2xl shadow-lg p-6 flex flex-col items-center text-center min-w-0">
                <img src="{{ optional($p->therapist)->image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(optional($p->therapist)->name ?? 'Therapist') . '&color=FFFFFF&background=059669&size=128' }}" alt="{{ optional($p->therapist)->name }}" class="w-20 h-20 sm:w-24 sm:h-24 md:w-28 md:h-28 lg:w-32 lg:h-32 rounded-full object-cover border-4 border-white shadow mb-4">
                <p class="text-lg font-bold text-gray-800 break-words">{{ optional($p->therapist)->name ?? '—' }}</p>
                <p class="text-gray-500 mb-2 text-sm break-words">{{ $p->period_start->format('Y-m-d') }} — {{ $p->period_end->format('Y-m-d') }}</p>
                <p class="text-lg font-semibold text-gray-900 mt-3">₱{{ number_format($p->gross,2) }}</p>
                <div class="mt-4 flex flex-col gap-2 w-full">
                    <a href="{{ route('admin.payrolls.show', $p->id) }}" class="font-semibold bg-gray-200 text-gray-700 py-2 rounded-full shadow-md transition-transform hover:scale-105 w-full">View</a>
                    <a href="{{ route('admin.payrolls.export_pdf', $p->id) }}" class="font-semibold bg-cyan-400 text-white py-2 rounded-full shadow-md transition-transform hover:scale-105 w-full">Export PDF</a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12 text-gray-500">
                <p class="font-bold text-lg">No payrolls found.</p>
                <p>Create one by generating from bookings.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $payrolls->links() }}
    </div>
</div>
@endsection

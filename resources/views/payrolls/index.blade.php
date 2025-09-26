@extends('layouts.admin')

@section('title', 'Payrolls')

@section('content')
<div class="space-y-8">
    <div class="flex items-start justify-between">
        <div>
            <h1 class="text-4xl font-bold text-gray-800">Payrolls</h1>
            <p class="text-gray-500 mt-1">Manage generated payrolls and create new ones from bookings.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.payrolls.export') }}" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-4 rounded-md">Export CSV</a>
            <a href="{{ route('admin.payrolls.create') }}" class="font-semibold bg-gradient-to-r from-teal-400 to-cyan-600 text-white py-2 px-4 rounded-md shadow">New Payroll</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
        <form action="{{ route('admin.payrolls.generate_from_bookings') }}" method="POST" class="flex items-end gap-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700">Start</label>
                <input type="date" name="period_start" class="mt-1 block w-full rounded border-gray-200" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">End</label>
                <input type="date" name="period_end" class="mt-1 block w-full rounded border-gray-200" required>
            </div>
            <div>
                <button class="inline-flex items-center gap-2 bg-teal-600 text-white py-2 px-4 rounded">Generate from Bookings</button>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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

    <div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse($payrolls as $p)
                <div class="bg-stone-50 rounded-2xl p-6 text-center shadow-lg border hover:shadow-xl transition-shadow duration-300">
                    <img src="{{ optional($p->therapist)->image_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(optional($p->therapist)->name ?? 'Therapist') . '&color=FFFFFF&background=059669&size=128' }}" alt="{{ optional($p->therapist)->name }}" class="w-24 h-24 mx-auto rounded-full mb-4 object-cover border-4 border-white shadow-md">
                    <p class="text-xl font-bold text-gray-800">{{ optional($p->therapist)->name ?? '—' }}</p>
                    <p class="text-sm text-gray-500 mt-1">{{ $p->period_start->format('Y-m-d') }} — {{ $p->period_end->format('Y-m-d') }}</p>
                    <p class="text-lg font-semibold text-gray-900 mt-3">₱{{ number_format($p->gross,2) }}</p>
                    <div class="mt-4 flex justify-center gap-3">
                        <a href="{{ route('admin.payrolls.show', $p->id) }}" class="font-semibold bg-gray-200 text-gray-700 py-2 px-4 rounded-full shadow-md">View</a>
                        <a href="{{ route('admin.payrolls.export_pdf', $p->id) }}" class="font-semibold bg-cyan-400 text-white py-2 px-4 rounded-full shadow-md">Export PDF</a>
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
</div>
@endsection

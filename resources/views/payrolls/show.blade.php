@extends('layouts.admin')

@section('title', "Payroll #{$payroll->id}")

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Payroll #{{ $payroll->id }}</h1>
            <p class="text-gray-500 mt-1">Details for this payroll record.</p>
        </div>
        <a href="{{ route('admin.payrolls.export_pdf', $payroll->id) }}" class="font-semibold bg-cyan-400 text-white py-2 px-6 rounded-full shadow-md hover:bg-cyan-500 transition-transform transform hover:scale-105 whitespace-nowrap">Export PDF</a>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-1">
            <h3 class="font-semibold text-gray-700 mb-4">Summary</h3>
            <div class="space-y-2 text-sm text-gray-700">
                <div><span class="font-medium">Therapist:</span> {{ optional($payroll->therapist)->name ?? '—' }}</div>
                <div><span class="font-medium">Period:</span> {{ $payroll->period_start->toDateString() }} — {{ $payroll->period_end->toDateString() }}</div>
                <div><span class="font-medium">Gross:</span> ₱{{ number_format($payroll->gross,2) }}</div>
                <div><span class="font-medium">Therapist (60%):</span> ₱{{ number_format($payroll->therapist_share ?? 0,2) }}</div>
                <div><span class="font-medium">Owner (40%):</span> ₱{{ number_format($payroll->owner_share ?? 0,2) }}</div>
                <div><span class="font-medium">Deductions:</span> ₱{{ number_format($payroll->deductions,2) }}</div>
                <div><span class="font-medium">Net (to Therapist):</span> ₱{{ number_format($payroll->net,2) }}</div>
                <div><span class="font-medium">Status:</span> {{ ucfirst($payroll->status) }}</div>
            </div>
        </div>
        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gray-50 p-4 rounded">
                <h4 class="font-semibold mb-2">Items</h4>
                <ul class="mt-3 space-y-2 text-sm">
                    @foreach($payroll->items as $item)
                        <li class="flex items-center justify-between">
                            <div>
                                <div class="font-medium">{{ $item->description }}</div>
                                <div class="text-xs text-gray-500">{{ $item->created_at->toDateString() }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="text-sm">₱{{ number_format($item->amount,2) }}</div>
                                <form action="{{ route('admin.payrolls.items.remove', $item->id) }}" method="POST">
                                    @csrf
                                    <button class="text-red-500 text-sm">Remove</button>
                                </form>
                            </div>
                        </li>
                    @endforeach
                </ul>
                <form action="{{ route('admin.payrolls.items.add', $payroll->id) }}" method="POST" class="mt-4 space-y-2">
                    @csrf
                    <input type="text" name="description" placeholder="Description" class="w-full rounded border-gray-200 p-2" required>
                    <input type="number" step="0.01" name="amount" placeholder="Amount" class="w-full rounded border-gray-200 p-2" required>
                    <div class="mt-2">
                        <button class="bg-teal-600 text-white py-1 px-3 rounded">Add Item</button>
                    </div>
                </form>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <h4 class="font-semibold mb-2">Payments</h4>
                <ul class="mt-3 space-y-2 text-sm">
                    @foreach($payroll->payments as $payment)
                        <li class="flex items-center justify-between">
                            <div>
                                <div class="font-medium">₱{{ number_format($payment->amount,2) }}</div>
                                <div class="text-xs text-gray-500">{{ optional($payment->paid_at)->toDateString() }} — {{ $payment->method }} {{ $payment->reference ? "(#{$payment->reference})" : '' }}</div>
                            </div>
                            <div class="text-green-600 text-sm">Recorded</div>
                        </li>
                    @endforeach
                </ul>
                <form action="{{ route('admin.payrolls.payments.add', $payroll->id) }}" method="POST" class="mt-4 space-y-2">
                    @csrf
                    <input type="number" step="0.01" name="amount" placeholder="Amount" class="w-full rounded border-gray-200 p-2" required>
                    <input type="date" name="paid_at" class="w-full rounded border-gray-200 p-2">
                    <input type="text" name="method" placeholder="Method (e.g. Bank transfer)" class="w-full rounded border-gray-200 p-2">
                    <input type="text" name="reference" placeholder="Reference" class="w-full rounded border-gray-200 p-2">
                    <div class="mt-2">
                        <button class="bg-teal-600 text-white py-1 px-3 rounded">Record Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="flex justify-end">
        <a href="{{ route('admin.payrolls.index') }}" class="font-semibold bg-gray-200 hover:bg-gray-300 text-gray-700 py-2 px-6 rounded-full shadow-md transition-transform transform hover:scale-105 whitespace-nowrap">&larr; Back to payrolls</a>
    </div>
</div>
@endsection

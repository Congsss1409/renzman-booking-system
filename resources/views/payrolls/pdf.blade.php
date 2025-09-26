<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payroll #{{ $payroll->id }}</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; color: #222; }
        .header { display:flex; align-items:center; justify-content:space-between; }
        .logo { display:flex; align-items:center; gap:10px; }
        .title { font-size:20px; font-weight:700; }
        table { width:100%; border-collapse:collapse; margin-top:12px; }
        th, td { padding:8px; border:1px solid #e5e7eb; }
        .text-right { text-align:right; }
        .totals { font-weight:700; background:#f8fafc; }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="{{ public_path('images\logo_white.png  ') }}" alt="Logo" style="height:36px; object-fit:contain;">
            <div>
                <div class="title">Renzman Payroll</div>
                <div style="font-size:12px; color:#6b7280">Payroll #{{ $payroll->id }} &middot; {{ $payroll->period_start->toDateString() }} — {{ $payroll->period_end->toDateString() }}</div>
            </div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:12px; color:#6b7280">Generated: {{ now()->toDateTimeString() }}</div>
        </div>
    </div>

    <table>
        <tr>
            <th>Therapist</th>
            <td>{{ optional($payroll->therapist)->name ?? '—' }}</td>
            <th class="text-right">Gross</th>
            <td class="text-right">{{ number_format($payroll->gross,2) }}</td>
        </tr>
        <tr>
            <th>Therapist (60%)</th>
            <td>{{ number_format($payroll->therapist_share ?? 0,2) }}</td>
            <th class="text-right">Owner (40%)</th>
            <td class="text-right">{{ number_format($payroll->owner_share ?? 0,2) }}</td>
        </tr>
        <tr>
            <th>Deductions</th>
            <td>{{ number_format($payroll->deductions,2) }}</td>
            <th class="text-right">Net</th>
            <td class="text-right">{{ number_format($payroll->net,2) }}</td>
        </tr>
    </table>

    @if($payroll->items->count())
    <h3 style="margin-top:18px;">Items</h3>
    <table>
        <thead>
            <tr>
                <th style="text-align:left">Description</th>
                <th style="text-align:right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payroll->items as $it)
            <tr>
                <td>{{ $it->description }}</td>
                <td class="text-right">{{ number_format($it->amount,2) }}</td>
            </tr>
            @endforeach
            <tr class="totals">
                <td>Total Items</td>
                <td class="text-right">{{ number_format($payroll->items->sum('amount'),2) }}</td>
            </tr>
        </tbody>
    </table>
    @endif

    @if($payroll->payments->count())
    <h3 style="margin-top:18px;">Payments</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Method / Reference</th>
                <th style="text-align:right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payroll->payments as $pay)
            <tr>
                <td>{{ optional($pay->paid_at)->toDateString() }}</td>
                <td>{{ $pay->method }} {{ $pay->reference ? "(#{$pay->reference})" : '' }}</td>
                <td class="text-right">{{ number_format($pay->amount,2) }}</td>
            </tr>
            @endforeach
            <tr class="totals">
                <td colspan="2">Total Paid</td>
                <td class="text-right">{{ number_format($payroll->payments->sum('amount'),2) }}</td>
            </tr>
        </tbody>
    </table>
    @endif

</body>
</html>

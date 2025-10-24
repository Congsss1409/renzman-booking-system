<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payroll Statement #{{ $payroll->id }}</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }
        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            background: #f4f7f6;
            margin: 0;
            padding: 0;
        }
        .payslip-container {
            max-width: 800px;
            margin: 8px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 32px rgba(44,62,80,0.08);
            padding: 12px 16px 12px 16px;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 2px solid #e0e7ef;
            padding-bottom: 8px;
            margin-bottom: 14px;
        }
        .logo {
            max-width: 80px;
        }
        .company-info {
            text-align: right;
        }
        .company-name {
            font-size: 28px;
            font-weight: 700;
            color: #2d3748;
            margin: 0;
        }
        .payslip-title {
            font-size: 18px;
            color: #6c5ce7;
            font-weight: 600;
            margin: 0;
            letter-spacing: 2px;
        }
        .summary-panel {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            background: #fff;
            border-radius: 8px;
            padding: 8px 10px;
            margin-bottom: 14px;
            font-size: 14px;
        }
        .summary-panel .summary-item {
            flex: 1 1 180px;
            min-width: 160px;
            margin-bottom: 8px;
        }
        .summary-label {
            color: #444;
            font-weight: 500;
        }
        .summary-value {
            color: #222;
            font-weight: 600;
            font-size: 16px;
        }
        .section {
            margin-bottom: 14px;
        }
        .section-title {
            font-size: 16px;
            font-weight: 600;
            color: #222;
            margin-bottom: 6px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 2px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
            margin-bottom: 0;
        }
        th, td {
            padding: 6px 7px;
            text-align: left;
        }
        th {
            background: #fff;
            color: #222;
            font-weight: 600;
            border-bottom: 2px solid #ccc;
        }
        tr:not(:last-child) td {
            border-bottom: 1px solid #ccc;
        }
        .total-row td {
            font-weight: 700;
            background: #fff;
            border-top: 2px solid #ccc;
        }
        .amount-column {
            text-align: right;
        }
        .net-pay-section {
            margin-top: 10px;
            padding: 10px 0 6px 0;
                background: #fff;
                color: #222;
                text-align: center;
            border-radius: 8px;
        }
        .net-pay-label {
            font-size: 20px;
            font-weight: 700;
            margin: 0;
              text-transform: none;
              letter-spacing: 0;
        }
        .net-pay-amount {
            font-size: 36px;
            font-weight: 700;
            margin: 8px 0 0 0;
              color: #222;
        }
        .net-pay-note {
            font-size: 13px;
              color: #444;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 13px;
            color: #222;
        }
        .signature-section {
            margin-top: 48px;
            display: flex;
            justify-content: flex-end;
        }
        .signature-line {
            border-top: 1.5px solid #bfc9d8;
            width: 220px;
            margin-top: 32px;
            text-align: center;
            color: #222;
            font-size: 14px;
            padding-top: 6px;
        }
    </style>
</head>
<body>
    <div class="payslip-container">
        <div class="header">
            <div class="company-info" style="width:100%;text-align:center;">
                <div class="payslip-title" style="font-size:22px; color:#222;">Payroll Statement</div>
            </div>
        </div>
        <div class="summary-panel">
            <div class="summary-item">
                <div class="summary-label">Employee</div>
                <div class="summary-value">{{ $employee_name }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Pay Date</div>
                <div class="summary-value">{{ $payroll->period_end->addDays(7)->format('M d, Y') }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Payroll Period</div>
                <div class="summary-value">{{ $payroll->period_start->format('M d, Y') }} - {{ $payroll->period_end->format('M d, Y') }}</div>
            </div>
            <div class="summary-item">
                <div class="summary-label">Status</div>
                <div class="summary-value">{{ ucfirst($payroll->status ?? 'pending') }}</div>
            </div>
        </div>
        <div class="section">
            <div class="section-title">Earnings</div>
            <table>
                <thead>
                    
                    <tr class="total-row">
                        <td><strong>Total Earnings</strong></td>
                        <td class="amount-column"><strong>{{ number_format(($payroll->therapist_share ?? 0) + $payroll->items->sum('amount'), 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="section">
            <div class="section-title">Deductions</div>
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th class="amount-column">Amount (PHP)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Standard Deductions</td>
                        <td class="amount-column">{{ number_format($payroll->deductions, 2) }}</td>
                    </tr>
                    <tr class="total-row">
                        <td><strong>Total Deductions</strong></td>
                        <td class="amount-column"><strong>{{ number_format($payroll->deductions, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="net-pay-section">
            <div class="net-pay-label">Net Pay</div>
            <div class="net-pay-amount">PHP {{ number_format($payroll->net, 2) }}</div>
            <div class="net-pay-note">This amount will be deposited to your designated account</div>
        </div>
        @if($payroll->payments->count())
        <div class="section">
            <div class="section-title">Payment History</div>
            <table>
                <thead>
                    <tr>
                        <th>Payment Date</th>
                        <th>Method</th>
                        <th>Reference</th>
                        <th class="amount-column">Amount (PHP)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payroll->payments as $payment)
                    <tr>
                        <td>{{ $payment->created_at->format('M d, Y') }}</td>
                        <td>{{ $payment->method }}</td>
                        <td>{{ $payment->reference }}</td>
                        <td class="amount-column">{{ number_format($payment->amount, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr class="total-row">
                        <td colspan="3"><strong>Total Paid</strong></td>
                        <td class="amount-column"><strong>{{ number_format($payroll->payments->sum('amount'), 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
    <!-- Signature and footer removed for single-page, clean payslip. -->
    </div>
</body>
</html>

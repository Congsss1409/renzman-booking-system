<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payroll Statement #{{ $payroll->id }}</title>
    <style>
        @page {
            size: A4;
            margin: 0; /* Remove margin for full page control */
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 10mm; /* Add padding to body to center content */
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            box-sizing: border-box;
        }
        .payslip-container {
            width: 100%; /* Use full width of padded body */
            max-width: 190mm; /* A4 width minus padding */
            min-height: 277mm; /* A4 height minus padding */
            margin: 0 auto;
            background: #fff;
            padding: 10mm;
            box-sizing: border-box;
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
            border-radius: 8px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #6c5ce7;
        }
        .logo {
            max-width: 100px;
            margin-bottom: 10px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin: 0;
        }
        .payslip-title {
            font-size: 18px;
            color: #555;
            margin-top: 5px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .details-section {
            margin-bottom: 20px;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
            font-size: 14px;
            line-height: 1.6;
        }
        .details-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .details-grid strong {
            display: inline-block;
            width: 120px;
            color: #333;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #6c5ce7;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }
        th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #555;
        }
        .total-row td {
            font-weight: bold;
            background-color: #f8f9fa;
            border-top: 2px solid #ddd;
        }
        .amount-column {
            text-align: right;
        }
        .net-pay-section {
            margin-top: 20px;
            padding: 20px;
            background-color: #6c5ce7;
            color: #fff;
            text-align: center;
            border-radius: 5px;
        }
        .net-pay-label {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .net-pay-amount {
            font-size: 36px;
            font-weight: bold;
            margin: 5px 0;
        }
        .net-pay-note {
            font-size: 12px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="payslip-container">
        <div class="header">
            <img src="{{ $company_logo_url }}" alt="Company Logo" class="logo">
            <h1 class="company-name">{{ $company_name }}</h1>
            <p class="payslip-title">Payslip</p>
        </div>
        <div class="details-section">
            <div class="details-grid">
                <div><strong>Employee:</strong> {{ $employee_name }}</div>
                <div><strong>Pay Date:</strong> {{ $payroll->period_end->addDays(7)->format('M d, Y') }}</div>
                <div><strong>Payroll Start:</strong> {{ $payroll->period_start->format('M d, Y') }}</div>
                <div><strong>Status:</strong> {{ ucfirst($payroll->status ?? 'pending') }}</div>
                <div><strong>Payroll End:</strong> {{ $payroll->period_end->format('M d, Y') }}</div>
            </div>
        </div>
        <div class="section">
            <div class="section-title">Earnings</div>
            <table>
                <thead>
                    <tr>
                        <th>Description</th>
                        <th class="amount-column">Amount (PHP)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Gross Revenue</td>
                        <td class="amount-column">{{ number_format($payroll->gross, 2) }}</td>
                    </tr>
                    <tr>
                        <td>Therapist Share (60%)</td>
                        <td class="amount-column">{{ number_format($payroll->therapist_share ?? 0, 2) }}</td>
                    </tr>
                    @if($payroll->items->count())
                        @foreach($payroll->items as $item)
                        <tr>
                            <td>{{ $item->description }}</td>
                            <td class="amount-column">{{ number_format($item->amount, 2) }}</td>
                        </tr>
                        @endforeach
                    @endif
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
        <div class="footer">
            <p>Confidential: Keep secure.</p>
            <p>Contact HR: hr@renzman.com | Phone: (555) 123-4567</p>
            <p>Electronically generated document - no signature required.</p>
        </div>
    </div>
</body>
</html>

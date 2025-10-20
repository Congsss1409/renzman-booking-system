<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Revenue Report - {{ $monthName }} {{ $year }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }
        
        .container {
            border: 2px solid #000;
            padding: 20px;
        }
        
        .header {
            text-align: center;
            border-bottom: 1px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .subtitle {
            font-size: 14px;
            margin-bottom: 10px;
        }
        
        .info-section {
            margin-bottom: 20px;
        }
        
        .info-row {
            margin-bottom: 5px;
        }
        
        .label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        
        th {
            background: #f0f0f0;
            font-weight: bold;
        }
        
        .amount {
            text-align: right;
        }
        
        .total {
            background: #e0e0e0;
            font-weight: bold;
        }
        

    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div class="title">RENZMAN BLIND MASSAGE</div>
            <div class="subtitle">Revenue Report - {{ $monthName }} {{ $year }}</div>
        </div>
        
        <!-- Basic Info -->
        <div class="info-section">
            <div class="info-row">
                <span class="label">Report ID:</span> REV-{{ $year }}-{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}
            </div>
            <div class="info-row">
                <span class="label">Period:</span> {{ $monthName }} {{ $year }}
            </div>
            <div class="info-row">
                <span class="label">Generated:</span> {{ now()->format('F d, Y - h:i A') }}
            </div>
        </div>
        
        <!-- Revenue Table -->
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Client</th>
                    <th>Service</th>
                    <th>Therapist</th>
                    <th>Status</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('M d') }}</td>
                    <td>{{ $booking->client_name }}</td>
                    <td>{{ $booking->service->name ?? 'N/A' }}</td>
                    <td>{{ $booking->therapist->name ?? 'N/A' }}</td>
                    <td>{{ $booking->status }}</td>
                    <td class="amount">PHP {{ number_format($booking->price, 2) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center;">No bookings found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Summary -->
        <table>
            <tr class="total">
                <td><strong>Total Revenue</strong></td>
                <td class="amount"><strong>PHP {{ number_format($totalRevenue, 2) }}</strong></td>
            </tr>
            <tr>
                <td>Total Bookings</td>
                <td class="amount">{{ $bookings->count() }}</td>
            </tr>
        </table>
        
        <p style="text-align: center; margin-top: 20px; font-size: 10px;">
            Generated on {{ now()->format('F d, Y \a\t h:i A') }}
        </p>
    </div>
</body>
</html>
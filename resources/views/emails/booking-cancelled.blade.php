<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Cancellation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .content {
            padding: 20px 0;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Booking Cancellation</h2>
        </div>
        <div class="content">
            <p>Dear {{ $booking->client_name }}!,</p>
            <p>This email is to confirm that your booking has been successfully cancelled. Here are the details of the cancelled appointment:</p>
            <ul>
                <li><strong>Service:</strong> {{ $booking->service->name }}</li>
                <li><strong>Date:</strong> {{ \Carbon\Carbon::parse($booking->date)->format('F d, Y') }}</li>
                <li><strong>Time:</strong> {{ \Carbon\Carbon::parse($booking->time)->format('h:i A') }}</li>
                <li><strong>Therapist:</strong> {{ $booking->therapist->name }}</li>
                <li><strong>Branch:</strong> {{ $booking->branch->name }}</li>
            </ul>
            <p>If you did not request this cancellation, please contact us immediately.</p>
            <p>We hope to see you again soon.</p>
            <p>Sincerely,<br>The Renzman Team</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Renzman. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

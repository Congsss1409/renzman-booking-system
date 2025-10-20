<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Booking Cancelled</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; color: #222; }
        .container { background: #fff; padding: 32px; border-radius: 12px; max-width: 500px; margin: 40px auto; box-shadow: 0 2px 8px rgba(0,0,0,0.07); }
        .header { font-size: 1.5em; color: #e53e3e; margin-bottom: 16px; }
        .details { margin: 24px 0; }
        .footer { color: #888; font-size: 0.95em; margin-top: 32px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Your Booking Has Been Cancelled</div>
        <p>Dear {{ $booking->client_name }},</p>
        <p>We regret to inform you that your booking at <strong>Renzman Massage</strong> has been cancelled.</p>
        <div class="details">
            <strong>Booking Details:</strong><br>
            Service: {{ $booking->service->name ?? 'N/A' }}<br>
            Therapist: {{ $booking->therapist->name ?? 'N/A' }}<br>
            Branch: {{ $booking->branch->name ?? 'N/A' }}<br>
            Date & Time: {{ $booking->start_time->format('F d, Y h:i A') }}<br>
        </div>
        <p>If you have any questions or would like to reschedule, please contact us.</p>
        <div class="footer">
            Thank you,<br>
            Renzman Massage Team
        </div>
    </div>
</body>
</html>

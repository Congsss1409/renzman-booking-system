<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Booking Cancelled</title>
        <style>
                body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#ffffff; margin:0; padding:0; }
                .hero { background:#0f9488; color:#fff; padding:44px 20px; text-align:center; }
                .hero img { max-width:120px; display:block; margin:0 auto 12px; }
                .hero h1 { font-size:28px; margin:18px 0 0; font-weight:700; }
                .content { background:#ffffff; padding:36px 20px; max-width:720px; margin:0 auto; }
                .container { max-width:620px; margin:0 auto; }
                .details { color:#374151; font-size:14px; line-height:1.7; margin:12px 0; }
                .footer { text-align:center; color:#94a3b8; font-size:13px; padding:24px 0; }
        </style>
</head>
<body>
    <div class="hero">
        @if(isset($message))
            <img src="{{ $message->embed(public_path('images/logo trans.png')) }}" alt="Renzman Logo">
        @endif
        <h1>Your Booking Has Been Cancelled</h1>
    </div>

    <div class="content">
        <div class="container">
            <p class="details">Dear {{ $booking->client_name }},</p>
            <p class="details">We regret to inform you that your booking at <strong>Renzman Massage</strong> has been cancelled.</p>

            <div class="details">
                <p><strong>Service:</strong> {{ $booking->service->name ?? 'N/A' }}</p>
                <p><strong>Therapist:</strong> {{ $booking->therapist->name ?? 'N/A' }}</p>
                <p><strong>Branch:</strong> {{ $booking->branch->name ?? 'N/A' }}</p>
                <p><strong>Date &amp; Time:</strong> {{ optional($booking->start_time)->format('F d, Y \a\t h:i A') }}</p>
            </div>

            <p class="details">If you have any questions or would like to reschedule, please contact us.</p>
        </div>
    </div>

    <div class="footer">Thank you,<br>Renzman Massage Team</div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Request - Renzman Spa</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#ffffff; margin:0; padding:0; }
        .hero { background:#0f9488; color:#fff; padding:44px 20px; text-align:center; }
        .hero img { max-width:120px; display:block; margin:0 auto 12px; }
        .hero h1 { font-size:28px; margin:18px 0 0; font-weight:700; }
        .content { background:#ffffff; padding:36px 20px; max-width:720px; margin:0 auto; }
        .container { max-width:620px; margin:0 auto; }
        .meta { color:#374151; font-size:14px; }
        .booking-info { background:#f8fafc; padding:16px; border-radius:8px; margin:18px 0; border-left:4px solid #34d399; }
        .btn { display:inline-block; background:#10b981; color:white; padding:12px 22px; border-radius:8px; text-decoration:none; font-weight:600; }
        .footer { text-align:center; color:#94a3b8; font-size:13px; padding:24px 0; }
    </style>
</head>
<body>
    <div class="hero">
        @if(isset($message))
            <img src="{{ $message->embed(public_path('images/logo trans.png')) }}" alt="Renzman Logo">
        @endif
        <h1>How was your experience?</h1>
    </div>

    <div class="content">
        <div class="container">
            <p class="meta">Hi {{ $booking->client_name }},</p>

            <p class="meta">Thank you for choosing Renzman Spa! We hope you enjoyed your recent {{ $booking->service->name ?? 'spa service' }} with {{ $booking->therapist->name ?? 'our therapist' }}.</p>

            <div class="booking-info">
                <h4 style="margin-top:0; color:#0f172a;">Your Service Details:</h4>
                <p><strong>Service:</strong> {{ $booking->service->name ?? 'N/A' }}</p>
                <p><strong>Therapist:</strong> {{ $booking->therapist->name ?? 'N/A' }}</p>
                <p><strong>Date:</strong> {{ $booking->start_time ? $booking->start_time->format('F d, Y \a\t h:i A') : 'N/A' }}</p>
                <p><strong>Location:</strong> {{ $booking->branch->name ?? 'N/A' }}</p>
            </div>

            <p class="meta">We would love to hear about your experience! Your feedback helps us continue to provide the best possible service to all our valued clients.</p>

            <div style="text-align:center; margin:20px 0;">
                <a href="{{ $feedbackUrl }}" class="btn">Share Your Feedback</a>
            </div>

            <p class="meta">It only takes a minute, and your honest review means the world to us!</p>

            <div class="footer">
                <p>If you have any concerns or need to contact us directly, please reply to this email or call us.</p>
                <p><strong>Renzman Spa</strong><br>Premium Spa Services</p>
            </div>
        </div>
    </div>
</body>
</html>
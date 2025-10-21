<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Request - Renzman Spa</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f8fafc; margin:0; padding:20px; }
        .email-wrapper { max-width:600px; margin:0 auto; }
        .card { background:#ffffff; border-radius:10px; padding:28px; box-shadow:0 6px 18px rgba(15,23,42,0.06); }
        .brand { text-align:center; margin-bottom:18px; }
        .brand .logo { font-size:22px; font-weight:700; color:#0f766e; }
        .brand .subtitle { color:#475569; font-size:13px; }
        h2.title { color:#059669; text-align:center; margin:6px 0 18px; }
        .meta { color:#374151; font-size:14px; }
        .booking-info { background:#f8fafc; padding:16px; border-radius:8px; margin:18px 0; border-left:4px solid #34d399; }
        .btn { display:inline-block; background:#10b981; color:white; padding:12px 22px; border-radius:8px; text-decoration:none; font-weight:600; }
        .footer { text-align:center; color:#6b7280; font-size:13px; margin-top:20px; }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <div class="card">
            <div class="brand">
                <div class="logo">RENZMAN SPA</div>
                <div class="subtitle">Premium Spa Services</div>
            </div>

            <h2 class="title">How was your experience?</h2>

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
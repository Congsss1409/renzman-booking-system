<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Request - Renzman Spa</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f3f7f5; margin:0; padding:24px 12px; color:#0f172a; }
        .wrapper { max-width:640px; margin:0 auto; }
        .card { background:#ffffff; border-radius:24px; overflow:hidden; box-shadow:0 24px 60px rgba(15,23,42,0.12); border:1px solid #e2e8f0; }
        .hero { background: linear-gradient(135deg,#0d9488,#10b981,#34d399); color:#fff; padding:48px 28px; text-align:center; }
        .hero img { max-width:120px; display:block; margin:0 auto 18px; }
        .hero h1 { font-size:28px; margin:0; font-weight:700; }
        .card-body { padding:36px 32px; line-height:1.7; font-size:15px; }
        .card-body p { margin:0 0 14px; }
        .booking-info { background:#f8fafc; padding:18px 20px; border-radius:16px; margin:22px 0; border:1px solid #e2e8f0; }
        .booking-info h4 { margin:0 0 12px; color:#0f172a; }
        .btn { display:inline-block; background:#10b981; color:white !important; padding:12px 28px; border-radius:9999px; text-decoration:none; font-weight:600; }
        .card-footer { background:#f8fafc; padding:20px 28px; text-align:center; font-size:13px; color:#64748b; }
        @media (max-width:600px) {
            body { padding:16px; }
            .hero { padding:36px 20px; }
            .card-body { padding:28px 20px; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="hero">
                @if(isset($message))
                    <img src="{{ $message->embed(public_path('images/logo trans.png')) }}" alt="Renzman Logo">
                @endif
                <h1>How was your experience?</h1>
            </div>
            <div class="card-body">
                <p>Hi {{ $booking->client_name }},</p>
                <p>Thank you for choosing Renzman Spa! We hope you enjoyed your recent {{ $booking->service->name ?? 'spa service' }} with {{ $booking->therapist->name ?? 'our therapist' }}.</p>
                <div class="booking-info">
                    <h4>Your Service Details</h4>
                    <p><strong>Service:</strong> {{ $booking->service->name ?? 'N/A' }}</p>
                    <p><strong>Therapist:</strong> {{ $booking->therapist->name ?? 'N/A' }}</p>
                    <p><strong>Date:</strong> {{ $booking->start_time ? $booking->start_time->format('F d, Y \a\t h:i A') : 'N/A' }}</p>
                    <p><strong>Location:</strong> {{ $booking->branch->name ?? 'N/A' }}</p>
                </div>
                <p>We would love to hear about your experience! Your feedback helps us continue to provide the best possible service to our valued clients.</p>
                <div style="text-align:center; margin:24px 0;">
                    <a href="{{ $feedbackUrl }}" class="btn">Share Your Feedback</a>
                </div>
                <p>It only takes a minute, and your honest review means the world to us!</p>
            </div>
            <div class="card-footer">
                <p>If you have any concerns or need to contact us directly, please reply to this email or call us.</p>
                <p><strong>Renzman Spa</strong><br>Premium Spa Services</p>
            </div>
        </div>
    </div>
</body>
</html>
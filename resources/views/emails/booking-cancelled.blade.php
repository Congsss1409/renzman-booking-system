<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Booking Cancelled</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f3f7f5; margin:0; padding:24px 12px; color:#0f172a; }
        .wrapper { max-width:640px; margin:0 auto; }
        .card { background:#ffffff; border-radius:24px; overflow:hidden; box-shadow:0 24px 60px rgba(15,23,42,0.12); border:1px solid #e2e8f0; }
        .hero { background: linear-gradient(135deg,#0d9488,#10b981,#34d399); color:#fff; padding:48px 28px; text-align:center; }
        .hero img { max-width:120px; display:block; margin:0 auto 18px; }
        .hero h1 { font-size:28px; margin:0; font-weight:700; }
        .card-body { padding:36px 32px; line-height:1.7; font-size:15px; }
        .card-body p { margin:0 0 14px; }
        .info-list { margin:20px 0; padding:0; list-style:none; border-radius:16px; background:#f8fafc; border:1px solid #e2e8f0; }
        .info-list li { padding:14px 18px; border-bottom:1px solid #e2e8f0; }
        .info-list li:last-child { border-bottom:none; }
        .info-label { font-weight:600; color:#b91c1c; display:block; margin-bottom:4px; }
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
                <h1>Your Booking Has Been Cancelled</h1>
            </div>
            <div class="card-body">
                <p>Dear {{ $booking->client_name }},</p>
                <p>We regret to inform you that your booking at <strong>Renzman Massage</strong> has been cancelled.</p>
                <ul class="info-list">
                    <li><span class="info-label">Service</span>{{ $booking->service->name ?? 'N/A' }}</li>
                    <li><span class="info-label">Therapist</span>{{ $booking->therapist->name ?? 'N/A' }}</li>
                    <li><span class="info-label">Branch</span>{{ $booking->branch->name ?? 'N/A' }}</li>
                    <li><span class="info-label">Date &amp; Time</span>{{ optional($booking->start_time)->format('F d, Y \a\t h:i A') }}</li>
                </ul>
                <p>If you have any questions or would like to reschedule, please contact us.</p>
            </div>
            <div class="card-footer">Thank you,<br>Renzman Massage Team</div>
        </div>
    </div>
</body>
</html>

@php $b = $booking; @endphp
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Booking Confirmation</title>
  <style>
  body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#ffffff; margin:0; padding:0; }
  .hero { background:#0f9488; color:#fff; padding:48px 20px; text-align:center; }
  .hero img { max-width:120px; display:block; margin:0 auto 12px; }
  .hero h1 { font-size:28px; margin:18px 0 0; font-weight:700; }
  .content { background:#ffffff; padding:36px 20px; max-width:720px; margin:0 auto; }
  .container { max-width:620px; margin:0 auto; }
  .greeting { color:#374151; font-size:15px; margin-bottom:14px; }
  .details { color:#374151; font-size:14px; line-height:1.7; }
  .cta { display:inline-block; background:#10b981; color:#fff; padding:12px 22px; border-radius:8px; text-decoration:none; font-weight:600; }
  .footer { text-align:center; color:#94a3b8; font-size:13px; padding:28px 0; }
  </style>
</head>
<body>
  <div class="hero">
  @if(isset($message))
  <img src="{{ $message->embed(public_path('images/logo trans.png')) }}" alt="Renzman Logo">
  @endif
  <h1>Booking Confirmed</h1>
  </div>

  <div class="content">
  <div class="container">
  <p class="greeting">Hi {{ $b->client_name }},</p>
  <p class="details">Your booking has been confirmed. Here are the details:</p>

  <div class="details" style="margin-top:12px; margin-bottom:8px;">
  <p><strong>Service:</strong> {{ $b->service->name ?? 'N/A' }}</p>
  <p><strong>Therapist:</strong> {{ $b->therapist->name ?? 'N/A' }}</p>
  <p><strong>Date &amp; Time:</strong> {{ optional($b->start_time)->format('F d, Y \a\t h:i A') }}</p>
  <p><strong>Branch:</strong> {{ $b->branch->name ?? 'N/A' }}</p>
  <p><strong>Price:</strong> ₱{{ number_format($b->price ?? 0, 2) }}</p>
  </div>

  @if(!empty($feedbackUrl))
  <div style="text-align:center; margin:20px 0;">
          <a href="{{ $feedbackUrl }}" class="cta">Share Your Feedback</a>
  </div>
  @endif

  <p class="details" style="margin-top:8px;">Thank you for booking with Renzman Spa.</p>
  </div>
  </div>

  <div class="footer">&copy; {{ date('Y') }} Renzman. All rights reserved.</div>
</body>
</html>
@php $b = $booking; @endphp

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Booking Confirmation</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f8fafc; margin:0; padding:20px; }
    .wrapper { max-width:600px; margin:0 auto; }
    .card { background:#fff; padding:26px; border-radius:10px; box-shadow:0 6px 18px rgba(15,23,42,0.06); }
    .brand { font-weight:700; color:#0f766e; margin-bottom:6px; }
    .subtitle { color:#475569; font-size:13px; margin-bottom:12px; }
    h1 { color:#065f46; margin:6px 0 14px; }
    .details { color:#374151; font-size:14px; }
    .btn { display:inline-block; background:#10b981; color:white; padding:12px 22px; border-radius:8px; text-decoration:none; font-weight:600; }
    .footer { text-align:center; color:#6b7280; font-size:13px; margin-top:20px; }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="card">
      <div class="brand">RENZMAN SPA</div>
      <div class="subtitle">Booking Confirmation</div>
      <h1>Booking Confirmed</h1>

      <p class="details">Hi {{ $b->client_name }},</p>
      <p class="details">Your booking has been confirmed. Here are the details:</p>

      <div class="details">
        <p><strong>Service:</strong> {{ $b->service->name ?? 'N/A' }}</p>
        <p><strong>Therapist:</strong> {{ $b->therapist->name ?? 'N/A' }}</p>
        <p><strong>Date &amp; Time:</strong> {{ optional($b->start_time)->format('F d, Y \a\t h:i A') }}</p>
        <p><strong>Branch:</strong> {{ $b->branch->name ?? 'N/A' }}</p>
        <p><strong>Price:</strong> ₱{{ number_format($b->price ?? 0, 2) }}</p>
      </div>

      <p class="details">Thank you for booking with Renzman Spa.</p>

      @if(!empty($feedbackUrl))
        <div style="text-align:center; margin:18px 0;">
          <a href="{{ $feedbackUrl }}" class="btn">Share Your Feedback</a>
        </div>
      @endif

      <div class="footer">
        &copy; {{ date('Y') }} Renzman. All rights reserved.
      </div>
    </div>
  </div>
</body>
</html>
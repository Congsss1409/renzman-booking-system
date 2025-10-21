@php $b = $booking; @endphp

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Booking Confirmation</title>
</head>
<body>
  <h2>Booking Confirmed</h2>
  <p>Hi {{ $b->client_name }},</p>
  <p>Your booking has been confirmed. Here are the details:</p>
  <ul>
    <li>Service: {{ $b->service->name ?? 'N/A' }}</li>
    <li>Therapist: {{ $b->therapist->name ?? 'N/A' }}</li>
    <li>Date & Time: {{ optional($b->start_time)->format('M d, Y, g:i A') }}</li>
    <li>Branch: {{ $b->branch->name ?? 'N/A' }}</li>
    <li>Price: ₱{{ number_format($b->price, 2) }}</li>
  </ul>
  <p>Thank you for booking with Renzman Blind Massage.</p>
</body>
</html>
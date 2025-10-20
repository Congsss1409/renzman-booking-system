<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Request - Renzman Spa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #2dd4bf;
            margin-bottom: 10px;
        }
        .subtitle {
            color: #666;
            font-size: 16px;
        }
        .booking-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid #2dd4bf;
        }
        .feedback-button {
            text-align: center;
            margin: 30px 0;
        }
        .btn {
            display: inline-block;
            background: #2dd4bf;
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 16px;
        }
        .btn:hover {
            background: #26a69a;
        }
        .stars {
            text-align: center;
            margin: 20px 0;
        }
        .star {
            font-size: 30px;
            color: #ddd;
            margin: 0 5px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #666;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">RENZMAN SPA</div>
            <div class="subtitle">Premium Spa Services</div>
        </div>

        <h2 style="color: #2dd4bf; text-align: center;">How was your experience?</h2>
        
        <p>Hi {{ $booking->client_name }},</p>
        
        <p>Thank you for choosing Renzman Spa! We hope you enjoyed your recent {{ $booking->service->name ?? 'spa service' }} with {{ $booking->therapist->name ?? 'our therapist' }}.</p>

        <div class="booking-info">
            <h4 style="margin-top: 0; color: #333;">Your Service Details:</h4>
            <p><strong>Service:</strong> {{ $booking->service->name ?? 'N/A' }}</p>
            <p><strong>Therapist:</strong> {{ $booking->therapist->name ?? 'N/A' }}</p>
            <p><strong>Date:</strong> {{ $booking->start_time ? $booking->start_time->format('F d, Y \a\t h:i A') : 'N/A' }}</p>
            <p><strong>Location:</strong> {{ $booking->branch->name ?? 'N/A' }}</p>
        </div>

        <p>We would love to hear about your experience! Your feedback helps us continue to provide the best possible service to all our valued clients.</p>

        <div class="stars">
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
            <span class="star">★</span>
        </div>

        <div class="feedback-button">
            <a href="{{ $feedbackUrl }}" class="btn">Share Your Feedback</a>
        </div>

        <p>It only takes a minute, and your honest review means the world to us!</p>

        <div class="footer">
            <p>If you have any concerns or need to contact us directly, please reply to this email or call us.</p>
            <p><strong>Renzman Spa</strong><br>
            Premium Spa Services<br>
            Thank you for being our valued client!</p>
        </div>
    </div>
</body>
</html>
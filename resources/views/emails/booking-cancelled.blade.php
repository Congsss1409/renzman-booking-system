{{-- resources/views/emails/booking-cancelled.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Cancellation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            background-color: #f3f4f6;
            color: #374151;
        }
    </style>
</head>
<body style="background-color: #f3f4f6; padding: 16px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 32px; border-radius: 8px;">
        <div style="text-align: center; margin-bottom: 32px;">
            <img src="{{ $message->embed(public_path('images/new.png')) }}" alt="Renzman Logo" style="height: 64px; margin: 0 auto;">
        </div>
        <h1 style="font-size: 24px; font-weight: bold; color: #111827; margin-bottom: 16px;">Hello, {{ $booking->client_name }},</h1>
        <p style="color: #4b5563; margin-bottom: 24px; line-height: 1.6;">
            This is a notification to inform you that your upcoming appointment with Renzman Blind Massage has been cancelled by our administration.
        </p>

        <div style="background-color: #f9fafb; padding: 24px; border-radius: 8px; border: 1px solid #e5e7eb;">
            <h2 style="font-size: 20px; font-weight: 600; margin-bottom: 16px; color: #1f2937;">Details of the Cancelled Appointment:</h2>
            <div style="font-size: 16px; color: #374151;">
                <div style="display: flex; justify-content: space-between; padding-bottom: 8px;">
                    <span>Service:</span>
                    <span style="font-weight: 600;">{{ $booking->service->name }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-top: 8px; padding-bottom: 8px;">
                    <span>Therapist:</span>
                    <span style="font-weight: 600;">{{ $booking->therapist->name }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-top: 8px; padding-bottom: 16px;">
                    <span>Date:</span>
                    <span style="font-weight: 600;">{{ $booking->start_time->format('F j, Y') }} at {{ $booking->start_time->format('g:i A') }}</span>
                </div>
            </div>
        </div>

        <p style="color: #4b5563; margin-top: 32px; font-size: 14px; line-height: 1.6;">
            If you believe this was in error or wish to reschedule, please contact us at 0932-423-3517 or 0977-392-6564, or simply book a new appointment on our website. We apologize for any inconvenience this may cause.
        </p>

        <div style="text-align: center; margin-top: 32px;">
             <a href="{{ url('/') }}" class="button" style="display: inline-block; background-color: #10B981; color: #ffffff; font-weight: bold; padding: 12px 24px; border-radius: 8px; text-decoration: none;">
                Book a New Appointment
            </a>
        </div>
    </div>
</body>
</html>

{{-- resources/views/emails/booking-confirmed.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    {{-- We use a script tag for Tailwind, but many styles are also inlined for email client compatibility --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
            background-color: #f3f4f6;
            color: #374151;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 32px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }
        .button {
            display: inline-block;
            background-color: #10B981;
            color: #ffffff;
            font-weight: bold;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .button:hover {
            background-color: #059669;
        }
    </style>
</head>
<body style="background-color: #f3f4f6; padding: 16px;">
    <div class="container" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 32px; border-radius: 8px;">
        <div style="text-align: center; margin-bottom: 32px;">
            {{-- Embedding the logo for email clients --}}
            <img src="{{ $message->embed(public_path('images/logo trans.png')) }}" alt="Renzman Logo" style="height: 64px; margin: 0 auto;">
        </div>
        <h1 style="font-size: 24px; font-weight: bold; color: #111827; margin-bottom: 16px;">Hello, {{ $booking->client_name }}!</h1>
        <p style="color: #4b5563; margin-bottom: 24px; line-height: 1.6;">
            Your appointment with Renzman Blind Massage has been successfully confirmed. We are excited to welcome you and provide a relaxing and rejuvenating experience.
        </p>

        <div style="background-color: #f9fafb; padding: 24px; border-radius: 8px; border: 1px solid #e5e7eb;">
            <h2 style="font-size: 20px; font-weight: 600; margin-bottom: 16px; color: #1f2937;">Your Booking Details:</h2>
            <div style="font-size: 16px; color: #374151;">
                <div style="display: flex; justify-content: space-between; padding-bottom: 8px;">
                    <span>Branch:</span>
                    <span style="font-weight: 600;">{{ $booking->branch->name }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-top: 8px; padding-bottom: 8px;">
                    <span>Service:</span>
                    <span style="font-weight: 600;">{{ $booking->service->name }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-top: 8px; padding-bottom: 8px;">
                    <span>Therapist:</span>
                    <span style="font-weight: 600;">{{ $booking->therapist->name }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-top: 8px; padding-bottom: 8px;">
                    <span>Date:</span>
                    <span style="font-weight: 600;">{{ $booking->start_time->format('F j, Y') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding-top: 8px; padding-bottom: 16px;">
                    <span>Time:</span>
                    <span style="font-weight: 600;">{{ $booking->start_time->format('g:i A') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; border-top: 1px solid #e5e7eb; padding-top: 16px; margin-top: 16px;">
                    <span style="font-size: 18px; font-weight: bold;">Total Price:</span>
                    <span style="font-size: 18px; font-weight: bold; color: #059669;">₱{{ number_format($booking->price, 2) }}</span>
                </div>
                 @if($booking->downpayment_amount > 0)
                <div style="display: flex; justify-content: space-between; padding-top: 8px;">
                    <span style="font-size: 16px;">Downpayment Paid:</span>
                    <span style="font-size: 16px; font-weight: 600;">- ₱{{ number_format($booking->downpayment_amount, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-weight: bold; padding-top: 8px;">
                    <span style="font-size: 16px;">Remaining Balance:</span>
                    <span style="font-size: 16px; font-weight: 600;">₱{{ number_format($booking->remaining_balance, 2) }}</span>
                </div>
                @endif
            </div>
        </div>

        <div style="text-align: center; margin-top: 32px; padding: 24px; background-color: #ECFDF5; border-radius: 8px;">
            <h3 style="font-weight: 600; font-size: 18px; color: #065F46;">How was your experience?</h3>
            <p style="color: #047857; margin-top: 8px;">After your session, please take a moment to leave us your feedback.</p>
            <a href="{{ route('feedback.create', $booking->feedback_token) }}" class="button" style="margin-top: 16px; display: inline-block; background-color: #10B981; color: #ffffff; font-weight: bold; padding: 12px 24px; border-radius: 8px; text-decoration: none;">
                Leave Feedback
            </a>
        </div>

        <p style="color: #4b5563; margin-top: 32px; font-size: 14px; line-height: 1.6;">
            If you need to cancel or reschedule, please contact us at least 24 hours in advance. You can reach us at 0932-423-3517 or 0977-392-6564.
        </p>

        <div style="text-align: center; margin-top: 32px; font-size: 12px; color: #9ca3af;">
            <p>Renzman Blind Massage Therapy</p>
            <p>&copy; {{ date('Y') }} All rights reserved.</p>
        </div>
    </div>
</body>
</html>

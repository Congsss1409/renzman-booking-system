{{-- resources/views/emails/booking-confirmed.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: ui-sans-serif, system-ui, sans-serif; }
    </style>
</head>
<body class="bg-gray-100 p-4 sm:p-6">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md">
        <div class="text-center mb-8">
            <img src="{{ $message->embed(public_path('images/logo trans.png')) }}" alt="Renzman Logo" class="h-16 mx-auto">
        </div>
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Hello, {{ $booking->client_name }}!</h1>
        <p class="text-gray-600 mb-6">Your appointment with Renzman Blind Massage has been successfully confirmed. We look forward to seeing you.</p>

        <div class="bg-gray-50 p-6 rounded-lg border">
            <h2 class="text-xl font-semibold mb-4 text-gray-800">Your Booking Details:</h2>
            <div class="space-y-3 text-gray-700">
                <div class="flex justify-between"><span>Branch:</span><span class="font-semibold">{{ $booking->branch->name }}</span></div>
                <div class="flex justify-between"><span>Service:</span><span class="font-semibold">{{ $booking->service->name }}</span></div>
                <div class="flex justify-between"><span>Therapist:</span><span class="font-semibold">{{ $booking->therapist->name }}</span></div>
                <div class="flex justify-between"><span>Date:</span><span class="font-semibold">{{ $booking->start_time->format('F j, Y') }}</span></div>
                <div class="flex justify-between"><span>Time:</span><span class="font-semibold">{{ $booking->start_time->format('g:i A') }}</span></div>
                <div class="flex justify-between border-t pt-3 mt-3"><span class="text-lg font-bold">Total Price:</span><span class="text-lg font-bold text-emerald-600">₱{{ number_format($booking->price, 2) }}</span></div>
            </div>
        </div>

        {{-- NEW FEEDBACK SECTION --}}
        <div class="text-center mt-8 p-6 bg-emerald-50 rounded-lg">
            <h3 class="font-semibold text-lg text-emerald-800">How was your experience?</h3>
            <p class="text-emerald-700 mt-2">After your session, please take a moment to leave us your feedback. It helps us improve our service.</p>
            <a href="{{ route('feedback.create', $booking->feedback_token) }}" class="mt-4 inline-block bg-emerald-600 text-white font-bold py-2 px-5 rounded-lg hover:bg-emerald-700 transition-colors">
                Leave Feedback
            </a>
        </div>

        <p class="text-gray-600 mt-8 text-sm">
            If you need to cancel or reschedule, please contact us at least 24 hours in advance. You can reach us at 0932-423-3517 or 0977-392-6564.
        </p>
    </div>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Booking Cancelled</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f8fafc; margin:0; padding:20px; }
        .wrapper { max-width:600px; margin:0 auto; }
        .card { background:#fff; padding:26px; border-radius:10px; box-shadow:0 6px 18px rgba(15,23,42,0.06); }
        .brand { font-weight:700; color:#0f766e; margin-bottom:6px; }
        h1 { color:#b91c1c; margin:6px 0 12px; }
        .details { color:#374151; font-size:14px; margin:14px 0; }
        .footer { text-align:center; color:#6b7280; font-size:13px; margin-top:20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="brand">RENZMAN SPA</div>
            <h1>Your Booking Has Been Cancelled</h1>

            <p class="details">Dear <?php echo e($booking->client_name); ?>,</p>
            <p class="details">We regret to inform you that your booking at <strong>Renzman Massage</strong> has been cancelled.</p>

            <div class="details">
                <strong>Booking Details:</strong><br>
                <p><strong>Service:</strong> <?php echo e($booking->service->name ?? 'N/A'); ?></p>
                <p><strong>Therapist:</strong> <?php echo e($booking->therapist->name ?? 'N/A'); ?></p>
                <p><strong>Branch:</strong> <?php echo e($booking->branch->name ?? 'N/A'); ?></p>
                <p><strong>Date &amp; Time:</strong> <?php echo e(optional($booking->start_time)->format('F d, Y \a\t h:i A')); ?></p>
            </div>

            <p class="details">If you have any questions or would like to reschedule, please contact us.</p>

            <div class="footer">
                Thank you,<br>
                Renzman Massage Team
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Vincen Basa\Desktop\renzman-booking-system\resources\views/emails/booking-cancelled.blade.php ENDPATH**/ ?>
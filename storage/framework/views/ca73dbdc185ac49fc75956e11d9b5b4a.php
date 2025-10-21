<?php $b = $booking; ?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Booking Confirmation</title>
</head>
<body>
  <h2>Booking Confirmed</h2>
  <p>Hi <?php echo e($b->client_name); ?>,</p>
  <p>Your booking has been confirmed. Here are the details:</p>
  <ul>
    <li>Service: <?php echo e($b->service->name ?? 'N/A'); ?></li>
    <li>Therapist: <?php echo e($b->therapist->name ?? 'N/A'); ?></li>
    <li>Date & Time: <?php echo e(optional($b->start_time)->format('M d, Y, g:i A')); ?></li>
    <li>Branch: <?php echo e($b->branch->name ?? 'N/A'); ?></li>
    <li>Price: ₱<?php echo e(number_format($b->price, 2)); ?></li>
  </ul>
  <p>Thank you for booking with Renzman Blind Massage.</p>
</body>
</html><?php /**PATH C:\Users\Vincen Basa\Desktop\renzman-booking-system\resources\views/emails/booking-confirmed.blade.php ENDPATH**/ ?>
<?php $b = $booking; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Booking Confirmation</title>
  <style>
    body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f3f7f5; margin:0; padding:24px 12px; color:#0f172a; }
    .wrapper { max-width:640px; margin:0 auto; }
    .card { background:#ffffff; border-radius:24px; overflow:hidden; box-shadow:0 24px 60px rgba(15,23,42,0.12); border:1px solid #e2e8f0; }
    .card-header { background:linear-gradient(135deg,#0d9488,#10b981,#34d399); padding:48px 28px; text-align:center; color:#ffffff; }
    .card-header img { max-width:120px; display:block; margin:0 auto 20px; }
    .card-header h1 { margin:0; font-size:28px; font-weight:700; }
    .card-body { padding:36px 32px; line-height:1.7; font-size:15px; }
    .card-body p { margin:0 0 14px; }
    .info-list { margin:20px 0; padding:0; list-style:none; border-radius:16px; background:#f8fafc; border:1px solid #e2e8f0; }
    .info-list li { padding:14px 18px; border-bottom:1px solid #e2e8f0; }
    .info-list li:last-child { border-bottom:none; }
    .info-label { font-weight:600; color:#0f766e; display:block; margin-bottom:4px; }
    .cta { display:inline-block; margin-top:18px; padding:12px 26px; border-radius:9999px; background:#10b981; color:#ffffff !important; text-decoration:none; font-weight:600; }
    .card-footer { background:#f8fafc; padding:20px 28px; text-align:center; font-size:13px; color:#64748b; }
    @media (max-width:600px) {
      body { padding:16px; }
      .card-header { padding:36px 20px; }
      .card-body { padding:28px 20px; }
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="card">
      <div class="card-header">
        <?php if(isset($message)): ?>
          <img src="<?php echo e($message->embed(public_path('images/logo trans.png'))); ?>" alt="Renzman Logo">
        <?php endif; ?>
        <h1>Booking Confirmed</h1>
      </div>
      <div class="card-body">
        <p>Hi <?php echo e($b->client_name); ?>,</p>
        <p>Your booking has been confirmed. Here are the details:</p>
        <ul class="info-list">
          <li><span class="info-label">Service</span><?php echo e($b->service->name ?? 'N/A'); ?></li>
          <li><span class="info-label">Therapist</span><?php echo e($b->therapist->name ?? 'N/A'); ?></li>
          <li><span class="info-label">Date &amp; Time</span><?php echo e(optional($b->start_time)->format('F d, Y \a\t h:i A')); ?></li>
          <li><span class="info-label">Branch</span><?php echo e($b->branch->name ?? 'N/A'); ?></li>
          <li><span class="info-label">Price</span>₱<?php echo e(number_format($b->price ?? 0, 2)); ?></li>
        </ul>
        <?php if(!empty($feedbackUrl)): ?>
          <div style="text-align:center;">
            <a href="<?php echo e($feedbackUrl); ?>" class="cta">Share Your Feedback</a>
          </div>
        <?php endif; ?>
        <p style="margin-top:24px;">Thank you for booking with Renzman Spa.</p>
      </div>
      <div class="card-footer">&copy; <?php echo e(date('Y')); ?> Renzman. All rights reserved.</div>
    </div>
  </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views\emails\booking-confirmed.blade.php ENDPATH**/ ?>
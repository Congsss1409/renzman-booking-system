<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Verification Code</title>
    <style>
      body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f8fafc; margin:0; padding:20px; }
      .wrapper { max-width:600px; margin:0 auto; }
      .card { background:#fff; padding:24px; border-radius:10px; box-shadow:0 6px 18px rgba(15,23,42,0.06); text-align:center; }
      .brand { font-weight:700; color:#0f766e; margin-bottom:6px; }
      .subtitle { color:#475569; font-size:13px; margin-bottom:12px; }
      .code { font-size:36px; font-weight:800; letter-spacing:6px; color:#0f172a; margin:10px 0; }
      .muted { color:#6b7280; }
    </style>
  </head>
  <body>
    <div class="wrapper">
      <div class="card">
        <div class="brand">RENZMAN SPA</div>
        <div class="subtitle">Your verification code</div>
        <p style="margin:0 0 8px;">Use the following code to complete your verification:</p>
        <div class="code"><?php echo e($code); ?></div>
        <p class="muted">This code will expire in 2 minutes. If you didn't request this, please ignore this email.</p>
      </div>
    </div>
  </body>
</html>
<?php /**PATH C:\Users\Vincen Basa\Desktop\renzman-booking-system\resources\views/emails/two_factor_code.blade.php ENDPATH**/ ?>
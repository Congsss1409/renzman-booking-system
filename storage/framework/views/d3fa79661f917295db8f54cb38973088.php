<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Verification Code</title>
    <style>
      body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#f3f7f5; margin:0; padding:24px 12px; color:#0f172a; }
      .wrapper { max-width:640px; margin:0 auto; }
      .card { background:#ffffff; border-radius:24px; overflow:hidden; box-shadow:0 24px 60px rgba(15,23,42,0.12); border:1px solid #e2e8f0; }
      .hero { background: linear-gradient(135deg,#0d9488,#10b981,#34d399); color:#fff; padding:48px 28px; text-align:center; }
      .hero img { max-width:120px; display:block; margin:0 auto 18px; }
      .hero h1 { font-size:26px; margin:0; font-weight:700; }
      .content { padding:36px 32px; text-align:center; line-height:1.7; font-size:15px; }
      .code-box { display:inline-block; background:#eef3f6; border:1px solid #dbeafe; padding:22px 36px; border-radius:16px; font-weight:800; font-size:36px; letter-spacing:8px; color:#0f172a; margin:22px auto; }
      .muted { color:#64748b; }
      .card-footer { background:#f8fafc; text-align:center; color:#64748b; font-size:13px; padding:20px 28px; }
      @media (max-width:600px) {
        body { padding:16px; }
        .hero { padding:36px 20px; }
        .content { padding:28px 20px; }
        .code-box { font-size:30px; padding:18px 28px; }
      }
    </style>
  </head>
  <body>
    <div class="wrapper">
      <div class="card">
        <div class="hero">
          <?php if(isset($message)): ?>
            <img src="<?php echo e($message->embed(public_path('images/logo trans.png'))); ?>" alt="Renzman Logo">
          <?php endif; ?>
          <h1>Your verification code</h1>
        </div>
        <div class="content">
          <p>Use the following code to complete your verification:</p>
          <div class="code-box"><?php echo e($code); ?></div>
          <p class="muted">This code will expire in 2 minutes. If you didn't request this, please ignore this email.</p>
        </div>
        <div class="card-footer">&copy; <?php echo e(date('Y')); ?> Renzman. All rights reserved.</div>
      </div>
    </div>
  </body>
</html>
<?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views/emails/two_factor_code.blade.php ENDPATH**/ ?>
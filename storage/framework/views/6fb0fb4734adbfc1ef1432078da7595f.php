<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Booking Verification Code</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background:#f3f7f5; margin:0; padding:24px 12px; color:#0f172a; }
        .wrapper { max-width:640px; margin:0 auto; }
        .card { background:#ffffff; border-radius:24px; overflow:hidden; box-shadow:0 24px 60px rgba(15,23,42,0.12); border:1px solid #e2e8f0; }
        .header { background: linear-gradient(135deg,#0d9488,#10b981,#34d399); color:#ffffff; padding:48px 28px; text-align:center; }
        .header img { max-width:120px; display:block; margin:0 auto 16px; }
        .header h1 { margin:0; font-size:26px; font-weight:700; }
        .content { padding:36px 32px; line-height:1.7; font-size:15px; }
        .content p { margin:0 0 14px; }
        .code-container { text-align:center; margin:30px 0; }
        .code { font-size:36px; font-weight:700; letter-spacing:10px; padding:18px 28px; background:#eef2f7; color:#0f172a; border-radius:16px; display:inline-block; border:1px solid #dbeafe; }
        .card-footer { background:#f8fafc; padding:20px 28px; text-align:center; font-size:13px; color:#64748b; }
        @media (max-width:600px) {
            body { padding:16px; }
            .header { padding:36px 20px; }
            .content { padding:28px 20px; }
            .code { font-size:30px; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="card">
            <div class="header">
                <img src="<?php echo e($message->embed(public_path('images/logo trans.png'))); ?>" alt="Renzman Logo">
                <h1>Confirm Your Booking</h1>
            </div>
            <div class="content">
                <p>Hello <?php echo e($booking->client_name); ?>,</p>
                <p>Thank you for choosing Renzman! To secure your appointment, please use the verification code below. This code is valid for 2 minutes.</p>
                <div class="code-container">
                    <span class="code"><?php echo e($booking->verification_code); ?></span>
                </div>
                <p>If you did not request this booking, you can safely ignore this email.</p>
                <p>Thank you,<br>The Renzman Team</p>
            </div>
            <div class="card-footer">&copy; <?php echo e(date('Y')); ?> Renzman. All rights reserved.</div>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\renzman-booking-system\resources\views/emails/booking-verification.blade.php ENDPATH**/ ?>
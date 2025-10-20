<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Booking Verification Code</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .header {
            background-color: #0d9488; /* teal-600 */
            color: #ffffff;
            padding: 40px;
            text-align: center;
        }
        .header img {
            max-width: 100px;
        }
        .content {
            padding: 40px;
            line-height: 1.6;
            color: #4a5568;
        }
        .code-container {
            text-align: center;
            margin: 30px 0;
        }
        .code {
            font-size: 36px;
            font-weight: bold;
            letter-spacing: 8px;
            padding: 15px 25px;
            background-color: #edf2f7;
            color: #1a202c;
            border-radius: 8px;
            display: inline-block;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #718096;
            background-color: #f7fafc;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="<?php echo e($message->embed(public_path('images/logo trans.png'))); ?>" alt="Renzman Logo">
            <h1>Confirm Your Booking</h1>
        </div>
        <div class="content">
            <p>Hello <?php echo e($booking->client_name); ?>,</p>
            <p>Thank you for choosing Renzman! To secure your appointment, please use the following verification code. This code is valid for 10 minutes.</p>
            
            <div class="code-container">
                <span class="code"><?php echo e($booking->verification_code); ?></span>
            </div>

            <p>If you did not request this booking, you can safely ignore this email.</p>
            <p>Thank you,<br>The Renzman Team</p>
        </div>
        <div class="footer">
            <p>&copy; <?php echo e(date('Y')); ?> Renzman. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Desktop\renzman-booking-system\resources\views/emails/booking-verification.blade.php ENDPATH**/ ?>
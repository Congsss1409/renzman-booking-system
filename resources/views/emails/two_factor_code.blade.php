<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Verification Code</title>
    <style>
      body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; background:#ffffff; margin:0; padding:0; }
      .hero { background:#0f9488; color:#fff; padding:44px 20px; text-align:center; }
      .hero img { max-width:120px; display:block; margin:0 auto 12px; }
      .hero h1 { font-size:24px; margin:8px 0 0; font-weight:700; }
      .content { padding:36px 20px; max-width:720px; margin:0 auto; }
      .container { max-width:620px; margin:0 auto; text-align:center; }
      .code-box { display:inline-block; background:#eef3f6; padding:22px 36px; border-radius:10px; font-weight:800; font-size:36px; letter-spacing:6px; color:#0f172a; margin:18px auto; }
      .muted { color:#6b7280; }
      .footer { text-align:center; color:#94a3b8; font-size:13px; padding:24px 0; }
    </style>
  </head>
  <body>
    <div class="hero">
      @if(isset($message))
        <img src="{{ $message->embed(public_path('images/logo trans.png')) }}" alt="Renzman Logo">
      @endif
      <h1>Your verification code</h1>
    </div>

    <div class="content">
      <div class="container">
        <p style="margin:0 0 8px; color:#374151;">Use the following code to complete your verification:</p>
        <div class="code-box">{{ $code }}</div>
        <p class="muted">This code will expire in 2 minutes. If you didn't request this, please ignore this email.</p>
      </div>
    </div>

    <div class="footer">&copy; {{ date('Y') }} Renzman. All rights reserved.</div>
  </body>
</html>

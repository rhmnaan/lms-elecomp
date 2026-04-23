<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f4f7fa;
            padding: 40px 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .header {
            background: linear-gradient(135deg, #03AADE 0%, #0D2656 100%);
            padding: 40px 30px;
            text-align: center;
        }
        .logo {
            width: 60px;
            height: 60px;
            background: rgba(255,255,255,0.2);
            border-radius: 14px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
        }
        .logo-text {
            font-size: 28px;
            color: #ffffff;
            font-weight: 700;
        }
        .header h1 {
            color: #ffffff;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .header p {
            color: rgba(255,255,255,0.85);
            font-size: 14px;
        }
        .content {
            padding: 40px 30px;
        }
        .greeting {
            font-size: 18px;
            color: #0A1628;
            font-weight: 600;
            margin-bottom: 16px;
        }
        .message {
            font-size: 15px;
            color: #6B7A9B;
            line-height: 1.6;
            margin-bottom: 28px;
        }
        .button-container {
            text-align: center;
            margin: 32px 0;
        }
        .verify-button {
            display: inline-block;
            padding: 16px 40px;
            background: linear-gradient(135deg, #03AADE 0%, #0D2656 100%);
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 0 8px 20px rgba(3,170,222,0.35);
            transition: all 0.3s;
        }
        .verify-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(3,170,222,0.45);
        }
        .alt-link {
            background: #F4F7FC;
            padding: 20px;
            border-radius: 10px;
            margin: 24px 0;
        }
        .alt-link p {
            font-size: 13px;
            color: #6B7A9B;
            margin-bottom: 8px;
        }
        .alt-link a {
            color: #03AADE;
            word-break: break-all;
            font-size: 13px;
            text-decoration: none;
        }
        .expiry-notice {
            background: #FFF9E6;
            border-left: 4px solid #FFB700;
            padding: 16px 20px;
            border-radius: 8px;
            margin: 24px 0;
        }
        .expiry-notice p {
            font-size: 14px;
            color: #8A6D00;
            margin: 0;
        }
        .footer {
            background: #F8FAFC;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #E2E8F0;
        }
        .footer p {
            font-size: 13px;
            color: #9BADD0;
            line-height: 1.6;
            margin-bottom: 8px;
        }
        .footer .brand {
            font-weight: 600;
            color: #0D2656;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <span class="logo-text">⚡</span>
            </div>
            <h1>Verifikasi Email Anda</h1>
            <p>LMS Elecomp - Learning Management System</p>
        </div>

        <div class="content">
            <p class="greeting">Halo, <?= esc($nama) ?>! 👋</p>

            <p class="message">
                Terima kasih telah mendaftar di <strong>LMS Elecomp</strong>. 
                Untuk mengaktifkan akun Anda dan mulai belajar, silakan verifikasi 
                alamat email Anda dengan mengklik tombol di bawah ini:
            </p>

            <div class="button-container">
                <a href="<?= $link ?>" class="verify-button">
                    Verifikasi Email Saya
                </a>
            </div>

            <div class="expiry-notice">
                <p>⏰ <strong>Link ini berlaku selama 24 jam</strong> sejak email ini dikirim.</p>
            </div>

            <div class="alt-link">
                <p>Atau copy link berikut ke browser Anda:</p>
                <a href="<?= $link ?>"><?= $link ?></a>
            </div>

            <p class="message" style="margin-top: 28px; font-size: 14px;">
                Jika Anda tidak mendaftar di LMS Elecomp, abaikan email ini. 
                Akun tidak akan dibuat tanpa verifikasi email.
            </p>
        </div>

        <div class="footer">
            <p class="brand">LMS Elecomp</p>
            <p>Learning Management System untuk Elecomp School</p>
            <p style="margin-top: 16px; font-size: 12px;">
                © <?= date('Y') ?> LMS Elecomp. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
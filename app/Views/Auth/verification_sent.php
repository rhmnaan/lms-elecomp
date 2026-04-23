<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Email Anda — LMS Elecomp</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --blue-deep:  #0A1628;
            --blue-mid:   #0D2656;
            --blue-sky:   #03AADE;
            --accent:     #00E5C0;
            --white:      #FFFFFF;
        }
        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(135deg, var(--blue-deep) 0%, var(--blue-mid) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: white;
            max-width: 500px;
            width: 100%;
            border-radius: 20px;
            padding: 48px 40px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .icon-wrap {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--accent), var(--blue-sky));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            box-shadow: 0 12px 30px rgba(3,170,222,0.4);
        }
        .icon-wrap i {
            font-size: 36px;
            color: white;
        }
        h1 {
            font-family: 'Syne', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: var(--blue-deep);
            margin-bottom: 12px;
        }
        p {
            font-size: 15px;
            color: #6B7A9B;
            line-height: 1.7;
            margin-bottom: 24px;
        }
        .steps {
            background: #F8FAFC;
            border-radius: 12px;
            padding: 24px;
            margin: 28px 0;
            text-align: left;
        }
        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
        }
        .step-item:last-child { margin-bottom: 0; }
        .step-num {
            width: 28px;
            height: 28px;
            background: var(--blue-sky);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
        }
        .step-text {
            font-size: 14px;
            color: #3D4B6B;
            padding-top: 4px;
        }
        .btn {
            display: inline-block;
            padding: 14px 28px;
            background: linear-gradient(135deg, var(--blue-sky), var(--blue-mid));
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            box-shadow: 0 8px 20px rgba(3,170,222,0.35);
            transition: all 0.3s;
            margin-top: 8px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(3,170,222,0.45);
        }
        .footer-note {
            font-size: 13px;
            color: #9BADD0;
            margin-top: 28px;
        }
        .footer-note a {
            color: var(--blue-sky);
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon-wrap">
            <i class="fas fa-envelope-circle-check"></i>
        </div>

        <h1>Cek Email Anda! 📧</h1>

        <p>
            Kami telah mengirim link verifikasi ke email Anda. 
            Silakan periksa inbox (atau folder spam) dan klik link 
            untuk mengaktifkan akun Anda.
        </p>

        <div class="steps">
            <div class="step-item">
                <div class="step-num">1</div>
                <div class="step-text">Buka email Anda dan cari email dari LMS Elecomp</div>
            </div>
            <div class="step-item">
                <div class="step-num">2</div>
                <div class="step-text">Klik tombol "Verifikasi Email Saya"</div>
            </div>
            <div class="step-item">
                <div class="step-num">3</div>
                <div class="step-text">Anda akan langsung diarahkan ke dashboard</div>
            </div>
        </div>

        <p style="font-size: 14px; color: #9BADD0;">
            <strong>Tidak menerima email?</strong><br>
            Periksa folder spam atau tunggu beberapa menit.
        </p>

        <a href="<?= base_url('/login') ?>" class="btn">
            <i class="fas fa-arrow-left"></i> Kembali ke Login
        </a>

        <p class="footer-note">
            Butuh bantuan? <a href="mailto:support@elecomp.sch.id">Hubungi Support</a>
        </p>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email — LMS Elecomp</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { 
            box-sizing: border-box; 
            margin: 0; 
            padding: 0; 
        }
        
        :root {
            --blue-deep:  #0A1628;
            --blue-mid:   #0D2656;
            --blue-sky:   #03AADE;
            --accent:     #00E5C0;
            --white:      #FFFFFF;
            --gray:       #6B7A9B;
        }
        
        html {
            overflow-y: auto;
            overflow-x: hidden;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: radial-gradient(ellipse at top, #0D3580 0%, #0A1628 60%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
            position: relative;
            overflow-y: auto;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(3, 170, 222, .12) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(0, 229, 192, .08) 0%, transparent 45%);
            pointer-events: none;
            z-index: 0;
        }
        
        .card {
            background: white;
            max-width: 520px;
            width: 100%;
            border-radius: 24px;
            padding: 48px 36px;
            text-align: center;
            box-shadow: 0 30px 80px rgba(0,0,0,0.35);
            position: relative;
            z-index: 1;
            margin: 20px auto;
            animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .icon-wrap {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, var(--accent), var(--blue-sky));
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            box-shadow: 0 12px 32px rgba(3,170,222,0.35);
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .icon-wrap i {
            font-size: 32px;
            color: white;
        }
        
        h1 {
            font-family: 'Syne', sans-serif;
            font-size: 26px;
            font-weight: 800;
            color: var(--blue-deep);
            margin-bottom: 12px;
            line-height: 1.2;
        }
        
        .subtitle {
            font-size: 15px;
            color: var(--gray);
            line-height: 1.6;
            margin-bottom: 32px;
        }

        .alert-box {
            background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%);
            border: 1.5px solid #93C5FD;
            border-radius: 14px;
            padding: 18px 20px;
            margin-bottom: 28px;
            text-align: left;
        }

        .alert-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .alert-header i {
            color: #2563EB;
            font-size: 18px;
        }

        .alert-header strong {
            font-size: 14px;
            color: #1E40AF;
            font-weight: 600;
        }

        .alert-text {
            font-size: 13.5px;
            color: #1E3A8A;
            line-height: 1.6;
            padding-left: 28px;
        }

        .instruction-box {
            background: #F8FAFC;
            border-radius: 12px;
            padding: 20px;
            margin: 24px 0;
            text-align: left;
        }

        .instruction-title {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .step-item {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 12px;
            padding: 12px;
            background: white;
            border-radius: 10px;
            border: 1px solid #E2E8F0;
            transition: all 0.2s;
        }

        .step-item:hover {
            border-color: var(--blue-sky);
            box-shadow: 0 4px 12px rgba(3,170,222,0.15);
        }

        .step-item:last-child { 
            margin-bottom: 0; 
        }

        .step-num {
            width: 26px;
            height: 26px;
            background: var(--blue-sky);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .step-text {
            font-size: 13.5px;
            color: #334155;
            padding-top: 3px;
            line-height: 1.5;
        }

        .step-text strong {
            color: var(--blue-deep);
        }

        .spam-warning {
            background: #FFF7ED;
            border: 1.5px solid #FED7AA;
            border-radius: 12px;
            padding: 16px 18px;
            margin: 24px 0;
            display: flex;
            align-items: flex-start;
            gap: 12px;
        }

        .spam-warning i {
            color: #EA580C;
            font-size: 18px;
            flex-shrink: 0;
            margin-top: 2px;
        }

        .spam-warning-text {
            font-size: 13px;
            color: #9A3412;
            line-height: 1.6;
            text-align: left;
        }

        .spam-warning-text strong {
            display: block;
            font-weight: 600;
            margin-bottom: 4px;
            color: #7C2D12;
        }

        .faq-section {
            margin-top: 32px;
            padding-top: 28px;
            border-top: 1px solid #E2E8F0;
        }

        .faq-title {
            font-size: 13px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            text-align: left;
        }

        .faq-item {
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 10px;
            padding: 14px 16px;
            margin-bottom: 10px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .faq-item:hover {
            background: #EFF6FF;
            border-color: #93C5FD;
        }

        .faq-item summary {
            font-size: 13.5px;
            font-weight: 600;
            color: #334155;
            list-style: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            outline: none;
        }

        .faq-item summary::-webkit-details-marker {
            display: none;
        }

        .faq-item summary::after {
            content: '+';
            font-size: 20px;
            color: var(--blue-sky);
            transition: transform 0.2s;
            font-weight: 400;
        }

        .faq-item[open] summary::after {
            transform: rotate(45deg);
        }

        .faq-item p {
            font-size: 13px;
            color: #64748B;
            line-height: 1.6;
            margin: 0;
            padding-top: 12px;
            margin-top: 10px;
            border-top: 1px solid #E2E8F0;
            text-align: left;
        }
        
        .btn-group {
            display: flex;
            gap: 10px;
            margin-top: 28px;
        }

        .btn {
            flex: 1;
            padding: 14px 20px;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--blue-sky), var(--blue-mid));
            color: white;
            box-shadow: 0 8px 20px rgba(3,170,222,0.35);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(3,170,222,0.45);
        }

        .btn-secondary {
            background: white;
            color: #475569;
            border: 1.5px solid #E2E8F5;
        }

        .btn-secondary:hover {
            background: #F8FAFC;
            border-color: #CBD5E1;
        }
        
        .footer-note {
            font-size: 12.5px;
            color: #94A3B8;
            margin-top: 24px;
            padding-top: 24px;
            border-top: 1px solid #E2E8F0;
            line-height: 1.6;
        }
        
        .footer-note a {
            color: var(--blue-sky);
            text-decoration: none;
            font-weight: 500;
        }

        .footer-note a:hover {
            text-decoration: underline;
        }

        @media (max-width: 580px) {
            body {
                padding: 40px 16px;
            }

            .card {
                padding: 36px 24px;
            }
            
            h1 {
                font-size: 22px;
            }

            .btn-group {
                flex-direction: column;
            }

            .alert-text {
                padding-left: 0;
            }

            .spam-warning {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .spam-warning-text {
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon-wrap">
            <i class="fas fa-envelope-circle-check"></i>
        </div>

        <h1>Periksa Email Anda</h1>
        <p class="subtitle">
            Kami telah mengirim link verifikasi ke email Anda.<br>
            Verifikasi diperlukan untuk mengaktifkan akun.
        </p>

        <div class="alert-box">
            <div class="alert-header">
                <i class="fas fa-circle-info"></i>
                <strong>Langkah Selanjutnya</strong>
            </div>
            <div class="alert-text">
                Buka email Anda dan klik tombol verifikasi. Anda akan langsung masuk ke dashboard setelah verifikasi berhasil.
            </div>
        </div>

        <div class="instruction-box">
            <div class="instruction-title">Cara Verifikasi Email</div>
            
            <div class="step-item">
                <div class="step-num">1</div>
                <div class="step-text">Buka inbox email Anda dan cari email dari <strong>LMS Elecomp</strong></div>
            </div>
            
            <div class="step-item">
                <div class="step-num">2</div>
                <div class="step-text">Klik tombol <strong>"Verifikasi Email Saya"</strong> dalam email tersebut</div>
            </div>
            
            <div class="step-item">
                <div class="step-num">3</div>
                <div class="step-text">Anda akan otomatis login dan diarahkan ke dashboard</div>
            </div>
        </div>

        <div class="spam-warning">
            <i class="fas fa-triangle-exclamation"></i>
            <div class="spam-warning-text">
                <strong>Tidak menemukan email?</strong>
                Periksa folder <strong>Spam</strong> atau <strong>Promosi</strong> Anda. Email verifikasi kadang masuk ke folder tersebut. Jika sudah lebih dari 5 menit, Anda bisa kirim ulang email verifikasi dari halaman login.
            </div>
        </div>

        <div class="faq-section">
            <div class="faq-title">Pertanyaan Umum</div>
            
            <details class="faq-item">
                <summary>Berapa lama link verifikasi berlaku?</summary>
                <p>Link verifikasi berlaku selama 24 jam. Setelah itu, Anda perlu meminta link baru dari halaman login.</p>
            </details>
            
            <details class="faq-item">
                <summary>Apa yang harus dilakukan jika link sudah kadaluwarsa?</summary>
                <p>Kembali ke halaman login, masukkan email dan password Anda, lalu klik tombol "Kirim Ulang Email Verifikasi".</p>
            </details>
            
            <details class="faq-item">
                <summary>Email tidak masuk sama sekali?</summary>
                <p>Pastikan email yang Anda daftarkan benar. Periksa folder Spam/Promosi. Jika masih belum ada, hubungi support kami.</p>
            </details>
        </div>

        <div class="btn-group">
            <a href="<?= base_url('/login') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Login
            </a>
            <!--<a href="mailto:?subject=Open%20Email" class="btn btn-primary">-->
            <!--    <i class="fas fa-envelope-open"></i>-->
            <!--    Buka Email Saya-->
            <!--</a>-->
        </div>

        <p class="footer-note">
            Butuh bantuan? <a href="mailto:support@elecomp.sch.id">Hubungi Support</a>
        </p>
    </div>
</body>
</html>
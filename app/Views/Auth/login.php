<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — LMS</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    :root {
        --blue-deep: #0A1628;
        --blue-mid: #0D2656;
        --blue-sky: #03AADE;
        --blue-light: #38C8F5;
        --accent: #00E5C0;
        --gold: #FFB700;
        --white: #FFFFFF;
        --gray-soft: #F0F4FA;
        --gray-muted: #8A9BBF;
        --danger: #FF4D6A;
    }

    html,
    body {
        height: 100%;
        font-family: 'DM Sans', sans-serif;
        background: var(--blue-deep);
        overflow: hidden;
        overflow-y: auto;
    }

    .bg-canvas {
        position: fixed;
        inset: 0;
        z-index: 0;
        background: radial-gradient(ellipse 80% 60% at 60% 40%, #0D3580 0%, #0A1628 60%);
        overflow: hidden;
    }

    .bg-canvas::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 20% 80%, rgba(3, 170, 222, .18) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(0, 229, 192, .12) 0%, transparent 45%), radial-gradient(circle at 50% 50%, rgba(13, 38, 86, .6) 0%, transparent 70%);
    }

    .grid-lines {
        position: absolute;
        inset: 0;
        opacity: .07;
        background-image: linear-gradient(rgba(56, 200, 245, 1) 1px, transparent 1px), linear-gradient(90deg, rgba(56, 200, 245, 1) 1px, transparent 1px);
        background-size: 48px 48px;
        mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 0%, transparent 75%);
    }

    .orb {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        opacity: .25;
        animation: floatOrb 12s ease-in-out infinite;
    }

    .orb-1 {
        width: 320px;
        height: 320px;
        background: var(--blue-sky);
        top: -80px;
        right: 10%;
        animation-delay: 0s;
    }

    .orb-2 {
        width: 200px;
        height: 200px;
        background: var(--accent);
        bottom: 10%;
        left: 5%;
        animation-delay: -4s;
    }

    .orb-3 {
        width: 160px;
        height: 160px;
        background: #5B40FF;
        bottom: 25%;
        right: 5%;
        animation-delay: -8s;
    }

    @keyframes floatOrb {

        0%,
        100% {
            transform: translateY(0) scale(1);
        }

        50% {
            transform: translateY(-30px) scale(1.08);
        }
    }

    .particles {
        position: absolute;
        inset: 0;
        pointer-events: none;
    }

    .particle {
        position: absolute;
        width: 2px;
        height: 2px;
        background: rgba(56, 200, 245, .7);
        border-radius: 50%;
        animation: particleDrift linear infinite;
    }

    @keyframes particleDrift {
        0% {
            transform: translateY(100vh) translateX(0);
            opacity: 0;
        }

        10% {
            opacity: 1;
        }

        90% {
            opacity: 1;
        }

        100% {
            transform: translateY(-10vh) translateX(40px);
            opacity: 0;
        }
    }

    .page-wrap {
        position: relative;
        z-index: 10;
        min-height: 100vh;
        display: grid;
        grid-template-columns: 1fr 480px;
        align-items: center;
    }

    .left-panel {
        padding: 60px 48px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        max-width: 600px;
        margin-left: auto;
        animation: slideInLeft .8s cubic-bezier(.16, 1, .3, 1) forwards;
        opacity: 0;
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-40px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .badge-top {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(3, 170, 222, .12);
        border: 1px solid rgba(3, 170, 222, .3);
        border-radius: 100px;
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 500;
        color: var(--blue-light);
        letter-spacing: .06em;
        text-transform: uppercase;
        margin-bottom: 28px;
        width: fit-content;
    }

    .badge-top span.dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--accent);
        animation: pulse 2s ease-in-out infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            opacity: 1;
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(0, 229, 192, .5);
        }

        50% {
            opacity: .8;
            transform: scale(1.3);
            box-shadow: 0 0 0 6px transparent;
        }
    }

    .hero-title {
        font-family: 'Syne', sans-serif;
        font-size: clamp(38px, 4vw, 56px);
        font-weight: 800;
        line-height: 1.05;
        color: var(--white);
        margin-bottom: 18px;
    }

    .hero-title .line-accent {
        display: block;
        background: linear-gradient(90deg, var(--blue-sky), var(--accent));
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }

    .hero-sub {
        font-size: 15px;
        line-height: 1.7;
        color: rgba(255, 255, 255, .5);
        max-width: 360px;
        margin-bottom: 40px;
    }

    .feature-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
    }

    .pill {
        display: flex;
        align-items: center;
        gap: 8px;
        background: rgba(255, 255, 255, .05);
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 100px;
        padding: 8px 14px;
        font-size: 13px;
        color: rgba(255, 255, 255, .6);
        backdrop-filter: blur(4px);
        transition: all .25s;
    }

    .pill i {
        color: var(--blue-sky);
        font-size: 12px;
    }

    .pill:hover {
        background: rgba(3, 170, 222, .1);
        border-color: rgba(3, 170, 222, .3);
        color: var(--white);
    }

    .card-wrap {
        padding: 32px 40px 40px;
        background: rgba(255, 255, 255, .96);
        backdrop-filter: blur(20px);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-shadow: -20px 0 80px rgba(0, 0, 0, .3);
        animation: slideInRight .8s cubic-bezier(.16, 1, .3, 1) .1s forwards;
        opacity: 0;
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(40px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .card-inner {
        max-width: 360px;
        margin: 0 auto;
        width: 100%;
    }

    .logo-area {
        text-align: center;
        padding: 16px 0 20px;
        position: relative;
    }

    .logo-mark {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        position: relative;
    }

    /* Wrapper untuk efek shine */
    .logo-shine-wrap {
        position: relative;
        display: inline-block;
        overflow: hidden;
        border-radius: 8px;
    }

    .logo-image {
        max-width: 300px;
        height: auto;
        width: 100%;
        display: block;
        animation: logoEntrance .8s cubic-bezier(.16, 1, .3, 1) .2s both,
            logoFloat 4s ease-in-out 1s infinite;
        filter: drop-shadow(0 4px 16px rgba(3, 170, 222, .35));
        transition: filter .3s;
    }

    /* Efek kilat/shine yang menyapu */
    .logo-shine-wrap::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -75%;
        width: 50%;
        height: 200%;
        background: linear-gradient(105deg,
                transparent 30%,
                rgba(255, 255, 255, .55) 50%,
                transparent 70%);
        transform: skewX(-15deg);
        animation: logoShine 3.5s ease-in-out 1.2s infinite;
        pointer-events: none;
    }

    .logo-image:hover {
        filter: drop-shadow(0 6px 24px rgba(3, 170, 222, .6));
    }

    @keyframes logoEntrance {
        from {
            opacity: 0;
            transform: translateY(-16px) scale(.92);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes logoFloat {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    @keyframes logoShine {
        0% {
            left: -75%;
            opacity: 0;
        }

        10% {
            opacity: 1;
        }

        40% {
            left: 125%;
            opacity: 1;
        }

        41%,
        100% {
            left: 125%;
            opacity: 0;
        }
    }

    @media (max-width: 768px) {
        .logo-image {
            max-width: 130px;
        }
    }

    .logo-icon {
        width: 42px;
        height: 42px;
        background: linear-gradient(135deg, var(--blue-sky), var(--blue-mid));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 20px rgba(3, 170, 222, .35);
    }

    .logo-icon i {
        color: #fff;
        font-size: 18px;
    }

    .logo-name {
        font-family: 'DM Sans', sans-serif;
        font-weight: 800;
        font-size: 20px;
        color: var(--blue-deep);
        letter-spacing: -.02em;
    }

    .logo-name span {
        color: var(--blue-sky);
    }

    .logo-tagline {
        font-size: 13px;
        color: var(--gray-muted);
        margin-top: 2px;
    }

    .form-heading {
        margin-bottom: 28px;
    }

    .form-heading h2 {
        font-family: 'Syne', sans-serif;
        font-size: 26px;
        font-weight: 700;
        color: var(--blue-deep);
        letter-spacing: -.02em;
        margin-bottom: 4px;
    }

    .form-heading p {
        font-size: 14px;
        color: var(--gray-muted);
    }

    .field {
        margin-bottom: 20px;
    }

    .field-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #3D4B6B;
        margin-bottom: 8px;
        letter-spacing: .01em;
    }

    .field-wrap {
        position: relative;
        display: flex;
        align-items: center;
    }

    .field-icon {
        position: absolute;
        left: 14px;
        color: #9BADD0;
        font-size: 14px;
        pointer-events: none;
        transition: color .2s;
    }

    .field-input {
        width: 100%;
        padding: 13px 14px 13px 42px;
        background: #F4F7FC;
        border: 1.5px solid #E2E8F5;
        border-radius: 12px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        color: var(--blue-deep);
        outline: none;
        transition: all .2s;
    }

    .field-input::placeholder {
        color: #B0BDDA;
    }

    .field-input:focus {
        background: #fff;
        border-color: var(--blue-sky);
        box-shadow: 0 0 0 4px rgba(3, 170, 222, .1);
    }

    .field-wrap:focus-within .field-icon {
        color: var(--blue-sky);
    }

    .toggle-pw {
        position: absolute;
        right: 12px;
        background: none;
        border: none;
        cursor: pointer;
        color: #9BADD0;
        padding: 4px;
        font-size: 14px;
        transition: color .2s;
    }

    .toggle-pw:hover {
        color: var(--blue-mid);
    }

    .error-box {
        display: none;
        background: #FFF0F3;
        border: 1px solid #FFCED8;
        border-radius: 10px;
        padding: 12px 14px;
        font-size: 13px;
        color: var(--danger);
        margin-bottom: 20px;
    }

    .error-box.show {
        display: block;
    }

    .btn-submit {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, var(--blue-sky) 0%, var(--blue-mid) 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-family: 'Syne', sans-serif;
        font-size: 15px;
        font-weight: 700;
        letter-spacing: .01em;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: all .25s;
        box-shadow: 0 8px 24px rgba(3, 170, 222, .35);
        margin-bottom: 20px;
        position: relative;
        overflow: hidden;
    }

    .btn-submit::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, var(--accent) 0%, var(--blue-sky) 100%);
        opacity: 0;
        transition: opacity .3s;
    }

    .btn-submit:hover::before {
        opacity: 1;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(3, 170, 222, .45);
    }

    .btn-submit:active {
        transform: translateY(0);
    }

    .btn-submit:disabled {
        opacity: .7;
        transform: none;
        cursor: not-allowed;
    }

    .btn-submit>* {
        position: relative;
        z-index: 1;
    }

    .spinner {
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, .4);
        border-top-color: white;
        border-radius: 50%;
        animation: spin .7s linear infinite;
        display: none;
    }

    .spinner.show {
        display: block;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 18px;
    }

    .divider::before,
    .divider::after {
        content: '';
        flex: 1;
        height: 1px;
        background: #E2E8F5;
    }

    .divider span {
        font-size: 12px;
        color: #B0BDDA;
        white-space: nowrap;
    }

    .card-footer-note {
        margin-top: 24px;
        text-align: center;
        font-size: 12px;
        color: #B0BDDA;
        line-height: 1.6;
    }

    .card-footer-note a {
        color: var(--blue-sky);
        text-decoration: none;
    }

    .card-footer-note a:hover {
        text-decoration: underline;
    }

    /* Modal */
    .modal-overlay {
        position: fixed;
        inset: 0;
        z-index: 99999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(8, 15, 30, .75);
        backdrop-filter: blur(10px);
    }

    .modal-overlay.show {
        display: flex;
    }

    .modal-card {
        background: #fff;
        width: 100%;
        max-width: 460px;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 30px 80px rgba(0, 0, 0, .35);
        animation: modalPop .4s cubic-bezier(.16, 1, .3, 1) forwards;
    }

    @keyframes modalPop {
        from {
            opacity: 0;
            transform: scale(.9) translateY(20px);
        }

        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .modal-top {
        padding: 28px 28px 24px;
        background: linear-gradient(135deg, #0D2656, #174EA6);
        position: relative;
        overflow: hidden;
    }

    .modal-top::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 140px;
        height: 140px;
        background: rgba(255, 255, 255, .05);
        border-radius: 50%;
    }

    .modal-warn-icon {
        width: 50px;
        height: 50px;
        background: rgba(255, 183, 0, .18);
        border: 1.5px solid rgba(255, 183, 0, .4);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
    }

    .modal-warn-icon i {
        color: var(--gold);
        font-size: 22px;
    }

    .modal-title {
        font-family: 'Syne', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: #fff;
        margin-bottom: 6px;
    }

    .modal-desc {
        font-size: 14px;
        color: rgba(255, 255, 255, .6);
        line-height: 1.5;
    }

    .modal-body {
        padding: 20px 28px;
    }

    .modal-info {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #EFF6FF;
        border: 1px solid #DBEAFE;
        border-radius: 10px;
        padding: 12px 14px;
        font-size: 13px;
        color: #1E40AF;
        line-height: 1.5;
    }

    .modal-info i {
        color: #3B82F6;
        flex-shrink: 0;
    }

    .modal-footer {
        padding: 16px 28px 24px;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .btn-m {
        padding: 10px 20px;
        border-radius: 10px;
        font-family: 'DM Sans', sans-serif;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 7px;
        transition: all .2s;
        border: none;
    }

    .btn-m-outline {
        background: #fff;
        border: 1.5px solid #E2E8F5;
        color: #374151;
    }

    .btn-m-outline:hover {
        background: #F4F7FC;
        border-color: #C5D0E8;
    }

    .btn-m-primary {
        background: linear-gradient(135deg, var(--blue-sky), var(--blue-mid));
        color: #fff;
        box-shadow: 0 4px 16px rgba(3, 170, 222, .3);
    }

    .btn-m-primary:hover {
        opacity: .9;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .page-wrap {
            grid-template-columns: 1fr;
        }

        .left-panel {
            display: none;
        }

        .card-wrap {
            min-height: 100vh;
            padding: 40px 28px;
            box-shadow: none;
        }
    }
    </style>
</head>

<body>
    <div class="bg-canvas">
        <div class="grid-lines"></div>
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
        <div class="particles" id="particles"></div>
    </div>

    <!-- Modal Konflik Sesi -->
    <div id="modal-konflik" class="modal-overlay" role="dialog" aria-modal="true">
        <div class="modal-card">
            <div class="modal-top">
                <div class="modal-warn-icon"><i class="fas fa-shield-exclamation"></i></div>
                <h3 class="modal-title">Konflik Sesi Terdeteksi</h3>
                <p class="modal-desc">Akun ini sedang aktif di perangkat atau tab lain. Pilih tindakan untuk
                    melanjutkan.</p>
            </div>
            <div class="modal-body">
                <div class="modal-info">
                    <i class="fas fa-circle-info"></i>
                    Login secara bersamaan di lebih dari satu perangkat tidak diizinkan demi keamanan akun Anda.
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="handleAction('other')" class="btn-m btn-m-outline">
                    <i class="fas fa-mobile-screen"></i> Gunakan di perangkat lain
                </button>
                <button onclick="handleAction('keep')" class="btn-m btn-m-primary">
                    <i class="fas fa-check"></i> Tetap gunakan di sini
                </button>
            </div>
        </div>
    </div>

    <div class="page-wrap">
        <div class="left-panel">
            <div class="badge-top"><span class="dot"></span> Platform Pembelajaran Digital</div>
            <h1 class="hero-title">
                Belajar Lebih<br>
                <span class="line-accent">Cerdas & Efisien</span>
            </h1>
            <p class="hero-sub">Akses materi, tugas, dan evaluasi kapan saja. Wujudkan potensi terbaik Anda bersama
                Elecomp.</p>
            <div class="feature-pills">
                <div class="pill"><i class="fas fa-book-open"></i> Materi Interaktif</div>
                <div class="pill"><i class="fas fa-chart-line"></i> Pantau Progres</div>
                <div class="pill"><i class="fas fa-users"></i> Kolaborasi Tim</div>
                <div class="pill"><i class="fas fa-trophy"></i> Sertifikasi</div>
                <div class="pill"><i class="fas fa-shield-halved"></i> Aman & Terpercaya</div>
            </div>
        </div>

        <div class="card-wrap">
            <div class="card-inner">
                <div class="logo-area">
                    <div class="logo-mark">
                        <img src="<?= base_url('logo/image.png') ?>" alt="Absys Group - Elecomp LMS" class="logo-image">
                    </div>
                </div>

                <div class="form-heading">
                    <p>Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                <div class="error-box" id="error-box"></div>

                <div class="field">
                    <label class="field-label" for="email">Username / Email</label>
                    <div class="field-wrap">
                        <i class="fas fa-user field-icon"></i>
                        <input type="text" id="email" class="field-input" placeholder="Username atau Email"
                            autocomplete="username">
                    </div>
                </div>

                <div class="field">
                    <label class="field-label" for="password">Password</label>
                    <div class="field-wrap">
                        <i class="fas fa-lock field-icon"></i>
                        <input type="password" id="password" class="field-input" placeholder="Masukkan password Anda"
                            autocomplete="current-password">
                        <button type="button" class="toggle-pw" id="toggle-pw" tabindex="-1">
                            <i class="fas fa-eye" id="eye-icon"></i>
                        </button>
                    </div>
                </div>

                <button class="btn-submit" id="btn-submit">
                    <span id="btn-label">Masuk</span>
                    <div class="spinner" id="spinner"></div>
                </button>

                <div class="divider"><span>Butuh bantuan?</span></div>

                <div class="card-footer-note">
                    Lupa password? <a href="<?= base_url('/forgot-password') ?>">Reset di sini</a><br>
                    Belum punya akun? <a href="<?= base_url('/register') ?>">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    </div>

    <script>
    const $ = id => document.getElementById(id);
    const BASE_URL = '<?= rtrim(base_url(), '/') ?>';

    // Particles
    (function() {
        const wrap = $('particles');
        for (let i = 0; i < 22; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            p.style.left = Math.random() * 100 + '%';
            p.style.animationDuration = (10 + Math.random() * 20) + 's';
            p.style.animationDelay = -(Math.random() * 25) + 's';
            p.style.width = p.style.height = (Math.random() > 0.6 ? 3 : 2) + 'px';
            p.style.opacity = (0.3 + Math.random() * 0.5).toString();
            wrap.appendChild(p);
        }
    })();

    // Fingerprint
    function generateFingerprint() {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        ctx.textBaseline = 'top';
        ctx.font = '14px Arial';
        ctx.fillText('fp', 2, 2);
        return hashStr([
            navigator.userAgent, navigator.language, screen.colorDepth,
            screen.width + 'x' + screen.height, new Date().getTimezoneOffset(),
            !!window.sessionStorage, !!window.localStorage, canvas.toDataURL(),
        ].join('|||'));
    }

    function hashStr(str) {
        let h = 0;
        for (let i = 0; i < str.length; i++) {
            h = (h << 5) - h + str.charCodeAt(i);
            h = h & h;
        }
        return Math.abs(h).toString(36);
    }

    function setCookieFP(value) {
        const exp = new Date();
        exp.setFullYear(exp.getFullYear() + 1);
        document.cookie = `device_fp=${value}; expires=${exp.toUTCString()}; path=/; SameSite=Strict`;
    }

    function getFP() {
        const m = document.cookie.match(/device_fp=([^;]+)/);
        if (m) return m[1];
        const fp = generateFingerprint();
        setCookieFP(fp);
        return fp;
    }

    getFP();

    function getCsrfToken() {
        const m = document.cookie.match(/csrf_test_name=([^;]+)/);
        return m ? decodeURIComponent(m[1]) : '';
    }

    // UI Helpers
    function showError(msg) {
        const box = $('error-box');
        box.style.background = '#FFF0F3';
        box.style.borderColor = '#FFCED8';
        box.style.color = 'var(--danger)';
        box.innerHTML = `<div style="display:flex;align-items:center;gap:8px;">
                <i class="fas fa-circle-exclamation"></i>
                <span>${msg}</span>
            </div>`;
        box.classList.add('show');
    }

    function showErrorWithResend(msg, email) {
        const box = $('error-box');
        box.style.background = '#FFF0F3';
        box.style.borderColor = '#FFCED8';
        box.style.color = 'var(--danger)';
        box.innerHTML = `
                <div style="display:flex;align-items:center;gap:8px;margin-bottom:10px;">
                    <i class="fas fa-circle-exclamation"></i>
                    <span>${msg}</span>
                </div>
                <button id="btn-resend" onclick="resendVerification('${email}')"
                    style="width:100%;padding:10px 14px;background:linear-gradient(135deg,#03AADE,#0D2656);
                    color:#fff;border:none;border-radius:8px;font-size:13px;font-weight:600;
                    cursor:pointer;display:flex;align-items:center;justify-content:center;gap:6px;margin-top:4px;">
                    <i class="fas fa-paper-plane"></i>
                    <span id="resend-label">Kirim Email Verifikasi</span>
                </button>
            `;
        box.classList.add('show');
    }

    function hideError() {
        $('error-box').classList.remove('show');
    }

    function setLoading(on) {
        $('btn-submit').disabled = on;
        $('spinner').classList.toggle('show', on);
        $('btn-label').textContent = on ? 'Memeriksa...' : 'Masuk';
    }

    // Toggle Password
    $('toggle-pw').addEventListener('click', () => {
        const pw = $('password');
        const ico = $('eye-icon');
        if (pw.type === 'password') {
            pw.type = 'text';
            ico.classList.replace('fa-eye', 'fa-eye-slash');
        } else {
            pw.type = 'password';
            ico.classList.replace('fa-eye-slash', 'fa-eye');
        }
    });

    // Resend Verification with Enhanced Feedback and Cooldown
async function resendVerification(email) {
    const btn = $('btn-resend');
    if (!btn || btn.disabled) return;

    // 1. Ubah UI saat status loading (Sedang Mengirim)
    btn.disabled = true;
    btn.style.opacity = '0.7';
    btn.style.cursor = 'not-allowed';
    btn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> <span id="resend-label">Sedang mengirim email verifikasi...</span>`;

    try {
        const form = new FormData();
        form.append('email', email);

        const res = await fetch(BASE_URL + '/auth/resend-verification', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: form,
        });
        
        if (!res.ok) throw new Error('Server error: ' + res.status);
        const data = await res.json();

        if (data.status === 'successful') {
            const box = $('error-box');
            // Mengubah box menjadi alert sukses hijau yang informatif
            box.style.background = '#ECFDF5';
            box.style.borderColor = '#A7F3D0';
            box.style.color = '#065F46';
            box.innerHTML = `
                <div style="display:flex; flex-direction:column; gap:8px;">
                    <div style="display:flex; align-items:center; gap:8px; font-weight:700;">
                        <i class="fas fa-circle-check" style="color:#10B981; font-size:16px;"></i>
                        <span>Email Berhasil Dikirim!</span>
                    </div>
                    <p style="font-size:12.5px; color:#047857; margin:0; line-height:1.5;">
                        Sistem telah mengirimkan tautan verifikasi baru ke <strong>${email}</strong>. 
                        Silakan periksa kotak masuk (Inbox) Anda.
                    </p>
                    <div style="margin-top:6px; padding:8px 10px; background:#F0FDF4; border-radius:6px; font-size:11.5px; color:#15803D;">
                        <i class="fas fa-circle-info"></i> Tidak menemukan email? Periksa folder <strong>Spam</strong> atau <strong>Promosi</strong> Anda.
                    </div>
                    <button id="btn-resend" disabled 
                        style="width:100%; padding:10px 14px; background:#D1D5DB; color:#9CA3AF; border:none; border-radius:8px; font-size:13px; font-weight:600; cursor:not-allowed; display:flex; align-items:center; justify-content:center; gap:6px; margin-top:6px;">
                        <i class="fas fa-clock"></i>
                        <span id="resend-countdown">Kirim ulang dalam 60s</span>
                    </button>
                </div>
            `;
            
            // 2. Jalankan fungsi Cooldown / Countdown Timer (60 Detik)
            startResendCooldown(email, 300);

        } else {
            // Jika backend mengembalikan status gagal
            resetResendButton(btn, 'Kirim Email Verifikasi');
            showError(data.message || 'Gagal mengirim email verifikasi.');
        }
    } catch (err) {
        console.error(err);
        resetResendButton(btn, 'Kirim Email Verifikasi');
        showError('Terjadi gangguan koneksi. Gagal mengirim ulang verifikasi.');
    }
}

// Fungsi Helper untuk mengembalikan kondisi tombol jika gagal
function resetResendButton(btn, labelText) {
    btn.disabled = false;
    btn.style.opacity = '1';
    btn.style.cursor = 'pointer';
    btn.innerHTML = `<i class="fas fa-paper-plane"></i> <span id="resend-label">${labelText}</span>`;
}

// Fungsi untuk menghitung mundur (Cooldown) agar tidak di-spam oleh user
function startResendCooldown(email, seconds) {
    let timeLeft = seconds;
    const countdownLabel = document.getElementById('resend-countdown');
    const resendBtn = document.getElementById('btn-resend');

    const timer = setInterval(() => {
        timeLeft--;
        if (timeLeft > 0) {
            if (countdownLabel) countdownLabel.textContent = `Kirim ulang dalam ${timeLeft}s`;
        } else {
            clearInterval(timer);
            // Ketika waktu habis, bangun ulang struktur tombol ke kondisi aktif
            if (resendBtn) {
                resendBtn.disabled = false;
                resendBtn.style.background = 'linear-gradient(135deg, #03AADE, #0D2656)';
                resendBtn.style.color = '#fff';
                resendBtn.style.cursor = 'pointer';
                resendBtn.setAttribute('onclick', `resendVerification('${email}')`);
                resendBtn.innerHTML = `<i class="fas fa-paper-plane"></i> <span>Kirim Ulang Email Verifikasi</span>`;
            }
        }
    }, 1000);
}

    // Main Login Flow
    async function fetchHandler(email, pass, action = '') {
        hideError();
        setLoading(true);

        try {
            const fpRes = await fetch(BASE_URL + '/cekfingerprint', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    email,
                    pass,
                    action,
                    fp: getFP()
                }),
            });
            if (!fpRes.ok) throw new Error('Server error: ' + fpRes.status);
            const fpData = await fpRes.json();

            if (fpData.status === 'invalid') {
                showError(fpData.message);
                return;
            }
            if (!fpData.valid) {
                $('modal-konflik').classList.add('show');
                return;
            }

            const form = new FormData();
            form.append('email', email);
            form.append('password', pass);

            const loginRes = await fetch(BASE_URL + '/auth/authenticate', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: form,
            });
            if (!loginRes.ok) throw new Error('Server error: ' + loginRes.status);
            const loginData = await loginRes.json();

            if (loginData.status === 'successful') {
                window.location.href = loginData.redirect;
            } else if (loginData.status === 'unverified') {
                showErrorWithResend(loginData.message, loginData.email);
            } else {
                showError(loginData.message || 'Login gagal.');
            }

        } catch (err) {
            console.error(err);
            showError('Terjadi kesalahan koneksi. Silakan coba lagi.');
        } finally {
            setLoading(false);
        }
    }

    let _pendingEmail = '';
    let _pendingPass = '';

    function doLogin() {
        const email = $('email').value.trim();
        const pass = $('password').value;
        if (!email || !pass) {
            showError('Username/Email dan password wajib diisi.');
            return;
        }
        _pendingEmail = email;
        _pendingPass = pass;
        fetchHandler(email, pass);
    }

    function handleAction(action) {
        $('modal-konflik').classList.remove('show');
        if (!_pendingEmail || !_pendingPass) {
            showError('Sesi tidak valid, silakan isi ulang form login.');
            return;
        }
        fetchHandler(_pendingEmail, _pendingPass, action);
    }

    $('btn-submit').addEventListener('click', doLogin);
    document.addEventListener('keydown', e => {
        if (e.key === 'Enter') doLogin();
    });
    </script>
</body>

</html>
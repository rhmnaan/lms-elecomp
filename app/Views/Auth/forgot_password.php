<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password — LMS Elecomp</title>
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
        --success: #10B981;
    }

    html, body {
        height: 100%;
        font-family: 'DM Sans', sans-serif;
        background: var(--blue-deep);
        overflow-x: hidden;
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
        background-image:
            radial-gradient(circle at 20% 80%, rgba(3, 170, 222, .18) 0%, transparent 50%),
            radial-gradient(circle at 80% 20%, rgba(0, 229, 192, .12) 0%, transparent 45%),
            radial-gradient(circle at 50% 50%, rgba(13, 38, 86, .6) 0%, transparent 70%);
    }

    .grid-lines {
        position: absolute;
        inset: 0;
        opacity: .07;
        background-image:
            linear-gradient(rgba(56, 200, 245, 1) 1px, transparent 1px),
            linear-gradient(90deg, rgba(56, 200, 245, 1) 1px, transparent 1px);
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
    .orb-1 { width: 320px; height: 320px; background: var(--blue-sky); top: -80px; right: 10%; animation-delay: 0s; }
    .orb-2 { width: 200px; height: 200px; background: var(--accent); bottom: 10%; left: 5%; animation-delay: -4s; }
    .orb-3 { width: 160px; height: 160px; background: #5B40FF; bottom: 25%; right: 5%; animation-delay: -8s; }

    @keyframes floatOrb {
        0%, 100% { transform: translateY(0) scale(1); }
        50% { transform: translateY(-30px) scale(1.08); }
    }

    .particles { position: absolute; inset: 0; pointer-events: none; }
    .particle {
        position: absolute;
        width: 2px; height: 2px;
        background: rgba(56, 200, 245, .7);
        border-radius: 50%;
        animation: particleDrift linear infinite;
    }
    @keyframes particleDrift {
        0%   { transform: translateY(100vh) translateX(0); opacity: 0; }
        10%  { opacity: 1; }
        90%  { opacity: 1; }
        100% { transform: translateY(-10vh) translateX(40px); opacity: 0; }
    }

    /* ── LAYOUT ── */
    .page-wrap {
        position: relative;
        z-index: 10;
        min-height: 100vh;
        display: grid;
        grid-template-columns: 1fr 480px;
        align-items: center;
    }

    /* ── LEFT PANEL ── */
    .left-panel {
        padding: 60px 48px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        max-width: 600px;
        margin-left: auto;
        animation: slideInLeft .8s cubic-bezier(.16,1,.3,1) forwards;
        opacity: 0;
    }
    @keyframes slideInLeft {
        from { opacity: 0; transform: translateX(-40px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .badge-top {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(3,170,222,.12);
        border: 1px solid rgba(3,170,222,.3);
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
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--accent);
        animation: pulse 2s ease-in-out infinite;
    }
    @keyframes pulse {
        0%,100% { opacity:1; transform:scale(1); box-shadow:0 0 0 0 rgba(0,229,192,.5); }
        50%      { opacity:.8; transform:scale(1.3); box-shadow:0 0 0 6px transparent; }
    }

    .hero-title {
        font-family: 'Syne', sans-serif;
        font-size: clamp(34px, 3.5vw, 50px);
        font-weight: 800;
        line-height: 1.1;
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
        color: rgba(255,255,255,.5);
        max-width: 360px;
        margin-bottom: 40px;
    }

    .steps-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }
    .step-item {
        display: flex;
        align-items: flex-start;
        gap: 14px;
    }
    .step-num {
        width: 32px; height: 32px;
        border-radius: 50%;
        background: rgba(3,170,222,.15);
        border: 1px solid rgba(3,170,222,.3);
        display: flex; align-items: center; justify-content: center;
        font-family: 'Syne', sans-serif;
        font-size: 13px; font-weight: 700;
        color: var(--blue-light);
        flex-shrink: 0;
    }
    .step-text { font-size: 13px; color: rgba(255,255,255,.55); line-height: 1.5; padding-top: 6px; }
    .step-text strong { color: rgba(255,255,255,.8); }

    /* ── RIGHT CARD ── */
    .card-wrap {
        padding: 32px 40px 40px;
        background: rgba(255,255,255,.96);
        backdrop-filter: blur(20px);
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-shadow: -20px 0 80px rgba(0,0,0,.3);
        animation: slideInRight .8s cubic-bezier(.16,1,.3,1) .1s forwards;
        opacity: 0;
    }
    @keyframes slideInRight {
        from { opacity: 0; transform: translateX(40px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .card-inner { max-width: 360px; margin: 0 auto; width: 100%; }

    .logo-area { text-align: center; padding: 16px 0 20px; }
    .logo-shine-wrap { position: relative; display: inline-block; overflow: hidden; border-radius: 8px; }
    .logo-image {
        max-width: 300px; height: auto; width: 100%; display: block;
        animation: logoEntrance .8s cubic-bezier(.16,1,.3,1) .2s both, logoFloat 4s ease-in-out 1s infinite;
        filter: drop-shadow(0 4px 16px rgba(3,170,222,.35));
        transition: filter .3s;
    }
    .logo-shine-wrap::after {
        content: '';
        position: absolute; top: -50%; left: -75%;
        width: 50%; height: 200%;
        background: linear-gradient(105deg, transparent 30%, rgba(255,255,255,.55) 50%, transparent 70%);
        transform: skewX(-15deg);
        animation: logoShine 3.5s ease-in-out 1.2s infinite;
        pointer-events: none;
    }
    @keyframes logoEntrance {
        from { opacity:0; transform:translateY(-16px) scale(.92); }
        to   { opacity:1; transform:translateY(0) scale(1); }
    }
    @keyframes logoFloat {
        0%,100% { transform:translateY(0); }
        50%     { transform:translateY(-5px); }
    }
    @keyframes logoShine {
        0%        { left:-75%; opacity:0; }
        10%       { opacity:1; }
        40%       { left:125%; opacity:1; }
        41%,100%  { left:125%; opacity:0; }
    }

    .form-heading { margin-bottom: 28px; }
    .form-heading h2 {
        font-family: 'Syne', sans-serif;
        font-size: 24px; font-weight: 700;
        color: var(--blue-deep);
        letter-spacing: -.02em;
        margin-bottom: 4px;
    }
    .form-heading p { font-size: 14px; color: var(--gray-muted); line-height: 1.5; }

    /* Icon header area */
    .icon-header {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 60px; height: 60px;
        background: linear-gradient(135deg, rgba(3,170,222,.15), rgba(0,229,192,.1));
        border: 1.5px solid rgba(3,170,222,.25);
        border-radius: 18px;
        margin-bottom: 20px;
    }
    .icon-header i { font-size: 26px; color: var(--blue-sky); }

    /* Fields */
    .field { margin-bottom: 20px; }
    .field-label {
        display: block;
        font-size: 13px; font-weight: 600;
        color: #3D4B6B;
        margin-bottom: 8px;
        letter-spacing: .01em;
    }
    .field-wrap { position: relative; display: flex; align-items: center; }
    .field-icon {
        position: absolute; left: 14px;
        color: #9BADD0; font-size: 14px;
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
    .field-input::placeholder { color: #B0BDDA; }
    .field-input:focus {
        background: #fff;
        border-color: var(--blue-sky);
        box-shadow: 0 0 0 4px rgba(3,170,222,.1);
    }
    .field-wrap:focus-within .field-icon { color: var(--blue-sky); }

    /* Alert boxes */
    .alert-box {
        display: none;
        border-radius: 10px;
        padding: 12px 14px;
        font-size: 13px;
        margin-bottom: 20px;
        line-height: 1.5;
    }
    .alert-box.show { display: block; }
    .alert-box.error {
        background: #FFF0F3;
        border: 1px solid #FFCED8;
        color: var(--danger);
    }
    .alert-box.success {
        background: #ECFDF5;
        border: 1px solid #A7F3D0;
        color: #065F46;
    }
    .alert-box.info {
        background: #EFF6FF;
        border: 1px solid #DBEAFE;
        color: #1E40AF;
    }

    /* Submit button */
    .btn-submit {
        width: 100%;
        padding: 14px;
        background: linear-gradient(135deg, var(--blue-sky) 0%, var(--blue-mid) 100%);
        color: #fff;
        border: none;
        border-radius: 12px;
        font-family: 'Syne', sans-serif;
        font-size: 15px; font-weight: 700;
        letter-spacing: .01em;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        gap: 8px;
        transition: all .25s;
        box-shadow: 0 8px 24px rgba(3,170,222,.35);
        margin-bottom: 16px;
        position: relative;
        overflow: hidden;
    }
    .btn-submit::before {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(135deg, var(--accent) 0%, var(--blue-sky) 100%);
        opacity: 0; transition: opacity .3s;
    }
    .btn-submit:hover::before { opacity: 1; }
    .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 12px 32px rgba(3,170,222,.45); }
    .btn-submit:active { transform: translateY(0); }
    .btn-submit:disabled { opacity: .7; transform: none; cursor: not-allowed; }
    .btn-submit > * { position: relative; z-index: 1; }

    /* Back link */
    .back-link {
        display: flex; align-items: center; justify-content: center;
        gap: 6px;
        font-size: 13px; color: var(--gray-muted);
        text-decoration: none;
        padding: 8px;
        border-radius: 8px;
        transition: all .2s;
    }
    .back-link:hover { color: var(--blue-sky); background: rgba(3,170,222,.06); }
    .back-link i { font-size: 12px; }

    /* Spinner */
    .spinner {
        width: 16px; height: 16px;
        border: 2px solid rgba(255,255,255,.4);
        border-top-color: white;
        border-radius: 50%;
        animation: spin .7s linear infinite;
        display: none;
    }
    .spinner.show { display: block; }
    @keyframes spin { to { transform: rotate(360deg); } }

    /* Success state panel */
    .success-panel {
        display: none;
        text-align: center;
        padding: 8px 0;
    }
    .success-panel.show { display: block; }
    .success-icon-wrap {
        width: 72px; height: 72px;
        background: linear-gradient(135deg, rgba(16,185,129,.15), rgba(0,229,192,.1));
        border: 2px solid rgba(16,185,129,.3);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
        animation: scaleIn .5s cubic-bezier(.16,1,.3,1) forwards;
    }
    .success-icon-wrap i { font-size: 30px; color: var(--success); }
    @keyframes scaleIn {
        from { opacity:0; transform:scale(.6); }
        to   { opacity:1; transform:scale(1); }
    }
    .success-title {
        font-family: 'Syne', sans-serif;
        font-size: 22px; font-weight: 700;
        color: var(--blue-deep);
        margin-bottom: 10px;
    }
    .success-text { font-size: 14px; color: var(--gray-muted); line-height: 1.6; margin-bottom: 24px; }
    .success-email-badge {
        display: inline-flex; align-items: center; gap: 8px;
        background: #EFF6FF;
        border: 1px solid #DBEAFE;
        border-radius: 100px;
        padding: 8px 16px;
        font-size: 13px; font-weight: 500;
        color: #1E40AF;
        margin-bottom: 24px;
    }

    /* Footer */
    .card-footer-note {
        margin-top: 24px;
        text-align: center;
        font-size: 12px; color: #B0BDDA;
        line-height: 1.6;
    }
    .card-footer-note a { color: var(--blue-sky); text-decoration: none; }
    .card-footer-note a:hover { text-decoration: underline; }

    @media (max-width: 768px) {
        .page-wrap { grid-template-columns: 1fr; }
        .left-panel { display: none; }
        .card-wrap { min-height: 100vh; padding: 40px 28px; box-shadow: none; }
        .logo-image { max-width: 200px; }
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

    <div class="page-wrap">
        <!-- LEFT PANEL -->
        <div class="left-panel">
            <div class="badge-top"><span class="dot"></span> Pemulihan Akun</div>
            <h1 class="hero-title">
                Lupa Password?<br>
                <span class="line-accent">Tenang, Kami Bantu</span>
            </h1>
            <p class="hero-sub">Ikuti tiga langkah mudah untuk memulihkan akses ke akun LMS Elecomp Anda.</p>
            <div class="steps-list">
                <div class="step-item">
                    <div class="step-num">1</div>
                    <div class="step-text"><strong>Masukkan email</strong> yang terdaftar di akun Anda.</div>
                </div>
                <div class="step-item">
                    <div class="step-num">2</div>
                    <div class="step-text"><strong>Cek kotak masuk</strong> email Anda — kami kirimkan tautan reset password.</div>
                </div>
                <div class="step-item">
                    <div class="step-num">3</div>
                    <div class="step-text"><strong>Klik tautan</strong> dan buat password baru. Selesai!</div>
                </div>
            </div>
        </div>

        <!-- RIGHT CARD -->
        <div class="card-wrap">
            <div class="card-inner">

                <div class="logo-area">
                    <div class="logo-mark">
                        <div class="logo-shine-wrap">
                            <img src="<?= base_url('logo/image.png') ?>" alt="LMS Elecomp" class="logo-image">
                        </div>
                    </div>
                </div>

                <!-- FORM STATE -->
                <div id="form-state">
                    <div class="icon-header">
                        <i class="fas fa-key"></i>
                    </div>
                    <div class="form-heading">
                        <h2>Reset Password</h2>
                        <p>Masukkan alamat email yang terdaftar. Kami akan mengirimkan tautan untuk membuat password baru.</p>
                    </div>

                    <div class="alert-box error" id="alert-error"></div>
                    <div class="alert-box info" id="alert-info"></div>

                    <div class="field">
                        <label class="field-label" for="email">Alamat Email</label>
                        <div class="field-wrap">
                            <i class="fas fa-envelope field-icon"></i>
                            <input type="email" id="email" class="field-input"
                                placeholder="contoh@email.com" autocomplete="email">
                        </div>
                    </div>

                    <button class="btn-submit" id="btn-submit">
                        <span id="btn-label">Kirim Tautan Reset</span>
                        <div class="spinner" id="spinner"></div>
                    </button>

                    <a href="<?= base_url('/login') ?>" class="back-link">
                        <i class="fas fa-arrow-left"></i> Kembali ke halaman login
                    </a>
                </div>

                <!-- SUCCESS STATE -->
                <div class="success-panel" id="success-state">
                    <div class="success-icon-wrap">
                        <i class="fas fa-paper-plane"></i>
                    </div>
                    <h3 class="success-title">Email Terkirim!</h3>
                    <p class="success-text">
                        Tautan reset password telah dikirimkan ke:
                    </p>
                    <div class="success-email-badge">
                        <i class="fas fa-envelope"></i>
                        <span id="sent-to-email"></span>
                    </div>
                    <p class="success-text" style="font-size:13px;">
                        Tautan berlaku selama <strong>30 menit</strong>. Jika tidak menemukan email, periksa folder <strong>Spam</strong> atau <strong>Promosi</strong>.
                    </p>

                    <button id="btn-resend-reset" onclick="resendReset()"
                        style="width:100%;padding:12px 14px;background:linear-gradient(135deg,#03AADE,#0D2656);
                        color:#fff;border:none;border-radius:12px;font-family:'Syne',sans-serif;font-size:14px;
                        font-weight:700;cursor:pointer;display:flex;align-items:center;justify-content:center;
                        gap:6px;margin-bottom:12px;transition:all .2s;box-shadow:0 6px 20px rgba(3,170,222,.3);">
                        <i class="fas fa-rotate-right"></i>
                        <span id="resend-label">Kirim Ulang Email</span>
                    </button>

                    <a href="<?= base_url('/login') ?>" class="back-link">
                        <i class="fas fa-arrow-left"></i> Kembali ke halaman login
                    </a>
                </div>

                <div class="card-footer-note">
                    Butuh bantuan? Hubungi <a href="https://wa.me/6282245975428" target="_blank">+62 822-4597-5428</a>
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

    function getCsrfToken() {
    const m = document.cookie.match(/csrf_cookie_name=([^;]+)/);
    return m ? decodeURIComponent(m[1]) : '';
}

    function showError(msg) {
        const box = $('alert-error');
        box.innerHTML = `<div style="display:flex;align-items:center;gap:8px;">
            <i class="fas fa-circle-exclamation"></i><span>${msg}</span></div>`;
        box.classList.add('show');
        $('alert-info').classList.remove('show');
    }

    function hideAlerts() {
        $('alert-error').classList.remove('show');
        $('alert-info').classList.remove('show');
    }

    function setLoading(on) {
        $('btn-submit').disabled = on;
        $('spinner').classList.toggle('show', on);
        $('btn-label').textContent = on ? 'Mengirim...' : 'Kirim Tautan Reset';
    }

    let _lastEmail = '';
    let _cooldownTimer = null;

    async function submitForm() {
        hideAlerts();
        const email = $('email').value.trim();
        if (!email) { showError('Alamat email wajib diisi.'); return; }
        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            showError('Format email tidak valid.'); return;
        }

        setLoading(true);
        try {
            const form = new FormData();
            form.append('email', email);

            const res = await fetch(BASE_URL + '/forgot-password/send', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': getCsrfToken() },
                body: form,
            });
            if (!res.ok) throw new Error('Server error ' + res.status);
            const data = await res.json();

            if (data.status === 'successful') {
                _lastEmail = email;
                $('sent-to-email').textContent = email;
                $('form-state').style.display = 'none';
                $('success-state').classList.add('show');
                startResendCooldown(120);
            } else {
                showError(data.message || 'Gagal mengirim email. Coba lagi.');
            }
        } catch (err) {
            showError('Terjadi gangguan koneksi. Silakan coba lagi.');
        } finally {
            setLoading(false);
        }
    }

    async function resendReset() {
        const btn = $('btn-resend-reset');
        if (!btn || btn.disabled || !_lastEmail) return;

        btn.disabled = true;
        btn.style.opacity = '.7';
        btn.innerHTML = `<i class="fas fa-spinner fa-spin"></i> <span>Mengirim...</span>`;

        try {
            const form = new FormData();
            form.append('email', _lastEmail);
            const res = await fetch(BASE_URL + '/forgot-password/send', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': getCsrfToken() },
                body: form,
            });
            const data = await res.json();
            if (data.status === 'successful') {
                startResendCooldown(120);
            } else {
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.innerHTML = `<i class="fas fa-rotate-right"></i> <span id="resend-label">Kirim Ulang Email</span>`;
            }
        } catch {
            btn.disabled = false;
            btn.style.opacity = '1';
            btn.innerHTML = `<i class="fas fa-rotate-right"></i> <span id="resend-label">Kirim Ulang Email</span>`;
        }
    }

    function startResendCooldown(seconds) {
        const btn = $('btn-resend-reset');
        if (!btn) return;
        btn.disabled = true;
        btn.style.opacity = '.6';
        btn.style.background = '#D1D5DB';
        btn.style.color = '#6B7280';
        btn.style.boxShadow = 'none';
        btn.style.cursor = 'not-allowed';

        let left = seconds;
        btn.innerHTML = `<i class="fas fa-clock"></i> <span id="resend-countdown">Kirim ulang dalam ${left}s</span>`;

        clearInterval(_cooldownTimer);
        _cooldownTimer = setInterval(() => {
            left--;
            const label = document.getElementById('resend-countdown');
            if (label) label.textContent = `Kirim ulang dalam ${left}s`;
            if (left <= 0) {
                clearInterval(_cooldownTimer);
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.style.background = 'linear-gradient(135deg,#03AADE,#0D2656)';
                btn.style.color = '#fff';
                btn.style.boxShadow = '0 6px 20px rgba(3,170,222,.3)';
                btn.style.cursor = 'pointer';
                btn.innerHTML = `<i class="fas fa-rotate-right"></i> <span id="resend-label">Kirim Ulang Email</span>`;
            }
        }, 1000);
    }

    $('btn-submit').addEventListener('click', submitForm);
    document.addEventListener('keydown', e => { if (e.key === 'Enter') submitForm(); });
    </script>
</body>
</html>
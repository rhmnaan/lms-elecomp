<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password — LMS Elecomp</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    :root{
        --blue-deep:#0A1628;--blue-mid:#0D2656;--blue-sky:#03AADE;
        --blue-light:#38C8F5;--accent:#00E5C0;--white:#FFFFFF;
        --gray-muted:#8A9BBF;--danger:#FF4D6A;--success:#10B981;
    }
    html,body{height:100%;font-family:'DM Sans',sans-serif;background:var(--blue-deep);overflow-x:hidden;overflow-y:auto}
    .bg-canvas{position:fixed;inset:0;z-index:0;background:radial-gradient(ellipse 80% 60% at 60% 40%,#0D3580 0%,#0A1628 60%);overflow:hidden}
    .bg-canvas::before{content:'';position:absolute;inset:0;background-image:radial-gradient(circle at 20% 80%,rgba(3,170,222,.18) 0%,transparent 50%),radial-gradient(circle at 80% 20%,rgba(0,229,192,.12) 0%,transparent 45%)}
    .grid-lines{position:absolute;inset:0;opacity:.07;background-image:linear-gradient(rgba(56,200,245,1) 1px,transparent 1px),linear-gradient(90deg,rgba(56,200,245,1) 1px,transparent 1px);background-size:48px 48px;mask-image:radial-gradient(ellipse 80% 80% at 50% 50%,black 0%,transparent 75%)}
    .orb{position:absolute;border-radius:50%;filter:blur(60px);opacity:.25;animation:floatOrb 12s ease-in-out infinite}
    .orb-1{width:320px;height:320px;background:var(--blue-sky);top:-80px;right:10%}
    .orb-2{width:200px;height:200px;background:var(--accent);bottom:10%;left:5%;animation-delay:-4s}
    .orb-3{width:160px;height:160px;background:#5B40FF;bottom:25%;right:5%;animation-delay:-8s}
    @keyframes floatOrb{0%,100%{transform:translateY(0) scale(1)}50%{transform:translateY(-30px) scale(1.08)}}
    .particles{position:absolute;inset:0;pointer-events:none}
    .particle{position:absolute;width:2px;height:2px;background:rgba(56,200,245,.7);border-radius:50%;animation:particleDrift linear infinite}
    @keyframes particleDrift{0%{transform:translateY(100vh);opacity:0}10%{opacity:1}90%{opacity:1}100%{transform:translateY(-10vh) translateX(40px);opacity:0}}

    .page-wrap{position:relative;z-index:10;min-height:100vh;display:grid;grid-template-columns:1fr 480px;align-items:center}

    .left-panel{padding:60px 48px;display:flex;flex-direction:column;justify-content:center;max-width:600px;margin-left:auto;animation:slideInLeft .8s cubic-bezier(.16,1,.3,1) forwards;opacity:0}
    @keyframes slideInLeft{from{opacity:0;transform:translateX(-40px)}to{opacity:1;transform:translateX(0)}}

    .badge-top{display:inline-flex;align-items:center;gap:8px;background:rgba(3,170,222,.12);border:1px solid rgba(3,170,222,.3);border-radius:100px;padding:6px 14px;font-size:12px;font-weight:500;color:var(--blue-light);letter-spacing:.06em;text-transform:uppercase;margin-bottom:28px;width:fit-content}
    .badge-top span.dot{width:6px;height:6px;border-radius:50%;background:var(--accent);animation:pulse 2s ease-in-out infinite}
    @keyframes pulse{0%,100%{opacity:1;transform:scale(1)}50%{opacity:.8;transform:scale(1.3)}}

    .hero-title{font-family:'Syne',sans-serif;font-size:clamp(34px,3.5vw,50px);font-weight:800;line-height:1.1;color:var(--white);margin-bottom:18px}
    .hero-title .line-accent{display:block;background:linear-gradient(90deg,var(--blue-sky),var(--accent));-webkit-background-clip:text;-webkit-text-fill-color:transparent}
    .hero-sub{font-size:15px;line-height:1.7;color:rgba(255,255,255,.5);max-width:360px;margin-bottom:36px}

    .req-list{display:flex;flex-direction:column;gap:10px}
    .req-item{display:flex;align-items:center;gap:10px;font-size:13px;color:rgba(255,255,255,.5)}
    .req-item i{color:var(--accent);font-size:12px;width:16px}

    .card-wrap{padding:32px 40px 40px;background:rgba(255,255,255,.96);backdrop-filter:blur(20px);min-height:100vh;display:flex;flex-direction:column;justify-content:center;box-shadow:-20px 0 80px rgba(0,0,0,.3);animation:slideInRight .8s cubic-bezier(.16,1,.3,1) .1s forwards;opacity:0}
    @keyframes slideInRight{from{opacity:0;transform:translateX(40px)}to{opacity:1;transform:translateX(0)}}

    .card-inner{max-width:360px;margin:0 auto;width:100%}
    .logo-area{text-align:center;padding:16px 0 20px}
    .logo-shine-wrap{position:relative;display:inline-block;overflow:hidden;border-radius:8px}
    .logo-image{max-width:300px;height:auto;width:100%;display:block;animation:logoEntrance .8s cubic-bezier(.16,1,.3,1) .2s both,logoFloat 4s ease-in-out 1s infinite;filter:drop-shadow(0 4px 16px rgba(3,170,222,.35))}
    .logo-shine-wrap::after{content:'';position:absolute;top:-50%;left:-75%;width:50%;height:200%;background:linear-gradient(105deg,transparent 30%,rgba(255,255,255,.55) 50%,transparent 70%);transform:skewX(-15deg);animation:logoShine 3.5s ease-in-out 1.2s infinite;pointer-events:none}
    @keyframes logoEntrance{from{opacity:0;transform:translateY(-16px) scale(.92)}to{opacity:1;transform:translateY(0) scale(1)}}
    @keyframes logoFloat{0%,100%{transform:translateY(0)}50%{transform:translateY(-5px)}}
    @keyframes logoShine{0%{left:-75%;opacity:0}10%{opacity:1}40%{left:125%;opacity:1}41%,100%{left:125%;opacity:0}}

    .icon-header{display:flex;align-items:center;justify-content:center;width:60px;height:60px;background:linear-gradient(135deg,rgba(3,170,222,.15),rgba(0,229,192,.1));border:1.5px solid rgba(3,170,222,.25);border-radius:18px;margin-bottom:20px}
    .icon-header i{font-size:26px;color:var(--blue-sky)}

    .form-heading{margin-bottom:28px}
    .form-heading h2{font-family:'Syne',sans-serif;font-size:24px;font-weight:700;color:var(--blue-deep);letter-spacing:-.02em;margin-bottom:4px}
    .form-heading p{font-size:14px;color:var(--gray-muted);line-height:1.5}

    .field{margin-bottom:20px}
    .field-label{display:block;font-size:13px;font-weight:600;color:#3D4B6B;margin-bottom:8px;letter-spacing:.01em}
    .field-wrap{position:relative;display:flex;align-items:center}
    .field-icon{position:absolute;left:14px;color:#9BADD0;font-size:14px;pointer-events:none;transition:color .2s}
    .field-input{width:100%;padding:13px 42px 13px 42px;background:#F4F7FC;border:1.5px solid #E2E8F5;border-radius:12px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--blue-deep);outline:none;transition:all .2s}
    .field-input::placeholder{color:#B0BDDA}
    .field-input:focus{background:#fff;border-color:var(--blue-sky);box-shadow:0 0 0 4px rgba(3,170,222,.1)}
    .field-wrap:focus-within .field-icon{color:var(--blue-sky)}
    .toggle-pw{position:absolute;right:12px;background:none;border:none;cursor:pointer;color:#9BADD0;padding:4px;font-size:14px;transition:color .2s}
    .toggle-pw:hover{color:var(--blue-mid)}

    /* Password strength */
    .pw-strength{margin-top:8px}
    .strength-bar{height:4px;border-radius:100px;background:#E2E8F5;overflow:hidden;margin-bottom:6px}
    .strength-fill{height:100%;border-radius:100px;transition:all .4s;width:0}
    .strength-label{font-size:12px;color:var(--gray-muted)}

    /* Requirement checklist */
    .pw-reqs{display:flex;flex-direction:column;gap:5px;margin-top:10px}
    .req{display:flex;align-items:center;gap:7px;font-size:12px;color:#B0BDDA;transition:color .2s}
    .req i{font-size:10px;width:14px;transition:color .2s}
    .req.met{color:#059669}
    .req.met i{color:#10B981}

    .alert-box{display:none;border-radius:10px;padding:12px 14px;font-size:13px;margin-bottom:20px;line-height:1.5}
    .alert-box.show{display:block}
    .alert-box.error{background:#FFF0F3;border:1px solid #FFCED8;color:var(--danger)}
    .alert-box.success{background:#ECFDF5;border:1px solid #A7F3D0;color:#065F46}

    .btn-submit{width:100%;padding:14px;background:linear-gradient(135deg,var(--blue-sky) 0%,var(--blue-mid) 100%);color:#fff;border:none;border-radius:12px;font-family:'Syne',sans-serif;font-size:15px;font-weight:700;letter-spacing:.01em;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:all .25s;box-shadow:0 8px 24px rgba(3,170,222,.35);margin-bottom:16px;position:relative;overflow:hidden}
    .btn-submit::before{content:'';position:absolute;inset:0;background:linear-gradient(135deg,var(--accent) 0%,var(--blue-sky) 100%);opacity:0;transition:opacity .3s}
    .btn-submit:hover::before{opacity:1}
    .btn-submit:hover{transform:translateY(-2px);box-shadow:0 12px 32px rgba(3,170,222,.45)}
    .btn-submit:active{transform:translateY(0)}
    .btn-submit:disabled{opacity:.7;transform:none;cursor:not-allowed}
    .btn-submit>*{position:relative;z-index:1}

    .spinner{width:16px;height:16px;border:2px solid rgba(255,255,255,.4);border-top-color:white;border-radius:50%;animation:spin .7s linear infinite;display:none}
    .spinner.show{display:block}
    @keyframes spin{to{transform:rotate(360deg)}}

    .back-link{display:flex;align-items:center;justify-content:center;gap:6px;font-size:13px;color:var(--gray-muted);text-decoration:none;padding:8px;border-radius:8px;transition:all .2s}
    .back-link:hover{color:var(--blue-sky);background:rgba(3,170,222,.06)}
    .back-link i{font-size:12px}

    /* Token expired panel */
    .expired-panel{display:none;text-align:center;padding:8px 0}
    .expired-panel.show{display:block}
    .expired-icon-wrap{width:72px;height:72px;background:rgba(255,77,106,.12);border:2px solid rgba(255,77,106,.25);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px}
    .expired-icon-wrap i{font-size:30px;color:var(--danger)}

    /* Done panel */
    .done-panel{display:none;text-align:center;padding:8px 0}
    .done-panel.show{display:block}
    .done-icon-wrap{width:72px;height:72px;background:linear-gradient(135deg,rgba(16,185,129,.15),rgba(0,229,192,.1));border:2px solid rgba(16,185,129,.3);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;animation:scaleIn .5s cubic-bezier(.16,1,.3,1) forwards}
    .done-icon-wrap i{font-size:30px;color:var(--success)}
    @keyframes scaleIn{from{opacity:0;transform:scale(.6)}to{opacity:1;transform:scale(1)}}
    .done-title{font-family:'Syne',sans-serif;font-size:22px;font-weight:700;color:var(--blue-deep);margin-bottom:10px}
    .done-text{font-size:14px;color:var(--gray-muted);line-height:1.6;margin-bottom:24px}

    .btn-login{display:block;width:100%;padding:14px;background:linear-gradient(135deg,var(--blue-sky),var(--blue-mid));color:#fff;border:none;border-radius:12px;font-family:'Syne',sans-serif;font-size:15px;font-weight:700;text-align:center;text-decoration:none;box-shadow:0 8px 24px rgba(3,170,222,.35);transition:all .25s}
    .btn-login:hover{transform:translateY(-2px);box-shadow:0 12px 32px rgba(3,170,222,.45)}

    .card-footer-note{margin-top:24px;text-align:center;font-size:12px;color:#B0BDDA;line-height:1.6}
    .card-footer-note a{color:var(--blue-sky);text-decoration:none}
    .card-footer-note a:hover{text-decoration:underline}

    @media(max-width:768px){
        .page-wrap{grid-template-columns:1fr}
        .left-panel{display:none}
        .card-wrap{min-height:100vh;padding:40px 28px;box-shadow:none}
        .logo-image{max-width:200px}
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
        <div class="left-panel">
            <div class="badge-top"><span class="dot"></span> Buat Password Baru</div>
            <h1 class="hero-title">Hampir Selesai!<br><span class="line-accent">Buat Password Baru</span></h1>
            <p class="hero-sub">Pastikan password baru Anda kuat dan mudah diingat. Berikut panduannya:</p>
            <div class="req-list">
                <div class="req-item"><i class="fas fa-check-circle"></i> Minimal 8 karakter</div>
                <div class="req-item"><i class="fas fa-check-circle"></i> Kombinasi huruf besar & kecil</div>
                <div class="req-item"><i class="fas fa-check-circle"></i> Mengandung angka</div>
                <div class="req-item"><i class="fas fa-check-circle"></i> Jangan gunakan password lama</div>
            </div>
        </div>

        <div class="card-wrap">
            <div class="card-inner">
                <div class="logo-area">
                    <div class="logo-shine-wrap">
                        <img src="<?= base_url('logo/image.png') ?>" alt="LMS Elecomp" class="logo-image">
                    </div>
                </div>

                <!-- TOKEN EXPIRED -->
                <?php if (!isset($valid_token) || !$valid_token): ?>
                <div class="expired-panel show">
                    <div class="expired-icon-wrap"><i class="fas fa-clock"></i></div>
                    <h3 style="font-family:'Syne',sans-serif;font-size:22px;font-weight:700;color:var(--blue-deep);margin-bottom:10px">
                        Tautan Kadaluarsa
                    </h3>
                    <p style="font-size:14px;color:var(--gray-muted);line-height:1.6;margin-bottom:24px">
                        Tautan reset password ini sudah tidak valid atau telah kadaluarsa (berlaku 30 menit). Silakan minta tautan baru.
                    </p>
                    <a href="<?= base_url('/forgot-password') ?>" class="btn-login" style="display:block;text-decoration:none;margin-bottom:12px">
                        <i class="fas fa-rotate-right"></i> Minta Tautan Baru
                    </a>
                    <a href="<?= base_url('/login') ?>" class="back-link">
                        <i class="fas fa-arrow-left"></i> Kembali ke login
                    </a>
                </div>
                <?php else: ?>

                <!-- FORM RESET -->
                <div id="form-state">
                    <div class="icon-header"><i class="fas fa-lock-open"></i></div>
                    <div class="form-heading">
                        <h2>Password Baru</h2>
                        <p>Buat password baru yang kuat untuk akun <strong><?= esc($email ?? '') ?></strong></p>
                    </div>

                    <div class="alert-box error" id="alert-error"></div>

                    <!-- Hidden token -->
                    <input type="hidden" id="reset-token" value="<?= esc($token ?? '') ?>">

                    <div class="field">
                        <label class="field-label" for="password">Password Baru</label>
                        <div class="field-wrap">
                            <i class="fas fa-lock field-icon"></i>
                            <input type="password" id="password" class="field-input"
                                placeholder="Masukkan password baru" autocomplete="new-password">
                            <button type="button" class="toggle-pw" onclick="togglePw('password','eye1')">
                                <i class="fas fa-eye" id="eye1"></i>
                            </button>
                        </div>
                        <!-- Strength indicator -->
                        <div class="pw-strength">
                            <div class="strength-bar"><div class="strength-fill" id="strength-fill"></div></div>
                            <span class="strength-label" id="strength-label">Masukkan password</span>
                        </div>
                        <div class="pw-reqs">
                            <div class="req" id="req-len"><i class="fas fa-circle"></i> Minimal 8 karakter</div>
                            <div class="req" id="req-letter"><i class="fas fa-circle"></i> Mengandung huruf</div>
                            <div class="req" id="req-number"><i class="fas fa-circle"></i> Mengandung angka</div>
                        </div>
                    </div>

                    <div class="field">
                        <label class="field-label" for="confirm">Konfirmasi Password</label>
                        <div class="field-wrap">
                            <i class="fas fa-lock field-icon"></i>
                            <input type="password" id="confirm" class="field-input"
                                placeholder="Ulangi password baru" autocomplete="new-password">
                            <button type="button" class="toggle-pw" onclick="togglePw('confirm','eye2')">
                                <i class="fas fa-eye" id="eye2"></i>
                            </button>
                        </div>
                    </div>

                    <button class="btn-submit" id="btn-submit">
                        <span id="btn-label">Simpan Password Baru</span>
                        <div class="spinner" id="spinner"></div>
                    </button>

                    <a href="<?= base_url('/login') ?>" class="back-link">
                        <i class="fas fa-arrow-left"></i> Kembali ke halaman login
                    </a>
                </div>

                <!-- DONE PANEL -->
                <div class="done-panel" id="done-state">
                    <div class="done-icon-wrap"><i class="fas fa-check"></i></div>
                    <h3 class="done-title">Password Berhasil Diubah!</h3>
                    <p class="done-text">Password Anda telah berhasil diperbarui. Silakan masuk menggunakan password baru.</p>
                    <a href="<?= base_url('/login') ?>" class="btn-login">
                        <i class="fas fa-right-to-bracket"></i> Masuk Sekarang
                    </a>
                </div>

                <?php endif; ?>

                <div class="card-footer-note">
                    Butuh bantuan? Hubungi <a href="https://wa.me/6282245975428" target="_blank">+62 822-4597-5428</a>
                </div>
            </div>
        </div>
    </div>

    <script>
    const $ = id => document.getElementById(id);
    const BASE_URL = '<?= rtrim(base_url(), '/') ?>';

    (function(){
        const wrap = $('particles');
        if (!wrap) return;
        for(let i=0;i<22;i++){
            const p=document.createElement('div');p.className='particle';
            p.style.left=Math.random()*100+'%';
            p.style.animationDuration=(10+Math.random()*20)+'s';
            p.style.animationDelay=-(Math.random()*25)+'s';
            p.style.width=p.style.height=(Math.random()>.6?3:2)+'px';
            p.style.opacity=(0.3+Math.random()*0.5).toString();
            wrap.appendChild(p);
        }
    })();

    function getCsrfToken(){const m=document.cookie.match(/csrf_test_name=([^;]+)/);return m?decodeURIComponent(m[1]):''}

    function togglePw(inputId, iconId){
        const el=$(inputId), ico=$(iconId);
        if(el.type==='password'){el.type='text';ico.classList.replace('fa-eye','fa-eye-slash');}
        else{el.type='password';ico.classList.replace('fa-eye-slash','fa-eye');}
    }

    // Password strength
    const pwInput = $('password');
    if (pwInput) {
        pwInput.addEventListener('input', () => {
            const v = pwInput.value;
            const hasLen = v.length >= 8;
            const hasLetter = /[a-zA-Z]/.test(v);
            const hasNum = /[0-9]/.test(v);
            const hasUpper = /[A-Z]/.test(v);
            const hasSpecial = /[^a-zA-Z0-9]/.test(v);

            toggleReq('req-len', hasLen);
            toggleReq('req-letter', hasLetter);
            toggleReq('req-number', hasNum);

            let score = 0;
            if (hasLen) score++;
            if (hasLetter) score++;
            if (hasNum) score++;
            if (hasUpper) score++;
            if (hasSpecial) score++;

            const fill = $('strength-fill');
            const label = $('strength-label');
            const configs = [
                {pct:'0%', color:'', text:'Masukkan password'},
                {pct:'25%', color:'#FF4D6A', text:'Lemah'},
                {pct:'50%', color:'#FB923C', text:'Cukup'},
                {pct:'75%', color:'#FBBF24', text:'Baik'},
                {pct:'90%', color:'#34D399', text:'Kuat'},
                {pct:'100%', color:'#10B981', text:'Sangat Kuat'},
            ];
            const c = configs[score] || configs[0];
            fill.style.width = c.pct;
            fill.style.background = c.color;
            label.textContent = c.text;
            label.style.color = c.color || '#8A9BBF';
        });
    }

    function toggleReq(id, met){
        const el=$(id); if(!el) return;
        el.classList.toggle('met', met);
        el.querySelector('i').className = met ? 'fas fa-circle-check' : 'fas fa-circle';
    }

    function showError(msg){
        const box=$('alert-error');
        box.innerHTML=`<div style="display:flex;align-items:center;gap:8px;"><i class="fas fa-circle-exclamation"></i><span>${msg}</span></div>`;
        box.classList.add('show');
    }
    function hideError(){$('alert-error').classList.remove('show')}

    function setLoading(on){
        $('btn-submit').disabled=on;
        $('spinner').classList.toggle('show',on);
        $('btn-label').textContent=on?'Menyimpan...':'Simpan Password Baru';
    }

    async function submitReset(){
        hideError();
        const pw=$('password').value;
        const confirm=$('confirm').value;
        const token=$('reset-token').value;

        if(!pw||!confirm){showError('Semua field wajib diisi.');return;}
        if(pw.length<8){showError('Password minimal 8 karakter.');return;}
        if(!/[a-zA-Z]/.test(pw)||!/[0-9]/.test(pw)){showError('Password harus mengandung huruf dan angka.');return;}
        if(pw!==confirm){showError('Konfirmasi password tidak cocok.');return;}

        setLoading(true);
        try{
            const form=new FormData();
            form.append('token',token);
            form.append('password',pw);
            form.append('password_confirm',confirm);

            const res=await fetch(BASE_URL+'/forgot-password/reset',{
                method:'POST',
                headers:{'X-CSRF-TOKEN':getCsrfToken()},
                body:form,
            });
            if(!res.ok) throw new Error('Server error '+res.status);
            const data=await res.json();

            if(data.status==='successful'){
                $('form-state').style.display='none';
                $('done-state').classList.add('show');
            } else {
                showError(data.message||'Gagal menyimpan password. Coba lagi.');
            }
        } catch(err){
            showError('Terjadi gangguan koneksi. Silakan coba lagi.');
        } finally{
            setLoading(false);
        }
    }

    const btn=$('btn-submit');
    if(btn) btn.addEventListener('click',submitReset);
    document.addEventListener('keydown',e=>{if(e.key==='Enter') submitReset();});
    </script>
</body>
</html>
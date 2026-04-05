<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= isset($title) ? esc($title) : 'LMS Elecomp'; ?></title>

    <?= $this->renderSection('meta'); ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        :root {
            --c-primary: #03AADE;
            --c-dark:    #0D2656;
            --c-accent:  #F2BF02;
            --c-white:   #fff;
        }

        body { background: #f4f6f9; }

        .navbar-lms {
            background: linear-gradient(to right, var(--c-dark), var(--c-primary));
            padding: 0 0;
            box-shadow: 0 2px 12px rgba(0,0,0,.15);
            position: sticky; top: 0; z-index: 1030;
        }
        .navbar-lms .navbar-brand { font-weight: 700; color: #fff; font-size: 18px; letter-spacing: .3px; }
        .navbar-lms .navbar-brand:hover { color: var(--c-accent); }
        .navbar-lms .nav-link {
            color: rgba(255,255,255,.85) !important;
            font-weight: 500; font-size: 14px;
            padding: 18px 14px !important;
            transition: color .2s, border-bottom .2s;
            border-bottom: 3px solid transparent;
        }
        .navbar-lms .nav-link:hover,
        .navbar-lms .nav-link.active { color: #fff !important; border-bottom-color: var(--c-accent); }
        .navbar-lms .dropdown-menu { border: none; border-radius: 10px; box-shadow: 0 8px 24px rgba(0,0,0,.12); min-width: 180px; }
        .navbar-lms .dropdown-item { font-size: 13px; padding: 9px 16px; transition: background .2s; }
        .navbar-lms .dropdown-item:hover { background: #f0f2f5; color: var(--c-dark); }

        .role-badge { font-size: 10px; padding: 2px 8px; border-radius: 20px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; }
        .role-admin { background: #fee2e2; color: #b91c1c; }
        .role-guru  { background: #d1fae5; color: #065f46; }
        .role-siswa { background: #dbeafe; color: #1e40af; }

        .avatar-circle {
            width: 34px; height: 34px; border-radius: 50%;
            background: var(--c-accent); color: var(--c-dark);
            display: flex; align-items: center; justify-content: center;
            font-weight: 700; font-size: 13px; flex-shrink: 0;
        }

        .footer-lms {
            background: var(--c-dark); color: rgba(255,255,255,.7);
            padding: 16px 0; text-align: center; font-size: 13px; margin-top: 60px;
        }
        .footer-lms a { color: var(--c-accent); text-decoration: none; }

        /* ── Overlay logout ── */
        @keyframes lo-fadein  { from { opacity:0 } to { opacity:1 } }
        @keyframes lo-slidein { from { opacity:0; transform:translateY(22px) scale(.97) } to { opacity:1; transform:translateY(0) scale(1) } }
        @keyframes lo-ring    { 0%,100%{transform:rotate(-12deg)} 25%{transform:rotate(12deg)} 50%{transform:rotate(-8deg)} 75%{transform:rotate(8deg)} }
        @keyframes lo-pulse   { 0%,100%{box-shadow:0 0 0 0 rgba(239,68,68,.35)} 50%{box-shadow:0 0 0 14px rgba(239,68,68,0)} }

        #logout-overlay {
            display: none;
            position: fixed; inset: 0; z-index: 99999;
            background: rgba(7, 16, 40, 0.88);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            align-items: center; justify-content: center;
            animation: lo-fadein .25s ease both;
        }
        #logout-overlay.show { display: flex; }

        .logout-overlay-card {
            background: linear-gradient(160deg, #0f1f4e 0%, #0a1530 100%);
            border: 1px solid rgba(255,255,255,.08);
            border-radius: 24px;
            padding: 40px 44px 36px;
            text-align: center;
            box-shadow: 0 32px 80px rgba(0,0,0,.55), 0 0 0 1px rgba(3,170,222,.15);
            max-width: 360px; width: 90%;
            animation: lo-slidein .3s cubic-bezier(.22,1,.36,1) both;
        }

        .logout-overlay-icon-wrap {
            width: 68px; height: 68px; border-radius: 50%;
            background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
            display: inline-flex; align-items: center; justify-content: center;
            margin-bottom: 20px;
            animation: lo-pulse 1.4s ease-in-out infinite;
        }
        .logout-overlay-icon-wrap i { font-size: 28px; color: #fff; animation: lo-ring 1.6s ease-in-out infinite; }

        .logout-overlay-title {
            font-size: 18px; font-weight: 800; color: #fff;
            letter-spacing: -.3px; margin-bottom: 8px;
        }
        .logout-overlay-desc { font-size: 13.5px; color: rgba(255,255,255,.55); line-height: 1.65; }

        .logout-progress-wrap {
            margin-top: 28px; height: 3px;
            background: rgba(255,255,255,.1); border-radius: 99px; overflow: hidden;
        }
        #logout-progress {
            height: 100%; width: 0%;
            background: linear-gradient(to right, #ef4444, #f97316);
            border-radius: 99px;
            transition: width 1.8s linear;
        }

        .logout-toast {
            display: none; position: fixed; bottom: 24px; right: 24px; z-index: 9999;
            background: #0f1f4e; color: #fff;
            padding: 14px 20px; border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0,0,0,.3);
            font-size: 14px; max-width: 320px;
            border-left: 4px solid #ef4444;
            opacity: 0; transform: translateY(10px);
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
        .logout-toast.show { display: block; opacity: 1; transform: translateY(0); }
    </style>

    <?= $this->renderSection('styles'); ?>
</head>

<body class="protected-page">

<!-- Overlay logout fullscreen -->
<div id="logout-overlay">
    <div class="logout-overlay-card">
        <div class="logout-overlay-icon-wrap">
            <i class="fas fa-shield-alt"></i>
        </div>
        <div class="logout-overlay-title">Sesi Diambil Alih</div>
        <div class="logout-overlay-desc">
            Akun Anda baru saja masuk di perangkat lain.<br>
            Anda akan keluar otomatis...
        </div>
        <div class="logout-progress-wrap">
            <div id="logout-progress"></div>
        </div>
    </div>
</div>

<!-- Toast fallback -->
<div id="logout-toast" class="logout-toast">
    <i class="fas fa-exclamation-circle me-2" style="color:#ef4444;"></i>
    Sesi Anda diambil alih perangkat lain. Logout otomatis...
</div>

<!-- NAVBAR -->
<nav class="navbar navbar-lms navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url('/dashboard') ?>">
            <i class="fas fa-bolt me-2" style="color:var(--c-accent);"></i>LMS Elecomp
        </a>
        <button class="navbar-toggler border-light" type="button"
            data-bs-toggle="collapse" data-bs-target="#navMain">
            <i class="fas fa-bars text-white"></i>
        </button>
        <div class="collapse navbar-collapse" id="navMain">
            <ul class="navbar-nav me-auto">
                <?php $role = session()->get('role'); ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/dashboard/' . $role) ?>">
                        <i class="fas fa-home me-1"></i>Dashboard
                    </a>
                </li>
                <?php if (in_array($role, ['guru','siswa'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/kelas') ?>">
                        <i class="fas fa-chalkboard me-1"></i>Kelas
                    </a>
                </li>
                <?php endif; ?>
                <?php if ($role === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/users') ?>">
                        <i class="fas fa-users me-1"></i>Kelola User
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/kelas') ?>">
                        <i class="fas fa-chalkboard me-1"></i>Kelas
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav ms-auto align-items-center gap-2">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 py-2"
                        href="#" id="userMenu" data-bs-toggle="dropdown">
                        <div class="avatar-circle">
                            <?= strtoupper(substr(session()->get('nama') ?? 'U', 0, 1)) ?>
                        </div>
                        <div class="d-none d-lg-block text-start" style="line-height:1.2;">
                            <div style="font-size:13px;font-weight:600;color:#fff;">
                                <?= esc(session()->get('nama')) ?>
                            </div>
                            <div>
                                <span class="role-badge role-<?= esc($role) ?>">
                                    <?= esc($role) ?>
                                </span>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <div class="px-3 py-2 border-bottom">
                                <div style="font-weight:600;font-size:13px;"><?= esc(session()->get('nama')) ?></div>
                                <div style="font-size:12px;color:#888;"><?= esc(session()->get('email')) ?></div>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= base_url('/logout') ?>">
                                <i class="fas fa-sign-out-alt me-2 text-danger"></i>Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- CONTENT -->
<main class="py-4">
    <div class="container">
        <?= $this->renderSection('content'); ?>
    </div>
</main>

<!-- FOOTER -->
<footer class="footer-lms">
    <div class="container">
        &copy; <?= date('Y') ?> <strong>LMS Elecomp</strong> — All rights reserved.
    </div>
</footer>

<!-- SCRIPTS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    <?php if (session()->getFlashdata('success')): ?>
        Swal.fire({ icon:'success', title:'Berhasil', text:'<?= esc(session()->getFlashdata('success')) ?>', timer:2000, showConfirmButton:false });
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        Swal.fire({ icon:'error', title:'Gagal', text:'<?= esc(session()->getFlashdata('error')) ?>' });
    <?php endif; ?>
</script>

<script src="<?= base_url('js/realtime.js') ?>"></script>
<script>
    let logoutTriggered = false;
    let monitor; // dideklarasi lebih awal agar triggerAutoLogout bisa akses tanpa ReferenceError

    /**
     * Tampilkan overlay dan redirect ke /logout setelah 3 detik.
     * Menggunakan /logout (bukan /login) agar session server ikut di-destroy.
     */
    function triggerAutoLogout() {
        if (logoutTriggered) return;
        logoutTriggered = true;

        if (monitor) monitor.stop();

        const overlay = document.getElementById('logout-overlay');
        overlay.classList.add('show');

        // Mulai progress bar langsung (transition 1.8s di CSS)
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                document.getElementById('logout-progress').style.width = '100%';
            });
        });

        // Redirect setelah 2 detik — fetch logout dulu untuk destroy session server
        setTimeout(async () => {
            try {
                await fetch('<?= base_url("/logout") ?>', { method: 'GET', redirect: 'manual' });
            } catch (_) {}
            window.location.replace('<?= base_url("/login") ?>');
        }, 2000);
    }

    monitor = new RealtimeMonitor({
        baseUrl: "<?= base_url() ?>",
        user:    "<?= esc(session()->get('email')) ?>",

        onConnected:    () => console.log('[SSE] Terhubung'),
        onDisconnected: () => console.log('[SSE] Terputus, mencoba reconnect...'),
        onError:        (e) => console.warn('[SSE] Error:', e),

        onNewAttendance: (data) => {
            // Tangani event absensi baru jika diperlukan
            console.log('[SSE] Absensi baru:', data);
        },

        /**
         * Server HANYA mengirim event ini jika fingerprint di DB sudah
         * berbeda dari cookie tab ini — artinya sesi kita sudah diambil alih.
         *
         * Tidak perlu membandingkan fingerprint di sini.
         * Langsung trigger logout.
         */
        onUpdateAttendance: (data) => {
            console.log('[SSE] Sesi diambil alih:', data);
            triggerAutoLogout();
        },
    });

    document.addEventListener('DOMContentLoaded', () => {
        if (document.body.classList.contains('protected-page')) {
            monitor.start();
        }
    });

    window.addEventListener('beforeunload', () => monitor.stop());
</script>

<?= $this->renderSection('scripts'); ?>
</body>
</html>
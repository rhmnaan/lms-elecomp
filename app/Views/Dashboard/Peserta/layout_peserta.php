<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo isset($title) ? esc($title) : 'LMS Elecomp'; ?></title>

    <?php echo $this->renderSection('meta'); ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="<?php echo base_url('css/peserta-layout.css') ?>">
    <style>
        .sidebar-logo {
            padding: 30px 20px !important;
            text-align: center;
            border-bottom: 1px solid #e5e7eb;
            background: #ffffff;
            min-height: 120px !important;
        }

        .sidebar-logo .logo-mark {
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
            width: 100% !important;
        }

        .sidebar-logo .logo-image {
            width: 200px !important;
            /* Fixed width */
            max-width: 200px !important;
            height: auto !important;
            object-fit: contain !important;
            display: block !important;
            margin: 0 auto !important;
        }

        /* Responsive untuk layar kecil */
        @media (max-width: 768px) {
            .sidebar-logo .logo-image {
                width: 160px !important;
                max-width: 160px !important;
            }
        }

        /* Sidebar collapsed */
        .sidebar.collapsed .sidebar-logo .logo-image,
        .sidebar:not(.show) .sidebar-logo .logo-image {
            width: 200px !important;
        }
    </style>
    <?php echo $this->renderSection('styles'); ?>
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

    <div class="wrapper">
        <div class="sidebar-overlay" onclick="closeSidebar()"></div>

        <!-- ── SIDEBAR ── -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-logo">
                <div class="logo-mark">
                    <img src="<?php echo base_url('logo/image.png') ?>" 
     class="logo-image" 
     alt="Absys Group"
     style="width: 220px !important; max-width: 220px !important; height: auto !important; display: block !important; margin: 0 auto !important;">
                </div>
            </div>
            <div class="menu-label">Menu Utama</div>

            <ul class="sidebar-nav">
                <li <?php echo uri_string() === 'dashboard/peserta/beranda' ? 'class="active"' : '' ?>>
                    <a href="<?php echo base_url('dashboard/peserta/beranda') ?>">
                        <i class="bi bi-house-fill"></i> Beranda
                        <?php if (uri_string() === 'dashboard/peserta/beranda'): ?>
                            <span class="dot"></span>
                        <?php endif; ?>
                    </a>
                </li>

                <!-- TEMUKAN KELAS -->
                <li <?php echo str_starts_with(uri_string(), 'dashboard/peserta/program') ? 'class="active"' : '' ?>>
                    <a href="<?php echo base_url('dashboard/peserta/program') ?>">
                        <i class="bi bi-search"></i> Temukan Kelas
                        <?php if (str_starts_with(uri_string(), 'dashboard/peserta/program')): ?>
                            <span class="dot"></span>
                        <?php endif; ?>
                    </a>
                </li>

                <!-- KELAS SAYA -->
                <li <?php echo str_starts_with(uri_string(), 'dashboard/peserta/kelas') ? 'class="active"' : '' ?>>
                    <a href="<?php echo base_url('dashboard/peserta/kelas') ?>">
                        <i class="bi bi-mortarboard-fill"></i> Kelas Saya
                        <?php if (str_starts_with(uri_string(), 'dashboard/peserta/kelas')): ?>
                            <span class="dot"></span>
                        <?php endif; ?>
                    </a>
                </li>
                <li <?php echo str_starts_with(uri_string(), 'dashboard/peserta/aplikasi') ? 'class="active"' : '' ?>>
                    <a href="<?php echo base_url('dashboard/peserta/aplikasi') ?>">
                        <i class="bi bi-grid-fill"></i> Aplikasi Pendukung
                        <?php if (str_starts_with(uri_string(), 'dashboard/peserta/aplikasi')): ?>
                            <span class="dot"></span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>
            <div class="menu-label" style="margin-top:12px;">Akun</div>
            <ul class="sidebar-nav">
                <li <?php echo uri_string() === 'dashboard/peserta/profil' ? 'class="active"' : '' ?>>
                    <a href="<?php echo base_url('dashboard/peserta/profil') ?>">
                        <i class="bi bi-person-circle"></i> Profil Saya
                        <?php if (uri_string() === 'dashboard/peserta/profil'): ?>
                            <span class="dot"></span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>

            <div class="sidebar-logout">
                <a href="<?php echo base_url('/logout') ?>">
                    <i class="bi bi-box-arrow-right"></i> Keluar Akun
                </a>
            </div>
        </aside>

        <!-- ── MAIN ── -->
        <div class="main">

            <!-- TOPBAR -->
            <div class="topbar">
                <button class="hamburger-btn" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <div class="search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Cari materi, modul,...">
                </div>
                <div class="topbar-right">
                    <div class="notif-btn">
                        <i class="bi bi-bell-fill"></i>
                        <span class="badge-dot"></span>
                    </div>
                    <div class="user-info">
                        <div class="avatar">
                            <?php echo strtoupper(substr(session()->get('nama') ?? 'S', 0, 1)) ?>
                        </div>
                        <div class="user-meta">
                            <div class="user-name"><?php echo esc(session()->get('nama') ?? 'Siswa') ?></div>
                            <div class="user-role">Peserta Didik</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="admin-content">
                <?php echo $this->renderSection('content'); ?>
            </div>

        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function toggleSub(el) {
            el.closest('.has-sub').classList.toggle('open');
        }
    </script>

    <script>
        <?php if (session()->getFlashdata('success')): ?>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '<?php echo esc(session()->getFlashdata('success')) ?>',
                timer: 2000,
                showConfirmButton: false
            });
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '<?php echo esc(session()->getFlashdata('error')) ?>'
            });
        <?php endif; ?>
    </script>

    <!-- Pastikan cookie device_fp selalu ada di browser -->
    <script>
        (function() {
            function hashStr(str) {
                let h = 0;
                for (let i = 0; i < str.length; i++) {
                    h = (h << 5) - h + str.charCodeAt(i);
                    h = h & h;
                }
                return Math.abs(h).toString(36);
            }

            function generateFingerprint() {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                ctx.textBaseline = 'top';
                ctx.font = '14px Arial';
                ctx.fillText('fp', 2, 2);
                return hashStr([
                    navigator.userAgent,
                    navigator.language,
                    screen.colorDepth,
                    screen.width + 'x' + screen.height,
                    new Date().getTimezoneOffset(),
                    !!window.sessionStorage,
                    !!window.localStorage,
                    canvas.toDataURL(),
                ].join('|||'));
            }

            function getCookie(name) {
                const m = document.cookie.match(new RegExp('(?:^|; )' + name + '=([^;]*)'));
                return m ? decodeURIComponent(m[1]) : null;
            }

            function setCookieFP(value) {
                const exp = new Date();
                exp.setFullYear(exp.getFullYear() + 1);
                document.cookie = `device_fp=${value}; expires=${exp.toUTCString()}; path=/; SameSite=Strict`;
            }

            if (!getCookie('device_fp')) {
                setCookieFP(generateFingerprint());
            }
        })();
    </script>

    <script src="<?php echo base_url('js/realtime.js') ?>"></script>
    <script>
        let logoutTriggered = false;
        let monitor;

        function triggerAutoLogout() {
            if (logoutTriggered) return;
            logoutTriggered = true;
            if (monitor) monitor.stop();
            const overlay = document.getElementById('logout-overlay');
            overlay.classList.add('show');
            requestAnimationFrame(() => {
                requestAnimationFrame(() => {
                    document.getElementById('logout-progress').style.width = '100%';
                });
            });
            setTimeout(async () => {
                try {
                    await fetch('<?php echo base_url("/logout") ?>', {
                        method: 'GET',
                        redirect: 'manual'
                    });
                } catch (_) {}
                window.location.replace('<?php echo base_url("/login") ?>');
            }, 2000);
        }

        monitor = new RealtimeMonitor({
            baseUrl: "<?php echo base_url() ?>",
            user: "<?php echo esc(session()->get('email_users')) ?>",
            onConnected: () => console.log('[SSE] Terhubung'),
            onDisconnected: () => console.log('[SSE] Terputus, mencoba reconnect...'),
            onError: (e) => console.warn('[SSE] Error:', e),
            onNewAttendance: (data) => console.log('[SSE] Notif baru:', data),
            onUpdateAttendance: (data) => {
                console.log('[SSE] Sesi diambil alih:', data);
                triggerAutoLogout();
            },
        });

        document.addEventListener('DOMContentLoaded', () => {
            if (document.body.classList.contains('protected-page')) monitor.start();
        });

        window.addEventListener('beforeunload', () => monitor.stop());
    </script>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            document.querySelector('.sidebar-overlay').classList.toggle('show');
        }

        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('show');
            document.querySelector('.sidebar-overlay').classList.remove('show');
        }
    </script>

    <?php echo $this->renderSection('scripts'); ?>
</body>

</html>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo isset($title) ? esc($title) : 'LMS Elecomp — Pengajar'; ?></title>

    <?php echo $this->renderSection('meta'); ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="<?php echo base_url('css/pengajar-layout.css') ?>">

    <style>
        /* ── SIDEBAR STRUCTURE ── */
        .sidebar {
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
        }

        .sidebar-logo {
            flex-shrink: 0;
        }

        .sidebar-nav-wrapper {
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
            padding-bottom: 10px;
        }

        .sidebar-nav-wrapper::-webkit-scrollbar { width: 6px; }
        .sidebar-nav-wrapper::-webkit-scrollbar-track { background: rgba(0,0,0,.03); }
        .sidebar-nav-wrapper::-webkit-scrollbar-thumb { background: rgba(0,0,0,.12); border-radius: 3px; }
        .sidebar-nav-wrapper::-webkit-scrollbar-thumb:hover { background: rgba(0,0,0,.2); }

        .sidebar-logout {
            flex-shrink: 0;
        }

        /* ── HAMBURGER BUTTON ── */
        .hamburger-btn {
            display: none;
            background: transparent;
            border: none;
            width: 40px;
            height: 40px;
            padding: 0;
            cursor: pointer;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 5px;
            flex-shrink: 0;
            border-radius: 8px;
            transition: background .15s;
        }

        .hamburger-btn:hover { background: #f3f4f6; }

        .hamburger-btn span {
            display: block;
            width: 22px;
            height: 2px;
            background: #374151;
            border-radius: 99px;
            transition: transform .3s ease, opacity .3s ease;
            pointer-events: none;
        }

        .hamburger-btn.active span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .hamburger-btn.active span:nth-child(2) { opacity: 0; }
        .hamburger-btn.active span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* ── SIDEBAR OVERLAY ── */
        .sidebar-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 998;
            opacity: 0;
            visibility: hidden;
            transition: opacity .3s ease, visibility .3s ease;
        }

        .sidebar-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* ── MOBILE RESPONSIVE ── */
        @media (max-width: 1024px) {
            .hamburger-btn {
                display: flex;
            }

            .sidebar {
                position: fixed !important;
                left: 0;
                top: 0;
                height: 100% !important;
                z-index: 999;
                transform: translateX(-100%);
                transition: transform .3s cubic-bezier(.4,0,.2,1);
                box-shadow: 4px 0 24px rgba(0,0,0,.10);
                visibility: visible !important; /* override apapun */
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .mobile-brand { display: flex; }

            .main { width: 100% !important; }

            .topbar {
                display: flex;
                align-items: center;
                gap: 12px;
            }
        }

        @media (max-width: 768px) {
            .topbar { padding: 12px 16px; }
            .search-wrap { flex: 1; }
            .user-meta { display: none; }
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

    <!-- ── SIDEBAR OVERLAY (backdrop mobile) ── -->
    <div class="sidebar-overlay" id="sidebar-overlay"></div>

    <div class="wrapper">

        <!-- ── SIDEBAR ── -->
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-logo">
                <div class="logo-mark d-flex align-items-center">
                    <img src="<?php echo base_url('logo/image.png') ?>" alt="Elecomp LMS" class="logo-image mr-2">
                </div>
                <p class="logo-tagline">Learning Management System</p>
            </div>

            <!-- Wrapper untuk menu yang bisa scroll -->
            <div class="sidebar-nav-wrapper">
                <div class="menu-label">Menu Utama</div>

                <?php
                $isPeserta = str_starts_with(uri_string(), 'dashboard/pengajar/peserta');
                $isKelas   = str_starts_with(uri_string(), 'dashboard/pengajar/kelas')
                    || str_starts_with(uri_string(), 'dashboard/pengajar/modul')
                    || str_starts_with(uri_string(), 'dashboard/pengajar/materi');
                ?>

                <ul class="sidebar-nav">

                    <!-- Beranda -->
                    <li <?php echo (uri_string() === 'dashboard/pengajar/beranda') ? 'class="active"' : '' ?>>
                        <a href="<?php echo base_url('dashboard/pengajar/beranda') ?>">
                            <i class="bi bi-house-fill"></i> Beranda
                            <?php if (uri_string() === 'dashboard/pengajar/beranda'): ?>
                                <span class="dot"></span>
                            <?php endif; ?>
                        </a>
                    </li>

                    <!-- Manajemen Kelas dengan submenu dropdown -->
                    <?php $isKelas = str_starts_with(uri_string(), 'dashboard/pengajar/kelas')
                        || str_starts_with(uri_string(), 'dashboard/pengajar/modul')
                        || str_starts_with(uri_string(), 'dashboard/pengajar/materi'); ?>
                    <li class="has-sub <?= $isKelas ? 'open' : '' ?>">
                        <a href="#" onclick="toggleSub(this); return false;">
                            <i class="bi bi-book-fill"></i> Manajemen Kelas
                            <i class="bi bi-chevron-down sub-arrow"
                                style="margin-left:auto;font-size:11px;transition:transform .2s;"></i>
                        </a>
                        <ul class="sub-nav">
                            <li <?php echo str_starts_with(uri_string(), 'dashboard/pengajar/program') ? 'class="sub-active"' : '' ?>>
                                <a href="<?php echo base_url('dashboard/pengajar/program') ?>">
                                    <i class="bi bi-grid-1x2-fill"></i> Program
                                </a>
                            </li>
                            <li <?php echo str_starts_with(uri_string(), 'dashboard/pengajar/kelas') ? 'class="sub-active"' : '' ?>>
                                <a href="<?php echo base_url('dashboard/pengajar/kelas') ?>">
                                    <i class="bi bi-mortarboard-fill"></i> Daftar Kelas
                                </a>
                            </li>
                            <li <?php echo str_starts_with(uri_string(), 'dashboard/pengajar/modul') ? 'class="sub-active"' : '' ?>>
                                <a href="<?php echo base_url('dashboard/pengajar/modul') ?>">
                                    <i class="bi bi-journal-bookmark-fill"></i> Modul
                                </a>
                            </li>
                            <li <?php echo str_starts_with(uri_string(), 'dashboard/pengajar/tugas') ? 'class="sub-active"' : '' ?>>
                                <a href="<?php echo base_url('dashboard/pengajar/tugas') ?>">
                                    <i class="bi bi-pencil-square"></i> Tugas
                                </a>
                            </li>
                            <li <?php echo str_starts_with(uri_string(), 'dashboard/pengajar/materi') ? 'class="sub-active"' : '' ?>>
                                <a href="<?php echo base_url('dashboard/pengajar/materi-list') ?>">
                                    <i class="bi bi-play-circle-fill"></i> Materi
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Aplikasi Pendukung -->
                    <li <?php echo str_starts_with(uri_string(), 'dashboard/pengajar/aplikasi-pendukung') ? 'class="active"' : '' ?>>
                        <a href="<?php echo base_url('dashboard/pengajar/aplikasi-pendukung') ?>">
                            <i class="bi bi-puzzle-fill"></i> Aplikasi Pendukung
                            <?php if (str_starts_with(uri_string(), 'dashboard/pengajar/aplikasi-pendukung')): ?>
                                <span class="dot"></span>
                            <?php endif; ?>
                        </a>
                    </li>

                    <!-- Peserta (submenu) -->
                    <li class="has-sub <?php echo $isPeserta ? 'open' : '' ?>">
                        <a href="#" onclick="toggleSub(this); return false;">
                            <i class="bi bi-people-fill"></i> Peserta
                            <i class="bi bi-chevron-down sub-arrow"
                                style="margin-left:auto;font-size:11px;transition:transform .2s;"></i>
                        </a>
                        <ul class="sub-nav">
                            <li <?php echo uri_string() === 'dashboard/pengajar/peserta' ? 'class="sub-active"' : '' ?>>
                                <a href="<?php echo base_url('dashboard/pengajar/peserta') ?>">
                                    <i class="bi bi-person-lines-fill"></i> Daftar Peserta
                                </a>
                            </li>
                            <li <?php echo str_starts_with(uri_string(), 'dashboard/pengajar/peserta/verifikasi') ? 'class="sub-active"' : '' ?>>
                                <a href="<?php echo base_url('dashboard/pengajar/peserta/verifikasi') ?>">
                                    <i class="bi bi-shield-check"></i> Verifikasi Email
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Voucher -->
                    <li <?= (str_starts_with(uri_string(), 'dashboard/pengajar/voucher')) ? 'class="active"' : '' ?>>
                        <a href="<?= base_url('dashboard/pengajar/voucher') ?>">
                            <i class="bi bi-ticket-perforated-fill"></i> Voucher
                            <?php if (str_starts_with(uri_string(), 'dashboard/pengajar/voucher')): ?>
                                <span class="dot"></span>
                            <?php endif; ?>
                        </a>
                    </li>

                </ul>

                <div class="menu-label" style="margin-top:12px;">Akun</div>
                <ul class="sidebar-nav">
                    <li <?php echo uri_string() === 'dashboard/pengajar/profil' ? 'class="active"' : '' ?>>
                        <a href="<?php echo base_url('dashboard/pengajar/profil') ?>">
                            <i class="bi bi-person-circle"></i> Profil Saya
                            <?php if (uri_string() === 'dashboard/pengajar/profil'): ?>
                                <span class="dot"></span>
                            <?php endif; ?>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Logout tetap di bawah, tidak ikut scroll -->
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

                <!-- ✅ HAMBURGER BUTTON — harus ada di sini -->
                <button id="hamburger-btn" class="hamburger-btn" aria-label="Toggle sidebar">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <!-- Mobile brand (logo kecil di topbar saat mobile) -->
                <div class="mobile-brand">
                    <img src="<?php echo base_url('logo/image.png') ?>" alt="Elecomp LMS">
                </div>

                <div class="search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Cari kelas, materi, atau peserta...">
                </div>

                <div class="topbar-right">
                    <div class="notif-btn">
                        <i class="bi bi-bell-fill"></i>
                        <span class="badge-dot"></span>
                    </div>

                    <a href="<?php echo base_url('dashboard/pengajar/profil') ?>" class="user-info" style="text-decoration:none;">
                        <div class="avatar">
                            <?php echo strtoupper(substr(session()->get('nama') ?? 'P', 0, 1)) ?>
                        </div>
                        <div class="user-meta">
                            <div class="user-name"><?php echo esc(session()->get('nama') ?? 'Pengajar') ?></div>
                            <div class="user-role">Pengajar</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="pengajar-content">
                <?php echo $this->renderSection('content'); ?>
            </div>

        </div><!-- /main -->
    </div><!-- /wrapper -->

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

    <script src="<?= base_url('js/realtime.js') ?>"></script>

    <script>
        /* ── REALTIME / LOGOUT ── */
        let logoutTriggered = false;
        let monitor;

        function triggerAutoLogout() {
            if (logoutTriggered) return;
            logoutTriggered = true;
            if (monitor) monitor.stop();
            const logoutOverlay = document.getElementById('logout-overlay');
            logoutOverlay.classList.add('show');
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
            user: "<?php echo esc(session()->get('email')) ?>",
            onConnected: () => console.log('[SSE] Terhubung'),
            onDisconnected: () => console.log('[SSE] Terputus, mencoba reconnect...'),
            onError: (e) => console.warn('[SSE] Error:', e),
            onNewAttendance: (data) => console.log('[SSE] Absensi baru:', data),
            onUpdateAttendance: (data) => {
                console.log('[SSE] Sesi diambil alih:', data);
                triggerAutoLogout();
            },
        });

        document.addEventListener('DOMContentLoaded', () => {
            if (document.body.classList.contains('protected-page')) monitor.start();
        });

        window.addEventListener('beforeunload', () => monitor.stop());

        /* ── HAMBURGER / MOBILE SIDEBAR ── */
        const hamburgerBtn   = document.getElementById('hamburger-btn');
        const sidebar        = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay'); // ← rename, bukan 'overlay' agar tidak konflik logout

        function openSidebar() {
            sidebar.classList.add('open');
            sidebarOverlay.classList.add('show');  // ← CSS pakai .show
            hamburgerBtn.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('show');
            hamburgerBtn.classList.remove('active');
            document.body.style.overflow = '';
        }

        if (hamburgerBtn) {
            hamburgerBtn.addEventListener('click', () => {
                sidebar.classList.contains('open') ? closeSidebar() : openSidebar();
            });
        }

        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeSidebar);
        }

        // Tutup sidebar saat link diklik di mobile (kecuali link submenu)
        sidebar.querySelectorAll('a:not(.has-sub > a)').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth <= 1024) closeSidebar();
            });
        });

        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') closeSidebar();
        });

        /* ── SUBMENU TOGGLE ── */
        function toggleSub(el) {
            el.closest('.has-sub').classList.toggle('open');
        }
    </script>

    <?php echo $this->renderSection('scripts'); ?>
</body>

</html>
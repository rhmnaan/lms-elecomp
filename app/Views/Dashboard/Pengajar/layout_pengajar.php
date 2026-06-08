<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php echo isset($title) ? esc($title) : 'LMS'; ?></title>

    <?php echo $this->renderSection('meta'); ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="<?php echo base_url('css/peserta-layout.css') ?>">

    <!-- Preconnect ke CDN yang sering dipakai -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">

    <style>
    /* =============================================
       RESPONSIVE OVERRIDES — Mobile & Tablet
       ============================================= */

    /* ── SIDEBAR LOGO ── */
    .sidebar-logo .logo-image {
        width: 110px !important;
        max-width: 110px !important;
        height: auto !important;
        object-fit: contain !important;
        display: block !important;
        margin: 0 !important;
    }

    /* ── SIDEBAR LAYOUT ── */
    .sidebar {
        display: flex !important;
        flex-direction: column !important;
        height: 100vh !important;
        max-height: 100vh !important;
        overflow-y: auto !important;
        overflow-x: hidden !important;
    }

    .sidebar-logo,
    .sidebar .menu-label,
    .sidebar .sidebar-nav {
        flex-shrink: 0 !important;
    }

    .sidebar .sidebar-logout {
        flex-shrink: 0 !important;
        position: sticky !important;
        bottom: 0 !important;
        background: #ffffff !important;
        border-top: 1px solid rgba(0, 0, 0, 0.07) !important;
        padding: 10px 12px 20px !important;
        margin-top: auto !important;
        z-index: 2 !important;
    }

    /* ── SIDEBAR: off-canvas on tablet/mobile ── */
    @media (max-width: 1024px) {
        .sidebar {
            position: fixed !important;
            left: 0;
            top: 0;
            height: 100% !important;
            z-index: 200;
            transform: translateX(-100%);
            transition: transform 0.24s cubic-bezier(.4, 0, .2, 1);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.10);
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .hamburger-btn {
            display: flex !important;
        }

        .main {
            width: 100% !important;
            min-width: 0 !important;
            max-width: 100% !important;
            margin-left: 0 !important;
            overflow-x: hidden !important;
        }
    }

    /* Pastikan konten tidak meluber */
    .wrapper {
        overflow-x: hidden !important;
    }

    .admin-content {
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
        overflow-x: hidden !important;
    }

    .admin-content>* {
        box-sizing: border-box !important;
        max-width: 100% !important;
    }

    .stat-cards,
    .bottom-grid,
    .dash-card,
    .welcome-banner,
    .page-header {
        width: 100% !important;
        max-width: 100% !important;
        box-sizing: border-box !important;
    }

    /* ── HAMBURGER ── */
    .hamburger-btn {
        display: none;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        border: none;
        background: transparent;
        border-radius: 8px;
        cursor: pointer;
        color: #475569;
        font-size: 22px;
        flex-shrink: 0;
        transition: background 0.2s, color 0.2s;
    }

    .hamburger-btn:hover {
        background: #f1f5f9;
        color: #2563eb;
    }

    /* ── TOPBAR ── */
    .topbar {
        display: flex !important;
        align-items: center;
        gap: 12px;
    }

    /* ── OVERLAY ── */
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        z-index: 100;
        backdrop-filter: blur(2px);
        -webkit-backdrop-filter: blur(2px);
    }

    .sidebar-overlay.show {
        display: block;
    }

    /* ── MOBILE (≤ 640px) ── */
    @media (max-width: 640px) {
        .topbar {
            padding: 0 12px !important;
            gap: 8px !important;
            height: 56px !important;
        }

        /* Search bar selalu tampil, flex-grow mengisi sisa ruang */
        .search-wrap {
            flex: 1 !important;
            min-width: 0 !important;
            max-width: 100% !important;
            padding: 0 !important;
            border-radius: 0 !important;
            overflow: visible !important;
        }

        .search-wrap input {
            font-size: 13px !important;
            width: 100% !important;
            padding: 9px 12px 9px 36px !important;
            border-radius: 10px !important;
        }

        #searchIcon {
            cursor: default !important;
        }

        .user-meta {
            display: none !important;
        }

        .user-info {
            padding: 4px !important;
            border-radius: 50% !important;
        }

        /* Tanpa bottom nav, tidak perlu padding-bottom ekstra */
        .admin-content {
            padding: 14px 12px !important;
        }

        .sidebar-logo {
            padding: 18px 14px 12px !important;
        }

        .menu-label {
            padding: 12px 14px 4px !important;
        }

        .sidebar-nav {
            padding: 4px 8px !important;
        }

        .sidebar-logout {
            padding: 10px 8px 20px !important;
        }
    }

    /* ── PAGE LOADING BAR ── */
    #page-loader {
        position: fixed;
        top: 0;
        left: 0;
        height: 3px;
        width: 0%;
        background: #2563eb;
        z-index: 99999;
        transition: width 0.1s ease;
        border-radius: 0 2px 2px 0;
        display: none;
    }

    #page-loader.loading {
        display: block;
        animation: loaderProgress 1.2s ease-in-out forwards;
    }

    #page-loader.done {
        width: 100% !important;
        animation: none;
        opacity: 0;
        transition: opacity 0.3s ease, width 0.1s ease;
    }

    @keyframes loaderProgress {
        0% {
            width: 0%;
        }

        30% {
            width: 35%;
        }

        60% {
            width: 65%;
        }

        85% {
            width: 85%;
        }

        100% {
            width: 90%;
        }
    }
    </style>

    <?php echo $this->renderSection('styles'); ?>
</head>

<body class="protected-page">

    <div id="page-loader"></div>

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
                    <img src="<?= base_url('logo/image.png') ?>" alt="Elecomp LMS" class="logo-image">
                </div>
                <p class="logo-tagline">Learning Management System</p>
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

                <li <?php echo str_starts_with(uri_string(), 'dashboard/peserta/program') ? 'class="active"' : '' ?>>
                    <a href="<?php echo base_url('dashboard/peserta/program') ?>">
                        <i class="bi bi-search"></i> Temukan Kelas
                        <?php if (str_starts_with(uri_string(), 'dashboard/peserta/program')): ?>
                        <span class="dot"></span>
                        <?php endif; ?>
                    </a>
                </li>

                <li <?php echo str_starts_with(uri_string(), 'dashboard/peserta/kelas') ? 'class="active"' : '' ?>>
                    <a href="<?php echo base_url('dashboard/peserta/kelas') ?>">
                        <i class="bi bi-mortarboard-fill"></i> Kelas Saya
                        <?php if (str_starts_with(uri_string(), 'dashboard/peserta/kelas')): ?>
                        <span class="dot"></span>
                        <?php endif; ?>
                    </a>
                </li>

                <li class="<?= str_starts_with(uri_string(), 'dashboard/peserta/aplikasi') ? 'active' : '' ?>">
                    <a href="<?= base_url('dashboard/peserta/aplikasi') ?>">
                        <i class="bi bi-grid-fill"></i>
                        <span>Aplikasi Pendukung</span>
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
                <button class="hamburger-btn" onclick="toggleSidebar()" aria-label="Buka menu">
                    <i class="bi bi-list"></i>
                </button>

                <div class="search-wrap" id="searchWrap">
                    <i class="bi bi-search" id="searchIcon"></i>
                    <input type="text" placeholder="Cari materi, modul,..." id="searchInput">
                </div>

                <div class="topbar-right">
                    <div class="notif-btn">
                        <i class="bi bi-bell-fill"></i>
                        <span class="badge-dot"></span>
                    </div>

                    <a href="<?php echo base_url('dashboard/peserta/profil') ?>" class="user-info"
                        style="text-decoration:none;">
                        <div class="avatar">
                            <?php echo strtoupper(substr(session()->get('nama') ?? 'S', 0, 1)) ?>
                        </div>
                        <div class="user-meta">
                            <div class="user-name"><?php echo esc(session()->get('nama') ?? 'Siswa') ?></div>
                            <div class="user-role">Peserta Didik</div>
                        </div>
                    </a>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="admin-content">
                <?php echo $this->renderSection('content'); ?>
            </div>

        </div><!-- /.main -->
    </div><!-- /.wrapper -->

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    // ── SIDEBAR TOGGLE ──
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('show');
        document.querySelector('.sidebar-overlay').classList.toggle('show');
    }

    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('show');
        document.querySelector('.sidebar-overlay').classList.remove('show');
    }
    document.querySelectorAll('.sidebar-nav a, .sidebar-logout a').forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 1024) closeSidebar();
        });
    });

    // ── SUB-MENU TOGGLE ──
    function toggleSub(el) {
        el.closest('.has-sub').classList.toggle('open');
    }

    // ── USER DROPDOWN TOGGLE ──
    function toggleUserDropdown(e) {
        e.stopPropagation();
        const menu = document.getElementById('userDropdownMenu');
        const chevron = document.getElementById('dropdownChevron');
        const isOpen = menu.classList.contains('open');
        closeUserDropdown();
        if (!isOpen) {
            menu.classList.add('open');
            if (chevron) chevron.style.transform = 'rotate(180deg)';
        }
    }

    function closeUserDropdown() {
        const menu = document.getElementById('userDropdownMenu');
        const chevron = document.getElementById('dropdownChevron');
        if (menu) menu.classList.remove('open');
        if (chevron) chevron.style.transform = 'rotate(0deg)';
    }
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('userDropdown');
        if (dropdown && !dropdown.contains(e.target)) closeUserDropdown();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeUserDropdown();
    });
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

    <!-- Device fingerprint -->
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


    (function() {
        const loader = document.getElementById('page-loader');
        if (!loader) return;

        function startLoader() {
            loader.classList.remove('done');
            loader.classList.add('loading');
        }

        function finishLoader() {
            loader.classList.add('done');
            setTimeout(() => {
                loader.classList.remove('loading', 'done');
                loader.style.width = '0%';
            }, 350);
        }

        // Semua link biasa (bukan anchor, bukan target blank, bukan javascript:)
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a[href]');
            if (!link) return;

            const href = link.getAttribute('href');
            if (
                !href ||
                href.startsWith('#') ||
                href.startsWith('javascript') ||
                link.target === '_blank' ||
                e.ctrlKey || e.metaKey || e.shiftKey
            ) return;

            startLoader();
        });

        // Selesai saat halaman baru sudah load
        window.addEventListener('pageshow', finishLoader);
        window.addEventListener('load', finishLoader);
    })();
    </script>

    <?php echo $this->renderSection('scripts'); ?>
</body>

</html>
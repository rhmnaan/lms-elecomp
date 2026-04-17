<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= isset($title) ? esc($title) : 'LMS Elecomp — Pengajar'; ?></title>

    <?= $this->renderSection('meta'); ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="<?= base_url('css/pengajar-layout.css') ?>">

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

    <div class="wrapper">

        <!-- ── SIDEBAR ── -->
        <aside class="sidebar">
            <div class="sidebar-logo">
                <div class="logo-mark">
                    <div class="logo-icon"><i class="fas fa-bolt"></i></div>
                    <span class="logo-name">
                        <span class="ele">Ele</span><span class="comp">comp</span>
                    </span>
                </div>
                <p class="logo-tagline">Learning Management System</p>
            </div>

            <div class="menu-label">Menu Utama</div>

            <ul class="sidebar-nav">
                <li <?= (uri_string() === 'dashboard/pengajar/beranda') ? 'class="active"' : '' ?>>
                    <a href="<?= base_url('dashboard/pengajar/beranda') ?>">
                        <i class="bi bi-house-fill"></i> Beranda
                        <?php if (uri_string() === 'dashboard/pengajar/beranda'): ?><span
                                class="dot"></span><?php endif; ?>
                    </a>
                </li>

                <!-- ✅ KELAS SAYA dengan submenu dropdown -->
                <?php $isKelas = str_starts_with(uri_string(), 'dashboard/pengajar/kelas')
                    || str_starts_with(uri_string(), 'dashboard/pengajar/modul')
                    || str_starts_with(uri_string(), 'dashboard/pengajar/materi'); ?>
                <li class="has-sub <?= $isKelas ? 'open' : '' ?>">
                    <a href="#" onclick="toggleSub(this); return false;">
                        <i class="bi bi-book-fill"></i> Kelas Saya
                        <i class="bi bi-chevron-down sub-arrow"
                            style="margin-left:auto;font-size:11px;transition:transform .2s;"></i>
                    </a>
                    <ul class="sub-nav">

                        <!-- PROGRAM -->
                        <li <?= (str_starts_with(uri_string(), 'dashboard/pengajar/program')) ? 'class="active"' : '' ?>>
                            <a href="<?= base_url('dashboard/pengajar/program') ?>">
                                <i class="bi bi-grid-1x2-fill"></i>
                                Program
                                <?php if (str_starts_with(uri_string(), 'dashboard/pengajar/program')): ?>
                                    <span class="dot"></span>
                                <?php endif; ?>
                            </a>
                        </li>

                        <!-- KELAS -->
                        <li <?= (str_starts_with(uri_string(), 'dashboard/pengajar/kelas')) ? 'class="sub-active"' : '' ?>>
                            <a href="<?= base_url('dashboard/pengajar/kelas') ?>">
                                <i class="bi bi-mortarboard-fill"></i>
                                Daftar Kelas
                            </a>
                        </li>

                        <!-- MODUL -->
                        <li <?= (str_starts_with(uri_string(), 'dashboard/pengajar/modul')) ? 'class="sub-active"' : '' ?>>
                            <a href="<?= base_url('dashboard/pengajar/modul') ?>">
                                <i class="bi bi-journal-bookmark-fill"></i>
                                Modul
                            </a>
                        </li>

                        <!-- MATERI -->
                        <li <?= (str_starts_with(uri_string(), 'dashboard/pengajar/materi')) ? 'class="sub-active"' : '' ?>>
                            <a href="<?= base_url('dashboard/pengajar/materi-list') ?>">
                                <i class="bi bi-play-circle-fill"></i>
                                Materi
                            </a>
                        </li>

                    </ul>
                </li>

                <li <?= (str_starts_with(uri_string(), 'dashboard/pengajar/peserta')) ? 'class="active"' : '' ?>>
                    <a href="<?= base_url('dashboard/pengajar/peserta') ?>">
                        <i class="bi bi-people-fill"></i> Peserta
                        <?php if (str_starts_with(uri_string(), 'dashboard/pengajar/peserta')): ?><span
                                class="dot"></span><?php endif; ?>
                    </a>
                </li>
                <!--  MENU VOUCHER -->
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
                <li <?= uri_string() === 'dashboard/pengajar/profil' ? 'class="active"' : '' ?>>
                    <a href="<?= base_url('dashboard/pengajar/profil') ?>">
                        <i class="bi bi-person-circle"></i> Profil Saya
                        <?php if (uri_string() === 'dashboard/pengajar/profil'): ?>
                            <span class="dot"></span>
                        <?php endif; ?>
                    </a>
                </li>
            </ul>

            <div class="sidebar-logout">
                <a href="<?= base_url('/logout') ?>">
                    <i class="bi bi-box-arrow-right"></i> Keluar Akun
                </a>
            </div>
        </aside>

        <!-- ── MAIN ── -->
        <div class="main">

            <!-- TOPBAR -->
            <div class="topbar">
                <div class="search-wrap">
                    <i class="bi bi-search"></i>
                    <input type="text" placeholder="Cari kelas, materi, atau peserta...">
                </div>
                <div class="topbar-right">
                    <div class="notif-btn">
                        <i class="bi bi-bell-fill"></i>
                        <span class="badge-dot"></span>
                    </div>
                    <div class="user-info">
                        <div class="avatar">
                            <?= strtoupper(substr(session()->get('nama') ?? 'P', 0, 1)) ?>
                        </div>
                        <div class="user-meta">
                            <div class="user-name"><?= esc(session()->get('nama') ?? 'Pengajar') ?></div>
                            <div class="user-role">Pengajar</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="pengajar-content">
                <?= $this->renderSection('content'); ?>
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
                text: '<?= esc(session()->getFlashdata('success')) ?>',
                timer: 2000,
                showConfirmButton: false
            });
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '<?= esc(session()->getFlashdata('error')) ?>'
            });
        <?php endif; ?>
    </script>

    <script src="<?= base_url('js/realtime.js') ?>"></script>
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
                    await fetch('<?= base_url("/logout") ?>', {
                        method: 'GET',
                        redirect: 'manual'
                    });
                } catch (_) { }
                window.location.replace('<?= base_url("/login") ?>');
            }, 2000);
        }

        monitor = new RealtimeMonitor({
            baseUrl: "<?= base_url() ?>",
            user: "<?= esc(session()->get('email')) ?>",
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
    </script>
    <script>
        function toggleSub(el) {
            el.closest('.has-sub').classList.toggle('open');
        }
    </script>

    <?= $this->renderSection('scripts'); ?>
</body>

</html>
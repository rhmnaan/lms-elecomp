<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= isset($title) ? esc($title) : 'LMS Elecomp'; ?></title>

    <?= $this->renderSection('meta'); ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
    /* ─────────────────────────────────────────
           RESET & BASE
        ───────────────────────────────────────── */
    *,
    *::before,
    *::after {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        background: #f4f6fb;
        font-family: 'DM Sans', sans-serif;
        min-height: 100vh;
    }

    /* ─────────────────────────────────────────
           LAYOUT WRAPPER
        ───────────────────────────────────────── */
    .wrapper {
        display: flex;
        min-height: 100vh;
    }

    /* ─────────────────────────────────────────
           SIDEBAR
        ───────────────────────────────────────── */
    .sidebar {
        width: 240px;
        min-width: 240px;
        background: #fff;
        border-right: 1px solid #eee;
        display: flex;
        flex-direction: column;
        padding: 28px 20px 24px;
        position: sticky;
        top: 0;
        height: 100vh;
        overflow-y: auto;
    }

    .sidebar-logo {
        flex-direction: column;
        align-items: flex-start;
        gap: 4px;
    }

    .logo-mark {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .logo-icon {
        width: 36px;
        height: 36px;
        background: linear-gradient(135deg, #1a8fe3, #0d5fb5);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-size: 16px;
        box-shadow: 0 2px 8px rgba(13, 95, 181, .3);
    }

    .logo-name {
        font-size: 20px;
        font-weight: 900;
        letter-spacing: -.3px;
        color: #111;
        font-family: 'DM Sans', sans-serif;
    }

    .logo-name .ele {
        color: #111;
    }

    .logo-name .comp {
        color: #0d8de3;
    }

    .logo-tagline {
        font-size: 9.5px;
        color: #9ca3af;
        font-weight: 600;
        letter-spacing: .6px;
        margin: 2px 0 0 46px;
        text-transform: uppercase;
    }

    .menu-label {
        font-size: 10px;
        font-weight: 700;
        color: #9ca3af;
        letter-spacing: 1px;
        margin: 28px 0 10px 8px;
        text-transform: uppercase;
    }

    .sidebar-nav {
        list-style: none;
        padding: 0;
    }

    .sidebar-nav li a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 14px;
        border-radius: 10px;
        color: #6b7280;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        transition: background .15s, color .15s;
        position: relative;
    }

    .sidebar-nav li a:hover {
        background: #f1f5ff;
        color: #2d6cdf;
    }

    .sidebar-nav li.active a {
        background: #2d6cdf;
        color: #fff;
    }

    .sidebar-nav li.active a .dot {
        width: 6px;
        height: 6px;
        background: #fff;
        border-radius: 50%;
        position: absolute;
        right: 14px;
    }

    .sidebar-logout {
        margin-top: auto;
        border-top: 1px solid #f0f0f0;
        padding-top: 16px;
    }

    .sidebar-logout a {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #ef4444;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        padding: 10px 14px;
        border-radius: 10px;
        transition: background .15s;
    }

    .sidebar-logout a:hover {
        background: #fff1f1;
    }

    /* ─────────────────────────────────────────
           MAIN & TOPBAR
        ───────────────────────────────────────── */
    .main {
        flex: 1;
        display: flex;
        flex-direction: column;
        min-width: 0;
    }

    .topbar {
        background: #fff;
        border-bottom: 1px solid #eee;
        padding: 14px 30px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .search-wrap {
        position: relative;
        width: 360px;
    }

    .search-wrap i {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 14px;
    }

    .search-wrap input {
        width: 100%;
        padding: 10px 14px 10px 38px;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        font-size: 13px;
        color: #374151;
        background: #f9fafb;
        outline: none;
        transition: border .2s;
    }

    .search-wrap input:focus {
        border-color: #2d6cdf;
        background: #fff;
    }

    .topbar-right {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .notif-btn {
        width: 38px;
        height: 38px;
        background: #f3f4f6;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: relative;
        color: #374151;
    }

    .notif-btn .badge-dot {
        width: 8px;
        height: 8px;
        background: #ef4444;
        border-radius: 50%;
        position: absolute;
        top: 7px;
        right: 8px;
        border: 1.5px solid #fff;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: #d1fae5;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: #059669;
        font-size: 14px;
    }

    .user-meta {
        line-height: 1.3;
    }

    .user-name {
        font-size: 13px;
        font-weight: 700;
        color: #111;
    }

    .user-role {
        font-size: 11px;
        color: #9ca3af;
        font-weight: 500;
        letter-spacing: .3px;
    }

    /* ─────────────────────────────────────────
           CONTENT AREA
        ───────────────────────────────────────── */
    .admin-content {
        padding: 30px;
        flex: 1;
    }

    /* ─────────────────────────────────────────
           SHARED COMPONENTS
        ───────────────────────────────────────── */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 26px;
    }

    .page-header h1 {
        font-size: 22px;
        font-weight: 800;
        color: #111;
    }

    .page-header p {
        font-size: 13px;
        color: #6b7280;
        margin-top: 4px;
    }

    .date-badge {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 8px 14px;
        font-size: 13px;
        color: #374151;
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }

    .date-badge i {
        color: #2d6cdf;
    }

    .stat-cards {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 18px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #fff;
        border-radius: 18px;
        padding: 22px 24px;
        box-shadow: 0 1px 8px rgba(0, 0, 0, .05);
        transition: transform .2s, box-shadow .2s;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, .09);
    }

    .stat-card-top {
        margin-bottom: 16px;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 13px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 21px;
    }

    .stat-icon.blue {
        background: #dbeafe;
        color: #2563eb;
    }

    .stat-icon.green {
        background: #d1fae5;
        color: #059669;
    }

    .stat-icon.orange {
        background: #ffedd5;
        color: #ea580c;
    }

    .stat-icon.purple {
        background: #ede9fe;
        color: #7c3aed;
    }

    .stat-icon.red {
        background: #fee2e2;
        color: #dc2626;
    }

    .stat-icon.teal {
        background: #ccfbf1;
        color: #0d9488;
    }

    .stat-icon.yellow {
        background: #fef9c3;
        color: #ca8a04;
    }

    .stat-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .6px;
        color: #9ca3af;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .stat-value {
        font-size: 30px;
        font-weight: 800;
        color: #111;
        line-height: 1;
    }

    .stat-sub {
        font-size: 11.5px;
        color: #9ca3af;
        margin-top: 5px;
    }

    .dash-card {
        background: #fff;
        border-radius: 18px;
        padding: 24px;
        box-shadow: 0 1px 8px rgba(0, 0, 0, .05);
    }

    .card-title {
        font-size: 15px;
        font-weight: 700;
        color: #111;
        margin-bottom: 2px;
    }

    .card-sub {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .6px;
        color: #9ca3af;
        text-transform: uppercase;
        margin-bottom: 18px;
    }

    .bottom-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    .right-col {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    /* Progress bar kelas */
    .kelas-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .kelas-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .kelas-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }

    .kelas-icon.blue {
        background: #dbeafe;
        color: #2563eb;
    }

    .kelas-icon.green {
        background: #d1fae5;
        color: #059669;
    }

    .kelas-icon.orange {
        background: #ffedd5;
        color: #ea580c;
    }

    .kelas-icon.purple {
        background: #ede9fe;
        color: #7c3aed;
    }

    .kelas-info {
        flex: 1;
        min-width: 0;
    }

    .kelas-nama {
        font-size: 13px;
        font-weight: 700;
        color: #111;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .kelas-pengajar {
        font-size: 11.5px;
        color: #9ca3af;
        margin-top: 1px;
    }

    .kelas-progress-wrap {
        margin-top: 6px;
    }

    .kelas-progress-bar {
        height: 5px;
        background: #f3f4f6;
        border-radius: 99px;
        overflow: hidden;
    }

    .kelas-progress-fill {
        height: 100%;
        border-radius: 99px;
        background: linear-gradient(to right, #2d6cdf, #59a6ff);
        transition: width .6s ease;
    }

    .kelas-progress-label {
        font-size: 11px;
        color: #9ca3af;
        margin-top: 4px;
        display: flex;
        justify-content: space-between;
    }

    /* Nilai rata chart */
    .dist-wrap {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-top: 4px;
    }

    .donut-wrap {
        width: 110px;
        height: 110px;
        flex-shrink: 0;
    }

    .dist-legend {
        flex: 1;
    }

    .dist-legend-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .dist-legend-item:last-child {
        margin-bottom: 0;
    }

    .dist-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .dist-legend-label {
        font-size: 12.5px;
        font-weight: 600;
        color: #374151;
        flex: 1;
    }

    .dist-legend-val {
        font-size: 13px;
        font-weight: 800;
        color: #111;
    }

    /* Hero welcome banner */
    .welcome-banner {
        background: linear-gradient(135deg, #1e40af 0%, #2d6cdf 50%, #0d8de3 100%);
        border-radius: 20px;
        padding: 28px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::before {
        content: '';
        position: absolute;
        right: -20px;
        top: -30px;
        width: 200px;
        height: 200px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .07);
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        right: 80px;
        bottom: -50px;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .05);
    }


    /* SESUDAH — ganti font-family sesuai keinginan */
    .welcome-text h2 {
        font-size: 20px;
        font-weight: 800;
        color: #fff;
        font-family: 'DM Sans', sans-serif;
    }

    .welcome-text p {
        font-size: 13px;
        color: rgba(255, 255, 255, .7);
        margin-top: 5px;
    }

    .welcome-text p strong {
        font-family: 'DM Sans', sans-serif;
        font-weight: 800;
        color: #fff;
        letter-spacing: -0.3px;
    }

    .welcome-emoji {
        font-size: 48px;
        position: relative;
        z-index: 1;
    }

    /* Leaderboard posisi siswa */
    .rank-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, .15);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        padding: 5px 12px;
        border-radius: 20px;
        margin-top: 10px;
        border: 1px solid rgba(255, 255, 255, .2);
    }

    /* Materi terbaru */
    .materi-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f3f4f6;
    }

    .materi-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .materi-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: #fef3c7;
        color: #d97706;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        flex-shrink: 0;
    }

    .materi-info {
        flex: 1;
        min-width: 0;
    }

    .materi-judul {
        font-size: 13px;
        font-weight: 700;
        color: #111;
    }

    .materi-modul {
        font-size: 12px;
        color: #6b7280;
        margin-top: 1px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .btn-lihat {
        font-size: 11.5px;
        font-weight: 700;
        color: #2d6cdf;
        background: #eff6ff;
        border: none;
        padding: 4px 10px;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        flex-shrink: 0;
        transition: background .15s;
    }

    .btn-lihat:hover {
        background: #dbeafe;
    }

    /* ─────────────────────────────────────────
           LOGOUT OVERLAY
        ───────────────────────────────────────── */
    @keyframes lo-fadein {
        from {
            opacity: 0
        }

        to {
            opacity: 1
        }
    }

    @keyframes lo-slidein {
        from {
            opacity: 0;
            transform: translateY(22px) scale(.97)
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1)
        }
    }

    @keyframes lo-ring {

        0%,
        100% {
            transform: rotate(-12deg)
        }

        25% {
            transform: rotate(12deg)
        }

        50% {
            transform: rotate(-8deg)
        }

        75% {
            transform: rotate(8deg)
        }
    }

    @keyframes lo-pulse {

        0%,
        100% {
            box-shadow: 0 0 0 0 rgba(239, 68, 68, .35)
        }

        50% {
            box-shadow: 0 0 0 14px rgba(239, 68, 68, 0)
        }
    }

    #logout-overlay {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 99999;
        background: rgba(7, 16, 40, .88);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        align-items: center;
        justify-content: center;
        animation: lo-fadein .25s ease both;
    }

    #logout-overlay.show {
        display: flex;
    }

    .logout-overlay-card {
        background: linear-gradient(160deg, #0f1f4e 0%, #0a1530 100%);
        border: 1px solid rgba(255, 255, 255, .08);
        border-radius: 24px;
        padding: 40px 44px 36px;
        text-align: center;
        box-shadow: 0 32px 80px rgba(0, 0, 0, .55), 0 0 0 1px rgba(3, 170, 222, .15);
        max-width: 360px;
        width: 90%;
        animation: lo-slidein .3s cubic-bezier(.22, 1, .36, 1) both;
    }

    .logout-overlay-icon-wrap {
        width: 68px;
        height: 68px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        animation: lo-pulse 1.4s ease-in-out infinite;
    }

    .logout-overlay-icon-wrap i {
        font-size: 28px;
        color: #fff;
        animation: lo-ring 1.6s ease-in-out infinite;
    }

    .logout-overlay-title {
        font-size: 18px;
        font-weight: 800;
        color: #fff;
        letter-spacing: -.3px;
        margin-bottom: 8px;
    }

    .logout-overlay-desc {
        font-size: 13.5px;
        color: rgba(255, 255, 255, .55);
        line-height: 1.65;
    }

    .logout-progress-wrap {
        margin-top: 28px;
        height: 3px;
        background: rgba(255, 255, 255, .1);
        border-radius: 99px;
        overflow: hidden;
    }

    #logout-progress {
        height: 100%;
        width: 0%;
        background: linear-gradient(to right, #ef4444, #f97316);
        border-radius: 99px;
        transition: width 1.8s linear;
    }

    /* ─────────────────────────────────────────
           RESPONSIVE
        ───────────────────────────────────────── */
    @media (max-width: 1200px) {
        .stat-cards {
            grid-template-columns: repeat(2, 1fr);
        }

        .bottom-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .sidebar {
            display: none;
        }

        .stat-cards {
            grid-template-columns: repeat(2, 1fr);
        }

        .search-wrap {
            width: 100%;
        }

        .admin-content {
            padding: 20px;
        }

        .welcome-banner {
            flex-direction: column;
            gap: 16px;
        }
    }

    .has-sub>a {
        cursor: pointer;
    }

    .has-sub.open>a {
        color: #2d6cdf;
        background: #f1f5ff;
    }

    .has-sub.open .sub-arrow {
        transform: rotate(180deg);
    }

    .sub-nav {
        list-style: none;
        padding: 0;
        max-height: 0;
        overflow: hidden;
        transition: max-height .25s ease;
    }

    .has-sub.open .sub-nav {
        max-height: 200px;
    }

    .sub-nav li a {
        display: block;
        padding: 8px 14px 8px 42px;
        font-size: 13px;
        font-weight: 500;
        color: #6b7280;
        text-decoration: none;
        border-radius: 8px;
        transition: background .12s, color .12s;
    }

    .sub-nav li a:hover {
        background: #f1f5ff;
        color: #2d6cdf;
    }

    .sub-nav li.sub-active a {
        color: #2d6cdf;
        font-weight: 700;
        background: #eff6ff;
    }
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

            <?php
// Ganti bagian sidebar nav Kelas Saya di layout_peserta.php
// dengan kode berikut:
?>

            <!-- SIDEBAR NAV - ganti seluruh <ul class="sidebar-nav"> dengan ini -->
            <ul class="sidebar-nav">

                <li <?= uri_string() === 'dashboard/peserta/beranda' ? 'class="active"' : '' ?>>
                    <a href="<?= base_url('dashboard/peserta/beranda') ?>">
                        <i class="bi bi-house-fill"></i> Beranda
                        <?php if (uri_string() === 'dashboard/peserta/beranda'): ?>
                        <span class="dot"></span>
                        <?php endif; ?>
                    </a>
                </li>

                <!-- KELAS SAYA dengan submenu -->
                <?php $isKelas = str_starts_with(uri_string(), 'dashboard/peserta/kelas')
                  || str_starts_with(uri_string(), 'dashboard/peserta/modul')
                  || str_starts_with(uri_string(), 'dashboard/peserta/materi'); ?>
                <li class="has-sub <?= $isKelas ? 'open' : '' ?>">
                    <a href="#" onclick="toggleSub(this); return false;">
                        <i class="bi bi-book-fill"></i> Kelas Saya
                        <i class="bi bi-chevron-down sub-arrow"
                            style="margin-left:auto;font-size:11px;transition:transform .2s;"></i>
                    </a>

                    <ul class="sub-nav">
                        <!-- Daftar Kelas -->
                        <li <?= uri_string() === 'dashboard/peserta/kelas' ? 'class="sub-active"' : '' ?>>
                            <a href="<?= base_url('dashboard/peserta/kelas') ?>">
                                <i class="bi bi-collection-fill me-2"></i>
                                Daftar Kelas
                            </a>
                        </li>

                        <!-- Modul -->
                        <li <?= str_starts_with(uri_string(), 'dashboard/peserta/modul') ? 'class="sub-active"' : '' ?>>
                            <a href="<?= base_url('dashboard/peserta/modul') ?>">
                                <i class="bi bi-journal-text me-2"></i>
                                Modul
                            </a>
                        </li>

                        <!-- Materi -->
                        <li
                            <?= str_starts_with(uri_string(), 'dashboard/peserta/materi') ? 'class="sub-active"' : '' ?>>
                            <a href="<?= base_url('dashboard/peserta/materi-list') ?>">
                                <i class="bi bi-file-earmark-text-fill me-2"></i>
                                Materi
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>

            <div class="menu-label" style="margin-top:12px;">Akun</div>
            <ul class="sidebar-nav">
                <li <?= uri_string() === 'dashboard/peserta/profil' ? 'class="active"' : '' ?>>
                    <a href="<?= base_url('dashboard/peserta/profil') ?>">
                        <i class="bi bi-person-circle"></i> Profil Saya
                        <?php if (uri_string() === 'dashboard/peserta/profil'): ?>
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
                    <input type="text" placeholder="Cari materi, modul,...">
                </div>
                <div class="topbar-right">
                    <div class="notif-btn">
                        <i class="bi bi-bell-fill"></i>
                        <span class="badge-dot"></span>
                    </div>
                    <div class="user-info">
                        <div class="avatar">
                            <?= strtoupper(substr(session()->get('nama') ?? 'S', 0, 1)) ?>
                        </div>
                        <div class="user-meta">
                            <div class="user-name"><?= esc(session()->get('nama') ?? 'Siswa') ?></div>
                            <div class="user-role">Peserta Didik</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CONTENT -->
            <div class="admin-content">
                <?= $this->renderSection('content'); ?>
            </div>

        </div><!-- /main -->
    </div><!-- /wrapper -->

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Script toggle submenu — taruh sebelum </body> -->
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
            } catch (_) {}
            window.location.replace('<?= base_url("/login") ?>');
        }, 2000);
    }

    monitor = new RealtimeMonitor({
        baseUrl: "<?= base_url() ?>",
        user: "<?= esc(session()->get('email')) ?>",
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

    <?= $this->renderSection('scripts'); ?>
</body>

</html>
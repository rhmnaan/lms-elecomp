<?php // app/Views/dashboard/Pengajar/beranda.php ?>
<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>

<?= $this->section('meta') ?>
<title>Dashboard Pengajar — LMS Elecomp</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h1>Dashboard Pengajar</h1>
        <p>Selamat datang kembali! Berikut ringkasan aktivitas LMS hari ini.</p>
    </div>
   <div class="date-badge" style="color:#111;border-color:#dbeafe;background:#eff6ff;">
    <i class="bi bi-calendar3" style="color:#2563eb;"></i>
    <span id="today-date"></span>
</div>
</div>

<!-- STAT CARDS -->
<div class="stat-cards">
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon blue"><i class="bi bi-person-fill"></i></div>
        </div>
        <div class="stat-label">Total Peserta</div>
        <div class="stat-value"><?= esc($total_peserta) ?></div>
        <div class="stat-sub">Terdaftar di sistem</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon orange"><i class="bi bi-book-fill"></i></div>
        </div>
        <div class="stat-label">Total Kelas</div>
        <div class="stat-value"><?= esc($total_kelas) ?></div>
        <div class="stat-sub"><?= esc($total_modul) ?> modul tersedia</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon green"><i class="bi bi-file-earmark-text-fill"></i></div>
        </div>
        <div class="stat-label">Total Materi</div>
        <div class="stat-value"><?= esc($total_materi) ?></div>
        <div class="stat-sub">Materi diunggah</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon purple"><i class="bi bi-grid-fill"></i></div>
        </div>
        <div class="stat-label">Total Modul</div>
        <div class="stat-value"><?= esc($total_modul) ?></div>
        <div class="stat-sub">Di semua kelas</div>
    </div>
</div>

<!-- BOTTOM GRID -->
<div class="bottom-grid">

    <!-- KELAS TERBARU -->
    <div class="dash-card">
        <div class="card-header-row">
            <div>
                <div class="card-title">Kelas Saya</div>
                <div class="card-sub">Daftar kelas yang Anda kelola</div>
            </div>
            <a href="<?= base_url('dashboard/pengajar/kelas') ?>" class="btn-outline-pengajar" style="font-size:12px;padding:7px 13px;
                color:#2563eb;border-color:#2563eb;">
                Lihat Semua <i class="bi bi-arrow-right"></i>
            </a>
        </div>

        <?php if (empty($kelas_list)): ?>
            <div class="empty-state">
                <i class="bi bi-book"></i>
                <p>Belum ada kelas yang dibuat.</p>
            </div>
        <?php else: ?>
            <?php foreach ($kelas_list as $kelas): ?>
                <div class="act-item">
                    <div class="act-icon" style="background:#eff6ff;color:#2563eb;">
                        <i class="bi bi-journal-bookmark-fill"></i>
                    </div>
                    <div class="act-info">
                        <div class="act-name"><?= esc($kelas['nama_kelas']) ?></div>
                        <div class="act-sub">
                            <?= esc($kelas['jumlah_modul'] ?? 0) ?> modul &middot;
                            <?= esc($kelas['jumlah_peserta'] ?? 0) ?> peserta
                        </div>
                    </div>
                    <a href="<?= base_url('dashboard/pengajar/kelas') ?>"
   class="act-badge" style="background:#eff6ff;color:#2563eb;text-decoration:none;">
    Lihat
</a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- KOLOM KANAN -->
    <div class="right-col">

        <!-- PESERTA TERBARU -->
        <div class="dash-card">
            <div class="card-header-row">
                <div>
                    <div class="card-title">Peserta Terdaftar</div>
                    <div class="card-sub">Pendaftaran terbaru</div>
                </div>
                <a href="<?= base_url('dashboard/pengajar/peserta') ?>" class="btn-outline-pengajar" style="font-size:12px;padding:7px 13px;
                    color:#2563eb;border-color:#2563eb;">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <?php if (empty($peserta_terbaru)): ?>
                <div class="empty-state">
                    <i class="bi bi-people"></i>
                    <p>Belum ada peserta terdaftar.</p>
                </div>
            <?php else: ?>
                <?php foreach ($peserta_terbaru as $peserta): ?>
                    <div class="act-item">
                        <div class="act-icon" style="background:#f0fdf4;color:#059669;font-weight:700;font-size:14px;">
                            <?= strtoupper(substr($peserta['nama_users'], 0, 1)) ?>
                        </div>
                        <div class="act-info">
                            <div class="act-name"><?= esc($peserta['nama_users']) ?></div>
                            <div class="act-sub"><?= esc($peserta['nama_kelas'] ?? '-') ?></div>
                            <div class="act-time">
                                <i class="bi bi-clock" style="font-size:10px;"></i>
                                <?= date('d M Y', strtotime($peserta['created_at'])) ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- RINGKASAN MATERI PER KELAS -->
        <div class="dash-card">
            <div class="card-title">Materi per Kelas</div>
            <div class="card-sub">Jumlah materi yang diunggah</div>

            <?php if (empty($materi_per_kelas)): ?>
                <div class="empty-state">
                    <i class="bi bi-file-earmark"></i>
                    <p>Belum ada data materi.</p>
                </div>
            <?php else: ?>
                <?php
                $max = max(array_column($materi_per_kelas, 'jumlah_materi'));
                $max = $max ?: 1;
                foreach ($materi_per_kelas as $item):
                    $pct = round(($item['jumlah_materi'] / $max) * 100);
                    ?>
                    <div class="prog-row">
                        <div class="prog-label"><?= esc($item['nama_kelas']) ?></div>
                        <div class="prog-bar-wrap">
                            <div class="prog-bar-fill" style="width:<?= $pct ?>%;background:#2563eb;"></div>
                        </div>
                        <div class="prog-pct" style="color:#2563eb;"><?= esc($item['jumlah_materi']) ?></div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div><!-- /right-col -->
</div><!-- /bottom-grid -->

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
    const now = new Date();
    document.getElementById('today-date').textContent =
        `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;
</script>
<?= $this->endSection() ?>
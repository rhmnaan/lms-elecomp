<?php // app/Views/Dashboard/Peserta/kelas.php ?>
<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('meta') ?>
<title>Kelas Saya — LMS Elecomp</title>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .kelas-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }
    .kelas-card {
        background: #fff; border-radius: 18px; overflow: hidden;
        box-shadow: 0 1px 8px rgba(0,0,0,.06);
        transition: transform .2s, box-shadow .2s;
    }
    .kelas-card:hover { transform: translateY(-4px); box-shadow: 0 10px 30px rgba(0,0,0,.11); }

    .kc-banner {
        padding: 22px 22px 18px; position: relative; overflow: hidden;
        min-height: 120px; display: flex; flex-direction: column; justify-content: flex-end;
    }
    .kc-banner::before {
        content: ''; position: absolute; right: -20px; top: -20px;
        width: 110px; height: 110px; border-radius: 50%;
        background: rgba(255,255,255,.10);
    }
    .kc-banner::after {
        content: ''; position: absolute; right: 55px; bottom: -30px;
        width: 70px; height: 70px; border-radius: 50%;
        background: rgba(255,255,255,.06);
    }
    .banner-blue   { background: linear-gradient(135deg,#1e40af,#3b82f6); }
    .banner-green  { background: linear-gradient(135deg,#065f46,#10b981); }
    .banner-orange { background: linear-gradient(135deg,#92400e,#f59e0b); }
    .banner-purple { background: linear-gradient(135deg,#4c1d95,#8b5cf6); }

    .kc-icon {
        width: 42px; height: 42px; border-radius: 12px;
        background: rgba(255,255,255,.2);
        display: flex; align-items: center; justify-content: center;
        font-size: 20px; color: #fff; margin-bottom: 10px;
        position: relative; z-index: 1;
    }
    .kc-nama {
        font-size: 15px; font-weight: 800; color: #fff;
        font-family: 'DM Sans', sans-serif;
        position: relative; z-index: 1; line-height: 1.3;
    }
    .kc-pengajar { font-size: 11.5px; color: rgba(255,255,255,.75); margin-top: 3px; position: relative; z-index: 1; }

    .kc-body { padding: 16px 20px 0; }
    .kc-progress-head {
        display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;
    }
    .kc-progress-lbl { font-size: 12px; color: #6b7280; font-weight: 500; }
    .kc-progress-pct { font-size: 13px; font-weight: 800; color: #2d6cdf; }
    .kc-bar { height: 5px; background: #f3f4f6; border-radius: 99px; overflow: hidden; margin-bottom: 14px; }
    .kc-bar-fill {
        height: 100%; border-radius: 99px;
        background: linear-gradient(to right, #2d6cdf, #60a5fa); transition: width .7s ease;
    }

    .kc-footer {
        display: flex; align-items: center; justify-content: space-between;
        padding: 12px 20px; border-top: 1px solid #f3f4f6;
    }
    .kc-meta { display: flex; align-items: center; gap: 14px; }
    .kc-meta-item {
        display: flex; align-items: center; gap: 5px;
        font-size: 12px; color: #6b7280; font-weight: 500;
    }
    .kc-meta-item i { font-size: 12px; color: #9ca3af; }

    .btn-lanjut {
        display: inline-flex; align-items: center; gap: 5px;
        font-size: 12px; font-weight: 700; padding: 6px 14px;
        border-radius: 10px; text-decoration: none; transition: all .15s;
    }
    .btn-lanjut-blue   { background:#eff6ff; color:#2d6cdf; }
    .btn-lanjut-blue:hover   { background:#2d6cdf; color:#fff; }
    .btn-lanjut-green  { background:#f0fdf4; color:#059669; }
    .btn-lanjut-green:hover  { background:#059669; color:#fff; }
    .btn-lanjut-orange { background:#fff7ed; color:#d97706; }
    .btn-lanjut-orange:hover { background:#d97706; color:#fff; }
    .btn-lanjut-purple { background:#f5f3ff; color:#7c3aed; }
    .btn-lanjut-purple:hover { background:#7c3aed; color:#fff; }

    .empty-state {
        text-align: center; padding: 70px 20px; background: #fff;
        border-radius: 20px; box-shadow: 0 1px 8px rgba(0,0,0,.05);
    }
    .empty-icon { font-size: 48px; margin-bottom: 14px; color: #d1d5db; }
    .empty-title { font-size: 16px; font-weight: 800; color: #374151; margin-bottom: 5px; }
    .empty-desc  { font-size: 13px; color: #9ca3af; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1>Kelas Saya</h1>
        <p>Kelas yang kamu ikuti semester ini.</p>
    </div>
    <div class="date-badge">
        <i class="bi bi-book-fill"></i>
        <span><?= $total_kelas ?> Kelas</span>
    </div>
</div>

<?php if (empty($kelas_list)): ?>
    <div class="empty-state">
        <div class="empty-icon"><i class="bi bi-journal-x"></i></div>
        <div class="empty-title">Belum Terdaftar di Kelas Manapun</div>
        <div class="empty-desc">Hubungi pengajar atau admin untuk mendaftarkan kamu.</div>
    </div>
<?php else: ?>

    <?php
    $banners = ['banner-blue','banner-green','banner-orange','banner-purple'];
    $icons   = ['bi-lightning-charge-fill','bi-cpu-fill','bi-tools','bi-diagram-3-fill'];
    $btnCls  = ['btn-lanjut-blue','btn-lanjut-green','btn-lanjut-orange','btn-lanjut-purple'];
    ?>

    <div class="kelas-grid">
        <?php foreach ($kelas_list as $i => $k):
            $ci  = $i % 4;
            $lbl = $k['persen'] >= 100 ? 'Selesai' : ($k['persen'] > 0 ? 'Lanjut' : 'Mulai');
        ?>
        <div class="kelas-card">
            <div class="kc-banner <?= $banners[$ci] ?>">
                <div class="kc-icon"><i class="bi <?= $icons[$ci] ?>"></i></div>
                <div class="kc-nama"><?= esc($k['nama_kelas']) ?></div>
                <div class="kc-pengajar"><?= esc($k['nama_pengajar'] ?? 'Pengajar') ?></div>
            </div>
            <div class="kc-body">
                <div class="kc-progress-head">
                    <span class="kc-progress-lbl">Progress</span>
                    <span class="kc-progress-pct"><?= $k['persen'] ?>%</span>
                </div>
                <div class="kc-bar">
                    <div class="kc-bar-fill" style="width:<?= $k['persen'] ?>%"></div>
                </div>
            </div>
            <div class="kc-footer">
                <div class="kc-meta">
                    <div class="kc-meta-item">
                        <i class="bi bi-journal-text"></i> <?= $k['total_modul'] ?> Modul
                    </div>
                    <div class="kc-meta-item">
                        <i class="bi bi-clock"></i> <?= $k['total_materi'] ?> Materi
                    </div>
                </div>
                <a href="<?= base_url('dashboard/peserta/modul?kelas=' . $k['id_kelas']) ?>"
                   class="btn-lanjut <?= $btnCls[$ci] ?>">
                    <?= $lbl ?> <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>
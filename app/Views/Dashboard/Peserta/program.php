<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/program-peserta.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="program-header">
    <div>
        <h1>Program Saya</h1>
        <p>Lanjutkan progres belajarmu dan raih sertifikasimu.</p>
    </div>
</div>

<?php if (empty($program_list)): ?>
<div class="program-empty">
    <div class="empty-icon-wrapper">
        <i class="bi bi-mortarboard-fill"></i>
    </div>
    <h3>Belum Ada Program</h3>
    <p>Sepertinya kamu belum terdaftar di program manapun.</p>
    <a href="<?= base_url('programs') ?>" class="btn-browse">Cari Program</a>
</div>
<?php else: ?>
<div class="program-grid">
    <?php foreach ($program_list as $index => $p): ?>
    <a href="<?= base_url('dashboard/peserta/program/' . $p['id_program']) ?>" class="program-card"
        style="animation-delay: <?= $index * 0.1 ?>s">

        <div class="program-banner banner-<?= $index % 3 ?>">
            <div class="banner-pattern"></div>
            <div class="banner-overlay"></div>

            <span class="program-badge">
                <i class="bi bi-book-half"></i> <?= esc($p['total_kelas']) ?> Modul
            </span>

            <h3 class="program-title">
                <?= esc($p['nama_program']) ?>
            </h3>
        </div>

        <div class="program-footer">
            <div class="program-info">
                <span class="program-action">Masuk Kelas</span>
                <div class="action-circle">
                    <i class="bi bi-arrow-right-short"></i>
                </div>
            </div>
        </div>
    </a>
    <?php endforeach ?>
</div>
<?php endif ?>

<?= $this->endSection() ?>
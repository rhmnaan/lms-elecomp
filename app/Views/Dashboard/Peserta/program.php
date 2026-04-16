<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/program-peserta.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="program-header">
    <div>
        <h1>Program Saya</h1>
        <p>Kelola dan lanjutkan program pembelajaranmu</p>
    </div>
</div>

<?php if (empty($program_list)): ?>
<div class="program-empty">
    <i class="bi bi-mortarboard"></i>
    <h3>Belum Ada Program</h3>
    <p>Program yang kamu ikuti akan muncul di sini</p>
</div>
<?php else: ?>
<div class="program-grid">
    <?php foreach ($program_list as $index => $p): ?>
    <a href="<?= base_url('dashboard/peserta/program/' . $p['id_program']) ?>" class="program-card">

        <div class="program-banner banner-<?= $index % 3 ?>">
            <span class="program-badge">
                <?= esc($p['total_kelas']) ?> Kelas
            </span>

            <h3 class="program-title">
                <?= esc($p['nama_program']) ?>
            </h3>
        </div>

        <div class="program-footer">
            <span class="program-action">
                Lihat Detail
                <i class="bi bi-arrow-right"></i>
            </span>
        </div>

    </a>
    <?php endforeach ?>
</div>
<?php endif ?>

<?= $this->endSection() ?>
<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/program-peserta.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$icons = [
    ['bi' => 'code-slash',    'cls' => 'ic-p'],
    ['bi' => 'palette2',      'cls' => 'ic-g'],
    ['bi' => 'cpu-fill',      'cls' => 'ic-a'],
    ['bi' => 'shield-lock',   'cls' => 'ic-p'],
    ['bi' => 'graph-up',      'cls' => 'ic-g'],
    ['bi' => 'phone',         'cls' => 'ic-a'],
    ['bi' => 'camera-video',  'cls' => 'ic-r'],
    ['bi' => 'brush',         'cls' => 'ic-p'],
];
$total = count($program_list);
?>

<div class="pg-wrap">

    <div class="pg-header">
        <div>
            <h1 class="pg-h1">Program<br><span class="acc">Belajar</span>mu</h1>
            <p class="pg-sub">Lanjutkan progres dan raih sertifikasimu.</p>
        </div>
        <?php if (!empty($program_list)): ?>
        <div class="pg-ctr">
            <div class="pg-ctr-num"><?= str_pad($total, 2, '0', STR_PAD_LEFT) ?></div>
            <div class="pg-ctr-lbl">Program aktif</div>
        </div>
        <?php endif ?>
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

            <div class="pg-card-top">
                <span class="pg-num"><?= $num ?></span>
                <div class="pg-icon <?= $ic['cls'] ?>">
                    <i class="bi bi-<?= $ic['bi'] ?>"></i>
                </div>
            </div>

            <h3 class="pg-title"><?= esc($p['nama_program']) ?></h3>
            <p class="pg-meta"><?= esc($p['deskripsi'] ?? 'Klik untuk mulai belajar') ?></p>

            <div class="pg-hr"></div>

            <div class="pg-card-bot">
                <span class="pg-pill">
                    <i class="bi bi-book-half"></i>
                    <?= esc($p['total_kelas']) ?> Modul
                </span>
                <div class="pg-arrow">
                    <i class="bi bi-arrow-up-right"></i>
                </div>
            </div>

        </a>
        <?php endforeach ?>
    </div>

    <?php endif ?>

</div>

<?= $this->endSection() ?>
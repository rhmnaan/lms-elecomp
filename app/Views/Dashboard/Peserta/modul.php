<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('meta') ?>
<title>Modul — LMS Elecomp</title>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
.modul-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}

.mc {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 10px rgba(0,0,0,.06);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    min-height: 260px;
    transition: transform .2s, box-shadow .2s;
}

.mc:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0,0,0,.10);
}

.mc-hdr {
    padding: 20px 20px 18px;
}

.mc-hdr-blue   { background: linear-gradient(135deg, #1e40af, #3b82f6); }
.mc-hdr-green  { background: linear-gradient(135deg, #065f46, #10b981); }
.mc-hdr-orange { background: linear-gradient(135deg, #92400e, #f59e0b); }
.mc-hdr-purple { background: linear-gradient(135deg, #4c1d95, #8b5cf6); }

.mc-num {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .08em;
    color: rgba(255,255,255,.75);
    margin-bottom: 6px;
}

.mc-title {
    font-size: 15px;
    font-weight: 800;
    color: #fff;
    line-height: 1.35;
}

.mc-body {
    padding: 20px 20px 16px;
    flex: 1 1 auto;
}

.mc-progress-row {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    margin-bottom: 10px;
}

.mc-progress-row span:last-child {
    font-weight: 700;
    color: #2d6cdf;
}

.mc-bar {
    height: 8px;
    background: #f3f4f6;
    border-radius: 99px;
    overflow: hidden;
}

.mc-bar-fill {
    height: 100%;
    background: linear-gradient(to right, #2d6cdf, #60a5fa);
    border-radius: 99px;
}

.mc-footer {
    padding: 16px 20px;
    border-top: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    min-height: 66px;
    flex-shrink: 0;
}

.mc-badge {
    font-size: 11px;
    font-weight: 700;
    padding: 8px 14px;
    border-radius: 9999px;
    white-space: nowrap;
    min-width: 118px;
    text-align: center;
    flex-shrink: 0;
}

.mc-badge.selesai  { background: #d1fae5; color: #059669; }
.mc-badge.progress { background: #eff6ff; color: #2d6cdf; }
.mc-badge.belum    { background: #f3f4f6; color: #9ca3af; }

.btn-lihat-materi {
    font-size: 11px;
    font-weight: 700;
    color: #2d6cdf;
    background: #eff6ff;
    padding: 8px 14px;
    border-radius: 8px;
    white-space: nowrap;
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
}

.btn-lihat-materi:hover {
    background: #dbeafe;
    color: #1e40af;
}

.kelas-section {
    margin-bottom: 40px;
}

.kelas-section-title {
    font-size: 15px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.kelas-section-title::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e5e7eb;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 1px 8px rgba(0,0,0,.05);
}

/* ── TOMBOL KEMBALI ── */
.back-wrapper {
    margin-bottom: 28px;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 0;
    text-decoration: none;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 2px 12px rgba(29,78,216,.2);
    transition: transform .2s, box-shadow .2s;
}

.btn-back:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(29,78,216,.3);
}

.btn-back-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    background: #1d4ed8;
    color: #fff;
    font-size: 16px;
    flex-shrink: 0;
    transition: background .2s;
}

.btn-back:hover .btn-back-icon {
    background: #1e3a8a;
}

.btn-back-text {
    padding: 0 18px;
    height: 42px;
    display: flex;
    align-items: center;
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: .01em;
    border: 1.5px solid #bfdbfe;
    border-left: none;
    border-radius: 0 12px 12px 0;
    transition: background .2s, color .2s;
}

.btn-back:hover .btn-back-text {
    background: #dbeafe;
    color: #1e3a8a;
}
/* ── FILE TYPE BADGES ── */
.mc-file-badges {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
    margin-top: 10px;
    padding-top: 10px;
    border-top: 1px solid #f3f4f6;
}

.mc-file-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 8px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
    white-space: nowrap;
}

.mc-file-badge.pdf   { background: #fff1f2; color: #e11d48; }
.mc-file-badge.word  { background: #eff6ff; color: #2563eb; }
.mc-file-badge.excel { background: #f0fdf4; color: #059669; }
.mc-file-badge.ppt   { background: #fff7ed; color: #ea580c; }
.mc-file-badge.video { background: #fefce8; color: #ca8a04; }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$mcHdrs     = ['mc-hdr-blue', 'mc-hdr-green', 'mc-hdr-orange', 'mc-hdr-purple'];
$focusKelas = $focus_kelas ?? null;

if ($focusKelas) {
    $tampilList = array_values(array_filter($kelas_list, fn($k) => $k['id_kelas'] == $focusKelas));
} else {
    $tampilList = array_values($kelas_list);
}

$totalModulTampil = 0;
foreach ($tampilList as $k) {
    $totalModulTampil += count($k['modul_list'] ?? []);
}

$namaKelasAktif = '';
if ($focusKelas && !empty($tampilList)) {
    $namaKelasAktif = $tampilList[0]['nama_kelas'];
}
?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h1><i class="bi bi-grid-3x3-gap-fill"></i> Modul</h1>
        <p>
            <?php if ($focusKelas && $namaKelasAktif): ?>
                Modul dalam kelas <strong><?= esc($namaKelasAktif) ?></strong>
            <?php else: ?>
                Modul pembelajaran dari kelas yang Anda ikuti
            <?php endif; ?>
        </p>
    </div>
    <div class="date-badge">
        <i class="bi bi-journal-bookmark-fill"></i>
        <span><?= $totalModulTampil ?> Modul</span>
    </div>
</div>

<!-- TOMBOL KEMBALI -->
<div class="back-wrapper">
    <a href="<?= base_url('dashboard/peserta/kelas') ?>" class="btn-back">
        <span class="btn-back-icon"><i class="bi bi-arrow-left"></i></span>
        <span class="btn-back-text">Kembali ke Daftar Kelas</span>
    </a>
</div>

<?php if (empty($tampilList) || $totalModulTampil == 0): ?>

<div class="empty-state">
    <i class="bi bi-journal-x" style="font-size:48px;color:#d1d5db;display:block;margin-bottom:14px;"></i>
    <p style="font-size:16px;font-weight:700;color:#374151;margin:0 0 4px;">Belum ada modul</p>
    <small style="color:#9ca3af;">Modul belum tersedia saat ini.</small>
</div>

<?php else: ?>

<?php foreach ($tampilList as $k):
    if (empty($k['modul_list'])) continue;
?>
<div class="kelas-section">
    <?php if (!$focusKelas): ?>
    <div class="kelas-section-title">
        <i class="bi bi-collection-fill" style="color:#2d6cdf;"></i>
        <?= esc($k['nama_kelas']) ?>
    </div>
    <?php endif; ?>

    <div class="modul-grid">
        <?php foreach ($k['modul_list'] as $mi => $m):
            $ci       = $mi % 4;
            $badgeCls = $m['persen'] >= 100 ? 'selesai' : ($m['persen'] > 0 ? 'progress' : 'belum');
            $badgeTxt = $m['persen'] >= 100 ? '✓ Selesai' : ($m['persen'] > 0 ? 'Berlangsung' : 'Belum Dimulai');
        ?>
        <div class="mc">
            <div class="mc-hdr <?= $mcHdrs[$ci] ?>">
                <div class="mc-num">MODUL <?= $m['urutan_modul'] ?? ($mi + 1) ?></div>
                <div class="mc-title"><?= esc($m['judul_modul']) ?></div>
            </div>
            <div class="mc-body">
    <div class="mc-progress-row">
        <span><?= $m['total_materi'] ?> materi</span>
        <span><?= $m['persen'] ?>%</span>
    </div>
    <div class="mc-bar">
        <div class="mc-bar-fill" style="width:<?= $m['persen'] ?>%"></div>
    </div>

    <?php
        $fc = $m['file_count'] ?? [];
        $adaBadge = !empty(array_filter($fc));
    ?>
    <?php if ($adaBadge): ?>
    <div class="mc-file-badges">
        <?php if (!empty($fc['pdf'])): ?>
            <span class="mc-file-badge pdf">
                <i class="bi bi-file-earmark-pdf-fill"></i> PDF <?= $fc['pdf'] ?>
            </span>
        <?php endif; ?>
        <?php if (!empty($fc['word'])): ?>
            <span class="mc-file-badge word">
                <i class="bi bi-file-earmark-word-fill"></i> Word <?= $fc['word'] ?>
            </span>
        <?php endif; ?>
        <?php if (!empty($fc['excel'])): ?>
            <span class="mc-file-badge excel">
                <i class="bi bi-file-earmark-excel-fill"></i> Excel <?= $fc['excel'] ?>
            </span>
        <?php endif; ?>
        <?php if (!empty($fc['ppt'])): ?>
            <span class="mc-file-badge ppt">
                <i class="bi bi-file-earmark-ppt-fill"></i> PPT <?= $fc['ppt'] ?>
            </span>
        <?php endif; ?>
        <?php if (!empty($fc['video'])): ?>
            <span class="mc-file-badge video">
                <i class="bi bi-play-circle-fill"></i> Video <?= $fc['video'] ?>
            </span>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>
            <div class="mc-footer">
                <span class="mc-badge <?= $badgeCls ?>"><?= $badgeTxt ?></span>
                <a href="<?= base_url('dashboard/peserta/materi-modul/' . $m['id_modul']) ?>" class="btn-lihat-materi">
                    Lihat Materi <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        <?php endforeach ?>
    </div>
</div>
<?php endforeach ?>

<?php endif ?>

<?= $this->endSection() ?>
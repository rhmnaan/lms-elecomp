<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('meta') ?>
<title>Modul — LMS Elecomp</title>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
.kelas-section {
    margin-bottom: 40px;
}

.kelas-section-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 16px;
}

.kelas-section-icon {
    width: 34px;
    height: 34px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.kelas-section-icon.blue {
    background: #dbeafe;
    color: #2563eb;
}

.kelas-section-icon.green {
    background: #d1fae5;
    color: #059669;
}

.kelas-section-icon.orange {
    background: #ffedd5;
    color: #ea580c;
}

.kelas-section-nama {
    font-size: 15px;
    font-weight: 800;
    color: #111;
}

.kelas-section-count {
    font-size: 12px;
    font-weight: 600;
    color: #9ca3af;
    background: #f3f4f6;
    border-radius: 20px;
    padding: 2px 10px;
}

.modul-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
}

/* ==================== CARD FIX TENGGELAM ==================== */
.mc {
    background: #fff;
    border-radius: 16px;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
    /* Penting */
    min-height: 260px;
    /* Tinggi minimum agar tidak terlalu pendek */
    transition: transform .2s, box-shadow .2s;
}

.mc:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.10);
}

.mc-hdr {
    padding: 20px 20px 18px;
}

.mc-hdr-blue {
    background: linear-gradient(135deg, #1e40af, #3b82f6);
}

.mc-hdr-green {
    background: linear-gradient(135deg, #065f46, #10b981);
}

.mc-hdr-orange {
    background: linear-gradient(135deg, #92400e, #f59e0b);
}

.mc-num {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .08em;
    color: rgba(255, 255, 255, .75);
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
    /* Body mengisi ruang tengah */
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
}

/* FOOTER - Badge & Tombol ukuran disamakan */
.mc-footer {
    padding: 16px 20px;
    border-top: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    min-height: 66px;
    /* Tinggi footer tetap */
    flex-shrink: 0;
}

.mc-badge {
    font-size: 11px;
    font-weight: 700;
    padding: 8px 14px;
    border-radius: 9999px;
    white-space: nowrap;
    text-align: center;
    min-width: 118px;
    flex-shrink: 0;
    box-sizing: border-box;
    line-height: 1;
}

.mc-badge.selesai {
    background: #d1fae5;
    color: #059669;
}

.mc-badge.progress {
    background: #eff6ff;
    color: #2d6cdf;
}

.mc-badge.belum {
    background: #f3f4f6;
    color: #9ca3af;
}

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
    line-height: 1;
}

.btn-lihat-materi:hover {
    background: #dbeafe;
    color: #1e40af;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 1px 8px rgba(0, 0, 0, .05);
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f3f4f6;
    padding: 8px 16px;
    border-radius: 10px;
    text-decoration: none;
    color: #374151;
    font-size: 13px;
    font-weight: 500;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$iconColors = ['blue', 'green', 'orange', 'purple'];
$mcHdrs     = ['mc-hdr-blue', 'mc-hdr-green', 'mc-hdr-orange', 'mc-hdr-blue'];
$icons      = ['bi-lightning-charge-fill', 'bi-cpu-fill', 'bi-tools', 'bi-diagram-3-fill'];

$focusKelas   = $focus_kelas ?? null;
$isSingleClass = !empty($focusKelas) && count($kelas_list ?? []) == 1;
$activeClass  = $isSingleClass ? ($kelas_list[0] ?? null) : null;
?>

<div class="page-header">
    <div>
        <?php if ($isSingleClass && $activeClass): ?>
        <h1><i class="bi bi-book-half"></i> <?= esc($activeClass['nama_kelas']) ?></h1>
        <p>Modul pembelajaran dari kelas <?= esc($activeClass['nama_kelas']) ?></p>
        <?php else: ?>
        <h1><i class="bi bi-grid-3x3-gap-fill"></i> Semua Modul</h1>
        <p>Modul dari seluruh kelas yang kamu ikuti</p>
        <?php endif; ?>
    </div>

    <div class="date-badge">
        <i class="bi bi-journal-bookmark-fill"></i>
        <span>
            <?php 
            $totalModul = 0;
            foreach ($kelas_list as $k) $totalModul += count($k['modul_list'] ?? []);
            echo $totalModul;
            ?> Modul
        </span>
    </div>
</div>

<?php if ($isSingleClass && $activeClass): ?>
<div style="margin-bottom: 24px;">
    <a href="<?= base_url('dashboard/peserta/kelas') ?>" class="btn-back">
        <i class="bi bi-arrow-left"></i> Kembali ke Daftar Kelas
    </a>
</div>
<?php endif; ?>

<?php if (empty($kelas_list) || (count($kelas_list) == 1 && empty($kelas_list[0]['modul_list']))): ?>
<div class="empty-state">Belum ada modul tersedia saat ini.</div>
<?php else: ?>
<?php foreach ($kelas_list as $ki => $k):
        if (empty($k['modul_list'])) continue;
        $ci = $ki % 4;
    ?>
<div class="kelas-section" id="kelas-<?= $k['id_kelas'] ?>">
    <div class="kelas-section-header">
        <div class="kelas-section-icon <?= $iconColors[$ci] ?>">
            <i class="bi <?= $icons[$ci] ?>"></i>
        </div>
        <span class="kelas-section-nama"><?= esc($k['nama_kelas']) ?></span>
        <span class="kelas-section-count"><?= count($k['modul_list']) ?> modul</span>
    </div>

    <div class="modul-grid">
        <?php foreach ($k['modul_list'] as $mi => $m):
                    $colorIndex = $mi % 4;
                    $badgeCls = $m['persen'] >= 100 ? 'selesai' : ($m['persen'] > 0 ? 'progress' : 'belum');
                    $badgeTxt = $m['persen'] >= 100 ? '✓ Selesai' : ($m['persen'] > 0 ? 'Berlangsung' : 'Belum Dimulai');
                ?>
        <div class="mc">
            <div class="mc-hdr <?= $mcHdrs[$colorIndex] ?>">
                <div class="mc-num">MODUL <?= $m['urutan_modul'] ?? ($mi + 1) ?></div>
                <div class="mc-title"><?= esc($m['judul_modul']) ?></div>
            </div>
            <div class="mc-body">
                <div class="mc-progress-row">
                    <span><?= $m['total_materi'] ?> materi</span>
                    <span><?= $m['persen'] ?>%</span>
                </div>
                <div class="mc-bar">
                    <div class="mc-bar-fill" style="width: <?= $m['persen'] ?>%"></div>
                </div>
            </div>
            <div class="mc-footer">
                <span class="mc-badge <?= $badgeCls ?>"><?= $badgeTxt ?></span>
                <a href="<?= base_url('dashboard/peserta/materi-modul/' . $m['id_modul']) ?>" class="btn-lihat-materi">
                    Lihat Materi <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
const focusId = '<?= $focusKelas ?>';
if (focusId) {
    setTimeout(() => {
        const el = document.getElementById('kelas-' + focusId);
        if (el) el.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });
    }, 300);
}
</script>
<?= $this->endSection() ?>
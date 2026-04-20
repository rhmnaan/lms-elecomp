<?php // app/Views/Dashboard/Peserta/kelas-saya.php ?>
<?php echo $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?php echo $this->section('meta') ?>
<title>Kelas Saya — LMS Elecomp</title>
<?php echo $this->endSection() ?>

<?php echo $this->section('styles') ?>
<style>
/* ── FILTER TABS ── */
.filter-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 24px;
}

.filter-tab {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: 99px;
    border: 1.5px solid #e5e7eb;
    background: #fff;
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
    cursor: pointer;
    transition: all .15s;
    user-select: none;
}

.filter-tab:hover {
    border-color: #2d6cdf;
    color: #2d6cdf;
}

.filter-tab.active {
    background: #1d4ed8;
    border-color: #1d4ed8;
    color: #fff;
}

.filter-tab .tab-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 22px;
    height: 22px;
    padding: 0 6px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 700;
    background: rgba(255,255,255,.25);
    color: inherit;
}

.filter-tab:not(.active) .tab-count {
    background: #f3f4f6;
    color: #374151;
}

/* ── KELAS GRID ── */
.kelas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

.kelas-card {
    background: #fff;
    border-radius: 18px;
    overflow: hidden;
    box-shadow: 0 1px 8px rgba(0,0,0,.06);
    transition: transform .2s, box-shadow .2s;
}

.kelas-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 30px rgba(0,0,0,.11);
}

.kc-banner {
    padding: 22px 22px 18px;
    position: relative;
    overflow: hidden;
    min-height: 120px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
}

.kc-banner::before {
    content: '';
    position: absolute;
    right: -20px; top: -20px;
    width: 110px; height: 110px;
    border-radius: 50%;
    background: rgba(255,255,255,.10);
}

.kc-banner::after {
    content: '';
    position: absolute;
    right: 55px; bottom: -30px;
    width: 70px; height: 70px;
    border-radius: 50%;
    background: rgba(255,255,255,.06);
}

.banner-blue   { background: linear-gradient(135deg, #1e40af, #3b82f6); }
.banner-green  { background: linear-gradient(135deg, #065f46, #10b981); }
.banner-orange { background: linear-gradient(135deg, #92400e, #f59e0b); }
.banner-purple { background: linear-gradient(135deg, #4c1d95, #8b5cf6); }

.kc-icon {
    width: 42px; height: 42px;
    border-radius: 12px;
    background: rgba(255,255,255,.2);
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; color: #fff;
    margin-bottom: 10px;
    position: relative; z-index: 1;
}

.kc-nama {
    font-size: 15px; font-weight: 800; color: #fff;
    position: relative; z-index: 1; line-height: 1.3;
}

.kc-pengajar {
    font-size: 11.5px; color: rgba(255,255,255,.75);
    margin-top: 3px; position: relative; z-index: 1;
}

.kc-body { padding: 16px 20px 0; }

.kc-progress-head {
    display: flex; justify-content: space-between;
    align-items: center; margin-bottom: 6px;
}

.kc-progress-lbl { font-size: 12px; color: #6b7280; font-weight: 500; }
.kc-progress-pct { font-size: 13px; font-weight: 800; color: #2d6cdf; }

.kc-bar {
    height: 5px; background: #f3f4f6;
    border-radius: 99px; overflow: hidden; margin-bottom: 14px;
}

.kc-bar-fill {
    height: 100%; border-radius: 99px;
    background: linear-gradient(to right, #2d6cdf, #60a5fa);
    transition: width .7s ease;
}

.kc-footer {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 12px 20px;
    border-top: 1px solid #f3f4f6;
}

.kc-meta { display: flex; align-items: center; gap: 14px; }

.kc-meta-item {
    display: flex; align-items: center; gap: 5px;
    font-size: 12px; color: #6b7280; font-weight: 500;
}

.kc-meta-item i { font-size: 12px; color: #9ca3af; }

.btn-lanjut {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 12px; font-weight: 700;
    padding: 6px 14px; border-radius: 10px;
    text-decoration: none; transition: all .15s;
}

.btn-lanjut-blue   { background: #eff6ff; color: #2d6cdf; }
.btn-lanjut-blue:hover   { background: #2d6cdf; color: #fff; }
.btn-lanjut-green  { background: #f0fdf4; color: #059669; }
.btn-lanjut-green:hover  { background: #059669; color: #fff; }
.btn-lanjut-orange { background: #fff7ed; color: #d97706; }
.btn-lanjut-orange:hover { background: #d97706; color: #fff; }
.btn-lanjut-purple { background: #f5f3ff; color: #7c3aed; }
.btn-lanjut-purple:hover { background: #7c3aed; color: #fff; }

/* ── INFO ROW ── */
.info-row {
    font-size: 13px; color: #6b7280; margin-bottom: 16px;
}

.info-row strong { color: #111827; }

/* ── EMPTY STATE ── */
.empty-state {
    text-align: center; padding: 70px 20px;
    background: #fff; border-radius: 20px;
    box-shadow: 0 1px 8px rgba(0,0,0,.05);
}

.empty-icon  { font-size: 48px; margin-bottom: 14px; color: #d1d5db; }
.empty-title { font-size: 16px; font-weight: 800; color: #374151; margin-bottom: 5px; }
.empty-desc  { font-size: 13px; color: #9ca3af; margin-bottom: 16px; }

.empty-btn {
    display: inline-block; padding: 10px 22px;
    background: linear-gradient(135deg, #2d6cdf, #3b82f6);
    color: #fff; border-radius: 10px;
    text-decoration: none; font-size: 13px; font-weight: 700;
    transition: all .2s;
}

.empty-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(45,108,223,.35);
    color: #fff;
}

/* ── PAGE HEADER ── */
.page-header {
    display: flex; justify-content: space-between;
    align-items: center; margin-bottom: 20px; gap: 12px;
}

.page-header-left h1 { font-size: 24px; font-weight: 800; color: #111827; margin: 0 0 4px; }
.page-header-left p  { font-size: 13px; color: #6b7280; margin: 0; }

.date-badge {
    display: flex; align-items: center; gap: 6px;
    padding: 8px 14px; background: #f3f4f6;
    border-radius: 12px; font-size: 12px;
    font-weight: 600; color: #374151; white-space: nowrap;
}

.program-panel { display: none; }
.program-panel.active { display: block; }

@media (max-width: 576px) {
    .page-header { flex-direction: column; align-items: flex-start; }
    .page-header-left h1 { font-size: 18px; }
}
</style>
<?php echo $this->endSection() ?>

<?php echo $this->section('content') ?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div class="page-header-left">
        <h1>Kelas Saya</h1>
        <p>Kelola dan lanjutkan pembelajaran di kelas yang telah kamu claim.</p>
    </div>
    <div class="date-badge">
        <i class="bi bi-mortarboard-fill"></i>
        <span><?= $total_kelas ?> Kelas</span>
    </div>
</div>

<?php if (empty($grouped)): ?>

    <div class="empty-state">
        <div class="empty-icon"><i class="bi bi-inbox"></i></div>
        <div class="empty-title">Belum Ada Kelas</div>
        <div class="empty-desc">Kamu belum mengklaim kelas apapun. Temukan dan klaim kelas sekarang!</div>
        <a href="<?= base_url('dashboard/peserta/program') ?>" class="empty-btn">
            <i class="bi bi-search"></i> Temukan Kelas
        </a>
    </div>

<?php else: ?>

<?php
    $banners     = ['banner-blue', 'banner-green', 'banner-orange', 'banner-purple'];
    $icons       = ['bi-lightning-charge-fill', 'bi-cpu-fill', 'bi-tools', 'bi-diagram-3-fill'];
    $btnCls      = ['btn-lanjut-blue', 'btn-lanjut-green', 'btn-lanjut-orange', 'btn-lanjut-purple'];
    $globalIndex = 0;
?>

<!-- FILTER TABS -->
<div class="filter-tabs">
    <div class="filter-tab active" onclick="filterProgram('semua', this)">
        Semua Kelas <span class="tab-count"><?= $total_kelas ?></span>
    </div>
    <?php foreach ($grouped as $pKey => $program): ?>
    <div class="filter-tab" onclick="filterProgram('program-<?= $pKey ?>', this)">
        <?= esc($program['nama_program']) ?>
        <span class="tab-count"><?= count($program['kelas']) ?></span>
    </div>
    <?php endforeach ?>
</div>

<!-- INFO ROW -->
<div class="info-row" id="infoRow">
    Menampilkan <strong><?= $total_kelas ?></strong> kelas
</div>

<!-- ══ PANEL SEMUA ══ -->
<div class="program-panel active" id="panel-semua">
    <div class="kelas-grid">
        <?php
        $gi = 0;
        foreach ($grouped as $program):
            foreach ($program['kelas'] as $k):
                $ci  = $gi % 4;
                $lbl = $k['persen'] >= 100 ? 'Selesai ✓' : ($k['persen'] > 0 ? 'Lanjutkan' : 'Mulai Belajar');
                $gi++;
        ?>
        <div class="kelas-card">
            <div class="kc-banner <?= $banners[$ci] ?>">
                <div class="kc-icon"><i class="bi <?= $icons[$ci] ?>"></i></div>
                <div class="kc-nama"><?= esc($k['nama_kelas']) ?></div>
                <div class="kc-pengajar"><?= esc($k['nama_pengajar'] ?? 'Pengajar') ?></div>
            </div>
            <div class="kc-body">
                <div class="kc-progress-head">
                    <span class="kc-progress-lbl">Progress Belajar</span>
                    <span class="kc-progress-pct"><?= (int)$k['persen'] ?>%</span>
                </div>
                <div class="kc-bar">
                    <div class="kc-bar-fill" style="width:<?= (int)$k['persen'] ?>%"></div>
                </div>
            </div>
            <div class="kc-footer">
                <div class="kc-meta">
                    <div class="kc-meta-item"><i class="bi bi-journal-text"></i> <?= (int)$k['total_modul'] ?> Modul</div>
                    <div class="kc-meta-item"><i class="bi bi-book"></i> <?= (int)$k['total_materi'] ?> Materi</div>
                </div>
                <a href="<?= base_url('dashboard/peserta/modul?kelas=' . $k['id_kelas']) ?>"
                   class="btn-lanjut <?= $btnCls[$ci] ?>">
                    <?= $lbl ?> <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>
        <?php endforeach; endforeach ?>
    </div>
</div>

<!-- ══ PANEL PER PROGRAM ══ -->
<?php foreach ($grouped as $pKey => $program): ?>
<div class="program-panel" id="panel-program-<?= $pKey ?>">
    <div class="kelas-grid">
        <?php foreach ($program['kelas'] as $k):
            $ci  = $globalIndex % 4;
            $lbl = $k['persen'] >= 100 ? 'Selesai ✓' : ($k['persen'] > 0 ? 'Lanjutkan' : 'Mulai Belajar');
            $globalIndex++;
        ?>
        <div class="kelas-card">
            <div class="kc-banner <?= $banners[$ci] ?>">
                <div class="kc-icon"><i class="bi <?= $icons[$ci] ?>"></i></div>
                <div class="kc-nama"><?= esc($k['nama_kelas']) ?></div>
                <div class="kc-pengajar"><?= esc($k['nama_pengajar'] ?? 'Pengajar') ?></div>
            </div>
            <div class="kc-body">
                <div class="kc-progress-head">
                    <span class="kc-progress-lbl">Progress Belajar</span>
                    <span class="kc-progress-pct"><?= (int)$k['persen'] ?>%</span>
                </div>
                <div class="kc-bar">
                    <div class="kc-bar-fill" style="width:<?= (int)$k['persen'] ?>%"></div>
                </div>
            </div>
            <div class="kc-footer">
                <div class="kc-meta">
                    <div class="kc-meta-item"><i class="bi bi-journal-text"></i> <?= (int)$k['total_modul'] ?> Modul</div>
                    <div class="kc-meta-item"><i class="bi bi-book"></i> <?= (int)$k['total_materi'] ?> Materi</div>
                </div>
                <a href="<?= base_url('dashboard/peserta/modul?kelas=' . $k['id_kelas']) ?>"
                   class="btn-lanjut <?= $btnCls[$ci] ?>">
                    <?= $lbl ?> <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>
        <?php endforeach ?>
    </div>
</div>
<?php endforeach ?>

<script>
const programCounts = {
    'semua': <?= $total_kelas ?>,
    <?php foreach ($grouped as $pKey => $program): ?>
    'program-<?= $pKey ?>': <?= count($program['kelas']) ?>,
    <?php endforeach ?>
};

const programNames = {
    'semua': 'Semua Kelas',
    <?php foreach ($grouped as $pKey => $program): ?>
    'program-<?= $pKey ?>': '<?= esc($program['nama_program']) ?>',
    <?php endforeach ?>
};

function filterProgram(panelId, tabEl) {
    document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
    tabEl.classList.add('active');

    document.querySelectorAll('.program-panel').forEach(p => p.classList.remove('active'));
    document.getElementById('panel-' + panelId).classList.add('active');

    const count = programCounts[panelId] || 0;
    const name  = programNames[panelId] || '';
    const label = panelId === 'semua'
        ? 'kelas'
        : 'kelas di program <strong>' + name + '</strong>';

    document.getElementById('infoRow').innerHTML =
        'Menampilkan <strong>' + count + '</strong> ' + label;
}
</script>

<?php endif ?>

<?php echo $this->endSection() ?>
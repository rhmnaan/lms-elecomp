<?php // app/Views/Dashboard/Peserta/kelas-saya.php ?>
<?php helper('text'); ?>
<?php echo $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?php echo $this->section('meta') ?>
<title>Kelas Saya — LMS Elecomp</title>
<?php echo $this->endSection() ?>

<?php echo $this->section('styles') ?>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
    rel="stylesheet">
<style>
/* ─────────────────────────────────────────
   ROOT & RESET
───────────────────────────────────────── */
.ks-root {
    font-family: 'Plus Jakarta Sans', sans-serif;
    padding-bottom: 2rem;
}

/* ─────────────────────────────────────────
   PAGE HEADER
───────────────────────────────────────── */
.ks-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    gap: 12px;
    flex-wrap: wrap;
}

.ks-header-left h1 {
    font-size: 24px;
    font-weight: 800;
    color: #111827;
    margin: 0 0 4px;
    letter-spacing: -0.5px;
}

.ks-header-left p {
    font-size: 13px;
    color: #6b7280;
    margin: 0;
}

.ks-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: #f3f4f6;
    border: 1px solid #e5e7eb;
    border-radius: 99px;
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    white-space: nowrap;
}

.ks-badge i {
    font-size: 13px;
    color: #6b7280;
}

/* ─────────────────────────────────────────
   FILTER TABS
───────────────────────────────────────── */
.ks-tabs {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 1.25rem;
}

.ks-tab {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 16px;
    border-radius: 99px;
    border: 1.5px solid #e5e7eb;
    background: #fff;
    font-size: 12px;
    font-weight: 600;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.15s;
    user-select: none;
}

.ks-tab:hover {
    border-color: #9ca3af;
    color: #374151;
}

.ks-tab.active {
    background: #111827;
    border-color: #111827;
    color: #fff;
}

.ks-tab .cnt {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 18px;
    height: 18px;
    padding: 0 5px;
    border-radius: 99px;
    font-size: 10px;
    font-weight: 700;
    background: rgba(0, 0, 0, 0.08);
    color: inherit;
}

.ks-tab.active .cnt {
    background: rgba(255, 255, 255, 0.2);
}

/* ─────────────────────────────────────────
   INFO ROW
───────────────────────────────────────── */
.ks-info {
    font-size: 13px;
    color: #6b7280;
    margin-bottom: 1rem;
}

.ks-info strong {
    color: #111827;
    font-weight: 700;
}

/* ─────────────────────────────────────────
   KELAS GRID
───────────────────────────────────────── */
.ks-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 18px;
}

/* ─────────────────────────────────────────
   KELAS CARD
───────────────────────────────────────── */
.kelas-card {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 18px;
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
}

.kelas-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0, 0, 0, 0.09);
    border-color: #e5e7eb;
}

/* ── BANNER ── */
.kc-banner {
    padding: 20px 22px;
    min-height: 118px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
}

/* Dark gradient palettes */
.banner-blue {
    background: #0F172A;
}

.banner-teal {
    background: #064E3B;
}

.banner-amber {
    background: #451A03;
}

.banner-purple {
    background: #2E1065;
}

/* Decorative blobs */
.kc-banner::before {
    content: '';
    position: absolute;
    width: 110px;
    height: 110px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.06);
    right: -28px;
    top: -28px;
}

.kc-banner::after {
    content: '';
    position: absolute;
    width: 65px;
    height: 65px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.04);
    right: 55px;
    bottom: -22px;
}

/* banner with image override */
.kc-banner-img {
    min-height: 160px;
    background-size: cover;
    background-position: center;
}

.kc-banner-img .kc-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.38);
}

/* ── BANNER TOP ROW ── */
.kc-banner-top {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    position: relative;
    z-index: 1;
}

.kc-icon {
    width: 38px;
    height: 38px;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
}

.icon-blue {
    background: rgba(59, 130, 246, 0.25);
    color: #93c5fd;
}

.icon-teal {
    background: rgba(16, 185, 129, 0.25);
    color: #6ee7b7;
}

.icon-amber {
    background: rgba(245, 158, 11, 0.25);
    color: #fcd34d;
}

.icon-purple {
    background: rgba(139, 92, 246, 0.25);
    color: #c4b5fd;
}

.kc-pct-pill {
    padding: 3px 10px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 700;
    background: rgba(255, 255, 255, 0.18);
    color: #fff;
    backdrop-filter: blur(4px);
}

/* ── BANNER BOTTOM ── */
.kc-banner-bottom {
    position: relative;
    z-index: 1;
}

.kc-nama {
    font-size: 14.5px;
    font-weight: 800;
    color: #fff;
    line-height: 1.3;
    margin-bottom: 3px;
}

.kc-pengajar {
    font-size: 11.5px;
    color: rgba(255, 255, 255, 0.55);
}

/* ── STATUS BADGE (selesai) ── */
.kc-done-badge {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-size: 10px;
    font-weight: 700;
    padding: 2px 8px;
    border-radius: 99px;
    background: rgba(16, 185, 129, 0.25);
    color: #6ee7b7;
    margin-left: 6px;
    vertical-align: middle;
}

/* ── BODY ── */
.kc-body {
    padding: 14px 20px 2px;
}

.kc-desc {
    font-size: 12px;
    color: #6b7280;
    line-height: 1.5;
    margin-bottom: 10px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.kc-prog-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 5px;
}

.kc-prog-lbl {
    font-size: 11.5px;
    color: #9ca3af;
    font-weight: 500;
}

.kc-prog-pct {
    font-size: 12px;
    font-weight: 800;
    color: #374151;
}

.kc-bar {
    height: 4px;
    background: #f3f4f6;
    border-radius: 99px;
    overflow: hidden;
    margin-bottom: 14px;
}

.kc-bar-fill {
    height: 100%;
    border-radius: 99px;
    transition: width 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.fill-blue {
    background: linear-gradient(90deg, #3b82f6, #93c5fd);
}

.fill-teal {
    background: linear-gradient(90deg, #10b981, #6ee7b7);
}

.fill-amber {
    background: linear-gradient(90deg, #f59e0b, #fcd34d);
}

.fill-purple {
    background: linear-gradient(90deg, #8b5cf6, #c4b5fd);
}

/* ── FOOTER ── */
.kc-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 20px 14px;
    border-top: 1px solid #f9fafb;
}

.kc-meta {
    display: flex;
    align-items: center;
    gap: 12px;
}

.kc-meta-item {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11.5px;
    color: #9ca3af;
    font-weight: 500;
}

.kc-meta-item i {
    font-size: 11px;
}

/* ── CTA BUTTON ── */
.btn-lanjut {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 700;
    padding: 6px 13px;
    border-radius: 10px;
    text-decoration: none;
    transition: all 0.15s;
    white-space: nowrap;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.btn-lanjut i {
    font-size: 10px;
}

.btn-blue {
    background: rgba(59, 130, 246, 0.10);
    color: #2563eb;
}

.btn-teal {
    background: rgba(16, 185, 129, 0.10);
    color: #059669;
}

.btn-amber {
    background: rgba(245, 158, 11, 0.10);
    color: #d97706;
}

.btn-purple {
    background: rgba(139, 92, 246, 0.10);
    color: #7c3aed;
}

.btn-blue:hover {
    background: #2563eb;
    color: #fff;
    text-decoration: none;
}

.btn-teal:hover {
    background: #059669;
    color: #fff;
    text-decoration: none;
}

.btn-amber:hover {
    background: #d97706;
    color: #fff;
    text-decoration: none;
}

.btn-purple:hover {
    background: #7c3aed;
    color: #fff;
    text-decoration: none;
}

/* ── PANEL TOGGLE ── */
.program-panel {
    display: none;
}

.program-panel.active {
    display: block;
}

/* ─────────────────────────────────────────
   EMPTY STATE
───────────────────────────────────────── */
.empty-state {
    text-align: center;
    padding: 72px 24px;
    background: #fff;
    border-radius: 20px;
    border: 1px solid #f0f0f0;
}

.empty-icon {
    font-size: 44px;
    color: #d1d5db;
    margin-bottom: 14px;
}

.empty-title {
    font-size: 17px;
    font-weight: 800;
    color: #374151;
    margin-bottom: 6px;
}

.empty-desc {
    font-size: 13px;
    color: #9ca3af;
    margin-bottom: 20px;
}

.empty-btn {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 22px;
    background: #111827;
    color: #fff;
    border-radius: 12px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 700;
    transition: all 0.2s;
}

.empty-btn:hover {
    background: #1f2937;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(17, 24, 39, 0.25);
    color: #fff;
    text-decoration: none;
}

/* ─────────────────────────────────────────
   RESPONSIVE
───────────────────────────────────────── */
@media (max-width: 576px) {
    .ks-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .ks-header-left h1 {
        font-size: 20px;
    }

    .ks-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<?php echo $this->endSection() ?>

<?php echo $this->section('content') ?>

<?php
    /* ── palette maps ── */
    $banners  = ['banner-blue', 'banner-teal', 'banner-amber', 'banner-purple'];
    $icons    = ['bi-lightning-charge-fill', 'bi-cpu-fill', 'bi-tools', 'bi-diagram-3-fill'];
    $iconCls  = ['icon-blue', 'icon-teal', 'icon-amber', 'icon-purple'];
    $fillCls  = ['fill-blue', 'fill-teal', 'fill-amber', 'fill-purple'];
    $btnCls   = ['btn-blue', 'btn-teal', 'btn-amber', 'btn-purple'];
?>

<div class="ks-root">

    <!-- ── PAGE HEADER ── -->
    <div class="ks-header">
        <div class="ks-header-left">
            <h1>Kelas Saya</h1>
            <p>Kelola dan lanjutkan pembelajaran di kelas yang telah kamu claim.</p>
        </div>
        <div class="ks-badge">
            <i class="bi bi-mortarboard-fill"></i>
            <span><?php echo (int)$total_kelas ?> Kelas</span>
        </div>
    </div>

    <?php if (empty($grouped)): ?>

    <!-- ── EMPTY STATE ── -->
    <div class="empty-state">
        <div class="empty-icon"><i class="bi bi-inbox"></i></div>
        <div class="empty-title">Belum Ada Kelas</div>
        <div class="empty-desc">Kamu belum mengklaim kelas apapun. Temukan dan klaim kelas sekarang!</div>
        <a href="<?php echo base_url('dashboard/peserta/program') ?>" class="empty-btn">
            <i class="bi bi-search"></i> Temukan Kelas
        </a>
    </div>

    <?php else: ?>

    <!-- ── FILTER TABS ── -->
    <div class="ks-tabs">
        <div class="ks-tab active" onclick="filterProgram('semua', this)">
            Semua Kelas <span class="cnt"><?php echo (int)$total_kelas ?></span>
        </div>
        <?php foreach ($grouped as $pKey => $program): ?>
        <div class="ks-tab" onclick="filterProgram('program-<?php echo $pKey ?>', this)">
            <?php echo esc($program['nama_program']) ?>
            <span class="cnt"><?php echo count($program['kelas']) ?></span>
        </div>
        <?php endforeach ?>
    </div>

    <!-- ── INFO ROW ── -->
    <div class="ks-info" id="infoRow">
        Menampilkan <strong><?php echo (int)$total_kelas ?></strong> kelas
    </div>

    <!-- ══════════════════════════════════
         PANEL: SEMUA KELAS
    ══════════════════════════════════ -->
    <div class="program-panel active" id="panel-semua">
        <div class="ks-grid">
            <?php
            $gi = 0;
            foreach ($grouped as $program):
                foreach ($program['kelas'] as $k):
                    $ci  = $gi % 4;
                    $pct = (int)$k['persen'];
                    $lbl = $pct >= 100 ? 'Selesai' : ($pct > 0 ? 'Lanjutkan' : 'Mulai Belajar');
                    $gi++;
        ?>
            <div class="kelas-card">

                <?php if (!empty($k['gambar_kelas'])): ?>
                <!-- Banner: gambar -->
                <div class="kc-banner kc-banner-img"
                    style="background-image: url('<?php echo base_url('uploads/kelas/' . esc($k['gambar_kelas'])) ?>')">
                    <div class="kc-overlay"></div>
                    <div class="kc-banner-top">
                        <div></div>
                        <div class="kc-pct-pill"><?php echo $pct ?>%</div>
                    </div>
                    <div class="kc-banner-bottom">
                        <div class="kc-nama">
                            <?php echo esc($k['nama_kelas']) ?>
                            <?php if ($pct >= 100): ?>
                            <span class="kc-done-badge"><i class="bi bi-check-lg"></i> Selesai</span>
                            <?php endif ?>
                        </div>
                        <div class="kc-pengajar"><?php echo esc($k['nama_pengajar'] ?? 'Pengajar') ?></div>
                    </div>
                </div>

                <?php else: ?>
                <!-- Banner: warna -->
                <div class="kc-banner <?php echo $banners[$ci] ?>">
                    <div class="kc-banner-top">
                        <div class="kc-icon <?php echo $iconCls[$ci] ?>">
                            <i class="bi <?php echo $icons[$ci] ?>"></i>
                        </div>
                        <div class="kc-pct-pill"><?php echo $pct ?>%</div>
                    </div>
                    <div class="kc-banner-bottom">
                        <div class="kc-nama">
                            <?php echo esc($k['nama_kelas']) ?>
                            <?php if ($pct >= 100): ?>
                            <span class="kc-done-badge"><i class="bi bi-check-lg"></i> Selesai</span>
                            <?php endif ?>
                        </div>
                        <div class="kc-pengajar"><?php echo esc($k['nama_pengajar'] ?? 'Pengajar') ?></div>
                    </div>
                </div>
                <?php endif ?>

                <div class="kc-body">
                    <?php if (!empty($k['deskripsi_kelas'])): ?>
                    <p class="kc-desc"><?php echo esc(word_limiter($k['deskripsi_kelas'], 20)) ?></p>
                    <?php endif ?>

                    <div class="kc-prog-row">
                        <span class="kc-prog-lbl">Progress belajar</span>
                        <span class="kc-prog-pct"><?php echo $pct ?>%</span>
                    </div>
                    <div class="kc-bar">
                        <div class="kc-bar-fill <?php echo $fillCls[$ci] ?>" style="width:<?php echo $pct ?>%"></div>
                    </div>
                </div>

                <div class="kc-footer">
                    <div class="kc-meta">
                        <?php if (isset($k['sisa_hari']) && $k['sisa_hari'] !== null): ?>
                        <div class="kc-meta-item">
                            <i class="bi bi-clock-history"></i>
                            <?php echo (int)$k['sisa_hari'] ?> hari
                        </div>
                        <?php else: ?>
                        <div class="kc-meta-item">
                            <i class="bi bi-infinity"></i>
                            Selamanya
                        </div>
                        <?php endif ?>

                        <div class="kc-meta-item">
                            <i class="bi bi-layers"></i>
                            <?php echo (int)$k['total_modul'] ?> Modul
                        </div>
                        <div class="kc-meta-item">
                            <i class="bi bi-book"></i>
                            <?php echo (int)$k['total_materi'] ?> Materi
                        </div>
                    </div>
                    <a href="<?php echo base_url('dashboard/peserta/modul?kelas=' . $k['id_kelas']) ?>"
                        class="btn-lanjut <?php echo $btnCls[$ci] ?>">
                        <?php echo $lbl ?> <i class="bi bi-chevron-right"></i>
                    </a>
                </div>

            </div><!-- /.kelas-card -->
            <?php endforeach; endforeach ?>
        </div><!-- /.ks-grid -->
    </div><!-- /#panel-semua -->


    <!-- ══════════════════════════════════
         PANEL: PER PROGRAM
    ══════════════════════════════════ -->
    <?php
        $globalIndex = 0;
        foreach ($grouped as $pKey => $program):
    ?>
    <div class="program-panel" id="panel-program-<?php echo $pKey ?>">
        <div class="ks-grid">
            <?php foreach ($program['kelas'] as $k):
            $ci  = $globalIndex % 4;
            $pct = (int)$k['persen'];
            $lbl = $pct >= 100 ? 'Selesai' : ($pct > 0 ? 'Lanjutkan' : 'Mulai Belajar');
            $globalIndex++;
        ?>
            <div class="kelas-card">

                <?php if (!empty($k['gambar_kelas'])): ?>
                <div class="kc-banner kc-banner-img"
                    style="background-image: url('<?php echo base_url('uploads/kelas/' . esc($k['gambar_kelas'])) ?>')">
                    <div class="kc-overlay"></div>
                    <div class="kc-banner-top">
                        <div></div>
                        <div class="kc-pct-pill"><?php echo $pct ?>%</div>
                    </div>
                    <div class="kc-banner-bottom">
                        <div class="kc-nama">
                            <?php echo esc($k['nama_kelas']) ?>
                            <?php if ($pct >= 100): ?>
                            <span class="kc-done-badge"><i class="bi bi-check-lg"></i> Selesai</span>
                            <?php endif ?>
                        </div>
                        <div class="kc-pengajar"><?php echo esc($k['nama_pengajar'] ?? 'Pengajar') ?></div>
                    </div>
                </div>

                <?php else: ?>
                <div class="kc-banner <?php echo $banners[$ci] ?>">
                    <div class="kc-banner-top">
                        <div class="kc-icon <?php echo $iconCls[$ci] ?>">
                            <i class="bi <?php echo $icons[$ci] ?>"></i>
                        </div>
                        <div class="kc-pct-pill"><?php echo $pct ?>%</div>
                    </div>
                    <div class="kc-banner-bottom">
                        <div class="kc-nama">
                            <?php echo esc($k['nama_kelas']) ?>
                            <?php if ($pct >= 100): ?>
                            <span class="kc-done-badge"><i class="bi bi-check-lg"></i> Selesai</span>
                            <?php endif ?>
                        </div>
                        <div class="kc-pengajar"><?php echo esc($k['nama_pengajar'] ?? 'Pengajar') ?></div>
                    </div>
                </div>
                <?php endif ?>

                <div class="kc-body">
                    <div class="kc-prog-row">
                        <span class="kc-prog-lbl">Progress belajar</span>
                        <span class="kc-prog-pct"><?php echo $pct ?>%</span>
                    </div>
                    <div class="kc-bar">
                        <div class="kc-bar-fill <?php echo $fillCls[$ci] ?>" style="width:<?php echo $pct ?>%"></div>
                    </div>
                </div>

                <div class="kc-footer">
                    <div class="kc-meta">
                        <?php if (isset($k['sisa_hari']) && $k['sisa_hari'] !== null): ?>
                        <div class="kc-meta-item">
                            <i class="bi bi-clock-history"></i>
                            <?php echo (int)$k['sisa_hari'] ?> hari
                        </div>
                        <?php else: ?>
                        <div class="kc-meta-item">
                            <i class="bi bi-infinity"></i>
                            Selamanya
                        </div>
                        <?php endif ?>

                        <div class="kc-meta-item">
                            <i class="bi bi-layers"></i>
                            <?php echo (int)$k['total_modul'] ?> Modul
                        </div>
                        <div class="kc-meta-item">
                            <i class="bi bi-book"></i>
                            <?php echo (int)$k['total_materi'] ?> Materi
                        </div>
                    </div>
                    <div style="display:flex; gap:6px;">
                        <!-- Tombol Tugas -->
                        <a href="<?= base_url('dashboard/peserta/tugas/' . $k['id_kelas']) ?>"
                            class="btn-lanjut btn-purple">
                            <i class="bi bi-clipboard-check"></i> Tugas
                        </a>

                        <!-- Tombol Modul -->
                        <a href="<?= base_url('dashboard/peserta/modul?kelas=' . $k['id_kelas']) ?>"
                            class="btn-lanjut <?= $btnCls[$ci] ?>">
                            <?= $lbl ?> <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                </div>

            </div><!-- /.kelas-card -->
            <?php endforeach ?>
        </div><!-- /.ks-grid -->
    </div><!-- /#panel-program-X -->
    <?php endforeach ?>

    <!-- ══════════════════════════════════
         JAVASCRIPT
    ══════════════════════════════════ -->
    <script>
    const programCounts = {
        'semua': <?php echo (int)$total_kelas ?>,
        <?php foreach ($grouped as $pKey => $program): ?> 'program-<?php echo $pKey ?>': <?php echo count($program['kelas']) ?>,
        <?php endforeach ?>
    };

    const programNames = {
        'semua': 'Semua Kelas',
        <?php foreach ($grouped as $pKey => $program): ?> 'program-<?php echo $pKey ?>': '<?php echo esc($program['nama_program']) ?>',
        <?php endforeach ?>
    };

    function filterProgram(panelId, tabEl) {
        /* update tabs */
        document.querySelectorAll('.ks-tab').forEach(t => t.classList.remove('active'));
        tabEl.classList.add('active');

        /* update panels */
        document.querySelectorAll('.program-panel').forEach(p => p.classList.remove('active'));
        document.getElementById('panel-' + panelId).classList.add('active');

        /* update info row */
        const count = programCounts[panelId] || 0;
        const name = programNames[panelId] || '';
        const label = panelId === 'semua' ?
            'kelas' :
            'kelas di program <strong>' + name + '</strong>';

        document.getElementById('infoRow').innerHTML =
            'Menampilkan <strong>' + count + '</strong> ' + label;
    }
    </script>

    <?php endif ?>

</div><!-- /.ks-root -->

<?php echo $this->endSection() ?>
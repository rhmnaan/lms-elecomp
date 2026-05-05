<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('meta') ?>
<title>Riwayat Tugas — LMS Elecomp</title>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* ─── ROOT ─── */
.rh-root {
    font-family: 'Plus Jakarta Sans', sans-serif;
    padding-bottom: 2.5rem;
    color: #111827;
}

/* ─── PAGE HEADER ─── */
.rh-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 1.75rem;
}

.rh-header-left h1 {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 3px;
    letter-spacing: -0.3px;
}

.rh-header-left p {
    font-size: 13px;
    color: #6b7280;
    margin: 0;
}

.rh-header-left p strong {
    font-weight: 600;
    color: #374151;
}

.rh-header-actions {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    align-items: center;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 15px;
    border-radius: 10px;
    font-size: 12.5px;
    font-weight: 600;
    font-family: 'Plus Jakarta Sans', sans-serif;
    border: 1px solid #e5e7eb;
    background: #fff;
    color: #374151;
    text-decoration: none;
    transition: all 0.15s;
}

.btn-back:hover {
    background: #f9fafb;
    border-color: #d1d5db;
    color: #111827;
    text-decoration: none;
}

.btn-daftar {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 17px;
    border-radius: 10px;
    font-size: 12.5px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: #111827;
    color: #fff;
    text-decoration: none;
    border: 1px solid #111827;
    transition: all 0.15s;
}

.btn-daftar:hover {
    background: #1f2937;
    color: #fff;
    text-decoration: none;
}

/* ─── INFO TUGAS BANNER ─── */
.rh-task-banner {
    background: #f9fafb;
    border: 1px solid #f0f0f0;
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
}

.rh-task-banner-left {
    display: flex;
    align-items: center;
    gap: 14px;
}

.rh-task-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: #111827;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 18px;
    flex-shrink: 0;
}

.rh-task-info-name {
    font-size: 14px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 3px;
    line-height: 1.3;
}

.rh-task-info-meta {
    font-size: 12px;
    color: #9ca3af;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
}

.rh-task-info-meta span {
    display: flex;
    align-items: center;
    gap: 4px;
}

.rh-count-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 99px;
    font-size: 12px;
    font-weight: 700;
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
    white-space: nowrap;
}

/* ─── TIMELINE WRAPPER ─── */
.rh-timeline {
    position: relative;
    padding-left: 28px;
    display: flex;
    flex-direction: column;
    gap: 0;
}

/* Garis vertikal timeline */
.rh-timeline::before {
    content: '';
    position: absolute;
    left: 9px;
    top: 20px;
    bottom: 20px;
    width: 1.5px;
    background: linear-gradient(to bottom, #e5e7eb 0%, #e5e7eb 90%, transparent 100%);
}

/* ─── TIMELINE ITEM ─── */
.rh-item {
    position: relative;
    margin-bottom: 16px;
}

.rh-item:last-child {
    margin-bottom: 0;
}

/* Dot pada garis timeline */
.rh-dot {
    position: absolute;
    left: -24px;
    top: 18px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 0 1.5px #d1d5db;
    background: #9ca3af;
    z-index: 1;
}

.rh-dot.dot-success { background: #16a34a; box-shadow: 0 0 0 1.5px #bbf7d0; }
.rh-dot.dot-pending { background: #d97706; box-shadow: 0 0 0 1.5px #fde68a; }
.rh-dot.dot-rejected { background: #dc2626; box-shadow: 0 0 0 1.5px #fecaca; }

/* ─── CARD ─── */
.rh-card {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 16px;
    overflow: hidden;
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
}

.rh-card:hover {
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.06);
    border-color: #e5e7eb;
}

/* ── CARD HEAD ── */
.rh-card-head {
    padding: 16px 20px 14px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}

.rh-card-date {
    font-size: 13.5px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 3px;
    display: flex;
    align-items: center;
    gap: 6px;
}

.rh-card-date i { font-size: 13px; color: #9ca3af; }

.rh-card-tipe {
    font-size: 12px;
    color: #9ca3af;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 5px;
}

/* ── STATUS BADGE ── */
.rh-status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 11px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
    flex-shrink: 0;
}

.badge-terkirim  { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
.badge-pending   { background: #fef9c3; color: #854d0e; border: 1px solid #fde68a; }
.badge-ditolak   { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }
.badge-default   { background: #f3f4f6; color: #374151; border: 1px solid #e5e7eb; }

/* ── DIVIDER ── */
.rh-divider {
    height: 1px;
    background: #f9fafb;
    margin: 0 20px;
}

/* ── CARD BODY ── */
.rh-card-body {
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
}

.rh-body-left {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    align-items: flex-start;
    flex: 1;
}

.rh-meta-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.rh-meta-label {
    font-size: 10.5px;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.rh-meta-val {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 5px;
}

.rh-meta-val i { font-size: 12px; color: #9ca3af; }

/* Tombol lihat file */
.btn-file {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 16px;
    border-radius: 10px;
    font-size: 12.5px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: rgba(37, 99, 235, 0.08);
    color: #2563eb;
    border: 1px solid rgba(37, 99, 235, 0.2);
    text-decoration: none;
    transition: all 0.15s;
    flex-shrink: 0;
}

.btn-file:hover {
    background: #2563eb;
    color: #fff;
    border-color: #2563eb;
    text-decoration: none;
}

/* ── CATATAN / FOOTER ── */
.rh-card-note {
    padding: 12px 20px;
    background: #f9fafb;
    border-top: 1px solid #f0f0f0;
    display: flex;
    align-items: flex-start;
    gap: 8px;
}

.rh-note-icon {
    font-size: 13px;
    color: #9ca3af;
    margin-top: 1px;
    flex-shrink: 0;
}

.rh-note-label {
    font-size: 10.5px;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 3px;
}

.rh-note-text {
    font-size: 13px;
    color: #374151;
    font-weight: 500;
    line-height: 1.55;
}

/* ─── URUTAN LABEL ─── */
.rh-order-label {
    font-size: 10.5px;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 5px;
}

/* ─── EMPTY STATE ─── */
.rh-empty {
    text-align: center;
    padding: 72px 24px;
    background: #fff;
    border-radius: 20px;
    border: 1px solid #f0f0f0;
}

.rh-empty-icon { font-size: 42px; color: #d1d5db; margin-bottom: 14px; }
.rh-empty-title { font-size: 16px; font-weight: 800; color: #374151; margin-bottom: 6px; }
.rh-empty-desc  { font-size: 13px; color: #9ca3af; line-height: 1.6; }

/* ─── RESPONSIVE ─── */
@media (max-width: 576px) {
    .rh-header          { flex-direction: column; }
    .rh-header-actions  { width: 100%; }
    .rh-header-actions a { flex: 1; justify-content: center; }
    .rh-timeline        { padding-left: 22px; }
    .rh-dot             { left: -18px; }
    .rh-card-head       { flex-direction: column; align-items: flex-start; }
    .rh-card-body       { flex-direction: column; }
    .rh-task-banner     { flex-direction: column; align-items: flex-start; }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="rh-root">

    <!-- ── PAGE HEADER ── -->
    <div class="rh-header">
        <div class="rh-header-left">
            <h1>Riwayat Pengumpulan</h1>
            <p>Riwayat pengumpulan untuk tugas <strong><?= esc($tugas['judul_tugas']) ?></strong></p>
        </div>
        <div class="rh-header-actions">
            <a href="<?= base_url('dashboard/peserta/kelas-saya') ?>" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="<?= base_url('dashboard/peserta/kelas-tugas?kelas=' . $tugas['id_kelas']) ?>" class="btn-daftar">
                <i class="bi bi-journal-bookmark"></i> Daftar Tugas
            </a>
        </div>
    </div>

    <!-- ── INFO TUGAS BANNER ── -->
    <div class="rh-task-banner">
        <div class="rh-task-banner-left">
            <div class="rh-task-icon">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <div>
                <div class="rh-task-info-name"><?= esc($tugas['judul_tugas']) ?></div>
                <div class="rh-task-info-meta">
                    <?php if (!empty($tugas['judul_modul'])): ?>
                    <span><i class="bi bi-layers"></i> <?= esc($tugas['judul_modul']) ?></span>
                    <span style="color:#e5e7eb">·</span>
                    <?php endif ?>
                    <span>
                        <i class="bi bi-clock-history"></i>
                        <?= $tugas['deadline_hari'] !== null
                            ? (int)$tugas['deadline_hari'] . ' hari deadline'
                            : 'Tanpa batas deadline' ?>
                    </span>
                </div>
            </div>
        </div>
        <?php if (!empty($history)): ?>
        <div class="rh-count-pill">
            <i class="bi bi-clock-history"></i>
            <?= count($history) ?> Pengumpulan
        </div>
        <?php endif ?>
    </div>

    <?php if (empty($history)): ?>

    <!-- ── EMPTY STATE ── -->
    <div class="rh-empty">
        <div class="rh-empty-icon"><i class="bi bi-clock-history"></i></div>
        <div class="rh-empty-title">Belum ada riwayat pengumpulan</div>
        <div class="rh-empty-desc">Kamu belum mengumpulkan tugas ini.<br>Kerjakan tugas terlebih dahulu untuk melihat riwayat pengumpulan.</div>
    </div>

    <?php else: ?>

    <!-- ── TIMELINE ── -->
    <div class="rh-timeline">
        <?php foreach ($history as $i => $item): ?>

        <?php
            /* ── dot & badge class berdasarkan status ── */
            $statusLower = strtolower($item['status'] ?? '');
            if (str_contains($statusLower, 'terkirim') || str_contains($statusLower, 'diterima')) {
                $dotClass   = 'dot-success';
                $badgeClass = 'badge-terkirim';
                $badgeIcon  = 'bi-check-circle-fill';
            } elseif (str_contains($statusLower, 'tolak') || str_contains($statusLower, 'ditolak')) {
                $dotClass   = 'dot-rejected';
                $badgeClass = 'badge-ditolak';
                $badgeIcon  = 'bi-x-circle-fill';
            } elseif (str_contains($statusLower, 'pending') || str_contains($statusLower, 'menunggu') || str_contains($statusLower, 'review')) {
                $dotClass   = 'dot-pending';
                $badgeClass = 'badge-pending';
                $badgeIcon  = 'bi-hourglass-split';
            } else {
                $dotClass   = '';
                $badgeClass = 'badge-default';
                $badgeIcon  = 'bi-circle';
            }
        ?>

        <div class="rh-item">
            <!-- Dot timeline -->
            <div class="rh-dot <?= $dotClass ?>"></div>

            <!-- Urutan -->
            <div class="rh-order-label" style="margin-bottom:6px">
                <i class="bi bi-arrow-up-circle"></i>
                Pengumpulan ke-<?= $i + 1 ?>
            </div>

            <div class="rh-card">

                <!-- HEAD: tanggal + badge status -->
                <div class="rh-card-head">
                    <div>
                        <div class="rh-card-date">
                            <i class="bi bi-calendar3"></i>
                            <?= date('d M Y', strtotime($item['created_at'])) ?>
                            <span style="color:#d1d5db;font-weight:400">·</span>
                            <?= date('H:i', strtotime($item['created_at'])) ?> WIB
                        </div>
                        <div class="rh-card-tipe">
                            <i class="bi bi-paperclip"></i>
                            <?= esc($item['tipe_jawaban']) ?>
                        </div>
                    </div>
                    <span class="rh-status-badge <?= $badgeClass ?>">
                        <i class="bi <?= $badgeIcon ?>"></i>
                        <?= esc($item['status']) ?>
                    </span>
                </div>

                <div class="rh-divider"></div>

                <!-- BODY: meta + tombol file -->
                <div class="rh-card-body">
                    <div class="rh-body-left">
                        <div class="rh-meta-item">
                            <div class="rh-meta-label">Status</div>
                            <div class="rh-meta-val">
                                <i class="bi bi-info-circle"></i>
                                <?= esc($item['status']) ?>
                            </div>
                        </div>
                        <div class="rh-meta-item">
                            <div class="rh-meta-label">Tipe Jawaban</div>
                            <div class="rh-meta-val">
                                <i class="bi bi-paperclip"></i>
                                <?= esc($item['tipe_jawaban']) ?>
                            </div>
                        </div>
                        <div class="rh-meta-item">
                            <div class="rh-meta-label">Waktu Kirim</div>
                            <div class="rh-meta-val">
                                <i class="bi bi-clock"></i>
                                <?= date('d M Y, H:i', strtotime($item['created_at'])) ?> WIB
                            </div>
                        </div>
                    </div>

                    <?php if (!empty($item['link_file'])): ?>
                    <a href="<?= base_url($item['link_file']) ?>" target="_blank" class="btn-file">
                        <i class="bi bi-file-earmark-arrow-down"></i> Lihat File
                    </a>
                    <?php endif ?>
                </div>

                <!-- CATATAN (jika ada) -->
                <?php if (!empty($item['catatan_jawaban'])): ?>
                <div class="rh-card-note">
                    <i class="bi bi-chat-left-text rh-note-icon"></i>
                    <div>
                        <div class="rh-note-label">Catatan</div>
                        <div class="rh-note-text"><?= esc($item['catatan_jawaban']) ?></div>
                    </div>
                </div>
                <?php endif ?>

            </div><!-- /.rh-card -->
        </div><!-- /.rh-item -->

        <?php endforeach ?>
    </div><!-- /.rh-timeline -->

    <?php endif ?>

</div><!-- /.rh-root -->

<?= $this->endSection() ?>
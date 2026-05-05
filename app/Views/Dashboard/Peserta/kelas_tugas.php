<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('meta') ?>
<title>Tugas Kelas — LMS Elecomp</title>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700&display=swap"
    rel="stylesheet">
<style>
/* ─── RESET & ROOT ─── */
.tj-root {
    font-family: 'Plus Jakarta Sans', sans-serif;
    padding-bottom: 2.5rem;
    color: #111827;
}

/* ─── PAGE HEADER ─── */
.tj-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 1.75rem;
}

.tj-header-left h1 {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 3px;
    letter-spacing: -0.3px;
}

.tj-header-left p {
    font-size: 13px;
    color: #6b7280;
    margin: 0;
}

.tj-header-left p strong {
    font-weight: 600;
    color: #374151;
}

.tj-header-actions {
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
    cursor: pointer;
}

.btn-back:hover {
    background: #f9fafb;
    border-color: #d1d5db;
    color: #111827;
    text-decoration: none;
}

.btn-modul {
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
    cursor: pointer;
}

.btn-modul:hover {
    background: #1f2937;
    color: #fff;
    text-decoration: none;
}

/* ─── ALERT ─── */
.tj-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 1.25rem;
}

.tj-alert-success {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
}

.tj-alert-error {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
}

/* ─── SUMMARY BAR ─── */
.tj-summary {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 10px;
    margin-bottom: 1.5rem;
}

.tj-sum-card {
    background: #f9fafb;
    border: 1px solid #f0f0f0;
    border-radius: 14px;
    padding: 16px 18px;
}

.tj-sum-label {
    font-size: 11px;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
}

.tj-sum-val {
    font-size: 26px;
    font-weight: 800;
    color: #111827;
    line-height: 1;
    letter-spacing: -0.5px;
}

.tj-sum-val.blue {
    color: #2563eb;
}

.tj-sum-val.amber {
    color: #d97706;
}

.tj-sum-val.red {
    color: #dc2626;
}

.tj-sum-sub {
    font-size: 11.5px;
    color: #9ca3af;
    margin-top: 5px;
    font-weight: 500;
}

/* ─── TASK LIST ─── */
.tj-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

/* ─── TASK CARD ─── */
.tj-card {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 18px;
    overflow: hidden;
    transition: box-shadow 0.2s ease, border-color 0.2s ease;
}

.tj-card:hover {
    box-shadow: 0 6px 24px rgba(0, 0, 0, 0.06);
    border-color: #e5e7eb;
}

.tj-card.is-expired {
    opacity: 0.65;
}

/* ── CARD HEAD ── */
.tj-card-head {
    padding: 18px 22px 16px;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 14px;
}

.tj-card-head-left {
    flex: 1;
    min-width: 0;
}

.tj-task-num {
    font-size: 11px;
    font-weight: 600;
    color: #9ca3af;
    margin-bottom: 6px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.tj-task-num i {
    font-size: 11px;
}

.tj-task-title {
    font-size: 14.5px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 5px;
    line-height: 1.35;
}

.tj-task-desc {
    font-size: 12.5px;
    color: #6b7280;
    line-height: 1.55;
    margin: 0;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* ── STATUS BADGE ── */
.tj-badge {
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

.badge-sent {
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
}

.badge-open {
    background: #f0fdf4;
    color: #15803d;
    border: 1px solid #bbf7d0;
}

.badge-expired {
    background: #fef2f2;
    color: #b91c1c;
    border: 1px solid #fecaca;
}

/* ── DIVIDER ── */
.tj-divider {
    height: 1px;
    background: #f9fafb;
    margin: 0 22px;
}

/* ── CARD META ── */
.tj-card-meta {
    padding: 14px 22px;
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
    align-items: center;
}

/* Meta kiri tumbuh, tombol kerjakan di kanan */
.tj-meta-left {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
    align-items: flex-start;
    flex: 1;
    min-width: 0;
}

.tj-meta-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.tj-meta-label {
    font-size: 10.5px;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.tj-meta-val {
    font-size: 12.5px;
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 5px;
}

.tj-meta-val i {
    font-size: 12px;
    color: #9ca3af;
}

.pill {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 9px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 700;
}

.pill-warn {
    background: #fef9c3;
    color: #854d0e;
    border: 1px solid #fde68a;
}

.pill-neutral {
    background: #f3f4f6;
    color: #374151;
    border: 1px solid #e5e7eb;
}

/* Pemisah vertikal antara meta kiri dan tombol kerjakan */
.tj-meta-sep {
    width: 1px;
    align-self: stretch;
    background: #f0f0f0;
    flex-shrink: 0;
}

/* Tombol kerjakan di dalam meta row */
.tj-meta-action {
    flex-shrink: 0;
}

/* ── CARD FOOTER (riwayat tugas) ── */
.tj-card-footer {
    padding: 12px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    background: #f9fafb;
    border-top: 1px solid #f0f0f0;
}

.tj-footer-note {
    font-size: 12px;
    color: #9ca3af;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 5px;
}

.tj-footer-note.danger {
    color: #dc2626;
}

.tj-footer-note.success {
    color: #16a34a;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 16px;
    border-radius: 10px;
    font-size: 12.5px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    text-decoration: none;
    transition: all 0.15s;
    cursor: pointer;
    border: none;
}

.btn-action-primary {
    background: rgba(37, 99, 235, 0.08);
    color: #2563eb;
    border: 1px solid rgba(37, 99, 235, 0.2);
}

.btn-action-primary:hover {
    background: #2563eb;
    color: #fff;
    border-color: #2563eb;
    text-decoration: none;
}

.btn-action-outline {
    background: transparent;
    color: #2563eb;
    border: 1px solid rgba(37, 99, 235, 0.2);
}

.btn-action-outline:hover {
    background: #eff6ff;
    color: #2563eb;
    text-decoration: none;
}

.btn-action-muted {
    background: #f3f4f6;
    color: #9ca3af;
    border: 1px solid #e5e7eb;
    cursor: not-allowed;
    pointer-events: none;
}

.tugas-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.55);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    padding: 1rem;
}

.tugas-modal-overlay.active {
    display: flex;
}

.tugas-modal {
    width: min(600px, 100%);
    max-height: 90vh;
    overflow: auto;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 32px 80px rgba(15, 23, 42, 0.25);
}

.tugas-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    padding: 20px 24px;
    border-bottom: 1px solid #f3f4f6;
}

.tugas-modal-header h3 {
    margin: 0;
    font-size: 18px;
    font-weight: 800;
    color: #111827;
}

.tugas-modal-close {
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 12px;
    background: #f3f4f6;
    color: #374151;
    font-size: 20px;
    cursor: pointer;
}

.tugas-modal-body {
    padding: 20px 24px 24px;
    display: grid;
    gap: 16px;
}

.tugas-form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.tugas-form-group label {
    font-size: 13px;
    font-weight: 700;
    color: #111827;
}

.tugas-form-input,
.tugas-form-textarea {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    font-size: 14px;
    color: #111827;
}

.tugas-form-textarea {
    min-height: 120px;
    resize: vertical;
}

.tugas-file-card {
    padding: 18px 16px;
    border: 1px dashed #d1d5db;
    border-radius: 16px;
    text-align: center;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.15s;
}

.tugas-file-card:hover {
    border-color: #2563eb;
    background: #eff6ff;
}

.tugas-file-card.active {
    border-color: #2563eb;
    background: #eff6ff;
}

.tugas-file-name {
    font-size: 13px;
    color: #374151;
    margin-top: 8px;
}

.tugas-radio-group {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}

.tugas-radio-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    color: #374151;
}

.tugas-btn-group {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    flex-wrap: wrap;
    padding-top: 6px;
}

.tugas-btn {
    border-radius: 12px;
    padding: 10px 18px;
    font-weight: 700;
    font-size: 13px;
    cursor: pointer;
    border: 1px solid transparent;
}

.tugas-btn-primary {
    background: #2563eb;
    color: #fff;
    border-color: #2563eb;
}

.tugas-btn-secondary {
    background: #f3f4f6;
    color: #374151;
    border-color: #e5e7eb;
}

/* ── HISTORY ── */
.tj-history {
    padding: 0 22px 18px;
}

.tj-history-label {
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

.tj-history-list {
    display: flex;
    flex-direction: column;
    gap: 7px;
}

.tj-history-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 9px 13px;
    background: #f9fafb;
    border: 1px solid #f0f0f0;
    border-radius: 10px;
    gap: 12px;
}

.tj-history-date {
    font-size: 11px;
    color: #9ca3af;
    font-weight: 500;
    margin-bottom: 2px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.tj-history-detail {
    font-size: 12px;
    font-weight: 600;
    color: #374151;
}

.tj-history-link {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11.5px;
    font-weight: 700;
    color: #2563eb;
    text-decoration: none;
    padding: 4px 10px;
    border-radius: 8px;
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    transition: all 0.15s;
    white-space: nowrap;
}

.tj-history-link:hover {
    background: #2563eb;
    color: #fff;
    border-color: #2563eb;
    text-decoration: none;
}

/* ─── EMPTY STATE ─── */
.tj-empty {
    text-align: center;
    padding: 72px 24px;
    background: #fff;
    border-radius: 20px;
    border: 1px solid #f0f0f0;
}

.tj-empty-icon {
    font-size: 42px;
    color: #d1d5db;
    margin-bottom: 14px;
}

.tj-empty-title {
    font-size: 16px;
    font-weight: 800;
    color: #374151;
    margin-bottom: 6px;
}

.tj-empty-desc {
    font-size: 13px;
    color: #9ca3af;
}

/* ─── RESPONSIVE ─── */
@media (max-width: 576px) {
    .tj-header {
        flex-direction: column;
    }

    .tj-header-actions {
        width: 100%;
    }

    .tj-header-actions a {
        flex: 1;
        justify-content: center;
    }

    .tj-summary {
        grid-template-columns: 1fr 1fr;
    }

    .tj-summary .tj-sum-card:last-child {
        grid-column: span 2;
    }

    .tj-card-head {
        flex-direction: column;
    }

    .tj-card-meta {
        flex-direction: column;
        gap: 12px;
    }

    .tj-meta-sep {
        display: none;
    }

    .tj-card-footer {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="tj-root">

    <!-- ── PAGE HEADER ── -->
    <div class="tj-header">
        <div class="tj-header-left">
            <h1>Tugas Kelas</h1>
            <p>Daftar tugas untuk kelas <strong><?= esc($kelas['nama_kelas']) ?></strong></p>
        </div>
        <div class="tj-header-actions">
            <a href="<?= base_url('dashboard/peserta/kelas') ?>" class="btn-back">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <a href="<?= base_url('dashboard/peserta/modul?kelas=' . $kelas['id_kelas']) ?>" class="btn-modul">
                <i class="bi bi-journal-bookmark"></i> Lihat Modul
            </a>
        </div>
    </div>

    <!-- ── FLASH MESSAGES ── -->
    <?php if (session()->getFlashdata('success')): ?>
    <div class="tj-alert tj-alert-success">
        <i class="bi bi-check-circle-fill"></i>
        <?= session()->getFlashdata('success') ?>
    </div>
    <?php endif ?>

    <?php if (session()->getFlashdata('error')): ?>
    <div class="tj-alert tj-alert-error">
        <i class="bi bi-exclamation-circle-fill"></i>
        <?= session()->getFlashdata('error') ?>
    </div>
    <?php endif ?>

    <?php if (empty($tugas)): ?>
    <!-- ── EMPTY STATE ── -->
    <div class="tj-empty">
        <div class="tj-empty-icon"><i class="bi bi-journal-bookmark"></i></div>
        <div class="tj-empty-title">Belum Ada Tugas</div>
        <div class="tj-empty-desc">Instruktur belum menambahkan tugas untuk kelas ini.</div>
    </div>

    <?php else: ?>

    <?php
        /* ── Hitung summary ── */
        $totalTugas   = count($tugas);
        $sudahKirim   = count(array_filter($tugas, fn($t) => $t['has_submission']));
        $belumKirim   = count(array_filter($tugas, fn($t) => !$t['has_submission'] && !$t['is_expired']));
        $expired      = count(array_filter($tugas, fn($t) => $t['is_expired']));
    ?>

    <!-- ── SUMMARY BAR ── -->
    <div class="tj-summary">
        <div class="tj-sum-card">
            <div class="tj-sum-label">Total Tugas</div>
            <div class="tj-sum-val"><?= $totalTugas ?></div>
            <div class="tj-sum-sub">Kelas ini</div>
        </div>
        <div class="tj-sum-card">
            <div class="tj-sum-label">Sudah Dikirim</div>
            <div class="tj-sum-val blue"><?= $sudahKirim ?></div>
            <div class="tj-sum-sub">Selesai</div>
        </div>
        <div class="tj-sum-card">
            <div class="tj-sum-label">Belum Dikirim</div>
            <div class="tj-sum-val <?= $belumKirim > 0 ? 'amber' : '' ?>"><?= $belumKirim ?></div>
            <div class="tj-sum-sub">Perlu dikerjakan</div>
        </div>
    </div>

    <!-- ── TASK LIST ── -->
    <div class="tj-list">
        <?php foreach ($tugas as $i => $task): ?>

        <?php
            /* ── Status vars ── */
            if ($task['is_expired']) {
                $badgeClass = 'badge-expired';
                $badgeIcon  = 'bi-x-circle-fill';
                $badgeText  = 'Berakhir';
            } elseif ($task['has_submission']) {
                $badgeClass = 'badge-sent';
                $badgeIcon  = 'bi-check-circle-fill';
                $badgeText  = 'Sudah Dikirim';
            } else {
                $badgeClass = 'badge-open';
                $badgeIcon  = 'bi-clock-fill';
                $badgeText  = 'Belum Dikirim';
            }
        ?>

        <div class="tj-card <?= $task['is_expired'] ? 'is-expired' : '' ?>">

            <!-- HEAD -->
            <div class="tj-card-head">
                <div class="tj-card-head-left">
                    <div class="tj-task-num">
                        <i class="bi bi-file-earmark-text"></i>
                        Tugas <?= $i + 1 ?>
                        <?php if (!empty($task['judul_modul'])): ?>
                        &nbsp;·&nbsp; <?= esc($task['judul_modul']) ?>
                        <?php endif ?>
                    </div>
                    <h2 class="tj-task-title"><?= esc($task['judul_tugas']) ?></h2>
                    <?php if (!empty($task['deskripsi_tugas'])): ?>
                    <p class="tj-task-desc"><?= esc($task['deskripsi_tugas']) ?></p>
                    <?php endif ?>
                </div>
                <span class="tj-badge <?= $badgeClass ?>">
                    <i class="bi <?= $badgeIcon ?>"></i>
                    <?= $badgeText ?>
                </span>
            </div>

            <div class="tj-divider"></div>

            <!-- META -->
            <div class="tj-card-meta">

                <!-- Kiri: deadline, modul, syarat -->
                <div class="tj-meta-left">
                    <div class="tj-meta-item">
                        <div class="tj-meta-label">Deadline</div>
                        <div class="tj-meta-val">
                            <i class="bi bi-clock-history"></i>
                            <?= $task['deadline_hari'] !== null
                                ? (int)$task['deadline_hari'] . ' hari'
                                : 'Tanpa batas' ?>
                        </div>
                    </div>

                    <?php if (!empty($task['judul_modul'])): ?>
                    <div class="tj-meta-item">
                        <div class="tj-meta-label">Modul</div>
                        <div class="tj-meta-val">
                            <i class="bi bi-layers"></i>
                            <?= esc($task['judul_modul']) ?>
                        </div>
                    </div>
                    <?php endif ?>

                    <div class="tj-meta-item">
                        <div class="tj-meta-label">Syarat Pengumpulan</div>
                        <div class="tj-meta-val">
                            <?php if ($task['is_wajib_posttest']): ?>
                            <span class="pill pill-warn">
                                <i class="bi bi-shield-check"></i> Setelah Posttest
                            </span>
                            <?php else: ?>
                            <span class="pill pill-neutral">
                                <i class="bi bi-unlock"></i> Bisa Langsung
                            </span>
                            <?php endif ?>
                        </div>
                    </div>
                </div>

                <!-- Separator vertikal -->
                <div class="tj-meta-sep"></div>

                <!-- Kanan: tombol kerjakan / kerjakan ulang -->
                <div class="tj-meta-action">
                    <?php if ($task['is_expired']): ?>
                    <button class="btn-action btn-action-muted" disabled>
                        <i class="bi bi-slash-circle"></i> Tidak Tersedia
                    </button>
                    <?php elseif (!$task['can_submit']): ?>
                    <button class="btn-action btn-action-muted" disabled>
                        <i class="bi bi-lock"></i>
                        <?= $task['has_submission'] ? 'Kerjakan Ulang' : 'Kerjakan Tugas' ?>
                    </button>
                    <?php else: ?>
                    <button type="button" class="btn-action btn-action-primary btn-open-tugas-modal"
                        data-task-id="<?= $task['id_tugas'] ?>"
                        data-task-title="<?= esc($task['judul_tugas'], 'attr') ?>"
                        data-task-desc="<?= esc($task['deskripsi_tugas'] ?? '', 'attr') ?>"
                        data-task-has-submission="<?= $task['has_submission'] ? '1' : '0' ?>">
                        <i class="bi bi-pencil-square"></i>
                        <?= $task['has_submission'] ? 'Kerjakan Ulang' : 'Kerjakan Tugas' ?>
                    </button>
                    <?php endif ?>
                </div>

            </div>

            <!-- FOOTER: status kiri + tombol riwayat kanan -->
            <div class="tj-card-footer">
                <?php if ($task['is_expired']): ?>
                <span class="tj-footer-note danger">
                    <i class="bi bi-x-circle"></i>
                    Periode pengumpulan telah berakhir
                </span>
                <?php elseif ($task['has_submission']): ?>
                <span class="tj-footer-note success">
                    <i class="bi bi-check-circle"></i>
                    Tugas sudah dikumpulkan
                </span>
                <?php elseif ($task['is_wajib_posttest'] && !$task['can_submit']): ?>
                <span class="tj-footer-note">
                    <i class="bi bi-info-circle"></i>
                    Selesaikan posttest modul terlebih dahulu
                </span>
                <?php else: ?>
                <span class="tj-footer-note">
                    <i class="bi bi-send"></i>
                    Belum ada pengumpulan
                </span>
                <?php endif ?>

                <a href="<?= base_url('dashboard/peserta/tugas-riwayat/' . $task['id_tugas']) ?>"
                    class="btn-action btn-action-outline">
                    <i class="bi bi-clock-history"></i> Riwayat Pengumpulan
                </a>
            </div>

        </div><!-- /.tj-card -->

        <?php endforeach ?>
    </div><!-- /.tj-list -->

    <?php endif ?>

</div><!-- /.tj-root -->

<div class="tugas-modal-overlay" id="tugasModalOverlay">
    <div class="tugas-modal" role="dialog" aria-modal="true" aria-labelledby="tugasModalTitle">
        <div class="tugas-modal-header">
            <div>
                <h3 id="tugasModalTitle">Kerjakan Tugas</h3>
                <p id="tugasModalDesc" class="tugas-modal-desc">Lengkapi jawaban tugas di bawah ini.</p>
            </div>
            <button type="button" id="tugasModalClose" class="tugas-modal-close" aria-label="Tutup modal">×</button>
        </div>
        <form id="tugasModalForm" action="<?= base_url('dashboard/peserta/tugas/submit') ?>" method="POST"
            enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="id_tugas" id="modalTugasId">
            <div class="tugas-modal-body">
                <div class="tugas-form-group">
                    <label>Jenis Jawaban</label>
                    <div class="tugas-radio-group">
                        <label class="tugas-radio-item">
                            <input type="radio" name="tipe_jawaban" value="file" checked>
                            Unggah File
                        </label>
                        <label class="tugas-radio-item">
                            <input type="radio" name="tipe_jawaban" value="text">
                            Teks
                        </label>
                    </div>
                </div>

                <div class="tugas-form-group" id="tugasFileGroup">
                    <label for="jawaban_file">Pilih file jawaban</label>
                    <div class="tugas-file-card" id="tugasFileCard">
                        <span>Pilih file atau seret ke sini</span>
                        <div class="tugas-file-name" id="tugasFileName">Tidak ada file dipilih</div>
                    </div>
                    <input type="file" name="jawaban_file" id="jawabanFile" class="tugas-form-input"
                        accept=".pdf,.doc,.docx,.txt" style="display:none;">
                </div>

                <div class="tugas-form-group" id="tugasTextGroup" style="display:none;">
                    <label for="jawaban_text">Jawaban Teks</label>
                    <textarea name="jawaban_text" id="jawabanText" class="tugas-form-textarea"
                        placeholder="Tuliskan jawaban tugas di sini..."></textarea>
                </div>

                <div class="tugas-form-group">
                    <label for="catatan_jawaban">Catatan</label>
                    <textarea name="catatan_jawaban" id="catatanJawaban" class="tugas-form-textarea"
                        placeholder="Opsional: tambahkan catatan atau keterangan"></textarea>
                </div>

                <div class="tugas-btn-group">
                    <button type="button" class="tugas-btn tugas-btn-secondary" id="tugasModalCancel">Batal</button>
                    <button type="submit" class="tugas-btn tugas-btn-primary">Kirim Jawaban</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
const tugasModalOverlay = document.getElementById('tugasModalOverlay');
const tugasModalClose = document.getElementById('tugasModalClose');
const tugasModalCancel = document.getElementById('tugasModalCancel');
const tugasModalTitle = document.getElementById('tugasModalTitle');
const tugasModalDesc = document.getElementById('tugasModalDesc');
const tugasModalForm = document.getElementById('tugasModalForm');
const modalTugasId = document.getElementById('modalTugasId');
const jawabanFile = document.getElementById('jawabanFile');
const tugasFileCard = document.getElementById('tugasFileCard');
const tugasFileName = document.getElementById('tugasFileName');
const tugasTextGroup = document.getElementById('tugasTextGroup');

document.querySelectorAll('.btn-open-tugas-modal').forEach(button => {
    button.addEventListener('click', () => {
        const taskId = button.dataset.taskId;
        const taskTitle = button.dataset.taskTitle || 'Kerjakan Tugas';
        const taskDesc = button.dataset.taskDesc || 'Lengkapi jawaban tugas di bawah ini.';

        tugasModalTitle.innerText = taskTitle;
        tugasModalDesc.innerText = taskDesc;
        modalTugasId.value = taskId;
        tugasModalOverlay.classList.add('active');
    });
});

function closeTugasModal() {
    tugasModalOverlay.classList.remove('active');
}

tugasModalClose.addEventListener('click', closeTugasModal);
tugasModalCancel.addEventListener('click', closeTugasModal);
tugasModalOverlay.addEventListener('click', (event) => {
    if (event.target === tugasModalOverlay) {
        closeTugasModal();
    }
});

document.querySelectorAll('input[name="tipe_jawaban"]').forEach(radio => {
    radio.addEventListener('change', () => {
        if (radio.value === 'file' && radio.checked) {
            tugasFileGroup.style.display = 'block';
            tugasTextGroup.style.display = 'none';
        }
        if (radio.value === 'text' && radio.checked) {
            tugasFileGroup.style.display = 'none';
            tugasTextGroup.style.display = 'block';
        }
    });
});

tugasFileCard.addEventListener('click', () => jawabanFile.click());
jawabanFile.addEventListener('change', () => {
    tugasFileName.textContent = jawabanFile.files.length > 0 ? jawabanFile.files[0].name :
        'Tidak ada file dipilih';
});
</script>

<?= $this->endSection() ?>
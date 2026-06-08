<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>
<?= $this->section('content') ?>

<style>
:root {
    --blue-50: #eff6ff;
    --blue-100: #dbeafe;
    --blue-200: #bfdbfe;
    --blue-500: #3b82f6;
    --blue-600: #2563eb;
    --blue-700: #1d4ed8;
    --blue-900: #1e3a8a;
    --slate-50: #f8fafc;
    --slate-100: #f1f5f9;
    --slate-200: #e2e8f0;
    --slate-300: #cbd5e1;
    --slate-400: #94a3b8;
    --slate-500: #64748b;
    --slate-600: #475569;
    --slate-700: #334155;
    --slate-800: #1e293b;
    --slate-900: #0f172a;
    --red-50: #fef2f2;
    --red-100: #fee2e2;
    --red-200: #fecaca;
    --red-500: #ef4444;
    --red-600: #dc2626;
    --violet-50: #f5f3ff;
    --violet-100: #ede9fe;
    --violet-500: #8b5cf6;
    --violet-600: #7c3aed;
    --green-50: #f0fdf4;
    --green-500: #22c55e;
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;
    --shadow-sm: 0 1px 3px rgba(0, 0, 0, .06), 0 1px 2px rgba(0, 0, 0, .04);
    --shadow-md: 0 4px 12px rgba(0, 0, 0, .07), 0 2px 4px rgba(0, 0, 0, .04);
    --shadow-lg: 0 12px 32px rgba(0, 0, 0, .10), 0 4px 8px rgba(0, 0, 0, .06);
}

/* ── PAGE HEADER ── */
.mt-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 28px;
    flex-wrap: wrap;
}

.mt-header-title {
    font-size: 22px;
    font-weight: 700;
    color: var(--slate-900);
    margin: 0 0 4px;
    letter-spacing: -.3px;
}

.mt-header-sub {
    font-size: 13px;
    color: var(--slate-400);
    margin: 0;
}

.btn-tambah-tugas {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 10px 20px;
    background: var(--blue-600);
    color: #fff;
    border: none;
    border-radius: var(--radius-md);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background .18s, transform .15s, box-shadow .18s;
    box-shadow: 0 2px 8px rgba(37, 99, 235, .3);
    white-space: nowrap;
    flex-shrink: 0;
}

.btn-tambah-tugas:hover {
    background: var(--blue-700);
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(37, 99, 235, .35);
}

.btn-tambah-tugas:active {
    transform: scale(.97);
}

/* ── FLASH ── */
.mt-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: var(--radius-md);
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 20px;
    animation: slideDown .25s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-8px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.mt-alert.success {
    background: var(--green-50);
    color: #166534;
    border: 1px solid #bbf7d0;
}

.mt-alert.danger {
    background: var(--red-50);
    color: #991b1b;
    border: 1px solid var(--red-200);
}

.mt-alert i {
    font-size: 16px;
    flex-shrink: 0;
}

.mt-alert-close {
    margin-left: auto;
    background: none;
    border: none;
    cursor: pointer;
    color: inherit;
    opacity: .5;
    font-size: 16px;
    padding: 0;
    line-height: 1;
}

.mt-alert-close:hover {
    opacity: 1;
}

/* ── FILTER BAR ── */
.mt-filter-bar {
    background: #fff;
    border: 1px solid var(--slate-200);
    border-radius: var(--radius-lg);
    padding: 16px 20px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    box-shadow: var(--shadow-sm);
}

.mt-select {
    padding: 9px 32px 9px 12px;
    border: 1px solid var(--slate-200);
    border-radius: var(--radius-sm);
    font-size: 13px;
    color: var(--slate-700);
    background: var(--slate-50) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E") no-repeat right 10px center;
    -webkit-appearance: none;
    appearance: none;
    cursor: pointer;
    min-width: 160px;
    flex: 1;
    transition: border .18s, box-shadow .18s;
    outline: none;
}

.mt-select:focus {
    border-color: var(--blue-500);
    background-color: #fff;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
}

.mt-total-badge {
    margin-left: auto;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: var(--blue-50);
    color: var(--blue-700);
    border-radius: 99px;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
    flex-shrink: 0;
}

/* ── TABLE CARD ── */
.mt-table-card {
    background: #fff;
    border: 1px solid var(--slate-200);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.mt-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.mt-table thead tr {
    background: var(--slate-50);
    border-bottom: 1px solid var(--slate-200);
}

.mt-table thead th {
    padding: 13px 16px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: var(--slate-400);
    white-space: nowrap;
}

.mt-table thead th:first-child {
    padding-left: 24px;
}

.mt-table tbody tr {
    border-bottom: 1px solid var(--slate-100);
    transition: background .15s;
    animation: rowIn .2s ease both;
}

.mt-table tbody tr:last-child {
    border-bottom: none;
}

.mt-table tbody tr:hover {
    background: var(--slate-50);
}

@keyframes rowIn {
    from {
        opacity: 0;
        transform: translateY(4px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.mt-table tbody tr:nth-child(1) {
    animation-delay: .03s;
}

.mt-table tbody tr:nth-child(2) {
    animation-delay: .06s;
}

.mt-table tbody tr:nth-child(3) {
    animation-delay: .09s;
}

.mt-table tbody tr:nth-child(4) {
    animation-delay: .12s;
}

.mt-table tbody tr:nth-child(5) {
    animation-delay: .15s;
}

.mt-table tbody tr:nth-child(6) {
    animation-delay: .18s;
}

.mt-table tbody tr:nth-child(7) {
    animation-delay: .21s;
}

.mt-table tbody tr:nth-child(8) {
    animation-delay: .24s;
}

.mt-table tbody td {
    padding: 14px 16px;
    color: var(--slate-700);
    vertical-align: middle;
}

.mt-table tbody td:first-child {
    padding-left: 24px;
}

/* Nomor */
.mt-row-num {
    font-size: 12px;
    color: var(--slate-400);
    font-weight: 500;
}

/* Tugas cell */
.mt-tugas-cell {
    display: flex;
    align-items: flex-start;
    gap: 12px;
}

.mt-tugas-icon {
    width: 38px;
    height: 38px;
    border-radius: var(--radius-sm);
    background: var(--violet-50);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
}

.mt-tugas-icon i {
    font-size: 17px;
    color: var(--violet-500);
}

.mt-tugas-name {
    font-weight: 600;
    color: var(--slate-800);
    font-size: 13px;
    margin-bottom: 3px;
}

.mt-tugas-desc {
    font-size: 12px;
    color: var(--slate-400);
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.5;
    max-width: 360px;
}

/* Badges */
.mt-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 3px 9px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.mt-badge.kelas {
    background: var(--slate-100);
    color: var(--slate-600);
    border: 1px solid var(--slate-200);
}

.mt-badge.modul {
    background: var(--blue-50);
    color: var(--blue-700);
    border: 1px solid var(--blue-100);
}

.mt-badge.umum {
    background: var(--violet-50);
    color: var(--violet-600);
    border: 1px solid var(--violet-100);
}

.mt-badge i {
    font-size: 10px;
}

/* Date */
.mt-date {
    font-size: 12px;
    color: var(--slate-400);
    font-weight: 500;
}

/* Actions */
.mt-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.mt-btn-icon {
    width: 32px;
    height: 32px;
    border-radius: var(--radius-sm);
    border: 1px solid;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all .18s;
    font-size: 13px;
    background: transparent;
    text-decoration: none;
}

.mt-btn-icon:active {
    transform: scale(.95);
}

.mt-btn-icon.view {
    border-color: var(--blue-200);
    color: var(--blue-600);
}

.mt-btn-icon.view:hover {
    background: var(--blue-600);
    border-color: var(--blue-600);
    color: #fff;
    transform: scale(1.05);
}

.mt-btn-icon.delete {
    border-color: var(--red-200);
    color: var(--red-500);
}

.mt-btn-icon.delete:hover {
    background: var(--red-500);
    border-color: var(--red-500);
    color: #fff;
    transform: scale(1.05);
}

/* Empty */
.mt-empty {
    text-align: center;
    padding: 56px 20px;
}

.mt-empty-icon {
    width: 64px;
    height: 64px;
    background: var(--slate-100);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
}

.mt-empty-icon i {
    font-size: 26px;
    color: var(--slate-300);
}

.mt-empty-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--slate-600);
    margin-bottom: 4px;
}

.mt-empty-sub {
    font-size: 13px;
    color: var(--slate-400);
}

/* ── MODAL ── */
.mt-modal .modal-content {
    border: none;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
    overflow: hidden;
}

.mt-modal .modal-header-custom {
    padding: 20px 24px 0;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
}

.mt-modal-icon {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 18px;
    background: var(--blue-50);
    color: var(--blue-600);
}

.mt-modal-title-wrap h5 {
    font-size: 15px;
    font-weight: 700;
    color: var(--slate-900);
    margin: 0 0 2px;
}

.mt-modal-title-wrap p {
    font-size: 12px;
    color: var(--slate-400);
    margin: 0;
}

.mt-modal-close {
    width: 30px;
    height: 30px;
    border: none;
    background: var(--slate-100);
    border-radius: 99px;
    color: var(--slate-500);
    cursor: pointer;
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: auto;
    flex-shrink: 0;
    transition: background .18s, color .18s;
}

.mt-modal-close:hover {
    background: var(--slate-200);
    color: var(--slate-700);
}

.mt-modal .modal-body {
    padding: 20px 24px;
}

/* Form */
.mt-form-group {
    margin-bottom: 16px;
}

.mt-form-group:last-of-type {
    margin-bottom: 0;
}

.mt-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: var(--slate-600);
    margin-bottom: 6px;
    letter-spacing: .02em;
    text-transform: uppercase;
}

.mt-label .req {
    color: var(--red-500);
    margin-left: 2px;
}

.mt-input,
.mt-select-field,
.mt-textarea {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid var(--slate-200);
    border-radius: var(--radius-sm);
    font-size: 13px;
    color: var(--slate-800);
    background: var(--slate-50);
    transition: border .18s, box-shadow .18s, background .18s;
    outline: none;
    font-family: inherit;
}

.mt-input:focus,
.mt-select-field:focus,
.mt-textarea:focus {
    border-color: var(--blue-500);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
}

.mt-input::placeholder,
.mt-textarea::placeholder {
    color: var(--slate-300);
}

.mt-textarea {
    resize: vertical;
    min-height: 100px;
    line-height: 1.6;
}

.mt-select-field {
    -webkit-appearance: none;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-color: var(--slate-50);
    padding-right: 36px;
    cursor: pointer;
}

.mt-form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
}

@media (max-width: 560px) {
    .mt-form-row {
        grid-template-columns: 1fr;
    }
}

/* Modal footer */
.mt-modal-footer {
    padding: 16px 24px 20px;
    border-top: 1px solid var(--slate-100);
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}

.mt-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 9px 20px;
    border-radius: var(--radius-sm);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    border: 1px solid;
    transition: all .18s;
    outline: none;
}

.mt-btn:active {
    transform: scale(.97);
}

.mt-btn.cancel {
    background: var(--slate-50);
    border-color: var(--slate-200);
    color: var(--slate-600);
}

.mt-btn.cancel:hover {
    background: var(--slate-100);
    color: var(--slate-800);
}

.mt-btn.primary {
    background: var(--blue-600);
    border-color: var(--blue-600);
    color: #fff;
    box-shadow: 0 2px 6px rgba(37, 99, 235, .25);
}

.mt-btn.primary:hover {
    background: var(--blue-700);
    border-color: var(--blue-700);
}

/* Modal hapus confirm via SweetAlert — tombol hapus tabel */
.btn-hapus-tugas-form {
    display: none;
}

/* Responsive */
@media (max-width: 640px) {
    .mt-filter-bar {
        gap: 8px;
    }

    .mt-select {
        min-width: 0;
    }

    .mt-total-badge {
        margin-left: 0;
    }

    .mt-tugas-desc {
        display: none;
    }

    .mt-table thead th:nth-child(4),
    .mt-table tbody td:nth-child(4) {
        display: none;
    }
}
</style>

<!-- ══ PAGE HEADER ══ -->
<div class="mt-header">
    <div>
        <h1 class="mt-header-title">Manajemen Tugas</h1>
        <p class="mt-header-sub">Tambahkan tugas kelas per modul dan lacak pengumpulan peserta</p>
    </div>
    <button class="btn-tambah-tugas" data-bs-toggle="modal" data-bs-target="#modalTambahTugas">
        <i class="bi bi-plus-lg"></i> Tambah Tugas
    </button>
</div>

<!-- ══ FLASH ══ -->
<?php if (session()->getFlashdata('success')): ?>
<div class="mt-alert success">
    <i class="bi bi-check-circle-fill"></i>
    <?= session()->getFlashdata('success') ?>
    <button class="mt-alert-close" onclick="this.closest('.mt-alert').remove()"><i class="bi bi-x"></i></button>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="mt-alert danger">
    <i class="bi bi-exclamation-circle-fill"></i>
    <?= session()->getFlashdata('error') ?>
    <button class="mt-alert-close" onclick="this.closest('.mt-alert').remove()"><i class="bi bi-x"></i></button>
</div>
<?php endif; ?>

<!-- ══ FILTER BAR ══ -->
<div class="mt-filter-bar">
    <select class="mt-select" id="filterProgram">
        <option value="">Semua Program</option>
        <?php foreach ($program as $p): ?>
        <option value="<?= $p['id_program'] ?>"><?= esc($p['nama_program']) ?></option>
        <?php endforeach; ?>
    </select>

    <select class="mt-select" id="filterKelas">
        <option value="">Semua Kelas</option>
        <?php foreach ($kelas as $k): ?>
        <option value="<?= $k['id_kelas'] ?>" data-program="<?= $k['id_program'] ?>">
            <?= esc($k['nama_kelas']) ?>
        </option>
        <?php endforeach; ?>
    </select>

    <select class="mt-select" id="filterModul">
        <option value="">S emua Modul</option>
        <?php foreach ($modul as $m): ?>
        <option value="<?= $m['id_modul'] ?>" data-kelas="<?= $m['id_kelas'] ?>">
            <?= esc($m['judul_modul']) ?>
        </option>
        <?php endforeach; ?>
    </select>

    <div class="mt-total-badge">
        <i class="bi bi-clipboard-check" style="font-size:12px;"></i>
        <span id="totalTugas"><?= count($tugas) ?></span> tugas
    </div>
</div>

<!-- ══ TABLE CARD ══ -->
<div class="mt-table-card">
    <div style="overflow-x:auto;">
        <table class="mt-table" id="tabelTugas">
            <thead>
                <tr>
                    <th style="width:48px;">#</th>
                    <th>Judul Tugas</th>
                    <th>Kelas / Modul</th>
                    <th style="width:110px;">Dibuat</th>
                    <th style="width:110px;text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($tugas)): ?>
                <?php foreach ($tugas as $i => $task): ?>
                <tr data-kelas="<?= $task['id_kelas'] ?>" data-modul="<?= $task['id_modul'] ?>">
                    <td><span class="mt-row-num"><?= $i + 1 ?></span></td>
                    <td>
                        <div class="mt-tugas-cell">
                            <div class="mt-tugas-icon">
                                <i class="bi bi-clipboard2-text-fill"></i>
                            </div>
                            <div>
                                <div class="mt-tugas-name"><?= esc($task['judul_tugas']) ?></div>
                                <div class="mt-tugas-desc"><?= esc($task['deskripsi_tugas']) ?></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="display:flex;flex-wrap:wrap;gap:5px;">
                            <span class="mt-badge kelas">
                                <i class="bi bi-mortarboard-fill"></i>
                                <?= esc($task['nama_kelas']) ?>
                            </span>
                            <?php if ($task['judul_modul']): ?>
                            <span class="mt-badge modul">
                                <i class="bi bi-collection-fill"></i>
                                <?= esc($task['judul_modul']) ?>
                            </span>
                            <?php else: ?>
                            <span class="mt-badge umum">
                                <i class="bi bi-globe2"></i>
                                Kelas Umum
                            </span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <span class="mt-date">
                            <i class="bi bi-calendar3" style="font-size:11px;margin-right:4px;"></i>
                            <?= date('d M Y', strtotime($task['created_at'])) ?>
                        </span>
                    </td>
                    <td>
                        <div class="mt-actions">
                            <a href="<?= base_url('dashboard/pengajar/tugas/pengumpulan/' . $task['id_tugas']) ?>"
                                class="mt-btn-icon view" title="Lihat Pengumpulan">
                                <i class="bi bi-people-fill"></i>
                            </a>
                            <button type="button" class="mt-btn-icon delete btn-confirm-hapus" title="Hapus Tugas"
                                data-id="<?= $task['id_tugas'] ?>" data-judul="<?= esc($task['judul_tugas']) ?>">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                            <!-- Hidden form untuk submit hapus -->
                            <form class="btn-hapus-tugas-form" id="formHapus_<?= $task['id_tugas'] ?>"
                                action="<?= base_url('dashboard/pengajar/tugas/delete/' . $task['id_tugas']) ?>"
                                method="POST">
                                <?= csrf_field() ?>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr id="emptyRow">
                    <td colspan="5">
                        <div class="mt-empty">
                            <div class="mt-empty-icon">
                                <i class="bi bi-clipboard-x"></i>
                            </div>
                            <div class="mt-empty-title">Belum ada tugas</div>
                            <div class="mt-empty-sub">Klik tombol <strong>Tambah Tugas</strong> untuk memulai</div>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- ══════════════════════════════════════════
     MODAL TAMBAH TUGAS
══════════════════════════════════════════ -->
<div class="modal fade mt-modal" id="modalTambahTugas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header-custom">
                <div class="mt-modal-icon">
                    <i class="bi bi-plus-circle-fill"></i>
                </div>
                <div class="mt-modal-title-wrap" style="margin-left:12px;">
                    <h5>Tambah Tugas Baru</h5>
                    <p>Isi detail tugas untuk peserta kelas</p>
                </div>
                <button class="mt-modal-close" data-bs-dismiss="modal">
                    <i class="bi bi-x"></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="<?= base_url('dashboard/pengajar/tugas/store') ?>" method="POST" id="formTambahTugas">
                    <?= csrf_field() ?>

                    <div class="mt-form-row" style="margin-bottom:16px;">
                        <div>
                            <label class="mt-label">Kelas <span class="req">*</span></label>
                            <select class="mt-select-field" name="id_kelas" id="modal_kelas" required>
                                <option value="" disabled selected>— Pilih Kelas —</option>
                                <?php foreach ($kelas as $k): ?>
                                <option value="<?= $k['id_kelas'] ?>"
                                    <?= old('id_kelas') == $k['id_kelas'] ? 'selected' : '' ?>>
                                    <?= esc($k['nama_kelas']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <label class="mt-label">Modul <span
                                    style="color:var(--slate-400);font-weight:400;text-transform:none;font-size:11px;">(opsional)</span></label>
                            <select class="mt-select-field" name="id_modul" id="modal_modul">
                                <option value="">— Pilih Kelas dulu —</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-form-group">
                        <label class="mt-label">Judul Tugas <span class="req">*</span></label>
                        <input type="text" class="mt-input" name="judul_tugas" value="<?= old('judul_tugas') ?>"
                            placeholder="cth: Buat laporan analisis SWOT produk" required>
                    </div>

                    <div class="mt-form-group">
                        <label class="mt-label">Deskripsi Tugas <span class="req">*</span></label>
                        <textarea class="mt-textarea" name="deskripsi_tugas"
                            placeholder="Jelaskan instruksi tugas secara detail..."
                            required><?= old('deskripsi_tugas') ?></textarea>
                    </div>

                </form>
            </div>

            <div class="mt-modal-footer">
                <button type="button" class="mt-btn cancel" data-bs-dismiss="modal">Batal</button>
                <button type="submit" form="formTambahTugas" class="mt-btn primary">
                    <i class="bi bi-save"></i> Simpan Tugas
                </button>
            </div>

        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {

    /* ── Filter ── */
    const filterProgram = document.getElementById('filterProgram');
    const filterKelas = document.getElementById('filterKelas');
    const filterModul = document.getElementById('filterModul');
    const totalEl = document.getElementById('totalTugas');

    filterProgram?.addEventListener('change', () => {
        const prog = filterProgram.value;
        filterKelas.querySelectorAll('option[data-program]').forEach(opt => {
            opt.hidden = prog && opt.dataset.program !== prog;
        });
        filterKelas.value = '';
        filterModul.value = '';
        updateTugasFilter();
    });

    filterKelas?.addEventListener('change', () => {
        const kel = filterKelas.value;
        filterModul.querySelectorAll('option[data-kelas]').forEach(opt => {
            opt.hidden = kel && opt.dataset.kelas !== kel;
        });
        filterModul.value = '';
        updateTugasFilter();
    });

    filterModul?.addEventListener('change', updateTugasFilter);

    function updateTugasFilter() {
        const kel = filterKelas.value;
        const mod = filterModul.value;
        let visible = 0;
        document.querySelectorAll('#tabelTugas tbody tr:not(#emptyRow)').forEach(row => {
            let show = true;
            if (kel && row.dataset.kelas !== kel) show = false;
            if (mod && row.dataset.modul !== mod) show = false;
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });
        totalEl.textContent = visible;
    }

    /* ── Cascade kelas → modul di modal tambah ── */
    const modalKelas = document.getElementById('modal_kelas');
    const modalModul = document.getElementById('modal_modul');
    const allModul = <?= json_encode(array_map(fn($m) => [
        'id'    => $m['id_modul'],
        'judul' => $m['judul_modul'],
        'kelas' => $m['id_kelas'],
    ], $modul), JSON_UNESCAPED_UNICODE) ?>;

    modalKelas?.addEventListener('change', function() {
        const idKelas = this.value;
        modalModul.innerHTML = '<option value="">— Tidak terikat modul —</option>';
        allModul.filter(m => m.kelas == idKelas).forEach(m => {
            const opt = document.createElement('option');
            opt.value = m.id;
            opt.textContent = m.judul;
            modalModul.appendChild(opt);
        });
        modalModul.disabled = false;
    });

    /* ── Konfirmasi hapus pakai SweetAlert ── */
    document.querySelectorAll('.btn-confirm-hapus').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const judul = this.dataset.judul;
            Swal.fire({
                title: 'Hapus Tugas?',
                html: `Tugas <strong>${judul}</strong> akan dihapus permanen.`,
                icon: 'warning',
                iconColor: '#ef4444',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#f1f5f9',
                customClass: {
                    cancelButton: 'swal-cancel-btn',
                    popup: 'swal-rounded',
                },
                reverseButtons: true,
            }).then(result => {
                if (result.isConfirmed) {
                    document.getElementById('formHapus_' + id).submit();
                }
            });
        });
    });

});
</script>

<style>
.swal-rounded {
    border-radius: 16px !important;
}

.swal-cancel-btn {
    color: #475569 !important;
}
</style>

<?= $this->endSection() ?>
<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>
<?= $this->section('content') ?>

<style>
/* ══════════════════════════════════════════
   DESIGN TOKENS
══════════════════════════════════════════ */
:root {
    --blue-50: #eff6ff;
    --blue-100: #dbeafe;
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
    --red-500: #ef4444;
    --red-600: #dc2626;
    --amber-50: #fffbeb;
    --amber-100: #fef3c7;
    --amber-500: #f59e0b;
    --amber-600: #d97706;
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

/* ══════════════════════════════════════════
   PAGE HEADER
══════════════════════════════════════════ */
.mm-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 28px;
    flex-wrap: wrap;
}

.mm-header-title {
    font-size: 22px;
    font-weight: 700;
    color: var(--slate-900);
    margin: 0 0 4px;
    letter-spacing: -.3px;
}

.mm-header-sub {
    font-size: 13px;
    color: var(--slate-400);
    margin: 0;
}

.btn-tambah {
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

.btn-tambah:hover {
    background: var(--blue-700);
    transform: translateY(-1px);
    box-shadow: 0 4px 14px rgba(37, 99, 235, .35);
}

.btn-tambah:active {
    transform: scale(.97);
}

.btn-tambah i {
    font-size: 15px;
}

/* ══════════════════════════════════════════
   FLASH ALERTS
══════════════════════════════════════════ */
.mm-alert {
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

.mm-alert.success {
    background: var(--green-50);
    color: #166534;
    border: 1px solid #bbf7d0;
}

.mm-alert.danger {
    background: var(--red-50);
    color: #991b1b;
    border: 1px solid #fecaca;
}

.mm-alert i {
    font-size: 16px;
    flex-shrink: 0;
}

.mm-alert-close {
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

.mm-alert-close:hover {
    opacity: 1;
}

/* ══════════════════════════════════════════
   FILTER BAR
══════════════════════════════════════════ */
.mm-filter-bar {
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

.mm-search-wrap {
    position: relative;
    flex: 1;
    min-width: 180px;
}

.mm-search-wrap i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--slate-400);
    font-size: 14px;
    pointer-events: none;
}

.mm-search-wrap input {
    width: 100%;
    padding: 9px 12px 9px 36px;
    border: 1px solid var(--slate-200);
    border-radius: var(--radius-sm);
    font-size: 13px;
    color: var(--slate-800);
    background: var(--slate-50);
    transition: border .18s, box-shadow .18s;
    outline: none;
}

.mm-search-wrap input:focus {
    border-color: var(--blue-500);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
}

.mm-search-wrap input::placeholder {
    color: var(--slate-400);
}

.mm-select {
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
    transition: border .18s, box-shadow .18s;
    outline: none;
}

.mm-select:focus {
    border-color: var(--blue-500);
    background-color: #fff;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
}

.mm-total-badge {
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

/* ══════════════════════════════════════════
   TABLE CARD
══════════════════════════════════════════ */
.mm-table-card {
    background: #fff;
    border: 1px solid var(--slate-200);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
    overflow: hidden;
}

.mm-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.mm-table thead tr {
    background: var(--slate-50);
    border-bottom: 1px solid var(--slate-200);
}

.mm-table thead th {
    padding: 13px 16px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .06em;
    text-transform: uppercase;
    color: var(--slate-400);
    white-space: nowrap;
}

.mm-table thead th:first-child {
    padding-left: 24px;
}

.mm-table tbody tr {
    border-bottom: 1px solid var(--slate-100);
    transition: background .15s;
}

.mm-table tbody tr:last-child {
    border-bottom: none;
}

.mm-table tbody tr:hover {
    background: var(--slate-50);
}

.mm-table tbody td {
    padding: 14px 16px;
    color: var(--slate-700);
    vertical-align: middle;
}

.mm-table tbody td:first-child {
    padding-left: 24px;
}

/* Nomor urut */
.mm-row-num {
    font-size: 12px;
    color: var(--slate-400);
    font-weight: 500;
}

/* Modul cell */
.mm-modul-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}

.mm-modul-icon {
    width: 38px;
    height: 38px;
    border-radius: var(--radius-sm);
    background: var(--blue-50);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.mm-modul-icon i {
    font-size: 17px;
    color: var(--blue-600);
}

.mm-modul-name {
    font-weight: 600;
    color: var(--slate-800);
    font-size: 13px;
}

/* Kelas badge */
.mm-kelas-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    background: var(--blue-50);
    color: var(--blue-700);
    border-radius: 99px;
    font-size: 11px;
    font-weight: 600;
    border: 1px solid var(--blue-100);
}

.mm-kelas-badge i {
    font-size: 11px;
}

/* Urutan badge */
.mm-urutan-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    background: var(--slate-100);
    color: var(--slate-600);
    border-radius: 99px;
    font-size: 12px;
    font-weight: 700;
}

/* Materi count */
.mm-materi-count {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    color: var(--slate-500);
    font-size: 12px;
    font-weight: 500;
}

.mm-materi-count i {
    font-size: 13px;
    color: var(--slate-400);
}

/* Action buttons */
.mm-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
}

.mm-btn-icon {
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
}

.mm-btn-icon.edit {
    border-color: var(--blue-200);
    color: var(--blue-600);
}

.mm-btn-icon.edit:hover {
    background: var(--blue-600);
    border-color: var(--blue-600);
    color: #fff;
    transform: scale(1.05);
}

.mm-btn-icon.delete {
    border-color: #fecaca;
    color: var(--red-500);
}

.mm-btn-icon.delete:hover {
    background: var(--red-500);
    border-color: var(--red-500);
    color: #fff;
    transform: scale(1.05);
}

/* Empty state */
.mm-empty {
    text-align: center;
    padding: 56px 20px;
}

.mm-empty-icon {
    width: 64px;
    height: 64px;
    background: var(--slate-100);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
}

.mm-empty-icon i {
    font-size: 26px;
    color: var(--slate-300);
}

.mm-empty-title {
    font-size: 14px;
    font-weight: 600;
    color: var(--slate-600);
    margin-bottom: 4px;
}

.mm-empty-sub {
    font-size: 13px;
    color: var(--slate-400);
}

/* ══════════════════════════════════════════
   MODAL BASE
══════════════════════════════════════════ */
.mm-modal .modal-content {
    border: none;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
    overflow: hidden;
}

.mm-modal .modal-header-custom {
    padding: 20px 24px 0;
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
}

.mm-modal-icon {
    width: 40px;
    height: 40px;
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 18px;
}

.mm-modal-icon.blue {
    background: var(--blue-50);
    color: var(--blue-600);
}

.mm-modal-icon.yellow {
    background: var(--amber-50);
    color: var(--amber-600);
}

.mm-modal-icon.red {
    background: var(--red-50);
    color: var(--red-500);
}

.mm-modal-title-wrap h5 {
    font-size: 15px;
    font-weight: 700;
    color: var(--slate-900);
    margin: 0 0 2px;
}

.mm-modal-title-wrap p {
    font-size: 12px;
    color: var(--slate-400);
    margin: 0;
}

.mm-modal-close {
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

.mm-modal-close:hover {
    background: var(--slate-200);
    color: var(--slate-700);
}

.mm-modal .modal-body {
    padding: 20px 24px;
}

/* Form elements */
.mm-form-group {
    margin-bottom: 16px;
}

.mm-form-group:last-of-type {
    margin-bottom: 0;
}

.mm-label {
    display: block;
    font-size: 12px;
    font-weight: 600;
    color: var(--slate-600);
    margin-bottom: 6px;
    letter-spacing: .02em;
    text-transform: uppercase;
}

.mm-label .req {
    color: var(--red-500);
    margin-left: 2px;
}

.mm-input,
.mm-select-field {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid var(--slate-200);
    border-radius: var(--radius-sm);
    font-size: 13px;
    color: var(--slate-800);
    background: var(--slate-50);
    transition: border .18s, box-shadow .18s, background .18s;
    outline: none;
}

.mm-input:focus,
.mm-select-field:focus {
    border-color: var(--blue-500);
    background: #fff;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, .12);
}

.mm-input::placeholder {
    color: var(--slate-300);
}

.mm-select-field {
    -webkit-appearance: none;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-color: var(--slate-50);
    padding-right: 36px;
    cursor: pointer;
}

.mm-select-field:disabled {
    opacity: .55;
    cursor: not-allowed;
}

.mm-form-hint {
    font-size: 11px;
    color: var(--slate-400);
    margin-top: 4px;
}

.mm-loading-text {
    font-size: 11px;
    color: var(--slate-400);
    display: none;
    align-items: center;
    gap: 6px;
    margin-top: 5px;
}

.mm-loading-text.show {
    display: flex;
}

.mm-spinner-sm {
    width: 12px;
    height: 12px;
    border: 2px solid var(--slate-200);
    border-top-color: var(--blue-500);
    border-radius: 50%;
    animation: spin .6s linear infinite;
    flex-shrink: 0;
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

/* Modal footer */
.mm-modal-footer {
    padding: 16px 24px 20px;
    border-top: 1px solid var(--slate-100);
    display: flex;
    justify-content: flex-end;
    gap: 8px;
}

.mm-btn {
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

.mm-btn:active {
    transform: scale(.97);
}

.mm-btn.cancel {
    background: var(--slate-50);
    border-color: var(--slate-200);
    color: var(--slate-600);
}

.mm-btn.cancel:hover {
    background: var(--slate-100);
    color: var(--slate-800);
}

.mm-btn.primary {
    background: var(--blue-600);
    border-color: var(--blue-600);
    color: #fff;
    box-shadow: 0 2px 6px rgba(37, 99, 235, .25);
}

.mm-btn.primary:hover {
    background: var(--blue-700);
    border-color: var(--blue-700);
}

.mm-btn.warning {
    background: var(--amber-500);
    border-color: var(--amber-500);
    color: #fff;
    box-shadow: 0 2px 6px rgba(245, 158, 11, .25);
}

.mm-btn.warning:hover {
    background: var(--amber-600);
    border-color: var(--amber-600);
}

.mm-btn.danger {
    background: var(--red-500);
    border-color: var(--red-500);
    color: #fff;
    box-shadow: 0 2px 6px rgba(239, 68, 68, .25);
}

.mm-btn.danger:hover {
    background: var(--red-600);
    border-color: var(--red-600);
}

/* Modal hapus khusus */
.mm-hapus-body {
    text-align: center;
    padding: 28px 24px 20px;
}

.mm-hapus-icon-wrap {
    width: 68px;
    height: 68px;
    background: var(--red-50);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 16px;
    border: 4px solid var(--red-100);
}

.mm-hapus-icon-wrap i {
    font-size: 28px;
    color: var(--red-500);
}

.mm-hapus-title {
    font-size: 16px;
    font-weight: 700;
    color: var(--slate-900);
    margin-bottom: 6px;
}

.mm-hapus-sub {
    font-size: 13px;
    color: var(--slate-500);
    line-height: 1.5;
    margin-bottom: 24px;
}

.mm-hapus-sub strong {
    color: var(--slate-800);
    font-weight: 600;
}

/* ══════════════════════════════════════════
   RESPONSIVE
══════════════════════════════════════════ */
@media (max-width: 640px) {
    .mm-filter-bar {
        gap: 8px;
    }

    .mm-search-wrap {
        min-width: 100%;
    }

    .mm-select {
        min-width: 0;
        flex: 1;
    }

    .mm-total-badge {
        margin-left: 0;
    }

    .mm-table thead th:nth-child(4),
    .mm-table tbody td:nth-child(4) {
        display: none;
    }

    .mm-table-card {
        border-radius: var(--radius-md);
    }
}

/* ══════════════════════════════════════════
   ROW ENTER ANIMATION
══════════════════════════════════════════ */
.mm-table tbody tr {
    animation: rowIn .2s ease both;
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

.mm-table tbody tr:nth-child(1) {
    animation-delay: .03s;
}

.mm-table tbody tr:nth-child(2) {
    animation-delay: .06s;
}

.mm-table tbody tr:nth-child(3) {
    animation-delay: .09s;
}

.mm-table tbody tr:nth-child(4) {
    animation-delay: .12s;
}

.mm-table tbody tr:nth-child(5) {
    animation-delay: .15s;
}

.mm-table tbody tr:nth-child(6) {
    animation-delay: .18s;
}

.mm-table tbody tr:nth-child(7) {
    animation-delay: .21s;
}

.mm-table tbody tr:nth-child(8) {
    animation-delay: .24s;
}
</style>

<!-- ══ PAGE HEADER ══ -->
<div class="mm-header">
    <div>
        <h1 class="mm-header-title">Manajemen Modul</h1>
        <p class="mm-header-sub">Kelola modul pembelajaran untuk setiap kelas</p>
    </div>
    <button class="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambahModul">
        <i class="bi bi-plus-lg"></i> Tambah Modul
    </button>
</div>

<!-- ══ FLASH ALERTS ══ -->
<?php if (session()->getFlashdata('success')): ?>
<div class="mm-alert success">
    <i class="bi bi-check-circle-fill"></i>
    <?= session()->getFlashdata('success') ?>
    <button class="mm-alert-close" onclick="this.closest('.mm-alert').remove()">
        <i class="bi bi-x"></i>
    </button>
</div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<div class="mm-alert danger">
    <i class="bi bi-exclamation-circle-fill"></i>
    <?= session()->getFlashdata('error') ?>
    <button class="mm-alert-close" onclick="this.closest('.mm-alert').remove()">
        <i class="bi bi-x"></i>
    </button>
</div>
<?php endif; ?>

<!-- ══ FILTER BAR ══ -->
<div class="mm-filter-bar">
    <div class="mm-search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="searchModul" placeholder="Cari judul modul...">
    </div>

    <select class="mm-select" id="filterProgram">
        <option value="">Semua Program</option>
        <?php if (!empty($program)): ?>
        <?php foreach ($program as $p): ?>
        <option value="<?= $p['id_program'] ?>"><?= esc($p['nama_program']) ?></option>
        <?php endforeach; ?>
        <?php endif; ?>
    </select>

    <select class="mm-select" id="filterKelas">
        <option value="">Semua Kelas</option>
        <?php if (!empty($kelas)): ?>
        <?php foreach ($kelas as $k): ?>
        <option value="<?= $k['id_kelas'] ?>" data-program="<?= $k['id_program'] ?>">
            <?= esc($k['nama_kelas']) ?>
        </option>
        <?php endforeach; ?>
        <?php endif; ?>
    </select>

    <div class="mm-total-badge">
        <i class="bi bi-collection" style="font-size:12px;"></i>
        <span id="totalModul"><?= count($modul ?? []) ?></span> modul
    </div>
</div>

<!-- ══ TABLE CARD ══ -->
<div class="mm-table-card">
    <div style="overflow-x:auto;">
        <table class="mm-table" id="tabelModul">
            <thead>
                <tr>
                    <th style="width:48px;">#</th>
                    <th>Judul Modul</th>
                    <th>Kelas</th>
                    <th style="width:90px;text-align:center;">Urutan</th>
                    <th style="width:130px;text-align:center;">Materi</th>
                    <th style="width:110px;text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($modul)): ?>
                <?php foreach ($modul as $i => $m): ?>
                <tr data-kelas="<?= $m['id_kelas'] ?>" data-program="<?= $m['id_program'] ?? '' ?>">
                    <td><span class="mm-row-num"><?= $i + 1 ?></span></td>
                    <td>
                        <div class="mm-modul-cell">
                            <div class="mm-modul-icon">
                                <i class="bi bi-collection-fill"></i>
                            </div>
                            <span class="mm-modul-name"><?= esc($m['judul_modul']) ?></span>
                        </div>
                    </td>
                    <td>
                        <span class="mm-kelas-badge">
                            <i class="bi bi-mortarboard-fill"></i>
                            <?= esc($m['nama_kelas']) ?>
                        </span>
                    </td>
                    <td style="text-align:center;">
                        <span class="mm-urutan-badge"><?= $m['urutan_modul'] ?? '-' ?></span>
                    </td>
                    <td style="text-align:center;">
                        <span class="mm-materi-count">
                            <i class="bi bi-file-earmark-text"></i>
                            <?= $m['total_materi'] ?? 0 ?> materi
                        </span>
                    </td>
                    <td>
                        <div class="mm-actions">
                            <button class="mm-btn-icon edit btn-edit-modul" title="Edit Modul"
                                data-id="<?= $m['id_modul'] ?>" data-judul="<?= esc($m['judul_modul']) ?>"
                                data-kelas="<?= $m['id_kelas'] ?>" data-program="<?= $m['id_program'] ?? '' ?>"
                                data-urutan="<?= $m['urutan_modul'] ?? '' ?>">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                            <button class="mm-btn-icon delete btn-delete-modul" title="Hapus Modul"
                                data-id="<?= $m['id_modul'] ?>" data-judul="<?= esc($m['judul_modul']) ?>">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr id="emptyRow">
                    <td colspan="6">
                        <div class="mm-empty">
                            <div class="mm-empty-icon">
                                <i class="bi bi-collection"></i>
                            </div>
                            <div class="mm-empty-title">Belum ada modul</div>
                            <div class="mm-empty-sub">Klik tombol <strong>Tambah Modul</strong> untuk memulai</div>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- ══════════════════════════════════════════
     MODAL TAMBAH
══════════════════════════════════════════ -->
<div class="modal fade mm-modal" id="modalTambahModul" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header-custom">
                <div class="mm-modal-icon blue">
                    <i class="bi bi-plus-circle-fill"></i>
                </div>
                <div class="mm-modal-title-wrap" style="margin-left:12px;">
                    <h5>Tambah Modul Baru</h5>
                    <p>Isi detail modul pembelajaran</p>
                </div>
                <button class="mm-modal-close" data-bs-dismiss="modal">
                    <i class="bi bi-x"></i>
                </button>
            </div>

            <div class="modal-body">
                <form action="<?= base_url('dashboard/pengajar/modul/store') ?>" method="POST" id="formTambahModul">
                    <?= csrf_field() ?>

                    <div class="mm-form-group">
                        <label class="mm-label">Program <span class="req">*</span></label>
                        <select class="mm-select-field" id="tambah_program" required>
                            <option value="" disabled selected>— Pilih Program —</option>
                            <?php if (!empty($program)): ?>
                            <?php foreach ($program as $p): ?>
                            <option value="<?= $p['id_program'] ?>"><?= esc($p['nama_program']) ?></option>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mm-form-group">
                        <label class="mm-label">Kelas <span class="req">*</span></label>
                        <select class="mm-select-field" name="id_kelas" id="tambah_kelas" required disabled>
                            <option value="" disabled selected>— Pilih Program dulu —</option>
                        </select>
                        <div class="mm-loading-text" id="loadingTambahKelas">
                            <div class="mm-spinner-sm"></div> Memuat kelas...
                        </div>
                    </div>

                    <div class="mm-form-group">
                        <label class="mm-label">Judul Modul <span class="req">*</span></label>
                        <input type="text" class="mm-input" name="judul_modul"
                            placeholder="cth: Pengenalan Komponen Elektronika" required>
                    </div>

                    <div class="mm-form-group">
                        <label class="mm-label">Urutan Modul</label>
                        <input type="number" class="mm-input" name="urutan_modul" placeholder="cth: 1" min="1">
                        <div class="mm-form-hint">Urutan tampil modul dalam kelas</div>
                    </div>
                </form>
            </div>

            <div class="mm-modal-footer">
                <button type="button" class="mm-btn cancel" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="submit" form="formTambahModul" class="mm-btn primary">
                    <i class="bi bi-save"></i> Simpan Modul
                </button>
            </div>

        </div>
    </div>
</div>


<!-- ══════════════════════════════════════════
     MODAL EDIT
══════════════════════════════════════════ -->
<div class="modal fade mm-modal" id="modalEditModul" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header-custom">
                <div class="mm-modal-icon yellow">
                    <i class="bi bi-pencil-square"></i>
                </div>
                <div class="mm-modal-title-wrap" style="margin-left:12px;">
                    <h5>Edit Modul</h5>
                    <p>Perbarui detail modul pembelajaran</p>
                </div>
                <button class="mm-modal-close" data-bs-dismiss="modal">
                    <i class="bi bi-x"></i>
                </button>
            </div>

            <div class="modal-body">
                <form id="formEditModul" method="POST">
                    <?= csrf_field() ?>

                    <div class="mm-form-group">
                        <label class="mm-label">Program <span class="req">*</span></label>
                        <select class="mm-select-field" id="edit_program">
                            <option value="" disabled>— Pilih Program —</option>
                            <?php if (!empty($program)): ?>
                            <?php foreach ($program as $p): ?>
                            <option value="<?= $p['id_program'] ?>"><?= esc($p['nama_program']) ?></option>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mm-form-group">
                        <label class="mm-label">Kelas <span class="req">*</span></label>
                        <select class="mm-select-field" name="id_kelas" id="edit_id_kelas" required disabled>
                            <option value="" disabled>— Pilih Program dulu —</option>
                        </select>
                        <div class="mm-loading-text" id="loadingEditKelas">
                            <div class="mm-spinner-sm"></div> Memuat kelas...
                        </div>
                    </div>

                    <div class="mm-form-group">
                        <label class="mm-label">Judul Modul <span class="req">*</span></label>
                        <input type="text" class="mm-input" name="judul_modul" id="edit_judul_modul" required>
                    </div>

                    <div class="mm-form-group">
                        <label class="mm-label">Urutan Modul</label>
                        <input type="number" class="mm-input" name="urutan_modul" id="edit_urutan_modul" min="1">
                        <div class="mm-form-hint">Urutan tampil modul dalam kelas</div>
                    </div>
                </form>
            </div>

            <div class="mm-modal-footer">
                <button type="button" class="mm-btn cancel" data-bs-dismiss="modal">
                    Batal
                </button>
                <button type="submit" form="formEditModul" class="mm-btn warning">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
            </div>

        </div>
    </div>
</div>


<!-- ══════════════════════════════════════════
     MODAL HAPUS
══════════════════════════════════════════ -->
<div class="modal fade mm-modal" id="modalHapusModul" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="mm-hapus-body">
                <div class="mm-hapus-icon-wrap">
                    <i class="bi bi-trash-fill"></i>
                </div>
                <div class="mm-hapus-title">Hapus Modul?</div>
                <p class="mm-hapus-sub">
                    Modul <strong id="hapusJudulModul"></strong> akan dihapus secara permanen dan tidak dapat
                    dikembalikan.
                </p>
                <form id="formHapusModul" method="POST">
                    <?= csrf_field() ?>
                    <div style="display:flex;gap:10px;justify-content:center;">
                        <button type="button" class="mm-btn cancel" data-bs-dismiss="modal" style="padding:9px 24px;">
                            Batal
                        </button>
                        <button type="submit" class="mm-btn danger" style="padding:9px 24px;">
                            <i class="bi bi-trash"></i> Ya, Hapus
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
function loadKelasByProgram(idProgram, selectEl, loadingEl, selectedId = null) {
    selectEl.innerHTML = '<option value="">— Pilih Kelas —</option>';
    selectEl.disabled = true;
    loadingEl.classList.add('show');

    fetch(`<?= base_url('dashboard/pengajar/kelas-by-program') ?>/${idProgram}`)
        .then(r => r.json())
        .then(data => {
            loadingEl.classList.remove('show');
            if (data.success && data.kelas.length > 0) {
                data.kelas.forEach(k => {
                    const opt = document.createElement('option');
                    opt.value = k.id_kelas;
                    opt.textContent = k.nama_kelas;
                    if (selectedId && k.id_kelas == selectedId) opt.selected = true;
                    selectEl.appendChild(opt);
                });
                selectEl.disabled = false;
            } else {
                selectEl.innerHTML = '<option value="">Tidak ada kelas di program ini</option>';
            }
        })
        .catch(() => {
            loadingEl.classList.remove('show');
            selectEl.innerHTML = '<option value="">Gagal memuat kelas</option>';
        });
}

document.addEventListener('DOMContentLoaded', function() {

    /* ── Cascade Tambah ── */
    document.getElementById('tambah_program').addEventListener('change', function() {
        if (!this.value) return;
        loadKelasByProgram(
            this.value,
            document.getElementById('tambah_kelas'),
            document.getElementById('loadingTambahKelas')
        );
    });

    /* ── Cascade Edit ── */
    document.getElementById('edit_program').addEventListener('change', function() {
        if (!this.value) return;
        loadKelasByProgram(
            this.value,
            document.getElementById('edit_id_kelas'),
            document.getElementById('loadingEditKelas')
        );
    });

    /* ── Filter Program → Kelas dropdown tabel ── */
    document.getElementById('filterProgram').addEventListener('change', function() {
        const idProgram = this.value;
        const selKelas = document.getElementById('filterKelas');
        selKelas.querySelectorAll('option').forEach(opt => {
            if (!opt.value) return;
            opt.style.display = (!idProgram || opt.dataset.program === idProgram) ? '' : 'none';
        });
        if (selKelas.value && selKelas.options[selKelas.selectedIndex]?.dataset.program !== idProgram) {
            selKelas.value = '';
        }
        filterTable();
    });

    /* ── Edit modal ── */
    document.querySelectorAll('.btn-edit-modul').forEach(btn => {
        btn.addEventListener('click', function() {
            const baseUrl = '<?= base_url('dashboard/pengajar/modul/update') ?>';
            document.getElementById('formEditModul').action = `${baseUrl}/${this.dataset.id}`;
            document.getElementById('edit_judul_modul').value = this.dataset.judul;
            document.getElementById('edit_urutan_modul').value = this.dataset.urutan;
            document.getElementById('edit_program').value = this.dataset.program;

            loadKelasByProgram(
                this.dataset.program,
                document.getElementById('edit_id_kelas'),
                document.getElementById('loadingEditKelas'),
                this.dataset.kelas
            );

            new bootstrap.Modal(document.getElementById('modalEditModul')).show();
        });
    });

    /* ── Hapus modal ── */
    document.querySelectorAll('.btn-delete-modul').forEach(btn => {
        btn.addEventListener('click', function() {
            const baseUrl = '<?= base_url('dashboard/pengajar/modul/delete') ?>';
            document.getElementById('formHapusModul').action = `${baseUrl}/${this.dataset.id}`;
            document.getElementById('hapusJudulModul').textContent = this.dataset.judul;
            new bootstrap.Modal(document.getElementById('modalHapusModul')).show();
        });
    });

    /* ── Filter tabel ── */
    function filterTable() {
        const keyword = document.getElementById('searchModul').value.toLowerCase();
        const kelasId = document.getElementById('filterKelas').value;
        const programId = document.getElementById('filterProgram').value;
        const rows = document.querySelectorAll('#tabelModul tbody tr:not(#emptyRow)');
        let visible = 0;

        rows.forEach(row => {
            const judul = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
            const kelas = row.dataset.kelas || '';
            const program = row.dataset.program || '';
            const ok = judul.includes(keyword) &&
                (!kelasId || kelas === kelasId) &&
                (!programId || program === programId);
            row.style.display = ok ? '' : 'none';
            if (ok) visible++;
        });

        document.getElementById('totalModul').textContent = visible;
    }

    document.getElementById('searchModul').addEventListener('input', filterTable);
    document.getElementById('filterKelas').addEventListener('change', filterTable);
    window.filterTable = filterTable;
});
</script>

<?= $this->endSection() ?>
<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>
<?= $this->section('content') ?>

<?php
$success = session()->getFlashdata('success');
$error   = session()->getFlashdata('error');
$errors  = session()->getFlashdata('errors');
?>

<style>
    .kelas-page-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 28px;
    }
    .kelas-page-header h1 { font-size: 22px; font-weight: 800; color: #111; margin: 0 0 4px; }
    .kelas-page-header p  { font-size: 13px; color: #6b7280; margin: 0; }

    .mp-alert {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 16px; border-radius: 12px;
        font-size: 13px; font-weight: 600; margin-bottom: 16px;
    }
    .mp-alert-success { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .mp-alert-danger  { background: #fff5f5; color: #dc2626; border: 1px solid #fecaca; }

    .toolbar-row {
        display: flex; align-items: center; gap: 12px; flex-wrap: wrap;
        margin-bottom: 24px; background: #fff; border-radius: 18px;
        padding: 16px 20px; box-shadow: 0 4px 18px rgba(0,0,0,.06);
    }
    .search-box { position: relative; flex: 1; min-width: 200px; max-width: 320px; }
    .search-box i { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 13px; pointer-events: none; }
    .search-box input {
        width: 100%; padding: 10px 14px 10px 36px;
        border: 1.5px solid #e5e7eb; border-radius: 12px;
        font-size: 13px; color: #374151; background: #f9fafb; outline: none;
        transition: border .2s, background .2s;
    }
    .search-box input:focus { border-color: #059669; background: #fff; }
    .toolbar-count { margin-left: auto; font-size: 12.5px; color: #9ca3af; white-space: nowrap; }
    .toolbar-count strong { color: #374151; }

    .kelas-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 20px; }

    .kelas-card {
        background: #fff; border-radius: 20px;
        box-shadow: 0 1px 8px rgba(0,0,0,.06); overflow: hidden;
        display: flex; flex-direction: column;
        transition: transform .2s, box-shadow .2s; position: relative;
    }
    .kelas-card:hover { transform: translateY(-4px); box-shadow: 0 12px 32px rgba(0,0,0,.11); }

    .kelas-card-band { height: 8px; width: 100%; }
    .band-green  { background: linear-gradient(90deg, #059669, #34d399); }
    .band-blue   { background: linear-gradient(90deg, #2563eb, #60a5fa); }
    .band-purple { background: linear-gradient(90deg, #7c3aed, #a78bfa); }
    .band-orange { background: linear-gradient(90deg, #ea580c, #fb923c); }
    .band-teal   { background: linear-gradient(90deg, #0d9488, #2dd4bf); }
    .band-rose   { background: linear-gradient(90deg, #e11d48, #fb7185); }

    .kelas-card-body { padding: 22px 24px 18px; flex: 1; display: flex; flex-direction: column; }

    .kelas-icon-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; }
    .kelas-icon { width: 48px; height: 48px; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 22px; }
    .icon-green  { background: #d1fae5; color: #059669; }
    .icon-blue   { background: #dbeafe; color: #2563eb; }
    .icon-purple { background: #ede9fe; color: #7c3aed; }
    .icon-orange { background: #ffedd5; color: #ea580c; }
    .icon-teal   { background: #ccfbf1; color: #0d9488; }
    .icon-rose   { background: #ffe4e6; color: #e11d48; }

    .kelas-id-badge { font-size: 11px; font-weight: 700; letter-spacing: .5px; color: #9ca3af; text-transform: uppercase; background: #f3f4f6; padding: 4px 10px; border-radius: 20px; }
    .kelas-name  { font-size: 17px; font-weight: 700; color: #111; margin-bottom: 8px; line-height: 1.3; }
    .kelas-desc  { font-size: 12.5px; color: #6b7280; line-height: 1.55; flex: 1; margin-bottom: 10px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }

    /* Badge tipe kelas */
    .badge-tipe {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 11px; font-weight: 700; padding: 3px 10px;
        border-radius: 20px; margin-bottom: 14px;
    }
    .badge-gratis   { background: #d1fae5; color: #065f46; }
    .badge-berbayar { background: #fef3c7; color: #92400e; }

    .kelas-stats { display: flex; gap: 16px; padding: 14px 0; border-top: 1px solid #f3f4f6; border-bottom: 1px solid #f3f4f6; margin-bottom: 16px; }
    .kelas-stat  { display: flex; flex-direction: column; align-items: center; flex: 1; gap: 3px; }
    .kelas-stat-value { font-size: 18px; font-weight: 800; color: #111; }
    .kelas-stat-label { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; color: #9ca3af; }
    .stat-divider { width: 1px; background: #f0f0f0; align-self: stretch; }

    .kelas-actions { display: flex; gap: 8px; }
    .btn-kelas-peserta {
        flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 6px;
        padding: 9px 14px; border-radius: 10px; font-size: 12.5px; font-weight: 600;
        border: 1.5px solid #059669; color: #059669; background: transparent;
        cursor: pointer; text-decoration: none; transition: background .15s, color .15s;
    }
    .btn-kelas-peserta:hover { background: #f0fdf4; color: #047857; }
    .btn-kelas-edit {
        display: inline-flex; align-items: center; justify-content: center;
        width: 38px; height: 38px; border-radius: 10px;
        border: 1.5px solid #dbeafe; background: #eff6ff; color: #2563eb;
        cursor: pointer; font-size: 14px; transition: background .15s;
    }
    .btn-kelas-edit:hover { background: #dbeafe; }
    .btn-kelas-delete {
        display: inline-flex; align-items: center; justify-content: center;
        width: 38px; height: 38px; border-radius: 10px;
        border: 1.5px solid #fee2e2; background: #fff5f5; color: #ef4444;
        cursor: pointer; font-size: 14px; transition: background .15s;
    }
    .btn-kelas-delete:hover { background: #fee2e2; border-color: #ef4444; }

    .kelas-empty { grid-column: 1 / -1; text-align: center; padding: 64px 24px; color: #9ca3af; }
    .kelas-empty-icon { width: 80px; height: 80px; border-radius: 24px; background: #f3f4f6; display: inline-flex; align-items: center; justify-content: center; font-size: 34px; color: #d1d5db; margin-bottom: 18px; }
    .kelas-empty h3 { font-size: 16px; font-weight: 700; color: #374151; margin-bottom: 6px; }
    .kelas-empty p  { font-size: 13px; color: #9ca3af; margin-bottom: 20px; }

    .btn-add-kelas {
        display: inline-flex; align-items: center; gap: 8px;
        background: linear-gradient(135deg, #059669, #047857);
        color: #fff; border: none; border-radius: 12px; padding: 11px 20px;
        font-size: 13.5px; font-weight: 700; cursor: pointer; text-decoration: none;
        box-shadow: 0 4px 14px rgba(5,150,105,.35); transition: transform .15s, box-shadow .15s; white-space: nowrap;
    }
    .btn-add-kelas:hover { color: #fff; transform: translateY(-2px); box-shadow: 0 8px 20px rgba(5,150,105,.4); }

    #noResults { display: none; grid-column: 1 / -1; text-align: center; padding: 48px; color: #9ca3af; font-size: 13.5px; }

    /* Tipe radio button style */
    .tipe-radio-group { display: flex; gap: 10px; }
    .tipe-radio-label {
        flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px;
        padding: 10px 16px; border-radius: 12px; border: 2px solid #e5e7eb;
        cursor: pointer; font-size: 13px; font-weight: 600; color: #6b7280;
        transition: all .18s; user-select: none;
    }
    .tipe-radio-label:has(input:checked) { border-color: #059669; background: #f0fdf4; color: #065f46; }
    .tipe-radio-label.berbayar:has(input:checked) { border-color: #d97706; background: #fffbeb; color: #92400e; }
    .tipe-radio-label input { display: none; }

    /* Field berbayar slide animation */
    .field-berbayar {
        overflow: hidden;
        max-height: 0;
        transition: max-height .3s ease, opacity .3s ease;
        opacity: 0;
    }
    .field-berbayar.show {
        max-height: 200px;
        opacity: 1;
    }

    /* ── Peserta modal styles ── */
    .peserta-list { max-height: 280px; overflow-y: auto; }
    .peserta-item {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 14px; border-radius: 10px;
        border: 1px solid #f0f0f0; margin-bottom: 8px;
        background: #fafafa;
    }
    .peserta-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: linear-gradient(135deg, #059669, #34d399);
        color: #fff; display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 700; flex-shrink: 0;
    }
    .peserta-info { flex: 1; min-width: 0; }
    .peserta-nama  { font-size: 13px; font-weight: 700; color: #111; }
    .peserta-email { font-size: 11px; color: #9ca3af; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .peserta-tgl   { font-size: 10.5px; color: #9ca3af; white-space: nowrap; }
    .btn-kick {
        display: inline-flex; align-items: center; justify-content: center;
        width: 28px; height: 28px; border-radius: 7px;
        background: #fff5f5; color: #ef4444; border: none; cursor: pointer;
        font-size: 11px; transition: background .14s; flex-shrink: 0;
    }
    .btn-kick:hover { background: #fee2e2; }
    .peserta-empty-box { text-align: center; padding: 28px; color: #9ca3af; font-size: 12.5px; }

    .search-peserta-box { position: relative; margin-bottom: 12px; }
    .search-peserta-box i { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 12px; }
    .search-peserta-box input {
        width: 100%; padding: 8px 12px 8px 30px; border: 1.5px solid #e5e7eb;
        border-radius: 9px; font-size: 13px; outline: none; background: #f9fafb;
        transition: border .18s;
    }
    .search-peserta-box input:focus { border-color: #059669; background: #fff; }

    .add-peserta-form { border-top: 1px solid #f0f0f0; padding-top: 16px; margin-top: 4px; }
    .add-peserta-form label { font-size: 12px; font-weight: 700; color: #374151; margin-bottom: 6px; display: block; }

    /* FILTER BOX MODERN */
    .filter-box {
        position: relative; display: flex; align-items: center;
        background: #f9fafb; border: 1.5px solid #e5e7eb;
        border-radius: 14px; padding: 0 12px; height: 40px;
        min-width: 200px; max-width: 240px; transition: all .2s ease;
    }
    .filter-box i { color: #9ca3af; font-size: 13px; margin-right: 6px; }
    .filter-box select {
        border: none; outline: none; background: transparent;
        font-size: 13px; color: #374151; width: 100%;
        cursor: pointer; appearance: none;
    }
    .filter-box:hover { border-color: #059669; background: #fff; }
    .filter-box:focus-within { border-color: #059669; background: #fff; box-shadow: 0 0 0 3px rgba(5,150,105,0.15); }
    .filter-box::after { content: "▾"; position: absolute; right: 12px; font-size: 12px; color: #9ca3af; pointer-events: none; }

    @media (max-width: 768px) {
        .kelas-grid { grid-template-columns: 1fr; }
        .kelas-page-header { flex-direction: column; }
    }
</style>

<!-- Page Header -->
<div class="kelas-page-header">
    <div>
        <h1>Daftar Kelas</h1>
        <p>Kelola kelas pembelajaran yang kamu buat.</p>
    </div>
    <button class="btn-add-kelas" data-bs-toggle="modal" data-bs-target="#modalTambahKelas">
        <i class="bi bi-plus-lg"></i> Tambah Kelas
    </button>
</div>

<!-- Flash Messages -->
<?php if ($success): ?>
    <div class="mp-alert mp-alert-success"><i class="bi bi-check-circle-fill"></i> <?= esc($success) ?></div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="mp-alert mp-alert-danger"><i class="bi bi-exclamation-triangle-fill"></i> <?= esc($error) ?></div>
<?php endif; ?>

<!-- Toolbar -->
<div class="toolbar-row">
    <div class="search-box">
        <i class="bi bi-search"></i>
        <input type="text" id="searchKelas" placeholder="Cari nama kelas...">
    </div>
    <div class="toolbar-count">
        Total: <strong id="totalKelas"><?= count($kelas_list ?? []) ?></strong> kelas
    </div>
    <div class="filter-box">
        <i class="bi bi-funnel-fill"></i>
        <select id="filterProgramGrid">
            <option value="">Semua Program</option>
            <?php foreach ($programList as $p): ?>
                <option value="<?= $p['id_program'] ?>">
                    <?= esc($p['nama_program']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<?php
$colors = ['green', 'blue', 'purple', 'orange', 'teal', 'rose'];
$icons  = ['bi-mortarboard-fill', 'bi-cpu-fill', 'bi-lightning-fill', 'bi-gear-fill', 'bi-diagram-3-fill', 'bi-book-fill'];
?>

<!-- Grid -->
<div class="kelas-grid" id="kelasGrid">
    <?php if (!empty($kelas_list)): ?>
        <?php foreach ($kelas_list as $i => $k): ?>
            <?php $c = $colors[$i % count($colors)]; $ic = $icons[$i % count($icons)]; ?>
            <div class="kelas-card"
                data-nama="<?= strtolower(esc($k['nama_kelas'])) ?>"
                data-program="<?= $k['id_program'] ?? '' ?>">
                <div class="kelas-card-band band-<?= $c ?>"></div>
                <div class="kelas-card-body">
                    <div class="kelas-icon-row">
                        <div class="kelas-icon icon-<?= $c ?>"><i class="bi <?= $ic ?>"></i></div>
                        <span class="kelas-id-badge">ID #<?= $k['id_kelas'] ?></span>
                    </div>
                    <div class="kelas-name"><?= esc($k['nama_kelas']) ?></div>
                    <div class="kelas-desc"><?= esc($k['deskripsi_kelas'] ?: 'Belum ada deskripsi untuk kelas ini.') ?></div>

                    <!-- Badge tipe kelas -->
                    <?php if (($k['tipe_kelas'] ?? 'gratis') === 'berbayar'): ?>
                        <span class="badge-tipe badge-berbayar">
                            <i class="bi bi-tag-fill"></i>
                            Berbayar — Rp <?= number_format($k['harga'] ?? 0, 0, ',', '.') ?>
                        </span>
                    <?php else: ?>
                        <span class="badge-tipe badge-gratis">
                            <i class="bi bi-gift-fill"></i> Gratis
                        </span>
                    <?php endif; ?>

                    <div class="kelas-stats">
                        <div class="kelas-stat">
                            <span class="kelas-stat-value"><?= $k['total_modul'] ?? 0 ?></span>
                            <span class="kelas-stat-label">Modul</span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="kelas-stat">
                            <span class="kelas-stat-value"><?= $k['total_materi'] ?? 0 ?></span>
                            <span class="kelas-stat-label">Materi</span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="kelas-stat">
                            <span class="kelas-stat-value peserta-count-<?= $k['id_kelas'] ?>"><?= $k['total_peserta'] ?? 0 ?></span>
                            <span class="kelas-stat-label">Peserta</span>
                        </div>
                    </div>
                    <div class="kelas-actions">
                        <button class="btn-kelas-peserta btn-kelola-peserta"
                                data-id="<?= $k['id_kelas'] ?>"
                                data-nama="<?= esc($k['nama_kelas']) ?>">
                            <i class="bi bi-people-fill"></i> Peserta
                        </button>
                        <button class="btn-kelas-edit btn-edit-kelas" title="Edit kelas"
                                data-id="<?= $k['id_kelas'] ?>"
                                data-program="<?= $k['id_program'] ?? '' ?>"
                                data-tipe="<?= esc($k['tipe_kelas'] ?? 'gratis') ?>"
                                data-harga="<?= esc($k['harga'] ?? '') ?>"
                                data-lynk="<?= esc($k['lynk_url'] ?? '') ?>"
                                data-nama="<?= esc($k['nama_kelas']) ?>"
                                data-deskripsi="<?= esc($k['deskripsi_kelas'] ?? '') ?>">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn-kelas-delete btn-delete-kelas" title="Hapus kelas"
                                data-id="<?= $k['id_kelas'] ?>"
                                data-nama="<?= esc($k['nama_kelas']) ?>">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="kelas-empty">
            <div class="kelas-empty-icon"><i class="bi bi-mortarboard"></i></div>
            <h3>Belum ada kelas</h3>
            <p>Mulai dengan membuat kelas pertamamu.</p>
            <button class="btn-add-kelas" data-bs-toggle="modal" data-bs-target="#modalTambahKelas">
                <i class="bi bi-plus-lg"></i> Buat Kelas Pertama
            </button>
        </div>
    <?php endif; ?>
    <div id="noResults">
        <i class="bi bi-search" style="font-size:36px;display:block;margin-bottom:12px;color:#d1d5db;"></i>
        Tidak ada kelas yang cocok.
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════════
     MODAL KELOLA PESERTA
════════════════════════════════════════════════════════════ -->
<div class="modal fade" id="modalPeserta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <div>
                    <h5 class="modal-title fw-bold mb-0">
                        <i class="bi bi-people-fill text-success me-2"></i>
                        Kelola Peserta — <span id="modalPesertaNamaKelas" class="text-success"></span>
                    </h5>
                    <small class="text-muted" id="modalPesertaJumlah"></small>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-3 pb-2">
                <div class="search-peserta-box">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchPesertaModal" placeholder="Cari peserta terdaftar...">
                </div>
                <div class="peserta-list" id="pesertaListContainer">
                    <div class="text-center py-3">
                        <div class="spinner-border spinner-border-sm text-success"></div>
                        <span class="ms-2 small text-muted">Memuat peserta...</span>
                    </div>
                </div>
                <div class="add-peserta-form">
                    <label><i class="bi bi-person-plus-fill text-success me-1"></i> Tambah Peserta ke Kelas</label>
                    <form id="formTambahPeserta" method="POST">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id_kelas" id="addPesertaIdKelas">
                        <div class="input-group">
                            <select class="form-select" name="id_users" id="selectPeserta" required>
                                <option value="" disabled selected>-- Pilih peserta --</option>
                                <?php if (!empty($semua_peserta)): ?>
                                    <?php foreach ($semua_peserta as $p): ?>
                                        <option value="<?= $p['id_users'] ?>">
                                            <?= esc($p['nama_users']) ?> — <?= esc($p['email_users']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <button type="submit" class="btn btn-success fw-semibold px-3">
                                <i class="bi bi-plus-lg"></i> Tambah
                            </button>
                        </div>
                        <div class="form-text">Hanya menampilkan akun dengan role peserta.</div>
                    </form>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 px-4">
                <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════════
     MODAL TAMBAH KELAS
════════════════════════════════════════════════════════════ -->
<div class="modal fade" id="modalTambahKelas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-plus-circle-fill text-success me-2"></i>Tambah Kelas Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-3 pb-4">
                <form action="<?= base_url('dashboard/pengajar/kelas/store') ?>" method="POST">
                    <?= csrf_field() ?>

                    <!-- Program -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">
                            Program <span class="text-danger">*</span>
                        </label>
                        <select name="id_program" class="form-select" required>
                            <option value="">-- Pilih Program --</option>
                            <?php foreach ($programList as $p): ?>
                                <option value="<?= $p['id_program'] ?>">
                                    <?= esc($p['nama_program']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Tipe Kelas -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">
                            Tipe Kelas <span class="text-danger">*</span>
                        </label>
                        <div class="tipe-radio-group">
                            <label class="tipe-radio-label">
                                <input type="radio" name="tipe_kelas" value="gratis"
                                       id="addTipeGratis" checked
                                       onchange="toggleBerbayar('Add')">
                                <i class="bi bi-gift-fill text-success"></i> Gratis
                            </label>
                            <label class="tipe-radio-label berbayar">
                                <input type="radio" name="tipe_kelas" value="berbayar"
                                       id="addTipeBerbayar"
                                       onchange="toggleBerbayar('Add')">
                                <i class="bi bi-tag-fill text-warning"></i> Berbayar
                            </label>
                        </div>
                    </div>

                    <!-- Field Berbayar (toggle) -->
                    <div class="field-berbayar" id="fieldBerbayarAdd">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">
                                Harga <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text fw-semibold">Rp</span>
                                <input type="number" name="harga" id="addHarga"
                                       class="form-control"
                                       placeholder="cth: 150000" min="0" step="500">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">
                                Link Pembayaran (Lynk.id) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                                <input type="url" name="lynk_url" id="addLynk"
                                       class="form-control"
                                       placeholder="https://lynk.id/username/...">
                            </div>
                            <div class="form-text">Link halaman pembayaran Lynk.id milikmu.</div>
                        </div>
                    </div>

                    <!-- Nama Kelas -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">
                            Nama Kelas <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="nama_kelas"
                               placeholder="cth: Teknik Elektronika Dasar" required
                               minlength="3" maxlength="150">
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Deskripsi Kelas</label>
                        <textarea class="form-control" name="deskripsi_kelas" rows="3"
                                  placeholder="Deskripsi singkat tentang kelas ini..."
                                  maxlength="500"></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success px-4 fw-semibold">
                            <i class="bi bi-save me-1"></i>Simpan Kelas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════════
     MODAL EDIT KELAS
════════════════════════════════════════════════════════════ -->
<div class="modal fade" id="modalEditKelas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-pencil-square text-warning me-2"></i>Edit Kelas
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-3 pb-4">
                <form id="formEditKelas" method="POST">
                    <?= csrf_field() ?>

                    <!-- Program -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">
                            Program <span class="text-danger">*</span>
                        </label>
                        <select name="id_program" id="editIdProgram" class="form-select" required>
                            <option value="">-- Pilih Program --</option>
                            <?php foreach ($programList as $p): ?>
                                <option value="<?= $p['id_program'] ?>">
                                    <?= esc($p['nama_program']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Tipe Kelas -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">
                            Tipe Kelas <span class="text-danger">*</span>
                        </label>
                        <div class="tipe-radio-group">
                            <label class="tipe-radio-label">
                                <input type="radio" name="tipe_kelas" value="gratis"
                                       id="editTipeGratis"
                                       onchange="toggleBerbayar('Edit')">
                                <i class="bi bi-gift-fill text-success"></i> Gratis
                            </label>
                            <label class="tipe-radio-label berbayar">
                                <input type="radio" name="tipe_kelas" value="berbayar"
                                       id="editTipeBerbayar"
                                       onchange="toggleBerbayar('Edit')">
                                <i class="bi bi-tag-fill text-warning"></i> Berbayar
                            </label>
                        </div>
                    </div>

                    <!-- Field Berbayar (toggle) -->
                    <div class="field-berbayar" id="fieldBerbayarEdit">
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">
                                Harga <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text fw-semibold">Rp</span>
                                <input type="number" name="harga" id="editHarga"
                                       class="form-control"
                                       placeholder="cth: 150000" min="0" step="500">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">
                                Link Pembayaran (Lynk.id) <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-link-45deg"></i></span>
                                <input type="url" name="lynk_url" id="editLynk"
                                       class="form-control"
                                       placeholder="https://lynk.id/username/...">
                            </div>
                        </div>
                    </div>

                    <!-- Nama Kelas -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">
                            Nama Kelas <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control" name="nama_kelas"
                               id="edit_nama_kelas" required minlength="3" maxlength="150">
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Deskripsi Kelas</label>
                        <textarea class="form-control" name="deskripsi_kelas"
                                  id="edit_deskripsi_kelas" rows="3" maxlength="500"></textarea>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning px-4 fw-semibold">
                            <i class="bi bi-save me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ═══ MODAL HAPUS KELAS ═══ -->
<div class="modal fade" id="modalHapusKelas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body text-center py-4 px-4">
                <div class="mb-3">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-10"
                          style="width:64px;height:64px;">
                        <i class="bi bi-trash-fill text-danger" style="font-size:26px;"></i>
                    </span>
                </div>
                <h6 class="fw-bold mb-1">Hapus Kelas?</h6>
                <p class="text-muted small mb-3">
                    Kelas <strong id="hapusNamaKelas"></strong> beserta seluruh modul dan materi
                    di dalamnya akan dihapus permanen.
                </p>
                <form id="formHapusKelas" method="POST">
                    <?= csrf_field() ?>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-light px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger px-3 fw-semibold">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ═══ MODAL KONFIRMASI KELUARKAN PESERTA ═══ -->
<div class="modal fade" id="modalKickPeserta" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body text-center py-4 px-4">
                <div class="mb-3">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-warning bg-opacity-10"
                          style="width:64px;height:64px;">
                        <i class="bi bi-person-dash-fill text-warning" style="font-size:26px;"></i>
                    </span>
                </div>
                <h6 class="fw-bold mb-1">Keluarkan Peserta?</h6>
                <p class="text-muted small mb-3">
                    <strong id="kickNamaPeserta"></strong> akan dikeluarkan dari kelas ini.
                </p>
                <form id="formKickPeserta" method="POST">
                    <?= csrf_field() ?>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-light px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning px-3 fw-semibold">Ya, Keluarkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
// ══════════════════════════════════════════════════════════
//  TOGGLE FIELD BERBAYAR
// ══════════════════════════════════════════════════════════
function toggleBerbayar(suffix) {
    const isBerbayar = document.getElementById(suffix === 'Add' ? 'addTipeBerbayar' : 'editTipeBerbayar').checked;
    const fieldDiv   = document.getElementById('fieldBerbayar' + suffix);

    if (isBerbayar) {
        fieldDiv.classList.add('show');
    } else {
        fieldDiv.classList.remove('show');
        // Kosongkan nilai saat beralih ke gratis
        fieldDiv.querySelector('input[name="harga"]').value   = '';
        fieldDiv.querySelector('input[name="lynk_url"]').value = '';
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const BASE = '<?= base_url('dashboard/pengajar') ?>';

    // ── Filter gabungan: search + program ──
    function applyFilter() {
        const q      = document.getElementById('searchKelas').value.toLowerCase();
        const progId = document.getElementById('filterProgramGrid').value;
        const cards  = document.querySelectorAll('#kelasGrid .kelas-card');
        let visible  = 0;

        cards.forEach(card => {
            const show = card.dataset.nama.includes(q) && (!progId || card.dataset.program === progId);
            card.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        document.getElementById('totalKelas').textContent = visible;
        document.getElementById('noResults').style.display = visible === 0 ? 'block' : 'none';
    }

    document.getElementById('searchKelas').addEventListener('input', applyFilter);
    document.getElementById('filterProgramGrid').addEventListener('change', applyFilter);

    // ── Edit kelas ──
    document.querySelectorAll('.btn-edit-kelas').forEach(btn => {
        btn.addEventListener('click', function () {
            const id      = this.dataset.id;
            const tipe    = this.dataset.tipe    || 'gratis';
            const harga   = this.dataset.harga   || '';
            const lynk    = this.dataset.lynk    || '';
            const program = this.dataset.program || '';

            // Set action form
            document.getElementById('formEditKelas').action = `${BASE}/kelas/update/${id}`;

            // Isi program
            document.getElementById('editIdProgram').value = program;

            // Set tipe kelas
            if (tipe === 'berbayar') {
                document.getElementById('editTipeBerbayar').checked = true;
                document.getElementById('editTipeGratis').checked   = false;
                document.getElementById('fieldBerbayarEdit').classList.add('show');
                document.getElementById('editHarga').value = harga;
                document.getElementById('editLynk').value  = lynk;
            } else {
                document.getElementById('editTipeGratis').checked   = true;
                document.getElementById('editTipeBerbayar').checked = false;
                document.getElementById('fieldBerbayarEdit').classList.remove('show');
                document.getElementById('editHarga').value = '';
                document.getElementById('editLynk').value  = '';
            }

            // Isi nama & deskripsi
            document.getElementById('edit_nama_kelas').value      = this.dataset.nama;
            document.getElementById('edit_deskripsi_kelas').value = this.dataset.deskripsi;

            new bootstrap.Modal(document.getElementById('modalEditKelas')).show();
        });
    });

    // ── Hapus kelas ──
    document.querySelectorAll('.btn-delete-kelas').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('formHapusKelas').action      = `${BASE}/kelas/delete/${this.dataset.id}`;
            document.getElementById('hapusNamaKelas').textContent = this.dataset.nama;
            new bootstrap.Modal(document.getElementById('modalHapusKelas')).show();
        });
    });

    // ── Auto dismiss alerts ──
    document.querySelectorAll('.mp-alert').forEach(el => {
        setTimeout(() => {
            el.style.transition = 'opacity .4s';
            el.style.opacity    = '0';
            setTimeout(() => el.remove(), 400);
        }, 4000);
    });

    // ════════════════════════════════════════════════════
    //  KELOLA PESERTA
    // ════════════════════════════════════════════════════
    let currentKelasId = null;

    function renderPesertaList(pesertaArr) {
        const container = document.getElementById('pesertaListContainer');
        document.getElementById('modalPesertaJumlah').textContent = `${pesertaArr.length} peserta terdaftar`;

        if (currentKelasId) {
            const el = document.querySelector(`.peserta-count-${currentKelasId}`);
            if (el) el.textContent = pesertaArr.length;
        }

        if (pesertaArr.length === 0) {
            container.innerHTML = `
                <div class="peserta-empty-box">
                    <i class="bi bi-people" style="font-size:28px;display:block;color:#d1d5db;margin-bottom:8px;"></i>
                    Belum ada peserta di kelas ini.
                </div>`;
            return;
        }

        container.innerHTML = pesertaArr.map(p => {
            const inisial = p.nama_users.split(' ').map(w => w[0]).join('').substring(0, 2).toUpperCase();
            const tgl = p.tanggal_daftar_kelas_peserta
                ? new Date(p.tanggal_daftar_kelas_peserta).toLocaleDateString('id-ID', {day:'2-digit',month:'short',year:'numeric'})
                : '';
            return `
            <div class="peserta-item" data-nama="${p.nama_users.toLowerCase()}">
                <div class="peserta-avatar">${inisial}</div>
                <div class="peserta-info">
                    <div class="peserta-nama">${escHtml(p.nama_users)}</div>
                    <div class="peserta-email">${escHtml(p.email_users)}</div>
                </div>
                <div class="peserta-tgl">${tgl}</div>
                <button class="btn-kick" title="Keluarkan peserta"
                        onclick="konfirmasiKick(${p.id_kelas_peserta}, '${escHtml(p.nama_users)}')">
                    <i class="bi bi-person-dash"></i>
                </button>
            </div>`;
        }).join('');
    }

    function loadPeserta(idKelas) {
        const container = document.getElementById('pesertaListContainer');
        container.innerHTML = `<div class="text-center py-3"><div class="spinner-border spinner-border-sm text-success"></div><span class="ms-2 small text-muted">Memuat...</span></div>`;

        fetch(`${BASE}/kelas/peserta/${idKelas}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => renderPesertaList(data.peserta || []))
        .catch(() => {
            container.innerHTML = `<div class="text-center py-3 text-danger small"><i class="bi bi-exclamation-circle me-1"></i>Gagal memuat data.</div>`;
        });
    }

    document.querySelectorAll('.btn-kelola-peserta').forEach(btn => {
        btn.addEventListener('click', function () {
            currentKelasId = this.dataset.id;
            document.getElementById('modalPesertaNamaKelas').textContent = this.dataset.nama;
            document.getElementById('addPesertaIdKelas').value = currentKelasId;
            document.getElementById('searchPesertaModal').value = '';
            loadPeserta(currentKelasId);
            new bootstrap.Modal(document.getElementById('modalPeserta')).show();
        });
    });

    document.getElementById('searchPesertaModal').addEventListener('input', function () {
        const q = this.value.toLowerCase();
        document.querySelectorAll('#pesertaListContainer .peserta-item').forEach(item => {
            item.style.display = item.dataset.nama.includes(q) ? '' : 'none';
        });
    });

    document.getElementById('formTambahPeserta').addEventListener('submit', function (e) {
        e.preventDefault();
        fetch(`${BASE}/kelas/peserta/store`, {
            method: 'POST',
            body: new FormData(this),
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                document.getElementById('selectPeserta').value = '';
                loadPeserta(currentKelasId);
                showToast(data.message || 'Peserta berhasil ditambahkan.', 'success');
            } else {
                showToast(data.message || 'Gagal menambahkan peserta.', 'danger');
            }
        })
        .catch(() => showToast('Terjadi kesalahan.', 'danger'));
    });

    window.konfirmasiKick = function(idKP, namaPeserta) {
        document.getElementById('formKickPeserta').action = `${BASE}/kelas/peserta/kick/${idKP}`;
        document.getElementById('kickNamaPeserta').textContent = namaPeserta;
        new bootstrap.Modal(document.getElementById('modalKickPeserta')).show();
    };

    document.getElementById('formKickPeserta').addEventListener('submit', function (e) {
        e.preventDefault();
        fetch(this.action, {
            method: 'POST',
            body: new FormData(this),
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            bootstrap.Modal.getInstance(document.getElementById('modalKickPeserta')).hide();
            if (data.success) {
                loadPeserta(currentKelasId);
                showToast(data.message || 'Peserta berhasil dikeluarkan.', 'success');
            } else {
                showToast(data.message || 'Gagal.', 'danger');
            }
        })
        .catch(() => showToast('Terjadi kesalahan.', 'danger'));
    });

    // ── Toast helper ──
    function showToast(msg, type) {
        const toast = document.createElement('div');
        toast.className = `mp-alert mp-alert-${type}`;
        toast.style.cssText = 'position:fixed;top:20px;right:20px;z-index:9999;min-width:260px;';
        toast.innerHTML = `<i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill'}"></i> ${msg}`;
        document.body.appendChild(toast);
        setTimeout(() => {
            toast.style.transition = 'opacity .4s';
            toast.style.opacity    = '0';
            setTimeout(() => toast.remove(), 400);
        }, 3000);
    }

    function escHtml(str) {
        return String(str)
            .replace(/&/g,'&amp;').replace(/</g,'&lt;')
            .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }
});
</script>

<?= $this->endSection() ?>
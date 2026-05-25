<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>

<?= $this->section('content') ?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');

:root {
    --acc: #6366f1;
    --acc-soft: #eef2ff;
    --acc-mid: #c7d2fe;
    --txt: #0f0e17;
    --muted: #6b7280;
    --meta: #9ca3af;
    --bg: #f5f4ff;
    --card: #ffffff;
    --border: #e8e6ff;
    --r: 18px;
    --sh: 0 2px 20px rgba(99, 102, 241, .07);
    --sh2: 0 12px 40px rgba(99, 102, 241, .15);
    --danger: #ef4444;
    --danger-soft: #fff1f2;
    --success: #059669;
}

.pg-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    padding: 2rem 2rem 3rem;
}

/* Header */
.pg-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-end;
    margin-bottom: 2.5rem;
}

.pg-eyebrow {
    font-size: .68rem;
    font-weight: 600;
    letter-spacing: .2em;
    color: var(--acc);
    text-transform: uppercase;
    margin: 0 0 .35rem;
}

.pg-h1 {
    font-family: 'Syne', sans-serif;
    font-size: 2.2rem;
    font-weight: 800;
    color: var(--txt);
    line-height: 1.05;
    letter-spacing: -.04em;
    margin: 0 0 .3rem;
}

.pg-h1 .acc {
    color: var(--acc);
}

.pg-sub {
    font-size: .84rem;
    color: var(--muted);
    margin: 0;
}

.pg-header-right {
    display: flex;
    align-items: center;
    gap: 10px;
}

.pg-ctr-num {
    font-family: 'Syne', sans-serif;
    font-size: 3rem;
    font-weight: 800;
    line-height: 1;
    color: transparent;
    -webkit-text-stroke: 2px var(--acc-mid);
    letter-spacing: -.06em;
}

.pg-ctr-lbl {
    font-size: .65rem;
    color: var(--meta);
    letter-spacing: .12em;
    text-transform: uppercase;
    text-align: right;
}

.btn-tambah {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    background: var(--acc);
    color: #fff;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: .82rem;
    font-weight: 600;
    padding: 10px 20px;
    border-radius: 100px;
    border: none;
    cursor: pointer;
    text-decoration: none;
    transition: opacity .2s, transform .2s;
}

.btn-tambah:hover {
    opacity: .88;
    transform: translateY(-1px);
    color: #fff;
}

/* Alert */
.pg-alert {
    padding: 12px 18px;
    border-radius: 12px;
    font-size: .82rem;
    font-weight: 500;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 8px;
}

.pg-alert-success {
    background: #ecfdf5;
    color: #065f46;
    border: 1px solid #6ee7b7;
}

.pg-alert-error {
    background: #fff1f2;
    color: #9f1239;
    border: 1px solid #fecdd3;
}

/* Grid */
.pg-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

/* Card */
.pg-card {
    background: var(--card);
    border-radius: var(--r);
    border: 1.5px solid var(--border);
    display: flex;
    flex-direction: column;
    box-shadow: var(--sh);
    transition: transform .35s cubic-bezier(.175, .885, .32, 1.275), box-shadow .35s ease, border-color .3s;
    overflow: hidden;
    opacity: 0;
    animation: fadeUp .5s ease forwards;
}

.pg-card::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--acc), #a5b4fc);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform .4s ease;
}

.pg-card {
    position: relative;
}

.pg-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--sh2);
    border-color: var(--acc-mid);
}

.pg-card:hover::after {
    transform: scaleX(1);
}

.pg-card-body {
    padding: 1.5rem 1.5rem 1rem;
    flex: 1;
}

.pg-card-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: .9rem;
}

.pg-num {
    font-size: .65rem;
    font-weight: 700;
    color: var(--acc-mid);
    letter-spacing: .16em;
}

.pg-icon {
    width: 42px;
    height: 42px;
    border-radius: 11px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
    background: var(--acc-soft);
    color: var(--acc);
}

.pg-title {
    font-family: 'Syne', sans-serif;
    font-size: 1rem;
    font-weight: 700;
    color: var(--txt);
    line-height: 1.3;
    margin: 0 0 .35rem;
}

.pg-desc {
    font-size: .78rem;
    color: var(--meta);
    margin: 0;
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.pg-hr {
    height: 1px;
    background: var(--border);
    margin: 1rem 1.5rem;
}

.pg-card-footer {
    padding: 0 1.5rem 1.25rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
}

.pg-pill {
    background: var(--acc-soft);
    color: var(--acc);
    font-size: .7rem;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 100px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
    transition: background .2s;
}

.pg-pill:hover {
    background: var(--acc-mid);
    color: var(--acc);
}

.pg-actions {
    display: flex;
    gap: 6px;
}

.pg-btn-icon {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 1.5px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    cursor: pointer;
    transition: all .25s;
    background: transparent;
}

.pg-btn-edit {
    color: var(--acc);
}

.pg-btn-edit:hover {
    background: var(--acc);
    border-color: var(--acc);
    color: #fff;
}

.pg-btn-del {
    color: var(--danger);
}

.pg-btn-del:hover {
    background: var(--danger);
    border-color: var(--danger);
    color: #fff;
}

/* Empty */
.pg-empty {
    border: 1.5px dashed var(--acc-mid);
    border-radius: var(--r);
    padding: 5rem 2rem;
    text-align: center;
    background: var(--acc-soft);
}

.pg-empty-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 1.25rem;
    border-radius: 18px;
    background: #fff;
    border: 1.5px solid var(--acc-mid);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: var(--acc);
}

.pg-empty h3 {
    font-family: 'Syne', sans-serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--txt);
    margin: 0 0 .5rem;
}

.pg-empty p {
    font-size: .82rem;
    color: var(--muted);
    margin: 0 0 1.5rem;
}

/* Modal */
.modal-content {
    border-radius: 20px !important;
    border: 1.5px solid var(--border) !important;
    box-shadow: var(--sh2) !important;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.modal-header {
    border-bottom: 1px solid var(--border) !important;
    padding: 1.25rem 1.5rem !important;
}

.modal-title {
    font-family: 'Syne', sans-serif !important;
    font-size: 1rem !important;
    font-weight: 700 !important;
    color: var(--txt) !important;
}

.modal-body {
    padding: 1.25rem 1.5rem !important;
}

.modal-footer {
    border-top: 1px solid var(--border) !important;
    padding: 1rem 1.5rem !important;
}

.form-label {
    font-size: .8rem !important;
    font-weight: 600 !important;
    color: var(--txt) !important;
    margin-bottom: .4rem !important;
}

.form-control {
    border-radius: 10px !important;
    border: 1.5px solid var(--border) !important;
    font-size: .85rem !important;
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    transition: border-color .2s !important;
}

.form-control:focus {
    border-color: var(--acc) !important;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, .1) !important;
}

.btn-simpan {
    background: var(--acc) !important;
    border: none !important;
    border-radius: 100px !important;
    font-size: .82rem !important;
    font-weight: 600 !important;
    padding: 9px 24px !important;
    font-family: 'Plus Jakarta Sans', sans-serif !important;
}

.btn-simpan:hover {
    opacity: .88 !important;
}

.btn-batal {
    background: transparent !important;
    border: 1.5px solid var(--border) !important;
    border-radius: 100px !important;
    color: var(--muted) !important;
    font-size: .82rem !important;
    font-weight: 600 !important;
    padding: 9px 20px !important;
    font-family: 'Plus Jakarta Sans', sans-serif !important;
}

.btn-batal:hover {
    border-color: var(--acc) !important;
    color: var(--acc) !important;
}

.modal-del-icon {
    width: 56px;
    height: 56px;
    border-radius: 16px;
    background: #fff1f2;
    border: 1.5px solid #fecdd3;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    color: var(--danger);
    margin: 0 auto 1rem;
}

.modal-del-title {
    font-family: 'Syne', sans-serif;
    font-size: 1rem;
    font-weight: 700;
    color: var(--txt);
    margin: 0 0 .4rem;
    text-align: center;
}

.modal-del-sub {
    font-size: .8rem;
    color: var(--muted);
    text-align: center;
    margin: 0;
}

.btn-hapus {
    background: var(--danger) !important;
    border: none !important;
    border-radius: 100px !important;
    font-size: .82rem !important;
    font-weight: 600 !important;
    padding: 9px 24px !important;
    font-family: 'Plus Jakarta Sans', sans-serif !important;
    color: #fff !important;
}

.btn-hapus:hover {
    opacity: .88 !important;
}

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(18px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 768px) {
    .pg-wrap {
        padding: 1.25rem 1rem 2rem;
    }

    .pg-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .pg-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<?php $total = count($program_list); ?>

<div class="pg-wrap">

    <!-- Header -->
    <div class="pg-header">
        <div>
            <p class="pg-eyebrow">Manajemen Konten</p>
            <h1 class="pg-h1">Program<br><span class="acc">Saya</span></h1>
            <p class="pg-sub">Kelola program dan kelas yang kamu buat.</p>
        </div>
        <div class="pg-header-right">
            <?php if ($total > 0): ?>
            <div style="text-align:right">
                <div class="pg-ctr-num"><?= str_pad($total, 2, '0', STR_PAD_LEFT) ?></div>
                <div class="pg-ctr-lbl">Program</div>
            </div>
            <?php endif ?>
            <button class="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg"></i> Tambah
            </button>
        </div>
    </div>

    <!-- Alert -->
    <?php if (session('success')): ?>
    <div class="pg-alert pg-alert-success">
        <i class="bi bi-check-circle-fill"></i> <?= session('success') ?>
    </div>
    <?php endif ?>
    <?php if (session('error')): ?>
    <div class="pg-alert pg-alert-error">
        <i class="bi bi-exclamation-circle-fill"></i> <?= session('error') ?>
    </div>
    <?php endif ?>

    <!-- Empty -->
    <?php if (empty($program_list)): ?>
    <div class="pg-empty">
        <div class="pg-empty-icon"><i class="bi bi-collection"></i></div>
        <h3>Belum Ada Program</h3>
        <p>Mulai buat program pertamamu dan tambahkan kelas di dalamnya.</p>
        <button class="btn-tambah" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg"></i> Buat Program Pertama
        </button>
    </div>

    <?php else: ?>

    <!-- Grid -->
    <div class="pg-grid">
        <?php foreach ($program_list as $i => $p): ?>
        <div class="pg-card" style="animation-delay:<?= $i * 0.07 ?>s">
            <div class="pg-card-body">
                <div class="pg-card-top">
                    <span class="pg-num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></span>
                    <div class="pg-icon"><i class="bi bi-collection-fill"></i></div>
                </div>
                <h3 class="pg-title"><?= esc($p['nama_program']) ?></h3>
                <p class="pg-desc"><?= esc($p['deskripsi_program'] ?: 'Tidak ada deskripsi program.') ?></p>
            </div>

            <div class="pg-hr"></div>

            <div class="pg-card-footer">
                <a href="<?= base_url('dashboard/pengajar/kelas?program=' . $p['id_program']) ?>" class="pg-pill">
                    <i class="bi bi-grid-3x3-gap"></i>
                    <?= $p['total_kelas'] ?> Kelas
                </a>
                <div class="pg-actions">
                    <!-- Tombol Edit -->
                    <button class="pg-btn-icon pg-btn-edit" data-bs-toggle="modal" data-bs-target="#modalEdit"
                        data-id="<?= $p['id_program'] ?>" data-nama="<?= esc($p['nama_program']) ?>"
                        data-deskripsi="<?= esc($p['deskripsi_program']) ?>" title="Edit">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <!-- Tombol Hapus -->
                    <button class="pg-btn-icon pg-btn-del" data-bs-toggle="modal" data-bs-target="#modalHapus"
                        data-id="<?= $p['id_program'] ?>" data-nama="<?= esc($p['nama_program']) ?>" title="Hapus">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach ?>
    </div>

    <?php endif ?>
</div>

<!-- ══════════════════════════════════
     MODAL TAMBAH
══════════════════════════════════ -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" action="<?= base_url('dashboard/pengajar/program/store') ?>" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title">Tambah Program Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Program <span style="color:#ef4444">*</span></label>
                    <input type="text" name="nama_program" class="form-control"
                        placeholder="cth. Web Development Batch 1" value="<?= old('nama_program') ?>" required>
                </div>
                <div class="mb-1">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi_program" class="form-control" rows="3"
                        placeholder="Jelaskan singkat tentang program ini..."><?= old('deskripsi_program') ?></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-batal" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-simpan text-white">
                    <i class="bi bi-check-lg me-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════
     MODAL EDIT
══════════════════════════════════ -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" id="formEdit" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5 class="modal-title">Edit Program</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Program <span style="color:#ef4444">*</span></label>
                    <input type="text" name="nama_program" id="edit_nama" class="form-control" required>
                </div>
                <div class="mb-1">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi_program" id="edit_deskripsi" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-batal" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-simpan text-white">
                    <i class="bi bi-check-lg me-1"></i> Perbarui
                </button>
            </div>
        </form>
    </div>
</div>

<!-- ══════════════════════════════════
     MODAL HAPUS
══════════════════════════════════ -->
<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body py-4 px-4">
                <div class="modal-del-icon"><i class="bi bi-trash3"></i></div>
                <p class="modal-del-title">Hapus Program?</p>
                <p class="modal-del-sub" id="hapus_nama_text">Program ini akan dihapus secara permanen.</p>
            </div>
            <div class="modal-footer justify-content-center border-0 pt-0">
                <button type="button" class="btn btn-batal" data-bs-dismiss="modal">Batal</button>
                <form method="post" id="formHapus">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-hapus">
                        <i class="bi bi-trash me-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Edit modal — isi field otomatis
document.getElementById('modalEdit').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    const id = btn.dataset.id;
    const nama = btn.dataset.nama;
    const desk = btn.dataset.deskripsi;
    document.getElementById('edit_nama').value = nama;
    document.getElementById('edit_deskripsi').value = desk;
    document.getElementById('formEdit').action =
        '<?= base_url('dashboard/pengajar/program/update') ?>/' + id;
});

// Hapus modal — set action form
document.getElementById('modalHapus').addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    const id = btn.dataset.id;
    const nama = btn.dataset.nama;
    document.getElementById('hapus_nama_text').textContent = '"' + nama + '" akan dihapus.';
    document.getElementById('formHapus').action =
        '<?= base_url('dashboard/pengajar/program/delete') ?>/' + id;
});
</script>

<?= $this->endSection() ?>
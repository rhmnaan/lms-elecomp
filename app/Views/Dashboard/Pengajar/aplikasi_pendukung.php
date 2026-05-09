<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>
<?= $this->section('content') ?>

<style>
.app-card {
    border: 0.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 1.25rem;
    background: #fff;
    display: flex;
    flex-direction: column;
    gap: 12px;
    transition: border-color .15s, box-shadow .15s;
    height: 100%;
}

.app-card:hover {
    border-color: #93c5fd;
    box-shadow: 0 2px 12px rgba(59, 130, 246, .08);
}

.app-icon-wrap {
    width: 44px;
    height: 44px;
    border-radius: 10px;
    background: #eff6ff;
    display: flex;
    align-items: center;
    justify-content: center;
}

.app-icon-wrap i {
    font-size: 22px;
    color: #3b82f6;
}

.app-name {
    font-size: 14px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 2px;
}

.app-link-text {
    font-size: 12px;
    color: #94a3b8;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.app-actions {
    display: flex;
    gap: 8px;
    padding-top: 10px;
    border-top: 1px solid #f1f5f9;
    margin-top: auto;
}

.btn-buka {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    font-size: 12px;
    font-weight: 500;
    padding: 6px 10px;
    border-radius: 8px;
}

.btn-icon {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    padding: 0;
}

/* Search bar */
.search-wrap {
    position: relative;
    width: 220px;
}

.search-wrap i {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 15px;
    pointer-events: none;
}

.search-wrap input {
    padding-left: 32px;
    font-size: 13px;
    height: 36px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    width: 100%;
    background: #f8fafc;
    color: #334155;
}

.search-wrap input:focus {
    outline: none;
    border-color: #93c5fd;
    background: #fff;
}

/* Modal tweaks */
.modal-content {
    border-radius: 14px;
    border: 0.5px solid #e2e8f0;
}

.modal-header {
    border-bottom: 0.5px solid #f1f5f9;
    padding: 1rem 1.25rem;
}

.modal-footer {
    border-top: 0.5px solid #f1f5f9;
    padding: 1rem 1.25rem;
}

.modal-body {
    padding: 1.25rem;
}

.modal-title {
    font-size: 15px;
    font-weight: 600;
}

.form-label {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: .04em;
    margin-bottom: 4px;
}

.form-control,
.form-control:focus {
    font-size: 14px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
}

.form-control:focus {
    border-color: #93c5fd;
    box-shadow: 0 0 0 3px rgba(147, 197, 253, .2);
}

.form-text {
    font-size: 11px;
    color: #94a3b8;
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: #94a3b8;
}

.empty-state i {
    font-size: 48px;
    margin-bottom: 1rem;
    display: block;
}
</style>

<!-- Page Header -->
<div class="d-flex align-items-start justify-content-between mb-4">
    <div>
        <h4 class="fw-semibold mb-1">Aplikasi Pendukung</h4>
        <p class="text-muted mb-0 small">Kelola aplikasi yang tersedia untuk peserta</p>
    </div>
</div>

<!-- Flash Messages -->
<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
    <i class="bi bi-check-circle-fill"></i>
    <?= session()->getFlashdata('success') ?>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="alert alert-danger alert-dismissible fade show d-flex align-items-center gap-2" role="alert">
    <i class="bi bi-exclamation-circle-fill"></i>
    <?= session()->getFlashdata('error') ?>
    <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
</div>
<?php endif; ?>

<!-- Toolbar -->
<div class="d-flex align-items-center justify-content-between mb-3">
    <div class="search-wrap">
        <i class="bi bi-search"></i>
        <input type="text" id="searchAplikasi" placeholder="Cari aplikasi...">
    </div>
    <button class="btn btn-success btn-sm d-flex align-items-center gap-2" data-bs-toggle="modal"
        data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Aplikasi
    </button>
</div>

<!-- Card Grid -->
<?php if (empty($aplikasi)): ?>
<div class="empty-state">
    <i class="bi bi-grid-3x3-gap"></i>
    <p class="fw-semibold mb-1">Belum ada aplikasi</p>
    <p class="small">Klik <strong>Tambah Aplikasi</strong> untuk menambahkan aplikasi baru.</p>
</div>
<?php else: ?>
<div class="row g-3" id="appGrid">
    <?php foreach ($aplikasi as $app): ?>
    <div class="col-sm-6 col-md-4 col-lg-3 app-item" data-name="<?= strtolower(esc($app['nama_aplikasi'])) ?>">
        <div class="app-card">

            <!-- Icon + Info -->
            <div class="d-flex align-items-center gap-3">
                <div class="app-icon-wrap">
                    <i class="bi bi-grid-fill"></i>
                </div>
                <div class="overflow-hidden">
                    <div class="app-name"><?= esc($app['nama_aplikasi']) ?></div>
                    <div class="app-link-text"><?= esc($app['link_aplikasi']) ?></div>
                </div>
            </div>

            <!-- Actions -->
            <div class="app-actions">
                <a href="<?= esc($app['link_aplikasi']) ?>" target="_blank" rel="noopener"
                    class="btn btn-primary btn-sm btn-buka">
                    <i class="bi bi-box-arrow-up-right"></i> Buka
                </a>
                <button class="btn btn-warning btn-sm btn-icon" title="Edit" data-bs-toggle="modal"
                    data-bs-target="#modalEdit" data-id="<?= $app['id_aplikasi'] ?>"
                    data-nama="<?= esc($app['nama_aplikasi']) ?>" data-link="<?= esc($app['link_aplikasi']) ?>">
                    <i class="bi bi-pencil-fill" style="font-size:13px"></i>
                </button>
                <form action="<?= base_url('dashboard/pengajar/aplikasi-pendukung/delete/'.$app['id_aplikasi']) ?>"
                    method="post" onsubmit="return confirm('Hapus aplikasi \'<?= esc($app['nama_aplikasi']) ?>\'?')">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger btn-sm btn-icon" title="Hapus">
                        <i class="bi bi-trash3-fill" style="font-size:13px"></i>
                    </button>
                </form>
            </div>

        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>


<!-- ===================== MODAL TAMBAH ===================== -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= base_url('dashboard/pengajar/aplikasi-pendukung/store') ?>" method="post"
            class="modal-content">
            <?= csrf_field() ?>

            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <span class="rounded-2 p-1" style="background:#dcfce7">
                        <i class="bi bi-plus-lg text-success" style="font-size:14px"></i>
                    </span>
                    Tambah Aplikasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Aplikasi</label>
                    <input type="text" name="nama_aplikasi" class="form-control" placeholder="contoh: Google Classroom"
                        value="<?= old('nama_aplikasi') ?>" required>
                </div>
                <div class="mb-1">
                    <label class="form-label">Link Aplikasi</label>
                    <div class="input-group">
                        <span class="input-group-text"
                            style="border-radius:8px 0 0 8px; border:1px solid #e2e8f0; background:#f8fafc; font-size:13px; color:#64748b">
                            <i class="bi bi-link-45deg"></i>
                        </span>
                        <input type="url" name="link_aplikasi" class="form-control"
                            placeholder="https://aplikasi.contoh.com" value="<?= old('link_aplikasi') ?>"
                            style="border-radius:0 8px 8px 0" required>
                    </div>
                    <div class="form-text">Pastikan URL diawali dengan https://</div>
                </div>
            </div>

            <div class="modal-footer gap-2">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success btn-sm d-flex align-items-center gap-2">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>


<!-- ===================== MODAL EDIT (shared) ===================== -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form id="formEdit" method="post" class="modal-content">
            <?= csrf_field() ?>

            <div class="modal-header">
                <h5 class="modal-title d-flex align-items-center gap-2">
                    <span class="rounded-2 p-1" style="background:#fef9c3">
                        <i class="bi bi-pencil-fill text-warning" style="font-size:13px"></i>
                    </span>
                    Edit Aplikasi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Aplikasi</label>
                    <input type="text" name="nama_aplikasi" id="editNama" class="form-control" required>
                </div>
                <div class="mb-1">
                    <label class="form-label">Link Aplikasi</label>
                    <div class="input-group">
                        <span class="input-group-text"
                            style="border-radius:8px 0 0 8px; border:1px solid #e2e8f0; background:#f8fafc; font-size:13px; color:#64748b">
                            <i class="bi bi-link-45deg"></i>
                        </span>
                        <input type="url" name="link_aplikasi" id="editLink" class="form-control"
                            style="border-radius:0 8px 8px 0" required>
                    </div>
                </div>
            </div>

            <div class="modal-footer gap-2">
                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-warning btn-sm d-flex align-items-center gap-2">
                    <i class="bi bi-floppy-fill"></i> Perbarui
                </button>
            </div>
        </form>
    </div>
</div>


<script>
// Isi form edit saat modal dibuka
const modalEdit = document.getElementById('modalEdit');
modalEdit.addEventListener('show.bs.modal', function(e) {
    const btn = e.relatedTarget;
    document.getElementById('editNama').value = btn.dataset.nama;
    document.getElementById('editLink').value = btn.dataset.link;
    document.getElementById('formEdit').action =
        '<?= base_url('dashboard/pengajar/aplikasi-pendukung/update') ?>/' + btn.dataset.id;
});

// Live search
document.getElementById('searchAplikasi')?.addEventListener('input', function() {
    const q = this.value.toLowerCase();
    document.querySelectorAll('#appGrid .app-item').forEach(item => {
        item.style.display = item.dataset.name.includes(q) ? '' : 'none';
    });
});
</script>

<?= $this->endSection() ?>
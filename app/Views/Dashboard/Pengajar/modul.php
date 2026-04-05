<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>
<?= $this->section('content') ?>

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-semibold mb-1">Manajemen Modul</h4>
        <p class="text-muted mb-0 small">Kelola modul pembelajaran untuk setiap kelas</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahModul">
        <i class="bi bi-plus-lg me-1"></i> Tambah Modul
    </button>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle me-2"></i><?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Filter -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body py-3">
        <div class="row align-items-center g-2">
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted"></i>
                    </span>
                    <input type="text" class="form-control border-start-0 ps-0"
                           id="searchModul" placeholder="Cari judul modul...">
                </div>
            </div>
            <div class="col-md-3">
                <select class="form-select form-select-sm" id="filterKelas">
                    <option value="">Semua Kelas</option>
                    <?php if (!empty($kelas)): ?>
                        <?php foreach ($kelas as $k): ?>
                            <option value="<?= $k['id_kelas'] ?>"><?= esc($k['nama_kelas']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div class="col-md-auto ms-auto text-muted small">
                Total: <strong id="totalModul"><?= count($modul ?? []) ?></strong> modul
            </div>
        </div>
    </div>
</div>

<!-- Tabel -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tabelModul">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width:50px;">No</th>
                        <th>Judul Modul</th>
                        <th>Kelas</th>
                        <th style="width:100px;" class="text-center">Urutan</th>
                        <th style="width:130px;" class="text-center">Total Materi</th>
                        <th style="width:140px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($modul)): ?>
                        <?php foreach ($modul as $i => $m): ?>
                        <tr data-kelas="<?= $m['id_kelas'] ?>">
                            <td class="ps-4 text-muted"><?= $i + 1 ?></td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center"
                                         style="width:40px;height:40px;background:#e8f0fe;flex-shrink:0;">
                                        <i class="bi bi-collection text-primary" style="font-size:16px;"></i>
                                    </div>
                                    <span class="fw-medium"><?= esc($m['judul_modul']) ?></span>
                                </div>
                            </td>
                            <td>
                                <span class="badge rounded-pill"
                                      style="background:#e8f0fe;color:#1967d2;font-weight:500;font-size:12px;">
                                    <?= esc($m['nama_kelas']) ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-light text-dark border"><?= $m['urutan_modul'] ?? '-' ?></span>
                            </td>
                            <td class="text-center">
                                <span class="text-muted small">
                                    <i class="bi bi-file-earmark-text me-1"></i>
                                    <?= $m['total_materi'] ?? 0 ?> materi
                                </span>
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary me-1 btn-edit-modul"
                                        title="Edit"
                                        data-id="<?= $m['id_modul'] ?>"
                                        data-judul="<?= esc($m['judul_modul']) ?>"
                                        data-kelas="<?= $m['id_kelas'] ?>"
                                        data-urutan="<?= $m['urutan_modul'] ?? '' ?>">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-danger btn-delete-modul"
                                        title="Hapus"
                                        data-id="<?= $m['id_modul'] ?>"
                                        data-judul="<?= esc($m['judul_modul']) ?>">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr id="emptyRow">
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-collection display-6 d-block mb-3 opacity-25"></i>
                                    <div class="fw-medium mb-1">Belum ada modul</div>
                                    <div class="small">Klik tombol <strong>Tambah Modul</strong> untuk memulai</div>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- ===== MODAL TAMBAH ===== -->
<div class="modal fade" id="modalTambahModul" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-semibold">
                    <i class="bi bi-plus-circle text-primary me-2"></i>Tambah Modul Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <form action="<?= base_url('dashboard/pengajar/modul/store') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-medium small">Kelas <span class="text-danger">*</span></label>
                        <select class="form-select" name="id_kelas" required>
                            <option value="" disabled selected>-- Pilih Kelas --</option>
                            <?php if (!empty($kelas)): ?>
                                <?php foreach ($kelas as $k): ?>
                                    <option value="<?= $k['id_kelas'] ?>"><?= esc($k['nama_kelas']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium small">Judul Modul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul_modul"
                               placeholder="cth: Pengenalan Komponen Elektronika" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium small">Urutan Modul</label>
                        <input type="number" class="form-control" name="urutan_modul"
                               placeholder="cth: 1" min="1">
                        <div class="form-text">Urutan tampil modul dalam kelas</div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2 border-top mt-3">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i>Simpan Modul
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ===== MODAL EDIT ===== -->
<div class="modal fade" id="modalEditModul" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-semibold">
                    <i class="bi bi-pencil-square text-warning me-2"></i>Edit Modul
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <form id="formEditModul" method="POST">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label class="form-label fw-medium small">Kelas <span class="text-danger">*</span></label>
                        <select class="form-select" name="id_kelas" id="edit_id_kelas" required>
                            <option value="" disabled>-- Pilih Kelas --</option>
                            <?php if (!empty($kelas)): ?>
                                <?php foreach ($kelas as $k): ?>
                                    <option value="<?= $k['id_kelas'] ?>"><?= esc($k['nama_kelas']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium small">Judul Modul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul_modul" id="edit_judul_modul" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-medium small">Urutan Modul</label>
                        <input type="number" class="form-control" name="urutan_modul" id="edit_urutan_modul" min="1">
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2 border-top mt-3">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="bi bi-save me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ===== MODAL HAPUS ===== -->
<div class="modal fade" id="modalHapusModul" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-body text-center py-4 px-4">
                <div class="mb-3">
                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-10"
                          style="width:60px;height:60px;">
                        <i class="bi bi-trash text-danger" style="font-size:24px;"></i>
                    </span>
                </div>
                <h6 class="fw-semibold mb-1">Hapus Modul?</h6>
                <p class="text-muted small mb-3">
                    Modul <strong id="hapusJudulModul"></strong> akan dihapus permanen.
                </p>
                <form id="formHapusModul" method="POST">
                    <?= csrf_field() ?>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-light px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger px-3">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    // Edit
    document.querySelectorAll('.btn-edit-modul').forEach(btn => {
        btn.addEventListener('click', function () {
            const baseUrl = '<?= base_url('dashboard/pengajar/modul/update') ?>';
            document.getElementById('formEditModul').action    = `${baseUrl}/${this.dataset.id}`;
            document.getElementById('edit_judul_modul').value  = this.dataset.judul;
            document.getElementById('edit_urutan_modul').value = this.dataset.urutan;
            document.getElementById('edit_id_kelas').value     = this.dataset.kelas;
            new bootstrap.Modal(document.getElementById('modalEditModul')).show();
        });
    });

    // Hapus
    document.querySelectorAll('.btn-delete-modul').forEach(btn => {
        btn.addEventListener('click', function () {
            const baseUrl = '<?= base_url('dashboard/pengajar/modul/delete') ?>';
            document.getElementById('formHapusModul').action       = `${baseUrl}/${this.dataset.id}`;
            document.getElementById('hapusJudulModul').textContent = this.dataset.judul;
            new bootstrap.Modal(document.getElementById('modalHapusModul')).show();
        });
    });

    // Search + filter kelas
    function filterTable() {
        const keyword = document.getElementById('searchModul').value.toLowerCase();
        const kelasId = document.getElementById('filterKelas').value;
        const rows    = document.querySelectorAll('#tabelModul tbody tr:not(#emptyRow)');
        let visible   = 0;
        rows.forEach(row => {
            const judul = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
            const kelas = row.dataset.kelas || '';
            const ok    = judul.includes(keyword) && (!kelasId || kelas === kelasId);
            row.style.display = ok ? '' : 'none';
            if (ok) visible++;
        });
        document.getElementById('totalModul').textContent = visible;
    }
    document.getElementById('searchModul').addEventListener('input', filterTable);
    document.getElementById('filterKelas').addEventListener('change', filterTable);
});
</script>

<?= $this->endSection() ?>
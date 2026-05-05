<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>
<?= $this->section('content') ?>

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-semibold mb-1">Manajemen Tugas</h4>
        <p class="text-muted mb-0 small">Tambahkan tugas kelas per modul dan lacak pengumpulan peserta.</p>
    </div>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahTugas">
        <i class="bi bi-plus-lg me-1"></i> Tambah Tugas
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

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body p-3">
        <div class="row align-items-center g-3">
            <div class="col-md-4">
                <select class="form-select form-select-sm" id="filterKelas">
                    <option value="">Semua Kelas</option>
                    <?php foreach ($kelas as $k): ?>
                        <option value="<?= $k['id_kelas'] ?>"><?= esc($k['nama_kelas']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-select form-select-sm" id="filterModul">
                    <option value="">Semua Modul</option>
                    <?php foreach ($modul as $m): ?>
                        <option value="<?= $m['id_modul'] ?>" data-kelas="<?= $m['id_kelas'] ?>">
                            <?= esc($m['judul_modul']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-auto ms-auto text-muted small">
                Total tugas: <strong id="totalTugas"><?= count($tugas) ?></strong>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tabelTugas">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4" style="width:50px;">No</th>
                        <th>Judul Tugas</th>
                        <th>Kelas / Modul</th>
                        <th style="width:120px;">Deadline</th>
                        <th style="width:130px;">Posttest</th>
                        <th style="width:120px;">Dibuat</th>
                        <th style="width:130px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (! empty($tugas)): ?>
                        <?php foreach ($tugas as $i => $task): ?>
                        <tr data-kelas="<?= $task['id_kelas'] ?>" data-modul="<?= $task['id_modul'] ?>">
                            <td class="ps-4 text-muted"><?= $i + 1 ?></td>
                            <td>
                                <div class="fw-semibold"><?= esc($task['judul_tugas']) ?></div>
                                <div class="text-muted small"><?= esc($task['deskripsi_tugas']) ?></div>
                            </td>
                            <td>
                                <div class="small">
                                    <span class="badge bg-light text-dark"><?= esc($task['nama_kelas']) ?></span>
                                    <?php if ($task['judul_modul']): ?>
                                        <span class="badge bg-primary text-white ms-1"><?= esc($task['judul_modul']) ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary text-white ms-1">Kelas Umum</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td>
                                <?= $task['deadline_hari'] !== null ? esc($task['deadline_hari']) . ' hari' : 'Tidak ada' ?>
                            </td>
                            <td>
                                <?php if ($task['is_wajib_posttest']): ?>
                                    <span class="badge bg-warning text-dark">Wajib</span>
                                <?php else: ?>
                                    <span class="badge bg-success">Tidak wajib</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <span class="small text-muted"><?= date('d M Y', strtotime($task['created_at'])) ?></span>
                            </td>
                            <td class="text-center">
                                <form action="<?= base_url('dashboard/pengajar/tugas/delete/' . $task['id_tugas']) ?>" method="POST" class="d-inline">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus tugas ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <div class="fw-semibold mb-1">Belum ada tugas.</div>
                                Tambahkan tugas baru untuk mulai mengelola tugas siswa.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Tugas -->
<div class="modal fade" id="modalTambahTugas" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-semibold">
                    <i class="bi bi-plus-circle text-primary me-2"></i> Tambah Tugas Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-3">
                <form action="<?= base_url('dashboard/pengajar/tugas/store') ?>" method="POST">
                    <?= csrf_field() ?>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-medium small">Kelas <span class="text-danger">*</span></label>
                            <select class="form-select" id="tugasKelas" name="id_kelas" required>
                                <option value="" selected disabled>-- Pilih Kelas --</option>
                                <?php foreach ($kelas as $k): ?>
                                    <option value="<?= $k['id_kelas'] ?>"><?= esc($k['nama_kelas']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-medium small">Modul (opsional)</label>
                            <select class="form-select" id="tugasModul" name="id_modul" disabled>
                                <option value="" selected>Tidak terkait modul</option>
                                <?php foreach ($modul as $m): ?>
                                    <option value="<?= $m['id_modul'] ?>" data-kelas="<?= $m['id_kelas'] ?>">
                                        <?= esc($m['judul_modul']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium small">Judul Tugas <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="judul_tugas" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-medium small">Deskripsi Tugas <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="deskripsi_tugas" rows="4" required></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-medium small">Deadline (hari)</label>
                            <input type="number" class="form-control" name="deadline_hari" min="0" placeholder="Contoh: 7">
                            <div class="form-text">Berdasarkan tanggal daftar peserta.</div>
                        </div>
                        <div class="col-md-8 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="isWajibPosttest" name="is_wajib_posttest" value="1">
                                <label class="form-check-label" for="isWajibPosttest">
                                    Tugas hanya dapat dikerjakan setelah peserta menyelesaikan posttest
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top mt-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-save me-1"></i> Simpan Tugas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const modulOptions = Array.from(document.querySelectorAll('#tugasModul option[data-kelas]'));
    const tugasKelas = document.getElementById('tugasKelas');
    const tugasModul = document.getElementById('tugasModul');

    tugasKelas?.addEventListener('change', function () {
        const selected = this.value;
        tugasModul.disabled = !selected;
        tugasModul.querySelectorAll('option[data-kelas]').forEach(option => {
            option.hidden = option.dataset.kelas !== selected;
        });
        tugasModul.value = '';
    });

    const filterKelas = document.getElementById('filterKelas');
    const filterModul = document.getElementById('filterModul');
    const tabelTugas = document.getElementById('tabelTugas');
    const totalTugas = document.getElementById('totalTugas');

    function updateTugasFilter() {
        const kelasValue = filterKelas?.value;
        const modulValue = filterModul?.value;
        const rows = tabelTugas?.querySelectorAll('tbody tr');
        let visible = 0;

        rows?.forEach(row => {
            const rowKelas = row.dataset.kelas;
            const rowModul = row.dataset.modul;
            let show = true;

            if (kelasValue && rowKelas !== kelasValue) show = false;
            if (modulValue && rowModul !== modulValue) show = false;
            row.style.display = show ? '' : 'none';
            if (show) visible++;
        });

        if (totalTugas) totalTugas.textContent = visible;
    }

    filterKelas?.addEventListener('change', updateTugasFilter);
    filterModul?.addEventListener('change', updateTugasFilter);
</script>

<?= $this->endSection() ?>
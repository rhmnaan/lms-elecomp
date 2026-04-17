<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h4 class="fw-bold mb-1">Manajemen Voucher</h4>
        <p class="text-muted mb-0">Kelola voucher akses kelas untuk peserta.</p>
    </div>
    <button class="btn btn-primary d-flex align-items-center gap-2"
            data-bs-toggle="modal" data-bs-target="#modalTambahVoucher">
        <i class="bi bi-plus-lg"></i> Tambah Voucher
    </button>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <ul class="mb-0">
            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                <li><?= esc($err) ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- ─── Tabel Voucher ─────────────────────────────────────────── -->
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Kode</th>
                        <th>Nama Voucher</th>
                        <th>Kelas</th>
                        <th>Harga</th>
                        <th>Berlaku</th>
                        <th>Kuota</th>
                        <th>Klaim</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($vouchers)): ?>
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">
                            Belum ada voucher. Klik <strong>+ Tambah Voucher</strong> untuk memulai.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($vouchers as $i => $v): ?>
                    <?php
                        $now       = date('Y-m-d H:i:s');
                        $expired   = $v['tanggal_berakhir'] < $now;
                        $aktif     = $v['is_active'] && !$expired;
                    ?>
                    <tr>
                        <td class="text-muted small"><?= $i + 1 ?></td>
                        <td>
                            <span class="badge bg-secondary font-monospace fs-6">
                                <?= esc($v['kode_voucher']) ?>
                            </span>
                        </td>
                        <td>
                            <div class="fw-semibold"><?= esc($v['nama_voucher']) ?></div>
                            <?php if ($v['deskripsi']): ?>
                                <small class="text-muted"><?= esc(mb_strimwidth($v['deskripsi'], 0, 50, '…')) ?></small>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($v['nama_kelas']) ?></td>
                        <td>
                            <?php if ((float)$v['harga'] == 0): ?>
                                <span class="badge bg-success">Gratis</span>
                            <?php else: ?>
                                Rp <?= number_format($v['harga'], 0, ',', '.') ?>
                            <?php endif; ?>
                        </td>
                        <td class="small">
                            <?= date('d M Y', strtotime($v['tanggal_mulai'])) ?> –
                            <?= date('d M Y', strtotime($v['tanggal_berakhir'])) ?>
                            <?php if ($expired): ?>
                                <br><span class="badge bg-secondary">Kadaluarsa</span>
                            <?php endif; ?>
                        </td>
                        <td><?= $v['kuota'] !== null ? $v['kuota'] : '∞' ?></td>
                        <td><?= (int)$v['total_klaim'] ?></td>
                        <td>
                            <div class="form-check form-switch mb-0">
                                <input class="form-check-input toggle-active" type="checkbox"
                                       data-id="<?= $v['id_voucher'] ?>"
                                       <?= $v['is_active'] ? 'checked' : '' ?>
                                       <?= $expired ? 'disabled' : '' ?>>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary me-1 btn-edit"
                                    data-id="<?= $v['id_voucher'] ?>"
                                    data-nama="<?= esc($v['nama_voucher']) ?>"
                                    data-deskripsi="<?= esc($v['deskripsi']) ?>"
                                    data-harga="<?= $v['harga'] ?>"
                                    data-mulai="<?= $v['tanggal_mulai'] ?>"
                                    data-berakhir="<?= $v['tanggal_berakhir'] ?>"
                                    data-kuota="<?= $v['kuota'] ?>"
                                    title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-danger btn-delete"
                                    data-id="<?= $v['id_voucher'] ?>"
                                    data-nama="<?= esc($v['nama_voucher']) ?>"
                                    title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ─── Modal Tambah Voucher ──────────────────────────────────── -->
<div class="modal fade" id="modalTambahVoucher" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-ticket-perforated me-2"></i>Tambah Voucher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?= base_url('dashboard/pengajar/voucher/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row g-3">
                        <!-- Program -->
<div class="col-md-6">
    <label class="form-label fw-semibold">Program <span class="text-danger">*</span></label>
    <select id="selectProgram" class="form-select">
        <option value="">-- Pilih Program --</option>
        <?php foreach ($programList as $p): ?>
            <option value="<?= $p['id_program'] ?>">
                <?= esc($p['nama_program']) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<!-- Kelas (difilter berdasarkan program) -->
<div class="col-md-6">
    <label class="form-label fw-semibold">Kelas <span class="text-danger">*</span></label>
    <select name="id_kelas" id="selectKelas" class="form-select" required disabled>
        <option value="">-- Pilih Program dulu --</option>
    </select>
    <div id="loadingKelas" class="form-text text-muted d-none">
        <span class="spinner-border spinner-border-sm me-1"></span> Memuat kelas...
    </div>
</div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Kode Voucher <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="kode_voucher" class="form-control text-uppercase"
                                       placeholder="Cth: BELAJAR2026" value="<?= old('kode_voucher') ?>"
                                       style="text-transform:uppercase" required>
                                <button type="button" class="btn btn-outline-secondary" id="btnGenKode" title="Generate otomatis">
                                    <i class="bi bi-shuffle"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Voucher <span class="text-danger">*</span></label>
                            <input type="text" name="nama_voucher" class="form-control"
                                   placeholder="Cth: Voucher Gratis Semester 1"
                                   value="<?= old('nama_voucher') ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="harga" class="form-control"
                                   placeholder="0 = Gratis" min="0" step="0.01"
                                   value="<?= old('harga', 0) ?>" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Kuota</label>
                            <input type="number" name="kuota" class="form-control"
                                   placeholder="Kosong = tak terbatas" min="1"
                                   value="<?= old('kuota') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" class="form-control"
                                   value="<?= old('tanggal_mulai', date('Y-m-d')) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Berakhir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_berakhir" class="form-control"
                                   value="<?= old('tanggal_berakhir') ?>" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="2"
                                      placeholder="Opsional..."><?= old('deskripsi') ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-plus-circle me-1"></i> Buat Voucher
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ─── Modal Edit Voucher ────────────────────────────────────── -->
<div class="modal fade" id="modalEditVoucher" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Voucher</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEdit" action="" method="post">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Nama Voucher <span class="text-danger">*</span></label>
                            <input type="text" name="nama_voucher" id="editNama" class="form-control" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Harga (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="harga" id="editHarga" class="form-control" min="0" step="0.01" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-semibold">Kuota</label>
                            <input type="number" name="kuota" id="editKuota" class="form-control" placeholder="Tak terbatas" min="1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" id="editMulai" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Tanggal Berakhir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_berakhir" id="editBerakhir" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Deskripsi</label>
                            <textarea name="deskripsi" id="editDeskripsi" class="form-control" rows="2"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ─── Modal Konfirmasi Hapus ────────────────────────────────── -->
<div class="modal fade" id="modalHapus" tabindex="-1">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h6 class="modal-title text-danger"><i class="bi bi-exclamation-triangle me-1"></i>Hapus Voucher</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body pt-0">
                Yakin ingin menghapus voucher <strong id="hapusNama"></strong>?
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                <form id="formHapus" action="" method="post" class="d-inline">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // ── Filter Kelas by Program ────────────────────────────────────────────
document.getElementById('selectProgram')?.addEventListener('change', function () {
    const idProgram  = this.value;
    const selKelas   = document.getElementById('selectKelas');
    const loading    = document.getElementById('loadingKelas');

    selKelas.innerHTML = '<option value="">-- Pilih Kelas --</option>';
    selKelas.disabled  = true;

    if (!idProgram) return;

    loading.classList.remove('d-none');

    fetch(`<?= base_url('dashboard/pengajar/kelas-by-program') ?>/${idProgram}`)
        .then(r => r.json())
        .then(data => {
            loading.classList.add('d-none');
            if (data.success && data.kelas.length > 0) {
                data.kelas.forEach(k => {
                    const opt = document.createElement('option');
                    opt.value       = k.id_kelas;
                    opt.textContent = k.nama_kelas;
                    selKelas.appendChild(opt);
                });
                selKelas.disabled = false;
            } else {
                selKelas.innerHTML = '<option value="">Tidak ada kelas di program ini</option>';
            }
        })
        .catch(() => {
            loading.classList.add('d-none');
            selKelas.innerHTML = '<option value="">Gagal memuat kelas</option>';
        });
});
// ── Generate kode voucher acak ─────────────────────────────────────────
document.getElementById('btnGenKode')?.addEventListener('click', function () {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let code = '';
    for (let i = 0; i < 8; i++) code += chars.charAt(Math.floor(Math.random() * chars.length));
    document.querySelector('input[name="kode_voucher"]').value = code;
});

// ── Modal Edit ────────────────────────────────────────────────────────
document.querySelectorAll('.btn-edit').forEach(btn => {
    btn.addEventListener('click', function () {
        const id = this.dataset.id;
        document.getElementById('formEdit').action = `<?= base_url('dashboard/pengajar/voucher/update') ?>/${id}`;
        document.getElementById('editNama').value      = this.dataset.nama;
        document.getElementById('editDeskripsi').value = this.dataset.deskripsi || '';
        document.getElementById('editHarga').value     = this.dataset.harga;
        document.getElementById('editMulai').value     = this.dataset.mulai ? this.dataset.mulai.substring(0, 10) : '';
        document.getElementById('editBerakhir').value  = this.dataset.berakhir ? this.dataset.berakhir.substring(0, 10) : '';
        document.getElementById('editKuota').value     = this.dataset.kuota || '';
        new bootstrap.Modal(document.getElementById('modalEditVoucher')).show();
    });
});

// ── Modal Hapus ───────────────────────────────────────────────────────
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('hapusNama').textContent = this.dataset.nama;
        document.getElementById('formHapus').action = `<?= base_url('dashboard/pengajar/voucher/delete') ?>/${this.dataset.id}`;
        new bootstrap.Modal(document.getElementById('modalHapus')).show();
    });
});

// ── Toggle Aktif / Nonaktif ───────────────────────────────────────────
document.querySelectorAll('.toggle-active').forEach(toggle => {
    toggle.addEventListener('change', function () {
        const id  = this.dataset.id;
        const el  = this;
        fetch(`<?= base_url('dashboard/pengajar/voucher/toggle') ?>/${id}`, {
            method: 'POST',
            headers: {'X-Requested-With': 'XMLHttpRequest', 'Content-Type': 'application/json'},
            body: JSON.stringify({<?= csrf_token() ?>: '<?= csrf_hash() ?>'})
        })
        .then(r => r.json())
        .then(data => {
            if (!data.success) {
                el.checked = !el.checked; // rollback
                alert(data.message);
            }
        })
        .catch(() => { el.checked = !el.checked; });
    });
});
</script>

<?= $this->endSection() ?>
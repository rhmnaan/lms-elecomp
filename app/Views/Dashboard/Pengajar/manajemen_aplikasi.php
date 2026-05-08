<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>
<?= $this->section('content') ?>

<div class="page-header mb-4">
    <h4 class="fw-semibold">Manajemen Akses Aplikasi</h4>
    <p class="text-muted small mb-0">
        Tentukan aplikasi pendukung yang dapat diakses oleh user
    </p>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="alert alert-success">
    <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>

<form method="post" action="<?= base_url('dashboard/pengajar/aplikasi-pendukung/simpan-akses') ?>">

    <!-- PILIH USER -->
    <div class="mb-3">
        <label class="form-label fw-semibold">Pilih User</label>
        <select name="id_users" class="form-control" required>
            <option value="">-- Pilih User --</option>
            <?php foreach ($users as $u): ?>
            <option value="<?= $u['id_users'] ?>">
                <?= esc($u['username']) ?>
            </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- PILIH APLIKASI -->
    <div class="mb-3">
        <label class="form-label fw-semibold">
            Aplikasi yang Dapat Diakses
        </label>

        <div class="row">
            <?php foreach ($aplikasi as $app): ?>
            <div class="col-md-4">
                <div class="form-check mb-2">
                    <input class="form-check-input" type="checkbox" name="aplikasi[]" value="<?= $app['id_aplikasi'] ?>"
                        id="app<?= $app['id_aplikasi'] ?>">

                    <label class="form-check-label" for="app<?= $app['id_aplikasi'] ?>">
                        <?= esc($app['nama_aplikasi']) ?>
                    </label>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <button class="btn btn-primary">
        <i class="bi bi-save"></i> Simpan Akses
    </button>
</form>

<?= $this->endSection() ?>
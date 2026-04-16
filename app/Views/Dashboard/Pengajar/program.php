<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>

<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/pengajar-program.css') ?>">

<div class="page-header">
    <h1 class="page-title">Program Saya</h1>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg"></i> Tambah Program
    </button>
</div>

<div class="kelas-grid mt-4">
    <?php foreach ($program_list as $p): ?>
    <div class="kelas-card">
        <div class="kc-banner banner-blue">
            <div class="kc-nama"><?= esc($p['nama_program']) ?></div>
            <div class="kc-pengajar"><?= $p['total_kelas'] ?> Kelas</div>
        </div>

        <div class="kc-body">
            <p class="kc-desc">
                <?= esc($p['deskripsi_program'] ?: 'Tidak ada deskripsi program.') ?>
            </p>
        </div>

        <div class="kc-footer">
            <a href="<?= base_url('dashboard/pengajar/kelas?program=' . $p['id_program']) ?>"
                class="btn-lanjut btn-lanjut-blue">
                Kelola Kelas <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
    <?php endforeach ?>
</div>

<!-- MODAL TAMBAH PROGRAM -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" action="<?= base_url('dashboard/pengajar/program/store') ?>" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Program</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama Program</label>
                    <input type="text" name="nama_program" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="deskripsi_program" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>
<?= $this->section('content') ?>

<div class="page-header mb-4">
    <h4 class="fw-semibold">Aplikasi Pendukung</h4>
    <p class="text-muted mb-0 small">
        Daftar aplikasi yang tersedia
    </p>
</div>
<div class="d-flex justify-content-end mb-3">
    <button class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-circle"></i> Tambah Aplikasi
    </button>
</div>

<div class="row">
    <?php foreach ($aplikasi as $app): ?>
    <div class="col-md-4 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body d-flex flex-column">

                <h6 class="fw-semibold"><?= esc($app['nama_aplikasi']) ?></h6>

                <a href="<?= esc($app['link_aplikasi']) ?>" target="_blank" class="btn btn-sm btn-primary mt-auto mb-2">
                    Buka Aplikasi
                </a>

                <div class="d-flex gap-2">
                    <button class="btn btn-sm btn-warning w-100" data-bs-toggle="modal"
                        data-bs-target="#modalEdit<?= $app['id_aplikasi'] ?>">
                        Edit
                    </button>

                    <form action="<?= base_url('aplikasi-pendukung/delete/'.$app['id_aplikasi']) ?>" method="post"
                        onsubmit="return confirm('Hapus aplikasi ini?')">
                        <?= csrf_field() ?>
                        <button class="btn btn-sm btn-danger w-100">Hapus</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- MODAL EDIT -->
    <div class="modal fade" id="modalEdit<?= $app['id_aplikasi'] ?>">
        <div class="modal-dialog">
            <form method="post" action="<?= base_url('aplikasi-pendukung/update/'.$app['id_aplikasi']) ?>"
                class="modal-content">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5>Edit Aplikasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" name="nama_aplikasi" class="form-control mb-2"
                        value="<?= esc($app['nama_aplikasi']) ?>" required>
                    <input type="url" name="link_aplikasi" class="form-control"
                        value="<?= esc($app['link_aplikasi']) ?>" required>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <?php endforeach; ?>
</div>


<div class="modal fade" id="modalTambah">
    <div class="modal-dialog">
        <form action="<?= base_url('dashboard/pengajar/aplikasi-pendukung/store') ?>" method="post">
            <?= csrf_field() ?>
            <div class="modal-header">
                <h5>Tambah Aplikasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="text" name="nama_aplikasi" class="form-control mb-2" placeholder="Nama Aplikasi" required>
                <input type="url" name="link_aplikasi" class="form-control" placeholder="Link Aplikasi" required>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>
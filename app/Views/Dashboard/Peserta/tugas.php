<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('meta') ?>
<title>Tugas - <?= esc($kelas['nama_kelas']) ?></title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container">

    <div class="mb-4">
        <h2 class="fw-bold"><?= esc($kelas['nama_kelas']) ?></h2>
        <p class="text-muted">
            Total <?= $total_tugas ?> tugas
        </p>
    </div>

    <?php if (empty($tugas)): ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle"></i>
        Belum ada tugas untuk kelas ini
    </div>
    <?php else: ?>
    <div class="row">
        <?php foreach ($tugas as $t): ?>
        <div class="col-md-6 mb-3">
            <div class="card h-100">
                <div class="card-body">

                    <h5 class="card-title fw-bold">
                        <?= esc($t['judul_tugas']) ?>
                    </h5>

                    <?php if (!empty($t['deskripsi_tugas'])): ?>
                    <p class="card-text text-muted">
                        <?= esc($t['deskripsi_tugas']) ?>
                    </p>
                    <?php endif ?>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-muted">
                            <i class="bi bi-clock"></i>
                            <?= $t['deadline_hari'] > 0
                                        ? 'Deadline ' . $t['deadline_hari'] . ' hari'
                                        : 'Tanpa deadline' ?>
                        </small>
                        <a href="#" class="btn btn-sm btn-primary">
                            Kerjakan
                        </a>
                    </div>

                </div>
            </div>
        </div>
        <?php endforeach ?>
    </div>
    <?php endif ?>

</div>

<?= $this->endSection() ?>
<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('title') ?>Profil Saya<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">

    <!-- Alert Messages -->
    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1><i class="bi bi-person-circle me-2"></i>Profil Saya</h1>
            <p>Kelola informasi akun dan data diri Anda</p>
        </div>
        <div class="date-badge">
            <i class="bi bi-calendar3"></i>
            <?= date('d F Y') ?>
        </div>
    </div>

    <!-- Informasi Akun -->
    <div class="dash-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <div class="card-title">Informasi Akun</div>
                <div class="card-sub">Data diri peserta didik</div>
            </div>
            <a href="<?= base_url('dashboard/peserta/profil/edit') ?>" class="btn btn-primary btn-sm">
                <i class="bi bi-pencil-square me-1"></i> Edit Profil
            </a>
        </div>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="info-item">
                    <div class="info-label">Nama Lengkap</div>
                    <div class="info-value">
                        <?= esc($user['nama_users'] ?? '-') ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-item">
                    <div class="info-label">Email</div>
                    <div class="info-value">
                        <?= esc($user['email_users'] ?? '-') ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="info-item">
                    <div class="info-label">Bergabung Sejak</div>
                    <div class="info-value">
                        <?= isset($user['created_at']) 
                            ? date('d F Y', strtotime($user['created_at'])) 
                            : '-' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.info-item {
    background: #f9fafb;
    padding: 14px 18px;
    border-radius: 12px;
    transition: all 0.2s;
}

.info-item:hover {
    background: #f3f4f6;
}

.info-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.5px;
    color: #9ca3af;
    text-transform: uppercase;
    margin-bottom: 6px;
}

.info-value {
    font-size: 15px;
    font-weight: 600;
    color: #111;
}

.btn-primary {
    background: #2d6cdf;
    border: none;
    padding: 8px 16px;
    font-size: 13px;
    border-radius: 10px;
}

.btn-primary:hover {
    background: #1e5bc4;
}

.alert {
    border-radius: 12px;
    border: none;
}
</style>

<?= $this->endSection() ?>
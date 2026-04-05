<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('title') ?>Edit Profil<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid px-0">
    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1><i class="bi bi-pencil-square me-2"></i>Edit Profil</h1>
            <p>Perbarui informasi akun dan data diri Anda</p>
        </div>
        <div class="date-badge">
            <i class="bi bi-calendar3"></i>
            <?= date('d F Y') ?>
        </div>
    </div>

    <!-- Error Messages -->
    <?php if (session()->getFlashdata('errors')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0 mt-2">
            <?php foreach (session()->getFlashdata('errors') as $error): ?>
            <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Edit Form -->
    <div class="dash-card">
        <form action="<?= base_url('dashboard/peserta/profil/update') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="row g-4">
                <!-- Nama -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="nama_users" class="form-label">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" class="form-control <?= session('errors.nama_users') ? 'is-invalid' : '' ?>"
                            id="nama_users" name="nama_users"
                            value="<?= old('nama_users', esc($user['nama_users'] ?? '')) ?>"
                            placeholder="Masukkan nama lengkap" required>
                        <div class="invalid-feedback">
                            <?= session('errors.nama_users') ?>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="email_users" class="form-label">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input type="email"
                            class="form-control <?= session('errors.email_users') ? 'is-invalid' : '' ?>"
                            id="email_users" name="email_users"
                            value="<?= old('email_users', esc($user['email_users'] ?? '')) ?>"
                            placeholder="Masukkan email aktif" required>
                        <div class="invalid-feedback">
                            <?= session('errors.email_users') ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action -->
            <div class="d-flex justify-content-end gap-2 mt-4 pt-3">
                <a href="<?= base_url('dashboard/peserta/profil') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.form-group {
    margin-bottom: 0;
}

.form-label {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.form-control {
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    padding: 10px 14px;
    font-size: 14px;
    transition: all 0.2s;
}

.form-control:focus {
    border-color: #2d6cdf;
    box-shadow: 0 0 0 3px rgba(45, 108, 223, 0.1);
    outline: none;
}

.btn-secondary {
    background: #6b7280;
    border: none;
    padding: 10px 20px;
    border-radius: 10px;
    font-size: 14px;
    color: white;
}

.btn-secondary:hover {
    background: #4b5563;
}

.btn-primary {
    background: #2d6cdf;
    border: none;
    padding: 10px 24px;
    border-radius: 10px;
    font-size: 14px;
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
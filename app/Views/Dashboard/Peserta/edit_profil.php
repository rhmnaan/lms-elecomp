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

    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Edit Form -->
    <div class="dash-card">
        <form action="<?= base_url('dashboard/peserta/profil/update') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="row g-4">

                <!-- Nama Lengkap -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama_users" class="form-label">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                            class="form-control <?= session('errors.nama_users') ? 'is-invalid' : '' ?>"
                            id="nama_users" name="nama_users"
                            value="<?= old('nama_users', esc($user['nama_users'] ?? '')) ?>"
                            placeholder="Masukkan nama lengkap" required>
                        <div class="invalid-feedback">
                            <?= session('errors.nama_users') ?>
                        </div>
                    </div>
                </div>

                <!-- Username -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username" class="form-label">
                            Username <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">@</span>
                            <input type="text"
                                class="form-control <?= session('errors.username') ? 'is-invalid' : '' ?>"
                                id="username" name="username"
                                value="<?= old('username', esc($user['username'] ?? '')) ?>"
                                placeholder="username_kamu" maxlength="50"
                                oninput="this.value=this.value.replace(/[^a-zA-Z0-9_.]/g,'')">
                            <div class="invalid-feedback">
                                <?= session('errors.username') ?>
                            </div>
                        </div>
                        <div class="form-text">Huruf, angka, titik, dan underscore. Min. 3 karakter.</div>
                    </div>
                </div>

                <!-- Email -->
                <div class="col-md-6">
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

                <!-- Nomor HP -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nomor_hp" class="form-label">
                            Nomor HP / WhatsApp <span class="text-danger">*</span>
                        </label>
                        <input type="tel"
                            class="form-control <?= session('errors.nomor_hp') ? 'is-invalid' : '' ?>"
                            id="nomor_hp" name="nomor_hp"
                            value="<?= old('nomor_hp', esc($user['nomor_hp'] ?? '')) ?>"
                            placeholder="08123456789" maxlength="15"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')">
                        <div class="invalid-feedback">
                            <?= session('errors.nomor_hp') ?>
                        </div>
                        <div class="form-text">Angka saja, 9–15 digit.</div>
                    </div>
                </div>

            </div>

            <!-- Action -->
            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
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

.input-group .input-group-text {
    border-radius: 10px 0 0 10px;
    border: 1px solid #e5e7eb;
    border-right: none;
    font-size: 14px;
    color: #6b7280;
}

.input-group .form-control {
    border-radius: 0 10px 10px 0;
}

.form-control:focus {
    border-color: #2d6cdf;
    box-shadow: 0 0 0 3px rgba(45, 108, 223, 0.1);
    outline: none;
}

.form-text {
    font-size: 11.5px;
    color: #9ca3af;
    margin-top: 5px;
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
    color: white;
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
    margin-bottom: 20px;
}
</style>

<?= $this->endSection() ?>
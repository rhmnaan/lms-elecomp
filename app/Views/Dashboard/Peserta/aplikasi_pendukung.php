<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('content') ?>

<div class="page-header d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-semibold mb-1">Aplikasi Pendukung</h4>
        <p class="text-muted mb-0 small">Akses aplikasi yang tersedia untukmu.</p>
    </div>
</div>

<?php if (empty($aplikasi)): ?>
<div class="text-center py-5 text-muted">
    <i class="bi bi-grid-fill" style="font-size:48px;opacity:0.2;"></i>
    <div class="fw-semibold mt-3">Belum ada aplikasi yang bisa diakses.</div>
    <div class="small">Hubungi admin untuk mendapatkan akses.</div>
</div>
<?php else: ?>
<div class="row g-3">
    <?php foreach ($aplikasi as $app): ?>
    <div class="col-6 col-md-4 col-lg-3">
        <a href="<?= esc($app['link_aplikasi']) ?>" target="_blank" rel="noopener noreferrer"
            class="text-decoration-none">
            <div class="card border-0 shadow-sm h-100 text-center p-3 app-card">
                <div class="app-icon mx-auto mb-3">
                    <i class="bi bi-grid-fill"></i>
                </div>
                <div class="fw-semibold small"><?= esc($app['nama_aplikasi']) ?></div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<style>
.app-card {
    border-radius: 16px;
    transition: transform .2s, box-shadow .2s;
    cursor: pointer;
}
.app-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(0,0,0,.1) !important;
}
.app-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    background: #eff6ff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: #2d6cdf;
}
</style>

<?= $this->endSection() ?>
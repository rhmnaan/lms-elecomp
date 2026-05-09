<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>
<?= $this->section('content') ?>

<style>
.app-card {
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    background: #fff;
    transition: transform .2s, box-shadow .2s, border-color .2s;
    cursor: pointer;
    padding: 1.5rem 1rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 10px;
    height: 100%;
}

.app-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 24px rgba(59, 130, 246, .12) !important;
    border-color: #93c5fd;
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
    color: #2563eb;
    flex-shrink: 0;
}

.app-name {
    font-size: 13px;
    font-weight: 600;
    color: #1e293b;
    text-align: center;
    line-height: 1.4;
}

.app-open-hint {
    font-size: 11px;
    color: #94a3b8;
    display: flex;
    align-items: center;
    gap: 3px;
}

/* Empty state */
.empty-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 4rem 1rem;
    text-align: center;
}

.empty-icon-wrap {
    width: 80px;
    height: 80px;
    background: #f1f5f9;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.25rem;
}

.empty-icon-wrap i {
    font-size: 36px;
    color: #cbd5e1;
}

.empty-wrap h6 {
    font-size: 15px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 4px;
}

.empty-wrap p {
    font-size: 13px;
    color: #94a3b8;
    margin: 0;
}

/* Search */
.search-wrap {
    position: relative;
    width: 240px;
}

.search-wrap i {
    position: absolute;
    left: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 15px;
    pointer-events: none;
}

.search-wrap input {
    padding-left: 32px;
    font-size: 13px;
    height: 36px;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    width: 100%;
    background: #f8fafc;
    color: #334155;
}

.search-wrap input:focus {
    outline: none;
    border-color: #93c5fd;
    background: #fff;
}
</style>

<!-- Header -->
<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h4 class="fw-semibold mb-1">Aplikasi Pendukung</h4>
        <p class="text-muted mb-0 small">Akses aplikasi yang tersedia untukmu.</p>
    </div>
    <?php if (!empty($aplikasi)): ?>
    <div class="search-wrap d-none d-md-block">
        <i class="bi bi-search"></i>
        <input type="text" id="searchApp" placeholder="Cari aplikasi...">
    </div>
    <?php endif; ?>
</div>

<!-- Search mobile -->
<?php if (!empty($aplikasi)): ?>
<div class="search-wrap d-md-none mb-3" style="width:100%">
    <i class="bi bi-search"></i>
    <input type="text" id="searchAppMobile" placeholder="Cari aplikasi...">
</div>
<?php endif; ?>

<?php if (empty($aplikasi)): ?>

<!-- Empty state -->
<div class="empty-wrap">
    <div class="empty-icon-wrap">
        <i class="bi bi-grid"></i>
    </div>
    <h6>Belum ada aplikasi yang bisa diakses</h6>
    <p>Hubungi pengajar atau admin untuk mendapatkan akses aplikasi.</p>
</div>

<?php else: ?>

<div class="row g-3" id="appGrid">
    <?php foreach ($aplikasi as $app): ?>
    <div class="col-6 col-md-4 col-lg-3 app-item" data-name="<?= strtolower(esc($app['nama_aplikasi'])) ?>">
        <a href="<?= esc($app['link_aplikasi']) ?>" target="_blank" rel="noopener noreferrer"
            class="text-decoration-none d-block h-100">
            <div class="app-card">
                <div class="app-icon">
                    <i class="bi bi-grid-fill"></i>
                </div>
                <div class="app-name"><?= esc($app['nama_aplikasi']) ?></div>
                <div class="app-open-hint">
                    <i class="bi bi-box-arrow-up-right" style="font-size:10px"></i> Buka aplikasi
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<!-- Not found state -->
<div id="notFound" class="empty-wrap" style="display:none">
    <div class="empty-icon-wrap">
        <i class="bi bi-search"></i>
    </div>
    <h6>Aplikasi tidak ditemukan</h6>
    <p>Coba kata kunci lain.</p>
</div>

<?php endif; ?>

<script>
function filterApp(q) {
    const items = document.querySelectorAll('#appGrid .app-item');
    let visible = 0;
    items.forEach(item => {
        const match = item.dataset.name.includes(q.toLowerCase());
        item.style.display = match ? '' : 'none';
        if (match) visible++;
    });
    const nf = document.getElementById('notFound');
    if (nf) nf.style.display = visible === 0 ? 'flex' : 'none';
}

document.getElementById('searchApp')?.addEventListener('input', e => filterApp(e.target.value));
document.getElementById('searchAppMobile')?.addEventListener('input', e => filterApp(e.target.value));
</script>

<?= $this->endSection() ?>
<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>
<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h4 class="fw-bold mb-1">Manajemen Transaksi</h4>
        <p class="text-muted mb-0">Kelola semua transaksi peserta dalam sistem.</p>
    </div>
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

<!-- ─── Filter & Search ─────────────────────────────────────────── -->
<div class="card shadow-sm border-0 mb-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="filterStatus" class="form-label fw-semibold">Filter Status</label>
                <select class="form-select" id="filterStatus" onchange="filterTransaksi()">
                    <option value="">Semua Status</option>
                    <option value="pending">Pending</option>
                    <option value="success">Sukses</option>
                    <option value="failed">Gagal</option>
                </select>
            </div>
            <div class="col-md-6">
                <label for="searchTransaksi" class="form-label fw-semibold">Cari Transaksi</label>
                <input type="text" class="form-control" id="searchTransaksi" 
                       placeholder="Cari kode, nama produk, atau peserta..." 
                       onkeyup="filterTransaksi()">
            </div>
        </div>
    </div>
</div>

<!-- ─── Tabel Transaksi ─────────────────────────────────────────── -->
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="tabelTransaksi">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Kode Transaksi</th>
                        <th>Peserta</th>
                        <th>Produk</th>
                        <th>Kelas</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Tgl Bayar</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (empty($transaksi)): ?>
                    <tr>
                        <td colspan="12" class="text-center py-4 text-muted">
                            Belum ada data transaksi.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($transaksi as $i => $t): ?>
                    <tr class="transaksi-row" 
                        data-status="<?= strtolower($t['status']) ?>"
                        data-search="<?= strtolower(
                            $t['kode_transaksi'] . ' ' . 
                            $t['nama_produk'] . ' ' . 
                            $t['nama_peserta']
                        ) ?>">
                        <td class="text-muted small"><?= $i + 1 ?></td>
                        <td>
                            <span class="badge bg-info font-monospace">
                                <?= esc($t['kode_transaksi']) ?>
                            </span>
                        </td>
                        <td>
                            <div class="fw-semibold"><?= esc($t['nama_peserta']) ?></div>
                        </td>
                        <td>
                            <small><?= esc($t['nama_produk']) ?></small>
                        </td>
                        <td>
                            <small><?= esc($t['nama_kelas'] ?? '-') ?></small>
                        </td>
                        <td>
                            <span class="font-monospace">Rp <?= number_format($t['harga'] ?? 0, 0, ',', '.') ?></span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark"><?= $t['qty'] ?? 1 ?></span>
                        </td>
                        <td>
                            <strong class="text-primary">Rp <?= number_format($t['total'] ?? 0, 0, ',', '.') ?></strong>
                        </td>
                        <td>
                            <small>
                                <?php
                                    $metode_map = [
                                        'LYNK' => 'Lynk Academy',
                                        'manual' => 'Manual',
                                    ];
                                    echo esc($metode_map[$t['metode_pembayaran']] ?? $t['metode_pembayaran']);
                                ?>
                            </small>
                        </td>
                        <td>
                            <?php
                                $status = strtolower($t['status']);
                                $badge_class = match($status) {
                                    'success' => 'bg-success',
                                    'pending' => 'bg-warning',
                                    'failed' => 'bg-danger',
                                    default => 'bg-secondary'
                                };
                                $status_label = match($status) {
                                    'success' => 'Sukses',
                                    'pending' => 'Pending',
                                    'failed' => 'Gagal',
                                    default => ucfirst($status)
                                };
                            ?>
                            <span class="badge <?= $badge_class ?>">
                                <?= $status_label ?>
                            </span>
                        </td>
                        <td>
                            <small><?= date('d M Y H:i', strtotime($t['tanggal_transaksi'])) ?></small>
                        </td>
                        <td>
                            <small>
                                <?= $t['tanggal_bayar'] 
                                    ? date('d M Y H:i', strtotime($t['tanggal_bayar'])) 
                                    : '-' 
                                ?>
                            </small>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- ─── Statistik Transaksi ─────────────────────────────────────────── -->
<?php if (!empty($transaksi)): ?>
<div class="row mt-4 g-3">
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h6 class="text-muted mb-2">Total Transaksi</h6>
                <h3 class="fw-bold"><?= count($transaksi) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h6 class="text-muted mb-2">Transaksi Sukses</h6>
                <h3 class="fw-bold text-success">
                    <?= count(array_filter($transaksi, fn($t) => strtolower($t['status']) === 'success')) ?>
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h6 class="text-muted mb-2">Pending</h6>
                <h3 class="fw-bold text-warning">
                    <?= count(array_filter($transaksi, fn($t) => strtolower($t['status']) === 'pending')) ?>
                </h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <h6 class="text-muted mb-2">Total Revenue</h6>
                <h3 class="fw-bold text-primary">
                    Rp <?= number_format(
                        array_sum(array_map(fn($t) => $t['total'] ?? 0, $transaksi)), 
                        0, ',', '.'
                    ) ?>
                </h3>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    
    .page-header h4 {
        margin-bottom: 4px;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.03);
    }
</style>

<script>
function filterTransaksi() {
    const status = document.getElementById('filterStatus')?.value?.toLowerCase() || '';
    const search = document.getElementById('searchTransaksi')?.value?.toLowerCase() || '';
    
    const rows = document.querySelectorAll('.transaksi-row');
    
    rows.forEach(row => {
        let show = true;
        
        // Filter status
        if (status && row.getAttribute('data-status') !== status) {
            show = false;
        }
        
        // Filter search
        if (search && !row.getAttribute('data-search').includes(search)) {
            show = false;
        }
        
        row.style.display = show ? '' : 'none';
    });
}
</script>

<?= $this->endSection() ?>

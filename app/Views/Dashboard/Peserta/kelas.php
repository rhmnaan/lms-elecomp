<?php // app/Views/Dashboard/Peserta/kelas.php 
?>
<?php echo $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?php echo $this->section('meta') ?>
<title>Kelas Saya — LMS Elecomp</title>
<?php echo $this->endSection() ?>

<?php echo $this->section('styles') ?>
<style>
    .kelas-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
    }

    .kelas-card {
        background: #fff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 1px 8px rgba(0, 0, 0, .06);
        transition: transform .2s, box-shadow .2s;
    }

    .kelas-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, .11);
    }

    .kc-banner {
        padding: 22px 22px 18px;
        position: relative;
        overflow: hidden;
        min-height: 120px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }

    .kc-banner::before {
        content: '';
        position: absolute;
        right: -20px;
        top: -20px;
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .10);
    }

    .kc-banner::after {
        content: '';
        position: absolute;
        right: 55px;
        bottom: -30px;
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .06);
    }

    .banner-blue {
        background: linear-gradient(135deg, #1e40af, #3b82f6);
    }

    .banner-green {
        background: linear-gradient(135deg, #065f46, #10b981);
    }

    .banner-orange {
        background: linear-gradient(135deg, #92400e, #f59e0b);
    }

    .banner-purple {
        background: linear-gradient(135deg, #4c1d95, #8b5cf6);
    }

    .kc-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: rgba(255, 255, 255, .2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #fff;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
    }

    .kc-nama {
        font-size: 15px;
        font-weight: 800;
        color: #fff;
        font-family: 'DM Sans', sans-serif;
        position: relative;
        z-index: 1;
        line-height: 1.3;
    }

    .kc-body {
        padding: 16px 20px 0;
    }

    .kc-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 20px;
        border-top: 1px solid #f3f4f6;
    }

    .kc-meta {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .kc-meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        color: #6b7280;
        font-weight: 500;
    }

    .kc-meta-item i {
        font-size: 12px;
        color: #9ca3af;
    }

    .empty-state {
        text-align: center;
        padding: 70px 20px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 1px 8px rgba(0, 0, 0, .05);
    }

    .empty-icon {
        font-size: 48px;
        margin-bottom: 14px;
        color: #d1d5db;
    }

    .empty-title {
        font-size: 16px;
        font-weight: 800;
        color: #374151;
        margin-bottom: 5px;
    }

    .empty-desc {
        font-size: 13px;
        color: #9ca3af;
    }

    /* ===============================
   VOUCHER
================================ */
    .voucher-box {
        margin-top: 12px;
        padding: 12px;
        background: #f9fafb;
        border-radius: 12px;
        border: 1px dashed #d1d5db;
    }

    .voucher-box label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 6px;
    }

    .voucher-input {
        display: flex;
        gap: 8px;
    }

    .voucher-input input {
        flex: 1;
        padding: 8px 12px;
        border-radius: 10px;
        border: 1px solid #d1d5db;
        font-size: 12px;
    }

    .voucher-input input:focus {
        outline: none;
        border-color: #6366f1;
    }

    .voucher-input button {
        padding: 8px 14px;
        border-radius: 10px;
        background: linear-gradient(135deg, #6366f1, #4f46e5);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: all .2s;
    }

    .voucher-input button:hover {
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(79, 70, 229, .35);
    }

    /* MOBILE */
    @media (max-width: 576px) {
        .voucher-input {
            flex-direction: column;
        }

        .voucher-input button {
            width: 100%;
        }
    }

    /* ===============================
   BACK BUTTON
================================ */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        font-size: 12.5px;
        font-weight: 700;
        color: #374151;
        background: #f3f4f6;
        border-radius: 12px;
        text-decoration: none;
        transition: all .2s;
    }

    .btn-back i {
        font-size: 14px;
    }

    .btn-back:hover {
        background: #e5e7eb;
        transform: translateX(-2px);
    }

    /* wrapper header */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
        gap: 12px;
    }

    .page-header-left {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    @media (max-width: 576px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    /* ===============================
   CLAIM STATUS
================================ */
    .claim-status {
        display: flex;
        align-items: center;
    }

    .status-ready {
        font-size: 12px;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 8px;
        background: #f0f9ff;
        color: #0369a1;
    }

    .status-success {
        font-size: 12px;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 8px;
        background: #f0fdf4;
        color: #166534;
    }

    .status-error {
        font-size: 12px;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 8px;
        background: #fef2f2;
        color: #dc2626;
    }

    /* ===============================
</style>
<?php echo $this->endSection() ?>

<?php echo $this->section('content') ?>

<div class="page-header">

    <div class="page-header-left">
        <a href="<?php echo base_url('dashboard/peserta/program') ?>" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali ke Program
        </a>

        <div>
            <h1>Kelas Tersedia</h1>
            <p>Kelas yang dapat diklaim dengan voucher yang telah disediakan.</p>
        </div>
    </div>

    <div class="date-badge">
        <i class="bi bi-book-fill"></i>
        <span><?php echo $total_kelas ?> Kelas</span>
    </div>

</div>

<?php if (empty($kelas_list)): ?>
    <div class="empty-state">
        <div class="empty-icon"><i class="bi bi-journal-x"></i></div>
        <div class="empty-title">Tidak Ada Kelas Tersedia</div>
        <div class="empty-desc">Semua kelas dalam program ini sudah diklaim atau belum ada kelas yang tersedia.</div>
    </div>
<?php else: ?>

    <?php
    $banners = ['banner-blue', 'banner-green', 'banner-orange', 'banner-purple'];
    $icons = ['bi-lightning-charge-fill', 'bi-cpu-fill', 'bi-tools', 'bi-diagram-3-fill'];
    $btnCls = ['btn-lanjut-blue', 'btn-lanjut-green', 'btn-lanjut-orange', 'btn-lanjut-purple'];
    ?>

    <div class="kelas-grid">
        <?php foreach ($kelas_list as $i => $k):
            $ci = $i % 4;
            ?>
            <?php if (isset($k['tipe_kelas']) && $k['tipe_kelas'] === 'berbayar' || (isset($k['voucher']) && $k['voucher'] && ($k['voucher']['kuota'] ?? 0) > 0)): ?>
                <div class="kelas-card">

                    <!-- BANNER -->
                    <div class="kc-banner <?php echo $banners[$ci] ?>">
                        <div class="kc-icon"><i class="bi <?php echo $icons[$ci] ?>"></i></div>
                        <div class="kc-nama"><?php echo esc($k['nama_kelas']) ?></div>
                    </div>

                    <!-- BODY -->
                    <div class="kc-body">
                        <!-- TIPE KELAS -->
                        <?php if (isset($k['tipe_kelas']) && $k['tipe_kelas'] === 'berbayar'): ?>
                            <!-- KELAS BERBAYAR -->
                            <div class="voucher-box">
                                <div style="margin-bottom: 12px;">
                                    <div
                                        style="font-size: 11px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Kelas Berbayar
                                    </div>
                                    <div style="font-size: 18px; font-weight: 800; color: #111827; margin-top: 4px;">
                                        Rp <?php echo number_format($k['harga'] ?? 0, 0, ',', '.') ?>
                                    </div>
                                </div>

                                <?php if (!empty($k['lynk_url'])): ?>
                                    <a href="<?php echo esc($k['lynk_url']) ?>" target="_blank" style="
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 10px 14px;
        border-radius: 10px;
        background: linear-gradient(135deg, #3b82f6, #1e40af);
        color: #fff;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        transition: all .2s;
    " onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 8px 20px rgba(59, 130, 246, .35)'"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                        <i class="bi bi-cart-plus" style="margin-right: 6px;"></i> Beli Kelas
                                    </a>
                                <?php else: ?>
                                    <div style="padding: 12px; text-align: center; background: #fef2f2; border-radius: 8px;">
                                        <div style="font-size: 12px; color: #dc2626; font-weight: 600;">
                                            <i class="bi bi-info-circle" style="margin-right: 4px;"></i>
                                            Link pembayaran belum tersedia
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <!-- KELAS GRATIS -->
                            <div class="voucher-box">
                                <?php if (isset($k['voucher']) && $k['voucher']): ?>
                                    <div style="margin-bottom: 12px;">
                                        <div
                                            style="font-size: 11px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px;">
                                            Kelas Gratis</div>
                                        <div
                                            style="display: flex; justify-content: space-between; align-items: flex-start; margin-top: 4px;">
                                            <div>
                                                <div style="font-size: 12px; font-weight: 600; color: #6b7280;">Berakhir:</div>
                                                <div style="font-size: 14px; font-weight: 700; color: #111827;">
                                                    <?php echo date('d M Y', strtotime($k['voucher']['tanggal_berakhir'])) ?>
                                                </div>
                                            </div>
                                            <div style="text-align: right;">
                                                <div style="font-size: 12px; font-weight: 600; color: #6b7280;">Sisa:</div>
                                                <div style="font-size: 14px; font-weight: 700; color: #10b981;">
                                                    <?php echo $k['voucher']['kuota'] ?> Voucher
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="open-voucher-modal" data-kelas-id="<?php echo $k['id_kelas'] ?>"
                                        data-nama-kelas="<?php echo esc($k['nama_kelas']) ?>" style="
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 100%;
                    padding: 10px 14px;
                    border-radius: 10px;
                    background: linear-gradient(135deg, #10b981, #065f46);
                    color: #fff;
                    font-size: 12px;
                    font-weight: 700;
                    border: none;
                    cursor: pointer;">
                                        <i class="bi bi-ticket-perforated" style="margin-right:6px"></i>
                                        Claim dengan Voucher
                                    </button>
                                <?php else: ?>
                                    <div style="padding: 12px; text-align: center; background: #fef2f2; border-radius: 8px;">
                                        <div style="font-size: 12px; color: #dc2626; font-weight: 600;">
                                            <i class="bi bi-info-circle" style="margin-right: 4px;"></i>
                                            Voucher tidak tersedia saat ini
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- FOOTER -->
                    <div class="kc-footer">
                        <div class="kc-meta">
                            <div class="kc-meta-item">
                                <i class="bi bi-journal-text"></i> <?php echo $k['total_modul'] ?> Modul
                            </div>
                            <div class="kc-meta-item">
                                <i class="bi bi-book"></i> <?php echo $k['total_materi'] ?> Materi
                            </div>
                        </div>

                        <div class="claim-status" id="status-<?php echo $k['id_kelas'] ?>">
                            <?php if (isset($k['tipe_kelas']) && $k['tipe_kelas'] === 'berbayar'): ?>
                                <span class="status-ready">Tersedia</span>
                            <?php else: ?>
                                <?php if (isset($k['voucher']) && $k['voucher'] && ($k['voucher']['kuota'] ?? 0) > 0): ?>
                                    <span class="status-ready">Tersedia</span>
                                <?php else: ?>
                                    <span class="status-error">Habis</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                </div>
            <?php endif; ?>
        <?php endforeach ?>
        <!-- Modal Voucher -->
        <div class="modal fade" id="voucherModal" tabindex="-1" role="dialog" aria-labelledby="voucherModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content border-0 shadow">

                    <!-- Header -->
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="voucherModalLabel">
                            🎟️ Gunakan Voucher Kelas
                        </h5>
                        <button type="button" class="close text-white" data-dismiss="modal" id="closeModal">
                            <span>&times;</span>
                        </button>
                    </div>

                    <!-- Body -->
                    <div class="modal-body px-4">
                        <p class="text-muted small mb-3">
                            Masukkan kode voucher jika kamu memilikinya.
                            Jika tidak ada, sistem akan otomatis menggunakan kuota yang tersedia.
                        </p>

                        <form id="voucherForm">
                            <input type="hidden" name="id_kelas" id="modalIdKelas">

                            <div class="form-group">
                                <label for="kode_voucher">Kode Voucher</label>
                                <input type="text" class="form-control" id="kode_voucher" name="kode_voucher"
                                    placeholder="Contoh: GRATIS2026">
                                <small class="form-text text-muted">
                                    Kosongkan jika tidak punya voucher
                                </small>
                            </div>

                            <!-- Alert -->
                            <div id="voucherAlert" class="alert d-none mt-3"></div>

                            <!-- Button -->
                            <button type="submit" class="btn btn-primary btn-block mt-4">
                                <span id="btnText">Gunakan Voucher</span>
                                <span id="btnLoading" class="spinner-border spinner-border-sm d-none"></span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>

<?php endif ?>

<?php echo $this->endSection() ?>

<?php echo $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {


        // Handle legacy voucher claim forms (jika masih ada)
        document.querySelectorAll('.voucher-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                const kelasId = this.dataset.kelasId;
                const formData = new FormData(this);
                const submitBtn = this.querySelector('button[type="submit"]');
                const statusDiv = document.getElementById(`status-${kelasId}`);

                // Disable button
                submitBtn.disabled = true;
                submitBtn.textContent = 'Memproses...';

                // Update status
                statusDiv.innerHTML = '<span class="status-ready">Memproses claim...</span>';

                // Send AJAX request
                fetch('<?php echo base_url('dashboard/peserta/voucher/claim') ?>', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Success
                            statusDiv.innerHTML =
                                '<span class="status-success">✓ Berhasil diklaim!</span>';
                            this.style.display = 'none';

                            // Optional: redirect after success
                            setTimeout(() => {
                                window.location.href =
                                    '<?php echo base_url('dashboard/peserta/kelas-saya') ?>';
                            }, 1500);
                        } else {
                            // Error
                            statusDiv.innerHTML =
                                `<span class="status-error">${data.message}</span>`;
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'Claim Kelas';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        statusDiv.innerHTML =
                            '<span class="status-error">Terjadi kesalahan sistem</span>';
                        submitBtn.disabled = false;
                        submitBtn.textContent = 'Claim Kelas';
                    });
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const modal = document.getElementById('voucherModal');
        const modalIdKelas = document.getElementById('modalIdKelas');
        const closeModalBtn = document.getElementById('closeModal');

        // buka modal
        document.querySelectorAll('.open-voucher-modal').forEach(btn => {
            btn.addEventListener('click', () => {
                modalIdKelas.value = btn.dataset.kelasId;
                modal.style.display = 'flex';
                modal.classList.add('show');
            });
        });

        // tutup modal
        closeModalBtn.addEventListener('click', () => {
            modal.style.display = 'none';
            modal.classList.remove('show');
        });

        // tutup modal saat klik di luar
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
                modal.classList.remove('show');
            }
        });

        // submit voucher
        document.getElementById('voucherForm').addEventListener('submit', e => {
            e.preventDefault();

            const formData = new FormData(e.target);
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');
            const alertBox = document.getElementById('voucherAlert');

            // Show loading
            btnText.classList.add('d-none');
            btnLoading.classList.remove('d-none');

            // Hide previous alerts
            alertBox.classList.add('d-none');

            fetch('<?php echo base_url('dashboard/peserta/voucher/claim') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(r => r.json())
                .then(res => {
                    // Hide loading
                    btnText.classList.remove('d-none');
                    btnLoading.classList.add('d-none');

                    if (res.success) {
                        // Success - redirect to kelas-saya
                        alertBox.classList.remove('d-none', 'alert-danger');
                        alertBox.classList.add('alert-success');
                        alertBox.textContent = res.message || 'Voucher berhasil diklaim!';

                        // Redirect after short delay
                        setTimeout(() => {
                            window.location.href =
                                '<?php echo base_url('dashboard/peserta/kelas-saya') ?>';
                        }, 1000);
                    } else {
                        // Error
                        alertBox.classList.remove('d-none', 'alert-success');
                        alertBox.classList.add('alert-danger');
                        alertBox.textContent = res.message || 'Terjadi kesalahan';
                    }
                })
                .catch(() => {
                    // Hide loading
                    btnText.classList.remove('d-none');
                    btnLoading.classList.add('d-none');

                    alertBox.classList.remove('d-none', 'alert-success');
                    alertBox.classList.add('alert-danger');
                    alertBox.textContent = 'Terjadi kesalahan sistem, silakan coba lagi';
                });
        });

    });
</script>

<?php echo $this->endSection() ?>
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

/* ===============================
       PRICE BOX
    ================================ */
.price-box {
    padding: 14px 16px;
    background: #f9fafb;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
}

.price-label {
    font-size: 11px;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 2px;
}

.price-value {
    font-size: 18px;
    font-weight: 800;
    color: #111827;
    margin-bottom: 12px;
}

/* ===============================
       ACTION BUTTONS
    ================================ */
.btn-actions {
    display: flex;
    gap: 8px;
}

.btn-beli {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 9px 12px;
    border-radius: 10px;
    background: linear-gradient(135deg, #3b82f6, #1e40af);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: all .2s;
}

.btn-beli:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(59, 130, 246, .35);
    color: #fff;
    text-decoration: none;
}

.btn-beli.disabled,
.btn-beli[disabled] {
    background: #d1d5db;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

.btn-voucher {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 9px 12px;
    border-radius: 10px;
    background: linear-gradient(135deg, #10b981, #065f46);
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    transition: all .2s;
}

.btn-voucher:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(16, 185, 129, .35);
}

.btn-voucher:disabled {
    background: #d1d5db;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* ===============================
       EMPTY STATE
    ================================ */
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
    text-decoration: none;
}

/* ===============================
       PAGE HEADER
    ================================ */
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

    .btn-actions {
        flex-direction: column;
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
       MODAL VOUCHER (custom — tidak pakai Bootstrap show/hide)
    ================================ */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, .45);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.modal-overlay.active {
    display: flex;
}

.modal-box {
    background: #fff;
    border-radius: 20px;
    width: 100%;
    max-width: 440px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, .2);
    animation: modalIn .2s ease;
}

@keyframes modalIn {
    from {
        transform: scale(.94);
        opacity: 0;
    }

    to {
        transform: scale(1);
        opacity: 1;
    }
}

.modal-head {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 22px;
    background: linear-gradient(135deg, #10b981, #065f46);
    color: #fff;
}

.modal-head h5 {
    margin: 0;
    font-size: 15px;
    font-weight: 800;
}

.modal-close {
    background: rgba(255, 255, 255, .2);
    border: none;
    color: #fff;
    border-radius: 8px;
    width: 30px;
    height: 30px;
    cursor: pointer;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .2s;
}

.modal-close:hover {
    background: rgba(255, 255, 255, .35);
}

.modal-body {
    padding: 22px;
}

.modal-nama-kelas {
    font-size: 13px;
    font-weight: 700;
    color: #111827;
    background: #f3f4f6;
    padding: 10px 14px;
    border-radius: 10px;
    margin-bottom: 16px;
}

.modal-note {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 16px;
    line-height: 1.6;
}

.modal-input-group {
    margin-bottom: 8px;
}

.modal-input-group label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 6px;
}

.modal-input-group input {
    width: 100%;
    padding: 10px 14px;
    border-radius: 10px;
    border: 1.5px solid #d1d5db;
    font-size: 13px;
    outline: none;
    transition: border-color .2s;
    box-sizing: border-box;
}

.modal-input-group input:focus {
    border-color: #10b981;
}

.modal-hint {
    font-size: 11px;
    color: #9ca3af;
    margin-top: 4px;
}

.modal-alert {
    display: none;
    padding: 10px 14px;
    border-radius: 10px;
    font-size: 12px;
    font-weight: 600;
    margin-top: 14px;
}

.modal-alert.success {
    display: block;
    background: #f0fdf4;
    color: #166534;
    border: 1px solid #bbf7d0;
}

.modal-alert.error {
    display: block;
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.btn-submit-voucher {
    width: 100%;
    padding: 11px;
    border-radius: 10px;
    background: linear-gradient(135deg, #10b981, #065f46);
    color: #fff;
    font-size: 13px;
    font-weight: 700;
    border: none;
    cursor: pointer;
    margin-top: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all .2s;
}

.btn-submit-voucher:hover:not(:disabled) {
    transform: translateY(-1px);
    box-shadow: 0 8px 20px rgba(16, 185, 129, .35);
}

.btn-submit-voucher:disabled {
    background: #d1d5db;
    cursor: not-allowed;
}
</style>
<?php echo $this->endSection() ?>

<?php echo $this->section('content') ?>

<!-- ===== PAGE HEADER ===== -->
<div class="page-header">
    <div class="page-header-left">
        <a href="<?php echo base_url('dashboard/peserta/program') ?>" class="btn-back">
            <i class="bi bi-arrow-left"></i> Kembali ke Program
        </a>
        <div>
            <h1>Kelas Tersedia</h1>
            <p>Beli kelas atau gunakan voucher untuk bergabung.</p>
        </div>
    </div>

    <div class="date-badge">
        <i class="bi bi-book-fill"></i>
        <span><?php echo $total_kelas ?> Kelas</span>
    </div>
</div>

<?php if (empty($kelas_list)): ?>
<!-- ===== EMPTY STATE ===== -->
<div class="empty-state">
    <div class="empty-icon"><i class="bi bi-journal-x"></i></div>
    <div class="empty-title">Tidak Ada Kelas Tersedia</div>
    <div class="empty-desc">Belum ada kelas yang tersedia dalam program ini.</div>
</div>

<?php else: ?>

<?php
    $banners = ['banner-blue', 'banner-green', 'banner-orange', 'banner-purple'];
    $icons   = ['bi-lightning-charge-fill', 'bi-cpu-fill', 'bi-tools', 'bi-diagram-3-fill'];
?>

<div class="kelas-grid">
    <?php foreach ($kelas_list as $i => $k):
            $ci = $i % 4;

            // Apakah ada voucher aktif untuk kelas ini?
            $hasVoucher = ($k['voucher_count'] ?? 0) > 0;

            // Apakah ada link pembelian?
            $hasLynk = ! empty($k['lynk_url']);
    ?>
    <div class="kelas-card">

        <!-- BANNER -->
        <div class="kc-banner <?php echo $banners[$ci] ?>">
            <div class="kc-icon"><i class="bi <?php echo $icons[$ci] ?>"></i></div>
            <div class="kc-nama"><?php echo esc($k['nama_kelas']) ?></div>
        </div>

        <!-- BODY -->
        <div class="kc-body">
            <div class="price-box">
                <div class="price-label">Harga</div>
                <div class="price-value">Rp <?php echo number_format($k['harga'] ?? 0, 0, ',', '.') ?></div>

                <div class="btn-actions">

                    <!-- TOMBOL 1: BELI KELAS -->
                    <?php if ($hasLynk): ?>
                    <a href="<?php echo esc($k['lynk_url']) ?>" target="_blank" class="btn-beli">
                        <i class="bi bi-cart-plus"></i> Beli Kelas
                    </a>
                    <?php else: ?>
                    <button class="btn-beli" disabled title="Link pembayaran belum tersedia">
                        <i class="bi bi-cart-plus"></i> Beli Kelas
                    </button>
                    <?php endif; ?>

                    <!-- TOMBOL 2: CLAIM VOUCHER -->
                    <?php if ($hasVoucher): ?>
                    <button class="btn-voucher open-voucher-modal" data-kelas-id="<?php echo $k['id_kelas'] ?>"
                        data-nama-kelas="<?php echo esc($k['nama_kelas']) ?>">
                        <i class="bi bi-ticket-perforated"></i>  Gunakan Voucher
                    </button>
                    <?php else: ?>
                    <button class="btn-voucher" disabled title="Voucher tidak tersedia">
                        <i class="bi bi-ticket-perforated"></i> GunakanVoucher
                    </button>
                    <?php endif; ?>

                </div><!-- /.btn-actions -->
            </div><!-- /.price-box -->
        </div><!-- /.kc-body -->

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

        </div>

    </div><!-- /.kelas-card -->
    <?php endforeach?>
</div><!-- /.kelas-grid -->

<?php endif?>

<!-- ===================================================
     MODAL VOUCHER (shared, satu untuk semua kelas)
===================================================== -->
<div class="modal-overlay" id="voucherModalOverlay">
    <div class="modal-box">

        <!-- Head -->
        <div class="modal-head">
            <h5><i class="bi bi-ticket-perforated-fill" style="margin-right:6px"></i> Gunakan Voucher</h5>
            <button class="modal-close" id="closeVoucherModal" type="button">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="modal-body">
            <div class="modal-nama-kelas" id="modalNamaKelas">—</div>

            <p class="modal-note">
                Masukkan kode voucher yang telah kamu terima. Voucher wajib diisi — sistem tidak akan
                memproses tanpa kode yang valid.
            </p>

            <input type="hidden" id="modalIdKelas" value="">

            <div class="modal-input-group">
                <label for="inputKodeVoucher">Kode Voucher <span style="color:#dc2626">*</span></label>
                <input type="text" id="inputKodeVoucher" placeholder="Contoh: ELECOMP2026" autocomplete="off"
                    style="text-transform:uppercase">
                <div class="modal-hint">Kode bersifat wajib. Pastikan kode benar sebelum submit.</div>
            </div>

            <!-- Alert -->
            <div id="voucherAlert" class="modal-alert"></div>

            <!-- Submit -->
            <button class="btn-submit-voucher" id="btnSubmitVoucher" type="button">
                <i class="bi bi-check-circle"></i>
                <span id="btnVoucherText">Gunakan Voucher</span>
                <span id="btnVoucherLoading" style="display:none">
                    <span class="spinner-border spinner-border-sm"></span> Memproses…
                </span>
            </button>
        </div>

    </div>
</div>

<?php echo $this->endSection() ?>

<?php echo $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {

    const overlay = document.getElementById('voucherModalOverlay');
    const closeBtn = document.getElementById('closeVoucherModal');
    const inputKelas = document.getElementById('modalIdKelas');
    const namaKelasEl = document.getElementById('modalNamaKelas');
    const inputVoucher = document.getElementById('inputKodeVoucher');
    const alertBox = document.getElementById('voucherAlert');
    const submitBtn = document.getElementById('btnSubmitVoucher');
    const btnText = document.getElementById('btnVoucherText');
    const btnLoading = document.getElementById('btnVoucherLoading');

    /* ---------- BUKA MODAL ---------- */
    document.querySelectorAll('.open-voucher-modal').forEach(btn => {
        btn.addEventListener('click', function() {
            inputKelas.value = this.dataset.kelasId;
            namaKelasEl.textContent = this.dataset.namaKelas;
            inputVoucher.value = '';
            resetAlert();
            overlay.classList.add('active');
            inputVoucher.focus();
        });
    });

    /* ---------- TUTUP MODAL ---------- */
    function closeModal() {
        overlay.classList.remove('active');
    }

    closeBtn.addEventListener('click', closeModal);

    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) closeModal();
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });

    /* ---------- RESET ALERT ---------- */
    function resetAlert() {
        alertBox.className = 'modal-alert';
        alertBox.textContent = '';
    }

    function showAlert(type, msg) {
        alertBox.className = 'modal-alert ' + type;
        alertBox.textContent = msg;
    }

    /* ---------- SUBMIT VOUCHER ---------- */
    submitBtn.addEventListener('click', function() {
        const kodeVoucher = inputVoucher.value.trim();
        const idKelas = inputKelas.value;

        // Validasi sisi klien: kode wajib diisi
        if (!kodeVoucher) {
            showAlert('error', 'Kode voucher wajib diisi.');
            inputVoucher.focus();
            return;
        }

        // Loading state
        submitBtn.disabled = true;
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline-flex';
        resetAlert();

        const formData = new FormData();
        formData.append('id_kelas', idKelas);
        formData.append('kode_voucher', kodeVoucher);

        fetch('<?php echo base_url('dashboard/peserta/voucher/claim') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(r => r.json())
            .then(res => {
                // Kembalikan tombol
                submitBtn.disabled = false;
                btnText.style.display = 'inline';
                btnLoading.style.display = 'none';

                if (res.success) {
                    showAlert('success', res.message || 'Voucher berhasil diklaim! Mengarahkan…');

                    // Update status badge di card
                    const statusEl = document.getElementById('status-' + idKelas);
                    if (statusEl) statusEl.innerHTML =
                        '<span class="status-success">✓ Terklaim</span>';

                    // Redirect setelah delay singkat
                    setTimeout(() => {
                        window.location.href =
                            '<?php echo base_url('dashboard/peserta/kelas-saya') ?>';
                    }, 1200);
                } else {
                    showAlert('error', res.message || 'Kode voucher tidak valid atau kuota habis.');
                }
            })
            .catch(() => {
                submitBtn.disabled = false;
                btnText.style.display = 'inline';
                btnLoading.style.display = 'none';
                showAlert('error', 'Terjadi kesalahan sistem. Silakan coba lagi.');
            });
    });

    /* Tekan Enter di input = langsung submit */
    inputVoucher.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') submitBtn.click();
    });

    /* Auto uppercase input */
    inputVoucher.addEventListener('input', function() {
        const pos = this.selectionStart;
        this.value = this.value.toUpperCase();
        this.setSelectionRange(pos, pos);
    });

});
</script>
<?php echo $this->endSection() ?>
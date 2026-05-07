<?php // app/Views/Dashboard/Peserta/kelas.php
?>
<?php echo $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?php echo $this->section('meta') ?>
<title>Kelas Saya — LMS Elecomp</title>
<?php echo $this->endSection() ?>

<?php echo $this->section('styles') ?>
<style>
/* ============================================================
   KELAS GRID
   ============================================================ */
.kelas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 16px;
}

/* ============================================================
   CARD
   ============================================================ */
.kelas-card {
    background: #fff;
    border-radius: 14px;
    border: 1px solid #f0f0f0;
    overflow: hidden;
    transition: transform .18s, box-shadow .18s, border-color .18s;
}

.kelas-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(0, 0, 0, .08);
    border-color: #e0e0e0;
}

/* ============================================================
   BANNER
   ============================================================ */
.kc-banner {
    position: relative;
    height: 128px;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 12px 14px;
    overflow: hidden;
}

.banner-blue {
    background: #185FA5;
}

.banner-green {
    background: #0F6E56;
}

.banner-orange {
    background: #854F0B;
}

.banner-purple {
    background: #534AB7;
}

/* Banner dengan gambar */
.kc-banner.has-image {
    background-size: cover;
    background-position: center;
}

.kc-banner.has-image::before {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0, 0, 0, .72) 0%, rgba(0, 0, 0, .18) 60%, transparent 100%);
    z-index: 1;
}

/* Badge durasi */
.badge-duration {
    position: absolute;
    top: 10px;
    left: 10px;
    z-index: 3;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 9px;
    border-radius: 999px;
    background: rgba(0, 0, 0, .48);
    color: #fff;
    font-size: 11px;
    font-weight: 500;
    backdrop-filter: blur(4px);
}

.badge-duration i {
    font-size: 11px;
}

/* Icon */
.kc-icon {
    width: 34px;
    height: 34px;
    border-radius: 9px;
    background: rgba(255, 255, 255, .18);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    color: #fff;
    margin-bottom: 7px;
    position: relative;
    z-index: 2;
}

/* Nama kelas */
.kc-nama {
    font-size: 13.5px;
    font-weight: 600;
    color: #fff;
    line-height: 1.35;
    position: relative;
    z-index: 2;
}

/* ============================================================
   BODY
   ============================================================ */
.kc-body {
    padding: 12px 14px 0;
}

/* Deskripsi — hanya tampil jika ada */
.kc-desc {
    font-size: 12px;
    color: #6b7280;
    line-height: 1.6;
    margin-bottom: 10px;

    /* CLAMP */
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;

    /* INI KUNCI KONSISTENSI */
    min-height: 38px;
}

/* ============================================================
   PRICE BOX
   ============================================================ */
.price-box {
    background: #f9fafb;
    border: 1px solid #f0f0f0;
    border-radius: 10px;
    padding: 11px 12px;
}

.price-label {
    font-size: 10px;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 2px;
}

.price-value {
    font-size: 16px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 10px;
}

/* ============================================================
   ACTION BUTTONS
   ============================================================ */
.btn-actions {
    display: flex;
    gap: 6px;
}

.btn-beli,
.btn-voucher {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 8px 10px;
    border-radius: 8px;
    font-size: 11.5px;
    font-weight: 600;
    border: 1px solid transparent;
    cursor: pointer;
    text-decoration: none;
    transition: background .15s, transform .15s;
}

.btn-beli {
    background: #185FA5;
    color: #fff;
    border-color: #185FA5;
}

.btn-beli:hover {
    background: #0C447C;
    border-color: #0C447C;
    color: #fff;
    text-decoration: none;
    transform: translateY(-1px);
}

.btn-voucher {
    background: #0F6E56;
    color: #fff;
    border-color: #0F6E56;
}

.btn-voucher:hover {
    background: #085041;
    border-color: #085041;
    transform: translateY(-1px);
}

/* Disabled — konsisten untuk keduanya */
.btn-beli[disabled],
.btn-voucher[disabled] {
    background: #f3f4f6;
    color: #9ca3af;
    border-color: #e5e7eb;
    cursor: not-allowed;
    transform: none;
    box-shadow: none;
}

/* ============================================================
   FOOTER META
   ============================================================ */
.kc-footer {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 9px 14px;
    border-top: 1px solid #f3f4f6;
    margin-top: 10px;
}

.kc-meta {
    display: flex;
    align-items: center;
    gap: 12px;
}

.kc-meta-item {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    color: #9ca3af;
    font-weight: 500;
}

.kc-meta-item i {
    font-size: 11px;
}

/* ============================================================
   EMPTY STATE
   ============================================================ */
.empty-state {
    text-align: center;
    padding: 56px 20px;
    background: #fff;
    border-radius: 14px;
    border: 1px solid #f0f0f0;
}

.empty-icon {
    font-size: 40px;
    color: #d1d5db;
    margin-bottom: 12px;
}

.empty-title {
    font-size: 15px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 4px;
}

.empty-desc {
    font-size: 12.5px;
    color: #9ca3af;
}

/* ============================================================
   PAGE HEADER
   ============================================================ */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    gap: 12px;
}

.page-header-left {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    font-size: 12px;
    font-weight: 600;
    color: #374151;
    background: #f3f4f6;
    border-radius: 8px;
    text-decoration: none;
    transition: background .15s, transform .15s;
    width: fit-content;
}

.btn-back:hover {
    background: #e5e7eb;
    transform: translateX(-2px);
    text-decoration: none;
}

/* ============================================================
   MODAL VOUCHER
   ============================================================ */
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
    border-radius: 16px;
    width: 100%;
    max-width: 420px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
    animation: modalIn .18s ease;
}

@keyframes modalIn {
    from {
        transform: scale(.95);
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
    padding: 14px 18px;
    background: #0F6E56;
    color: #fff;
}

.modal-head h5 {
    margin: 0;
    font-size: 13.5px;
    font-weight: 600;
    color: #fff;
}

.modal-close {
    background: rgba(255, 255, 255, .18);
    border: none;
    color: #fff;
    border-radius: 6px;
    width: 26px;
    height: 26px;
    cursor: pointer;
    font-size: 13px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background .15s;
}

.modal-close:hover {
    background: rgba(255, 255, 255, .3);
}

.modal-body {
    padding: 18px;
}

.modal-nama-kelas {
    font-size: 12.5px;
    font-weight: 600;
    color: #111827;
    background: #f9fafb;
    padding: 9px 12px;
    border-radius: 8px;
    border: 1px solid #f0f0f0;
    margin-bottom: 12px;
}

.modal-note {
    font-size: 12px;
    color: #6b7280;
    margin-bottom: 14px;
    line-height: 1.6;
}

.modal-input-group {
    margin-bottom: 6px;
}

.modal-input-group label {
    display: block;
    font-size: 11.5px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 5px;
}

.modal-input-group input {
    width: 100%;
    padding: 9px 12px;
    border-radius: 8px;
    border: 1px solid #d1d5db;
    font-size: 13px;
    outline: none;
    transition: border-color .15s;
    box-sizing: border-box;
}

.modal-input-group input:focus {
    border-color: #0F6E56;
}

.modal-hint {
    font-size: 11px;
    color: #9ca3af;
    margin-top: 4px;
}

.modal-alert {
    display: none;
    padding: 9px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    margin-top: 12px;
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
    padding: 10px;
    border-radius: 8px;
    background: #0F6E56;
    color: #fff;
    font-size: 13px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    margin-top: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    transition: background .15s, transform .15s;
}

.btn-submit-voucher:hover:not(:disabled) {
    background: #085041;
    transform: translateY(-1px);
}

.btn-submit-voucher:disabled {
    background: #e5e7eb;
    color: #9ca3af;
    cursor: not-allowed;
}

/* ============================================================
   RESPONSIVE
   ============================================================ */
@media (max-width: 576px) {
    .page-header {
        flex-direction: column;
        align-items: flex-start;
    }

    .btn-actions {
        flex-direction: column;
    }
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

    <?php
    function formatDurasi($hari)
    {
        if (empty($hari) || $hari <= 0) {
            return 'Durasi fleksibel';
        }

        if ($hari % 30 === 0) {
            return ($hari / 30) . ' Bulan';
        }

        if ($hari % 7 === 0) {
            return ($hari / 7) . ' Minggu';
        }

        return $hari . ' Hari';
    }
    
    ?>
    <?php foreach ($kelas_list as $i => $k):
            $ci = $i % 4;

            // Apakah ada voucher aktif untuk kelas ini?
            $hasVoucher = ($k['voucher_count'] ?? 0) > 0;

            // Apakah ada link pembelian?
            $hasLynk = ! empty($k['lynk_url']);
    ?>
    <div class="kelas-card">

        <!-- BANNER dengan Gambar atau Warna Default -->
        <?php if (!empty($k['gambar_kelas'])): ?>
        <div class="kc-banner has-image"
            style="background:url('<?php echo base_url('uploads/kelas/' . $k['gambar_kelas']) ?>') center/cover;">
            <div style="position:absolute;inset:0;background:rgba(0,0,0,.35)"></div>

            <!-- BADGE DURASI -->
            <div class="badge-duration">
                <i class="bi bi-stopwatch"></i>
                <?php echo formatDurasi($k['durasi_hari']) ?>
            </div>

            <div style="position: relative; z-index: 1;">
                <div class="kc-nama"><?php echo esc($k['nama_kelas']) ?></div>
            </div>
        </div>
        <?php else: ?>
        <div class="kc-banner <?php echo $banners[$ci] ?>">
            <div class="kc-icon"><i class="bi <?php echo $icons[$ci] ?>"></i></div>

            <div class="badge-duration">
                <i class="bi bi-stopwatch"></i>
                <?php echo formatDurasi($k['durasi_hari']) ?>
            </div>

            <div class="kc-nama"><?php echo esc($k['nama_kelas']) ?></div>
        </div>
        <?php endif; ?>

        <!-- BODY -->
        <div class="kc-body">
            <?php if (!empty($k['deskripsi_kelas'])): ?>
            <p class="kc-desc">
                <?php echo !empty($k['deskripsi_kelas']) 
                ? esc($k['deskripsi_kelas']) 
                : '&nbsp;'; ?>
            </p>
            <?php endif; ?>

            <div class="price-box">
                <div class="price-label">Harga</div>
                <div class="price-value">Rp <?php echo number_format($k['harga'] ?? 0, 0, ',', '.') ?></div>

                <div class="btn-actions">
                    <?php if ($hasLynk): ?>
                    <a href="<?php echo esc($k['lynk_url']) ?>" target="_blank" class="btn-beli">
                        <i class="bi bi-cart-plus"></i> Beli Kelas
                    </a>
                    <?php else: ?>
                    <button class="btn-beli" disabled>
                        <i class="bi bi-cart-plus"></i> Beli Kelas
                    </button>
                    <?php endif; ?>

                    <?php if ($hasVoucher): ?>
                    <button class="btn-voucher open-voucher-modal" data-kelas-id="<?php echo $k['id_kelas'] ?>"
                        data-nama-kelas="<?php echo esc($k['nama_kelas']) ?>">
                        <i class="bi bi-ticket-perforated"></i> Gunakan Voucher
                    </button>
                    <?php else: ?>
                    <button class="btn-voucher" disabled title="Voucher tidak tersedia">
                        <i class="bi bi-ticket-perforated"></i> Voucher
                    </button>
                    <?php endif; ?>
                </div>
            </div>
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
                            '<?php echo base_url('dashboard/peserta/kelasSaya') ?>';
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
<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap');

.pv-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
}

/* ══ HERO ══ */
.pv-hero {
    position: relative;
    border-radius: 24px;
    padding: 34px 40px;
    margin-bottom: 28px;
    background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #1d4ed8 100%);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}

.pv-hero::before {
    content: '';
    position: absolute;
    width: 360px;
    height: 360px;
    border-radius: 50%;
    background: rgba(255, 255, 255, .03);
    top: -100px;
    right: -80px;
    pointer-events: none;
}

.pv-hero::after {
    content: '';
    position: absolute;
    width: 200px;
    height: 200px;
    border-radius: 50%;
    background: rgba(59, 130, 246, .2);
    bottom: -70px;
    left: 35%;
    filter: blur(50px);
    pointer-events: none;
}

.pv-hero-text {
    z-index: 1;
}

.pv-hero-text h2 {
    font-size: 22px;
    font-weight: 800;
    color: #fff;
    margin: 0 0 6px;
    letter-spacing: -.3px;
}

.pv-hero-text p {
    font-size: 13px;
    color: rgba(255, 255, 255, .6);
    margin: 0;
    line-height: 1.6;
}

.pv-hero-stats {
    display: flex;
    gap: 12px;
    flex-shrink: 0;
    z-index: 1;
}

.pv-stat-box {
    background: rgba(255, 255, 255, .09);
    border: 1px solid rgba(255, 255, 255, .14);
    backdrop-filter: blur(8px);
    border-radius: 16px;
    padding: 14px 20px;
    text-align: center;
    min-width: 88px;
}

.pv-stat-box .num {
    font-size: 26px;
    font-weight: 800;
    color: #fff;
    line-height: 1;
}

.pv-stat-box .lbl {
    font-size: 10.5px;
    color: rgba(255, 255, 255, .55);
    margin-top: 4px;
    font-weight: 500;
}

.pv-stat-box.green .num {
    color: #4ade80;
}

.pv-stat-box.red .num {
    color: #f87171;
}

/* ══ TOOLBAR ══ */
.pv-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.pv-toolbar-left {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.pv-filter-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-size: 12.5px;
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    background: #fff;
    color: #64748b;
    cursor: pointer;
    transition: all .2s;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.pv-filter-btn:hover {
    border-color: #6366f1;
    color: #6366f1;
    background: #f5f3ff;
}

.pv-filter-btn.active-all {
    background: #1d4ed8;
    color: #fff;
    border-color: #1d4ed8;
}

.pv-filter-btn.active-verified {
    background: #16a34a;
    color: #fff;
    border-color: #16a34a;
}

.pv-filter-btn.active-unverified {
    background: #dc2626;
    color: #fff;
    border-color: #dc2626;
}

.pv-search-wrap {
    position: relative;
}

.pv-search-wrap i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 13px;
    pointer-events: none;
}

.pv-search-wrap input {
    padding: 9px 16px 9px 34px;
    width: 230px;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    font-size: 13px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #334155;
    background: #f8fafc;
    outline: none;
    transition: all .25s;
}

.pv-search-wrap input:focus {
    border-color: #6366f1;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, .1);
    width: 270px;
}

/* ══ TABLE CARD ══ */
.pv-table-card {
    background: #fff;
    border-radius: 20px;
    border: 1.5px solid #f1f5f9;
    box-shadow: 0 2px 12px rgba(0, 0, 0, .05);
    overflow: hidden;
}

.pv-table-header {
    padding: 18px 24px;
    border-bottom: 1px solid #f1f5f9;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.pv-table-title {
    font-size: 14px;
    font-weight: 700;
    color: #0f172a;
}

.pv-count-badge {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
    background: #f1f5f9;
    color: #64748b;
}

/* ══ TABLE ══ */
.pv-table {
    width: 100%;
    border-collapse: collapse;
}

.pv-table thead th {
    padding: 11px 20px;
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: .6px;
    text-transform: uppercase;
    color: #94a3b8;
    background: #fafafa;
    border-bottom: 1px solid #f1f5f9;
    text-align: left;
}

.pv-table tbody tr {
    transition: background .15s;
    border-bottom: 1px solid #f8fafc;
}

.pv-table tbody tr:last-child {
    border-bottom: none;
}

.pv-table tbody tr:hover {
    background: #fafbff;
}

.pv-table tbody td {
    padding: 14px 20px;
    vertical-align: middle;
}

/* avatar */
.pv-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    flex-shrink: 0;
}

.pv-user-cell {
    display: flex;
    align-items: center;
    gap: 12px;
}

.pv-user-name {
    font-size: 13.5px;
    font-weight: 700;
    color: #0f172a;
}

.pv-user-email {
    font-size: 12px;
    color: #94a3b8;
    margin-top: 1px;
}

/* date */
.pv-date {
    font-size: 12.5px;
    color: #334155;
    font-weight: 500;
}

.pv-date-sub {
    font-size: 11px;
    color: #94a3b8;
    margin-top: 2px;
}

/* badges */
.pv-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 700;
    padding: 4px 11px;
    border-radius: 20px;
    letter-spacing: .2px;
}

.pv-badge.verified {
    background: #f0fdf4;
    color: #16a34a;
    border: 1px solid #bbf7d0;
}

.pv-badge.unverified {
    background: #fef2f2;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.pv-badge.pending {
    background: #fefce8;
    color: #ca8a04;
    border: 1px solid #fde68a;
}

/* action btn */
.pv-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 600;
    padding: 5px 12px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    transition: all .15s;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.pv-action-btn.resend {
    background: #eff6ff;
    color: #2563eb;
}

.pv-action-btn.resend:hover {
    background: #2563eb;
    color: #fff;
}

.pv-action-btn.verified-done {
    background: #f0fdf4;
    color: #16a34a;
    cursor: default;
}

/* ══ EMPTY ══ */
.pv-empty {
    text-align: center;
    padding: 60px 24px;
}

.pv-empty-icon {
    width: 80px;
    height: 80px;
    border-radius: 20px;
    background: #f8fafc;
    border: 2px dashed #e2e8f0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    color: #cbd5e1;
    margin: 0 auto 16px;
}

.pv-empty h5 {
    font-size: 15px;
    font-weight: 700;
    color: #334155;
    margin-bottom: 5px;
}

.pv-empty p {
    font-size: 13px;
    color: #94a3b8;
    margin: 0;
}

/* ══ AVATAR COLORS ══ */
.av-0 {
    background: #ede9fe;
    color: #7c3aed
}

.av-1 {
    background: #dbeafe;
    color: #2563eb
}

.av-2 {
    background: #d1fae5;
    color: #059669
}

.av-3 {
    background: #ffedd5;
    color: #ea580c
}

.av-4 {
    background: #fce7f3;
    color: #db2777
}

.av-5 {
    background: #ccfbf1;
    color: #0d9488
}

.av-6 {
    background: #fef9c3;
    color: #ca8a04
}

.av-7 {
    background: #fee2e2;
    color: #dc2626
}

/* ══ RESPONSIVE ══ */
@media(max-width:768px) {
    .pv-hero {
        padding: 22px 18px;
        flex-direction: column;
        align-items: flex-start;
    }

    .pv-hero-stats {
        width: 100%;
    }

    .pv-stat-box {
        flex: 1;
    }

    .pv-table thead th:nth-child(4),
    .pv-table tbody td:nth-child(4) {
        display: none;
    }

    .pv-search-wrap input {
        width: 180px;
    }
}
</style>

<div class="pv-wrap">

    <!-- ══ HERO ══ -->
    <div class="pv-hero" data-aos="fade-down" data-aos-duration="600">
        <div class="pv-hero-text">
            <h2><i class="bi bi-people-fill me-2" style="opacity:.75"></i>Manajemen Peserta</h2>
            <p>Pantau status pendaftaran & verifikasi email setiap peserta.<br>
                Kirim ulang email verifikasi jika diperlukan.</p>
        </div>
        <div class="pv-hero-stats">
            <div class="pv-stat-box" data-aos="zoom-in" data-aos-delay="150">
                <div class="num"><?= $totalPeserta ?></div>
                <div class="lbl">Total Peserta</div>
            </div>
            <div class="pv-stat-box green" data-aos="zoom-in" data-aos-delay="230">
                <div class="num"><?= $totalVerified ?></div>
                <div class="lbl">Terverifikasi</div>
            </div>
            <div class="pv-stat-box red" data-aos="zoom-in" data-aos-delay="310">
                <div class="num"><?= $totalUnverified ?></div>
                <div class="lbl">Belum Verifikasi</div>
            </div>
        </div>
    </div>

    <!-- ══ TOOLBAR ══ -->
    <div class="pv-toolbar" data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">
        <div class="pv-toolbar-left">
            <button class="pv-filter-btn active-all" onclick="filterStatus('all', this)">
                <i class="bi bi-list-ul"></i> Semua
            </button>
            <button class="pv-filter-btn" onclick="filterStatus('verified', this)">
                <i class="bi bi-check-circle-fill"></i> Terverifikasi
            </button>
            <button class="pv-filter-btn" onclick="filterStatus('unverified', this)">
                <i class="bi bi-x-circle-fill"></i> Belum Verifikasi
            </button>
        </div>
        <div class="pv-search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="pvSearch" placeholder="Cari nama / email..." oninput="filterTable()">
        </div>
    </div>

    <!-- ══ TABLE CARD ══ -->
    <div class="pv-table-card" data-aos="fade-up" data-aos-duration="500" data-aos-delay="180">
        <div class="pv-table-header">
            <div class="pv-table-title">Daftar Peserta</div>
            <div class="pv-count-badge" id="pvCount"><?= $totalPeserta ?> peserta</div>
        </div>

        <?php if (!empty($peserta)): ?>
        <div style="overflow-x:auto">
            <table class="pv-table" id="pvTable">
                <thead>
                    <tr>
                        <th style="width:40px">#</th>
                        <th>Peserta</th>
                        <th>Tanggal Daftar</th>
                        <th>Status Verifikasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($peserta as $i => $p):
                $isVerified = !empty($p['email_verified']) && $p['email_verified'] == 1;
                $namaInisial = strtoupper(substr($p['nama_users'] ?? 'U', 0, 1));
                $avClass = 'av-' . ($i % 8);
                $createdAt = $p['created_at'] ?? null;
                $tglDaftar = $createdAt ? date('d M Y', strtotime($createdAt)) : '-';
                $jamDaftar = $createdAt ? date('H:i', strtotime($createdAt)) : '';
            ?>
                    <tr data-status="<?= $isVerified ? 'verified' : 'unverified' ?>"
                        data-name="<?= strtolower(esc($p['nama_users'])) ?>"
                        data-email="<?= strtolower(esc($p['email_users'])) ?>">

                        <!-- No -->
                        <td style="color:#94a3b8;font-size:12px;font-weight:600"><?= $i + 1 ?></td>

                        <!-- Peserta -->
                        <td>
                            <div class="pv-user-cell">
                                <div class="pv-avatar <?= $avClass ?>"><?= $namaInisial ?></div>
                                <div>
                                    <div class="pv-user-name"><?= esc($p['nama_users']) ?></div>
                                    <div class="pv-user-email"><?= esc($p['email_users']) ?></div>
                                </div>
                            </div>
                        </td>

                        <!-- Tanggal Daftar -->
                        <td>
                            <div class="pv-date"><?= $tglDaftar ?></div>
                            <?php if ($jamDaftar): ?>
                            <div class="pv-date-sub"><i class="bi bi-clock" style="font-size:10px"></i>
                                <?= $jamDaftar ?> WIB</div>
                            <?php endif; ?>
                        </td>

                        <!-- Status -->
                        <td>
                            <?php if ($isVerified): ?>
                            <span class="pv-badge verified">
                                <i class="bi bi-check-circle-fill"></i> Terverifikasi
                            </span>
                            <?php else: ?>
                            <span class="pv-badge unverified">
                                <i class="bi bi-x-circle-fill"></i> Belum Verifikasi
                            </span>
                            <?php endif; ?>
                        </td>

                        <!-- Aksi -->
                        <td>
                            <?php if ($isVerified): ?>
                            <button class="pv-action-btn verified-done" disabled>
                                <i class="bi bi-shield-check"></i> Sudah Aktif
                            </button>
                            <?php else: ?>
                            <button class="pv-action-btn resend"
                                onclick="resendVerifikasi(<?= $p['id_users'] ?>, '<?= esc($p['email_users']) ?>', this)">
                                <i class="bi bi-send-fill"></i> Kirim Ulang
                            </button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- No result row -->
        <div id="pvEmpty" style="display:none">
            <div class="pv-empty">
                <div class="pv-empty-icon"><i class="bi bi-search"></i></div>
                <h5>Tidak Ditemukan</h5>
                <p>Peserta yang kamu cari tidak ada dalam daftar.</p>
            </div>
        </div>

        <?php else: ?>
        <div class="pv-empty">
            <div class="pv-empty-icon"><i class="bi bi-people"></i></div>
            <h5>Belum Ada Peserta</h5>
            <p>Belum ada peserta yang terdaftar di sistem.</p>
        </div>
        <?php endif; ?>
    </div>

</div>

<!-- AOS JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
AOS.init({
    once: true,
    easing: 'ease-out-cubic',
    offset: 50
});

let activeFilter = 'all';

/* ── Filter status ── */
function filterStatus(status, btn) {
    activeFilter = status;

    // update tombol aktif
    document.querySelectorAll('.pv-filter-btn').forEach(b => {
        b.className = 'pv-filter-btn';
    });
    if (status === 'all') btn.classList.add('active-all');
    else if (status === 'verified') btn.classList.add('active-verified');
    else btn.classList.add('active-unverified');

    filterTable();
}

/* ── Filter tabel (search + status) ── */
function filterTable() {
    const q = document.getElementById('pvSearch').value.toLowerCase().trim();
    const rows = document.querySelectorAll('#pvTable tbody tr[data-status]');
    let vis = 0;

    rows.forEach(row => {
        const matchStatus = activeFilter === 'all' || row.dataset.status === activeFilter;
        const matchSearch = !q || row.dataset.name.includes(q) || row.dataset.email.includes(q);
        const show = matchStatus && matchSearch;
        row.style.display = show ? '' : 'none';
        if (show) vis++;
    });

    document.getElementById('pvEmpty').style.display = vis === 0 ? 'block' : 'none';
    document.getElementById('pvCount').textContent = vis + ' peserta';
}

/* ── Kirim ulang verifikasi ── */
function resendVerifikasi(userId, email, btn) {
    Swal.fire({
        title: 'Kirim Ulang Verifikasi?',
        html: `Email verifikasi akan dikirim ke<br><strong>${email}</strong>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-send-fill"></i> Kirim',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#94a3b8',
    }).then(result => {
        if (!result.isConfirmed) return;

        btn.disabled = true;
        btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Mengirim...';

        fetch('<?= base_url('dashboard/pengajar/peserta/resend-verifikasi') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                },
                body: JSON.stringify({
                    id_users: userId
                })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Terkirim!',
                        text: 'Email verifikasi berhasil dikirim ulang.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    btn.innerHTML = '<i class="bi bi-check2"></i> Terkirim';
                    btn.style.background = '#f0fdf4';
                    btn.style.color = '#16a34a';
                } else {
                    Swal.fire('Gagal', data.message || 'Terjadi kesalahan.', 'error');
                    btn.disabled = false;
                    btn.innerHTML = '<i class="bi bi-send-fill"></i> Kirim Ulang';
                }
            })
            .catch(() => {
                Swal.fire('Error', 'Tidak dapat terhubung ke server.', 'error');
                btn.disabled = false;
                btn.innerHTML = '<i class="bi bi-send-fill"></i> Kirim Ulang';
            });
    });
}
</script>

<?= $this->endSection() ?>
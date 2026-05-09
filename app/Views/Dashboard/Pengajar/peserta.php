<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>
<?= $this->section('content') ?>

<style>
/* ====== Stat cards ====== */
.stat-cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}
.stat-card {
    background: #fff;
    border-radius: 16px;
    padding: 20px 22px;
    box-shadow: 0 1px 8px rgba(0,0,0,.05);
    transition: transform .2s, box-shadow .2s;
}
.stat-card:hover { transform: translateY(-2px); box-shadow: 0 6px 20px rgba(0,0,0,.09); }
.stat-icon { width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:19px;margin-bottom:14px; }
.stat-icon.blue   { background:#dbeafe;color:#2563eb }
.stat-icon.green  { background:#d1fae5;color:#059669 }
.stat-icon.orange { background:#ffedd5;color:#ea580c }
.stat-icon.purple { background:#ede9fe;color:#7c3aed }
.stat-label { font-size:11px;font-weight:700;letter-spacing:.6px;color:#9ca3af;text-transform:uppercase;margin-bottom:4px; }
.stat-value { font-size:28px;font-weight:800;color:#111;line-height:1; }
.stat-sub   { font-size:11.5px;color:#9ca3af;margin-top:4px; }

/* ====== Main card ====== */
.main-card { background:#fff;border-radius:18px;box-shadow:0 1px 8px rgba(0,0,0,.05);overflow:hidden; }
.toolbar {
    padding: 20px 24px;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}
.toolbar-title { font-size:15px;font-weight:700;color:#111;flex:1;min-width:160px; }
.search-box { position:relative;width:240px; }
.search-box i { position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:13px; }
.search-box input {
    width:100%;padding:9px 12px 9px 34px;border:1px solid #e5e7eb;border-radius:10px;
    font-size:13px;color:#374151;background:#f9fafb;outline:none;transition:border .2s;
    font-family:'DM Sans',sans-serif;
}
.search-box input:focus { border-color:#059669;background:#fff; }

/* ====== Tabs kelas ====== */
.kelas-tabs { display:flex;gap:8px;flex-wrap:wrap;padding:16px 24px;border-bottom:1px solid #f3f4f6; }
.kelas-tab {
    padding:7px 16px;border-radius:20px;font-size:13px;font-weight:600;
    border:1.5px solid #e5e7eb;background:#fff;color:#6b7280;cursor:pointer;transition:all .15s;white-space:nowrap;
}
.kelas-tab:hover  { border-color:#059669;color:#059669;background:#f0fdf4; }
.kelas-tab.active { background:#059669;border-color:#059669;color:#fff; }
.tab-count {
    display:inline-flex;align-items:center;justify-content:center;
    width:20px;height:20px;border-radius:50%;font-size:11px;font-weight:800;
    background:rgba(255,255,255,.25);margin-left:6px;
}
.kelas-tab:not(.active) .tab-count { background:#f3f4f6;color:#6b7280; }

.info-bar { padding:10px 24px;background:#fafafa;border-bottom:1px solid #f0f0f0;font-size:12px;color:#6b7280; }
.info-bar strong { color:#374151; }

/* ====== Table ====== */
.table-wrap { overflow-x:auto; }
.dash-table { width:100%;border-collapse:collapse;font-size:13px; }
.dash-table thead th {
    padding:12px 16px;text-align:left;font-size:10.5px;font-weight:700;
    letter-spacing:.5px;color:#9ca3af;text-transform:uppercase;
    background:#fafafa;border-bottom:1px solid #f0f0f0;
}
.dash-table tbody td { padding:13px 16px;border-bottom:1px solid #f9fafb;color:#374151;vertical-align:middle; }
.dash-table tbody tr:last-child td { border-bottom:none; }
.dash-table tbody tr:hover td { background:#f9fafb; }

/* ====== Student cell ====== */
.student-cell { display:flex;align-items:center;gap:12px; }
.stu-avatar { width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:14px;flex-shrink:0; }
.stu-name  { font-size:13px;font-weight:700;color:#111; }
.stu-email { font-size:11.5px;color:#9ca3af;margin-top:1px; }
.av-0{background:#dbeafe;color:#2563eb}.av-1{background:#d1fae5;color:#059669}
.av-2{background:#ffedd5;color:#ea580c}.av-3{background:#ede9fe;color:#7c3aed}
.av-4{background:#ccfbf1;color:#0d9488}.av-5{background:#fce7f3;color:#db2777}
.av-6{background:#fef3c7;color:#d97706}.av-7{background:#fee2e2;color:#dc2626}

/* ====== Badges ====== */
.kelas-badge { display:inline-block;padding:3px 10px;border-radius:20px;font-size:11.5px;font-weight:700;background:#eff6ff;color:#2563eb;white-space:nowrap; }
.score-badge { font-size:12px;font-weight:700;padding:3px 9px;border-radius:20px; }
.score-badge.high { background:#d1fae5;color:#059669 }
.score-badge.mid  { background:#fef3c7;color:#d97706 }
.score-badge.low  { background:#fee2e2;color:#ef4444 }
.score-badge.none { background:#f3f4f6;color:#9ca3af }

/* ====== Tombol akses ====== */
.btn-akses {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    border: 1.5px solid #e0f2fe;
    background: #f0f9ff;
    color: #0284c7;
    cursor: pointer;
    transition: all .15s;
    white-space: nowrap;
}
.btn-akses:hover { background:#0284c7;color:#fff;border-color:#0284c7; }

/* ====== Modal akses aplikasi ====== */
.modal-akses .modal-content { border-radius:16px;border:0.5px solid #e2e8f0;overflow:hidden; }
.modal-akses .modal-header  { background:#f8fafc;border-bottom:1px solid #f1f5f9;padding:16px 20px; }
.modal-akses .modal-footer  { background:#f8fafc;border-top:1px solid #f1f5f9;padding:12px 20px; }
.modal-akses .modal-body    { padding:20px; }
.modal-akses .modal-title   { font-size:15px;font-weight:700; }

/* List aplikasi di modal */
.app-check-list { display:flex;flex-direction:column;gap:8px; }
.app-check-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 14px;
    border-radius: 10px;
    border: 1.5px solid #e5e7eb;
    cursor: pointer;
    transition: border-color .15s, background .15s;
    user-select: none;
}
.app-check-item:hover  { border-color:#0284c7;background:#f0f9ff; }
.app-check-item.active { border-color:#0284c7;background:#f0f9ff; }

.app-check-item input[type="checkbox"] { display:none; }

.app-check-icon {
    width: 36px;
    height: 36px;
    border-radius: 9px;
    background: #eff6ff;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.app-check-icon i { font-size:16px;color:#3b82f6; }

.app-check-info { flex:1;min-width:0; }
.app-check-name { font-size:13px;font-weight:700;color:#111; }
.app-check-link { font-size:11px;color:#9ca3af;white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }

.app-check-tick {
    width: 22px;
    height: 22px;
    border-radius: 50%;
    border: 2px solid #d1d5db;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    transition: all .15s;
}
.app-check-item.active .app-check-tick { background:#0284c7;border-color:#0284c7; }
.app-check-item.active .app-check-tick i { color:#fff; }
.app-check-tick i { font-size:11px;color:transparent; }

/* Skeleton loader */
.skeleton-line {
    height: 14px;
    border-radius: 6px;
    background: linear-gradient(90deg,#f0f0f0 25%,#e0e0e0 50%,#f0f0f0 75%);
    background-size: 200% 100%;
    animation: shimmer 1.2s infinite;
}
@keyframes shimmer { 0%{background-position:200% 0} 100%{background-position:-200% 0} }

.empty-state { text-align:center;padding:48px;color:#9ca3af; }
.empty-state i { font-size:40px;display:block;margin-bottom:12px; }
.empty-state p { font-size:13px; }

@media(max-width:1200px){ .stat-cards{grid-template-columns:repeat(2,1fr)} }
@media(max-width:768px)  { .stat-cards{grid-template-columns:repeat(2,1fr)} .search-box{width:100%} }
</style>

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1>Daftar Peserta</h1>
        <p>Peserta yang terdaftar di kelas kamu.</p>
    </div>
    <div class="date-badge">
        <i class="bi bi-calendar3"></i> <?= date('d F Y') ?>
    </div>
</div>

<!-- Main Card -->
<div class="main-card">

    <!-- Toolbar -->
    <div class="toolbar">
        <div class="toolbar-title">Semua Peserta</div>
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="searchInput" placeholder="Cari nama atau email..." oninput="filterTable()">
        </div>
    </div>

    <!-- Tabs per kelas -->
    <div class="kelas-tabs">
        <button class="kelas-tab active" data-kelas="semua" onclick="switchKelas('semua', this)">
            Semua Kelas <span class="tab-count"><?= $totalPeserta ?></span>
        </button>
        <?php foreach ($kelasList as $k): ?>
        <button class="kelas-tab" data-kelas="<?= $k->id_kelas ?>" onclick="switchKelas('<?= $k->id_kelas ?>', this)">
            <?= esc($k->nama_kelas) ?> <span class="tab-count"><?= $k->jumlah_peserta ?></span>
        </button>
        <?php endforeach; ?>
    </div>

    <!-- Info bar -->
    <div class="info-bar">
        <span id="infoText">Menampilkan <strong><?= $totalPeserta ?></strong> peserta</span>
    </div>

    <!-- Table -->
    <div class="table-wrap">
        <table class="dash-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Peserta</th>
                    <th>Kelas</th>
                    <th>Nilai Rata-rata</th>
                    <th>Tanggal Daftar</th>
                    <th>Akses Aplikasi</th><!-- KOLOM BARU -->
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php if (!empty($peserta)): ?>
                <?php foreach ($peserta as $i => $p): ?>
                <?php
                    $nilai      = $p->rata_nilai ?? 0;
                    $scoreClass = $nilai >= 80 ? 'high' : ($nilai >= 65 ? 'mid' : ($nilai > 0 ? 'low' : 'none'));
                    $avColor    = 'av-' . ($i % 8);
                ?>
                <tr data-kelas="<?= $p->id_kelas ?>"
                    data-nama="<?= strtolower(esc($p->nama_users)) ?>"
                    data-email="<?= strtolower(esc($p->email_users)) ?>">

                    <td class="row-num" style="color:#9ca3af;font-weight:700;"><?= $i + 1 ?></td>

                    <td>
                        <div class="student-cell">
                            <div class="stu-avatar <?= $avColor ?>">
                                <?= strtoupper(substr($p->nama_users, 0, 1)) ?>
                            </div>
                            <div>
                                <div class="stu-name"><?= esc($p->nama_users) ?></div>
                                <div class="stu-email"><?= esc($p->email_users) ?></div>
                            </div>
                        </div>
                    </td>

                    <td><span class="kelas-badge"><?= esc($p->nama_kelas) ?></span></td>

                    <td>
                        <?php if ($nilai > 0): ?>
                            <span class="score-badge <?= $scoreClass ?>"><?= $nilai ?></span>
                        <?php else: ?>
                            <span class="score-badge none">Belum ada</span>
                        <?php endif; ?>
                    </td>

                    <td style="color:#6b7280;">
                        <?= date('d M Y', strtotime($p->tanggal_daftar_kelas_peserta)) ?>
                    </td>

                    <!-- Tombol kelola akses -->
                    <td>
                        <button class="btn-akses"
                            onclick="bukaModalAkses(<?= $p->id_users ?>, '<?= esc($p->nama_users) ?>')">
                            <i class="bi bi-shield-lock-fill"></i> Kelola Akses
                        </button>
                    </td>

                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="bi bi-people"></i>
                            <p>Belum ada peserta yang mendaftar di kelas kamu.</p>
                        </div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div id="emptyState" class="empty-state" style="display:none;">
            <i class="bi bi-people"></i>
            <p>Tidak ada peserta ditemukan.</p>
        </div>
    </div>

</div>


<!-- ===================== MODAL KELOLA AKSES APLIKASI ===================== -->
<div class="modal fade modal-akses" id="modalAkses" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" style="max-width:480px">
        <div class="modal-content">

            <div class="modal-header">
                <div>
                    <h5 class="modal-title mb-0">
                        <i class="bi bi-shield-lock me-2 text-primary"></i>Kelola Akses Aplikasi
                    </h5>
                    <p class="text-muted mb-0" style="font-size:12px;margin-top:2px" id="modalSubtitle">—</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <!-- Loading skeleton -->
                <div id="aksesLoading">
                    <div class="d-flex flex-column gap-2">
                        <?php for ($s = 0; $s < 4; $s++): ?>
                        <div style="display:flex;align-items:center;gap:12px;padding:10px 14px;border-radius:10px;border:1.5px solid #f0f0f0;">
                            <div style="width:36px;height:36px;border-radius:9px;" class="skeleton-line"></div>
                            <div style="flex:1;">
                                <div class="skeleton-line mb-1" style="width:60%;height:13px;"></div>
                                <div class="skeleton-line" style="width:80%;height:11px;"></div>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- List aplikasi -->
                <div id="aksesContent" style="display:none;">
                    <p style="font-size:12px;color:#6b7280;margin-bottom:12px;">
                        Centang aplikasi yang ingin diberikan akses kepada peserta ini.
                    </p>

                    <?php if (!empty($aplikasiSemua)): ?>
                    <div class="app-check-list" id="appCheckList">
                        <?php foreach ($aplikasiSemua as $app): ?>
                        <label class="app-check-item" data-id="<?= $app['id_aplikasi'] ?>">
                            <input type="checkbox" value="<?= $app['id_aplikasi'] ?>">
                            <div class="app-check-icon">
                                <i class="bi bi-grid-fill"></i>
                            </div>
                            <div class="app-check-info">
                                <div class="app-check-name"><?= esc($app['nama_aplikasi']) ?></div>
                                <div class="app-check-link"><?= esc($app['link_aplikasi']) ?></div>
                            </div>
                            <div class="app-check-tick">
                                <i class="bi bi-check"></i>
                            </div>
                        </label>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div class="empty-state" style="padding:32px;">
                        <i class="bi bi-grid-3x3-gap"></i>
                        <p>Belum ada aplikasi pendukung.<br>Tambahkan dulu di menu Aplikasi Pendukung.</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="modal-footer d-flex justify-content-between align-items-center">
                <span id="aksesCountInfo" class="text-muted" style="font-size:12px;">—</span>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-2"
                        id="btnSimpanAkses" onclick="simpanAkses()">
                        <i class="bi bi-floppy-fill"></i> Simpan Akses
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Toast notifikasi -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index:9999">
    <div id="toastAkses" class="toast align-items-center text-white border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
                <i id="toastIcon" class="bi"></i>
                <span id="toastMsg"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>


<script>
// ---------------------------------------------------------------
// Filter & tab (sama seperti sebelumnya)
// ---------------------------------------------------------------
let activeKelas = 'semua';

function switchKelas(kelasId, btn) {
    activeKelas = String(kelasId);
    document.querySelectorAll('.kelas-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    filterTable();
}

function filterTable() {
    const q    = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#tableBody tr[data-nama]');
    let visible = 0;

    rows.forEach(row => {
        const matchKelas  = activeKelas === 'semua' || row.dataset.kelas === activeKelas;
        const matchSearch = row.dataset.nama.includes(q) || row.dataset.email.includes(q);
        const show        = matchKelas && matchSearch;
        row.style.display = show ? '' : 'none';
        if (show) visible++;
    });

    let num = 1;
    rows.forEach(row => {
        if (row.style.display !== 'none') row.querySelector('.row-num').textContent = num++;
    });

    document.getElementById('emptyState').style.display = visible === 0 ? '' : 'none';
    document.getElementById('infoText').innerHTML = `Menampilkan <strong>${visible}</strong> peserta`;
}


// ---------------------------------------------------------------
// Modal Akses Aplikasi
// ---------------------------------------------------------------
let currentUserId = null;

async function bukaModalAkses(idUsers, namaUsers) {
    currentUserId = idUsers;

    // Reset tampilan
    document.getElementById('modalSubtitle').textContent = namaUsers;
    document.getElementById('aksesLoading').style.display  = '';
    document.getElementById('aksesContent').style.display  = 'none';
    document.getElementById('aksesCountInfo').textContent  = '—';
    document.getElementById('btnSimpanAkses').disabled     = true;

    // Uncheck semua dulu
    document.querySelectorAll('#appCheckList .app-check-item').forEach(item => {
        item.classList.remove('active');
        item.querySelector('input[type=checkbox]').checked = false;
    });

    // Buka modal
    const modal = new bootstrap.Modal(document.getElementById('modalAkses'));
    modal.show();

    try {
        // Ambil akses yang sudah ada
        const res  = await fetch(`<?= base_url('dashboard/pengajar/peserta/akses') ?>/${idUsers}`);
        const data = await res.json();

        if (data.success) {
            const aksesIds = data.akses.map(String);

            document.querySelectorAll('#appCheckList .app-check-item').forEach(item => {
                const id = String(item.dataset.id);
                if (aksesIds.includes(id)) {
                    item.classList.add('active');
                    item.querySelector('input[type=checkbox]').checked = true;
                }
            });
        }
    } catch (e) {
        console.error(e);
    } finally {
        document.getElementById('aksesLoading').style.display = 'none';
        document.getElementById('aksesContent').style.display = '';
        document.getElementById('btnSimpanAkses').disabled    = false;
        updateCount();
    }
}

// Toggle item saat di-klik
document.querySelectorAll('#appCheckList .app-check-item').forEach(item => {
    item.addEventListener('click', () => {
        const cb = item.querySelector('input[type=checkbox]');
        cb.checked = !cb.checked;
        item.classList.toggle('active', cb.checked);
        updateCount();
    });
});

function updateCount() {
    const total    = document.querySelectorAll('#appCheckList .app-check-item').length;
    const selected = document.querySelectorAll('#appCheckList .app-check-item.active').length;
    document.getElementById('aksesCountInfo').textContent =
        `${selected} dari ${total} aplikasi dipilih`;
}

async function simpanAkses() {
    if (!currentUserId) return;

    const btn = document.getElementById('btnSimpanAkses');
    btn.disabled   = true;
    btn.innerHTML  = '<span class="spinner-border spinner-border-sm"></span> Menyimpan...';

    const selectedIds = [...document.querySelectorAll('#appCheckList .app-check-item.active')]
        .map(item => parseInt(item.dataset.id));

    try {
        const res  = await fetch('<?= base_url('dashboard/pengajar/peserta/akses/simpan') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?= csrf_hash() ?>',
            },
            body: JSON.stringify({ id_users: currentUserId, aplikasi: selectedIds }),
        });
        const data = await res.json();

        showToast(data.success, data.message);

        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('modalAkses'))?.hide();
        }
    } catch (e) {
        showToast(false, 'Gagal menyimpan, coba lagi.');
    } finally {
        btn.disabled  = false;
        btn.innerHTML = '<i class="bi bi-floppy-fill"></i> Simpan Akses';
    }
}

function showToast(success, msg) {
    const toast = document.getElementById('toastAkses');
    toast.className = `toast align-items-center text-white border-0 ${success ? 'bg-success' : 'bg-danger'}`;
    document.getElementById('toastIcon').className = `bi ${success ? 'bi-check-circle-fill' : 'bi-x-circle-fill'}`;
    document.getElementById('toastMsg').textContent = msg;
    bootstrap.Toast.getOrCreateInstance(toast, { delay: 3000 }).show();
}
</script>

<?= $this->endSection() ?>
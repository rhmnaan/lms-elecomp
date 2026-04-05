<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('meta') ?>
<title>Materi — LMS Elecomp</title>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
/* ── SEARCH & FILTER BAR ── */
.filter-bar {
    background: #fff;
    border-radius: 16px;
    padding: 16px 20px;
    box-shadow: 0 1px 8px rgba(0, 0, 0, .05);
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.filter-search {
    flex: 1;
    min-width: 200px;
    position: relative;
}

.filter-search i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 14px;
}

.filter-search input {
    width: 100%;
    padding: 9px 14px 9px 36px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 13px;
    color: #374151;
    background: #f9fafb;
    outline: none;
    font-family: 'DM Sans', sans-serif;
    transition: border .2s;
}

.filter-search input:focus {
    border-color: #2d6cdf;
    background: #fff;
}

.filter-select {
    padding: 9px 14px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 13px;
    color: #374151;
    background: #f9fafb;
    outline: none;
    font-family: 'DM Sans', sans-serif;
    cursor: pointer;
    transition: border .2s;
}

.filter-select:focus {
    border-color: #2d6cdf;
}

/* ── MATERI LIST ── */
.materi-table {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 1px 8px rgba(0, 0, 0, .05);
    overflow: hidden;
}

.materi-row {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 13px 20px;
    border-bottom: 1px solid #f3f4f6;
    transition: background .12s;
    cursor: pointer;

    flex-wrap: nowrap;
    /* 🔥 penting */
    overflow: hidden;
    /* 🔥 anti jebol */
}

.materi-row:last-child {
    border-bottom: none;
}

.materi-row:hover {
    background: #f9fafb;
}

.materi-row-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
}

.materi-row-icon.artikel {
    background: #eff6ff;
    color: #2563eb;
}

.materi-row-icon.video {
    background: #fff1f2;
    color: #e11d48;
}

.materi-row-icon.file {
    background: #fef3c7;
    color: #d97706;
}

.materi-row-info {
    flex: 1;
    min-width: 0;
}

.materi-row-judul {
    font-size: 13.5px;
    font-weight: 700;
    color: #111;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.materi-row-sub {
    font-size: 11.5px;
    color: #9ca3af;
    margin-top: 2px;
    display: flex;
    align-items: center;
    gap: 5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.materi-row-sub i {
    font-size: 10px;
}

.tipe-badge {
    flex-shrink: 0;
    font-size: 11px;
    font-weight: 700;
    padding: 3px 10px;
    border-radius: 20px;
}

.tipe-badge.artikel {
    background: #eff6ff;
    color: #2563eb;
}

.tipe-badge.video {
    background: #fff1f2;
    color: #e11d48;
}

.tipe-badge.file {
    background: #fef3c7;
    color: #d97706;
}

.btn-lihat-materi {
    flex-shrink: 0;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11.5px;
    font-weight: 700;
    color: #2d6cdf;
    background: #eff6ff;
    padding: 5px 12px;
    border-radius: 8px;
    text-decoration: none;
    transition: background .15s;
}

.btn-lihat-materi:hover {
    background: #dbeafe;
    color: #1e40af;
}

/* ── EMPTY ── */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #9ca3af;
}

.empty-state i {
    font-size: 40px;
    display: block;
    margin-bottom: 12px;
}

.empty-state p {
    font-size: 14px;
    font-weight: 600;
}

.hidden {
    display: none !important;
}

/* Wrapper kanan biar sejajar */
/* ── PERBAIKAN POSISI TOMBOL ── */
.materi-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    /* Jarak antar elemen di kanan */
    flex-shrink: 0;
}

.materi-actions .btn-lihat-materi,
.materi-actions .tipe-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 32px;
    font-size: 11px;
    border-radius: 8px;
    white-space: nowrap;
}

/* Berikan lebar statis agar lurus dari atas ke bawah */
.btn-pretest {
    width: 100px;
    /* Jarak statis untuk tombol Pre-test */
    background: #ecfdf5;
    color: #059669;
}

.tipe-badge {
    width: 90px;
    /* Jarak statis untuk Badge tipe */
    border-radius: 20px;
    text-align: center;
}

.btn-lihat-materi:not(.btn-pretest) {
    width: 80px;
    /* Jarak statis untuk tombol Lihat */
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="page-header">
    <div>
        <h1>Semua Materi</h1>
        <p>Seluruh materi pembelajaran kamu.</p>
    </div>
    <div class="date-badge">
        <i class="bi bi-file-earmark-text-fill"></i>
        <span id="total-count"><?= $total ?> Materi</span>
    </div>
</div>

<!-- FILTER BAR -->
<div class="filter-bar">
    <div class="filter-search">
        <i class="bi bi-search"></i>
        <input type="text" id="searchInput" placeholder="Cari materi..." oninput="filterMateri()">
    </div>
    <select class="filter-select" id="tipeFilter" onchange="filterMateri()">
        <option value="">Semua Tipe</option>
        <option value="artikel">Artikel</option>
        <option value="video">Video</option>
        <option value="file">File / PDF</option>
    </select>
</div>

<!-- MATERI LIST -->
<div class="materi-table" id="materiList">
    <?php if (empty($materi_list)): ?>
    <div class="empty-state">
        <i class="bi bi-journal-x"></i>
        <p>Belum ada materi tersedia.</p>
    </div>
    <?php else: ?>
    <?php foreach ($materi_list as $m):
            if ($m['tipe'] === 'video') {
                $tipeLabel = 'Video';
                $tipeIcon  = 'bi-play-circle-fill';
            } elseif ($m['tipe'] === 'file') {
                $tipeLabel = 'File / PDF';
                $tipeIcon  = 'bi-file-earmark-pdf-fill';
            } else {
                $tipeLabel = 'Artikel';
                $tipeIcon  = 'bi-file-earmark-text-fill';
            }
        ?>
    <div class="materi-row" data-judul="<?= strtolower(htmlspecialchars($m['judul_materi'], ENT_QUOTES)) ?>"
        data-tipe="<?= $m['tipe'] ?>"
        onclick="window.location='<?= base_url('dashboard/peserta/materi-modul/' . $m['id_modul'] . '?materi=' . $m['id_materi']) ?>'">

        <!-- ICON -->
        <div class="materi-row-icon <?= $m['tipe'] ?>">
            <i class="bi <?= $tipeIcon ?>"></i>
        </div>

        <!-- INFO -->
        <div class="materi-row-info">
            <div class="materi-row-judul"><?= esc($m['judul_materi']) ?></div>
            <div class="materi-row-sub">
                <?= esc($m['nama_kelas']) ?>
                <i class="bi bi-chevron-right"></i>
                <?= esc($m['judul_modul']) ?>
            </div>
        </div>

        <!-- ACTIONS (KANAN) -->
        <div class="materi-actions">

            <?php if (!empty($m['pretest_id'])): ?>
            <a href="<?= base_url('pretest/soal/' . $m['pretest_id']) ?>" class="btn-lihat-materi btn-pretest"
                onclick="event.stopPropagation()">
                Pre-Test <i class="bi bi-clipboard-check"></i>
            </a>
            <?php else: ?>
            <button class="btn-lihat-materi" style="background:#f3f4f6; color:#9ca3af; border:none;" disabled>
                No Pre-test
            </button>
            <?php endif; ?>
            <!-- BADGE -->
            <span class="tipe-badge <?= $m['tipe'] ?>">
                <?= $tipeLabel ?>
            </span>

            <!-- LIHAT -->
            <a href="<?= base_url('dashboard/peserta/materi-modul/' . $m['id_modul'] . '?materi=' . $m['id_materi']) ?>"
                class="btn-lihat-materi" onclick="event.stopPropagation()">
                Lihat <i class="bi bi-arrow-right"></i>
            </a>

        </div>
    </div> <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- Empty search result -->
<div id="noResult" class="empty-state hidden"
    style="background:#fff;border-radius:16px;box-shadow:0 1px 8px rgba(0,0,0,.05);">
    <i class="bi bi-search"></i>
    <p>Materi tidak ditemukan.</p>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
function filterMateri() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    const tipe = document.getElementById('tipeFilter').value;
    const rows = document.querySelectorAll('.materi-row');
    let visible = 0;

    rows.forEach(row => {
        const matchQ = row.dataset.judul.includes(q);
        const matchT = !tipe || row.dataset.tipe === tipe;
        if (matchQ && matchT) {
            row.classList.remove('hidden');
            visible++;
        } else {
            row.classList.add('hidden');
        }
    });

    const noResultDiv = document.getElementById('noResult');
    if (visible === 0 && rows.length > 0) {
        noResultDiv.classList.remove('hidden');
    } else {
        noResultDiv.classList.add('hidden');
    }

    document.getElementById('total-count').textContent = visible + ' Materi';
}

document.addEventListener('DOMContentLoaded', function() {
    filterMateri();
});
</script>
<?= $this->endSection() ?>
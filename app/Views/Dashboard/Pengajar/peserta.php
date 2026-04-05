<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>
<?= $this->section('content') ?>

<style>
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
    box-shadow: 0 1px 8px rgba(0, 0, 0, .05);
    transition: transform .2s, box-shadow .2s;
  }

  .stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, .09);
  }

  .stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 19px;
    margin-bottom: 14px;
  }

  .stat-icon.blue {
    background: #dbeafe;
    color: #2563eb;
  }

  .stat-icon.green {
    background: #d1fae5;
    color: #059669;
  }

  .stat-icon.orange {
    background: #ffedd5;
    color: #ea580c;
  }

  .stat-icon.purple {
    background: #ede9fe;
    color: #7c3aed;
  }

  .stat-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .6px;
    color: #9ca3af;
    text-transform: uppercase;
    margin-bottom: 4px;
  }

  .stat-value {
    font-size: 28px;
    font-weight: 800;
    color: #111;
    line-height: 1;
  }

  .stat-sub {
    font-size: 11.5px;
    color: #9ca3af;
    margin-top: 4px;
  }

  .main-card {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 1px 8px rgba(0, 0, 0, .05);
    overflow: hidden;
  }

  .toolbar {
    padding: 20px 24px;
    border-bottom: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
  }

  .toolbar-title {
    font-size: 15px;
    font-weight: 700;
    color: #111;
    flex: 1;
    min-width: 160px;
  }

  .search-box {
    position: relative;
    width: 240px;
  }

  .search-box i {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 13px;
  }

  .search-box input {
    width: 100%;
    padding: 9px 12px 9px 34px;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    font-size: 13px;
    color: #374151;
    background: #f9fafb;
    outline: none;
    transition: border .2s;
    font-family: 'DM Sans', sans-serif;
  }

  .search-box input:focus {
    border-color: #059669;
    background: #fff;
  }

  /* Tabs kelas */
  .kelas-tabs {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
    padding: 16px 24px;
    border-bottom: 1px solid #f3f4f6;
  }

  .kelas-tab {
    padding: 7px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    border: 1.5px solid #e5e7eb;
    background: #fff;
    color: #6b7280;
    cursor: pointer;
    transition: all .15s;
    white-space: nowrap;
  }

  .kelas-tab:hover {
    border-color: #059669;
    color: #059669;
    background: #f0fdf4;
  }

  .kelas-tab.active {
    background: #059669;
    border-color: #059669;
    color: #fff;
  }

  .tab-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    font-size: 11px;
    font-weight: 800;
    background: rgba(255, 255, 255, .25);
    margin-left: 6px;
  }

  .kelas-tab:not(.active) .tab-count {
    background: #f3f4f6;
    color: #6b7280;
  }

  .info-bar {
    padding: 10px 24px;
    background: #fafafa;
    border-bottom: 1px solid #f0f0f0;
    font-size: 12px;
    color: #6b7280;
  }

  .info-bar strong {
    color: #374151;
  }

  /* Table */
  .table-wrap {
    overflow-x: auto;
  }

  .dash-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
  }

  .dash-table thead th {
    padding: 12px 16px;
    text-align: left;
    font-size: 10.5px;
    font-weight: 700;
    letter-spacing: .5px;
    color: #9ca3af;
    text-transform: uppercase;
    background: #fafafa;
    border-bottom: 1px solid #f0f0f0;
  }

  .dash-table tbody td {
    padding: 13px 16px;
    border-bottom: 1px solid #f9fafb;
    color: #374151;
    vertical-align: middle;
  }

  .dash-table tbody tr:last-child td {
    border-bottom: none;
  }

  .dash-table tbody tr:hover td {
    background: #f9fafb;
  }

  .student-cell {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .stu-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 800;
    font-size: 14px;
    flex-shrink: 0;
  }

  .stu-name {
    font-size: 13px;
    font-weight: 700;
    color: #111;
  }

  .stu-email {
    font-size: 11.5px;
    color: #9ca3af;
    margin-top: 1px;
  }

  .av-0 {
    background: #dbeafe;
    color: #2563eb
  }

  .av-1 {
    background: #d1fae5;
    color: #059669
  }

  .av-2 {
    background: #ffedd5;
    color: #ea580c
  }

  .av-3 {
    background: #ede9fe;
    color: #7c3aed
  }

  .av-4 {
    background: #ccfbf1;
    color: #0d9488
  }

  .av-5 {
    background: #fce7f3;
    color: #db2777
  }

  .av-6 {
    background: #fef3c7;
    color: #d97706
  }

  .av-7 {
    background: #fee2e2;
    color: #dc2626
  }

  .kelas-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11.5px;
    font-weight: 700;
    background: #eff6ff;
    color: #2563eb;
    white-space: nowrap;
  }

  .score-badge {
    font-size: 12px;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 20px;
  }

  .score-badge.high {
    background: #d1fae5;
    color: #059669
  }

  .score-badge.mid {
    background: #fef3c7;
    color: #d97706
  }

  .score-badge.low {
    background: #fee2e2;
    color: #ef4444
  }

  .score-badge.none {
    background: #f3f4f6;
    color: #9ca3af
  }

  .empty-state {
    text-align: center;
    padding: 48px;
    color: #9ca3af;
  }

  .empty-state i {
    font-size: 40px;
    display: block;
    margin-bottom: 12px;
  }

  .empty-state p {
    font-size: 13px;
  }

  @media(max-width:1200px) {
    .stat-cards {
      grid-template-columns: repeat(2, 1fr)
    }
  }

  @media(max-width:768px) {
    .stat-cards {
      grid-template-columns: repeat(2, 1fr)
    }

    .search-box {
      width: 100%
    }
  }
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
          <th>Quiz Dikerjakan</th>
          <th>Tanggal Daftar</th>
        </tr>
      </thead>
      <tbody id="tableBody">
        <?php if (!empty($peserta)): ?>
          <?php foreach ($peserta as $i => $p): ?>
            <?php
            $nilai = $p->rata_nilai ?? 0;
            $scoreClass = $nilai >= 80 ? 'high' : ($nilai >= 65 ? 'mid' : ($nilai > 0 ? 'low' : 'none'));
            $avColor = 'av-' . ($i % 8);
            ?>
            <tr data-kelas="<?= $p->id_kelas ?>" data-nama="<?= strtolower(esc($p->nama_users)) ?>"
              data-email="<?= strtolower(esc($p->email_users)) ?>">
              <td class="row-num" style="color:#9ca3af;font-weight:700;"><?= $i + 1 ?></td>
              <td>
                <div class="student-cell">
                  <div class="stu-avatar <?= $avColor ?>"><?= strtoupper(substr($p->nama_users, 0, 1)) ?></div>
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
              <td style="color:#374151;font-weight:600;"><?= $p->jumlah_quiz ?> quiz</td>
              <td style="color:#6b7280;"><?= date('d M Y', strtotime($p->tanggal_daftar_kelas_peserta)) ?></td>
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

<script>
  let activeKelas = 'semua';

  function switchKelas(kelasId, btn) {
    activeKelas = String(kelasId);
    document.querySelectorAll('.kelas-tab').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    filterTable();
  }

  function filterTable() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    const rows = document.querySelectorAll('#tableBody tr[data-nama]');
    let visible = 0;

    rows.forEach(row => {
      const matchKelas = activeKelas === 'semua' || row.dataset.kelas === activeKelas;
      const matchSearch = row.dataset.nama.includes(q) || row.dataset.email.includes(q);
      const show = matchKelas && matchSearch;
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
</script>

<?= $this->endSection() ?>
<?php // app/Views/Dashboard/Peserta/beranda.php
?>
<?php echo $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?php echo $this->section('meta') ?>
<title>Beranda Siswa — LMS Elecomp</title>
<?php echo $this->endSection() ?>

<?php echo $this->section('styles') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
/* =============================================
   BERANDA PESERTA — Responsive
   ============================================= */

/* ── PAGE HEADER ── */
.page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.page-header h1 {
    font-size: 22px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 4px;
    font-family: 'Syne', sans-serif;
}
.page-header p {
    font-size: 13px;
    color: #64748b;
    margin: 0;
}
.date-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    background: #f1f5f9;
    border: 1px solid #e2e8f0;
    border-radius: 9999px;
    padding: 6px 14px;
    font-size: 13px;
    color: #475569;
    white-space: nowrap;
    flex-shrink: 0;
}

/* ── WELCOME BANNER ── */
.welcome-banner {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 60%, #0ea5e9 100%);
    border-radius: 18px;
    padding: 28px 28px 28px 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 20px;
    overflow: hidden;
    position: relative;
}
.welcome-banner::before {
    content: '';
    position: absolute;
    width: 200px;
    height: 200px;
    background: rgba(255,255,255,0.07);
    border-radius: 50%;
    right: 60px;
    top: -60px;
}
.welcome-text h2 {
    font-size: 20px;
    font-weight: 700;
    color: #fff;
    margin: 0 0 6px;
    font-family: 'Syne', sans-serif;
}
.welcome-text p {
    font-size: 14px;
    color: rgba(255,255,255,0.85);
    margin: 0 0 12px;
    line-height: 1.5;
}
.rank-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(255,255,255,0.2);
    color: #fff;
    border-radius: 9999px;
    padding: 5px 14px;
    font-size: 12px;
    font-weight: 600;
}
.welcome-emoji {
    font-size: 52px;
    flex-shrink: 0;
    line-height: 1;
    position: relative;
    z-index: 1;
}

/* ── STAT CARDS ── */
.stat-cards {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 12px;
    margin-bottom: 20px;
    width: 100%;
    box-sizing: border-box;
}
.stat-card {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 16px;
    padding: 16px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
}
.stat-card-top {
    margin-bottom: 10px;
}
.stat-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
}
.stat-icon.blue   { background: #eff6ff; color: #2563eb; }
.stat-icon.orange { background: #fff7ed; color: #ea580c; }
.stat-icon.purple { background: #f5f3ff; color: #7c3aed; }
.stat-icon.green  { background: #f0fdf4; color: #16a34a; }
.stat-label {
    font-size: 11px;
    font-weight: 600;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 4px;
}
.stat-value {
    font-size: 28px;
    font-weight: 700;
    color: #0f172a;
    line-height: 1;
    margin-bottom: 4px;
    font-family: 'Syne', sans-serif;
}
.stat-sub {
    font-size: 11px;
    color: #94a3b8;
}

/* ── BOTTOM GRID ── */
.bottom-grid {
    display: grid;
    grid-template-columns: minmax(0, 1fr);
    gap: 16px;
    margin-bottom: 16px;
    width: 100%;
    box-sizing: border-box;
}

/* ── DASH CARD ── */
.dash-card {
    background: #ffffff;
    border: 1px solid #f1f5f9;
    border-radius: 18px;
    padding: 20px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.04);
}
.card-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 2px;
    font-family: 'Syne', sans-serif;
}

/* ── FIX: override peserta-layout.css lama ── */
.card-sub {
    font-size: 12px !important;
    font-weight: 400 !important;
    color: #94a3b8 !important;
    text-transform: none !important;
    letter-spacing: normal !important;
    margin-bottom: 16px !important;
}

/* ── KELAS ITEM ── */
.kelas-item {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 12px 0;
    border-bottom: 1px solid #f8fafc;
}
.kelas-item:last-child { border-bottom: none; }
.kelas-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    flex-shrink: 0;
}
.kelas-icon.blue   { background: #eff6ff; color: #2563eb; }
.kelas-icon.green  { background: #f0fdf4; color: #16a34a; }
.kelas-icon.orange { background: #fff7ed; color: #ea580c; }
.kelas-icon.purple { background: #f5f3ff; color: #7c3aed; }
.kelas-info { flex: 1; min-width: 0; }
.kelas-nama {
    font-size: 13px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.kelas-pengajar {
    font-size: 11px;
    color: #94a3b8;
    margin-bottom: 8px;
}
.kelas-progress-wrap { width: 100%; }
.kelas-progress-bar {
    height: 5px;
    background: #f1f5f9;
    border-radius: 9999px;
    overflow: hidden;
    margin-bottom: 4px;
}
.kelas-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #2563eb, #0ea5e9);
    border-radius: 9999px;
    transition: width 0.6s ease;
}
.kelas-progress-label {
    display: flex;
    justify-content: space-between;
    font-size: 10px;
    color: #94a3b8;
}

/* ── DONUT CHART ── */
.dist-wrap {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
}
.donut-wrap {
    width: 100px;
    height: 100px;
    flex-shrink: 0;
}
.dist-legend { flex: 1; min-width: 120px; }
.dist-legend-item {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 8px;
}
.dist-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    flex-shrink: 0;
}
.dist-legend-label { flex: 1; font-size: 12px; color: #64748b; }
.dist-legend-val { font-size: 13px; font-weight: 700; color: #0f172a; }

/* ── QUIZ ITEM ── */
.quiz-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px solid #f8fafc;
}
.quiz-item:last-child { border-bottom: none; }
.quiz-icon {
    width: 34px;
    height: 34px;
    border-radius: 9px;
    background: #f0fdf4;
    color: #16a34a;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
}
.quiz-info { flex: 1; min-width: 0; }
.quiz-name {
    font-size: 13px;
    font-weight: 600;
    color: #1e293b;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.quiz-kelas { font-size: 11px; color: #94a3b8; }
.quiz-time  { font-size: 10px; color: #cbd5e1; margin-top: 2px; }
.quiz-badge {
    padding: 3px 10px;
    border-radius: 9999px;
    font-size: 12px;
    font-weight: 700;
    flex-shrink: 0;
    align-self: center;
}
.quiz-badge.high { background: #f0fdf4; color: #16a34a; }
.quiz-badge.mid  { background: #fffbeb; color: #d97706; }
.quiz-badge.low  { background: #fef2f2; color: #ef4444; }

/* ── EMPTY STATE ── */
.empty-state {
    text-align: center;
    padding: 32px 16px;
    color: #94a3b8;
}
.empty-state i  { font-size: 36px; margin-bottom: 8px; display: block; }
.empty-state p  { font-size: 13px; margin: 0; }

/* ── MATERI ITEM ── */
.materi-icon {
    font-size: 22px;
    margin-bottom: 8px;
    color: #2563eb;
}
.materi-judul {
    font-size: 13px;
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 2px;
}
.materi-modul {
    font-size: 11px;
    color: #94a3b8;
    margin-bottom: 10px;
}

/* ── RIGHT-COL ── */
.right-col {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* =============================================
   RESPONSIVE — TABLET (≥ 768px)
   ============================================= */
@media (min-width: 768px) {
    .bottom-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
    .stat-cards {
        grid-template-columns: repeat(4, minmax(0, 1fr));
    }
}

/* =============================================
   RESPONSIVE — MOBILE (≤ 640px)
   ============================================= */
@media (max-width: 640px) {
    .page-header h1   { font-size: 18px; }
    .date-badge       { font-size: 12px; padding: 5px 11px; }

    .welcome-banner   { padding: 20px 18px; border-radius: 14px; }
    .welcome-text h2  { font-size: 17px; }
    .welcome-text p   { font-size: 13px; }
    .welcome-emoji    { font-size: 38px; }

    .stat-cards {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }
    .stat-value  { font-size: 24px; }
    .stat-icon   { width: 36px; height: 36px; font-size: 16px; }

    .dash-card   { padding: 16px; border-radius: 14px; }
    .card-title  { font-size: 14px; }

    .materi-grid { grid-template-columns: 1fr !important; }

    .donut-wrap  { width: 80px; height: 80px; }
}
</style>
<?php echo $this->endSection() ?>

<?php echo $this->section('content') ?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h1>Beranda Saya</h1>
        <p>Pantau progres belajar dan aktivitas quiz kamu hari ini.</p>
    </div>
    <div class="date-badge">
        <i class="bi bi-calendar3"></i>
        <span id="today-date"></span>
    </div>
</div>

<!-- WELCOME BANNER -->
<div class="welcome-banner">
    <div class="welcome-text">
        <h2>Halo, <?php echo esc(session()->get('nama') ?? 'Siswa') ?>! 👋</h2>
        <p>Semangat belajar hari ini. Kamu sudah mengerjakan <strong style="color:#fff;"><?php echo esc($total_quiz_dikerjakan ?? 0) ?> quiz</strong> dari total yang tersedia.</p>
        <?php if (! empty($peringkat)): ?>
        <div class="rank-badge">
            <i class="bi bi-trophy-fill"></i>
            Peringkat <?php echo esc($peringkat) ?> dari <?php echo esc($total_peserta_kelas ?? '-') ?> peserta
        </div>
        <?php endif; ?>
    </div>
    <div class="welcome-emoji">🎓</div>
</div>

<!-- STAT CARDS -->
<div class="stat-cards">
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon blue"><i class="bi bi-book-fill"></i></div>
        </div>
        <div class="stat-label">Kelas Diikuti</div>
        <div class="stat-value"><?php echo esc($total_kelas ?? 0) ?></div>
        <div class="stat-sub">Kelas aktif</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon orange"><i class="bi bi-file-earmark-text-fill"></i></div>
        </div>
        <div class="stat-label">Total Materi</div>
        <div class="stat-value"><?php echo esc($total_materi ?? 0) ?></div>
        <div class="stat-sub">Tersedia untuk dibaca</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon purple"><i class="bi bi-clipboard-check-fill"></i></div>
        </div>
        <div class="stat-label">Quiz Dikerjakan</div>
        <div class="stat-value"><?php echo esc($total_quiz_dikerjakan ?? 0) ?></div>
        <div class="stat-sub">Dari <?php echo esc($total_quiz_tersedia ?? 0) ?> quiz tersedia</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon green"><i class="bi bi-graph-up-arrow"></i></div>
        </div>
        <div class="stat-label">Rata-rata Nilai</div>
        <div class="stat-value"><?php echo esc($rata_nilai ?? 0) ?></div>
        <div class="stat-sub">Dari semua quiz</div>
    </div>
</div>

<!-- BOTTOM GRID -->
<div class="bottom-grid">

    <!-- KELAS SAYA + PROGRES -->
    <div class="dash-card">
        <div class="card-title">Kelas yang Diikuti</div>
        <div class="card-sub">Progres materi per kelas</div>

        <?php if (empty($kelas_list)): ?>
        <div class="empty-state">
            <i class="bi bi-journal-x"></i>
            <p>Belum ada kelas yang kamu ikuti.</p>
        </div>
        <?php else: ?>
        <?php
            $iconColors = ['blue', 'green', 'orange', 'purple'];
            $icons      = ['bi-lightning-charge-fill', 'bi-cpu-fill', 'bi-tools', 'bi-diagram-3-fill'];
            foreach ($kelas_list as $i => $k):
                $colorIdx      = $i % count($iconColors);
                $total_modul   = $k['total_modul']   ?? 0;
                $modul_selesai = $k['modul_selesai'] ?? 0;
                $persen        = $total_modul > 0 ? round(($modul_selesai / $total_modul) * 100) : 0;
        ?>
        <div class="kelas-item">
            <div class="kelas-icon <?php echo $iconColors[$colorIdx] ?>">
                <i class="bi <?php echo $icons[$colorIdx] ?>"></i>
            </div>
            <div class="kelas-info">
                <div class="kelas-nama"><?php echo esc($k['nama_kelas']) ?></div>
                <div class="kelas-pengajar"><?php echo esc($k['nama_pengajar'] ?? 'Pengajar') ?></div>
                <div class="kelas-progress-wrap">
                    <div class="kelas-progress-bar">
                        <div class="kelas-progress-fill" style="width: <?php echo $persen ?>%"></div>
                    </div>
                    <div class="kelas-progress-label">
                        <span><?php echo $modul_selesai ?>/<?php echo $total_modul ?> modul selesai</span>
                        <span><?php echo $persen ?>%</span>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- KOLOM KANAN -->
    <div class="right-col">

        <!-- DISTRIBUSI NILAI -->
        <div class="dash-card">
            <div class="card-title">Distribusi Nilai Quiz Saya</div>
            <div class="card-sub">Dari semua quiz yang dikerjakan</div>
            <div class="dist-wrap">
                <div class="donut-wrap">
                    <canvas id="donutChart"></canvas>
                </div>
                <div class="dist-legend">
                    <div class="dist-legend-item">
                        <div class="dist-dot" style="background:#059669;"></div>
                        <div class="dist-legend-label">Lulus (≥70)</div>
                        <div class="dist-legend-val"><?php echo esc($dist_lulus ?? 0) ?></div>
                    </div>
                    <div class="dist-legend-item">
                        <div class="dist-dot" style="background:#d97706;"></div>
                        <div class="dist-legend-label">Cukup (50–69)</div>
                        <div class="dist-legend-val"><?php echo esc($dist_cukup ?? 0) ?></div>
                    </div>
                    <div class="dist-legend-item">
                        <div class="dist-dot" style="background:#ef4444;"></div>
                        <div class="dist-legend-label">Kurang (&lt;50)</div>
                        <div class="dist-legend-val"><?php echo esc($dist_kurang ?? 0) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIWAYAT QUIZ TERBARU -->
        <div class="dash-card">
            <div class="card-title">Riwayat Quiz Terbaru</div>
            <div class="card-sub">Hasil quiz yang kamu kerjakan</div>

            <?php if (empty($riwayat_quiz)): ?>
            <p style="color:#9ca3af;font-size:13px;">Kamu belum mengerjakan quiz apapun.</p>
            <?php else: ?>
            <?php foreach ($riwayat_quiz as $qr):
                $val = (int) $qr['nilai_quiz_results'];
                $cls = $val >= 70 ? 'high' : ($val >= 50 ? 'mid' : 'low');
                $tgl = date('d M, H:i', strtotime($qr['waktu_selesai_quiz_results']));
            ?>
            <div class="quiz-item">
                <div class="quiz-icon"><i class="bi bi-clipboard2-check-fill"></i></div>
                <div class="quiz-info">
                    <div class="quiz-name"><?php echo esc($qr['judul_quiz']) ?></div>
                    <div class="quiz-kelas"><?php echo esc($qr['nama_kelas']) ?></div>
                    <div class="quiz-time"><i class="bi bi-clock" style="font-size:10px;"></i> <?php echo $tgl ?></div>
                </div>
                <span class="quiz-badge <?php echo $cls ?>"><?php echo $val ?></span>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div><!-- /right-col -->

</div><!-- /bottom-grid -->

<!-- MATERI TERBARU -->
<div class="dash-card" style="margin-top:0;">
    <div class="card-title">Materi Terbaru</div>
    <div class="card-sub">Konten pembelajaran yang baru ditambahkan di kelas kamu</div>

    <?php if (empty($materi_terbaru)): ?>
    <p style="color:#9ca3af;font-size:13px;">Belum ada materi.</p>
    <?php else: ?>
    <div class="materi-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(240px,100%),1fr));gap:12px;">
        <?php foreach ($materi_terbaru as $m): ?>
        <div style="border:1px solid #f1f5f9;border-radius:14px;padding:14px;background:#fafafa;">
            <div class="materi-icon">
                <?php if ($m['file_materi']): ?>
                <i class="bi bi-file-earmark-pdf-fill" style="color:#ef4444;"></i>
                <?php elseif ($m['video_url_materi']): ?>
                <i class="bi bi-play-circle-fill" style="color:#ef4444;"></i>
                <?php else: ?>
                <i class="bi bi-file-earmark-text-fill" style="color:#2563eb;"></i>
                <?php endif; ?>
            </div>
            <div class="materi-judul"><?php echo esc($m['judul_materi']) ?></div>
            <div class="materi-modul"><?php echo esc($m['judul_modul']) ?> · <?php echo esc($m['nama_kelas']) ?></div>
            <a href="<?php echo base_url('dashboard/peserta/materi-modul/' . $m['id_modul'] . '?materi=' . $m['id_materi']) ?>"
                style="font-size:12px;font-weight:600;color:#2563eb;text-decoration:none;background:#eff6ff;padding:5px 14px;border-radius:8px;display:inline-flex;align-items:center;gap:4px;">
                Lihat Materi <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?php echo $this->endSection() ?>

<?php echo $this->section('scripts') ?>
<script>
const days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
const months = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
const now    = new Date();
document.getElementById('today-date').textContent =
    `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;

window.addEventListener('load', function() {
    const ctx    = document.getElementById('donutChart').getContext('2d');
    const lulus  = <?php echo (int)($dist_lulus  ?? 0) ?>;
    const cukup  = <?php echo (int)($dist_cukup  ?? 0) ?>;
    const kurang = <?php echo (int)($dist_kurang ?? 0) ?>;
    const total  = lulus + cukup + kurang;

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Lulus','Cukup','Kurang'],
            datasets: [{
                data: total > 0 ? [lulus, cukup, kurang] : [1, 0, 0],
                backgroundColor: total > 0
                    ? ['#059669','#d97706','#ef4444']
                    : ['#e5e7eb','#e5e7eb','#e5e7eb'],
                borderWidth: 0,
                hoverOffset: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '70%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#111',
                    titleColor: '#fff',
                    bodyColor: '#ccc',
                    padding: 10,
                    cornerRadius: 8,
                    callbacks: {
                        label: (ctx) => total > 0 ? ` ${ctx.label}: ${ctx.raw}` : ' Belum ada data'
                    }
                }
            }
        }
    });
});
</script>
<?php echo $this->endSection() ?>
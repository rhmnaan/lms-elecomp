<?php // app/Views/Dashboard/Peserta/beranda.php
?>
<?php echo $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?php echo $this->section('meta') ?>
<title>Beranda Siswa — LMS Elecomp</title>
<?php echo $this->endSection() ?>

<?php echo $this->section('styles') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        <p>Semangat belajar hari ini. Kamu sudah mengerjakan <strong
                style="color:#fff;"><?php echo esc($total_quiz_dikerjakan ?? 0) ?> quiz</strong> dari total yang tersedia.</p>
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
                $colorIdx = $i % count($iconColors);
                // Tambahkan default values
                $total_modul   = $k['total_modul'] ?? 0;
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

        <!-- DISTRIBUSI NILAI SAYA -->
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

<!-- MATERI TERBARU (full width) -->
<div class="dash-card" style="margin-top:20px;">
    <div class="card-title">Materi Terbaru</div>
    <div class="card-sub">Konten pembelajaran yang baru ditambahkan di kelas kamu</div>

    <?php if (empty($materi_terbaru)): ?>
    <p style="color:#9ca3af;font-size:13px;">Belum ada materi.</p>
    <?php else: ?>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:12px;">
        <?php foreach ($materi_terbaru as $m): ?>
        <div class="materi-item" style="border:1px solid #f3f4f6;border-radius:14px;padding:14px;background:#fafafa;">
            <div class="materi-icon">
                <?php if ($m['file_materi']): ?>
                <i class="bi bi-file-earmark-pdf-fill"></i>
                <?php elseif ($m['video_url_materi']): ?>
                <i class="bi bi-play-circle-fill" style="color:#ef4444;background:#fee2e2;"></i>
                <?php else: ?>
                <i class="bi bi-file-earmark-text-fill"></i>
                <?php endif; ?>
            </div>
            <div class="materi-info">
                <div class="materi-judul"><?php echo esc($m['judul_materi']) ?></div>
                <div class="materi-modul"><?php echo esc($m['judul_modul']) ?> · <?php echo esc($m['nama_kelas']) ?></div>
            </div>
            <!-- PERBAIKAN LINK: arah ke materi-modul dengan parameter materi -->
            <a href="<?php echo base_url('dashboard/peserta/materi-modul/' . $m['id_modul'] . '?materi=' . $m['id_materi']) ?>"
                class="btn-lihat-materi"
                style="font-size: 11px; font-weight: 700; color: #2d6cdf; text-decoration: none; background: #eff6ff; padding: 5px 12px; border-radius: 8px; display: inline-block;">
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
const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
];
const now = new Date();
document.getElementById('today-date').textContent =
    `${days[now.getDay()]}, ${now.getDate()} ${months[now.getMonth()]} ${now.getFullYear()}`;

window.addEventListener('load', function() {
    const ctx = document.getElementById('donutChart').getContext('2d');
    const lulus = <?php echo (int)($dist_lulus  ?? 0) ?>;
    const cukup = <?php echo (int)($dist_cukup  ?? 0) ?>;
    const kurang = <?php echo (int)($dist_kurang ?? 0) ?>;
    const total = lulus + cukup + kurang;

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Lulus', 'Cukup', 'Kurang'],
            datasets: [{
                data: total > 0 ? [lulus, cukup, kurang] : [1, 0, 0],
                backgroundColor: total > 0 ? ['#059669', '#d97706', '#ef4444'] : ['#e5e7eb',
                    '#e5e7eb', '#e5e7eb'
                ],
                borderWidth: 0,
                hoverOffset: 4,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                },
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
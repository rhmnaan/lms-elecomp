<?php // app/Views/dashboard/admin.php ?>
<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>

<?= $this->section('meta') ?>
<title>Dashboard Pengajar — LMS Elecomp</title>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h1>Ikhtisar Dasbor</h1>
        <p>Selamat datang kembali! Berikut ringkasan aktivitas LMS hari ini.</p>
    </div>
    <div class="date-badge">
        <i class="bi bi-calendar3"></i>
        <span id="today-date"></span>
    </div>
</div>

<!-- STAT CARDS -->
<div class="stat-cards">
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon blue"><i class="bi bi-person-fill"></i></div>
        </div>
        <div class="stat-label">Total Peserta</div>
        <div class="stat-value"><?= esc($total_peserta) ?></div>
        <div class="stat-sub">Terdaftar di sistem</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon orange"><i class="bi bi-book-fill"></i></div>
        </div>
        <div class="stat-label">Total Kelas</div>
        <div class="stat-value"><?= esc($total_kelas) ?></div>
        <div class="stat-sub"><?= esc($total_modul) ?> modul tersedia</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon green"><i class="bi bi-file-earmark-text-fill"></i></div>
        </div>
        <div class="stat-label">Total Materi</div>
        <div class="stat-value"><?= esc($total_materi) ?></div>
        <div class="stat-sub">Materi diunggah</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-top">
            <div class="stat-icon purple"><i class="bi bi-clipboard-check-fill"></i></div>
        </div>
        <div class="stat-label">Total Quiz</div>
        <div class="stat-value"><?= esc($total_quiz) ?></div>
        <div class="stat-sub">Di semua kelas</div>
    </div>
</div>

<!-- BOTTOM GRID -->
<div class="bottom-grid">

    <!-- LEADERBOARD -->
    <div class="dash-card">
        <div class="card-title">Leaderboard Peserta</div>
        <div class="card-sub">Rata-rata nilai quiz tertinggi</div>

        <?php if (empty($leaderboard)): ?>
        <p style="color:#9ca3af;font-size:13px;">Belum ada data quiz.</p>
        <?php else: ?>
        <?php
            $rankClass = ['gold', 'silver', 'bronze', 'other', 'other'];
            $rankIcon  = ['🥇', '🥈', '🥉', '4', '5'];
            foreach ($leaderboard as $i => $lb):
                $val = (int) $lb['rata_nilai'];
                $cls = $val >= 70 ? 'high' : ($val >= 50 ? 'mid' : 'low');
            ?>
        <div class="lb-item">
            <div class="lb-rank <?= $rankClass[$i] ?>"><?= $rankIcon[$i] ?></div>
            <div class="lb-avatar"><?= strtoupper(substr($lb['nama_users'], 0, 1)) ?></div>
            <div class="lb-info">
                <div class="lb-name"><?= esc($lb['nama_users']) ?></div>
                <div class="lb-meta"><?= esc($lb['total_quiz_dikerjakan']) ?> quiz dikerjakan</div>
            </div>
            <div class="lb-score">
                <div class="lb-score-val <?= $cls ?>"><?= $val ?></div>
                <div class="lb-score-label">RERATA</div>
            </div>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- KOLOM KANAN -->
    <div class="right-col">

        <!-- DISTRIBUSI NILAI -->
        <div class="dash-card">
            <div class="card-title">Distribusi Nilai Quiz</div>
            <div class="card-sub">Dari semua hasil pengerjaan</div>
            <div class="dist-wrap">
                <div class="donut-wrap">
                    <canvas id="donutChart"></canvas>
                </div>
                <div class="dist-legend">
                    <div class="dist-legend-item">
                        <div class="dist-dot" style="background:#059669;"></div>
                        <div class="dist-legend-label">Lulus (≥70)</div>
                        <div class="dist-legend-val"><?= esc($dist_lulus) ?></div>
                    </div>
                    <div class="dist-legend-item">
                        <div class="dist-dot" style="background:#d97706;"></div>
                        <div class="dist-legend-label">Cukup (50–69)</div>
                        <div class="dist-legend-val"><?= esc($dist_cukup) ?></div>
                    </div>
                    <div class="dist-legend-item">
                        <div class="dist-dot" style="background:#ef4444;"></div>
                        <div class="dist-legend-label">Kurang (&lt;50)</div>
                        <div class="dist-legend-val"><?= esc($dist_kurang) ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AKTIVITAS TERBARU -->
        <div class="dash-card">
            <div class="card-title">Aktivitas Quiz Terbaru</div>
            <div class="card-sub">Pengerjaan terakhir oleh peserta</div>

            <?php if (empty($aktivitas_terbaru)): ?>
            <p style="color:#9ca3af;font-size:13px;">Belum ada aktivitas.</p>
            <?php else: ?>
            <?php foreach ($aktivitas_terbaru as $act):
                    $val = (int) $act['nilai_quiz_results'];
                    $cls = $val >= 70 ? 'high' : ($val >= 50 ? 'mid' : 'low');
                    $tgl = date('d M, H:i', strtotime($act['waktu_selesai_quiz_results']));
                ?>
            <div class="act-item">
                <div class="act-icon"><i class="bi bi-clipboard2-check-fill"></i></div>
                <div class="act-info">
                    <div class="act-name"><?= esc($act['nama_users']) ?></div>
                    <div class="act-quiz"><?= esc($act['judul_quiz']) ?> · <?= esc($act['nama_kelas']) ?></div>
                    <div class="act-time"><i class="bi bi-clock" style="font-size:10px;"></i> <?= $tgl ?></div>
                </div>
                <span class="act-badge <?= $cls ?>"><?= $val ?></span>
            </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div><!-- /right-col -->

</div><!-- /bottom-grid -->

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
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
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Lulus', 'Cukup', 'Kurang'],
            datasets: [{
                data: [
                    <?= (int) $dist_lulus ?>,
                    <?= (int) $dist_cukup ?>,
                    <?= (int) $dist_kurang ?>
                ],
                backgroundColor: ['#059669', '#d97706', '#ef4444'],
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
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>
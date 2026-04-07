<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('meta') ?>
<title><?= esc($modul['judul_modul']) ?> — LMS Elecomp</title>
<?= $this->endSection() ?>
<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('css/materi-modul.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$currentMateri = $materi_aktif ?? ($materi_list[0] ?? null);
$currentIndex  = 0;
$prevMateri    = null;
$nextMateri    = null;

if ($currentMateri) {
    foreach ($materi_list as $index => $m) {
        if ($m['id_materi'] == $currentMateri['id_materi']) {
            $currentIndex = $index;
            $prevMateri   = $materi_list[$index - 1] ?? null;
            $nextMateri   = $materi_list[$index + 1] ?? null;
            break;
        }
    }
}

// Parse quiz_data
$quizSoal = [];
if (!empty($currentMateri['quiz_data'])) {
    $decoded = json_decode($currentMateri['quiz_data'], true);
    if (is_array($decoded)) $quizSoal = $decoded;
}

$hasVideo = !empty($currentMateri['video_url_materi']);
$hasFile  = !empty($currentMateri['file_materi']);
$hasIsi   = !empty($currentMateri['isi_materi']);
$hasQuiz  = !empty($quizSoal);
?>

<?php
// ==============================
// SET VAR GLOBAL (ANTI ERROR)
// ==============================
$embedId = null;

if (!empty($materi_aktif['video_url_materi'])) {
    preg_match(
        '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_-]{11})/',
        $materi_aktif['video_url_materi'],
        $matches
    );
    $embedId = $matches[1] ?? null;
}
?>

<div class="materi-modul-container">

    <!-- ══ SIDEBAR ══ -->
    <div class="materi-sidebar">
        <div class="sidebar-header">
            <h3><?= esc($modul['judul_modul']) ?></h3>
            <p><?= count($materi_list) ?> materi &bull; Modul <?= $modul['urutan_modul'] ?? 1 ?></p>
        </div>
        <ul class="materi-list">
            <?php foreach ($materi_list as $index => $m):
                $isActive = ($currentMateri && $m['id_materi'] == $currentMateri['id_materi']);
                $hasV = !empty($m['video_url_materi']);
                $hasF = !empty($m['file_materi']);
                if ($hasV && $hasF)  { $tipeIcon = '<i class="bi bi-collection-play-fill"></i>'; $tipeLabel = 'Video & PDF'; }
                elseif ($hasV)       { $tipeIcon = '<i class="bi bi-play-circle-fill"></i>';     $tipeLabel = 'Video'; }
                elseif ($hasF)       { $tipeIcon = '<i class="bi bi-file-earmark-pdf-fill"></i>'; $tipeLabel = 'PDF'; }
                else                 { $tipeIcon = '<i class="bi bi-file-text-fill"></i>';        $tipeLabel = 'Artikel'; }
            ?>
            <li class="materi-list-item <?= $isActive ? 'active' : '' ?> <?= !$m['is_accessible'] ? 'disabled' : '' ?>"
                <?= $m['is_accessible'] ? 'onclick="loadMateri(' . $m['id_materi'] . ')"' : '' ?>>
                <div class="materi-list-number"><?= $index + 1 ?></div>
                <div class="materi-list-info">
                    <div class="materi-list-title"><?= esc($m['judul_materi']) ?></div>
                    <div class="materi-list-meta"><?= $tipeIcon ?> <?= $tipeLabel ?></div>
                </div>
                <div class="status-icon <?= ($m['is_completed'] ?? false) ? 'completed' : '' ?>">
                    <?php if ($m['is_completed'] ?? false): ?>
                    <i class="bi bi-check-circle-fill"></i>
                    <?php endif; ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- ══ KONTEN ══ -->
    <div class="materi-content">
        <?php if ($currentMateri): ?>

        <div class="content-header">
            <div class="content-breadcrumb">
                <a href="<?= base_url('dashboard/peserta/kelas') ?>">Kelas Saya</a>
                <i class="bi bi-chevron-right"></i>
                <a href="<?= base_url('dashboard/peserta/modul') ?>">Modul</a>
                <i class="bi bi-chevron-right"></i>
                <span><?= esc($modul['judul_modul']) ?></span>
            </div>
            <div class="content-title"><?= esc($currentMateri['judul_materi']) ?></div>
            <div class="content-meta">
                <span><i class="bi bi-folder"></i> <?= esc($modul['judul_modul']) ?></span>
                <div class="tipe-badges">
                    <?php if ($hasVideo): ?><span class="tipe-badge video"><i class="bi bi-play-circle-fill"></i>
                        Video</span><?php endif; ?>
                    <?php if ($hasFile):  ?><span class="tipe-badge pdf"><i class="bi bi-file-earmark-pdf-fill"></i>
                        PDF</span><?php endif; ?>
                    <?php if ($hasIsi):   ?><span class="tipe-badge artikel"><i class="bi bi-file-text-fill"></i>
                        Artikel</span><?php endif; ?>
                    <?php if ($hasQuiz):  ?><span class="tipe-badge quiz"><i class="bi bi-patch-question-fill"></i>
                        Quiz</span><?php endif; ?>
                </div>
            </div>
        </div>

        <div class="content-body">
            <!-- PRE TEST -->
            <div class="content-section">
                <div class="section-label">
                    <i class="bi bi-clipboard-check" style="color:#0ea5e9;"></i> Pre Test
                </div>

                <?php if ($has_pretest): ?>
                <!-- ✅ SUDAH ADA HASIL -->
                <div class="pretest-card" style="background:#ecfdf5; border-color:#86efac;">
                    <div class="pretest-icon" style="background:#10b981;">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                    <div class="pretest-info">
                        <h4>Hasil Pre Test</h4>
                        <p>Kamu sudah mengerjakan pre test</p>
                        <strong style="font-size:18px; color:#065f46;">
                            Nilai: <?= esc($nilai_pre['nilai']) ?>
                        </strong>
                    </div>
                </div>

                <?php else: ?>
                <!-- ❌ BELUM ADA HASIL -->
                <div class="pretest-card">
                    <div class="pretest-icon">
                        <i class="bi bi-clipboard-data"></i>
                    </div>
                    <div class="pretest-info">
                        <h4>Pre Test Modul</h4>
                        <p>Kerjakan pre test untuk mengetahui pemahaman awal kamu sebelum memulai materi.</p>
                    </div>
                    <a href="<?= base_url('dashboard/peserta/pretest/' . $currentMateri['id_materi']) .
                        '?redirect=' . urlencode(
                            base_url('dashboard/peserta/materi-modul/' . $modul['id_modul']) .
                            '?materi=' . $currentMateri['id_materi']
                        )
                    ?>" class="btn-pretest">
                        <i class="bi bi-play-fill"></i> Mulai Pre Test
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <!-- 1. VIDEO -->
            <?php if ($hasVideo): ?>
            <div class="content-section">

                <?php if (!$has_pretest): ?>
                <!-- 🔒 VIDEO TERKUNCI -->
                <div class="video-container locked">
                    <div class="locked-overlay">
                        <i class="bi bi-lock-fill"></i>
                        <p>Selesaikan Pre Test untuk membuka video</p>
                    </div>
                </div>

                <?php else: ?>
                <!-- ▶️ VIDEO AKTIF -->
                <div class="video-container">
                    <?php
                    preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_-]{11})/', $currentMateri['video_url_materi'], $matches);
                    $embedId = $matches[1] ?? null;
                    ?>
                    <?php if ($embedId): ?>
                    <div class="mb-4">
                        <div id="player"></div>
                    </div>
                    <?php else: ?>
                    <iframe src="<?= esc($currentMateri['video_url_materi']) ?>" allowfullscreen></iframe>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>
            <?php endif; ?>

            <!-- 2. FILE PDF - MODAL FULLSCREEN -->
            <?php if ($hasFile): ?>
            <div class="content-section">
                <?php if (!$has_pretest): ?>
                <!-- 🔒 FILE TERKUNCI - BELUM PRETEST -->
                <div class="file-preview locked">
                    <div class="file-icon locked">
                        <i class="bi bi-file-earmark-pdf-fill"></i>
                        <div class="lock-overlay">
                            <i class="bi bi-lock-fill"></i>
                        </div>
                    </div>
                    <div class="file-info">
                        <h4><?= esc($currentMateri['judul_materi']) ?></h4>
                        <p>Materi PDF terkunci. Selesaikan Pre Test terlebih dahulu untuk membuka materi.</p>
                    </div>
                    <span class="btn-view-pdf disabled">Terkunci</span>
                </div>
                <?php else: ?>
                <!-- ✅ FILE TERBUKA - SUDAH PRETEST -->
                <div class="file-preview">
                    <div class="file-icon">
                        <i class="bi bi-file-earmark-pdf-fill"></i>
                    </div>
                    <div class="file-info">
                        <h4><?= esc($currentMateri['judul_materi']) ?></h4>
                        <p>Klik tombol di bawah untuk membaca materi PDF. Sistem akan otomatis membuka posttest setelah
                            Anda selesai membaca.</p>
                    </div>
                    <button class="btn-view-pdf" onclick="openPDFModal()">Baca Materi</button>
                </div>
                <?php endif; ?>

                <!-- MODAL PDF FULLSCREEN -->
                <div id="pdfModal" class="pdf-modal" style="display:none;">
                    <div class="pdf-modal-content">
                        <!-- Header Modal -->
                        <div class="pdf-modal-header">
                            <h3><?= esc($currentMateri['judul_materi']) ?></h3>
                            <div class="pdf-modal-progress">
                                <div class="pdf-progress-bar">
                                    <div id="pdfProgressFill" class="pdf-progress-fill" style="width:0%"></div>
                                </div>
                                <span id="pdfProgressText" class="pdf-progress-text">0%</span>
                            </div>
                            <button class="pdf-modal-close" onclick="closePDFModal()">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>

                        <!-- PDF Container dengan Scroll -->
                        <div id="pdfContainer" class="pdf-container">
                            <div id="pdfViewer" style="overflow-y:auto;height:100%;padding:20px;">
                                <p>Browser Anda tidak mendukung PDF.
                                    <a href="<?= base_url($currentMateri['file_materi']) ?>" target="_blank">Download
                                        PDF</a>
                                </p>
                            </div>
                        </div>

                        <!-- Footer Modal -->
                        <div class="pdf-modal-footer">
                            <p id="pdfStatusText" class="pdf-status">Scrolling untuk membaca...</p>
                            <button class="btn-secondary" onclick="closePDFModal()">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- 3. ISI MATERI -->
            <?php if ($hasIsi): ?>
            <div class="content-section">
                <div class="section-label">
                    <i class="bi bi-file-text-fill" style="color:#2d6cdf;"></i>
                    <?= ($hasVideo || $hasFile) ? 'Ringkasan / Penjelasan Materi' : 'Isi Materi' ?>
                </div>
                <div class="article-content">
                    <?= htmlspecialchars_decode($currentMateri['isi_materi'], ENT_QUOTES) ?>
                </div>
            </div>
            <?php elseif (!$hasVideo && !$hasFile): ?>
            <div class="empty-content">
                <i class="bi bi-file-text" style="color:#d1d5db;"></i>
                <p style="font-size:15px;font-weight:600;color:#374151;margin:0 0 4px;">Konten belum tersedia</p>
                <small>Materi ini akan segera dilengkapi oleh instruktur.</small>
            </div>
            <?php endif; ?>

            <!-- POST TEST -->
            <div class="content-section">
                <div class="section-label">
                    <i class="bi bi-patch-question-fill" style="color:#7c3aed;"></i> Post Test
                </div>

                <?php if ($has_posttest): 
                    $posttestPassed = !empty($nilai_post['nilai']) && $nilai_post['nilai'] >= 70;
                    $cardBg = $posttestPassed ? '#ecfdf5' : '#fee2e2';
                    $borderColor = $posttestPassed ? '#86efac' : '#fca5a5';
                    $iconBg = $posttestPassed ? '#10b981' : '#dc2626';
                    $textColor = $posttestPassed ? '#065f46' : '#991b1b';
                    $statusLabel = $posttestPassed ? 'Lulus Post Test' : 'Belum Lulus Post Test';
                ?>
                <div class="posttest-card"
                    style="background:<?= $cardBg ?>;border-color:<?= $borderColor ?>;display:flex;align-items:center;justify-content:space-between;">
                    <div class="posttest-info" style="max-width: calc(100% - 180px);">
                        <h4><?= $statusLabel ?></h4>
                        <p>Nilai terakhir post test kamu.</p>
                        <strong style="font-size:18px;color:<?= $textColor ?>;">
                            Nilai: <?= esc($nilai_post['nilai']) ?>
                        </strong>
                    </div>
                    <?php if (!$posttestPassed): ?>
                    <a href="<?= base_url('dashboard/peserta/posttest/' . $currentMateri['id_materi'] . '?redirect=' . urlencode(current_url())) ?>"
                        class="btn-posttest" style="margin-left:20px;background:#dc2626;border-color:#dc2626;">
                        Mulai ulang Post Test
                    </a>
                    <?php else: ?>
                    <span
                        style="display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:10px;background:#d1fae5;color:#065f46;font-weight:700;">
                        <i class="bi bi-check-circle-fill"></i> Lulus
                    </span>
                    <?php endif; ?>
                </div>

                <?php else: ?>

                <?php if (!$has_pretest): ?>
                <!-- BELUM PRE TEST -->
                <div class="posttest-card" style="opacity:.6;">
                    <div class="posttest-icon">
                        <i class="bi bi-lock-fill"></i>
                    </div>
                    <div class="posttest-info">
                        <h4>Post Test Terkunci</h4>
                        <p>Selesaikan Pre Test terlebih dahulu</p>
                    </div>
                    <span class="btn-posttest disabled">Terkunci</span>
                </div>

                <?php elseif (!$materi_selesai): ?>
                <!-- MATERI BELUM SELESAI -->
                <div class="posttest-card" style="opacity:.6;" id="posttestLocked">
                    <div class="posttest-icon">
                        <i class="bi bi-lock-fill"></i>
                    </div>
                    <div class="posttest-info">
                        <h4>Post Test Terkunci</h4>
                        <p>Tonton video / scroll PDF sampai selesai</p>
                    </div>
                    <span class="btn-posttest disabled">Terkunci</span>
                </div>

                <?php else: ?>
                <!-- BOLEH POST TEST -->
                <div class="posttest-card" id="posttestUnlocked">
                    <div class="posttest-icon">
                        <i class="bi bi-patch-question-fill"></i>
                    </div>
                    <div class="posttest-info">
                        <h4>Post Test Modul</h4>
                        <p>Kerjakan test setelah menyelesaikan semua materi.</p>
                    </div>
                    <a href="<?= base_url('dashboard/peserta/posttest/' . $currentMateri['id_materi'] . '?redirect=' . urlencode(current_url())) ?>"
                        class="btn-posttest">
                        Mulai Post Test
                    </a>
                </div>
                <?php endif; ?>

                <?php endif; ?>
            </div>


            <!-- Navigasi -->
            <div class="nav-buttons">
                <?php if ($prevMateri): ?>
                <button onclick="loadMateri(<?= $prevMateri['id_materi'] ?>)" class="nav-btn prev">
                    <i class="bi bi-arrow-left"></i> Sebelumnya
                </button>
                <?php else: ?>
                <span class="nav-btn prev disabled"><i class="bi bi-arrow-left"></i> Sebelumnya</span>
                <?php endif; ?>

                <a href="<?= base_url('dashboard/peserta/modul') ?>" class="nav-btn modul">
                    <i class="bi bi-grid"></i> Daftar Modul
                </a>

                <?php if ($nextMateri && $nextMateri['is_accessible']): ?>
                <button onclick="loadMateri(<?= $nextMateri['id_materi'] ?>)" class="nav-btn next">
                    Selanjutnya <i class="bi bi-arrow-right"></i>
                </button>
                <?php elseif ($nextMateri): ?>
                <span class="nav-btn next disabled" title="Selesaikan materi sebelumnya dengan posttest >=70">
                    Belum Bisa <i class="bi bi-lock"></i>
                </span>
                <?php else: ?>
                <span class="nav-btn next disabled">Selanjutnya <i class="bi bi-arrow-right"></i></span>
                <?php endif; ?>
            </div>

        </div><!-- /content-body -->

        <?php else: ?>
        <div class="empty-content" style="margin:40px;">
            <i class="bi bi-journal-x" style="color:#d1d5db;"></i>
            <p style="font-size:16px;font-weight:600;color:#374151;margin:0 0 4px;">Belum ada materi</p>
            <small>Belum ada materi di modul ini.</small>
        </div>
        <?php endif; ?>
    </div>

</div>

<script>
const pdfUrl = <?= !empty($currentMateri['file_materi'])
    ? '"' . base_url($currentMateri['file_materi']) . '"'
    : 'null'
?>;
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
pdfjsLib.GlobalWorkerOptions.workerSrc =
    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
</script>
<script>
const MATERI_SELESAI = <?= $materi_selesai ? 'true' : 'false' ?>;
</script>
<script>
/* ── Data dari PHP ── */
const SOAL_DATA = <?= json_encode($quizSoal, JSON_UNESCAPED_UNICODE) ?>;
const TOTAL_SOAL = SOAL_DATA.length;
const CSRF_TOKEN = '<?= csrf_hash() ?>';
const CSRF_NAME = '<?= csrf_token() ?>';
const SAVE_URL = '<?= base_url('dashboard/peserta/quiz/simpan-materi') ?>';

/* ── State ── */
const jawabanUser = {}; // { soalIndex: pilihanIndex }
let quizSelesai = false;

/* ── Navigasi ── */
function loadMateri(idMateri) {
    window.location.href = '<?= base_url('dashboard/peserta/materi-modul') ?>/<?= $modul['id_modul'] ?>?materi=' +
        idMateri;
}

/* ── Pilih jawaban ── */
function pilihJawaban(el, soalIdx, pilihanIdx) {
    if (quizSelesai) return;

    document.querySelectorAll(`.pilihan-item[data-soal="${soalIdx}"]`)
        .forEach(p => p.classList.remove('selected'));
    el.classList.add('selected');
    jawabanUser[soalIdx] = pilihanIdx;

    // Update progress
    const terjawab = Object.keys(jawabanUser).length;
    document.getElementById('quizProgressText').textContent =
        `${terjawab} / ${TOTAL_SOAL} soal terjawab`;
}

/* ── Kumpulkan quiz ── */
async function kumpulkanQuiz() {
    if (quizSelesai) return;

    const terjawab = Object.keys(jawabanUser).length;
    if (terjawab < TOTAL_SOAL) {
        alert(`Harap jawab semua soal terlebih dahulu!\n(${terjawab} dari ${TOTAL_SOAL} soal terjawab)`);
        return;
    }

    // UI loading
    const btn = document.getElementById('btnKumpulkan');
    const spinner = document.getElementById('quizSpinner');
    const icon = document.getElementById('quizSendIcon');
    btn.disabled = true;
    spinner.style.display = 'inline-block';
    icon.style.display = 'none';

    // Hitung nilai lokal
    let benar = 0;
    SOAL_DATA.forEach((soal, qi) => {
        if (jawabanUser[qi] === soal.jawaban_benar) benar++;
    });
    const nilai = Math.round((benar / TOTAL_SOAL) * 100);

    // Highlight jawaban
    SOAL_DATA.forEach((soal, qi) => {
        document.querySelectorAll(`.pilihan-item[data-soal="${qi}"]`).forEach(el => {
            const idx = parseInt(el.dataset.index);
            el.classList.remove('selected');
            if (idx === soal.jawaban_benar) {
                el.classList.add('correct');
            } else if (idx === jawabanUser[qi]) {
                el.classList.add('wrong');
            } else {
                el.classList.add('not-selected-lock');
            }
            el.style.pointerEvents = 'none';
        });
    });

    quizSelesai = true;

    // Tampilkan hasil
    const resultBox = document.getElementById('quizResult');
    const lulus = nilai >= 70;
    document.getElementById('nilaiAngka').textContent = nilai;
    document.getElementById('nilaiKeterangan').textContent = lulus ? '🎉 Selamat! Kamu Lulus' :
        '😔 Belum Lulus';
    document.getElementById('nilaiDetail').textContent = `${benar} benar dari ${TOTAL_SOAL} soal`;
    resultBox.className = 'quiz-result-box ' + (lulus ? 'lulus' : 'tidak-lulus');
    resultBox.style.display = 'block';

    // Tampilkan tombol coba lagi jika tidak lulus
    if (!lulus) {
        document.getElementById('btnUlangi').style.display = 'inline-flex';
    }

    resultBox.scrollIntoView({
        behavior: 'smooth',
        block: 'center'
    });

    // Kirim ke server (simpan hasil)
    try {
        const formData = new FormData();
        formData.append(CSRF_NAME, CSRF_TOKEN);
        formData.append('id_materi', '<?= $currentMateri['id_materi'] ?? 0 ?>');
        formData.append('nilai', nilai);
        formData.append('jumlah_benar', benar);
        formData.append('jumlah_salah', TOTAL_SOAL - benar);

        const res = await fetch(SAVE_URL, {
            method: 'POST',
            body: formData
        });
        const json = await res.json();

        if (!json.success) {
            console.warn('Gagal menyimpan hasil quiz:', json.message);
        }
    } catch (err) {
        console.warn('Error simpan quiz:', err);
    } finally {
        spinner.style.display = 'none';
        icon.style.display = 'inline-block';
    }
}

/* ── Ulangi quiz ── */
function ulangiQuiz() {
    quizSelesai = false;

    // Reset jawaban
    Object.keys(jawabanUser).forEach(k => delete jawabanUser[k]);

    // Reset UI pilihan
    document.querySelectorAll('.pilihan-item').forEach(el => {
        el.classList.remove('selected', 'correct', 'wrong', 'not-selected-lock');
        el.style.pointerEvents = '';
    });

    // Reset progress & tombol
    document.getElementById('quizProgressText').textContent = `0 / ${TOTAL_SOAL} soal terjawab`;
    const btn = document.getElementById('btnKumpulkan');
    btn.disabled = false;
    document.getElementById('quizSpinner').style.display = 'none';
    document.getElementById('quizSendIcon').style.display = 'inline-block';

    // Sembunyikan hasil
    const resultBox = document.getElementById('quizResult');
    resultBox.style.display = 'none';
    resultBox.className = 'quiz-result-box';
    document.getElementById('btnUlangi').style.display = 'none';

    // Scroll ke atas quiz
    document.getElementById('quizSection').scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}
</script>

<script src="https://www.youtube.com/iframe_api"></script>
<script>
/* ===============================
   YOUTUBE PLAYER
================================ */

let player;

function onYouTubeIframeAPIReady() {
    <?php if ($hasVideo && $embedId): ?>
    player = new YT.Player('player', {
        height: '390',
        width: '640',
        videoId: '<?= $embedId ?>',
        events: {
            'onStateChange': onPlayerStateChange
        }
    });
    <?php endif; ?>
}

function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.ENDED) {
        kirimProgressMateri();
    }
}

// ===============================

window.materiTerkirim = window.materiTerkirim ?? false;
window.pdfSelesai = window.pdfSelesai ?? false;

function openPDFModal() {
    // Cek apakah sudah pretest
    <?php if (!$has_pretest): ?>
    alert('Anda harus menyelesaikan Pre Test terlebih dahulu untuk membuka materi PDF.');
    return;
    <?php endif; ?>

    const modal = document.getElementById('pdfModal');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';

        // Setup scroll detection untuk container
        if (!MATERI_SELESAI) {
            setupPDFScrollDetection();
        } else {
            hidePDFProgressUI();
        }
    }
}

function setupPDFScrollDetection() {
    const viewer = document.getElementById('pdfViewer');
    if (!viewer) return;

    highestPageSeen = 0;

    function onScroll() {
        detectPageProgress();
    }

    viewer.addEventListener('scroll', onScroll);

    // simpan cleanup supaya bisa dilepas saat modal ditutup
    window.pdfScrollCleanup = () => {
        viewer.removeEventListener('scroll', onScroll);
    };
}

function closePDFModal() {
    const modal = document.getElementById('pdfModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';

        if (window.pdfScrollCleanup) {
            window.pdfScrollCleanup();
            window.pdfScrollCleanup = null;
        }
    }
}

function hidePDFProgressUI() {
    const progressWrap = document.querySelector('.pdf-modal-progress');
    const statusText = document.getElementById('pdfStatusText');

    if (progressWrap) progressWrap.style.display = 'none';
    if (statusText) {
        statusText.textContent = 'Materi telah selesai. Anda dapat membaca kembali.';
    }
}




let pdfDoc = null;
let totalPages = 0;
let highestPageSeen = 0;
let renderedPages = new Set();

if (pdfUrl) {
    pdfjsLib.getDocument(pdfUrl).promise.then(pdf => {
        pdfDoc = pdf;
        totalPages = pdf.numPages;
        renderAllPages();
    }).catch(err => {
        console.error('Gagal memuat PDF:', err);
    });
}

function renderAllPages() {
    const viewer = document.getElementById('pdfViewer');
    viewer.innerHTML = '';

    for (let pageNum = 1; pageNum <= totalPages; pageNum++) {
        renderPage(pageNum, viewer);
    }
    viewer.addEventListener('scroll', detectPageProgress);
}

function renderPage(pageNum, container) {
    pdfDoc.getPage(pageNum).then(page => {
        const viewport = page.getViewport({
            scale: 1.2
        });
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        canvas.height = viewport.height;
        canvas.width = viewport.width;
        canvas.dataset.page = pageNum;
        canvas.style.display = 'block';
        canvas.style.margin = '0 auto 20px';

        container.appendChild(canvas);

        page.render({
            canvasContext: ctx,
            viewport
        });
    });
}

function detectPageProgress() {
    if (MATERI_SELESAI) return;

    const viewer = document.getElementById('pdfViewer');
    const canvases = viewer.querySelectorAll('canvas');

    canvases.forEach(canvas => {
        const rect = canvas.getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.8) {
            const page = parseInt(canvas.dataset.page);
            if (page > highestPageSeen) {
                highestPageSeen = page;
                updateProgress();
            }
        }
    });

    if (highestPageSeen === totalPages) {
        selesaiBacaPDF();
    }
}

function updateProgress() {
    const percent = Math.round((highestPageSeen / totalPages) * 100);
    updateProgressBar(percent);

    document.getElementById('pdfStatusText').textContent =
        `Halaman ${highestPageSeen} dari ${totalPages}`;
}

function kirimProgressMateri() {
    if (window.materiTerkirim) {
        //console.log('[DEBUG] Material sudah dikirim sebelumnya, skip');
        return;
    }

    window.materiTerkirim = true;
    //console.log('[DEBUG] ========== MENGIRIM PROGRESS ==========');

    const idMateri = <?= (int)($materi_aktif['id_materi'] ?? 0) ?>;
    const csrfName = '<?= csrf_token() ?>';
    const csrfHash = '<?= csrf_hash() ?>';
    const baseUrl = '<?= base_url() ?>';

    // console.log('[DEBUG] ID Materi:', idMateri);
    // console.log('[DEBUG] CSRF Name:', csrfName);
    // console.log('[DEBUG] CSRF Hash:', csrfHash);
    // console.log('[DEBUG] Base URL:', baseUrl);
    // console.log('[DEBUG] Full Fetch URL:', baseUrl + 'dashboard/peserta/materi/selesai');

    const fd = new FormData();
    fd.append(csrfName, csrfHash);
    fd.append('id_materi', idMateri);

    fetch(baseUrl + 'dashboard/peserta/materi/selesai', {
            method: 'POST',
            body: fd,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => {
            //console.log('[DEBUG] Response status:', res.status);
            return res.json();
        })
        .then(res => {
            // console.log('[DEBUG] Response JSON:', res);
            if (res.success) {
                // console.log('[SUCCESS] Progress berhasil disimpan!');

                // Tampilkan notifikasi visual
                showSuccessNotification();


                // 🔁 tunggu 1 detik lalu reload halaman
                setTimeout(() => {
                    location.reload();
                }, 1000);



                // console.log('[DEBUG] Posttest unlocked. User dapat melanjutkan membaca materi.');

            } else {
                // console.error('[ERROR] Server returned success=false');
                // console.error('[ERROR] Error message:', res.error);
                // console.error('[ERROR] Full response:', res);
                window.materiTerkirim = false;

                // Tampilkan error notification
                showErrorNotification(res.error || 'Gagal menyimpan progress');
            }
        })
        .catch(err => {
            // console.error('[ERROR] Fetch error:', err);
            window.materiTerkirim = false;
        });
}

function showSuccessNotification() {
    const notification = document.createElement('div');
    notification.innerHTML = `
        <div style="
            position: fixed;
            top: 20px;
            right: 20px;
            background: #10b981;
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 10000;
            animation: slideIn 0.3s ease-out;
        ">
            <strong>✓ Sukses!</strong> Materi sudah ditandai selesai. Posttest sekarang tersedia.
        </div>
        `;
    document.body.appendChild(notification);

    setTimeout(() => notification.remove(), 3000);
}

function showErrorNotification(message) {
    const notification = document.createElement('div');
    notification.innerHTML = `
        <div style="
            position: fixed;
            top: 20px;
            right: 20px;
            background: #ef4444;
            color: white;
            padding: 16px 24px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 10000;
            animation: slideIn 0.3s ease-out;
        ">
            <strong>✗ Error!</strong> ${message}
        </div>
        `;
    document.body.appendChild(notification);

    setTimeout(() => notification.remove(), 5000);
}

function updateProgressBar(percent) {
    const progressFill = document.getElementById('pdfProgressFill');
    const progressText = document.getElementById('pdfProgressText');

    if (progressFill) {
        progressFill.style.width = percent + '%';
    }
    if (progressText) {
        progressText.textContent = Math.round(percent) + '%';
    }
}

function unlockPosttest() {
    // console.log('[DEBUG] Menjalankan unlockPosttest()');
    const lockedCard = document.getElementById('posttestLocked');
    const unlockedCard = document.getElementById('posttestUnlocked');

    //console.log('[DEBUG] lockedCard:', lockedCard);
    //console.log('[DEBUG] unlockedCard:', unlockedCard);

    if (lockedCard) {
        //console.log('[DEBUG] Menyembunyikan locked card...');
        lockedCard.style.opacity = '0';
        lockedCard.style.pointerEvents = 'none';
        lockedCard.style.height = '0';
        lockedCard.style.overflow = 'hidden';
    }

    if (unlockedCard) {
        //console.log('[DEBUG] Menampilkan unlocked card...');
        unlockedCard.style.display = 'block';
        unlockedCard.style.opacity = '1';
        unlockedCard.style.height = 'auto';
        unlockedCard.style.animation = 'slideIn 0.3s ease-out';
    }
}

function selesaiBacaPDF() {
    if (window.pdfSelesai) return;
    window.pdfSelesai = true;
    kirimProgressMateri();
}
</script>
<?= $this->endSection() ?>
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

$quizSoal = [];
if (!empty($currentMateri['quiz_data'])) {
    $decoded = json_decode($currentMateri['quiz_data'], true);
    if (is_array($decoded)) $quizSoal = $decoded;
}

$hasVideo = !empty($currentMateri['video_url_materi']);
$hasFile  = !empty($currentMateri['file_materi']);
$hasIsi   = !empty($currentMateri['isi_materi']);
$hasQuiz  = !empty($quizSoal);

// Deteksi tipe video: lokal (vid_xxx) atau YouTube
$isLocalVideo = $hasVideo && str_starts_with($currentMateri['video_url_materi'], 'vid_');
$isYouTube    = $hasVideo && !$isLocalVideo;

$embedId = null;
if ($isYouTube) {
    preg_match(
        '/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_-]{11})/',
        $currentMateri['video_url_materi'],
        $matches
    );
    $embedId = $matches[1] ?? null;
}

// Helper: file type map (dipakai berulang)
$fileTypeMap = [
    'pdf'  => ['bi-file-earmark-pdf-fill',   'PDF',   'pdf'],
    'doc'  => ['bi-file-earmark-word-fill',  'Word',  'word'],
    'docx' => ['bi-file-earmark-word-fill',  'Word',  'word'],
    'xls'  => ['bi-file-earmark-excel-fill', 'Excel', 'excel'],
    'xlsx' => ['bi-file-earmark-excel-fill', 'Excel', 'excel'],
    'ppt'  => ['bi-file-earmark-ppt-fill',   'PPT',   'ppt'],
    'pptx' => ['bi-file-earmark-ppt-fill',   'PPT',   'ppt'],
];

$currentExt   = $hasFile ? strtolower(pathinfo($currentMateri['file_materi'], PATHINFO_EXTENSION)) : '';
$currentFileInfo = $fileTypeMap[$currentExt] ?? ['bi-file-earmark-fill', strtoupper($currentExt), 'file'];
[$currentFileIcon, $currentFileLabel, $currentFileCls] = $currentFileInfo;
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
                $isLoc = $hasV && str_starts_with($m['video_url_materi'], 'vid_');

                if ($hasV && $hasF) {
                    $tipeIcon  = '<i class="bi bi-collection-play-fill"></i>';
                    $tipeLabel = 'Video & Dokumen';
                } elseif ($hasV) {
                    $tipeIcon  = $isLoc
                        ? '<i class="bi bi-shield-lock-fill"></i>'
                        : '<i class="bi bi-play-circle-fill"></i>';
                    $tipeLabel = $isLoc ? 'Video Lokal' : 'Video';
                } elseif ($hasF) {
                    $sExt = strtolower(pathinfo($m['file_materi'], PATHINFO_EXTENSION));
                    [$sFi, $sFl] = $fileTypeMap[$sExt] ?? ['bi-file-earmark-fill', strtoupper($sExt)];
                    $tipeIcon  = '<i class="bi ' . $sFi . '"></i>';
                    $tipeLabel = $sFl;
                } else {
                    $tipeIcon  = '<i class="bi bi-file-text-fill"></i>';
                    $tipeLabel = 'Artikel';
                }
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
                    <?php if ($hasVideo): ?>
                    <span class="tipe-badge video">
                        <i class="bi bi-<?= $isLocalVideo ? 'shield-lock-fill' : 'play-circle-fill' ?>"></i>
                        <?= $isLocalVideo ? 'Video Lokal' : 'Video' ?>
                    </span>
                    <?php endif; ?>

                    <?php if ($hasFile): ?>
                    <span class="tipe-badge <?= $currentFileCls ?>">
                        <i class="bi <?= $currentFileIcon ?>"></i> <?= $currentFileLabel ?>
                    </span>
                    <?php endif; ?>

                    <?php if ($hasIsi): ?>
                    <span class="tipe-badge artikel">
                        <i class="bi bi-file-text-fill"></i> Artikel
                    </span>
                    <?php endif; ?>

                    <?php if ($hasQuiz): ?>
                    <span class="tipe-badge quiz">
                        <i class="bi bi-patch-question-fill"></i> Quiz
                    </span>
                    <?php endif; ?>
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
                <div class="pretest-card" style="background:#ecfdf5; border-color:#86efac;">
                    <div class="pretest-icon" style="background:#10b981;"><i class="bi bi-check2-circle"></i></div>
                    <div class="pretest-info">
                        <h4>Hasil Pre Test</h4>
                        <p>Kamu sudah mengerjakan pre test</p>
                        <strong style="font-size:18px; color:#065f46;">Nilai: <?= esc($nilai_pre['nilai']) ?></strong>
                    </div>
                </div>
                <?php else: ?>
                <div class="pretest-card">
                    <div class="pretest-icon"><i class="bi bi-clipboard-data"></i></div>
                    <div class="pretest-info">
                        <h4>Pre Test Modul</h4>
                        <p>Kerjakan pre test untuk mengetahui pemahaman awal kamu sebelum memulai materi.</p>
                    </div>
                    <a href="<?= base_url('dashboard/peserta/pretest/' . $currentMateri['id_materi']) .
                                '?redirect=' . urlencode(
                                    base_url('dashboard/peserta/materi-modul/' . $modul['id_modul']) .
                                    '?materi=' . $currentMateri['id_materi']
                                ) ?>" class="btn-pretest">
                        <i class="bi bi-play-fill"></i> Mulai Pre Test
                    </a>
                </div>
                <?php endif; ?>
            </div>

            <!-- 1. VIDEO -->
            <?php if ($hasVideo): ?>
            <div class="content-section">

                <?php if (!$has_pretest): ?>
                <!-- VIDEO TERKUNCI -->
                <div class="video-container locked">
                    <div class="locked-overlay">
                        <i class="bi bi-lock-fill"></i>
                        <p>Selesaikan Pre Test untuk membuka video</p>
                    </div>
                </div>

                <?php elseif ($isLocalVideo): ?>
                <!-- ▶️ VIDEO LOKAL -->
                <div class="video-container mb-4" style="border-radius:12px;overflow:hidden;">
                    <video id="localVideo" controls preload="metadata"
                        style="width:100%;max-width:100%;background:#000;"
                        controlsList="nodownload noplaybackrate"
                        disablePictureInPicture>
                        <source src="<?= base_url('video/stream/' . esc($currentMateri['video_url_materi'])) ?>"
                            type="video/mp4">
                        Browser Anda tidak mendukung pemutar video.
                    </video>
                </div>

                <?php elseif ($isYouTube && $embedId): ?>
                <!-- ▶️ VIDEO YOUTUBE -->
                <div class="video-container"
                    style="position:relative;width:100%;aspect-ratio:16/9;border-radius:12px;overflow:hidden;background:#000;margin-bottom:16px;">
                    <div id="player"></div>
                </div>

                <?php else: ?>
                <!-- ▶️ VIDEO HTML5 BIASA -->
                <div class="video-container mb-4" style="border-radius:12px;overflow:hidden;">
                    <video id="html5Video" controls preload="metadata" style="width:100%;max-width:100%;">
                        <source src="<?= esc($currentMateri['video_url_materi']) ?>" type="video/mp4">
                        Browser Anda tidak mendukung pemutar video.
                    </video>
                </div>
                <?php endif; ?>

            </div>
            <?php endif; ?>

            <!-- 2. FILE DOKUMEN -->
            <?php if ($hasFile): ?>
            <div class="content-section">

                <?php if (!$has_pretest): ?>
                <!-- DOKUMEN TERKUNCI -->
                <div class="file-preview locked">
                    <div class="file-icon locked">
                        <i class="bi <?= $currentFileIcon ?>"></i>
                        <div class="lock-overlay"><i class="bi bi-lock-fill"></i></div>
                    </div>
                    <div class="file-info">
                        <h4><?= esc($currentMateri['judul_materi']) ?></h4>
                        <p>Materi <?= $currentFileLabel ?> terkunci. Selesaikan Pre Test terlebih dahulu untuk membuka materi.</p>
                    </div>
                    <span class="btn-view-pdf disabled">Terkunci</span>
                </div>

                <?php else: ?>
                <!-- DOKUMEN TERBUKA -->
                <div class="file-preview">
                    <div class="file-icon">
                        <i class="bi <?= $currentFileIcon ?>"></i>
                    </div>
                    <div class="file-info">
                        <h4><?= esc($currentMateri['judul_materi']) ?></h4>
                        <p>Klik tombol di bawah untuk membaca materi <?= $currentFileLabel ?>.</p>
                    </div>
                    <div style="display:flex;gap:8px;flex-shrink:0;">
                        <?php if ($currentExt === 'pdf'): ?>
                        <button class="btn-view-pdf" onclick="openPDFModal()">
                            <i class="bi bi-book"></i> Baca Materi
                        </button>
                        <?php else: ?>
<button class="btn-view-pdf"
    onclick="openDocViewer('<?= base_url($currentMateri['file_materi']) ?>')"
    style="display:inline-flex;align-items:center;gap:6px;">
    <i class="bi bi-box-arrow-up-right"></i> Buka <?= $currentFileLabel ?>
</button>
<?php endif; ?>

<!-- Modal Doc Viewer (SheetJS untuk Excel, Google Viewer untuk lainnya) -->
<div id="docViewerModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.6);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:16px;width:90%;max-width:1100px;height:88vh;overflow:hidden;display:flex;flex-direction:column;">
        <div style="display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid #e5e7eb;">
            <span style="font-weight:700;font-size:14px;"><?= esc($currentMateri['judul_materi']) ?></span>
            <button onclick="closeDocViewer()" style="background:#fee2e2;color:#ef4444;border:none;border-radius:8px;width:32px;height:32px;cursor:pointer;font-size:16px;">✕</button>
        </div>
        <!-- Konten dinamis: iframe atau tabel Excel -->
        <div id="docViewerBody" style="flex:1;overflow:auto;width:100%;"></div>
        <div id="docViewerLoading" style="display:none;position:absolute;inset:0;background:rgba(255,255,255,.8);align-items:center;justify-content:center;font-size:14px;color:#6b7280;">
            ⏳ Memuat dokumen...
        </div>
    </div>
</div>

                        <a href="<?= base_url($currentMateri['file_materi']) ?>"
                           download="<?= esc(preg_replace('/[^a-zA-Z0-9_\-]/', '_', $currentMateri['judul_materi'])) . '.' . $currentExt ?>"
                           class="btn-view-pdf"
                           style="background:#16a34a;text-decoration:none;display:inline-flex;align-items:center;gap:6px;">
                            <i class="bi bi-download"></i> Download
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <!-- MODAL PDF FULLSCREEN (hanya untuk PDF) -->
                <?php if ($currentExt === 'pdf'): ?>
                <div id="pdfModal" class="pdf-modal" style="display:none;">
                    <div class="pdf-modal-content">
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
                        <div id="pdfContainer" class="pdf-container">
                            <div id="pdfViewer" style="overflow-y:auto;height:100%;padding:20px;">
                                <p>Browser Anda tidak mendukung PDF.
                                    <a href="<?= base_url($currentMateri['file_materi']) ?>" target="_blank">Download PDF</a>
                                </p>
                            </div>
                        </div>
                        <div class="pdf-modal-footer">
                            <p id="pdfStatusText" class="pdf-status">Scroll untuk membaca...</p>
                            <button class="btn-secondary" onclick="closePDFModal()">Tutup</button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

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
                    $cardBg      = $posttestPassed ? '#ecfdf5' : '#fee2e2';
                    $borderColor = $posttestPassed ? '#86efac' : '#fca5a5';
                    $textColor   = $posttestPassed ? '#065f46' : '#991b1b';
                    $statusLabel = $posttestPassed ? 'Lulus Post Test' : 'Belum Lulus Post Test';
                ?>
                <div class="posttest-card"
                    style="background:<?= $cardBg ?>;border-color:<?= $borderColor ?>;display:flex;align-items:center;justify-content:space-between;">
                    <div class="posttest-info" style="max-width:calc(100% - 180px);">
                        <h4><?= $statusLabel ?></h4>
                        <p>Nilai terakhir post test kamu.</p>
                        <strong style="font-size:18px;color:<?= $textColor ?>;">Nilai: <?= esc($nilai_post['nilai']) ?></strong>
                    </div>
                    <?php if (!$posttestPassed): ?>
                    <a href="<?= base_url('dashboard/peserta/posttest/' . $currentMateri['id_materi'] . '?redirect=' . urlencode(current_url())) ?>"
                        class="btn-posttest" style="margin-left:20px;background:#dc2626;border-color:#dc2626;">
                        Mulai ulang Post Test
                    </a>
                    <?php else: ?>
                    <span style="display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border-radius:10px;background:#d1fae5;color:#065f46;font-weight:700;">
                        <i class="bi bi-check-circle-fill"></i> Lulus
                    </span>
                    <?php endif; ?>
                </div>

                <?php else: ?>

                <?php if (!$has_pretest): ?>
                <div class="posttest-card" style="opacity:.6;">
                    <div class="posttest-icon"><i class="bi bi-lock-fill"></i></div>
                    <div class="posttest-info">
                        <h4>Post Test Terkunci</h4>
                        <p>Selesaikan Pre Test terlebih dahulu</p>
                    </div>
                    <span class="btn-posttest disabled">Terkunci</span>
                </div>

                <?php elseif (!$materi_selesai): ?>
                <div class="posttest-card" style="opacity:.6;" id="posttestLocked">
                    <div class="posttest-icon"><i class="bi bi-lock-fill"></i></div>
                    <div class="posttest-info">
                        <h4>Post Test Terkunci</h4>
                        <p id="lockStatusMessage">
                            <?php if ($hasVideo && $hasFile): ?>
                            Video dan file materi harus diselesaikan terlebih dahulu
                            <?php elseif ($isLocalVideo): ?>
                            Klik tombol "Saya sudah menonton video ini" setelah selesai menonton
                            <?php elseif ($hasVideo): ?>
                            Tonton video materi sampai selesai
                            <?php elseif ($hasFile): ?>
                            Baca materi sampai selesai
                            <?php else: ?>
                            Selesaikan materi terlebih dahulu
                            <?php endif; ?>
                        </p>
                    </div>
                    <span class="btn-posttest disabled">Terkunci</span>
                </div>
                <div class="posttest-card" id="posttestUnlocked"
                    style="display:none;opacity:0;pointer-events:none;transition:opacity .25s ease;">
                    <div class="posttest-icon"><i class="bi bi-patch-question-fill"></i></div>
                    <div class="posttest-info">
                        <h4>Post Test Modul</h4>
                        <p>Kerjakan test setelah menyelesaikan semua materi.</p>
                    </div>
                    <a href="<?= base_url('dashboard/peserta/posttest/' . $currentMateri['id_materi'] .
                            '?redirect=' . urlencode(current_url())) ?>" class="btn-posttest">
                        Mulai Post Test
                    </a>
                </div>

                <?php else: ?>
                <div class="posttest-card" id="posttestUnlocked">
                    <div class="posttest-icon"><i class="bi bi-patch-question-fill"></i></div>
                    <div class="posttest-info">
                        <h4>Post Test Modul</h4>
                        <p>Kerjakan test setelah menyelesaikan semua materi.</p>
                    </div>
                    <a href="<?= base_url('dashboard/peserta/posttest/' . $currentMateri['id_materi'] .
                            '?redirect=' . urlencode(current_url())) ?>" class="btn-posttest">
                        Mulai Post Test
                    </a>
                </div>
                <?php endif; ?>

                <?php endif; ?>
            </div>

            <!-- NAVIGASI -->
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
                <span class="nav-btn next disabled" title="Selesaikan materi ini dengan posttest >=70">
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
const pdfUrl = <?= ($hasFile && $currentExt === 'pdf' && !empty($currentMateri['file_materi']))
    ? '"' . base_url($currentMateri['file_materi']) . '"'
    : 'null' ?>;
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script>
pdfjsLib.GlobalWorkerOptions.workerSrc =
    'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
</script>

<script>
/* ── CONFIG ── */
const MATERI_SELESAI     = <?= $materi_selesai ? 'true' : 'false' ?>;
const MATERI_PUNYA_VIDEO = <?= $hasVideo ? 'true' : 'false' ?>;
const MATERI_PUNYA_FILE  = <?= $hasFile  ? 'true' : 'false' ?>;
const IS_LOCAL_VIDEO     = <?= $isLocalVideo ? 'true' : 'false' ?>;
const FILE_EXT           = '<?= $currentExt ?>';
const SOAL_DATA          = <?= json_encode($quizSoal, JSON_UNESCAPED_UNICODE) ?>;
const TOTAL_SOAL         = SOAL_DATA.length;
const CSRF_TOKEN         = '<?= csrf_hash() ?>';
const CSRF_NAME          = '<?= csrf_token() ?>';
const SAVE_URL           = '<?= base_url('dashboard/peserta/quiz/simpan-materi') ?>';
const BASE_URL_JS        = '<?= base_url() ?>';

/* ── STATE ── */
window.videoSelesai     = false;
window.pdfSelesai       = false;
window.progressTerkirim = false;

/* ════════════════════════════════════════════════════════
   NAVIGASI
════════════════════════════════════════════════════════ */
function loadMateri(idMateri) {
    window.location.href =
        '<?= base_url('dashboard/peserta/materi-modul') ?>/<?= $modul['id_modul'] ?>?materi=' + idMateri;
}

/* ══════════════════════════════════════
   INIT: VIDEO & NON-PDF FILE SELESAI
══════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
    // Video lokal
    const video = document.getElementById('localVideo');
    if (video) {
        video.addEventListener('ended', () => {
            window.videoSelesai = true;
            kirimProgressMateri();
        });
    }

    // Untuk file non-PDF (Word/Excel/PPT): langsung tandai selesai saat dibuka
    if (MATERI_PUNYA_FILE && FILE_EXT !== 'pdf') {
        window.pdfSelesai = true;
    }
});

/* ════════════════════════════════════════════════════════
   YOUTUBE PLAYER API
════════════════════════════════════════════════════════ */
<?php if ($isYouTube && $embedId): ?>
let player;

function onYouTubeIframeAPIReady() {
    player = new YT.Player('player', {
        height: '390',
        width: '640',
        videoId: '<?= $embedId ?>',
        events: { 'onStateChange': onPlayerStateChange }
    });
}

function onPlayerStateChange(event) {
    if (event.data == YT.PlayerState.ENDED) {
        window.videoSelesai = true;
        kirimProgressMateri();
    }
}
<?php else: ?>
function onYouTubeIframeAPIReady() {}
<?php endif; ?>

/* ════════════════════════════════════════════════════════
   CEK SEMUA KONTEN SELESAI
════════════════════════════════════════════════════════ */
function checkAllMateriCompleted() {
    if (MATERI_PUNYA_VIDEO && !window.videoSelesai) return false;
    if (MATERI_PUNYA_FILE  && !window.pdfSelesai)   return false;
    return true;
}

/* ════════════════════════════════════════════════════════
   KIRIM PROGRESS KE SERVER
════════════════════════════════════════════════════════ */
function kirimProgressMateri() {
    if (!checkAllMateriCompleted()) return;
    if (window.progressTerkirim) return;
    window.progressTerkirim = true;

    const idMateri = <?= (int)($materi_aktif['id_materi'] ?? 0) ?>;
    const fd = new FormData();
    fd.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');
    fd.append('id_materi', idMateri);

    fetch(BASE_URL_JS + 'dashboard/peserta/materi/selesai', {
        method: 'POST',
        body: fd,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            showSuccessNotification();
            unlockPosttest();
            setTimeout(() => location.reload(), 1500);
        } else {
            window.progressTerkirim = false;
            showErrorNotification(res.error || 'Gagal menyimpan progress');
        }
    })
    .catch(() => { window.progressTerkirim = false; });
}

/* ════════════════════════════════════════════════════════
   UI HELPERS
════════════════════════════════════════════════════════ */
function showSuccessNotification() {
    const n = document.createElement('div');
    n.innerHTML = `<div style="position:fixed;top:20px;right:20px;background:#10b981;color:#fff;
        padding:16px 24px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.2);
        z-index:10000;font-family:system-ui,sans-serif;">
        <strong>✓ Sukses!</strong> Materi selesai. Posttest sekarang tersedia.
    </div>`;
    document.body.appendChild(n);
    setTimeout(() => n.remove(), 3000);
}

function showErrorNotification(msg) {
    const n = document.createElement('div');
    n.innerHTML = `<div style="position:fixed;top:20px;right:20px;background:#ef4444;color:#fff;
        padding:16px 24px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,.2);
        z-index:10000;font-family:system-ui,sans-serif;">
        <strong>✗ Error!</strong> ${msg}
    </div>`;
    document.body.appendChild(n);
    setTimeout(() => n.remove(), 5000);
}

function unlockPosttest() {
    const locked   = document.getElementById('posttestLocked');
    const unlocked = document.getElementById('posttestUnlocked');
    if (locked) {
        locked.style.opacity      = '0';
        locked.style.pointerEvents = 'none';
        locked.style.height        = '0';
        locked.style.overflow      = 'hidden';
    }
    if (unlocked) {
        unlocked.style.display      = 'block';
        unlocked.style.opacity      = '1';
        unlocked.style.height       = 'auto';
        unlocked.style.pointerEvents = 'auto';
    }
}

function updateProgressBar(percent) {
    const fill = document.getElementById('pdfProgressFill');
    const txt  = document.getElementById('pdfProgressText');
    if (fill) fill.style.width   = percent + '%';
    if (txt)  txt.textContent    = Math.round(percent) + '%';
}

/* ════════════════════════════════════════════════════════
   PDF MODAL & PROGRESS (hanya aktif untuk file PDF)
════════════════════════════════════════════════════════ */
function openPDFModal() {
    <?php if (!$has_pretest): ?>
    alert('Anda harus menyelesaikan Pre Test terlebih dahulu untuk membuka materi.');
    return;
    <?php endif; ?>
    const modal = document.getElementById('pdfModal');
    if (modal) {
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
        if (!MATERI_SELESAI) {
            setupPDFScrollDetection();
        } else {
            hidePDFProgressUI();
        }
    }
}

function setupPDFScrollDetection() {
    highestPageSeen = 0;
    const viewer = document.getElementById('pdfViewer');
    if (!viewer) return;
    const onScroll = () => detectPageProgress();
    viewer.addEventListener('scroll', onScroll);
    window.pdfScrollCleanup = () => viewer.removeEventListener('scroll', onScroll);
}

function closePDFModal() {
    const modal = document.getElementById('pdfModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
    if (window.pdfScrollCleanup) {
        window.pdfScrollCleanup();
        window.pdfScrollCleanup = null;
    }
}

function hidePDFProgressUI() {
    const pw = document.querySelector('.pdf-modal-progress');
    const st = document.getElementById('pdfStatusText');
    if (pw) pw.style.display = 'none';
    if (st) st.textContent = 'Materi telah selesai. Anda dapat membaca kembali.';
}

/* ── PDF.js render ── */
let pdfDoc = null, totalPages = 0, highestPageSeen = 0;

if (pdfUrl) {
    pdfjsLib.getDocument(pdfUrl).promise
        .then(pdf => {
            pdfDoc      = pdf;
            totalPages  = pdf.numPages;
            renderAllPages();
        })
        .catch(err => console.error('Gagal memuat PDF:', err));
}

function renderAllPages() {
    const viewer = document.getElementById('pdfViewer');
    viewer.innerHTML = '';
    for (let p = 1; p <= totalPages; p++) renderPage(p, viewer);
    viewer.addEventListener('scroll', detectPageProgress);
}

function renderPage(pageNum, container) {
    pdfDoc.getPage(pageNum).then(page => {
        const vp     = page.getViewport({ scale: 1.2 });
        const canvas = document.createElement('canvas');
        const ctx    = canvas.getContext('2d');
        canvas.height       = vp.height;
        canvas.width        = vp.width;
        canvas.dataset.page = pageNum;
        canvas.style.cssText = 'display:block;margin:0 auto 20px;';
        container.appendChild(canvas);
        page.render({ canvasContext: ctx, viewport: vp });
    });
}

function detectPageProgress() {
    if (MATERI_SELESAI) return;
    const viewer  = document.getElementById('pdfViewer');
    const canvases = viewer.querySelectorAll('canvas');
    canvases.forEach(canvas => {
        const rect = canvas.getBoundingClientRect();
        if (rect.top < window.innerHeight * 0.8) {
            const page = parseInt(canvas.dataset.page);
            if (page > highestPageSeen) {
                highestPageSeen = page;
                updatePDFProgress();
            }
        }
    });
    if (highestPageSeen === totalPages) selesaiBacaPDF();
}

function updatePDFProgress() {
    const percent = Math.round((highestPageSeen / totalPages) * 100);
    updateProgressBar(percent);
    const st = document.getElementById('pdfStatusText');
    if (st) st.textContent = `Halaman ${highestPageSeen} dari ${totalPages}`;
}

function selesaiBacaPDF() {
    if (window.pdfSelesai) return;
    window.pdfSelesai = true;
    kirimProgressMateri();
}
function openDocViewer(fileUrl) {
    const ext = fileUrl.split('.').pop().toLowerCase();
    const body = document.getElementById('docViewerBody');
    const modal = document.getElementById('docViewerModal');
    const loading = document.getElementById('docViewerLoading');

    body.innerHTML = '';
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    if (ext === 'xls' || ext === 'xlsx') {
        // Render Excel pakai SheetJS
        loading.style.display = 'flex';
        fetch(fileUrl)
            .then(r => r.arrayBuffer())
            .then(data => {
                const wb = XLSX.read(data, { type: 'array' });
                let html = '<div style="padding:16px;">';

                // Tab sheet selector jika lebih dari 1 sheet
                if (wb.SheetNames.length > 1) {
                    html += '<div style="display:flex;gap:8px;margin-bottom:12px;flex-wrap:wrap;">';
                    wb.SheetNames.forEach((name, i) => {
                        html += `<button onclick="switchSheet(${i})"
                            id="tab-${i}"
                            style="padding:6px 14px;border-radius:8px;border:1px solid #e5e7eb;
                            background:${i===0?'#2563eb':'#f9fafb'};
                            color:${i===0?'#fff':'#374151'};cursor:pointer;font-size:13px;">
                            ${name}
                        </button>`;
                    });
                    html += '</div>';
                }
                html += '</div>';

                body.innerHTML = html;

                // Simpan workbook untuk switching sheet
                window._xlsxWb = wb;
                renderSheet(0);
                loading.style.display = 'none';
            })
            .catch(() => {
                loading.style.display = 'none';
                body.innerHTML = '<p style="padding:24px;color:#ef4444;">Gagal memuat file Excel.</p>';
            });

    } else {
        // Word/PPT: fallback download saja karena localhost tidak bisa pakai Google Viewer
        body.innerHTML = `
            <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;height:100%;gap:16px;color:#6b7280;">
                <i class="bi bi-file-earmark-fill" style="font-size:64px;color:#d1d5db;"></i>
                <p style="font-size:15px;font-weight:600;color:#374151;">Pratinjau tidak tersedia untuk tipe file ini</p>
                <small>Silakan download file untuk membukanya.</small>
                <a href="${fileUrl}" download style="padding:10px 20px;background:#2563eb;color:#fff;border-radius:10px;text-decoration:none;font-size:14px;">
                    ⬇ Download File
                </a>
            </div>`;
    }
}

function renderSheet(index) {
    const wb = window._xlsxWb;
    if (!wb) return;
    const ws = wb.Sheets[wb.SheetNames[index]];
    const htmlTable = XLSX.utils.sheet_to_html(ws, { editable: false });

    // Update tab aktif
    wb.SheetNames.forEach((_, i) => {
        const tab = document.getElementById('tab-' + i);
        if (tab) {
            tab.style.background = i === index ? '#2563eb' : '#f9fafb';
            tab.style.color      = i === index ? '#fff'    : '#374151';
        }
    });

    // Inject tabel
    let tableContainer = document.getElementById('xlsxTableContainer');
    if (!tableContainer) {
        tableContainer = document.createElement('div');
        tableContainer.id = 'xlsxTableContainer';
        tableContainer.style.cssText = 'padding:0 16px 16px;overflow:auto;';
        document.getElementById('docViewerBody').appendChild(tableContainer);
    }

    tableContainer.innerHTML = `
        <style>
            #xlsxTableContainer table { border-collapse:collapse; font-size:13px; min-width:100%; }
            #xlsxTableContainer td, #xlsxTableContainer th {
                border:1px solid #e5e7eb; padding:6px 10px; white-space:nowrap;
            }
            #xlsxTableContainer tr:nth-child(even) { background:#f9fafb; }
            #xlsxTableContainer tr:first-child td, #xlsxTableContainer tr:first-child th {
                background:#dbeafe; font-weight:600;
            }
        </style>
        ${htmlTable}`;
}

function switchSheet(index) {
    renderSheet(index);
}

function closeDocViewer() {
    document.getElementById('docViewerModal').style.display = 'none';
    document.getElementById('docViewerBody').innerHTML = '';
    document.body.style.overflow = 'auto';
    window._xlsxWb = null;
}

/* ── Realtime lock status update ── */
setInterval(() => {
    if (!MATERI_PUNYA_VIDEO || !MATERI_PUNYA_FILE) return;
    const msgEl = document.getElementById('lockStatusMessage');
    if (!msgEl) return;
    const vs = window.videoSelesai ? '✓ Video selesai'  : '○ Tonton video sampai selesai';
    const fs = window.pdfSelesai   ? '✓ Dokumen selesai' : '○ Buka/scroll dokumen sampai selesai';
    msgEl.innerHTML = vs + '<br>' + fs;
}, 500);
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://www.youtube.com/iframe_api"></script>

<?= $this->endSection() ?>
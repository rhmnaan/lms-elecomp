<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('meta') ?>
<title><?= esc($modul['judul_modul']) ?> — LMS Elecomp</title>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
    .materi-modul-container {
        display: flex;
        gap: 24px;
        min-height: 600px;
    }

    .materi-sidebar {
        width: 320px;
        flex-shrink: 0;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 1px 8px rgba(0,0,0,.05);
        overflow: hidden;
    }

    .sidebar-header {
        padding: 20px;
        border-bottom: 1px solid #f3f4f6;
        background: #f9fafb;
    }

    .sidebar-header h3 {
        font-size: 16px;
        font-weight: 800;
        color: #111;
        margin: 0;
    }

    .sidebar-header p {
        font-size: 12px;
        color: #9ca3af;
        margin: 4px 0 0;
    }

    .materi-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .materi-list-item {
        padding: 14px 20px;
        border-bottom: 1px solid #f3f4f6;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .materi-list-item:hover { background: #f9fafb; }
    .materi-list-item.active {
        background: #eff6ff;
        border-left: 3px solid #2d6cdf;
    }

    .materi-list-number {
        width: 28px;
        height: 28px;
        background: #f3f4f6;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        font-weight: 700;
        color: #6b7280;
        flex-shrink: 0;
    }

    .materi-list-item.active .materi-list-number {
        background: #2d6cdf;
        color: #fff;
    }

    .materi-list-info { flex: 1; }

    .materi-list-title {
        font-size: 13px;
        font-weight: 600;
        color: #111;
        margin-bottom: 2px;
    }

    .materi-list-meta {
        font-size: 11px;
        color: #9ca3af;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .status-icon { width: 20px; text-align: center; }
    .status-icon.completed { color: #10b981; }

    .materi-content {
        flex: 1;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 1px 8px rgba(0,0,0,.05);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }

    .content-header {
        padding: 20px 28px;
        border-bottom: 1px solid #f3f4f6;
        background: #f9fafb;
    }

    .content-breadcrumb {
        font-size: 12px;
        color: #9ca3af;
        margin-bottom: 8px;
    }

    .content-breadcrumb a {
        color: #9ca3af;
        text-decoration: none;
    }

    .content-breadcrumb a:hover { color: #2d6cdf; }

    .content-title {
        font-size: 24px;
        font-weight: 800;
        color: #111;
        margin-bottom: 8px;
    }

    .content-meta {
        display: flex;
        gap: 16px;
        font-size: 13px;
        color: #6b7280;
        flex-wrap: wrap;
        align-items: center;
    }

    .tipe-badges { display: flex; gap: 6px; flex-wrap: wrap; }

    .tipe-badge {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 8px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }

    .tipe-badge.artikel { background: #eff6ff; color: #2d6cdf; }
    .tipe-badge.video   { background: #fef3c7; color: #d97706; }
    .tipe-badge.pdf     { background: #fff1f2; color: #e11d48; }
    .tipe-badge.quiz    { background: #ede9fe; color: #7c3aed; }

    .content-body { padding: 28px; flex: 1; }

    .content-section { margin-bottom: 32px; }

    .section-label {
        font-size: 11px;
        font-weight: 700;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Video */
    .video-container {
        position: relative;
        padding-bottom: 56.25%;
        height: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,.08);
    }

    .video-container iframe {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        border: none;
    }

    /* PDF — hanya tombol Lihat, tanpa Download */
    .file-preview {
        background: #fff8f8;
        border-radius: 16px;
        padding: 20px 24px;
        border: 1px solid #fecaca;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .file-icon { font-size: 36px; color: #ef4444; flex-shrink: 0; }

    .file-info { flex: 1; }

    .file-info h4 {
        font-size: 14px;
        font-weight: 700;
        color: #111;
        margin: 0 0 3px;
    }

    .file-info p {
        font-size: 12px;
        color: #9ca3af;
        margin: 0;
    }

    .btn-view-pdf {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 8px 18px;
        background: #ef4444;
        color: #fff;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        font-size: 12px;
        transition: all .18s;
        white-space: nowrap;
        flex-shrink: 0;
    }

    .btn-view-pdf:hover {
        background: #dc2626;
        color: #fff;
        transform: translateY(-1px);
    }

    /* Article */
    .article-content {
        line-height: 1.85;
        color: #374151;
        font-size: 15px;
        background: #fff;
        border-radius: 12px;
        padding: 28px 32px;
        box-shadow: 0 1px 3px rgba(0,0,0,.05);
        border: 1px solid #f1f5f9;
    }

    .article-content h1 { font-size: 26px; margin: 32px 0 16px; color: #111827; }
    .article-content h2 { font-size: 22px; margin: 28px 0 14px; color: #1f2937; }
    .article-content h3 { font-size: 18px; margin: 24px 0 12px; color: #374151; }
    .article-content p  { margin-bottom: 18px; }
    .article-content ul,
    .article-content ol { margin: 16px 0 20px 28px; }
    .article-content li { margin-bottom: 8px; }
    .article-content img { max-width: 100%; height: auto; border-radius: 8px; margin: 20px 0; }

    /* Quiz */
    .quiz-wrapper {
        background: #faf5ff;
        border-radius: 16px;
        padding: 24px;
        border: 1px solid #e9d5ff;
    }

    .quiz-intro {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 20px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e9d5ff;
    }

    .quiz-intro-icon {
        width: 48px; height: 48px;
        background: #7c3aed;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 22px; flex-shrink: 0;
    }

    .quiz-intro h4 { font-size: 16px; font-weight: 700; color: #111; margin: 0 0 4px; }
    .quiz-intro p  { font-size: 12px; color: #7c3aed; margin: 0; }

    .quiz-soal { margin-bottom: 24px; }

    .soal-pertanyaan {
        font-size: 14px;
        font-weight: 700;
        color: #111;
        margin-bottom: 12px;
        display: flex;
        gap: 8px;
        align-items: flex-start;
    }

    .soal-num {
        width: 24px; height: 24px;
        background: #7c3aed;
        color: #fff;
        border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 800;
        flex-shrink: 0; margin-top: 1px;
    }

    .pilihan-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 8px; }

    .pilihan-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        background: #fff;
        border: 1.5px solid #e9d5ff;
        border-radius: 10px;
        cursor: pointer;
        transition: all .18s;
        font-size: 13px;
        color: #374151;
        user-select: none;
    }

    .pilihan-item:hover              { border-color: #7c3aed; background: #faf5ff; }
    .pilihan-item.selected           { border-color: #7c3aed; background: #ede9fe; font-weight: 600; color: #5b21b6; }
    .pilihan-item.correct            { border-color: #10b981; background: #d1fae5; color: #065f46; font-weight: 700; pointer-events: none; }
    .pilihan-item.wrong              { border-color: #ef4444; background: #fee2e2; color: #991b1b; pointer-events: none; }
    .pilihan-item.not-selected-lock  { pointer-events: none; opacity: .7; }

    .pilihan-radio {
        width: 18px; height: 18px;
        border: 2px solid #d1d5db;
        border-radius: 50%;
        flex-shrink: 0;
        display: flex; align-items: center; justify-content: center;
        transition: all .18s;
    }

    .pilihan-item.selected .pilihan-radio { border-color: #7c3aed; background: #7c3aed; }
    .pilihan-item.selected .pilihan-radio::after {
        content: '';
        width: 8px; height: 8px;
        background: #fff;
        border-radius: 50%;
    }

    .pilihan-item.correct .pilihan-radio { border-color: #10b981; background: #10b981; }
    .pilihan-item.correct .pilihan-radio::after { content: ''; width: 8px; height: 8px; background: #fff; border-radius: 50%; }
    .pilihan-item.wrong .pilihan-radio   { border-color: #ef4444; background: #ef4444; }
    .pilihan-item.wrong .pilihan-radio::after { content: ''; width: 8px; height: 8px; background: #fff; border-radius: 50%; }

    .quiz-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 20px;
        padding-top: 16px;
        border-top: 1px solid #e9d5ff;
        gap: 10px;
        align-items: center;
    }

    .quiz-progress-text {
        font-size: 12px;
        color: #7c3aed;
        flex: 1;
    }

    .btn-submit-quiz {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 24px;
        background: #7c3aed;
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        font-family: inherit;
        transition: all .18s;
    }

    .btn-submit-quiz:hover    { background: #6d28d9; transform: translateY(-1px); }
    .btn-submit-quiz:disabled { opacity: .55; cursor: not-allowed; transform: none; }

    /* Spinner */
    .btn-submit-quiz .spinner {
        width: 14px; height: 14px;
        border: 2px solid rgba(255,255,255,.4);
        border-top-color: #fff;
        border-radius: 50%;
        animation: spin .7s linear infinite;
        display: none;
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    .quiz-result-box {
        border-radius: 14px;
        margin-top: 20px;
        padding: 28px;
        text-align: center;
        display: none;
    }

    .quiz-result-box.lulus       { background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; }
    .quiz-result-box.tidak-lulus { background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; }

    .nilai-besar { font-size: 52px; font-weight: 800; margin: 8px 0; line-height: 1; }

    .btn-ulangi {
        margin-top: 14px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        background: #fff;
        border: 1.5px solid currentColor;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 700;
        cursor: pointer;
        font-family: inherit;
        transition: opacity .18s;
        color: inherit;
    }

    .btn-ulangi:hover { opacity: .75; }

    /* Empty state */
    .empty-content {
        text-align: center;
        padding: 60px 32px;
        background: #f9fafb;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        color: #9ca3af;
    }

    .empty-content i { font-size: 56px; margin-bottom: 16px; display: inline-block; }

    /* Nav buttons */
    .nav-buttons {
        display: flex;
        justify-content: space-between;
        gap: 16px;
        margin-top: 32px;
        padding-top: 24px;
        border-top: 1px solid #f3f4f6;
    }

    .nav-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        text-decoration: none;
        transition: all .2s;
        border: none;
        cursor: pointer;
        font-family: inherit;
    }

    .nav-btn.prev  { background: #f3f4f6; color: #374151; }
    .nav-btn.prev:hover  { background: #e5e7eb; transform: translateX(-2px); }
    .nav-btn.next  { background: #2d6cdf; color: #fff; }
    .nav-btn.next:hover  { background: #1e40af; transform: translateX(2px); color: #fff; }
    .nav-btn.modul { background: #f3f4f6; color: #374151; }
    .nav-btn.modul:hover { background: #e5e7eb; }
    .nav-btn.disabled    { opacity: .5; pointer-events: none; }

    @media (max-width: 768px) {
        .materi-modul-container { flex-direction: column; }
        .materi-sidebar { width: 100%; }
        .content-title  { font-size: 20px; }
        .content-header { padding: 16px 20px; }
        .content-body   { padding: 20px; }
        .file-preview   { flex-direction: column; align-items: flex-start; }
    }
</style>
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
            <li class="materi-list-item <?= $isActive ? 'active' : '' ?>"
                onclick="loadMateri(<?= $m['id_materi'] ?>)">
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
                        <?php if ($hasVideo): ?><span class="tipe-badge video"><i class="bi bi-play-circle-fill"></i> Video</span><?php endif; ?>
                        <?php if ($hasFile):  ?><span class="tipe-badge pdf"><i class="bi bi-file-earmark-pdf-fill"></i> PDF</span><?php endif; ?>
                        <?php if ($hasIsi):   ?><span class="tipe-badge artikel"><i class="bi bi-file-text-fill"></i> Artikel</span><?php endif; ?>
                        <?php if ($hasQuiz):  ?><span class="tipe-badge quiz"><i class="bi bi-patch-question-fill"></i> Quiz</span><?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="content-body">

                <!-- 1. VIDEO -->
                <?php if ($hasVideo): ?>
                <div class="content-section">
                    <div class="section-label">
                        <i class="bi bi-play-circle-fill" style="color:#d97706;"></i> Video Pembelajaran
                    </div>
                    <div class="video-container">
                        <?php
                        preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([A-Za-z0-9_-]{11})/', $currentMateri['video_url_materi'], $matches);
                        $embedId = $matches[1] ?? null;
                        ?>
                        <?php if ($embedId): ?>
                            <iframe src="https://www.youtube.com/embed/<?= esc($embedId) ?>"
                                    allowfullscreen
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                            </iframe>
                        <?php else: ?>
                            <iframe src="<?= esc($currentMateri['video_url_materi']) ?>" allowfullscreen></iframe>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- 2. FILE PDF (hanya tombol Lihat, tanpa Download) -->
                <?php if ($hasFile): ?>
                <div class="content-section">
                    <div class="section-label">
                        <i class="bi bi-file-earmark-pdf-fill" style="color:#e11d48;"></i> File PDF
                    </div>
                    <div class="file-preview">
                        <div class="file-icon">
                            <i class="bi bi-file-earmark-pdf-fill"></i>
                        </div>
                        <div class="file-info">
                            <h4><?= esc($currentMateri['judul_materi']) ?></h4>
                            <p>Klik tombol untuk membuka file PDF materi ini di tab baru.</p>
                        </div>
                        <a href="<?= base_url(esc($currentMateri['file_materi'])) ?>"
                           class="btn-view-pdf" target="_blank">
                            <i class="bi bi-eye"></i> Lihat PDF
                        </a>
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

                <!-- 4. QUIZ -->
                <?php if ($hasQuiz): ?>
                <div class="content-section" id="quizSection">
                    <div class="section-label">
                        <i class="bi bi-patch-question-fill" style="color:#7c3aed;"></i> Quiz Materi
                    </div>
                    <div class="quiz-wrapper" id="quizWrapper">
                        <div class="quiz-intro">
                            <div class="quiz-intro-icon">
                                <i class="bi bi-patch-question-fill"></i>
                            </div>
                            <div>
                                <h4>Quiz: <?= esc($currentMateri['judul_materi']) ?></h4>
                                <p id="quizSubtitle"><?= count($quizSoal) ?> soal pilihan ganda &bull; Jawab semua soal lalu klik Kumpulkan</p>
                            </div>
                        </div>

                        <!-- Soal -->
                        <?php foreach ($quizSoal as $qi => $soal): ?>
                        <div class="quiz-soal" id="soal-<?= $qi ?>">
                            <div class="soal-pertanyaan">
                                <div class="soal-num"><?= $qi + 1 ?></div>
                                <span><?= esc($soal['pertanyaan']) ?></span>
                            </div>
                            <ul class="pilihan-list">
                                <?php foreach ($soal['pilihan'] as $pi => $pilihan): ?>
                                <li class="pilihan-item"
                                    data-soal="<?= $qi ?>"
                                    data-index="<?= $pi ?>"
                                    onclick="pilihJawaban(this, <?= $qi ?>, <?= $pi ?>)">
                                    <div class="pilihan-radio"></div>
                                    <span><?= esc($pilihan) ?></span>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <?php endforeach; ?>

                        <div class="quiz-actions">
                            <span class="quiz-progress-text" id="quizProgressText">
                                0 / <?= count($quizSoal) ?> soal terjawab
                            </span>
                            <button class="btn-submit-quiz" id="btnKumpulkan"
                                    onclick="kumpulkanQuiz()">
                                <span class="spinner" id="quizSpinner"></span>
                                <i class="bi bi-send-fill" id="quizSendIcon"></i>
                                Kumpulkan Jawaban
                            </button>
                        </div>

                        <!-- Hasil -->
                        <div class="quiz-result-box" id="quizResult">
                            <div style="font-size:13px;font-weight:600;opacity:.8;">Hasil Quiz Kamu</div>
                            <div class="nilai-besar" id="nilaiAngka">0</div>
                            <div style="font-size:15px;font-weight:700;" id="nilaiKeterangan"></div>
                            <div style="margin-top:6px;font-size:13px;opacity:.8;" id="nilaiDetail"></div>
                            <button class="btn-ulangi" id="btnUlangi" onclick="ulangiQuiz()" style="display:none;">
                                <i class="bi bi-arrow-counterclockwise"></i> Coba Lagi
                            </button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

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

                    <?php if ($nextMateri): ?>
                        <button onclick="loadMateri(<?= $nextMateri['id_materi'] ?>)" class="nav-btn next">
                            Selanjutnya <i class="bi bi-arrow-right"></i>
                        </button>
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
/* ── Data dari PHP ── */
const SOAL_DATA   = <?= json_encode($quizSoal, JSON_UNESCAPED_UNICODE) ?>;
const TOTAL_SOAL  = SOAL_DATA.length;
const CSRF_TOKEN  = '<?= csrf_hash() ?>';
const CSRF_NAME   = '<?= csrf_token() ?>';
const SAVE_URL    = '<?= base_url('dashboard/peserta/quiz/simpan-materi') ?>';

/* ── State ── */
const jawabanUser = {};   // { soalIndex: pilihanIndex }
let   quizSelesai = false;

/* ── Navigasi ── */
function loadMateri(idMateri) {
    window.location.href = '<?= base_url('dashboard/peserta/materi-modul') ?>/<?= $modul['id_modul'] ?>?materi=' + idMateri;
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
    const btn     = document.getElementById('btnKumpulkan');
    const spinner = document.getElementById('quizSpinner');
    const icon    = document.getElementById('quizSendIcon');
    btn.disabled      = true;
    spinner.style.display = 'inline-block';
    icon.style.display    = 'none';

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
    const lulus     = nilai >= 70;
    document.getElementById('nilaiAngka').textContent      = nilai;
    document.getElementById('nilaiKeterangan').textContent = lulus ? '🎉 Selamat! Kamu Lulus' : '😔 Belum Lulus';
    document.getElementById('nilaiDetail').textContent     = `${benar} benar dari ${TOTAL_SOAL} soal`;
    resultBox.className    = 'quiz-result-box ' + (lulus ? 'lulus' : 'tidak-lulus');
    resultBox.style.display = 'block';

    // Tampilkan tombol coba lagi jika tidak lulus
    if (!lulus) {
        document.getElementById('btnUlangi').style.display = 'inline-flex';
    }

    resultBox.scrollIntoView({ behavior: 'smooth', block: 'center' });

    // Kirim ke server (simpan hasil)
    try {
        const formData = new FormData();
        formData.append(CSRF_NAME, CSRF_TOKEN);
        formData.append('id_materi',   '<?= $currentMateri['id_materi'] ?? 0 ?>');
        formData.append('nilai',       nilai);
        formData.append('jumlah_benar', benar);
        formData.append('jumlah_salah', TOTAL_SOAL - benar);

        const res  = await fetch(SAVE_URL, { method: 'POST', body: formData });
        const json = await res.json();

        if (!json.success) {
            console.warn('Gagal menyimpan hasil quiz:', json.message);
        }
    } catch (err) {
        console.warn('Error simpan quiz:', err);
    } finally {
        spinner.style.display = 'none';
        icon.style.display    = 'inline-block';
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
    document.getElementById('quizSection').scrollIntoView({ behavior: 'smooth', block: 'start' });
}
</script>

<?= $this->endSection() ?>
<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('meta') ?>
<title><?= esc($materi['judul_materi']) ?> — LMS Elecomp</title>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
.materi-detail-container {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 1px 8px rgba(0, 0, 0, .05);
}

/* Header */
.materi-header {
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    padding: 28px 32px;
    color: #fff;
}

.materi-breadcrumb {
    font-size: 13px;
    color: rgba(255, 255, 255, .7);
    margin-bottom: 12px;
}

.materi-breadcrumb a {
    color: rgba(255, 255, 255, .9);
    text-decoration: none;
}

.materi-breadcrumb a:hover {
    text-decoration: underline;
}

.materi-title {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 12px;
}

.materi-meta {
    display: flex;
    gap: 20px;
    font-size: 13px;
    color: rgba(255, 255, 255, .8);
}

.materi-meta i {
    margin-right: 5px;
}

.tipe-badge-white {
    background: rgba(255, 255, 255, .2);
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
}

/* Content */
.materi-content {
    padding: 32px;
}

/* Video */
.video-container {
    position: relative;
    padding-bottom: 56.25%;
    height: 0;
    margin-bottom: 24px;
    border-radius: 12px;
    overflow: hidden;
}

.video-container iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}

/* File */
.file-preview {
    text-align: center;
    padding: 60px 40px;
    background: #f9fafb;
    border-radius: 16px;
    margin-bottom: 24px;
}

.file-preview i {
    font-size: 64px;
    color: #ef4444;
    margin-bottom: 16px;
    display: block;
}

.btn-download {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #2d6cdf;
    color: #fff;
    padding: 10px 24px;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    margin-top: 16px;
    transition: background .15s;
}

.btn-download:hover {
    background: #1e40af;
    color: #fff;
}

/* Artikel */
.article-content {
    line-height: 1.8;
    color: #374151;
    font-size: 15px;
}

.article-content h1,
.article-content h2,
.article-content h3 {
    margin-top: 24px;
    margin-bottom: 16px;
    font-weight: 700;
}

.article-content p {
    margin-bottom: 16px;
}

.article-content pre {
    background: #1e293b;
    color: #e2e8f0;
    padding: 16px;
    border-radius: 12px;
    overflow-x: auto;
    font-size: 13px;
    margin: 16px 0;
}

.article-content code {
    background: #f1f5f9;
    padding: 2px 6px;
    border-radius: 6px;
    font-size: 13px;
    color: #dc2626;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 20px 0;
}

/* Navigasi */
.materi-nav {
    display: flex;
    justify-content: space-between;
    gap: 16px;
    margin-top: 32px;
    padding-top: 24px;
    border-top: 1px solid #e5e7eb;
}

.nav-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #f3f4f6;
    border-radius: 10px;
    text-decoration: none;
    font-weight: 600;
    color: #374151;
    transition: all .15s;
}

.nav-btn:hover {
    background: #e5e7eb;
}

.nav-btn.prev:hover {
    transform: translateX(-2px);
}

.nav-btn.next:hover {
    transform: translateX(2px);
}

.nav-btn.disabled {
    opacity: 0.5;
    pointer-events: none;
}

.nav-btn i {
    font-size: 14px;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="materi-detail-container">
    <!-- HEADER -->
    <div class="materi-header">
        <div class="materi-breadcrumb">
            <a href="<?= base_url('dashboard/peserta/kelas') ?>">Kelas Saya</a>
            <i class="bi bi-chevron-right"></i>
            <a href="<?= base_url('dashboard/peserta/modul') ?>">Modul</a>
            <i class="bi bi-chevron-right"></i>
            <span><?= esc($materi['nama_kelas']) ?></span>
        </div>
        <h1 class="materi-title"><?= esc($materi['judul_materi']) ?></h1>
        <div class="materi-meta">
            <span><i class="bi bi-folder"></i> <?= esc($materi['judul_modul']) ?></span>
            <span><i class="bi bi-person"></i> <?= esc($materi['nama_pengajar'] ?? 'Pengajar') ?></span>
            <span class="tipe-badge-white">
                <i
                    class="bi <?= $materi['tipe'] == 'video' ? 'bi-play-circle-fill' : ($materi['tipe'] == 'file' ? 'bi-file-earmark-pdf-fill' : 'bi-file-text-fill') ?>"></i>
                <?= ucfirst($materi['tipe']) ?>
            </span>
        </div>
    </div>

    <!-- CONTENT -->
    <div class="materi-content">
        <!-- VIDEO -->
        <?php if ($materi['tipe'] == 'video' && !empty($materi['video_url_materi'])): ?>
        <div class="video-container">
            <?php
                $video_url = $materi['video_url_materi'];
                if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/', $video_url, $matches)) {
                    $video_id = $matches[1];
                    echo '<iframe src="https://www.youtube.com/embed/' . $video_id . '" frameborder="0" allowfullscreen></iframe>';
                } elseif (preg_match('/vimeo\.com\/(\d+)/', $video_url, $matches)) {
                    echo '<iframe src="https://player.vimeo.com/video/' . $matches[1] . '" frameborder="0" allowfullscreen></iframe>';
                } else {
                    echo '<iframe src="' . $video_url . '" frameborder="0" allowfullscreen></iframe>';
                }
                ?>
        </div>
        <?php endif; ?>

        <!-- FILE -->
        <?php if ($materi['tipe'] == 'file' && !empty($materi['file_materi'])): ?>
        <div class="file-preview">
            <i class="bi bi-file-earmark-pdf-fill"></i>
            <h3><?= esc($materi['judul_materi']) ?></h3>
            <p style="color: #6b7280; margin-top: 8px;">Klik tombol di bawah untuk mengunduh materi</p>
            <a href="<?= base_url('uploads/materi/' . $materi['file_materi']) ?>" class="btn-download" target="_blank">
                <i class="bi bi-download"></i> Unduh Materi
            </a>
        </div>
        <?php endif; ?>

        <!-- ARTIKEL -->
        <?php if ($materi['tipe'] == 'artikel' && !empty($materi['isi_materi'])): ?>
        <div class="article-content">
            <?= $materi['isi_materi'] ?>
        </div>
        <?php endif; ?>

        <!-- NAVIGASI -->
        <div class="materi-nav">
            <?php if ($prev_materi): ?>
            <a href="<?= base_url('dashboard/peserta/materi/' . $prev_materi['id_materi']) ?>" class="nav-btn prev">
                <i class="bi bi-arrow-left"></i> Sebelumnya
            </a>
            <?php else: ?>
            <span class="nav-btn prev disabled">
                <i class="bi bi-arrow-left"></i> Sebelumnya
            </span>
            <?php endif; ?>

            <a href="<?= base_url('dashboard/peserta/materi-list') ?>" class="nav-btn">
                <i class="bi bi-grid"></i> Semua Materi
            </a>

            <?php if ($next_materi): ?>
            <a href="<?= base_url('dashboard/peserta/materi/' . $next_materi['id_materi']) ?>" class="nav-btn next">
                Selanjutnya <i class="bi bi-arrow-right"></i>
            </a>
            <?php else: ?>
            <span class="nav-btn next disabled">
                Selanjutnya <i class="bi bi-arrow-right"></i>
            </span>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>
<?= $this->section('content') ?>

<?php
$success = session()->getFlashdata('success');
$error = session()->getFlashdata('error');
$errors = session()->getFlashdata('errors');
?>

<style>
    .mp-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 24px;
    }

    .mp-header h1 {
        font-size: 20px;
        font-weight: 800;
        color: #111;
        margin: 0 0 3px;
    }

    .mp-header p {
        font-size: 13px;
        color: #6b7280;
        margin: 0;
    }

    .mp-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        border-radius: 12px;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 16px;
    }

    .mp-alert-success {
        background: #f0fdf4;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }

    .mp-alert-danger {
        background: #fff5f5;
        color: #dc2626;
        border: 1px solid #fecaca;
    }

    .mp-alert i {
        font-size: 15px;
    }

    .mp-toolbar {
        background: #fff;
        border-radius: 14px;
        padding: 14px 18px;
        box-shadow: 0 1px 6px rgba(0, 0, 0, .05);
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .mp-search {
        position: relative;
        flex: 1;
        min-width: 200px;
        max-width: 280px;
    }

    .mp-search i {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 12px;
        pointer-events: none;
    }

    .mp-search input {
        width: 100%;
        padding: 8px 12px 8px 30px;
        border: 1.5px solid #e5e7eb;
        border-radius: 9px;
        font-size: 13px;
        font-family: inherit;
        color: #374151;
        background: #f9fafb;
        outline: none;
        transition: border .18s, background .18s;
    }

    .mp-search input:focus {
        border-color: #059669;
        background: #fff;
    }

    .mp-select {
        padding: 8px 12px;
        border: 1.5px solid #e5e7eb;
        border-radius: 9px;
        font-size: 13px;
        font-family: inherit;
        color: #374151;
        background: #f9fafb;
        outline: none;
        cursor: pointer;
        min-width: 190px;
        transition: border .18s;
    }

    .mp-select:focus {
        border-color: #059669;
        background: #fff;
    }

    .mp-count {
        margin-left: auto;
        font-size: 12px;
        color: #9ca3af;
        white-space: nowrap;
    }

    .mp-count strong {
        color: #374151;
    }

    .mp-table-card {
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 1px 8px rgba(0, 0, 0, .05);
        overflow: hidden;
    }

    .mp-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .mp-table thead th {
        padding: 12px 16px;
        text-align: left;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .6px;
        color: #9ca3af;
        text-transform: uppercase;
        background: #fafafa;
        border-bottom: 1px solid #f0f0f0;
        white-space: nowrap;
    }

    .mp-table tbody td {
        padding: 12px 16px;
        border-bottom: 1px solid #f9fafb;
        color: #374151;
        vertical-align: middle;
    }

    .mp-table tbody tr:last-child td {
        border-bottom: none;
    }

    .mp-table tbody tr:hover td {
        background: #f9fafb;
    }

    .mcell {
        display: flex;
        align-items: center;
        gap: 11px;
    }

    .micon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: #ecfdf5;
        color: #059669;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .mtitle {
        font-size: 13px;
        font-weight: 700;
        color: #111;
        margin-bottom: 2px;
    }

    .mpreview {
        font-size: 11.5px;
        color: #9ca3af;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 240px;
    }

    .media-badges {
        display: flex;
        gap: 4px;
        margin-top: 4px;
        flex-wrap: wrap;
    }

    .mbadge {
        display: inline-flex;
        align-items: center;
        gap: 3px;
        padding: 2px 7px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
        white-space: nowrap;
    }

    .mbadge-pretest {
        background: #e0f2fe;
        color: #0369a1;
    }

    .mbadge-pdf {
    background: #fff1f2;
    color: #e11d48;
}

.mbadge-word {
    background: #eff6ff;
    color: #2563eb;
}

.mbadge-excel {
    background: #f0fdf4;
    color: #059669;
}

.mbadge-ppt {
    background: #fff7ed;
    color: #ea580c;
}

    .mbadge-video {
        background: #fef3c7;
        color: #d97706;
    }

    .mbadge-posttest {
        background: #ede9fe;
        color: #7c3aed;
    }

    .badge-modul {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        background: #eff6ff;
        color: #2563eb;
        white-space: nowrap;
    }

    .badge-kelas {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        background: #f0fdf4;
        color: #059669;
        white-space: nowrap;
    }

    .btn-act {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 31px;
        height: 31px;
        border-radius: 7px;
        border: none;
        cursor: pointer;
        font-size: 12px;
        transition: background .14s, color .14s;
        text-decoration: none;
    }

    .btn-edit {
        background: #eff6ff;
        color: #2563eb;
    }

    .btn-edit:hover {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .btn-delete {
        background: #fff5f5;
        color: #ef4444;
    }

    .btn-delete:hover {
        background: #fee2e2;
        color: #dc2626;
    }

    .btn-view {
        background: #f0fdf4;
        color: #059669;
    }

    .btn-view:hover {
        background: #dcfce7;
        color: #047857;
    }

    .mp-empty {
        text-align: center;
        padding: 52px 20px;
        color: #9ca3af;
    }

    .mp-empty-icon {
        width: 66px;
        height: 66px;
        border-radius: 18px;
        background: #f3f4f6;
        color: #d1d5db;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        margin-bottom: 14px;
    }

    .mp-empty h3 {
        font-size: 14px;
        font-weight: 700;
        color: #374151;
        margin-bottom: 4px;
    }

    .mp-empty p {
        font-size: 12.5px;
        margin-bottom: 16px;
    }

    #mp-no-results {
        display: none;
        text-align: center;
        padding: 44px;
        color: #9ca3af;
        font-size: 13px;
    }

    .btn-add {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: linear-gradient(135deg, #059669, #047857);
        color: #fff;
        border: none;
        border-radius: 11px;
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 700;
        font-family: inherit;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 0 4px 12px rgba(5, 150, 105, .28);
        transition: transform .14s, box-shadow .14s;
        white-space: nowrap;
    }

    .btn-add:hover {
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(5, 150, 105, .38);
    }

    /* ── Tabs ── */
    .mtab-nav {
        display: flex;
        gap: 4px;
        background: #f3f4f6;
        border-radius: 10px;
        padding: 4px;
        margin-bottom: 20px;
    }

    .mtab-btn {
        flex: 1;
        padding: 8px 10px;
        border: none;
        border-radius: 7px;
        background: transparent;
        font-size: 12px;
        font-weight: 600;
        color: #6b7280;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        transition: all .18s;
    }

    .mtab-btn.active {
        background: #fff;
        color: #059669;
        box-shadow: 0 1px 4px rgba(0, 0, 0, .1);
    }

    .mtab-pane {
        display: none;
    }

    .mtab-pane.active {
        display: block;
    }

    /* ── Upload drop zone ── */
    .upload-zone {
        border: 2px dashed #d1d5db;
        border-radius: 12px;
        padding: 28px 20px;
        text-align: center;
        cursor: pointer;
        transition: border-color .18s, background .18s;
        background: #fafafa;
    }

    .upload-zone:hover,
    .upload-zone.dragover {
        border-color: #059669;
        background: #f0fdf4;
    }

    .upload-zone i {
        font-size: 28px;
        color: #d1d5db;
        margin-bottom: 8px;
        display: block;
    }

    .upload-zone.has-file i {
        color: #059669;
    }

    .upload-zone p {
        margin: 0;
        font-size: 13px;
        color: #6b7280;
    }

    .upload-zone .file-name {
        font-weight: 700;
        color: #374151;
        font-size: 13px;
    }

    .upload-zone input[type=file] {
        display: none;
    }

    /* ── Quiz / soal builder ── */
    .quiz-item {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 14px 14px 10px;
        margin-bottom: 10px;
        position: relative;
    }

    .quiz-item.is-pretest {
        background: #f0f9ff;
        border-color: #bae6fd;
    }

    .quiz-item.is-posttest {
        background: #faf5ff;
        border-color: #ddd6fe;
    }

    .quiz-item .quiz-num {
        position: absolute;
        top: -10px;
        left: 14px;
        background: #7c3aed;
        color: #fff;
        font-size: 10px;
        font-weight: 800;
        padding: 2px 10px;
        border-radius: 20px;
    }

    .quiz-item.is-pretest .quiz-num {
        background: #0ea5e9;
    }

    .quiz-item.is-posttest .quiz-num {
        background: #7c3aed;
    }

    .quiz-remove {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #fee2e2;
        color: #ef4444;
        border: none;
        border-radius: 6px;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 11px;
    }

    .quiz-remove:hover {
        background: #fecaca;
    }

    .choice-row {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 6px;
    }

    .choice-row input[type=radio] {
        flex-shrink: 0;
    }

    .choice-row.is-pretest input[type=radio] {
        accent-color: #0ea5e9;
    }

    .choice-row.is-posttest input[type=radio] {
        accent-color: #7c3aed;
    }

    .choice-row .form-control {
        flex: 1;
        font-size: 12px;
        padding: 6px 10px;
    }

    .btn-add-quiz {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 8px;
        background: #faf5ff;
        color: #7c3aed;
        border: 1.5px dashed #ddd6fe;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background .14s;
    }

    .btn-add-quiz:hover {
        background: #ede9fe;
    }

    .btn-add-quiz.blue {
        background: #f0f9ff;
        color: #0284c7;
        border-color: #7dd3fc;
    }

    .btn-add-quiz.blue:hover {
        background: #e0f2fe;
    }

    .current-file-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        border-radius: 8px;
        background: #fff1f2;
        color: #e11d48;
        font-size: 11px;
        font-weight: 600;
        margin-top: 6px;
    }

    /* ── Preview quiz list ── */
    .quiz-preview-wrap {
        margin-bottom: 16px;
    }

    .quiz-preview-label {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 20px;
        margin-bottom: 10px;
    }

    .quiz-preview-label.pre {
        color: #0369a1;
        background: #e0f2fe;
    }

    .quiz-preview-label.post {
        color: #7c3aed;
        background: #ede9fe;
    }

    .quiz-preview-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .quiz-preview-list>li {
        padding: 10px 14px;
        border-radius: 8px;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        margin-bottom: 8px;
        font-size: 13px;
    }

    .quiz-preview-list.pre>li {
        background: #f0f9ff;
        border-color: #bae6fd;
    }

    .quiz-preview-list.post>li {
        background: #faf5ff;
        border-color: #ddd6fe;
    }

    .q-num {
        font-weight: 800;
        margin-right: 4px;
    }

    .q-num.pre {
        color: #0369a1;
    }

    .q-num.post {
        color: #7c3aed;
    }

    .choice-list {
        list-style: none;
        margin: 6px 0 0 16px;
        padding: 0;
    }

    .choice-list li {
        font-size: 12px;
        color: #6b7280;
        padding: 2px 0;
    }

    .choice-list li.correct {
        color: #059669;
        font-weight: 700;
    }

    .no-soal {
        font-size: 12px;
        color: #9ca3af;
        font-style: italic;
        margin-bottom: 12px;
    }

    /* ── Validasi alert ── */
    .mp-alert-warn {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 14px;
        border-radius: 10px;
        margin-bottom: 12px;
        font-size: 12.5px;
        font-weight: 600;
        background: #fffbeb;
        color: #b45309;
        border: 1px solid #fde68a;
    }

    /* ── Video selector tab ── */
    .vid-select-wrap {
        position: relative;
    }

    .vid-info-box {
        display: none;
        margin-top: 8px;
        padding: 8px 12px;
        border-radius: 8px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        font-size: 12px;
        color: #15803d;
        font-weight: 600;
    }

    .vid-info-box.show {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    @media (max-width: 768px) {
        .mp-header {
            flex-direction: column;
        }

        .mpreview {
            max-width: 140px;
        }

        .mtab-btn span {
            display: none;
        }
    }
</style>

<!-- PAGE HEADER -->
<div class="mp-header">
    <div>
        <h1>Manajemen Materi</h1>
        <p>Kelola konten materi untuk setiap modul kelas Anda.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
        <a href="<?= base_url('dashboard/pengajar/video/upload') ?>" class="btn-add"
            style="background:linear-gradient(135deg,#2563eb,#1d4ed8);">
            <i class="bi bi-play-circle-fill"></i> Upload Video
        </a>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg"></i> Tambah Materi
        </button>
    </div>
</div>

<!-- FLASH MESSAGES -->
<?php if ($success): ?>
    <div class="mp-alert mp-alert-success"><i class="bi bi-check-circle-fill"></i> <?= esc($success) ?></div>
<?php endif; ?>
<?php if ($error): ?>
    <div class="mp-alert mp-alert-danger"><i class="bi bi-exclamation-triangle-fill"></i> <?= esc($error) ?></div>
<?php endif; ?>
<?php if ($errors): ?>
    <div class="mp-alert mp-alert-danger" style="flex-direction:column;align-items:flex-start;gap:4px;">
        <div style="display:flex;align-items:center;gap:8px;font-weight:700;">
            <i class="bi bi-exclamation-triangle-fill"></i> Terjadi Kesalahan Validasi
        </div>
        <ul style="margin:4px 0 0 20px;padding:0;">
            <?php foreach ($errors as $e): ?>
                <li style="font-weight:400;"><?= esc($e) ?></li><?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- TOOLBAR -->
<div class="mp-toolbar">
    <div class="mp-search">
        <i class="bi bi-search"></i>
        <input type="text" id="searchInput" placeholder="Cari judul materi...">
    </div>

    <!-- Filter Program -->
    <select class="mp-select" id="filterProgram" style="min-width:155px;">
        <option value="">Semua Program</option>
        <?php foreach (($program ?? []) as $p): ?>
            <option value="<?= $p['id_program'] ?>"><?= esc($p['nama_program']) ?></option>
        <?php endforeach; ?>
    </select>

    <!-- Filter Kelas -->
    <select class="mp-select" id="filterKelas" style="min-width:155px;">
        <option value="">Semua Kelas</option>
        <?php foreach (($kelas ?? []) as $k): ?>
            <option value="<?= $k['id_kelas'] ?>" data-program="<?= $k['id_program'] ?>">
                <?= esc($k['nama_kelas']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <!-- Filter Modul -->
    <select class="mp-select" id="filterModul">
        <option value="">Semua Modul</option>
        <?php foreach (($modul ?? []) as $m): ?>
            <option value="<?= $m['id_modul'] ?>" data-program="<?= $m['id_program'] ?>" data-kelas="<?= $m['id_kelas'] ?>">
                <?= esc($m['judul_modul']) ?> — <?= esc($m['nama_kelas']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <div class="mp-count">Tampil: <strong id="visibleCount"><?= count($materi ?? []) ?></strong> materi</div>
</div>

<!-- TABLE -->
<div class="mp-table-card">
    <div class="table-responsive">
        <table class="mp-table">
            <thead>
                <tr>
                    <th style="width:44px;padding-left:20px;">#</th>
                    <th>Judul Materi</th>
                    <th>Modul</th>
                    <th>Kelas</th>
                    <th style="width:110px;" class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="tableBody">
                <?php if (!empty($materi)): ?>
                    <?php foreach ($materi as $i => $mt):
                        $preArr = json_decode($mt['pre_test'] ?? '', true);
                        $postArr = json_decode($mt['post_test'] ?? '', true);
                        if (!is_array($preArr))
                            $preArr = [];
                        if (!is_array($postArr))
                            $postArr = [];
                        $isLocalVideo = !empty($mt['video_url_materi']) && str_starts_with($mt['video_url_materi'], 'vid_');
                        ?>
                        <tr data-modul="<?= $mt['id_modul'] ?>" data-program="<?= $mt['id_program'] ?>"
                            data-kelas="<?= $mt['id_kelas'] ?>" data-judul="<?= strtolower(esc($mt['judul_materi'])) ?>"
                            data-id="<?= $mt['id_materi'] ?>" data-judul-raw="<?= esc($mt['judul_materi']) ?>"
                            data-modul-val="<?= $mt['id_modul'] ?>" data-file="<?= esc($mt['file_materi'] ?? '') ?>"
                            data-video="<?= esc($mt['video_url_materi'] ?? '') ?>"
                            data-pretest="<?= htmlspecialchars(json_encode($preArr), ENT_QUOTES, 'UTF-8') ?>"
                            data-posttest="<?= htmlspecialchars(json_encode($postArr), ENT_QUOTES, 'UTF-8') ?>">

                            <td style="padding-left:20px;color:#9ca3af;font-weight:700;" class="row-num"><?= $i + 1 ?></td>
                            <td>
                                <div class="mcell">
                                    <div class="micon"><i class="bi bi-file-earmark-text-fill"></i></div>
                                    <div>
                                        <div class="mtitle"><?= esc($mt['judul_materi']) ?></div>
                                        <div class="mpreview">
                                            <?php if (count($preArr) > 0): ?>
                                                <?= count($preArr) ?> soal pre test · <?= count($postArr) ?> soal post test
                                            <?php else: ?>
                                                Belum ada pre test
                                            <?php endif; ?>
                                        </div>
                                        <div class="media-badges">
                                            <?php if (count($preArr) > 0): ?>
                                                <span class="mbadge mbadge-pretest"><i class="bi bi-list-check"></i> Pre Test
                                                    (<?= count($preArr) ?>)</span>
                                            <?php endif; ?>
                                            <?php if (!empty($mt['file_materi'])): ?>
    <?php
        $ext = strtolower(pathinfo($mt['file_materi'], PATHINFO_EXTENSION));
        $badgeMap = [
            'pdf'  => ['mbadge-pdf',   'bi-file-earmark-pdf-fill',   'PDF'],
            'doc'  => ['mbadge-word',  'bi-file-earmark-word-fill',  'Word'],
            'docx' => ['mbadge-word',  'bi-file-earmark-word-fill',  'Word'],
            'xls'  => ['mbadge-excel', 'bi-file-earmark-excel-fill', 'Excel'],
            'xlsx' => ['mbadge-excel', 'bi-file-earmark-excel-fill', 'Excel'],
            'ppt'  => ['mbadge-ppt',   'bi-file-earmark-ppt-fill',   'PPT'],
            'pptx' => ['mbadge-ppt',   'bi-file-earmark-ppt-fill',   'PPT'],
        ];
        [$bc, $ic, $lb] = $badgeMap[$ext] ?? ['mbadge-pdf', 'bi-file-earmark-fill', strtoupper($ext)];
    ?>
    <span class="mbadge <?= $bc ?>">
        <i class="bi <?= $ic ?>"></i> <?= $lb ?>
    </span>
<?php endif; ?>
                                            <?php if (!empty($mt['video_url_materi'])): ?>
                                                <span class="mbadge mbadge-video">
                                                    <i
                                                        class="bi bi-<?= $isLocalVideo ? 'shield-lock-fill' : 'play-circle-fill' ?>"></i>
                                                    <?= $isLocalVideo ? 'Video Lokal' : 'Video' ?>
                                                </span>
                                            <?php endif; ?>
                                            <?php if (count($postArr) > 0): ?>
                                                <span class="mbadge mbadge-posttest"><i class="bi bi-patch-question-fill"></i> Post
                                                    Test (<?= count($postArr) ?>)</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-modul"><i class="bi bi-collection" style="font-size:10px;"></i>
                                    <?= esc($mt['judul_modul']) ?></span>
                            </td>
                            <td>
                                <span class="badge-kelas"><i class="bi bi-mortarboard-fill" style="font-size:10px;"></i>
                                    <?= esc($mt['nama_kelas']) ?></span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center gap-1">
                                    <button class="btn-act btn-view btn-preview" title="Lihat Konten"
                                        data-row-id="<?= $mt['id_materi'] ?>">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn-act btn-edit btn-edit-materi" title="Edit Materi"
                                        data-row-id="<?= $mt['id_materi'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn-act btn-delete btn-hapus-materi" title="Hapus Materi"
                                        data-row-id="<?= $mt['id_materi'] ?>" data-judul-raw="<?= esc($mt['judul_materi']) ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr id="emptyRow">
                        <td colspan="5">
                            <div class="mp-empty">
                                <div class="mp-empty-icon"><i class="bi bi-file-earmark-text"></i></div>
                                <h3>Belum ada materi</h3>
                                <p>Mulai dengan menambahkan materi pertama untuk kelas Anda.</p>
                                <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                    <i class="bi bi-plus-lg"></i> Tambah Materi Pertama
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div id="mp-no-results">
            <i class="bi bi-search" style="font-size:30px;display:block;margin-bottom:8px;color:#d1d5db;"></i>
            Tidak ada materi yang cocok dengan pencarian.
        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════
     MODAL TAMBAH
════════════════════════════════════════ -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-plus-circle-fill text-success me-2"></i>Tambah Materi Baru
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-3 pb-4">
                <form id="formTambah" action="<?= base_url('dashboard/pengajar/materi/store') ?>" method="POST"
                    enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <!-- Program + Kelas -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Pilih Program <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="tambah_id_program">
                                <option value="" disabled selected>-- Pilih Program --</option>
                                <?php foreach ($program ?? [] as $p): ?>
                                    <option value="<?= $p['id_program'] ?>"><?= esc($p['nama_program']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Pilih Kelas <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="tambah_id_kelas" disabled>
                                <option value="" disabled selected>-- Pilih Kelas --</option>
                            </select>
                        </div>
                    </div>

                    <!-- Modul (muncul setelah kelas dipilih) -->
                    <div class="mb-3" id="wrapModulTambah" style="display:none;">
                        <label class="form-label fw-semibold small">Modul <span class="text-danger">*</span></label>
                        <?php if (empty($modul)): ?>
                            <div class="alert alert-warning py-2 px-3 small rounded-3">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                Belum ada modul. Silakan buat modul terlebih dahulu.
                            </div>
                        <?php else: ?>
                            <select class="form-select" name="id_modul" id="tambah_id_modul" required>
                                <option value="" disabled selected>-- Pilih Modul --</option>
                                <?php foreach ($modul as $m): ?>
                                    <option value="<?= $m['id_modul'] ?>" data-kelas="<?= $m['id_kelas'] ?>"
                                        data-program="<?= $m['id_program'] ?>" <?= (old('id_modul') == $m['id_modul']) ? 'selected' : '' ?>>
                                        <?= esc($m['judul_modul']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Judul Materi <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul_materi" value="<?= old('judul_materi') ?>"
                            placeholder="cth: Pengertian Resistor dan Fungsinya" required>
                    </div>

                    <!-- Alert validasi PDF/Video -->
                    <div id="alertPdfVideoTambah" class="mp-alert-warn" style="display:none;">
    <i class="bi bi-exclamation-triangle-fill"></i>
    Wajib mengisi salah satu: <strong>upload Dokumen</strong> (PDF/Word/Excel/PPT) atau <strong>pilih Video</strong>.
</div>

                    <!-- TABS -->
                    <div class="mtab-nav" id="tabNavTambah">
                        <button type="button" class="mtab-btn active" data-tab="tab-pre-tambah">
                            <i class="bi bi-list-check"></i><span> Pre Test</span>
                        </button>
                        <button type="button" class="mtab-btn" data-tab="tab-pdf-tambah">
    <i class="bi bi-file-earmark-arrow-up"></i><span> Dokumen</span>
</button>
                        <button type="button" class="mtab-btn" data-tab="tab-video-tambah">
                            <i class="bi bi-play-circle"></i><span> Video</span>
                        </button>
                        <button type="button" class="mtab-btn" data-tab="tab-post-tambah">
                            <i class="bi bi-patch-question"></i><span> Post Test</span>
                        </button>
                    </div>

                    <!-- TAB: Pre Test -->
                    <div class="mtab-pane active" id="tab-pre-tambah">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <p class="fw-semibold small mb-0">Soal Pre Test</p>
                                <p class="form-text mb-0">Dikerjakan peserta <strong>sebelum</strong> membaca materi.
                                </p>
                            </div>
                            <button type="button" class="btn-add-quiz blue" id="btnAddPreTambah">
                                <i class="bi bi-plus-lg"></i> Tambah Soal
                            </button>
                        </div>
                        <div id="containerPreTambah"></div>
                        <div id="emptyPreTambah" class="text-center py-4" style="color:#9ca3af;font-size:12.5px;">
                            <i class="bi bi-list-check"
                                style="font-size:28px;display:block;color:#bae6fd;margin-bottom:8px;"></i>
                            Belum ada soal. Klik "+ Tambah Soal" untuk membuat pre test.
                        </div>
                    </div>

                   <!-- TAB: Dokumen -->
<div class="mtab-pane" id="tab-pdf-tambah">
    <label class="form-label fw-semibold small">
        Upload Dokumen <span class="text-danger">*</span>
        <span class="text-muted fw-normal">(wajib jika tidak ada video)</span>
    </label>

    <!-- Info format yang didukung -->
    <div class="d-flex gap-2 flex-wrap mb-3">
        <span class="mbadge mbadge-pdf"><i class="bi bi-file-earmark-pdf-fill"></i> PDF</span>
        <span class="mbadge mbadge-word"><i class="bi bi-file-earmark-word-fill"></i> Word</span>
        <span class="mbadge mbadge-excel"><i class="bi bi-file-earmark-excel-fill"></i> Excel</span>
        <span class="mbadge mbadge-ppt"><i class="bi bi-file-earmark-ppt-fill"></i> PowerPoint</span>
    </div>

    <div class="upload-zone" id="dropZoneTambah"
        onclick="document.getElementById('filePdfTambah').click()">
        <input type="file" id="filePdfTambah" name="file_materi"
            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
        <i class="bi bi-cloud-arrow-up" id="uploadIconTambah"></i>
        <p class="mb-1"><strong>Klik untuk upload</strong> atau drag &amp; drop</p>
        <p style="font-size:11px;">PDF · Word · Excel · PowerPoint · Maks. 20 MB</p>
        <p class="file-name" id="fileNameTambah" style="display:none;"></p>
    </div>

    <!-- Preview tipe file setelah dipilih -->
    <div id="fileTypeBadgeTambah" style="display:none; margin-top:8px;"></div>
</div>

                    <!-- TAB: Video (Video Lokal Terenkripsi) -->
                    <div class="mtab-pane" id="tab-video-tambah">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-semibold small mb-0">
                                Video Lokal Terenkripsi <span class="text-danger">*</span>
                                <span class="text-muted fw-normal">(wajib jika tidak ada PDF)</span>
                            </label>
                            <a href="<?= base_url('dashboard/pengajar/video/upload') ?>" target="_blank"
                                class="d-inline-flex align-items-center gap-1 px-2 py-1 rounded-2 text-decoration-none fw-semibold"
                                style="background:#f0fdf4;color:#059669;font-size:11px;white-space:nowrap;">
                                <i class="bi bi-cloud-arrow-up"></i> Upload Video Baru
                            </a>
                        </div>

                        <div class="input-group mb-1">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-shield-lock-fill text-success"></i>
                            </span>
                            <select class="form-select border-start-0" name="video_url_materi" id="videoSelectTambah">
                                <option value="">-- Pilih Video --</option>
                            </select>
                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                onclick="loadVideoOptions('videoSelectTambah', 'videoInfoTambah', 'videoInfoTextTambah')"
                                title="Refresh daftar video">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </div>

                        <div id="videoInfoTambah" class="vid-info-box">
                            <i class="bi bi-shield-check-fill"></i>
                            <span id="videoInfoTextTambah"></span>
                        </div>

                        <div class="mt-2">
                            <p class="form-text mb-1">Atau masukkan Video ID secara manual:</p>
                            <input type="text" class="form-control form-control-sm" id="videoManualTambah"
                                placeholder="cth: vid_abc123def456..."
                                oninput="syncManual('videoSelectTambah','videoManualTambah','videoInfoTambah','videoInfoTextTambah')">
                        </div>

                        <div class="mt-2 p-2 rounded-3"
                            style="background:#fffbeb;border:1px solid #fde68a;font-size:11.5px;color:#92400e;">
                            <i class="bi bi-info-circle me-1"></i>
                            Video diputar aman di browser dengan dekripsi AES-256-CBC. Tidak bisa didownload.
                        </div>
                    </div>

                    <!-- TAB: Post Test -->
                    <div class="mtab-pane" id="tab-post-tambah">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <p class="fw-semibold small mb-0">Soal Post Test</p>
                                <p class="form-text mb-0">Dikerjakan peserta <strong>setelah</strong> membaca materi.
                                </p>
                            </div>
                            <button type="button" class="btn-add-quiz" id="btnAddPostTambah">
                                <i class="bi bi-plus-lg"></i> Tambah Soal
                            </button>
                        </div>
                        <div id="containerPostTambah"></div>
                        <div id="emptyPostTambah" class="text-center py-4" style="color:#9ca3af;font-size:12.5px;">
                            <i class="bi bi-patch-question"
                                style="font-size:28px;display:block;color:#ddd6fe;margin-bottom:8px;"></i>
                            Belum ada soal. Klik "+ Tambah Soal" untuk membuat post test.
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3 mt-3">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success px-4 fw-semibold">
                            <i class="bi bi-save me-1"></i>Simpan Materi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════
     MODAL EDIT
════════════════════════════════════════ -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-pencil-square text-warning me-2"></i>Edit Materi
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-3 pb-4">
                <form id="formEdit" method="POST" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Pilih Program <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="edit_id_program">
                                <option value="" disabled selected>-- Pilih Program --</option>
                                <?php foreach ($program ?? [] as $p): ?>
                                    <option value="<?= $p['id_program'] ?>"><?= esc($p['nama_program']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Pilih Kelas <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="edit_id_kelas" disabled>
                                <option value="" disabled selected>-- Pilih Kelas --</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Modul <span class="text-danger">*</span></label>
                        <select class="form-select" name="id_modul" id="edit_id_modul" required>
                            <option value="" disabled>-- Pilih Modul --</option>
                            <?php foreach ($modul as $m): ?>
                                <option value="<?= $m['id_modul'] ?>"><?= esc($m['judul_modul']) ?> —
                                    <?= esc($m['nama_kelas']) ?></option>
                            <?php endforeach; ?>
                            <option value="<?= $m['id_modul'] ?>" data-kelas="<?= $m['id_kelas'] ?>"
                                data-program="<?= $m['id_program'] ?>">
                                <?= esc($m['judul_modul']) ?> — <?= esc($m['nama_kelas']) ?>
                            </option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Judul Materi <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="judul_materi" id="edit_judul_materi" required>
                    </div>

                    <!-- Alert validasi PDF/Video Edit -->
                    <div id="alertPdfVideoEdit" class="mp-alert-warn" style="display:none;">
    <i class="bi bi-exclamation-triangle-fill"></i>
    Wajib mengisi salah satu: <strong>upload Dokumen</strong> (PDF/Word/Excel/PPT) atau <strong>pilih Video</strong>.
</div>

                    <!-- TABS Edit -->
                    <div class="mtab-nav" id="tabNavEdit">
                        <button type="button" class="mtab-btn active" data-tab="tab-pre-edit">
                            <i class="bi bi-list-check"></i><span> Pre Test</span>
                        </button>
                        <button type="button" class="mtab-btn" data-tab="tab-pdf-edit">
    <i class="bi bi-file-earmark-arrow-up"></i><span> Dokumen</span>
</button>
                        <button type="button" class="mtab-btn" data-tab="tab-video-edit">
                            <i class="bi bi-play-circle"></i><span> Video</span>
                        </button>
                        <button type="button" class="mtab-btn" data-tab="tab-post-edit">
                            <i class="bi bi-patch-question"></i><span> Post Test</span>
                        </button>
                    </div>

                    <!-- TAB: Pre Test Edit -->
                    <div class="mtab-pane active" id="tab-pre-edit">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <p class="fw-semibold small mb-0">Soal Pre Test</p>
                                <p class="form-text mb-0">Dikerjakan peserta <strong>sebelum</strong> membaca materi.
                                </p>
                            </div>
                            <button type="button" class="btn-add-quiz blue" id="btnAddPreEdit">
                                <i class="bi bi-plus-lg"></i> Tambah Soal
                            </button>
                        </div>
                        <div id="containerPreEdit"></div>
                        <div id="emptyPreEdit" class="text-center py-4" style="color:#9ca3af;font-size:12.5px;">
                            <i class="bi bi-list-check"
                                style="font-size:28px;display:block;color:#bae6fd;margin-bottom:8px;"></i>
                            Belum ada soal pre test.
                        </div>
                    </div>

                    <!-- TAB: Dokumen Edit -->
<div class="mtab-pane" id="tab-pdf-edit">
    <label class="form-label fw-semibold small">
        Upload Dokumen <span class="text-danger">*</span>
        <span class="text-muted fw-normal">(wajib jika tidak ada video)</span>
    </label>

    <div class="d-flex gap-2 flex-wrap mb-3">
        <span class="mbadge mbadge-pdf"><i class="bi bi-file-earmark-pdf-fill"></i> PDF</span>
        <span class="mbadge mbadge-word"><i class="bi bi-file-earmark-word-fill"></i> Word</span>
        <span class="mbadge mbadge-excel"><i class="bi bi-file-earmark-excel-fill"></i> Excel</span>
        <span class="mbadge mbadge-ppt"><i class="bi bi-file-earmark-ppt-fill"></i> PowerPoint</span>
    </div>

    <div id="currentFileEdit" style="display:none;margin-bottom:8px;">
        <span class="current-file-badge">
            <i class="bi bi-file-earmark-fill"></i>
            <span id="currentFileName"></span>
        </span>
        <small class="text-muted ms-2">— upload baru untuk mengganti</small>
    </div>

    <div class="upload-zone" id="dropZoneEdit"
        onclick="document.getElementById('filePdfEdit').click()">
        <input type="file" id="filePdfEdit" name="file_materi"
            accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
        <i class="bi bi-cloud-arrow-up"></i>
        <p class="mb-1"><strong>Klik untuk upload</strong> atau drag &amp; drop</p>
        <p style="font-size:11px;">PDF · Word · Excel · PowerPoint · Maks. 20 MB</p>
        <p class="file-name" id="fileNameEdit" style="display:none;"></p>
    </div>

    <div id="fileTypeBadgeEdit" style="display:none; margin-top:8px;"></div>
</div>

                    <!-- TAB: Video Edit (Video Lokal Terenkripsi) -->
                    <div class="mtab-pane" id="tab-video-edit">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <label class="form-label fw-semibold small mb-0">
                                Video Lokal Terenkripsi <span class="text-danger">*</span>
                                <span class="text-muted fw-normal">(wajib jika tidak ada PDF)</span>
                            </label>
                            <a href="<?= base_url('dashboard/pengajar/video/upload') ?>" target="_blank"
                                class="d-inline-flex align-items-center gap-1 px-2 py-1 rounded-2 text-decoration-none fw-semibold"
                                style="background:#f0fdf4;color:#059669;font-size:11px;white-space:nowrap;">
                                <i class="bi bi-cloud-arrow-up"></i> Upload Video Baru
                            </a>
                        </div>

                        <div class="input-group mb-1">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-shield-lock-fill text-success"></i>
                            </span>
                            <select class="form-select border-start-0" name="video_url_materi" id="videoSelectEdit">
                                <option value="">-- Pilih Video --</option>
                            </select>
                            <button type="button" class="btn btn-outline-secondary btn-sm"
                                onclick="loadVideoOptions('videoSelectEdit', 'videoInfoEdit', 'videoInfoTextEdit')"
                                title="Refresh daftar video">
                                <i class="bi bi-arrow-clockwise"></i>
                            </button>
                        </div>

                        <div id="videoInfoEdit" class="vid-info-box">
                            <i class="bi bi-shield-check-fill"></i>
                            <span id="videoInfoTextEdit"></span>
                        </div>

                        <div class="mt-2">
                            <p class="form-text mb-1">Atau masukkan Video ID secara manual:</p>
                            <input type="text" class="form-control form-control-sm" id="videoManualEdit"
                                placeholder="cth: vid_abc123def456..."
                                oninput="syncManual('videoSelectEdit','videoManualEdit','videoInfoEdit','videoInfoTextEdit')">
                        </div>
                    </div>

                    <!-- TAB: Post Test Edit -->
                    <div class="mtab-pane" id="tab-post-edit">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <div>
                                <p class="fw-semibold small mb-0">Soal Post Test</p>
                                <p class="form-text mb-0">Dikerjakan peserta <strong>setelah</strong> membaca materi.
                                </p>
                            </div>
                            <button type="button" class="btn-add-quiz" id="btnAddPostEdit">
                                <i class="bi bi-plus-lg"></i> Tambah Soal
                            </button>
                        </div>
                        <div id="containerPostEdit"></div>
                        <div id="emptyPostEdit" class="text-center py-4" style="color:#9ca3af;font-size:12.5px;">
                            <i class="bi bi-patch-question"
                                style="font-size:28px;display:block;color:#ddd6fe;margin-bottom:8px;"></i>
                            Belum ada soal post test.
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3 mt-3">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning px-4 fw-semibold">
                            <i class="bi bi-save me-1"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════
     MODAL PREVIEW
════════════════════════════════════════ -->
<div class="modal fade" id="modalPreview" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-eye-fill text-primary me-2"></i>
                    <span id="previewJudul"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4 pt-3 pb-4">
                <!-- PRE TEST -->
                <div class="quiz-preview-wrap" id="previewPreWrap">
                    <div class="quiz-preview-label pre"><i class="bi bi-list-check"></i> Pre Test</div>
                    <div id="previewPreList"></div>
                </div>
                <!-- PDF -->
                <div id="previewPdfWrap" style="display:none;" class="mb-3">
                    <a id="previewPdfLink" href="#" target="_blank"
                        class="d-inline-flex align-items-center gap-2 px-3 py-2 rounded-3 text-decoration-none fw-semibold"
                        style="background:#fff1f2;color:#e11d48;font-size:13px;">
                        <i class="bi bi-file-earmark-pdf-fill"></i> Buka File PDF
                    </a>
                </div>
                <!-- Video (Lokal) -->
                <div id="previewVideoWrap" style="display:none;" class="mb-3">
                    <div class="p-3 rounded-3 d-flex align-items-center gap-3"
                        style="background:#f0fdf4;border:1px solid #bbf7d0;">
                        <i class="bi bi-shield-lock-fill text-success fs-4"></i>
                        <div>
                            <div class="fw-bold" style="font-size:13px;">Video Lokal Terenkripsi</div>
                            <div style="font-size:11.5px;color:#6b7280;" id="previewVideoId"></div>
                        </div>
                        <a id="previewVideoLink" href="#" target="_blank" class="ms-auto btn btn-sm btn-success">
                            <i class="bi bi-play-fill me-1"></i> Play
                        </a>
                    </div>
                </div>
                <!-- POST TEST -->
                <div class="quiz-preview-wrap" id="previewPostWrap" style="display:none;">
                    <div class="quiz-preview-label post"><i class="bi bi-patch-question-fill"></i> Post Test</div>
                    <div id="previewPostList"></div>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 px-4">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<!-- MODAL HAPUS -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-body text-center py-4 px-4">
                <div class="mb-3">
                    <span
                        class="d-inline-flex align-items-center justify-content-center rounded-circle bg-danger bg-opacity-10"
                        style="width:62px;height:62px;">
                        <i class="bi bi-trash-fill text-danger" style="font-size:24px;"></i>
                    </span>
                </div>
                <h6 class="fw-bold mb-1">Hapus Materi?</h6>
                <p class="text-muted small mb-3">
                    <strong id="hapusJudul"></strong> akan dihapus dan tidak bisa dikembalikan.
                </p>
                <form id="formHapus" method="POST">
                    <?= csrf_field() ?>
                    <div class="d-flex gap-2 justify-content-center">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger px-4 fw-semibold">Ya, Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════
     JAVASCRIPT
════════════════════════════════════════ -->
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const BASE_URL = '<?= base_url('dashboard/pengajar/materi') ?>';
        const BASE_ROOT = '<?= base_url() ?>';

        /* ══════════════════════════════════════
           UTILITY HELPERS
        ══════════════════════════════════════ */
        function esc(str) {
            const d = document.createElement('div');
            d.appendChild(document.createTextNode(str ?? ''));
            return d.innerHTML;
        }

        function escAttr(str) {
            return String(str ?? '')
                .replace(/&/g, '&amp;').replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        }

        function getRowData(rowId) {
            const tr = document.querySelector(`tr[data-id="${rowId}"]`);
            if (!tr) return null;
            return {
                id: tr.dataset.id,
                judul: tr.dataset.judulRaw,
                modul: tr.dataset.modulVal,
                file: tr.dataset.file,
                video: tr.dataset.video,
                preArr: JSON.parse(tr.dataset.pretest || '[]'),
                postArr: JSON.parse(tr.dataset.posttest || '[]'),
            };
        }

        /* ══════════════════════════════════════
    TABLE FILTER (cascade: program → kelas → modul)
 ══════════════════════════════════════ */
        function filterTable() {
            const kw = document.getElementById('searchInput').value.toLowerCase().trim();
            const pid = document.getElementById('filterProgram').value;
            const kid = document.getElementById('filterKelas').value;
            const mid = document.getElementById('filterModul').value;
            const rows = document.querySelectorAll('#tableBody tr[data-id]');
            let vis = 0;

            rows.forEach(row => {
                const ok = row.dataset.judul.includes(kw)
                    && (!pid || row.dataset.program === pid)
                    && (!kid || row.dataset.kelas === kid)
                    && (!mid || row.dataset.modul === mid);
                row.style.display = ok ? '' : 'none';
                if (ok) vis++;
            });

            let n = 1;
            rows.forEach(row => {
                if (row.style.display !== 'none') row.querySelector('.row-num').textContent = n++;
            });

            document.getElementById('visibleCount').textContent = vis;
            document.getElementById('mp-no-results').style.display = vis === 0 ? 'block' : 'none';
            const er = document.getElementById('emptyRow');
            if (er) er.style.display = 'none';
        }

        // Cascade: pilih Program → filter Kelas & Modul
        function cascadeFromProgram() {
            const pid = document.getElementById('filterProgram').value;
            const kSel = document.getElementById('filterKelas');
            const mSel = document.getElementById('filterModul');

            kSel.value = '';
            mSel.value = '';

            Array.from(kSel.options).forEach(opt => {
                if (!opt.value) return;
                opt.hidden = pid ? opt.dataset.program !== pid : false;
            });
            Array.from(mSel.options).forEach(opt => {
                if (!opt.value) return;
                opt.hidden = pid ? opt.dataset.program !== pid : false;
            });

            filterTable();
        }

        // Cascade: pilih Kelas → filter Modul
        function cascadeFromKelas() {
            const pid = document.getElementById('filterProgram').value;
            const kid = document.getElementById('filterKelas').value;
            const mSel = document.getElementById('filterModul');

            mSel.value = '';

            Array.from(mSel.options).forEach(opt => {
                if (!opt.value) return;
                const okProgram = !pid || opt.dataset.program === pid;
                const okKelas = !kid || opt.dataset.kelas === kid;
                opt.hidden = !(okProgram && okKelas);
            });

            filterTable();
        }

        document.getElementById('searchInput').addEventListener('input', filterTable);
        document.getElementById('filterProgram').addEventListener('change', cascadeFromProgram);
        document.getElementById('filterKelas').addEventListener('change', cascadeFromKelas);
        document.getElementById('filterModul').addEventListener('change', filterTable);

        /* ══════════════════════════════════════
           TABS
        ══════════════════════════════════════ */
        function initTabs(navId) {
            const nav = document.getElementById(navId);
            if (!nav) return;
            nav.querySelectorAll('.mtab-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    nav.querySelectorAll('.mtab-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                    const mc = nav.closest('.modal-content');
                    mc.querySelectorAll('.mtab-pane').forEach(p =>
                        p.classList.toggle('active', p.id === this.dataset.tab));
                });
            });
        }
        initTabs('tabNavTambah');
        initTabs('tabNavEdit');
        /* CASCADE Program → Kelas → Modul */
        const allKelas = <?= json_encode($kelas ?? []) ?>;
        const allModul = <?= json_encode($modul ?? []) ?>;

        function populateKelas(programId, kelasSelId) {
            const sel = document.getElementById(kelasSelId);
            sel.innerHTML = '<option value="" disabled selected>-- Pilih Kelas --</option>';
            sel.disabled = true;
            if (!programId) return;
            allKelas.filter(k => String(k.id_program) === String(programId))
                .forEach(k => sel.add(new Option(k.nama_kelas, k.id_kelas)));
            sel.disabled = false;
        }

        function populateModul(kelasId, modulSelId, wrapId) {
            const sel = document.getElementById(modulSelId);
            const wrap = wrapId ? document.getElementById(wrapId) : null;
            sel.innerHTML = '<option value="" disabled selected>-- Pilih Modul --</option>';
            sel.disabled = true;
            if (wrap) wrap.style.display = 'none';
            if (!kelasId) return;
            const list = allModul.filter(m => String(m.id_kelas) === String(kelasId));
            list.forEach(m => {
                const o = new Option(m.judul_modul, m.id_modul);
                o.dataset.kelas = m.id_kelas;
                o.dataset.program = m.id_program;
                sel.add(o);
            });
            if (list.length > 0) { sel.disabled = false; if (wrap) wrap.style.display = 'block'; }
        }

        // Event Tambah
        document.getElementById('tambah_id_program')
            ?.addEventListener('change', function () {
                populateKelas(this.value, 'tambah_id_kelas');
                populateModul(null, 'tambah_id_modul', 'wrapModulTambah');
            });
        document.getElementById('tambah_id_kelas')
            ?.addEventListener('change', function () {
                populateModul(this.value, 'tambah_id_modul', 'wrapModulTambah');
            });

        // Event Edit
        document.getElementById('edit_id_program')
            ?.addEventListener('change', function () {
                populateKelas(this.value, 'edit_id_kelas');
                populateModul(null, 'edit_id_modul', null);
            });
        document.getElementById('edit_id_kelas')
            ?.addEventListener('change', function () {
                populateModul(this.value, 'edit_id_modul', null);
            });

        function resetTabs(navId) {
            const nav = document.getElementById(navId);
            if (!nav) return;
            nav.querySelectorAll('.mtab-btn').forEach((b, i) => b.classList.toggle('active', i === 0));
            nav.closest('.modal-content').querySelectorAll('.mtab-pane').forEach((p, i) =>
                p.classList.toggle('active', i === 0));
        }

        function switchToTab(navId, tabId) {
            const nav = document.getElementById(navId);
            if (!nav) return;
            nav.querySelectorAll('.mtab-btn').forEach(b =>
                b.classList.toggle('active', b.dataset.tab === tabId));
            nav.closest('.modal-content').querySelectorAll('.mtab-pane').forEach(p =>
                p.classList.toggle('active', p.id === tabId));
        }

        /* ══════════════════════════════════════
           PDF DROP ZONES
        ══════════════════════════════════════ */
        function initDropZone(zoneId, inputId, nameId) {
            const zone = document.getElementById(zoneId);
            const input = document.getElementById(inputId);
            const nameEl = document.getElementById(nameId);
            if (!zone) return;

            function setFile(file) {
                nameEl.textContent = file.name;
                nameEl.style.display = 'block';
                zone.classList.add('has-file');
                const dt = new DataTransfer();
                dt.items.add(file);
                input.files = dt.files;
            }

            input.addEventListener('change', () => {
                if (input.files[0]) setFile(input.files[0]);
            });
            zone.addEventListener('dragover', e => {
                e.preventDefault();
                zone.classList.add('dragover');
            });
            zone.addEventListener('dragleave', e => {
                e.preventDefault();
                zone.classList.remove('dragover');
            });
            zone.addEventListener('drop', e => {
                e.preventDefault();
                zone.classList.remove('dragover');
                if (e.dataTransfer.files[0]) setFile(e.dataTransfer.files[0]);
            });
        }
        initDropZone('dropZoneTambah', 'filePdfTambah', 'fileNameTambah');
        initDropZone('dropZoneEdit', 'filePdfEdit', 'fileNameEdit');

        /* ══════════════════════════════════════
   DETEKSI TIPE FILE — tampilkan badge
══════════════════════════════════════ */
function getFileIcon(filename) {
    const ext = filename.split('.').pop().toLowerCase();
    const map = {
        pdf:  { icon: 'bi-file-earmark-pdf-fill',   cls: 'mbadge-pdf',   label: 'PDF' },
        doc:  { icon: 'bi-file-earmark-word-fill',   cls: 'mbadge-word',  label: 'Word' },
        docx: { icon: 'bi-file-earmark-word-fill',   cls: 'mbadge-word',  label: 'Word' },
        xls:  { icon: 'bi-file-earmark-excel-fill',  cls: 'mbadge-excel', label: 'Excel' },
        xlsx: { icon: 'bi-file-earmark-excel-fill',  cls: 'mbadge-excel', label: 'Excel' },
        ppt:  { icon: 'bi-file-earmark-ppt-fill',    cls: 'mbadge-ppt',   label: 'PowerPoint' },
        pptx: { icon: 'bi-file-earmark-ppt-fill',    cls: 'mbadge-ppt',   label: 'PowerPoint' },
    };
    return map[ext] ?? { icon: 'bi-file-earmark-fill', cls: 'mbadge-pdf', label: ext.toUpperCase() };
}

function showFileTypeBadge(badgeId, filename, sizeByte) {
    const el = document.getElementById(badgeId);
    if (!el) return;
    const info = getFileIcon(filename);
    const sizeMB = (sizeByte / 1048576).toFixed(2);
    el.innerHTML = `
        <span class="mbadge ${info.cls}">
            <i class="bi ${info.icon}"></i> ${info.label}
        </span>
        <span style="font-size:11px;color:#6b7280;margin-left:6px;">
            ${esc(filename)} · ${sizeMB} MB
        </span>`;
    el.style.display = 'block';
}

// Bind ke input file Tambah
document.getElementById('filePdfTambah').addEventListener('change', function () {
    if (this.files[0]) {
        showFileTypeBadge('fileTypeBadgeTambah', this.files[0].name, this.files[0].size);
        document.getElementById('alertPdfVideoTambah').style.display = 'none';
    }
});

// Bind ke input file Edit
document.getElementById('filePdfEdit').addEventListener('change', function () {
    if (this.files[0]) {
        showFileTypeBadge('fileTypeBadgeEdit', this.files[0].name, this.files[0].size);
        document.getElementById('alertPdfVideoEdit').style.display = 'none';
    }
});

        /* ══════════════════════════════════════
           VIDEO LOKAL — LOAD OPTIONS
        ══════════════════════════════════════ */
        let _videoCache = [];

        function fmtSz(b) {
            if (b >= 1048576) return (b / 1048576).toFixed(1) + ' MB';
            if (b >= 1024) return (b / 1024).toFixed(0) + ' KB';
            return b + ' B';
        }

        window.loadVideoOptions = async function (selectId, infoId, infoTextId) {
            const sel = document.getElementById(selectId);
            if (!sel) return;
            const currentVal = sel.value;
            sel.innerHTML = '<option value="">Memuat...</option>';
            try {
                const res = await fetch(BASE_ROOT + 'dashboard/pengajar/video/list');
                const data = await res.json();
                if (!data.success || !data.data.length) {
                    sel.innerHTML = '<option value="">-- Belum ada video. Upload dulu! --</option>';
                    return;
                }
                _videoCache = data.data;
                sel.innerHTML = '<option value="">-- Pilih Video --</option>' +
                    data.data.map(v =>
                        `<option value="${v.video_id}">${esc(v.judul_video)} (${fmtSz(v.size)})</option>`
                    ).join('');
                // Kembalikan value sebelumnya jika ada
                if (currentVal) {
                    const found = Array.from(sel.options).some(o => o.value === currentVal);
                    if (found) {
                        sel.value = currentVal;
                    } else {
                        const opt = new Option('Manual: ' + currentVal, currentVal, true, true);
                        sel.add(opt);
                    }
                    updateVideoInfo(selectId, infoId, infoTextId);
                }
            } catch (e) {
                sel.innerHTML = '<option value="">-- Gagal memuat daftar video --</option>';
            }
        };

        window.syncManual = function (selId, inputId, infoId, infoTextId) {
            const val = document.getElementById(inputId).value.trim();
            const sel = document.getElementById(selId);
            if (!sel) return;
            if (!val) {
                sel.value = '';
                updateVideoInfo(selId, infoId, infoTextId);
                return;
            }
            let found = false;
            for (const opt of sel.options) {
                if (opt.value === val) {
                    opt.selected = true;
                    found = true;
                    break;
                }
            }
            if (!found) {
                // Hapus option manual sebelumnya jika ada
                Array.from(sel.options).forEach(o => {
                    if (o.dataset.manual) o.remove();
                });
                const opt = new Option('Manual: ' + val, val, true, true);
                opt.dataset.manual = '1';
                sel.add(opt);
            }
            updateVideoInfo(selId, infoId, infoTextId);
        };

        function updateVideoInfo(selId, infoId, infoTextId) {
            const sel = document.getElementById(selId);
            const infoBox = document.getElementById(infoId);
            const infoTxt = document.getElementById(infoTextId);
            if (!sel || !infoBox) return;
            if (sel.value) {
                const vid = _videoCache.find(v => v.video_id === sel.value);
                infoTxt.textContent = vid ?
                    `${vid.judul_video} · ${fmtSz(vid.size)} · ID: ${vid.video_id}` :
                    `Video ID: ${sel.value}`;
                infoBox.classList.add('show');
            } else {
                infoBox.classList.remove('show');
            }
        }

        // Bind change event pada select
        ['videoSelectTambah', 'videoSelectEdit'].forEach(selId => {
            const el = document.getElementById(selId);
            if (!el) return;
            const suffix = selId.includes('Tambah') ? 'Tambah' : 'Edit';
            el.addEventListener('change', () =>
                updateVideoInfo(selId, 'videoInfo' + suffix, 'videoInfoText' + suffix));
        });

        // Load options saat modal Tambah dibuka
        document.getElementById('modalTambah')?.addEventListener('show.bs.modal', () => {
            loadVideoOptions('videoSelectTambah', 'videoInfoTambah', 'videoInfoTextTambah');
        });

        /* ══════════════════════════════════════
           QUIZ / SOAL BUILDER
        ══════════════════════════════════════ */
        const counters = {};

        function buildSoalHtml(fieldName, containerId, num, isPre, data) {
            const pertanyaan = data?.pertanyaan ?? '';
            const pilihan = data?.pilihan ?? ['', '', '', ''];
            const jawaban = data?.jawaban_benar ?? 0;
            const uid = `${containerId}-s${num}`;
            const itemClass = isPre ? 'is-pretest' : 'is-posttest';
            const rowClass = isPre ? 'is-pretest' : 'is-posttest';
            const label = isPre ? 'Pre' : 'Post';

            const choices = [0, 1, 2, 3].map(c => `
            <div class="choice-row ${rowClass}">
                <input type="radio"
                    name="${fieldName}[${num}][jawaban_benar]"
                    value="${c}"
                    ${jawaban == c ? 'checked' : ''}>
                <input type="text" class="form-control"
                    name="${fieldName}[${num}][pilihan][${c}]"
                    value="${escAttr(pilihan[c] ?? '')}"
                    placeholder="Pilihan ${String.fromCharCode(65 + c)}"
                    required>
            </div>`).join('');

            return `
        <div class="quiz-item ${itemClass}" id="${uid}">
            <span class="quiz-num">${label} Soal ${num}</span>
            <button type="button" class="quiz-remove"
                onclick="removeSoal('${uid}','${containerId}','${containerId.replace('container', 'empty')}')">
                <i class="bi bi-x"></i>
            </button>
            <div class="mb-2 mt-2">
                <input type="text" class="form-control form-control-sm"
                    name="${fieldName}[${num}][pertanyaan]"
                    value="${escAttr(pertanyaan)}"
                    placeholder="Tulis pertanyaan soal..." required>
            </div>
            ${choices}
            <div class="form-text mt-1">
                <i class="bi bi-info-circle me-1"></i>Centang radio = jawaban benar
            </div>
        </div>`;
        }

        window.removeSoal = function (itemId, containerId, emptyId) {
            const el = document.getElementById(itemId);
            if (el) el.remove();
            checkEmpty(containerId, emptyId);
        };

        function checkEmpty(containerId, emptyId) {
            const c = document.getElementById(containerId);
            const e = document.getElementById(emptyId);
            if (!c || !e) return;
            e.style.display = c.querySelectorAll('.quiz-item').length === 0 ? 'block' : 'none';
        }

        function addSoal(fieldName, containerId, emptyId, isPre) {
            if (!counters[containerId]) counters[containerId] = 0;
            counters[containerId]++;
            const html = buildSoalHtml(fieldName, containerId, counters[containerId], isPre, null);
            document.getElementById(containerId).insertAdjacentHTML('beforeend', html);
            checkEmpty(containerId, emptyId);
        }

        function populateSoal(fieldName, containerId, emptyId, isPre, soalArr) {
            counters[containerId] = 0;
            document.getElementById(containerId).innerHTML = '';
            if (!Array.isArray(soalArr) || soalArr.length === 0) {
                checkEmpty(containerId, emptyId);
                return;
            }
            soalArr.forEach((soal, idx) => {
                counters[containerId] = idx + 1;
                const html = buildSoalHtml(fieldName, containerId, idx + 1, isPre, soal);
                document.getElementById(containerId).insertAdjacentHTML('beforeend', html);
            });
            checkEmpty(containerId, emptyId);
        }

        document.getElementById('btnAddPreTambah').addEventListener('click', () => addSoal('pre_test', 'containerPreTambah', 'emptyPreTambah', true));
        document.getElementById('btnAddPostTambah').addEventListener('click', () => addSoal('post_test', 'containerPostTambah', 'emptyPostTambah', false));
        document.getElementById('btnAddPreEdit').addEventListener('click', () => addSoal('pre_test', 'containerPreEdit', 'emptyPreEdit', true));
        document.getElementById('btnAddPostEdit').addEventListener('click', () => addSoal('post_test', 'containerPostEdit', 'emptyPostEdit', false));

        /* ══════════════════════════════════════
           RENDER QUIZ LIST (Preview modal)
        ══════════════════════════════════════ */
        function renderQuizList(containerId, soalArr, isPre) {
            const wrap = document.getElementById(containerId);
            if (!Array.isArray(soalArr) || soalArr.length === 0) {
                wrap.innerHTML = `<p class="no-soal">Tidak ada soal.</p>`;
                return;
            }
            const cls = isPre ? 'pre' : 'post';
            let html = `<ul class="quiz-preview-list ${cls}">`;
            soalArr.forEach((s, i) => {
                html += `<li><span class="q-num ${cls}">Q${i + 1}.</span> ${esc(s.pertanyaan)}<ul class="choice-list">`;
                (s.pilihan || []).forEach((p, pi) => {
                    const isCorrect = pi == s.jawaban_benar;
                    html += `<li class="${isCorrect ? 'correct' : ''}">${isCorrect ? '✓' : String.fromCharCode(65 + pi) + '.'} ${esc(p)}</li>`;
                });
                html += `</ul></li>`;
            });
            html += `</ul>`;
            wrap.innerHTML = html;
        }

        /* ══════════════════════════════════════
           PREVIEW MODAL
        ══════════════════════════════════════ */
        document.querySelectorAll('.btn-preview').forEach(btn => {
            btn.addEventListener('click', function () {
                const d = getRowData(this.dataset.rowId);
                if (!d) return;

                document.getElementById('previewJudul').textContent = d.judul;

                renderQuizList('previewPreList', d.preArr, true);
                document.getElementById('previewPreWrap').style.display = d.preArr.length > 0 ? 'block' : 'none';

                const pdfWrap = document.getElementById('previewPdfWrap');
                if (d.file) {
                    document.getElementById('previewPdfLink').href = BASE_ROOT + '/' + d.file;
                    pdfWrap.style.display = 'block';
                } else {
                    pdfWrap.style.display = 'none';
                }

                // Video lokal
                const vidWrap = document.getElementById('previewVideoWrap');
                if (d.video) {
                    document.getElementById('previewVideoId').textContent = 'ID: ' + d.video;
                    document.getElementById('previewVideoLink').href = BASE_ROOT + 'video/player?id=' + d.video;
                    vidWrap.style.display = 'block';
                } else {
                    vidWrap.style.display = 'none';
                }

                if (d.postArr.length > 0) {
                    renderQuizList('previewPostList', d.postArr, false);
                    document.getElementById('previewPostWrap').style.display = 'block';
                } else {
                    document.getElementById('previewPostList').innerHTML = '';
                    document.getElementById('previewPostWrap').style.display = 'none';
                }

                new bootstrap.Modal(document.getElementById('modalPreview')).show();
            });
        });

        /* ══════════════════════════════════════
           EDIT MODAL
        ══════════════════════════════════════ */
        document.querySelectorAll('.btn-edit-materi').forEach(btn => {
            btn.addEventListener('click', async function () {
            const d = getRowData(this.dataset.rowId);
            if (!d) return;
    
            document.getElementById('formEdit').action = `${BASE_URL}/update/${d.id}`;
            document.getElementById('edit_judul_materi').value = d.judul;
    
            const editRow = document.querySelector(`tr[data-id="${this.dataset.rowId}"]`);
            const rowProgram = editRow?.dataset.program;
            const rowKelas   = editRow?.dataset.kelas;
    
            const progSel = document.getElementById('edit_id_program');
            if (progSel && rowProgram) {
                progSel.value = rowProgram;
    
                // populate kelas lalu set value
                populateKelas(rowProgram, 'edit_id_kelas');
                const kelasSel = document.getElementById('edit_id_kelas');
                if (kelasSel) kelasSel.value = rowKelas;
    
                // populate modul lalu SET VALUE modul yang sedang diedit
                populateModul(rowKelas, 'edit_id_modul', null);
                document.getElementById('edit_id_modul').value = d.modul; // ← INI YANG KURANG
            }

                const cfDiv = document.getElementById('currentFileEdit');
                const cfName = document.getElementById('currentFileName');
                if (d.file) {
                    cfName.textContent = d.file.split('/').pop();
                    cfDiv.style.display = 'block';
                } else {
                    cfDiv.style.display = 'none';
                }
                document.getElementById('fileNameEdit').style.display = 'none';
                document.getElementById('dropZoneEdit').classList.remove('has-file');
                document.getElementById('alertPdfVideoEdit').style.display = 'none';

                // Load video options dan set value
                await loadVideoOptions('videoSelectEdit', 'videoInfoEdit', 'videoInfoTextEdit');
                const vSel = document.getElementById('videoSelectEdit');
                const vMan = document.getElementById('videoManualEdit');
                if (d.video) {
                    vMan.value = d.video;
                    syncManual('videoSelectEdit', 'videoManualEdit', 'videoInfoEdit', 'videoInfoTextEdit');
                } else {
                    if (vSel) vSel.value = '';
                    if (vMan) vMan.value = '';
                    document.getElementById('videoInfoEdit').classList.remove('show');
                }

                populateSoal('pre_test', 'containerPreEdit', 'emptyPreEdit', true, d.preArr);
                populateSoal('post_test', 'containerPostEdit', 'emptyPostEdit', false, d.postArr);

                resetTabs('tabNavEdit');
                new bootstrap.Modal(document.getElementById('modalEdit')).show();
            });
        });

        /* ══════════════════════════════════════
           HAPUS MODAL
        ══════════════════════════════════════ */
        document.querySelectorAll('.btn-hapus-materi').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('formHapus').action = `${BASE_URL}/delete/${this.dataset.rowId}`;
                document.getElementById('hapusJudul').textContent = this.dataset.judulRaw;
                new bootstrap.Modal(document.getElementById('modalHapus')).show();
            });
        });

        /* ══════════════════════════════════════
           VALIDASI: PDF atau VIDEO wajib salah satu
        ══════════════════════════════════════ */
        document.getElementById('formTambah').addEventListener('submit', function (e) {
            const hasFile = document.getElementById('filePdfTambah')?.files?.length > 0;
            const hasVideo = document.getElementById('videoSelectTambah')?.value.trim() !== '';
            const alertEl = document.getElementById('alertPdfVideoTambah');
            if (!hasFile && !hasVideo) {
                e.preventDefault();
                e.stopPropagation();
                alertEl.style.display = 'flex';
                switchToTab('tabNavTambah', 'tab-pdf-tambah');
                alertEl.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            } else {
                alertEl.style.display = 'none';
            }
        });
        document.getElementById('filePdfTambah').addEventListener('change', function () {
            if (this.files.length > 0) document.getElementById('alertPdfVideoTambah').style.display = 'none';
        });
        document.getElementById('videoSelectTambah').addEventListener('change', function () {
            if (this.value) document.getElementById('alertPdfVideoTambah').style.display = 'none';
        });

        document.getElementById('formEdit').addEventListener('submit', function (e) {
            const fileInput = document.getElementById('filePdfEdit');
            const currentFile = document.getElementById('currentFileEdit');
            const hasNewFile = fileInput?.files?.length > 0;
            const hasOldFile = currentFile?.style.display !== 'none';
            const hasVideo = document.getElementById('videoSelectEdit')?.value.trim() !== '';
            const alertEl = document.getElementById('alertPdfVideoEdit');
            if (!hasNewFile && !hasOldFile && !hasVideo) {
                e.preventDefault();
                e.stopPropagation();
                alertEl.style.display = 'flex';
                switchToTab('tabNavEdit', 'tab-pdf-edit');
                alertEl.scrollIntoView({
                    behavior: 'smooth',
                    block: 'center'
                });
            } else {
                alertEl.style.display = 'none';
            }
        });
        document.getElementById('filePdfEdit').addEventListener('change', function () {
            if (this.files.length > 0) document.getElementById('alertPdfVideoEdit').style.display = 'none';
        });
        document.getElementById('videoSelectEdit').addEventListener('change', function () {
            if (this.value) document.getElementById('alertPdfVideoEdit').style.display = 'none';
        });

        /* ══════════════════════════════════════
           AUTO-DISMISS ALERTS
        ══════════════════════════════════════ */
        document.querySelectorAll('.mp-alert').forEach(el => {
            setTimeout(() => {
                el.style.transition = 'opacity .4s';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 400);
            }, 4500);
        });

        /* Reset form Tambah saat modal ditutup */
        document.getElementById('modalTambah')?.addEventListener('hidden.bs.modal', () => {
            document.getElementById('containerPreTambah').innerHTML = '';
            document.getElementById('containerPostTambah').innerHTML = '';
            checkEmpty('containerPreTambah', 'emptyPreTambah');
            checkEmpty('containerPostTambah', 'emptyPostTambah');
            counters['containerPreTambah'] = 0;
            counters['containerPostTambah'] = 0;
            resetTabs('tabNavTambah');
            document.getElementById('fileNameTambah').style.display = 'none';
            document.getElementById('dropZoneTambah').classList.remove('has-file');
            document.getElementById('alertPdfVideoTambah').style.display = 'none';
            document.getElementById('videoSelectTambah').value = '';
            document.getElementById('videoManualTambah').value = '';
            document.getElementById('videoInfoTambah').classList.remove('show');
            document.getElementById('tambah_id_program').value = '';
            const kSel = document.getElementById('tambah_id_kelas');
            kSel.innerHTML = '<option value="" disabled selected>-- Pilih Kelas --</option>';
            kSel.disabled = true;
            document.getElementById('wrapModulTambah').style.display = 'none';
        });
        
        document.getElementById('formTambah')
            ?.querySelector('[type="submit"]')
            ?.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('formTambah').requestSubmit();
            });

    });
</script>

<?= $this->endSection() ?>
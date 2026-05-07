<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>
<?= $this->section('content') ?>

<style>
/* ─── ROOT ─── */
.tp-root {
    font-family: 'Plus Jakarta Sans', sans-serif;
    padding-bottom: 2.5rem;
    color: #111827;
}

/* ─── PAGE HEADER ─── */
.tp-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
    margin-bottom: 1.75rem;
}
.tp-header-left h1 {
    font-size: 20px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 4px;
    letter-spacing: -0.3px;
}
.tp-header-left p {
    font-size: 13px;
    color: #6b7280;
    margin: 0;
}
.tp-header-left p strong {
    font-weight: 600;
    color: #374151;
}

/* ─── TOMBOL ─── */
.btn-back-tp {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 15px;
    border-radius: 10px;
    font-size: 12.5px;
    font-weight: 600;
    font-family: 'Plus Jakarta Sans', sans-serif;
    border: 1px solid #e5e7eb;
    background: #fff;
    color: #374151;
    text-decoration: none;
    transition: all 0.15s;
}
.btn-back-tp:hover {
    background: #f9fafb;
    border-color: #d1d5db;
    color: #111827;
    text-decoration: none;
}

/* ─── BANNER INFO TUGAS ─── */
.tp-banner {
    background: #f9fafb;
    border: 1px solid #f0f0f0;
    border-radius: 16px;
    padding: 16px 20px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    flex-wrap: wrap;
}
.tp-banner-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.tp-banner-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: #111827;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 18px;
    flex-shrink: 0;
}
.tp-banner-name {
    font-size: 14px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 3px;
}
.tp-banner-meta {
    font-size: 12px;
    color: #9ca3af;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 8px;
}
.tp-count-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 99px;
    font-size: 12px;
    font-weight: 700;
    background: #eff6ff;
    color: #1d4ed8;
    border: 1px solid #bfdbfe;
    white-space: nowrap;
}

/* ─── KARTU PENGUMPULAN ─── */
.tp-card {
    background: #fff;
    border: 1px solid #f0f0f0;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 16px;
    transition: box-shadow 0.2s, border-color 0.2s;
}
.tp-card:hover {
    box-shadow: 0 6px 24px rgba(0,0,0,.06);
    border-color: #e5e7eb;
}

/* ── KEPALA KARTU ── */
.tp-card-head {
    padding: 14px 20px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    background: #f9fafb;
    border-bottom: 1px solid #f0f0f0;
}
.tp-peserta-info {
    display: flex;
    align-items: center;
    gap: 10px;
}
.tp-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: #111827;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    flex-shrink: 0;
}
.tp-peserta-name {
    font-size: 13.5px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 2px;
}
.tp-peserta-email {
    font-size: 11.5px;
    color: #9ca3af;
}

/* ── BADGE STATUS ── */
.tp-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 11px;
    border-radius: 99px;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
    flex-shrink: 0;
}
.badge-terkirim { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
.badge-pending  { background:#fef9c3; color:#854d0e; border:1px solid #fde68a; }
.badge-ditolak  { background:#fef2f2; color:#b91c1c; border:1px solid #fecaca; }
.badge-default  { background:#f3f4f6; color:#374151; border:1px solid #e5e7eb; }

/* ── BADAN KARTU ── */
.tp-card-body {
    padding: 16px 20px;
}
.tp-meta-grid {
    display: flex;
    gap: 28px;
    flex-wrap: wrap;
    margin-bottom: 16px;
}
.tp-meta-item { display: flex; flex-direction: column; gap: 3px; }
.tp-meta-label {
    font-size: 10.5px;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: .5px;
}
.tp-meta-val {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    display: flex;
    align-items: center;
    gap: 5px;
}
.tp-meta-val i { font-size: 12px; color: #9ca3af; }

/* ── TOMBOL LIHAT FILE ── */
.btn-lihat-file {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 14px;
    border-radius: 10px;
    font-size: 12.5px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: rgba(37,99,235,.08);
    color: #2563eb;
    border: 1px solid rgba(37,99,235,.2);
    text-decoration: none;
    transition: all 0.15s;
}
.btn-lihat-file:hover {
    background: #2563eb;
    color: #fff;
    border-color: #2563eb;
    text-decoration: none;
}

/* ─── AREA KOMENTAR ─── */
.tp-komentar-wrap {
    border-top: 1px solid #f3f4f6;
    padding-top: 14px;
    margin-top: 4px;
}
.tp-komentar-title {
    font-size: 10.5px;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: .5px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 5px;
}

/* bubble komentar */
.tp-km-item {
    display: flex;
    gap: 10px;
    margin-bottom: 10px;
}
.tp-km-avatar {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: #111827;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: 700;
    flex-shrink: 0;
    margin-top: 2px;
}
.tp-km-bubble {
    background: #f3f4f6;
    border-radius: 0 10px 10px 10px;
    padding: 8px 12px;
    flex: 1;
}
.tp-km-name {
    font-size: 11px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 3px;
}
.tp-km-text {
    font-size: 12.5px;
    color: #374151;
    line-height: 1.55;
}
.tp-km-time {
    font-size: 10.5px;
    color: #9ca3af;
    margin-top: 4px;
}

/* form komentar */
.tp-km-form {
    display: flex;
    gap: 8px;
    margin-top: 10px;
    align-items: flex-end;
}
.tp-km-form textarea {
    border-radius: 10px;
    font-size: 13px;
    resize: none;
    border: 1px solid #e5e7eb;
    padding: 8px 12px;
    flex: 1;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.tp-km-form textarea:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99,102,241,.1);
}
.btn-kirim-km {
    padding: 8px 16px;
    border-radius: 10px;
    border: none;
    background: #111827;
    color: #fff;
    font-size: 12.5px;
    font-weight: 700;
    font-family: 'Plus Jakarta Sans', sans-serif;
    cursor: pointer;
    white-space: nowrap;
    transition: background 0.15s;
    display: flex;
    align-items: center;
    gap: 5px;
}
.btn-kirim-km:hover { background: #1f2937; }

/* ─── EMPTY STATE ─── */
.tp-empty {
    text-align: center;
    padding: 72px 24px;
    background: #fff;
    border-radius: 20px;
    border: 1px solid #f0f0f0;
}
.tp-empty-icon { font-size: 42px; color: #d1d5db; margin-bottom: 14px; }
.tp-empty-title { font-size: 16px; font-weight: 800; color: #374151; margin-bottom: 6px; }
.tp-empty-desc  { font-size: 13px; color: #9ca3af; line-height: 1.6; }

/* ─── RESPONSIVE ─── */
@media (max-width: 576px) {
    .tp-header { flex-direction: column; }
    .tp-meta-grid { gap: 16px; }
    .tp-card-head { flex-direction: column; align-items: flex-start; }
    .tp-km-form { flex-direction: column; }
    .btn-kirim-km { width: 100%; justify-content: center; }
}
</style>

<div class="tp-root">

    <!-- ── HEADER ── -->
    <div class="tp-header">
        <div class="tp-header-left">
            <h1>Daftar Pengumpulan</h1>
            <p>Tugas: <strong><?= esc($tugas['judul_tugas']) ?></strong>
                — <?= count($pengumpulan) ?> peserta telah mengumpulkan</p>
        </div>
        <a href="<?= base_url('dashboard/pengajar/tugas') ?>" class="btn-back-tp">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i><?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php endif ?>

    <!-- ── BANNER INFO TUGAS ── -->
    <div class="tp-banner">
        <div class="tp-banner-left">
            <div class="tp-banner-icon">
                <i class="bi bi-file-earmark-text"></i>
            </div>
            <div>
                <div class="tp-banner-name"><?= esc($tugas['judul_tugas']) ?></div>
                <div class="tp-banner-meta">
                    <?php if (!empty($tugas['nama_kelas'])): ?>
                    <span><i class="bi bi-building"></i> <?= esc($tugas['nama_kelas']) ?></span>
                    <span style="color:#e5e7eb">·</span>
                    <?php endif ?>
                    <?php if (!empty($tugas['judul_modul'])): ?>
                    <span><i class="bi bi-layers"></i> <?= esc($tugas['judul_modul']) ?></span>
                    <?php endif ?>
                </div>
            </div>
        </div>
        <?php if (!empty($pengumpulan)): ?>
        <div class="tp-count-pill">
            <i class="bi bi-people"></i>
            <?= count($pengumpulan) ?> Pengumpulan
        </div>
        <?php endif ?>
    </div>

    <?php if (empty($pengumpulan)): ?>

    <!-- ── KOSONG ── -->
    <div class="tp-empty">
        <div class="tp-empty-icon"><i class="bi bi-inbox"></i></div>
        <div class="tp-empty-title">Belum ada pengumpulan</div>
        <div class="tp-empty-desc">Belum ada peserta yang mengumpulkan tugas ini.</div>
    </div>

    <?php else: ?>

    <?php foreach ($pengumpulan as $item):
        $statusLower = strtolower($item['status'] ?? '');
        if (str_contains($statusLower, 'terkirim') || str_contains($statusLower, 'diterima')) {
            $bc = 'badge-terkirim'; $bi = 'bi-check-circle-fill';
        } elseif (str_contains($statusLower, 'tolak') || str_contains($statusLower, 'ditolak')) {
            $bc = 'badge-ditolak'; $bi = 'bi-x-circle-fill';
        } elseif (str_contains($statusLower, 'pending') || str_contains($statusLower, 'menunggu')) {
            $bc = 'badge-pending'; $bi = 'bi-hourglass-split';
        } else {
            $bc = 'badge-default'; $bi = 'bi-circle';
        }
    ?>

    <div class="tp-card">

        <!-- KEPALA: nama peserta + status -->
        <div class="tp-card-head">
            <div class="tp-peserta-info">
                <div class="tp-avatar">
                    <?= strtoupper(substr($item['nama_users'], 0, 2)) ?>
                </div>
                <div>
                    <div class="tp-peserta-name"><?= esc($item['nama_users']) ?></div>
                    <div class="tp-peserta-email"><?= esc($item['email']) ?></div>
                </div>
            </div>
            <span class="tp-badge <?= $bc ?>">
                <i class="bi <?= $bi ?>"></i>
                <?= esc($item['status']) ?>
            </span>
        </div>

        <!-- BADAN: meta info -->
        <div class="tp-card-body">
            <div class="tp-meta-grid">
                <div class="tp-meta-item">
                    <div class="tp-meta-label">Waktu Kirim</div>
                    <div class="tp-meta-val">
                        <i class="bi bi-clock"></i>
                        <?= date('d M Y, H:i', strtotime($item['created_at'])) ?> WIB
                    </div>
                </div>
                <div class="tp-meta-item">
                    <div class="tp-meta-label">Tipe Jawaban</div>
                    <div class="tp-meta-val">
                        <i class="bi bi-paperclip"></i>
                        <?= esc($item['tipe_jawaban']) ?>
                    </div>
                </div>
                <?php if (!empty($item['catatan_peserta'])): ?>
                <div class="tp-meta-item">
                    <div class="tp-meta-label">Catatan Peserta</div>
                    <div class="tp-meta-val">
                        <i class="bi bi-chat-left-text"></i>
                        <?= esc($item['catatan_peserta']) ?>
                    </div>
                </div>
                <?php endif ?>
            </div>

            <?php if (!empty($item['link_file'])): ?>
            <div class="mb-3">
                <a href="<?= base_url($item['link_file']) ?>" target="_blank" class="btn-lihat-file">
                    <i class="bi bi-file-earmark-arrow-down"></i> Lihat File
                </a>
            </div>
            <?php endif ?>

            <!-- ── AREA KOMENTAR ── -->
            <div class="tp-komentar-wrap">
                <div class="tp-komentar-title">
                    <i class="bi bi-chat-dots"></i>
                    Komentar (<?= count($item['komentar']) ?>)
                </div>

                <?php if (!empty($item['komentar'])): ?>
                    <?php foreach ($item['komentar'] as $km): ?>
                    <div class="tp-km-item">
                        <div class="tp-km-avatar">
                            <?= strtoupper(substr($km['nama_users'], 0, 2)) ?>
                        </div>
                        <div class="tp-km-bubble">
                            <div class="tp-km-name"><?= esc($km['nama_users']) ?></div>
                            <div class="tp-km-text"><?= esc($km['komentar']) ?></div>
                            <div class="tp-km-time">
                                <?= date('d M Y, H:i', strtotime($km['created_at'])) ?> WIB
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                <?php else: ?>
                    <p style="font-size:12.5px;color:#9ca3af;margin-bottom:10px;">
                        Belum ada komentar untuk pengumpulan ini.
                    </p>
                <?php endif ?>

                <!-- Form tambah komentar -->
                <form action="<?= base_url('dashboard/pengajar/tugas/komentar/simpan') ?>" method="POST">
                    <?= csrf_field() ?>
                    <input type="hidden" name="id_pengumpulan" value="<?= $item['id_pengumpulan'] ?>">
                    <input type="hidden" name="id_tugas" value="<?= $tugas['id_tugas'] ?>">
                    <div class="tp-km-form">
                        <textarea name="komentar" rows="2"
                            placeholder="Tulis komentar untuk <?= esc($item['nama_users']) ?>..."
                            required></textarea>
                        <button type="submit" class="btn-kirim-km">
                            <i class="bi bi-send"></i> Kirim
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <?php endforeach ?>
    <?php endif ?>

</div>

<?= $this->endSection() ?>
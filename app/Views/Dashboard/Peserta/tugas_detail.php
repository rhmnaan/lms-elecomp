<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('meta') ?>
<title><?= esc($tugas['judul_tugas']) ?> — LMS Elecomp</title>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
.td-root {
    font-family: 'Plus Jakarta Sans', sans-serif;
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.td-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 2rem;
}

.td-header-back {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    background: #f3f4f6;
    color: #374151;
    text-decoration: none;
    border: 1.5px solid #e5e7eb;
    transition: all 0.2s;
}

.td-header-back:hover {
    background: #e5e7eb;
    color: #111827;
    text-decoration: none;
}

.td-title {
    font-size: 24px;
    font-weight: 800;
    color: #111827;
    margin: 0;
}

.td-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 16px;
    padding: 24px;
    margin-bottom: 24px;
}

.td-section-title {
    font-size: 16px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 16px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.td-section-title i {
    font-size: 18px;
    color: #7c3aed;
}

.td-meta-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    margin-bottom: 16px;
}

.td-meta-item {
    padding: 12px 0;
}

.td-meta-label {
    font-size: 11px;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.td-meta-value {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
}

.td-desc {
    background: #f9fafb;
    border: 1px solid #f0f0f0;
    border-radius: 12px;
    padding: 16px;
    font-size: 14px;
    color: #374151;
    line-height: 1.6;
}

.td-form {
    margin-top: 24px;
}

.td-form-group {
    margin-bottom: 20px;
}

.td-form-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.td-form-input,
.td-form-textarea {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 14px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    transition: all 0.2s;
}

.td-form-input:focus,
.td-form-textarea:focus {
    outline: none;
    border-color: #7c3aed;
    box-shadow: 0 0 0 3px rgba(124, 58, 237, 0.1);
}

.td-form-textarea {
    resize: vertical;
    min-height: 120px;
}

.td-radio-group {
    display: flex;
    gap: 20px;
    margin-bottom: 16px;
}

.td-radio-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.td-radio-item input[type="radio"] {
    width: 18px;
    height: 18px;
    cursor: pointer;
}

.td-radio-item label {
    font-size: 14px;
    font-weight: 500;
    color: #374151;
    cursor: pointer;
    margin: 0;
}

.td-hidden-group {
    margin-top: 16px;
}

.td-file-input {
    padding: 20px;
    border: 2px dashed #d1d5db;
    border-radius: 10px;
    text-align: center;
    background: #f9fafb;
    cursor: pointer;
    transition: all 0.2s;
}

.td-file-input:hover {
    border-color: #7c3aed;
    background: #f3f4f6;
}

.td-file-input.active {
    border-color: #7c3aed;
    background: #f0f9ff;
}

.td-file-name {
    font-size: 13px;
    color: #6b7280;
    margin-top: 8px;
}

.td-button-group {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    margin-top: 24px;
}

.td-btn {
    padding: 10px 20px;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 600;
    border: 1.5px solid;
    cursor: pointer;
    transition: all 0.2s;
    font-family: 'Plus Jakarta Sans', sans-serif;
}

.td-btn-primary {
    background: #7c3aed;
    color: #fff;
    border-color: #7c3aed;
}

.td-btn-primary:hover {
    background: #6d28d9;
    border-color: #6d28d9;
}

.td-btn-secondary {
    background: #fff;
    color: #374151;
    border-color: #e5e7eb;
}

.td-btn-secondary:hover {
    background: #f9fafb;
    border-color: #9ca3af;
}

.td-alert {
    padding: 16px;
    border-radius: 12px;
    margin-bottom: 16px;
    font-size: 14px;
    display: flex;
    gap: 12px;
    align-items: flex-start;
}

.td-alert-info {
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    color: #1e40af;
}

.td-alert-warning {
    background: #fffbeb;
    border: 1px solid #fde68a;
    color: #92400e;
}

.td-alert-danger {
    background: #fee2e2;
    border: 1px solid #fecaca;
    color: #991b1b;
}

.td-alert i {
    font-size: 16px;
    flex-shrink: 0;
    margin-top: 2px;
}

/* History */
.td-history-item {
    padding: 16px;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    margin-bottom: 12px;
}

.td-history-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 12px;
}

.td-history-date {
    font-size: 13px;
    font-weight: 600;
    color: #6b7280;
}

.td-history-status {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    background: #ecfdf5;
    color: #065f46;
}

.td-history-type {
    font-size: 14px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}

.td-history-link {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    background: rgba(37, 99, 235, 0.1);
    color: #2563eb;
    text-decoration: none;
    border: 1px solid rgba(37, 99, 235, 0.2);
    transition: all 0.2s;
}

.td-history-link:hover {
    background: #2563eb;
    color: #fff;
    border-color: #2563eb;
    text-decoration: none;
}

@media (max-width: 576px) {
    .td-root {
        padding: 1.5rem 1rem;
    }

    .td-card {
        padding: 16px;
    }

    .td-button-group {
        flex-direction: column-reverse;
    }

    .td-button-group .td-btn {
        width: 100%;
    }

    .td-meta-grid {
        grid-template-columns: 1fr;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="td-root">

    <!-- Header -->
    <div class="td-header">
        <a href="<?= base_url('dashboard/peserta/kelas-tugas?kelas=' . $tugas['id_kelas']) ?>" class="td-header-back">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
        <h1 class="td-title"><?= esc($tugas['judul_tugas']) ?></h1>
    </div>

    <!-- Info Card -->
    <div class="td-card">
        <h3 class="td-section-title">
            <i class="bi bi-info-circle-fill"></i> Informasi Tugas
        </h3>

        <div class="td-meta-grid">
            <div class="td-meta-item">
                <div class="td-meta-label">Kelas</div>
                <div class="td-meta-value"><?= esc($tugas['nama_kelas']) ?></div>
            </div>
            <div class="td-meta-item">
                <div class="td-meta-label">Modul</div>
                <div class="td-meta-value"><?= esc($tugas['judul_modul'] ?? 'Tidak terkait modul') ?></div>
            </div>
            <div class="td-meta-item">
                <div class="td-meta-label">Deadline</div>
                <div class="td-meta-value">
                    <?php if ($deadline_at): ?>
                        <?= date('d M Y H:i', strtotime($deadline_at)) ?> WIB
                    <?php else: ?>
                        Tanpa batas waktu
                    <?php endif; ?>
                </div>
            </div>
            <div class="td-meta-item">
                <div class="td-meta-label">Syarat Pengumpulan</div>
                <div class="td-meta-value">
                    <?= $tugas['is_wajib_posttest'] ? 'Setelah Posttest' : 'Bisa Langsung' ?>
                </div>
            </div>
        </div>

        <?php if (!empty($tugas['deskripsi_tugas'])): ?>
        <div style="margin-top: 16px;">
            <div class="td-meta-label">Deskripsi</div>
            <div class="td-desc"><?= esc($tugas['deskripsi_tugas']) ?></div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Status Alerts -->
    <?php if ($is_expired): ?>
    <div class="td-alert td-alert-danger">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <div>
            <strong>Batas waktu telah berakhir.</strong> Pengumpulan sudah ditutup untuk tugas ini.
        </div>
    </div>
    <?php elseif ($tugas['is_wajib_posttest'] && !$can_submit): ?>
    <div class="td-alert td-alert-warning">
        <i class="bi bi-info-circle-fill"></i>
        <div>
            <strong>Tugas belum tersedia.</strong> Anda harus menyelesaikan posttest modul terlebih dahulu.
        </div>
    </div>
    <?php endif; ?>

    <!-- Form Pengumpulan -->
    <?php if ($can_submit): ?>
    <div class="td-card">
        <h3 class="td-section-title">
            <i class="bi bi-pencil-square"></i> Pengumpulan Tugas
        </h3>

        <form action="<?= base_url('dashboard/peserta/tugas/submit') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <input type="hidden" name="id_tugas" value="<?= $tugas['id_tugas'] ?>">

            <div class="td-form-group">
                <label class="td-form-label">Jenis Jawaban</label>
                <div class="td-radio-group">
                    <div class="td-radio-item">
                        <input type="radio" id="jawabanFile" name="tipe_jawaban" value="file" checked>
                        <label for="jawabanFile">File (PDF, Word, Excel, PowerPoint)</label>
                    </div>
                    <div class="td-radio-item">
                        <input type="radio" id="jawabanText" name="tipe_jawaban" value="text">
                        <label for="jawabanText">Teks</label>
                    </div>
                </div>
            </div>

            <!-- File Input -->
            <div class="td-form-group" id="fileGroup">
                <label class="td-form-label">Unggah File Jawaban</label>
                <label for="jawabanFileInput" class="td-file-input">
                    <div>
                        <i class="bi bi-cloud-arrow-up" style="font-size:24px;color:#9ca3af;"></i>
                        <p style="margin:8px 0 0;font-size:14px;color:#6b7280;font-weight:500;">
                            Klik untuk memilih file atau drag & drop di sini
                        </p>
                        <p style="margin:4px 0 0;font-size:12px;color:#9ca3af;">
                            PDF, Word, Excel, PowerPoint (Max 20MB)
                        </p>
                    </div>
                    <input type="file" id="jawabanFileInput" name="jawaban_file" 
                           accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx" 
                           style="display:none;">
                </label>
                <div id="fileName" class="td-file-name"></div>
            </div>

            <!-- Text Input -->
            <div class="td-form-group" id="textGroup" style="display:none;">
                <label class="td-form-label">Jawaban Teks</label>
                <textarea class="td-form-textarea" name="jawaban_text" 
                          placeholder="Tuliskan jawaban Anda di sini..."></textarea>
            </div>

            <!-- Catatan -->
            <div class="td-form-group">
                <label class="td-form-label">Catatan (Opsional)</label>
                <textarea class="td-form-textarea" name="catatan_peserta" 
                          placeholder="Tambahkan keterangan atau catatan jika diperlukan..."></textarea>
            </div>

            <!-- Buttons -->
            <div class="td-button-group">
                <a href="<?= base_url('dashboard/peserta/kelas-tugas?kelas=' . $tugas['id_kelas']) ?>" class="td-btn td-btn-secondary">
                    Batal
                </a>
                <button type="submit" class="td-btn td-btn-primary">
                    <i class="bi bi-send"></i> Kirim Jawaban
                </button>
            </div>
        </form>
    </div>
    <?php else: ?>
    <div class="td-alert td-alert-info">
        <i class="bi bi-lock-fill"></i>
        <div>
            <strong>Pengumpulan tidak tersedia.</strong> Anda tidak dapat mengumpulkan tugas saat ini.
        </div>
    </div>
    <?php endif; ?>

    <!-- Riwayat Pengumpulan -->
    <?php if (!empty($history)): ?>
    <div class="td-card">
        <h3 class="td-section-title">
            <i class="bi bi-clock-history"></i> Riwayat Pengumpulan
        </h3>

        <div style="display:flex;flex-direction:column;gap:12px;">
            <?php foreach ($history as $item): ?>
            <div class="td-history-item">
                <div class="td-history-header">
                    <div class="td-history-date">
                        <i class="bi bi-calendar3"></i>
                        <?= date('d M Y, H:i', strtotime($item['created_at'])) ?> WIB
                    </div>
                    <span class="td-history-status">
                        <i class="bi bi-check-circle-fill"></i>
                        <?= esc($item['status']) ?>
                    </span>
                </div>
                <div class="td-history-type">
                    <?php if ($item['tipe_jawaban'] === 'file'): ?>
                        <i class="bi bi-file-earmark"></i> File: <?= !empty($item['link_file']) ? basename($item['link_file']) : 'File dihapus' ?>
                    <?php else: ?>
                        <i class="bi bi-file-text"></i> Teks
                    <?php endif; ?>
                </div>
                <?php if (!empty($item['catatan_peserta'])): ?>
                <div style="font-size:13px;color:#6b7280;margin-bottom:8px;padding:10px;background:#f9fafb;border-radius:8px;border-left:3px solid #7c3aed;">
                    <strong>Catatan:</strong> <?= esc($item['catatan_peserta']) ?>
                </div>
                <?php endif; ?>
                <?php if (!empty($item['link_file'])): ?>
                <a href="<?= base_url($item['link_file']) ?>" target="_blank" class="td-history-link">
                    <i class="bi bi-download"></i> Unduh File
                </a>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

</div>

<script>
document.querySelectorAll('input[name="tipe_jawaban"]').forEach(radio => {
    radio.addEventListener('change', function() {
        const fileGroup = document.getElementById('fileGroup');
        const textGroup = document.getElementById('textGroup');
        
        if (this.value === 'file') {
            fileGroup.style.display = 'block';
            textGroup.style.display = 'none';
        } else {
            fileGroup.style.display = 'none';
            textGroup.style.display = 'block';
        }
    });
});

// File input handling
const fileInput = document.getElementById('jawabanFileInput');
const fileLabel = fileInput.parentElement;
const fileName = document.getElementById('fileName');

fileInput.addEventListener('change', function() {
    if (this.files.length > 0) {
        fileName.textContent = this.files[0].name;
        fileLabel.classList.add('active');
    } else {
        fileName.textContent = '';
        fileLabel.classList.remove('active');
    }
});

// Drag and drop
fileLabel.addEventListener('dragover', (e) => {
    e.preventDefault();
    fileLabel.classList.add('active');
});

fileLabel.addEventListener('dragleave', () => {
    fileLabel.classList.remove('active');
});

fileLabel.addEventListener('drop', (e) => {
    e.preventDefault();
    fileInput.files = e.dataTransfer.files;
    fileInput.dispatchEvent(new Event('change'));
});
</script>

<?= $this->endSection() ?>

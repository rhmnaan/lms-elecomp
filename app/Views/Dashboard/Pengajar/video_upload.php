<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>
<?= $this->section('content') ?>

<style>
.vu-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 24px;
}

.vu-header h1 {
    font-size: 20px;
    font-weight: 800;
    color: #111;
    margin: 0 0 3px;
}

.vu-header p {
    font-size: 13px;
    color: #6b7280;
    margin: 0;
}

.vu-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}

@media(max-width:768px) {
    .vu-grid {
        grid-template-columns: 1fr;
    }
}

.vu-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 1px 8px rgba(0, 0, 0, .06);
    padding: 24px;
}

.vu-card h2 {
    font-size: 14px;
    font-weight: 800;
    color: #111;
    margin: 0 0 16px;
    display: flex;
    align-items: center;
    gap: 8px;
}

.vu-card h2 i {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: #f0fdf4;
    color: #059669;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
}

/* Drop zone */
.drop-zone {
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 36px 20px;
    text-align: center;
    cursor: pointer;
    transition: border-color .18s, background .18s;
    background: #fafafa;
    margin-bottom: 14px;
    position: relative;
}

.drop-zone:hover,
.drop-zone.dragover {
    border-color: #059669;
    background: #f0fdf4;
}

.drop-zone.has-file {
    border-color: #059669;
    background: #f0fdf4;
}

.drop-zone i.dz-icon {
    font-size: 36px;
    color: #d1d5db;
    margin-bottom: 10px;
    display: block;
    transition: color .18s;
    pointer-events: none;
}

.drop-zone.has-file i.dz-icon {
    color: #059669;
}

.drop-zone p {
    margin: 0;
    font-size: 13px;
    color: #6b7280;
    pointer-events: none;
}

.drop-zone .file-name {
    font-weight: 700;
    color: #111;
    font-size: 13px;
    margin-top: 4px;
    pointer-events: none;
}

/* FIX: input file benar-benar tersembunyi tapi tetap functional */
#videoFileInput {
    position: absolute;
    inset: 0;
    opacity: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
    z-index: 2;
}

/* Progress */
.upload-progress {
    display: none;
    margin-top: 12px;
}

.up-bar-track {
    background: #e5e7eb;
    border-radius: 99px;
    height: 6px;
    overflow: hidden;
}

.up-bar-fill {
    background: linear-gradient(90deg, #059669, #10b981);
    height: 100%;
    width: 0%;
    border-radius: 99px;
    transition: width .2s;
}

.up-label {
    display: flex;
    justify-content: space-between;
    font-size: 11.5px;
    color: #6b7280;
    margin-top: 4px;
}

/* Video list */
.vlist-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 14px;
    border-radius: 10px;
    border: 1px solid #f0f0f0;
    background: #fafafa;
    margin-bottom: 8px;
    transition: background .12s;
}

.vlist-item:hover {
    background: #f3f4f6;
}

.vlist-icon {
    width: 34px;
    height: 34px;
    border-radius: 8px;
    background: #ecfdf5;
    color: #059669;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    flex-shrink: 0;
}

.vlist-info {
    flex: 1;
    min-width: 0;
}

.vlist-name {
    font-size: 12.5px;
    font-weight: 700;
    color: #111;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.vlist-meta {
    font-size: 11px;
    color: #9ca3af;
    margin-top: 1px;
}

.vlist-actions {
    display: flex;
    gap: 6px;
    flex-shrink: 0;
}

.btn-copy-id {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    font-weight: 700;
    background: #eff6ff;
    color: #2563eb;
    border: none;
    border-radius: 7px;
    padding: 5px 10px;
    cursor: pointer;
    transition: background .14s;
}

.btn-copy-id:hover {
    background: #dbeafe;
}

.btn-del-vid {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 28px;
    height: 28px;
    border-radius: 7px;
    background: #fff5f5;
    color: #ef4444;
    border: none;
    cursor: pointer;
    font-size: 12px;
    transition: background .14s;
}

.btn-del-vid:hover {
    background: #fee2e2;
}

/* Alert */
.vu-alert {
    align-items: center;
    gap: 10px;
    padding: 11px 14px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 14px;
    display: none;
}

.vu-alert.success {
    background: #f0fdf4;
    color: #15803d;
    border: 1px solid #bbf7d0;
}

.vu-alert.danger {
    background: #fff5f5;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.empty-vlist {
    text-align: center;
    padding: 32px 20px;
    color: #9ca3af;
    font-size: 12.5px;
}

.empty-vlist i {
    font-size: 28px;
    display: block;
    margin-bottom: 8px;
    color: #e5e7eb;
}

.badge-size {
    display: inline-block;
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
    background: #f3f4f6;
    color: #6b7280;
}
</style>

<!-- HEADER -->
<div class="vu-header">
    <div>
        <h1>Upload Video Materi</h1>
        <p>Upload video lokal yang akan dienkripsi AES-256-CBC dan disimpan aman di server.</p>
    </div>
    <a href="<?= base_url('dashboard/pengajar/materi') ?>" class="btn btn-light btn-sm px-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Materi
    </a>
</div>

<div class="vu-grid">

    <!-- ── UPLOAD FORM ── -->
    <div class="vu-card">
        <h2><i class="bi bi-cloud-arrow-up-fill"></i> Upload &amp; Enkripsi Video</h2>

        <div id="vuAlert" class="vu-alert"></div>

        <div class="mb-3">
            <label class="form-label fw-semibold small">Judul Video</label>
            <input type="text" class="form-control" id="judulVideo" placeholder="cth: Pengenalan Elektronika Dasar">
        </div>

        <!-- FIX: Hapus onclick dari div, input file dijadikan overlay transparan di dalam drop-zone -->
        <div class="drop-zone" id="dropZone">
            <!-- FIX: input diposisikan absolute menutupi seluruh drop-zone, bukan display:none -->
            <input type="file" id="videoFileInput" name="video" accept=".mp4,.avi,.mkv,.mov,.webm">
            <i class="bi bi-play-circle dz-icon" id="dzIcon"></i>
            <p class="mb-1"><strong>Klik untuk pilih video</strong> atau drag &amp; drop</p>
            <p style="font-size:11px;">Format: MP4, AVI, MKV, MOV, WEBM &middot; Maks. 500 MB</p>
            <p class="file-name" id="selectedFileName" style="display:none;"></p>
        </div>

        <div class="upload-progress" id="uploadProgress">
            <div class="up-bar-track">
                <div class="up-bar-fill" id="upBarFill"></div>
            </div>
            <div class="up-label">
                <span id="upLabelText">Mengupload...</span>
                <span id="upLabelPct">0%</span>
            </div>
        </div>

        <div class="d-grid mt-3">
            <button class="btn btn-success fw-semibold" id="btnUpload" onclick="doUpload()" disabled>
                <i class="bi bi-shield-lock-fill me-2"></i>Upload &amp; Enkripsi
            </button>
        </div>

        <div class="mt-3 p-3 rounded-3"
            style="background:#fffbeb;border:1px solid #fde68a;font-size:12px;color:#92400e;">
            <i class="bi bi-info-circle-fill me-1"></i>
            Video dienkripsi dengan <strong>AES-256-CBC</strong> sebelum disimpan.
            File asli akan dihapus otomatis setelah enkripsi selesai.
            Salin <strong>Video ID</strong> dan tempel di form materi.
        </div>
    </div>

    <!-- ── VIDEO LIST ── -->
    <div class="vu-card">
        <h2><i class="bi bi-collection-play-fill"></i> Video Tersimpan</h2>
        <div id="videoListWrap">
            <div class="empty-vlist">
                <i class="bi bi-hourglass"></i>
                <p>Memuat daftar video...</p>
            </div>
        </div>
    </div>

</div>

<script>
const API_ROOT = '<?= base_url() ?>';

/* ════════════════════════════════════════════════════
   DROP ZONE
   FIX: input file adalah overlay transparan di atas drop-zone,
   sehingga klik langsung ke input tanpa onclick manual.
   Ini menghindari double-trigger yang menyebabkan file = null.
════════════════════════════════════════════════════ */
const dz = document.getElementById('dropZone');
const input = document.getElementById('videoFileInput');
const fnEl = document.getElementById('selectedFileName');
const btn = document.getElementById('btnUpload');

function setFile(file) {
    fnEl.textContent = file.name + ' (' + (file.size / 1024 / 1024).toFixed(1) + ' MB)';
    fnEl.style.display = 'block';
    dz.classList.add('has-file');
    btn.disabled = false;
}

// FIX: dengarkan change di input (sudah menutupi drop-zone sebagai overlay)
input.addEventListener('change', () => {
    if (input.files[0]) setFile(input.files[0]);
});

// Drag & drop
dz.addEventListener('dragover', e => {
    e.preventDefault();
    dz.classList.add('dragover');
});
dz.addEventListener('dragleave', e => {
    e.preventDefault();
    dz.classList.remove('dragover');
});
dz.addEventListener('drop', e => {
    e.preventDefault();
    dz.classList.remove('dragover');
    const f = e.dataTransfer.files[0];
    if (!f) return;

    // FIX: assign file ke input via DataTransfer agar input.files[0] terisi
    const dt = new DataTransfer();
    dt.items.add(f);
    input.files = dt.files;
    setFile(f);
});

/* ════════════════════════════════════════════════════
   ALERT
════════════════════════════════════════════════════ */
function showAlert(type, msg) {
    const el = document.getElementById('vuAlert');
    el.className = 'vu-alert ' + type;
    el.innerHTML =
        `<i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill'}"></i> ${msg}`;
    el.style.display = 'flex';
    el.style.opacity = '1';
    el.style.transition = '';
    setTimeout(() => {
        el.style.transition = 'opacity .4s';
        el.style.opacity = '0';
        setTimeout(() => {
            el.style.display = 'none';
            el.style.opacity = '';
        }, 400);
    }, 6000);
}

/* ════════════════════════════════════════════════════
   UPLOAD
   FIX utama: gunakan FormData yang menyertakan file
   dari input.files[0] secara eksplisit.
   Jangan set Content-Type header — biarkan browser
   set boundary multipart secara otomatis.
════════════════════════════════════════════════════ */
function doUpload() {
    const file = input.files[0];
    if (!file) {
        showAlert('danger', 'Pilih file video terlebih dahulu!');
        return;
    }

    // FIX: append file langsung (bukan dari input element)
    const formData = new FormData();
    formData.append('video', file, file.name); // nama field harus 'video'
    formData.append('judul_video', document.getElementById('judulVideo').value.trim() || file.name);
    formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>'); // CSRF CI4

    const xhr = document.createElement('span'); // dummy — pakai XMLHttpRequest di bawah
    const xr = new XMLHttpRequest();
    const prog = document.getElementById('uploadProgress');
    const fill = document.getElementById('upBarFill');
    const lbl = document.getElementById('upLabelText');
    const pct = document.getElementById('upLabelPct');

    btn.disabled = true;
    prog.style.display = 'block';
    fill.style.width = '0%';
    pct.textContent = '0%';
    lbl.textContent = 'Mengupload...';

    xr.withCredentials = true;

    xr.upload.onprogress = e => {
        if (e.lengthComputable) {
            const p = Math.round(e.loaded / e.total * 100);
            fill.style.width = p + '%';
            pct.textContent = p + '%';
            lbl.textContent = p < 100 ? 'Mengupload...' : 'Mengenkripsi... harap tunggu';
        }
    };

    xr.onload = () => {
        prog.style.display = 'none';
        btn.disabled = false;

        // FIX: cek status HTTP dulu sebelum parse JSON
        if (xr.status === 401) {
            showAlert('danger', 'Sesi habis. Silakan refresh halaman dan login ulang.');
            return;
        }
        if (xr.status === 403) {
            showAlert('danger', 'Akses ditolak. Pastikan Anda login sebagai pengajar.');
            return;
        }

        let data;
        try {
            data = JSON.parse(xr.responseText);
        } catch (e) {
            console.error('Raw server response:', xr.responseText.substring(0, 500));
            showAlert('danger', 'Response tidak valid dari server (HTTP ' + xr.status +
                '). Cek console untuk detail.');
            return;
        }

        if (data.success) {
            showAlert('success',
                `&#10003; Berhasil! Video ID: <strong>${data.data.video_id}</strong> &mdash; salin dan tempel di form materi.`
            );
            loadVideoList();
            // Reset form
            input.value = '';
            fnEl.style.display = 'none';
            dz.classList.remove('has-file');
            document.getElementById('judulVideo').value = '';
            btn.disabled = true;
        } else {
            const errs = data.errors ?
                Object.values(data.errors).join('<br>') :
                (data.message || 'Gagal upload');
            showAlert('danger', errs);
            console.error('Upload error detail:', data);
        }
    };

    xr.onerror = () => {
        prog.style.display = 'none';
        btn.disabled = false;
        showAlert('danger', 'Koneksi terputus saat upload.');
    };

    xr.ontimeout = () => {
        prog.style.display = 'none';
        btn.disabled = false;
        showAlert('danger', 'Upload timeout. Coba lagi atau gunakan file yang lebih kecil.');
    };

    // FIX: jangan set Content-Type — browser set otomatis dengan boundary
    xr.open('POST', API_ROOT + 'dashboard/pengajar/video/upload');
    xr.send(formData);
}

/* ════════════════════════════════════════════════════
   HELPERS
════════════════════════════════════════════════════ */
function fmtSize(b) {
    if (b >= 1048576) return (b / 1048576).toFixed(1) + ' MB';
    if (b >= 1024) return (b / 1024).toFixed(0) + ' KB';
    return b + ' B';
}

function escHtml(str) {
    const d = document.createElement('div');
    d.appendChild(document.createTextNode(str));
    return d.innerHTML;
}

/* ════════════════════════════════════════════════════
   VIDEO LIST
════════════════════════════════════════════════════ */
async function loadVideoList() {
    const wrap = document.getElementById('videoListWrap');
    try {
        const res = await fetch(API_ROOT + 'dashboard/pengajar/video/list', {
            method: 'GET',
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!res.ok) {
            const errText = await res.text();
            console.error('Video list HTTP error:', res.status, errText);
            wrap.innerHTML = `
                <div class="empty-vlist">
                    <i class="bi bi-exclamation-triangle"></i>
                    <p>Error ${res.status}: Gagal memuat daftar video.<br>
                    <small style="font-size:10px;color:#9ca3af;">${res.status === 401 ? 'Sesi habis, silakan refresh halaman.' : 'Cek console untuk detail.'}</small></p>
                </div>`;
            return;
        }

        const data = await res.json();

        if (!data.success || !data.data || !data.data.length) {
            wrap.innerHTML = `
                <div class="empty-vlist">
                    <i class="bi bi-collection-play"></i>
                    <p>Belum ada video yang diupload.</p>
                </div>`;
            return;
        }

        wrap.innerHTML = data.data.map(v => `
            <div class="vlist-item" id="vitem-${v.video_id}">
                <div class="vlist-icon"><i class="bi bi-play-circle-fill"></i></div>
                <div class="vlist-info">
                    <div class="vlist-name">${escHtml(v.judul_video)}</div>
                    <div class="vlist-meta">
                        <span class="badge-size">${fmtSize(v.size)}</span>
                        &nbsp;<span style="font-family:monospace;font-size:10px;">${v.video_id}</span>
                    </div>
                </div>
                <div class="vlist-actions">
                    <button class="btn-copy-id" onclick="copyId('${v.video_id}', this)">
                        <i class="bi bi-clipboard"></i> Salin ID
                    </button>
                    <button class="btn-del-vid" onclick="deleteVideo('${v.video_id}')" title="Hapus video">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>`).join('');

    } catch (e) {
        wrap.innerHTML = `
            <div class="empty-vlist">
                <i class="bi bi-exclamation-triangle"></i>
                <p>Gagal memuat daftar video.</p>
            </div>`;
    }
}

function copyId(videoId, el) {
    navigator.clipboard.writeText(videoId).then(() => {
        el.innerHTML = '<i class="bi bi-check-lg"></i> Disalin!';
        el.style.background = '#dcfce7';
        el.style.color = '#15803d';
        setTimeout(() => {
            el.innerHTML = '<i class="bi bi-clipboard"></i> Salin ID';
            el.style.background = '';
            el.style.color = '';
        }, 2500);
    }).catch(() => {
        const ta = document.createElement('textarea');
        ta.value = videoId;
        document.body.appendChild(ta);
        ta.select();
        document.execCommand('copy');
        ta.remove();
        el.innerHTML = '<i class="bi bi-check-lg"></i> Disalin!';
        setTimeout(() => {
            el.innerHTML = '<i class="bi bi-clipboard"></i> Salin ID';
        }, 2500);
    });
}

async function deleteVideo(videoId) {
    if (!confirm('Hapus video ini? File tidak bisa dikembalikan.')) return;
    try {
        const res = await fetch(API_ROOT + 'dashboard/pengajar/video/delete/' + videoId, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: '<?= csrf_token() ?>=' + encodeURIComponent('<?= csrf_hash() ?>')
        });
        const data = await res.json();
        if (data.success) {
            document.getElementById('vitem-' + videoId)?.remove();
            showAlert('success', 'Video berhasil dihapus.');
            if (!document.querySelector('.vlist-item')) {
                document.getElementById('videoListWrap').innerHTML = `
                    <div class="empty-vlist">
                        <i class="bi bi-collection-play"></i>
                        <p>Belum ada video yang diupload.</p>
                    </div>`;
            }
        } else {
            showAlert('danger', data.message || 'Gagal menghapus video.');
        }
    } catch (e) {
        showAlert('danger', 'Koneksi error saat menghapus video.');
    }
}

document.addEventListener('DOMContentLoaded', loadVideoList);
</script>

<?= $this->endSection() ?>
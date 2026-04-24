<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Video Player — LMS Elecomp</title>
    <style>
    *,
    *::before,
    *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        user-select: none;
        -webkit-user-select: none;
    }

    html,
    body {
        width: 100%;
        height: 100%;
        overflow: hidden;
        background: #0a0a0a;
        font-family: 'Segoe UI', system-ui, sans-serif;
    }

    /* ── Player Container ── */
    .player-wrap {
        width: 100%;
        height: 100%;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    video {
        width: 100%;
        height: 100%;
        display: block;
        object-fit: contain;
        background: #000;
    }

    video::-webkit-media-controls-download-button,
    video::-webkit-media-controls-overflow-button,
    video::-webkit-media-controls-remote-playback-button {
        display: none !important;
    }

    /* ── Loading Overlay ── */
    .loading-overlay {
        position: absolute;
        inset: 0;
        background: rgba(10, 10, 10, .97);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 100;
        transition: opacity .45s ease;
    }

    .loading-overlay.fade-out {
        opacity: 0;
        pointer-events: none;
    }

    .ring-wrap {
        position: relative;
        width: 96px;
        height: 96px;
    }

    .ring-svg {
        transform: rotate(-90deg);
    }

    .ring-track {
        fill: none;
        stroke: rgba(255, 255, 255, .08);
        stroke-width: 5;
    }

    .ring-fill {
        fill: none;
        stroke: #10b981;
        stroke-width: 5;
        stroke-linecap: round;
        stroke-dasharray: 270;
        stroke-dashoffset: 270;
        transition: stroke-dashoffset .25s ease;
    }

    .ring-pct {
        position: absolute;
        inset: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 800;
        color: #10b981;
    }

    .load-title {
        margin-top: 18px;
        font-size: 13px;
        color: rgba(255, 255, 255, .6);
        letter-spacing: .5px;
    }

    .load-status {
        margin-top: 6px;
        font-size: 11px;
        color: rgba(255, 255, 255, .35);
    }

    .steps {
        display: flex;
        gap: 6px;
        margin-top: 18px;
    }

    .step-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .15);
        transition: background .3s, transform .3s;
    }

    .step-dot.active {
        background: #10b981;
        transform: scale(1.3);
    }

    .step-dot.done {
        background: rgba(16, 185, 129, .4);
    }

    /* ── Error Overlay ── */
    .error-overlay {
        position: absolute;
        inset: 0;
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 200;
        background: rgba(10, 10, 10, .92);
    }

    .error-overlay.show {
        display: flex;
    }

    .error-box {
        background: #1a0e0e;
        border: 1px solid rgba(239, 68, 68, .35);
        border-radius: 14px;
        padding: 28px 32px;
        text-align: center;
        max-width: 380px;
    }

    .error-box i {
        font-size: 32px;
        color: #ef4444;
        margin-bottom: 12px;
        display: block;
    }

    .error-box h3 {
        color: #fff;
        font-size: 15px;
        margin-bottom: 6px;
    }

    .error-box p {
        color: rgba(255, 255, 255, .5);
        font-size: 12.5px;
    }
    </style>
</head>

<body>

    <div class="player-wrap">

        <video id="vp" autoplay controls playsinline controlsList="nodownload noremoteplayback" disablePictureInPicture
            oncontextmenu="return false;">
        </video>

        <!-- Loading Overlay -->
        <div class="loading-overlay" id="loadOverlay">
            <div class="ring-wrap">
                <svg class="ring-svg" width="96" height="96" viewBox="0 0 96 96">
                    <circle class="ring-track" r="43" cx="48" cy="48" />
                    <circle class="ring-fill" r="43" cx="48" cy="48" id="ringFill" />
                </svg>
                <div class="ring-pct" id="ringPct">0%</div>
            </div>
            <div class="load-title" id="loadTitle">Memuat video...</div>
            <div class="load-status" id="loadStatus">Mengamankan koneksi</div>
            <div class="steps">
                <div class="step-dot" id="sd0"></div>
                <div class="step-dot" id="sd1"></div>
                <div class="step-dot" id="sd2"></div>
                <div class="step-dot" id="sd3"></div>
            </div>
        </div>

        <!-- Error Overlay -->
        <div class="error-overlay" id="errOverlay">
            <div class="error-box">
                <i class="bi bi-exclamation-circle-fill"></i>
                <h3>Gagal Memuat Video</h3>
                <p id="errMsg">Terjadi kesalahan saat memuat video.</p>
            </div>
        </div>

    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script>
    /* ══════════════════════════════════════════════════════════
   CONFIG — diisi PHP saat serve
══════════════════════════════════════════════════════════ */
    const VIDEO_ID = '<?= esc($videoId ?? '') ?>';
    const API_BASE = '<?= base_url('api/videos') ?>';

    /* ══════════════════════════════════════════════════════════
       ELEMEN
    ══════════════════════════════════════════════════════════ */
    const vp = document.getElementById('vp');
    const loadOverlay = document.getElementById('loadOverlay');
    const ringFill = document.getElementById('ringFill');
    const ringPct = document.getElementById('ringPct');
    const loadTitle = document.getElementById('loadTitle');
    const loadStatus = document.getElementById('loadStatus');
    const errOverlay = document.getElementById('errOverlay');
    const errMsg = document.getElementById('errMsg');
    const stepDots = [0, 1, 2, 3].map(i => document.getElementById('sd' + i));

    let activeStep = -1;
    const CIRCUMFERENCE = 2 * Math.PI * 43;

    /* ══════════════════════════════════════════════════════════
       SECURITY
    ══════════════════════════════════════════════════════════ */
    document.addEventListener('contextmenu', e => e.preventDefault());
    document.addEventListener('keydown', e => {
        const blocked = (
            e.keyCode === 123 ||
            (e.ctrlKey && e.shiftKey && [73, 74, 75].includes(e.keyCode)) ||
            (e.ctrlKey && [85, 83, 80].includes(e.keyCode))
        );
        if (blocked) e.preventDefault();
    });

    /* ══════════════════════════════════════════════════════════
       HELPERS
    ══════════════════════════════════════════════════════════ */
    function setProgress(pct, title, status, step) {
        const offset = CIRCUMFERENCE - (pct / 100) * CIRCUMFERENCE;
        ringFill.style.strokeDashoffset = offset;
        ringPct.textContent = Math.round(pct) + '%';
        if (title) loadTitle.textContent = title;
        if (status) loadStatus.textContent = status;

        if (step !== undefined && step !== activeStep && step >= 0) {
            if (activeStep >= 0) {
                stepDots[activeStep].classList.remove('active');
                stepDots[activeStep].classList.add('done');
            }
            stepDots[step].classList.add('active');
            activeStep = step;
        }
    }

    function showError(msg) {
        loadOverlay.style.display = 'none';
        errMsg.textContent = msg;
        errOverlay.classList.add('show');
    }

    function b64ToBuffer(b64) {
        const bin = atob(b64);
        const arr = new Uint8Array(bin.length);
        for (let i = 0; i < bin.length; i++) arr[i] = bin.charCodeAt(i);
        return arr.buffer;
    }

    /* ══════════════════════════════════════════════════════════
       STEP 1 — Ambil kunci enkripsi dari server
    ══════════════════════════════════════════════════════════ */
    async function getKey() {
        setProgress(5, 'Memuat video...', 'Mengamankan koneksi', 0);

        const res = await fetch(API_BASE + '/key');
        if (!res.ok) throw new Error('Gagal mendapatkan lisensi (HTTP ' + res.status + ')');

        const data = await res.json();
        if (!data.success) throw new Error(data.message || 'Lisensi tidak valid');

        // Key sudah berupa SHA-256 derived key yang di-base64 dari server
        return crypto.subtle.importKey(
            'raw',
            b64ToBuffer(data.key), {
                name: 'AES-CBC'
            },
            false,
            ['decrypt']
        );
    }

    /* ══════════════════════════════════════════════════════════
       STEP 2 — Ambil metadata video
    ══════════════════════════════════════════════════════════ */
    async function getMeta() {
        setProgress(18, 'Memuat video...', 'Membaca informasi file', 1);

        const res = await fetch(API_BASE + '/info/' + VIDEO_ID);
        if (!res.ok) throw new Error('Video tidak ditemukan (HTTP ' + res.status + ')');

        const data = await res.json();
        if (!data.success) throw new Error(data.message || 'Video tidak ditemukan');

        return data.data;
    }

    /* ══════════════════════════════════════════════════════════
       STEP 3 — Download file .enc dengan progress real-time
    ══════════════════════════════════════════════════════════ */
    async function downloadFile(totalSize) {
        setProgress(30, 'Mengunduh...', 'Mengunduh file terenkripsi', 2);

        const res = await fetch(API_BASE + '/stream/' + VIDEO_ID);
        if (!res.ok) throw new Error('Gagal mengunduh video (HTTP ' + res.status + ')');

        const reader = res.body.getReader();
        const chunks = [];
        let received = 0;

        while (true) {
            const {
                done,
                value
            } = await reader.read();
            if (done) break;
            chunks.push(value);
            received += value.byteLength;

            const pct = totalSize ?
                Math.min(30 + (received / totalSize) * 40, 70) :
                50;
            setProgress(pct, 'Mengunduh...', (received / 1048576).toFixed(1) + ' MB diunduh');
        }

        const total = chunks.reduce((s, c) => s + c.byteLength, 0);
        const merged = new Uint8Array(total);
        let offset = 0;
        for (const c of chunks) {
            merged.set(c, offset);
            offset += c.byteLength;
        }
        return merged.buffer;
    }

    /* ══════════════════════════════════════════════════════════
       STEP 4 — Dekripsi AES-256-CBC di browser
    ══════════════════════════════════════════════════════════ */
    async function decryptBuffer(cryptoKey, buffer) {
        setProgress(75, 'Mendekripsi...', 'AES-256-CBC dekripsi', 3);

        const raw = new Uint8Array(buffer);
        const iv = raw.slice(0, 16);
        const data = raw.slice(16);

        return crypto.subtle.decrypt({
                name: 'AES-CBC',
                iv
            },
            cryptoKey,
            data
        );
    }

    /* ══════════════════════════════════════════════════════════
       MAIN INIT
    ══════════════════════════════════════════════════════════ */
    async function init() {
        if (!VIDEO_ID) {
            showError('Video ID tidak ditemukan. Pastikan URL mengandung parameter ?id=xxx');
            return;
        }

        try {
            const key = await getKey();
            const meta = await getMeta();
            const buffer = await downloadFile(meta.size);
            const clear = await decryptBuffer(key, buffer);

            setProgress(95, 'Menyiapkan...', 'Hampir selesai...');

            const blob = new Blob([clear], {
                type: 'video/mp4'
            });
            const url = URL.createObjectURL(blob);
            vp.src = url;

            vp.addEventListener('loadeddata', () => {
                setProgress(100, 'Siap!', '');
                setTimeout(() => {
                    loadOverlay.classList.add('fade-out');
                    vp.play().catch(() => {});
                }, 350);
            }, {
                once: true
            });

            /* ══ postMessage ke parent (materi_modul) saat video selesai ══ */
            vp.addEventListener('ended', () => {
                window.parent.postMessage({
                    type: 'VIDEO_ENDED',
                    videoId: VIDEO_ID
                }, '*');
                console.log('[VideoPlayer] VIDEO_ENDED postMessage sent.');
            });

            vp.addEventListener('error', () => {
                showError('Format video tidak didukung atau file rusak. Coba kontak admin.');
            }, {
                once: true
            });

        } catch (err) {
            console.error('[VideoPlayer]', err);
            showError(err.message || 'Terjadi kesalahan tidak diketahui. Coba muat ulang halaman.');
        }
    }

    window.addEventListener('DOMContentLoaded', init);
    </script>
</body>

</html>
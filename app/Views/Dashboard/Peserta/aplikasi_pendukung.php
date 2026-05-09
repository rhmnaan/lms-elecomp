<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>
<?= $this->section('content') ?>

<!-- AOS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">

<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap');

.ap-wrap { font-family: 'Plus Jakarta Sans', sans-serif; }

/* ══ HERO BANNER ══ */
.ap-hero {
    position: relative;
    border-radius: 24px;
    padding: 36px 40px;
    margin-bottom: 32px;
    background: linear-gradient(135deg, #1e1b4b 0%, #312e81 45%, #4338ca 100%);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
}
.ap-hero::before,
.ap-hero::after {
    content: '';
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}
.ap-hero::before {
    width: 320px; height: 320px;
    background: rgba(255,255,255,.04);
    top: -80px; right: -60px;
}
.ap-hero::after {
    width: 180px; height: 180px;
    background: rgba(99,102,241,.25);
    bottom: -60px; left: 30%;
    filter: blur(40px);
}

.ap-hero-text { z-index: 1; }
.ap-hero-text h2 {
    font-size: 24px;
    font-weight: 800;
    color: #fff;
    margin: 0 0 6px;
    letter-spacing: -.4px;
}
.ap-hero-text p {
    font-size: 13.5px;
    color: rgba(255,255,255,.65);
    margin: 0;
    line-height: 1.6;
}

.ap-hero-stats {
    display: flex;
    gap: 14px;
    flex-shrink: 0;
    z-index: 1;
}
.ap-stat-box {
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.15);
    backdrop-filter: blur(8px);
    border-radius: 16px;
    padding: 14px 22px;
    text-align: center;
    min-width: 90px;
}
.ap-stat-box .num {
    font-size: 28px;
    font-weight: 800;
    color: #fff;
    line-height: 1;
}
.ap-stat-box .lbl {
    font-size: 11px;
    color: rgba(255,255,255,.6);
    margin-top: 4px;
    font-weight: 500;
}

/* ══ TOOLBAR ══ */
.ap-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 24px;
    flex-wrap: wrap;
}
.ap-toolbar-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
}
.ap-search-wrap { position: relative; }
.ap-search-wrap i {
    position: absolute;
    left: 13px; top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 13px;
    pointer-events: none;
}
.ap-search-wrap input {
    padding: 9px 16px 9px 36px;
    width: 240px;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    font-size: 13px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: #334155;
    background: #f8fafc;
    outline: none;
    transition: all .25s;
}
.ap-search-wrap input:focus {
    border-color: #6366f1;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(99,102,241,.1);
    width: 280px;
}

/* ══ GRID ══ */
.ap-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
    gap: 18px;
}

/* ══ CARD ══ */
.ap-card {
    position: relative;
    background: #fff;
    border-radius: 20px;
    border: 1.5px solid #f1f5f9;
    text-decoration: none;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: transform .3s cubic-bezier(.34,1.56,.64,1),
                box-shadow .3s ease,
                border-color .3s;
    box-shadow: 0 2px 8px rgba(0,0,0,.05);
}
.ap-card:hover {
    transform: translateY(-7px) scale(1.015);
    box-shadow: 0 24px 56px rgba(99,102,241,.15), 0 6px 18px rgba(0,0,0,.07);
    border-color: #c7d2fe;
    text-decoration: none;
}

/* top colour strip */
.ap-card-strip { height: 5px; width: 100%; }

.ap-card-body {
    padding: 22px 20px 16px;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 12px;
    flex: 1;
}

/* icon */
.ap-favicon-wrap { position: relative; width: 68px; height: 68px; }
.ap-favicon {
    width: 68px; height: 68px;
    border-radius: 18px;
    display: flex; align-items: center; justify-content: center;
    font-size: 30px;
    transition: transform .3s cubic-bezier(.34,1.56,.64,1);
    box-shadow: 0 4px 14px rgba(0,0,0,.1);
}
.ap-card:hover .ap-favicon { transform: scale(1.14) rotate(-5deg); }

/* green dot */
.ap-online-dot {
    position: absolute;
    bottom: 2px; right: 2px;
    width: 14px; height: 14px;
    background: #22c55e;
    border-radius: 50%;
    border: 2.5px solid #fff;
    animation: pulse-dot 2s infinite;
}
@keyframes pulse-dot {
    0%,100% { box-shadow: 0 0 0 0 rgba(34,197,94,.4); }
    50%      { box-shadow: 0 0 0 5px rgba(34,197,94,0); }
}

.ap-card-info { text-align: center; width: 100%; }
.ap-app-name {
    font-size: 14px; font-weight: 700; color: #0f172a;
    margin-bottom: 3px;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}
.ap-app-domain {
    font-size: 11.5px; color: #94a3b8;
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
}

/* card footer */
.ap-card-footer {
    padding: 10px 18px;
    border-top: 1px solid #f8fafc;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.ap-badge-free {
    font-size: 10px; font-weight: 700;
    padding: 3px 8px; border-radius: 6px;
    background: #f0fdf4; color: #16a34a;
    text-transform: uppercase; letter-spacing: .3px;
}
.ap-open-btn {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 12px; font-weight: 600;
    color: #6366f1; background: #eef2ff;
    border: none; border-radius: 8px;
    padding: 5px 12px;
    transition: background .15s, color .15s, transform .15s;
    text-decoration: none;
    cursor: pointer;
}
.ap-card:hover .ap-open-btn {
    background: #6366f1; color: #fff;
}

/* ══ COLOUR VARIANTS ══ */
.strip-0{background:linear-gradient(90deg,#7c3aed,#a78bfa)}
.strip-1{background:linear-gradient(90deg,#2563eb,#60a5fa)}
.strip-2{background:linear-gradient(90deg,#059669,#34d399)}
.strip-3{background:linear-gradient(90deg,#ea580c,#fb923c)}
.strip-4{background:linear-gradient(90deg,#db2777,#f472b6)}
.strip-5{background:linear-gradient(90deg,#0d9488,#2dd4bf)}
.strip-6{background:linear-gradient(90deg,#ca8a04,#fbbf24)}
.strip-7{background:linear-gradient(90deg,#dc2626,#f87171)}
.strip-8{background:linear-gradient(90deg,#0284c7,#38bdf8)}
.strip-9{background:linear-gradient(90deg,#7c3aed,#ec4899)}

.ic-0{background:#ede9fe;color:#7c3aed}
.ic-1{background:#dbeafe;color:#2563eb}
.ic-2{background:#d1fae5;color:#059669}
.ic-3{background:#ffedd5;color:#ea580c}
.ic-4{background:#fce7f3;color:#db2777}
.ic-5{background:#ccfbf1;color:#0d9488}
.ic-6{background:#fef9c3;color:#ca8a04}
.ic-7{background:#fee2e2;color:#dc2626}
.ic-8{background:#e0f2fe;color:#0284c7}
.ic-9{background:#fae8ff;color:#a21caf}

/* ══ EMPTY STATE ══ */
.ap-empty {
    grid-column: 1/-1;
    text-align: center;
    padding: 64px 24px;
}
.ap-empty-icon {
    width: 88px; height: 88px;
    border-radius: 24px;
    background: #f8fafc;
    border: 2px dashed #e2e8f0;
    display: flex; align-items: center; justify-content: center;
    font-size: 34px; color: #cbd5e1;
    margin: 0 auto 20px;
}
.ap-empty h5 { font-size:16px;font-weight:700;color:#334155;margin-bottom:6px; }
.ap-empty p  { font-size:13px;color:#94a3b8;margin:0; }

/* ══ NO RESULT ══ */
#noResult {
    display: none;
    grid-column: 1/-1;
    text-align: center;
    padding: 48px;
    color: #94a3b8;
    font-size: 13px;
}

/* ══ RESPONSIVE ══ */
@media(max-width:768px){
    .ap-hero { padding:22px 20px; flex-direction:column; align-items:flex-start; }
    .ap-hero-stats { width:100%; }
    .ap-stat-box { flex:1; }
    .ap-grid { grid-template-columns:repeat(2,1fr); gap:12px; }
    .ap-search-wrap input { width:190px; }
    .ap-search-wrap input:focus { width:210px; }
}
</style>

<div class="ap-wrap">

    <!-- ══ HERO ══ -->
    <div class="ap-hero" data-aos="fade-down" data-aos-duration="700">
        <div class="ap-hero-text">
            <h2><i class="bi bi-grid-fill me-2" style="opacity:.75"></i>Aplikasi Pendukung</h2>
            <p>Semua aplikasi yang kamu butuhkan tersedia di sini.<br>Klik kartu untuk membuka langsung.</p>
        </div>
        <div class="ap-hero-stats">
            <div class="ap-stat-box" data-aos="zoom-in" data-aos-delay="200" data-aos-duration="500">
                <div class="num"><?= count($aplikasi) ?></div>
                <div class="lbl">Aplikasi</div>
            </div>
            <div class="ap-stat-box" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="500">
                <div class="num"><i class="bi bi-check-circle-fill" style="font-size:22px;color:#4ade80"></i></div>
                <div class="lbl">Aktif</div>
            </div>
        </div>
    </div>

    <?php if (!empty($aplikasi)): ?>

    <!-- ══ TOOLBAR ══ -->
    <div class="ap-toolbar" data-aos="fade-up" data-aos-duration="500" data-aos-delay="100">
        <div class="ap-toolbar-title">
            Semua Aplikasi
            <span style="font-weight:500;color:#94a3b8;font-size:13px;margin-left:6px">(<?= count($aplikasi) ?>)</span>
        </div>
        <div class="ap-search-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="apSearch" placeholder="Cari aplikasi..." oninput="filterAplikasi()">
        </div>
    </div>

    <!-- ══ CARD GRID ══ -->
    <?php
    $icons = [
        'bi-palette-fill',
        'bi-play-btn-fill',
        'bi-file-earmark-text-fill',
        'bi-bar-chart-fill',
        'bi-camera-fill',
        'bi-chat-dots-fill',
        'bi-code-slash',
        'bi-cloud-fill',
        'bi-book-fill',
        'bi-lightning-charge-fill',
    ];
    ?>

    <div class="ap-grid" id="apGrid">
        <?php foreach ($aplikasi as $i => $app):
            $domain    = parse_url($app['link_aplikasi'], PHP_URL_HOST) ?? '';
            $domain    = preg_replace('/^www\./', '', $domain);
            $idx       = $i % 10;
            $icon      = $icons[$i % count($icons)];
            $aosDelay  = 150 + ($i * 70);
        ?>
        <a class="ap-card"
           href="<?= esc($app['link_aplikasi']) ?>"
           target="_blank"
           rel="noopener noreferrer"
           data-name="<?= strtolower(esc($app['nama_aplikasi'])) ?>"
           data-aos="zoom-in-up"
           data-aos-duration="500"
           data-aos-delay="<?= $aosDelay ?>">

            <div class="ap-card-strip strip-<?= $idx ?>"></div>

            <div class="ap-card-body">
                <div class="ap-favicon-wrap">
                    <div class="ap-favicon ic-<?= $idx ?>">
                        <i class="bi <?= $icon ?>"></i>
                    </div>
                    <div class="ap-online-dot" title="Tersedia"></div>
                </div>
                <div class="ap-card-info">
                    <div class="ap-app-name"><?= esc($app['nama_aplikasi']) ?></div>
                    <div class="ap-app-domain"><?= esc($domain) ?></div>
                </div>
            </div>

            <div class="ap-card-footer">
                <span class="ap-badge-free">Tersedia</span>
                <span class="ap-open-btn">
                    Buka <i class="bi bi-arrow-right-short" style="font-size:15px"></i>
                </span>
            </div>

        </a>
        <?php endforeach; ?>

        <div id="noResult">
            <i class="bi bi-search" style="font-size:32px;display:block;margin-bottom:10px;opacity:.35"></i>
            Aplikasi "<strong id="noResultQ"></strong>" tidak ditemukan.
        </div>
    </div>

    <?php else: ?>

    <div class="ap-grid" data-aos="fade-up" data-aos-delay="200">
        <div class="ap-empty">
            <div class="ap-empty-icon"><i class="bi bi-grid"></i></div>
            <h5>Belum Ada Aplikasi</h5>
            <p>Kamu belum mendapat akses ke aplikasi apapun.<br>Hubungi pengajar untuk mendapatkan akses.</p>
        </div>
    </div>

    <?php endif; ?>

</div>

<!-- AOS JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
AOS.init({ once: true, easing: 'ease-out-cubic', offset: 60 });

function filterAplikasi() {
    const q     = document.getElementById('apSearch').value.toLowerCase().trim();
    const cards = document.querySelectorAll('#apGrid .ap-card[data-name]');
    let visible = 0;

    cards.forEach(card => {
        const match = card.dataset.name.includes(q);
        card.style.display = match ? '' : 'none';
        if (match) visible++;
    });

    const noRes = document.getElementById('noResult');
    noRes.style.display = visible === 0 ? 'block' : 'none';
    if (document.getElementById('noResultQ'))
        document.getElementById('noResultQ').textContent = q;
}
</script>

<?= $this->endSection() ?>
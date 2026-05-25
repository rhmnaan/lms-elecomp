<?php
// Deteksi role user dari session
$userRole = session()->get('role') ?? 'peserta';
$layoutPath = ($userRole === 'pengajar') 
    ? 'Dashboard/Pengajar/layout_pengajar' 
    : 'Dashboard/Peserta/layout_peserta';
?>
<?= $this->extend($layoutPath); ?>
<?= $this->section('content'); ?>

<?php
$labelSatuan     = $labelSatuan     ?? '';
$ukuranKontainer = $ukuranKontainer ?? [];
$exwork          = $exwork          ?? [];
$fob             = $fob             ?? [];
$cfr             = $cfr             ?? [];
$cif             = $cif             ?? [];

// Route base juga disesuaikan dengan role
$userRole  = session()->get('role') ?? 'peserta';
$routeBase = ($userRole === 'pengajar') 
    ? 'dashboard/pengajar/kalkulator' 
    : 'dashboard/peserta/kalkulator';

$sections = [
    [
        'title'        => 'Exwork Form',
        'badge'        => 'Step 1',
        'key'          => 'exwork',
        'data'         => $exwork,
        'field_name'   => 'komponen_exwork',
        'field_id'     => 'id_exwork',
        'result_class' => 'result-harga-exwork',
        'result_label' => 'Rekomendasi Harga Exwork',
        'extra_input'  => 'hargaExwork',
        'extra_label'  => null,
        'delay'        => 60,
        'nama_field'   => 'komponenExwork',
        'biaya_field'  => 'biayaExwork',
        'css_inp'      => 'inp-exwork',
        'defaults'     => [
            'Biaya Handling Produk Kemasan',
        ],
    ],
    [
        'title'        => 'FOB Form',
        'badge'        => 'Step 2',
        'key'          => 'fob',
        'data'         => $fob,
        'field_name'   => 'komponen_fob',
        'field_id'     => 'id_fob',
        'result_class' => 'result-harga-fob',
        'result_label' => 'Rekomendasi Harga FOB',
        'extra_input'  => 'hargaFOB',
        'extra_label'  => 'Harga Exwork',
        'delay'        => 80,
        'nama_field'   => 'komponenFOB',
        'biaya_field'  => 'biayaFOB',
        'css_inp'      => 'inp-fob',
        'defaults'     => [
            'Transportasi dan Penanganan Barang Ekspor (Jasa EMKL)',
            'Bea Keluar (Jika Ada, jika tidak ada tulis 0)',
            'Biaya Bank',
            'Biaya Lain-Lain',
            'Biaya Komisi Agent 2-5% (Jika Ada, jika tidak ada tulis 0)',
        ],
    ],
    [
        'title'        => 'CFR Form',
        'badge'        => 'Step 3',
        'key'          => 'cfr',
        'data'         => $cfr,
        'field_name'   => 'komponen_cfr',
        'field_id'     => 'id_cfr',
        'result_class' => 'result-harga-cfr',
        'result_label' => 'Rekomendasi Harga CFR',
        'extra_input'  => 'hargaCFR',
        'extra_label'  => 'Harga FOB',
        'delay'        => 100,
        'nama_field'   => 'komponenCFR',
        'biaya_field'  => 'biayaCFR',
        'css_inp'      => 'inp-cfr',
        'defaults'     => [
            'Freight (Sesuai Negara Tujuan Ekspor)',
        ],
    ],
    [
        'title'        => 'CIF Form',
        'badge'        => 'Step 4',
        'key'          => 'cif',
        'data'         => $cif,
        'field_name'   => 'komponen_cif',
        'field_id'     => 'id_cif',
        'result_class' => 'result-harga-cif',
        'result_label' => 'Rekomendasi Harga CIF',
        'extra_input'  => null,
        'extra_label'  => 'Harga CFR',
        'delay'        => 120,
        'nama_field'   => 'komponenCIF',
        'biaya_field'  => 'biayaCIF',
        'css_inp'      => 'inp-cif',
        'defaults'     => [
            'Asuransi Cargo',
        ],
    ],
];

// Kumpulkan section yang masih kosong untuk auto-insert via JS
$needsAutoInsert = [];
foreach ($sections as $s) {
    if (empty($s['data'])) {
        $needsAutoInsert[] = [
            'key'      => $s['key'],
            'url'      => base_url($routeBase . '/' . $s['key'] . '/save-all'),
            'nama'     => $s['nama_field'],
            'biaya'    => $s['biaya_field'],
            'defaults' => $s['defaults'],
        ];
    }
}

// Breadcrumb juga disesuaikan dengan role
$berandaUrl = ($userRole === 'pengajar') 
    ? base_url('dashboard/pengajar/beranda') 
    : base_url('dashboard/peserta/beranda');
$aplikasiUrl = ($userRole === 'pengajar') 
    ? base_url('dashboard/pengajar/aplikasi') 
    : base_url('dashboard/peserta/aplikasi');
?>

<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Lora:ital,wght@0,400;0,600;1,400&display=swap" rel="stylesheet"/>

<style>
:root {
    --brand:       #03AADE;
    --brand-rgb:   3, 170, 222;
    --brand-dark:  #0288b8;
    --ink:         #111827;
    --ink-soft:    #374151;
    --muted:       #9ca3af;
    --surface:     #ffffff;
    --ground:      #f8fafc;
    --border:      #e5e7eb;
    --border-soft: #f1f5f9;
    --ff-display:  'Outfit', sans-serif;
    --ff-serif:    'Lora', serif;
    --shadow-sm:   0 1px 3px rgba(0,0,0,.06);
    --shadow-md:   0 4px 16px rgba(0,0,0,.07);
}
*, *::before, *::after { box-sizing: border-box; }

/* ── HERO ── */
.calc-hero {
    position: relative;
    background: linear-gradient(135deg, #eff6ff 0%, #f5f3ff 100%);
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(15 23 42 / 0.04)'%3e%3cpath d='M0 .5H31.5V32'/%3e%3c/svg%3e");
    padding: 52px 0 44px;
    text-align: center;
    overflow: hidden;
    border-radius: 0 0 28px 28px;
    margin-bottom: 36px;
}
.ch-blob { position:absolute;border-radius:50%;filter:blur(80px);opacity:.5;pointer-events:none;animation:chblob 7s ease-in-out infinite; }
.ch-blob-1 { width:300px;height:300px;background:#bae6fd;top:-70px;left:-50px; }
.ch-blob-2 { width:240px;height:240px;background:#c7d2fe;top:-30px;right:-30px;animation-delay:2s; }
.ch-blob-3 { width:180px;height:180px;background:#ddd6fe;bottom:-40px;left:25%;animation-delay:4s; }
@keyframes chblob { 0%,100%{transform:translate(0,0) scale(1);}33%{transform:translate(24px,-38px) scale(1.07);}66%{transform:translate(-14px,14px) scale(.94);} }

.calc-eyebrow {
    display:inline-flex;align-items:center;gap:8px;padding:5px 14px;
    border-radius:9999px;background:#eff6ff;border:1px solid #dbeafe;
    color:var(--brand);font-size:.7rem;font-weight:800;letter-spacing:.1em;
    text-transform:uppercase;margin-bottom:12px;font-family:var(--ff-display);
}
.ping-dot { position:relative;width:8px;height:8px;display:inline-block; }
.ping-dot::before { content:'';position:absolute;inset:0;border-radius:50%;background:var(--brand);animation:ping 1.5s cubic-bezier(0,0,.2,1) infinite; }
.ping-dot::after  { content:'';position:absolute;inset:0;border-radius:50%;background:var(--brand); }
@keyframes ping { 75%,100%{transform:scale(2.4);opacity:0;} }

.calc-hero-title {
    font-family:var(--ff-display);font-weight:800;
    font-size:clamp(1.7rem,4vw,2.8rem);line-height:1.05;
    letter-spacing:-1.5px;color:#111827;margin-bottom:10px;
}
.calc-hero-title .grad {
    background:linear-gradient(135deg,var(--brand) 0%,#7c3aed 100%);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.calc-hero-sub {
    font-family:var(--ff-serif);font-style:italic;font-size:.92rem;
    color:#4b5563;line-height:1.7;max-width:500px;margin:0 auto;
}
.sec-rule { width:36px;height:3px;background:var(--brand);border-radius:2px;margin:0 auto 14px; }

/* ── BREADCRUMB ── */
.calc-breadcrumb {
    display:flex;align-items:center;gap:6px;
    font-family:var(--ff-display);font-size:.78rem;color:var(--muted);
    margin-bottom:24px;
}
.calc-breadcrumb a { color:var(--brand);text-decoration:none; }
.calc-breadcrumb a:hover { text-decoration:underline; }
.calc-breadcrumb .sep { font-size:.65rem; }

/* ── BODY ── */
.calc-wrap  { padding: 0 0 80px; }
.calc-inner { max-width:860px; margin:0 auto; padding:0 4px; }

/* ── CARDS ── */
.global-inputs-card,
.calc-section-card {
    background:var(--surface);border-radius:18px;box-shadow:var(--shadow-md);
    padding:28px 32px;margin-bottom:24px;border:1px solid var(--border-soft);
}
.calc-section-card { position:relative;overflow:hidden; }
.calc-section-card::before {
    content:'';position:absolute;left:0;top:20px;bottom:20px;width:4px;
    background:linear-gradient(to bottom,var(--brand),#7c3aed);border-radius:0 4px 4px 0;
}
.section-label {
    font-family:var(--ff-display);font-size:.63rem;font-weight:700;letter-spacing:.15em;
    text-transform:uppercase;color:var(--muted);margin-bottom:16px;
    display:flex;align-items:center;gap:10px;
}
.section-label::after { content:'';flex:1;height:1px;background:var(--border); }
.calc-section-title {
    font-family:var(--ff-display);font-weight:800;font-size:1.15rem;
    color:var(--ink);margin-bottom:4px;display:flex;align-items:center;gap:10px;
}
.calc-section-badge {
    font-size:.6rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
    padding:3px 9px;border-radius:6px;background:rgba(var(--brand-rgb),.1);color:var(--brand);
}
.calc-section-divider { height:1px;background:var(--border-soft);margin:14px 0; }
.text-danger-note { font-family:var(--ff-serif);font-style:italic;font-size:.8rem;color:#ef4444;margin-bottom:12px; }

/* ── FORM ── */
.form-label-custom { font-family:var(--ff-display);font-size:.8rem;font-weight:600;color:var(--ink-soft);margin-bottom:5px;display:block; }
.form-control, .form-select {
    font-family:var(--ff-display)!important;font-size:.87rem!important;
    border:1.5px solid var(--border)!important;border-radius:10px!important;
    padding:9px 12px!important;background:var(--surface)!important;color:var(--ink)!important;
    transition:border-color .2s,box-shadow .2s!important;
}
.form-control:focus,.form-select:focus {
    border-color:var(--brand)!important;box-shadow:0 0 0 3px rgba(var(--brand-rgb),.12)!important;outline:none!important;
}
.input-group-text {
    font-family:var(--ff-display)!important;font-size:.78rem!important;font-weight:600!important;
    background:var(--ground)!important;border:1.5px solid var(--border)!important;
    color:var(--muted)!important;border-radius:10px!important;
}

/* ── TABLE ── */
.table-wrap { border-radius:12px;overflow:hidden;border:1.5px solid var(--border);margin-bottom:14px; }
.table { width:100%;table-layout:auto;font-family:var(--ff-display);font-size:.85rem;border-collapse:separate!important;border-spacing:0!important;margin:0!important; }
.table thead tr th {
    background:var(--ink)!important;color:#fff!important;font-weight:700!important;
    font-size:.68rem!important;letter-spacing:.08em!important;text-transform:uppercase!important;
    padding:11px 14px!important;border:none!important;white-space:nowrap;
}
.table thead tr th:first-child { border-radius:10px 0 0 0!important; }
.table thead tr th:last-child  { border-radius:0 10px 0 0!important; }
.table tbody tr td {
    vertical-align:middle!important;padding:9px 12px!important;border:none!important;
    border-bottom:1px solid var(--border-soft)!important;background:var(--surface);color:var(--ink-soft);
}
.table tbody tr:hover td { background:#f0f9ff; }
.table tbody tr:last-child td { border-bottom:none!important; }
.table tbody tr:last-child td:first-child { border-radius:0 0 0 10px!important; }
.table tbody tr:last-child td:last-child  { border-radius:0 0 10px 0!important; }

/* ── BUTTONS ── */
.btn-add-komponen {
    display:inline-flex;align-items:center;gap:6px;background:var(--brand);color:#fff;
    font-family:var(--ff-display);font-weight:700;font-size:.76rem;border:none;border-radius:10px;
    padding:8px 15px;cursor:pointer;transition:background .25s,transform .2s,box-shadow .2s;
    box-shadow:0 4px 12px rgba(var(--brand-rgb),.25);
}
.btn-add-komponen:hover { background:var(--brand-dark);transform:translateY(-2px);color:#fff; }
.btn-hapus-baris {
    display:inline-flex;align-items:center;justify-content:center;
    background:#fee2e2;color:#dc2626;border:none;border-radius:8px;
    padding:6px 10px;font-size:.76rem;cursor:pointer;transition:background .2s;white-space:nowrap;
}
.btn-hapus-baris:hover { background:#fca5a5;color:#991b1b; }
.btn-simpan-komponen {
    display:none;background:#22c55e!important;color:#fff!important;
    font-family:var(--ff-display)!important;font-weight:700!important;font-size:.76rem!important;
    border:none!important;border-radius:10px!important;padding:8px 15px!important;cursor:pointer!important;
    transition:background .25s,transform .2s!important;
}
.btn-simpan-komponen:hover { background:#16a34a!important;transform:translateY(-2px)!important;color:#fff!important; }

/* ── RESULT BADGE ── */
.result-badge {
    display:inline-flex;align-items:center;gap:10px;width:100%;
    background:rgba(var(--brand-rgb),.07);border:1.5px solid rgba(var(--brand-rgb),.18);
    border-radius:12px;padding:11px 18px;margin-top:14px;
    font-family:var(--ff-display);font-weight:700;font-size:.93rem;color:var(--brand);
}
.komponen-container { display:none; }
.komponen-container .card {
    border-radius:12px!important;border:1.5px solid var(--border)!important;
    box-shadow:var(--shadow-sm)!important;background:var(--ground)!important;
}
#satuanStatus { font-size:.74rem;margin-top:4px; }

/* ── LOADING ROW ── */
@keyframes spin { to { transform:rotate(360deg); } }
.loading-spinner-inline {
    width:16px;height:16px;border-radius:50%;
    border:2px solid #e5e7eb;border-top-color:var(--brand);
    animation:spin .8s linear infinite;display:inline-block;
}

/* ── AUTO-INSERT OVERLAY ── */
.auto-insert-overlay {
    position:fixed;inset:0;z-index:9999;
    background:rgba(255,255,255,.88);backdrop-filter:blur(8px);
    display:flex;flex-direction:column;align-items:center;justify-content:center;gap:16px;
}
.auto-insert-spinner {
    width:56px;height:56px;border-radius:50%;
    border:4px solid #e5e7eb;border-top-color:var(--brand);
    animation:spin .75s linear infinite;
}
.auto-insert-text {
    font-family:var(--ff-display);font-weight:800;font-size:1rem;color:var(--ink);
}
.auto-insert-sub {
    font-family:var(--ff-serif);font-style:italic;font-size:.82rem;color:var(--muted);
}
.auto-insert-steps {
    display:flex;flex-direction:column;gap:6px;margin-top:4px;
}
.auto-insert-step {
    font-family:var(--ff-display);font-size:.75rem;color:var(--muted);
    display:flex;align-items:center;gap:8px;
}
.auto-insert-step.done  { color:#16a34a; }
.auto-insert-step.active{ color:var(--brand);font-weight:700; }
.step-dot {
    width:8px;height:8px;border-radius:50%;background:var(--muted);flex-shrink:0;
}
.auto-insert-step.done  .step-dot { background:#16a34a; }
.auto-insert-step.active .step-dot { background:var(--brand);animation:ping 1s infinite; }

@media (max-width:768px) {
    .calc-section-card, .global-inputs-card { padding:18px 14px; }
    .calc-hero { padding:32px 0 28px; }
}
</style>

<!-- ═══════════ HERO ═══════════ -->
<div class="calc-hero">
    <div class="ch-blob ch-blob-1"></div>
    <div class="ch-blob ch-blob-2"></div>
    <div class="ch-blob ch-blob-3"></div>
    <div class="container position-relative" style="z-index:1;" data-aos="fade-up" data-aos-duration="500">
        <div class="calc-eyebrow"><span class="ping-dot"></span> Aplikasi Pendukung</div>
        <h1 class="calc-hero-title">Kalkulator <span class="grad">Ekspor</span></h1>
        <div class="sec-rule"></div>
        <p class="calc-hero-sub">Hitung harga Exwork, FOB, CFR, dan CIF produk ekspor Anda</p>
    </div>
</div>

<!-- ═══════════ BODY ═══════════ -->
<div class="calc-wrap">
    <div class="calc-inner">

        <!-- Breadcrumb -->
        <div class="calc-breadcrumb" data-aos="fade-right" data-aos-duration="400">
            <a href="<?= $berandaUrl ?>">
                <i class="bi bi-house-fill"></i> Beranda
            </a>
            <span class="sep"><i class="bi bi-chevron-right"></i></span>
            <a href="<?= $aplikasiUrl ?>">Aplikasi Pendukung</a>
            <span class="sep"><i class="bi bi-chevron-right"></i></span>
            <span>Kalkulator Ekspor</span>
        </div>

        <!-- Global Inputs -->
        <div class="global-inputs-card" data-aos="fade-up">
            <p class="section-label">Informasi Produk</p>
            <div class="form-group mb-3">
                <label class="form-label-custom" for="namaProduk">Nama Produk</label>
                <input type="text" class="form-control" id="namaProduk"
                    placeholder="Masukkan Nama Produk" autocomplete="off">
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label-custom" for="ukuran_kontainer">Ukuran Kontainer</label>
                    <select class="form-control" id="ukuran_kontainer">
                        <option value="">Pilih Ukuran Kontainer</option>
                        <?php if (!empty($ukuranKontainer)): foreach ($ukuranKontainer as $uk): ?>
                            <option value="<?= esc($uk['nama']) ?>"><?= esc($uk['nama']) ?></option>
                        <?php endforeach; else: ?>
                            <option value="20 Feet">20 Feet</option>
                            <option value="40 Feet">40 Feet</option>
                            <option value="40 Feet HC">40 Feet HC</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom" for="satuan">Satuan</label>
                    <input type="text" class="form-control" id="satuan"
                        placeholder="cth: pcs, kg, karton"
                        value="<?= esc($labelSatuan) ?>" autocomplete="off">
                    <small class="text-muted d-block mt-1" id="satuanStatus"></small>
                </div>
            </div>
        </div>

        <!-- ═══════════ LOOP SECTIONS ═══════════ -->
        <?php foreach ($sections as $s): ?>
        <div class="calc-section-card" data-aos="fade-up" data-aos-delay="<?= $s['delay'] ?>">

            <div class="calc-section-title">
                <?= $s['title'] ?> <span class="calc-section-badge"><?= $s['badge'] ?></span>
            </div>
            <div class="calc-section-divider"></div>

            <!-- Harga dari step sebelumnya -->
            <?php if ($s['extra_label']): ?>
            <div class="col-md-6 mb-3">
                <label class="form-label-custom"
                    for="<?= $s['extra_input'] ?? 'harga'.strtoupper($s['key']) ?>">
                    <?= $s['extra_label'] ?>
                </label>
                <div class="input-group">
                    <span class="input-group-text">Rp.</span>
                    <input type="text" class="form-control"
                        id="<?= $s['extra_input'] ?? 'harga'.strtoupper($s['key']) ?>"
                        placeholder="Otomatis dari step sebelumnya" autocomplete="off" readonly
                        style="background:var(--ground)!important;">
                    <span class="input-group-text satuan-badge"><?= esc($labelSatuan) ?></span>
                </div>
            </div>
            <?php endif; ?>

            <!-- Input khusus Exwork -->
            <?php if ($s['key'] === 'exwork'): ?>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label-custom" id="jumlahBarangLabel" for="jumlahBarang">
                        Jumlah Barang Dalam 1 Kontainer
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="jumlahBarang"
                            placeholder="Masukkan Jumlah" autocomplete="off">
                        <span class="input-group-text satuan-badge"><?= esc($labelSatuan) ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom" for="hpp">Harga Pokok Produksi (HPP)</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input type="text" class="form-control" id="hpp"
                            placeholder="Masukkan HPP" autocomplete="off">
                        <span class="input-group-text satuan-badge"><?= esc($labelSatuan) ?></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label-custom" for="keuntungan">Keuntungan</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input type="text" class="form-control" id="keuntungan"
                            placeholder="Masukkan Keuntungan" autocomplete="off">
                        <span class="input-group-text satuan-badge"><?= esc($labelSatuan) ?></span>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <p class="text-danger-note">* Komponen <?= strtoupper($s['key']) ?> (Sesuaikan dengan kebutuhan)</p>

            <!-- Form -->
            <form action="<?= base_url($routeBase . '/' . $s['key'] . '/save-all') ?>"
                  method="post" id="form<?= strtoupper($s['key']) ?>All">
                <?= csrf_field() ?>
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width:48px">No</th>
                                    <th>Komponen</th>
                                    <th class="text-center">Biaya (Rp.)</th>
                                    <th class="text-center" style="width:80px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody<?= strtoupper($s['key']) ?>">

                                <?php if (!empty($s['data'])): ?>
                                    <?php foreach ($s['data'] as $i => $item): ?>
                                    <tr>
                                        <td class="text-center"><?= $i + 1 ?></td>
                                        <td><?= esc($item[$s['field_name']]) ?></td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="text"
                                                    class="form-control <?= $s['key'] ?>-existing"
                                                    name="<?= $s['key'] ?>_<?= $item[$s['field_id']] ?>"
                                                    value="<?= number_format((int)($item['biaya']??0),0,',','.') ?>"
                                                    placeholder="0" autocomplete="off">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url($routeBase.'/'.$s['key'].'/delete/'.$item[$s['field_id']]) ?>"
                                               class="btn-hapus-baris"
                                               onclick="return confirm('Hapus komponen ini?')">
                                                <i class="bi bi-x-lg"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <!-- Skeleton loading — diganti setelah auto-insert reload -->
                                    <tr>
                                        <td colspan="4" class="text-center"
                                            style="padding:22px!important;color:var(--muted);font-family:var(--ff-display);font-size:.82rem;">
                                            <span class="loading-spinner-inline"></span>
                                            &nbsp;Menyiapkan komponen default...
                                        </td>
                                    </tr>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Baris tambah manual & simpan -->
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-1 mb-1" style="padding:0 2px;">
                    <button type="button" class="btn-add-komponen"
                        id="tambah<?= strtoupper($s['key']) ?>">
                        <i class="bi bi-plus-lg"></i> Tambah Komponen
                    </button>
                    <button type="submit"
                        id="btnSimpan<?= strtoupper($s['key']) ?>"
                        class="btn-simpan-komponen">
                        Simpan Komponen (0)
                    </button>
                </div>
                <div id="container<?= strtoupper($s['key']) ?>" class="komponen-container mt-2"></div>

            </form>

            <!-- Result -->
            <div class="result-badge">
                <i class="fas fa-calculator"></i>
                <span class="<?= $s['result_class'] ?>"><?= $s['result_label'] ?>: —</span>
            </div>

        </div>
        <?php endforeach; ?>

    </div>
</div>

<!-- ═══════════ SCRIPTS ═══════════ -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 550, offset: 30, once: true });

/* ── Namespace localStorage ── */
const USER_ID  = <?= (int)(session()->get('id_users') ?? 0) ?>;
const STORE_NS = `lms_calc_${USER_ID}_`;
const NS = {
    get(k)    { try { return localStorage.getItem(STORE_NS + k); }    catch(e) { return null; } },
    set(k, v) { try { localStorage.setItem(STORE_NS + k, v); }         catch(e) {} },
};

/* ── Helpers format ── */
function formatRupiah(angka) {
    var s = (angka || '').toString().replace(/[^,\d]/g, '');
    var sp = s.split(','), sisa = sp[0].length % 3, rp = sp[0].substr(0, sisa);
    var ribuan = sp[0].substr(sisa).match(/\d{3}/gi);
    if (ribuan) rp += (sisa ? '.' : '') + ribuan.join('.');
    return sp[1] !== undefined ? rp + ',' + sp[1] : rp;
}
function bersihkan(str) { return (str || '').toString().replace(/\./g, '').replace(/[^\d]/g, ''); }
function getSatuan()    { return (document.getElementById('satuan')?.value || '').trim(); }
function debounce(fn, ms) { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); }; }

function updateSatuanBadges() {
    const txt = getSatuan();
    document.querySelectorAll('.satuan-badge').forEach(el => {
        el.textContent = txt; el.style.display = txt ? '' : 'none';
    });
}

const satuanStatus = document.getElementById('satuanStatus');
function setSatuanStatus(text, ok = null) {
    if (!satuanStatus) return;
    satuanStatus.textContent = text || '';
    satuanStatus.className   = ok === true  ? 'text-success d-block mt-1'
                             : ok === false ? 'text-danger d-block mt-1'
                             :                'text-muted d-block mt-1';
}

const autosaveSatuan = debounce(async () => {
    try {
        updateSatuanBadges();
        const val = getSatuan();
        const res = await fetch('<?= base_url($routeBase . '/satuan/upsert-json') ?>', {
            method:  'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
            body:    new URLSearchParams({ satuan: val }),
        });
        const json = await res.json();
        if (res.ok && json.ok) { NS.set('satuan', val); setSatuanStatus('✓ Tersimpan', true); recalcAll(); }
        else setSatuanStatus('Gagal menyimpan', false);
    } catch(e) { setSatuanStatus('', false); }
}, 500);
document.getElementById('satuan')?.addEventListener('input', autosaveSatuan);

document.getElementById('ukuran_kontainer')?.addEventListener('change', function () {
    const label = document.getElementById('jumlahBarangLabel');
    if (label) label.textContent = 'Jumlah Barang Dalam 1 Kontainer' + (this.value ? ' ' + this.value : '');
    saveGlobalState();
});

/* ── Global state ── */
function saveGlobalState() {
    ['namaProduk', 'jumlahBarang', 'hpp', 'keuntungan'].forEach(id => {
        const el = document.getElementById(id); if (!el) return;
        NS.set(id, id === 'namaProduk' ? el.value : bersihkan(el.value));
    });
    (async () => {
        try {
            await fetch('<?= base_url($routeBase . '/state/save') ?>', {
                method:  'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
                body:    new URLSearchParams({
                    nama_produk:   document.getElementById('namaProduk')?.value   || '',
                    jumlah_barang: bersihkan(document.getElementById('jumlahBarang')?.value || ''),
                    hpp:           bersihkan(document.getElementById('hpp')?.value           || ''),
                    keuntungan:    bersihkan(document.getElementById('keuntungan')?.value    || ''),
                }),
            });
        } catch(e) {}
    })();
}

async function restoreState() {
    try {
        const res  = await fetch('<?= base_url($routeBase . '/state/load') ?>', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
        });
        const json = await res.json();
        if (json?.ok && json.data) {
            const d  = json.data;
            const sv = (id, v) => { const el = document.getElementById(id); if (el && !el.value && v) el.value = v; };
            sv('namaProduk',   d.nama_produk);
            sv('jumlahBarang', d.jumlah_barang ? formatRupiah(d.jumlah_barang) : '');
            sv('hpp',          d.hpp           ? formatRupiah(d.hpp)           : '');
            sv('keuntungan',   d.keuntungan    ? formatRupiah(d.keuntungan)    : '');
        }
    } catch(e) {}
    ['namaProduk', 'jumlahBarang', 'hpp', 'keuntungan'].forEach(id => {
        const el = document.getElementById(id); if (!el || el.value) return;
        const v  = NS.get(id); if (v) el.value = id === 'namaProduk' ? v : formatRupiah(v);
    });
    updateSatuanBadges();
    recalcAll();
}

['jumlahBarang', 'hpp', 'keuntungan'].forEach(id => {
    document.getElementById(id)?.addEventListener('keyup', function () {
        this.value = formatRupiah(this.value); recalcAll(); saveGlobalState();
    });
});
document.getElementById('namaProduk')?.addEventListener('keyup', saveGlobalState);

/* ── Live recalc pada biaya existing ── */
document.addEventListener('keyup', function (e) {
    const el = e.target;
    if (el.matches('.exwork-existing,.fob-existing,.cfr-existing,.cif-existing')) {
        el.value = formatRupiah(el.value); recalcAll();
    }
});

/* ── Kalkulasi ── */
function sumInputs(sel) {
    let t = 0;
    document.querySelectorAll(sel).forEach(el => { const v = parseFloat(bersihkan(el.value)); if (v) t += v; });
    return t;
}
function recalcAll() { hitungExwork(); }

function hitungExwork() {
    const jb = parseFloat(bersihkan(document.getElementById('jumlahBarang').value));
    const hp = parseFloat(bersihkan(document.getElementById('hpp').value));
    const un = parseFloat(bersihkan(document.getElementById('keuntungan').value));
    const el = document.querySelector('.result-harga-exwork');
    if (!jb || !hp || !un) { if (el) el.textContent = 'Rekomendasi Harga Exwork: —'; hitungFOB(0); return; }
    const extra = sumInputs('.exwork-existing') + sumInputs('input[name="biayaExwork[]"]');
    const harga = ((hp + un) * jb + extra) / jb;
    const suf   = getSatuan() ? ' / ' + getSatuan() : '';
    if (el) el.textContent = 'Rekomendasi Harga Exwork: Rp. ' + formatRupiah(harga.toFixed(0)) + suf;
    const heEl = document.getElementById('hargaExwork'); if (heEl) heEl.value = formatRupiah(harga.toFixed(0));
    hitungFOB(harga);
}
function hitungFOB(autoHarga = null) {
    const jb   = parseFloat(bersihkan(document.getElementById('jumlahBarang').value));
    const heEl = document.getElementById('hargaExwork');
    const he   = autoHarga !== null ? autoHarga : parseFloat(bersihkan(heEl?.value || ''));
    const el   = document.querySelector('.result-harga-fob');
    if (!jb || !he) { if (el) el.textContent = 'Rekomendasi Harga FOB: —'; hitungCFR(0); return; }
    const extra = sumInputs('.fob-existing') + sumInputs('input[name="biayaFOB[]"]');
    const harga = (he * jb + extra) / jb;
    const suf   = getSatuan() ? ' / ' + getSatuan() : '';
    if (el) el.textContent = 'Rekomendasi Harga FOB: Rp. ' + formatRupiah(harga.toFixed(0)) + suf;
    const hfEl = document.getElementById('hargaFOB'); if (hfEl) hfEl.value = formatRupiah(harga.toFixed(0));
    hitungCFR(harga);
}
function hitungCFR(autoHarga = null) {
    const jb   = parseFloat(bersihkan(document.getElementById('jumlahBarang').value));
    const hfEl = document.getElementById('hargaFOB');
    const hf   = autoHarga !== null ? autoHarga : parseFloat(bersihkan(hfEl?.value || ''));
    const el   = document.querySelector('.result-harga-cfr');
    if (!jb || !hf) { if (el) el.textContent = 'Rekomendasi Harga CFR: —'; hitungCIF(0); return; }
    const extra = sumInputs('.cfr-existing') + sumInputs('input[name="biayaCFR[]"]');
    const harga = (hf * jb + extra) / jb;
    const suf   = getSatuan() ? ' / ' + getSatuan() : '';
    if (el) el.textContent = 'Rekomendasi Harga CFR: Rp. ' + formatRupiah(harga.toFixed(0)) + suf;
    const hcEl = document.getElementById('hargaCFR'); if (hcEl) hcEl.value = formatRupiah(harga.toFixed(0));
    hitungCIF(harga);
}
function hitungCIF(autoHarga = null) {
    const jb   = parseFloat(bersihkan(document.getElementById('jumlahBarang').value));
    const hcEl = document.getElementById('hargaCFR');
    const hc   = autoHarga !== null ? autoHarga : parseFloat(bersihkan(hcEl?.value || ''));
    const el   = document.querySelector('.result-harga-cif');
    if (!jb || !hc) { if (el) el.textContent = 'Rekomendasi Harga CIF: —'; return; }
    const extra = sumInputs('.cif-existing') + sumInputs('input[name="biayaCIF[]"]');
    const harga = (hc * jb + extra) / jb;
    const suf   = getSatuan() ? ' / ' + getSatuan() : '';
    if (el) el.textContent = 'Rekomendasi Harga CIF: Rp. ' + formatRupiah(harga.toFixed(0)) + suf;
}

/* ── Tambah baris manual ── */
function makeAddRow(btnId, containerId, submitBtnId, namaField, biayaField, cssClass) {
    const btnAdd    = document.getElementById(btnId);
    const container = document.getElementById(containerId);
    const btnSubmit = document.getElementById(submitBtnId);
    if (!btnAdd || !container || !btnSubmit) return;

    const updateCounter = () => {
        const n = container.querySelectorAll('.komponen-row').length;
        btnSubmit.textContent   = `Simpan Komponen (${n})`;
        btnSubmit.style.display = n > 0 ? 'inline-block' : 'none';
    };

    btnAdd.addEventListener('click', () => {
        container.style.display = 'block';
        const row = document.createElement('div');
        row.className = 'card p-3 mb-2 komponen-row';
        row.innerHTML = `
            <div class="row g-2 align-items-end">
                <div class="col-12 col-md-6">
                    <label class="form-label-custom">Nama Komponen</label>
                    <input type="text" name="${namaField}" class="form-control"
                        placeholder="Nama Komponen" autocomplete="off" required>
                </div>
                <div class="col-12 col-md-5">
                    <label class="form-label-custom">Biaya (Rp.)</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp.</span>
                        <input type="text" name="${biayaField}"
                            class="form-control ${cssClass}"
                            placeholder="0" inputmode="numeric" autocomplete="off" required>
                    </div>
                </div>
                <div class="col-12 col-md-1">
                    <button type="button" class="btn-hapus-baris w-100">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>`;
        row.querySelector('.' + cssClass).addEventListener('keyup', function () {
            this.value = formatRupiah(this.value); recalcAll();
        });
        row.querySelector('.btn-hapus-baris').addEventListener('click', () => {
            row.remove(); updateCounter();
            if (!container.querySelectorAll('.komponen-row').length) container.style.display = 'none';
            recalcAll();
        });
        container.appendChild(row);
        updateCounter();
    });
}

makeAddRow('tambahEXWORK', 'containerEXWORK', 'btnSimpanEXWORK', 'komponenExwork[]', 'biayaExwork[]', 'inp-exwork');
makeAddRow('tambahFOB',    'containerFOB',    'btnSimpanFOB',    'komponenFOB[]',    'biayaFOB[]',    'inp-fob');
makeAddRow('tambahCFR',    'containerCFR',    'btnSimpanCFR',    'komponenCFR[]',    'biayaCFR[]',    'inp-cfr');
makeAddRow('tambahCIF',    'containerCIF',    'btnSimpanCIF',    'komponenCIF[]',    'biayaCIF[]',    'inp-cif');

/* ── Bersihkan format sebelum submit ── */
[
    ['formEXWORKAll', '.exwork-existing', 'input[name="biayaExwork[]"]'],
    ['formFOBAll',    '.fob-existing',    'input[name="biayaFOB[]"]'],
    ['formCFRAll',    '.cfr-existing',    'input[name="biayaCFR[]"]'],
    ['formCIFAll',    '.cif-existing',    'input[name="biayaCIF[]"]'],
].forEach(([formId, existSel, newSel]) => {
    document.getElementById(formId)?.addEventListener('submit', function () {
        saveGlobalState();
        document.querySelectorAll(existSel + ', ' + newSel).forEach(el => el.value = bersihkan(el.value));
    });
});

/* ════════════════════════════════════════════════════════════
   AUTO-INSERT KOMPONEN DEFAULT
   Jika ada section yang belum punya data di DB,
   kirim POST ke endpoint save-all secara otomatis (tanpa klik),
   lalu reload halaman agar data tampil dari DB.
════════════════════════════════════════════════════════════ */
<?php if (!empty($needsAutoInsert)): ?>

const AUTO_INSERT_QUEUE = <?= json_encode($needsAutoInsert, JSON_UNESCAPED_UNICODE) ?>;
const CSRF_NAME  = '<?= csrf_token() ?>';
const CSRF_HASH  = '<?= csrf_hash() ?>';

function getCsrfHash() {
    // Coba ambil hash terbaru dari hidden input di halaman
    const el = document.querySelector(`input[name="${CSRF_NAME}"]`);
    return el ? el.value : CSRF_HASH;
}

async function runAutoInsert() {
    // Buat overlay loading
    const overlay = document.createElement('div');
    overlay.id = 'autoInsertOverlay';
    overlay.className = 'auto-insert-overlay';

    const stepsHtml = AUTO_INSERT_QUEUE.map((s, i) =>
        `<div class="auto-insert-step ${i === 0 ? 'active' : ''}" id="step_${s.key}">
            <span class="step-dot"></span>
            Menyiapkan komponen <strong>${s.key.toUpperCase()}</strong>
         </div>`
    ).join('');

    overlay.innerHTML = `
        <div class="auto-insert-spinner"></div>
        <div class="auto-insert-text">Menyiapkan Komponen Default</div>
        <div class="auto-insert-sub">Hanya sekali saat pertama kali digunakan</div>
        <div class="auto-insert-steps">${stepsHtml}</div>`;
    document.body.appendChild(overlay);

    let latestCsrf = getCsrfHash();

    for (let i = 0; i < AUTO_INSERT_QUEUE.length; i++) {
        const section = AUTO_INSERT_QUEUE[i];

        // Update status step
        const stepEl = document.getElementById('step_' + section.key);
        if (stepEl) stepEl.className = 'auto-insert-step active';

        const params = new URLSearchParams();
        params.append(CSRF_NAME, latestCsrf);

        section.defaults.forEach(nama => {
            params.append(section.nama + '[]', nama);
            params.append(section.biaya + '[]', '0');
        });

        try {
            const res = await fetch(section.url, {
                method:   'POST',
                headers:  { 'Content-Type': 'application/x-www-form-urlencoded' },
                body:     params.toString(),
                redirect: 'manual',
            });

            // CI4 mengembalikan CSRF token baru di cookie setiap request
            // Ambil dari cookie jika ada, fallback ke value awal
            const newCsrf = document.cookie.match(/csrf_cookie_name=([^;]+)/);
            if (newCsrf) latestCsrf = decodeURIComponent(newCsrf[1]);

        } catch(e) {
            console.warn('Auto-insert gagal untuk:', section.key, e);
        }

        // Tandai step selesai
        if (stepEl) stepEl.className = 'auto-insert-step done';

        // Delay kecil antar request supaya tidak flood
        if (i < AUTO_INSERT_QUEUE.length - 1) {
            await new Promise(r => setTimeout(r, 120));
        }
    }

    // Update teks overlay sebelum reload
    const textEl = overlay.querySelector('.auto-insert-text');
    const subEl  = overlay.querySelector('.auto-insert-sub');
    if (textEl) textEl.textContent = 'Selesai! Memuat halaman...';
    if (subEl)  subEl.textContent  = '';

    // Reload halaman agar semua data tampil dari DB
    setTimeout(() => window.location.reload(), 400);
}

document.addEventListener('DOMContentLoaded', () => {
    restoreState();
    setTimeout(runAutoInsert, 250);
});

<?php else: ?>

document.addEventListener('DOMContentLoaded', restoreState);

<?php endif; ?>
</script>

<?= $this->endSection(); ?>
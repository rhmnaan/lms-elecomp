<?= $this->extend('dashboard/pengajar/layout/app'); ?>
<?= $this->section('content'); ?>

<?php
// Fallback aman
$labelSatuan     = $labelSatuan     ?? '';
$ukuranKontainer = $ukuranKontainer ?? [];
$exwork          = $exwork          ?? [];
$fob             = $fob             ?? [];
$cfr             = $cfr             ?? [];
$cif             = $cif             ?? [];
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
    background: #f3f4f6;
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32' width='32' height='32' fill='none' stroke='rgb(15 23 42 / 0.04)'%3e%3cpath d='M0 .5H31.5V32'/%3e%3c/svg%3e");
    padding: 56px 0 48px;
    text-align: center;
    overflow: hidden;
    border-radius: 0 0 24px 24px;
    margin-bottom: 32px;
}
.ch-blob { position:absolute;border-radius:50%;filter:blur(80px);opacity:.45;pointer-events:none;animation:chblob 7s ease-in-out infinite; }
.ch-blob-1 { width:320px;height:320px;background:#bae6fd;top:-80px;left:-60px; }
.ch-blob-2 { width:260px;height:260px;background:#c7d2fe;top:-40px;right:-40px;animation-delay:2s; }
.ch-blob-3 { width:200px;height:200px;background:#ddd6fe;bottom:-40px;left:22%;animation-delay:4s; }
@keyframes chblob { 0%,100%{transform:translate(0,0) scale(1);}33%{transform:translate(28px,-44px) scale(1.08);}66%{transform:translate(-18px,18px) scale(.93);} }

.calc-eyebrow {
    display:inline-flex;align-items:center;gap:8px;padding:6px 16px;
    border-radius:9999px;background:#eff6ff;border:1px solid #dbeafe;
    color:var(--brand);font-size:.72rem;font-weight:800;letter-spacing:.1em;
    text-transform:uppercase;margin-bottom:14px;font-family:var(--ff-display);
}
.ping-dot { position:relative;width:8px;height:8px;display:inline-block; }
.ping-dot::before { content:'';position:absolute;inset:0;border-radius:50%;background:var(--brand);animation:ping 1.5s cubic-bezier(0,0,.2,1) infinite; }
.ping-dot::after  { content:'';position:absolute;inset:0;border-radius:50%;background:var(--brand); }
@keyframes ping { 75%,100%{transform:scale(2.4);opacity:0;} }

.calc-hero-title {
    font-family:var(--ff-display);font-weight:800;
    font-size:clamp(1.8rem,4vw,3rem);line-height:1.05;
    letter-spacing:-1.5px;color:#111827;margin-bottom:10px;
}
.calc-hero-title .grad {
    background:linear-gradient(135deg,var(--brand) 0%,#7c3aed 100%);
    -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.calc-hero-sub {
    font-family:var(--ff-serif);font-style:italic;font-size:.95rem;
    color:#4b5563;line-height:1.7;max-width:520px;margin:0 auto;
}
.sec-rule { width:42px;height:3px;background:var(--brand);border-radius:2px;margin:0 auto 16px; }

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
    font-family:var(--ff-display);font-size:.65rem;font-weight:700;letter-spacing:.15em;
    text-transform:uppercase;color:var(--muted);margin-bottom:16px;
    display:flex;align-items:center;gap:10px;
}
.section-label::after { content:'';flex:1;height:1px;background:var(--border); }

.calc-section-title {
    font-family:var(--ff-display);font-weight:800;font-size:1.2rem;
    color:var(--ink);margin-bottom:4px;display:flex;align-items:center;gap:10px;
}
.calc-section-badge {
    font-size:.62rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;
    padding:3px 10px;border-radius:6px;background:rgba(var(--brand-rgb),.1);color:var(--brand);
}
.calc-section-divider { height:1px;background:var(--border-soft);margin:16px 0; }
.text-danger-note { font-family:var(--ff-serif);font-style:italic;font-size:.82rem;color:#ef4444;margin-bottom:12px; }

/* ── FORM ── */
.form-label-custom { font-family:var(--ff-display);font-size:.82rem;font-weight:600;color:var(--ink-soft);margin-bottom:6px;display:block; }
.form-control, .form-select {
    font-family:var(--ff-display)!important;font-size:.88rem!important;
    border:1.5px solid var(--border)!important;border-radius:10px!important;
    padding:9px 13px!important;background:var(--surface)!important;color:var(--ink)!important;
    transition:border-color .2s,box-shadow .2s!important;
}
.form-control:focus,.form-select:focus {
    border-color:var(--brand)!important;box-shadow:0 0 0 3px rgba(var(--brand-rgb),.12)!important;outline:none!important;
}
.input-group-text {
    font-family:var(--ff-display)!important;font-size:.8rem!important;font-weight:600!important;
    background:var(--ground)!important;border:1.5px solid var(--border)!important;
    color:var(--muted)!important;border-radius:10px!important;
}

/* ── TABLE ── */
.table-wrap { border-radius:12px;overflow:hidden;border:1.5px solid var(--border);margin-bottom:14px; }
.table { width:100%;table-layout:auto;font-family:var(--ff-display);font-size:.86rem;border-collapse:separate!important;border-spacing:0!important;margin:0!important; }
.table thead tr th {
    background:var(--ink)!important;color:#fff!important;font-weight:700!important;
    font-size:.7rem!important;letter-spacing:.08em!important;text-transform:uppercase!important;
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
.table input.form-control { min-width:110px; }

/* ── BUTTONS ── */
.btn-add-komponen {
    display:inline-flex;align-items:center;gap:7px;background:var(--brand);color:#fff;
    font-family:var(--ff-display);font-weight:700;font-size:.78rem;border:none;border-radius:10px;
    padding:8px 16px;cursor:pointer;transition:background .25s,transform .2s,box-shadow .2s;
    box-shadow:0 4px 14px rgba(var(--brand-rgb),.25);
}
.btn-add-komponen:hover { background:var(--brand-dark);transform:translateY(-2px);box-shadow:0 6px 20px rgba(var(--brand-rgb),.35);color:#fff; }

.btn-hapus-baris {
    display:inline-flex;align-items:center;justify-content:center;
    background:#fee2e2;color:#dc2626;border:none;border-radius:8px;
    padding:6px 11px;font-size:.78rem;cursor:pointer;transition:background .2s;white-space:nowrap;
}
.btn-hapus-baris:hover { background:#fca5a5;color:#991b1b; }

.btn-simpan-komponen {
    display:none;background:#22c55e!important;color:#fff!important;
    font-family:var(--ff-display)!important;font-weight:700!important;font-size:.78rem!important;
    border:none!important;border-radius:10px!important;padding:8px 16px!important;cursor:pointer!important;
    transition:background .25s,transform .2s!important;
}
.btn-simpan-komponen:hover { background:#16a34a!important;transform:translateY(-2px)!important;color:#fff!important; }

/* ── RESULT BADGE ── */
.result-badge {
    display:inline-flex;align-items:center;gap:10px;width:100%;
    background:rgba(var(--brand-rgb),.07);border:1.5px solid rgba(var(--brand-rgb),.18);
    border-radius:12px;padding:11px 18px;margin-top:16px;
    font-family:var(--ff-display);font-weight:700;font-size:.95rem;color:var(--brand);
}

/* ── KOMPONEN CONTAINERS ── */
.komponen-container { display:none; }
.komponen-container .card {
    border-radius:12px!important;border:1.5px solid var(--border)!important;
    box-shadow:var(--shadow-sm)!important;background:var(--ground)!important;
}

#satuanStatus { font-size:.76rem;margin-top:4px; }

/* ── RESPONSIVE ── */
@media (max-width:768px) {
    .calc-section-card, .global-inputs-card { padding:18px 16px; }
    .table { font-size:.78rem; }
    .table th, .table td { padding:7px 9px!important; }
    .table input.form-control { min-width:80px; }
    .calc-hero { padding:36px 0 32px; }
}
@media (max-width:425px) {
    .btn-hapus-baris { width:100%;margin-top:6px; }
    .form-control, .form-select { font-size:.78rem!important;padding:7px 8px!important; }
}
</style>

<!-- ── HERO ── -->
<div class="calc-hero">
    <div class="ch-blob ch-blob-1"></div>
    <div class="ch-blob ch-blob-2"></div>
    <div class="ch-blob ch-blob-3"></div>
    <div class="container position-relative" style="z-index:1;" data-aos="fade-up" data-aos-duration="500">
        <div class="calc-eyebrow"><span class="ping-dot"></span> LMS Elecomp</div>
        <h1 class="calc-hero-title">Kalkulator <span class="grad">Ekspor</span></h1>
        <div class="sec-rule"></div>
        <p class="calc-hero-sub">Hitung harga Exwork, FOB, CFR, dan CIF secara otomatis</p>
    </div>
</div>

<!-- ── BODY ── -->
<div class="calc-wrap">
    <div class="calc-inner">

        <!-- ── GLOBAL INPUTS ── -->
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

        <!-- ══════════════ EXWORK — Step 1 ══════════════ -->
        <div class="calc-section-card" data-aos="fade-up" data-aos-delay="60">
            <div class="calc-section-title">
                Exwork Form <span class="calc-section-badge">Step 1</span>
            </div>
            <div class="calc-section-divider"></div>

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

            <p class="text-danger-note">* Komponen Exwork (Sesuaikan dengan kebutuhan)</p>

            <form action="<?= base_url('dashboard/pengajar/kalkulator/exwork/save-all') ?>"
                  method="post" id="formExworkAll">
                <?= csrf_field() ?>
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table">
                            <thead><tr>
                                <th class="text-center" style="width:50px">No</th>
                                <th>Komponen</th>
                                <th class="text-center">Biaya (Rp.)</th>
                                <th class="text-center" style="width:90px">Aksi</th>
                            </tr></thead>
                            <tbody>
                                <?php if (empty($exwork)): ?>
                                    <tr><td colspan="4" class="text-center"
                                        style="color:var(--muted);font-style:italic;padding:18px!important;">
                                        Belum ada komponen Exwork.
                                    </td></tr>
                                <?php else: foreach ($exwork as $i => $item): ?>
                                    <tr>
                                        <td class="text-center"><?= $i + 1 ?></td>
                                        <td><?= esc($item['komponen_exwork']) ?></td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="text" class="form-control exwork-existing"
                                                    name="exwork_<?= $item['id_exwork'] ?>"
                                                    value="<?= number_format((int)($item['biaya'] ?? 0), 0, ',', '.') ?>"
                                                    placeholder="0" autocomplete="off">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('dashboard/pengajar/kalkulator/exwork/delete/' . $item['id_exwork']) ?>"
                                               class="btn-hapus-baris"
                                               onclick="return confirm('Hapus komponen ini?')">
                                                <i class="bi bi-x-lg"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; ?>
                                <tr>
                                    <td colspan="4" style="background:var(--ground)!important;">
                                        <button type="button" class="btn-add-komponen" id="tambahExwork">
                                            <i class="bi bi-plus-lg"></i> Tambah Komponen
                                        </button>
                                        <div id="containerExwork" class="komponen-container mt-2"></div>
                                        <div class="d-flex justify-content-end mt-2">
                                            <button type="submit" id="btnSimpanExwork" class="btn-simpan-komponen">
                                                Simpan Komponen (0)
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>

            <div class="result-badge">
                <i class="fas fa-calculator"></i>
                <span class="result-harga-exwork">Rekomendasi Harga Exwork: —</span>
            </div>
        </div>

        <!-- ══════════════ FOB — Step 2 ══════════════ -->
        <div class="calc-section-card" data-aos="fade-up" data-aos-delay="80">
            <div class="calc-section-title">
                FOB Form <span class="calc-section-badge">Step 2</span>
            </div>
            <div class="calc-section-divider"></div>

            <div class="col-md-6 mb-3">
                <label class="form-label-custom" for="hargaExwork">Harga Exwork</label>
                <div class="input-group">
                    <span class="input-group-text">Rp.</span>
                    <input type="text" class="form-control" id="hargaExwork"
                        placeholder="Otomatis dari Step 1" autocomplete="off">
                    <span class="input-group-text satuan-badge"><?= esc($labelSatuan) ?></span>
                </div>
            </div>

            <p class="text-danger-note">* Komponen FOB (Sesuaikan dengan kebutuhan)</p>

            <form action="<?= base_url('dashboard/pengajar/kalkulator/fob/save-all') ?>"
                  method="post" id="formFOBAll">
                <?= csrf_field() ?>
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table">
                            <thead><tr>
                                <th class="text-center" style="width:50px">No</th>
                                <th>Komponen</th>
                                <th class="text-center">Biaya (Rp.)</th>
                                <th class="text-center" style="width:90px">Aksi</th>
                            </tr></thead>
                            <tbody>
                                <?php if (empty($fob)): ?>
                                    <tr><td colspan="4" class="text-center"
                                        style="color:var(--muted);font-style:italic;padding:18px!important;">
                                        Belum ada komponen FOB.
                                    </td></tr>
                                <?php else: foreach ($fob as $i => $item): ?>
                                    <tr>
                                        <td class="text-center"><?= $i + 1 ?></td>
                                        <td><?= esc($item['komponen_fob']) ?></td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="text" class="form-control fob-existing"
                                                    name="fob_<?= $item['id_fob'] ?>"
                                                    value="<?= number_format((int)($item['biaya'] ?? 0), 0, ',', '.') ?>"
                                                    placeholder="0" autocomplete="off">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('dashboard/pengajar/kalkulator/fob/delete/' . $item['id_fob']) ?>"
                                               class="btn-hapus-baris"
                                               onclick="return confirm('Hapus komponen ini?')">
                                                <i class="bi bi-x-lg"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; ?>
                                <tr>
                                    <td colspan="4" style="background:var(--ground)!important;">
                                        <button type="button" class="btn-add-komponen" id="tambahFOB">
                                            <i class="bi bi-plus-lg"></i> Tambah Komponen
                                        </button>
                                        <div id="containerFOB" class="komponen-container mt-2"></div>
                                        <div class="d-flex justify-content-end mt-2">
                                            <button type="submit" id="btnSimpanFOB" class="btn-simpan-komponen">
                                                Simpan Komponen (0)
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>

            <div class="result-badge">
                <i class="fas fa-calculator"></i>
                <span class="result-harga-fob">Rekomendasi Harga FOB: —</span>
            </div>
        </div>

        <!-- ══════════════ CFR — Step 3 ══════════════ -->
        <div class="calc-section-card" data-aos="fade-up" data-aos-delay="100">
            <div class="calc-section-title">
                CFR Form <span class="calc-section-badge">Step 3</span>
            </div>
            <div class="calc-section-divider"></div>

            <div class="col-md-6 mb-3">
                <label class="form-label-custom" for="hargaFOB">Harga FOB</label>
                <div class="input-group">
                    <span class="input-group-text">Rp.</span>
                    <input type="text" class="form-control" id="hargaFOB"
                        placeholder="Otomatis dari Step 2" autocomplete="off">
                    <span class="input-group-text satuan-badge"><?= esc($labelSatuan) ?></span>
                </div>
            </div>

            <p class="text-danger-note">* Komponen CFR (Sesuaikan dengan kebutuhan)</p>

            <form action="<?= base_url('dashboard/pengajar/kalkulator/cfr/save-all') ?>"
                  method="post" id="formCFRAll">
                <?= csrf_field() ?>
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table">
                            <thead><tr>
                                <th class="text-center" style="width:50px">No</th>
                                <th>Komponen</th>
                                <th class="text-center">Biaya (Rp.)</th>
                                <th class="text-center" style="width:90px">Aksi</th>
                            </tr></thead>
                            <tbody>
                                <?php if (empty($cfr)): ?>
                                    <tr><td colspan="4" class="text-center"
                                        style="color:var(--muted);font-style:italic;padding:18px!important;">
                                        Belum ada komponen CFR.
                                    </td></tr>
                                <?php else: foreach ($cfr as $i => $item): ?>
                                    <tr>
                                        <td class="text-center"><?= $i + 1 ?></td>
                                        <td><?= esc($item['komponen_cfr']) ?></td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="text" class="form-control cfr-existing"
                                                    name="cfr_<?= $item['id_cfr'] ?>"
                                                    value="<?= number_format((int)($item['biaya'] ?? 0), 0, ',', '.') ?>"
                                                    placeholder="0" autocomplete="off">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('dashboard/pengajar/kalkulator/cfr/delete/' . $item['id_cfr']) ?>"
                                               class="btn-hapus-baris"
                                               onclick="return confirm('Hapus komponen ini?')">
                                                <i class="bi bi-x-lg"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; ?>
                                <tr>
                                    <td colspan="4" style="background:var(--ground)!important;">
                                        <button type="button" class="btn-add-komponen" id="tambahCFR">
                                            <i class="bi bi-plus-lg"></i> Tambah Komponen
                                        </button>
                                        <div id="containerCFR" class="komponen-container mt-2"></div>
                                        <div class="d-flex justify-content-end mt-2">
                                            <button type="submit" id="btnSimpanCFR" class="btn-simpan-komponen">
                                                Simpan Komponen (0)
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>

            <div class="result-badge">
                <i class="fas fa-calculator"></i>
                <span class="result-harga-cfr">Rekomendasi Harga CFR: —</span>
            </div>
        </div>

        <!-- ══════════════ CIF — Step 4 ══════════════ -->
        <div class="calc-section-card" data-aos="fade-up" data-aos-delay="120">
            <div class="calc-section-title">
                CIF Form <span class="calc-section-badge">Step 4</span>
            </div>
            <div class="calc-section-divider"></div>

            <div class="col-md-6 mb-3">
                <label class="form-label-custom" for="hargaCFR">Harga CFR</label>
                <div class="input-group">
                    <span class="input-group-text">Rp.</span>
                    <input type="text" class="form-control" id="hargaCFR"
                        placeholder="Otomatis dari Step 3" autocomplete="off">
                    <span class="input-group-text satuan-badge"><?= esc($labelSatuan) ?></span>
                </div>
            </div>

            <p class="text-danger-note">* Komponen CIF (Sesuaikan dengan kebutuhan)</p>

            <form action="<?= base_url('dashboard/pengajar/kalkulator/cif/save-all') ?>"
                  method="post" id="formCIFAll">
                <?= csrf_field() ?>
                <div class="table-wrap">
                    <div class="table-responsive">
                        <table class="table">
                            <thead><tr>
                                <th class="text-center" style="width:50px">No</th>
                                <th>Komponen</th>
                                <th class="text-center">Biaya (Rp.)</th>
                                <th class="text-center" style="width:90px">Aksi</th>
                            </tr></thead>
                            <tbody>
                                <?php if (empty($cif)): ?>
                                    <tr><td colspan="4" class="text-center"
                                        style="color:var(--muted);font-style:italic;padding:18px!important;">
                                        Belum ada komponen CIF.
                                    </td></tr>
                                <?php else: foreach ($cif as $i => $item): ?>
                                    <tr>
                                        <td class="text-center"><?= $i + 1 ?></td>
                                        <td><?= esc($item['komponen_cif']) ?></td>
                                        <td>
                                            <div class="input-group">
                                                <span class="input-group-text">Rp.</span>
                                                <input type="text" class="form-control cif-existing"
                                                    name="cif_<?= $item['id_cif'] ?>"
                                                    value="<?= number_format((int)($item['biaya'] ?? 0), 0, ',', '.') ?>"
                                                    placeholder="0" autocomplete="off">
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url('dashboard/pengajar/kalkulator/cif/delete/' . $item['id_cif']) ?>"
                                               class="btn-hapus-baris"
                                               onclick="return confirm('Hapus komponen ini?')">
                                                <i class="bi bi-x-lg"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; ?>
                                <tr>
                                    <td colspan="4" style="background:var(--ground)!important;">
                                        <button type="button" class="btn-add-komponen" id="tambahCIF">
                                            <i class="bi bi-plus-lg"></i> Tambah Komponen
                                        </button>
                                        <div id="containerCIF" class="komponen-container mt-2"></div>
                                        <div class="d-flex justify-content-end mt-2">
                                            <button type="submit" id="btnSimpanCIF" class="btn-simpan-komponen">
                                                Simpan Komponen (0)
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>

            <div class="result-badge">
                <i class="fas fa-calculator"></i>
                <span class="result-harga-cif">Rekomendasi Harga CIF: —</span>
            </div>
        </div>

    </div><!-- /calc-inner -->
</div><!-- /calc-wrap -->

<!-- ── SCRIPTS ── -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 600, offset: 30, once: true, easing: 'ease-out-quart' });

// ── USER CONTEXT ──
const USER_ID  = <?= (int)(session()->get('id_users') ?? 0) ?>;
const STORE_NS = `lms_calc_${USER_ID}_`;
const NS = {
    get(k)    { try { return localStorage.getItem(STORE_NS + k); }     catch(e){ return null; } },
    set(k, v) { try { localStorage.setItem(STORE_NS + k, v); }          catch(e){} },
};

// ── UTILITIES ──
function formatRupiah(angka) {
    var s = (angka||'').toString().replace(/[^,\d]/g,'');
    var sp = s.split(','), sisa = sp[0].length % 3, rp = sp[0].substr(0, sisa);
    var ribuan = sp[0].substr(sisa).match(/\d{3}/gi);
    if (ribuan) { rp += (sisa ? '.' : '') + ribuan.join('.'); }
    return sp[1] !== undefined ? rp + ',' + sp[1] : rp;
}
function bersihkan(str) { return (str||'').toString().replace(/\./g,'').replace(/[^\d]/g,''); }
function getSatuan()    { return (document.getElementById('satuan')?.value||'').trim(); }
function debounce(fn, ms) { let t; return (...a) => { clearTimeout(t); t = setTimeout(() => fn(...a), ms); }; }

function updateSatuanBadges() {
    const txt = getSatuan();
    document.querySelectorAll('.satuan-badge').forEach(el => {
        el.textContent = txt;
        el.style.display = txt ? '' : 'none';
    });
}

// ── SATUAN AUTO-SAVE ──
const satuanStatus = document.getElementById('satuanStatus');
function setSatuanStatus(text, ok = null) {
    if (!satuanStatus) return;
    satuanStatus.textContent = text || '';
    satuanStatus.className = ok === true  ? 'text-success d-block mt-1'
                           : ok === false ? 'text-danger d-block mt-1'
                           : 'text-muted d-block mt-1';
}

const autosaveSatuan = debounce(async () => {
    try {
        updateSatuanBadges();
        const val = getSatuan();
        const body = new URLSearchParams({ satuan: val });
        const res  = await fetch('<?= base_url('dashboard/pengajar/kalkulator/satuan/upsert-json') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
            body
        });
        const json = await res.json();
        if (res.ok && json.ok) { NS.set('satuan', val); setSatuanStatus('✓ Tersimpan', true); recalcAll(); }
        else { setSatuanStatus('Gagal menyimpan', false); }
    } catch(e) { setSatuanStatus('', false); }
}, 500);

document.getElementById('satuan')?.addEventListener('input', autosaveSatuan);

// ── UKURAN KONTAINER ──
document.getElementById('ukuran_kontainer')?.addEventListener('change', function() {
    const label = document.getElementById('jumlahBarangLabel');
    if (label) label.textContent = 'Jumlah Barang Dalam 1 Kontainer' + (this.value ? ' ' + this.value : '');
    saveGlobalState();
});

// ── STATE SAVE/LOAD ──
function saveGlobalState() {
    ['namaProduk','jumlahBarang','hpp','keuntungan'].forEach(id => {
        const el = document.getElementById(id);
        if (!el) return;
        NS.set(id, id === 'namaProduk' ? el.value : bersihkan(el.value));
    });
    (async () => {
        try {
            const body = new URLSearchParams({
                nama_produk:   document.getElementById('namaProduk')?.value    || '',
                jumlah_barang: bersihkan(document.getElementById('jumlahBarang')?.value || ''),
                hpp:           bersihkan(document.getElementById('hpp')?.value           || ''),
                keuntungan:    bersihkan(document.getElementById('keuntungan')?.value    || ''),
            });
            await fetch('<?= base_url('dashboard/pengajar/kalkulator/state/save') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded', 'X-Requested-With': 'XMLHttpRequest' },
                body
            });
        } catch(e) {}
    })();
}

async function restoreState() {
    // 1. Server
    try {
        const res  = await fetch('<?= base_url('dashboard/pengajar/kalkulator/state/load') ?>', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        const json = await res.json();
        if (json?.ok && json.data) {
            const d = json.data;
            const setVal = (id, v) => { const el = document.getElementById(id); if (el && !el.value && v) el.value = v; };
            setVal('namaProduk',   d.nama_produk);
            setVal('jumlahBarang', d.jumlah_barang ? formatRupiah(d.jumlah_barang) : '');
            setVal('hpp',          d.hpp           ? formatRupiah(d.hpp)           : '');
            setVal('keuntungan',   d.keuntungan    ? formatRupiah(d.keuntungan)    : '');
        }
    } catch(e) {}
    // 2. Fallback localStorage
    ['namaProduk','jumlahBarang','hpp','keuntungan'].forEach(id => {
        const el = document.getElementById(id); if (!el || el.value) return;
        const v = NS.get(id); if (v) el.value = id === 'namaProduk' ? v : formatRupiah(v);
    });
    updateSatuanBadges();
    recalcAll();
}

// ── KALKULASI ──
function recalcAll() { hitungExwork(); hitungFOB(); hitungCFR(); hitungCIF(); }

function sumInputs(selector) {
    let total = 0;
    document.querySelectorAll(selector).forEach(el => {
        const v = parseFloat(bersihkan(el.value)); if (v) total += v;
    });
    return total;
}

function hitungExwork() {
    const jb = parseFloat(bersihkan(document.getElementById('jumlahBarang').value));
    const hp = parseFloat(bersihkan(document.getElementById('hpp').value));
    const un = parseFloat(bersihkan(document.getElementById('keuntungan').value));
    const el = document.querySelector('.result-harga-exwork');
    if (!jb || !hp || !un) { if (el) el.textContent = 'Rekomendasi Harga Exwork: —'; return; }
    const extra = sumInputs('.exwork-existing') + sumInputs('input[name="biayaExwork[]"]');
    const harga = ((hp + un) * jb + extra) / jb;
    const suf   = getSatuan() ? ' / ' + getSatuan() : '';
    if (el) el.textContent = 'Rekomendasi Harga Exwork: Rp. ' + formatRupiah(harga.toFixed(0)) + suf;
    const heEl = document.getElementById('hargaExwork'); if (heEl) heEl.value = formatRupiah(harga.toFixed(0));
    hitungFOB();
}

function hitungFOB() {
    const jb = parseFloat(bersihkan(document.getElementById('jumlahBarang').value));
    const he = parseFloat(bersihkan(document.getElementById('hargaExwork').value));
    const el = document.querySelector('.result-harga-fob');
    if (!jb || !he) { if (el) el.textContent = 'Rekomendasi Harga FOB: —'; return; }
    const extra = sumInputs('.fob-existing') + sumInputs('input[name="biayaFOB[]"]');
    const harga = (he * jb + extra) / jb;
    const suf   = getSatuan() ? ' / ' + getSatuan() : '';
    if (el) el.textContent = 'Rekomendasi Harga FOB: Rp. ' + formatRupiah(harga.toFixed(0)) + suf;
    const hfEl = document.getElementById('hargaFOB'); if (hfEl) hfEl.value = formatRupiah(harga.toFixed(0));
    hitungCFR();
}

function hitungCFR() {
    const jb = parseFloat(bersihkan(document.getElementById('jumlahBarang').value));
    const hf = parseFloat(bersihkan(document.getElementById('hargaFOB').value));
    const el = document.querySelector('.result-harga-cfr');
    if (!jb || !hf) { if (el) el.textContent = 'Rekomendasi Harga CFR: —'; return; }
    const extra = sumInputs('.cfr-existing') + sumInputs('input[name="biayaCFR[]"]');
    const harga = (hf * jb + extra) / jb;
    const suf   = getSatuan() ? ' / ' + getSatuan() : '';
    if (el) el.textContent = 'Rekomendasi Harga CFR: Rp. ' + formatRupiah(harga.toFixed(0)) + suf;
    const hcEl = document.getElementById('hargaCFR'); if (hcEl) hcEl.value = formatRupiah(harga.toFixed(0));
    hitungCIF();
}

function hitungCIF() {
    const jb = parseFloat(bersihkan(document.getElementById('jumlahBarang').value));
    const hc = parseFloat(bersihkan(document.getElementById('hargaCFR').value));
    const el = document.querySelector('.result-harga-cif');
    if (!jb || !hc) { if (el) el.textContent = 'Rekomendasi Harga CIF: —'; return; }
    const extra = sumInputs('.cif-existing') + sumInputs('input[name="biayaCIF[]"]');
    const harga = (hc * jb + extra) / jb;
    const suf   = getSatuan() ? ' / ' + getSatuan() : '';
    if (el) el.textContent = 'Rekomendasi Harga CIF: Rp. ' + formatRupiah(harga.toFixed(0)) + suf;
}

// ── INPUT LISTENERS ──
['jumlahBarang','hpp','keuntungan','hargaExwork','hargaFOB','hargaCFR'].forEach(id => {
    document.getElementById(id)?.addEventListener('keyup', function() {
        this.value = formatRupiah(this.value);
        recalcAll();
        if (['jumlahBarang','hpp','keuntungan'].includes(id)) saveGlobalState();
    });
});
document.getElementById('namaProduk')?.addEventListener('keyup', saveGlobalState);

// ── ADD ROW FACTORY ──
function makeAddRow(btnId, containerId, submitBtnId, namaField, biayaField, cssClass) {
    const btnAdd    = document.getElementById(btnId);
    const container = document.getElementById(containerId);
    const btnSubmit = document.getElementById(submitBtnId);
    if (!btnAdd || !container || !btnSubmit) return;

    const updateCounter = () => {
        const n = container.querySelectorAll('.komponen-row').length;
        btnSubmit.textContent = `Simpan Komponen (${n})`;
    };

    btnAdd.addEventListener('click', () => {
        container.style.display = 'block';
        btnSubmit.style.display = 'inline-block';

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
                    <input type="text" name="${biayaField}" class="form-control ${cssClass}"
                        placeholder="0" inputmode="numeric" autocomplete="off" required>
                </div>
            </div>
            <div class="col-12 col-md-1">
                <button type="button" class="btn-hapus-baris w-100">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>
        </div>`;

        row.querySelector('.' + cssClass).addEventListener('keyup', function() {
            this.value = formatRupiah(this.value);
            recalcAll();
        });
        row.querySelector('.btn-hapus-baris').addEventListener('click', () => {
            row.remove();
            updateCounter();
            if (!container.querySelectorAll('.komponen-row').length) {
                container.style.display = 'none';
                btnSubmit.style.display = 'none';
            }
            recalcAll();
        });

        container.appendChild(row);
        updateCounter();
    });
}

makeAddRow('tambahExwork','containerExwork','btnSimpanExwork','komponenExwork[]','biayaExwork[]','inp-exwork');
makeAddRow('tambahFOB',   'containerFOB',   'btnSimpanFOB',   'komponenFOB[]',   'biayaFOB[]',   'inp-fob');
makeAddRow('tambahCFR',   'containerCFR',   'btnSimpanCFR',   'komponenCFR[]',   'biayaCFR[]',   'inp-cfr');
makeAddRow('tambahCIF',   'containerCIF',   'btnSimpanCIF',   'komponenCIF[]',   'biayaCIF[]',   'inp-cif');

// ── STRIP FORMATTING SEBELUM SUBMIT ──
[
    ['formExworkAll', '.exwork-existing', 'input[name="biayaExwork[]"]'],
    ['formFOBAll',    '.fob-existing',    'input[name="biayaFOB[]"]'],
    ['formCFRAll',    '.cfr-existing',    'input[name="biayaCFR[]"]'],
    ['formCIFAll',    '.cif-existing',    'input[name="biayaCIF[]"]'],
].forEach(([formId, existSel, newSel]) => {
    document.getElementById(formId)?.addEventListener('submit', function() {
        saveGlobalState();
        document.querySelectorAll(existSel + ', ' + newSel)
                .forEach(el => el.value = bersihkan(el.value));
    });
});

// ── INIT ──
document.addEventListener('DOMContentLoaded', restoreState);
</script>

<?= $this->endSection(); ?>

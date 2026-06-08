<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>
<?= $this->section('content') ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">

<style>
* { font-family: 'Plus Jakarta Sans', sans-serif; }
:root{
  --bg:#f0f4f8;--surface:#fff;--border:#e2e8f0;--border-focus:#3b82f6;
  --text-primary:#0f172a;--text-secondary:#64748b;--text-muted:#94a3b8;
  --accent:#2563eb;--accent-light:#eff6ff;
  --green:#16a34a;--green-light:#dcfce7;
  --purple:#7c3aed;--purple-light:#ede9fe;
  --red:#dc2626;--red-light:#fee2e2;
  --shadow-sm:0 1px 3px rgba(0,0,0,.06);
  --radius:12px;--radius-sm:8px;
}

/* ── Page Header ── */
.re-header{display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:2rem;gap:1rem}
.re-header-left h4{font-size:22px;font-weight:700;color:#0f172a;margin:0 0 4px;letter-spacing:-.4px}
.re-header-left p{font-size:13px;color:#94a3b8;margin:0}
.btn-lihat-hasil{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;font-size:13px;font-weight:600;color:var(--accent);background:var(--accent-light);border:1.5px solid #bfdbfe;border-radius:10px;text-decoration:none;transition:background .15s}
.btn-lihat-hasil:hover{background:#dbeafe}

/* Flash */
.flash-alert{display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:10px;font-size:13px;font-weight:500;margin-bottom:1.25rem;border:1px solid transparent}
.flash-alert.success{background:#f0fdf4;border-color:#bbf7d0;color:#15803d}
.flash-alert.error  {background:#fef2f2;border-color:#fecaca;color:#b91c1c}

/* Section label */
.section-label{font-size:11px;font-weight:700;color:var(--text-secondary);text-transform:uppercase;letter-spacing:.1em;margin-bottom:10px;margin-top:1.5rem;display:flex;align-items:center;gap:8px}
.section-label::after{content:'';flex:1;height:1px;background:var(--border)}

/* ══ PRODUCT CARD ══ */
.product-card{background:var(--surface);border:1.5px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-sm);margin-bottom:14px;overflow:hidden}
.product-card-header{display:flex;align-items:center;justify-content:space-between;padding:12px 16px;background:linear-gradient(to right,var(--purple-light),#f5f3ff);border-bottom:1px solid var(--border);cursor:pointer;user-select:none}
.product-card-header-left{display:flex;align-items:center;gap:10px}
.prod-num{width:26px;height:26px;border-radius:7px;background:var(--purple);color:#fff;font-size:11px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.prod-title{font-size:13px;font-weight:700;color:var(--text-primary)}
.prod-subtitle{font-size:11px;color:var(--text-secondary);margin-top:1px}
.prod-actions{display:flex;align-items:center;gap:6px}
.chevron-btn{width:28px;height:28px;border:1px solid #d8b4fe;border-radius:7px;background:transparent;cursor:pointer;color:var(--purple);font-size:13px;display:flex;align-items:center;justify-content:center;transition:transform .25s}
.chevron-btn.closed{transform:rotate(180deg)}
.product-body{overflow:hidden;transition:max-height .35s ease}
.product-body-inner{padding:16px}
.prod-info-row{display:grid;grid-template-columns:1fr 220px;gap:16px;align-items:start;margin-bottom:14px}
.prod-nama-block{display:flex;flex-direction:column;gap:10px}
.foto-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:10px}
.foto-box-sm{width:100%;aspect-ratio:1/1;flex-shrink:0;border:1.5px dashed var(--border);border-radius:12px;display:flex;flex-direction:column;align-items:center;justify-content:center;cursor:pointer;overflow:hidden;position:relative;background:#f8fafc;transition:all .15s;font-size:12px;color:var(--text-muted);gap:6px}
.foto-box-sm i{font-size:28px}
.foto-box-sm:hover{background:#f1f5f9;border-color:var(--accent)}
.foto-box-sm.has-img{border-style:solid;border-color:var(--accent)}
.foto-box-sm img{width:100%;height:100%;object-fit:contain;position:absolute;inset:0;border-radius:11px;padding:4px}
.harga-block{display:grid;grid-template-columns:1fr 1fr;gap:8px}
.harga-badge{font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;padding:2px 6px;border-radius:4px;display:inline-block;margin-bottom:3px}
.harga-badge.exw{background:#fef9c3;color:#854d0e}
.harga-badge.fob{background:#dbeafe;color:#1e40af}

/* ══ NEGARA BLOCK ══ */
.negara-list{margin-top:4px}
.negara-block{border:1.5px solid #bfdbfe;border-radius:10px;margin-bottom:10px;overflow:hidden;background:#fafbfe}
.negara-block-header{display:flex;align-items:center;justify-content:space-between;padding:9px 13px;background:linear-gradient(to right,var(--accent-light),#f0f9ff);border-bottom:1px solid #bfdbfe;cursor:pointer;user-select:none}
.negara-block-header-left{display:flex;align-items:center;gap:8px}
.neg-num{width:22px;height:22px;border-radius:5px;background:var(--accent);color:#fff;font-size:10px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.neg-title{font-size:12px;font-weight:700;color:var(--accent)}
.neg-subtitle{font-size:10.5px;color:var(--text-secondary);margin-top:1px}
.neg-chevron{width:24px;height:24px;border:1px solid #bfdbfe;border-radius:5px;background:transparent;cursor:pointer;color:var(--accent);font-size:12px;display:flex;align-items:center;justify-content:center;transition:transform .25s}
.neg-chevron.closed{transform:rotate(180deg)}
.negara-body{overflow:hidden;transition:max-height .3s ease}
.negara-body-inner{padding:13px}
.neg-fields{display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px;margin-bottom:12px}

/* ══ BUYER BLOCK ══ */
.buyer-list-wrap{border-top:1px dashed #bfdbfe;padding-top:12px;margin-top:4px}
.buyer-list-label{font-size:10px;font-weight:700;color:var(--green);text-transform:uppercase;letter-spacing:.07em;display:flex;align-items:center;gap:5px;margin-bottom:10px}
.buyer-block{border:1.5px solid #bbf7d0;border-radius:8px;margin-bottom:8px;overflow:hidden;background:#f0fdf4}
.buyer-block-header{display:flex;align-items:center;justify-content:space-between;padding:7px 11px;background:linear-gradient(to right,var(--green-light),#f0fdf4);border-bottom:1px solid #bbf7d0}
.buyer-badge{width:20px;height:20px;border-radius:4px;background:var(--green);color:#fff;font-size:9px;font-weight:700;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.buyer-title{font-size:11.5px;font-weight:700;color:var(--green)}
.buyer-body{padding:11px}
.buyer-fields{display:grid;grid-template-columns:1fr 1fr 1fr;gap:10px}

/* Fields */
.field{display:flex;flex-direction:column;gap:4px}
.field label{font-size:11px;font-weight:600;color:var(--text-secondary)}
.field input,.field textarea{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;border:1.5px solid var(--border);border-radius:7px;padding:7px 10px;background:var(--surface);color:var(--text-primary);resize:none;outline:none;transition:border-color .15s,box-shadow .15s;width:100%}
.field input:focus,.field textarea:focus{border-color:var(--border-focus);box-shadow:0 0 0 3px rgba(59,130,246,.1)}
.field input::placeholder,.field textarea::placeholder{color:var(--text-muted)}
.mono{font-family:'JetBrains Mono',monospace!important;font-size:12px!important}

/* Buttons */
.btn-icon-sm{width:26px;height:26px;border-radius:6px;border:1px solid var(--border);background:transparent;cursor:pointer;color:var(--text-muted);font-size:13px;display:flex;align-items:center;justify-content:center;transition:all .15s;flex-shrink:0}
.btn-icon-sm:hover{background:var(--red-light);border-color:#fca5a5;color:var(--red)}
.btn-add-inline{display:inline-flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;padding:6px 12px;border-radius:7px;cursor:pointer;background:transparent;border:1.5px dashed var(--border);color:var(--text-secondary);transition:all .15s}
.btn-add-inline:hover{background:var(--accent-light);border-color:var(--accent);color:var(--accent)}
.btn-add-inline.green:hover{background:var(--green-light);border-color:var(--green);color:var(--green)}
.btn-add-product{width:100%;display:flex;align-items:center;justify-content:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;padding:13px;border-radius:var(--radius);cursor:pointer;background:transparent;border:2px dashed var(--purple);color:var(--purple);transition:all .15s;margin-top:4px}
.btn-add-product:hover{background:var(--purple-light)}

/* Bottom action bar */
.re-bottom-bar{display:flex;align-items:center;justify-content:space-between;margin-top:2rem;padding:14px 18px;background:#fff;border:1.5px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-sm);gap:12px}
.re-count{font-size:12.5px;color:var(--text-secondary);font-weight:500}
.re-bottom-btns{display:flex;gap:10px}
.btn-preview{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;font-size:13px;font-weight:600;color:var(--accent);background:var(--accent-light);border:1.5px solid #bfdbfe;border-radius:9px;cursor:pointer;transition:background .15s}
.btn-preview:hover{background:#dbeafe}
.btn-simpan{display:inline-flex;align-items:center;gap:8px;padding:9px 20px;font-size:13px;font-weight:700;color:#fff;background:linear-gradient(135deg,#16a34a,#22c55e);border:none;border-radius:9px;cursor:pointer;box-shadow:0 4px 14px rgba(22,163,74,.3);transition:all .15s}
.btn-simpan:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(22,163,74,.4)}
.btn-simpan:disabled{opacity:.6;cursor:not-allowed;transform:none}

/* Toast */
.toast-wrap{position:fixed;bottom:1.5rem;right:1.5rem;z-index:9999;display:flex;flex-direction:column;gap:8px}
.toast-item{padding:12px 18px;border-radius:10px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px;box-shadow:0 4px 20px rgba(0,0,0,.12);animation:toastIn .25s ease}
.toast-item.success{background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d}
.toast-item.error  {background:#fef2f2;border:1px solid #fecaca;color:#b91c1c}
@keyframes toastIn{from{opacity:0;transform:translateX(30px)}to{opacity:1;transform:translateX(0)}}

/* Table preview */
.preview-section{margin-top:1.5rem;display:none}
.divider{height:1px;background:var(--border);margin:1.5rem 0}
.tbl-scroll{overflow-x:auto;border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow-sm)}
table{width:100%;border-collapse:collapse;font-size:11.5px;min-width:1200px}
thead th{background:#f8fafc;font-weight:700;font-size:10px;padding:9px 10px;text-align:center;border-bottom:1px solid var(--border);white-space:nowrap;color:var(--text-secondary);letter-spacing:.05em;text-transform:uppercase}
thead tr.group-header th{font-size:9.5px;letter-spacing:.08em}
thead tr.group-header .gh-prod{background:linear-gradient(to right,var(--purple-light),#f5f3ff);color:var(--purple)}
thead tr.group-header .gh-neg{background:linear-gradient(to right,var(--accent-light),#f0f9ff);color:var(--accent)}
thead tr.group-header .gh-buyer{background:linear-gradient(to right,var(--green-light),#f0fdf4);color:var(--green)}
tbody td{padding:9px 10px;border-bottom:1px solid #f1f5f9;vertical-align:middle;color:var(--text-primary)}
tbody tr:last-child td{border-bottom:none}
tbody tr:hover td{background:#f8fafc}
td.center{text-align:center}
td.muted{color:var(--text-secondary);font-size:11px}
.foto-thumb{width:30px;height:30px;border-radius:5px;object-fit:cover;border:1px solid var(--border);display:block;margin:0 auto}
.foto-placeholder{width:30px;height:30px;border-radius:5px;background:#f1f5f9;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;font-size:10px;color:var(--text-muted);margin:0 auto}
.email-link{color:var(--accent);text-decoration:none}
.email-link:hover{text-decoration:underline}
.sep-prod{border-left:3px solid var(--purple)!important}
.sep-neg{border-left:2px solid var(--accent)!important}

@media(max-width:640px){
  .prod-info-row,.neg-fields,.buyer-fields{grid-template-columns:1fr}
  .foto-strip{flex-wrap:wrap}
  .re-header{flex-direction:column;align-items:flex-start}
  .re-bottom-bar{flex-direction:column;align-items:stretch}
  .re-bottom-btns{flex-direction:column}
}
</style>

<div class="re-header">
  <div class="re-header-left">
    <h4><i class="bi bi-graph-up-arrow me-2" style="color:#7c3aed"></i>Riset Pasar Ekspor</h4>
    <p>Isi data produk, negara tujuan, dan buyer untuk riset ekspor kamu</p>
  </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
<div class="flash-alert success">
  <i class="bi bi-check-circle-fill"></i>
  <?= session()->getFlashdata('success') ?>
</div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')): ?>
<div class="flash-alert error">
  <i class="bi bi-exclamation-circle-fill"></i>
  <?= session()->getFlashdata('error') ?>
</div>
<?php endif; ?>

<div class="section-label">Data Produk &amp; Ekspor</div>
<div id="product-wrap"></div>
<button class="btn-add-product" onclick="addProduct()">
  <i class="ti ti-plus"></i> Tambah Produk
</button>

<!-- Bottom action bar -->
<div class="re-bottom-bar">
  <span class="re-count" id="countInfo">Belum ada produk ditambahkan</span>
  <div class="re-bottom-btns">
    <button class="btn-preview" onclick="generateTable()">
      <i class="bi bi-eye"></i> Preview Tabel
    </button>
    <!--<button class="btn-simpan" id="btnSimpan" onclick="simpanKeDB()">-->
    <!--  <i class="bi bi-cloud-upload-fill"></i> Simpan ke Database-->
    <!--</button>-->
  </div>
</div>

<!-- Preview tabel -->
<div class="preview-section" id="preview-section">
  <div class="divider"></div>
  <div class="section-label">Preview — Tabel Data Ekspor</div>
  <div class="tbl-scroll">
    <table>
      <thead>
        <tr class="group-header">
          <th colspan="9" class="gh-prod">Data Produk</th>
          <th colspan="3" class="gh-neg">Data Negara Tujuan</th>
          <th colspan="6" class="gh-buyer">Data Buyer</th>
        </tr>
        <tr>
          <th>#</th><th>Nama Produk</th><th>HS Code</th>
          <th>Foto 1</th><th>Foto 2</th><th>Foto 3</th><th>Foto 4</th>
          <th>Harga EXW</th><th>Harga FOB</th>
          <th>Negara Tujuan Ekspor</th><th>Alasan Pemilihan</th><th>Persyaratan Ekspor</th>
          <th>Nama Perusahaan</th><th>Alamat</th><th>Website</th>
          <th>Email</th><th>No. HP</th><th>Nama PIC</th>
        </tr>
      </thead>
      <tbody id="result-tbody"></tbody>
    </table>
  </div>
</div>

<!-- Toast -->
<div class="toast-wrap" id="toastWrap"></div>

<script>
const BASE_URL  = '<?= base_url() ?>';
const CSRF_NAME = '<?= csrf_token() ?>';
let   CSRF_HASH = '<?= csrf_hash() ?>';

let prodSeq = 0, prodIds = [];
const fotosMap = {};

function updateCountInfo() {
  const el = document.getElementById('countInfo');
  if (el) el.textContent = prodIds.length
    ? prodIds.length + ' produk siap disimpan'
    : 'Belum ada produk ditambahkan';
}

function showToast(msg, type = 'success') {
  const wrap = document.getElementById('toastWrap');
  const el = document.createElement('div');
  el.className = 'toast-item ' + type;
  el.innerHTML = '<i class="bi bi-' + (type === 'success' ? 'check-circle-fill' : 'exclamation-circle-fill') + '"></i> ' + msg;
  wrap.appendChild(el);
  setTimeout(() => el.remove(), 3500);
}

/* ══ PRODUK ══ */
function addProduct() {
  prodSeq++;
  const pid = 'p' + Date.now();
  prodIds.push(pid);
  fotosMap[pid] = [null, null, null, null];
  updateCountInfo();

  const wrap = document.getElementById('product-wrap');
  const card = document.createElement('div');
  card.className = 'product-card';
  card.id = pid;

  // Build foto boxes HTML tanpa nested template literal
  let fotoBoxesHtml = '';
  for (let i = 0; i < 4; i++) {
    fotoBoxesHtml += '<div class="foto-box-sm" id="' + pid + '-fb' + i + '" onclick="triggerFoto(\'' + pid + '\',' + i + ')" title="Foto ' + (i+1) + '">'
      + '<i class="ti ti-photo-plus"></i><span>Foto ' + (i+1) + '</span>'
      + '<input type="file" accept="image/*" style="display:none" onchange="previewFoto(this,\'' + pid + '\',' + i + ')">'
      + '</div>';
  }

  card.innerHTML = ''
    + '<div class="product-card-header" onclick="toggleProd(\'' + pid + '\')">'
    +   '<div class="product-card-header-left">'
    +     '<div class="prod-num" id="' + pid + '-num">' + prodSeq + '</div>'
    +     '<div>'
    +       '<div class="prod-title" id="' + pid + '-label">Produk ' + prodSeq + '</div>'
    +       '<div class="prod-subtitle">Klik untuk buka / tutup</div>'
    +     '</div>'
    +   '</div>'
    +   '<div class="prod-actions" onclick="event.stopPropagation()">'
    +     '<button class="btn-icon-sm" title="Hapus produk" onclick="removeProd(\'' + pid + '\')"><i class="ti ti-trash"></i></button>'
    +     '<button class="chevron-btn" id="' + pid + '-chev"><i class="ti ti-chevron-up"></i></button>'
    +   '</div>'
    + '</div>'
    + '<div class="product-body" id="' + pid + '-body" style="max-height:3000px">'
    +   '<div class="product-body-inner">'
    +     '<div class="prod-info-row">'
    +       '<div class="prod-nama-block">'
    +         '<div class="field">'
    +           '<label>Nama produk</label>'
    +           '<input type="text" class="p-nama" placeholder="Nama produk" oninput="updateProdLabel(\'' + pid + '\',this.value)">'
    +         '</div>'
    +         '<div>'
    +           '<div style="font-size:11px;font-weight:600;color:var(--text-secondary);margin-bottom:8px">Foto produk <span style="font-weight:400;color:var(--text-muted)">(maks. 4)</span></div>'
    +           '<div class="foto-strip">' + fotoBoxesHtml + '</div>'
    +         '</div>'
    +         '<div class="harga-block">'
    +           '<div class="field">'
    +             '<div class="harga-badge exw">EXW</div>'
    +             '<input type="text" class="p-harga-exw mono" placeholder="Harga EXW">'
    +           '</div>'
    +           '<div class="field">'
    +             '<div class="harga-badge fob">FOB</div>'
    +             '<input type="text" class="p-harga-fob mono" placeholder="Harga FOB">'
    +           '</div>'
    +         '</div>'
    +       '</div>'
    +       '<div class="field">'
    +         '<label>HS Code</label>'
    +         '<input type="text" class="p-hs mono" placeholder="HS Code">'
    +       '</div>'
    +     '</div>'
    +     '<div class="negara-list" id="' + pid + '-negara-list"></div>'
    +     '<button class="btn-add-inline" onclick="addNegara(\'' + pid + '\')"><i class="ti ti-plus"></i> Tambah negara tujuan</button>'
    +   '</div>'
    + '</div>';

  wrap.appendChild(card);
  addNegara(pid);
}

function removeProd(pid) {
  document.getElementById(pid) && document.getElementById(pid).remove();
  prodIds = prodIds.filter(function(x){ return x !== pid; });
  delete fotosMap[pid];
  renumProds();
  updateCountInfo();
}

function renumProds() {
  prodIds.forEach(function(pid, i) {
    const n = document.getElementById(pid + '-num');
    if (n) n.textContent = i + 1;
  });
}

function toggleProd(pid) {
  const body = document.getElementById(pid + '-body');
  const chev = document.getElementById(pid + '-chev');
  const open = body.style.maxHeight !== '0px';
  body.style.maxHeight = open ? '0px' : '3000px';
  chev.classList.toggle('closed', open);
}

function updateProdLabel(pid, val) {
  const el = document.getElementById(pid + '-label');
  if (el) el.textContent = val || ('Produk ' + (prodIds.indexOf(pid) + 1));
}

/* ══ FOTO ══ */
function triggerFoto(pid, i) {
  const input = document.querySelector('#' + pid + '-fb' + i + ' input[type=file]');
  if (input) input.click();
}

function previewFoto(inp, pid, i) {
  const f = inp.files[0];
  if (!f) return;
  const r = new FileReader();
  r.onload = function(e) {
    fotosMap[pid][i] = e.target.result;
    const box = document.getElementById(pid + '-fb' + i);
    box.innerHTML = '';
    box.classList.add('has-img');
    const img = document.createElement('img');
    img.src = e.target.result;
    box.appendChild(img);
    const ni = document.createElement('input');
    ni.type = 'file';
    ni.accept = 'image/*';
    ni.style.display = 'none';
    ni.onchange = function() { previewFoto(this, pid, i); };
    box.appendChild(ni);
    box.onclick = function() { triggerFoto(pid, i); };
  };
  r.readAsDataURL(f);
}

function fotoHtml(pid, i) {
  const src = fotosMap[pid] && fotosMap[pid][i];
  if (src) return '<img class="foto-thumb" src="' + src + '">';
  return '<div class="foto-placeholder"><i class="ti ti-photo"></i></div>';
}

/* ══ NEGARA ══ */
const negSeqMap = {};
function addNegara(pid) {
  if (!negSeqMap[pid]) negSeqMap[pid] = 0;
  negSeqMap[pid]++;
  const nid = 'n' + Date.now();
  const seq = negSeqMap[pid];
  const list = document.getElementById(pid + '-negara-list');
  const block = document.createElement('div');
  block.className = 'negara-block';
  block.id = nid;
  block.innerHTML = ''
    + '<div class="negara-block-header" onclick="toggleNeg(\'' + nid + '\')">'
    +   '<div class="negara-block-header-left">'
    +     '<div class="neg-num">' + seq + '</div>'
    +     '<div>'
    +       '<div class="neg-title" id="' + nid + '-label">Negara ' + seq + '</div>'
    +       '<div class="neg-subtitle">Klik untuk buka / tutup</div>'
    +     '</div>'
    +   '</div>'
    +   '<div style="display:flex;align-items:center;gap:6px" onclick="event.stopPropagation()">'
    +     '<button class="btn-icon-sm" onclick="removeNeg(\'' + nid + '\')" title="Hapus negara"><i class="ti ti-trash"></i></button>'
    +     '<button class="neg-chevron" id="' + nid + '-chev"><i class="ti ti-chevron-up"></i></button>'
    +   '</div>'
    + '</div>'
    + '<div class="negara-body" id="' + nid + '-body" style="max-height:2000px">'
    +   '<div class="negara-body-inner">'
    +     '<div class="neg-fields">'
    +       '<div class="field"><label>Negara tujuan ekspor</label><input class="n-negara" type="text" placeholder="Negara tujuan" oninput="updateNegLabel(\'' + nid + '\',this.value)"></div>'
    +       '<div class="field"><label>Alasan pemilihan negara</label><textarea class="n-alasan" rows="3" placeholder="Alasan pemilihan negara"></textarea></div>'
    +       '<div class="field"><label>Persyaratan ekspor ke negara tujuan</label><textarea class="n-syarat" rows="3" placeholder="Persyaratan ekspor"></textarea></div>'
    +     '</div>'
    +     '<div class="buyer-list-wrap">'
    +       '<div class="buyer-list-label"><i class="ti ti-building-store"></i> Data Buyer</div>'
    +       '<div class="buyer-list" id="' + nid + '-buyer-list"></div>'
    +       '<button class="btn-add-inline green" onclick="addBuyer(\'' + nid + '\')"><i class="ti ti-plus"></i> Tambah buyer</button>'
    +     '</div>'
    +   '</div>'
    + '</div>';
  list.appendChild(block);
  addBuyer(nid);
}

function removeNeg(nid) {
  const el = document.getElementById(nid);
  if (el) el.remove();
}

function toggleNeg(nid) {
  const body = document.getElementById(nid + '-body');
  const chev = document.getElementById(nid + '-chev');
  const open = body.style.maxHeight !== '0px';
  body.style.maxHeight = open ? '0px' : '2000px';
  chev.classList.toggle('closed', open);
}

function updateNegLabel(nid, val) {
  const el = document.getElementById(nid + '-label');
  if (el) el.textContent = val || 'Negara';
}

/* ══ BUYER ══ */
const buyerSeqMap = {};
function addBuyer(nid) {
  if (!buyerSeqMap[nid]) buyerSeqMap[nid] = 0;
  buyerSeqMap[nid]++;
  const bid = 'b' + Date.now();
  const seq = buyerSeqMap[nid];
  const list = document.getElementById(nid + '-buyer-list');
  const block = document.createElement('div');
  block.className = 'buyer-block';
  block.id = bid;
  block.innerHTML = ''
    + '<div class="buyer-block-header">'
    +   '<div style="display:flex;align-items:center;gap:7px">'
    +     '<div class="buyer-badge">' + seq + '</div>'
    +     '<span class="buyer-title">Buyer ' + seq + '</span>'
    +   '</div>'
    +   '<button class="btn-icon-sm" onclick="removeBuyer(\'' + bid + '\')" title="Hapus buyer"><i class="ti ti-x"></i></button>'
    + '</div>'
    + '<div class="buyer-body">'
    +   '<div class="buyer-fields">'
    +     '<div class="field"><label>Nama perusahaan buyer</label><input class="b-nama" type="text" placeholder="Nama perusahaan buyer"></div>'
    +     '<div class="field"><label>Alamat perusahaan buyer</label><input class="b-alamat" type="text" placeholder="Alamat perusahaan buyer"></div>'
    +     '<div class="field"><label>Website perusahaan buyer</label><input class="b-web" type="text" placeholder="Website perusahaan buyer"></div>'
    +     '<div class="field"><label>Email buyer</label><input class="b-email" type="email" placeholder="Email buyer"></div>'
    +     '<div class="field"><label>Nomor HP buyer</label><input class="b-hp" type="text" placeholder="Nomor HP buyer"></div>'
    +     '<div class="field"><label>Nama buyer (PIC)</label><input class="b-pic" type="text" placeholder="Nama buyer (PIC)"></div>'
    +   '</div>'
    + '</div>';
  list.appendChild(block);
}

function removeBuyer(bid) {
  const el = document.getElementById(bid);
  if (el) el.remove();
}

/* ══ COLLECT DATA ══ */
function collectData() {
  return prodIds.map(function(pid) {
    const pCard = document.getElementById(pid);
    const negBlocks = Array.from(pCard.querySelectorAll('.negara-block'));
    return {
      nama_produk: pCard.querySelector('.p-nama') ? pCard.querySelector('.p-nama').value : '',
      hs_code:     pCard.querySelector('.p-hs')   ? pCard.querySelector('.p-hs').value   : '',
      harga_exw:   pCard.querySelector('.p-harga-exw') ? pCard.querySelector('.p-harga-exw').value : '',
      harga_fob:   pCard.querySelector('.p-harga-fob') ? pCard.querySelector('.p-harga-fob').value : '',
      foto_1: fotosMap[pid][0] || '',
      foto_2: fotosMap[pid][1] || '',
      foto_3: fotosMap[pid][2] || '',
      foto_4: fotosMap[pid][3] || '',
      negara_list: negBlocks.map(function(nb) {
        return {
          negara:             nb.querySelector('.n-negara') ? nb.querySelector('.n-negara').value : '',
          alasan_pemilihan:   nb.querySelector('.n-alasan') ? nb.querySelector('.n-alasan').value : '',
          persyaratan_ekspor: nb.querySelector('.n-syarat') ? nb.querySelector('.n-syarat').value : '',
          buyers: Array.from(nb.querySelectorAll('.buyer-block')).map(function(bb) {
            return {
              nama_perusahaan: bb.querySelector('.b-nama')   ? bb.querySelector('.b-nama').value   : '',
              alamat:          bb.querySelector('.b-alamat') ? bb.querySelector('.b-alamat').value : '',
              website:         bb.querySelector('.b-web')    ? bb.querySelector('.b-web').value    : '',
              email:           bb.querySelector('.b-email')  ? bb.querySelector('.b-email').value  : '',
              no_hp:           bb.querySelector('.b-hp')     ? bb.querySelector('.b-hp').value     : '',
              nama_pic:        bb.querySelector('.b-pic')    ? bb.querySelector('.b-pic').value    : '',
            };
          }),
        };
      }),
    };
  });
}

/* ══ PREVIEW TABLE ══ */
function generateTable() {
  const data  = collectData();
  const tbody = document.getElementById('result-tbody');
  tbody.innerHTML = '';

  data.forEach(function(produk, pi) {
    const negData = produk.negara_list.length
      ? produk.negara_list
      : [{ negara:'—', alasan_pemilihan:'—', persyaratan_ekspor:'—', buyers:[] }];

    let totalRows = 0;
    negData.forEach(function(n) { totalRows += (n.buyers.length || 1); });

    let firstProd = true;
    negData.forEach(function(neg) {
      const buyers = neg.buyers.length
        ? neg.buyers
        : [{ nama_perusahaan:'—', alamat:'—', website:'—', email:'—', no_hp:'—', nama_pic:'—' }];
      let firstNeg = true;

      buyers.forEach(function(buyer) {
        const tr = document.createElement('tr');
        let prodCols = '';
        let negCols  = '';

        if (firstProd) {
          prodCols = ''
            + '<td rowspan="' + totalRows + '" class="center sep-prod" style="font-weight:700;color:var(--text-secondary)">' + (pi+1) + '</td>'
            + '<td rowspan="' + totalRows + '" style="font-weight:600">' + (produk.nama_produk || '—') + '</td>'
            + '<td rowspan="' + totalRows + '" class="center mono">' + (produk.hs_code || '—') + '</td>'
            + '<td rowspan="' + totalRows + '" class="center">' + fotoHtml(prodIds[pi], 0) + '</td>'
            + '<td rowspan="' + totalRows + '" class="center">' + fotoHtml(prodIds[pi], 1) + '</td>'
            + '<td rowspan="' + totalRows + '" class="center">' + fotoHtml(prodIds[pi], 2) + '</td>'
            + '<td rowspan="' + totalRows + '" class="center">' + fotoHtml(prodIds[pi], 3) + '</td>'
            + '<td rowspan="' + totalRows + '" class="center mono">' + (produk.harga_exw || '—') + '</td>'
            + '<td rowspan="' + totalRows + '" class="center mono" style="border-right:1px solid #e2e8f0">' + (produk.harga_fob || '—') + '</td>';
          firstProd = false;
        }

        if (firstNeg) {
          negCols = ''
            + '<td rowspan="' + buyers.length + '" class="sep-neg" style="font-weight:500">' + (neg.negara || '—') + '</td>'
            + '<td rowspan="' + buyers.length + '" class="muted">' + (neg.alasan_pemilihan || '—') + '</td>'
            + '<td rowspan="' + buyers.length + '" class="muted" style="border-right:1px solid #e2e8f0">' + (neg.persyaratan_ekspor || '—') + '</td>';
          firstNeg = false;
        }

        const emailHtml = (buyer.email && buyer.email !== '—')
          ? '<a class="email-link" href="mailto:' + buyer.email + '">' + buyer.email + '</a>'
          : '—';

        tr.innerHTML = prodCols + negCols
          + '<td style="font-weight:500">' + (buyer.nama_perusahaan || '—') + '</td>'
          + '<td class="muted">'           + (buyer.alamat          || '—') + '</td>'
          + '<td class="muted">'           + (buyer.website         || '—') + '</td>'
          + '<td>'                         + emailHtml                      + '</td>'
          + '<td class="muted">'           + (buyer.no_hp           || '—') + '</td>'
          + '<td>'                         + (buyer.nama_pic        || '—') + '</td>';

        tbody.appendChild(tr);
      });
    });
  });

  const sec = document.getElementById('preview-section');
  sec.style.display = 'block';
  sec.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

/* ══ SIMPAN KE DATABASE ══ */
async function simpanKeDB() {
  if (prodIds.length === 0) {
    showToast('Tambahkan minimal 1 produk terlebih dahulu.', 'error');
    return;
  }

  const btn = document.getElementById('btnSimpan');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1" role="status"></span> Menyimpan...';

  const data = collectData();

  try {
    const res = await fetch(BASE_URL + 'dashboard/peserta/riset-ekspor/simpan', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
      },
      body: JSON.stringify({
        [CSRF_NAME]: CSRF_HASH,
        produk: data,
      }),
    });

    const json = await res.json();

    if (json.success) {
      if (json.csrf_hash) CSRF_HASH = json.csrf_hash;
      showToast('Data berhasil disimpan! Mengarahkan ke halaman hasil...', 'success');
      setTimeout(function() {
        window.location.href = json.redirect || (BASE_URL + 'dashboard/peserta/riset-ekspor/hasil');
      }, 1800);
    } else {
      showToast(json.message || 'Gagal menyimpan data.', 'error');
      btn.disabled = false;
      btn.innerHTML = '<i class="bi bi-cloud-upload-fill"></i> Simpan ke Database';
    }
  } catch (err) {
    showToast('Terjadi kesalahan jaringan. Coba lagi.', 'error');
    btn.disabled = false;
    btn.innerHTML = '<i class="bi bi-cloud-upload-fill"></i> Simpan ke Database';
  }
}

// Init — langsung tambah 1 produk kosong
addProduct();
</script>

<?= $this->endSection() ?>
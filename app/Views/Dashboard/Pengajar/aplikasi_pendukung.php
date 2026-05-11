<?= $this->extend('Dashboard/Pengajar/layout_pengajar') ?>
<?= $this->section('content') ?>

<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
* { font-family: 'Plus Jakarta Sans', sans-serif; }

/* ── Page shell ── */
.ap-page { padding: 0 0 3rem; }

/* ── Header ── */
.ap-header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    margin-bottom: 2rem;
    gap: 1rem;
}
.ap-header-left h4 {
    font-size: 22px;
    font-weight: 700;
    color: #0f172a;
    margin: 0 0 4px;
    letter-spacing: -.4px;
}
.ap-header-left p {
    font-size: 13px;
    color: #94a3b8;
    margin: 0;
}

/* ── Tombol Tambah — HIJAU ── */
.btn-add {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 9px 18px;
    font-size: 13px;
    font-weight: 600;
    color: #fff;
    background: linear-gradient(135deg, #16a34a 0%, #22c55e 100%);
    border: none;
    border-radius: 10px;
    cursor: pointer;
    transition: opacity .15s, transform .1s, box-shadow .2s;
    white-space: nowrap;
    box-shadow: 0 4px 14px rgba(22,163,74,.35);
}
.btn-add:hover  { opacity: .93; transform: translateY(-1px); box-shadow: 0 8px 20px rgba(22,163,74,.4); }
.btn-add:active { transform: translateY(0); }
.btn-add i { font-size: 16px; }

/* ── Toolbar ── */
.ap-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    gap: 12px;
}
.search-box {
    position: relative;
    flex: 1;
    max-width: 280px;
}
.search-box i {
    position: absolute;
    left: 12px; top: 50%;
    transform: translateY(-50%);
    color: #94a3b8;
    font-size: 15px;
    pointer-events: none;
}
.search-box input {
    width: 100%;
    height: 38px;
    padding: 0 12px 0 36px;
    font-size: 13px;
    font-family: inherit;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    background: #f8fafc;
    color: #1e293b;
    transition: border-color .15s, background .15s;
    outline: none;
}
.search-box input:focus {
    border-color: #6366f1;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(99,102,241,.12);
}
.ap-count-badge {
    font-size: 12px;
    color: #64748b;
    background: #f1f5f9;
    border-radius: 20px;
    padding: 5px 12px;
    font-weight: 500;
}

/* ── Flash alerts ── */
.flash-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border-radius: 10px;
    font-size: 13px;
    font-weight: 500;
    margin-bottom: 1.25rem;
    border: 1px solid transparent;
}
.flash-alert.success { background: #f0fdf4; border-color: #bbf7d0; color: #15803d; }
.flash-alert.error   { background: #fef2f2; border-color: #fecaca; color: #b91c1c; }
.flash-alert .btn-close { margin-left: auto; }

/* ══════════════════════════════════════════
   APP CARD — DESAIN BARU
══════════════════════════════════════════ */
.app-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 20px;
}

/* wrapper animasi */
.app-item {
    animation: fadeUp .35s ease both;
}
.app-item:nth-child(1) { animation-delay:.04s }
.app-item:nth-child(2) { animation-delay:.08s }
.app-item:nth-child(3) { animation-delay:.12s }
.app-item:nth-child(4) { animation-delay:.16s }
.app-item:nth-child(5) { animation-delay:.20s }
.app-item:nth-child(6) { animation-delay:.24s }
.app-item:nth-child(7) { animation-delay:.28s }
.app-item:nth-child(8) { animation-delay:.32s }
@keyframes fadeUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0);    }
}

/* kartu utama */
.app-card {
    position: relative;
    background: #fff;
    border-radius: 20px;
    border: 1.5px solid #eef2f7;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    transition: transform .3s cubic-bezier(.34,1.56,.64,1),
                box-shadow .3s ease,
                border-color .25s;
    box-shadow: 0 2px 10px rgba(15,23,42,.05);
    cursor: default;
}
.app-card:hover {
    transform: translateY(-6px) scale(1.01);
    box-shadow: 0 20px 50px rgba(99,102,241,.13), 0 4px 16px rgba(0,0,0,.06);
    border-color: #c7d2fe;
}

/* pita warna atas */
.card-ribbon {
    height: 4px;
    width: 100%;
    background: linear-gradient(90deg, #6366f1, #3b82f6, #06b6d4);
    background-size: 200% 100%;
    animation: ribbonShift 4s linear infinite;
}
@keyframes ribbonShift {
    0%   { background-position: 0% 0%; }
    100% { background-position: 200% 0%; }
}

/* area ikon + nama */
.card-hero {
    padding: 20px 20px 14px;
    display: flex;
    align-items: center;
    gap: 14px;
}
.card-icon-wrap {
    position: relative;
    flex-shrink: 0;
}
.card-icon {
    width: 52px; height: 52px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 24px;
    background: linear-gradient(135deg, #eff6ff 0%, #ede9fe 100%);
    color: #6366f1;
    transition: transform .3s cubic-bezier(.34,1.56,.64,1);
    box-shadow: 0 3px 10px rgba(99,102,241,.18);
}
.app-card:hover .card-icon { transform: rotate(-8deg) scale(1.1); }

/* badge status aktif */
.card-status-dot {
    position: absolute;
    bottom: -1px; right: -1px;
    width: 13px; height: 13px;
    background: #22c55e;
    border-radius: 50%;
    border: 2px solid #fff;
    animation: statusPulse 2s infinite;
}
@keyframes statusPulse {
    0%,100% { box-shadow: 0 0 0 0 rgba(34,197,94,.45); }
    50%     { box-shadow: 0 0 0 5px rgba(34,197,94,0);  }
}

.card-text { flex: 1; min-width: 0; }
.card-app-name {
    font-size: 14.5px;
    font-weight: 700;
    color: #0f172a;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    margin-bottom: 3px;
}
.card-app-url {
    font-size: 11px;
    color: #94a3b8;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    display: flex;
    align-items: center;
    gap: 4px;
    text-decoration: none;
    transition: color .15s;
}
.card-app-url:hover { color: #6366f1; }
.card-app-url i { font-size: 10px; flex-shrink: 0; }

/* divider tipis */
.card-divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, #e2e8f0 20%, #e2e8f0 80%, transparent);
    margin: 0 16px;
}

/* strip akses */
.card-akses {
    margin: 10px 16px;
    border-radius: 8px;
    padding: 7px 10px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
}
.card-akses.has-akses {
    background: #f0f9ff;
    border: 1px solid #bae6fd;
}
.card-akses.no-akses {
    background: #fff7ed;
    border: 1px solid #fed7aa;
}
.akses-left {
    display: flex;
    align-items: center;
    gap: 6px;
    min-width: 0;
}
.akses-icon-wrap {
    width: 22px; height: 22px;
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    font-size: 11px;
    flex-shrink: 0;
}
.has-akses .akses-icon-wrap { background: #e0f2fe; color: #0284c7; }
.no-akses  .akses-icon-wrap { background: #ffedd5; color: #ea580c; }
.akses-text-main {
    font-size: 11.5px;
    font-weight: 600;
    line-height: 1;
    white-space: nowrap;
}
.has-akses .akses-text-main { color: #0369a1; }
.no-akses  .akses-text-main { color: #c2410c; }
.btn-kelola-new {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 10.5px;
    font-weight: 700;
    padding: 4px 9px;
    border-radius: 6px;
    border: 1.5px solid;
    background: transparent;
    cursor: pointer;
    transition: background .15s, transform .1s;
    white-space: nowrap;
    flex-shrink: 0;
}
.btn-kelola-new:active { transform: scale(.97); }
.has-akses .btn-kelola-new { border-color: #7dd3fc; color: #0369a1; }
.has-akses .btn-kelola-new:hover { background: #e0f2fe; }
.no-akses  .btn-kelola-new { border-color: #fdba74; color: #c2410c; }
.no-akses  .btn-kelola-new:hover { background: #ffedd5; }

/* action bar bawah */
.card-actions {
    display: flex;
    gap: 8px;
    padding: 12px 16px 16px;
    margin-top: auto;
}
.btn-open-new {
    flex: 1;
    display: flex; align-items: center; justify-content: center; gap: 6px;
    font-size: 12px; font-weight: 700;
    padding: 8px 12px;
    border-radius: 10px;
    color: #fff;
    background: linear-gradient(135deg, #6366f1 0%, #3b82f6 100%);
    border: none;
    text-decoration: none;
    transition: opacity .15s, transform .15s;
    box-shadow: 0 3px 10px rgba(99,102,241,.28);
    letter-spacing: .01em;
}
.btn-open-new:hover { opacity: .88; color: #fff; transform: translateY(-1px); }
.btn-icon-sm {
    width: 36px; height: 36px;
    display: flex; align-items: center; justify-content: center;
    border-radius: 10px;
    border: 1.5px solid;
    background: transparent;
    cursor: pointer;
    transition: background .15s, transform .1s;
    padding: 0;
    font-size: 13px;
    flex-shrink: 0;
}
.btn-icon-sm:active { transform: scale(.95); }
.btn-edit  { border-color: #fde68a; color: #b45309; }
.btn-edit:hover  { background: #fefce8; }
.btn-del   { border-color: #fecaca; color: #b91c1c; }
.btn-del:hover   { background: #fef2f2; }

/* ── Empty state ── */
.empty-wrap {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 4rem 1rem;
    text-align: center;
}
.empty-icon {
    width: 72px; height: 72px;
    border-radius: 20px;
    background: linear-gradient(135deg, #eff6ff, #e0e7ff);
    display: flex; align-items: center; justify-content: center;
    font-size: 32px;
    color: #6366f1;
    margin-bottom: 1.25rem;
}
.empty-wrap h5 { font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 6px; }
.empty-wrap p  { font-size: 13px; color: #94a3b8; margin: 0; }

/* ═══ MODALS ═══ */
.modal-content {
    border-radius: 18px;
    border: 1.5px solid #f1f5f9;
    box-shadow: 0 20px 60px rgba(15,23,42,.12);
    overflow: hidden;
}
.modal-header {
    padding: 1.25rem 1.5rem 1rem;
    border-bottom: 1.5px solid #f8fafc;
    background: #fafbff;
}
.modal-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 10px;
}
.modal-icon {
    width: 30px; height: 30px;
    border-radius: 8px;
    display: flex; align-items: center; justify-content: center;
    font-size: 14px;
}
.modal-icon.green  { background: #dcfce7; color: #16a34a; }
.modal-icon.yellow { background: #fef9c3; color: #b45309; }
.modal-icon.blue   { background: #dbeafe; color: #2563eb; }
.modal-body   { padding: 1.5rem; }
.modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1.5px solid #f8fafc;
    background: #fafbff;
    gap: 10px;
}
.form-group { margin-bottom: 1.25rem; }
.form-group:last-child { margin-bottom: 0; }
.f-label {
    display: block;
    font-size: 11px;
    font-weight: 700;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: .06em;
    margin-bottom: 6px;
}
.f-input {
    width: 100%;
    height: 40px;
    padding: 0 12px;
    font-size: 14px;
    font-family: inherit;
    border: 1.5px solid #e2e8f0;
    border-radius: 10px;
    background: #f8fafc;
    color: #1e293b;
    outline: none;
    transition: border-color .15s, background .15s, box-shadow .15s;
}
.f-input:focus {
    border-color: #6366f1;
    background: #fff;
    box-shadow: 0 0 0 3px rgba(99,102,241,.12);
}
.f-hint { font-size: 11px; color: #94a3b8; margin-top: 5px; }
.input-prefix { display: flex; align-items: center; }
.input-prefix-icon {
    height: 40px;
    padding: 0 10px;
    display: flex; align-items: center;
    background: #f1f5f9;
    border: 1.5px solid #e2e8f0;
    border-right: none;
    border-radius: 10px 0 0 10px;
    color: #64748b;
    font-size: 16px;
}
.input-prefix .f-input { border-radius: 0 10px 10px 0; flex: 1; }
.btn-modal-cancel {
    height: 36px; padding: 0 16px;
    font-size: 13px; font-weight: 600; font-family: inherit;
    color: #64748b; background: #f1f5f9;
    border: none; border-radius: 9px; cursor: pointer;
    transition: background .15s;
}
.btn-modal-cancel:hover { background: #e2e8f0; }
.btn-modal-primary {
    height: 36px; padding: 0 18px;
    font-size: 13px; font-weight: 600; font-family: inherit;
    color: #fff; background: linear-gradient(135deg, #3b82f6, #6366f1);
    border: none; border-radius: 9px; cursor: pointer;
    transition: opacity .15s;
    display: inline-flex; align-items: center; gap: 6px;
    box-shadow: 0 3px 10px rgba(99,102,241,.3);
}
.btn-modal-primary:hover { opacity: .9; }
.btn-modal-warning {
    height: 36px; padding: 0 18px;
    font-size: 13px; font-weight: 600; font-family: inherit;
    color: #fff; background: linear-gradient(135deg, #f59e0b, #f97316);
    border: none; border-radius: 9px; cursor: pointer;
    transition: opacity .15s;
    display: inline-flex; align-items: center; gap: 6px;
    box-shadow: 0 3px 10px rgba(249,115,22,.3);
}
.btn-modal-warning:hover { opacity: .9; }

/* Modal akses */
.akses-search-wrap {
    padding: 1rem 1.25rem 0.75rem;
    border-bottom: 1.5px solid #f1f5f9;
}
.akses-quick {
    display: flex; align-items: center; justify-content: space-between;
    padding: 8px 1.25rem;
    background: #fafbff;
    border-bottom: 1.5px solid #f1f5f9;
}
.akses-quick-count { font-size: 12px; font-weight: 600; color: #64748b; }
.akses-quick-btns { display: flex; gap: 8px; }
.btn-qk {
    font-size: 11px; font-weight: 600; font-family: inherit;
    padding: 5px 10px; border-radius: 7px;
    border: 1.5px solid #e2e8f0; background: #fff; color: #475569;
    cursor: pointer;
    display: inline-flex; align-items: center; gap: 4px;
    transition: background .15s, border-color .15s;
}
.btn-qk:hover { background: #f1f5f9; }
.btn-qk.primary { border-color: #bfdbfe; color: #2563eb; }
.btn-qk.primary:hover { background: #eff6ff; }
.peserta-list-wrap { max-height: 320px; overflow-y: auto; }
.peserta-list-wrap::-webkit-scrollbar { width: 4px; }
.peserta-list-wrap::-webkit-scrollbar-track { background: #f8fafc; }
.peserta-list-wrap::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
.p-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 10px 1.25rem;
    border-bottom: 1px solid #f8fafc;
    transition: background .1s;
}
.p-row:last-child { border-bottom: none; }
.p-row:hover { background: #f8fafc; }
.p-avatar {
    width: 36px; height: 36px; border-radius: 50%;
    background: linear-gradient(135deg, #ede9fe, #dbeafe);
    color: #6d28d9; font-size: 12px; font-weight: 700;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; letter-spacing: -.5px;
}
.p-name  { font-size: 13px; font-weight: 600; color: #1e293b; }
.p-email { font-size: 11px; color: #94a3b8; margin-top: 1px; }
.toggle-switch { position: relative; width: 38px; height: 22px; flex-shrink: 0; }
.toggle-switch input { opacity: 0; width: 0; height: 0; position: absolute; }
.toggle-track {
    position: absolute; inset: 0; border-radius: 11px;
    background: #e2e8f0; cursor: pointer; transition: background .2s;
}
.toggle-track::after {
    content: ''; position: absolute; top: 3px; left: 3px;
    width: 16px; height: 16px; border-radius: 50%; background: #fff;
    transition: left .2s; box-shadow: 0 1px 3px rgba(0,0,0,.2);
}
.toggle-switch input:checked + .toggle-track { background: #6366f1; }
.toggle-switch input:checked + .toggle-track::after { left: 19px; }
.akses-loading {
    display: flex; align-items: center; justify-content: center; gap: 10px;
    padding: 2rem; color: #94a3b8; font-size: 13px;
}
</style>


<div class="ap-page">

    <!-- Header -->
    <div class="ap-header">
        <div class="ap-header-left">
            <h4>Aplikasi Pendukung</h4>
            <p>Kelola aplikasi dan hak akses peserta di kelasmu</p>
        </div>
        <button class="btn-add" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg"></i> Tambah Aplikasi
        </button>
    </div>

    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
    <div class="flash-alert success">
        <i class="bi bi-check-circle-fill"></i>
        <?= session()->getFlashdata('success') ?>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
    <div class="flash-alert error">
        <i class="bi bi-exclamation-circle-fill"></i>
        <?= session()->getFlashdata('error') ?>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
    </div>
    <?php endif; ?>

    <!-- Toolbar -->
    <div class="ap-toolbar">
        <div class="search-box">
            <i class="bi bi-search"></i>
            <input type="text" id="searchAplikasi" placeholder="Cari aplikasi...">
        </div>
        <?php if (!empty($aplikasi)): ?>
        <span class="ap-count-badge" id="countBadge">
            <?= count($aplikasi) ?> aplikasi
        </span>
        <?php endif; ?>
    </div>

    <!-- Grid -->
    <?php if (empty($aplikasi)): ?>
    <div class="empty-wrap">
        <div class="empty-icon"><i class="bi bi-grid-3x3-gap"></i></div>
        <h5>Belum ada aplikasi</h5>
        <p>Klik <strong>Tambah Aplikasi</strong> untuk menambahkan aplikasi baru.</p>
    </div>
    <?php else: ?>
    <div class="app-grid" id="appGrid">
        <?php foreach ($aplikasi as $app):
            $count    = (int)($app['akses_count'] ?? 0);
            $hasAkses = $count > 0;
            $domain   = preg_replace('/^www\./', '', parse_url($app['link_aplikasi'], PHP_URL_HOST) ?? '');
        ?>
        <div class="app-item" data-name="<?= strtolower(esc($app['nama_aplikasi'])) ?>">
            <div class="app-card">

                <!-- Pita gradien atas -->
                <div class="card-ribbon"></div>

                <!-- Ikon + nama -->
                <div class="card-hero">
                    <div class="card-icon-wrap">
                        <div class="card-icon">
                            <i class="bi bi-grid-fill"></i>
                        </div>
                        <div class="card-status-dot" title="Aktif"></div>
                    </div>
                    <div class="card-text">
                        <div class="card-app-name"><?= esc($app['nama_aplikasi']) ?></div>
                        <a href="<?= esc($app['link_aplikasi']) ?>" target="_blank"
                           rel="noopener" class="card-app-url">
                            <i class="bi bi-link-45deg"></i>
                            <?= esc($domain) ?>
                        </a>
                    </div>
                </div>

                <div class="card-divider"></div>

                <!-- Strip akses -->
                <div class="card-akses <?= $hasAkses ? 'has-akses' : 'no-akses' ?>">
                    <div class="akses-left">
                        <div class="akses-icon-wrap">
                            <i class="bi bi-<?= $hasAkses ? 'people-fill' : 'person-x-fill' ?>"></i>
                        </div>
                        <div class="akses-text-main">
                            <?= $hasAkses ? $count.' Peserta' : 'Belum ada akses' ?>
                        </div>
                    </div>
                    <button class="btn-kelola-new"
                        data-bs-toggle="modal"
                        data-bs-target="#modalAkses"
                        data-id="<?= $app['id_aplikasi'] ?>"
                        data-nama="<?= esc($app['nama_aplikasi']) ?>">
                        <i class="bi bi-<?= $hasAkses ? 'gear-fill' : 'plus-lg' ?>"
                           style="font-size:11px"></i>
                        <?= $hasAkses ? 'Kelola' : 'Beri Akses' ?>
                    </button>
                </div>

                <!-- Action bar -->
                <div class="card-actions">
                    <a href="<?= esc($app['link_aplikasi']) ?>" target="_blank"
                       rel="noopener" class="btn-open-new">
                        <i class="bi bi-box-arrow-up-right" style="font-size:11px"></i>
                        Buka Aplikasi
                    </a>
                    <button class="btn-icon-sm btn-edit" title="Edit"
                        data-bs-toggle="modal" data-bs-target="#modalEdit"
                        data-id="<?= $app['id_aplikasi'] ?>"
                        data-nama="<?= esc($app['nama_aplikasi']) ?>"
                        data-link="<?= esc($app['link_aplikasi']) ?>">
                        <i class="bi bi-pencil-fill"></i>
                    </button>
                    <form action="<?= base_url('dashboard/pengajar/aplikasi-pendukung/delete/'.$app['id_aplikasi']) ?>"
                          method="post"
                          onsubmit="return confirm('Hapus aplikasi \'<?= esc($app['nama_aplikasi']) ?>\'?')">
                        <?= csrf_field() ?>
                        <button type="submit" class="btn-icon-sm btn-del" title="Hapus">
                            <i class="bi bi-trash3-fill"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</div><!-- /ap-page -->


<!-- ═══════════════════ MODAL TAMBAH ═══════════════════ -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:440px">
        <form action="<?= base_url('dashboard/pengajar/aplikasi-pendukung/store') ?>"
              method="post" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header">
                <div class="modal-title">
                    <div class="modal-icon green"><i class="bi bi-plus-lg"></i></div>
                    Tambah Aplikasi
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="f-label">Nama Aplikasi</label>
                    <input type="text" name="nama_aplikasi" class="f-input"
                        placeholder="contoh: Google Classroom"
                        value="<?= old('nama_aplikasi') ?>" required>
                </div>
                <div class="form-group">
                    <label class="f-label">Link Aplikasi</label>
                    <div class="input-prefix">
                        <div class="input-prefix-icon"><i class="bi bi-link-45deg"></i></div>
                        <input type="url" name="link_aplikasi" class="f-input"
                            placeholder="https://aplikasi.contoh.com"
                            value="<?= old('link_aplikasi') ?>" required>
                    </div>
                    <p class="f-hint">Pastikan URL diawali dengan https://</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn-modal-primary">
                    <i class="bi bi-check-lg"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>


<!-- ═══════════════════ MODAL EDIT ═══════════════════ -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:440px">
        <form id="formEdit" method="post" class="modal-content">
            <?= csrf_field() ?>
            <div class="modal-header">
                <div class="modal-title">
                    <div class="modal-icon yellow"><i class="bi bi-pencil-fill"></i></div>
                    Edit Aplikasi
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="f-label">Nama Aplikasi</label>
                    <input type="text" name="nama_aplikasi" id="editNama" class="f-input" required>
                </div>
                <div class="form-group">
                    <label class="f-label">Link Aplikasi</label>
                    <div class="input-prefix">
                        <div class="input-prefix-icon"><i class="bi bi-link-45deg"></i></div>
                        <input type="url" name="link_aplikasi" id="editLink" class="f-input" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn-modal-warning">
                    <i class="bi bi-floppy-fill"></i> Perbarui
                </button>
            </div>
        </form>
    </div>
</div>


<!-- ═══════════════════ MODAL HAK AKSES ═══════════════════ -->
<div class="modal fade" id="modalAkses" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:460px">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title">
                    <div class="modal-icon blue"><i class="bi bi-people-fill"></i></div>
                    Hak Akses &mdash;
                    <span id="aksesNamaApp" style="color:#3b82f6;font-weight:700;margin-left:4px"></span>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="akses-search-wrap">
                <div class="search-box" style="max-width:100%">
                    <i class="bi bi-search"></i>
                    <input type="text" id="searchPesertaAkses" placeholder="Cari nama atau email peserta...">
                </div>
            </div>
            <div class="akses-quick">
                <span class="akses-quick-count" id="aksesCountLabel">Belum ada peserta dipilih</span>
                <div class="akses-quick-btns">
                    <button class="btn-qk" onclick="setSemuaAkses(false)">
                        <i class="bi bi-dash-circle" style="font-size:11px"></i> Hapus semua
                    </button>
                    <button class="btn-qk primary" onclick="setSemuaAkses(true)">
                        <i class="bi bi-check-all" style="font-size:11px"></i> Pilih semua
                    </button>
                </div>
            </div>
            <div class="peserta-list-wrap" id="listPesertaAkses">
                <div class="akses-loading">
                    <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
                    Memuat data...
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn-modal-primary" id="btnSimpanAkses">
                    <i class="bi bi-check-lg"></i> Simpan Akses
                </button>
            </div>
        </div>
    </div>
</div>


<script>
const SEMUA_PESERTA = <?= json_encode(
    array_values(array_map(function ($p) {
        return [
            'id'    => (int) $p['id_users'],
            'nama'  => $p['nama'],
            'email' => $p['email'] ?? '',
        ];
    }, $peserta ?? []))
) ?>;

const BASE_URL        = '<?= base_url() ?>';
const CSRF_TOKEN_NAME = '<?= csrf_token() ?>';
let   CSRF_HASH       = '<?= csrf_hash() ?>';

let currentAppId = null;
let aksesState   = {};

function getInitials(nama) {
    return nama.trim().split(/\s+/).slice(0, 2).map(w => w[0].toUpperCase()).join('');
}
function escHtml(str) {
    return String(str)
        .replace(/&/g,'&amp;').replace(/</g,'&lt;')
        .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
function updateCountLabel() {
    const count = Object.values(aksesState).filter(Boolean).length;
    document.getElementById('aksesCountLabel').textContent =
        count === 0 ? 'Belum ada peserta dipilih' : `${count} peserta dipilih`;
}
function renderListPeserta(query = '') {
    const q        = query.toLowerCase();
    const filtered = SEMUA_PESERTA.filter(p =>
        p.nama.toLowerCase().includes(q) || p.email.toLowerCase().includes(q)
    );
    updateCountLabel();
    if (filtered.length === 0) {
        document.getElementById('listPesertaAkses').innerHTML =
            '<p style="text-align:center;color:#94a3b8;font-size:13px;padding:2rem">Tidak ada peserta ditemukan.</p>';
        return;
    }
    document.getElementById('listPesertaAkses').innerHTML = filtered.map(p => `
        <div class="p-row">
            <div style="display:flex;align-items:center;gap:10px">
                <div class="p-avatar">${getInitials(p.nama)}</div>
                <div>
                    <div class="p-name">${escHtml(p.nama)}</div>
                    <div class="p-email">${escHtml(p.email)}</div>
                </div>
            </div>
            <label class="toggle-switch">
                <input type="checkbox" ${aksesState[p.id] ? 'checked' : ''}
                    onchange="aksesState[${p.id}] = this.checked; updateCountLabel()">
                <span class="toggle-track"></span>
            </label>
        </div>
    `).join('');
}
function setSemuaAkses(val) {
    SEMUA_PESERTA.forEach(p => aksesState[p.id] = val);
    renderListPeserta(document.getElementById('searchPesertaAkses').value);
}

document.getElementById('modalAkses').addEventListener('show.bs.modal', function (e) {
    const btn    = e.relatedTarget;
    currentAppId = btn.dataset.id;
    document.getElementById('aksesNamaApp').textContent = btn.dataset.nama;
    document.getElementById('searchPesertaAkses').value = '';
    aksesState = {};
    document.getElementById('listPesertaAkses').innerHTML = `
        <div class="akses-loading">
            <div class="spinner-border spinner-border-sm text-primary" role="status"></div>
            Memuat data...
        </div>`;
    fetch(`${BASE_URL}dashboard/pengajar/aplikasi-pendukung/akses/${currentAppId}`)
        .then(r => r.json())
        .then(data => {
            if (data.success) data.akses.forEach(id => aksesState[id] = true);
            renderListPeserta();
        })
        .catch(() => {
            document.getElementById('listPesertaAkses').innerHTML =
                '<p style="text-align:center;color:#ef4444;font-size:13px;padding:2rem">Gagal memuat data akses.</p>';
        });
});

document.getElementById('searchPesertaAkses').addEventListener('input', function () {
    renderListPeserta(this.value);
});

document.getElementById('btnSimpanAkses').addEventListener('click', function () {
    const btn     = this;
    btn.disabled  = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Menyimpan...';
    const userIds = Object.keys(aksesState).filter(id => aksesState[id]).map(Number);
    fetch(`${BASE_URL}dashboard/pengajar/aplikasi-pendukung/akses/simpan`, {
        method  : 'POST',
        headers : { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body    : JSON.stringify({
            [CSRF_TOKEN_NAME] : CSRF_HASH,
            id_aplikasi       : parseInt(currentAppId),
            user_ids          : userIds,
        }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            if (data.csrf_hash) CSRF_HASH = data.csrf_hash;
            bootstrap.Modal.getInstance(document.getElementById('modalAkses')).hide();
            location.reload();
        } else {
            alert(data.message || 'Gagal menyimpan akses.');
        }
    })
    .catch(() => alert('Terjadi kesalahan jaringan.'))
    .finally(() => {
        btn.disabled  = false;
        btn.innerHTML = '<i class="bi bi-check-lg"></i> Simpan Akses';
    });
});

document.getElementById('modalEdit').addEventListener('show.bs.modal', function (e) {
    const btn = e.relatedTarget;
    document.getElementById('editNama').value = btn.dataset.nama;
    document.getElementById('editLink').value = btn.dataset.link;
    document.getElementById('formEdit').action =
        `${BASE_URL}dashboard/pengajar/aplikasi-pendukung/update/${btn.dataset.id}`;
});

document.getElementById('searchAplikasi')?.addEventListener('input', function () {
    const q     = this.value.toLowerCase();
    let visible = 0;
    document.querySelectorAll('#appGrid .app-item').forEach(item => {
        const show = item.dataset.name.includes(q);
        item.style.display = show ? '' : 'none';
        if (show) visible++;
    });
    const badge = document.getElementById('countBadge');
    if (badge) badge.textContent = visible + ' aplikasi';
});
</script>

<?= $this->endSection() ?>
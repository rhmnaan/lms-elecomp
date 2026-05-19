<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>
<?= $this->section('content') ?>

<style>
:root {
    --cp-bg: #f4f6fb;
    --cp-white: #fff;
    --cp-border: #e8edf5;
    --cp-text: #111827;
    --cp-muted: #6b7280;
    --cp-blue: #2d6cdf;
    --cp-blue-l: #eff6ff;
    --cp-blue-m: #dbeafe;
    --cp-green: #16a34a;
    --cp-green-l: #ecfdf5;
    --cp-orange: #ea580c;
    --cp-orange-l: #fff7ed;
    --cp-red: #dc2626;
    --cp-red-l: #fef2f2;
    --cp-purple: #7c3aed;
    --cp-purple-l: #f5f3ff;
    --cp-sh: 0 2px 12px rgba(0, 0, 0, .06);
    --cp-sh-md: 0 8px 32px rgba(0, 0, 0, .12);
}

/* STATS */
.cp-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
    margin-bottom: 20px
}

.cp-stat {
    background: var(--cp-white);
    border-radius: 16px;
    padding: 18px 20px;
    border: 1.5px solid var(--cp-border);
    box-shadow: var(--cp-sh);
    display: flex;
    align-items: center;
    gap: 14px
}

.cp-stat-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0
}

.cp-stat-icon.blue {
    background: var(--cp-blue-m);
    color: var(--cp-blue)
}

.cp-stat-icon.green {
    background: var(--cp-green-l);
    color: var(--cp-green)
}

.cp-stat-icon.orange {
    background: var(--cp-orange-l);
    color: var(--cp-orange)
}

.cp-stat-val {
    font-size: 26px;
    font-weight: 800;
    color: var(--cp-text);
    line-height: 1
}

.cp-stat-lbl {
    font-size: 12px;
    color: var(--cp-muted);
    margin-top: 3px;
    font-weight: 500
}

/* CARD */
.cp-card {
    background: var(--cp-white);
    border-radius: 20px;
    border: 1.5px solid var(--cp-border);
    box-shadow: var(--cp-sh);
    overflow: hidden
}

/* TOOLBAR */
.cp-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 20px;
    border-bottom: 1.5px solid var(--cp-border);
    flex-wrap: wrap;
    gap: 10px
}

.cp-cal-nav {
    display: flex;
    align-items: center;
    gap: 8px
}

.cp-nav-btn {
    width: 32px;
    height: 32px;
    border: 1.5px solid var(--cp-border);
    background: var(--cp-white);
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--cp-muted);
    font-size: 13px;
    transition: all .15s
}

.cp-nav-btn:hover {
    background: var(--cp-blue-l);
    color: var(--cp-blue);
    border-color: var(--cp-blue-m)
}

.cp-month-lbl {
    font-size: 15px;
    font-weight: 800;
    color: var(--cp-text);
    min-width: 180px;
    text-align: center
}

.cp-filters {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap
}

.cp-sel {
    padding: 6px 10px;
    border: 1.5px solid var(--cp-border);
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    color: var(--cp-text);
    background: var(--cp-white);
    outline: none;
    font-family: 'DM Sans', sans-serif;
    transition: border .15s
}

.cp-sel:focus {
    border-color: var(--cp-blue)
}

/* BUTTONS */
.cpb {
    padding: 7px 14px;
    border: none;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 700;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all .15s
}

.cpb-pri {
    background: var(--cp-blue);
    color: #fff
}

.cpb-pri:hover {
    opacity: .88
}

.cpb-out {
    background: var(--cp-white);
    color: var(--cp-text);
    border: 1.5px solid var(--cp-border)
}

.cpb-out:hover {
    background: var(--cp-bg)
}

.cpb-dan {
    background: var(--cp-red-l);
    color: var(--cp-red);
    border: 1.5px solid #fecaca
}

.cpb-dan:hover {
    background: #fee2e2
}

.cpb-suc {
    background: var(--cp-green-l);
    color: var(--cp-green);
    border: 1.5px solid #bbf7d0
}

.cpb-suc:hover {
    background: #d1fae5
}

.cpb-sm {
    padding: 5px 10px;
    font-size: 11.5px;
    border-radius: 7px
}

/* MANAGE ROW */
.cp-manage {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 9px 20px;
    border-bottom: 1px solid var(--cp-border);
    background: #fafbfc;
    flex-wrap: wrap
}

.cp-manage-lbl {
    font-size: 11px;
    font-weight: 700;
    color: var(--cp-muted);
    letter-spacing: .6px;
    text-transform: uppercase;
    margin-right: 4px
}

/* LEGEND */
.cp-legend {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 8px 20px;
    border-bottom: 1px solid var(--cp-border);
    flex-wrap: wrap
}

.cp-leg-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: var(--cp-muted);
    font-weight: 500
}

.cp-leg-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%
}

.cp-leg-dot.published {
    background: var(--cp-green)
}

.cp-leg-dot.draft {
    background: var(--cp-orange)
}

/* VIEW TOGGLE */
.cp-toggle-wrap {
    display: flex;
    gap: 3px;
    background: var(--cp-bg);
    padding: 3px;
    border-radius: 9px
}

.cp-tog {
    padding: 5px 11px;
    border: none;
    border-radius: 7px;
    background: transparent;
    font-size: 12px;
    font-weight: 600;
    color: var(--cp-muted);
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    transition: all .15s
}

.cp-tog.active {
    background: var(--cp-white);
    color: var(--cp-blue);
    box-shadow: 0 1px 4px rgba(0, 0, 0, .08)
}

/* CALENDAR */
.cp-cal-head {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    border-bottom: 1px solid var(--cp-border)
}

.cp-cal-head-cell {
    padding: 9px 0;
    text-align: center;
    font-size: 10.5px;
    font-weight: 700;
    color: var(--cp-muted);
    letter-spacing: .8px;
    text-transform: uppercase
}

.cp-cal-head-cell.we {
    color: #ef4444
}

.cp-cal-body {
    display: grid;
    grid-template-columns: repeat(7, 1fr)
}

.cp-day {
    min-height: 90px;
    border-right: 1px solid var(--cp-border);
    border-bottom: 1px solid var(--cp-border);
    padding: 7px 7px 5px;
    position: relative;
    cursor: pointer;
    transition: background .12s
}

.cp-day:nth-child(7n) {
    border-right: none
}

.cp-day.empty {
    background: #fafbfd;
    cursor: default;
    pointer-events: none
}

.cp-day:not(.empty):hover {
    background: var(--cp-blue-l)
}

.cp-day.today .cp-day-num {
    background: var(--cp-blue);
    color: #fff;
    border-radius: 50%
}

.cp-day.we .cp-day-num {
    color: #ef4444
}

.cp-day-num {
    font-size: 12.5px;
    font-weight: 700;
    color: var(--cp-text);
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 4px
}

.cp-day-evs {
    display: flex;
    flex-direction: column;
    gap: 2px;
    overflow: hidden;
    max-height: 52px
}

.cp-epill {
    font-size: 10px;
    font-weight: 600;
    padding: 2px 6px;
    border-radius: 5px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    line-height: 1.5
}

.cp-epill.published {
    background: var(--cp-green-l);
    color: #15803d
}

.cp-epill.draft {
    background: var(--cp-orange-l);
    color: #c2410c
}

.cp-more {
    font-size: 10px;
    font-weight: 700;
    color: var(--cp-blue);
    background: var(--cp-blue-l);
    border-radius: 5px;
    padding: 1px 5px;
    display: inline-block
}

.cp-add-hint {
    position: absolute;
    bottom: 5px;
    right: 6px;
    font-size: 10px;
    color: var(--cp-blue);
    opacity: 0;
    transition: opacity .15s
}

.cp-day:not(.empty):hover .cp-add-hint {
    opacity: 1
}

/* LIST */
.cp-ltbl {
    width: 100%;
    border-collapse: collapse
}

.cp-ltbl th {
    padding: 10px 14px;
    font-size: 11px;
    font-weight: 700;
    color: var(--cp-muted);
    text-transform: uppercase;
    letter-spacing: .6px;
    border-bottom: 1.5px solid var(--cp-border);
    text-align: left;
    background: #fafbfc
}

.cp-ltbl td {
    padding: 11px 14px;
    font-size: 13px;
    color: var(--cp-text);
    border-bottom: 1px solid var(--cp-border);
    vertical-align: middle
}

.cp-ltbl tr:last-child td {
    border-bottom: none
}

.cp-ltbl tr:hover td {
    background: var(--cp-blue-l)
}

/* BADGE */
.cp-badge {
    font-size: 11px;
    font-weight: 700;
    padding: 3px 9px;
    border-radius: 20px
}

.cp-badge.published {
    background: var(--cp-green-l);
    color: var(--cp-green)
}

.cp-badge.draft {
    background: var(--cp-orange-l);
    color: var(--cp-orange)
}

/* MODAL */
.cp-back {
    position: fixed;
    inset: 0;
    background: rgba(7, 16, 40, .55);
    backdrop-filter: blur(6px);
    z-index: 9000;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px
}

.cp-back.show {
    display: flex
}

.cp-modal {
    background: var(--cp-white);
    border-radius: 20px;
    width: 100%;
    box-shadow: var(--cp-sh-md);
    animation: cpUp .25s cubic-bezier(.22, 1, .36, 1) both;
    max-height: 90vh;
    display: flex;
    flex-direction: column
}

.cp-mh {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 17px 22px 13px;
    border-bottom: 1.5px solid var(--cp-border);
    flex-shrink: 0
}

.cp-mt {
    font-size: 15px;
    font-weight: 800;
    color: var(--cp-text)
}

.cp-ms {
    font-size: 12px;
    color: var(--cp-muted);
    margin-top: 2px
}

.cp-mcls {
    width: 30px;
    height: 30px;
    border: 1.5px solid var(--cp-border);
    background: var(--cp-white);
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 14px;
    color: var(--cp-muted);
    transition: all .15s
}

.cp-mcls:hover {
    background: #fee2e2;
    color: var(--cp-red);
    border-color: #fca5a5
}

.cp-mb {
    padding: 18px 22px;
    overflow-y: auto;
    flex: 1
}

.cp-mf {
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    padding: 13px 22px;
    border-top: 1.5px solid var(--cp-border);
    flex-shrink: 0
}

@keyframes cpUp {
    from {
        opacity: 0;
        transform: translateY(20px) scale(.97)
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1)
    }
}

/* FORM */
.cp-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 14px;
    margin-bottom: 14px
}

.cp-row.full {
    grid-template-columns: 1fr
}

.cp-field label {
    display: block;
    font-size: 12px;
    font-weight: 700;
    color: #374151;
    margin-bottom: 5px
}

.cp-inp {
    width: 100%;
    padding: 9px 12px;
    border: 1.5px solid var(--cp-border);
    border-radius: 10px;
    font-size: 13px;
    font-family: 'DM Sans', sans-serif;
    color: var(--cp-text);
    outline: none;
    transition: border .15s;
    background: var(--cp-white)
}

.cp-inp:focus {
    border-color: var(--cp-blue);
    box-shadow: 0 0 0 3px rgba(45, 108, 223, .08)
}

textarea.cp-inp {
    resize: vertical;
    min-height: 72px
}

.cp-plat-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    margin-top: 4px
}

.cp-plat-lbl {
    display: flex;
    align-items: center;
    gap: 5px;
    background: var(--cp-bg);
    border: 1.5px solid var(--cp-border);
    padding: 5px 10px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 12.5px;
    font-weight: 600;
    color: var(--cp-muted);
    transition: all .15s;
    user-select: none
}

.cp-plat-lbl input {
    display: none
}

.cp-plat-lbl.on {
    background: var(--cp-blue-l);
    border-color: var(--cp-blue-m);
    color: var(--cp-blue)
}

/* DETAIL */
.cp-det-empty {
    text-align: center;
    padding: 24px 0;
    color: var(--cp-muted)
}

.cp-det-empty i {
    font-size: 30px;
    display: block;
    margin-bottom: 8px;
    opacity: .35
}

.cp-ci {
    border: 1.5px solid var(--cp-border);
    border-radius: 14px;
    padding: 13px 15px;
    margin-bottom: 10px;
    transition: border-color .15s
}

.cp-ci:last-child {
    margin-bottom: 0
}

.cp-ci:hover {
    border-color: var(--cp-blue-m)
}

.cp-ci-hd {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 8px;
    margin-bottom: 7px
}

.cp-ci-title {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--cp-text);
    line-height: 1.35
}

.cp-ci-acts {
    display: flex;
    gap: 5px;
    flex-shrink: 0;
    align-items: center
}

.cp-meta-wrap {
    display: flex;
    flex-wrap: wrap;
    gap: 6px
}

.cp-meta-tag {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    color: var(--cp-muted);
    background: var(--cp-bg);
    padding: 3px 8px;
    border-radius: 6px;
    font-weight: 500
}

/* MASTER TABLE */
.cp-mtbl {
    width: 100%;
    border-collapse: collapse
}

.cp-mtbl th {
    padding: 9px 12px;
    font-size: 11px;
    font-weight: 700;
    color: var(--cp-muted);
    text-transform: uppercase;
    letter-spacing: .6px;
    border-bottom: 1.5px solid var(--cp-border);
    text-align: left;
    background: #fafbfc
}

.cp-mtbl td {
    padding: 10px 12px;
    font-size: 13px;
    border-bottom: 1px solid var(--cp-border);
    vertical-align: middle
}

.cp-mtbl tr:last-child td {
    border-bottom: none
}

.cp-madd {
    display: flex;
    gap: 8px;
    margin-top: 14px;
    flex-wrap: wrap
}

.cp-madd-label {
    font-size: 11px;
    font-weight: 700;
    color: var(--cp-muted);
    letter-spacing: .5px;
    text-transform: uppercase;
    margin-bottom: 8px
}

.cp-sdot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 5px
}

.cp-sdot.aktif {
    background: var(--cp-green)
}

.cp-sdot.nonaktif {
    background: var(--cp-muted)
}

/* SECTION DIVIDER in master */
.cp-sect {
    font-size: 11px;
    font-weight: 700;
    color: var(--cp-muted);
    letter-spacing: .6px;
    text-transform: uppercase;
    padding: 10px 0 6px;
    border-bottom: 1px solid var(--cp-border);
    margin-bottom: 10px
}

/* CONFIRM */
.cp-conf-icon {
    width: 52px;
    height: 52px;
    background: var(--cp-red-l);
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    color: var(--cp-red);
    margin: 0 auto 14px
}

/* TOAST */
#cp-toast {
    position: fixed;
    bottom: 24px;
    right: 24px;
    z-index: 99999;
    display: flex;
    flex-direction: column;
    gap: 8px;
    pointer-events: none
}

.cp-toast {
    background: #1e293b;
    color: #fff;
    padding: 12px 18px;
    border-radius: 12px;
    font-size: 13px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 20px rgba(0, 0, 0, .2);
    animation: cpTI .3s ease both
}

.cp-toast.success {
    background: #166534
}

.cp-toast.error {
    background: #991b1b
}

@keyframes cpTI {
    from {
        opacity: 0;
        transform: translateY(12px)
    }

    to {
        opacity: 1;
        transform: translateY(0)
    }
}

/* RESPONSIVE */
@media(max-width:768px) {
    .cp-stats {
        grid-template-columns: 1fr 1fr
    }

    .cp-stats .cp-stat:last-child {
        grid-column: span 2
    }

    .cp-day {
        min-height: 56px;
        padding: 5px 4px 4px
    }

    .cp-epill {
        display: none
    }

    .cp-day.has-c .cp-day-num::after {
        content: '';
        display: block;
        width: 5px;
        height: 5px;
        background: var(--cp-blue);
        border-radius: 50%;
        margin: 1px auto 0
    }

    .cp-toolbar {
        flex-direction: column;
        align-items: flex-start
    }

    .cp-row {
        grid-template-columns: 1fr
    }
}

.cp-asset-row {
    display: grid;
    grid-template-columns: 1fr 1fr auto;
    gap: 8px;
    align-items: center;
    margin-bottom: 6px;
}

.cp-asset-plat-label {
    font-size: 11px;
    font-weight: 700;
    color: var(--cp-blue);
    margin: 10px 0 4px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.cp-asset-add {
    font-size: 11.5px;
    color: var(--cp-blue);
    background: var(--cp-blue-l);
    border: 1.5px solid var(--cp-blue-m);
    border-radius: 7px;
    padding: 3px 9px;
    cursor: pointer;
    font-family: 'DM Sans', sans-serif;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    margin-top: 4px;
}

.cp-asset-add:hover {
    opacity: .8;
}

.cp-asset-del {
    width: 26px;
    height: 26px;
    background: var(--cp-red-l);
    color: var(--cp-red);
    border: 1.5px solid #fecaca;
    border-radius: 6px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    flex-shrink: 0;
}

.cp-asset-del:hover {
    background: #fee2e2;
}
</style>

<!-- ═══════════════════════════════════
     DATA BRIDGE PHP → JS
════════════════════════════════════ -->
<script>
/* Base URL includes the full prefix so routes match */
const BASE_URL = '<?= rtrim(base_url(), '/') ?>/dashboard/peserta/content-plan';
const CSRF_NAME = '<?= csrf_token() ?>';
let CSRF_HASH = '<?= csrf_hash() ?>';

const RAW_CONTENTS = <?= json_encode(array_map(fn($c) => [
    'id'          => $c['id'],
    'judul'       => $c['judul_konten'],
    'deskripsi'   => $c['deskripsi'] ?? '',
    'tanggal'     => $c['tanggal_publish'],
    'jenis_id'    => $c['jenis_konten_id'],
    'jenis'       => $c['nama_jenis']    ?? '-',
    'type_id'     => $c['content_type_id'],
    'type'        => $c['nama_type']     ?? '-',
    'platform'    => $c['platform']      ?? '-',
    'platform_ids'=> array_map('intval', $c['platform_ids'] ?? []),
    'assets'      => $c['assets']        ?? [],   // ← tambah ini
    'status'      => strtolower($c['status']),
], $contents ?? [])) ?>;

const RAW_PLATFORMS = <?= json_encode(array_map(fn($p) => [
    'id'           => (int)$p['id'],
    'nama_platform'=> $p['nama_platform'],
    'status'       => $p['status'] ?? 'aktif',
], $platforms ?? [])) ?>;

const RAW_JENIS = <?= json_encode(array_map(fn($j) => [
    'id'         => (int)$j['id'],
    'nama_jenis' => $j['nama_jenis'],
    'keterangan' => $j['keterangan'] ?? '',
], $jenis ?? [])) ?>;

const RAW_TYPES = <?= json_encode(array_map(fn($t) => [
    'id'       => (int)$t['id'],
    'nama_type'=> $t['nama_type'],
], $contentTypes ?? [])) ?>;
</script>

<!-- ═══════════════════════════════════
     HTML
════════════════════════════════════ -->
<div class="container-fluid">

    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <div>
            <h4 class="fw-bold mb-0" style="font-size:20px;letter-spacing:-.3px">📅 Content Plan</h4>
            <p class="text-muted mb-0" style="font-size:13px">Kelola dan pantau rencana konten kamu</p>
        </div>
    </div>

    <!-- STATS -->
    <div class="cp-stats">
        <div class="cp-stat">
            <div class="cp-stat-icon blue"><i class="bi bi-collection-fill"></i></div>
            <div>
                <div class="cp-stat-val" id="s-total">0</div>
                <div class="cp-stat-lbl">Total Konten</div>
            </div>
        </div>
        <div class="cp-stat">
            <div class="cp-stat-icon orange"><i class="bi bi-pencil-fill"></i></div>
            <div>
                <div class="cp-stat-val" id="s-draft">0</div>
                <div class="cp-stat-lbl">Draft</div>
            </div>
        </div>
        <div class="cp-stat">
            <div class="cp-stat-icon green"><i class="bi bi-check-circle-fill"></i></div>
            <div>
                <div class="cp-stat-val" id="s-pub">0</div>
                <div class="cp-stat-lbl">Published</div>
            </div>
        </div>
    </div>

    <!-- CALENDAR CARD -->
    <div class="cp-card">

        <!-- Toolbar -->
        <div class="cp-toolbar">
            <div class="cp-cal-nav">
                <button class="cp-nav-btn" id="cp-prev"><i class="bi bi-chevron-left"></i></button>
                <div class="cp-month-lbl" id="cp-mlbl">— —</div>
                <button class="cp-nav-btn" id="cp-next"><i class="bi bi-chevron-right"></i></button>
            </div>
            <div class="cp-filters">
                <select class="cp-sel" id="cp-msel">
                    <?php foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $i=>$m): ?>
                    <option value="<?=$i?>"><?=$m?></option>
                    <?php endforeach ?>
                </select>
                <select class="cp-sel" id="cp-ysel" style="width:86px"></select>
                <button class="cpb cpb-out" id="cp-today"><i class="bi bi-calendar-check"></i> Hari Ini</button>
                <div class="cp-toggle-wrap">
                    <button class="cp-tog active" id="tog-cal"><i class="bi bi-calendar3"></i> Kalender</button>
                    <button class="cp-tog" id="tog-lst"><i class="bi bi-list-ul"></i> List</button>
                </div>
            </div>
        </div>

        <!-- Manage Row -->
        <div class="cp-manage">
            <span class="cp-manage-lbl">Kelola:</span>
            <button class="cpb cpb-out cpb-sm" onclick="openMaster('platform')"><i class="bi bi-display"></i>
                Platform</button>
            <button class="cpb cpb-out cpb-sm" onclick="openMaster('jenis')"><i class="bi bi-tag"></i> Jenis
                Konten</button>
            <button class="cpb cpb-out cpb-sm" onclick="openMaster('type')"><i class="bi bi-layers"></i> Tipe
                Konten</button>
        </div>

        <!-- Legend -->
        <div class="cp-legend">
            <div class="cp-leg-item"><span class="cp-leg-dot published"></span> Published</div>
            <div class="cp-leg-item"><span class="cp-leg-dot draft"></span> Draft</div>
            <span style="margin-left:auto;font-size:12px;color:var(--cp-muted)"><i class="bi bi-hand-index"></i> Klik
                tanggal untuk lihat / tambah konten</span>
        </div>

        <!-- Calendar -->
        <div id="v-cal">
            <div class="cp-cal-head">
                <div class="cp-cal-head-cell">MIN</div>
                <div class="cp-cal-head-cell">SEN</div>
                <div class="cp-cal-head-cell">SEL</div>
                <div class="cp-cal-head-cell">RAB</div>
                <div class="cp-cal-head-cell">KAM</div>
                <div class="cp-cal-head-cell">JUM</div>
                <div class="cp-cal-head-cell we">SAB</div>
            </div>
            <div class="cp-cal-body" id="cal-body"></div>
        </div>

        <!-- List -->
        <div id="v-lst" style="display:none">
            <table class="cp-ltbl">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Platform</th>
                        <th>Jenis</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="lst-body"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- ═══ MODAL: DETAIL TANGGAL ═══ -->
<div class="cp-back" id="m-detail">
    <div class="cp-modal" style="max-width:560px">
        <div class="cp-mh">
            <div>
                <div class="cp-mt" id="m-det-title">Konten</div>
                <div class="cp-ms" id="m-det-sub"></div>
            </div>
            <button class="cp-mcls" onclick="cls('m-detail')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="cp-mb" id="m-det-body"></div>
        <div class="cp-mf">
            <button class="cpb cpb-out" onclick="cls('m-detail')">Tutup</button>
            <button class="cpb cpb-pri" onclick="openAdd(curDate)"><i class="bi bi-plus-lg"></i> Tambah Konten</button>
        </div>
    </div>
</div>

<!-- ═══ MODAL: FORM ADD/EDIT ═══ -->
<div class="cp-back" id="m-form">
    <div class="cp-modal" style="max-width:620px">
        <div class="cp-mh">
            <div>
                <div class="cp-mt" id="mf-title">Tambah Konten</div>
                <div class="cp-ms" id="mf-sub"></div>
            </div>
            <button class="cp-mcls" onclick="cls('m-form')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="cp-mb">
            <input type="hidden" id="f-id">
            <div class="cp-row full">
                <div class="cp-field">
                    <label>Judul Konten <span style="color:var(--cp-red)">*</span></label>
                    <input type="text" class="cp-inp" id="f-judul" placeholder="Masukkan judul konten...">
                </div>
            </div>
            <div class="cp-row full">
                <div class="cp-field">
                    <label>Deskripsi / Caption</label>
                    <textarea class="cp-inp" id="f-desk"
                        placeholder="Deskripsi atau caption konten (opsional)"></textarea>
                </div>
            </div>
            <div class="cp-row">
                <div class="cp-field">
                    <label>Tanggal Publish <span style="color:var(--cp-red)">*</span></label>
                    <input type="date" class="cp-inp" id="f-tgl">
                </div>
                <div class="cp-field">
                    <label>Status <span style="color:var(--cp-red)">*</span></label>
                    <select class="cp-inp" id="f-status">
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                    </select>
                </div>
            </div>
            <div class="cp-row">
                <div class="cp-field">
                    <label>Jenis Konten</label>
                    <select class="cp-inp" id="f-jenis">
                        <option value="">-- Pilih Jenis --</option>
                    </select>
                </div>
                <div class="cp-field">
                    <label>Tipe Konten</label>
                    <select class="cp-inp" id="f-type">
                        <option value="">-- Pilih Tipe --</option>
                    </select>
                </div>
            </div>
            <div class="cp-field">
                <label>Platform</label>
                <div class="cp-plat-wrap" id="f-plats">
                    <span style="font-size:12px;color:var(--cp-muted)">Belum ada platform — tambahkan di menu Kelola
                        Platform</span>
                </div>
            </div>
            <!-- Asset / Link per Platform -->
            <div class="cp-field" style="margin-top:14px">
                <label>Link / Asset per Platform</label>
                <div id="f-assets-wrap">
                    <span style="font-size:12px;color:var(--cp-muted)">Pilih platform terlebih dahulu</span>
                </div>
            </div>
        </div>
        <div class="cp-mf">
            <button class="cpb cpb-out" onclick="cls('m-form')">Batal</button>
            <button class="cpb cpb-pri" id="f-submit" onclick="submitForm()"><i class="bi bi-check-lg"></i>
                Simpan</button>
        </div>
    </div>
</div>

<!-- ═══ MODAL: MASTER DATA (Platform / Jenis / Tipe) ═══ -->
<div class="cp-back" id="m-master">
    <div class="cp-modal" style="max-width:520px">
        <div class="cp-mh">
            <div>
                <div class="cp-mt" id="mm-title">Kelola</div>
                <div class="cp-ms" id="mm-sub"></div>
            </div>
            <button class="cp-mcls" onclick="cls('m-master')"><i class="bi bi-x-lg"></i></button>
        </div>
        <div class="cp-mb">
            <!-- existing items table -->
            <div id="mm-tbl"></div>
            <!-- add new form -->
            <div style="margin-top:16px;padding-top:14px;border-top:1.5px solid var(--cp-border)">
                <div class="cp-madd-label">Tambah Baru</div>
                <div class="cp-madd">
                    <input type="text" class="cp-inp" id="mm-new" placeholder="Nama..." style="flex:1;min-width:120px"
                        onkeydown="if(event.key==='Enter')addMaster()">
                    <input type="text" class="cp-inp" id="mm-ket" placeholder="Keterangan (opsional)"
                        style="flex:1;min-width:120px;display:none">
                    <select class="cp-inp" id="mm-status" style="width:110px;display:none">
                        <option value="aktif">Aktif</option>
                        <option value="nonaktif">Nonaktif</option>
                    </select>
                    <button class="cpb cpb-pri" onclick="addMaster()" style="flex-shrink:0"><i
                            class="bi bi-plus-lg"></i> Tambah</button>
                </div>
            </div>
        </div>
        <div class="cp-mf"><button class="cpb cpb-out" onclick="cls('m-master')">Tutup</button></div>
    </div>
</div>

<!-- ═══ MODAL: CONFIRM DELETE ═══ -->
<div class="cp-back" id="m-confirm">
    <div class="cp-modal" style="max-width:360px">
        <div class="cp-mb" style="text-align:center;padding:28px 24px">
            <div class="cp-conf-icon"><i class="bi bi-trash3-fill"></i></div>
            <div style="font-size:16px;font-weight:800;color:var(--cp-text);margin-bottom:8px" id="mc-title">Hapus?
            </div>
            <p style="font-size:13px;color:var(--cp-muted);line-height:1.6;margin:0" id="mc-msg">Data yang dihapus tidak
                bisa dikembalikan.</p>
        </div>
        <div class="cp-mf">
            <button class="cpb cpb-out" onclick="cls('m-confirm')">Batal</button>
            <button class="cpb cpb-dan" id="mc-ok">Hapus</button>
        </div>
    </div>
</div>

<div id="cp-toast"></div>

<!-- ═══════════════════════════════════
     JAVASCRIPT
════════════════════════════════════ -->
<script>
/* ══ GLOBALS ══ */
const MN = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober',
    'November', 'Desember'
];
const DN = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
const TODAY = new Date();
let cY = TODAY.getFullYear(),
    cM = TODAY.getMonth(),
    curDate = '',
    curMaster = '';

let LC = [...RAW_CONTENTS];
let LP = [...RAW_PLATFORMS];
let LJ = [...RAW_JENIS];
let LT = [...RAW_TYPES];

/* ══ API HELPER ══
   BASE_URL sudah = .../dashboard/peserta/content-plan
   tinggal append: /store, /master/jenis/store, dst
*/
function hdr() {
    return {
        'Content-Type': 'application/json',
        [CSRF_NAME]: CSRF_HASH
    };
}
async function api(path, body = {}) {
    const r = await fetch(BASE_URL + path, {
        method: 'POST',
        headers: hdr(),
        body: JSON.stringify(body)
    });
    const d = await r.json();
    if (d.csrf) CSRF_HASH = d.csrf;
    return d;
}

/* ══ TOAST ══ */
function toast(msg, type = 'success') {
    const el = document.createElement('div');
    el.className = 'cp-toast ' + type;
    el.innerHTML = `<i class="bi bi-${type==='success'?'check-circle':'exclamation-circle'}-fill"></i> ${msg}`;
    document.getElementById('cp-toast').appendChild(el);
    setTimeout(() => el.remove(), 3000);
}

/* ══ MODAL ══ */
function opn(id) {
    document.getElementById(id).classList.add('show');
    document.body.style.overflow = 'hidden';
}

function cls(id) {
    document.getElementById(id).classList.remove('show');
    if (!document.querySelector('.cp-back.show')) document.body.style.overflow = '';
}
document.querySelectorAll('.cp-back').forEach(b => b.addEventListener('click', e => {
    if (e.target === b) cls(b.id);
}));
document.addEventListener('keydown', e => {
    if (e.key === 'Escape') document.querySelectorAll('.cp-back.show').forEach(b => cls(b.id));
});

/* ══ HELPERS ══ */
function esc(s) {
    if (!s || s === '-') return s || '-';
    return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function cap(s) {
    return s ? s.charAt(0).toUpperCase() + s.slice(1) : '';
}

function fdt(s) {
    if (!s) return '-';
    const d = new Date(s + 'T00:00:00');
    return d.getDate() + ' ' + MN[d.getMonth()] + ' ' + d.getFullYear();
}

function isOk(d) {
    return d && (d.status === 'ok' || d.success === true);
}

function buildMap() {
    const m = {};
    LC.forEach(c => {
        if (!c.tanggal) return;
        const k = c.tanggal.slice(0, 10);
        if (!m[k]) m[k] = [];
        m[k].push(c);
    });
    return m;
}

/* ══ STATS ══ */
function rfStats() {
    document.getElementById('s-total').textContent = LC.length;
    document.getElementById('s-draft').textContent = LC.filter(c => c.status === 'draft').length;
    document.getElementById('s-pub').textContent = LC.filter(c => ['publish', 'published'].includes(c.status)).length;
}

/* ══ YEAR SELECT ══ */
function buildYears() {
    const sel = document.getElementById('cp-ysel');
    const ys = new Set([TODAY.getFullYear()]);
    LC.forEach(c => {
        if (c.tanggal) ys.add(new Date(c.tanggal).getFullYear());
    });
    for (let y = TODAY.getFullYear() - 2; y <= TODAY.getFullYear() + 3; y++) ys.add(y);
    sel.innerHTML = '';
    [...ys].sort().forEach(y => {
        const o = document.createElement('option');
        o.value = y;
        o.textContent = y;
        sel.appendChild(o);
    });
    sel.value = cY;
}

function syncSel() {
    document.getElementById('cp-msel').value = cM;
    document.getElementById('cp-ysel').value = cY;
}

/* ══ RENDER CALENDAR ══ */
function rfCal() {
    const map = buildMap();
    document.getElementById('cp-mlbl').textContent = MN[cM] + ' ' + cY;
    syncSel();
    const body = document.getElementById('cal-body');
    body.innerHTML = '';
    const first = new Date(cY, cM, 1).getDay();
    const days = new Date(cY, cM + 1, 0).getDate();
    const todS = TODAY.toISOString().slice(0, 10);
    for (let i = 0; i < first; i++) {
        const c = document.createElement('div');
        c.className = 'cp-day empty';
        body.appendChild(c);
    }
    for (let d = 1; d <= days; d++) {
        const ds = cY + '-' + String(cM + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
        const evs = map[ds] || [];
        const dow = new Date(cY, cM, d).getDay();
        const cell = document.createElement('div');
        cell.className = 'cp-day' + (ds === todS ? ' today' : '') + (dow === 6 ? ' we' : '') + (evs.length ? ' has-c' :
            '');
        const num = document.createElement('div');
        num.className = 'cp-day-num';
        num.textContent = d;
        cell.appendChild(num);
        if (evs.length) {
            const ew = document.createElement('div');
            ew.className = 'cp-day-evs';
            evs.slice(0, 2).forEach(ev => {
                const p = document.createElement('div');
                p.className = 'cp-epill ' + (ev.status === 'published' ? 'published' : 'draft');
                p.textContent = ev.judul;
                ew.appendChild(p);
            });
            if (evs.length > 2) {
                const m = document.createElement('span');
                m.className = 'cp-more';
                m.textContent = '+' + (evs.length - 2) + ' lagi';
                ew.appendChild(m);
            }
            cell.appendChild(ew);
        }
        const hint = document.createElement('span');
        hint.className = 'cp-add-hint';
        hint.innerHTML = '<i class="bi bi-plus-circle-fill"></i>';
        cell.appendChild(hint);
        cell.addEventListener('click', () => openDay(ds));
        body.appendChild(cell);
    }
}

/* ══ RENDER LIST ══ */
function rfList() {
    const tb = document.getElementById('lst-body');
    tb.innerHTML = '';
    const fl = LC.filter(c => {
        if (!c.tanggal) return false;
        const dt = new Date(c.tanggal);
        return dt.getFullYear() === cY && dt.getMonth() === cM;
    }).sort((a, b) => a.tanggal.localeCompare(b.tanggal));
    if (!fl.length) {
        tb.innerHTML =
            '<tr><td colspan="6" style="text-align:center;padding:28px;color:var(--cp-muted)">Tidak ada konten di bulan ini</td></tr>';
        return;
    }
    fl.forEach(c => {
        const sc = c.status === 'published' ? 'published' : 'draft';
        const tr = document.createElement('tr');
        tr.innerHTML = `<td style="font-weight:600">${esc(c.judul)}</td><td>${esc(c.platform)}</td><td>${esc(c.jenis)}</td><td>${fdt(c.tanggal)}</td>
        <td><span class="cp-badge ${sc}">${cap(c.status)}</span></td>
        <td><div style="display:flex;gap:5px">
            <button class="cpb cpb-out cpb-sm" onclick="openEdit(${c.id})"><i class="bi bi-pencil"></i></button>
            <button class="cpb cpb-dan cpb-sm" onclick="confirmDel(${c.id},'${esc(c.judul)}','content')"><i class="bi bi-trash3"></i></button>
        </div></td>`;
        tb.appendChild(tr);
    });
}

function openDay(ds) {
    curDate = ds;
    const items = buildMap()[ds] || [];
    const dt = new Date(ds + 'T00:00:00');
    document.getElementById('m-det-title').textContent =
        DN[dt.getDay()] + ', ' + dt.getDate() + ' ' + MN[dt.getMonth()] + ' ' + dt.getFullYear();
    document.getElementById('m-det-sub').textContent =
        items.length ? items.length + ' konten dijadwalkan' : 'Belum ada konten';

    const body = document.getElementById('m-det-body');
    body.innerHTML = '';

    if (!items.length) {
        body.innerHTML = `<div class="cp-det-empty">
            <i class="bi bi-calendar-plus"></i>
            <div style="font-weight:600">Belum ada konten untuk tanggal ini</div>
            <div style="font-size:12px;margin-top:4px;color:var(--cp-muted)">Klik "Tambah Konten" untuk membuat jadwal baru</div>
        </div>`;
    } else {
        items.forEach(c => {
            const sc = c.status === 'published' ? 'published' : 'draft';

            // Render asset links per platform
            let assetHtml = '';
            if (c.assets && Object.keys(c.assets).length) {
                Object.entries(c.assets).forEach(([pid, arr]) => {
                    const plat = LP.find(p => p.id == pid);
                    const platName = plat ? plat.nama_platform : 'Platform';
                    arr.forEach(a => {
                        if (!a.asset_link) return;
                        assetHtml += `<a href="${esc(a.asset_link)}" target="_blank" rel="noopener"
                            style="display:inline-flex;align-items:center;gap:5px;font-size:11.5px;
                                   color:var(--cp-blue);background:var(--cp-blue-l);
                                   border:1.5px solid var(--cp-blue-m);border-radius:7px;
                                   padding:3px 9px;margin:3px 4px 0 0;text-decoration:none;font-weight:600">
                            <i class="bi bi-link-45deg"></i>
                            ${esc(a.asset_nama || platName)}
                        </a>`;
                    });
                });
            }

            const div = document.createElement('div');
            div.className = 'cp-ci';
            div.innerHTML = `
            <div class="cp-ci-hd">
                <div class="cp-ci-title">${esc(c.judul)}</div>
                <div class="cp-ci-acts">
                    <span class="cp-badge ${sc}">${cap(c.status)}</span>
                    <button class="cpb cpb-out cpb-sm" onclick="openEdit(${c.id})"><i class="bi bi-pencil"></i></button>
                    <button class="cpb cpb-dan cpb-sm" onclick="confirmDel(${c.id},'${esc(c.judul)}','content')"><i class="bi bi-trash3"></i></button>
                </div>
            </div>
            ${c.deskripsi ? `<p style="font-size:12px;color:var(--cp-muted);margin:0 0 7px;line-height:1.55">
                ${esc(c.deskripsi.slice(0, 120))}${c.deskripsi.length > 120 ? '…' : ''}</p>` : ''}
            <div class="cp-meta-wrap">
                <span class="cp-meta-tag"><i class="bi bi-display"></i>${esc(c.platform)}</span>
                <span class="cp-meta-tag"><i class="bi bi-tag"></i>${esc(c.jenis)}</span>
                ${c.type && c.type !== '-' ? `<span class="cp-meta-tag"><i class="bi bi-layers"></i>${esc(c.type)}</span>` : ''}
            </div>
            ${assetHtml ? `<div style="margin-top:8px">${assetHtml}</div>` : ''}`;

            body.appendChild(div);
        });
    }
    opn('m-detail');
}

/* ══ ASSET BUILDER ══
   Dipanggil setelah platform checkbox berubah atau saat open edit.
   Membuat baris input nama+link per platform yang dicentang.
*/
function rfAssets(selectedPlatformIds = [], existingAssets = {}) {
    const wrap = document.getElementById('f-assets-wrap');
    wrap.innerHTML = '';

    const aktif = LP.filter(p => p.status === 'aktif' && selectedPlatformIds.includes(p.id));

    if (!aktif.length) {
        wrap.innerHTML = '<span style="font-size:12px;color:var(--cp-muted)">Pilih platform terlebih dahulu</span>';
        return;
    }

    aktif.forEach(p => {
        const key = String(p.id);
        const existing = existingAssets[key] || [];

        const section = document.createElement('div');
        section.dataset.pid = p.id;

        const lbl = document.createElement('div');
        lbl.className = 'cp-asset-plat-label';
        lbl.innerHTML = `<i class="bi bi-display"></i> ${esc(p.nama_platform)}`;
        section.appendChild(lbl);

        const rowsWrap = document.createElement('div');
        rowsWrap.className = 'cp-asset-rows';
        section.appendChild(rowsWrap);

        // Tambah existing rows
        if (existing.length) {
            existing.forEach(a => addAssetRow(rowsWrap, a.asset_nama, a.asset_link, a.keterangan));
        } else {
            addAssetRow(rowsWrap); // satu row kosong
        }

        const addBtn = document.createElement('button');
        addBtn.type = 'button';
        addBtn.className = 'cp-asset-add';
        addBtn.innerHTML = '<i class="bi bi-plus-lg"></i> Tambah Link';
        addBtn.addEventListener('click', () => addAssetRow(rowsWrap));
        section.appendChild(addBtn);

        wrap.appendChild(section);
    });
}

function addAssetRow(container, nama = '', link = '', ket = '') {
    const row = document.createElement('div');
    row.className = 'cp-asset-row';
    row.innerHTML = `
        <input type="text" class="cp-inp" placeholder="Nama asset / konten" value="${esc(nama)}" data-field="nama">
        <input type="url"  class="cp-inp" placeholder="https://..." value="${esc(link)}" data-field="link">
        <button type="button" class="cp-asset-del" title="Hapus baris"><i class="bi bi-x-lg"></i></button>`;
    row.querySelector('.cp-asset-del').addEventListener('click', () => {
        row.remove();
        // Jika tidak ada row tersisa, tambah satu kosong
        if (!container.querySelectorAll('.cp-asset-row').length) addAssetRow(container);
    });
    container.appendChild(row);
}

/* Baca semua asset dari form → { "platform_id": [{nama,link,ket},...], ... } */
function collectAssets() {
    const result = {};
    document.querySelectorAll('#f-assets-wrap > div[data-pid]').forEach(section => {
        const pid = section.dataset.pid;
        const rows = [];
        section.querySelectorAll('.cp-asset-row').forEach(row => {
            const nama = row.querySelector('[data-field="nama"]').value.trim();
            const link = row.querySelector('[data-field="link"]').value.trim();
            if (nama || link) rows.push({
                nama,
                link,
                ket: ''
            });
        });
        if (rows.length) result[pid] = rows;
    });
    return result;
}

/* ══ FILL FORM DROPDOWNS ══ */
function fillForm(selectedPlatIds = [], existingAssets = {}) {
    // Jenis
    const js = document.getElementById('f-jenis');
    js.innerHTML = '<option value="">-- Pilih Jenis --</option>';
    LJ.forEach(j => {
        const o = document.createElement('option');
        o.value = j.id;
        o.textContent = j.nama_jenis;
        js.appendChild(o);
    });
    // Type
    const ts = document.getElementById('f-type');
    ts.innerHTML = '<option value="">-- Pilih Tipe --</option>';
    LT.forEach(t => {
        const o = document.createElement('option');
        o.value = t.id;
        o.textContent = t.nama_type;
        ts.appendChild(o);
    });
    // Platform checkboxes
    const pw = document.getElementById('f-plats');
    pw.innerHTML = '';
    const aktif = LP.filter(p => p.status === 'aktif');
    if (!aktif.length) {
        pw.innerHTML = '<span style="font-size:12px;color:var(--cp-muted)">Belum ada platform aktif</span>';
        rfAssets([], {});
        return;
    }
    aktif.forEach(p => {
        const lbl = document.createElement('label');
        lbl.className = 'cp-plat-lbl' + (selectedPlatIds.includes(p.id) ? ' on' : '');
        lbl.innerHTML =
            `<input type="checkbox" value="${p.id}"${selectedPlatIds.includes(p.id) ? ' checked' : ''}> <i class="bi bi-display" style="font-size:11px"></i> ${esc(p.nama_platform)}`;
        lbl.querySelector('input').addEventListener('change', function() {
            lbl.classList.toggle('on', this.checked);
            rfAssets(getCheckedPlatIds(), collectAssets());
        });
        pw.appendChild(lbl);
    });
    // Render asset sesuai platform terpilih
    rfAssets(selectedPlatIds, existingAssets);
}

function getCheckedPlatIds() {
    return [...document.querySelectorAll('#f-plats input:checked')].map(i => parseInt(i.value));
}


/* ══ OPEN ADD ══ */
function openAdd(ds) {
    cls('m-detail');
    fillForm([], {});
    document.getElementById('f-id').value = '';
    document.getElementById('mf-title').textContent = 'Tambah Konten';
    document.getElementById('mf-sub').textContent = ds ? 'Tanggal: ' + fdt(ds) : '';
    document.getElementById('f-judul').value = '';
    document.getElementById('f-desk').value = '';
    document.getElementById('f-tgl').value = ds || '';
    document.getElementById('f-status').value = 'draft';
    document.getElementById('f-jenis').value = '';
    document.getElementById('f-type').value = '';
    opn('m-form');
}


/* ══ OPEN EDIT ══ */
function openEdit(id) {
    const c = LC.find(x => x.id == id);
    if (!c) return;
    cls('m-detail');

    // assets dari LC sudah berbentuk { "pid": [{asset_nama, asset_link, ...}] }
    // perlu dikonversi ke key string dan field nama/link
    const existingAssets = {};
    if (c.assets) {
        Object.entries(c.assets).forEach(([pid, arr]) => {
            existingAssets[pid] = arr.map(a => ({
                asset_nama: a.asset_nama,
                asset_link: a.asset_link,
                keterangan: a.keterangan,
            }));
        });
    }

    fillForm(c.platform_ids, existingAssets);

    document.getElementById('f-id').value = c.id;
    document.getElementById('mf-title').textContent = 'Edit Konten';
    document.getElementById('mf-sub').textContent = 'Tanggal: ' + fdt(c.tanggal);
    document.getElementById('f-judul').value = c.judul;
    document.getElementById('f-desk').value = c.deskripsi || '';
    document.getElementById('f-tgl').value = c.tanggal ? c.tanggal.slice(0, 10) : '';
    document.getElementById('f-status').value = c.status;
    document.getElementById('f-jenis').value = c.jenis_id || '';
    document.getElementById('f-type').value = c.type_id || '';
    opn('m-form');
}

/* ══ SUBMIT FORM ══ */
async function submitForm() {
    const id = document.getElementById('f-id').value;
    const judul = document.getElementById('f-judul').value.trim();
    const desk = document.getElementById('f-desk').value.trim();
    const tgl = document.getElementById('f-tgl').value;
    const status = document.getElementById('f-status').value;
    const jenisId = document.getElementById('f-jenis').value;
    const typeId = document.getElementById('f-type').value;
    const platIds = getCheckedPlatIds();
    const assets = collectAssets(); // ← kumpulkan asset

    if (!judul) {
        toast('Judul wajib diisi', 'error');
        return;
    }
    if (!tgl) {
        toast('Tanggal wajib diisi', 'error');
        return;
    }

    const btn = document.getElementById('f-submit');
    btn.disabled = true;
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';

    try {
        const path = id ? '/update/' + id : '/store';
        const d = await api(path, {
            judul_konten: judul,
            deskripsi: desk,
            tanggal_publish: tgl,
            status,
            jenis_konten_id: jenisId || null,
            content_type_id: typeId || null,
            platform_ids: platIds,
            assets, // ← kirim ke controller
        });

        if (isOk(d)) {
            const newId = d.id || id;

            // Rebuild asset map untuk local state
            const assetMap = {};
            platIds.forEach(pid => {
                const key = String(pid);
                if (assets[key]) {
                    assetMap[pid] = assets[key].map(a => ({
                        asset_nama: a.nama,
                        asset_link: a.link,
                        keterangan: a.ket || '',
                    }));
                }
            });

            const obj = {
                id: parseInt(newId),
                judul,
                deskripsi: desk,
                tanggal: tgl,
                status,
                jenis_id: jenisId ? parseInt(jenisId) : null,
                type_id: typeId ? parseInt(typeId) : null,
                platform_ids: platIds,
                assets: assetMap,
                jenis: LJ.find(j => j.id == jenisId)?.nama_jenis || '-',
                type: LT.find(t => t.id == typeId)?.nama_type || '-',
                platform: platIds.map(pid => LP.find(p => p.id == pid)?.nama_platform || '').filter(Boolean)
                    .join(', ') || '-',
            };

            if (id) {
                const i = LC.findIndex(c => c.id == id);
                if (i > -1) LC[i] = obj;
            } else {
                LC.push(obj);
            }

            toast(id ? 'Konten berhasil diperbarui' : 'Konten berhasil ditambahkan');
            cls('m-form');
            rfCal();
            rfList();
            rfStats();
        } else {
            toast(d.message || 'Gagal menyimpan', 'error');
        }
    } catch (e) {
        console.error(e);
        toast('Koneksi gagal', 'error');
    }

    btn.disabled = false;
    btn.innerHTML = '<i class="bi bi-check-lg"></i> Simpan';
}


/* ══ CONFIRM DELETE ══ */
function confirmDel(id, label, type) {
    document.getElementById('mc-title').textContent = 'Hapus "' + label + '"?';
    document.getElementById('mc-msg').textContent = 'Data yang dihapus tidak bisa dikembalikan.';
    const btn = document.getElementById('mc-ok');
    btn.onclick = type === 'content' ? () => doDeleteContent(id) : () => doDeleteMaster(id, type);
    opn('m-confirm');
}
async function doDeleteContent(id) {
    const btn = document.getElementById('mc-ok');
    btn.disabled = true;
    btn.textContent = 'Menghapus...';
    try {
        const d = await api('/delete/' + id);
        if (isOk(d)) {
            LC = LC.filter(c => c.id != id);
            toast('Konten dihapus');
            cls('m-confirm');
            rfCal();
            rfList();
            rfStats();
        } else toast(d.message || 'Gagal', 'error');
    } catch (e) {
        toast('Koneksi gagal', 'error');
    }
    btn.disabled = false;
    btn.textContent = 'Hapus';
}

/* ══════════════════════════════════════
   MASTER DATA — Platform / Jenis / Tipe
══════════════════════════════════════ */
const MCFG = {
    platform: {
        title: 'Platform',
        sub: 'Kelola platform tempat konten dipublikasikan',
        storeUrl: '/master/platform/store',
        updateUrl: '/master/platform/update/',
        deleteUrl: '/master/platform/delete/',
        key: 'nama_platform',
        hasStatus: true,
        hasKet: false,
    },
    jenis: {
        title: 'Jenis Konten',
        sub: 'Kelola kategori jenis konten',
        storeUrl: '/master/jenis/store',
        updateUrl: '/master/jenis/update/',
        deleteUrl: '/master/jenis/delete/',
        key: 'nama_jenis',
        hasStatus: false,
        hasKet: true,
    },
    type: {
        title: 'Tipe Konten',
        sub: 'Kelola format/tipe konten',
        storeUrl: '/master/type/store',
        updateUrl: '/master/type/update/',
        deleteUrl: '/master/type/delete/',
        key: 'nama_type',
        hasStatus: false,
        hasKet: false,
    },
};

function getArr(t) {
    return t === 'platform' ? LP : t === 'jenis' ? LJ : LT;
}

function openMaster(t) {
    curMaster = t;
    const cfg = MCFG[t];
    document.getElementById('mm-title').textContent = cfg.title;
    document.getElementById('mm-sub').textContent = cfg.sub;
    document.getElementById('mm-new').value = '';
    document.getElementById('mm-ket').value = '';
    // show/hide extra fields
    document.getElementById('mm-ket').style.display = cfg.hasKet ? '' : 'none';
    document.getElementById('mm-status').style.display = cfg.hasStatus ? '' : 'none';
    rfMaster(t);
    opn('m-master');
}

function rfMaster(t) {
    const arr = getArr(t),
        cfg = MCFG[t],
        wrap = document.getElementById('mm-tbl');
    if (!arr.length) {
        wrap.innerHTML =
            '<div style="text-align:center;color:var(--cp-muted);padding:20px 0;font-size:13px"><i class="bi bi-inbox" style="font-size:28px;display:block;margin-bottom:6px;opacity:.35"></i>Belum ada data</div>';
        return;
    }
    let h =
        `<table class="cp-mtbl"><thead><tr><th style="width:36px">#</th><th>Nama</th>${cfg.hasKet?'<th>Keterangan</th>':''}${cfg.hasStatus?'<th>Status</th>':''}<th style="width:90px">Aksi</th></tr></thead><tbody>`;
    arr.forEach((item, i) => {
        const nameVal = esc(item[cfg.key]);
        h += `<tr id="mr-${item.id}">
        <td style="color:var(--cp-muted);font-size:12px">${i+1}</td>
        <td>
            <span id="mn-${item.id}">${nameVal}</span>
            <input id="me-${item.id}" type="text" class="cp-inp" value="${nameVal}" style="display:none;padding:5px 9px;font-size:12.5px" onkeydown="if(event.key==='Enter')saveME(${item.id},'${t}')">
        </td>
        ${cfg.hasKet?`<td style="font-size:12px;color:var(--cp-muted);max-width:140px"><span class="text-truncate d-block">${esc(item.keterangan)||'-'}</span></td>`:''}
        ${cfg.hasStatus?`<td><span class="cp-sdot ${item.status||'aktif'}"></span>${cap(item.status||'aktif')}</td>`:''}
        <td>
            <div style="display:flex;gap:4px">
                <button class="cpb cpb-out cpb-sm" id="mb-e-${item.id}" title="Edit" onclick="startME(${item.id},'${t}')"><i class="bi bi-pencil"></i></button>
                <button class="cpb cpb-suc cpb-sm" id="mb-s-${item.id}" title="Simpan" style="display:none" onclick="saveME(${item.id},'${t}')"><i class="bi bi-check-lg"></i></button>
                <button class="cpb cpb-dan cpb-sm" title="Hapus" onclick="confirmDelMaster(${item.id},'${nameVal}','${t}')"><i class="bi bi-trash3"></i></button>
            </div>
        </td></tr>`;
    });
    h += '</tbody></table>';
    wrap.innerHTML = h;
}

function startME(id, t) {
    document.getElementById('mn-' + id).style.display = 'none';
    document.getElementById('me-' + id).style.display = 'block';
    document.getElementById('mb-e-' + id).style.display = 'none';
    document.getElementById('mb-s-' + id).style.display = '';
    document.getElementById('me-' + id).focus();
}

async function saveME(id, t) {
    const val = document.getElementById('me-' + id).value.trim();
    if (!val) {
        toast('Nama tidak boleh kosong', 'error');
        return;
    }
    const cfg = MCFG[t];
    // payload: jenis pakai 'nama', platform/type pakai 'name'
    const payload = t === 'jenis' ? {
        nama: val
    } : {
        name: val
    };
    try {
        const d = await api(cfg.updateUrl + id, payload);
        if (isOk(d)) {
            const item = getArr(t).find(x => x.id == id);
            if (item) item[cfg.key] = val;
            toast('Berhasil diperbarui');
            rfMaster(t);
            fillForm(); // refresh dropdown form
        } else toast(d.message || 'Gagal', 'error');
    } catch (e) {
        toast('Koneksi gagal', 'error');
    }
}

function confirmDelMaster(id, label, t) {
    confirmDel(id, label, t); // reuse confirm modal, pass type
}
async function doDeleteMaster(id, t) {
    const btn = document.getElementById('mc-ok');
    btn.disabled = true;
    btn.textContent = 'Menghapus...';
    const cfg = MCFG[t];
    try {
        const d = await api(cfg.deleteUrl + id);
        if (isOk(d)) {
            if (t === 'platform') LP = LP.filter(x => x.id != id);
            else if (t === 'jenis') LJ = LJ.filter(x => x.id != id);
            else LT = LT.filter(x => x.id != id);
            toast('Berhasil dihapus');
            cls('m-confirm');
            rfMaster(t);
            fillForm(); // refresh dropdown
        } else toast(d.message || 'Gagal', 'error');
    } catch (e) {
        toast('Koneksi gagal', 'error');
    }
    btn.disabled = false;
    btn.textContent = 'Hapus';
}

async function addMaster() {
    const t = curMaster,
        cfg = MCFG[t];
    const nama = document.getElementById('mm-new').value.trim();
    if (!nama) {
        toast('Nama tidak boleh kosong', 'error');
        document.getElementById('mm-new').focus();
        return;
    }
    const ket = cfg.hasKet ? document.getElementById('mm-ket').value.trim() : null;
    const status = cfg.hasStatus ? document.getElementById('mm-status').value : null;
    // build payload — jenis pakai key 'nama', platform pakai 'nama', type pakai 'name'
    let payload = t === 'type' ? {
        name: nama
    } : {
        nama
    };
    if (ket !== null) payload.ket = ket;
    if (status !== null) payload.status = status;
    try {
        const d = await api(cfg.storeUrl, payload);
        if (isOk(d)) {
            const newId = parseInt(d.id || d.insertId);
            const newItem = {
                id: newId,
                [cfg.key]: nama
            };
            if (cfg.hasKet) newItem.keterangan = ket || '';
            if (cfg.hasStatus) newItem.status = status || 'aktif';
            getArr(t).push(newItem);
            document.getElementById('mm-new').value = '';
            if (cfg.hasKet) document.getElementById('mm-ket').value = '';
            toast('Berhasil ditambahkan');
            rfMaster(t);
            fillForm();
        } else toast(d.message || 'Gagal', 'error');
    } catch (e) {
        toast('Koneksi gagal', 'error');
    }
}

/* ══ NAV ══ */
function nav(d) {
    cM += d;
    if (cM > 11) {
        cM = 0;
        cY++;
    }
    if (cM < 0) {
        cM = 11;
        cY--;
    }
    rfCal();
    rfList();
}
document.getElementById('cp-prev').addEventListener('click', () => nav(-1));
document.getElementById('cp-next').addEventListener('click', () => nav(1));
document.getElementById('cp-today').addEventListener('click', () => {
    cM = TODAY.getMonth();
    cY = TODAY.getFullYear();
    rfCal();
    rfList();
});
document.getElementById('cp-msel').addEventListener('change', function() {
    cM = parseInt(this.value);
    rfCal();
    rfList();
});
document.getElementById('cp-ysel').addEventListener('change', function() {
    cY = parseInt(this.value);
    rfCal();
    rfList();
});
document.getElementById('tog-cal').addEventListener('click', function() {
    this.classList.add('active');
    document.getElementById('tog-lst').classList.remove('active');
    document.getElementById('v-cal').style.display = '';
    document.getElementById('v-lst').style.display = 'none';
    rfCal();
});
document.getElementById('tog-lst').addEventListener('click', function() {
    this.classList.add('active');
    document.getElementById('tog-cal').classList.remove('active');
    document.getElementById('v-cal').style.display = 'none';
    document.getElementById('v-lst').style.display = 'block';
    rfList();
});
document.addEventListener('keydown', e => {
    if (!document.querySelector('.cp-back.show') && e.key === 'ArrowLeft') nav(-1);
    if (!document.querySelector('.cp-back.show') && e.key === 'ArrowRight') nav(1);
});

/* ══ INIT ══ */
buildYears();
rfCal();
rfStats();
</script>

<?= $this->endSection() ?>
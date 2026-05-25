<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('styles') ?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');

:root {
    --acc: #6366f1;
    --acc-soft: #eef2ff;
    --acc-mid: #c7d2fe;
    --txt: #0f0e17;
    --muted: #6b7280;
    --meta: #9ca3af;
    --bg: #f5f4ff;
    --card: #ffffff;
    --border: #e8e6ff;
    --r: 18px;
    --sh: 0 2px 20px rgba(99, 102, 241, .07);
    --sh2: 0 12px 40px rgba(99, 102, 241, .15);
}

.pg-wrap {
    font-family: 'Plus Jakarta Sans', sans-serif;
    background: var(--bg);
    min-height: 100vh;
    padding: 2rem 2rem 3rem;
}

/* Header */
.pg-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2.5rem;
}

.pg-eyebrow {
    font-size: .68rem;
    font-weight: 600;
    letter-spacing: .2em;
    color: var(--acc);
    text-transform: uppercase;
    margin: 0 0 .35rem;
}

.pg-h1 {
    font-family: 'Syne', sans-serif;
    font-size: 2.4rem;
    font-weight: 800;
    color: var(--txt);
    line-height: 1.05;
    letter-spacing: -.04em;
    margin: 0 0 .4rem;
}

.pg-h1 .acc {
    color: var(--acc);
}

.pg-sub {
    font-size: .84rem;
    color: var(--muted);
    margin: 0;
}

.pg-ctr {
    text-align: right;
}

.pg-ctr-num {
    font-family: 'Syne', sans-serif;
    font-size: 3.6rem;
    font-weight: 800;
    line-height: 1;
    color: transparent;
    -webkit-text-stroke: 2px var(--acc-mid);
    letter-spacing: -.06em;
}

.pg-ctr-lbl {
    font-size: .65rem;
    color: var(--meta);
    letter-spacing: .14em;
    text-transform: uppercase;
}

/* Grid */
.pg-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));
    gap: 20px;
}

/* Card */
.pg-card {
    background: var(--card);
    border-radius: var(--r);
    border: 1.5px solid var(--border);
    text-decoration: none;
    display: flex;
    flex-direction: column;
    padding: 1.6rem;
    position: relative;
    overflow: hidden;
    box-shadow: var(--sh);
    transition: transform .35s cubic-bezier(.175, .885, .32, 1.275), box-shadow .35s ease, border-color .3s ease;
    opacity: 0;
    animation: fadeUp .5s ease forwards;
}

.pg-card::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(90deg, var(--acc), #a5b4fc);
    transform: scaleX(0);
    transform-origin: left;
    transition: transform .4s ease;
}

.pg-card:hover {
    transform: translateY(-6px);
    box-shadow: var(--sh2);
    border-color: var(--acc-mid);
}

.pg-card:hover::after {
    transform: scaleX(1);
}

.pg-card:hover .pg-arrow {
    background: var(--acc);
    border-color: var(--acc);
    color: #fff;
    transform: translate(2px, -2px);
}

/* Card parts */
.pg-card-top {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1.1rem;
}

.pg-num {
    font-size: .65rem;
    font-weight: 700;
    color: var(--acc-mid);
    letter-spacing: .16em;
}

.pg-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}

.ic-p {
    background: #eef2ff;
    color: #6366f1;
}

.ic-g {
    background: #ecfdf5;
    color: #059669;
}

.ic-a {
    background: #fffbeb;
    color: #d97706;
}

.ic-r {
    background: #fff1f2;
    color: #e11d48;
}

.pg-title {
    font-family: 'Syne', sans-serif;
    font-size: 1.05rem;
    font-weight: 700;
    color: var(--txt);
    line-height: 1.3;
    margin: 0 0 .35rem;
}

.pg-meta {
    font-size: .75rem;
    color: var(--meta);
    margin: 0 0 1.2rem;
}

.pg-hr {
    height: 1px;
    background: var(--border);
    margin: 0 0 1.2rem;
}

.pg-card-bot {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
}

.pg-pill {
    background: var(--acc-soft);
    color: var(--acc);
    font-size: .72rem;
    font-weight: 600;
    padding: 5px 13px;
    border-radius: 100px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
}

.pg-arrow {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    border: 1.5px solid var(--border);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--acc);
    font-size: 17px;
    transition: all .3s ease;
    flex-shrink: 0;
}

/* Empty */
.pg-empty {
    border: 1.5px solid var(--border);
    border-radius: var(--r);
    padding: 5rem 2rem;
    text-align: center;
    background: var(--card);
    box-shadow: var(--sh);
}

.pg-empty-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 1.25rem;
    border-radius: 18px;
    background: var(--acc-soft);
    border: 1.5px solid var(--acc-mid);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    color: var(--acc);
}

.pg-empty h3 {
    font-family: 'Syne', sans-serif;
    font-size: 1.1rem;
    font-weight: 700;
    color: var(--txt);
    margin: 0 0 .5rem;
}

.pg-empty p {
    font-size: .82rem;
    color: var(--muted);
    margin: 0;
}

@keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@media (max-width: 768px) {
    .pg-wrap {
        padding: 1.5rem 1rem 2.5rem;
    }

    .pg-header {
        flex-direction: column;
        gap: 1rem;
    }

    .pg-h1 {
        font-size: 1.9rem;
    }

    .pg-ctr {
        text-align: left;
    }

    .pg-grid {
        grid-template-columns: 1fr;
        gap: 14px;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$icons = [
    ['bi' => 'code-slash',    'cls' => 'ic-p'],
    ['bi' => 'palette2',      'cls' => 'ic-g'],
    ['bi' => 'cpu-fill',      'cls' => 'ic-a'],
    ['bi' => 'shield-lock',   'cls' => 'ic-p'],
    ['bi' => 'graph-up',      'cls' => 'ic-g'],
    ['bi' => 'phone',         'cls' => 'ic-a'],
    ['bi' => 'camera-video',  'cls' => 'ic-r'],
    ['bi' => 'brush',         'cls' => 'ic-p'],
];
$total = count($program_list);
?>

<div class="pg-wrap">

    <div class="pg-header">
        <div>
            <h1 class="pg-h1">Program<br><span class="acc">Belajar</span>mu</h1>
            <p class="pg-sub">Lanjutkan progres dan raih sertifikasimu.</p>
        </div>
        <?php if (!empty($program_list)): ?>
        <div class="pg-ctr">
            <div class="pg-ctr-num"><?= str_pad($total, 2, '0', STR_PAD_LEFT) ?></div>
            <div class="pg-ctr-lbl">Program aktif</div>
        </div>
        <?php endif ?>
    </div>

    <?php if (empty($program_list)): ?>

    <div class="pg-empty">
        <div class="pg-empty-icon">
            <i class="bi bi-mortarboard-fill"></i>
        </div>
        <h3>Belum Ada Program</h3>
        <p>Program belum tersedia. Nantikan informasi selanjutnya.</p>
    </div>

    <?php else: ?>

    <div class="pg-grid">
        <?php foreach ($program_list as $i => $p):
            $ic  = $icons[$i % count($icons)];
            $num = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        ?>
        <a href="<?= base_url('dashboard/peserta/program/' . $p['id_program']) ?>" class="pg-card"
            style="animation-delay:<?= $i * 0.07 ?>s">

            <div class="pg-card-top">
                <span class="pg-num"><?= $num ?></span>
                <div class="pg-icon <?= $ic['cls'] ?>">
                    <i class="bi bi-<?= $ic['bi'] ?>"></i>
                </div>
            </div>

            <h3 class="pg-title"><?= esc($p['nama_program']) ?></h3>
            <p class="pg-meta"><?= esc($p['deskripsi'] ?? 'Klik untuk mulai belajar') ?></p>

            <div class="pg-hr"></div>

            <div class="pg-card-bot">
                <span class="pg-pill">
                    <i class="bi bi-book-half"></i>
                    <?= esc($p['total_kelas']) ?> Modul
                </span>
                <div class="pg-arrow">
                    <i class="bi bi-arrow-up-right"></i>
                </div>
            </div>

        </a>
        <?php endforeach ?>
    </div>

    <?php endif ?>

</div>

<?= $this->endSection() ?>
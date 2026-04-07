<?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

<?= $this->section('content') ?>

<div style="max-width:800px;margin:auto;">

    <h2 style="font-weight:800;margin-bottom:20px;">
        Post Test: <?= esc($materi['judul_materi']) ?>
    </h2>

    <?php if (session()->getFlashdata('retry_posttest')): ?>
        <div style="margin-bottom:20px;padding:20px;background:#fee2e2;border:1px solid #fca5a5;border-radius:12px;">
            <p style="margin:0 0 12px;color:#b91c1c;font-weight:700;">Nilai kurang dari 70. Silakan ulang post test dengan menekan tombol di bawah.</p>
            <a href="<?= base_url('dashboard/peserta/posttest/' . $materi['id_materi']) ?>" style="
                display:inline-block;
                background:#ef4444;
                color:#fff;
                padding:12px 20px;
                border-radius:10px;
                text-decoration:none;
                font-weight:700;
            ">Mulai ulang Post Test</a>
        </div>
    <?php endif; ?>

    <form method="post" action="<?= base_url('dashboard/peserta/posttest/submit') ?>">
        <input type="hidden" name="id_materi" value="<?= $materi['id_materi'] ?>">

        <?php foreach ($soal as $i => $s): ?>
            <div style="margin-bottom:24px;padding:20px;background:#fff;border-radius:12px;border:1px solid #eee;">
                
                <div style="font-weight:700;margin-bottom:10px;">
                    <?= ($i+1) ?>. <?= esc($s['pertanyaan']) ?>
                </div>

                <?php foreach ($s['pilihan'] as $pi => $p): ?>
                    <label style="display:block;margin-bottom:6px;cursor:pointer;">
                        <input type="radio"
                               name="jawaban[<?= $i ?>]"
                               value="<?= $pi ?>"
                               required>
                        <?= esc($p) ?>
                    </label>
                <?php endforeach; ?>

            </div>
        <?php endforeach; ?>

        <button type="submit" style="
            background:#7c3aed;
            color:#fff;
            padding:12px 24px;
            border:none;
            border-radius:8px;
            font-weight:700;
            cursor:pointer;
        ">
            Kumpulkan Post Test
        </button>

    </form>

</div>

<?= $this->endSection() ?>
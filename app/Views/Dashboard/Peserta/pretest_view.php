    <?= $this->extend('Dashboard/Peserta/layout_peserta') ?>

    <?= $this->section('content') ?>

    <div style="max-width:800px;margin:auto;">

        <h2 style="font-weight:800;margin-bottom:20px;">
            Pre Test: <?= esc($materi['judul_materi']) ?>
        </h2>

        <form method="post" action="<?= base_url('dashboard/peserta/pretest/submit') ?>">
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
                background:#0ea5e9;
                color:#fff;
                padding:12px 24px;
                border:none;
                border-radius:8px;
                font-weight:700;
                cursor:pointer;
            ">
                Kumpulkan Pre Test
            </button>

        </form>

    </div>

    <?= $this->endSection() ?>
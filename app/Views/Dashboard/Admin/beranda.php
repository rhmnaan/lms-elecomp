<?php // app/Views/dashboard/admin.php ?>
<?= $this->extend('Dashboard/Admin/layout_admin') ?>

<?= $this->section('meta') ?>
<title>Dashboard Admin — LMS Elecomp</title>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- PAGE HEADER -->
<div class="page-header">
    <div>
        <h1>Ikhtisar Dasbor</h1>
        <p>Selamat datang kembali! Berikut ringkasan aktivitas LMS hari ini.</p>
    </div>
    <div class="date-badge">
        <i class="bi bi-calendar3"></i>
        <span id="today-date"></span>
    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const days   = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
    const months = ['Januari','Februari','Maret','April','Mei','Juni',
                    'Juli','Agustus','September','Oktober','November','Desember'];
</script>
<?= $this->endSection() ?>
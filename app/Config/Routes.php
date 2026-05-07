<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ─────────────────────────────────────────
// PUBLIC ROUTES
// ─────────────────────────────────────────
$routes->get('/', 'Auth::index');
$routes->get('login', 'Auth::index');
$routes->get('logout', 'Auth::logout');
$routes->post('auth/authenticate', 'Auth::authenticate');
$routes->post('auth/resend-verification', 'Auth::resendVerification');
$routes->get('register', 'Register::index');
$routes->post('register', 'Register::store');
$routes->get('register/verify', 'Register::verify');
$routes->get('register/verification-sent', 'Register::verificationSent');
$routes->get('testemail', 'TestEmail::index');
// Webhook / API ringan
$routes->get('cekaction/(:segment)', 'Webhook::cekAction/$1');
$routes->get('api/realtime/attendance-stream', 'RealtimeDatabaseMonitoring::attendanceStream');
// Routes.php
$routes->get('api/check-session', 'RealtimeDatabaseMonitoring::checkSession');
$routes->post('cekfingerprint', 'Webhook::cekFingerprint');

// ─────────────────────────────────────────
// PROTECTED ROUTES (LOGIN REQUIRED)
// ─────────────────────────────────────────
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // ── DASHBOARD UMUM ──
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('dashboard/siswa', 'Dashboard::siswa');

    // ═══════════════════════════════════════════════════════
    //  VIDEO ENKRIPSI — player & stream (semua user login)
    // ═══════════════════════════════════════════════════════
    $routes->get('video/player', 'VideoStream::player');
    $routes->get('api/videos/stream/(:segment)', 'VideoStream::stream/$1');
    $routes->get('api/videos/info/(:segment)', 'VideoStream::info/$1');
    $routes->get('api/videos/key', 'VideoStream::getKey');

    // ─────────────────────────────────────
    // DASHBOARD PESERTA
    // ─────────────────────────────────────
    $routes->group('dashboard/peserta', function ($routes) {
        $routes->get('beranda', 'DashboardPeserta::beranda');

        // PROGRAM PESERTA
        $routes->get('program', 'Peserta\Program::index');
        $routes->get('program/(:num)', 'Peserta\Program::kelas/$1');

        $routes->get('kelas', 'DashboardPeserta::kelasSaya');
        $routes->get('kelas/(:num)', 'DashboardPeserta::modul/$1');
        $routes->get('materi', 'DashboardPeserta::materi');
        $routes->get('quiz', 'DashboardPeserta::quiz');
        $routes->get('hasil-quiz', 'DashboardPeserta::hasilQuiz');
        $routes->get('modul', 'DashboardPeserta::modul');
        $routes->get('materi-list', 'DashboardPeserta::materi_list');
        $routes->get('materi/(:num)', 'DashboardPeserta::materi/$1');
        $routes->get('materi-modul/(:num)', 'DashboardPeserta::materi_modul/$1');
        $routes->get('quiz/kerjakan/(:num)', 'DashboardPeserta::kerjakanQuiz/$1');
        $routes->post('quiz/submit/(:num)', 'DashboardPeserta::submitQuiz/$1');
        $routes->post('quiz/simpan-materi', 'DashboardPeserta::simpanHasilQuizMateri');
        $routes->post('materi/selesai', 'DashboardPeserta::selesaiMateri');
        $routes->post('tugas/submit', 'DashboardPeserta::submitTugas');
        $routes->get('kelas/tugas/(:num)', 'DashboardPeserta::kelasTugas/$1');
        $routes->get('kelas-tugas', 'DashboardPeserta::kelasTugas');
        $routes->get('tugas-riwayat/(:num)', 'DashboardPeserta::tugasRiwayat/$1');

        // =====================
        // KELAS SAYA
        // =====================
        // =========================
        // TEMUKAN KELAS
        // =========================
        $routes->get('kelas/program', 'Peserta\KelasPeserta::program');
        $routes->get('kelas/program/(:num)', 'Peserta\KelasPeserta::kelasByProgram/$1');

        // tugas
        $routes->get('tugas/(:num)', 'Peserta\Tugas::index/$1');

        // =========================
        // DETAIL & VOUCHER
        // =========================
        $routes->get('kelas/detail/(:num)', 'Peserta\KelasPeserta::detail/$1');

        // =========================
        // VOUCHER CLAIM
        // =========================
        $routes->post('voucher/claim', 'VoucherController::claim');

        // =========================
        // KELAS SAYA
        // =========================
        $routes->get('kelas-saya', 'Peserta\KelasPeserta::kelasSaya');

        // Pre Test & Post Test
        $routes->get('pretest/(:num)', 'Peserta\Pretest::index/$1');
        $routes->post('pretest/submit', 'Peserta\Pretest::submit');

        $routes->get('posttest/(:num)', 'Peserta\Posttest::index/$1');
        $routes->post('posttest/submit', 'Peserta\Posttest::submit');

        // Profil Peserta
        $routes->get('profil', 'ProfilController::index');
        $routes->get('profil/edit', 'ProfilController::edit');
        $routes->post('profil/update', 'ProfilController::update');
    });

    // ─────────────────────────────────────
    // DASHBOARD ADMIN
    // ─────────────────────────────────────
    $routes->group('dashboard/admin', function ($routes) {
        $routes->get('beranda', 'DashboardAdmin::beranda');

        // Manajemen Pengguna
        $routes->get('pengguna', 'DashboardAdmin::users');
        $routes->post('pengguna/store', 'DashboardAdmin::usersStore');
        $routes->post('pengguna/update/(:num)', 'DashboardAdmin::usersUpdate/$1');
        $routes->post('pengguna/delete/(:num)', 'DashboardAdmin::usersDelete/$1');
        $routes->post('pengguna/reset-password/(:num)', 'DashboardAdmin::usersReset/$1');
    });

    // ─────────────────────────────────────
    // DASHBOARD PENGAJAR
    // ─────────────────────────────────────
    $routes->group('dashboard/pengajar', function ($routes) {

        $routes->get('/', 'DashboardPengajar::beranda');
        $routes->get('beranda', 'DashboardPengajar::beranda');
        $routes->get('peserta', 'DashboardPengajar::peserta');
        $routes->get('hasil-quiz', 'DashboardPengajar::hasilQuiz');

        // Kelas
        $routes->get('kelas', 'DashboardPengajar::kelas');
        $routes->post('kelas/store', 'DashboardPengajar::kelasStore');
        $routes->post('kelas/update/(:num)', 'DashboardPengajar::kelasUpdate/$1');
        $routes->post('kelas/delete/(:num)', 'DashboardPengajar::kelasDelete/$1');
        $routes->get('kelas/peserta/(:num)', 'DashboardPengajar::kelasPesertaList/$1');
        $routes->post('kelas/peserta/store', 'DashboardPengajar::kelasPesertaStore');
        $routes->post('kelas/peserta/kick/(:num)', 'DashboardPengajar::kelasPesertaKick/$1');
        $routes->get('kelas/gambar/(:segment)', 'FileController::kelasGambar/$1');

        // Modul
        $routes->get('modul', 'DashboardPengajar::modul');
        $routes->post('modul/store', 'DashboardPengajar::modulStore');
        $routes->post('modul/update/(:num)', 'DashboardPengajar::modulUpdate/$1');
        $routes->post('modul/delete/(:num)', 'DashboardPengajar::modulDelete/$1');

        // Tugas
        $routes->get('tugas', 'DashboardPengajar::tugas');
        $routes->post('tugas/store', 'DashboardPengajar::tugasStore');
        $routes->post('tugas/delete/(:num)', 'DashboardPengajar::tugasDelete/$1');
        $routes->get('tugas/pengumpulan/(:num)', 'DashboardPengajar::tugasPengumpulan/$1');
        $routes->post('tugas/komentar/simpan', 'DashboardPengajar::simpanKomentar');

        // Materi
        $routes->get('materi', 'DashboardPengajar::materi');
        $routes->post('materi/store', 'DashboardPengajar::materiStore');
        $routes->post('materi/update/(:num)', 'DashboardPengajar::materiUpdate/$1');
        $routes->post('materi/delete/(:num)', 'DashboardPengajar::materiDelete/$1');
        $routes->get('materi-list', 'DashboardPengajar::materiList');

        $routes->get('program', 'DashboardPengajar::program');
        $routes->post('program/store', 'DashboardPengajar::programStore');
        $routes->post('program/update/(:num)', 'DashboardPengajar::programUpdate/$1');
        $routes->post('program/delete/(:num)', 'DashboardPengajar::programDelete/$1');

        // ═══════════════════════════════════════════════════════════════════
        //VOUCHER
        // ═══════════════════════════════════════════════════════════════════
        $routes->get('voucher', 'DashboardPengajar::voucher');
        $routes->post('voucher/store', 'DashboardPengajar::voucherStore');
        $routes->post('voucher/update/(:num)', 'DashboardPengajar::voucherUpdate/$1');
        $routes->post('voucher/delete/(:num)', 'DashboardPengajar::voucherDelete/$1');
        $routes->post('voucher/toggle/(:num)', 'DashboardPengajar::voucherToggleActive/$1');
        $routes->post('voucher/klaim', 'DashboardPengajar::voucherKlaim');

        $routes->get('kelas-by-program/(:num)', 'DashboardPengajar::kelasByProgram/$1');

        // Profil
        $routes->get('profil', 'ProfilController::index');
        $routes->get('profil/edit', 'ProfilController::edit');
        $routes->post('profil/update', 'ProfilController::update');

        // ═══════════════════════════════════════════════
        //  VIDEO ENKRIPSI — manajemen video (pengajar)
        // ═══════════════════════════════════════════════
        $routes->get('video/upload', 'VideoStream::uploadPage');
        $routes->post('video/upload', 'VideoStream::doUpload');
        $routes->get('video/list', 'VideoStream::listVideos');
        $routes->post('video/delete/(:segment)', 'VideoStream::deleteVideo/$1');
    });
});
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

$routes->get('register', 'Register::index');
$routes->post('register', 'Register::store');

// Webhook / API ringan
$routes->get('cekaction/(:segment)', 'Webhook::cekAction/$1');
$routes->get('api/realtime/attendance-stream', 'RealtimeDatabaseMonitoring::attendanceStream');
$routes->post('cekfingerprint', 'Webhook::cekFingerprint');


// ─────────────────────────────────────────
// PROTECTED ROUTES (LOGIN REQUIRED)
// ─────────────────────────────────────────
$routes->group('', ['filter' => 'auth'], function ($routes) {

    // ── DASHBOARD UMUM ──
    $routes->get('dashboard', 'Dashboard::index');
    $routes->get('dashboard/siswa', 'Dashboard::siswa');


    // ─────────────────────────────────────
    // DASHBOARD PESERTA (FIXED ✅)
    // ─────────────────────────────────────
    $routes->group('dashboard/peserta', function ($routes) {
        $routes->get('beranda', 'DashboardPeserta::beranda');
        $routes->get('kelas', 'DashboardPeserta::kelas');
        $routes->get('materi', 'DashboardPeserta::materi');
        $routes->get('quiz', 'DashboardPeserta::quiz');
        $routes->get('hasil-quiz', 'DashboardPeserta::hasilQuiz');
        $routes->get('modul', 'DashboardPeserta::modul');
        $routes->get('materi-list', 'DashboardPeserta::materi_list');
        $routes->get('materi/(:num)', 'DashboardPeserta::materi/$1');
        $routes->get('materi-modul/(:num)', 'DashboardPeserta::materi_modul/$1'); // Route untuk detail materi
        $routes->get('quiz', 'DashboardPeserta::quiz');
        $routes->get('quiz/kerjakan/(:num)', 'DashboardPeserta::kerjakanQuiz/$1');
        $routes->post('quiz/submit/(:num)', 'DashboardPeserta::submitQuiz/$1');
        $routes->post('dashboard/peserta/quiz/simpan-materi', 'DashboardPeserta::simpanHasilQuizMateri');


        // ========== ROUTE PROFIL PESERTA (DIPERBAIKI) ==========
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

    // ─────────────────────────────────────────
    // DASHBOARD PENGAJAR
    // ─────────────────────────────────────────
    $routes->group('dashboard/pengajar', function ($routes) {

        $routes->get('/', 'DashboardPengajar::beranda'); // ← tambah ini
        $routes->get('beranda', 'DashboardPengajar::beranda');

        // Peserta
        $routes->get('peserta', 'DashboardPengajar::peserta');     // ← tambah ini

        // Hasil Quiz
        $routes->get('hasil-quiz', 'DashboardPengajar::hasilQuiz');   // ← tambah ini

        // Kelas
        $routes->get('kelas', 'DashboardPengajar::kelas');
        $routes->post('kelas/store', 'DashboardPengajar::kelasStore');
        $routes->post('kelas/update/(:num)', 'DashboardPengajar::kelasUpdate/$1');
        $routes->post('kelas/delete/(:num)', 'DashboardPengajar::kelasDelete/$1');
        // --- BARU: kelola peserta per kelas (AJAX) ---
        $routes->get('kelas/peserta/(:num)', 'DashboardPengajar::kelasPesertaList/$1');
        $routes->post('kelas/peserta/store', 'DashboardPengajar::kelasPesertaStore');
        $routes->post('kelas/peserta/kick/(:num)', 'DashboardPengajar::kelasPesertaKick/$1');

        // Modul
        $routes->get('modul', 'DashboardPengajar::modul');
        $routes->post('modul/store', 'DashboardPengajar::modulStore');
        $routes->post('modul/update/(:num)', 'DashboardPengajar::modulUpdate/$1');
        $routes->post('modul/delete/(:num)', 'DashboardPengajar::modulDelete/$1');

        // Materi
        $routes->get('materi', 'DashboardPengajar::materi');
        $routes->post('materi/store', 'DashboardPengajar::materiStore');
        $routes->post('materi/update/(:num)', 'DashboardPengajar::materiUpdate/$1');
        $routes->post('materi/delete/(:num)', 'DashboardPengajar::materiDelete/$1');
        $routes->get('materi-list', 'DashboardPengajar::materiList');

        // Quiz
        $routes->get('quiz', 'DashboardPengajar::quiz');
        $routes->post('quiz/store', 'DashboardPengajar::quizStore');
        $routes->post('quiz/update/(:num)', 'DashboardPengajar::quizUpdate/$1');
        $routes->post('quiz/delete/(:num)', 'DashboardPengajar::quizDelete/$1');
        $routes->get('quiz/hasil/(:num)', 'DashboardPengajar::quizHasil/$1');

        // Profil
        $routes->get('profil', 'ProfilController::index');
        $routes->get('profil/edit', 'ProfilController::edit');
        $routes->post('profil/update', 'ProfilController::update');
    });
});
<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    // ─────────────────────────────────────────────
    // INDEX — router berdasarkan role
    // ─────────────────────────────────────────────
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        return match(session()->get('role')) {
            'admin'    => redirect()->to('/dashboard/admin/beranda'),
            'pengajar' => redirect()->to('/dashboard/pengajar'),
            'peserta'    => redirect()->to('/dashboard/peserta/beranda'),
        };
    }

    // ─────────────────────────────────────────────
    // PENGAJAR — data terbatas kelas miliknya saja
    // ─────────────────────────────────────────────
    public function pengajar()
    {
        if (session()->get('role') !== 'pengajar') {
            return redirect()->to('/dashboard');
        }

        $db          = \Config\Database::connect();
        $id_pengajar = session()->get('id_users');

        // ── Stat cards ───────────────────────────
        $total_kelas_saya = $db->table('kelas')
                               ->where('id_users', $id_pengajar)
                               ->where('deleted_at IS NULL', null, false)
                               ->countAllResults();

        $total_materi_saya = $db->query("
            SELECT COUNT(*) AS total
            FROM materi ma
            JOIN modul  mo ON mo.id_modul = ma.id_modul
            JOIN kelas  k  ON k.id_kelas  = mo.id_kelas
            WHERE k.id_users    = {$id_pengajar}
              AND k.deleted_at  IS NULL
              AND ma.deleted_at IS NULL
        ")->getRow()->total;

        $total_quiz_saya = $db->query("
            SELECT COUNT(*) AS total
            FROM quiz  q
            JOIN modul m ON m.id_modul = q.id_modul
            JOIN kelas k ON k.id_kelas = m.id_kelas
            WHERE k.id_users   = {$id_pengajar}
              AND k.deleted_at IS NULL
              AND q.deleted_at IS NULL
        ")->getRow()->total;

        $total_peserta_aktif = $db->query("
            SELECT COUNT(DISTINCT qr.id_users) AS total
            FROM quiz_results qr
            JOIN quiz  q ON q.id_quiz  = qr.id_quiz
            JOIN modul m ON m.id_modul = q.id_modul
            JOIN kelas k ON k.id_kelas = m.id_kelas
            WHERE k.id_users    = {$id_pengajar}
              AND k.deleted_at  IS NULL
              AND qr.deleted_at IS NULL
        ")->getRow()->total;

        // ── Distribusi nilai (kelas milik pengajar ini) ──
        $dist_lulus = $db->query("
            SELECT COUNT(*) AS total
            FROM quiz_results qr
            JOIN quiz  q ON q.id_quiz  = qr.id_quiz
            JOIN modul m ON m.id_modul = q.id_modul
            JOIN kelas k ON k.id_kelas = m.id_kelas
            WHERE k.id_users            = {$id_pengajar}
              AND qr.nilai_quiz_results >= 70
              AND k.deleted_at          IS NULL
              AND qr.deleted_at         IS NULL
        ")->getRow()->total;

        $dist_cukup = $db->query("
            SELECT COUNT(*) AS total
            FROM quiz_results qr
            JOIN quiz  q ON q.id_quiz  = qr.id_quiz
            JOIN modul m ON m.id_modul = q.id_modul
            JOIN kelas k ON k.id_kelas = m.id_kelas
            WHERE k.id_users            = {$id_pengajar}
              AND qr.nilai_quiz_results >= 50
              AND qr.nilai_quiz_results  < 70
              AND k.deleted_at          IS NULL
              AND qr.deleted_at         IS NULL
        ")->getRow()->total;

        $dist_kurang = $db->query("
            SELECT COUNT(*) AS total
            FROM quiz_results qr
            JOIN quiz  q ON q.id_quiz  = qr.id_quiz
            JOIN modul m ON m.id_modul = q.id_modul
            JOIN kelas k ON k.id_kelas = m.id_kelas
            WHERE k.id_users           = {$id_pengajar}
              AND qr.nilai_quiz_results < 50
              AND k.deleted_at         IS NULL
              AND qr.deleted_at        IS NULL
        ")->getRow()->total;

        // ── Leaderboard peserta di kelas saya (top 5) ──
        $leaderboard = $db->query("
            SELECT
                u.nama_users,
                k.nama_kelas,
                ROUND(AVG(qr.nilai_quiz_results), 1) AS rata_nilai,
                COUNT(qr.id_quiz_results)             AS total_quiz_dikerjakan
            FROM quiz_results qr
            JOIN users u ON u.id_users = qr.id_users
            JOIN quiz  q ON q.id_quiz  = qr.id_quiz
            JOIN modul m ON m.id_modul = q.id_modul
            JOIN kelas k ON k.id_kelas = m.id_kelas
            WHERE k.id_users    = {$id_pengajar}
              AND u.role_users  = 'peserta'
              AND k.deleted_at  IS NULL
              AND qr.deleted_at IS NULL
            GROUP BY u.id_users, u.nama_users, k.id_kelas, k.nama_kelas
            ORDER BY rata_nilai DESC
            LIMIT 5
        ")->getResultArray();

        // ── Aktivitas quiz terbaru di kelas saya ──
        $aktivitas_terbaru = $db->query("
            SELECT
                u.nama_users,
                q.judul_quiz,
                k.nama_kelas,
                qr.nilai_quiz_results,
                qr.waktu_selesai_quiz_results
            FROM quiz_results qr
            JOIN users u ON u.id_users = qr.id_users
            JOIN quiz  q ON q.id_quiz  = qr.id_quiz
            JOIN modul m ON m.id_modul = q.id_modul
            JOIN kelas k ON k.id_kelas = m.id_kelas
            WHERE k.id_users    = {$id_pengajar}
              AND k.deleted_at  IS NULL
              AND qr.deleted_at IS NULL
            ORDER BY qr.waktu_selesai_quiz_results DESC
            LIMIT 6
        ")->getResultArray();

        // ── Daftar kelas milik pengajar ini ──────
        $daftar_kelas = $db->query("
            SELECT
                k.id_kelas,
                k.nama_kelas,
                COUNT(DISTINCT ma.id_materi) AS total_materi,
                COUNT(DISTINCT q.id_quiz)    AS total_quiz,
                COUNT(DISTINCT qr.id_users)  AS total_peserta_aktif
            FROM kelas k
            LEFT JOIN modul        mo ON mo.id_kelas  = k.id_kelas
            LEFT JOIN materi       ma ON ma.id_modul  = mo.id_modul AND ma.deleted_at IS NULL
            LEFT JOIN quiz         q  ON q.id_modul   = mo.id_modul AND q.deleted_at  IS NULL
            LEFT JOIN quiz_results qr ON qr.id_quiz   = q.id_quiz   AND qr.deleted_at IS NULL
            WHERE k.id_users   = {$id_pengajar}
              AND k.deleted_at IS NULL
            GROUP BY k.id_kelas, k.nama_kelas
            ORDER BY k.nama_kelas ASC
        ")->getResultArray();

        return view('dashboard/pengajar', [
            'total_kelas_saya'    => $total_kelas_saya,
            'total_materi_saya'   => $total_materi_saya,
            'total_quiz_saya'     => $total_quiz_saya,
            'total_peserta_aktif' => $total_peserta_aktif,
            'dist_lulus'          => $dist_lulus,
            'dist_cukup'          => $dist_cukup,
            'dist_kurang'         => $dist_kurang,
            'leaderboard'         => $leaderboard,
            'aktivitas_terbaru'   => $aktivitas_terbaru,
            'daftar_kelas'        => $daftar_kelas,
        ]);
    }

    // ─────────────────────────────────────────────
    // PESERTA
    // ─────────────────────────────────────────────
    public function peserta()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }
        if (session()->get('role') !== 'peserta') {
            return redirect()->to('/dashboard');
        }
        return view('dashboard/peserta');
    }
}
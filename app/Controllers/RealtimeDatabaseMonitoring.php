<?php

namespace App\Controllers;

use App\Models\Users;

class RealtimeDatabaseMonitoring extends BaseController
{
    /**
     * GET /api/realtime/attendance-stream
     *
     * SSE endpoint — kirim event 'updated_attendances' jika:
     *   fingerprint_device di DB BERBEDA dari cookie device_fp tab ini.
     *
     * Artinya: perangkat lain baru login dan mengambil alih sesi,
     * sehingga tab ini harus logout otomatis.
     */
    public function attendanceStream()
    {
        // ── Ambil data identitas SEKALI di awal, sebelum session di-close ──
        // Penting: session CI4 menggunakan file lock. Jika session dibiarkan
        // terbuka di dalam loop, request lain dari user yang sama akan terblock.
        $fp    = $_COOKIE['device_fp'] ?? '';
        $email = session()->get('email') ?? '';

        // Tutup session segera agar request lain tidak terblock
        session()->close();

        // Jika tidak ada fp atau email (belum login / cookie belum ada),
        // jangan langsung close — tunggu dulu agar tidak infinite reconnect loop
        if (!$fp || !$email) {
            $this->startSSEHeaders();
            echo ": waiting\n\n";
            flush();
            sleep(5);
            echo "event: close\ndata: {}\n\n";
            flush();
            return;
        }

        // Izinkan PHP tetap jalan walau client disconnect (kita handle manual)
        ignore_user_abort(true);

        // Nonaktifkan batas waktu eksekusi PHP (default 30 detik akan membunuh loop 25 detik)
        set_time_limit(0);

        $this->startSSEHeaders();

        $startTime    = time();
        $maxDuration  = 1;
        $pollInterval = 2;

        // hapus baris ini → $firstPoll = true;

        while ((time() - $startTime) < $maxDuration) {
            if (connection_aborted()) return;

            if ($this->isSessionHijacked($fp, $email)) {
                return;
            }

            echo ": heartbeat\n\n";
            if (ob_get_level()) ob_flush();
            flush();

            sleep($pollInterval);
        }

        // Durasi maksimum tercapai → minta client reconnect
        echo "event: close\ndata: {}\n\n";
        if (ob_get_level()) ob_flush();
        flush();
    }

    // ──────────────────────────────────────────────────────────────────
    // Private helpers
    // ──────────────────────────────────────────────────────────────────

    private function startSSEHeaders(): void
    {
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache');
        header('X-Accel-Buffering: no');  // matikan buffer Nginx
        header('Connection: keep-alive');
    }

    /**
     * Cek apakah fingerprint di DB sudah BERBEDA dari cookie tab ini.
     *
     * Skenario:
     *   Tab A buka dashboard (cookie = FP_A)
     *   → Perangkat B login → Webhook update DB ke FP_B
     *   → Loop SSE tab A: DB=FP_B ≠ cookie FP_A → kirim event → tab A logout
     *
     * Setelah event dikirim, kolom `action` di-reset ke NULL agar
     * jika SSE reconnect sebelum redirect terjadi, event tidak terkirim dua kali.
     *
     * @return bool  true = event sudah dikirim, loop boleh dihentikan
     */
    private function isSessionHijacked(string $fp, string $email): bool
    {
        $usersModel = new Users();

        $user = $usersModel
            ->where('email_users', $email)
            ->select('email_users, fingerprint_device, action')
            ->first();

        if (!$user) return false;

        $dbFP = $user['fingerprint_device'];

        // Fingerprint DB berbeda dari cookie → sesi diambil alih
        if ($dbFP !== null && $dbFP !== '' && $dbFP !== $fp) {
            $payload = json_encode([
                'email_users'        => $user['email_users'],
                'fingerprint_device' => $dbFP,
                'action'             => $user['action'],
            ]);

            echo "event: updated_attendances\ndata: {$payload}\n\n";
            if (ob_get_level()) ob_flush();
            flush();

            // Tidak perlu reset action di sini.
            // Setelah event dikirim, triggerAutoLogout() di client akan
            // redirect ke /logout dalam 3 detik — tab tidak akan reconnect SSE.
            // Jika user membuka banyak tab, setiap tab punya SSE sendiri
            // dan akan masing-masing menerima event ini pada polling berikutnya
            // selama fingerprint di DB masih berbeda dari cookie mereka.
            return true;
        }

        return false;
    }
}
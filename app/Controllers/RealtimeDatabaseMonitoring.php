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
     */
    public function attendanceStream()
    {

        while (ob_get_level()) ob_end_clean();
        $fp    = $_COOKIE['device_fp'] ?? '';
        $email = session()->get('email_users') ?? '';

        session()->close();

        if (!$fp || !$email) {
            $this->startSSEHeaders();
            echo ": waiting\n\n";
            flush();
            sleep(5);
            echo "event: close\ndata: {}\n\n";
            flush();
            return;
        }

        ignore_user_abort(true);
        set_time_limit(0);

        $this->startSSEHeaders();

        $startTime    = time();
        $maxDuration  = 5; // 
        $pollInterval = 2;  // 

        while ((time() - $startTime) < $maxDuration) {
            if (connection_aborted()) return;

            // ✅ Cek apakah ada perubahan fingerprint (berarti ada device baru login)
            if ($this->isSessionHijacked($fp, $email)) {
                // Event sudah dikirim, tutup stream
                return;
            }

            echo ": heartbeat\n\n";
            if (ob_get_level()) ob_flush();
            flush();

            sleep($pollInterval);
        }

        echo "event: close\ndata: {}\n\n";
        if (ob_get_level()) ob_flush();
        flush();
    }

    // ──────────────────────────────────────────────────────────────────
    // Private helpers
    // ──────────────────────────────────────────────────────────────────

    private function startSSEHeaders(): void
    {
        // Buang semua header sebelumnya
        if (function_exists('header_remove')) {
            header_remove();
        }

        http_response_code(200);
        header('Content-Type: text/event-stream');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('X-Accel-Buffering: no');
        header('X-Content-Type-Options: nosniff');
        header('Connection: keep-alive');
        header('Pragma: no-cache');
    }

    /**
     * Cek apakah fingerprint di DB sudah BERBEDA dari cookie tab ini.
     * 
     * LOGIKA: Jika fingerprint DB ≠ fingerprint tab ini, 
     * artinya ada login baru dari device lain → tab ini harus logout
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

        $dbFP   = $user['fingerprint_device'];
        $action = $user['action'];

        // ✅ PERBAIKAN: Trigger logout HANYA berdasarkan perbedaan fingerprint
        // Tidak peduli apa nilai 'action' nya
        if (
            $dbFP !== null &&
            $dbFP !== '' &&
            $dbFP !== $fp  // ← fingerprint berbeda = ada device baru login
        ) {
            $payload = json_encode([
                'email_users'        => $user['email_users'],
                'fingerprint_device' => $dbFP,
                'action'             => $action ?? 'switched',
            ]);

            echo "event: updated_attendances\ndata: {$payload}\n\n";
            if (ob_get_level()) ob_flush();
            flush();

            return true;
        }

        return false;
    }

    // RealtimeDatabaseMonitoring.php
    public function checkSession()
    {
        $fp    = $_COOKIE['device_fp'] ?? '';
        $email = session()->get('email') ?? '';

        if (!$fp || !$email) {
            return $this->response->setJSON(['hijacked' => false]);
        }

        // Tutup session segera
        session()->close();

        $user = (new Users())
            ->where('email_users', $email)
            ->select('fingerprint_device')
            ->first();

        if (!$user) {
            return $this->response->setJSON(['hijacked' => false]);
        }

        $hijacked = !empty($user['fingerprint_device'])
            && $user['fingerprint_device'] !== $fp;

        return $this->response->setJSON(['hijacked' => $hijacked]);
    }
}

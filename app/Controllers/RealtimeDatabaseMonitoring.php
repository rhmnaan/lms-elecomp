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
        $fp    = $_COOKIE['device_fp'] ?? '';
        $email = session()->get('email') ?? '';

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
        $maxDuration  = 5; // ✅ diperpanjang dari 5 → 25 detik
        $pollInterval = 1;

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
        header('X-Accel-Buffering: no');
        header('Connection: keep-alive');
    }

    /**
     * Cek apakah fingerprint di DB sudah BERBEDA dari cookie tab ini.
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

        if ($dbFP !== null && $dbFP !== '' && $dbFP !== $fp) {
            $payload = json_encode([
                'email_users'        => $user['email_users'],
                'fingerprint_device' => $dbFP,
                'action'             => $user['action'],
            ]);

            echo "event: updated_attendances\ndata: {$payload}\n\n";
            if (ob_get_level()) ob_flush();
            flush();

            return true;
        }

        return false;
    }
}
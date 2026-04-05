<?php

namespace App\Controllers;

use App\Models\Users;

class Webhook extends BaseController
{
    /**
     * POST /cekfingerprint
     *
     * Flow:
     *  1. Validasi email + password
     *  2. Bandingkan fingerprint dari request dengan yang ada di DB
     *  3. Kembalikan status: 'sama' | 'baru' | 'updated' | 'switched' | 'beda' | 'invalid'
     *
     * PERBAIKAN:
     *  - Selalu simpan kolom `action` saat update fingerprint
     *    agar SSE di tab lain tahu harus logout
     *  - Jika fingerprint null di DB, simpan juga action='baru'
     */
    public function cekFingerprint()
    {
        $data = $this->request->getJSON(true);

        $email  = $data['email']  ?? null;
        $pass   = $data['pass']   ?? null;
        $action = $data['action'] ?? null;
        $fp     = $data['fp']     ?? ($_COOKIE['device_fp'] ?? null);

        if (!$email || !$pass || !$fp) {
            return $this->response->setJSON([
                'status'  => 'invalid',
                'message' => 'Data tidak lengkap.',
            ]);
        }

        $model = new Users();

        $user = $model
            ->where('email_users', $email)
            ->select('fingerprint_device, password_users')
            ->first();

        // Validasi kredensial
        if (!$user || !password_verify($pass, $user['password_users'])) {
            return $this->response->setJSON([
                'status'  => 'invalid',
                'message' => 'Email atau password salah.',
            ]);
        }

        $dbFP = $user['fingerprint_device'];

        // ── KASUS 1: Fingerprint sama → langsung izinkan ──
        if ($fp === $dbFP && $dbFP !== null) {
            return $this->response->setJSON([
                'status' => 'sama',
                'valid'  => true,
                'login'  => base_url('auth/authenticate'),
            ]);
        }

        // ── KASUS 2: Fingerprint belum ada di DB → simpan, izinkan ──
        if ($dbFP === null || $dbFP === '') {
            $model->where('email_users', $email)
                  ->set([
                      'fingerprint_device' => $fp,
                      'action'             => 'baru',
                  ])
                  ->update();

            return $this->response->setJSON([
                'status' => 'baru',
                'valid'  => true,
                'login'  => base_url('auth/authenticate'),
            ]);
        }

        // ── KASUS 3: Fingerprint BEDA, user pilih 'keep' (tetap di sini) ──
        // → Update fingerprint ke FP baru, tab lama akan ter-logout via SSE
        if ($action === 'keep') {
            $model->where('email_users', $email)
                  ->set([
                      'fingerprint_device' => $fp,
                      'action'             => 'keep',    // ← SSE tab lama baca ini
                  ])
                  ->update();

            return $this->response->setJSON([
                'status' => 'updated',
                'valid'  => true,
                'login'  => base_url('auth/authenticate'),
            ]);
        }

        // ── KASUS 4: Fingerprint BEDA, user pilih 'other' (logout perangkat lain) ──
        // → Update fingerprint, sesi di perangkat lama logout otomatis via SSE
        if ($action === 'other') {
            $model->where('email_users', $email)
                  ->set([
                      'fingerprint_device' => $fp,
                      'action'             => 'other',   // ← SSE tab lama baca ini
                  ])
                  ->update();

            return $this->response->setJSON([
                'status' => 'switched',
                'valid'  => true,
                'login'  => base_url('auth/authenticate'),
            ]);
        }

        // ── KASUS 5: Fingerprint BEDA, belum ada aksi → minta konfirmasi frontend ──
        return $this->response->setJSON([
            'status' => 'beda',
            'valid'  => false,
        ]);
    }

    /**
     * GET /cekaction/:email
     * Dipakai untuk verifikasi ringan apakah fingerprint masih sinkron.
     */
    public function cekAction($email)
    {
        $fp = $_COOKIE['device_fp'] ?? null;

        if (!$fp || !$email) {
            return $this->response->setJSON(['valid' => false]);
        }

        $model = new Users();
        $user  = $model
            ->where('email_users', $email)
            ->select('fingerprint_device')
            ->first();

        if ($user && $fp === $user['fingerprint_device']) {
            return $this->response->setJSON(['valid' => true]);
        }

        return $this->response->setJSON(['valid' => false]);
    }
}
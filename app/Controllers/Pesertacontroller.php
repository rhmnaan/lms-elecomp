<?php

namespace App\Controllers\Dashboard;

use App\Models\Users;
use CodeIgniter\I18n\Time;
use CodeIgniter\Controller;

class PesertaController extends Controller
{
    /**
     * GET /dashboard/pengajar/peserta
     * Tampilkan halaman daftar peserta beserta statistik verifikasi.
     */
    public function index()
    {
        $usersModel = new Users();

        // Ambil semua user dengan role peserta
        $peserta = $usersModel
            ->where('role_users', 'peserta')
            ->orderBy('created_at', 'DESC')
            ->findAll();

        $totalPeserta    = count($peserta);
        $totalVerified   = count(array_filter($peserta, fn($p) => !empty($p['email_verified']) && $p['email_verified'] == 1));
        $totalUnverified = $totalPeserta - $totalVerified;

        return view('Dashboard/Pengajar/peserta', [
            'peserta'         => $peserta,
            'totalPeserta'    => $totalPeserta,
            'totalVerified'   => $totalVerified,
            'totalUnverified' => $totalUnverified,
        ]);
    }

    /**
     * POST /dashboard/pengajar/peserta/resend-verifikasi
     * Kirim ulang email verifikasi ke peserta yang belum verifikasi.
     * Dipanggil via AJAX dari view pengajar (fetch + JSON body).
     */
    public function resendVerifikasi()
    {
        // Pastikan request dari AJAX
        if (! $this->request->isAJAX()) {
            return $this->response->setStatusCode(403)->setJSON([
                'success' => false,
                'message' => 'Akses tidak diizinkan.',
            ]);
        }

        // Ambil id_users dari JSON body
        $body   = $this->request->getJSON(true);
        $userId = $body['id_users'] ?? null;

        if (! $userId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID peserta tidak ditemukan.',
            ]);
        }

        $usersModel = new Users();
        $user       = $usersModel->find($userId);

        if (! $user) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Peserta tidak ditemukan.',
            ]);
        }

        // Pastikan role benar
        if ($user['role_users'] !== 'peserta') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User bukan peserta.',
            ]);
        }

        // Jangan kirim ulang jika sudah terverifikasi
        if (! empty($user['email_verified']) && $user['email_verified'] == 1) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Email peserta ini sudah terverifikasi.',
            ]);
        }

        // Generate token baru + expiry 24 jam
        $token   = bin2hex(random_bytes(32));
        $expires = Time::now()->addHours(24);

        $usersModel->update($userId, [
            'verification_token' => $token,
            'token_expires_at'   => $expires,
        ]);

        // Kirim email verifikasi
        $verificationLink = base_url("register/verify?token={$token}");
        $emailService     = \Config\Services::email();

        $emailService->setTo($user['email_users']);
        $emailService->setSubject('Verifikasi Email Akun LMS Elecomp');
        $emailService->setMessage(view('emails/verification', [
            'nama' => $user['nama_users'],
            'link' => $verificationLink,
        ]));

        if ($emailService->send()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Email verifikasi berhasil dikirim ulang.',
            ]);
        }

        // Jika gagal kirim email, log error-nya
        log_message('error', '[ResendVerifikasi] Gagal kirim email ke ' . $user['email_users'] . ': ' . $emailService->printDebugger(['headers']));

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Gagal mengirim email. Coba beberapa saat lagi.',
        ]);
    }
}
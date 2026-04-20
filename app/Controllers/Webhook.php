<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\Users;
use App\Models\KelasModel;
use App\Models\KelasPesertaModel;
use CodeIgniter\HTTP\ResponseInterface;

class Webhook extends BaseController
{
    protected TransaksiModel $transaksiModel;
    protected Users $usersModel;
    protected KelasModel $kelasModel;
    protected KelasPesertaModel $kelasPesertaModel;

    public function __construct()
    {
        $this->transaksiModel    = new TransaksiModel();
        $this->usersModel        = new Users();
        $this->kelasModel        = new KelasModel();
        $this->kelasPesertaModel = new KelasPesertaModel();
    }

    // ===============================
    // HELPER: Safe Array Getter
    // ===============================
    private function getArray($array, $keys, $default = null)
    {
        foreach ($keys as $key) {
            if (!isset($array[$key])) {
                return $default;
            }
            $array = $array[$key];
        }
        return $array;
    }

    // ===============================
    // FINGERPRINT CHECK
    // ===============================
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
            ->groupStart()
            ->where('LOWER(email_users)', strtolower($email))
            ->orWhere('LOWER(nama_users)', strtolower($email))
            ->groupEnd()
            ->select('email_users, fingerprint_device, password_users')
            ->first();

        if (!$user || !password_verify($pass, $user['password_users'])) {
            return $this->response->setJSON([
                'status'  => 'invalid',
                'message' => 'Username/Email atau password salah.',
            ]);
        }

        $emailDB = $user['email_users'];
        $dbFP    = $user['fingerprint_device'];

        if ($fp === $dbFP && $dbFP !== null) {
            return $this->response->setJSON([
                'status' => 'sama',
                'valid'  => true,
                'login'  => base_url('auth/authenticate'),
            ]);
        }

        if ($dbFP === null || $dbFP === '') {
            $model->where('email_users', $emailDB)
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

        if ($action === 'keep') {
            $model->where('email_users', $emailDB)
                ->set([
                    'fingerprint_device' => $fp,
                    'action'             => 'keep',
                ])
                ->update();

            return $this->response->setJSON([
                'status' => 'updated',
                'valid'  => true,
                'login'  => base_url('auth/authenticate'),
            ]);
        }

        if ($action === 'other') {
            $model->where('email_users', $emailDB)
                ->set([
                    'fingerprint_device' => $fp,
                    'action'             => 'other',
                ])
                ->update();

            return $this->response->setJSON([
                'status' => 'switched',
                'valid'  => true,
                'login'  => base_url('auth/authenticate'),
            ]);
        }

        return $this->response->setJSON([
            'status' => 'beda',
            'valid'  => false,
        ]);
    }

    // ===============================
    // GET /cekaction/:email
    // ===============================
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

    // ===============================
    // GET /transaksi
    // ===============================
    public function index()
    {
        $transaksi = $this->transaksiModel
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('transaksi/index', [
            'transaksi' => $transaksi,
        ]);
    }

    // ===============================
    // GET /transaksi/detail/{id}
    // ===============================
    public function detail($id)
    {
        $transaksi = $this->transaksiModel->find($id);

        if (!$transaksi) {
            return redirect()->to('/transaksi')->with('error', 'Transaksi tidak ditemukan.');
        }

        $user  = $this->usersModel->find($transaksi['id_users']);
        $kelas = null;

        if (!empty($transaksi['id_kelas'])) {
            $kelas = $this->kelasModel->find($transaksi['id_kelas']);
        }

        return view('transaksi/detail', [
            'transaksi' => $transaksi,
            'user'      => $user,
            'kelas'     => $kelas,
        ]);
    }

    // ===============================
    // GET /transaksi/milik/{id_users}
    // ===============================
    public function milik($id_users)
    {
        $user = $this->usersModel->find($id_users);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan.');
        }

        $transaksi = $this->transaksiModel
            ->where('id_users', $id_users)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('transaksi/milik', [
            'user'      => $user,
            'transaksi' => $transaksi,
        ]);
    }

    // ===============================
    // WEBHOOK LYNK — BELI KELAS
    // ===============================
    public function webhookLynk()
    {
        $logFile = WRITEPATH . 'logs/webhook_lynk.log';
        $logTime = date('Y-m-d H:i:s');

        file_put_contents($logFile, "\n\n=== WEBHOOK CALLED: {$logTime} ===\n", FILE_APPEND);

        try {
            $payload = $this->request->getBody();

            file_put_contents($logFile, "Raw Payload: {$payload}\n", FILE_APPEND);

            $data = json_decode($payload, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                $error = json_last_error_msg();
                file_put_contents($logFile, "JSON Error: {$error}\n", FILE_APPEND);
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON(['status' => 'error', 'message' => 'Invalid JSON: ' . $error]);
            }

            if (empty($data)) {
                file_put_contents($logFile, "ERROR: Payload kosong\n", FILE_APPEND);
                return $this->response
                    ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                    ->setJSON(['status' => 'error', 'message' => 'Payload kosong']);
            }

            // ── Validasi Signature ──
            $signature = $this->request->getHeaderLine('X-Signature');
            $secret    = env('LYNK_WEBHOOK_SECRET');

            if ($secret && $signature) {
                $hash = hash_hmac('sha256', $payload, $secret);
                if (!hash_equals($hash, $signature)) {
                    file_put_contents($logFile, "ERROR: Invalid signature\n", FILE_APPEND);
                    return $this->response
                        ->setStatusCode(403)
                        ->setJSON(['status' => 'invalid signature']);
                }
            }

            // ── Filter Event ──
            $event  = $this->getArray($data, ['event']);
            $status = $this->getArray($data, ['data', 'message_action']);

            file_put_contents($logFile, "Event: {$event}, Status: {$status}\n", FILE_APPEND);

            if ($event !== 'payment.received' || $status !== 'SUCCESS') {
                return $this->response->setJSON(['status' => 'ignored']);
            }

            // ── Ambil Data dari Payload ──
            $lynk_transaction_id = $this->getArray($data, ['data', 'message_data', 'refId']);
            $email               = $this->getArray($data, ['data', 'message_data', 'customer', 'email']);
            $time                = $this->getArray($data, ['data', 'message_data', 'createdAt'], date('Y-m-d H:i:s'));

            $item  = $this->getArray($data, ['data', 'message_data', 'items', 0], []);
            $harga = $item['price'] ?? 0;
            $qty   = $item['qty']   ?? 1;

            // ── Cari Kelas Berdasarkan Nama Produk Lynk ──
            $namaKelas = $item['title'] ?? null;
            $kelas     = null;
            $id_kelas  = null;

            if ($namaKelas) {
                $kelas = $this->kelasModel
                    ->where('nama_kelas', $namaKelas)
                    ->where('deleted_at', null)
                    ->first();

                if ($kelas) {
                    $id_kelas = $kelas['id_kelas'];
                    file_put_contents($logFile, "Kelas ditemukan: {$namaKelas} (ID: {$id_kelas})\n", FILE_APPEND);
                } else {
                    file_put_contents($logFile, "WARNING: Kelas tidak ditemukan dengan nama: {$namaKelas}\n", FILE_APPEND);
                }
            }

            // Gunakan totalPrice (harga asli sebelum diskon)
            $totals = $this->getArray($data, ['data', 'message_data', 'totals'], []);
            $total  = $totals['totalPrice'] ?? ($harga * $qty);

            file_put_contents($logFile, "Transaction ID: {$lynk_transaction_id}\n", FILE_APPEND);
            file_put_contents($logFile, "Email: {$email}\n", FILE_APPEND);
            file_put_contents($logFile, "Total: {$total}\n", FILE_APPEND);

            // ── Validasi User ──
            $user = $this->usersModel
                ->where('email_users', $email)
                ->first();

            if (!$user) {
                file_put_contents($logFile, "ERROR: User tidak ditemukan - {$email}\n", FILE_APPEND);
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'user_not_found',
                    'email'   => $email,
                ]);
            }

            file_put_contents($logFile, "User ditemukan - ID: {$user['id_users']}\n", FILE_APPEND);

            // ── Cek Duplikat Transaksi ──
            $exists = $this->transaksiModel
                ->where('lynk_transaction_id', $lynk_transaction_id)
                ->first();

            if ($exists) {
                file_put_contents($logFile, "DUPLICATE: Transaksi sudah ada\n", FILE_APPEND);
                return $this->response->setJSON([
                    'status'  => 'duplicate',
                    'message' => 'Transaction already processed',
                ]);
            }

            // ── Insert Transaksi ──
            $dataTransaksi = [
                'id_users'            => $user['id_users'],
                'id_kelas'            => $id_kelas,
                'kode_transaksi'      => 'TRX-' . strtoupper(uniqid(mt_rand(100, 999), true)),
                'lynk_transaction_id' => $lynk_transaction_id,
                'nama_produk'         => $namaKelas ?? 'Produk',
                'harga'               => $harga,
                'qty'                 => $qty,
                'total'               => $total,
                'status'              => 'success',
                'metode_pembayaran'   => 'lynk',
                'tanggal_transaksi'   => $time,
                'tanggal_bayar'       => date('Y-m-d H:i:s'),
            ];

            file_put_contents($logFile, "Inserting: " . json_encode($dataTransaksi) . "\n", FILE_APPEND);

            $insert = $this->transaksiModel->insert($dataTransaksi);

            if (!$insert) {
                $error = $this->transaksiModel->errors();
                file_put_contents($logFile, "ERROR: Insert gagal - " . json_encode($error) . "\n", FILE_APPEND);
                return $this->response
                    ->setStatusCode(500)
                    ->setJSON(['status' => 'error', 'message' => 'Database insert failed', 'errors' => $error]);
            }

            $insertId = $this->transaksiModel->getInsertID();
            file_put_contents($logFile, "SUCCESS: Transaksi ID {$insertId}\n", FILE_APPEND);

            // ── Auto-Enroll ke Kelas Peserta ──
            if ($kelas) {
                try {
                    $enrolled = $this->kelasPesertaModel->enroll(
                        $id_kelas,
                        $user['id_users']
                    );

                    if ($enrolled) {
                        file_put_contents($logFile, "User enrolled ke kelas {$id_kelas}\n", FILE_APPEND);
                    } else {
                        file_put_contents($logFile, "User sudah terdaftar di kelas {$id_kelas}\n", FILE_APPEND);
                    }
                } catch (\Exception $e) {
                    file_put_contents($logFile, "ERROR enroll: " . $e->getMessage() . "\n", FILE_APPEND);
                }
            }

            file_put_contents($logFile, "=== SELESAI ===\n", FILE_APPEND);

            return $this->response->setJSON([
                'status'         => 'success',
                'transaction_id' => $insertId,
                'message'        => 'Payment processed successfully',
            ]);

        } catch (\Exception $e) {
            file_put_contents($logFile, "EXCEPTION: " . $e->getMessage() . "\n", FILE_APPEND);
            file_put_contents($logFile, "Stack: " . $e->getTraceAsString() . "\n", FILE_APPEND);

            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status'  => 'error',
                    'message' => 'Internal server error',
                    'error'   => $e->getMessage(),
                ]);
        }
    }

    // ===============================
    // UPDATE STATUS TRANSAKSI
    // ===============================
    public function updateStatus($id)
    {
        $transaksi = $this->transaksiModel->find($id);

        if (!$transaksi) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON(['status' => 'error', 'message' => 'Transaksi tidak ditemukan']);
        }

        $newStatus = $this->request->getPost('status');
        $allowed   = ['pending', 'success', 'failed'];

        if (!in_array($newStatus, $allowed)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON(['status' => 'error', 'message' => 'Status tidak valid']);
        }

        $this->transaksiModel->update($id, [
            'status'        => $newStatus,
            'tanggal_bayar' => $newStatus === 'success' ? date('Y-m-d H:i:s') : $transaksi['tanggal_bayar'],
        ]);

        if ($newStatus === 'success' && !empty($transaksi['id_kelas'])) {
            $this->kelasPesertaModel->enroll(
                $transaksi['id_kelas'],
                $transaksi['id_users']
            );
        }

        return $this->response->setJSON(['status' => 'success']);
    }

    // ===============================
    // FILTER TRANSAKSI
    // ===============================
    public function filter()
    {
        $status   = $this->request->getGet('status');
        $id_users = $this->request->getGet('id_users');
        $id_kelas = $this->request->getGet('id_kelas');

        $builder = $this->transaksiModel->orderBy('created_at', 'DESC');

        if ($status) {
            $builder->where('status', $status);
        }

        if ($id_users) {
            $builder->where('id_users', $id_users);
        }

        if ($id_kelas) {
            $builder->where('id_kelas', $id_kelas);
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $builder->findAll(),
        ]);
    }

    // ===============================
    // HAPUS TRANSAKSI
    // ===============================
    public function hapus($id)
    {
        $transaksi = $this->transaksiModel->find($id);

        if (!$transaksi) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON(['status' => 'error', 'message' => 'Transaksi tidak ditemukan']);
        }

        $this->transaksiModel->delete($id);

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Transaksi dihapus',
        ]);
    }
}
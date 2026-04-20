<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * VideoStream Controller
 * Upload, enkripsi AES-256-CBC, streaming, dan playback video lokal.
 * Terintegrasi penuh dengan LMS (pengajar upload, peserta play).
 */
class VideoStream extends BaseController
{
    protected string $encryptionKey;
    protected int    $chunkSize = 1024 * 256; // 256 KB

    public function __construct()
    {
        $this->encryptionKey = (string) env('VIDEO_ENCRYPTION_KEY', '');

        if (empty($this->encryptionKey)) {
            log_message('error', '[VideoStream] VIDEO_ENCRYPTION_KEY tidak ditemukan di .env');
        }
    }

    // ═══════════════════════════════════════════════════════════════
    //  GUARD HELPERS
    // ═══════════════════════════════════════════════════════════════

    private function guardLogin()
    {
        if (!session()->get('id_users')) {
            return redirect()->to('/login');
        }
        return null;
    }

    private function guardPengajarJson()
    {
        if (session()->get('role') !== 'pengajar') {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Akses ditolak. Hanya pengajar yang diizinkan.'])
                ->setStatusCode(403);
        }
        return null;
    }

    private function uid(): int
    {
        return (int) session()->get('id_users');
    }

    private function isLoggedIn(): bool
    {
        return !empty(session()->get('id_users'));
    }

    // ═══════════════════════════════════════════════════════════════
    //  HALAMAN UPLOAD  —  GET /dashboard/pengajar/video/upload
    // ═══════════════════════════════════════════════════════════════

    public function uploadPage()
    {
        if ($r = $this->guardLogin()) return $r;

        if (session()->get('role') !== 'pengajar') {
            return redirect()->to('/dashboard')->with('error', 'Akses ditolak.');
        }

        return view('Dashboard/Pengajar/video_upload');
    }

    // ═══════════════════════════════════════════════════════════════
    //  DO UPLOAD  —  POST /dashboard/pengajar/video/upload
    // ═══════════════════════════════════════════════════════════════

    public function doUpload()
    {
        if (!$this->isLoggedIn()) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Unauthorized'])
                ->setStatusCode(401);
        }

        if ($r = $this->guardPengajarJson()) return $r;

        // ── FIX: Bypass rule uploaded[] CI4, cek $_FILES langsung ──
        if (empty($_FILES['video']) || $_FILES['video']['error'] !== UPLOAD_ERR_OK) {
            $errCode = $_FILES['video']['error'] ?? UPLOAD_ERR_NO_FILE;
            $errMap  = [
                UPLOAD_ERR_INI_SIZE   => 'File melebihi batas upload server (' . ini_get('upload_max_filesize') . '). Naikkan upload_max_filesize di hosting.',
                UPLOAD_ERR_FORM_SIZE  => 'File melebihi batas MAX_FILE_SIZE form.',
                UPLOAD_ERR_PARTIAL    => 'Upload tidak lengkap, coba lagi.',
                UPLOAD_ERR_NO_FILE    => 'Tidak ada file yang dikirim.',
                UPLOAD_ERR_NO_TMP_DIR => 'Folder temporary server tidak ditemukan.',
                UPLOAD_ERR_CANT_WRITE => 'Gagal tulis ke disk. Cek permission writable/.',
            ];
            $msg = $errMap[$errCode] ?? 'Upload error kode: ' . $errCode;
            log_message('error', '[VideoStream::doUpload] $_FILES error=' . $errCode . ' msg=' . $msg);
            return $this->response
                ->setJSON(['success' => false, 'message' => $msg])
                ->setStatusCode(400);
        }

        // ── Validasi ekstensi & ukuran manual ──
        $allowedExt = ['mp4', 'avi', 'mkv', 'mov', 'webm'];
        $tmpName    = $_FILES['video']['tmp_name'];
        $origName   = $_FILES['video']['name'];
        $fileSize   = $_FILES['video']['size'];
        $ext        = strtolower(pathinfo($origName, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowedExt)) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Format tidak didukung. Gunakan: MP4, AVI, MKV, MOV, WEBM.'])
                ->setStatusCode(400);
        }

        if ($fileSize > 524288 * 1024) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Ukuran file melebihi 512 MB.'])
                ->setStatusCode(400);
        }

        // ── Buat direktori ──
        $originalPath  = WRITEPATH . 'uploads/original/';
        $encryptedPath = WRITEPATH . 'uploads/encrypted/';

        foreach ([$originalPath, $encryptedPath] as $dir) {
            if (!is_dir($dir)) mkdir($dir, 0755, true);
        }

        if (!is_writable($originalPath) || !is_writable($encryptedPath)) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Folder upload tidak writable. Jalankan: chmod -R 775 writable/'])
                ->setStatusCode(500);
        }

        $videoId      = uniqid('vid_', true);
        $originalFile = $originalPath . $videoId . '.' . $ext;
        $encFile      = $encryptedPath . $videoId . '.enc';

        // ── Pindahkan file dari tmp ──
        if (!move_uploaded_file($tmpName, $originalFile)) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Gagal memindahkan file upload. Cek permission folder.'])
                ->setStatusCode(500);
        }

        // ── Enkripsi per-chunk (hemat RAM) ──
        if (!$this->encryptFileChunked($originalFile, $encFile)) {
            @unlink($originalFile);
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Gagal mengenkripsi video. Pastikan VIDEO_ENCRYPTION_KEY sudah diset di .env'])
                ->setStatusCode(500);
        }

        @unlink($originalFile);

        $judulVideo = trim((string) $this->request->getPost('judul_video'));
        if (empty($judulVideo)) $judulVideo = $origName;

        $encSize = file_exists($encFile) ? filesize($encFile) : 0;

        $db = \Config\Database::connect();
        $db->table('video_encrypted')->insert([
            'video_id'    => $videoId,
            'judul_video' => $judulVideo,
            'ext'         => $ext,
            'size'        => $encSize,
            'id_users'    => $this->uid(),
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Video berhasil diupload dan dienkripsi.',
            'data'    => [
                'video_id'    => $videoId,
                'judul_video' => $judulVideo,
                'size'        => $encSize,
            ],
        ]);
    }

    // ═══════════════════════════════════════════════════════════════
    //  STREAM  —  GET /api/videos/stream/{videoId}
    // ═══════════════════════════════════════════════════════════════

    public function stream($videoId = null)
    {
        if (!$this->isLoggedIn()) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Unauthorized'])
                ->setStatusCode(401);
        }

        if (empty($videoId)) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Video ID diperlukan.'])
                ->setStatusCode(400);
        }

        $videoId   = preg_replace('/[^a-zA-Z0-9_\-.]/', '', $videoId);
        $videoPath = WRITEPATH . 'uploads/encrypted/' . $videoId . '.enc';

        if (!file_exists($videoPath)) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'File video tidak ditemukan.'])
                ->setStatusCode(404);
        }

        $fileSize = filesize($videoPath);
        $handle   = fopen($videoPath, 'rb');

        if (!$handle) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Tidak bisa membuka file video.'])
                ->setStatusCode(500);
        }

        header('Content-Type: application/octet-stream');
        header('Content-Length: ' . $fileSize);
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        header('X-Accel-Buffering: no');
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');

        while (!feof($handle)) {
            $chunk = fread($handle, $this->chunkSize);
            echo $chunk;
            flush();
            if (connection_aborted()) {
                break;
            }
        }

        fclose($handle);
        exit;
    }

    // ═══════════════════════════════════════════════════════════════
    //  INFO  —  GET /api/videos/info/{videoId}
    // ═══════════════════════════════════════════════════════════════

    public function info($videoId = null)
    {
        if (!$this->isLoggedIn()) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Unauthorized'])
                ->setStatusCode(401);
        }

        if (empty($videoId)) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Video ID diperlukan.'])
                ->setStatusCode(400);
        }

        $videoId   = preg_replace('/[^a-zA-Z0-9_\-.]/', '', $videoId);
        $videoPath = WRITEPATH . 'uploads/encrypted/' . $videoId . '.enc';

        if (!file_exists($videoPath)) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'File video tidak ditemukan.'])
                ->setStatusCode(404);
        }

        $size = filesize($videoPath);

        $db  = \Config\Database::connect();
        $row = $db->table('video_encrypted')
            ->where('video_id', $videoId)
            ->where('deleted_at IS NULL')
            ->get()->getRowArray();

        return $this->response->setJSON([
            'success' => true,
            'data'    => [
                'id'           => $videoId,
                'judul'        => $row['judul_video'] ?? $videoId,
                'size'         => $size,
                'chunk_size'   => $this->chunkSize,
                'total_chunks' => (int) ceil($size / $this->chunkSize),
            ],
        ]);
    }

    // ═══════════════════════════════════════════════════════════════
    //  GET KEY  —  GET /api/videos/key
    // ═══════════════════════════════════════════════════════════════

    public function getKey()
    {
        if (!$this->isLoggedIn()) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Unauthorized'])
                ->setStatusCode(401);
        }

        if (empty($this->encryptionKey)) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Kunci enkripsi belum dikonfigurasi di server.'])
                ->setStatusCode(500);
        }

        return $this->response->setJSON([
            'success' => true,
            'key'     => base64_encode($this->encryptionKey),
        ]);
    }

    // ═══════════════════════════════════════════════════════════════
    //  PLAYER PAGE  —  GET /video/player?id=vid_xxx
    // ═══════════════════════════════════════════════════════════════

    public function player()
    {
        if (!$this->isLoggedIn()) {
            return redirect()->to('/login');
        }

        $videoId = $this->request->getGet('id');

        if (empty($videoId)) {
            return redirect()->back()->with('error', 'Video ID tidak ditemukan.');
        }

        $videoId = preg_replace('/[^a-zA-Z0-9_\-.]/', '', $videoId);

        return view('video/embed_video', ['videoId' => $videoId]);
    }

    // ═══════════════════════════════════════════════════════════════
    //  LIST VIDEO  —  GET /dashboard/pengajar/video/list  (AJAX)
    // ═══════════════════════════════════════════════════════════════

    public function listVideos()
    {
        if (!$this->isLoggedIn()) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Unauthorized'])
                ->setStatusCode(401);
        }

        $db   = \Config\Database::connect();
        $role = session()->get('role');

        $query = $db->table('video_encrypted')->where('deleted_at IS NULL');

        if ($role === 'pengajar') {
            $query->where('id_users', $this->uid());
        }

        $videos = $query->orderBy('created_at', 'DESC')->get()->getResultArray();

        return $this->response->setJSON([
            'success' => true,
            'data'    => $videos,
        ]);
    }

    // ═══════════════════════════════════════════════════════════════
    //  DELETE VIDEO  —  POST /dashboard/pengajar/video/delete/{videoId}
    // ═══════════════════════════════════════════════════════════════

    public function deleteVideo($videoId = null)
    {
        if (!$this->isLoggedIn()) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Unauthorized'])
                ->setStatusCode(401);
        }

        if ($r = $this->guardPengajarJson()) return $r;

        if (empty($videoId)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Video ID diperlukan.']);
        }

        $videoId = preg_replace('/[^a-zA-Z0-9_\-.]/', '', $videoId);
        $db      = \Config\Database::connect();

        $row = $db->table('video_encrypted')
            ->where('video_id', $videoId)
            ->where('id_users', $this->uid())
            ->where('deleted_at IS NULL')
            ->get()->getRowArray();

        if (!$row) {
            return $this->response->setJSON(['success' => false, 'message' => 'Video tidak ditemukan.']);
        }

        $encFile = WRITEPATH . 'uploads/encrypted/' . $videoId . '.enc';
        if (file_exists($encFile)) {
            @unlink($encFile);
        }

        $db->table('video_encrypted')
            ->where('video_id', $videoId)
            ->update(['deleted_at' => date('Y-m-d H:i:s')]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Video berhasil dihapus.',
        ]);
    }

    // ═══════════════════════════════════════════════════════════════
    //  PRIVATE: ENKRIPSI FILE AES-256-CBC
    // ═══════════════════════════════════════════════════════════════

    // ── encryptFile lama diganti chunked agar hemat RAM di hosting ──
    private function encryptFile(string $source, string $destination): bool
    {
        return $this->encryptFileChunked($source, $destination);
    }

    private function encryptFileChunked(string $source, string $destination): bool
    {
        try {
            if (empty($this->encryptionKey)) {
                throw new \Exception('VIDEO_ENCRYPTION_KEY kosong.');
            }
            if (!file_exists($source)) {
                throw new \Exception('File sumber tidak ditemukan: ' . $source);
            }

            // Derive 32-byte key untuk AES-256
            $key = hash('sha256', $this->encryptionKey, true);
            $iv  = openssl_random_pseudo_bytes(16);

            $src  = fopen($source, 'rb');
            $dest = fopen($destination, 'wb');

            if (!$src || !$dest) {
                throw new \Exception('Tidak bisa membuka file untuk enkripsi.');
            }

            fwrite($dest, $iv); // Tulis IV 16 byte di awal

            while (!feof($src)) {
                $chunk = fread($src, 65536); // 64 KB per chunk
                if ($chunk === false) break;

                $enc = openssl_encrypt($chunk, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
                if ($enc === false) {
                    throw new \Exception('openssl_encrypt gagal: ' . openssl_error_string());
                }
                fwrite($dest, $enc);
                // ✅ PENTING: Jangan gunakan IV chaining! Gunakan IV yang sama untuk semua chunk
                // Dengan ini, browser bisa decrypt dengan mudah menggunakan IV pertama
            }

            fclose($src);
            fclose($dest);
            return true;

        } catch (\Exception $e) {
            log_message('error', '[VideoStream::encryptFileChunked] ' . $e->getMessage());
            if (isset($src)  && is_resource($src))  fclose($src);
            if (isset($dest) && is_resource($dest)) fclose($dest);
            return false;
        }
    }
}
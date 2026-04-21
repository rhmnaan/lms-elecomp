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

        $validation = \Config\Services::validation();
        $validation->setRules([
            'video' => 'uploaded[video]|max_size[video,524288]|ext_in[video,mp4,avi,mkv,mov,webm]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response
                ->setJSON(['success' => false, 'errors' => $validation->getErrors()])
                ->setStatusCode(400);
        }

        $video = $this->request->getFile('video');

        if (!$video || !$video->isValid()) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'File video tidak valid.'])
                ->setStatusCode(400);
        }

        $encryptedPath = WRITEPATH . 'uploads/encrypted/';

        if (!is_dir($encryptedPath)) {
            mkdir($encryptedPath, 0755, true);
        }

        $videoId = uniqid('vid_', true);
        $ext     = $video->getClientExtension();
        $encFile = $encryptedPath . $videoId . '.enc';
        $tempFile = $video->getTempName();

        if (!$tempFile || !is_file($tempFile)) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'File sementara tidak ditemukan.'])
                ->setStatusCode(500);
        }

        if (!$this->encryptFile($tempFile, $encFile)) {
            @unlink($encFile);
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Gagal mengenkripsi video. Pastikan VIDEO_ENCRYPTION_KEY sudah diset di .env'])
                ->setStatusCode(500);
        }

        $judulVideo = trim((string) $this->request->getPost('judul_video'));
        if (empty($judulVideo)) {
            $judulVideo = $video->getClientName();
        }

        $db = \Config\Database::connect();
        $db->table('video_encrypted')->insert([
            'video_id'    => $videoId,
            'judul_video' => $judulVideo,
            'ext'         => $ext,
            'size'        => filesize($encFile),
            'id_users'    => $this->uid(),
            'created_at'  => date('Y-m-d H:i:s'),
        ]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Video berhasil diupload dan dienkripsi.',
            'data'    => [
                'video_id'    => $videoId,
                'judul_video' => $judulVideo,
                'size'        => filesize($encFile),
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
                ->setJSON(['success' => false, 'message' => 'Kunci enkripsi belum dikonfigurasi.'])
                ->setStatusCode(500);
        }

        // ✅ Derive dulu seperti saat enkripsi, baru kirim ke browser
        $derivedKey = hash('sha256', $this->encryptionKey, true); // 32 bytes binary

        return $this->response->setJSON([
            'success' => true,
            'key'     => base64_encode($derivedKey), // kirim derived key
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
    //  PRIVATE: ENKRIPSI FILE AES-256-CBC (FIXED)
    // ═══════════════════════════════════════════════════════════════

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

            $iv = openssl_random_pseudo_bytes(16);
            if ($iv === false) {
                throw new \Exception('Gagal membuat IV acak.');
            }

            $sourceHandle = fopen($source, 'rb');
            if (!$sourceHandle) {
                throw new \Exception('Tidak bisa membuka file sumber: ' . $source);
            }

            $destinationHandle = fopen($destination, 'wb');
            if (!$destinationHandle) {
                fclose($sourceHandle);
                throw new \Exception('Tidak bisa membuat file tujuan: ' . $destination);
            }

            fwrite($destinationHandle, $iv);

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
                $iv = substr($enc, -16); // IV chaining
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

    private function pkcs7Pad(string $data, int $blockSize): string
    {
        $padLen = $blockSize - (strlen($data) % $blockSize);
        if ($padLen === 0) {
            $padLen = $blockSize;
        }
        return $data . str_repeat(chr($padLen), $padLen);
    }
}

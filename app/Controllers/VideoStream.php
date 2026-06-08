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
        $encryptedPath = WRITEPATH . 'uploads/encrypted/';
        if (!is_dir($encryptedPath)) mkdir($encryptedPath, 0755, true);
        
        if (!is_writable($encryptedPath)) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Folder upload tidak writable.'])
                ->setStatusCode(500);
        }
        
        $videoId = uniqid('vid_', true);
        $encFile = $encryptedPath . $videoId . '.enc';
        
        // Langsung pindah dari /tmp ke encrypted, tanpa singgah folder original
        if (!move_uploaded_file($tmpName, $encFile)) {
            return $this->response
                ->setJSON(['success' => false, 'message' => 'Gagal memindahkan file upload.'])
                ->setStatusCode(500);
        }

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
        while (ob_get_level()) {
            ob_end_clean();
        }
    
        if (!$this->isLoggedIn()) {
            http_response_code(401);
            exit;
        }
        
        if (!$this->isLoggedIn()) {
            http_response_code(401);
            exit;
        }
    
        if (empty($videoId)) {
            http_response_code(400);
            exit;
        }
    
        $videoId   = preg_replace('/[^a-zA-Z0-9_\-.]/', '', $videoId);
        $videoPath = WRITEPATH . 'uploads/encrypted/' . $videoId . '.enc';
    
        if (!file_exists($videoPath)) {
            http_response_code(404);
            exit;
        }
    
        // Ambil ext dari DB untuk MIME type
        $db  = \Config\Database::connect();
        $row = $db->table('video_encrypted')
            ->where('video_id', $videoId)
            ->get()->getRowArray();
    
        $ext  = $row['ext'] ?? 'mp4';
        $mime = match($ext) {
            'mp4'  => 'video/mp4',
            'webm' => 'video/webm',
            'mkv'  => 'video/x-matroska',
            'avi'  => 'video/x-msvideo',
            'mov'  => 'video/quicktime',
            default => 'video/mp4',
        };
    
        $fileSize = filesize($videoPath);
        $handle   = fopen($videoPath, 'rb');
    
        if (!$handle) {
            http_response_code(500);
            exit;
        }
    
        // Handle Range request (untuk seekbar video)
        $start = 0;
        $end   = $fileSize - 1;
    
        if (isset($_SERVER['HTTP_RANGE'])) {
            preg_match('/bytes=(\d+)-(\d*)/', $_SERVER['HTTP_RANGE'], $matches);
            $start = (int) $matches[1];
            $end   = !empty($matches[2]) ? (int) $matches[2] : $fileSize - 1;
    
            http_response_code(206);
            header('Content-Range: bytes ' . $start . '-' . $end . '/' . $fileSize);
        } else {
            http_response_code(200);
        }
    
        $length = $end - $start + 1;
    
        header('Content-Type: ' . $mime);
        header('Content-Length: ' . $length);
        header('Accept-Ranges: bytes');
        header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        header('Pragma: no-cache');
        header('X-Accel-Buffering: no');
        header('X-Content-Type-Options: nosniff');
        header('X-Frame-Options: SAMEORIGIN');
    
        fseek($handle, $start);
        $remaining = $length;
    
        while (!feof($handle) && $remaining > 0) {
            $readSize = min($this->chunkSize, $remaining);
            $chunk    = fread($handle, $readSize);
            echo $chunk;
            flush();
            $remaining -= strlen($chunk);
    
            if (connection_aborted()) break;
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

    /**
     * ✅ FIXED: Enkripsi file dengan AES-256-CBC yang kompatibel dengan browser
     * Untuk video kecil-menengah (<100MB)
     */
    private function encryptFileChunked(string $source, string $destination): bool
    {
        try {
            if (empty($this->encryptionKey)) {
                throw new \Exception('VIDEO_ENCRYPTION_KEY kosong.');
            }
            if (!file_exists($source)) {
                throw new \Exception('File sumber tidak ditemukan: ' . $source);
            }
    
            $key = hash('sha256', $this->encryptionKey, true); // 32 bytes
            $iv  = openssl_random_pseudo_bytes(16);
    
            // Baca seluruh file sekaligus (works untuk file <= ~500MB dengan RAM cukup)
            $plaintext = file_get_contents($source);
            if ($plaintext === false) {
                throw new \Exception('Gagal membaca file sumber.');
            }
    
            // Enkripsi sekali — openssl handle PKCS7 padding otomatis
            $encrypted = openssl_encrypt(
                $plaintext,
                'aes-256-cbc',
                $key,
                OPENSSL_RAW_DATA, // bukan ZERO_PADDING
                $iv
            );
    
            if ($encrypted === false) {
                throw new \Exception('openssl_encrypt gagal: ' . openssl_error_string());
            }
    
            // Format: [16 byte IV][ciphertext]chunkUpload()
            $result = file_put_contents($destination, $iv . $encrypted);
            if ($result === false) {
                throw new \Exception('Gagal menulis file enkripsi.');
            }
    
            unset($plaintext, $encrypted); // bebaskan RAM
            log_message('info', '[VideoStream] Enkripsi berhasil: ' . $destination);
            return true;
    
        } catch (\Exception $e) {
            log_message('error', '[VideoStream::encryptFileChunked] ' . $e->getMessage());
            if (file_exists($destination)) @unlink($destination);
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
    
    
    // ═══════════════════════════════════════════════════════════════
    //  CHUNK UPLOAD  —  POST /dashboard/pengajar/video/chunk-upload
    // ═══════════════════════════════════════════════════════════════
    
    public function chunkUpload()
    {
        if (!$this->isLoggedIn()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized'])->setStatusCode(401);
        }
        if ($r = $this->guardPengajarJson()) return $r;
    
        $chunkIndex  = (int) $this->request->getPost('chunk_index');
        $totalChunks = (int) $this->request->getPost('total_chunks');
        $uploadId    = preg_replace('/[^a-zA-Z0-9_\-]/', '', (string) $this->request->getPost('upload_id'));
        $ext         = strtolower(preg_replace('/[^a-z0-9]/', '', (string) $this->request->getPost('ext')));
        $judulVideo  = trim((string) $this->request->getPost('judul_video'));
    
        if (empty($uploadId) || $totalChunks <= 0) {
            return $this->response->setJSON(['success' => false, 'message' => 'Parameter tidak valid.'])->setStatusCode(400);
        }
    
        if (empty($_FILES['chunk']) || $_FILES['chunk']['error'] !== UPLOAD_ERR_OK) {
            return $this->response->setJSON(['success' => false, 'message' => 'Chunk tidak diterima.'])->setStatusCode(400);
        }
    
        $encryptedPath = WRITEPATH . 'uploads/encrypted/';
        if (!is_dir($encryptedPath)) mkdir($encryptedPath, 0755, true);
    
        // Pakai uploadId sebagai nama file sementara
        $tempFile = $encryptedPath . $uploadId . '.tmp';
    
        // Append chunk langsung ke file output
        $src  = fopen($_FILES['chunk']['tmp_name'], 'rb');
        $dest = fopen($tempFile, 'ab'); // 'ab' = append binary
    
        if (!$src || !$dest) {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal membuka file.'])->setStatusCode(500);
        }
    
        while (!feof($src)) {
            fwrite($dest, fread($src, 1024 * 256));
        }
        fclose($src);
        fclose($dest);
    
        // Jika ini chunk terakhir, rename jadi .enc dan simpan ke DB
        $isLast = ($chunkIndex === $totalChunks - 1);
    
        if ($isLast) {
            $allowedExt = ['mp4', 'avi', 'mkv', 'mov', 'webm'];
            if (!in_array($ext, $allowedExt)) {
                @unlink($tempFile);
                return $this->response->setJSON(['success' => false, 'message' => 'Format tidak didukung.'])->setStatusCode(400);
            }
    
            $videoId = uniqid('vid_', true);
            $encFile = $encryptedPath . $videoId . '.enc';
    
            if (!rename($tempFile, $encFile)) {
                @unlink($tempFile);
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal finalisasi file.'])->setStatusCode(500);
            }
    
            if (empty($judulVideo)) $judulVideo = $videoId . '.' . $ext;
            $encSize = filesize($encFile);
    
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
                'success'  => true,
                'finished' => true,
                'message'  => 'Video berhasil diupload.',
                'data'     => [
                    'video_id'    => $videoId,
                    'judul_video' => $judulVideo,
                    'size'        => $encSize,
                ],
            ]);
        }
    
        return $this->response->setJSON([
            'success'     => true,
            'finished'    => false,
            'chunk_index' => $chunkIndex,
            'message'     => 'Chunk ' . ($chunkIndex + 1) . '/' . $totalChunks . ' diterima.',
        ]);
    }
    
    // ═══════════════════════════════════════════════════════════════
    //  CHUNK MERGE  —  POST /dashboard/pengajar/video/chunk-merge
    // ═══════════════════════════════════════════════════════════════
    
    public function chunkMerge()
    {
        if (!$this->isLoggedIn()) {
            return $this->response->setJSON(['success' => false, 'message' => 'Unauthorized'])->setStatusCode(401);
        }
        if ($r = $this->guardPengajarJson()) return $r;
    
        $uploadId    = preg_replace('/[^a-zA-Z0-9_\-]/', '', (string) $this->request->getPost('upload_id'));
        $totalChunks = (int) $this->request->getPost('total_chunks');
        $ext         = strtolower(preg_replace('/[^a-z0-9]/', '', (string) $this->request->getPost('ext')));
        $judulVideo  = trim((string) $this->request->getPost('judul_video'));
    
        $allowedExt = ['mp4', 'avi', 'mkv', 'mov', 'webm'];
        if (!in_array($ext, $allowedExt)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Format tidak didukung.'])->setStatusCode(400);
        }
    
        $chunkDir = WRITEPATH . 'uploads/chunks/' . $uploadId . '/';
        if (!is_dir($chunkDir)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Chunk tidak ditemukan.'])->setStatusCode(400);
        }
    
        // Cek semua chunk sudah ada
        for ($i = 0; $i < $totalChunks; $i++) {
            if (!file_exists($chunkDir . $i . '.part')) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Chunk ke-' . $i . ' belum diterima.',
                ])->setStatusCode(400);
            }
        }
    
        // Gabungkan chunk
        $encryptedPath = WRITEPATH . 'uploads/encrypted/';
        if (!is_dir($encryptedPath)) mkdir($encryptedPath, 0755, true);
    
        $videoId = uniqid('vid_', true);
        $encFile = $encryptedPath . $videoId . '.enc';
    
        $dest = fopen($encFile, 'wb');
        if (!$dest) {
            return $this->response->setJSON(['success' => false, 'message' => 'Gagal membuat file output.'])->setStatusCode(500);
        }
    
        for ($i = 0; $i < $totalChunks; $i++) {
            $chunkFile = $chunkDir . $i . '.part';
            $src = fopen($chunkFile, 'rb');
            if (!$src) {
                fclose($dest);
                return $this->response->setJSON(['success' => false, 'message' => 'Gagal membaca chunk ke-' . $i])->setStatusCode(500);
            }
            while (!feof($src)) {
                fwrite($dest, fread($src, 1024 * 256));
            }
            fclose($src);
            @unlink($chunkFile); // hapus chunk setelah digabung
        }
    
        fclose($dest);
    
        // Hapus folder chunk
        @rmdir($chunkDir);
    
        if (empty($judulVideo)) $judulVideo = $videoId . '.' . $ext;
        $encSize = filesize($encFile);
    
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
            'message' => 'Video berhasil diupload.',
            'data'    => [
                'video_id'    => $videoId,
                'judul_video' => $judulVideo,
                'size'        => $encSize,
            ],
        ]);
    }
}
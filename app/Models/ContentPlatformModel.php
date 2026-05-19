<?php

namespace App\Models;

use CodeIgniter\Model;

class ContentPlatformModel extends Model
{
    protected $table      = 'content_platform';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'content_id',
        'platform_id'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

     /* ── Ambil semua platform (beserta id cp) untuk 1 konten ── */
    public function getPlatformByContent($contentId)
    {
        return $this->db->table('content_platform cp')
            ->select('cp.id, cp.platform_id, p.nama_platform')
            ->join('platform p', 'p.id = cp.platform_id')
            ->where('cp.content_id', $contentId)
            ->get()->getResultArray();
    }
 
    /* ── Insert banyak platform sekaligus (tidak return id) ── */
    public function insertBatchPlatform(int $contentId, array $platformIds): void
    {
        foreach ($platformIds as $pid) {
            $this->insert(['content_id' => $contentId, 'platform_id' => (int)$pid]);
        }
    }
 
    /* ── Insert 1 platform, return insertId (dipakai untuk asset) ── */
    public function insertBatchPlatformSingle(int $contentId, int $platformId): int
    {
        $this->insert([
            'content_id'  => $contentId,
            'platform_id' => $platformId,
        ]);
        return (int)$this->db->insertID();
    }
 
    /* ── Hapus semua platform untuk 1 konten ── */
    public function deleteByContent($contentId): void
    {
        $this->where('content_id', $contentId)->delete();
    }
}
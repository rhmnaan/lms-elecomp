<?php

namespace App\Models;

use CodeIgniter\Model;

class AssetModel extends Model
{
    protected $table      = 'asset';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'content_platform_id',
        'asset_nama',
        'asset_link',
        'keterangan',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';   // tabel tidak punya updated_at

    /**
     * Ambil semua asset milik sebuah konten,
     * sekaligus sertakan platform_id agar controller bisa
     * mengelompokkan asset per platform.
     */
    public function getAssetByContent(int $contentId): array
    {
        return $this->db->table('asset a')
            ->select('a.id, a.content_platform_id, a.asset_nama, a.asset_link, a.keterangan,
                      cp.platform_id, p.nama_platform')
            ->join('content_platform cp', 'cp.id = a.content_platform_id')
            ->join('platform p', 'p.id = cp.platform_id')
            ->where('cp.content_id', $contentId)
            ->get()
            ->getResultArray();
    }
}
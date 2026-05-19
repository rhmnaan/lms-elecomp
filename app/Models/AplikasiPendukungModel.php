<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Model AplikasiPendukungModel
 * Mendukung tipe 'external' (link luar) dan 'internal' (route dalam LMS)
 */
class AplikasiPendukungModel extends Model
{
    protected $table         = 'aplikasi_pendukung';
    protected $primaryKey    = 'id_aplikasi';
    protected $useTimestamps = false;
    protected $allowedFields = ['nama_aplikasi', 'link_aplikasi', 'tipe', 'icon', 'deskripsi'];

    /**
     * Ambil semua aplikasi yang boleh diakses user tertentu
     * (via tabel aplikasi_user)
     */
    public function getByUser(int $userId): array
    {
        return $this->db->table('aplikasi_pendukung ap')
            ->select('ap.*')
            ->join('aplikasi_user au', 'au.id_aplikasi = ap.id_aplikasi')
            ->where('au.id_users', $userId)
            ->orderBy('ap.nama_aplikasi', 'ASC')
            ->get()->getResultArray();
    }

    /**
     * Cek apakah user punya akses ke aplikasi tertentu
     */
    public function hasAccess(int $userId, int $idAplikasi): bool
    {
        $row = $this->db->table('aplikasi_user')
            ->where('id_users', $userId)
            ->where('id_aplikasi', $idAplikasi)
            ->get()->getRowArray();
        return (bool) $row;
    }

    /**
     * Cari aplikasi internal berdasarkan nama (untuk cek kalkulator)
     */
    public function findInternal(string $nama): ?array
    {
        return $this->where('tipe', 'internal')
                    ->where('nama_aplikasi', $nama)
                    ->first();
    }
}
<?php

namespace App\Models;

use CodeIgniter\Model;

class AplikasiPendukungModel extends Model
{
    protected $table      = 'aplikasi_pendukung';
    protected $primaryKey = 'id_aplikasi';

    protected $allowedFields = [
        'nama_aplikasi',
        'link_aplikasi',
    ];

    /**
     * Ambil semua aplikasi beserta jumlah peserta yang punya akses
     */
    public function getAllWithAksesCount(): array
    {
        $db = \Config\Database::connect();
        return $db->table('aplikasi_pendukung ap')
            ->select('ap.*, COUNT(au.id_users) AS akses_count')
            ->join('aplikasi_user au', 'au.id_aplikasi = ap.id_aplikasi', 'left')
            ->groupBy('ap.id_aplikasi')
            ->get()
            ->getResultArray();
    }

    /**
     * Ambil id_users yang punya akses ke aplikasi tertentu
     * (dipakai dari sisi halaman aplikasi)
     */
    public function getUsersByAplikasi(int $idAplikasi): array
    {
        $db  = \Config\Database::connect();
        $rows = $db->table('aplikasi_user')
            ->select('id_users')
            ->where('id_aplikasi', $idAplikasi)
            ->get()
            ->getResultArray();

        return array_map(fn($r) => (int) $r['id_users'], $rows);
    }

    /**
     * Ambil id_aplikasi yang bisa diakses oleh peserta tertentu
     * (dipakai dari sisi halaman peserta)
     */
    public function getAplikasiByUser(int $idUsers): array
    {
        $db   = \Config\Database::connect();
        $rows = $db->table('aplikasi_user')
            ->select('id_aplikasi')
            ->where('id_users', $idUsers)
            ->get()
            ->getResultArray();

        return array_map(fn($r) => (int) $r['id_aplikasi'], $rows);
    }

    /**
     * Simpan akses dari sisi aplikasi:
     * ganti semua peserta untuk aplikasi tertentu
     */
    public function simpanAksesByAplikasi(int $idAplikasi, array $userIds): void
    {
        $db = \Config\Database::connect();
        $db->table('aplikasi_user')->where('id_aplikasi', $idAplikasi)->delete();

        if (!empty($userIds)) {
            $db->table('aplikasi_user')->insertBatch(
                array_map(
                    fn($id) => ['id_aplikasi' => $idAplikasi, 'id_users' => $id],
                    $userIds
                )
            );
        }
    }

    /**
     * Simpan akses dari sisi peserta:
     * ganti semua aplikasi untuk peserta tertentu
     */
    public function simpanAksesByUser(int $idUsers, array $aplikasiIds): void
    {
        $db = \Config\Database::connect();
        $db->table('aplikasi_user')->where('id_users', $idUsers)->delete();

        if (!empty($aplikasiIds)) {
            $db->table('aplikasi_user')->insertBatch(
                array_map(
                    fn($id) => ['id_aplikasi' => $id, 'id_users' => $idUsers],
                    $aplikasiIds
                )
            );
        }
    }
}
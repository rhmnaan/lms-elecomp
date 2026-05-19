<?php

namespace App\Models;

use CodeIgniter\Model;

class PlatformModel extends Model
{
    protected $table      = 'platform';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_users',        // ⬅️ relasi ke users
        'nama_platform',
        'status'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = '';

    /**
     * Ambil semua platform aktif milik user
     */
    public function getActivePlatformByUser($idUser)
    {
        return $this
            ->where('id_users', $idUser)
            ->where('status', 'aktif')
            ->orderBy('nama_platform', 'ASC')
            ->findAll();
    }

    /**
     * Ambil semua platform milik user (aktif + nonaktif)
     */
    public function getByUser($idUser)
    {
        return $this
            ->where('id_users', $idUser)
            ->orderBy('nama_platform', 'ASC')
            ->findAll();
    }

    /**
     * Ambil satu platform milik user
     */
    public function getOneByUser($id, $idUser)
    {
        return $this
            ->where('id', $id)
            ->where('id_users', $idUser)
            ->first();
    }
}
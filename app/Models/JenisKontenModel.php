<?php

namespace App\Models;

use CodeIgniter\Model;

class JenisKontenModel extends Model
{
    protected $table      = 'jenis_konten';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_users',     // ⬅️ relasi ke users
        'nama_jenis',
        'keterangan'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';

    /**
     * Ambil semua jenis konten milik user
     */
    public function getByUser($idUser)
    {
        return $this
            ->where('id_users', $idUser)
            ->orderBy('nama_jenis', 'ASC')
            ->findAll();
    }

    /**
     * Ambil satu jenis konten milik user
     */
    public function getOneByUser($id, $idUser)
    {
        return $this
            ->where('id', $id)
            ->where('id_users', $idUser)
            ->first();
    }
}
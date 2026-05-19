<?php

namespace App\Models;

use CodeIgniter\Model;

class ContentTypeModel extends Model
{
    protected $table      = 'content_type';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'id_users',     // ⬅️ relasi ke users
        'nama_type'
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = '';

    /**
     * Ambil semua content type milik user
     */
    public function getByUser($idUser)
    {
        return $this
            ->where('id_users', $idUser)
            ->orderBy('nama_type', 'ASC')
            ->findAll();
    }

    /**
     * Ambil 1 content type milik user
     */
    public function getOneByUser($id, $idUser)
    {
        return $this
            ->where('id', $id)
            ->where('id_users', $idUser)
            ->first();
    }
}
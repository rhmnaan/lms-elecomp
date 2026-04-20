<?php

namespace App\Models;

use CodeIgniter\Model;

class ProgramModel extends Model
{
    protected $table            = 'program';
    protected $primaryKey       = 'id_program';
    protected $useAutoIncrement = true;

    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;

    protected $allowedFields = [
        'nama_program',
        'deskripsi_program',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    /**
     * Ambil semua program aktif
     */
    public function getAll()
    {
        return $this->where('deleted_at', null)
                    ->orderBy('nama_program', 'ASC')
                    ->findAll();
    }
}
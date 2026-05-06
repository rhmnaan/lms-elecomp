<?php

namespace App\Models;

use CodeIgniter\Model;

class TugasDeadlinePesertaModel extends Model
{
    protected $table            = 'tugas_deadline_peserta';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $protectFields  = true;

    protected $allowedFields = [
        'id_tugas',
        'id_users',
        'deadline_at',
        'created_at'
    ];

    protected $useTimestamps = false;

    /**
     * Ambil deadline tugas peserta
     */
    public function getDeadline($id_tugas, $id_users)
    {
        return $this->where('id_tugas', $id_tugas)
                    ->where('id_users', $id_users)
                    ->first();
    }

    /**
     * Set atau update deadline tugas peserta
     * (aman dengan UNIQUE KEY id_tugas + id_users)
     */
    public function setDeadline($id_tugas, $id_users, $deadline_at)
    {
        $data = [
            'id_tugas'    => $id_tugas,
            'id_users'    => $id_users,
            'deadline_at' => $deadline_at,
            'created_at'  => date('Y-m-d H:i:s')
        ];

        $existing = $this->getDeadline($id_tugas, $id_users);

        if ($existing) {
            return $this->where('id', $existing['id'])
                        ->set('deadline_at', $deadline_at)
                        ->update();
        }

        return $this->insert($data);
    }
}
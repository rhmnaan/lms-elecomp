<?php

namespace App\Models;

use CodeIgniter\Model;

class TugasDeadlinePesertaModel extends Model
{
    protected $table            = 'tugas_deadline_peserta';
    protected $primaryKey       = 'id_deadline';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $protectFields  = true;

    protected $allowedFields = [
        'id_kelas',
        'id_users',
        'deadline_at',
        'created_at'
    ];

    protected $useTimestamps = false;

    /**
     * Ambil deadline tugas peserta
     */
    public function getDeadline($id_kelas, $id_users)
    {
        return $this->where('id_kelas', $id_kelas)
                    ->where('id_users', $id_users)
                    ->first();
    }

    /**
     * Set atau update deadline tugas peserta
     * (aman dengan UNIQUE KEY id_kelas + id_users)
     */
    public function setDeadline($id_kelas, $id_users, $deadline_at)
    {
        $existing = $this->getDeadline($id_kelas, $id_users);
    
        if ($existing) {
            return $this->where('id_deadline', $existing['id_deadline'])
                        ->set('deadline_at', $deadline_at)
                        ->update();
        }
    
        return $this->insert([
            'id_kelas'    => $id_kelas,
            'id_users'    => $id_users,
            'deadline_at' => $deadline_at,
            'created_at'  => date('Y-m-d H:i:s')
        ]);
    }
}
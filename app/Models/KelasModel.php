<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama_kelas',
        'deskripsi_kelas',
        'id_users'
    ];
    
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
        'nama_kelas' => 'required|min_length[3]|max_length[100]',
        'id_users' => 'required|numeric'
    ];
    
    /**
     * Get kelas with pengajar
     */
    public function getWithPengajar()
    {
        return $this->select('kelas.*, users.nama_users as nama_pengajar, users.email_users')
                    ->join('users', 'users.id_users = kelas.id_users')
                    ->findAll();
    }
    
    /**
     * Get kelas by pengajar
     */
    public function getByPengajar($id_pengajar)
    {
        return $this->where('id_users', $id_pengajar)->findAll();
    }
    
    /**
     * Get kelas with modul count
     */
    public function getWithModulCount()
    {
        return $this->select('kelas.*, users.nama_users as nama_pengajar, COUNT(modul.id_modul) as total_modul')
                    ->join('users', 'users.id_users = kelas.id_users', 'left')
                    ->join('modul', 'modul.id_kelas = kelas.id_kelas AND modul.deleted_at IS NULL', 'left')
                    ->groupBy('kelas.id_kelas')
                    ->findAll();
    }
}
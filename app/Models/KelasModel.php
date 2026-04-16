<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasModel extends Model
{
    protected $table            = 'kelas';
    protected $primaryKey       = 'id_kelas';
    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields  = true;

    protected $allowedFields = [
        'id_program',        // ✅ TAMBAHAN
        'nama_kelas',
        'deskripsi_kelas',
        'id_users'
    ];
    
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    protected $validationRules = [
        'id_program' => 'required|numeric', // ✅ TAMBAHAN
        'nama_kelas' => 'required|min_length[3]|max_length[100]',
        'id_users'   => 'required|numeric'
    ];
    
    /**
     * Get kelas with pengajar + program
     */
    public function getWithPengajar()
    {
        return $this->select('
                kelas.*,
                program.nama_program,
                users.nama_users as nama_pengajar,
                users.email_users
            ')
            ->join('program', 'program.id_program = kelas.id_program')
            ->join('users', 'users.id_users = kelas.id_users')
            ->where('kelas.deleted_at', null)
            ->findAll();
    }
    
    /**
     * Get kelas by pengajar
     */
    public function getByPengajar($id_pengajar)
    {
        return $this->select('kelas.*, program.nama_program')
                    ->join('program', 'program.id_program = kelas.id_program')
                    ->where('kelas.id_users', $id_pengajar)
                    ->where('kelas.deleted_at', null)
                    ->findAll();
    }
    
    /**
     * Get kelas by program
     */
    public function getByProgram($id_program)
    {
        return $this->select('kelas.*, program.nama_program')
                    ->join('program', 'program.id_program = kelas.id_program')
                    ->where('kelas.id_program', $id_program)
                    ->where('kelas.deleted_at', null)
                    ->findAll();
    }
    
    /**
     * Get kelas with modul count
     */
    public function getWithModulCount()
    {
        return $this->select('
                kelas.*,
                program.nama_program,
                users.nama_users as nama_pengajar,
                COUNT(DISTINCT modul.id_modul) as total_modul
            ')
            ->join('program', 'program.id_program = kelas.id_program')
            ->join('users', 'users.id_users = kelas.id_users', 'left')
            ->join('modul', 'modul.id_kelas = kelas.id_kelas AND modul.deleted_at IS NULL', 'left')
            ->where('kelas.deleted_at', null)
            ->groupBy('kelas.id_kelas')
            ->findAll();
    }

    /**
     * Detail kelas lengkap (program + pengajar)
     */
    public function getDetail($id_kelas)
    {
        return $this->select('
                kelas.*,
                program.nama_program,
                program.deskripsi_program,
                users.nama_users as nama_pengajar
            ')
            ->join('program', 'program.id_program = kelas.id_program')
            ->join('users', 'users.id_users = kelas.id_users', 'left')
            ->where('kelas.id_kelas', $id_kelas)
            ->where('kelas.deleted_at', null)
            ->first();
    }
}
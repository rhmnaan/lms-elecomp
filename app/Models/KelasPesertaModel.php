<?php

namespace App\Models;

use CodeIgniter\Model;

class KelasPesertaModel extends Model
{
    protected $table = 'kelas_peserta';
    protected $primaryKey = 'id_kelas_peserta';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'id_kelas',
        'id_users',
        'tanggal_daftar_kelas_peserta',
        'tanggal_berakhir',
        'status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';
    
    /**
     * Get kelas by peserta (with all info including total_quiz)
     */
    public function getKelasByPeserta($id_users)
    {
        return $this->select('
                MAX(kelas_peserta.id_kelas_peserta) as id_kelas_peserta,
                kelas_peserta.id_kelas,
                MAX(kelas_peserta.id_users) as id_users,
                MAX(kelas_peserta.tanggal_daftar_kelas_peserta) as tanggal_daftar_kelas_peserta,
                MAX(kelas_peserta.created_at) as created_at,
                MAX(kelas_peserta.updated_at) as updated_at,
                MAX(kelas_peserta.deleted_at) as deleted_at,
                kelas.nama_kelas,
                kelas.deskripsi_kelas,
                users.nama_users as nama_pengajar,
                COUNT(DISTINCT modul.id_modul) as total_modul,
                COUNT(DISTINCT materi.id_materi) as total_materi
            ')
            ->join('kelas', 'kelas.id_kelas = kelas_peserta.id_kelas')
            ->join('users', 'users.id_users = kelas.id_users', 'left')
            ->join('modul', 'modul.id_kelas = kelas.id_kelas AND modul.deleted_at IS NULL', 'left')
            ->join('materi', 'materi.id_modul = modul.id_modul AND materi.deleted_at IS NULL', 'left')
            ->where('kelas_peserta.id_users', $id_users)
            ->where('kelas_peserta.deleted_at', null)
            ->groupBy('kelas.id_kelas')
            ->orderBy('tanggal_daftar_kelas_peserta', 'ASC')
            ->findAll();
    }
    
    /**
     * Get peserta by kelas
     */
    public function getPesertaByKelas($id_kelas)
    {
        return $this->select('kelas_peserta.*, users.nama_users, users.email_users')
                    ->join('users', 'users.id_users = kelas_peserta.id_users')
                    ->where('kelas_peserta.id_kelas', $id_kelas)
                    ->where('kelas_peserta.deleted_at', null)
                    ->findAll();
    }
    
    /**
     * Check if user is enrolled
     */
    public function isEnrolled($id_kelas, $id_users)
    {
        return $this->where('id_kelas', $id_kelas)
                    ->where('id_users', $id_users)
                    ->countAllResults() > 0;
    }
    
    /**
     * Enroll user to class
     */
    public function enroll($id_kelas, $id_users)
    {
        if ($this->isEnrolled($id_kelas, $id_users)) {
            return false;
        }
        
        return $this->insert([
            'id_kelas' => $id_kelas,
            'id_users' => $id_users,
            'tanggal_daftar_kelas_peserta' => date('Y-m-d H:i:s')
        ]);
    }
}
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
        'id_program',
        'harga',    // nullable
        'lynk_url', // nullable
        'gambar_kelas',
        'nama_kelas',
        'deskripsi_kelas',
        'id_users',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules = [
        'id_program' => 'required|numeric',
        'nama_kelas' => 'required|min_length[3]|max_length[100]',
        'id_users'   => 'required|numeric',
    ];

    protected $validationMessages = [
    ];

    /* =========================
     * ADMIN / PENGAJAR
     * ========================= */

    public function getWithPengajar()
    {
        return $this->select('
                kelas.*,
                program.nama_program,
                users.nama_users AS nama_pengajar,
                users.email_users
            ')
            ->join('program', 'program.id_program = kelas.id_program')
            ->join('users', 'users.id_users = kelas.id_users')
            ->where('kelas.deleted_at', null)
            ->findAll();
    }

    public function getByPengajar($id_pengajar)
    {
        return $this->select('kelas.*, program.nama_program')
            ->join('program', 'program.id_program = kelas.id_program')
            ->where('kelas.id_users', $id_pengajar)
            ->where('kelas.deleted_at', null)
            ->findAll();
    }

    public function getByProgram($id_program)
    {
        return $this->select('kelas.*, program.nama_program')
            ->join('program', 'program.id_program = kelas.id_program')
            ->where('kelas.id_program', $id_program)
            ->where('kelas.deleted_at', null)
            ->findAll();
    }

    public function getWithModulCount()
    {
        return $this->select('
                kelas.*,
                program.nama_program,
                users.nama_users AS nama_pengajar,
                COUNT(DISTINCT modul.id_modul) AS total_modul
            ')
            ->join('program', 'program.id_program = kelas.id_program')
            ->join('users', 'users.id_users = kelas.id_users', 'left')
            ->join(
                'modul',
                'modul.id_kelas = kelas.id_kelas AND modul.deleted_at IS NULL',
                'left'
            )
            ->where('kelas.deleted_at', null)
            ->groupBy('kelas.id_kelas')
            ->findAll();
    }

    public function getDetail($id_kelas)
    {
        return $this->select('
                kelas.*,
                program.nama_program,
                program.deskripsi_program,
                users.nama_users AS nama_pengajar
            ')
            ->join('program', 'program.id_program = kelas.id_program')
            ->join('users', 'users.id_users = kelas.id_users', 'left')
            ->where('kelas.id_kelas', $id_kelas)
            ->where('kelas.deleted_at', null)
            ->first();
    }

    /* =========================
     * PESERTA
     * ========================= */

    // Untuk halaman detail peserta
    public function getForPeserta($id_kelas)
    {
        return $this->select('
                kelas.id_kelas,
                kelas.nama_kelas,
                kelas.deskripsi_kelas,
                kelas.harga,
                kelas.lynk_url,
                program.nama_program,
                users.nama_users AS nama_pengajar
            ')
            ->join('program', 'program.id_program = kelas.id_program')
            ->join('users', 'users.id_users = kelas.id_users')
            ->where('kelas.id_kelas', $id_kelas)
            ->where('kelas.deleted_at', null)
            ->first();
    }
}
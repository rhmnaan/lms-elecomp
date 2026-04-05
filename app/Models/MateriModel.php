<?php

namespace App\Models;

use CodeIgniter\Model;

class MateriModel extends Model
{
    protected $table            = 'materi';
    protected $primaryKey       = 'id_materi';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;

    protected $allowedFields = [
        'id_modul',
        'judul_materi',
        'pre_test',        // ← ganti dari isi_materi
        'file_materi',
        'video_url_materi',
        'post_test',       // ← ganti dari quiz_data
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // ──────────────────────────────────────────────
    //  HELPERS
    // ──────────────────────────────────────────────

    private function resolveTipe(array &$row): void
    {
        if (!empty($row['video_url_materi'])) {
            $row['tipe'] = 'video';
        } elseif (!empty($row['file_materi'])) {
            $row['tipe'] = 'file';
        } else {
            $row['tipe'] = 'artikel';
        }
    }

    private function addTipe(array $results): array
    {
        foreach ($results as &$row) {
            $this->resolveTipe($row);
        }
        return $results;
    }

    // ──────────────────────────────────────────────
    //  QUERIES
    // ──────────────────────────────────────────────

    public function getByModul(int $id_modul): array
    {
        return $this->where('id_modul', $id_modul)
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    public function getWithTipe(int $id_modul = null): array
    {
        $builder = $this->select('*');
        if ($id_modul) {
            $builder->where('id_modul', $id_modul);
        }
        return $this->addTipe($builder->orderBy('created_at', 'ASC')->findAll());
    }

    public function getWithKelasModul(int $id_users): array
    {
        $db = \Config\Database::connect();

        $kelasIds = array_column(
            $db->table('kelas_peserta')
               ->select('id_kelas')
               ->where('id_users', $id_users)
               ->where('deleted_at', null)
               ->get()->getResultArray(),
            'id_kelas'
        );

        if (empty($kelasIds)) {
            return [];
        }

        $results = $this->select('materi.*, modul.id_modul, modul.judul_modul, kelas.id_kelas, kelas.nama_kelas')
                        ->join('modul', 'modul.id_modul = materi.id_modul')
                        ->join('kelas', 'kelas.id_kelas = modul.id_kelas')
                        ->whereIn('modul.id_kelas', $kelasIds)
                        ->orderBy('kelas.id_kelas',     'ASC')
                        ->orderBy('modul.urutan_modul', 'ASC')
                        ->orderBy('materi.created_at',  'ASC')
                        ->findAll();

        return $this->addTipe($results);
    }

    public function getLatest(int $limit = 6, int $id_users = null): array
    {
        $builder = $this->select('materi.*, modul.judul_modul, kelas.nama_kelas')
                        ->join('modul', 'modul.id_modul = materi.id_modul')
                        ->join('kelas', 'kelas.id_kelas = modul.id_kelas');

        if ($id_users) {
            $builder->join('kelas_peserta', 'kelas_peserta.id_kelas = kelas.id_kelas')
                    ->where('kelas_peserta.id_users', $id_users)
                    ->where('kelas_peserta.deleted_at', null);
        }

        return $this->addTipe(
            $builder->orderBy('materi.created_at', 'DESC')->limit($limit)->findAll()
        );
    }

    public function getDetail(int $id_materi): ?array
    {
        $result = $this->select('
                materi.*,
                modul.id_modul,
                modul.judul_modul,
                modul.urutan_modul,
                kelas.id_kelas,
                kelas.nama_kelas,
                users.nama_users AS nama_pengajar
            ')
            ->join('modul', 'modul.id_modul = materi.id_modul')
            ->join('kelas', 'kelas.id_kelas = modul.id_kelas')
            ->join('users', 'users.id_users = kelas.id_users', 'left')
            ->where('materi.id_materi', $id_materi)
            ->first();

        if ($result) {
            $this->resolveTipe($result);
        }

        return $result;
    }

    public function getAdjacent(int $id_materi, int $id_modul): array
    {
        $all = $this->select('id_materi, judul_materi')
                    ->where('id_modul', $id_modul)
                    ->orderBy('created_at', 'ASC')
                    ->findAll();

        $prev = $next = null;
        foreach ($all as $i => $m) {
            if ((int) $m['id_materi'] === $id_materi) {
                $prev = $all[$i - 1] ?? null;
                $next = $all[$i + 1] ?? null;
                break;
            }
        }

        return [$prev, $next];
    }
}
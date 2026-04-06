<?php
// app/Models/MateriQuizResultsModel.php

namespace App\Models;

use CodeIgniter\Model;

class MateriQuizResultsModel extends Model
{
    protected $table         = 'materi_quiz_results';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = [
        'id_materi',
        'id_users',
        'nilai',
        'jumlah_benar',
        'jumlah_salah',
    ];

    protected $useTimestamps = false; // pakai created_at manual
    protected $dateFormat    = 'datetime';

    // Simpan hasil, hanya satu record per user per materi (upsert)
    public function simpan(int $idMateri, int $idUsers, int $nilai, int $benar, int $salah): bool
    {
        $existing = $this->where('id_materi', $idMateri)
                         ->where('id_users',  $idUsers)
                         ->first();

        if ($existing) {
            // Update jika nilai baru lebih tinggi
            if ($nilai > (int) $existing['nilai']) {
                return $this->update($existing['id'], [
                    'nilai'        => $nilai,
                    'jumlah_benar' => $benar,
                    'jumlah_salah' => $salah,
                    'created_at'   => date('Y-m-d H:i:s'),
                ]);
            }
            return true; // tidak perlu update
        }

        return (bool) $this->insert([
            'id_materi'    => $idMateri,
            'id_users'     => $idUsers,
            'nilai'        => $nilai,
            'jumlah_benar' => $benar,
            'jumlah_salah' => $salah,
            'created_at'   => date('Y-m-d H:i:s'),
        ]);
    }

    // Ambil hasil quiz materi milik satu user
    public function getByUser(int $idUsers): array
    {
        return $this->select('materi_quiz_results.*, materi.judul_materi, modul.judul_modul, kelas.nama_kelas')
                    ->join('materi', 'materi.id_materi = materi_quiz_results.id_materi')
                    ->join('modul',  'modul.id_modul   = materi.id_modul')
                    ->join('kelas',  'kelas.id_kelas   = modul.id_kelas')
                    ->where('materi_quiz_results.id_users', $idUsers)
                    ->orderBy('materi_quiz_results.created_at', 'DESC')
                    ->findAll();
    }

    // Cek apakah user sudah mengerjakan quiz materi ini
    public function sudahDikerjakan(int $idMateri, int $idUsers): bool
    {
        return $this->where('id_materi', $idMateri)
                    ->where('id_users',  $idUsers)
                    ->countAllResults() > 0;
    }
}
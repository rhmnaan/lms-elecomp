<?php
// app/Models/MateriQuizResultsModel.php

namespace App\Models;

use CodeIgniter\Model;

class MateriQuizResultsModel extends Model
{
    protected $table         = 'materi_quiz_results';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    
    // UPDATE: Tambahkan jenis_test dan jawaban_peserta
    protected $allowedFields = [
        'id_materi',
        'id_users',
        'jenis_test',
        'nilai',
        'jumlah_benar',
        'jumlah_salah',
        'jawaban_peserta'
    ];

    protected $useTimestamps = false; // pakai created_at manual
    protected $dateFormat    = 'datetime';

    // UPDATE: Tambahkan parameter $jenisTest dan $jawabanPeserta
    public function simpan(int $idMateri, int $idUsers, string $jenisTest, int $nilai, int $benar, int $salah, string $jawabanPeserta = null): bool
    {
        // Cari berdasarkan materi, user, DAN jenis test (pre/post)
        $existing = $this->where('id_materi', $idMateri)
                         ->where('id_users',  $idUsers)
                         ->where('jenis_test', $jenisTest)
                         ->first();

        if ($existing) {
            // Update jika nilai baru lebih tinggi (opsional, tergantung kebijakanmu)
            if ($nilai > (int) $existing['nilai']) {
                return $this->update($existing['id'], [
                    'nilai'           => $nilai,
                    'jumlah_benar'    => $benar,
                    'jumlah_salah'    => $salah,
                    'jawaban_peserta' => $jawabanPeserta,
                    'created_at'      => date('Y-m-d H:i:s'),
                ]);
            }
            return true; // tidak perlu update
        }

        // Insert data baru
        return (bool) $this->insert([
            'id_materi'       => $idMateri,
            'id_users'        => $idUsers,
            'jenis_test'      => $jenisTest,
            'nilai'           => $nilai,
            'jumlah_benar'    => $benar,
            'jumlah_salah'    => $salah,
            'jawaban_peserta' => $jawabanPeserta,
            'created_at'      => date('Y-m-d H:i:s'),
        ]);
    }

    // Ambil hasil quiz materi milik satu user (semua pre dan post)
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

    // UPDATE: Tambahkan pengecekan berdasarkan jenis_test
    public function sudahDikerjakan(int $idMateri, int $idUsers, string $jenisTest): bool
    {
        return $this->where('id_materi', $idMateri)
                    ->where('id_users',  $idUsers)
                    ->where('jenis_test', $jenisTest)
                    ->countAllResults() > 0;
    }
}
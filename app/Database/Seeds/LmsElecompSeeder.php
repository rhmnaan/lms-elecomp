<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LmsElecompSeeder extends Seeder
{
    public function run()
    {
        // Users
        $this->db->table('users')->insertBatch([
            ['id_users' => 2,  'nama_users' => 'Budi Santoso',  'email_users' => 'budi.santoso@elecomp.sch.id',        'password_users' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'role_users' => 'pengajar', 'fingerprint_device' => null, 'action' => null, 'created_at' => '2026-01-02 08:00:00'],
            ['id_users' => 3,  'nama_users' => 'Siti Rahayu',   'email_users' => 'siti.rahayu@elecomp.sch.id',         'password_users' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'role_users' => 'pengajar', 'fingerprint_device' => null, 'action' => null, 'created_at' => '2026-01-02 09:00:00'],
            ['id_users' => 4,  'nama_users' => 'Andi Pratama',  'email_users' => 'andi.pratama@siswa.elecomp.sch.id',  'password_users' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'role_users' => 'peserta',  'fingerprint_device' => null, 'action' => null, 'created_at' => '2026-01-05 07:30:00'],
            ['id_users' => 5,  'nama_users' => 'Dewi Lestari',  'email_users' => 'dewi.lestari@siswa.elecomp.sch.id', 'password_users' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'role_users' => 'peserta',  'fingerprint_device' => null, 'action' => null, 'created_at' => '2026-01-05 07:45:00'],
            ['id_users' => 6,  'nama_users' => 'Fajar Nugroho', 'email_users' => 'fajar.nugroho@siswa.elecomp.sch.id','password_users' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'role_users' => 'peserta',  'fingerprint_device' => null, 'action' => null, 'created_at' => '2026-01-05 08:00:00'],
            ['id_users' => 7,  'nama_users' => 'Rizka Amalia',  'email_users' => 'rizka.amalia@siswa.elecomp.sch.id', 'password_users' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'role_users' => 'peserta',  'fingerprint_device' => null, 'action' => null, 'created_at' => '2026-01-06 08:10:00'],
            ['id_users' => 8,  'nama_users' => 'Hendra Kusuma', 'email_users' => 'hendra.kusuma@siswa.elecomp.sch.id','password_users' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'role_users' => 'peserta',  'fingerprint_device' => null, 'action' => null, 'created_at' => '2026-01-06 08:20:00'],
            ['id_users' => 10, 'nama_users' => 'Budi Hermawan', 'email_users' => 'cukimai@gmail.com',                 'password_users' => '$2y$10$.AX5ZES/P31ToUrQ87oi8.p1u1kydAKW0nwklQYzeqFC4UzE2EzDK', 'role_users' => 'peserta',  'fingerprint_device' => null, 'action' => null, 'created_at' => '2026-03-11 14:07:28'],
            ['id_users' => 13, 'nama_users' => 'Mahmud',        'email_users' => 'cumadi@gmail.com',                  'password_users' => '$2y$10$wVZxyoAUhp7IfmnLDmzTbeZYyvX6xZxh5gmTiJLBMqUvPtpmCV06u', 'role_users' => 'peserta',  'fingerprint_device' => null, 'action' => null, 'created_at' => '2026-03-11 17:17:29'],
            ['id_users' => 15, 'nama_users' => 'Administrator', 'email_users' => 'admin@elecomp.sch.id',              'password_users' => '$2y$10$afrQ5EGxuZhysqxl97ddwutGGmE1rsyY2SHFYUrtxcTPAenoLNZGy', 'role_users' => 'admin',    'fingerprint_device' => 'wcxvzb', 'action' => null, 'created_at' => '2026-03-11 18:33:39'],
        ]);

        // Kelas
        $this->db->table('kelas')->insertBatch([
            ['id_kelas' => 1, 'nama_kelas' => 'Teknik Elektronika Dasar',   'deskripsi_kelas' => 'Kelas pengantar elektronika untuk siswa tingkat X',                 'id_users' => 2, 'created_at' => '2026-01-10 08:00:00'],
            ['id_kelas' => 2, 'nama_kelas' => 'Pemrograman Mikrokontroler', 'deskripsi_kelas' => 'Kelas pemrograman Arduino dan ESP32 untuk siswa tingkat XI',        'id_users' => 2, 'created_at' => '2026-01-10 09:00:00'],
            ['id_kelas' => 3, 'nama_kelas' => 'Instalasi Listrik',          'deskripsi_kelas' => 'Kelas instalasi listrik rumah dan industri untuk siswa tingkat XII', 'id_users' => 3, 'created_at' => '2026-01-11 08:00:00'],
        ]);

        // Kelas Peserta
        $this->db->table('kelas_peserta')->insertBatch([
            ['id_kelas_peserta' => 1, 'id_kelas' => 1, 'id_users' => 4, 'tanggal_daftar_kelas_peserta' => '2026-01-12 08:00:00'],
            ['id_kelas_peserta' => 2, 'id_kelas' => 1, 'id_users' => 5, 'tanggal_daftar_kelas_peserta' => '2026-01-12 08:05:00'],
            ['id_kelas_peserta' => 3, 'id_kelas' => 1, 'id_users' => 6, 'tanggal_daftar_kelas_peserta' => '2026-01-12 08:10:00'],
            ['id_kelas_peserta' => 4, 'id_kelas' => 2, 'id_users' => 4, 'tanggal_daftar_kelas_peserta' => '2026-01-12 08:15:00'],
            ['id_kelas_peserta' => 5, 'id_kelas' => 2, 'id_users' => 7, 'tanggal_daftar_kelas_peserta' => '2026-01-12 08:20:00'],
            ['id_kelas_peserta' => 6, 'id_kelas' => 3, 'id_users' => 7, 'tanggal_daftar_kelas_peserta' => '2026-01-12 08:25:00'],
            ['id_kelas_peserta' => 7, 'id_kelas' => 3, 'id_users' => 8, 'tanggal_daftar_kelas_peserta' => '2026-01-12 08:30:00'],
            ['id_kelas_peserta' => 8, 'id_kelas' => 2, 'id_users' => 8, 'tanggal_daftar_kelas_peserta' => '2026-01-12 08:35:00'],
        ]);

        // Modul
        $this->db->table('modul')->insertBatch([
            ['id_modul' => 1, 'id_kelas' => 1, 'judul_modul' => 'Pengenalan Komponen Elektronika', 'urutan_modul' => 1, 'created_at' => '2026-01-13 08:00:00'],
            ['id_modul' => 2, 'id_kelas' => 1, 'judul_modul' => 'Hukum Ohm dan Kirchhoff',        'urutan_modul' => 2, 'created_at' => '2026-01-13 09:00:00'],
            ['id_modul' => 3, 'id_kelas' => 1, 'judul_modul' => 'Rangkaian Seri dan Paralel',     'urutan_modul' => 3, 'created_at' => '2026-01-13 10:00:00'],
            ['id_modul' => 4, 'id_kelas' => 2, 'judul_modul' => 'Pengenalan Arduino',             'urutan_modul' => 1, 'created_at' => '2026-01-14 08:00:00'],
            ['id_modul' => 5, 'id_kelas' => 2, 'judul_modul' => 'Pemrograman Dasar Arduino',      'urutan_modul' => 2, 'created_at' => '2026-01-14 09:00:00'],
            ['id_modul' => 6, 'id_kelas' => 3, 'judul_modul' => 'Keselamatan Kerja Listrik',      'urutan_modul' => 1, 'created_at' => '2026-01-15 08:00:00'],
            ['id_modul' => 7, 'id_kelas' => 3, 'judul_modul' => 'Instalasi Panel Listrik',        'urutan_modul' => 2, 'created_at' => '2026-01-15 09:00:00'],
        ]);

        // Materi
        $this->db->table('materi')->insertBatch([
            ['id_materi' => 1, 'id_modul' => 1, 'judul_materi' => 'Resistor dan Kapasitor',    'isi_materi' => 'Resistor adalah komponen elektronika yang berfungsi untuk menghambat arus listrik. Kapasitor berfungsi untuk menyimpan muatan listrik sementara.',                     'file_materi' => 'materi/resistor_kapasitor.pdf', 'video_url_materi' => 'https://youtube.com/watch?v=dummy001', 'created_at' => '2026-01-14 08:00:00'],
            ['id_materi' => 2, 'id_modul' => 1, 'judul_materi' => 'Dioda dan Transistor',      'isi_materi' => 'Dioda adalah komponen semikonduktor yang hanya mengalirkan arus satu arah. Transistor dapat berfungsi sebagai saklar atau penguat sinyal.',                            'file_materi' => 'materi/dioda_transistor.pdf',   'video_url_materi' => 'https://youtube.com/watch?v=dummy002', 'created_at' => '2026-01-14 09:00:00'],
            ['id_materi' => 3, 'id_modul' => 2, 'judul_materi' => 'Hukum Ohm',                 'isi_materi' => 'Hukum Ohm menyatakan bahwa arus yang mengalir pada suatu penghantar berbanding lurus dengan tegangan dan berbanding terbalik dengan hambatan: V = I x R.',              'file_materi' => 'materi/hukum_ohm.pdf',          'video_url_materi' => null,                                   'created_at' => '2026-01-15 08:00:00'],
            ['id_materi' => 4, 'id_modul' => 2, 'judul_materi' => 'Hukum Kirchhoff',           'isi_materi' => 'Hukum Kirchhoff terdiri dari KCL (Kirchhoff Current Law) dan KVL (Kirchhoff Voltage Law) yang digunakan untuk menganalisis rangkaian listrik kompleks.',                'file_materi' => 'materi/hukum_kirchhoff.pdf',    'video_url_materi' => 'https://youtube.com/watch?v=dummy003', 'created_at' => '2026-01-15 09:00:00'],
            ['id_materi' => 5, 'id_modul' => 4, 'judul_materi' => 'Apa itu Arduino?',          'isi_materi' => 'Arduino adalah platform elektronik open-source berbasis mikrokontroler yang mudah digunakan untuk membuat proyek elektronika interaktif.',                               'file_materi' => 'materi/pengenalan_arduino.pdf', 'video_url_materi' => 'https://youtube.com/watch?v=dummy004', 'created_at' => '2026-01-16 08:00:00'],
            ['id_materi' => 6, 'id_modul' => 5, 'judul_materi' => 'Struktur Program Arduino',  'isi_materi' => 'Program Arduino terdiri dari dua fungsi utama: setup() yang dijalankan sekali saat awal, dan loop() yang dijalankan berulang terus-menerus.',                           'file_materi' => null,                            'video_url_materi' => 'https://youtube.com/watch?v=dummy005', 'created_at' => '2026-01-17 08:00:00'],
            ['id_materi' => 7, 'id_modul' => 6, 'judul_materi' => 'APD dalam Kelistrikan',     'isi_materi' => 'Alat Pelindung Diri (APD) wajib digunakan saat bekerja dengan instalasi listrik, meliputi sarung tangan isolasi, sepatu safety, dan helm pelindung.',                  'file_materi' => 'materi/apd_listrik.pdf',        'video_url_materi' => null,                                   'created_at' => '2026-01-18 08:00:00'],
        ]);

        // Quiz
        $this->db->table('quiz')->insertBatch([
            ['id_quiz' => 1, 'id_modul' => 1, 'judul_quiz' => 'Quiz Komponen Elektronika',     'deskripsi_quiz' => 'Uji pemahaman tentang komponen dasar elektronika', 'waktu_mulai_quiz' => '2026-02-01 08:00:00', 'waktu_selesai_quiz' => '2026-02-01 09:00:00'],
            ['id_quiz' => 2, 'id_modul' => 2, 'judul_quiz' => 'Quiz Hukum Ohm dan Kirchhoff', 'deskripsi_quiz' => 'Uji pemahaman tentang hukum dasar kelistrikan',     'waktu_mulai_quiz' => '2026-02-08 08:00:00', 'waktu_selesai_quiz' => '2026-02-08 09:00:00'],
            ['id_quiz' => 3, 'id_modul' => 4, 'judul_quiz' => 'Quiz Pengenalan Arduino',      'deskripsi_quiz' => 'Uji pemahaman dasar tentang platform Arduino',      'waktu_mulai_quiz' => '2026-02-10 10:00:00', 'waktu_selesai_quiz' => '2026-02-10 11:00:00'],
        ]);

        // Quiz Questions
        $this->db->table('quiz_questions')->insertBatch([
            ['id_quiz_questions' => 1,  'id_quiz' => 1, 'pertanyaan_quiz_questions' => 'Komponen elektronika yang berfungsi menghambat arus listrik disebut...', 'pilihan_a_quiz_questions' => 'Kapasitor', 'pilihan_b_quiz_questions' => 'Resistor',                       'pilihan_c_quiz_questions' => 'Dioda',                               'pilihan_d_quiz_questions' => 'Transistor',                              'jawaban_benar_quiz_questions' => 'B'],
            ['id_quiz_questions' => 2,  'id_quiz' => 1, 'pertanyaan_quiz_questions' => 'Satuan hambatan listrik adalah...',                                       'pilihan_a_quiz_questions' => 'Ampere',   'pilihan_b_quiz_questions' => 'Volt',                           'pilihan_c_quiz_questions' => 'Ohm',                                 'pilihan_d_quiz_questions' => 'Watt',                                    'jawaban_benar_quiz_questions' => 'C'],
            ['id_quiz_questions' => 3,  'id_quiz' => 1, 'pertanyaan_quiz_questions' => 'Komponen yang hanya mengalirkan arus satu arah adalah...',                'pilihan_a_quiz_questions' => 'Resistor', 'pilihan_b_quiz_questions' => 'Kapasitor',                      'pilihan_c_quiz_questions' => 'Transistor',                           'pilihan_d_quiz_questions' => 'Dioda',                                   'jawaban_benar_quiz_questions' => 'D'],
            ['id_quiz_questions' => 4,  'id_quiz' => 1, 'pertanyaan_quiz_questions' => 'Fungsi utama kapasitor adalah...',                                        'pilihan_a_quiz_questions' => 'Menghambat arus', 'pilihan_b_quiz_questions' => 'Menyimpan muatan listrik',   'pilihan_c_quiz_questions' => 'Memperkuat sinyal',                   'pilihan_d_quiz_questions' => 'Mengubah tegangan',                       'jawaban_benar_quiz_questions' => 'B'],
            ['id_quiz_questions' => 5,  'id_quiz' => 2, 'pertanyaan_quiz_questions' => 'Rumus Hukum Ohm yang benar adalah...',                                    'pilihan_a_quiz_questions' => 'V = I + R', 'pilihan_b_quiz_questions' => 'V = I / R',                     'pilihan_c_quiz_questions' => 'V = I x R',                           'pilihan_d_quiz_questions' => 'V = I - R',                               'jawaban_benar_quiz_questions' => 'C'],
            ['id_quiz_questions' => 6,  'id_quiz' => 2, 'pertanyaan_quiz_questions' => 'KCL (Kirchhoff Current Law) menyatakan bahwa...',                         'pilihan_a_quiz_questions' => 'Jumlah tegangan dalam loop tertutup = 0', 'pilihan_b_quiz_questions' => 'Jumlah arus masuk = Jumlah arus keluar', 'pilihan_c_quiz_questions' => 'Arus berbanding lurus dengan hambatan', 'pilihan_d_quiz_questions' => 'Tegangan berbanding terbalik dengan arus', 'jawaban_benar_quiz_questions' => 'B'],
            ['id_quiz_questions' => 7,  'id_quiz' => 2, 'pertanyaan_quiz_questions' => 'Jika hambatan = 10 Ohm dan tegangan = 5V, maka arus yang mengalir adalah...', 'pilihan_a_quiz_questions' => '50 A', 'pilihan_b_quiz_questions' => '2 A',                          'pilihan_c_quiz_questions' => '0.5 A',                               'pilihan_d_quiz_questions' => '15 A',                                    'jawaban_benar_quiz_questions' => 'C'],
            ['id_quiz_questions' => 8,  'id_quiz' => 3, 'pertanyaan_quiz_questions' => 'Kepanjangan dari IDE pada Arduino IDE adalah...',                         'pilihan_a_quiz_questions' => 'Integrated Development Environment', 'pilihan_b_quiz_questions' => 'Internal Device Engine', 'pilihan_c_quiz_questions' => 'Input Data Engine',               'pilihan_d_quiz_questions' => 'Integrated Data Editor',                  'jawaban_benar_quiz_questions' => 'A'],
            ['id_quiz_questions' => 9,  'id_quiz' => 3, 'pertanyaan_quiz_questions' => 'Fungsi fungsi loop() pada Arduino adalah...',                             'pilihan_a_quiz_questions' => 'Dijalankan sekali saat program mulai', 'pilihan_b_quiz_questions' => 'Dijalankan berulang terus-menerus', 'pilihan_c_quiz_questions' => 'Untuk mendeklarasikan variabel', 'pilihan_d_quiz_questions' => 'Untuk mengakhiri program',               'jawaban_benar_quiz_questions' => 'B'],
            ['id_quiz_questions' => 10, 'id_quiz' => 3, 'pertanyaan_quiz_questions' => 'Pin digital pada Arduino Uno berjumlah...',                               'pilihan_a_quiz_questions' => '6 pin',    'pilihan_b_quiz_questions' => '10 pin',                         'pilihan_c_quiz_questions' => '14 pin',                              'pilihan_d_quiz_questions' => '20 pin',                                  'jawaban_benar_quiz_questions' => 'C'],
        ]);

        // Quiz Results
        $this->db->table('quiz_results')->insertBatch([
            ['id_quiz_results' => 1, 'id_quiz' => 1, 'id_users' => 4, 'jumlah_benar_quiz_results' => 4, 'jumlah_salah_quiz_results' => 0, 'nilai_quiz_results' => 100, 'waktu_selesai_quiz_results' => '2026-02-01 08:45:00'],
            ['id_quiz_results' => 2, 'id_quiz' => 1, 'id_users' => 5, 'jumlah_benar_quiz_results' => 3, 'jumlah_salah_quiz_results' => 1, 'nilai_quiz_results' => 75,  'waktu_selesai_quiz_results' => '2026-02-01 08:50:00'],
            ['id_quiz_results' => 3, 'id_quiz' => 1, 'id_users' => 6, 'jumlah_benar_quiz_results' => 2, 'jumlah_salah_quiz_results' => 2, 'nilai_quiz_results' => 50,  'waktu_selesai_quiz_results' => '2026-02-01 08:55:00'],
            ['id_quiz_results' => 4, 'id_quiz' => 2, 'id_users' => 4, 'jumlah_benar_quiz_results' => 3, 'jumlah_salah_quiz_results' => 0, 'nilai_quiz_results' => 100, 'waktu_selesai_quiz_results' => '2026-02-08 08:40:00'],
            ['id_quiz_results' => 5, 'id_quiz' => 2, 'id_users' => 5, 'jumlah_benar_quiz_results' => 2, 'jumlah_salah_quiz_results' => 1, 'nilai_quiz_results' => 67,  'waktu_selesai_quiz_results' => '2026-02-08 08:50:00'],
            ['id_quiz_results' => 6, 'id_quiz' => 3, 'id_users' => 4, 'jumlah_benar_quiz_results' => 2, 'jumlah_salah_quiz_results' => 1, 'nilai_quiz_results' => 67,  'waktu_selesai_quiz_results' => '2026-02-10 10:35:00'],
            ['id_quiz_results' => 7, 'id_quiz' => 3, 'id_users' => 7, 'jumlah_benar_quiz_results' => 3, 'jumlah_salah_quiz_results' => 0, 'nilai_quiz_results' => 100, 'waktu_selesai_quiz_results' => '2026-02-10 10:40:00'],
            ['id_quiz_results' => 8, 'id_quiz' => 3, 'id_users' => 8, 'jumlah_benar_quiz_results' => 1, 'jumlah_salah_quiz_results' => 2, 'nilai_quiz_results' => 33,  'waktu_selesai_quiz_results' => '2026-02-10 10:55:00'],
        ]);
    }
}
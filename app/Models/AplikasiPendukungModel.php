<?php

namespace App\Models;

use CodeIgniter\Model;

class AplikasiPendukungModel extends Model
{
    protected $table      = 'aplikasi_pendukung';
    protected $primaryKey = 'id_aplikasi';

    protected $allowedFields = [
        'nama_aplikasi',
        'link_aplikasi',
    ];
}
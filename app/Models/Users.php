<?php

namespace App\Models;

use CodeIgniter\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_users';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = true;
    protected $protectFields = true;
    protected $allowedFields = [
        'nama_users',
        'username', 
        'email_users',
        'nomor_hp',            
        'password_users',
        'role_users',
        'fingerprint_device',
        'action',
        'email_verified',
        'verification_token',
        'token_expires_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    protected $validationRules = [
        'nama_users'     => 'required|min_length[3]|max_length[100]',
        'username' => 'permit_empty|min_length[3]|max_length[50]|is_unique[users.username,id_users,{id_users}]',
        'email_users'    => 'required|valid_email|is_unique[users.email_users,id_users,{id_users}]',
        'nomor_hp'       => 'permit_empty|min_length[9]|max_length[15]|is_unique[users.nomor_hp,id_users,{id_users}]', // ← TAMBAHAN
        'password_users' => 'required|min_length[6]',
        'role_users'     => 'required|in_list[admin,pengajar,peserta]',
    ];

    protected $validationMessages = [
        'email_users' => [
            'is_unique' => 'Email sudah terdaftar.',
        ],
        'username' => [
        'is_unique'  => 'Username sudah digunakan.',
        'min_length' => 'Username minimal 3 karakter.',
        ],
        'nomor_hp' => [                                             
            'is_unique'   => 'Nomor HP sudah terdaftar. Gunakan nomor lain.',
            'min_length'  => 'Nomor HP minimal 9 digit.',
            'max_length'  => 'Nomor HP maksimal 15 digit.',
        ],
    ];

    /**
     * Get users by role
     */
    public function getByRole($role)
    {
        return $this->where('role_users', $role)->findAll();
    }

    /**
     * Get pengajar list
     */
    public function getPengajar()
    {
        return $this->where('role_users', 'pengajar')->findAll();
    }

    /**
     * Get peserta list
     */
    public function getPeserta()
    {
        return $this->where('role_users', 'peserta')->findAll();
    }

    /**
     * Verify login
     */
    public function verifyLogin($email, $password)
    {
        $user = $this->where('email_users', $email)->first();

        if ($user && password_verify($password, $user['password_users'])) {
            return $user;
        }

        return null;
    }

    // Tambahkan di bawah method verifyLogin()

    public function countByRole()
    {
        $result = $this->select('role_users, COUNT(*) as total')
            ->groupBy('role_users')
            ->findAll();

        $data = [
            'admin' => 0,
            'pengajar' => 0,
            'peserta' => 0
        ];

        foreach ($result as $row) {
            $data[$row['role_users']] = (int)$row['total'];
        }

        return $data;
    }

    public function getFiltered($role = null, $search = null)
    {
        $builder = $this;

        if ($role) {
            $builder = $builder->where('role_users', $role);
        }

        if ($search) {
            $builder = $builder->groupStart()
                ->like('nama_users', $search)
                ->orLike('email_users', $search)
                ->groupEnd();
        }

        return $builder->findAll();
    }

    public function resetPassword($id)
    {
        return $this->update($id, [
            'password_users' => password_hash('elecomp123', PASSWORD_DEFAULT)
        ]);
    }
}

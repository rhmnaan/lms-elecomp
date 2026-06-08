<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\KelasModel;
use App\Models\MateriModel;
use App\Models\QuizModel;
use App\Models\QuizResultsModel;
use App\Models\Users;

class DashboardAdmin extends BaseController
{
    protected Users $userModel;
    protected KelasModel $kelasModel;
    protected MateriModel $materiModel;
    
    public function __construct()
    {
        $this->userModel = new Users();
        $this->kelasModel = new KelasModel();
        $this->materiModel = new MateriModel();
    }
    
    private function guardAdmin()
    {
        if (session()->get('role') !== 'admin') {
            return redirect()->to('/dashboard');
        }
        return null;
    }
    
    public function beranda()
    {
        if ($r = $this->guardAdmin()) return $r;
        
        $total_peserta = $this->userModel->where('role_users', 'peserta')->countAllResults();
        $total_pengajar = $this->userModel->where('role_users', 'pengajar')->countAllResults();
        $total_kelas = $this->kelasModel->countAllResults();
        $total_materi = $this->materiModel->countAllResults();
        $total_quiz = $this->quizModel->countAllResults();
        
        $distribution = $this->quizResultsModel->getDistribution();
        $leaderboard = $this->quizResultsModel->getLeaderboard();
        $aktivitas_terbaru = $this->quizResultsModel->getWithQuizInfo(null, 6);
        
        return view('Dashboard/Admin/beranda', [
            'total_peserta' => $total_peserta,
            'total_pengajar' => $total_pengajar,
            'total_kelas' => $total_kelas,
            'total_materi' => $total_materi,
            'total_quiz' => $total_quiz,
            'dist_lulus' => $distribution['lulus'],
            'dist_cukup' => $distribution['cukup'],
            'dist_kurang' => $distribution['kurang'],
            'leaderboard' => $leaderboard,
            'aktivitas_terbaru' => $aktivitas_terbaru,
        ]);
    }
    
    public function users()
    {
        if ($r = $this->guardAdmin()) return $r;
        
        $role = $this->request->getGet('role');
        $search = $this->request->getGet('search');
        $counts = $this->userModel->countByRole();
        
        return view('Dashboard/Admin/Pengguna/index', [
            'users' => $this->userModel->getFiltered($role, $search),
            'active_role' => $role,
            'search' => $search,
            'count_all' => array_sum($counts),
            'count_admin' => $counts['admin'],
            'count_pengajar' => $counts['pengajar'],
            'count_peserta' => $counts['peserta'],
        ]);
    }
    
    public function usersStore()
    {
        if ($r = $this->guardAdmin()) return $r;
        
        $rules = [
            'nama_users' => 'required|min_length[3]|max_length[100]',
            'email_users' => 'required|valid_email|is_unique[users.email_users]',
            'password' => 'required|min_length[6]',
            'role_users' => 'required|in_list[admin,pengajar,peserta]',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }
        
        $this->userModel->insert([
            'nama_users' => $this->request->getPost('nama_users'),
            'email_users' => $this->request->getPost('email_users'),
            'password_users' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role_users' => $this->request->getPost('role_users'),
        ]);
        
        return redirect()->to('/dashboard/admin/pengguna')->with('success', 'Pengguna berhasil ditambahkan.');
    }
    
    public function usersUpdate(int $id)
    {
        if ($r = $this->guardAdmin()) return $r;
        
        $rules = [
            'nama_users' => 'required|min_length[3]|max_length[100]',
            'email_users' => "required|valid_email|is_unique[users.email_users,id_users,{$id}]",
            'role_users' => 'required|in_list[admin,pengajar,peserta]',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()
                             ->with('errors', $this->validator->getErrors());
        }
        
        $this->userModel->update($id, [
            'nama_users' => $this->request->getPost('nama_users'),
            'email_users' => $this->request->getPost('email_users'),
            'role_users' => $this->request->getPost('role_users'),
        ]);
        
        return redirect()->to('/dashboard/admin/pengguna')->with('success', 'Pengguna berhasil diperbarui.');
    }
    
    public function usersDelete(int $id)
    {
        if ($r = $this->guardAdmin()) return $r;
        
        if ((int) session()->get('id_users') === $id) {
            return redirect()->to('/dashboard/admin/pengguna')->with('error', 'Tidak dapat menghapus akun sendiri.');
        }
        
        if (!$this->userModel->find($id)) {
            return redirect()->to('/dashboard/admin/pengguna')->with('error', 'Pengguna tidak ditemukan.');
        }
        
        $this->userModel->delete($id);
        
        return redirect()->to('/dashboard/admin/pengguna')->with('success', 'Pengguna berhasil dihapus.');
    }
    
    public function usersReset(int $id)
    {
        if ($r = $this->guardAdmin()) return $r;
        
        $user = $this->userModel->find($id);
        
        if (!$user) {
            return redirect()->to('/dashboard/admin/pengguna')->with('error', 'Pengguna tidak ditemukan.');
        }
        
        $this->userModel->resetPassword($id);
        
        return redirect()->to('/dashboard/admin/pengguna')
                         ->with('success', "Password {$user['nama_users']} berhasil direset ke default.");
    }
}
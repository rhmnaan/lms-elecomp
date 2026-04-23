<?php

namespace App\Controllers;

class TestEmail extends BaseController
{
    public function index()
    {
        $email = \Config\Services::email();
        
        // Ganti dengan email Anda untuk test
        $email->setTo('elecomp.sh@gmail.com');
        $email->setSubject('Test Email Verifikasi LMS Elecomp');
        
        $message = view('emails/verification', [
            'nama' => 'Budi Santoso',
            'link' => base_url('register/verify?token=sample123456789')
        ]);
        
        $email->setMessage($message);
        
        if ($email->send()) {
            echo '<h2 style="color:green;">✅ Email berhasil dikirim!</h2>';
            echo '<p>Cek inbox atau folder spam email Anda.</p>';
        } else {
            echo '<h2 style="color:red;">❌ Email gagal dikirim</h2>';
            echo '<pre>';
            echo $email->printDebugger(['headers']);
            echo '</pre>';
        }
    }
}
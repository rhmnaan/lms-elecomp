<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: #ffffff;
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h2 {
            color: #d32f2f;
            border-bottom: 3px solid #d32f2f;
            padding-bottom: 10px;
        }
        .info-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 12px;
            border-bottom: 1px solid #e0e0e0;
        }
        .info-table td:first-child {
            font-weight: bold;
            width: 40%;
            color: #555;
        }
        .info-table td:last-child {
            color: #333;
        }
        .password-box {
            background-color: #fff3e0;
            padding: 15px;
            border-left: 4px solid #ff9800;
            margin: 20px 0;
            font-family: 'Courier New', monospace;
            font-size: 16px;
            font-weight: bold;
            color: #e65100;
        }
        .warning {
            background-color: #ffebee;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            color: #c62828;
            font-size: 13px;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #999;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🔐 Backup Kredensial Pendaftar Baru</h2>
        
        <p>Halo Admin,</p>
        <p>Pengguna baru telah mendaftar di sistem LMS Elecomp. Berikut adalah detail kredensial untuk backup:</p>

        <table class="info-table">
            <tr>
                <td>Nama Lengkap</td>
                <td><?= esc($nama) ?></td>
            </tr>
            <tr>
                <td>Username</td>
                <td><?= esc($username) ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?= esc($email) ?></td>
            </tr>
            <tr>
                <td>Nomor HP</td>
                <td><?= esc($nomor_hp) ?></td>
            </tr>
            <tr>
                <td>Tanggal Daftar</td>
                <td><?= esc($tanggal) ?></td>
            </tr>
        </table>

        <div class="password-box">
            <strong>Password:</strong> <?= esc($password) ?>
        </div>

        <div class="warning">
            ⚠️ <strong>PERHATIAN:</strong> Email ini berisi informasi sensitif. Harap simpan dengan aman dan jangan dibagikan kepada pihak lain. Segera hapus email ini setelah dicatat jika diperlukan.
        </div>

        <div class="footer">
            <p>Email otomatis dari sistem LMS Elecomp</p>
            <p>&copy; <?= date('Y') ?> LMS Elecomp. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
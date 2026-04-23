<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Gagal — LMS Elecomp</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --blue-deep:  #0A1628;
            --blue-mid:   #0D2656;
            --blue-sky:   #03AADE;
            --danger:     #FF4D6A;
        }
        body {
            font-family: 'DM Sans', sans-serif;
            background: linear-gradient(135deg, var(--blue-deep) 0%, var(--blue-mid) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: white;
            max-width: 480px;
            width: 100%;
            border-radius: 20px;
            padding: 48px 40px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        .icon-wrap {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #FF6B6B, var(--danger));
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 28px;
            box-shadow: 0 12px 30px rgba(255,77,106,0.4);
        }
        .icon-wrap i {
            font-size: 36px;
            color: white;
        }
        h1 {
            font-family: 'Syne', sans-serif;
            font-size: 28px;
            font-weight: 800;
            color: var(--blue-deep);
            margin-bottom: 12px;
        }
        p {
            font-size: 15px;
            color: #6B7A9B;
            line-height: 1.7;
            margin-bottom: 28px;
        }
        .btn {
            display: inline-block;
            padding: 14px 28px;
            background: linear-gradient(135deg, var(--blue-sky), var(--blue-mid));
            color: white;
            text-decoration: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 15px;
            box-shadow: 0 8px 20px rgba(3,170,222,0.35);
            transition: all 0.3s;
            margin: 0 6px;
        }
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(3,170,222,0.45);
        }
        .btn-secondary {
            background: #F4F7FC;
            color: #6B7A9B;
            box-shadow: none;
            border: 1.5px solid #E2E8F5;
        }
        .btn-secondary:hover {
            background: #EEF2FA;
            box-shadow: none;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon-wrap">
            <i class="fas fa-circle-xmark"></i>
        </div>

        <h1>Verifikasi Gagal</h1>

        <p><?= esc($message) ?></p>

        <div>
            <a href="<?= base_url('/register') ?>" class="btn">
                <i class="fas fa-user-plus"></i> Daftar Ulang
            </a>
            <a href="<?= base_url('/login') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Ke Login
            </a>
        </div>
    </div>
</body>
</html>
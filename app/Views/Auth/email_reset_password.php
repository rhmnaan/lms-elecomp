<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password - LMS Elecomp</title>
</head>
<body style="margin:0;padding:0;background:#F0F4FA;font-family:'DM Sans',Arial,sans-serif;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#F0F4FA;padding:40px 20px;">
  <tr>
    <td align="center">
      <table width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 4px 24px rgba(10,22,40,.1);">

        <!-- HEADER -->
        <tr>
          <td style="background:linear-gradient(135deg,#0D2656,#0A1628);padding:36px 40px;text-align:center;">
            <div style="display:inline-block;background:rgba(3,170,222,.2);border:1px solid rgba(3,170,222,.4);border-radius:50%;width:64px;height:64px;line-height:64px;text-align:center;margin-bottom:16px;">
              <span style="font-size:28px;">🔑</span>
            </div>
            <h1 style="margin:0;font-size:22px;font-weight:700;color:#ffffff;letter-spacing:-.02em;">Reset Password</h1>
            <p style="margin:8px 0 0;font-size:14px;color:rgba(255,255,255,.6);">LMS Elecomp — Platform Pembelajaran Digital</p>
          </td>
        </tr>

        <!-- BODY -->
        <tr>
          <td style="padding:36px 40px;">
            <p style="margin:0 0 16px;font-size:15px;color:#374151;">Halo, <strong><?= esc($nama) ?></strong> 👋</p>
            <p style="margin:0 0 20px;font-size:14px;color:#6B7280;line-height:1.6;">
              Kami menerima permintaan untuk mereset password akun LMS Elecomp Anda. Klik tombol di bawah ini untuk membuat password baru.
            </p>

            <!-- CTA Button -->
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td align="center" style="padding:8px 0 24px;">
                  <a href="<?= esc($link) ?>"
                     style="display:inline-block;padding:14px 36px;background:linear-gradient(135deg,#03AADE,#0D2656);color:#ffffff;text-decoration:none;border-radius:12px;font-size:15px;font-weight:700;letter-spacing:.01em;box-shadow:0 8px 20px rgba(3,170,222,.35);">
                    🔐 Buat Password Baru
                  </a>
                </td>
              </tr>
            </table>

            <!-- Expiry notice -->
            <div style="background:#FFF7ED;border:1px solid #FDE68A;border-radius:10px;padding:14px 16px;margin-bottom:20px;">
              <p style="margin:0;font-size:13px;color:#92400E;">
                ⏱️ <strong>Perhatian:</strong> Tautan ini hanya berlaku selama <strong><?= esc($expires) ?></strong> sejak email ini dikirim.
              </p>
            </div>

            <!-- URL fallback -->
            <p style="margin:0 0 8px;font-size:13px;color:#6B7280;">
              Jika tombol tidak berfungsi, salin dan tempelkan URL berikut di browser Anda:
            </p>
            <div style="background:#F4F7FC;border:1px solid #E2E8F5;border-radius:8px;padding:12px 14px;word-break:break-all;">
              <a href="<?= esc($link) ?>" style="font-size:12px;color:#03AADE;text-decoration:none;"><?= esc($link) ?></a>
            </div>
          </td>
        </tr>

        <!-- SECURITY NOTICE -->
        <tr>
          <td style="padding:0 40px 36px;">
            <div style="background:#EFF6FF;border:1px solid #DBEAFE;border-radius:10px;padding:14px 16px;">
              <p style="margin:0;font-size:13px;color:#1E40AF;line-height:1.6;">
                🛡️ <strong>Keamanan Akun:</strong> Jika Anda tidak merasa meminta reset password ini, abaikan email ini dan password Anda tidak akan berubah.
              </p>
            </div>
          </td>
        </tr>

        <!-- FOOTER -->
        <tr>
          <td style="background:#F9FAFB;border-top:1px solid #E5E7EB;padding:24px 40px;text-align:center;">
            <p style="margin:0 0 8px;font-size:12px;color:#9CA3AF;">
              Butuh bantuan? Hubungi kami di
              <a href="https://wa.me/6282245975428" style="color:#03AADE;text-decoration:none;">+62 822-4597-5428</a>
            </p>
            <p style="margin:0;font-size:11px;color:#D1D5DB;">
              © <?= date('Y') ?> LMS Elecomp — Absys Group. Semua hak dilindungi.
            </p>
          </td>
        </tr>

      </table>
    </td>
  </tr>
</table>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Kata Sandi</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="background-color: #ffffff; padding: 30px; border-radius: 10px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="color: #17447e; margin-top: 0;">Halo,</h2>
        <p style="color: #333; line-height: 1.6;">
            Anda menerima email ini karena kami menerima permintaan pengaturan ulang kata sandi untuk akun Anda.
        </p>
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $resetUrl }}" style="background-color: #17447e; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 5px; font-weight: bold; display: inline-block;">
                Atur Ulang Kata Sandi
            </a>
        </div>
        <p style="color: #333; line-height: 1.6;">
            Tautan pengaturan ulang kata sandi ini akan kedaluwarsa dalam 60 menit.
        </p>
        <p style="color: #333; line-height: 1.6;">
            Jika Anda tidak meminta pengaturan ulang kata sandi, tidak ada tindakan lebih lanjut yang diperlukan.
        </p>
        <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
        <p style="color: #999; font-size: 12px; text-align: center;">
            Jika Anda kesulitan mengklik tombol "Atur Ulang Kata Sandi", salin dan tempel URL di bawah ini ke peramban web Anda:<br>
            <a href="{{ $resetUrl }}" style="color: #17447e; word-break: break-all;">{{ $resetUrl }}</a>
        </p>
    </div>
</body>
</html>

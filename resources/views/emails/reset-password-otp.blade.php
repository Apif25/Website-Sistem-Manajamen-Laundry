<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f4f6f9; padding:30px;">

    <div style="
        max-width:600px;
        margin:auto;
        background:white;
        padding:30px;
        border-radius:12px;
        box-shadow:0 2px 10px rgba(0,0,0,.1);
    ">

        <h2 style="margin-top:0;">
            Reset Password
        </h2>

        <p>
            Kami menerima permintaan untuk mereset password akun Anda.
        </p>

        <p>
            Gunakan kode OTP berikut:
        </p>

        <div style="
            text-align:center;
            margin:30px 0;
        ">
            <span style="
                font-size:32px;
                font-weight:bold;
                letter-spacing:8px;
                color:#0d6efd;
            ">
                {{ $otp }}
            </span>
        </div>

        <p>
            Kode OTP berlaku selama <strong>10 menit</strong>.
        </p>

        <p>
            Jika Anda tidak melakukan permintaan ini, abaikan email ini.
        </p>

    </div>

</body>

</html>
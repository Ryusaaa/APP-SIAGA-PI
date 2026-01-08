<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Tamu Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #4CAF50;
            color: #fff;
            padding: 10px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>Permintaan Pertemuan</h1>
        </div>
        <p>Halo, {{ $kemana }}</p>
        <p>Anda menerima sebuah permintaan untuk bertemu dari <strong>{{ $nama }}</strong>.</p>
        <p>Berikut adalah detail permintaan pertemuannya:</p>
        <ul>
            <li><strong>Dia datang dari:</strong> {{ $instansi }}</li>
            <li><strong>Untuk keperluan:</strong> {{ $keperluan }}</li>
        </ul>
        <p>Mohon untuk segera bertemu jika sedang luang, jika sedang tidak luang, mohon berikan konfirmasi lewat satpam.</p>
        <p>Terima kasih,</p>
        <p><strong>SIAGA SYSTEM</strong></p>
        <div class="footer">
            <p>Email ini dikirim secara otomatis. Harap tidak membalas email ini.</p>
        </div>
    </div>
</body>
</html>

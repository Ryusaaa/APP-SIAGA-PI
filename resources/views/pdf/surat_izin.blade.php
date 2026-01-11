<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMK Prakarya Internasional</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 30px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            margin-bottom: 30px;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
        }

        .header-content {
            display: table;
            width: 100%;
        }

        .header img {
            display: table-cell;
            width: 60px;
            height: 60px;
            vertical-align: top;
        }

        .header-text {
            display: table-cell;
            padding-left: 15px;
            vertical-align: middle;
            width: 100%;
        }

        .header-text h1 {
            font-size: 16px;
            margin: 0 0 5px 0;
            font-weight: bold;
        }

        .header-text p {
            font-size: 10px;
            margin: 2px 0;
            line-height: 1.4;
        }

        .content {
            padding: 20px 0;
        }

        .content h2 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 25px;
            text-decoration: underline;
        }

        .content-info {
            margin-bottom: 20px;
            overflow: hidden;
        }

        .info-left, .info-right {
            width: 50%;
            box-sizing: border-box;
        }

        .info-left {
            float: left;
            padding-right: 10px;
        }

        .info-right {
            float: right;
            padding-left: 10px;
        }

        .content-info p {
            margin: 6px 0;
            font-size: 14px;
            line-height: 1.5;
        }

        .clear {
            clear: both;
        }

        .content > p {
            margin: 20px 0;
            text-align: justify;
            line-height: 1.7;
            font-size: 14px;
        }

        .signature {
            margin-top: 35px;
            overflow: hidden;
        }

        .signature-box {
            width: 45%;
            text-align: center;
            font-size: 14px;
        }

        .left-signature {
            float: left;
        }

        .right-signature {
            float: right;
        }

        .signature-space {
            margin-top: 50px;
            margin-bottom: 5px;
        }

        .date-right {
            text-align: right !important;
            width: 100%;
            display: block;
            clear: both;
            margin-top: 10px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 15px;
            border-top: 1px solid #ccc;
        }

        .footer p {
            font-size: 10px;
            margin: 0;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <img src="pi_blue.png" alt="Logo SMK PI">
                <div class="header-text">
                    <h1>Yayasan Pendidikan Teknologi Prakarya Internasional 1952</h1>
                    <p>SMK PRAKARYA INTERNASIONAL [SMK PI]</p>
                    <p>Jalan Inhoftank Nomor 46-146 Pelindung Hewan, Astanaanyar, Bandung 40243, Indonesia</p>
                    <p>Telepon/Faksimile: (022) 520-8637 | website: www.smk-pi.sch.id | e-mail: info@smk-pl.sch.id</p>
                </div>
            </div>
        </div>

        <div class="content">
            <h2>Surat Izin Keluar</h2>

            <div class="content-info">
                <div class="info-left">
                    <p><strong>Nama:</strong> {{ $izin->siswa->nama }}</p>
                    <p><strong>Kelas:</strong> {{ $izin->siswa->kelas }}</p>
                    <p><strong>Alasan:</strong> {{ $izin->alasan }}</p>
                </div>
                <div class="info-right">
                    <p><strong>Mata Pelajaran:</strong> {{ $izin->mapel }}</p>
                    <p><strong>Hari & Tanggal:</strong> {{ strftime('%A, %d/%m/%Y %H:%M', strtotime($izin->created_at)) }}</p>
                </div>
                <div class="clear"></div>
            </div>

            <p>Diizinkan Keluar di jam Pembelajaran dengan alasan {{ $izin->alasan }} demikian siswa/i yang bersangkutan dapat keluar kelas atas izin Guru Mata Pelajaran.</p>

            <div class="signature">
                <div class="signature-box left-signature">
                    <p>Penanggung Jawab</p>
                    <p class="signature-space">___________________</p>
                </div>
                <div class="signature-box right-signature">
                    <p>Kaprog</p>
                    <p class="signature-space">___________________</p>
                </div>
                <div class="clear"></div>
            </div>

            <p class="date-right">Bandung, {{ $izin->created_at->format('d/m/Y') }}</p>
        </div>

        <div class="footer">
            <p>**Mohon surat ini dibawa oleh siswa/i yang bersangkutan dan diberikan kepada guru yang bersangkutan saat siswa/i izin keluar kelas.**</p>
        </div>
    </div>
</body>
</html>

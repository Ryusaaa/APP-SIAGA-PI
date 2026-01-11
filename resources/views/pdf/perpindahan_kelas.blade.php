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
            margin-bottom: 20px;
            border-bottom: 3px solid #000;
            padding-bottom: 10px;
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

        h2 {
            text-align: center;
            font-size: 18px;
            margin-bottom: 25px;
            text-decoration: underline;
        }

        .content-info {
            margin-bottom: 20px;
            overflow: hidden;
        }

        .info-left {
            width: 50%;
            float: left;
            padding-right: 10px;
        }

        .info-right {
            width: 50%;
            float: right;
            padding-left: 10px;
        }

        .content-info p {
            margin: 6px 0;
            font-size: 14px;
            line-height: 1.5;
        }

        .clear { clear: both; }

        .content p {
            margin: 15px 0;
            font-size: 14px;
            text-align: justify;
            line-height: 1.7;
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

        .date-right span {
            float: right;
            font-size: 14px;
        }

        .footer {
            margin-top: 25px;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            text-align: center;
        }

        .footer p {
            font-size: 10px;
            font-style: italic;
            margin: 0;
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

    <h2>Surat Pindah Kampus</h2>

    <div class="content-info">
        <div class="info-left">
            <p><strong>Kelas Tujuan:</strong> {{ $perpindahanKelas->kelas->kelas ?? '-' }} - {{ $perpindahanKelas->kelas->jurusan ?? '-' }}</p>
            <p><strong>Jumlah Siswa:</strong> {{ $perpindahanKelas->jumlah_siswa }} Orang</p>
            <p><strong>Mata Pelajaran:</strong> {{ $perpindahanKelas->mataPelajaran->nama ?? $perpindahanKelas->mapel ?? '-' }}</p>
        </div>
        <div class="info-right">
            <p><strong>Guru Kampus Asal:</strong> {{ $perpindahanKelas->guru_kampus_asal ?? '-' }}</p>
            <p><strong>Guru Kampus Tujuan:</strong> {{ $perpindahanKelas->guru_kampus_tujuan ?? '-' }}</p>
            <p><strong>Hari & Tanggal:</strong> {{ $perpindahanKelas->created_at->format('l, d/m/Y H:i') }}</p>
        </div>
        <div class="clear"></div>
    </div>

    <p>Berdasarkan kebutuhan pembelajaran, siswa-siswa diberikan izin untuk melakukan perpindahan kelas ke kelas yang dituju untuk mengikuti kegiatan pembelajaran pada tanggal dan waktu tersebut di atas.</p>

    <div class="signature">
        <div class="signature-box left-signature">
            <p>Mengetahui</p>
            <p class="signature-space">___________________</p>
        </div>
        <div class="signature-box right-signature">
            <p>Guru Kesiswaan</p>
            <p class="signature-space">___________________</p>
        </div>
        <div class="clear"></div>
    </div>

    <p class="date-right"><span>Bandung, {{ $perpindahanKelas->created_at->format('d/m/Y') }}</span></p>

    <div class="footer">
        <p>**Mohon surat ini dibawa oleh siswa/i yang bersangkutan dan diberikan kepada guru yang bersangkutan saat siswa/i berpindah kelas.**</p>
    </div>

</div>

</body>
</html>

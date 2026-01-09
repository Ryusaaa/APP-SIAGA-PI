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
            padding: 0;
            background-color: #f2f2f2;
        }

        .container {
            width: 100%;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }


        .header {
            margin-bottom: 20px;
            text-align: center;
        }

        .header img {
            width: 60px;
            margin-right: 10px;
            display: inline-block;
            vertical-align: middle;
        }

        .header-text {
            display: inline-block;
            vertical-align: middle;
            text-align: left;
        }

        .header h1 {
            font-size: 16px;
            margin: 0;
        }

        .header p {
            font-size: 10px;
            margin: 0;
        }


        .content {
            padding: 20px;
            margin-bottom: 20px;
        }

        .content p {
            margin-bottom: 5px;
        }

        .signature {
            text-align: center;
        }

        .signature p {
            margin-top: 20px;
            display: inline-block;
            width: 45%;
        }

        .signature .left-signature {
            text-align: left;
            float: left;
        }

        .signature .right-signature {
            text-align: left;
            float: right;
            margin-right: 30px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer p {
            font-size: 10px;
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="pi_blue.png" alt="Logo">
            <div class="header-text">
                <h1>Yayasan Pendidikan Teknologi Prakarya Internasional 1952</h1>
                <p>SMK PRAKARYA INTERNASIONAL [SMK PI]</p>
                <p>Jalan Inhoftank Nomor 46-146 Pelindung</p>
                <p>Hewan, Astanaanyar, Bandung 40243, Indonesia</p>
                <p>Telepon/Faksimile: (022) 520-8637 | website: www.smk-pi.sch.id | e-mail: info@smk-pl.sch.id</p>
            </div>
        </div>

        <div class="content">
            <h2>Surat Pindah Kampus</h2>

            <div class="content-info">
                <div style="width: 50%; float: left;">
                    <p>Kelas Tujuan: {{ $perpindahanKelas->kelas->kelas ?? '-' }} - {{ $perpindahanKelas->kelas->jurusan ?? '-' }}</p>
                    <p>Jumlah Siswa: {{ $perpindahanKelas->jumlah_siswa }} Orang</p>
                    <p>Mata Pelajaran: {{ $perpindahanKelas->mataPelajaran->nama ?? $perpindahanKelas->mapel ?? '-' }}</p>
                </div>
                <div style="width: 50%; float: right;">
                    <p>Guru Kampus Asal: {{ $perpindahanKelas->guru_kampus_asal ?? '-' }}</p>
                    <p>Guru Kampus Tujuan: {{ $perpindahanKelas->guru_kampus_tujuan ?? '-' }}</p>
                    <p>Hari & Tanggal: {{ $perpindahanKelas->created_at->format('l, d/m/Y H:i') }}</p>
                </div>
                <div style="clear: both;"></div>
            </div>

            <p>Berdasarkan kebutuhan pembelajaran, siswa-siswa diberikan izin untuk melakukan perpindahan kelas ke kelas yang dituju untuk mengikuti kegiatan pembelajaran pada tanggal dan waktu tersebut di atas.</p>

            <div class="signature">
                <div class="left-signature">
                    <p>Mengetahui,</p>
                    <p>Guru Mata Pelajaran</p>
                    <p style="margin-top: 50px;">(___________________)</p>
                </div>
                <div class="right-signature">
                    <p>Bandung, {{ $perpindahanKelas->created_at->format('d/m/Y') }}</p>
                    <p>Guru Kesiswaan</p>
                    <p style="margin-top: 50px;">(___________________)</p>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>

        {{-- <div class="footer">
            <p>**Mohon surat ini dibawa oleh siswa/i yang bersangkutan dan diberikan kepada guru yang bersangkutan saat siswa/i izin keluar kelas.**</p>
        </div> --}}
    </div>
</body>
</html>

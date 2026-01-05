<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Terlambat - SMK PI</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; font-size: 12px; padding: 20px; background-color: #fff; }

        .container { width: 100%; margin: 0 auto; background-color: #fff; }

        /* Updated Header Style to Match Others */
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #667eea; padding-bottom: 15px; position: relative; }
        .logo { width: 80px; position: absolute; left: 0; top: 0; }
        .header-text { display: inline-block; width: 100%; padding-left: 90px; } /* Space for logo */
        .school-name { font-size: 18px; font-weight: bold; color: #667eea; margin-bottom: 5px; }
        .subtitle { font-size: 10px; color: #666; line-height: 1.3; }

        .content { padding: 10px 0; margin-bottom: 20px; }
        .doc-title { text-align: center; font-size: 16px; font-weight: bold; text-decoration: underline; margin: 20px 0; }

        .content-info { overflow: hidden; margin-bottom: 20px; border: 1px solid #ddd; padding: 15px; border-radius: 8px; background: #f8f9fa; }
        .content-info p { margin-bottom: 8px; line-height: 1.5; }

        /* Signature Layout Table */
        .signature-table { width: 100%; margin-top: 40px; border-collapse: collapse; }
        .signature-cell { width: 50%; text-align: center; vertical-align: top; }
        .signature-line { margin-top: 60px; border-top: 1px solid #000; width: 80%; margin-left: auto; margin-right: auto; padding-top: 5px;}

        .footer { text-align: center; margin-top: 30px; border-top: 1px solid #ddd; padding-top: 10px; font-size: 10px; color: #666; }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <img src="{{ public_path('pi_blue.png') }}" alt="Logo" class="logo">
            <div class="header-text">
                <div class="school-name">SMK PRAKARYA INTERNASIONAL</div>
                <div class="subtitle">
                    Jl. Inhoftank No. 46-146, Pelindung Hewan, Kec. Astanaanyar, Kota Bandung, Jawa Barat 40243<br>
                    Telp: (022) 5208637 | Email: info@smk-pi.sch.id | Website: www.smk-pi.sch.id
                </div>
            </div>
        </div>

        <div class="content">
            <div class="doc-title">SURAT KETERANGAN TERLAMBAT</div>

            <div class="content-info">
                <div style="width: 50%; float: left;">
                    <p><strong>Nama:</strong> {{ $siswa->siswa->nama }}</p>
                    <p><strong>Kelas:</strong> {{ $siswa->kelas->kelas ?? $siswa->siswa->kelas }} {{ $siswa->jurusan->nama ?? $siswa->siswa->jurusan }}</p>
                    <p><strong>Alasan:</strong> {{ $siswa->alasan }}</p>
                </div>
                <div style="width: 50%; float: right; text-align: right;">
                    <p><strong>Waktu:</strong> {{ strftime('%A, %d/%m/%Y %H:%M', strtotime($siswa->created_at)) }} WIB</p>
                </div>
                <div style="clear: both;"></div>
            </div>

            <p style="text-align: justify; line-height: 1.6; margin-top: 20px;">
                Siswa/i tersebut di atas diizinkan masuk mengikuti jam pembelajaran dengan alasan 
                <strong>{{ $siswa->alasan }}</strong>. Demikian surat ini dibuat agar siswa/i yang 
                bersangkutan dapat masuk kelas atas izin Guru Mata Pelajaran.
            </p>

            <table class="signature-table">
                <tr>
                    <td class="signature-cell">
                        Mengetahui,<br>
                        Guru Mata Pelajaran<br><br><br><br>
                        <div class="signature-line">(..................................)</div>
                    </td>
                    <td class="signature-cell">
                        Bandung, {{ $siswa->created_at->format('d F Y') }}<br>
                        Guru Kesiswaan<br><br><br><br>
                        <div class="signature-line">(..................................)</div>
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>**Mohon surat ini dibawa oleh siswa/i dan diberikan kepada guru yang bersangkutan saat masuk kelas.**</p>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Perpindahan Kelas</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; font-size: 12px; padding: 20px; }

        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #667eea; padding-bottom: 15px; }
        .logo { width: 80px; position: absolute; left: 20px; top: 20px; }
        .school-name { font-size: 18px; font-weight: bold; color: #667eea; margin-bottom: 5px; margin-top: 10px;}
        .subtitle { font-size: 10px; color: #666; line-height: 1.3; }

        .doc-title { text-align: center; font-size: 16px; font-weight: bold; text-decoration: underline; margin: 20px 0; }
        .doc-number { text-align: center; font-size: 11px; margin-bottom: 20px; }

        .content { line-height: 1.8; text-align: justify; }

        .info-box { border: 1px solid #ddd; border-radius: 8px; padding: 15px; margin: 20px 0; background: #f8f9fa; }
        .info-row { display: flex; margin-bottom: 8px; }
        .info-label { width: 180px; font-weight: bold; }
        .info-value { flex: 1; }

        /* Signature Layout Table - Ensures Side by Side */
        .signature-table { width: 100%; margin-top: 40px; border-collapse: collapse; }
        .signature-cell { width: 50%; text-align: center; vertical-align: top; }
        .signature-line { margin-top: 60px; border-top: 1px solid #000; width: 80%; margin-left: auto; margin-right: auto; padding-top: 5px;}

        .footer { margin-top: 30px; font-size: 10px; text-align: center; color: #666; border-top: 1px solid #ddd; padding-top: 10px; }
        .important-note { background: #fff3cd; border-left: 4px solid #ffc107; padding: 10px; margin: 20px 0; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path('pi_blue.png') }}" alt="Logo" class="logo">
        <div class="school-name">SMK PRAKARYA INTERNASIONAL</div>
        <div class="subtitle">
            Jl. Inhoftank No. 46-146, Pelindung Hewan, Kec. Astanaanyar, Kota Bandung, Jawa Barat 40243<br>
            Telp: (022) 5208637 | Email: info@smk-pi.sch.id | Website: www.smk-pi.sch.id
        </div>
    </div>

    <div class="doc-title">SURAT PERPINDAHAN KELAS</div>
    <div class="doc-number">No: {{ str_pad($perpindahanKelas->id, 5, '0', STR_PAD_LEFT) }}/PK/SMK-PI/{{ date('Y') }}</div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini menerangkan bahwa:</p>
    </div>

    <div class="info-box">
        <div class="info-row">
            <div class="info-label">Kelas Tujuan</div>
            <div class="info-value">: {{ $perpindahanKelas->kelas->kelas }} - {{ $perpindahanKelas->jurusan->nama ?? $perpindahanKelas->kelas->jurusan }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Jumlah Siswa</div>
            <div class="info-value">: {{ $perpindahanKelas->jumlah_siswa }} Orang</div>
        </div>
        <div class="info-row">
            <div class="info-label">Mata Pelajaran</div>
            <div class="info-value">: {{ $perpindahanKelas->mataPelajaran->nama ?? $perpindahanKelas->mapel }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Waktu Perpindahan</div>
            <div class="info-value">: {{ $perpindahanKelas->created_at->format('d F Y, H:i') }} WIB</div>
        </div>
    </div>

    <div class="content">
        <p>
            Berdasarkan kebutuhan pembelajaran, siswa-siswa tersebut di atas diberikan izin untuk 
            melakukan perpindahan kelas ke kelas yang dituju untuk mengikuti kegiatan pembelajaran 
            {{ $perpindahanKelas->mataPelajaran->nama ?? $perpindahanKelas->mapel }}. Surat ini berlaku untuk 1 (satu) kali pertemuan pada 
            tanggal tersebut di atas.
        </p>
    </div>

    <div class="important-note">
        <strong>⚠ Catatan Penting:</strong>
        <ul style="margin-left: 20px; margin-top: 5px;">
            <li>Siswa wajib menjaga ketertiban di kelas tujuan</li>
            <li>Guru pengampu bertanggung jawab atas kehadiran siswa</li>
            <li>Setelah selesai, siswa kembali ke kelas masing-masing</li>
        </ul>
    </div>

    <table class="signature-table">
        <tr>
            <td class="signature-cell">
                Mengetahui,<br>
                Guru Mata Pelajaran<br><br><br><br>
                <div class="signature-line">(..................................)</div>
            </td>
            <td class="signature-cell">
                Bandung, {{ $perpindahanKelas->created_at->format('d F Y') }}<br>
                Guru Kesiswaan<br><br><br><br>
                <div class="signature-line">(..................................)</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        <p>
            Dokumen ini dicetak secara otomatis pada {{ now()->format('d/m/Y H:i') }} WIB
        </p>
    </div>
</body>
</html>
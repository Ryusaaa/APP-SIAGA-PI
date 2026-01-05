<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Izin Keluar</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; font-size: 12px; padding: 20px; }

        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #667eea; padding-bottom: 15px; }
        .logo { width: 80px; position: absolute; left: 20px; top: 20px; }
        .school-name { font-size: 18px; font-weight: bold; color: #667eea; margin-bottom: 5px; margin-top: 10px; }
        .subtitle { font-size: 10px; color: #666; line-height: 1.3; }

        .doc-title { text-align: center; font-size: 16px; font-weight: bold; text-decoration: underline; margin: 20px 0; }
        .doc-number { text-align: center; font-size: 11px; margin-bottom: 20px; }

        .content { line-height: 1.8; text-align: justify; }

        .info-box { border: 1px solid #ddd; border-radius: 8px; padding: 15px; margin: 20px 0; background: #f8f9fa; }
        .info-row { display: flex; margin-bottom: 8px; }
        .info-label { width: 150px; font-weight: bold; }
        .info-value { flex: 1; }

        /* Signature Layout Table */
        .signature-table { width: 100%; margin-top: 40px; border-collapse: collapse; }
        .signature-cell { width: 50%; text-align: center; vertical-align: top; }
        .signature-line { margin-top: 60px; border-top: 1px solid #000; width: 80%; margin-left: auto; margin-right: auto; padding-top: 5px; }

        .footer { margin-top: 30px; font-size: 10px; text-align: center; color: #666; border-top: 1px solid #ddd; padding-top: 10px; }
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

    <div class="doc-title">SURAT IZIN KELUAR</div>
    <div class="doc-number">No: {{ str_pad($izin->id, 5, '0', STR_PAD_LEFT) }}/IZIN/SMK-PI/{{ date('Y') }}</div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini menerangkan bahwa:</p>
    </div>

    <div class="info-box">
        <div class="info-row">
            <div class="info-label">Nama</div>
            <div class="info-value">: {{ $izin->siswa->nama }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">NIS</div>
            <div class="info-value">: {{ $izin->siswa->nis }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Kelas</div>
            <div class="info-value">: {{ $izin->kelas->kelas ?? $izin->siswa->kelas }} {{ $izin->jurusan->nama ?? $izin->siswa->jurusan }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Mata Pelajaran</div>
            <div class="info-value">: {{ $izin->mataPelajaran->nama ?? ($izin->mapel ?? '-') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Alasan Izin</div>
            <div class="info-value">: {{ $izin->alasan }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Waktu Keluar</div>
            <div class="info-value">: {{ $izin->created_at->format('d F Y, H:i') }} WIB</div>
        </div>
    </div>

    <div class="content">
        <p>
            Berdasarkan alasan tersebut, siswa yang bersangkutan diberikan izin untuk 
            meninggalkan sekolah selama jam pelajaran berlangsung. Surat ini berlaku 
            untuk 1 (satu) hari pada tanggal tersebut di atas.
        </p>
    </div>

    <table class="signature-table">
        <tr>
            <td class="signature-cell">
                Mengetahui,<br>
                Guru Mata Pelajaran<br><br><br><br>
                <div class="signature-line">(..................................)</div>
            </td>
            <td class="signature-cell">
                Bandung, {{ $izin->created_at->format('d F Y') }}<br>
                Guru Kesiswaan<br><br><br><br>
                <div class="signature-line">(..................................)</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        <p>
            <strong>Catatan:</strong> Siswa wajib kembali ke sekolah dan melapor ke guru piket/kesiswaan<br>
            Dokumen ini dicetak secara otomatis pada {{ now()->format('d/m/Y H:i') }} WIB
        </p>
    </div>
</body>
</html>
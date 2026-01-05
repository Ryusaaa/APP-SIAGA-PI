<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Buku Tamu</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Arial', sans-serif; font-size: 12px; padding: 20px; }
        
        .header { text-align: center; margin-bottom: 20px; border-bottom: 3px solid #667eea; padding-bottom: 15px; }
        .logo { width: 80px; position: absolute; left: 20px; top: 20px; }
        .school-name { font-size: 18px; font-weight: bold; color: #667eea; margin-bottom: 5px; margin-top: 10px; }
        .subtitle { font-size: 10px; color: #666; line-height: 1.3; }

        .doc-title { text-align: center; font-size: 16px; font-weight: bold; text-decoration: underline; margin: 20px 0; }
        .doc-number { text-align: center; font-size: 11px; margin-bottom: 20px; }

        .content-wrapper { display: flex; gap: 20px; }
        .left-section { flex: 1; }
        .right-section { width: 200px; }

        .info-box { border: 1px solid #ddd; border-radius: 8px; padding: 15px; margin: 20px 0; background: #f8f9fa; }
        .info-row { display: flex; margin-bottom: 10px; }
        .info-label { width: 150px; font-weight: bold; }
        .info-value { flex: 1; }

        .photo-box { border: 2px solid #667eea; border-radius: 8px; padding: 10px; text-align: center; background: #f8f9fa; }
        .photo-box img { max-width: 100%; border-radius: 4px; }
        .photo-label { font-weight: bold; margin-bottom: 10px; color: #667eea; }

        /* Signature Layout Table */
        .signature-table { width: 100%; margin-top: 40px; }
        .signature-cell { width: 50%; text-align: center; vertical-align: top; }
        .signature-line { margin-top: 60px; border-top: 1px solid #000; width: 80%; margin-left: auto; margin-right: auto; }

        .footer { margin-top: 30px; font-size: 10px; text-align: center; color: #666; border-top: 1px solid #ddd; padding-top: 10px; }
        .badge { display: inline-block; padding: 3px 8px; border-radius: 4px; background: #667eea; color: white; font-size: 10px; }
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

    <div class="doc-title">BUKU TAMU</div>
    <div class="doc-number">No: {{ str_pad($tamu->id, 5, '0', STR_PAD_LEFT) }}/TAMU/SMK-PI/{{ date('Y') }}</div>

    <div class="content-wrapper">
        <div class="left-section">
            <div class="info-box">
                <div class="info-row">
                    <div class="info-label">Identitas Tamu</div>
                    <div class="info-value">: <span class="badge">{{ strtoupper($tamu->identitas) }}</span></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Nama Lengkap</div>
                    <div class="info-value">: {{ $tamu->nama }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">No. Telepon</div>
                    <div class="info-value">: {{ $tamu->no_telp }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Asal Instansi</div>
                    <div class="info-value">: {{ $tamu->darimana }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tujuan</div>
                    <div class="info-value">: <strong>{{ $tamu->kemana }}</strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Jurusan Tujuan</div>
                    <div class="info-value">: {{ $tamu->jurusan->nama ?? '-' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Keperluan</div>
                    <div class="info-value">: {{ $tamu->keperluan }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Waktu Kunjungan</div>
                    <div class="info-value">: {{ $tamu->created_at->format('d F Y, H:i') }} WIB</div>
                </div>
            </div>
        </div>

        <div class="right-section">
            <div class="photo-box">
                <div class="photo-label">Foto Tamu</div>
                @if($photoData)
                    <img src="{{ $photoData }}" alt="Foto Tamu">
                @else
                    <div style="padding: 40px; background: #e9ecef; border-radius: 4px;">
                        <p style="color: #6c757d;">Tidak ada foto</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <table class="signature-table">
        <tr>
            <td class="signature-cell"></td> <td class="signature-cell">
                Bandung, {{ $tamu->created_at->format('d F Y') }}<br>
                Guru Kesiswaan<br><br><br><br>
                <div class="signature-line">(..................................)</div>
            </td>
        </tr>
    </table>

    <div class="footer">
        <p>
            <strong>Catatan:</strong> Tamu wajib melapor kembali ke pos satpam saat meninggalkan sekolah<br>
            Dokumen ini dicetak secara otomatis pada {{ now()->format('d/m/Y H:i') }} WIB
        </p>
    </div>
</body>
</html>
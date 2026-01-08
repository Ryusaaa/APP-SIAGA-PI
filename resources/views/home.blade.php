<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SMK PI - Sistem Izin Keluar</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-image: url("{{ asset('bg.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }

        .container {
            width: 100%;
            max-width: 900px;
            z-index: 1;
        }

        .header {
            text-align: center;
            margin-bottom: 40px;
            animation: fadeInDown 0.6s ease-out;
        }

        .header img {
            width: 100px;
            margin-bottom: 20px;
        }

        .header h1 {
            color: white;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 10px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        }

        .header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
        }

        .tabs {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            padding: 8px;
            border-radius: 16px;
            animation: fadeIn 0.8s ease-out;
        }

        .tab-button {
            flex: 1;
            padding: 14px 20px;
            background: transparent;
            border: none;
            color: rgba(255, 255, 255, 0.7);
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .tab-button:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .tab-button.active {
            background: white;
            color: #667eea;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .card {
            background: white;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 0.6s ease-out;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .form-control,
        select {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus,
        select:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .select2-container--default .select2-selection--multiple,
        .select2-container--default .select2-selection--single {
            border: 2px solid #e5e7eb !important;
            border-radius: 12px !important;
            padding: 8px !important;
            min-height: 48px !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple,
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #667eea !important;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1) !important;
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 32px;
        }

        .btn {
            flex: 1;
            padding: 14px 24px;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.5);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-secondary {
            background: #f3f4f6;
            color: #6b7280;
        }

        .btn-secondary:hover {
            background: #e5e7eb;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
            animation: fadeIn 0.4s ease-out;
        }

        .loading {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .loading.show {
            display: flex;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 640px) {
            .header h1 {
                font-size: 1.8rem;
            }

            .card {
                padding: 24px;
            }

            .button-group {
                flex-direction: column;
            }

            .tabs {
                flex-direction: column;
            }

            .tab-button {
                width: 100%;
            }
        }

        .success-message {
            background: #10b981;
            color: white;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: none;
            animation: fadeInDown 0.4s ease-out;
        }

        .success-message.show {
            display: block;
        }

        .error-message {
            background: #ef4444;
            color: white;
            padding: 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: none;
            animation: fadeInDown 0.4s ease-out;
        }

        .error-message.show {
            display: block;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }
    </style>
</head>

<body>
    <div class="loading" id="loading">
        <div class="spinner"></div>
    </div>

    <div class="container">
        <div class="header">
            <img src="{{ asset('pi_white.png') }}" alt="Logo SMK PI">
            <h1>SMK Prakarya Internasional</h1>
            <p>Sistem Izin Keluar Kampus</p>
        </div>

        <div class="tabs">
            <button class="tab-button active" onclick="switchTab('izin-keluar')">
                Izin Keluar
            </button>
            <button class="tab-button" onclick="switchTab('pindah-kelas')">
                Pindah Kelas
            </button>
            <button class="tab-button" onclick="switchTab('surat-tamu')">
                Surat Tamu
            </button>
            <button class="tab-button" onclick="switchTab('surat-terlambat')">
                Keterlambatan
            </button>
        </div>

        <div class="card">
            <div id="success-msg" class="success-message"></div>
            <div id="error-msg" class="error-message"></div>

            <!-- Tab Izin Keluar -->
            <div id="izin-keluar" class="tab-content active">
                <h2 style="margin-bottom: 24px; color: #1f2937; font-size: 1.5rem;">Form Izin Keluar</h2>
                <form id="formIzinKeluar">
                    @csrf
                    <div class="form-group">
                        <label for="siswa_id">Nama Siswa</label>
                        <select name="siswa_id[]" id="siswa_id" class="form-control" multiple required>
                            @foreach ($siswas as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jurusan_id">Jurusan <span class="text-danger">*</span></label>
                        <select name="jurusan_id" id="jurusan_id_izin" class="form-control" required>
                            <option value="">Pilih Jurusan</option>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->id }}">{{ $j->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kelas_id">Kelas <span class="text-danger">*</span></label>
                        <select name="kelas_id" id="kelas_id_izin" class="form-control" required>
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->kelas }} - {{ $k->jurusan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="mapel_id">Mata Pelajaran <span class="text-danger">*</span></label>
                        <select name="mapel_id" id="mapel_id" class="form-control" required>
                            <option value="">Pilih Mata Pelajaran</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="nama_guru">Nama Guru (Opsional)</label>
                        <input type="text" name="nama_guru" class="form-control" id="nama_guru" 
                            placeholder="Masukkan nama guru mata pelajaran">
                    </div>

                    <div class="form-group">
                        <label for="alasan">Alasan Keluar</label>
                        <textarea name="alasan" class="form-control" id="alasan" required
                            placeholder="Contoh: Sakit, keperluan keluarga, dll"></textarea>
                    </div>

                    <div class="button-group">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Submit & Export PDF</button>
                    </div>
                </form>
            </div>

            <!-- Tab Pindah Kelas -->
            <div id="pindah-kelas" class="tab-content">
                <h2 style="margin-bottom: 24px; color: #1f2937; font-size: 1.5rem;">Form Perpindahan Kelas</h2>
                <form id="formPindahKelas">
                    @csrf
                    <div class="form-group">
                        <label for="jurusan_id">Jurusan <span class="text-danger">*</span></label>
                        <select name="jurusan_id" id="jurusan_id_pindah" class="form-control" required>
                            <option value="">Pilih Jurusan</option>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->id }}">{{ $j->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kelas_id">Kelas</label>
                        <select name="kelas_id" id="kelas_id_pindah" class="form-control" required>
                            <option value="">Pilih Kelas</option>
                            @foreach ($kelas as $kls)
                                <option value="{{ $kls->id }}">{{ $kls->kelas . ' - ' . $kls->jurusan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mapel_id_pindah">Mata Pelajaran <span class="text-danger">*</span></label>
                        <select name="mapel_id" id="mapel_id_pindah" class="form-control" required>
                            <option value="">Pilih Mata Pelajaran</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="jumlah_siswa">Jumlah Siswa</label>
                        <input type="number" name="jumlah_siswa" class="form-control" id="jumlah_siswa" required min="1"
                            placeholder="Masukkan jumlah siswa">
                    </div>

                    <div class="form-group">
                        <label for="guru_kampus_asal">Guru Kampus Asal (Dari Sini)</label>
                        <input type="text" name="guru_kampus_asal" class="form-control" id="guru_kampus_asal" 
                            placeholder="Nama guru di kampus asal">
                    </div>

                    <div class="form-group">
                        <label for="guru_kampus_tujuan">Guru Kampus Tujuan (Ke Sana)</label>
                        <input type="text" name="guru_kampus_tujuan" class="form-control" id="guru_kampus_tujuan" 
                            placeholder="Nama guru di kampus tujuan">
                    </div>

                    <div class="form-group">
                        <label for="mapel_pindah">Keterangan Tambahan (Opsi)</label>
                        <input type="text" name="mapel" class="form-control" id="mapel_pindah" 
                            placeholder="Contoh: Praktikum PPLG">
                    </div>

                    <div class="button-group">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Submit & Export PDF</button>
                    </div>
                </form>
            </div>

            <!-- Tab Surat Tamu -->
            <div id="surat-tamu" class="tab-content">
                <h2 style="margin-bottom: 24px; color: #1f2937; font-size: 1.5rem;">Form Surat Tamu</h2>
                <form id="formSuratTamu">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="form-control" id="nama" required
                            placeholder="Nama lengkap">
                    </div>
<!-- 
                    <div class="form-group">
                        <label for="identitas">No. Identitas (KTP/SIM)</label>
                        <input type="text" name="identitas" class="form-control" id="identitas" required
                            placeholder="Nomor identitas">
                    </div> -->

                    <div class="form-group">
                        <label for="jurusan_id_tamu">Jurusan Tujuan (Opsi)</label>
                        <select name="jurusan_id" id="jurusan_id_tamu" class="form-control">
                            <option value="">Pilih Jurusan</option>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->id }}">{{ $j->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="no_telp">No. Telepon</label>
                        <input type="tel" name="no_telp" class="form-control" id="no_telp" required
                            placeholder="Nomor telepon yang bisa dihubungi">
                    </div>

                    <div class="form-group">
                        <label for="instansi">instansi</label>
                        <input type="text" name="instansi" class="form-control" id="instansi" required
                            placeholder="Asal instansi/tempat">
                    </div>

                    <div class="form-group">
                        <label for="kemana">Tujuan</label>
                        <select name="kemana" id="kemana" class="form-control" required>
                            <option value="">Pilih Tujuan</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->name }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="keperluan">Keperluan</label>
                        <textarea name="keperluan" class="form-control" id="keperluan" required
                            placeholder="Jelaskan keperluan kunjungan"></textarea>
                    </div>

                    <div class="form-group">
                        <label>Foto Tamu</label>
                        <div style="margin-top: 10px;">
                            <video id="video" width="100%" style="max-width: 400px; border-radius: 12px; display: none;"
                                autoplay></video>
                            <canvas id="canvas" style="display: none;"></canvas>
                            <img id="photo" style="max-width: 400px; width: 100%; border-radius: 12px; display: none;">
                            <input type="hidden" name="captured_photo" id="captured_photo">
                        </div>
                        <div style="margin-top: 12px; display: flex; gap: 10px;">
                            <button type="button" onclick="startCamera()" class="btn btn-secondary"
                                style="flex: 1;">Buka Kamera</button>
                            <button type="button" onclick="capturePhoto()" class="btn btn-secondary" id="capture-btn"
                                style="flex: 1; display: none;">Ambil Foto</button>
                            <button type="button" onclick="retakePhoto()" class="btn btn-secondary" id="retake-btn"
                                style="flex: 1; display: none;">Foto Ulang</button>
                        </div>
                    </div>

                    <div class="button-group">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Submit & Export PDF</button>
                    </div>
                </form>
            </div>

            <!-- Tab Keterlambatan -->
            <div id="surat-terlambat" class="tab-content">
                <h2 style="margin-bottom: 24px; color: #1f2937; font-size: 1.5rem;">Form Keterlambatan</h2>
                <form id="formKeterlambatan">
                    @csrf
                    <div class="form-group">
                        <label for="siswa_id_telat">Nama Siswa</label>
                        <select name="siswa_id" id="siswa_id_telat" class="form-control" required>
                            <option value="">Pilih Siswa</option>
                            @foreach ($siswas as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jurusan_id_telat">Jurusan <span class="text-danger">*</span></label>
                        <select name="jurusan_id" id="jurusan_id_telat" class="form-control" required>
                            <option value="">Pilih Jurusan</option>
                            @foreach($jurusans as $j)
                                <option value="{{ $j->id }}">{{ $j->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="kelas_id_telat">Kelas <span class="text-danger">*</span></label>
                        <select name="kelas_id" id="kelas_id_telat" class="form-control" required>
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}">{{ $k->kelas }} - {{ $k->jurusan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="alasan_telat">Alasan Terlambat</label>
                        <textarea name="alasan" class="form-control" id="alasan_telat" required
                            placeholder="Jelaskan alasan keterlambatan"></textarea>
                    </div>
                    <div class="button-group">
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary">Submit & Export PDF</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>

        // Auto load mapel based on kelas
        function loadMapel(kelasId, targetSelect) {
            if (kelasId) {
                $.get(`/api/mapel-by-kelas/${kelasId}`, function (data) {
                    $(targetSelect).html('<option value="">Pilih Mata Pelajaran</option>');
                    data.forEach(mapel => {
                        $(targetSelect).append(`<option value="${mapel.id}">${mapel.nama}</option>`);
                    });
                });
            }
        }

        $('#kelas_id_izin').on('change', function () {
            loadMapel($(this).val(), '#mapel_id');
        });

        $('#kelas_id_pindah').on('change', function () {
            loadMapel($(this).val(), '#mapel_id_pindah');
        });

        // Initialize Select2
        $(document).ready(function () {
            $('#siswa_id, #siswa_id_telat').select2({
                placeholder: 'Pilih nama siswa',
                allowClear: true
            });

            $('#kelas_id_izin, #kelas_id_pindah, #kelas_id_telat, #jurusan_id_izin, #jurusan_id_pindah, #jurusan_id_telat, #jurusan_id_tamu, #mapel_id, #mapel_id_pindah').select2({
                placeholder: 'Pilih data',
                allowClear: true
            });

            $('#kemana').select2({
                placeholder: 'Pilih tujuan',
                allowClear: true
            });
        });

        // Tab Switching
        function switchTab(tabName) {
            // Hide all tabs
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            // Remove active class from all buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('active');
            });

            // Show selected tab
            document.getElementById(tabName).classList.add('active');

            // Add active class to clicked button
            if (event && event.target) {
                event.target.classList.add('active');
            }
        }

        // Form Izin Keluar
        $('#formIzinKeluar').on('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            $('#loading').addClass('show');

            $.ajax({
                url: '{{ route('keluar-kampus.storeIzinkeluar') }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#loading').removeClass('show');
                    if (response.pdf_files && response.pdf_files.length > 0) {
                        // Open first PDF in new tab
                        window.open(response.pdf_files[0], '_blank');
                        showSuccess('Surat izin berhasil dibuat! PDF akan terbuka di tab baru.');
                        $('#formIzinKeluar')[0].reset();
                        $('#siswa_id').val(null).trigger('change');
                        $('#kelas_id_izin').val(null).trigger('change');
                        $('#jurusan_id_izin').val(null).trigger('change');
                        $('#mapel_id').val(null).trigger('change');
                    }
                },
                error: function (xhr) {
                    $('#loading').removeClass('show');
                    showError('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });

        // Form Pindah Kelas
        $('#formPindahKelas').on('submit', function (e) {
            e.preventDefault();
            $('#loading').addClass('show');

            $.ajax({
                url: '{{ route('keluar-kampus.storePindahkelas') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    $('#loading').removeClass('show');
                    if (response.url) {
                         window.open(response.url, '_blank');
                         showSuccess('Surat perpindahan kelas berhasil dibuat!');
                         $('#formPindahKelas')[0].reset();
                         $('#kelas_id_pindah').trigger('change');
                         $('#jurusan_id_pindah').trigger('change');
                         $('#mapel_id_pindah').trigger('change');
                    }
                },
                error: function (xhr) {
                    $('#loading').removeClass('show');
                    showError('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });

        // Form Keterlambatan
        $('#formKeterlambatan').on('submit', function (e) {
            e.preventDefault();
            $('#loading').addClass('show');

            $.ajax({
                url: '{{ route('terlambat.store') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    $('#loading').removeClass('show');
                    if (response.url) {
                         window.open(response.url, '_blank');
                    }
                    showSuccess('Surat keterangan terlambat berhasil dibuat!');
                    $('#formKeterlambatan')[0].reset();
                    $('#siswa_id_telat').val(null).trigger('change');
                    $('#kelas_id_telat').val(null).trigger('change');
                    $('#jurusan_id_telat').val(null).trigger('change');
                },
                error: function (xhr) {
                    $('#loading').removeClass('show');
                    showError('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });

        // Form Surat Tamu
        $('#formSuratTamu').on('submit', function (e) {
            e.preventDefault();

            if (!$('#captured_photo').val()) {
                showError('Harap ambil foto tamu terlebih dahulu!');
                return;
            }

            $('#loading').addClass('show');

            $.ajax({
                url: '{{ route('keluar-kampus.storeSuratTamu') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    $('#loading').removeClass('show');
                    window.location.href = response.url || '{{ route('home') }}';
                },
                error: function (xhr) {
                    $('#loading').removeClass('show');
                    showError('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });

        // Camera functions
        let stream = null;

        function startCamera() {
            const video = document.getElementById('video');
            navigator.mediaDevices.getUserMedia({
                video: true
            })
                .then(function (s) {
                    stream = s;
                    video.srcObject = stream;
                    video.style.display = 'block';
                    document.getElementById('capture-btn').style.display = 'block';
                    document.getElementById('photo').style.display = 'none';
                })
                .catch(function (err) {
                    showError('Tidak dapat mengakses kamera: ' + err.message);
                });
        }

        function capturePhoto() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const photo = document.getElementById('photo');
            const context = canvas.getContext('2d');

            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            context.drawImage(video, 0, 0);

            const dataURL = canvas.toDataURL('image/jpeg');
            photo.src = dataURL;
            photo.style.display = 'block';
            video.style.display = 'none';

            document.getElementById('captured_photo').value = dataURL;
            document.getElementById('capture-btn').style.display = 'none';
            document.getElementById('retake-btn').style.display = 'block';

            // Stop camera
            if (stream) {
                stream.getTracks().forEach(track => track.stop());
            }
        }

        function retakePhoto() {
            document.getElementById('photo').style.display = 'none';
            document.getElementById('retake-btn').style.display = 'none';
            document.getElementById('captured_photo').value = '';
            startCamera();
        }

        function showSuccess(message) {
            const msg = document.getElementById('success-msg');
            msg.textContent = message;
            msg.classList.add('show');
            setTimeout(() => {
                msg.classList.remove('show');
            }, 5000);
        }

        function showError(message) {
            const msg = document.getElementById('error-msg');
            msg.textContent = message;
            msg.classList.add('show');
            setTimeout(() => {
                msg.classList.remove('show');
            }, 5000);
        }
    </script>
</body>

</html>
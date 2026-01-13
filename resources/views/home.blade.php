<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SMK PI - Sistem Izin Keluar</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet" />

    <style>
        :root {
            --md-sys-color-primary: #0061a4;
            --md-sys-color-on-primary: #ffffff;
            --md-sys-color-primary-container: #d1e4ff;
            --md-sys-color-on-primary-container: #001d36;
            --md-sys-color-surface: #fdfcff;
            --md-sys-color-surface-container: #f0f4f9;
            --md-sys-color-surface-container-high: #ffffff;
            --md-sys-color-outline: #74777f;
            --md-radius-l: 16px;
            --md-radius-xl: 28px;
            --md-radius-full: 100px;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--md-sys-color-surface-container);
            color: #1a1c1e;
            min-height: 100vh;
        }
        .header-section {
            background-color: var(--md-sys-color-surface-container);
            padding: 2rem 1.5rem 4rem;
            text-align: center;
        }
        .logo {
            width: 80px;
            height: auto;
        }
        .school-name {
            font-size: 2.25rem;
            font-weight: 400;
            color: #1a1c1e;
            margin: 0.5rem 0 0;
            letter-spacing: -0.5px;
        }
        .school-subtitle {
            font-size: 1.125rem;
            color: #43474e;
            margin-top: 0.25rem;
        }
        .cards-container {
            max-width: 1200px;
            margin: -3rem auto 0;
            padding: 0 1.5rem 3rem;
            position: relative;
            z-index: 10;
        }
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
        .card-item {
            background: var(--md-sys-color-surface-container-high);
            border-radius: var(--md-radius-l);
            padding: 1.5rem;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.2, 0, 0, 1);
            box-shadow: 0px 1px 3px 1px rgba(0,0,0,0.15), 0px 1px 2px 0px rgba(0,0,0,0.3);
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .card-item:hover {
            background: #fdfdfd;
            box-shadow: 0px 2px 6px 2px rgba(0,0,0,0.15), 0px 1px 2px 0px rgba(0,0,0,0.3);
            transform: scale(1.02);
        }
        .card-icon-wrapper {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background-color: var(--md-sys-color-primary-container);
            color: var(--md-sys-color-on-primary-container);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card-icon {
            font-size: 28px;
        }
        .card-title {
            font-size: 1.15rem;
            font-weight: 500;
            color: #1a1c1e;
            margin: 0;
        }
        .card-subtitle {
            font-size: 0.875rem;
            color: #43474e;
            margin: 0;
        }
        .modal-content-custom {
            background: var(--md-sys-color-surface-container-high);
            border-radius: var(--md-radius-xl);
            border: none;
            box-shadow: 0px 4px 8px 3px rgba(0,0,0,0.15);
            padding: 24px;
            max-height: 90vh;
            overflow-y: auto;
        }
        .form-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #1a1c1e;
            margin-bottom: 0.5rem;
            display: block;
        }
        .form-control {
            border-radius: 12px;
            border: 1px solid var(--md-sys-color-outline);
            padding: 12px 16px;
            background: transparent;
            width: 100%;
        }
        .form-control:focus {
            border-color: var(--md-sys-color-primary);
            border-width: 2px;
            outline: none;
        }
        .btn-primary {
            background-color: var(--md-sys-color-primary);
            color: var(--md-sys-color-on-primary);
            border-radius: var(--md-radius-full);
            padding: 10px 24px;
            font-weight: 500;
            border: none;
            box-shadow: 0px 1px 2px rgba(0,0,0,0.3);
        }
        .btn-primary:hover {
            background-color: #005391;
            box-shadow: 0px 2px 4px rgba(0,0,0,0.3);
        }
        .btn-secondary {
            background: transparent;
            color: var(--md-sys-color-primary);
            border: 1px solid var(--md-sys-color-outline);
            border-radius: var(--md-radius-full);
            padding: 10px 24px;
            font-weight: 500;
        }
        .select2-container--default .select2-selection--single,
        .select2-container--default .select2-selection--multiple {
            border-radius: 12px !important;
            border: 1px solid var(--md-sys-color-outline) !important;
            padding: 8px !important;
            height: auto !important;
            background: transparent;
        }
        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: var(--md-sys-color-primary) !important;
            border-width: 2px !important;
        }
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid var(--md-sys-color-primary);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        #camera-section {
            background: var(--md-sys-color-surface-container);
            border-radius: var(--md-radius-l);
            padding: 1rem;
        }
        #video, #photo {
            border-radius: var(--md-radius-l);
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen">

    <main class="flex-1">

    <!-- Loading Overlay -->
    <div id="loading" class="hidden fixed inset-0 bg-black/30 backdrop-blur-sm z-[100] flex items-center justify-center">
        <div class="bg-white p-6 rounded-2xl shadow-lg">
            <div class="spinner"></div>
        </div>
    </div>

    <!-- Header -->
    <div class="header-section">
        <div class="text-center">
            <img src="{{ asset('pi_blue.png') }}" alt="Logo" class="logo mx-auto">
            <h1 class="school-name">SMK Prakarya Internasional</h1>
            <p class="school-subtitle">Sistem Informasi Agenda</p>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="cards-container">
        <div class="cards-grid">
            <button type="button" class="card-item" data-hs-overlay="#modal-izin-keluar">
                <div class="card-icon-wrapper">
                    <span class="material-symbols-outlined card-icon">exit_to_app</span>
                </div>
                <h3 class="card-title">Izin Keluar</h3>
                <p class="card-subtitle">Buat surat izin keluar kampus</p>
            </button>

            <button type="button" class="card-item" data-hs-overlay="#modal-pindah-kelas">
                <div class="card-icon-wrapper">
                    <span class="material-symbols-outlined card-icon">swap_horiz</span>
                </div>
                <h3 class="card-title">Pindah Kelas</h3>
                <p class="card-subtitle">Ajukan perpindahan kelas sementara</p>
            </button>

            <button type="button" class="card-item" data-hs-overlay="#modal-surat-tamu">
                <div class="card-icon-wrapper">
                    <span class="material-symbols-outlined card-icon">assignment_ind</span>
                </div>
                <h3 class="card-title">Surat Tamu</h3>
                <p class="card-subtitle">Daftarkan tamu yang berkunjung</p>
            </button>

            <button type="button" class="card-item" data-hs-overlay="#modal-terlambat">
                <div class="card-icon-wrapper">
                    <span class="material-symbols-outlined card-icon">schedule</span>
                </div>
                <h3 class="card-title">Keterlambatan</h3>
                <p class="card-subtitle">Laporkan keterlambatan siswa</p>
            </button>
        </div>
    </div>

    <!-- Modal: Izin Keluar -->
    <div id="modal-izin-keluar" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none">
        <div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 ease-out transition-all sm:max-w-4xl sm:w-full m-3 sm:mx-auto flex items-center min-h-screen">
            <div class="modal-content-custom pointer-events-auto w-full">
                <h3 class="mb-6 text-2xl font-medium">Form Izin Keluar</h3>
                <form id="formIzinKeluar" class="space-y-5">
                    @csrf
                    <div>
                        <label class="form-label">Nama Siswa</label>
                        <select name="siswa_id[]" id="siswa_id" class="form-control" multiple required>
                            @foreach ($siswas as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Jurusan <span class="text-red-600">*</span></label>
                            <select name="jurusan_id" id="jurusan_id_izin" class="form-control" required>
                                <option value="">Pilih Jurusan</option>
                                @foreach($jurusans as $j)
                                    <option value="{{ $j->id }}">{{ $j->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Kelas <span class="text-red-600">*</span></label>
                            <select name="kelas_id" id="kelas_id_izin" class="form-control" required>
                                <option value="">Pilih Kelas</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->kelas }} - {{ $k->jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Mata Pelajaran <span class="text-red-600">*</span></label>
                        <select name="mapel_id" id="mapel_id" class="form-control" required>
                            <option value="">Pilih Mata Pelajaran</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Nama Guru (Opsional)</label>
                        <input type="text" name="nama_guru" class="form-control" placeholder="Masukkan nama guru">
                    </div>
                    <div>
                        <label class="form-label">Alasan Keluar</label>
                        <textarea name="alasan" class="form-control min-h-[100px]" required placeholder="Contoh: Sakit, keperluan keluarga..."></textarea>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="reset" class="flex-1 btn-secondary">Reset</button>
                        <button type="submit" class="flex-1 btn-primary">Submit & Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Pindah Kelas -->
    <div id="modal-pindah-kelas" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none">
        <div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 ease-out transition-all sm:max-w-4xl sm:w-full m-3 sm:mx-auto flex items-center min-h-screen">
            <div class="modal-content-custom pointer-events-auto w-full">
                <h3 class="mb-6 text-2xl font-medium">Form Perpindahan Kelas</h3>
                <form id="formPindahKelas" class="space-y-5">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Jurusan <span class="text-red-600">*</span></label>
                            <select name="jurusan_id" id="jurusan_id_pindah" class="form-control" required>
                                <option value="">Pilih Jurusan</option>
                                @foreach($jurusans as $j)
                                    <option value="{{ $j->id }}">{{ $j->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Kelas</label>
                            <select name="kelas_id" id="kelas_id_pindah" class="form-control" required>
                                <option value="">Pilih Kelas</option>
                                @foreach ($kelas as $kls)
                                    <option value="{{ $kls->id }}">{{ $kls->kelas . ' - ' . $kls->jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Mata Pelajaran <span class="text-red-600">*</span></label>
                        <select name="mapel_id" id="mapel_id_pindah" class="form-control" required>
                            <option value="">Pilih Mata Pelajaran</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Jumlah Siswa</label>
                        <input type="number" name="jumlah_siswa" class="form-control" required min="1" placeholder="Masukkan jumlah siswa">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Guru Kampus Asal</label>
                            <input type="text" name="guru_kampus_asal" class="form-control" placeholder="Nama guru asal">
                        </div>
                        <div>
                            <label class="form-label">Guru Kampus Tujuan</label>
                            <input type="text" name="guru_kampus_tujuan" class="form-control" placeholder="Nama guru tujuan">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Keterangan Tambahan (Opsi)</label>
                        <input type="text" name="mapel" class="form-control" placeholder="Contoh: Praktikum PPLG">
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="reset" class="flex-1 btn-secondary">Reset</button>
                        <button type="submit" class="flex-1 btn-primary">Submit & Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Surat Tamu -->
    <div id="modal-surat-tamu" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none">
        <div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 ease-out transition-all sm:max-w-4xl sm:w-full m-3 sm:mx-auto flex items-center min-h-screen">
            <div class="modal-content-custom pointer-events-auto w-full">
                <h3 class="mb-6 text-2xl font-medium">Form Surat Tamu</h3>
                <form id="formSuratTamu" class="space-y-5">
                    @csrf
                    <div id="camera-section" class="flex flex-col items-center mb-6">
                        <video id="video" class="w-full max-w-md hidden" autoplay playsinline></video>
                        <canvas id="canvas" class="hidden"></canvas>
                        <img id="photo" class="w-full max-w-md hidden" alt="Foto Tamu">
                        <div id="cam-placeholder" class="w-full max-w-md h-64 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">
                            <span class="material-symbols-outlined text-6xl">photo_camera</span>
                        </div>
                        <input type="hidden" name="captured_photo" id="captured_photo">
                        <div class="flex gap-3 mt-4">
                            <button type="button" onclick="startCamera()" class="btn-secondary">Buka Kamera</button>
                            <button type="button" onclick="capturePhoto()" id="capture-btn" class="hidden btn-primary">Ambil Foto</button>
                            <button type="button" onclick="retakePhoto()" id="retake-btn" class="hidden btn-secondary">Ulangi</button>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required placeholder="Nama lengkap">
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">No. Telepon</label>
                            <input type="tel" name="no_telp" class="form-control" required placeholder="08...">
                        </div>
                        <div>
                            <label class="form-label">Instansi (opsi)</label>
                            <input type="text" name="instansi" class="form-control" placeholder="Asal instansi">
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Tujuan Menemui</label>
                        <select name="kemana" id="kemana" class="form-control" required>
                            <option value="">Pilih Tujuan</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->name }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Keperluan</label>
                        <textarea name="keperluan" class="form-control min-h-[100px]" required placeholder="Jelaskan keperluan kunjungan"></textarea>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="reset" class="flex-1 btn-secondary">Reset</button>
                        <button type="submit" class="flex-1 btn-primary">Submit & Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal: Keterlambatan -->
    <div id="modal-terlambat" class="hs-overlay hidden size-full fixed top-0 start-0 z-[80] overflow-x-hidden overflow-y-auto pointer-events-none">
        <div class="hs-overlay-open:opacity-100 hs-overlay-open:duration-500 opacity-0 ease-out transition-all sm:max-w-4xl sm:w-full m-3 sm:mx-auto flex items-center min-h-screen">
            <div class="modal-content-custom pointer-events-auto w-full">
                <h3 class="mb-6 text-2xl font-medium">Form Keterlambatan</h3>
                <form id="formKeterlambatan" class="space-y-5">
                    @csrf
                    <div>
                        <label class="form-label">Nama Siswa</label>
                        <select name="siswa_id" id="siswa_id_telat" class="form-control" required>
                            <option value="">Pilih Siswa</option>
                            @foreach ($siswas as $siswa)
                                <option value="{{ $siswa->id }}">{{ $siswa->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Jurusan <span class="text-red-600">*</span></label>
                            <select name="jurusan_id" id="jurusan_id_telat" class="form-control" required>
                                <option value="">Pilih Jurusan</option>
                                @foreach($jurusans as $j)
                                    <option value="{{ $j->id }}">{{ $j->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="form-label">Kelas <span class="text-red-600">*</span></label>
                            <select name="kelas_id" id="kelas_id_telat" class="form-control" required>
                                <option value="">Pilih Kelas</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->kelas }} - {{ $k->jurusan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Alasan Terlambat</label>
                        <textarea name="alasan" class="form-control min-h-[100px]" required placeholder="Jelaskan alasan keterlambatan"></textarea>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="reset" class="flex-1 btn-secondary">Reset</button>
                        <button type="submit" class="flex-1 btn-primary">Submit & Export</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/preline@1.9.0/dist/preline.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function () {
            $('select').select2({ width: '100%' });
        });

        function toggleLoading(show) {
            const loading = document.getElementById('loading');
            if (show) {
                loading.classList.remove('hidden');
            } else {
                loading.classList.add('hidden');
            }
        }

        function loadMapel(kelasId, targetSelect) {
            if (kelasId) {
                $.get(`/api/mapel-by-kelas/${kelasId}`, function (data) {
                    $(targetSelect).html('<option value="">Pilih Mata Pelajaran</option>');
                    data.forEach(mapel => {
                        $(targetSelect).append(`<option value="${mapel.id}">${mapel.nama}</option>`);
                    });
                });
            } else {
                $(targetSelect).html('<option value="">Pilih Mata Pelajaran</option>');
            }
        }

        $('#kelas_id_izin').on('change', function () { loadMapel($(this).val(), '#mapel_id'); });
        $('#kelas_id_pindah').on('change', function () { loadMapel($(this).val(), '#mapel_id_pindah'); });

        $('#formIzinKeluar').on('submit', function (e) {
            e.preventDefault();
            toggleLoading(true);
            const formData = new FormData(this);
            $.ajax({
                url: '{{ route('keluar-kampus.storeIzinkeluar') }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    toggleLoading(false);
                    if (response.pdf_files && response.pdf_files.length > 0) {
                        response.pdf_files.forEach(file => window.open(file, '_blank'));
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Surat izin berhasil dibuat dan di-download!',
                            confirmButtonColor: '#0061a4',
                            confirmButtonText: 'OK'
                        });
                        $('#formIzinKeluar')[0].reset();
                        $('select').val(null).trigger('change');
                    }
                },
                error: function () {
                    toggleLoading(false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan!',
                        text: 'Terjadi kesalahan saat mengirim data.',
                        confirmButtonColor: '#0061a4',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        $('#formPindahKelas').on('submit', function (e) {
            e.preventDefault();
            toggleLoading(true);
            $.ajax({
                url: '{{ route('keluar-kampus.storePindahkelas') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    toggleLoading(false);
                    if (response.url) {
                        window.open(response.url, '_blank');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Surat perpindahan kelas berhasil dibuat!',
                            confirmButtonColor: '#0061a4',
                            confirmButtonText: 'OK'
                        });
                        $('#formPindahKelas')[0].reset();
                        $('select').val(null).trigger('change');
                    }
                },
                error: function () {
                    toggleLoading(false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan!',
                        text: 'Terjadi kesalahan.',
                        confirmButtonColor: '#0061a4',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        $('#formSuratTamu').on('submit', function (e) {
            e.preventDefault();
            if (!$('#captured_photo').val()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian!',
                    text: 'Harap ambil foto tamu terlebih dahulu!',
                    confirmButtonColor: '#0061a4',
                    confirmButtonText: 'OK'
                });
                return;
            }
            toggleLoading(true);
            $.ajax({
                url: '{{ route('keluar-kampus.storeSuratTamu') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    toggleLoading(false);
                    window.location.href = response.url || '{{ route('home') }}';
                },
                error: function () {
                    toggleLoading(false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan!',
                        text: 'Terjadi kesalahan.',
                        confirmButtonColor: '#0061a4',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        $('#formKeterlambatan').on('submit', function (e) {
            e.preventDefault();
            toggleLoading(true);
            $.ajax({
                url: '{{ route('terlambat.store') }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    toggleLoading(false);
                    if (response.url) {
                        window.open(response.url, '_blank');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Surat keterangan terlambat berhasil dibuat!',
                            confirmButtonColor: '#0061a4',
                            confirmButtonText: 'OK'
                        });
                        $('#formKeterlambatan')[0].reset();
                        $('select').val(null).trigger('change');
                    }
                },
                error: function () {
                    toggleLoading(false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan!',
                        text: 'Terjadi kesalahan.',
                        confirmButtonColor: '#0061a4',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });

        let stream = null;
        function startCamera() {
            const video = document.getElementById('video');
            const placeholder = document.getElementById('cam-placeholder');
            placeholder.classList.add('hidden');
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function (s) {
                    stream = s;
                    video.srcObject = stream;
                    video.classList.remove('hidden');
                    document.getElementById('capture-btn').classList.remove('hidden');
                })
                .catch(function (err) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan!',
                        text: 'Tidak dapat mengakses kamera: ' + err.message,
                        confirmButtonColor: '#0061a4',
                        confirmButtonText: 'OK'
                    });
                });
        }

        function capturePhoto() {
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const photo = document.getElementById('photo');
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);
            const dataURL = canvas.toDataURL('image/jpeg');
            photo.src = dataURL;
            photo.classList.remove('hidden');
            video.classList.add('hidden');
            document.getElementById('captured_photo').value = dataURL;
            document.getElementById('capture-btn').classList.add('hidden');
            document.getElementById('retake-btn').classList.remove('hidden');
            if (stream) stream.getTracks().forEach(track => track.stop());
        }

        function retakePhoto() {
            document.getElementById('photo').classList.add('hidden');
            document.getElementById('retake-btn').classList.add('hidden');
            document.getElementById('captured_photo').value = '';
            startCamera();
        }
    </script>
    </main>

    <footer class="py-4">
        <div class="max-w-7xl mx-auto text-center text-sm text-gray-600">
            &copy; {{ date('Y') }} pplg smkpi
        </div>
    </footer>
</body>
</html>
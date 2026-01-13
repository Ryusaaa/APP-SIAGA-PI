@extends('layouts.navadmin')

@section('content')
<div class="container-xxl flex-grow-1">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Data Siswa</h4>
        <div>
            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalImport">
                <i class='bx bx-upload'></i> Import Data
            </button>
            <a href="{{ route('siswa.template') }}" class="btn btn-info">
                <i class='bx bx-download'></i> Download Template
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            
            <div class="row mb-4 g-3">
                <div class="col-md-3 col-sm-12">
                    <label for="filterKelas" class="form-label fw-bold">Filter Kelas:</label>
                    <select id="filterKelas" class="form-select">
                        <option value="">Semua Kelas</option>
                        {{-- Mengambil list kelas unik --}}
                        @foreach($siswa->pluck('kelas')->unique()->sort() as $kls)
                            <option value="{{ $kls }}">{{ $kls }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3 col-sm-12">
                    <label for="filterJurusan" class="form-label fw-bold">Filter Jurusan:</label>
                    <select id="filterJurusan" class="form-select">
                        <option value="">Semua Jurusan</option>
                        {{-- Mengambil list jurusan unik --}}
                        @foreach($siswa->pluck('jurusan')->unique()->sort() as $jrs)
                            <option value="{{ $jrs }}">{{ $jrs }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div id="loadingSpinner" class="text-center py-5">
                <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-muted">Memuat data siswa...</p>
            </div>

            <div class="table-responsive" id="tableContainer" style="display: none;">
                <table class="table table-hover w-100" id="tableSiswa">
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>   <th>Jurusan</th> <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($siswa as $data)
                        <tr>
                            <td><span class="badge bg-label-primary">{{ $data->nis }}</span></td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-sm me-2">
                                        <span class="avatar-initial rounded-circle bg-label-info">
                                            {{ substr($data->nama, 0, 1) }}
                                        </span>
                                    </div>
                                    <span>{{ $data->nama }}</span>
                                </div>
                            </td>
                            <td>{{ $data->kelas }}</td>
                            <td><span class="badge bg-label-success">{{ $data->jurusan }}</span></td>
                            <td>
                                <button class="btn btn-sm btn-icon btn-text-danger rounded-pill" 
                                        onclick="deleteSiswa({{ $data->id }})"
                                        data-bs-toggle="tooltip" title="Hapus">
                                    <i class='bx bx-trash'></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalImport" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info mb-3">
                        <i class='bx bx-info-circle'></i>
                        <strong>Petunjuk:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Download template Excel terlebih dahulu</li>
                            <li>Isi data siswa sesuai format template</li>
                            <li>Upload file yang sudah diisi</li>
                            <li>Format file: .xlsx, .xls, .csv (Max: 2MB)</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilih File Excel <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="file" accept=".xlsx,.xls,.csv" required>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('siswa.template') }}" class="btn btn-sm btn-outline-info">
                            <i class='bx bx-download'></i> Download Template
                        </a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">
                        <i class='bx bx-upload'></i> Import
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // 1. Inisialisasi DataTable
    var table = $('#tableSiswa').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        order: [[1, 'asc']], // Urutkan berdasarkan Nama (Index 1)
        
        // Callback saat render selesai
        initComplete: function(settings, json) {
            // Sembunyikan spinner
            $('#loadingSpinner').hide();
            // Tampilkan tabel dengan efek fade in
            $('#tableContainer').fadeIn(500);
        }
    });

    // 2. Fungsi Filter General (Bisa dipakai untuk Kelas & Jurusan)
    function filterTable(columnIndex, value) {
        if (value) {
            // Gunakan Regex utk pencarian eksak (misal: "X" tidak akan match dengan "XII")
            // ^ = awal string, $ = akhir string
            table.column(columnIndex).search('^' + value + '$', true, false).draw();
        } else {
            // Reset search kolom tersebut
            table.column(columnIndex).search('').draw();
        }
    }

    // Event Listener Filter Kelas (Kolom Index 2)
    $('#filterKelas').on('change', function() {
        filterTable(2, $(this).val());
    });

    // Event Listener Filter Jurusan (Kolom Index 3)
    $('#filterJurusan').on('change', function() {
        filterTable(3, $(this).val());
    });
});

function deleteSiswa(id) {
    Swal.fire({
        title: 'Hapus Siswa?',
        text: "Data siswa akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/siswa/${id}`,
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    Swal.fire('Terhapus!', 'Data siswa berhasil dihapus', 'success')
                        .then(() => location.reload());
                },
                error: function(xhr) {
                    Swal.fire('Gagal!', 'Terjadi kesalahan saat menghapus data.', 'error');
                }
            });
        }
    });
}
</script>
@endpush

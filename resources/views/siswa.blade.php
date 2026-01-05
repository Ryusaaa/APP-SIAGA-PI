@extends('layouts.navadmin')

@section('content')
<div class="container-xxl flex-grow-1">
    <!-- Header -->
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

    <!-- Alert Messages -->
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

    <!-- Card -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tableSiswa">
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Aksi</th>
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

<!-- Modal Import -->
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
    $('#tableSiswa').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        order: [[1, 'asc']]
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
                }
            });
        }
    });
}
</script>
@endpush
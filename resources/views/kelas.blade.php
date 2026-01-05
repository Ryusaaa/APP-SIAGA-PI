@extends('layouts.navadmin')

@section('content')
<div class="container-xxl flex-grow-1">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Data Kelas</h4>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalImport">
            <i class='bx bx-upload'></i> Import Data
        </button>
    </div>

    <!-- Card -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tableKelas">
                    <thead>
                        <tr>
                            <th>Kelas</th>
                            <th>Jurusan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kelas as $data)
                        <tr>
                            <td>
                                <span class="badge bg-label-primary" style="font-size: 1rem;">
                                    {{ $data->kelas }}
                                </span>
                            </td>
                            <td>{{ $data->jurusan }}</td>
                            <td>
                                <button class="btn btn-sm btn-icon btn-text-danger rounded-pill" 
                                        onclick="deleteKelas({{ $data->id }})"
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
                <h5 class="modal-title">Import Data Kelas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('kelas.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info mb-3">
                        <i class='bx bx-info-circle'></i>
                        <strong>Format File:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Kolom 1: Kelas (contoh: X, XI, XII)</li>
                            <li>Kolom 2: Jurusan (contoh: PPLG, TJKT, DKV)</li>
                            <li>Format: .xlsx, .xls, .csv (Max: 2MB)</li>
                        </ul>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pilih File Excel <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" name="file" accept=".xlsx,.xls,.csv" required>
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
    $('#tableKelas').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        }
    });
});

function deleteKelas(id) {
    Swal.fire({
        title: 'Hapus Kelas?',
        text: "Data kelas akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/kelas/${id}`,
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    Swal.fire('Terhapus!', 'Data kelas berhasil dihapus', 'success')
                        .then(() => location.reload());
                }
            });
        }
    });
}
</script>
@endpush
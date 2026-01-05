@extends('layouts.navadmin')

@section('content')
<div class="container-xxl flex-grow-1">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Master Data Jurusan</h4>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalJurusan">
            <i class='bx bx-plus'></i> Tambah Jurusan
        </button>
    </div>

    <!-- Card -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tableJurusan">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Jurusan</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($jurusans as $jurusan)
                        <tr>
                            <td><span class="badge bg-label-primary">{{ $jurusan->kode }}</span></td>
                            <td>{{ $jurusan->nama }}</td>
                            <td>{{ Str::limit($jurusan->deskripsi, 50) }}</td>
                            <td>
                                @if($jurusan->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill" 
                                        onclick="editJurusan({{ $jurusan->id }})"
                                        data-bs-toggle="tooltip" title="Edit">
                                    <i class='bx bx-edit'></i>
                                </button>
                                <button class="btn btn-sm btn-icon btn-text-danger rounded-pill" 
                                        onclick="deleteJurusan({{ $jurusan->id }})"
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

<!-- Modal -->
<div class="modal fade" id="modalJurusan" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Jurusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formJurusan">
                <div class="modal-body">
                    <input type="hidden" id="jurusan_id" name="id">
                    
                    <div class="mb-3">
                        <label class="form-label">Kode Jurusan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="kode" id="kode" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Jurusan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama" id="nama" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#tableJurusan').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        }
    });

    // Form Submit
    $('#formJurusan').on('submit', function(e) {
        e.preventDefault();
        const id = $('#jurusan_id').val();
        const url = id ? `/admin/master/jurusan/${id}` : '{{ route("master.jurusan.store") }}';
        const method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: $(this).serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                $('#modalJurusan').modal('hide');
                Swal.fire('Berhasil!', response.message, 'success')
                    .then(() => location.reload());
            },
            error: function(xhr) {
                Swal.fire('Error!', 'Terjadi kesalahan', 'error');
            }
        });
    });

    // Reset form when modal hidden
    $('#modalJurusan').on('hidden.bs.modal', function() {
        $('#formJurusan')[0].reset();
        $('#jurusan_id').val('');
        $('#modalTitle').text('Tambah Jurusan');
    });
});

function editJurusan(id) {
    // Fetch data and populate form
    $.get(`/admin/master/jurusan/${id}`, function(data) {
        $('#jurusan_id').val(data.id);
        $('#kode').val(data.kode);
        $('#nama').val(data.nama);
        $('#deskripsi').val(data.deskripsi);
        $('#modalTitle').text('Edit Jurusan');
        $('#modalJurusan').modal('show');
    });
}

function deleteJurusan(id) {
    Swal.fire({
        title: 'Hapus Jurusan?',
        text: "Data ini akan dihapus permanen!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/master/jurusan/${id}`,
                method: 'DELETE',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    Swal.fire('Terhapus!', response.message, 'success')
                        .then(() => location.reload());
                }
            });
        }
    });
}
</script>
@endpush
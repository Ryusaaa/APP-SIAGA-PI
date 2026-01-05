@extends('layouts.navadmin')

@section('content')
<div class="container-xxl flex-grow-1">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Master Data Mata Pelajaran</h4>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalMapel">
            <i class='bx bx-plus'></i> Tambah Mata Pelajaran
        </button>
    </div>

    <!-- Card -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tableMapel">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Mata Pelajaran</th>
                            <th>Jurusan</th>
                            <th>Jam Pelajaran</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mapels as $mapel)
                        <tr>
                            <td><span class="badge bg-label-info">{{ $mapel->kode }}</span></td>
                            <td>{{ $mapel->nama }}</td>
                            <td>
                                @if($mapel->jurusan)
                                    <span class="badge bg-label-primary">{{ $mapel->jurusan->nama }}</span>
                                @else
                                    <span class="text-muted">Umum</span>
                                @endif
                            </td>
                            <td>{{ $mapel->jam_pelajaran }} JP</td>
                            <td>
                                @if($mapel->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill" 
                                        onclick="editMapel({{ $mapel }})"
                                        data-bs-toggle="tooltip" title="Edit">
                                    <i class='bx bx-edit'></i>
                                </button>
                                <button class="btn btn-sm btn-icon btn-text-danger rounded-pill" 
                                        onclick="deleteMapel({{ $mapel->id }})"
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
<div class="modal fade" id="modalMapel" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Tambah Mata Pelajaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="formMapel">
                <div class="modal-body">
                    <input type="hidden" id="mapel_id" name="id">
                    
                    <div class="mb-3">
                        <label class="form-label">Kode Mapel <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="kode" id="kode" required>
                        <small class="text-muted">Contoh: MTK, IPA, B.IND</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="nama" id="nama" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Jurusan</label>
                        <select class="form-select" name="jurusan_id" id="jurusan_id">
                            <option value="">Umum (Semua Jurusan)</option>
                            @foreach($jurusans as $jurusan)
                                <option value="{{ $jurusan->id }}">{{ $jurusan->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Jam Pelajaran <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="jam_pelajaran" id="jam_pelajaran" 
                               min="1" max="10" value="2" required>
                        <small class="text-muted">Dalam satuan jam pelajaran (JP)</small>
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
    $('#tableMapel').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        }
    });

    // Form Submit
    $('#formMapel').on('submit', function(e) {
        e.preventDefault();
        const id = $('#mapel_id').val();
        const url = id ? `/admin/master/mapel/${id}` : '{{ route("master.mapel.store") }}';
        const method = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            method: method,
            data: $(this).serialize(),
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            success: function(response) {
                $('#modalMapel').modal('hide');
                Swal.fire('Berhasil!', response.message, 'success')
                    .then(() => location.reload());
            },
            error: function(xhr) {
                let errors = xhr.responseJSON.errors;
                let errorMsg = Object.values(errors).flat().join('\n');
                Swal.fire('Error!', errorMsg, 'error');
            }
        });
    });

    // Reset form when modal hidden
    $('#modalMapel').on('hidden.bs.modal', function() {
        $('#formMapel')[0].reset();
        $('#mapel_id').val('');
        $('#modalTitle').text('Tambah Mata Pelajaran');
    });
});

function editMapel(mapel) {
    $('#mapel_id').val(mapel.id);
    $('#kode').val(mapel.kode);
    $('#nama').val(mapel.nama);
    $('#jurusan_id').val(mapel.jurusan_id || '');
    $('#jam_pelajaran').val(mapel.jam_pelajaran);
    $('#modalTitle').text('Edit Mata Pelajaran');
    $('#modalMapel').modal('show');
}

function deleteMapel(id) {
    Swal.fire({
        title: 'Hapus Mata Pelajaran?',
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
                url: `/admin/master/mapel/${id}`,
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
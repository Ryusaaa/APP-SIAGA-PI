@extends('layouts.navadmin')

@section('content')
<div class="container-xxl flex-grow-1">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-primary">
                                    <i class='bx bx-user-check fs-4'></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Total Izin</h6>
                            <h3 class="mb-0">{{ $stats['total'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-success">
                                    <i class='bx bx-check-circle fs-4'></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Sudah Kembali</h6>
                            <h3 class="mb-0">{{ $stats['kembali'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-warning">
                                    <i class='bx bx-time fs-4'></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Belum Kembali</h6>
                            <h3 class="mb-0">{{ $stats['belum_kembali'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="avatar">
                                <span class="avatar-initial rounded bg-label-info">
                                    <i class='bx bx-hourglass fs-4'></i>
                                </span>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="mb-0">Rata-rata Durasi</h6>
                            <h3 class="mb-0">{{ number_format($stats['rata_durasi'], 0) }} mnt</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter & Table -->
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tracking Keluar Masuk Siswa</h5>
            <div class="btn-group">
                <a href="?interval=day" class="btn btn-sm {{ $interval == 'day' ? 'btn-primary' : 'btn-outline-primary' }}">Hari Ini</a>
                <a href="?interval=week" class="btn btn-sm {{ $interval == 'week' ? 'btn-primary' : 'btn-outline-primary' }}">Minggu Ini</a>
                <a href="?interval=month" class="btn btn-sm {{ $interval == 'month' ? 'btn-primary' : 'btn-outline-primary' }}">Bulan Ini</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover" id="tableTracking">
                    <thead>
                        <tr>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Alasan</th>
                            <th>Waktu Keluar</th>
                            <th>Waktu Kembali</th>
                            <th>Durasi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trackings as $tracking)
                        <tr>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-medium">{{ $tracking->siswa->nama }}</span>
                                    <small class="text-muted">{{ $tracking->siswa->nis }}</small>
                                </div>
                            </td>
                            <td>{{ $tracking->siswa->kelas }} {{ $tracking->siswa->jurusan }}</td>
                            <td>{{ Str::limit($tracking->izin->alasan, 30) }}</td>
                            <td>{{ $tracking->waktu_keluar->format('d/m/Y H:i') }}</td>
                            <td>
                                @if($tracking->waktu_kembali)
                                    {{ $tracking->waktu_kembali->format('d/m/Y H:i') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($tracking->durasi_menit)
                                    {{ $tracking->durasi_menit }} menit
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                @if($tracking->waktu_kembali)
                                    <span class="badge bg-success">Kembali</span>
                                @else
                                    <span class="badge bg-warning">Di Luar</span>
                                @endif
                            </td>
                            <td>
                                @if(!$tracking->waktu_kembali)
                                    <button class="btn btn-sm btn-primary" onclick="markKembali({{ $tracking->id }})">
                                        <i class='bx bx-check'></i> Kembali
                                    </button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#tableTracking').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json'
        },
        order: [[3, 'desc']]
    });
});

function markKembali(id) {
    Swal.fire({
        title: 'Konfirmasi Kembali',
        html: `<textarea id="catatan" class="swal2-input" placeholder="Catatan (opsional)"></textarea>`,
        showCancelButton: true,
        confirmButtonText: 'Konfirmasi',
        cancelButtonText: 'Batal',
        preConfirm: () => {
            return document.getElementById('catatan').value;
        }
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/admin/tracking/${id}/kembali`,
                method: 'POST',
                data: {
                    catatan: result.value,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire('Berhasil!', response.message, 'success')
                        .then(() => location.reload());
                }
            });
        }
    });
}
</script>
@endpush
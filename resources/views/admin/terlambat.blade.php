@extends('layouts.navadmin')

@section('content')
    <div class="p-3 mx-4 card">
        <form method="GET" action="{{ route('filter.terlambat') }}" class="flex justify-between mb-3">
            <div class="flex gap-2">
                <select name="jurusan_id" class="rounded-md">
                    <option value="">Semua Jurusan</option>
                    @foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" @if(request('jurusan_id') == $jurusan->id) selected @endif>
                            {{ $jurusan->nama }}
                        </option>
                    @endforeach
                </select>
                <select name="interval" class="rounded-md">
                    <option value="day" @if ($interval == 'day') selected @endif>Hari Ini</option>
                    <option value="week" @if ($interval == 'week') selected @endif>Minggu Ini</option>
                    <option value="month" @if ($interval == 'month') selected @endif>Bulan Ini</option>
                    <li>
                        <hr class="">
                    </li>
                    <option value="yesterday" @if ($interval == 'yesterday') selected @endif>Kemarin</option>
                    <option value="lastWeek" @if ($interval == 'lastWeek') selected @endif>Minggu Kemarin</option>
                    <option value="lastMonth" @if ($interval == 'lastMonth') selected @endif>Bulan Kemarin</option>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <option value="all" @if ($interval == 'all') selected @endif>Semua</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white font-bold">Filter</button>
            </div>

            <button type="submit" name="export" value="excel" class="p-2 bg-green-500 rounded-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" class="" viewBox="0 0 32 32 ">
                    <defs>
                        <linearGradient id="vscodeIconsFileTypeExcel0" x1="4.494" x2="13.832" y1="-2092.086"
                            y2="-2075.914" gradientTransform="translate(0 2100)" gradientUnits="userSpaceOnUse">
                            <stop offset="0" stop-color="#18884f" />
                            <stop offset=".5" stop-color="#117e43" />
                            <stop offset="1" stop-color="#0b6631" />
                        </linearGradient>
                    </defs>
                    <path fill="#185c37"
                        d="M19.581 15.35L8.512 13.4v14.409A1.19 1.19 0 0 0 9.705 29h19.1A1.19 1.19 0 0 0 30 27.809V22.5Z" />
                    <path fill="#21a366"
                        d="M19.581 3H9.705a1.19 1.19 0 0 0-1.193 1.191V9.5L19.581 16l5.861 1.95L30 16V9.5Z" />
                    <path fill="#107c41" d="M8.512 9.5h11.069V16H8.512Z" />
                    <path d="M16.434 8.2H8.512v16.25h7.922a1.2 1.2 0 0 0 1.194-1.191V9.391A1.2 1.2 0 0 0 16.434 8.2"
                        opacity="0.1" />
                    <path d="M15.783 8.85H8.512V25.1h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191"
                        opacity="0.2" />
                    <path d="M15.783 8.85H8.512V23.8h7.271a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191"
                        opacity="0.2" />
                    <path d="M15.132 8.85h-6.62V23.8h6.62a1.2 1.2 0 0 0 1.194-1.191V10.041a1.2 1.2 0 0 0-1.194-1.191"
                        opacity="0.2" />
                    <path fill="url(#vscodeIconsFileTypeExcel0)"
                        d="M3.194 8.85h11.938a1.193 1.193 0 0 1 1.194 1.191v11.918a1.193 1.193 0 0 1-1.194 1.191H3.194A1.19 1.19 0 0 1 2 21.959V10.041A1.19 1.19 0 0 1 3.194 8.85" />
                    <path fill="#fff"
                        d="m5.7 19.873l2.511-3.884l-2.3-3.862h1.847L9.013 14.6c.116.234.2.408.238.524h.017q.123-.281.26-.546l1.342-2.447h1.7l-2.359 3.84l2.419 3.905h-1.809l-1.45-2.711A2.4 2.4 0 0 1 9.2 16.8h-.024a1.7 1.7 0 0 1-.168.351l-1.493 2.722Z" />
                    <path fill="#33c481" d="M28.806 3h-9.225v6.5H30V4.191A1.19 1.19 0 0 0 28.806 3" />
                    <path fill="#107c41" d="M19.581 16H30v6.5H19.581Z" />
                </svg></button>
        </form>
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>NIS</td>
                    <td>Nama</td>
                    <td>Kelas</td>
                    <td>Alasan</td>
                    <td>Waktu</td>
                    <td></td>
                </tr>
            </thead>
            <tbody>
                @forelse ($terlambats as $terlambat)
                    <tr>
                        <td>{{ $terlambat->siswa->nis }}</td>
                        <td>{{ $terlambat->siswa->nama }}</td>
                        <td>{{ $terlambat->siswa->kelas . ' - ' . $terlambat->siswa->jurusan }}</td>
                        <td>{{ $terlambat->alasan }}</td>
                        <td>
                            {{ $terlambat->created_at->locale('id')->translatedFormat('d F Y') .
                                ' / ' .
                                $terlambat->created_at->format('H:i T') }}
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="p-0 btn dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <form action="{{ route('data.lateDelete', $terlambat->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item">
                                            <i class="bx bx-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    {{-- <div class="mx-auto pb-3">
                        Tidak Ada Siswa Yang Terlambat Hari Ini
                    </div> --}}
                @endforelse
            </tbody>
        </table>
    </div>
@endsection

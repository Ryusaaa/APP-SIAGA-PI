<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Mapel;
use App\Models\Izin;
use App\Models\Kelas;
use App\Models\PerpindahanKelas;
use App\Models\Siswa;
use Illuminate\Http\Request;

class DashboardUserController extends Controller
{
    public function index(Request $request)
    {
        $izins = Izin::latest()->with('siswa')->get();
        $perpindahanKelas = PerpindahanKelas::all();
        $kelas = Kelas::all();
        $siswas = Siswa::all();
        $jurusans = Jurusan::where('is_active', true)->get();
        $mapels = Mapel::where('is_active', true)->get();

        return view('home', compact('izins', 'siswas', 'perpindahanKelas', 'kelas', 'jurusans', 'mapels'));
    }
}

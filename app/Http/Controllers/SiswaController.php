<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\SiswaImport;
use App\Exports\SiswaTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Siswa;
use App\Models\Kelas;
class SiswaController extends Controller
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function index()
    {
        $siswa = Siswa::get();
        $kelas = Kelas::get();

        return view('siswa', compact('siswa', 'kelas'));
    }

    // Belum Beres
    public function createSiswa(Request $request) {
        $request->validate([
                'nis' => 'required',
                'nama' => 'required',
                'kelas' => 'required',
                'jurusan' => 'required',
            ]);

        Siswa::create([
            'nis' => $request->nis,
            'nama' => $request->nama,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
        ]);

        return redirect()->back();
    }

    public function deleteKelas($id) {
        Kelas::find($id)->delete();

        return redirect()->back();
    }

    public function delete($id) {
        Siswa::find($id)->delete();

        return redirect()->back();
    }

    /**
    * @return \Illuminate\Support\Collection
    */

    /**
    * @return \Illuminate\Support\Collection
    */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ]);

        try {
            Excel::import(new SiswaImport, $request->file('file'));
            return back()->with('success', 'Data berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengimpor data: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new SiswaTemplateExport, 'template_siswa.xlsx');
    }
    
}

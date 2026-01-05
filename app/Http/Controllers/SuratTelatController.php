<?php

namespace App\Http\Controllers;

use App\Models\siswa;
use App\Models\SuratTerlambat;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PDF;

class SuratTelatController extends Controller
{
    public function index()
    {
        $siswa = siswa::get();

        return view('terlambat', compact('siswa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'kelas_id' => 'required|exists:kelas,id',
            'jurusan_id' => 'required|exists:jurusans,id',
            'alasan' => 'nullable',
        ]);

        $now = Carbon::now();

        $siswa = SuratTerlambat::create([
            'siswa_id' => $request->siswa_id,
            'kelas_id' => $request->kelas_id,
            'jurusan_id' => $request->jurusan_id,
            'jamMasuk' => $now,
            'alasan' => $request->alasan,
        ]);

        $pdf = PDF::loadView('pdf.surat_terlambat', compact('siswa'));
        $filename = 'suratterlambat-' . $siswa->siswa_id . '.pdf';

        // Ensure the directory exists
        $directory = public_path('pdf');
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Save the PDF file
        $pdf->save($directory . '/' . $filename);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'url' => route('showPdf', ['filename' => $filename]),
                'message' => 'Surat keterangan terlambat berhasil dibuat'
            ]);
        }

        return redirect()->route('showPdf', ['filename' => $filename]);
    }

    public function showPdf($filename)
    {
        $filePath = public_path('pdf/' . $filename);

        if (!file_exists($filePath)) {
            abort(404);
        }

        return view('pdf.show', compact('filename'));
    }
}

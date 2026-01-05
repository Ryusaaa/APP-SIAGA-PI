<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiswaTracking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
        $interval = $request->get('interval', 'day');
        
        $query = SiswaTracking::with(['siswa', 'izin']);

        switch ($interval) {
            case 'day':
                $query->whereDate('waktu_keluar', Carbon::today());
                break;
            case 'week':
                $query->whereBetween('waktu_keluar', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ]);
                break;
            case 'month':
                $query->whereMonth('waktu_keluar', Carbon::now()->month);
                break;
        }

        $trackings = $query->orderBy('waktu_keluar', 'desc')->get();

        // Statistics
        $stats = [
            'total' => $trackings->count(),
            'kembali' => $trackings->where('waktu_kembali', '!=', null)->count(),
            'belum_kembali' => $trackings->where('waktu_kembali', null)->count(),
            'rata_durasi' => $trackings->where('durasi_menit', '!=', null)->avg('durasi_menit')
        ];

        return view('admin.tracking', compact('trackings', 'interval', 'stats'));
    }

    public function updateKembali(Request $request, $id)
    {
        $tracking = SiswaTracking::findOrFail($id);
        
        $waktuKembali = now();
        $durasi = $waktuKembali->diffInMinutes($tracking->waktu_keluar);

        $tracking->update([
            'waktu_kembali' => $waktuKembali,
            'durasi_menit' => $durasi,
            'catatan' => $request->catatan
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Waktu kembali berhasil dicatat'
        ]);
    }
}
<?php

namespace App\Http\Controllers\Admin;

use App\Exports\GuestsExport;
use App\Exports\LatesExport;
use App\Http\Controllers\Controller;
use App\Models\Izin;
use App\Models\SuratTerlambat;
use App\Models\Tamu;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DataSiswaController extends Controller
{
    public function index()
    {
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

        $latesMonth = SuratTerlambat::whereMonth('created_at', Carbon::now()->month)->count();
        $latesWeek = SuratTerlambat::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $latesToday = SuratTerlambat::whereDate('created_at', Carbon::today())->count();

        $guestsMonth = Tamu::whereMonth('created_at', Carbon::now()->month)->count();
        $guestsWeek = Tamu::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
        $guestsToday = Tamu::whereDate('created_at', Carbon::today())->count();

        return view(
            'admin.data',
            compact('latesMonth', 'latesWeek', 'latesToday', 'guestsMonth', 'guestsWeek', 'guestsToday')
        );
    }

    public function izin()
    {
        $current = now();
        $startHour = 6;
        $startMinute = 45;

        $startMinutes = ($startHour * 60) + $startMinute;
        $currentMinutes = ($current->hour * 60) + $current->minute;
        $difference = $currentMinutes - $startMinutes;

        if ($difference < 0) {
            $difference += 1440;
        }

        $hour = intdiv($difference, 45) + 1;

        $surats = Izin::latest()->get();

        return view('admin.suratIzin', compact('surats', 'hour'));
    }

    public function terlambat()
    {
        $terlambats = SuratTerlambat::whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get();
        $interval = 'day';
        $jurusans = \App\Models\Jurusan::where('is_active', true)->get();

        return view('admin.terlambat', compact('terlambats', 'interval', 'jurusans'));
    }

    public function filterLate(Request $request)
    {
        $interval = $request->input('interval');
        $export = $request->input('export');
        $jurusanId = $request->input('jurusan_id');

        $query = SuratTerlambat::query()->with(['siswa', 'kelas', 'jurusan']);

        // Apply jurusan filter first
        if ($jurusanId) {
            $query->where('jurusan_id', $jurusanId);
        }

        switch ($interval) {
            case 'day':
                $startDate = Carbon::today();
                $endDate = Carbon::today()->endOfDay();
                break;
            case 'week':
                $startDate = Carbon::now()->startOfWeek();
                $endDate = Carbon::now()->endOfWeek();
                break;
            case 'month':
                $startDate = Carbon::now()->startOfMonth();
                $endDate = Carbon::now()->endOfMonth();
                break;
            case 'yesterday':
                $startDate = Carbon::yesterday();
                $endDate = Carbon::yesterday()->endOfDay();
                break;
            case 'lastWeek':
                $startDate = Carbon::now()->subWeek()->startOfWeek();
                $endDate = Carbon::now()->subWeek()->endOfWeek();
                break;
            case 'lastMonth':
                $startDate = Carbon::now()->subMonth()->startOfMonth();
                $endDate = Carbon::now()->subMonth()->endOfMonth();
                break;
            case 'all':
                $startDate = null;
                $endDate = null;
                break;
            default:
                $startDate = Carbon::today();
                $endDate = Carbon::today()->endOfDay();
                break;
        }

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }

        $terlambats = $query->orderBy('created_at', 'desc')->get();

        if ($export && $export === 'excel') {
            return Excel::download(new \App\Exports\TerlambatExport($jurusanId, $interval, $startDate, $endDate), 'data_terlambat.xlsx');
        }

        $jurusans = \App\Models\Jurusan::where('is_active', true)->get();
        return view('admin.terlambat', compact('terlambats', 'interval', 'jurusans'));
    }

    public function lateDelete($id)
    {
        SuratTerlambat::find($id)->delete();

        return redirect()->back();
    }

    public function guest()
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();
        $guests = Tamu::whereBetween('created_at', [$startOfMonth, $endOfMonth])->orderBy('created_at', 'desc')->get();
        $interval = 'month';

        return view('admin.guest', compact('guests', 'interval'));
    }

    public function filterGuest(Request $request)
    {
        $interval = $request->input('interval');
        $export = $request->input('export');

        switch ($interval) {
            case 'day':
                $guests = Tamu::whereDate('created_at', Carbon::today())->orderBy('created_at', 'desc')->get();
                break;
            case 'week':
                $startOfWeek = Carbon::now()->startOfWeek();
                $endOfWeek = Carbon::now()->endOfWeek();
                $guests = Tamu::whereBetween('created_at', [$startOfWeek, $endOfWeek])->orderBy('created_at', 'desc')->get();
                break;
            case 'month':
                $startOfMonth = Carbon::now()->startOfMonth();
                $endOfMonth = Carbon::now()->endOfMonth();
                $guests = Tamu::whereBetween('created_at', [$startOfMonth, $endOfMonth])->orderBy('created_at', 'desc')->get();
                break;
            case 'yesterday':
                $guests = Tamu::whereDate('created_at', Carbon::yesterday())->orderBy('created_at', 'desc')->get();
                break;
            case 'lastWeek':
                $startOfLastWeek = Carbon::now()->subWeek()->startOfWeek();
                $endOfLastWeek = Carbon::now()->subWeek()->endOfWeek();
                $guests = Tamu::whereBetween('created_at', [$startOfLastWeek, $endOfLastWeek])->orderBy('created_at', 'desc')->get();
                break;
            case 'lastMonth':
                $startOfLastMonth = Carbon::now()->subMonth()->startOfMonth();
                $endOfLastMonth = Carbon::now()->subMonth()->endOfMonth();
                $guests = Tamu::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->orderBy('created_at', 'desc')->get();
                break;
            case 'all':
                $guests = Tamu::latest()->get();
                break;
            default:
                $guests = collect();
                break;
        }

        if ($export && $export === 'excel') {
            return Excel::download(new GuestsExport($guests), 'guests.xls');
        }

        return view('admin.guest', compact('guests', 'interval'));
    }

    public function guestDelete($id)
    {
        Tamu::find($id)->delete();

        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jurusan;
use App\Models\Mapel;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    // Jurusan Methods
    public function indexJurusan()
    {
        $jurusans = Jurusan::latest()->get();
        return view('admin.master.jurusan', compact('jurusans'));
    }

    public function storeJurusan(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:jurusans,kode|max:10',
            'nama' => 'required|max:255',
            'deskripsi' => 'nullable',
        ]);

        Jurusan::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jurusan berhasil ditambahkan'
        ]);
    }

    public function updateJurusan(Request $request, $id)
    {
        $jurusan = Jurusan::findOrFail($id);
        
        $validated = $request->validate([
            'kode' => 'required|max:10|unique:jurusans,kode,' . $id,
            'nama' => 'required|max:255',
            'deskripsi' => 'nullable',
        ]);

        $jurusan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Jurusan berhasil diupdate'
        ]);
    }

    public function deleteJurusan($id)
    {
        Jurusan::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jurusan berhasil dihapus'
        ]);
    }

    // Mapel Methods
    public function indexMapel()
    {
        $mapels = Mapel::with('jurusan')->latest()->get();
        $jurusans = Jurusan::where('is_active', true)->get();
        return view('admin.master.mapel', compact('mapels', 'jurusans'));
    }

    public function storeMapel(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|unique:mapels,kode|max:20',
            'nama' => 'required|max:255',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'jam_pelajaran' => 'required|integer|min:1|max:10',
        ]);

        Mapel::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil ditambahkan'
        ]);
    }

    public function updateMapel(Request $request, $id)
    {
        $mapel = Mapel::findOrFail($id);
        
        $validated = $request->validate([
            'kode' => 'required|max:20|unique:mapels,kode,' . $id,
            'nama' => 'required|max:255',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'jam_pelajaran' => 'required|integer|min:1|max:10',
        ]);

        $mapel->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil diupdate'
        ]);
    }

    public function deleteMapel($id)
    {
        Mapel::findOrFail($id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mata pelajaran berhasil dihapus'
        ]);
    }
}
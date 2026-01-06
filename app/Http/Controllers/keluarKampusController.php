<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Izin;
use App\Models\Siswa;
use App\Models\Tamu;
use App\Models\PerpindahanKelas;
use App\Models\Kelas;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class keluarKampusController extends Controller
{
    public function index(Request $request)
    {
        $izins = Izin::latest()->with('siswa')->get();
        $perpindahanKelas = PerpindahanKelas::all();
        $kelas = Kelas::all();
        $siswas = Siswa::all();
        $users = User::all();

        return view('home', compact('izins', 'siswas', 'perpindahanKelas', 'kelas', 'users'));
    }

    public function storePindahkelas(Request $request)
    {
        $validatedData = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'jurusan_id' => 'required|exists:jurusans,id',
            'mapel_id' => 'required|exists:mapels,id',
            'jumlah_siswa' => 'required|integer|min:1',
            'mapel' => 'nullable|string|max:255',
        ]);

        // Create PerpindahanKelas record
        $perpindahanKelas = PerpindahanKelas::create($validatedData);

        // Generate PDF content
        $pdf = Pdf::loadView('pdf.perpindahan_kelas', compact('perpindahanKelas'));
        $filename = 'perpindahan_kelas_' . $perpindahanKelas->id . '.pdf';

        // Ensure the directory exists
        $directory = public_path('pdf');
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        // Save the PDF file
        $pdf->save($directory . '/' . $filename);

        // Return JSON with PDF URL
        return response()->json([
            'success' => true,
            'url' => route('showPdf', ['filename' => $filename]),
            'message' => 'Surat perpindahan kelas berhasil dibuat'
        ]);
    }

    public function storeIzinkeluar(Request $request)
    {
        $validatedData = $request->validate([
            'siswa_id' => 'required|array',
            'siswa_id.*' => 'required|exists:siswas,id',
            'kelas_id' => 'required|exists:kelas,id',
            'jurusan_id' => 'required|exists:jurusans,id',
            'mapel_id' => 'required|exists:mapels,id',
            'alasan' => 'required|max:255',
        ]);

        $pdfFiles = [];

        foreach ($validatedData['siswa_id'] as $siswaId) {
            $mapel = \App\Models\Mapel::find($validatedData['mapel_id']);

            $izinData = [
                'siswa_id' => $siswaId,
                'kelas_id' => $validatedData['kelas_id'],
                'jurusan_id' => $validatedData['jurusan_id'],
                'mapel_id' => $validatedData['mapel_id'],
                'alasan' => $validatedData['alasan'],
            ];

            // Create Izin record
            $izin = Izin::create($izinData);

            // Create Tracking record
            \App\Models\SiswaTracking::create([
                'siswa_id' => $siswaId,
                'izin_id' => $izin->id,
                'waktu_keluar' => now(),
            ]);

            // Load relationships for PDF
            $izin->load('siswa');
            $izin->mapel = $mapel->nama;

            // Generate PDF
            $pdf = PDF::loadView('pdf.surat_izin', compact('izin'));
            $filename = 'suratizin-' . $izin->id . '.pdf';

            $directory = public_path('pdf');
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            $pdf->save($directory . '/' . $filename);
            $pdfFiles[] = url('pdf/' . $filename);
        }

        return response()->json([
            'success' => true,
            'pdf_files' => $pdfFiles,
            'message' => 'Surat izin berhasil dibuat'
        ]);
    }



    public function storeSuratTamu(Request $request)
    {
        $validatedData = $request->validate([
            'identitas' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'jurusan_id' => 'nullable|exists:jurusans,id',
            'darimana' => 'required|string|max:255',
            'kemana' => 'required|string|max:255',
            'keperluan' => 'required|string|max:255',
            'captured_photo' => 'required|string', // base64 tetap dikirim
            'no_telp' => 'required|string|max:20'
        ]);

        $imagePath = null;

        if ($request->has('captured_photo') && $request->captured_photo) {
            $imageData = $request->captured_photo;

            // Pisahkan base64 header jika ada
            if (strpos($imageData, 'base64,') !== false) {
                list($type, $imageData) = explode('base64,', $imageData);
            }

            // Decode base64
            $photoBinary = base64_decode($imageData);

            // Generate unique filename
            $imageName = 'photo_' . time() . '_' . Str::random(10) . '.jpg';
            $imagePath = 'photos/' . $imageName;

            // Simpan ke disk public
            Storage::disk('public')->put($imagePath, $photoBinary);

            // Masukkan path ke data validasi
            $validatedData['captured_photo'] = $imagePath;
        }

        // Simpan data tamu ke database
        $tamu = Tamu::create($validatedData);

        // Encode ulang untuk PDF (agar bisa disisipkan sebagai img src)
        $photoData = $imagePath ? 'data:image/jpeg;base64,' . base64_encode(Storage::disk('public')->get($imagePath)) : null;

        // Generate PDF
        $pdf = PDF::loadView('pdf.surat_tamu', [
            'tamu' => $tamu,
            'photoData' => $photoData
        ]);

        $filename = 'surat_tamu_' . $tamu->id . '.pdf';

        // Simpan PDF ke public/pdf
        $directory = public_path('pdf');
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
        $pdf->save($directory . '/' . $filename);

        // Kirim email
        $toEmail = $this->getEmailByDestination($validatedData['kemana']);
        if ($toEmail) {
            Mail::send('emails.surat_tamu', $validatedData, function ($message) use ($toEmail, $filename) {
                $message->to($toEmail)
                    ->subject('Surat Tamu Baru')
                    ->attach(public_path('pdf/' . $filename));
            });
        }

        return response()->json([
            'success' => true,
            'url' => route('showPdf', ['filename' => $filename]),
            'message' => 'Surat tamu berhasil dibuat dan email terkirim'
        ]);
    }

    private function getEmailByDestination($destination)
    {
        $user = User::where('name', $destination)->first(); 

        return $user ? $user->email : null;
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
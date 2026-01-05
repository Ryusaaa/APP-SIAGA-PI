<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Jurusan;
use App\Models\Mapel;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // Jurusan
        $jurusans = [
            ['kode' => 'PPLG', 'nama' => 'Pengembangan Perangkat Lunak dan Gim', 'deskripsi' => 'Jurusan yang mempelajari pemrograman dan pengembangan software'],
            ['kode' => 'TJKT', 'nama' => 'Teknik Jaringan Komputer dan Telekomunikasi', 'deskripsi' => 'Jurusan yang mempelajari jaringan komputer dan telekomunikasi'],
            ['kode' => 'DKV', 'nama' => 'Desain Komunikasi Visual', 'deskripsi' => 'Jurusan yang mempelajari desain grafis dan multimedia'],
            ['kode' => 'MPLB', 'nama' => 'Manajemen Perkantoran dan Layanan Bisnis', 'deskripsi' => 'Jurusan yang mempelajari administrasi perkantoran'],
            ['kode' => 'TKR', 'nama' => 'Teknik Kendaraan Ringan', 'deskripsi' => 'Jurusan yang mempelajari otomotif kendaraan ringan'],
            ['kode' => 'TSM', 'nama' => 'Teknik Sepeda Motor', 'deskripsi' => 'Jurusan yang mempelajari teknik sepeda motor'],
        ];

        foreach ($jurusans as $jurusan) {
            Jurusan::create($jurusan);
        }

        // Mapel Umum
        $mapelUmum = [
            ['kode' => 'MTK', 'nama' => 'Matematika', 'jam_pelajaran' => 4],
            ['kode' => 'B.IND', 'nama' => 'Bahasa Indonesia', 'jam_pelajaran' => 4],
            ['kode' => 'B.ING', 'nama' => 'Bahasa Inggris', 'jam_pelajaran' => 3],
            ['kode' => 'PKN', 'nama' => 'Pendidikan Kewarganegaraan', 'jam_pelajaran' => 2],
            ['kode' => 'PAI', 'nama' => 'Pendidikan Agama Islam', 'jam_pelajaran' => 2],
            ['kode' => 'PJOK', 'nama' => 'Pendidikan Jasmani Olahraga dan Kesehatan', 'jam_pelajaran' => 2],
            ['kode' => 'SEJ', 'nama' => 'Sejarah Indonesia', 'jam_pelajaran' => 2],
        ];

        foreach ($mapelUmum as $mapel) {
            Mapel::create($mapel);
        }

        // Mapel PPLG
        $pplg = Jurusan::where('kode', 'PPLG')->first();
        $mapelPPLG = [
            ['kode' => 'PBO', 'nama' => 'Pemrograman Berorientasi Objek', 'jurusan_id' => $pplg->id, 'jam_pelajaran' => 6],
            ['kode' => 'WEB', 'nama' => 'Pemrograman Web', 'jurusan_id' => $pplg->id, 'jam_pelajaran' => 6],
            ['kode' => 'BASIS', 'nama' => 'Basis Data', 'jurusan_id' => $pplg->id, 'jam_pelajaran' => 4],
        ];

        foreach ($mapelPPLG as $mapel) {
            Mapel::create($mapel);
        }
    }
}
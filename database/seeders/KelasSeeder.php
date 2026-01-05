<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear the table before seeding
        DB::table('kelas')->delete();
        
        DB::table('kelas')->insert([
            [
                'kelas' => 'XII',
                'jurusan' => 'PPLG 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas' => 'XII',
                'jurusan' => 'PPLG 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas' => 'XII',
                'jurusan' => 'TJKT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas' => 'XII',
                'jurusan' => 'DKV 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas' => 'XII',
                'jurusan' => 'DKV 2',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas' => 'XII',
                'jurusan' => 'TBSM',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas' => 'XII',
                'jurusan' => 'TKRO',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas' => 'XII',
                'jurusan' => 'MPLB',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas' => 'XII',
                'jurusan' => 'PERHOTELAN',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kelas' => 'XII',
                'jurusan' => 'TMP',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

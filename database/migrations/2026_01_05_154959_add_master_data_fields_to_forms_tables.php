<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('perpindahan_kelas', function (Blueprint $table) {
            $table->foreignId('jurusan_id')->nullable()->after('kelas_id')->constrained('jurusans')->onDelete('set null');
            $table->foreignId('mapel_id')->nullable()->after('jurusan_id')->constrained('mapels')->onDelete('set null');
        });

        Schema::table('surat_terlambats', function (Blueprint $table) {
            $table->foreignId('kelas_id')->nullable()->after('siswa_id')->constrained('kelas')->onDelete('set null');
            $table->foreignId('jurusan_id')->nullable()->after('kelas_id')->constrained('jurusans')->onDelete('set null');
        });

        Schema::table('tamus', function (Blueprint $table) {
            $table->foreignId('jurusan_id')->nullable()->after('nama')->constrained('jurusans')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tamus', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropColumn('jurusan_id');
        });

        Schema::table('surat_terlambats', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropForeign(['jurusan_id']);
            $table->dropColumn(['kelas_id', 'jurusan_id']);
        });

        Schema::table('perpindahan_kelas', function (Blueprint $table) {
            $table->dropForeign(['jurusan_id']);
            $table->dropForeign(['mapel_id']);
            $table->dropColumn(['jurusan_id', 'mapel_id']);
        });
    }
};

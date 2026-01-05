<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jurusans', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 10)->unique();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('mapels', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique();
            $table->string('nama');
            $table->foreignId('jurusan_id')->nullable()->constrained('jurusans')->onDelete('set null');
            $table->integer('jam_pelajaran')->default(2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Update table izins
        Schema::table('izins', function (Blueprint $table) {
            $table->foreignId('kelas_id')->nullable()->after('siswa_id')->constrained('kelas')->onDelete('set null');
            $table->foreignId('jurusan_id')->nullable()->after('kelas_id')->constrained('jurusans')->onDelete('set null');
            $table->foreignId('mapel_id')->nullable()->after('jurusan_id')->constrained('mapels')->onDelete('set null');
        });

        // Tracking keluar masuk siswa
        Schema::create('siswa_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('izin_id')->constrained('izins')->onDelete('cascade');
            $table->timestamp('waktu_keluar');
            $table->timestamp('waktu_kembali')->nullable();
            $table->integer('durasi_menit')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa_trackings');
        Schema::table('izins', function (Blueprint $table) {
            $table->dropForeign(['kelas_id']);
            $table->dropForeign(['jurusan_id']);
            $table->dropForeign(['mapel_id']);
            $table->dropColumn(['kelas_id', 'jurusan_id', 'mapel_id']);
        });
        Schema::dropIfExists('mapels');
        Schema::dropIfExists('jurusans');
    }
};
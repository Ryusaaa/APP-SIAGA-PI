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
        // Add nama_guru to izins table
        Schema::table('izins', function (Blueprint $table) {
            $table->string('nama_guru')->nullable()->after('alasan');
        });

        // Add guru fields to perpindahan_kelas table
        Schema::table('perpindahan_kelas', function (Blueprint $table) {
            $table->string('guru_kampus_asal')->nullable()->after('jumlah_siswa');
            $table->string('guru_kampus_tujuan')->nullable()->after('guru_kampus_asal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('izins', function (Blueprint $table) {
            $table->dropColumn('nama_guru');
        });

        Schema::table('perpindahan_kelas', function (Blueprint $table) {
            $table->dropColumn(['guru_kampus_asal', 'guru_kampus_tujuan']);
        });
    }
};

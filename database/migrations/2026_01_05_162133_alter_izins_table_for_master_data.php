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
        Schema::table('izins', function (Blueprint $table) {
            if (!Schema::hasColumn('izins', 'kelas_id')) {
                $table->foreignId('kelas_id')->nullable()->after('siswa_id')->constrained('kelas')->onDelete('set null');
            }
            if (!Schema::hasColumn('izins', 'jurusan_id')) {
                $table->foreignId('jurusan_id')->nullable()->after('kelas_id')->constrained('jurusans')->onDelete('set null');
            }
            if (!Schema::hasColumn('izins', 'mapel_id')) {
                $table->foreignId('mapel_id')->nullable()->after('jurusan_id')->constrained('mapels')->onDelete('set null');
            }
            if (Schema::hasColumn('izins', 'mapel')) {
                $table->string('mapel')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('izins', function (Blueprint $table) {
            if (Schema::hasColumn('izins', 'kelas_id')) {
                $table->dropForeign(['kelas_id']);
                $table->dropColumn('kelas_id');
            }
            if (Schema::hasColumn('izins', 'jurusan_id')) {
                $table->dropForeign(['jurusan_id']);
                $table->dropColumn('jurusan_id');
            }
            if (Schema::hasColumn('izins', 'mapel_id')) {
                $table->dropForeign(['mapel_id']);
                $table->dropColumn('mapel_id');
            }
            if (Schema::hasColumn('izins', 'mapel')) {
                $table->string('mapel')->nullable(false)->change();
            }
        });
    }
};

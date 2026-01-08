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
        Schema::create('tamus', function (Blueprint $table) {
            $table->id();
            $table->string('identitas')->nullable();
            $table->string('nama');
            $table->string('instansi')->nullable();
            $table->string('kemana');
            $table->text('keperluan');
            $table->text('no_telp');
            $table->text('captured_photo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tamus');
    }
};

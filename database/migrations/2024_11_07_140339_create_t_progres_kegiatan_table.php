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
        Schema::create('t_progres_kegiatan', function (Blueprint $table) {
            $table->id('progres_kegiatan_id');
            $table->unsignedBigInteger('kegiatan_id')->index(); // Relasi dengan t_kegiatan
            $table->unsignedBigInteger('anggota_kegiatan_id')->index(); // Relasi dengan t_anggota_kegiatan
            $table->string('status');
            $table->text('update_progress');
            $table->timestamps();
        
            $table->foreign('kegiatan_id')->references('kegiatan_id')->on('t_kegiatan');
            $table->foreign('anggota_kegiatan_id')->references('anggota_kegiatan_id')->on('t_anggota_kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_progres_kegiatan');
    }
};

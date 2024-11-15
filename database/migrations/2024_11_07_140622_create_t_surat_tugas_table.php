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
        Schema::create('t_surat_tugas', function (Blueprint $table) {
            $table->id('surat_tugas_id');
            $table->unsignedBigInteger('kegiatan_id')->index(); // Relasi dengan t_kegiatan
            $table->string('surat_tugas');
            $table->timestamps();
        
            $table->foreign('kegiatan_id')->references('kegiatan_id')->on('t_kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_surat_tugas');
    }
};

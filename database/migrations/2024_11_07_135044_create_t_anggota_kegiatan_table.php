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
        Schema::create('t_anggota_kegiatan', function (Blueprint $table) {
            $table->id('anggota_kegiatan_id');
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('kegiatan_id')->index(); // Relasi dengan t_kegiatan
            $table->unsignedBigInteger('jabatan_id')->index(); // Relasi dengan m_jabatan_kegiatan
            $table->timestamps();
        
            $table->foreign('kegiatan_id')->references('kegiatan_id')->on('t_kegiatan');
            $table->foreign('jabatan_id')->references('jabatan_id')->on('m_jabatan_kegiatan');
            $table->foreign('user_id')->references('user_id')->on('m_user');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_anggota_kegiatan');
    }
};

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
        Schema::create('t_poin_dosen', function (Blueprint $table) {
            $table->id('poin_dosen_id');
            $table->unsignedBigInteger('profile_dosen_id')->index(); // Relasi dengan t_profil_dosen
            $table->unsignedBigInteger('kegiatan_id')->index(); // Relasi dengan tabel kegiatan
            $table->unsignedBigInteger('jabatan_id')->index(); // Relasi dengan tabel jabatan (PIC atau Anggota)
            $table->integer('poin'); // Nilai poin berdasarkan jabatan
            $table->timestamps();

            // Menambahkan relasi
            $table->foreign('profile_dosen_id')->references('profile_dosen_id')->on('t_profile_dosen');
            $table->foreign('kegiatan_id')->references('kegiatan_id')->on('t_kegiatan'); // Relasi dengan tabel kegiatan
            $table->foreign('jabatan_id')->references('jabatan_id')->on('m_jabatan_kegiatan'); // Relasi dengan tabel jabatan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_poin_dosen');
    }
};

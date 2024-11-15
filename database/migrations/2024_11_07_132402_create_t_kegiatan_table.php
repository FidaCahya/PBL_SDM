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
        Schema::create('t_kegiatan', function (Blueprint $table) {
            $table->id('kegiatan_id');
            $table->unsignedBigInteger('jenis_kegiatan_id')->index();
            $table->string('nama_kegiatan');
            $table->text('deskripsi_kegiatan');
            $table->enum('bobot_kerja', ['ringan', 'berat']);
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('status', ['Belum Dimulai', 'Sedang Berlangsung', 'Selesai']);
            $table->timestamps();

            $table->foreign('jenis_kegiatan_id')->references('jenis_kegiatan_id')->on('m_jenis_kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_kegiatan');
    }
};

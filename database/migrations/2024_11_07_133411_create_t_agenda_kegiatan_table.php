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
        Schema::create('t_agenda_kegiatan', function (Blueprint $table) {
            $table->id('agenda_kegiatan_id');
            $table->unsignedBigInteger('kegiatan_id')->index(); // Relasi dengan t_kegiatan
            $table->string('agenda_name');
            $table->dateTime('waktu');
            $table->string('tempat');
            $table->timestamps();
        
            $table->foreign('kegiatan_id')->references('kegiatan_id')->on('t_kegiatan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_agenda_kegiatan');
    }
};

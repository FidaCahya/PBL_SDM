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
        Schema::create('t_profile_dosen', function (Blueprint $table) {
            $table->id('profile_dosen_id');
            $table->unsignedBigInteger('user_id')->index(); // Relasi dengan m_user
            $table->string('nip');
            $table->string('jurusan');
            $table->string('alamat');
            $table->string('email');
            $table->string('no_telepon');
            $table->timestamps();
        
            $table->foreign('user_id')->references('user_id')->on('m_user');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_profile_dosen');
    }
};

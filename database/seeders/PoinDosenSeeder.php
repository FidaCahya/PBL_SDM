<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PoinDosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_poin_dosen')->insert([
            'profile_dosen_id' => 1,    // ID dosen pertama
            'kegiatan_id' => 1,         // ID kegiatan pertama
            'jabatan_id' => 1,          // ID jabatan PIC
            'poin' => 1,                // Poin untuk PIC
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('t_poin_dosen')->insert([
            'profile_dosen_id' => 2,    // ID dosen kedua
            'kegiatan_id' => 1,         // ID kegiatan pertama
            'jabatan_id' => 2,          // ID jabatan Anggota
            'poin' => 0.5,              // Poin untuk Anggota
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        
    }
}

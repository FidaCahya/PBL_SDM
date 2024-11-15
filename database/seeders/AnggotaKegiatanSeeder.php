<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnggotaKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_anggota_kegiatan')->insert([
            [
                'anggota_kegiatan_id' => 1,
                'kegiatan_id' => 1, // ID dari tabel t_kegiatan
                'profile_dosen_id' => 1, // ID dari tabel t_profile_dosen
                'jabatan_id' => 1, // ID dari tabel m_jabatan_kegiatan
                'bobot' => 0.5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'anggota_kegiatan_id' => 2,
                'kegiatan_id' => 2, // ID dari tabel t_kegiatan
                'profile_dosen_id' => 2, // ID dari tabel t_profile_dosen
                'jabatan_id' => 2, // ID dari tabel m_jabatan_kegiatan
                'bobot' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'anggota_kegiatan_id' => 3,
                'kegiatan_id' => 2, // ID dari tabel t_kegiatan
                'profile_dosen_id' => 2, // ID dari tabel t_profile_dosen
                'jabatan_id' => 3, // ID dari tabel m_jabatan_kegiatan
                'bobot' => 0.5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}

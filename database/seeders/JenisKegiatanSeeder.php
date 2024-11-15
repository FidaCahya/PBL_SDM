<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class JenisKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['jenis_kegiatan_id' => 1, 'nama_jenis_kegiatan' => 'Terprogram JTI'],
            ['jenis_kegiatan_id' => 2, 'nama_jenis_kegiatan' => 'Non-program JTI'],
        ];
        DB::table('m_jenis_kegiatan')->insert($data);
    }
}

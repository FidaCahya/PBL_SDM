<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class JabatanKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['jabatan_id' => 1, 'jabatan' => 'PIC'],
            ['jabatan_id' => 2, 'jabatan' => 'Sekretaris'],
            ['jabatan_id' => 3, 'jabatan' => 'Anggota'],
        ];
        DB::table('m_jabatan_kegiatan')->insert($data);
    }
}

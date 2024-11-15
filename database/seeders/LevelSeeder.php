<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['level_id' => 1, 'level_kode' => 'PRC', 'level_nama' => 'Tim Perencana'],
            ['level_id' => 2, 'level_kode' => 'PMP', 'level_nama' => 'Pimpinan'],
            ['level_id' => 3, 'level_kode' => 'DSN', 'level_nama' => 'Dosen'],
            
        ];
        DB::table('m_level')->insert($data);
    }
}

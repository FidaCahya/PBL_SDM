<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AgendaKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_agenda_kegiatan')->insert([
            [
                'agenda_kegiatan_id' => 1,
                'kegiatan_id' => 1,  // ID dari t_kegiatan yang sudah ada
                'agenda_name' => 'Rapat Perencanaan',
                'waktu' => Carbon::parse('2024-11-10 09:00:00'),
                'tempat' => 'Ruang Rapat 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'agenda_kegiatan_id' => 2,
                'kegiatan_id' => 2,  // ID dari t_kegiatan yang sudah ada
                'agenda_name' => 'Pelatihan Penggunaan Sistem',
                'waktu' => Carbon::parse('2024-11-12 14:00:00'),
                'tempat' => 'Lab IT',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}

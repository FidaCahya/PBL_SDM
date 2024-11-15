<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProgresKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_progres_kegiatan')->insert([
            [
                'progres_kegiatan_id' => 1,
                'kegiatan_id' => 1, // ID kegiatan yang relevan
                'anggota_kegiatan_id' => 1, // ID anggota kegiatan yang relevan
                'status' => 'In Progress',
                'update_progress' => 'Pekerjaan dimulai, tahap pertama telah selesai.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'progres_kegiatan_id' => 2,
                'kegiatan_id' => 2, // ID kegiatan yang relevan
                'anggota_kegiatan_id' => 2, // ID anggota kegiatan yang relevan
                'status' => 'Completed',
                'update_progress' => 'Semua tugas telah selesai dan laporan diserahkan.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'progres_kegiatan_id' => 3,
                'kegiatan_id' => 2, // ID kegiatan yang relevan
                'anggota_kegiatan_id' => 3, // ID anggota kegiatan yang relevan
                'status' => 'Pending',
                'update_progress' => 'Tunggu persetujuan untuk memulai kegiatan.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}

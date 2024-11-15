<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SuratTugasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_surat_tugas')->insert([
            [
                'surat_tugas_id' => 1,
                'kegiatan_id' => 1, // Sesuaikan dengan kegiatan_id yang ada di t_kegiatan
                'surat_tugas' => 'Surat Tugas Kegiatan 1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'surat_tugas_id' => 2,
                'kegiatan_id' => 2, // Sesuaikan dengan kegiatan_id yang ada di t_kegiatan
                'surat_tugas' => 'Surat Tugas Kegiatan 2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'surat_tugas_id' => 3,
                'kegiatan_id' => 1, // Sesuaikan dengan kegiatan_id yang ada di t_kegiatan
                'surat_tugas' => 'Surat Tugas Kegiatan 1 Revisi',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class KegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_kegiatan')->insert([
            [
                'kegiatan_id' => 1,
                'jenis_kegiatan_id' => 1, // Assuming this id exists in m_jenis_kegiatan
                'nama_kegiatan' => 'Workshop Teknologi',
                'deskripsi_kegiatan' => 'Workshop mengenai pengembangan teknologi terbaru.',
                'bobot_kerja' => 'berat',
                'tanggal_mulai' => Carbon::parse('2024-12-01'),
                'tanggal_selesai' => Carbon::parse('2024-12-05'),
                'status' => 'Belum Dimulai',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kegiatan_id' => 2,
                'jenis_kegiatan_id' => 2, // Assuming this id exists in m_jenis_kegiatan
                'nama_kegiatan' => 'Seminar Pendidikan',
                'deskripsi_kegiatan' => 'Seminar mengenai metode pembelajaran terbaru.',
                'bobot_kerja' => 'ringan',
                'tanggal_mulai' => Carbon::parse('2024-11-20'),
                'tanggal_selesai' => Carbon::parse('2024-11-22'),
                'status' => 'Sedang Berlangsung',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'kegiatan_id' => 3,
                'jenis_kegiatan_id' => 1, // Assuming this id exists in m_jenis_kegiatan
                'nama_kegiatan' => 'Rapat Evaluasi',
                'deskripsi_kegiatan' => 'Rapat untuk mengevaluasi kegiatan semester lalu.',
                'bobot_kerja' => 'ringan',
                'tanggal_mulai' => Carbon::parse('2024-10-15'),
                'tanggal_selesai' => Carbon::parse('2024-10-16'),
                'status' => 'Selesai',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}

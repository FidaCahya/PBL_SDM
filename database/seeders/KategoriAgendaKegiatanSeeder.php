<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class KategoriAgendaKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('m_kategori_agenda')->insert([
            [
                'kategori_agenda' => 'Seminar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_agenda' => 'Workshop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'kategori_agenda' => 'Rapat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
           
        ]);
    }
        
    }


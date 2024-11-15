<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfileDosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('t_profile_dosen')->insert([
            [
                'user_id' => 1, // Relasi dengan m_user, pastikan user_id ini ada
                'nip' => '1982030210010101',
                'alamat' => 'Jalan Raya No. 123, Malang',
                'no_telepon' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2, // Relasi dengan m_user, pastikan user_id ini ada
                'nip' => '1983020210010102',
                'alamat' => 'Jalan Raya No. 456, Malang',
                'no_telepon' => '081234567891',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}

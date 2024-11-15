<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'user_id' => 1,
                'password' => Hash::make('password1'), // Contoh password yang dienkripsi
                'nama' => 'Tim Perencana JTI',
                'level_id' => 1, // Sesuai dengan level di m_level
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'password' => Hash::make('password2'),
                'nama' => 'Ketua Jurusan',
                'level_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 3,
                'password' => Hash::make('password3'),
                'nama' => 'Dosen PWL',
                'level_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('m_user')->insert($data);
    }
}

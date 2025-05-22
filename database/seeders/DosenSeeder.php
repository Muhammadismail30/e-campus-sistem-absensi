<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dosen;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Dr. Andi samsu',
                'email' => 'andisamsu@gmail.com',
                'password' => bcrypt('andisamsu123'),
                'role' => 'dosen',
                'nidn' => 'DSN001'
            ],
            [
                'name' => 'Prof. Rina wati',
                'email' => 'rinawati@gmail.com',
                'password' => bcrypt('rinawati123'),
                'role' => 'dosen',
                'nidn' => 'DSN002'
            ],
            [
                'name' => 'Fajar rahman',
                'email' => 'fajarrahman@gmail.com',
                'password' => bcrypt('fajarrahman12345'),
                'role' => 'dosen',
                'nidn' => 'DSN003'
            ],
            [
                'name' => 'Nurhayati',
                'email' => 'nurhayati@gmail.com',
                'password' => bcrypt('nurhayati123'),
                'role' => 'dosen',
                'nidn' => 'DSN004'
            ],
            [
                'name' => 'Ir. Yusuh halim',
                'email' => 'yuzufhalim@gmail.com',
                'password' => bcrypt('yuzufhalim123'),
                'role' => 'dosen',
                'nidn' => 'DSN005'
            ]
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'role' => $userData['role']
            ]);

            Dosen::create([
                'user_id' => $user->id,
                'nidn' => $userData['nidn']
            ]);
        }
    }
}

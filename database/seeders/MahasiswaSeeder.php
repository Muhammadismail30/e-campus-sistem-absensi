<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Mahasiswa;

class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Fikrank',
                'email' => 'fikran@gmail.com',
                'password' => bcrypt('fikran123'),
                'role' => 'mahasiswa',
                'nim' => 'MHS001'
            ],
            [
                'name' => 'Thoriq',
                'email' => 'thoriq@gmail.com',
                'password' => bcrypt('thoriq123'),
                'role' => 'mahasiswa',
                'nim' => 'MHS002'
            ],
            [
                'name' => 'Aji',
                'email' => 'aji@gmail.com',
                'password' => bcrypt('aji12345'),
                'role' => 'mahasiswa',
                'nim' => 'MHS003'
            ],
            [
                'name' => 'Syukran',
                'email' => 'syukran@gmail.com',
                'password' => bcrypt('syukran123'),
                'role' => 'mahasiswa',
                'nim' => 'MHS004'
            ],
            [
                'name' => 'Zakiaa',
                'email' => 'zaskiaa@gmail.com',
                'password' => bcrypt('zaskia123'),
                'role' => 'mahasiswa',
                'nim' => 'MHS005'
            ]
        ];

        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => $userData['password'],
                'role' => $userData['role']
            ]);

            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $userData['nim']
            ]);
        }
    }
}

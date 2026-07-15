<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Tamus Tahir',
                'email' => 'tamus@gmail.com',
                'role' => 'Superadmin',
            ],
            [
                'name' => 'Pak Kades',
                'email' => 'kades@gmail.com',
                'role' => 'Kades_Lurah',
            ],
            [
                'name' => 'Operator Desa',
                'email' => 'staf@gmail.com',
                'role' => 'Staf',
            ],
            [
                'name' => 'Budi Warga',
                'email' => 'warga@gmail.com',
                'role' => 'Warga',
            ],
        ];

        foreach ($users as $user) {
            if (User::where('email', $user['email'])->exists()) {
                continue;
            }

            User::factory()->create([
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
            ]);
        }
    }
}

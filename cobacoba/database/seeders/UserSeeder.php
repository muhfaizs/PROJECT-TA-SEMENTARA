<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Sistem',
                'email' => 'admin@sipanak.id',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'posyandu_id' => null,
            ],
            [
                'name' => 'dr. Siti Nurhaliza',
                'email' => 'dokter@sipanak.id',
                'password' => Hash::make('password'),
                'role' => 'dokter',
                'posyandu_id' => null,
            ],
            [
                'name' => 'Bidan Ani',
                'email' => 'bidan@sipanak.id',
                'password' => Hash::make('password'),
                'role' => 'bidan',
                'posyandu_id' => null,
            ],
            [
                'name' => 'Kader Melati 1',
                'email' => 'kader1@sipanak.id',
                'password' => Hash::make('password'),
                'role' => 'kader',
                'posyandu_id' => 1, // Posyandu Melati 1
            ],
            [
                'name' => 'Kader Mawar',
                'email' => 'kader2@sipanak.id',
                'password' => Hash::make('password'),
                'role' => 'kader',
                'posyandu_id' => 3, // Posyandu Mawar
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert(array_merge($user, [
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}

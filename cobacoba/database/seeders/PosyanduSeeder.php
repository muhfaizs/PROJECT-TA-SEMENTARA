<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PosyanduSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posyandus = [
            ['nama' => 'Posyandu Melati 1', 'desa' => 'Desa Sukamaju', 'puskesmas' => 'Puskesmas Kecamatan A'],
            ['nama' => 'Posyandu Melati 2', 'desa' => 'Desa Sukamaju', 'puskesmas' => 'Puskesmas Kecamatan A'],
            ['nama' => 'Posyandu Mawar', 'desa' => 'Desa Makmur', 'puskesmas' => 'Puskesmas Kecamatan A'],
            ['nama' => 'Posyandu Anggrek', 'desa' => 'Desa Sejahtera', 'puskesmas' => 'Puskesmas Kecamatan B'],
            ['nama' => 'Posyandu Dahlia', 'desa' => 'Desa Bahagia', 'puskesmas' => 'Puskesmas Kecamatan B'],
        ];

        foreach ($posyandus as $posyandu) {
            DB::table('posyandus')->insert(array_merge($posyandu, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}

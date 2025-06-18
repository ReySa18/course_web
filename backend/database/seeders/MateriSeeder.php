<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MateriSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('materis')->insert([
            [
                'judul' => 'Pengenalan Algoritma',
                'deskripsi' => 'Belajar tentang konsep dasar algoritma dan logika pemrograman.',
                'label' => 'Algoritma',
                'thumbnail' => 'https://source.unsplash.com/400x300/?algorithm',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Struktur Data Dasar',
                'deskripsi' => 'Memahami array, list, stack, dan queue.',
                'label' => 'Struktur Data',
                'thumbnail' => 'https://source.unsplash.com/400x300/?data',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Dasar-dasar Basis Data',
                'deskripsi' => 'Pengenalan basis data relasional dan query SQL.',
                'label' => 'Database',
                'thumbnail' => 'https://source.unsplash.com/400x300/?database',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}


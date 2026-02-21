<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Berita Umum', 'description' => 'Berita dan informasi umum dari Kwarran Bekasi Timur'],
            ['name' => 'Kegiatan', 'description' => 'Laporan kegiatan dan event Pramuka'],
            ['name' => 'Pendidikan', 'description' => 'Materi pendidikan dan pembelajaran Pramuka'],
            ['name' => 'Pengumuman', 'description' => 'Pengumuman penting dari Kwaran'],
            ['name' => 'Prestasi', 'description' => 'Prestasi dan pencapaian anggota Pramuka'],
            // Kategori unit usia Pramuka (materi khusus)
            ['name' => 'Siaga', 'description' => 'Materi dan informasi untuk Siaga'],
            ['name' => 'Penggalan', 'description' => 'Materi dan informasi untuk Penggalan'],
            ['name' => 'Penegak', 'description' => 'Materi dan informasi untuk Penegak'],
            ['name' => 'Pandega', 'description' => 'Materi dan informasi untuk Pandega'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => Str::slug($category['name'])],
                ['name' => $category['name'], 'description' => $category['description']]
            );
        }
    }
}

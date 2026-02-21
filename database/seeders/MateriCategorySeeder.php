<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MateriCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Materi Siaga',
            'Materi Penggalang',
            'Materi Penegak',
            'Materi Pandega',
            'Materi Pembina',
        ];

        foreach ($categories as $name) {
            \App\Models\Category::firstOrCreate(
                ['name' => $name],
                ['slug' => \Illuminate\Support\Str::slug($name)]
            );
        }
    }
}

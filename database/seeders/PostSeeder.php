<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        $posts = [
            [
                'title' => 'Pelantikan Pengurus Kwarcab 2025-2030',
                'content' => '<p>Acara pelantikan pengurus Kwarcab tahun 2025-2030 telah berlangsung dengan sukses pada tanggal 15 Februari 2026. Acara ini dihadiri oleh berbagai pihak termasuk undangan khusus dan anggota Pramuka dari berbagai tingkatan.</p><p>Pengurus yang baru dilantik diharapkan dapat memberikan kontribusi maksimal dalam pengembangan kepramukaan di wilayah Bekasi Timur.</p>',
                'excerpt' => 'Pelantikan pengurus Kwarcab tahun 2025-2030 telah berlangsung dengan sukses',
                'category_id' => 4,
                'author' => 'Admin',
                'published_at' => now()->subDays(5),
                'is_published' => true,
            ],
            [
                'title' => 'Program Pelatihan Pemimpin Regu Pramuka',
                'content' => '<p>Kwarran Bekasi Timur mengadakan program pelatihan khusus untuk pemimpin regu. Program ini dirancang untuk meningkatkan skill kepemimpinan dan manajemen regu.</p><p>Peserta akan mendapatkan materi lengkap tentang teknik kepemimpinan modern dan praktik langsung di lapangan.</p>',
                'excerpt' => 'Program pelatihan khusus untuk pemimpin regu telah dimulai dengan antusias',
                'category_id' => 3,
                'author' => 'Admin',
                'published_at' => now()->subDays(10),
                'is_published' => true,
            ],
            [
                'title' => 'Jambore Wilayah 2026 Siap Diselenggarakan',
                'content' => '<p>Persiapan Jambore Wilayah 2026 sudah memasuki tahap lanjut. Lokasi telah ditentukan dan berbagai persiapan logistik sedang dilakukan dengan cermat.</p><p>Diharapkan Jambore ini akan menjadi ajang yang berkesan bagi seluruh peserta dari berbagai cabang Pramuka.</p>',
                'excerpt' => 'Jambore Wilayah 2026 sedang dalam tahap persiapan intensif',
                'category_id' => 2,
                'author' => 'Admin',
                'published_at' => now()->subDays(15),
                'is_published' => true,
            ],
            [
                'title' => 'Pencapaian Luar Biasa Tim Pramuka Bekasi',
                'content' => '<p>Tim Pramuka dari Bekasi Timur berhasil meraih medali emas dalam kompetisi Pramuka tingkat nasional. Prestasi ini merupakan hasil kerja keras dan dedikasi selama berminggu-minggu latihan.</p><p>Kami bangga dengan pencapaian ini dan berkomitmen untuk terus berprestasi di masa depan.</p>',
                'excerpt' => 'Tim Pramuka Bekasi Timur meraih medali emas di kompetisi nasional',
                'category_id' => 5,
                'author' => 'Admin',
                'published_at' => now()->subDays(20),
                'is_published' => true,
            ],
            [
                'title' => 'Pembentukan Saka Bakti Husada Tahun Ini',
                'content' => '<p>Kwarran Bekasi Timur akan membentuk Saka Bakti Husada untuk anggota yang berkeinginan mendalami bidang kesehatan dan kemanusiaan.</p><p>Pendaftaran sudah dibuka dan terbatas untuk 40 peserta. Silakan hubungi kantor Kwaran untuk informasi lebih lanjut.</p>',
                'excerpt' => 'Pembentukan Saka Bakti Husada dibuka untuk anggota Pramuka',
                'category_id' => 2,
                'author' => 'Admin',
                'published_at' => now()->subDays(25),
                'is_published' => true,
            ],
        ];

        foreach ($posts as $post) {
            Post::create([
                'title' => $post['title'],
                'slug' => Str::slug($post['title']),
                'content' => $post['content'],
                'excerpt' => $post['excerpt'],
                'category_id' => $post['category_id'],
                'author' => $post['author'],
                'published_at' => $post['published_at'],
                'is_published' => $post['is_published'],
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'Tentang Kami',
                'content' => '<h2>Sejarah Kwarran Bekasi Timur</h2><p>Kwarran Bekasi Timur didirikan dengan tujuan untuk mengembangkan potensi generasi muda melalui kegiatan kepramukaan yang terstruktur dan berkelanjutan.</p><h2>Visi Kami</h2><p>Menjadi organisasi kepramukaan yang terdepan dalam membentuk karakter dan kompetensi generasi muda Indonesia.</p><h2>Misi Kami</h2><ul><li>Menyelenggarakan pendidikan kepramukaan berkualitas</li><li>Mengembangkan skill dan karakter anggota Pramuka</li><li>Memperkuat nilai-nilai kepemimpinan dan kemanusiaan</li><li>Berkontribusi aktif untuk kemajuan masyarakat</li></ul>',
            ],
            [
                'title' => 'Visi & Misi',
                'content' => '<h2>Visi</h2><p>Terwujudnya Pramuka Bekasi Timur sebagai gerakan pendidikan kaum muda yang dipercaya oleh masyarakat dan memiliki kontribusi nyata dalam pembangunan bangsa.</p><h2>Misi</h2><p>Menjalankan tiga misi pokok gerakan Pramuka dengan komitmen penuh:</p><ol><li>Menyelenggarakan pendidikan kepramukaan untuk mengembangkan karakter kaum muda</li><li>Membina dan mengembangkan kader Pramuka yang berkualitas</li><li>Berkontribusi aktif dalam pelayanan kepada masyarakat</li></ol>',
            ],
            [
                'title' => 'Struktur Organisasi',
                'content' => '<h2>Struktur Organisasi Kwaran 2025-2030</h2><table><tr><th>Posisi</th><th>Nama</th></tr><tr><td>Ketua Kwaran</td><td>-</td></tr><tr><td>Wakil Ketua</td><td>-</td></tr><tr><td>Sekretaris</td><td>-</td></tr><tr><td>Bendahara</td><td>-</td></tr><tr><td>Koordinator Bidang Pendidikan</td><td>-</td></tr></table><p>Struktur organisasi lengkap dapat dilihat di kantor Kwaran atau hubungi kami untuk informasi lebih detail.</p>',
            ],
            [
                'title' => 'Kontak',
                'content' => '<h2>Hubungi Kami</h2><h3>Kantor Kwarran Bekasi Timur</h3><ul><li><strong>Alamat:</strong> Bekasi Timur, Jawa Barat</li><li><strong>Telepon:</strong> +62 (0) xxx-xxxx-xxxx</li><li><strong>Email:</strong> <a href="mailto:info@kwarranbekasitimur.id">info@kwarranbekasitimur.id</a></li><li><strong>Website:</strong> <a href="https://kwarranbekasitimur.id">www.kwarranbekasitimur.id</a></li></ul><h3>Jam Operasional</h3><ul><li>Senin - Jumat: 09.00 - 17.00 WIB</li><li>Sabtu: 09.00 - 13.00 WIB</li><li>Minggu: Tutup</li></ul>',
            ],
        ];

        foreach ($pages as $page) {
            Page::create([
                'title' => $page['title'],
                'slug' => Str::slug($page['title']),
                'content' => $page['content'],
                'is_published' => true,
            ]);
        }
    }
}

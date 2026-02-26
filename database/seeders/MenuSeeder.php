<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('menus')->truncate();
        Schema::enableForeignKeyConstraints();

        $menus = array (
  0 => 
  array (
    'id' => 5,
    'name' => 'Beranda',
    'url' => '/',
    'parent_id' => NULL,
    'order' => 1,
    'is_active' => true,
    'created_at' => '2026-02-20T00:28:53.000000Z',
    'updated_at' => '2026-02-20T01:12:53.000000Z',
  ),
  1 => 
  array (
    'id' => 6,
    'name' => 'Organisasi',
    'url' => '#',
    'parent_id' => NULL,
    'order' => 2,
    'is_active' => true,
    'created_at' => '2026-02-20T00:29:06.000000Z',
    'updated_at' => '2026-02-22T11:48:59.000000Z',
  ),
  2 => 
  array (
    'id' => 7,
    'name' => 'Visi Misi',
    'url' => '/visi-misi',
    'parent_id' => 6,
    'order' => 2,
    'is_active' => true,
    'created_at' => '2026-02-20T00:29:53.000000Z',
    'updated_at' => '2026-02-22T11:49:15.000000Z',
  ),
  3 => 
  array (
    'id' => 8,
    'name' => 'Struktur Organisasi',
    'url' => '/struktur-organisasi',
    'parent_id' => 6,
    'order' => 1,
    'is_active' => true,
    'created_at' => '2026-02-20T00:30:47.000000Z',
    'updated_at' => '2026-02-22T11:49:13.000000Z',
  ),
  4 => 
  array (
    'id' => 9,
    'name' => 'Kontak Kami',
    'url' => '/kontak',
    'parent_id' => NULL,
    'order' => 10,
    'is_active' => true,
    'created_at' => '2026-02-20T00:33:04.000000Z',
    'updated_at' => '2026-02-23T15:54:17.000000Z',
  ),
  5 => 
  array (
    'id' => 10,
    'name' => 'Agenda',
    'url' => '/agenda',
    'parent_id' => NULL,
    'order' => 3,
    'is_active' => true,
    'created_at' => '2026-02-20T00:36:21.000000Z',
    'updated_at' => '2026-02-23T07:09:41.000000Z',
  ),
  6 => 
  array (
    'id' => 11,
    'name' => 'Berita',
    'url' => '/berita',
    'parent_id' => NULL,
    'order' => 4,
    'is_active' => true,
    'created_at' => '2026-02-20T00:57:16.000000Z',
    'updated_at' => '2026-02-23T07:09:41.000000Z',
  ),
  7 => 
  array (
    'id' => 12,
    'name' => 'Pusat Data',
    'url' => '#',
    'parent_id' => NULL,
    'order' => 6,
    'is_active' => true,
    'created_at' => '2026-02-20T01:01:35.000000Z',
    'updated_at' => '2026-02-23T15:54:08.000000Z',
  ),
  8 => 
  array (
    'id' => 13,
    'name' => 'Tautan',
    'url' => '#',
    'parent_id' => NULL,
    'order' => 7,
    'is_active' => true,
    'created_at' => '2026-02-20T01:11:21.000000Z',
    'updated_at' => '2026-02-23T15:54:08.000000Z',
  ),
  9 => 
  array (
    'id' => 14,
    'name' => 'Buletin',
    'url' => '#',
    'parent_id' => NULL,
    'order' => 8,
    'is_active' => true,
    'created_at' => '2026-02-20T01:11:29.000000Z',
    'updated_at' => '2026-02-23T15:54:08.000000Z',
  ),
  10 => 
  array (
    'id' => 15,
    'name' => 'Reportase',
    'url' => '/kirim-berita',
    'parent_id' => NULL,
    'order' => 9,
    'is_active' => true,
    'created_at' => '2026-02-20T01:11:40.000000Z',
    'updated_at' => '2026-02-23T15:54:17.000000Z',
  ),
  11 => 
  array (
    'id' => 16,
    'name' => 'Kwarcab Kota Bekasi',
    'url' => 'https://pramukakotabekasi.id/',
    'parent_id' => 13,
    'order' => 1,
    'is_active' => true,
    'created_at' => '2026-02-20T03:54:52.000000Z',
    'updated_at' => '2026-02-20T03:55:25.000000Z',
  ),
  12 => 
  array (
    'id' => 17,
    'name' => 'Kwarda Jawa Barat',
    'url' => 'https://pramukajawabarat.id/',
    'parent_id' => 13,
    'order' => 2,
    'is_active' => true,
    'created_at' => '2026-02-20T03:56:37.000000Z',
    'updated_at' => '2026-02-20T03:56:49.000000Z',
  ),
  13 => 
  array (
    'id' => 18,
    'name' => 'Kwarnas',
    'url' => 'https://pramuka.or.id/',
    'parent_id' => 13,
    'order' => 3,
    'is_active' => true,
    'created_at' => '2026-02-20T03:57:54.000000Z',
    'updated_at' => '2026-02-20T03:59:26.000000Z',
  ),
  14 => 
  array (
    'id' => 19,
    'name' => 'World Scouting',
    'url' => 'https://www.scout.org/',
    'parent_id' => 13,
    'order' => 4,
    'is_active' => true,
    'created_at' => '2026-02-20T03:59:09.000000Z',
    'updated_at' => '2026-02-20T04:38:45.000000Z',
  ),
  15 => 
  array (
    'id' => 22,
    'name' => 'Download',
    'url' => '/download',
    'parent_id' => 12,
    'order' => 7,
    'is_active' => true,
    'created_at' => '2026-02-20T04:32:21.000000Z',
    'updated_at' => '2026-02-23T15:54:15.000000Z',
  ),
  16 => 
  array (
    'id' => 23,
    'name' => 'Materi',
    'url' => '#',
    'parent_id' => NULL,
    'order' => 5,
    'is_active' => true,
    'created_at' => '2026-02-20T04:38:08.000000Z',
    'updated_at' => '2026-02-23T07:09:41.000000Z',
  ),
  17 => 
  array (
    'id' => 24,
    'name' => 'Data Statistik Kwarran',
    'url' => '/statistik',
    'parent_id' => 12,
    'order' => 6,
    'is_active' => true,
    'created_at' => '2026-02-20T07:40:32.000000Z',
    'updated_at' => '2026-02-23T07:09:50.000000Z',
  ),
  18 => 
  array (
    'id' => 25,
    'name' => 'Transparansi Keuangan LPK',
    'url' => '/transparansi',
    'parent_id' => 12,
    'order' => 2,
    'is_active' => true,
    'created_at' => '2026-02-20T07:46:32.000000Z',
    'updated_at' => '2026-02-23T07:09:50.000000Z',
  ),
  19 => 
  array (
    'id' => 26,
    'name' => 'Dokumen PDF',
    'url' => '/dokumen',
    'parent_id' => 12,
    'order' => 5,
    'is_active' => true,
    'created_at' => '2026-02-20T08:05:30.000000Z',
    'updated_at' => '2026-02-23T07:09:50.000000Z',
  ),
  20 => 
  array (
    'id' => 29,
    'name' => 'Dokumentasi Kegiatan',
    'url' => '/galeri',
    'parent_id' => 12,
    'order' => 4,
    'is_active' => true,
    'created_at' => '2026-02-20T09:24:35.000000Z',
    'updated_at' => '2026-02-23T07:09:50.000000Z',
  ),
  21 => 
  array (
    'id' => 30,
    'name' => 'Database Gudep Bekasi Timur',
    'url' => '/gudep',
    'parent_id' => 12,
    'order' => 3,
    'is_active' => true,
    'created_at' => '2026-02-21T15:56:13.000000Z',
    'updated_at' => '2026-02-23T07:09:50.000000Z',
  ),
  22 => 
  array (
    'id' => 32,
    'name' => 'Dewan Kerja Ranting',
    'url' => '/dkr',
    'parent_id' => 6,
    'order' => 4,
    'is_active' => true,
    'created_at' => '2026-02-21T18:39:28.000000Z',
    'updated_at' => '2026-02-22T11:48:59.000000Z',
  ),
  23 => 
  array (
    'id' => 33,
    'name' => 'Lembaga Pemeriksa Keuangan',
    'url' => '/lpk',
    'parent_id' => 6,
    'order' => 3,
    'is_active' => true,
    'created_at' => '2026-02-22T11:48:40.000000Z',
    'updated_at' => '2026-02-22T11:49:15.000000Z',
  ),
  24 => 
  array (
    'id' => 34,
    'name' => 'STATISTIK',
    'url' => 'sisran/hasil/data-potensi-gugus-depan-zpJki',
    'parent_id' => 12,
    'order' => 1,
    'is_active' => true,
    'created_at' => '2026-02-23T07:09:27.000000Z',
    'updated_at' => '2026-02-23T07:09:50.000000Z',
  ),
  25 => 
  array (
    'id' => 35,
    'name' => 'Publikasi Buletin Kwarran',
    'url' => '/buletin',
    'parent_id' => 14,
    'order' => 1,
    'is_active' => true,
    'created_at' => '2026-02-23T15:53:53.000000Z',
    'updated_at' => '2026-02-23T15:54:17.000000Z',
  ),
);

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}

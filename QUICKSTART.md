# Kwarran Bekasi Timur Website - Quick Start Guide

## 🚀 Memulai Dengan Cepat

### 1. Pastikan Server Berjalan

```bash
cd d:\xampp\htdocs\kwarran
php artisan serve
```

Server akan berjalan di: **http://localhost:8000**

### 2. Akses Website

Buka browser dan pergi ke: http://localhost:8000

## 📋 Daftar Halaman yang Tersedia

### Halaman Publik
- **Home** - `http://localhost:8000/`
- **Semua Berita** - `http://localhost:8000/berita`
- **Tentang Kami** - `http://localhost:8000/tentang-kami`
- **Visi & Misi** - `http://localhost:8000/visi-misi`
- **Struktur Organisasi** - `http://localhost:8000/struktur-organisasi`
- **Kontak** - `http://localhost:8000/kontak`

### Kategori Berita
- **Berita Umum** - `http://localhost:8000/kategori/berita-umum`
- **Kegiatan** - `http://localhost:8000/kategori/kegiatan`
- **Pendidikan** - `http://localhost:8000/kategori/pendidikan`
- **Pengumuman** - `http://localhost:8000/kategori/pengumuman`
- **Prestasi** - `http://localhost:8000/kategori/prestasi`

## 📝 Menambah Berita Baru

### Method 1: Laravel Tinker (Mudah)

```bash
php artisan tinker
```

Kemudian ketik:

```php
App\Models\Post::create([
    'title' => 'Judul Berita Anda',
    'slug' => 'judul-berita-anda',
    'content' => '<h2>Heading</h2><p>Konten berita Anda di sini...</p>',
    'excerpt' => 'Ringkasan singkat berita',
    'category_id' => 1,
    'author' => 'Nama Anda',
    'published_at' => now(),
    'is_published' => true,
]);
```

### Method 2: Melalui Database GUI

Gunakan tools seperti:
- PhpMyAdmin
- MySQL Workbench
- DBeaver

Query untuk insert:
```sql
INSERT INTO posts (title, slug, content, excerpt, category_id, author, published_at, is_published, created_at, updated_at)
VALUES ('Judul', 'judul', '<p>Konten</p>', 'Ringkasan', 1, 'Admin', NOW(), 1, NOW(), NOW());
```

## 📄 Menambah Halaman Statis

```bash
php artisan tinker
```

```php
App\Models\Page::create([
    'title' => 'Nama Halaman',
    'slug' => 'nama-halaman',
    'content' => '<h1>Judul</h1><p>Konten halaman...</p>',
    'is_published' => true,
]);
```

Halaman akan otomatis accessible di: `/nama-halaman`

## 🏷️ Menambah Kategori

```bash
php artisan tinker
```

```php
App\Models\Category::create([
    'name' => 'Kategori Baru',
    'slug' => 'kategori-baru',
    'description' => 'Deskripsi kategori',
]);
```

## 🎨 Editing Desain & Layout

### File Layout Utama
`resources/views/layouts/app.blade.php`

Ubah bagian:
- **Navbar** - Menu utama
- **CSS Variables** - Warna dan styling
- **Footer** - Informasi kontak dan copyright

### File Halaman Spesifik
- `resources/views/home.blade.php` - Halaman utama
- `resources/views/posts/index.blade.php` - Daftar berita
- `resources/views/posts/show.blade.php` - Detail berita

## 🔧 Useful Commands

```bash
# Buka console interaktif
php artisan tinker

# Clear semua cache
php artisan cache:clear && php artisan config:clear && php artisan view:clear

# Lihat semua routes
php artisan route:list

# Backup database
mysqldump -u root kwarran_bekasi > backup.sql

# Reset database dan seed ulang
php artisan migrate:refresh --seed

# Jalankan server di port berbeda
php artisan serve --port=8001
```

## 🗄️ Database Commands (Tinker)

```bash
php artisan tinker
```

```php
# Lihat semua kategori
App\Models\Category::all();

# Lihat semua berita
App\Models\Post::all();

# Lihat berita by kategori
App\Models\Post::where('category_id', 1)->get();

# Lihat berita yang dipublikasikan
App\Models\Post::where('is_published', true)->get();

# Update berita
$post = App\Models\Post::find(1);
$post->update(['title' => 'Judul Baru']);

# Hapus berita
App\Models\Post::find(1)->delete();

# Exit tinker
exit
```

## 🚨 Jika Ada Error

### Blank Page
```bash
php artisan config:clear
php artisan view:clear
```

### Database Error
- Pastikan MySQL berjalan
- Cek file `.env` - pastikan database config benar
- Cek database `kwarran_bekasi` sudah ada

### Port 8000 Sudah Terpakai
```bash
php artisan serve --port=8001
```

### Missing Views
```bash
php artisan view:clear
php artisan cache:clear
```

## 📱 Responsif Design

Website sudah responsive dan mobile-friendly dengan Bootstrap 5. Tested on:
- Desktop (Chrome, Firefox, Edge)
- Tablet (iPad, Android tablets)
- Mobile (iPhone, Android phones)

## 🔐 Security Notes

- Default tidak ada authentication
- Jangan expose `.env` file ke public
- Untuk production, gunakan `php artisan config:cache`
- Update PHP dan Laravel ke versi terbaru

## 📞 Need Help?

Lihat dokumentasi lengkap di `README.md` file.

---

**Happy Coding! 🎉**

# Kwarran Bekasi Timur Website

Website resmi Kwarran (Kwartir Ranting) Pramuka Bekasi Timur yang dibangun dengan Laravel dan MySQL.

## Fitur Utama

- **Homepage** - Menampilkan berita terbaru dan informasi penting
- **Manajemen Berita** - Create, Read, Update, Delete (CRUD) berita dengan kategori
- **Kategori Berita** - Organisasi berita berdasarkan kategori
- **Halaman Statis** - Halaman tentang, visi misi, struktur organisasi, kontak, dll
- **Responsive Design** - Desain yang responsive dan mobile-friendly menggunakan Bootstrap 5
- **SEO Friendly** - URL slug yang SEO friendly

## Persyaratan Sistem

- PHP >= 8.0
- Composer
- MySQL >= 5.7 atau MariaDB
- Node.js dan npm (opsional, hanya untuk asset compilation)

## Instalasi

### 1. Lokasi Project
```bash
d:\xampp\htdocs\kwarran
```

### 2. Setup Environment File
File `.env` sudah dikonfigurasi dengan:
- Database: MySQL
- Database Name: `kwarran_bekasi`
- Database User: `root`
- Database Password: (kosong)

### 3. Database Sudah Siap
- Database sudah dibuat
- Migrations sudah dijalankan
- Data sampel sudah diisi (seeders)

### 4. Jalankan Development Server
```bash
php artisan serve
```

Server akan berjalan di: `http://localhost:8000`

## Struktur Database

### Tabel Categories
- `id` - Primary Key
- `name` - Nama kategori
- `slug` - URL slug
- `description` - Deskripsi kategori
- `timestamps` - Created at & Updated at

### Tabel Posts
- `id` - Primary Key
- `title` - Judul berita
- `slug` - URL slug
- `content` - Konten berita (HTML)
- `excerpt` - Ringkasan berita
- `featured_image` - Gambar utama
- `category_id` - Foreign Key ke categories
- `author` - Nama penulis
- `published_at` - Waktu publikasi
- `is_published` - Status publikasi (true/false)
- `timestamps` - Created at & Updated at

### Tabel Pages
- `id` - Primary Key
- `title` - Judul halaman
- `slug` - URL slug
- `content` - Konten halaman (HTML)
- `featured_image` - Gambar utama
- `is_published` - Status publikasi (true/false)
- `timestamps` - Created at & Updated at

## Routing

### Public Routes
- `/` - Halaman utama (Home)
- `/berita` - Daftar semua berita
- `/berita/{slug}` - Detail berita
- `/kategori/{slug}` - Berita berdasarkan kategori
- `/{slug}` - Halaman statis (tentang, kontak, dll)

## Data Sampel yang Tersedia

Database sudah diisi dengan data sampel meliputi:
- 5 Kategori berita (Berita Umum, Kegiatan, Pendidikan, Pengumuman, Prestasi)
- 5 Berita dengan konten lengkap
- 4 Halaman statis (Tentang Kami, Visi & Misi, Struktur Organisasi, Kontak)

## Menambah Konten

### Menggunakan Tinker (REPL)
```bash
php artisan tinker

# Tambah kategori baru
App\Models\Category::create(['name' => 'Kategori Baru', 'slug' => 'kategori-baru', 'description' => 'Deskripsi...']);

# Tambah berita
App\Models\Post::create([
    'title' => 'Judul Berita',
    'slug' => 'judul-berita',
    'content' => '<p>Konten berita...</p>',
    'excerpt' => 'Ringkasan...',
    'category_id' => 1,
    'author' => 'Nama Penulis',
    'published_at' => now(),
    'is_published' => true,
]);

# Tambah halaman
App\Models\Page::create([
    'title' => 'Judul Halaman',
    'slug' => 'judul-halaman',
    'content' => '<p>Konten...</p>',
    'is_published' => true,
]);
```

## Struktur Folder

```
kwarran/
├── app/
│   ├── Models/
│   │   ├── Post.php
│   │   ├── Category.php
│   │   └── Page.php
│   └── Http/
│       └── Controllers/
│           ├── HomeController.php
│           ├── PostController.php
│           ├── CategoryController.php
│           └── PageController.php
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── posts/
│       │   ├── index.blade.php
│       │   └── show.blade.php
│       ├── categories/
│       │   └── show.blade.php
│       ├── pages/
│       │   └── show.blade.php
│       └── home.blade.php
├── routes/
│   └── web.php
├── .env
└── README.md
```

## Customization

### Mengubah Warna/Styling
Edit file `resources/views/layouts/app.blade.php` dan ubah CSS variables:

```css
:root {
    --primary-color: #1a472a;  /* Warna hijau Pramuka */
    --secondary-color: #e74c3c; /* Warna merah */
    --accent-color: #f39c12;    /* Warna kuning */
}
```

### Mengubah Logo/Nama Website
Edit navbar brand di `resources/views/layouts/app.blade.php`:

```blade
<a class="navbar-brand" href="{{ route('home') }}">
    <i class="fas fa-campground"></i> Kwarran Bekasi Timur
</a>
```

### Mengubah Informasi Kontak/Footer
Edit footer di `resources/views/layouts/app.blade.php` di bagian akhir file

## Maintenance

### Backup Database
```bash
mysqldump -u root kwarran_bekasi > kwarran_backup_$(date +%Y%m%d_%H%M%S).sql
```

### Restore Database
```bash
mysql -u root kwarran_bekasi < kwarran_backup_20260220_120000.sql
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Reset Database (hapus semua data dan seeding ulang)
```bash
php artisan migrate:refresh --seed
```

## Troubleshooting

### Database Connection Error
- Pastikan MySQL berjalan
- Cek konfigurasi di `.env` file
- Cek database `kwarran_bekasi` sudah dibuat

### View Not Found
```bash
php artisan view:clear
```

### Class Not Found Error
```bash
composer dump-autoload
```

### Port 8000 Sudah Terpakai
```bash
php artisan serve --port=8001
```

## Development Next Steps

- [ ] Admin Panel (Create, Edit, Delete berita dan halaman)
- [ ] User Authentication & Authorization
- [ ] Image Upload & Gallery Management
- [ ] Advanced Search Functionality
- [ ] Comments/Discussion System
- [ ] Email Newsletter
- [ ] Social Media Integration
- [ ] Analytics Dashboard
- [ ] Backup Management
- [ ] API untuk mobile app

## Useful Commands

```bash
# List semua routes
php artisan route:list

# Create database backup
php artisan tinker
>>> exec('mysqldump -u root kwarran_bekasi > backup.sql');

# Check PHP & MySQL version
php -v
mysql -u root -e "SELECT VERSION();"

# Install node dependencies (jika update CSS/JS)
npm install
npm run dev
```

## Support & Resources

- Laravel Documentation: https://laravel.com/docs
- Bootstrap Documentation: https://getbootstrap.com/docs
- MySQL Documentation: https://dev.mysql.com/doc/
- Pramuka Official: https://pramuka.or.id

## License

MIT License - Kwarran Bekasi Timur

---

**Versi:** 1.0  
**Terakhir diupdate:** Februari 2026  
**Build with:** Laravel 11, MySQL, Bootstrap 5

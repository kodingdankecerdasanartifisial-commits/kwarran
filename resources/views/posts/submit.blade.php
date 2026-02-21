@extends('layouts.public')

@section('title', 'Kirim Berita - ' . config('app.name'))

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="mb-5">
            <h1 class="fw-bold border-bottom pb-3 mb-4">Kirim Berita</h1>
            
            <div class="alert alert-light border shadow-sm mb-4">
                <p>Kakak-kakak bisa mengirimkan tulisan melalui form yang kami sediakan ini. Tulisan bisa berupa artikel kepramukaan atau liputan/berita kegiatan pramuka di wilayah Kwarran Bekasi Timur. Untuk penulisan berita silakan dipenuhi unsur-unsur 5W1H-nya sebagai berikut :</p>
                <div class="row">
                    <div class="col-md-6">
                        <ul class="mb-2">
                            <li><strong>What :</strong> Apa yang terjadi?</li>
                            <li><strong>Who :</strong> Siapa yang terlibat dalam peristiwa itu?</li>
                            <li><strong>Why :</strong> Mengapa hal itu bisa terjadi?</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="mb-2">
                            <li><strong>When :</strong> Kapan peristiwa itu terjadi?</li>
                            <li><strong>Where :</strong> Di mana peristiwa itu terjadi?</li>
                            <li><strong>How :</strong> Bagaimana peristiwa itu terjadi?</li>
                        </ul>
                    </div>
                </div>
                
                <hr>
                <h6 class="fw-bold"><i class="fas fa-info-circle me-1 text-primary"></i> Panduan Singkat</h6>
                <ol class="mb-0 small ps-3">
                    <li class="mb-1">Isilah formulir dengan lengkap.</li>
                    <li class="mb-1">Tulislah Judul yang menarik, singkat, padat, serta <strong>TIDAK</strong> menggunakan huruf besar semua.</li>
                    <li class="mb-1">Sesuaikan dengan kategori-kategori yang tersedia.</li>
                    <li class="mb-1">Unggah 1 foto dengan file .jpg; Jika punya foto lebih dari satu, silakan sertakan link google drive pada isi berita.</li>
                    <li class="mb-1">Jika ada video dari Youtube, silakan bisa dicantumkan link-nya dalam isi berita.</li>
                    <li class="mb-1">Jangan sungkan menghubungi Kakak Humas Kwarran Bekasi Timur jika perlu bantuan.</li>
                    <li class="mb-1">Silakan pantau secara berkala, untuk mengetahui apakah tulisan sudah dipublikasikan.</li>
                </ol>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="card p-4 shadow-sm border-0">
                <form action="{{ route('posts.submit.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Judul Berita</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" required placeholder="Contoh: Kegiatan Perkemahan Sabtu Minggu">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Isi Berita</label>
                        <textarea name="content" rows="8" class="form-control" required placeholder="Tuliskan berita lengkap di sini...">{{ old('content') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Foto Kegiatan (Maks 2MB)</label>
                        <input type="file" name="featured_image" class="form-control" accept="image/*" required>
                        <div class="form-text">Format yang didukung: JPG, PNG, JPEG.</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Pengirim</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required placeholder="Nama Lengkap Anda">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email (untuk konfirmasi)</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required placeholder="email@contoh.com">
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary py-2 fw-bold"><i class="fas fa-paper-plane me-2"></i>Kirim Berita</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-lg-4">
        @include('layouts.sidebar')
    </div>
</div>
@endsection

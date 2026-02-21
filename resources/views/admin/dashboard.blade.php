@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Berita</h6>
                        <h2 class="mb-0">{{ $stats['posts'] }}</h2>
                    </div>
                    <i class="fas fa-newspaper fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Kategori</h6>
                        <h2 class="mb-0">{{ $stats['categories'] }}</h2>
                    </div>
                    <i class="fas fa-folder fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Halaman Statis</h6>
                        <h2 class="mb-0">{{ $stats['pages'] }}</h2>
                    </div>
                    <i class="fas fa-file-alt fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Pengguna</h6>
                        <h2 class="mb-0">{{ $stats['users'] }}</h2>
                    </div>
                    <i class="fas fa-users fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6 mb-4">
        <div class="card bg-indigo text-white h-100" style="background: #6610f2;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Database Gugus Depan</h6>
                        <h2 class="mb-0">{{ $stats['gudeps'] }} Pangkalan</h2>
                    </div>
                    <i class="fas fa-university fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card bg-teal text-white h-100" style="background: #20c997;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-uppercase mb-1">Total Anggota Terdata</h6>
                        <h2 class="mb-0">{{ number_format($stats['total_members']) }} Anggota</h2>
                    </div>
                    <i class="fas fa-id-card fa-3x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="m-0 fw-bold">Selamat Datang di Panel Admin Kwarran Bekasi Timur</h5>
            </div>
            <div class="card-body">
                <p>Gunakan menu di sebelah kiri untuk mengelola konten website Anda. Anda dapat menambah berita baru, mengelola kategori, dan mengubah isi halaman statis.</p>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>Tulis Berita Baru</a>
                    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-primary"><i class="fas fa-list me-2"></i>Lihat Semua Berita</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

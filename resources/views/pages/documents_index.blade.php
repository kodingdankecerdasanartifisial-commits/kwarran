@extends('layouts.public')

@section('title', 'Perpustakaan Dokumen - Kwarran Bekasi Timur')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Perpustakaan Dokumen</h1>
        <p class="text-muted">Kumpulan dokumen resmi, surat keputusan, dan arsip Kwarran Bekasi Timur</p>
        <div class="border-bottom border-warning border-4 w-25 mx-auto mt-3"></div>
    </div>

    <div class="row g-4">
        @forelse($documents as $item)
        <div class="col-md-6 col-lg-4">
            <div class="card h-100 border-0 shadow-sm rounded-4 hover-lift transition">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-danger bg-opacity-10 p-3 rounded-3 me-3">
                            <i class="fas fa-file-pdf text-danger fs-4"></i>
                        </div>
                        <h5 class="fw-bold m-0">{{ $item->title }}</h5>
                    </div>
                    <p class="text-muted small mb-4">
                        Dokumen resmi yang dapat diakses secara publik dalam format PDF.
                    </p>
                    <div class="mt-auto d-flex justify-content-between align-items-center">
                        <span class="small text-muted"><i class="far fa-calendar-alt me-1"></i> {{ $item->created_at->format('d M Y') }}</span>
                        <div class="btn-group">
                            <a href="{{ route('documents.public.show', $item->slug) }}" class="btn btn-primary btn-sm rounded-pill px-3 me-1">Buka</a>
                            <a href="{{ asset('storage/' . $item->file_path) }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3" download>
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="bg-light d-inline-block p-5 rounded-circle mb-3">
                <i class="fas fa-folder-open fa-4x text-muted opacity-25"></i>
            </div>
            <p class="text-muted">Belum ada dokumen publik yang tersedia saat ini.</p>
        </div>
        @endforelse
    </div>
</div>

<style>
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 1rem 3rem rgba(0,0,0,0.1) !important;
}
.transition {
    transition: all 0.3s ease;
}
</style>
@endsection

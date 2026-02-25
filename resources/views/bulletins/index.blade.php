@extends('layouts.public')

@section('title', 'Buletin - Kwarran Bekasi Timur')

@section('content')
<section class="py-5 bg-light">
    <div class="container">
        <div class="row mb-5 justify-content-center text-center">
            <div class="col-lg-8">
                <span class="badge bg-primary px-3 py-2 rounded-pill mb-3">PUBLIKASI TERBARU</span>
                <h1 class="fw-bold mb-3 display-4">Buletin Digital</h1>
                <p class="text-muted lead">Informasi terbaru, kegiatan, dan prestasi Kwartir Ranting Bekasi Timur dalam format buletin digital interaktif.</p>
                <div class="mx-auto bg-primary" style="width: 80px; height: 4px; border-radius: 2px;"></div>
            </div>
        </div>

        @if($bulletins->count() > 0)
        <div class="row g-4">
            @foreach($bulletins as $bulletin)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm transition-hover rounded-4 overflow-hidden bg-white">
                    <div class="position-relative">
                        {{-- Portrait Container (Aspect Ratio for A4/Portrait) --}}
                        <div class="bg-dark d-flex align-items-center justify-content-center" style="aspect-ratio: 1 / 1.414; overflow: hidden; background-color: #2c3e50 !important;">
                            @if($bulletin->cover_image)
                                <img src="{{ asset('storage/' . $bulletin->cover_image) }}" alt="{{ $bulletin->title }}" class="w-100 h-100" style="object-fit: contain; background-color: #f8f9fa;">
                            @else
                                <div class="text-center">
                                    <i class="fas fa-book-open fa-4x text-white opacity-25"></i>
                                    <p class="text-white opacity-50 mt-2 small">Tidak ada cover</p>
                                </div>
                            @endif
                            
                            {{-- Overlay on Hover --}}
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-0 hover-opacity-70 transition-all z-index-1 d-flex align-items-center justify-content-center">
                                <div class="text-center p-3">
                                    <h6 class="text-white fw-bold mb-3 d-none d-md-block">{{ $bulletin->title }}</h6>
                                    <a href="{{ route('bulletins.show', $bulletin->slug) }}" class="btn btn-primary rounded-pill px-4 shadow">
                                        <i class="fas fa-eye me-1"></i> Baca Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3 text-center">
                        <div class="small text-muted mb-1" style="font-size: 0.75rem;">
                            <i class="far fa-calendar-alt me-1"></i> {{ $bulletin->created_at->format('d M Y') }}
                        </div>
                        <h6 class="card-title fw-bold mb-0 text-truncate">{{ $bulletin->title }}</h6>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-5 d-flex justify-content-center">
            {{ $bulletins->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <div class="bg-white p-5 rounded-4 shadow-sm d-inline-block">
                <i class="fas fa-folder-open fa-4x text-muted mb-4"></i>
                <h4 class="fw-bold">Belum Ada Buletin</h4>
                <p class="text-muted">Maaf, saat ini belum ada buletin digital yang dipublikasikan.</p>
                <a href="{{ route('home') }}" class="btn btn-primary rounded-pill px-4 mt-3">Kembali ke Beranda</a>
            </div>
        </div>
        @endif
    </div>
</section>

<style>
    .transition-hover {
        transition: all 0.3s ease;
    }
    .transition-hover:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }
    .transition-hover:hover .hover-opacity-70 {
        opacity: 0.7 !important;
    }
    .transition-all {
        transition: all 0.3s ease-in-out;
    }
    .z-index-1 { z-index: 1; }
    .z-index-2 { z-index: 2; }
    .bg-gradient-dark {
        background: linear-gradient(180deg, rgba(0,0,0,0) 0%, rgba(0,0,0,0.8) 100%);
    }
</style>
@endsection

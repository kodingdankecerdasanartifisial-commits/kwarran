@extends('layouts.public')

@section('title', $album->name . ' - Galeri DKR')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dkr.index') }}">DKR</a></li>
            <li class="breadcrumb-item active" aria-current="page">Album: {{ $album->name }}</li>
        </ol>
    </nav>

    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-dark text-uppercase mb-2">{{ $album->name }}</h1>
        <p class="text-muted lead">{{ $album->description }}</p>
        <div class="badge bg-primary px-3 py-2 rounded-pill"><i class="fas fa-calendar-alt me-1"></i> {{ $album->created_at->format('d M Y') }}</div>
        <div class="badge bg-secondary px-3 py-2 rounded-pill"><i class="fas fa-camera me-1"></i> {{ $album->photos->count() }} Foto</div>
    </div>

    <div class="row g-3">
        @foreach($album->photos as $photo)
        <div class="col-md-4 col-lg-3 col-6">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden gallery-card h-100">
                <a href="{{ asset('storage/' . $photo->image) }}" data-lightbox="dkr-album" data-title="{{ $photo->caption }}">
                    <img src="{{ asset('storage/' . $photo->image) }}" class="img-fluid post-card-hover" style="height: 200px; width: 100%; object-fit: cover;" alt="Galeri">
                </a>
                @if($photo->caption)
                <div class="card-body p-2 text-center">
                    <small class="text-muted fst-italic">{{ $photo->caption }}</small>
                </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('dkr.index') }}" class="btn btn-outline-primary px-5 rounded-pill fw-bold">KEMBALI KE HALAMAN DKR</a>
    </div>
</div>

<style>
    .gallery-card { transition: all 0.3s ease; }
    .gallery-card:hover { transform: scale(1.02); }
    .post-card-hover { transition: all 0.3s ease; }
    .post-card-hover:hover { filter: brightness(0.8); }
</style>
@endsection

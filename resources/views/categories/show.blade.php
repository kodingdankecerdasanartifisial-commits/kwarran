@extends('layouts.public')

@section('title', 'Kategori: ' . $category->name . ' - Kwarran Bekasi Timur')

@section('content')
<!-- Page Header -->
<div class="hero py-5" style="padding: 60px 0 !important; margin-bottom: 40px;">
    <div class="container">
        <p class="mb-2"><i class="fas fa-folder me-2"></i>Kategori</p>
        <h1 class="fw-bold">{{ $category->name }}</h1>
        @if($category->description)
        <p class="lead">{{ $category->description }}</p>
        @endif
    </div>
</div>

<div class="container mb-5">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none" style="color: var(--primary-color);">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('posts.index') }}" class="text-decoration-none" style="color: var(--primary-color);">Berita</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-12">
            @if($isAgenda)
                <p class="text-muted mb-4 border-start border-warning border-4 ps-3">Menampilkan daftar <strong>Agenda Kegiatan</strong> Pramuka Kwarran Bekasi Timur.</p>
                
                @if($events->count() > 0)
                    @foreach($events as $event)
                    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                        <div class="card-body p-4">
                            <div class="row align-items-center">
                                <div class="col-md-auto text-center mb-3 mb-md-0">
                                    <div class="bg-light rounded-4 p-3" style="min-width: 100px;">
                                        <span class="d-block fw-bold fs-2 text-warning" style="line-height: 1;">{{ $event->event_date->format('d') }}</span>
                                        <span class="d-block text-uppercase fw-bold text-muted" style="font-size: 14px;">{{ $event->event_date->format('M Y') }}</span>
                                    </div>
                                </div>
                                <div class="col">
                                    <h4 class="fw-bold mb-2 text-dark">{{ $event->title }}</h4>
                                    <div class="d-flex flex-wrap gap-3 text-muted mb-3">
                                        <span><i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $event->location ?? 'Lokasi menyusul' }}</span>
                                        <span><i class="fas fa-clock text-primary me-2"></i>{{ $event->event_date->format('H:i') }} WIB</span>
                                    </div>
                                    @if($event->description)
                                        <p class="text-muted mb-0">{{ Str::limit(strip_tags($event->description), 200) }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <div class="mt-4">
                        {{ $events->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Belum ada agenda kegiatan terbaru saat ini.
                    </div>
                @endif
            @else
                <p class="text-muted mb-4 border-start border-warning border-4 ps-3">Menampilkan artikel dalam kategori <strong>{{ $category->name }}</strong></p>

                @if($posts->count() > 0)
                    @foreach($posts as $post)
                    <article class="card post-card mb-4">
                        <div class="row g-0">
                            @if($post->featured_image)
                            <div class="col-md-4">
                                <img src="{{ asset('storage/' . $post->featured_image) }}" class="img-fluid rounded-start h-100" alt="{{ $post->title }}" style="object-fit: cover;">
                            </div>
                            @endif
                            <div class="col-md-{{ $post->featured_image ? '8' : '12' }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="post-category">{{ $category->name }}</span>
                                        <small class="text-muted"><i class="far fa-calendar-alt me-1"></i> {{ $post->published_at?->format('d M Y') }}</small>
                                    </div>
                                    <h5 class="card-title fw-bold">
                                        <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none text-dark">
                                            {{ $post->title }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-secondary"><i class="fas fa-user me-1"></i> {{ $post->author }}</small>
                                        <a href="{{ route('posts.show', $post->slug) }}" class="fw-bold text-decoration-none" style="color: var(--primary-color);">BACA SELENGKAPNYA <i class="fas fa-arrow-right ms-1"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach
                    
                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                @else
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle"></i> Belum ada artikel dalam kategori ini.
                </div>
                @endif
            @endif
        </div>
    </div>
</div>
@endsection


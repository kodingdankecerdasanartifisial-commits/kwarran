@extends('layouts.public')

@section('title', 'Semua Berita - Kwarran Bekasi Timur')

@section('content')

<div class="container mb-5">
    <div class="row">
        <!-- Main Content -->
        <!-- Main Content -->
        <div class="col-lg-8">
            <h2 class="fw-bold mb-4 border-bottom pb-2" style="border-color: var(--secondary-color) !important;">Berita Terbaru</h2>
            @if($posts->count() > 0)
                <div class="row">
                @foreach($posts as $post)
                <div class="col-md-12 mb-4">
                    <article class="card h-100 border-0 shadow-sm overflow-hidden flex-row">
                        @php
                            $thumbnail = null;
                            if ($post->featured_image) {
                                $thumbnail = asset('storage/' . $post->featured_image);
                            } elseif ($post->youtube_url) {
                                preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $post->youtube_url, $matches);
                                if (isset($matches[1])) {
                                    $thumbnail = "https://img.youtube.com/vi/{$matches[1]}/mqdefault.jpg";
                                }
                            }
                        @endphp

                        @if($thumbnail)
                        <div class="col-4 position-relative overflow-hidden">
                            <img src="{{ $thumbnail }}" class="img-fluid w-100 h-100" alt="{{ $post->title }}" style="object-fit: cover;">
                            @if($post->category)
                            <div class="position-absolute top-0 start-0 bg-warning text-dark px-2 py-1 small fw-bold m-2 rounded">{{ $post->category->name }}</div>
                            @endif
                            @if(!$post->featured_image && $post->youtube_url)
                            <div class="position-absolute top-50 start-50 translate-middle">
                                <i class="fab fa-youtube fa-3x text-danger bg-white rounded-circle p-1"></i>
                            </div>
                            @endif
                        </div>
                        @endif
                        <div class="col-{{ $thumbnail ? '8' : '12' }}">
                            <div class="card-body d-flex flex-column h-100 p-3">
                                <div class="text-muted small mb-2">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $post->published_at?->format('d M Y') }}
                                    <span class="mx-1">•</span>
                                    <i class="far fa-user me-1"></i> {{ $post->author }}
                                </div>
                                <h5 class="card-title fw-bold mb-2">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none text-dark stretched-link">
                                        {{ Str::limit($post->title, 60) }}
                                    </a>
                                </h5>
                                <p class="card-text text-muted small mb-3 flex-grow-1">{{ Str::limit(strip_tags($post->excerpt ?? $post->content), 100) }}</p>
                                <div class="mt-auto">
                                    <span class="text-primary fw-bold small">Baca Selengkapnya <i class="fas fa-arrow-right ms-1"></i></span>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-4">
                    {{ $posts->links() }}
                </div>
            @else
            <div class="alert alert-info py-4" role="alert">
                <div class="text-center">
                    <i class="fas fa-newspaper fa-3x mb-3 text-info opacity-50"></i>
                    <h5 class="alert-heading fw-bold">Belum Ada Berita</h5>
                    <p class="mb-0">Saat ini belum ada artikel berita yang tersedia. Silakan kembali lagi nanti.</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            @include('layouts.sidebar')
        </div>

    </div>
</div>
@endsection


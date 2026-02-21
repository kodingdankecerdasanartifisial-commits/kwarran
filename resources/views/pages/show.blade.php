@extends('layouts.public')

@section('title', $page->title . ' - Kwarran Bekasi Timur')

@section('content')
<!-- Page Header -->
<section class="page-hero position-relative text-white" style="margin-bottom: 40px;">
    @if($page->featured_image)
        <div class="hero-bg" style="background-image: linear-gradient(rgba(0,0,0,0.45), rgba(0,0,0,0.45)), url('{{ asset('storage/' . $page->featured_image) }}'); background-size: cover; background-position: center; padding: 80px 0;">
            <div class="container">
                <h1 class="fw-bold display-5">{{ $page->title }}</h1>
            </div>
        </div>
    @else
        <div class="hero-bg bg-secondary py-5">
            <div class="container">
                <h1 class="fw-bold display-5">{{ $page->title }}</h1>
            </div>
        </div>
    @endif
</section>

<div class="row">
    <div class="col-lg-8">
        <div class="mb-5">
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none" style="color: var(--primary-color);">Beranda</a></li>
                    <li class="breadcrumb-item active">{{ $page->title }}</li>
                </ol>
            </nav>

            <article class="card border-0 shadow-sm rounded-3 overflow-hidden mb-4">
                @if($page->featured_image)
                <img src="{{ asset('storage/' . $page->featured_image) }}" class="img-fluid w-100" alt="{{ $page->title }}" style="max-height: 400px; object-fit: cover;">
                @endif

                <div class="card-body p-4 p-md-5">
                    <h1 class="fw-bold mb-4 border-bottom pb-3">{{ $page->title }}</h1>

                    <!-- Page Content -->
                    <div class="page-content">
                        {!! $page->content !!}
                    </div>

                    <!-- Last Updated -->
                    <div class="mt-5 pt-3 border-top text-muted">
                        <small><i class="far fa-clock me-1"></i> Terakhir diperbarui pada: {{ $page->updated_at->format('d F Y') }}</small>
                    </div>
                </div>
            </article>
        </div>
    </div>
    <div class="col-lg-4">
        @include('layouts.sidebar')
    </div>
</div>

<style>
    .page-content {
        line-height: 1.8;
        font-size: 1.1rem;
        color: #333;
    }
    .page-content p { margin-bottom: 1.5rem; }
    .page-content img {
        max-width: 100%;
        height: auto;
        margin: 20px 0;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .page-content h2, .page-content h3 {
        margin-top: 30px;
        margin-bottom: 20px;
        font-weight: 700;
        color: var(--primary-color);
    }
    .page-content table {
        width: 100%;
        margin: 30px 0;
        border-collapse: collapse;
    }
    .page-content table th, .page-content table td {
        padding: 15px;
        border: 1px solid #eee;
    }
    .page-content table th {
        background-color: #f8f9fa;
        font-weight: 700;
    }
    .page-content blockquote {
        background: #f9f9f9;
        border-left: 5px solid var(--secondary-color);
        padding: 20px 30px;
        margin: 30px 0;
        font-style: italic;
        font-size: 1.2rem;
    }

    /* Narrow the main article content for better readability */
    .layout-main .card-body {
        max-width: 720px;
    }

    /* Hero adjustments */
    .page-hero .hero-bg { border-bottom: 6px solid var(--secondary-color); }
    .page-hero .display-5 { color: #fff; }
</style>
@endsection


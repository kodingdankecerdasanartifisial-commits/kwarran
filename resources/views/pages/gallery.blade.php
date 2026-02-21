@extends('layouts.public')

@section('title', 'Galeri Kegiatan - Kwarran Bekasi Timur')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Galeri Kegiatan</h1>
        <p class="text-muted">Dokumentasi momen dan kegiatan Kwartir Ranting Bekasi Timur</p>
        <div class="border-bottom border-warning border-4 w-25 mx-auto mt-3"></div>
    </div>

    <!-- Nav Tabs -->
    <ul class="nav nav-pills justify-content-center mb-5 gap-2" id="galleryTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active rounded-pill px-4 fw-bold shadow-sm" id="photo-tab" data-bs-toggle="tab" data-bs-target="#photo-pane" type="button" role="tab">
                <i class="fas fa-camera me-2"></i> Foto
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link rounded-pill px-4 fw-bold shadow-sm" id="video-tab" data-bs-toggle="tab" data-bs-target="#video-pane" type="button" role="tab">
                <i class="fas fa-video me-2"></i> Video
            </button>
        </li>
    </ul>

    <div class="tab-content" id="galleryTabContent">
        <!-- Photo Pane -->
        <div class="tab-pane fade show active" id="photo-pane" role="tabpanel" tabindex="0">
            <div class="row g-4">
                @forelse($photos as $title => $items)
                <div class="col-6 col-md-4 col-lg-3">
                    @php 
                        $firstItem = $items->first(); 
                        $groupName = 'gallery-' . Str::slug($title);
                    @endphp
                    
                    <div class="album-wrapper mb-4">
                        <div class="album-cover-container rounded-4 shadow-sm overflow-hidden position-relative mb-2" style="height: 200px;">
                            @if($firstItem->image)
                                <img src="{{ asset('storage/' . $firstItem->image) }}" class="img-fluid w-100 h-100 object-fit-cover transition">
                                
                                <!-- Link trigger for the first photo (Cover) -->
                                <a href="{{ asset('storage/' . $firstItem->image) }}" 
                                   data-lightbox="{{ $groupName }}" 
                                   data-title="{{ $title }}"
                                   class="stretched-link d-flex align-items-center justify-content-center text-decoration-none overlay-hover">
                                    <i class="fas fa-search-plus text-white fa-2x opacity-0 transition"></i>
                                </a>
                            @else
                                <a href="{{ $firstItem->external_link }}" target="_blank" class="d-block bg-primary bg-opacity-10 text-center py-4 h-100 text-decoration-none rounded-4">
                                    <i class="fab fa-google-drive fa-3x text-primary mb-2 mt-4"></i>
                                    <div class="small fw-bold text-primary">Buka Drive</div>
                                </a>
                            @endif
                        </div>

                        <!-- Hidden links for the REST of the photos in the album -->
                        @if($firstItem->image)
                            <div class="hidden-gallery-links">
                                @foreach($items as $index => $photo)
                                    @if($index > 0)
                                        <a href="{{ asset('storage/' . $photo->image) }}" 
                                           data-lightbox="{{ $groupName }}" 
                                           data-title="{{ $title }}" 
                                           class="d-none"></a>
                                    @endif
                                @endforeach
                            </div>
                        @endif
                        
                        <!-- Album Title -->
                        <div class="album-info px-1">
                            <h6 class="fw-bold mb-0 text-dark text-truncate" title="{{ $title }}">{{ $title }}</h6>
                            <small class="text-muted"><i class="fas fa-images me-1"></i> {{ $items->count() }} Foto</small>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada koleksi foto.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Video Pane -->
        <div class="tab-pane fade" id="video-pane" role="tabpanel" tabindex="0">
            <div class="row g-4">
                @forelse($videos as $video)
                <div class="col-md-6 col-lg-4">
                    <div class="video-item rounded-4 shadow-sm overflow-hidden bg-white h-100">
                        <div class="ratio ratio-16x9">
                            <iframe src="https://www.youtube.com/embed/{{ $video->external_link }}" title="{{ $video->title }}" allowfullscreen></iframe>
                        </div>
                        <div class="p-3">
                            <h6 class="fw-bold mb-1">{{ $video->title }}</h6>
                            <p class="small text-muted mb-0">{{ Str::limit($video->description, 80) }}</p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada koleksi video.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<style>
.gallery-item img:hover {
    transform: scale(1.1);
}
.album-cover-container {
    height: 220px !important;
    width: 100% !important;
    background-color: #f8f9fa;
    display: block !important;
}
.album-cover-container img {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
}
.overlay-hover:hover {
    background: rgba(0,0,0,0.3);
}
.overlay-hover:hover i {
    opacity: 1 !important;
}
.transition {
    transition: all 0.3s ease;
}
.nav-pills .nav-link.active {
    background-color: var(--primary-color) !important;
}
.nav-pills .nav-link {
    color: var(--primary-color);
    background: white;
}
</style>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css">
<style>
    .lb-outerContainer { background-color: #000; border-radius: 8px 8px 0 0; }
    .lb-dataContainer { background-color: #fff; border-radius: 0 0 8px 8px; padding: 10px; }
    .lb-image { border-radius: 4px; }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script>
    lightbox.option({
        'resizeDuration': 0,
        'fadeDuration': 200,
        'wrapAround': true,
        'fitImagesInViewport': true
    });
</script>
@endpush
@endsection

@extends('layouts.public')

@section('title', 'Download Area - Kwarran Bekasi Timur')

@section('content')
<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <h2 class="fw-bold mb-4 border-bottom pb-2" style="border-color: var(--secondary-color) !important;">Download Area</h2>
        
        <div class="alert alert-light border shadow-sm mb-4">
            <i class="fas fa-info-circle me-2 text-primary"></i> 
            Pilih dan unduh dokumen atau file yang Anda butuhkan di bawah ini.
        </div>

        @if($downloads->count() > 0)
            <div class="list-group shadow-sm mb-4">
                @foreach($downloads as $download)
                <div class="list-group-item list-group-item-action p-3 border-0 border-bottom">
                    <div class="d-flex w-100 justify-content-between align-items-center">
                        <div class="pe-3">
                            <h5 class="mb-1 text-primary fw-bold">
                                <i class="fas fa-file-alt me-2 text-muted"></i> {{ $download->title }}
                            </h5>
                            @if($download->description)
                                <p class="mb-1 text-muted small">{{ $download->description }}</p>
                            @endif
                            <small class="text-secondary">
                                <i class="fas fa-cloud-download-alt me-1"></i> {{ $download->downloads_count }}x diunduh
                                <span class="mx-1">•</span>
                                {{ $download->created_at->format('d M Y') }}
                            </small>
                        </div>
                        <div>
                            @if($download->external_url)
                                <a href="{{ route('downloads.download', $download->id) }}" class="btn btn-outline-primary btn-sm rounded-pill px-3 fw-bold" target="_blank">
                                    <i class="fas fa-external-link-alt me-1"></i> Buka Link
                                </a>
                            @else
                                <a href="{{ route('downloads.download', $download->id) }}" class="btn btn-primary btn-sm rounded-pill px-3 fw-bold" target="_blank">
                                    <i class="fas fa-download me-1"></i> Unduh
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-4">
                {{ $downloads->links() }}
            </div>
        @else
            <div class="alert alert-info py-4" role="alert">
                <div class="text-center">
                    <i class="fas fa-folder-open fa-3x mb-3 text-info opacity-50"></i>
                    <h5 class="alert-heading fw-bold">Belum Ada File</h5>
                    <p class="mb-0">Saat ini belum ada file yang tersedia untuk diunduh.</p>
                </div>
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        @include('layouts.sidebar')
    </div>
</div>
@endsection

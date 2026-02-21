@extends('layouts.public')

@section('title', $document->title . ' - Kwarran Bekasi Timur')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white p-4 border-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold mb-1">{{ $document->title }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('home') }}">Beranda</a></li>
                                <li class="breadcrumb-item active">Lihat Dokumen</li>
                            </ol>
                        </nav>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('documents.public.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                            <i class="fas fa-list me-2"></i> Semua Dokumen
                        </a>
                        <a href="{{ asset('storage/' . $document->file_path) }}" class="btn btn-primary rounded-pill px-4" download>
                            <i class="fas fa-download me-2"></i> Download PDF
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <!-- PDF Embed -->
                    <div style="height: 800px; background: #525659;">
                        <iframe src="{{ asset('storage/' . $document->file_path) }}#toolbar=0" width="100%" height="100%" style="border: none;"></iframe>
                    </div>
                </div>
                <div class="card-footer bg-light p-4 text-center">
                    <p class="small text-muted mb-0">Dipublikasikan pada: {{ $document->created_at->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

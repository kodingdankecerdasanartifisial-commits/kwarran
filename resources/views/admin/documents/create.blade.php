@extends('layouts.admin')

@section('page_title', 'Upload Dokumen Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="m-0 fw-bold">Form Upload PDF</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Dokumen</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" placeholder="Contoh: SK Pengurus Kwarran 2026" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">File PDF</label>
                        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".pdf" required>
                        <small class="text-muted">Maksimal ukuran file: 10MB</small>
                        @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" checked>
                            <label class="form-check-label fw-bold" for="is_published">Publikasikan Langsung</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Upload & Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

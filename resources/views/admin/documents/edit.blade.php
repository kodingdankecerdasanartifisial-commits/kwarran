@extends('layouts.admin')

@section('page_title', 'Edit Dokumen')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="m-0 fw-bold">Update Dokumen PDF</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.documents.update', $document->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Dokumen</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $document->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Ganti File PDF (Opsional)</label>
                        <input type="file" name="file" class="form-control @error('file') is-invalid @enderror" accept=".pdf">
                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti file. Maksimal 10MB.</small>
                        @error('file')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_published" id="is_published" value="1" {{ $document->is_published ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold" for="is_published">Publikasikan</label>
                        </div>
                    </div>

                    <div class="bg-light p-3 rounded mb-4">
                        <small class="text-muted d-block mb-1">Link Saat Ini:</small>
                        <a href="{{ route('documents.public.show', $document->slug) }}" target="_blank" class="small fw-bold">{{ route('documents.public.show', $document->slug) }}</a>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

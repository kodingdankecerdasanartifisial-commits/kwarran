@extends('layouts.admin')

@section('title', 'Edit Download')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit File: {{ $download->title }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.downloads.index') }}" class="btn btn-sm btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body">
                <form action="{{ route('admin.downloads.update', $download->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul File</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $download->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi (Opsional)</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $download->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Jenis Sumber</label>
                        <div class="d-flex gap-4 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="source_type" id="source_upload" value="upload" {{ $download->file_path ? 'checked' : '' }}>
                                <label class="form-check-label" for="source_upload">Upload File</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="source_type" id="source_link" value="link" {{ $download->external_url ? 'checked' : '' }}>
                                <label class="form-check-label" for="source_link">Link Eksternal</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3" id="upload_section" style="{{ $download->external_url ? 'display: none;' : '' }}">
                        <label for="file_path" class="form-label">Ganti File (Opsional)</label>
                        @if($download->file_path)
                            <div class="mb-2 text-muted small">File saat ini: <a href="{{ Storage::url($download->file_path) }}" target="_blank">{{ basename($download->file_path) }}</a></div>
                        @endif
                        <input class="form-control @error('file_path') is-invalid @enderror" type="file" id="file_path" name="file_path">
                        <div class="form-text">Biarkan kosong jika tidak ingin mengubah file. Maks 50MB.</div>
                        @error('file_path')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="link_section" style="{{ $download->file_path ? 'display: none;' : '' }}">
                        <label for="external_url" class="form-label">Link Eksternal</label>
                        <input type="url" class="form-control @error('external_url') is-invalid @enderror" id="external_url" name="external_url" value="{{ old('external_url', $download->external_url) }}" placeholder="https://drive.google.com/...">
                        <div class="form-text">Masukkan URL lengkap ke file eksternal.</div>
                        @error('external_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const radioUpload = document.getElementById('source_upload');
                            const radioLink = document.getElementById('source_link');
                            const uploadSection = document.getElementById('upload_section');
                            const linkSection = document.getElementById('link_section');

                            function toggleSections() {
                                if (radioUpload.checked) {
                                    uploadSection.style.display = 'block';
                                    linkSection.style.display = 'none';
                                } else {
                                    uploadSection.style.display = 'none';
                                    linkSection.style.display = 'block';
                                }
                            }

                            radioUpload.addEventListener('change', toggleSections);
                            radioLink.addEventListener('change', toggleSections);
                        });
                    </script>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ old('is_active', $download->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Aktifkan File (Tampilkan di Publik)</label>
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

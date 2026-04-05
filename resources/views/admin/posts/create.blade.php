@extends('layouts.admin')

@section('page_title', $isMateri ? 'Tambah Materi Pembelajaran' : 'Tambah Berita Baru')

@section('content')
<form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="post_type" value="{{ $isMateri ? 'materi' : 'berita' }}">
    @csrf
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Judul Berita</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label fw-bold">Isi Berita</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="15">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="m-0 fw-bold">Pengaturan</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Kategori</label>
                        <div class="category-list p-3 border rounded shadow-sm bg-light" style="max-height: 200px; overflow-y: auto;">
                            @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="category_ids[]" value="{{ $category->id }}" id="cat_{{ $category->id }}" {{ (is_array(old('category_ids')) && in_array($category->id, old('category_ids'))) || ($selectedCategoryId == $category->id) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cat_{{ $category->id }}">
                                        {{ $category->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('category_ids')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label fw-bold">Ringkasan (Opsional)</label>
                        <textarea class="form-control" id="excerpt" name="excerpt" rows="3">{{ old('excerpt') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="featured_image" class="form-label fw-bold">Gambar Unggulan</label>
                        <input type="file" class="form-control @error('featured_image') is-invalid @enderror" id="featured_image" name="featured_image" accept="image/jpeg,image/png,image/jpg,image/webp">
                        <small class="text-muted">Format: JPG, PNG, WEBP. Maks: 2MB.</small>
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="youtube_url" class="form-label fw-bold">Link Video YouTube {{ $isMateri ? '' : '(Opsional)' }}</label>
                        <input type="url" class="form-control @error('youtube_url') is-invalid @enderror" id="youtube_url" name="youtube_url" value="{{ old('youtube_url') }}" placeholder="https://www.youtube.com/watch?v=...">
                        <small class="text-muted">Masukkan link lengkap video YouTube.</small>
                        @error('youtube_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="embed_code" class="form-label fw-bold">Embed HTML / Multimedia (Opsional)</label>
                        <textarea class="form-control" id="embed_code" name="embed_code" rows="3" placeholder="Paste embed code (iframe, etc.) here">{{ old('embed_code') }}</textarea>
                        <small class="text-muted">Gunakan untuk menempelkan kode iframe dari YouTube, Google Drive, atau Peta.</small>
                    </div>

                    @if($isMateri)
                    <div class="mb-3">
                        <label for="material_pdf" class="form-label fw-bold">Lampiran Materi (PDF)</label>
                        <input type="file" class="form-control @error('material_pdf') is-invalid @enderror" id="material_pdf" name="material_pdf" accept="application/pdf">
                        <small class="text-muted">Format: PDF. Maks: 5MB.</small>
                        @error('material_pdf')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @endif

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="is_published">Terbitkan Langsung</label>
                    </div>

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" id="is_html" name="is_html" value="1" {{ old('is_html') ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="is_html">Mode HTML (Custom Code)</label>
                        <br><small class="text-muted">Aktifkan jika Anda ingin memasukkan HTML, CSS, atau JS secara manual di isi berita.</small>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Simpan Berita</button>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>
<script>
    let editor;
    const isHtmlCheckbox = document.getElementById('is_html');
    
    function initEditor() {
        if (!isHtmlCheckbox.checked) {
            editor = CKEDITOR.replace('content', {
                height: 500,
                versionCheck: false
            });
        }
    }

    initEditor();

    isHtmlCheckbox.addEventListener('change', function() {
        if (this.checked) {
            if (editor) {
                editor.destroy();
                editor = null;
            }
        } else {
            initEditor();
        }
    });
</script>
@endsection

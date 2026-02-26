@extends('layouts.admin')

@section('page_title', 'Edit Berita')

@section('content')
<form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Judul Berita</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label fw-bold">Isi Berita</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="15">{{ old('content', $post->content) }}</textarea>
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
                            @php
                                $currentCategoryIds = $post->categories->pluck('id')->toArray();
                            @endphp
                            @foreach($categories as $category)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="category_ids[]" value="{{ $category->id }}" id="cat_{{ $category->id }}" {{ (is_array(old('category_ids')) && in_array($category->id, old('category_ids'))) || (!old('category_ids') && in_array($category->id, $currentCategoryIds)) ? 'checked' : '' }}>
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
                        <textarea class="form-control" id="excerpt" name="excerpt" rows="3">{{ old('excerpt', $post->excerpt) }}</textarea>
                    </div>

@php
    $isMateri = \Illuminate\Support\Str::startsWith($post->category->name, 'Materi');
@endphp

                    @if($isMateri)
                    <div class="mb-3">
                        <label for="material_pdf" class="form-label fw-bold">Lampiran Materi (PDF)</label>
                        @if($post->material_pdf)
                            <div class="mb-2">
                                <a href="{{ asset('storage/' . $post->material_pdf) }}" target="_blank" class="btn btn-sm btn-outline-secondary me-2"><i class="fas fa-file-pdf"></i> Lihat Lampiran</a>
                                <p class="small text-muted d-inline">File saat ini</p>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('material_pdf') is-invalid @enderror" id="material_pdf" name="material_pdf" accept="application/pdf">
                        <small class="text-muted">Unggah PDF materi (opsional). Maks: 5MB.</small>
                        @error('material_pdf')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="youtube_url" class="form-label fw-bold">Link Video YouTube</label>
                        <input type="url" class="form-control @error('youtube_url') is-invalid @enderror" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $post->youtube_url) }}" placeholder="https://www.youtube.com/watch?v=...">
                        <small class="text-muted">Masukkan link lengkap video YouTube untuk pembelajaran.</small>
                        @error('youtube_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @else
                    <div class="mb-3">
                        <label for="featured_image" class="form-label fw-bold">Gambar Unggulan</label>
                        @if($post->featured_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="Preview" class="img-thumbnail" style="max-height: 150px;">
                                <p class="small text-muted">Gambar saat ini</p>
                            </div>
                        @endif
                        <input type="file" class="form-control @error('featured_image') is-invalid @enderror" id="featured_image" name="featured_image" accept="image/*">
                        <small class="text-muted">Pilih jika ingin mengganti gambar. Format: JPG, PNG. Maks: 2MB</small>
                        @error('featured_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="youtube_url" class="form-label fw-bold">Link Video YouTube (Opsional)</label>
                        <input type="url" class="form-control @error('youtube_url') is-invalid @enderror" id="youtube_url" name="youtube_url" value="{{ old('youtube_url', $post->youtube_url) }}" placeholder="https://www.youtube.com/watch?v=...">
                        <small class="text-muted">Link pembelajaran tambahan (opsional).</small>
                        @error('youtube_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    @endif

                    <div class="form-check form-switch mb-4">
                        <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                        <label class="form-check-input-label fw-bold" for="is_published">Terbitkan</label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">Simpan Perubahan</button>
                        <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">Batal</a>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-body">
                    <small class="text-muted d-block mb-1">Dibuat: {{ $post->created_at->format('d/m/Y H:i') }}</small>
                    <small class="text-muted d-block">Penulis: {{ $post->author }}</small>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#content'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection

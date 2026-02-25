@extends('layouts.admin')

@section('page_title', 'Edit Buletin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.bulletins.update', $bulletin->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="title" class="form-label fw-bold">Judul Buletin <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $bulletin->title) }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="cover_image" class="form-label fw-bold">Cover Buletin</label>
                        @if($bulletin->cover_image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $bulletin->cover_image) }}" alt="Cover" class="img-thumbnail" style="max-height: 150px;">
                            </div>
                        @endif
                        <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image" accept="image/*">
                        <div class="form-text mt-2">
                             <i class="fas fa-info-circle me-1"></i> Upload gambar baru untuk mengganti cover sebelumnya. (Optional)
                        </div>
                        @error('cover_image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="embed_link" class="form-label fw-bold">Link Embed Canva <span class="text-danger">*</span></label>
                        <input type="url" class="form-control @error('embed_link') is-invalid @enderror" id="embed_link" name="embed_link" value="{{ old('embed_link', $bulletin->embed_link) }}" required>
                        <div class="form-text mt-2">
                             <i class="fas fa-info-circle me-1"></i> Masukkan link dari Canva (bisa link view atau link embed).
                        </div>
                        @error('embed_link')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label for="order" class="form-label fw-bold">Urutan Tampil</label>
                                <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', $bulletin->order) }}">
                                @error('order')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <label class="form-label fw-bold d-block">Status</label>
                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" {{ $bulletin->is_active ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">Aktifkan Buletin</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.bulletins.index') }}" class="btn btn-outline-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-5">Perbarui Buletin</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="m-0 fw-bold">Pratinjau Link</h6>
            </div>
            <div class="card-body">
                <div style="position: relative; width: 100%; height: 0; padding-top: 56.25%; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px 0 rgba(63,69,81,0.16); transition: all 0.3s ease-in-out;">
                    @php
                        $embed_url = $bulletin->embed_link;
                        if (str_contains($embed_url, '/view?')) {
                            $embed_url = str_replace('/view?', '/view?embed&', $embed_url);
                        } elseif (!str_contains($embed_url, 'embed')) {
                             if (str_contains($embed_url, '?')) {
                                $embed_url .= '&embed';
                             } else {
                                $embed_url .= '?embed';
                             }
                        }
                    @endphp
                    <iframe scrolling="no" title="Canva Preview" src="{{ $embed_url }}" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; border: none; padding: 0;margin: 0;" allowfullscreen="allowfullscreen" allow="fullscreen">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

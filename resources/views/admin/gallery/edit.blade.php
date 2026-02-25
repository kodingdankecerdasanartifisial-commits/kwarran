@extends('layouts.admin')

@section('page_title', 'Edit Galeri')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white p-4">
                <h5 class="m-0 fw-bold">Edit Item Galeri</h5>
            </div>
            <div class="card-body p-4">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Tipe Galeri</label>
                        <div class="d-flex gap-3">
                            <div class="form-check custom-option">
                                <input class="form-check-input" type="radio" name="type" id="typePhoto" value="photo" {{ $gallery->type === 'photo' ? 'checked' : 'disabled' }}>
                                <label class="form-check-label" for="typePhoto">
                                    <i class="fas fa-camera me-1"></i> Foto
                                </label>
                            </div>
                            <div class="form-check custom-option">
                                <input class="form-check-input" type="radio" name="type" id="typeVideo" value="video" {{ $gallery->type === 'video' ? 'checked' : 'disabled' }}>
                                <label class="form-check-label" for="typeVideo">
                                    <i class="fas fa-video me-1"></i> Video YouTube
                                </label>
                            </div>
                        </div>
                        <small class="text-muted">Tipe tidak dapat diubah setelah dibuat.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul/Nama Kegiatan</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $gallery->title) }}" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    @if($gallery->type === 'photo')
                        <div id="photoFields">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Link Google Drive / Album Eksternal (Opsional)</label>
                                <input type="url" name="external_link" class="form-control @error('external_link') is-invalid @enderror" value="{{ old('external_link', $gallery->external_link) }}" placeholder="https://photos.google.com/share/...">
                                <small class="text-muted">Gunakan ini jika foto disimpan di luar server (Google Drive/Photos).</small>
                                @error('external_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Upload Foto / Cover</label>
                                @if($gallery->image)
                                    <div class="mb-2">
                                        <p class="small mb-1 text-muted">Cover Saat Ini:</p>
                                        <img src="{{ asset('storage/' . $gallery->image) }}" alt="Current Image" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                @endif
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <small class="text-muted">
                                    @if($gallery->external_link)
                                        Unggah foto untuk dijadikan sampul (thumbnail) di halaman utama.
                                    @else
                                        Unggah file foto jika tidak menggunakan link eksternal.
                                    @endif
                                    (Biarkan kosong jika tidak ingin mengubah)
                                </small>
                            </div>
                        </div>
                    @else
                        <div id="videoFields">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Link YouTube / ID Video</label>
                                <input type="text" name="external_link" class="form-control @error('external_link') is-invalid @enderror" value="{{ old('external_link', 'https://www.youtube.com/watch?v=' . $gallery->external_link) }}" placeholder="Contoh: https://www.youtube.com/watch?v=xxxxxx">
                                @error('external_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <small class="text-muted">Masukkan URL lengkap atau cukup ID videonya saja.</small>
                            </div>
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="form-label fw-bold">Keterangan (Opsional)</label>
                        <textarea name="description" class="form-control" rows="3">{{ old('description', $gallery->description) }}</textarea>
                    </div>

                    <div class="d-flex justify-content-between pt-3 border-top">
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

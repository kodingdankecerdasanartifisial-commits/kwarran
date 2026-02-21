@extends('layouts.admin')

@section('page_title', 'Tambah Galeri')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-header bg-white p-4">
                <h5 class="m-0 fw-bold">Tambah Koleksi Baru</h5>
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
                <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Tipe Galeri</label>
                        <div class="d-flex gap-3">
                            <div class="form-check custom-option">
                                <input class="form-check-input" type="radio" name="type" id="typePhoto" value="photo" checked onclick="toggleFields('photo')">
                                <label class="form-check-label" for="typePhoto">
                                    <i class="fas fa-camera me-1"></i> Foto
                                </label>
                            </div>
                            <div class="form-check custom-option">
                                <input class="form-check-input" type="radio" name="type" id="typeVideo" value="video" onclick="toggleFields('video')">
                                <label class="form-check-label" for="typeVideo">
                                    <i class="fas fa-video me-1"></i> Video YouTube
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul/Nama Kegiatan</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required placeholder="Contoh: Jambore Ranting 2025">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div id="photoFields">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Upload Foto (Bisa banyak sekaligus)</label>
                            <input type="file" name="images[]" class="form-control @error('images.*') is-invalid @enderror" multiple accept="image/*">
                            @error('images.*')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Foto akan otomatis dikompresi untuk menghemat ruang server.</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">ATAU Link Google Drive/Photos</label>
                            <input type="url" name="external_link" class="form-control @error('external_link') is-invalid @enderror" value="{{ old('external_link') }}" placeholder="https://photos.google.com/share/...">
                            @error('external_link')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted">Gunakan ini jika ingin menghemat penyimpanan server sepenuhnya.</small>
                        </div>
                    </div>

                    <div id="videoFields" style="display: none;">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Link YouTube / ID Video</label>
                            <input type="text" name="external_link_video" class="form-control" placeholder="Contoh: https://www.youtube.com/watch?v=xxxxxx">
                            <small class="text-muted">Masukkan URL lengkap atau cukup ID videonya saja.</small>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Keterangan (Opsional)</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="d-flex justify-content-between pt-3 border-top">
                        <a href="{{ route('admin.gallery.index') }}" class="btn btn-secondary rounded-pill px-4">Batal</a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Galeri</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function toggleFields(type) {
    const photoFields = document.getElementById('photoFields');
    const videoFields = document.getElementById('videoFields');
    const extLink = document.querySelector('input[name="external_link"]');
    const extLinkVideo = document.querySelector('input[name="external_link_video"]');

    if (type === 'photo') {
        photoFields.style.display = 'block';
        videoFields.style.display = 'none';
        extLinkVideo.name = 'unused';
        extLink.name = 'external_link';
    } else {
        photoFields.style.display = 'none';
        videoFields.style.display = 'block';
        extLink.name = 'unused';
        extLinkVideo.name = 'external_link';
    }
}
</script>
@endsection

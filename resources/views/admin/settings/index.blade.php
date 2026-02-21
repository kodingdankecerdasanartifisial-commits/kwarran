@extends('layouts.admin')

@section('page_title', 'Pengaturan Website')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold">Pengaturan Website</h5>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-bold">Tentang Kwarran</label>
                <textarea name="about" rows="5" class="form-control">{{ old('about', $settings['about'] ?? '') }}</textarea>
            </div>

            <h5 class="mt-4">Sidebar Profile</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nama</label>
                    <input type="text" name="sidebar_profile_name" class="form-control" value="{{ old('sidebar_profile_name', $settings['sidebar_profile_name'] ?? '') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Link Profil</label>
                    <input type="url" name="sidebar_profile_link" class="form-control" value="{{ old('sidebar_profile_link', $settings['sidebar_profile_link'] ?? '') }}">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label fw-bold">Bio Singkat</label>
                    <input type="text" name="sidebar_profile_bio" class="form-control" value="{{ old('sidebar_profile_bio', $settings['sidebar_profile_bio'] ?? '') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Gambar Profil (opsional)</label>
                    <input type="file" name="sidebar_profile_image" class="form-control">
                    @if(!empty($settings['sidebar_profile_image']))
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $settings['sidebar_profile_image']) }}" alt="Preview" style="max-width:120px;">
                        </div>
                    @endif
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Judul Daftar Populer</label>
                <input type="text" name="sidebar_popular_title" class="form-control" value="{{ old('sidebar_popular_title', $settings['sidebar_popular_title'] ?? 'Sering Banget Dibaca') }}">
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Facebook</label>
                    <input type="url" name="social_facebook" class="form-control" value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Instagram</label>
                    <input type="url" name="social_instagram" class="form-control" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">YouTube</label>
                    <input type="url" name="social_youtube" class="form-control" value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">X (Twitter)</label>
                    <input type="url" name="social_x" class="form-control" value="{{ old('social_x', $settings['social_x'] ?? '') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label fw-bold">TikTok</label>
                    <input type="url" name="social_tiktok" class="form-control" value="{{ old('social_tiktok', $settings['social_tiktok'] ?? '') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Alamat</label>
                <input type="text" name="address" class="form-control" value="{{ old('address', $settings['address'] ?? '') }}">
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nomor Telepon</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $settings['phone'] ?? '') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $settings['email'] ?? '') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Embed Maps (iframe)</label>
                <textarea name="maps_embed" rows="3" class="form-control">{{ old('maps_embed', $settings['maps_embed'] ?? '') }}</textarea>
                <small class="text-muted">Masukkan iframe embed Google Maps.</small>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Link PIC Web</label>
                <input type="url" name="pic_web_link" class="form-control" value="{{ old('pic_web_link', $settings['pic_web_link'] ?? '') }}">
            </div>

            <div class="d-grid">
                <button class="btn btn-primary">Simpan Pengaturan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.public')

@section('title', 'Kontak - ' . config('app.name'))

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-8 offset-md-2 text-center">
            <h1 class="fw-bold display-5">Kontak Kami</h1>
            <p class="text-muted">Hubungi Kwartir Ranting Bekasi Timur untuk pertanyaan atau informasi lebih lanjut.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <div class="card p-4 mb-4">
                <h5 class="fw-bold">Informasi Kontak</h5>
                <p class="mb-1"><i class="fas fa-map-marker-alt me-2"></i> {{ \App\Models\Setting::get('address', 'Kec. Bekasi Timur, Kota Bekasi, Jawa Barat') }}</p>
                <p class="mb-1"><i class="fas fa-phone me-2"></i> {{ \App\Models\Setting::get('phone', '+62 ...') }}</p>
                <p class="mb-0"><i class="fas fa-envelope me-2"></i> {{ \App\Models\Setting::get('email', 'info@kwarranbekasitimur.id') }}</p>
                <div class="mt-3">
                    @if($fb = \App\Models\Setting::get('social_facebook')) <a href="{{ $fb }}" class="text-secondary fs-5 me-3" target="_blank"><i class="fab fa-facebook-f"></i></a> @endif
                    @if($ig = \App\Models\Setting::get('social_instagram')) <a href="{{ $ig }}" class="text-secondary fs-5 me-3" target="_blank"><i class="fab fa-instagram"></i></a> @endif
                    @if($yt = \App\Models\Setting::get('social_youtube')) <a href="{{ $yt }}" class="text-secondary fs-5 me-3" target="_blank"><i class="fab fa-youtube"></i></a> @endif
                    @if($x = \App\Models\Setting::get('social_x')) <a href="{{ $x }}" class="text-secondary fs-5 me-3" target="_blank"><i class="fab fa-twitter"></i></a> @endif
                    @if($tt = \App\Models\Setting::get('social_tiktok')) <a href="{{ $tt }}" class="text-secondary fs-5 me-3" target="_blank"><i class="fab fa-tiktok"></i></a> @endif
                </div>
            </div>

            <div class="card p-4">
                <h5 class="fw-bold">Kirim Pesan</h5>
                <form method="POST" action="{{ route('contact.send') }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pesan</label>
                        <textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror" required>{{ old('message') }}</textarea>
                        @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    @if(env('RECAPTCHA_SITE_KEY'))
                        <div class="mb-3">
                            <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                            @if($errors->has('captcha'))
                                <div class="text-danger small mt-1">{{ $errors->first('captcha') }}</div>
                            @endif
                        </div>
                    @endif

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Kirim Pesan</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card p-4 mb-4">
                <h5 class="fw-bold">Lokasi</h5>
                <div class="ratio ratio-16x9 border rounded overflow-hidden">
                    @php
                        $map = \App\Models\Setting::get('maps_embed');
                    @endphp
                    @if($map)
                        {!! $map !!}
                    @else
                        <iframe src="https://www.google.com/maps?q=Bekasi+Timur&output=embed" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    @endif
                </div>
            </div>

            <div class="card p-4">
                <h5 class="fw-bold">Jam Operasional</h5>
                <p class="mb-0">Senin - Jumat: 08:00 - 16:00</p>
                <p>Sabtu - Minggu: Tutup</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if(env('RECAPTCHA_SITE_KEY'))
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endif
@endsection

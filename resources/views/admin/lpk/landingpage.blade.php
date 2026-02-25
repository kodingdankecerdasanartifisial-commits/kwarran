@extends('layouts.admin')

@section('page_title', 'Manajemen Landing Page LPK')

@section('content')
<form action="{{ route('admin.lpk.landingpage.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-white"><h5 class="m-0 fw-bold">Informasi LPK</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap Lembaga</label>
                        <input type="text" name="name" class="form-control" required value="{{ $lpk->name }}">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold"><i class="fab fa-whatsapp text-success"></i> No. WhatsApp</label>
                            <input type="text" name="whatsapp" class="form-control" value="{{ $lpk->whatsapp }}" placeholder="08xxxx">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold"><i class="fas fa-envelope text-danger"></i> Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $lpk->email }}" placeholder="lpk@email.com">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fas fa-map-marker-alt text-warning"></i> Alamat Kantor</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="Jl. Raya ...">{{ $lpk->address }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Visi</label>
                            <textarea name="vision" class="form-control" rows="3">{{ $lpk->vision }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Misi</label>
                            <textarea name="mission" class="form-control" rows="3">{{ $lpk->mission }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Struktur Kepengurusan -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold">Struktur Personil LPK</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addStructure()">+ Tambah Personil</button>
                </div>
                <div class="card-body" id="structure-container">
                    @if($lpk->structure)
                        @foreach($lpk->structure as $index => $item)
                        <div class="row align-items-end mb-3 border-bottom pb-3 structure-item" id="structure-{{ $index }}">
                            <div class="col-md-1">
                                @if(!empty($item['photo']))
                                    <img src="{{ asset('storage/' . $item['photo']) }}" class="rounded shadow-sm" style="width: 40px; height: 55px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="width: 40px; height: 55px;"><i class="fas fa-user text-muted small"></i></div>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <label class="small fw-bold">Nama Lengkap</label>
                                <input type="text" name="structure[{{ $index }}][name]" class="form-control form-control-sm" value="{{ $item['name'] }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="small fw-bold">Jabatan</label>
                                <input type="text" name="structure[{{ $index }}][position]" class="form-control form-control-sm" value="{{ $item['position'] }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="small fw-bold">Ganti Foto (3x4)</label>
                                <input type="file" name="structure_photos[{{ $index }}]" class="form-control form-control-sm" accept="image/*">
                                <input type="hidden" name="structure[{{ $index }}][photo]" value="{{ $item['photo'] ?? '' }}">
                            </div>
                            <div class="col-md-1 text-end">
                                <button type="button" class="btn btn-sm btn-danger p-1" onclick="document.getElementById('structure-{{ $index }}').remove()"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Custom HTML Section -->
            <div class="card mb-4">
                <div class="card-header bg-white"><h5 class="m-0 fw-bold">Custom HTML Block</h5></div>
                <div class="card-body">
                    <p class="text-muted small mb-2">Gunakan bagian ini untuk menambahkan widget eksternal atau kode embed kustom di halaman LPK.</p>
                    <textarea name="custom_html" class="form-control" rows="6" placeholder="<div class='my-widget'>...</div>">{{ $lpk->custom_html }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-white"><h5 class="m-0 fw-bold">Video YouTube</h5></div>
                <div class="card-body">
                    <div id="video-container">
                        @if($lpk->videos)
                            @foreach($lpk->videos as $index => $url)
                            <div class="input-group mb-2" id="video-{{ $index }}">
                                <span class="input-group-text"><i class="fab fa-youtube text-danger"></i></span>
                                <input type="url" name="videos[]" class="form-control form-control-sm" value="{{ $url }}" placeholder="https://youtube.com/...">
                                <button class="btn btn-sm btn-outline-danger" type="button" onclick="document.getElementById('video-{{ $index }}').remove()"><i class="fas fa-trash"></i></button>
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary w-100" onclick="addVideo()">+ Tambah Video</button>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-white"><h5 class="m-0 fw-bold">Media Visual</h5></div>
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Logo LPK</label>
                        @if($lpk->logo)
                            <div class="mb-2"><img src="{{ asset('storage/' . $lpk->logo) }}" class="img-thumbnail" style="max-height: 100px;"></div>
                        @endif
                        <input type="file" name="logo" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Hero Image (Banner)</label>
                        @if($lpk->hero_image)
                            <div class="mb-2"><img src="{{ asset('storage/' . $lpk->hero_image) }}" class="img-fluid rounded border"></div>
                        @endif
                        <input type="file" name="hero_image" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-white"><h5 class="m-0 fw-bold">Media Sosial</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold small"><i class="fab fa-facebook text-primary"></i> Facebook URL</label>
                        <input type="url" name="social_media[facebook]" class="form-control form-control-sm" value="{{ $lpk->social_media['facebook'] ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small"><i class="fab fa-instagram text-danger"></i> Instagram URL</label>
                        <input type="url" name="social_media[instagram]" class="form-control form-control-sm" value="{{ $lpk->social_media['instagram'] ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small"><i class="fab fa-youtube text-danger"></i> YouTube URL</label>
                        <input type="url" name="social_media[youtube]" class="form-control form-control-sm" value="{{ $lpk->social_media['youtube'] ?? '' }}">
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    let structureIndex = {{ count($lpk->structure ?? []) }};
    function addStructure() {
        const container = document.getElementById('structure-container');
        const html = `
            <div class="row align-items-end mb-3 border-bottom pb-3 structure-item" id="structure-${structureIndex}">
                <div class="col-md-1">
                    <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="width: 40px; height: 55px;"><i class="fas fa-user text-muted small"></i></div>
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold">Nama Lengkap</label>
                    <input type="text" name="structure[${structureIndex}][name]" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold">Jabatan</label>
                    <input type="text" name="structure[${structureIndex}][position]" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-4">
                    <label class="small fw-bold">Foto (3x4)</label>
                    <input type="file" name="structure_photos[${structureIndex}]" class="form-control form-control-sm" accept="image/*">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-sm btn-danger p-1" onclick="document.getElementById('structure-${structureIndex}').remove()"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        structureIndex++;
    }

    let videoIndex = {{ count($lpk->videos ?? []) }};
    function addVideo() {
        const container = document.getElementById('video-container');
        const html = `
            <div class="input-group mb-2" id="video-${videoIndex}">
                <span class="input-group-text"><i class="fab fa-youtube text-danger"></i></span>
                <input type="url" name="videos[]" class="form-control form-control-sm" placeholder="https://youtube.com/...">
                <button class="btn btn-sm btn-outline-danger" type="button" onclick="document.getElementById('video-${videoIndex}').remove()"><i class="fas fa-trash"></i></button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        videoIndex++;
    }
</script>
@endsection

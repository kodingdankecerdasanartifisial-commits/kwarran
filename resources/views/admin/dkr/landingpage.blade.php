@extends('layouts.admin')

@section('page_title', 'Manajemen Landing Page DKR')

@section('content')
<form action="{{ route('admin.dkr.landingpage.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-white"><h5 class="m-0 fw-bold">Informasi DKR</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap DKR</label>
                        <input type="text" name="name" class="form-control" required value="{{ $dkr->name }}">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold"><i class="fab fa-whatsapp text-success"></i> No. WhatsApp</label>
                            <input type="text" name="whatsapp" class="form-control" value="{{ $dkr->whatsapp }}" placeholder="08xxxx">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold"><i class="fas fa-envelope text-danger"></i> Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $dkr->email }}" placeholder="dkr@email.com">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fas fa-map-marker-alt text-warning"></i> Alamat Kantor/Sekretariat</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="Jl. Raya ...">{{ $dkr->address }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Visi</label>
                            <textarea name="vision" class="form-control" rows="3">{{ $dkr->vision }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Misi</label>
                            <textarea name="mission" class="form-control" rows="3">{{ $dkr->mission }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small"><i class="fas fa-user-friends text-primary"></i> Total Anggota</label>
                            <input type="number" name="active_members_count" class="form-control form-control-sm" value="{{ $dkr->active_members_count }}" min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small"><i class="fas fa-male text-primary"></i> Putra</label>
                            <input type="number" name="male_members_count" class="form-control form-control-sm" value="{{ $dkr->male_members_count }}" min="0">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold small"><i class="fas fa-female text-danger"></i> Putri</label>
                            <input type="number" name="female_members_count" class="form-control form-control-sm" value="{{ $dkr->female_members_count }}" min="0">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Struktur Kepengurusan -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold">Struktur Dewan Kerja</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addStructure()">+ Tambah Personil</button>
                </div>
                <div class="card-body" id="structure-container">
                    @if($dkr->structure)
                        @foreach($dkr->structure as $index => $item)
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
            <!-- Prestasi section follows -->

            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold">Prestasi & Pencapaian</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addAchievement()">+ Tambah</button>
                </div>
                <div class="card-body" id="achievement-container">
                    @if($dkr->achievements)
                        @foreach($dkr->achievements as $index => $item)
                        <div class="input-group mb-2" id="achievement-{{ $index }}">
                            <input type="text" name="achievements[]" class="form-control" value="{{ $item }}" placeholder="Contoh: Juara 1 Lomba ...">
                            <button class="btn btn-outline-danger" type="button" onclick="document.getElementById('achievement-{{ $index }}').remove()"><i class="fas fa-trash"></i></button>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-white"><h5 class="m-0 fw-bold">Video YouTube</h5></div>
                <div class="card-body">
                    <div id="video-container">
                        @if($dkr->videos)
                            @foreach($dkr->videos as $index => $url)
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
                        <label class="form-label fw-bold">Logo DKR</label>
                        @if($dkr->logo)
                            <div class="mb-2"><img src="{{ asset('storage/' . $dkr->logo) }}" class="img-thumbnail" style="max-height: 100px;"></div>
                        @endif
                        <input type="file" name="logo" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Hero Image (Banner)</label>
                        @if($dkr->hero_image)
                            <div class="mb-2"><img src="{{ asset('storage/' . $dkr->hero_image) }}" class="img-fluid rounded border"></div>
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
                        <input type="url" name="social_media[facebook]" class="form-control form-control-sm" value="{{ $dkr->social_media['facebook'] ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small"><i class="fab fa-instagram text-danger"></i> Instagram URL</label>
                        <input type="url" name="social_media[instagram]" class="form-control form-control-sm" value="{{ $dkr->social_media['instagram'] ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small"><i class="fab fa-youtube text-danger"></i> YouTube URL</label>
                        <input type="url" name="social_media[youtube]" class="form-control form-control-sm" value="{{ $dkr->social_media['youtube'] ?? '' }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold small"><i class="fab fa-tiktok text-dark"></i> TikTok URL</label>
                        <input type="url" name="social_media[tiktok]" class="form-control form-control-sm" value="{{ $dkr->social_media['tiktok'] ?? '' }}">
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save me-2"></i>Simpan Perubahan</button>
                <a href="{{ route('dkr.index') }}" target="_blank" class="btn btn-outline-info"><i class="fas fa-external-link-alt me-2"></i>Lihat Halaman DKR</a>
            </div>
        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    let structureIndex = {{ count($dkr->structure ?? []) }};
    function addStructure() {
        // ... index incremented inside ...
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

    let achievementIndex = {{ count($dkr->achievements ?? []) }};
    function addAchievement() {
        const container = document.getElementById('achievement-container');
        const html = `
            <div class="input-group mb-2" id="achievement-${achievementIndex}">
                <input type="text" name="achievements[]" class="form-control" placeholder="Contoh: Juara 1 Lomba ...">
                <button class="btn btn-outline-danger" type="button" onclick="document.getElementById('achievement-${achievementIndex}').remove()"><i class="fas fa-trash"></i></button>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        achievementIndex++;
    }

    let videoIndex = {{ count($dkr->videos ?? []) }};
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

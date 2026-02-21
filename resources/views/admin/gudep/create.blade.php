@extends('layouts.admin')

@section('page_title', 'Tambah Gudep')

@section('content')
<form action="{{ route('admin.gudep.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-white"><h5 class="m-0 fw-bold">Informasi Dasar</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">Nama Pangkalan (Sekolah)</label>
                            <input type="text" name="pangkalan_name" class="form-control" required placeholder="Contoh: SDN Bekasi Timur 01">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Nomor Gudep</label>
                            <input type="text" name="gudep_number" class="form-control" required placeholder="Contoh: 04.001 - 04.002">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold"><i class="fab fa-whatsapp text-success"></i> No. WhatsApp Pangkalan</label>
                            <input type="text" name="whatsapp" class="form-control" placeholder="08xxxx">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold"><i class="fas fa-envelope text-danger"></i> Email Pangkalan</label>
                            <input type="email" name="email" class="form-control" placeholder="pangkalan@email.com">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fas fa-map-marker-alt text-warning"></i> Alamat Pangkalan</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="Jl. Raya ..."></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Visi</label>
                            <textarea name="vision" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Misi</label>
                            <textarea name="mission" class="form-control" rows="3" placeholder="Pisahkan dengan enter"></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <input type="hidden" name="active_members_count" value="0">
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold small"><i class="fas fa-male text-primary"></i> Anggota Putra</label>
                            <input type="number" name="male_members_count" class="form-control form-control-sm" value="0" min="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold small"><i class="fas fa-female text-danger"></i> Anggota Putri</label>
                            <input type="number" name="female_members_count" class="form-control form-control-sm" value="0" min="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold small"><i class="fas fa-user-tie text-primary"></i> Pembina Putra</label>
                            <input type="number" name="male_pembina_count" class="form-control form-control-sm" value="0" min="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold small"><i class="fas fa-user-tie text-danger"></i> Pembina Putri</label>
                            <input type="number" name="female_pembina_count" class="form-control form-control-sm" value="0" min="0">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Struktur Kepengurusan -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold">Struktur Kepengurusan</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addStructure()">+ Tambah</button>
                </div>
                <div class="card-body" id="structure-container">
                    {{-- Row will be added here --}}
                </div>
            </div>

            <!-- Galeri Foto (Kompresi Otomatis) -->
            <div class="card mb-4">
                <div class="card-header bg-white"><h5 class="m-0 fw-bold">Unggah Galeri Foto</h5></div>
                <div class="card-body">
                    <div class="alert alert-info py-2 small">
                        <i class="fas fa-info-circle me-1"></i> Foto yang diunggah akan dikompresi otomatis untuk menjaga kecepatan web.
                    </div>
                    <div id="gallery-container">
                        <div class="row g-2 mb-2 gallery-item">
                            <div class="col-8">
                                <input type="file" name="gallery_files[]" class="form-control form-control-sm" accept="image/*">
                            </div>
                            <div class="col-4">
                                <input type="text" name="gallery_captions[]" class="form-control form-control-sm" placeholder="Caption">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="addGalleryField()">+ Tambah Foto</button>
                </div>
            </div>

            <!-- Video Dokumentasi (Embed) -->
            <div class="card mb-4">
                <div class="card-header bg-white"><h5 class="m-0 fw-bold">Video Dokumentasi (YouTube/TikTok)</h5></div>
                <div class="card-body">
                    <div id="video-container">
                        <div class="mb-3 video-item">
                            <label class="small fw-bold">Link Video Embed</label>
                            <input type="url" name="videos[][url]" class="form-control form-control-sm" placeholder="https://www.youtube.com/embed/...">
                            <input type="text" name="videos[][title]" class="form-control form-control-sm mt-1" placeholder="Judul Video">
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addVideoField()">+ Tambah Video</button>
                </div>
            </div>

            <!-- Daftar Prestasi -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold">Daftar Prestasi</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addAchievement()">+ Tambah Prestasi</button>
                </div>
                <div class="card-body" id="achievement-container">
                    {{-- Row will be added here --}}
                </div>
            </div>

            <!-- Kegiatan Rutin -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold">Kegiatan Rutin</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addActivity()">+ Tambah</button>
                </div>
                <div class="card-body" id="activity-container">
                    {{-- Row will be added here --}}
                </div>
            </div>

            <!-- Data Potensi Pembina -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold"><i class="fas fa-user-tie text-success me-2"></i>Data Potensi Pembina</h5>
                    <button type="button" id="btn-add-pembina" class="btn btn-sm btn-outline-success" onclick="addPotensiPembina()" style="display: none;">
                        + Tambah Detail
                    </button>
                </div>
                <div class="card-body">
                    <div id="pembina-detail-info" class="alert alert-warning py-2 small mb-0">
                        <i class="fas fa-exclamation-triangle me-1"></i> Silakan isi <strong>Jumlah Pembina Putra/Putri</strong> di bagian Statistik terlebih dahulu untuk mengisi detail ini.
                    </div>
                    
                    <div id="pembina-detail-section" style="display: none;">
                        <div class="alert alert-success py-2 small">
                            <i class="fas fa-info-circle me-1"></i> Masukkan data potensi pembina berdasarkan jenis kelamin, kursus, dan tahun.
                        </div>
                        <div id="potensi-pembina-container">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-white"><h5 class="m-0 fw-bold">Media & Gambar</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Logo Gudep</label>
                        <input type="file" name="logo" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Hero Image (Cover)</label>
                        <input type="file" name="hero_image" class="form-control" accept="image/*">
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header bg-white"><h5 class="m-0 fw-bold">Link Media Sosial</h5></div>
                <div class="card-body">
                    <div class="alert alert-light py-2 small border-0 mb-3">
                        Kosongkan untuk menggunakan link medsos Kwarran sebagai bawaan.
                    </div>
                    <div class="mb-2">
                        <label class="small fw-bold">Facebook URL</label>
                        <input type="url" name="social_media[facebook]" class="form-control form-control-sm" placeholder="{{ \App\Models\Setting::get('social_facebook') }}">
                    </div>
                    <div class="mb-2">
                        <label class="small fw-bold">Instagram URL</label>
                        <input type="url" name="social_media[instagram]" class="form-control form-control-sm" placeholder="{{ \App\Models\Setting::get('social_instagram') }}">
                    </div>
                    <div class="mb-2">
                        <label class="small fw-bold">YouTube URL</label>
                        <input type="url" name="social_media[youtube]" class="form-control form-control-sm" placeholder="{{ \App\Models\Setting::get('social_youtube') }}">
                    </div>
                    <div class="mb-2">
                        <label class="small fw-bold">TikTok URL</label>
                        <input type="url" name="social_media[tiktok]" class="form-control form-control-sm" placeholder="{{ \App\Models\Setting::get('social_tiktok') }}">
                    </div>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary rounded-pill py-3 fw-bold">Simpan Gudep</button>
                <a href="{{ route('admin.gudep.index') }}" class="btn btn-link text-muted mt-2">Batal</a>
            </div>
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
    let structureIndex = 0;
    function addStructure() {
        const container = document.getElementById('structure-container');
        const html = `
            <div class="row align-items-end mb-3 border-bottom pb-3 structure-item" id="structure-${structureIndex}">
                <div class="col-md-1">
                    <div class="bg-light rounded d-flex align-items-center justify-content-center border" style="width: 40px; height: 55px;"><i class="fas fa-user text-muted small"></i></div>
                </div>
                <div class="col-md-4">
                    <label class="small fw-bold">Nama Lengkap</label>
                    <input type="text" name="structure[${structureIndex}][name]" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold">Jabatan</label>
                    <input type="text" name="structure[${structureIndex}][position]" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold">Foto</label>
                    <input type="file" name="structure_photos[${structureIndex}]" class="form-control form-control-sm" accept="image/*">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger w-100" onclick="document.getElementById('structure-${structureIndex}').remove()"><i class="fas fa-trash"></i></button>
                    <input type="hidden" name="structure[${structureIndex}][photo]" value="">
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        structureIndex++;
    }

    function addGalleryField() {
        const container = document.getElementById('gallery-container');
        const html = `
            <div class="row g-2 mb-2 gallery-item">
                <div class="col-8">
                    <input type="file" name="gallery_files[]" class="form-control form-control-sm" accept="image/*">
                </div>
                <div class="col-3">
                    <input type="text" name="gallery_captions[]" class="form-control form-control-sm" placeholder="Caption">
                </div>
                <div class="col-1">
                    <button type="button" class="btn btn-sm btn-danger w-100" onclick="this.parentElement.parentElement.remove()"><i class="fas fa-times"></i></button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }

    let videoIndex = 1;
    function addVideoField() {
        const container = document.getElementById('video-container');
        const html = `
            <div class="mb-3 border-top pt-3 video-item">
                <div class="d-flex justify-content-between">
                    <label class="small fw-bold">Link Video Embed #${videoIndex + 1}</label>
                    <button type="button" class="btn btn-link btn-sm text-danger p-0" onclick="this.parentElement.parentElement.remove()">Hapus</button>
                </div>
                <input type="url" name="videos[${videoIndex}][url]" class="form-control form-control-sm" placeholder="https://www.youtube.com/embed/...">
                <input type="text" name="videos[${videoIndex}][title]" class="form-control form-control-sm mt-1" placeholder="Judul Video">
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        videoIndex++;
    }

    let achievementIndex = 0;
    function addAchievement() {
        const container = document.getElementById('achievement-container');
        const html = `
            <div class="row align-items-end mb-3 border-bottom pb-3 achievement-item" id="achievement-${achievementIndex}">
                <div class="col-md-2">
                    <label class="small fw-bold">Tahun</label>
                    <input type="text" name="achievements[${achievementIndex}][year]" class="form-control form-control-sm" placeholder="2023" required>
                </div>
                <div class="col-md-5">
                    <label class="small fw-bold">Nama Prestasi / Kegiatan</label>
                    <input type="text" name="achievements[${achievementIndex}][title]" class="form-control form-control-sm" required>
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold">Tingkat</label>
                    <input type="text" name="achievements[${achievementIndex}][level]" class="form-control form-control-sm" placeholder="Ranting/Cabang/Nasional">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger w-100" onclick="document.getElementById('achievement-${achievementIndex}').remove()"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        achievementIndex++;
    }

    let activityIndex = 0;
    function addActivity() {
        const container = document.getElementById('activity-container');
        const html = `
            <div class="mb-3 border-bottom pb-3 activity-item" id="activity-${activityIndex}">
                <div class="row mb-2">
                    <div class="col-md-6">
                        <label class="small fw-bold">Judul Kegiatan</label>
                        <input type="text" name="routine_activities[${activityIndex}][title]" class="form-control form-control-sm" required>
                    </div>
                    <div class="col-md-3">
                        <label class="small fw-bold">Hari</label>
                        <input type="text" name="routine_activities[${activityIndex}][day]" class="form-control form-control-sm" placeholder="Sabtu">
                    </div>
                    <div class="col-md-3">
                        <label class="small fw-bold">Waktu</label>
                        <input type="text" name="routine_activities[${activityIndex}][time]" class="form-control form-control-sm" placeholder="14:00 - 16:00">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <label class="small fw-bold">Deskripsi</label>
                        <input type="text" name="routine_activities[${activityIndex}][description]" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger w-100" onclick="document.getElementById('activity-${activityIndex}').remove()">Hapus</button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        activityIndex++;
    }

    let potensiPembinaIndex = 0;
    function addPotensiPembina() {
        const container = document.getElementById('potensi-pembina-container');
        const currentYear = new Date().getFullYear();
        const html = `
            <div class="row align-items-end mb-3 border-bottom pb-3 potensi-pembina-item" id="potensi-pembina-${potensiPembinaIndex}">
                <div class="col-md-2">
                    <label class="small fw-bold">Jenis Kelamin</label>
                    <select name="potensi_pembina[${potensiPembinaIndex}][jenis_kelamin]" class="form-select form-select-sm">
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="col-md-7">
                    <label class="small fw-bold">Jenis Kursus & Tahun (Bisa > 1)</label>
                    <div class="form-check mb-2">
                        <input class="form-check-input belum-kursus-check" type="checkbox" name="potensi_pembina[${potensiPembinaIndex}][belum_kursus]" value="1" id="belum-kursus-${potensiPembinaIndex}" onchange="toggleBelumKursus(this, ${potensiPembinaIndex})">
                        <label class="form-check-label small fw-bold text-danger" for="belum-kursus-${potensiPembinaIndex}">Belum Kursus</label>
                    </div>
                    <div class="row g-2 kursus-detail-fields-${potensiPembinaIndex}">
                        <div class="col-md-6">
                            <div class="input-group input-group-sm">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" name="potensi_pembina[${potensiPembinaIndex}][kursus][KMD][active]" value="1" id="kursus-${potensiPembinaIndex}-KMD">
                                    <span class="ms-1 small">KMD</span>
                                </div>
                                <input type="number" name="potensi_pembina[${potensiPembinaIndex}][kursus][KMD][tahun]" class="form-control" placeholder="Tahun" value="${currentYear}" min="1900" max="${currentYear}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-sm">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" name="potensi_pembina[${potensiPembinaIndex}][kursus][KML][active]" value="1" id="kursus-${potensiPembinaIndex}-KML">
                                    <span class="ms-1 small">KML</span>
                                </div>
                                <input type="number" name="potensi_pembina[${potensiPembinaIndex}][kursus][KML][tahun]" class="form-control" placeholder="Tahun" value="${currentYear}" min="1900" max="${currentYear}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-sm">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" name="potensi_pembina[${potensiPembinaIndex}][kursus][KPD][active]" value="1" id="kursus-${potensiPembinaIndex}-KPD">
                                    <span class="ms-1 small">KPD</span>
                                </div>
                                <input type="number" name="potensi_pembina[${potensiPembinaIndex}][kursus][KPD][tahun]" class="form-control" placeholder="Tahun" value="${currentYear}" min="1900" max="${currentYear}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-sm">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="checkbox" name="potensi_pembina[${potensiPembinaIndex}][kursus][KPL][active]" value="1" id="kursus-${potensiPembinaIndex}-KPL">
                                    <span class="ms-1 small">KPL</span>
                                </div>
                                <input type="number" name="potensi_pembina[${potensiPembinaIndex}][kursus][KPL][tahun]" class="form-control" placeholder="Tahun" value="${currentYear}" min="1900" max="${currentYear}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="small fw-bold">Jumlah Orang</label>
                    <input type="number" name="potensi_pembina[${potensiPembinaIndex}][jumlah]" class="form-control form-control-sm" min="0" value="0" required>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-sm btn-danger w-100" onclick="document.getElementById('potensi-pembina-${potensiPembinaIndex}').remove()"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        potensiPembinaIndex++;
    }

    function toggleBelumKursus(checkbox, index) {
        const detailFields = document.querySelector(`.kursus-detail-fields-${index}`);
        if (checkbox.checked) {
            detailFields.style.display = 'none';
            detailFields.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
            detailFields.querySelectorAll('input[type="number"]').forEach(input => input.value = '');
        } else {
            detailFields.style.display = 'flex';
        }
    }

    // Initialize with one row
    window.onload = function() {
        addStructure();
        addActivity();
        addAchievement();

        // Auto calculate total members
        const maleInput = document.querySelector('input[name="male_members_count"]');
        const femaleInput = document.querySelector('input[name="female_members_count"]');
        const totalInput = document.querySelector('input[name="active_members_count"]');

        const calculateTotal = () => {
            totalInput.value = parseInt(maleInput.value || 0) + parseInt(femaleInput.value || 0);
        };

        if(maleInput && femaleInput && totalInput) {
            maleInput.addEventListener('input', calculateTotal);
            femaleInput.addEventListener('input', calculateTotal);
        }
        // Logic to show/hide pembina detail based on counts
        const malePembinaInput = document.querySelector('input[name="male_pembina_count"]');
        const femalePembinaInput = document.querySelector('input[name="female_pembina_count"]');
        const detailSection = document.getElementById('pembina-detail-section');
        const detailInfo = document.getElementById('pembina-detail-info');
        const btnAddPembina = document.getElementById('btn-add-pembina');

        const togglePembinaDetail = () => {
            const total = (parseInt(malePembinaInput.value) || 0) + (parseInt(femalePembinaInput.value) || 0);
            if (total > 0) {
                detailSection.style.display = 'block';
                detailInfo.style.display = 'none';
                btnAddPembina.style.display = 'block';
            } else {
                detailSection.style.display = 'none';
                detailInfo.style.display = 'block';
                btnAddPembina.style.display = 'none';
                // Clear the container if count is 0? 
                // Maybe better just hide it to avoid data loss if user accidentally typed 0
            }
        };

        if(malePembinaInput && femalePembinaInput) {
            malePembinaInput.addEventListener('input', togglePembinaDetail);
            femalePembinaInput.addEventListener('input', togglePembinaDetail);
        }
    };
</script>
@endsection

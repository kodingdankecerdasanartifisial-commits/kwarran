@extends('layouts.admin')

@section('page_title', 'Edit Gudep')

@section('content')
<form action="{{ route('admin.gudep.update', $gudep->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-white"><h5 class="m-0 fw-bold">Informasi Dasar</h5></div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label fw-bold">Nama Pangkalan (Sekolah)</label>
                            <input type="text" name="pangkalan_name" class="form-control" required value="{{ $gudep->pangkalan_name }}">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label fw-bold">Nomor Gudep</label>
                            <input type="text" name="gudep_number" class="form-control" required value="{{ $gudep->gudep_number }}">
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold"><i class="fab fa-whatsapp text-success"></i> No. WhatsApp Pangkalan</label>
                            <input type="text" name="whatsapp" class="form-control" value="{{ $gudep->whatsapp }}" placeholder="08xxxx">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold"><i class="fas fa-envelope text-danger"></i> Email Pangkalan</label>
                            <input type="email" name="email" class="form-control" value="{{ $gudep->email }}" placeholder="pangkalan@email.com">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold"><i class="fas fa-map-marker-alt text-warning"></i> Alamat Pangkalan</label>
                        <textarea name="address" class="form-control" rows="2" placeholder="Jl. Raya ...">{{ $gudep->address }}</textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Visi</label>
                            <textarea name="vision" class="form-control" rows="3">{{ $gudep->vision }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Misi</label>
                            <textarea name="mission" class="form-control" rows="3">{{ $gudep->mission }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <input type="hidden" name="active_members_count" value="{{ $gudep->active_members_count }}">
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold small"><i class="fas fa-male text-primary"></i> Anggota Putra</label>
                            <input type="number" name="male_members_count" class="form-control form-control-sm" value="{{ $gudep->male_members_count }}" min="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold small"><i class="fas fa-female text-danger"></i> Anggota Putri</label>
                            <input type="number" name="female_members_count" class="form-control form-control-sm" value="{{ $gudep->female_members_count }}" min="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold small"><i class="fas fa-user-tie text-primary"></i> Pembina Putra</label>
                            <input type="number" name="male_pembina_count" class="form-control form-control-sm" value="{{ $gudep->male_pembina_count }}" min="0">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label fw-bold small"><i class="fas fa-user-tie text-danger"></i> Pembina Putri</label>
                            <input type="number" name="female_pembina_count" class="form-control form-control-sm" value="{{ $gudep->female_pembina_count }}" min="0">
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
                    @if($gudep->structure)
                        @foreach($gudep->structure as $index => $item)
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
                                <label class="small fw-bold">Ganti Foto</label>
                                <input type="file" name="structure_photos[{{ $index }}]" class="form-control form-control-sm" accept="image/*">
                                <input type="hidden" name="structure[{{ $index }}][old_photo]" value="{{ $item['photo'] ?? '' }}">
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

            <!-- Galeri Foto (Kompresi Otomatis) -->
            <div class="card mb-4">
                <div class="card-header bg-white"><h5 class="m-0 fw-bold">Kelola Galeri Foto</h5></div>
                <div class="card-body">
                    <div class="alert alert-info py-2 small">
                        <i class="fas fa-info-circle me-1"></i> Foto yang diunggah akan dikompresi otomatis.
                    </div>
                    <div id="gallery-container">
                        @if($gudep->gallery)
                            @foreach($gudep->gallery as $index => $item)
                            <div class="row g-2 mb-2 gallery-item align-items-center border-bottom pb-2">
                                <div class="col-2">
                                    <img src="{{ asset('storage/' . $item['image_path']) }}" class="img-thumbnail" style="height: 40px;">
                                </div>
                                <div class="col-3">
                                    <input type="text" name="gallery[{{ $index }}][caption]" class="form-control form-control-sm" value="{{ $item['caption'] ?? '' }}">
                                    <input type="hidden" name="gallery[{{ $index }}][image_path]" value="{{ $item['image_path'] }}">
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Foto tersimpan</small>
                                </div>
                                <div class="col-1 text-end">
                                    <button type="button" class="btn btn-sm btn-danger p-1" onclick="this.parentElement.parentElement.remove()"><i class="fas fa-times"></i></button>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        <div class="row g-2 mb-2 gallery-item mt-3">
                            <div class="col-8">
                                <label class="small fw-bold">Unggah Foto Baru</label>
                                <input type="file" name="gallery_files[]" class="form-control form-control-sm" accept="image/*">
                            </div>
                            <div class="col-4">
                                <label class="small fw-bold">Caption</label>
                                <input type="text" name="gallery_captions[]" class="form-control form-control-sm" placeholder="Caption">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary mt-2" onclick="addGalleryField()">+ Tambah Baris Unggah</button>
                </div>
            </div>

            <!-- Video Dokumentasi (Embed) -->
            <div class="card mb-4">
                <div class="card-header bg-white"><h5 class="m-0 fw-bold">Video Dokumentasi</h5></div>
                <div class="card-body">
                    <div id="video-container">
                        @if($gudep->videos)
                            @foreach($gudep->videos as $index => $video)
                            <div class="mb-3 video-item @if(!$loop->first) border-top pt-3 @endif">
                                <div class="d-flex justify-content-between">
                                    <label class="small fw-bold">Link Video Embed #{{ $index + 1 }}</label>
                                    <button type="button" class="btn btn-link btn-sm text-danger p-0" onclick="this.parentElement.parentElement.remove()">Hapus</button>
                                </div>
                                <input type="url" name="videos[{{ $index }}][url]" class="form-control form-control-sm" value="{{ $video['url'] ?? '' }}">
                                <input type="text" name="videos[{{ $index }}][title]" class="form-control form-control-sm mt-1" value="{{ $video['title'] ?? '' }}" placeholder="Judul Video">
                            </div>
                            @endforeach
                        @else
                            <div class="mb-3 video-item text-center text-muted small">Belum ada video.</div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="addVideoField()">+ Tambah Video Baru</button>
                </div>
            </div>

            <!-- Daftar Prestasi -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold">Daftar Prestasi</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addAchievement()">+ Tambah Prestasi</button>
                </div>
                <div class="card-body" id="achievement-container">
                    @if($gudep->achievements)
                        @foreach($gudep->achievements as $index => $item)
                        <div class="row align-items-end mb-3 border-bottom pb-3 achievement-item" id="achievement-{{ $index }}">
                            <div class="col-md-2">
                                <label class="small fw-bold">Tahun</label>
                                <input type="text" name="achievements[{{ $index }}][year]" class="form-control form-control-sm" value="{{ $item['year'] }}" required>
                            </div>
                            <div class="col-md-5">
                                <label class="small fw-bold">Nama Prestasi / Kegiatan</label>
                                <input type="text" name="achievements[{{ $index }}][title]" class="form-control form-control-sm" value="{{ $item['title'] }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="small fw-bold">Tingkat</label>
                                <input type="text" name="achievements[{{ $index }}][level]" class="form-control form-control-sm" value="{{ $item['level'] ?? '' }}">
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-sm btn-danger p-1" onclick="document.getElementById('achievement-{{ $index }}').remove()"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Kegiatan Rutin -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold">Kegiatan Rutin</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addActivity()">+ Tambah</button>
                </div>
                <div class="card-body" id="activity-container">
                    @if($gudep->routine_activities)
                        @foreach($gudep->routine_activities as $index => $item)
                        <div class="mb-3 border-bottom pb-3 activity-item" id="activity-{{ $index }}">
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <label class="small fw-bold">Judul Kegiatan</label>
                                    <input type="text" name="routine_activities[{{ $index }}][title]" class="form-control form-control-sm" value="{{ $item['title'] }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="small fw-bold">Hari</label>
                                    <input type="text" name="routine_activities[{{ $index }}][day]" class="form-control form-control-sm" value="{{ $item['day'] ?? '' }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="small fw-bold">Waktu</label>
                                    <input type="text" name="routine_activities[{{ $index }}][time]" class="form-control form-control-sm" value="{{ $item['time'] ?? '' }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-10">
                                    <label class="small fw-bold">Deskripsi</label>
                                    <input type="text" name="routine_activities[{{ $index }}][description]" class="form-control form-control-sm" value="{{ $item['description'] ?? '' }}">
                                </div>
                                <div class="col-md-2 d-flex align-items-end text-end">
                                    <button type="button" class="btn btn-sm btn-danger w-100" onclick="document.getElementById('activity-{{ $index }}').remove()">Hapus</button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Data Potensi -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold"><i class="fas fa-chart-bar text-info me-2"></i>Data Potensi</h5>
                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="addPotensi()">+ Tambah</button>
                </div>
                <div class="card-body" id="potensi-container">
                    <div class="alert alert-info py-2 small">
                        <i class="fas fa-info-circle me-1"></i> Masukkan data potensi anggota per jenjang, tingkatan, dan jenis kelamin.
                    </div>
                    @if($gudep->potensi)
                        @foreach($gudep->potensi as $index => $item)
                        <div class="row align-items-end mb-3 border-bottom pb-3 potensi-item" id="potensi-{{ $index }}">
                            <div class="col-md-2">
                                <label class="small fw-bold">Jenis Kelamin</label>
                                <select name="potensi[{{ $index }}][gender]" class="form-select form-select-sm">
                                    <option value="Laki-Laki" {{ ($item['gender'] ?? '') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                    <option value="Perempuan" {{ ($item['gender'] ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="small fw-bold">Jenjang</label>
                                <select name="potensi[{{ $index }}][jenjang]" class="form-select form-select-sm jenjang-select" data-index="{{ $index }}" onchange="updateTingkatan(this, {{ $index }})">
                                    <option value="">-- Pilih Jenjang --</option>
                                    <option value="Siaga" {{ ($item['jenjang'] ?? '') == 'Siaga' ? 'selected' : '' }}>Siaga</option>
                                    <option value="Penggalang" {{ ($item['jenjang'] ?? '') == 'Penggalang' ? 'selected' : '' }}>Penggalang</option>
                                    <option value="Penegak" {{ ($item['jenjang'] ?? '') == 'Penegak' ? 'selected' : '' }}>Penegak</option>
                                    <option value="Pandega" {{ ($item['jenjang'] ?? '') == 'Pandega' ? 'selected' : '' }}>Pandega</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="small fw-bold">Tingkatan</label>
                                <select name="potensi[{{ $index }}][tingkatan]" class="form-select form-select-sm tingkatan-select" id="tingkatan-{{ $index }}">
                                    @php $jenjang = $item['jenjang'] ?? ''; @endphp
                                    @if($jenjang == 'Siaga')
                                        <option value="">-- Pilih Tingkatan --</option>
                                        <option value="Siaga Mula" {{ ($item['tingkatan'] ?? '') == 'Siaga Mula' ? 'selected' : '' }}>Siaga Mula</option>
                                        <option value="Siaga Bantu" {{ ($item['tingkatan'] ?? '') == 'Siaga Bantu' ? 'selected' : '' }}>Siaga Bantu</option>
                                        <option value="Siaga Tata" {{ ($item['tingkatan'] ?? '') == 'Siaga Tata' ? 'selected' : '' }}>Siaga Tata</option>
                                    @elseif($jenjang == 'Penggalang')
                                        <option value="">-- Pilih Tingkatan --</option>
                                        <option value="Ramu" {{ ($item['tingkatan'] ?? '') == 'Ramu' ? 'selected' : '' }}>Ramu</option>
                                        <option value="Rakit" {{ ($item['tingkatan'] ?? '') == 'Rakit' ? 'selected' : '' }}>Rakit</option>
                                        <option value="Terap" {{ ($item['tingkatan'] ?? '') == 'Terap' ? 'selected' : '' }}>Terap</option>
                                    @elseif($jenjang == 'Penegak')
                                        <option value="">-- Pilih Tingkatan --</option>
                                        <option value="Bantara" {{ ($item['tingkatan'] ?? '') == 'Bantara' ? 'selected' : '' }}>Bantara</option>
                                        <option value="Laksana" {{ ($item['tingkatan'] ?? '') == 'Laksana' ? 'selected' : '' }}>Laksana</option>
                                    @elseif($jenjang == 'Pandega')
                                        <option value="-" selected>-</option>
                                    @else
                                        <option value="">-- Pilih Jenjang dulu --</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="small fw-bold">Jumlah</label>
                                <input type="number" name="potensi[{{ $index }}][jumlah]" class="form-control form-control-sm" value="{{ $item['jumlah'] ?? 0 }}" min="0" required>
                            </div>
                            <div class="col-md-1 text-end">
                                <button type="button" class="btn btn-sm btn-danger p-1" onclick="document.getElementById('potensi-{{ $index }}').remove()"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Data Potensi Pembina -->
            <div class="card mb-4">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="m-0 fw-bold"><i class="fas fa-user-tie text-success me-2"></i>Data Potensi Pembina</h5>
                    <button type="button" id="btn-add-pembina" class="btn btn-sm btn-outline-success" onclick="addPotensiPembina()" style="display: {{ ($gudep->male_pembina_count + $gudep->female_pembina_count) > 0 ? 'block' : 'none' }}">
                        + Tambah Detail
                    </button>
                </div>
                <div class="card-body">
                    <div id="pembina-detail-info" class="alert alert-warning py-2 small mb-0" style="display: {{ ($gudep->male_pembina_count + $gudep->female_pembina_count) == 0 ? 'block' : 'none' }}">
                        <i class="fas fa-exclamation-triangle me-1"></i> Silakan isi <strong>Jumlah Pembina Putra/Putri</strong> di bagian Statistik terlebih dahulu untuk mengisi detail ini.
                    </div>
                    
                    <div id="pembina-detail-section" style="display: {{ ($gudep->male_pembina_count + $gudep->female_pembina_count) > 0 ? 'block' : 'none' }}">
                        <div class="alert alert-success py-2 small">
                            <i class="fas fa-info-circle me-1"></i> Masukkan data potensi pembina berdasarkan jenis kelamin, kursus, dan tahun.
                        </div>
                        <div id="potensi-pembina-container">
                    @if($gudep->potensi_pembina)
                        @foreach($gudep->potensi_pembina as $index => $item)
                        <div class="row align-items-end mb-3 border-bottom pb-3 potensi-pembina-item" id="potensi-pembina-{{ $index }}">
                            <div class="col-md-2">
                                <label class="small fw-bold">Jenis Kelamin</label>
                                <select name="potensi_pembina[{{ $index }}][jenis_kelamin]" class="form-select form-select-sm">
                                    <option value="Laki-laki" {{ ($item['jenis_kelamin'] ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ ($item['jenis_kelamin'] ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-7">
                                <label class="small fw-bold">Jenis Kursus & Tahun (Bisa > 1)</label>
                                <div class="form-check mb-2">
                                    <input class="form-check-input belum-kursus-check" type="checkbox" name="potensi_pembina[{{ $index }}][belum_kursus]" value="1" id="belum-kursus-{{ $index }}" onchange="toggleBelumKursus(this, {{ $index }})" {{ !empty($item['belum_kursus']) ? 'checked' : '' }}>
                                    <label class="form-check-label small fw-bold text-danger" for="belum-kursus-{{ $index }}">Belum Kursus</label>
                                </div>
                                <div class="row g-2 kursus-detail-fields-{{ $index }}" style="{{ !empty($item['belum_kursus']) ? 'display: none;' : '' }}">
                                    @foreach(['KMD', 'KML', 'KPD', 'KPL'] as $kursus)
                                    @php 
                                        $kursusEntry = collect($item['kursus_data'] ?? [])->where('jenis', $kursus)->first();
                                        $isChecked = !empty($kursusEntry);
                                    @endphp
                                    <div class="col-md-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text">
                                                <input class="form-check-input mt-0" type="checkbox" name="potensi_pembina[{{ $index }}][kursus][{{ $kursus }}][active]" value="1" id="kursus-{{ $index }}-{{ $kursus }}" {{ $isChecked ? 'checked' : '' }}>
                                                <span class="ms-1 small">{{ $kursus }}</span>
                                            </div>
                                            <input type="number" name="potensi_pembina[{{ $index }}][kursus][{{ $kursus }}][tahun]" class="form-control" placeholder="Tahun" value="{{ $kursusEntry['tahun'] ?? '' }}" min="1900" max="{{ date('Y') }}">
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-2">
                                <label class="small fw-bold">Jumlah Orang</label>
                                <input type="number" name="potensi_pembina[{{ $index }}][jumlah]" class="form-control form-control-sm" value="{{ $item['jumlah'] ?? 0 }}" min="0" required>
                            </div>
                            <div class="col-md-1 text-end">
                                <button type="button" class="btn btn-sm btn-danger p-1" onclick="document.getElementById('potensi-pembina-{{ $index }}').remove()"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        @endforeach
                    @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-white"><h5 class="m-0 fw-bold">Media & Gambar</h5></div>
                <div class="card-body text-center">
                    @if($gudep->logo)
                        <img src="{{ asset('storage/' . $gudep->logo) }}" class="img-thumbnail mb-2" style="max-height: 100px;">
                    @endif
                    <div class="mb-3 text-start">
                        <label class="form-label small fw-bold">Logo Gudep</label>
                        <input type="file" name="logo" class="form-control form-control-sm" accept="image/*">
                    </div>
                    
                    @if($gudep->hero_image)
                        <img src="{{ asset('storage/' . $gudep->hero_image) }}" class="img-thumbnail mb-2" style="max-height: 100px;">
                    @endif
                    <div class="mb-3 text-start">
                        <label class="form-label small fw-bold">Hero Image (Cover)</label>
                        <input type="file" name="hero_image" class="form-control form-control-sm" accept="image/*">
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
                        <input type="url" name="social_media[facebook]" class="form-control form-control-sm" value="{{ $gudep->social_media['facebook'] ?? '' }}" placeholder="{{ \App\Models\Setting::get('social_facebook') }}">
                    </div>
                    <div class="mb-2">
                        <label class="small fw-bold">Instagram URL</label>
                        <input type="url" name="social_media[instagram]" class="form-control form-control-sm" value="{{ $gudep->social_media['instagram'] ?? '' }}" placeholder="{{ \App\Models\Setting::get('social_instagram') }}">
                    </div>
                    <div class="mb-2">
                        <label class="small fw-bold">YouTube URL</label>
                        <input type="url" name="social_media[youtube]" class="form-control form-control-sm" value="{{ $gudep->social_media['youtube'] ?? '' }}" placeholder="{{ \App\Models\Setting::get('social_youtube') }}">
                    </div>
                    <div class="mb-2">
                        <label class="small fw-bold">TikTok URL</label>
                        <input type="url" name="social_media[tiktok]" class="form-control form-control-sm" value="{{ $gudep->social_media['tiktok'] ?? '' }}" placeholder="{{ \App\Models\Setting::get('social_tiktok') }}">
                    </div>
                </div>
            </div>

            <div class="d-grid shadow">
                <button type="submit" class="btn btn-warning rounded-pill py-3 fw-bold">Update Gudep</button>
                <a href="{{ route('admin.gudep.index') }}" class="btn btn-link text-muted mt-2 text-decoration-none">Batal ke Daftar</a>
            </div>
        </div>
    </div>
</form>

@endsection

@section('scripts')
<script>
    let structureIndex = {{ count($gudep->structure ?? []) }};
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
                    <label class="small fw-bold">Unggah Foto</label>
                    <input type="file" name="structure_photos[${structureIndex}]" class="form-control form-control-sm" accept="image/*">
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-sm btn-danger p-1" onclick="document.getElementById('structure-${structureIndex}').remove()"><i class="fas fa-trash"></i></button>
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
            <div class="row g-2 mb-2 gallery-item mt-2">
                <div class="col-8">
                    <input type="file" name="gallery_files[]" class="form-control form-control-sm" accept="image/*">
                </div>
                <div class="col-3">
                    <input type="text" name="gallery_captions[]" class="form-control form-control-sm" placeholder="Caption">
                </div>
                <div class="col-1 text-end">
                    <button type="button" class="btn btn-sm btn-danger p-1" onclick="this.parentElement.parentElement.remove()"><i class="fas fa-times"></i></button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    }

    let videoIndex = {{ count($gudep->videos ?? []) }};
    function addVideoField() {
        const container = document.getElementById('video-container');
        const html = `
            <div class="mb-3 border-top pt-3 video-item">
                <div class="d-flex justify-content-between">
                    <label class="small fw-bold">Link Video Embed Baru</label>
                    <button type="button" class="btn btn-link btn-sm text-danger p-0" onclick="this.parentElement.parentElement.remove()">Hapus</button>
                </div>
                <input type="url" name="videos[${videoIndex}][url]" class="form-control form-control-sm" placeholder="https://www.youtube.com/embed/...">
                <input type="text" name="videos[${videoIndex}][title]" class="form-control form-control-sm mt-1" placeholder="Judul Video">
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        videoIndex++;
    }

    let achievementIndex = {{ count($gudep->achievements ?? []) }};
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
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-sm btn-danger p-1" onclick="document.getElementById('achievement-${achievementIndex}').remove()"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        achievementIndex++;
    }

    let activityIndex = {{ count($gudep->routine_activities ?? []) }};
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
                    <div class="col-md-2 d-flex align-items-end text-end">
                        <button type="button" class="btn btn-sm btn-danger w-100" onclick="document.getElementById('activity-${activityIndex}').remove()">Hapus</button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        activityIndex++;
    }

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

    // === Data Potensi ===
    const tingkatanMap = {
        'Siaga': ['Siaga Mula', 'Siaga Bantu', 'Siaga Tata'],
        'Penggalang': ['Ramu', 'Rakit', 'Terap'],
        'Penegak': ['Bantara', 'Laksana'],
        'Pandega': ['-']
    };

    function updateTingkatan(selectEl, index) {
        const jenjang = selectEl.value;
        const tingkatanSelect = document.getElementById('tingkatan-' + index);
        tingkatanSelect.innerHTML = '';

        if (!jenjang) {
            tingkatanSelect.innerHTML = '<option value="">-- Pilih Jenjang dulu --</option>';
            return;
        }

        const options = tingkatanMap[jenjang] || [];
        if (jenjang !== 'Pandega') {
            tingkatanSelect.innerHTML = '<option value="">-- Pilih Tingkatan --</option>';
        }
        options.forEach(opt => {
            const o = document.createElement('option');
            o.value = opt;
            o.textContent = opt;
            tingkatanSelect.appendChild(o);
        });
    }

    let potensiIndex = {{ count($gudep->potensi ?? []) }};
    function addPotensi() {
        const container = document.getElementById('potensi-container');
        const html = `
            <div class="row align-items-end mb-3 border-bottom pb-3 potensi-item" id="potensi-${potensiIndex}">
                <div class="col-md-2">
                    <label class="small fw-bold">Jenis Kelamin</label>
                    <select name="potensi[${potensiIndex}][gender]" class="form-select form-select-sm">
                        <option value="Laki-Laki">Laki-Laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold">Jenjang</label>
                    <select name="potensi[${potensiIndex}][jenjang]" class="form-select form-select-sm jenjang-select" onchange="updateTingkatan(this, ${potensiIndex})">
                        <option value="">-- Pilih Jenjang --</option>
                        <option value="Siaga">Siaga</option>
                        <option value="Penggalang">Penggalang</option>
                        <option value="Penegak">Penegak</option>
                        <option value="Pandega">Pandega</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="small fw-bold">Tingkatan</label>
                    <select name="potensi[${potensiIndex}][tingkatan]" class="form-select form-select-sm tingkatan-select" id="tingkatan-${potensiIndex}">
                        <option value="">-- Pilih Jenjang dulu --</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="small fw-bold">Jumlah</label>
                    <input type="number" name="potensi[${potensiIndex}][jumlah]" class="form-control form-control-sm" min="0" value="0" required>
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-sm btn-danger p-1" onclick="document.getElementById('potensi-${potensiIndex}').remove()"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        potensiIndex++;
    }

    let potensiPembinaIndex = {{ count($gudep->potensi_pembina ?? []) }};
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
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-sm btn-danger p-1" onclick="document.getElementById('potensi-pembina-${potensiPembinaIndex}').remove()"><i class="fas fa-trash"></i></button>
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
            // Optional: clear values
            detailFields.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
            detailFields.querySelectorAll('input[type="number"]').forEach(input => input.value = '');
        } else {
            detailFields.style.display = 'flex';
        }
    }

    // Logic to show/hide pembina detail based on counts
    const malePembinaInput = document.querySelector('input[name="male_pembina_count"]');
    const femalePembinaInput = document.querySelector('input[name="female_pembina_count"]');
    const detailSection = document.getElementById('pembina-detail-section');
    const detailInfo = document.getElementById('pembina-detail-info');
    const btnAddPembina = document.getElementById('btn-add-pembina');

    function togglePembinaDetail() {
        const total = (parseInt(malePembinaInput.value) || 0) + (parseInt(femalePembinaInput.value) || 0);
        if (total > 0) {
            detailSection.style.display = 'block';
            detailInfo.style.display = 'none';
            btnAddPembina.style.display = 'block';
        } else {
            detailSection.style.display = 'none';
            detailInfo.style.display = 'block';
            btnAddPembina.style.display = 'none';
        }
    }

    malePembinaInput.addEventListener('input', togglePembinaDetail);
    femalePembinaInput.addEventListener('input', togglePembinaDetail);
</script>
@endsection

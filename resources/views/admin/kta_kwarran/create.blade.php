@extends('layouts.admin')

@section('page_title', 'Buat KTA Kwarran')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Form Pembuatan KTA</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.kta_kwarran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                    <input type="text" class="form-control @error('nama_lengkap') is-invalid @enderror" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required>
                    @error('nama_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="tempat_tanggal_lahir" class="form-label">Tempat Tanggal Lahir</label>
                    <input type="text" class="form-control @error('tempat_tanggal_lahir') is-invalid @enderror" id="tempat_tanggal_lahir" name="tempat_tanggal_lahir" value="{{ old('tempat_tanggal_lahir') }}" required placeholder="Contoh: Bekasi, 17 Agustus 1945">
                    @error('tempat_tanggal_lahir')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="agama" class="form-label">Agama</label>
                    <select class="form-select @error('agama') is-invalid @enderror" id="agama" name="agama" required>
                        <option value="">Pilih Agama</option>
                        <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                        <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                        <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                        <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                        <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                    </select>
                    @error('agama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="golongan_darah" class="form-label">Golongan Darah</label>
                    <select class="form-select @error('golongan_darah') is-invalid @enderror" id="golongan_darah" name="golongan_darah" required>
                        <option value="">Pilih Golongan Darah</option>
                        <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                        <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                        <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                        <option value="-" {{ old('golongan_darah') == '-' ? 'selected' : '' }}>Tidak Tahu (-)</option>
                    </select>
                    @error('golongan_darah')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="pangkalan" class="form-label">Pangkalan</label>
                    <input type="text" class="form-control @error('pangkalan') is-invalid @enderror" id="pangkalan" name="pangkalan" value="{{ old('pangkalan') }}" required>
                    @error('pangkalan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="nomor_gudep" class="form-label">Nomor Gudep</label>
                    <input type="text" class="form-control @error('nomor_gudep') is-invalid @enderror" id="nomor_gudep" name="nomor_gudep" value="{{ old('nomor_gudep') }}">
                    @error('nomor_gudep')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
                    <textarea class="form-control @error('alamat_lengkap') is-invalid @enderror" id="alamat_lengkap" name="alamat_lengkap" rows="2">{{ old('alamat_lengkap') }}</textarea>
                    @error('alamat_lengkap')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label for="jabatan_golongan" class="form-label">Jabatan/Golongan</label>
                    <input type="text" class="form-control @error('jabatan_golongan') is-invalid @enderror" id="jabatan_golongan" name="jabatan_golongan" value="{{ old('jabatan_golongan') }}" required>
                    @error('jabatan_golongan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="kwarran" class="form-label">Kwarran</label>
                    <input type="text" class="form-control @error('kwarran') is-invalid @enderror" id="kwarran" name="kwarran" value="{{ old('kwarran', 'Bekasi Timur') }}" required>
                    @error('kwarran')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="kwarcab" class="form-label">Kwarcab</label>
                    <input type="text" class="form-control @error('kwarcab') is-invalid @enderror" id="kwarcab" name="kwarcab" value="{{ old('kwarcab', 'Kota Bekasi') }}" required>
                    @error('kwarcab')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="pas_foto" class="form-label">Pas Foto Pramuka</label>
                <input type="file" class="form-control @error('pas_foto') is-invalid @enderror" id="pas_foto" name="pas_foto" accept="image/*">
                <div class="form-text">Format: JPG, PNG. Rekomendasi rasio 3:4 or 4:6. Maksimal 2MB.</div>
                @error('pas_foto')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Data</button>
                <a href="{{ route('admin.kta_kwarran.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

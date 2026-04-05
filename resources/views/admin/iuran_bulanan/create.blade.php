@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-hand-holding-usd me-2"></i> Form Pelaporan Iuran Bulanan Kwarran</h5>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('admin.iuran_bulanan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-12 mb-4 text-center">
                            <p class="text-muted small italic">Silakan lengkapi formulir pelaporan iuran bulanan pangkalan Anda di bawah ini secara akurat.</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nama_pelapor" class="form-label fw-bold">Nama Pelapor <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_pelapor') is-invalid @enderror" id="nama_pelapor" name="nama_pelapor" value="{{ old('nama_pelapor') }}" placeholder="Contoh: Kak Ahmad" required>
                            @error('nama_pelapor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="asal_pangkalan" class="form-label fw-bold">Nama Sekolah <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('asal_pangkalan') is-invalid @enderror" id="asal_pangkalan" name="asal_pangkalan" value="{{ old('asal_pangkalan') }}" placeholder="Contoh: SDN Bekasi Jaya I" required>
                            @error('asal_pangkalan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="no_wa" class="form-label fw-bold">No WhatsApp <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('no_wa') is-invalid @enderror" id="no_wa" name="no_wa" value="{{ old('no_wa') }}" placeholder="Contoh: 081234567890" required>
                            @error('no_wa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="nominal" class="form-label fw-bold">Jumlah Nominal (Rp) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light fw-bold border-right-0">Rp</span>
                                <input type="number" class="form-control @error('nominal') is-invalid @enderror" id="nominal" name="nominal" value="{{ old('nominal') }}" placeholder="Contoh: 50000" min="0" required>
                                @error('nominal')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label for="bukti_setoran" class="form-label fw-bold">Upload Bukti Setoran <span class="text-danger">*</span></label>
                            <input type="file" class="form-control @error('bukti_setoran') is-invalid @enderror" id="bukti_setoran" name="bukti_setoran" accept="image/*" required>
                            <div class="form-text text-muted small">Maksimal ukuran file: 2MB (Hanya JPG, JPEG, PNG).</div>
                            @error('bukti_setoran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="catatan" class="form-label fw-bold">Catatan <small class="text-muted fw-normal">(Optional)</small></label>
                            <textarea class="form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan" rows="3" placeholder="Contoh: Iuran untuk Bulan Januari">{{ old('catatan') }}</textarea>
                            @error('catatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 text-center">
                            <hr class="mb-4">
                            <a href="{{ route('admin.iuran_bulanan.index') }}" class="btn btn-light px-4 me-2">Batal</a>
                            <button type="submit" class="btn btn-primary px-5">
                                <i class="fas fa-paper-plane me-1"></i> Kirim Konfirmasi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

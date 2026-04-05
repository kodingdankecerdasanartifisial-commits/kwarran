<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelaporan Iuran Bulanan - Kwarran Bekasi Timur</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4B2C20;
            --secondary: #F2C94C;
        }
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .bg-scout { background-color: var(--primary); }
        .card-form { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); overflow: hidden; }
        .form-header { background: linear-gradient(135deg, var(--primary) 0%, #6d412d 100%); color: white; padding: 40px 20px; text-align: center; }
        .btn-scout { background-color: var(--primary); color: white; border: none; padding: 12px 30px; border-radius: 8px; font-weight: bold; }
        .btn-scout:hover { background-color: #351f16; color: white; }
    </style>
</head>
<body>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card card-form">
                <div class="form-header">
                    <img src="{{ asset('logo.png') }}" alt="Logo" height="80" class="mb-3">
                    <h3 class="fw-bold mb-1">KWARTIR RANTING BEKASI TIMUR</h3>
                    <p class="mb-0 opacity-75">Form Konfirmasi Pelaporan Iuran Bulanan Pangkalan</p>
                </div>
                <div class="card-body p-4 p-md-5">
                    @if(session('success'))
                        <div class="alert alert-success border-0 shadow-sm rounded-3 p-4 text-center mb-4">
                            <i class="fas fa-check-circle fa-3x mb-3 d-block text-success"></i>
                            <h5 class="fw-bold">TERIMA KASIH!</h5>
                            <p class="mb-0">{{ session('success') }}</p>
                        </div>
                    @else
                        <form action="{{ route('iuran.public.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row g-4">
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small text-uppercase text-muted">Informasi Pelapor</label>
                                    <hr class="mt-0">
                                </div>

                                <div class="col-md-6 mt-1">
                                    <label for="nama_pelapor" class="form-label fw-bold">Nama Lengkap Pelapor</label>
                                    <input type="text" class="form-control @error('nama_pelapor') is-invalid @enderror" id="nama_pelapor" name="nama_pelapor" value="{{ old('nama_pelapor') }}" required placeholder="Masukkan nama Kakak">
                                </div>

                                <div class="col-md-6 mt-1">
                                    <label for="asal_pangkalan" class="form-label fw-bold">Nama Sekolah</label>
                                    <input type="text" class="form-control @error('asal_pangkalan') is-invalid @enderror" id="asal_pangkalan" name="asal_pangkalan" value="{{ old('asal_pangkalan') }}" required placeholder="Contoh: SMPN 1 Bekasi">
                                </div>

                                <div class="col-md-6 mt-1">
                                    <label for="no_wa" class="form-label fw-bold">Nomor WhatsApp</label>
                                    <input type="text" class="form-control @error('no_wa') is-invalid @enderror" id="no_wa" name="no_wa" value="{{ old('no_wa') }}" required placeholder="Contoh: 081234567890">
                                </div>

                                <div class="col-md-6 mt-1">
                                    <label for="nominal" class="form-label fw-bold">Besaran Iuran (Rp)</label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rp</span>
                                        <input type="number" class="form-control @error('nominal') is-invalid @enderror" id="nominal" name="nominal" value="{{ old('nominal') }}" required placeholder="0">
                                    </div>
                                </div>

                                <div class="col-md-12 mt-4">
                                    <label class="form-label fw-bold small text-uppercase text-muted">Lampiran Bukti</label>
                                    <hr class="mt-0">
                                </div>

                                <div class="col-md-12 mt-1">
                                    <label for="bukti_setoran" class="form-label fw-bold">Upload Bukti Transfer/Setoran</label>
                                    <input type="file" class="form-control @error('bukti_setoran') is-invalid @enderror" id="bukti_setoran" name="bukti_setoran" accept="image/*" required>
                                    <div class="form-text small">Maksimal 2MB (JPG/PNG). Mohon pastikan bukti terlihat jelas.</div>
                                </div>

                                <div class="col-md-12 mt-1">
                                    <label for="catatan" class="form-label fw-bold">Catatan Pendukung <span class="fw-normal text-muted small">(Opsional)</span></label>
                                    <textarea class="form-control" id="catatan" name="catatan" rows="3" placeholder="Contoh: Iuran rutin untuk periode Januari 2026">{{ old('catatan') }}</textarea>
                                </div>

                                <div class="col-md-12 pt-3">
                                    <button type="submit" class="btn btn-scout w-100 shadow-sm">
                                        <i class="fas fa-paper-plane me-2"></i> KIRIM PELAPORAN SEKARANG
                                    </button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
                <div class="card-footer bg-light py-3 border-0 text-center">
                    <small class="text-muted text-uppercase">PRAMUKA BEKASI TIMUR - SATYA DARMA BAKTI</small>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('home') }}" class="text-decoration-none text-muted small"><i class="fas fa-arrow-left me-1"></i> Kembali ke Website Utama</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>

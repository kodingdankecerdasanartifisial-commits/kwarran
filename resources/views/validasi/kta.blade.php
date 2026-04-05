<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi KTA - Gerakan Pramuka</title>
    <!-- Use Bootstrap for neat validation view -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .valid-badge {
            background-color: #198754;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            display: inline-block;
            margin-bottom: 20px;
        }
        .card-kta-preview {
            max-width: 400px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .preview-header {
            background: linear-gradient(90deg, #d32f2f 0%, #b71c1c 100%);
            color: white;
            text-align: center;
            padding: 15px;
            border-bottom: 4px solid #F2C94C;
        }
        .preview-body { padding: 20px; }
        .preview-photo {
            width: 100px;
            height: 140px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .dl-details dt { font-size: 0.85rem; color: #6c757d; }
        .dl-details dd { font-weight: bold; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="container py-5 text-center">
    <!-- Validation Success Banner -->
    <div class="valid-badge">
        <i class="fas fa-check-circle me-2"></i> KTA VALID - KWARRAN BEKASI TIMUR
    </div>
    <h4 class="mb-4">Sistem Validasi Kartu Tanda Anggota Gerakan Pramuka<br><small class="text-muted">Kwarran Bekasi Timur, Kota Bekasi</small></h4>

    <!-- KTA Data Card -->
    <div class="card-kta-preview text-start">
        <div class="preview-header">
            <h5 class="mb-0">INFORMASI ANGGOTA</h5>
        </div>
        <div class="preview-body row">
            <div class="col-4 text-center">
                @if($kta->pas_foto)
                    <img src="{{ asset('storage/' . $kta->pas_foto) }}" class="preview-photo" alt="Pas Foto">
                @else
                    <div class="preview-photo d-flex align-items-center justify-content-center bg-light text-muted">
                        <i class="fas fa-user fa-3x"></i>
                    </div>
                @endif
                <div class="mt-3 badge bg-dark w-100">NTA: {{ $kta->nta }}</div>
            </div>
            <div class="col-8">
                <dl class="dl-details mb-0">
                    <dt>Nama Lengkap</dt>
                    <dd>{{ strtoupper($kta->nama_lengkap) }}</dd>

                    <dt>Tempat/Tanggal Lahir</dt>
                    <dd>{{ $kta->tempat_tanggal_lahir }}</dd>

                    <dt>Pangkalan (Gudep)</dt>
                    <dd>{{ $kta->pangkalan }} {{ $kta->nomor_gudep ? ' - '.$kta->nomor_gudep : '' }}</dd>

                    <dt>Jabatan / Golongan</dt>
                    <dd>{{ $kta->jabatan_golongan }}</dd>

                    <dt>Agama & Gol. Darah</dt>
                    <dd>{{ $kta->agama }} / {{ $kta->golongan_darah }}</dd>
                    
                    <dt>Terdaftar sejak</dt>
                    <dd>{{ \Carbon\Carbon::parse($kta->created_at)->translatedFormat('d F Y') }}</dd>
                </dl>
            </div>
        </div>
        <div class="bg-light p-3 text-center border-top">
            <small class="text-muted">Atas nama Ketua Kwartir Ranting Bekasi Timur<br><strong>H. Supyanto, M.Pd</strong></small>
        </div>
    </div>
</div>

</body>
</html>

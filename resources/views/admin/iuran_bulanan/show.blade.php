@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Detail Konfirmasi Iuran</h5>
                <a href="{{ route('admin.iuran_bulanan.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <tr>
                            <th class="bg-light w-30 px-4 py-3">Status</th>
                            <td class="px-4 py-3">
                                @if($iuranBulanan->status == 'pending')
                                    <span class="badge bg-warning text-dark px-3 py-2">Menunggu Verifikasi</span>
                                @elseif($iuranBulanan->status == 'approved')
                                    <span class="badge bg-success px-3 py-2">Sudah Disetujui</span>
                                @else
                                    <span class="badge bg-danger px-3 py-2">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light px-4 py-3">Waktu Pengiriman</th>
                            <td class="px-4 py-3">
                                <div class="fw-bold text-primary">
                                    <i class="far fa-calendar-alt me-1"></i> {{ $iuranBulanan->created_at->translatedFormat('d F Y') }}
                                </div>
                                <div class="small text-muted">
                                    <i class="far fa-clock me-1"></i> Pukul {{ $iuranBulanan->created_at->format('H:i:s') }} WIB
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light px-4 py-3">Nama Pelapor</th>
                            <td class="px-4 py-3 fw-bold">{{ $iuranBulanan->nama_pelapor }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light px-4 py-3">Nama Sekolah</th>
                            <td class="px-4 py-3">{{ $iuranBulanan->asal_pangkalan }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light px-4 py-3">Nomor WhatsApp</th>
                            <td class="px-4 py-3">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $iuranBulanan->no_wa) }}" target="_blank" class="text-decoration-none">
                                    <i class="fab fa-whatsapp me-1 text-success"></i> {{ $iuranBulanan->no_wa }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light px-4 py-3">Nominal Iuran</th>
                            <td class="px-4 py-3">
                                <h4 class="fw-bold text-success mb-0">Rp {{ number_format($iuranBulanan->nominal, 0, ',', '.') }}</h4>
                            </td>
                        </tr>
                        <tr>
                            <th class="bg-light px-4 py-3">Catatan</th>
                            <td class="px-4 py-3">{{ $iuranBulanan->catatan ?: '-' }}</td>
                        </tr>
                        <tr>
                            <th class="bg-light px-4 py-3 align-middle">Bukti Setoran</th>
                            <td class="px-4 py-3">
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $iuranBulanan->bukti_setoran) }}" class="img-fluid rounded border shadow-sm" style="max-height: 400px;" alt="Bukti Setoran">
                                    <div class="mt-3">
                                        <a href="{{ asset('storage/' . $iuranBulanan->bukti_setoran) }}" target="_blank" class="btn btn-outline-info btn-sm">
                                            <i class="fas fa-search-plus me-1"></i> Lihat Gambar Ukuran Penuh
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            @if($iuranBulanan->status == 'pending')
            <div class="card-footer bg-white py-4 text-center">
                <form action="{{ route('admin.iuran_bulanan.approve', $iuranBulanan->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success px-4 py-2 me-2" onclick="return confirm('Setujui iuran ini? Saldo kas akan otomatis bertambah.')">
                        <i class="fas fa-check me-1"></i> Setujui & Tambah Kas
                    </button>
                </form>
                <form action="{{ route('admin.iuran_bulanan.reject', $iuranBulanan->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger px-4 py-2" onclick="return confirm('Tolak iuran ini?')">
                        <i class="fas fa-times me-1"></i> Tolak Laporan
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

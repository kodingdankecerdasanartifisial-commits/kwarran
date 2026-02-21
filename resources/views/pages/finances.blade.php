@extends('layouts.public')

@section('title', 'Transparansi Keuangan - Kwarran Bekasi Timur')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="fw-bold">Transparansi Keuangan</h1>
        <p class="text-muted">Laporan Arus Kas Masuk dan Keluar Kwartir Ranting Bekasi Timur</p>
        <div class="border-bottom border-warning border-4 w-25 mx-auto mt-3"></div>
        @if($lastUpdate)
            <div class="mt-3">
                <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
                    <i class="fas fa-clock me-1 text-primary"></i> 
                    Update Terakhir: {{ $lastUpdate->updated_at->translatedFormat('d F Y, H:i') }} WIB
                </span>
            </div>
        @endif
    </div>

    <!-- Summary Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body p-4 text-center">
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="fas fa-arrow-down text-success fs-3"></i>
                    </div>
                    <h6 class="text-uppercase small fw-bold text-muted">Total Pemasukan</h6>
                    <h3 class="fw-bold text-success mb-0">Rp {{ number_format($totalPemasukan) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100">
                <div class="card-body p-4 text-center">
                    <div class="bg-danger bg-opacity-10 p-3 rounded-circle d-inline-block mb-3">
                        <i class="fas fa-arrow-up text-danger fs-3"></i>
                    </div>
                    <h6 class="text-uppercase small fw-bold text-muted">Total Pengeluaran</h6>
                    <h3 class="fw-bold text-danger mb-0">Rp {{ number_format($totalPengeluaran) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-primary text-white overflow-hidden h-100">
                <div class="card-body p-4 text-center">
                    <div class="bg-white bg-opacity-20 p-3 rounded-circle d-inline-block mb-3">
                        <i class="fas fa-wallet fs-3"></i>
                    </div>
                    <h6 class="text-uppercase small fw-bold opacity-75">Saldo Akhir</h6>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($saldo) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Table -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white p-4 border-0">
            <h5 class="fw-bold m-0"><i class="fas fa-history me-2 text-primary"></i> Riwayat Transaksi</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Tanggal</th>
                            <th>Keterangan</th>
                            <th>Jenis</th>
                            <th class="text-end pe-4">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($finances as $item)
                        <tr>
                            <td class="ps-4">{{ \Carbon\Carbon::parse($item->transaction_date)->format('d/m/Y') }}</td>
                            <td>
                                <div class="fw-bold">{{ $item->description }}</div>
                                @if($item->details)
                                    <small class="text-muted d-block">{{ $item->details }}</small>
                                @endif
                            </td>
                            <td>
                                @if($item->type === 'pemasukan')
                                    <span class="badge bg-success-subtle text-success rounded-pill px-3">Masuk</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger rounded-pill px-3">Keluar</span>
                                @endif
                            </td>
                            <td class="text-end pe-4 fw-bold {{ $item->type === 'pemasukan' ? 'text-success' : 'text-danger' }}">
                                {{ $item->type === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($item->amount) }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">Belum ada riwayat transaksi publik.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <button onclick="window.print()" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fas fa-print me-2"></i> Cetak Laporan
        </button>
    </div>
</div>
@endsection

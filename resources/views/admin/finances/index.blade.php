@extends('layouts.admin')

@section('page_title', 'Laporan Keuangan (Arus Kas)')

@section('content')
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body p-4">
                <h6 class="text-uppercase small fw-bold opacity-75">Total Pemasukan</h6>
                <h2 class="fw-bold m-0">Rp {{ number_format($totalPemasukan) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white">
            <div class="card-body p-4">
                <h6 class="text-uppercase small fw-bold opacity-75">Total Pengeluaran</h6>
                <h2 class="fw-bold m-0">Rp {{ number_format($totalPengeluaran) }}</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body p-4">
                <h6 class="text-uppercase small fw-bold opacity-75">Saldo Akhir</h6>
                <h2 class="fw-bold m-0">Rp {{ number_format($saldo) }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold">Riwayat Transaksi</h5>
        <div>
            <a href="{{ route('admin.finances.calendar') }}" class="btn btn-outline-primary btn-sm rounded-pill me-2">
                <i class="fas fa-calendar-alt me-1"></i> Lihat Kalender
            </a>
            <a href="{{ route('admin.finances.create') }}" class="btn btn-primary btn-sm rounded-pill">
                <i class="fas fa-plus me-1"></i> Tambah Transaksi
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($finances as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->transaction_date)->format('d M Y') }}</td>
                        <td>
                            <div class="fw-bold">{{ $item->description }}</div>
                            @if($item->details)
                                <small class="text-muted">{{ $item->details }}</small>
                            @endif
                        </td>
                        <td>
                            @if($item->type === 'pemasukan')
                                <span class="badge bg-success-subtle text-success border border-success border-opacity-25 rounded-pill px-3">Masuk</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger border border-danger border-opacity-25 rounded-pill px-3">Keluar</span>
                            @endif
                        </td>
                        <td class="fw-bold {{ $item->type === 'pemasukan' ? 'text-success' : 'text-danger' }}">
                            {{ $item->type === 'pemasukan' ? '+' : '-' }} Rp {{ number_format($item->amount) }}
                        </td>
                        <td>
                            <a href="{{ route('admin.finances.edit', $item->id) }}" class="btn btn-sm btn-outline-primary rounded-circle" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <form action="{{ route('admin.finances.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data transaksi ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger rounded-circle" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada riwayat transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $finances->links() }}
        </div>
    </div>
</div>
@endsection

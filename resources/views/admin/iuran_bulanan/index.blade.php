@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">Konfirmasi Iuran Bulanan Kwarran</h5>
                <a href="{{ route('admin.iuran_bulanan.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-1"></i> Form Iuran Baru
                </a>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm mb-4">{{ session('error') }}</div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Tanggal Pelaporan</th>
                                <th>Nama Pelapor</th>
                                <th>Nama Sekolah</th>
                                <th>WA</th>
                                <th>Nominal</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($iuran as $item)
                            <tr>
                                <td>{{ ($iuran->currentPage() - 1) * $iuran->perPage() + $loop->iteration }}</td>
                                <td>
                                    {{ $item->created_at->translatedFormat('d F Y') }} <br>
                                    <small class="text-muted"><i class="far fa-clock me-1"></i>{{ $item->created_at->format('H:i') }}</small>
                                </td>
                                <td>{{ $item->nama_pelapor }}</td>
                                <td>{{ $item->asal_pangkalan }}</td>
                                <td>{{ $item->no_wa }}</td>
                                <td><span class="fw-bold text-success">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span></td>
                                <td>
                                    @if($item->status == 'pending')
                                        <span class="badge bg-warning text-dark px-2">Menunggu</span>
                                    @elseif($item->status == 'approved')
                                        <span class="badge bg-success px-2">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger px-2">Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm gap-1">
                                        <a href="{{ route('admin.iuran_bulanan.show', $item->id) }}" class="btn btn-primary" title="Detail Lengkap">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                        @if($item->status == 'pending')
                                            <form action="{{ route('admin.iuran_bulanan.approve', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success" onclick="return confirm('Setujui iuran ini? Saldo kas akan otomatis bertambah.')" title="Setujui">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.iuran_bulanan.reject', $item->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak iuran ini?')" title="Tolak">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <a href="{{ asset('storage/' . $item->bukti_setoran) }}" target="_blank" class="btn btn-info text-white" title="Bukti Setoran">
                                            <i class="fas fa-file-image"></i> Bukti
                                        </a>
                                        <form action="{{ route('admin.iuran_bulanan.destroy', $item->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-secondary" onclick="return confirm('Hapus data ini?')" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-5">Belum ada data iuran masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $iuran->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

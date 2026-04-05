@extends('layouts.admin')

@section('page_title', 'Pembuatan KTA Kwarran')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Data KTA Kwarran</h6>
        <a href="{{ route('admin.kta_kwarran.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah / Buat KTA</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NTA & Nama Lengkap</th>
                        <th>Agama</th>
                        <th>Pangkalan</th>
                        <th>Jabatan/Golongan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ktas as $index => $kta)
                    <tr>
                        <td>{{ $ktas->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($kta->pas_foto)
                                    <img src="{{ asset('storage/' . $kta->pas_foto) }}" alt="Foto" class="rounded me-2" style="width: 40px; height: 50px; object-fit: cover;">
                                @else
                                    <div class="bg-secondary rounded me-2 d-flex justify-content-center align-items-center text-white" style="width: 40px; height: 50px;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                                <div>
                                    @if($kta->nta)
                                        <span class="badge bg-info text-dark mb-1">{{ $kta->nta }}</span><br>
                                    @endif
                                    <strong>{{ $kta->nama_lengkap }}</strong><br>
                                    <small class="text-muted">{{ $kta->tempat_tanggal_lahir }}</small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $kta->agama }} ({{ $kta->golongan_darah }})</td>
                        <td>{{ $kta->pangkalan }}<br><small class="text-muted">{{ $kta->kwarran }} - {{ $kta->kwarcab }}</small></td>
                        <td>{{ $kta->jabatan_golongan }}</td>
                        <td>
                            <a href="{{ route('admin.kta_kwarran.print', $kta->id) }}" class="btn btn-info btn-sm text-white" title="Cetak KTA" target="_blank"><i class="fas fa-print"></i></a>
                            <a href="{{ route('admin.kta_kwarran.edit', $kta->id) }}" class="btn btn-warning btn-sm" title="Edit"><i class="fas fa-edit"></i></a>
                            <form action="{{ route('admin.kta_kwarran.destroy', $kta->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data KTA ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" title="Hapus"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data KTA.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-3">
            {{ $ktas->links() }}
        </div>
    </div>
</div>
@endsection

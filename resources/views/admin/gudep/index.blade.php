@extends('layouts.admin')

@section('page_title', 'Kelola Gudep / Pangkalan')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold">Daftar Gudep / Pangkalan</h5>
        <a href="{{ route('admin.gudep.create') }}" class="btn btn-primary btn-sm rounded-pill"><i class="fas fa-plus me-1"></i> Tambah Gudep</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th width="80">Logo</th>
                        <th>Nama Gudep</th>
                        <th>Anggota</th>
                        <th>Status</th>
                        <th width="200" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($gudeps as $gudep)
                    <tr>
                        <td>{{ ($gudeps->currentPage()-1) * $gudeps->perPage() + $loop->iteration }}</td>
                        <td>
                            @if($gudep->logo)
                                <img src="{{ asset('storage/' . $gudep->logo) }}" class="rounded" width="50" height="50" style="object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold fs-6">{{ $gudep->pangkalan_name }}</div>
                            <div class="text-primary small fw-bold">Gudep: {{ $gudep->gudep_number }}</div>
                            <small class="text-muted"><a href="{{ route('gudep.show', $gudep->slug) }}" target="_blank" class="text-decoration-none">Lihat Profil <i class="fas fa-external-link-alt ms-1" style="font-size: 0.7rem;"></i></a></small>
                        </td>
                        <td><span class="badge bg-info text-dark">{{ number_format($gudep->active_members_count) }} Anggota</span></td>
                        <td>
                            @if($gudep->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Non-Aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="{{ route('gudep.show', $gudep->slug) }}" class="btn btn-sm btn-info text-white" target="_blank" title="Lihat"><i class="fas fa-eye"></i></a>
                                @php $canEdit = auth()->user()->role === 'admin' || (auth()->user()->role === 'operator_gudep' && $gudep->user_id === auth()->id()); @endphp
                                @if($canEdit)
                                    <a href="{{ route('admin.gudep.edit', $gudep->id) }}" class="btn btn-sm btn-warning" title="Edit"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.gudep.destroy', $gudep->id) }}" method="POST" onsubmit="return confirm('Hapus Gudep ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"><i class="fas fa-trash"></i></button>
                                    </form>
                                @else
                                    <span class="btn btn-sm btn-secondary disabled" title="Bukan milik Anda"><i class="fas fa-lock"></i></span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Belum ada data Gudep.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $gudeps->links() }}
        </div>
    </div>
</div>
@endsection

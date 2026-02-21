@extends('layouts.admin')

@section('page_title', 'Manajemen Pengurus')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold">Daftar Pengurus</h5>
        <a href="{{ route('admin.organization.create') }}" class="btn btn-primary btn-sm rounded-pill">
            <i class="fas fa-plus me-1"></i> Tambah Pengurus
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Urutan</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($members as $member)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($member->photo)
                                <img src="{{ asset('storage/' . $member->photo) }}" width="50" height="50" class="rounded-circle object-fit-cover">
                            @else
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-user text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $member->name }}</td>
                        <td>{{ $member->position }}</td>
                        <td>{{ $member->sort_order }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.organization.edit', $member->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if(auth()->user()->role === 'admin')
                                <form action="{{ route('admin.organization.destroy', $member->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus data pengurus ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada data pengurus.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

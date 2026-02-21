@extends('layouts.admin')

@section('page_title', 'Manajemen User')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold">Daftar User</h5>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm rounded-pill"><i class="fas fa-plus me-1"></i> Tambah User</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="bg-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Terdaftar</th>
                        <th width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration + $users->firstItem() - 1 }}</td>
                        <td class="fw-semibold">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                                <span class="badge bg-danger rounded-pill">Admin</span>
                            @elseif($user->role === 'humas')
                                <span class="badge bg-info rounded-pill">Humas</span>
                            @elseif($user->role === 'lpk')
                                <span class="badge bg-success rounded-pill">LPK</span>
                            @elseif($user->role === 'operator_gudep')
                                <span class="badge bg-primary rounded-pill">Op. Gudep</span>
                            @elseif($user->role === 'dkr')
                                <span class="badge bg-warning text-dark rounded-pill">Op. DKR</span>
                            @else
                                <span class="badge bg-secondary rounded-pill">User</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-info btn-sm text-white rounded-circle"><i class="fas fa-pencil-alt"></i></a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm rounded-circle"><i class="fas fa-trash"></i></button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada user</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

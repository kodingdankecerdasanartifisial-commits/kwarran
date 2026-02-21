@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Sidebar Widgets</h5>
        <a href="{{ route('admin.sidebar-widgets.create') }}" class="btn btn-sm btn-primary">Tambah Widget</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Judul</th>
                    <th>Tipe</th>
                    <th>Order</th>
                    <th>Aktif</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($widgets as $w)
                <tr>
                    <td>{{ $w->name }}</td>
                    <td>{{ $w->title }}</td>
                    <td>{{ $w->type }}</td>
                    <td>{{ $w->order }}</td>
                    <td>{{ $w->is_active ? 'Ya' : 'Tidak' }}</td>
                    <td class="text-end">
                        <a href="{{ route('admin.sidebar-widgets.edit', $w) }}" class="btn btn-sm btn-secondary">Edit</a>
                        <form action="{{ route('admin.sidebar-widgets.destroy', $w) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus widget ini?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

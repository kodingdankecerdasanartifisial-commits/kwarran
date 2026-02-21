@extends('layouts.admin')

@section('page_title', 'Baca Pesan')

@section('content')
<div class="card">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <h5 class="m-0 fw-bold">Pesan dari {{ $message->name }}</h5>
        <div>
            <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-outline-secondary">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <p><strong>Nama:</strong> {{ $message->name }}</p>
        <p><strong>Email:</strong> <a href="mailto:{{ $message->email }}">{{ $message->email }}</a></p>
        <p><strong>Waktu:</strong> {{ $message->created_at->format('d/m/Y H:i') }}</p>

        <hr>

        <div class="mb-3">
            <p style="white-space: pre-line;">{{ $message->message }}</p>
        </div>

        <form action="{{ route('admin.messages.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Hapus Pesan</button>
        </form>
    </div>
</div>
@endsection

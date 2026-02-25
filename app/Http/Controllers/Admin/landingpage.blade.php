@extends('layouts.admin')

@section('page_title', 'Pengaturan Landing Page LPK')

@section('content')
<div class="container mt-4">
    <h1>Pengaturan Landing Page LPK</h1>
    <p>Halaman ini digunakan untuk mengatur profil dan tampilan publik Lembaga Pemeriksa Keuangan (LPK).</p>
    
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i> 
        Untuk mengelola data keuangan, silakan akses menu 
        <a href="{{ route('admin.lpk.finances.index') }}" class="alert-link">Laporan Keuangan</a>.
    </div>
</div>
@endsection
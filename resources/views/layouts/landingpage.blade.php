@extends('layouts.admin')

@section('page_title', 'Pengaturan Landing Page LPK')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Pengaturan Landing Page LPK</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Landing Page LPK</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">Halaman ini digunakan untuk mengatur profil dan tampilan publik Lembaga Pemeriksa Keuangan (LPK). Fitur ini sedang dalam pengembangan.</div>
    </div>
</div>
@endsection

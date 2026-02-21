@extends('layouts.admin')

@section('page_title', 'Pengaturan Grafik: ' . $sisran_form->title)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.sisran.visualize.index') }}" class="btn btn-light rounded-pill px-4 shadow-sm border">
        <i class="fas fa-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white p-4 border-0">
        <h5 class="fw-bold m-0"><i class="fas fa-eye me-2 text-primary"></i>Konfigurasi Tampilan Data</h5>
    </div>
    <div class="card-body p-4">
        @if(session('success'))
            <div class="alert alert-success border-0 rounded-3 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.sisran.visualize.update', $sisran_form) }}" method="POST">
            @csrf
            <table class="table align-middle">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-3">Nama Kolom (Label)</th>
                        <th>Tipe Data</th>
                        <th width="300">Jenis Visualisasi Chart</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sisran_form->fields as $field)
                    @if(in_array($field->type, ['number', 'select', 'radio', 'checkbox']))
                    <tr>
                        <td class="ps-3 fw-bold">{{ $field->label }}</td>
                        <td>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary">{{ ucfirst($field->type) }}</span>
                        </td>
                        <td>
                            <select name="fields[{{ $field->id }}]" class="form-select rounded-pill">
                                <option value="bar" {{ $field->chart_type == 'bar' ? 'selected' : '' }}>Grafik Batang (Bar)</option>
                                <option value="pie" {{ $field->chart_type == 'pie' ? 'selected' : '' }}>Grafik Lingkaran (Pie)</option>
                                <option value="doughnut" {{ $field->chart_type == 'doughnut' ? 'selected' : '' }}>Grafik Donat (Doughnut)</option>
                                <option value="line" {{ $field->chart_type == 'line' ? 'selected' : '' }}>Grafik Garis (Line)</option>
                            </select>
                        </td>
                    </tr>
                    @else
                    <tr class="opacity-50">
                        <td class="ps-3">{{ $field->label }}</td>
                        <td><span class="badge bg-light text-muted">{{ ucfirst($field->type) }}</span></td>
                        <td class="small italic text-muted">Tipe teks tidak dapat dijadikan grafik</td>
                    </tr>
                    @endif
                    @endforeach
                </tbody>
            </table>

            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary rounded-pill px-5 shadow-sm">
                    Simpan Pengaturan Visualisasi
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

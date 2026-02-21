@extends('layouts.admin')

@section('page_title', 'Data Masuk: ' . $sisran_form->title)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.sisran.index') }}" class="btn btn-light rounded-pill px-4 shadow-sm border">
        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
    </a>
</div>

<div class="card border-0 shadow-sm rounded-4">
    <div class="card-header bg-white p-4 border-0">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="fw-bold m-0"><i class="fas fa-table me-2 text-primary"></i>Rekapitulasi Isian Operator</h5>
            <a href="{{ route('sisran.public.result', $sisran_form->slug) }}" target="_blank" class="btn btn-success btn-sm rounded-pill">
                <i class="fas fa-chart-bar me-2"></i>Preview Grafik Publik
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Waktu</th>
                        <th>Operator</th>
                        <th>Unit/Utusan</th>
                        @foreach($sisran_form->fields as $field)
                        <th class="text-center">{{ $field->label }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($entries as $entry)
                    <tr>
                        <td class="ps-4 small text-muted">{{ $entry->created_at->format('d/m/Y H:i') }}</td>
                        <td class="fw-bold">{{ $entry->operator_name }}</td>
                        <td><span class="badge bg-info bg-opacity-10 text-info">{{ $entry->operator_unit }}</span></td>
                        @foreach($sisran_form->fields as $field)
                        <td class="text-center">
                            @if(is_array($entry->values[$field->id] ?? null))
                                {{ implode(', ', $entry->values[$field->id]) }}
                            @else
                                {{ $entry->values[$field->id] ?? '-' }}
                            @endif
                        </td>
                        @endforeach
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ 3 + $sisran_form->fields->count() }}" class="text-center py-5 text-muted">
                            Belum ada data isian yang masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $entries->links() }}
        </div>
    </div>
</div>
@endsection

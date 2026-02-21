@extends('layouts.public')

@section('title', $publicTitle . ' - Kwarran Bekasi Timur')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 p-4 overflow-hidden">
                <div class="text-center mb-4">
                    <h1 class="fw-bold">{{ $publicTitle }}</h1>
                    @if($publicDescription)
                        <p class="text-muted">{{ $publicDescription }}</p>
                    @endif
                    <div class="border-bottom border-warning border-4 w-25 mx-auto mt-3"></div>
                </div>

                <div style="height: 450px; position: relative;">
                    <canvas id="publicChart"></canvas>
                </div>

                <div class="mt-5 bg-light p-4 rounded-4 border-start border-4 border-warning">
                    <h5 class="fw-bold mb-3"><i class="fas fa-info-circle me-2 text-warning"></i> Keterangan Data</h5>
                    <div class="row text-center">
                        @foreach($chartData['labels'] as $index => $label)
                        <div class="col-md-4 mb-3">
                            <div class="p-3 bg-white rounded shadow-sm">
                                <small class="text-muted d-block">{{ $label }}</small>
                                <span class="h4 fw-bold text-primary">{{ number_format($chartData['values'][$index]) }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="text-center mt-4 pt-4 border-top">
                    <div class="d-flex justify-content-center gap-2">
                        <button onclick="window.print()" class="btn btn-outline-secondary btn-sm rounded-pill px-4">
                            <i class="fas fa-print me-2"></i> Cetak Laporan
                        </button>
                        <a href="{{ route('statistics.public.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-4">
                            <i class="fas fa-list me-2"></i> Indeks Statistik
                        </a>
                    </div>
                    <p class="small text-muted mt-3">Data diperbarui pada: {{ $statistic ? $statistic->updated_at->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('publicChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [{
                label: '{{ $chartData['labelName'] }}',
                data: {!! json_encode($chartData['values']) !!},
                backgroundColor: [
                    'rgba(75, 44, 32, 0.7)',
                    'rgba(242, 201, 76, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
                ],
                borderColor: [
                    'rgba(75, 44, 32, 1)',
                    'rgba(242, 201, 76, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
</script>
@endsection

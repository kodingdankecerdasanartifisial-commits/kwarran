@extends('layouts.admin')

@section('page_title', 'Buat Statistik Baru')

@section('content')
<div class="row">
    <div class="col-md-5">
        <div class="card mb-4">
            <div class="card-header bg-white">
                <h5 class="m-0 fw-bold">1. Upload & Proses Data</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.statistics.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Pilih File CSV</label>
                        <input type="file" name="file" class="form-control" accept=".csv" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary rounded-pill">
                            <i class="fas fa-sync me-1"></i> Proses Data CSV
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($chartData)
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="m-0 fw-bold text-success">2. Detail Publikasi</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.statistics.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="chart_data" value="{{ json_encode($chartData) }}">
                    
                    <div class="mb-3">
                        <label class="form-label">Judul Statistik</label>
                        <input type="text" name="title" class="form-control" placeholder="Contoh: Statistik Sertifikasi Pembina 2026" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan / Deskripsi</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Jelaskan tentang data ini..."></textarea>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success rounded-pill">
                            <i class="fas fa-save me-1"></i> Simpan & Publikasikan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-7">
        <div class="card h-100">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold">Pratinjau Grafik</h5>
                @if($chartData)
                <select id="chartType" class="form-select form-select-sm w-auto" onchange="updateChartType()">
                    <option value="bar">Bar</option>
                    <option value="pie">Pie</option>
                    <option value="doughnut">Doughnut</option>
                    <option value="line">Line</option>
                </select>
                @endif
            </div>
            <div class="card-body d-flex align-items-center justify-content-center">
                @if($chartData)
                    <div style="width: 100%; height: 400px; position: relative;">
                        <canvas id="previewChart"></canvas>
                    </div>
                @else
                    <div class="text-center text-muted py-5">
                        <i class="fas fa-file-csv fa-4x mb-3 opacity-25"></i>
                        <p>Upload file CSV di samping untuk melihat pratinjau grafik di sini.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@if($chartData)
<script>
    let myChart;
    const ctx = document.getElementById('previewChart').getContext('2d');
    const data = {
        labels: {!! json_encode($chartData['labels']) !!},
        datasets: [{
            label: '{{ $chartData['labelName'] }}',
            data: {!! json_encode($chartData['values']) !!},
            backgroundColor: [
                'rgba(75, 44, 32, 0.7)', 'rgba(242, 201, 76, 0.7)', 'rgba(54, 162, 235, 0.7)',
                'rgba(255, 99, 132, 0.7)', 'rgba(153, 102, 255, 0.7)', 'rgba(255, 159, 64, 0.7)'
            ],
            borderColor: [
                'rgba(75, 44, 32, 1)', 'rgba(242, 201, 76, 1)', 'rgba(54, 162, 235, 1)',
                'rgba(255, 99, 132, 1)', 'rgba(153, 102, 255, 1)', 'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    };

    function initChart(type = 'bar') {
        if (myChart) myChart.destroy();
        myChart = new Chart(ctx, {
            type: type,
            data: data,
            options: { responsive: true, maintainAspectRatio: false, scales: type === 'bar' || type === 'line' ? { y: { beginAtZero: true } } : {} }
        });
    }

    function updateChartType() {
        initChart(document.getElementById('chartType').value);
    }
    initChart('bar');
</script>
@endif
@endsection

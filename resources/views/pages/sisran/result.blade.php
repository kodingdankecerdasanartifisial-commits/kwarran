<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Statistik: {{ $form->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { background-color: #f8f9fa; }
        .hero-section { 
            background: linear-gradient(135deg, #4B2C20 0%, #8d5540 100%); 
            color: white; 
            padding: 60px 0; 
            margin-bottom: 40px;
            border-bottom: 5px solid #F2C94C;
        }
        .chart-card { background: white; border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: transform 0.3s; }
        .chart-card:hover { transform: translateY(-5px); }
        .footer-text { margin-top: 50px; padding: 20px; text-align: center; color: #666; font-size: 0.9rem; }
    </style>
</head>
<body>
    <div class="hero-section text-center">
        <div class="container">
            <h1 class="fw-bold mb-3">{{ $form->title }}</h1>
            <p class="lead opacity-75 mb-0">{{ $form->description }}</p>
            <div class="mt-4">
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill shadow-sm">
                    <i class="fas fa-layer-group me-2"></i>Kategori: {{ $form->category }}
                </span>
                <span class="badge bg-light text-dark px-3 py-2 rounded-pill shadow-sm ms-2">
                    <i class="fas fa-database me-2"></i>{{ $form->entries->count() }} Laporan Masuk
                </span>
            </div>
        </div>
    </div>

    <div class="container">
        @if($chartData)
            <div class="row g-4">
                @foreach($chartData as $data)
                <div class="col-md-6 mb-4">
                    <div class="card chart-card h-100">
                        <div class="card-body p-4 text-center">
                            <h5 class="fw-bold border-bottom pb-3 mb-4 text-start">{{ $data['label'] }}</h5>
                            <div style="position: relative; height: 300px;">
                                <canvas id="chart_{{ $data['id'] }}"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-chart-area fa-4x text-muted mb-3"></i>
                <h3>Belum ada data untuk ditampilkan</h3>
                <p class="text-muted">Visualisasi grafik akan muncul setelah operator mengisi data.</p>
            </div>
        @endif

        <div class="footer-text">
            <hr class="mb-4">
            <p>&copy; 2026 Kwarran Bekasi Timur. All Rights Reserved.</p>
            <p>Sistem Informasi Statistik Kwarran (SISRAN)</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @foreach($chartData as $data)
            const ctx_{{ $data['id'] }} = document.getElementById('chart_{{ $data['id'] }}').getContext('2d');
            new Chart(ctx_{{ $data['id'] }}, {
                type: '{{ $data['chart_type'] }}',
                data: {
                    labels: {!! json_encode($data['labels']) !!},
                    datasets: [{
                        label: '{{ $data['label'] }}',
                        data: {!! json_encode($data['values']) !!},
                        backgroundColor: [
                            'rgba(75, 44, 32, 0.7)',
                            'rgba(242, 201, 76, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)'
                        ],
                        borderColor: 'rgba(75, 44, 32, 1)',
                        borderWidth: 1,
                        borderRadius: {{ $data['chart_type'] == 'bar' ? 5 : 0 }}
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: {{ in_array($data['chart_type'], ['pie', 'doughnut']) ? 'true' : 'false' }} }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true, 
                            display: {{ in_array($data['chart_type'], ['pie', 'doughnut']) ? 'false' : 'true' }},
                            grid: { drawBorder: false } 
                        },
                        x: {
                            display: {{ in_array($data['chart_type'], ['pie', 'doughnut']) ? 'false' : 'true' }}
                        }
                    }
                }
            });
            @endforeach
        });
    </script>
</body>
</html>

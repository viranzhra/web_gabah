@extends('layout.app')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="container">
                <h1>Error in Drying Process Duration (Actual vs Recommended)</h1>
                <div class="chart-container">
                    <canvas id="errorChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // const apiBaseUrl = 'http://192.168.43.142'; // <- Ganti ke IP backend kamu
        const csrfUrl = `${baseUrl}/sanctum/csrf-cookie`;
        const sanctumToken = "{{ session('sanctum_token') ?? '' }}";
        const baseUrl = "{{ config('services.api.base_url') }}";
        const errorDataUrl = `${baseUrl}/api/drying-process/error-data`;

        fetch(sanctumToken, {
            credentials: 'include'
        })
        .then(() => {
            return fetch(errorDataUrl, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'include'
            });
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (!data.success) {
                alert('Gagal mengambil data: ' + data.error);
                return;
            }

            const errorData = data.data;
            if (errorData.length === 0) {
                alert('Tidak ada data proses pengeringan yang selesai.');
                return;
            }

            const labels = errorData.map(item => item.timestamp_mulai);
            const errors = errorData.map(item => item.error);

            const ctx = document.getElementById('errorChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Error (menit)',
                        data: errors,
                        backgroundColor: errors.map(e => e >= 0 ? 'rgba(54, 162, 235, 0.6)' : 'rgba(255, 99, 132, 0.6)'),
                        borderColor: errors.map(e => e >= 0 ? 'rgba(54, 162, 235, 1)' : 'rgba(255, 99, 132, 1)'),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        title: { display: true, text: 'Error in Drying Process Duration' },
                        tooltip: {
                            callbacks: {
                                label: ctx => `${ctx.dataset.label || ''}: ${ctx.parsed.y} menit`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: { display: true, text: 'Error (menit)' }
                        },
                        x: {
                            title: { display: true, text: 'Waktu Mulai Proses' }
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('Error fetching chart data:', error);
            alert('Gagal mengambil data chart: ' + error.message);
        });
    });
</script>

    <style>
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        .chart-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }
    </style>
@endsection
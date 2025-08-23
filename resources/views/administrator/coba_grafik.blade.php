@extends('layout.app')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gaugeJS/dist/gauge.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .gauge-label {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            margin-top: -50px;
        }
        .page-wrapper {
            font-family: 'Plus Jakarta Sans';
        }
        #error-message {
            color: red;
            text-align: center;
            margin-bottom: 1rem;
            display: none;
        }
    </style>

    <!-- Dashboard Grid -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 p-6">
        <!-- Error Message -->
        <div class="col-span-4">
            <div id="error-message"></div>
        </div>

        <!-- Error Durasi Estimasi vs Prediksi (Horizontal Bar) -->
        <div class="col-span-2 bg-white shadow rounded-lg p-4 h-96">
            <h2 class="font-semibold text-lg mb-3">Suhu Pembakaran</h2>
            <div class="h-[calc(100%-2rem)]">
                <canvas id="burnChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Gauge Suhu Gabah -->
        <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-center items-center">
            <h2 class="text-lg font-semibold mb-3">Suhu Gabah</h2>
            <canvas id="gaugeGrainTemp" width="250" height="130"></canvas>
            <div class="gauge-label" id="grainTempValue">0°C</div>
        </div>

        <!-- Gauge Suhu Ruangan -->
        <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-center items-center">
            <h2 class="text-lg font-semibold mb-3">Suhu Ruangan</h2>
            <canvas id="gaugeRoomTemp" width="250" height="130"></canvas>
            <div class="gauge-label" id="roomTempValue">0°C</div>
        </div>

        <!-- Chart Suhu Pembakaran -->
        <div class="col-span-2 bg-white shadow rounded-lg p-4 h-96">
            <h2 class="font-semibold text-lg mb-3">Error Durasi (Estimasi - Prediksi)</h2>
            <div class="h-[calc(100%-2rem)]">
                <canvas id="errorChart" class="w-full h-full"></canvas>
            </div>
        </div>

        <!-- Chart Kadar Air Gabah -->
        <div class="col-span-2 bg-white shadow rounded-lg p-4 h-96">
            <h2 class="font-semibold text-lg mb-3">Kadar Air Gabah</h2>
            <div class="h-[calc(100%-2rem)]">
                <canvas id="moistureChart" class="w-full h-full"></canvas>
            </div>
        </div>
    </div>

    <script>
        // Error Chart (Horizontal Bar)
        const errorCtx = document.getElementById('errorChart').getContext('2d');
        const errorChart = new Chart(errorCtx, {
            type: 'bar',
            data: {
                labels: ['Proses 1', 'Proses 2', 'Proses 3', 'Proses 4', 'Proses 5'],
                datasets: [{
                    label: 'Selisih (menit)',
                    data: [1.5, -0.8, 0.6, -1.2, 1.0],
                    backgroundColor: function(ctx) {
                        const val = ctx.dataset.data[ctx.dataIndex];
                        return val >= 0 ? 'rgba(34, 197, 94, 0.7)' : 'rgba(239, 68, 68, 0.7)';
                    },
                    hoverBackgroundColor: function(ctx) {
                        const val = ctx.dataset.data[ctx.dataIndex];
                        return val >= 0 ? 'rgba(34, 197, 94, 1)' : 'rgba(239, 68, 68, 1)';
                    },
                    borderRadius: 6,
                    barThickness: 20
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                indexAxis: 'y',
                scales: {
                    x: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Selisih Durasi (menit)'
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    y: {
                        grid: {
                            display: false
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

        // Reusable Gauge Function
        function createGauge(canvasId, labelId, currentValue) {
            const opts = {
                angle: 0,
                lineWidth: 0.2,
                radiusScale: 1,
                pointer: {
                    length: 0.6,
                    strokeWidth: 0.035,
                    color: '#000000'
                },
                staticZones: [{
                        strokeStyle: "#22c55e",
                        min: 0,
                        max: 30
                    },
                    {
                        strokeStyle: "#eab308",
                        min: 30,
                        max: 40
                    },
                    {
                        strokeStyle: "#ef4444",
                        min: 40,
                        max: 50
                    }
                ],
                staticLabels: {
                    font: "12px sans-serif",
                    labels: [0, 10, 20, 30, 40, 50],
                    color: "#000",
                    fractionDigits: 0
                },
                strokeColor: "#E0E0E0",
                generateGradient: true,
                highDpiSupport: true
            };

            const target = document.getElementById(canvasId);
            const gauge = new Gauge(target).setOptions(opts);
            gauge.maxValue = 50;
            gauge.setMinValue(0);
            gauge.animationSpeed = 32;
            gauge.set(currentValue);
            document.getElementById(labelId).textContent = currentValue + '°C';
            return gauge;
        }

        // Inisialisasi Gauge
        let grainTempGauge = createGauge('gaugeGrainTemp', 'grainTempValue', 0);
        let roomTempGauge = createGauge('gaugeRoomTemp', 'roomTempValue', 0);

        // Suhu Pembakaran Chart
        const burnCtx = document.getElementById('burnChart').getContext('2d');
        const burnChart = new Chart(burnCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Suhu Pembakaran',
                    data: [],
                    borderColor: '#ef4444',
                    backgroundColor: 'rgb(246 200 200 / 20%)',
                    tension: 0.4, // Untuk efek gelombang
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { 
                        mode: 'index', 
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                let value = context.parsed.y;
                                return 'Suhu: ' + value.toFixed(2) + '°C';
                            }
                        }
                    }
                },
                interaction: { mode: 'index', intersect: false },
                scales: {
                    x: {
                        type: 'category',
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: false,
                        grid: { display: false },
                        ticks: {
                            callback: function(value) {
                                return value.toFixed(2) + '°C';
                            }
                        }
                    }
                }
            }
        });

        // Kadar Air Gabah Chart
        const moistureCtx = document.getElementById('moistureChart').getContext('2d');
        const moistureChart = new Chart(moistureCtx, {
            type: 'line',
            data: {
                labels: [],
                datasets: [{
                    label: 'Kadar Air (%)',
                    data: [],
                    borderColor: '#0ea5e9',
                    backgroundColor: 'rgb(177 226 248 / 20%)',
                    tension: 0.4, // Untuk efek gelombang
                    fill: true,
                    pointRadius: 0,
                    pointHoverRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { mode: 'index', intersect: false }
                },
                interaction: { mode: 'index', intersect: false },
                scales: {
                    x: {
                        type: 'category',
                        grid: { display: false }
                    },
                    y: {
                        beginAtZero: false,
                        grid: { display: false },
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });

        // Array untuk menyimpan data real-time
        let chartData = [];
        const DATA_UPDATE_INTERVAL = 5000; // 5 detik
        const MAX_DATA_POINTS = 8; // Maksimum 6 titik data
        let lastUpdateTime = 0;

        // Fungsi untuk menampilkan pesan error
        function showError(message) {
            const errorDiv = document.getElementById('error-message');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
        }

        // Fungsi untuk menyembunyikan pesan error
        function hideError() {
            const errorDiv = document.getElementById('error-message');
            errorDiv.style.display = 'none';
        }

        // Fungsi untuk menghitung skala Y dinamis
        function calculateYScale(data, key, minDefault, maxDefault, marginPercent = 0.1) {
            if (!data || data.length === 0) {
                return { min: minDefault, max: maxDefault };
            }
            const values = data.map(item => item[key]).filter(val => val != null && !isNaN(val));
            if (values.length === 0) {
                return { min: minDefault, max: maxDefault };
            }
            const min = Math.min(...values);
            const max = Math.max(...values);
            const range = max - min;
            const margin = range * marginPercent || 1; // Margin minimal 1
            return {
                min: Math.max(minDefault, min - margin),
                max: Math.min(maxDefault, max + margin)
            };
        }

        // Fungsi untuk memperbarui chart
        function updateCharts() {
            // Siapkan data untuk chart
            const labels = chartData.map(d => d.time);
            const burnData = chartData.map(d => d.burn);
            const moistureData = chartData.map(d => d.moisture);

            // Hitung skala Y dinamis
            const burnScale = calculateYScale(chartData, 'burn', 180, 350, 0.1);
            const moistureScale = calculateYScale(chartData, 'moisture', 0, 30, 0.1);

            // Update chart suhu pembakaran
            burnChart.data.labels = labels;
            burnChart.data.datasets[0].data = burnData;
            burnChart.options.scales.y.suggestedMin = burnScale.min;
            burnChart.options.scales.y.suggestedMax = burnScale.max;
            burnChart.update();

            // Update chart kadar air
            moistureChart.data.labels = labels;
            moistureChart.data.datasets[0].data = moistureData;
            moistureChart.options.scales.y.suggestedMin = moistureScale.min;
            moistureChart.options.scales.y.suggestedMax = moistureScale.max;
            moistureChart.update();

            // Tampilkan pesan error jika tidak ada data valid
            if (chartData.length === 0) {
                showError('Tidak ada data sensor valid untuk ditampilkan di grafik.');
            } else {
                hideError();
            }

            console.log('Chart Data:', JSON.stringify(chartData, null, 2));
            console.log('Burn Chart Data:', JSON.stringify(burnChart.data, null, 2));
            console.log('Moisture Chart Data:', JSON.stringify(moistureChart.data, null, 2));
        }

        // Fungsi untuk memulai koneksi SSE
        function startSSE(processId) {
            const source = new EventSource(`{{ config('services.api.base_url') }}/sse/sensor-data/${processId}`);

            source.addEventListener('sensor-update', function(event) {
                const data = JSON.parse(event.data);
                console.log('SSE Data:', JSON.stringify(data, null, 2));

                if (data.error || data.status === 'invalid') {
                    showError(data.error || 'Data tidak valid');
                    return;
                }

                const now = Date.now();
                if (now - lastUpdateTime >= DATA_UPDATE_INTERVAL) {
                    lastUpdateTime = now;

                    // Validasi data wajib
                    if (data.suhu_pembakaran == null || data.kadar_air == null || !data.timestamp) {
                        console.warn('Data tidak lengkap:', data);
                        return;
                    }

                    // Tambahkan data ke chartData dengan pembulatan 2 desimal
                    chartData.push({
                        time: new Date(data.timestamp).toLocaleTimeString('id-ID', {
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit',
                            timeZone: 'Asia/Jakarta'
                        }),
                        burn: parseFloat(data.suhu_pembakaran).toFixed(2),
                        moisture: parseFloat(data.kadar_air).toFixed(2)
                    });

                    // Batasi ke 6 data terakhir
                    if (chartData.length > MAX_DATA_POINTS) {
                        chartData.shift();
                    }

                    // Update Gauge
                    if (data.suhu_gabah != null) {
                        grainTempGauge.set(parseFloat(data.suhu_gabah));
                        document.getElementById('grainTempValue').textContent = parseFloat(data.suhu_gabah).toFixed(2) + '°C';
                    }
                    if (data.suhu_ruangan != null) {
                        roomTempGauge.set(parseFloat(data.suhu_ruangan));
                        document.getElementById('roomTempValue').textContent = parseFloat(data.suhu_ruangan).toFixed(2) + '°C';
                    }

                    // Perbarui chart
                    updateCharts();
                }
            });

            source.addEventListener('error', function(event) {
                console.error('SSE Error:', event);
                source.close();
                // showError('Koneksi SSE terputus. Mencoba menyambung kembali...');
                setTimeout(() => connectToApi(), 5000);
            });

            return source;
        }

        // Fungsi untuk menghubungkan ke API
        function connectToApi() {
            fetch('{{ config('services.api.base_url') }}/ongoing-process')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Ongoing Process Response:', JSON.stringify(data, null, 2));
                    if (!data.success) {
                        showError(data.error || 'Tidak ada proses berlangsung');
                        setTimeout(() => connectToApi(), 10000);
                        return;
                    }

                    hideError();
                    const processId = data.process_id;
                    console.log('Process ID:', processId);
                    startSSE(processId);
                })
                .catch(error => {
                    console.error('Error fetching ongoing process:', error);
                    // showError('Gagal menghubungi server: ' + error.message);
                    setTimeout(() => connectToApi(), 10000);
                });
        }

        // Mulai koneksi
        connectToApi();
    </script>
@endsection
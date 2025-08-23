<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Sensor Real-Time Dashboard</title>
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
    </style>
</head>

<body class="bg-gray-100 p-6">

    <div class="max-w-7xl mx-auto bg-white rounded-xl shadow-lg">
        <!-- Header -->
        <div class="bg-blue-700 text-white text-xl font-bold p-4 rounded-t-xl">
            SENSOR REAL-TIME
        </div>

        <!-- Dashboard Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 p-6">

            <!-- Error Durasi Estimasi vs Prediksi (Horizontal Bar) -->
            <div class="col-span-2 bg-white shadow rounded-lg p-4 h-96">
                <h2 class="font-semibold text-lg mb-3">Error Durasi (Estimasi - Prediksi)</h2>
                <div class="h-[calc(100%-2rem)]">
                    <canvas id="errorChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Gauge Suhu Gabah -->
            <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-center items-center">
                <h2 class="text-lg font-semibold mb-3">Suhu Gabah</h2>
                <canvas id="gaugeGrainTemp" width="250" height="130"></canvas>
                <div class="gauge-label" id="grainTempValue">35°C</div>
            </div>

            <!-- Gauge Suhu Ruangan -->
            <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-center items-center">
                <h2 class="text-lg font-semibold mb-3">Suhu Ruangan</h2>
                <canvas id="gaugeRoomTemp" width="250" height="130"></canvas>
                <div class="gauge-label" id="roomTempValue">27°C</div>
            </div>

            <!-- Chart Suhu Pembakaran -->
            <div class="col-span-2 bg-white shadow rounded-lg p-4 h-96">
                <h2 class="font-semibold text-lg mb-3">Suhu Pembakaran</h2>
                <div class="h-[calc(100%-2rem)]">
                    <canvas id="burnChart" class="w-full h-full"></canvas>
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
    </div>

    <script>
        // Error Chart (Horizontal Bar)
        const errorCtx = document.getElementById('errorChart').getContext('2d');
        new Chart(errorCtx, {
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
        }

        // Gauge Instances
        createGauge('gaugeGrainTemp', 'grainTempValue', 35);
        createGauge('gaugeRoomTemp', 'roomTempValue', 27);

        // Suhu Pembakaran Chart
        const burnCtx = document.getElementById('burnChart').getContext('2d');
        new Chart(burnCtx, {
            type: 'line',
            data: {
                labels: ['09:00', '09:10', '09:20', '09:30', '09:40'],
                datasets: [{
                    label: 'Suhu Pembakaran',
                    data: [190, 210, 240, 220, 210],
                    borderColor: '#ef4444',
                    backgroundColor: 'rgba(239, 68, 68, 0.2)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: false,
                        suggestedMin: 180,
                        suggestedMax: 250,
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Kadar Air Gabah Chart
        const moistureCtx = document.getElementById('moistureChart').getContext('2d');
        new Chart(moistureCtx, {
            type: 'line',
            data: {
                labels: ['09:00', '09:10', '09:20', '09:30', '09:40'],
                datasets: [{
                    label: 'Kadar Air (%)',
                    data: [20, 18, 21.5, 19, 14],
                    borderColor: '#0ea5e9',
                    backgroundColor: 'rgba(14, 165, 233, 0.2)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false
                        }
                    },
                    y: {
                        beginAtZero: true,
                        suggestedMin: 12,
                        suggestedMax: 30,
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>

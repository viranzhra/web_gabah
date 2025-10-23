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
        #admin-message {
            display: none;
            text-align: center;
            font-size: 1.5rem;
            font-weight: bold;
            color: #1f2937;
            padding: 2rem;
            border-radius: 0.5rem;
            margin: 1rem;
        }
        .dryer-selected {
            border-color: #3b82f6;
        }
    </style>

    <div id="content-container" class="p-6">
        <!-- Dropdown for Dryer Selection -->
        <div class="mb-6">
            <label for="global_dryer_id" class="form-label">Pilih Bed Dryer <span class="text-danger">*</span></label>
            <select id="global_dryer_id" class="form-control" onchange="updateGlobalDryerId()" style="background-color: white;" required>
                <option value="" disabled selected>-- Pilih Bed Dryer --</option>
            </select>
        </div>

        <!-- ===== DASHBOARD ADMINISTRATOR ===== -->
        <div id="admin-message">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">📊 Dashboard Administrator</h2>

            <!-- === Row 1: 3 Card Utama === -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Total Mitra -->
                <div class="bg-white shadow rounded-xl p-6 flex items-center gap-4 border">
                    <div class="p-3 rounded-full bg-blue-100">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5V4H2v16h5m10 0v-6h-4v6m0-0v-4h4v4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-gray-600 text-sm">Total Mitra</h3>
                        <p id="totalMitra" class="text-3xl font-bold text-blue-700">0</p>
                    </div>
                </div>

                <!-- Mitra Sedang Proses -->
                <div class="bg-white shadow rounded-xl p-6 border">
                    <h3 class="text-gray-600 text-sm mb-3">Mitra Sedang Proses</h3>
                    <ul id="mitraOngoingList" class="text-gray-800 list-disc list-inside text-sm max-h-24 overflow-y-auto">
                        <li>Memuat...</li>
                    </ul>
                </div>

                <!-- Total Alat -->
                <div class="bg-white shadow rounded-xl p-6 flex items-center gap-4 border">
                    <div class="p-3 rounded-full bg-green-100">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 6v6h4m6 6H6V6h12v12z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-gray-600 text-sm">Total Alat Terpasang</h3>
                        <p id="totalAlat" class="text-3xl font-bold text-green-700">0</p>
                    </div>
                </div>
            </div>

            <!-- === Row 2: Tabel & Donut === -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Tabel Mitra -->
                <div class="bg-white shadow rounded-xl p-6 border">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-3">
                        <h3 class="text-gray-700 font-semibold text-lg">📋 Daftar Alat & Mitra</h3>
                        <input id="alatSearch" type="text" placeholder="Cari mitra..."
                               class="w-full sm:w-64 border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    </div>
                    <div class="overflow-auto rounded-lg border border-gray-200">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-100 sticky top-0 z-10">
                                <tr>
                                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Mitra</th>
                                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="alatTableBody" class="divide-y divide-gray-100">
                                <tr>
                                    <td class="px-4 py-3 text-gray-500" colspan="2">Memuat...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Card: Donut Distribusi Alat per Mitra -->
                <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200 w-full flex flex-col">
                    <div class="flex flex-wrap items-center justify-between mb-3">
                        <h3 class="text-gray-700 font-semibold text-lg">Distribusi Alat per Mitra</h3>
                        <span id="topMitraBadge"
                            class="hidden text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-md whitespace-nowrap"></span>
                    </div>
                    <p class="text-gray-500 text-sm mb-4">
                        Menunjukkan sebaran jumlah alat terpasang di masing-masing mitra.
                    </p>
                    <div class="flex-1 flex items-center justify-center">
                        <div class="w-full max-w-lg h-80">
                            <canvas id="alatPerMitraChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="dashboard-grid" class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="col-span-1 md:col-span-2">
                <div id="error-message" class="bg-white shadow rounded-lg p-4 text-red-600 hidden"></div>
                <div id="success-message" class="bg-white shadow rounded-lg p-4 text-green-600 hidden"></div>
            </div>
            <div class="col-span-1 bg-white shadow rounded-lg p-4 flex flex-col justify-center items-center">
                <h2 class="text-lg font-semibold mb-3">Suhu Gabah (Rata-rata)</h2>
                <canvas id="gaugeGrainTemp" width="250" height="130"></canvas>
                <div class="gauge-label" id="grainTempValue">0°C</div>
            </div>
            <div class="col-span-1 bg-white shadow rounded-lg p-4 flex flex-col justify-center items-center">
                <h2 class="text-lg font-semibold mb-3">Suhu Ruangan (Rata-rata)</h2>
                <canvas id="gaugeRoomTemp" width="250" height="130"></canvas>
                <div class="gauge-label" id="roomTempValue">0°C</div>
            </div>
            <div class="col-span-1 bg-white shadow rounded-lg p-4 h-96">
                <h2 class="font-semibold text-lg mb-3">Suhu Pembakaran (Real-time)</h2>
                <div class="h-[calc(100%-2rem)]"><canvas id="burnChart" class="w-full h-full"></canvas></div>
            </div>
            <div class="col-span-1 bg-white shadow rounded-lg p-4 h-96">
                <h2 class="font-semibold text-lg mb-3">Kadar Air Gabah (Real-time)</h2>
                <div class="h-[calc(100%-2rem)]"><canvas id="moistureChart" class="w-full h-full"></canvas></div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Alat -->
    <div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full">
            <div class="flex justify-between items-center border-b px-5 py-3">
                <h3 id="detailModalTitle" class="text-lg font-semibold text-gray-800">Detail Alat</h3>
                <button onclick="closeDetailModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>
            <div class="p-5">
                <ul id="detailModalList" class="list-disc list-inside space-y-1 text-gray-700"></ul>
            </div>
            <div class="border-t px-5 py-3 flex justify-end">
                <button onclick="closeDetailModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Tutup</button>
            </div>
        </div>
    </div>

    <script>
    // Debugging: Log base URL dan token
    console.log('Base URL:', '{{ config('services.api.base_url') }}');
    console.log('Sanctum Token:', '{{ $token ?? '' }}');
    console.log('User Role:', '{{ $role ?? '' }}');

    // ===== Variabel dari controller web
    const sanctumToken = @json($token ?? '');
    const userRole = @json($role ?? '');
    let activeChannel = null;
    let selectedDryerName = '';
    let selectedWarehouseName = '';

    // ===== Utils
    function showError(message) {
        const el = document.getElementById('error-message');
        el.textContent = message;
        el.style.display = 'block';
        console.error('Error displayed:', message);
    }
    function hideError() {
        document.getElementById('error-message').style.display = 'none';
    }

    function showSuccess(message) {
        const el = document.getElementById('success-message');
        el.textContent = message;
        el.style.display = 'block';
        console.log('Success displayed:', message);
    }
    function hideSuccess() {
        document.getElementById('success-message').style.display = 'none';
    }

    function showNotification(message, type = 'info') {
        const bgClass = type === 'error' ? 'bg-red-600' : type === 'warning' ? 'bg-yellow-600' : 'bg-blue-600';
        const el = document.getElementById(type === 'error' ? 'error-message' : 'success-message');
        el.textContent = message;
        el.classList.remove('bg-red-600', 'bg-yellow-600', 'bg-blue-600');
        el.classList.add(bgClass);
        el.style.display = 'block';
    }

    function resetUI() {
        chartData = [];
        grainTempGauge.set(0);
        roomTempGauge.set(0);
        document.getElementById('grainTempValue').textContent = '0°C';
        document.getElementById('roomTempValue').textContent = '0°C';
        burnChart.data.labels = [];
        burnChart.data.datasets[0].data = [];
        moistureChart.data.datasets[0].data = [];
        debouncedUpdateCharts();
        hideSuccess();
    }

    // ===== Debounce untuk optimasi performa
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    // ===== Charts
    function createGauge(canvasId, labelId, currentValue) {
        const opts = {
            angle: 0, lineWidth: 0.2, radiusScale: 1,
            pointer: { length: 0.6, strokeWidth: 0.035, color: '#000000' },
            staticZones: [
                { strokeStyle: "#22c55e", min: 0, max: 30 },
                { strokeStyle: "#eab308", min: 30, max: 40 },
                { strokeStyle: "#ef4444", min: 40, max: 50 }
            ],
            staticLabels: { font: "12px sans-serif", labels: [0, 10, 20, 30, 40, 50], color: "#000", fractionDigits: 0 },
            strokeColor: "#E0E0E0", generateGradient: true, highDpiSupport: true
        };
        const gauge = new Gauge(document.getElementById(canvasId)).setOptions(opts);
        gauge.maxValue = 50; gauge.setMinValue(0); gauge.animationSpeed = 32; gauge.set(currentValue);
        document.getElementById(labelId).textContent = currentValue + '°C';
        return gauge;
    }

    let grainTempGauge = createGauge('gaugeGrainTemp', 'grainTempValue', 0);
    let roomTempGauge = createGauge('gaugeRoomTemp', 'roomTempValue', 0);

    const burnCtx = document.getElementById('burnChart').getContext('2d');
    const burnChart = new Chart(burnCtx, {
        type: 'line',
        data: { labels: [], datasets: [{
            label: 'Suhu Pembakaran',
            data: [],
            borderColor: '#ef4444',
            backgroundColor: 'rgb(246 200 200 / 20%)',
            tension: 0.5,
            fill: true,
            pointRadius: 2,
            pointHoverRadius: 5,
            spanGaps: true
        }]},
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    mode: 'index',
                    intersect: false,
                    callbacks: {
                        label: (ctx) => {
                            const v = Number(ctx.parsed.y);
                            return 'Suhu: ' + (Number.isFinite(v) ? v.toFixed(2) : '-') + '°C';
                        }
                    }
                }
            },
            interaction: { mode: 'index', intersect: false },
            scales: {
                x: { type: 'category', grid: { display: false } },
                y: {
                    beginAtZero: false,
                    grid: { display: false },
                    ticks: {
                        callback: (value) => {
                            const v = Number(value);
                            return (Number.isFinite(v) ? v.toFixed(2) : value) + '°C';
                        }
                    }
                }
            }
        }
    });

    const moistureCtx = document.getElementById('moistureChart').getContext('2d');
    const moistureChart = new Chart(moistureCtx, {
        type: 'line',
        data: { labels: [], datasets: [{
            label: 'Kadar Air (%)',
            data: [],
            borderColor: '#0ea5e9',
            backgroundColor: 'rgb(177 226 248 / 20%)',
            tension: 0.5,
            fill: true,
            pointRadius: 2,
            pointHoverRadius: 5,
            spanGaps: true
        }]},
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: false,
            plugins: {
                legend: { display: false },
                tooltip: { mode: 'index', intersect: false }
            },
            interaction: { mode: 'index', intersect: false },
            scales: {
                x: { type: 'category', grid: { display: false } },
                y: {
                    beginAtZero: false,
                    grid: { display: false },
                    ticks: { callback: (value) => value + '%' }
                }
            }
        }
    });

    // ===== Realtime state
    let chartData = [];
    const MAX_DATA_POINTS = 10; // 10 data terakhir untuk grafik
    let rafPending = false;
    let currentDryerId = null;
    let latestSensorData = {}; // Menyimpan data terbaru per device_id

    function calculateYScale(data, key, minDefault, maxDefault, marginPercent = 0.1) {
        if (!data || data.length === 0) return { min: minDefault, max: maxDefault };
        const values = data.map(d => Number(d[key])).filter(v => Number.isFinite(v));
        if (values.length === 0) return { min: minDefault, max: maxDefault };
        const min = Math.min(...values), max = Math.max(...values);
        const range = Math.max(max - min, 1);
        const margin = range * marginPercent;
        return { min: Math.max(minDefault, min - margin), max: Math.min(maxDefault, max + margin) };
    }

    function fillMissingData(dataArray, key) {
        let lastValidValue = null;
        return dataArray.map(item => {
            if (item[key] === null || !Number.isFinite(parseFloat(item[key]))) {
                return lastValidValue !== null ? lastValidValue : 0;
            }
            lastValidValue = parseFloat(item[key]);
            return lastValidValue;
        });
    }

    const debouncedUpdateCharts = debounce(updateCharts, 100);

    function updateCharts() {
        const labels = chartData.map(d => d.time);
        let burnData = chartData.map(d => d.burn);
        let moistureData = chartData.map(d => d.moisture);

        burnData = fillMissingData(chartData, 'burn');
        moistureData = fillMissingData(chartData, 'moisture');

        console.log('Chart Data:', chartData);
        console.log('Burn Data:', burnData);
        console.log('Moisture Data:', moistureData);
        console.log('Labels:', labels);

        const burnScale = calculateYScale(chartData, 'burn', 180, 350, 0.1);
        const moistureScale = calculateYScale(chartData, 'moisture', 0, 30, 0.1);

        burnChart.data.labels = labels;
        burnChart.data.datasets[0].data = burnData;
        burnChart.options.scales.y.suggestedMin = burnScale.min;
        burnChart.options.scales.y.suggestedMax = burnScale.max;

        moistureChart.data.labels = labels;
        moistureChart.data.datasets[0].data = moistureData;
        moistureChart.options.scales.y.suggestedMin = moistureScale.min;
        moistureChart.options.scales.y.suggestedMax = moistureScale.max;

        if (!rafPending) {
            rafPending = true;
            requestAnimationFrame(() => {
                burnChart.update('none');
                moistureChart.update('none');
                rafPending = false;
                console.log('Charts updated');
            });
        }

        if (chartData.length === 0) showError('Tidak ada data sensor untuk ditampilkan di grafik.');
        else hideError();
    }

    // Fetch available dryers
    async function fetchGlobalDryers() {
        const userId = {{ auth()->id() }};
        const dryerSelect = document.getElementById('global_dryer_id');

        if (!dryerSelect) {
            console.warn('Element #global_dryer_id tidak ditemukan');
            return;
        }

        dryerSelect.innerHTML = '<option value="" disabled selected>-- Memuat Bed Dryer --</option>';
        dryerSelect.disabled = true;

        try {
            const baseUrl = '{{ config("services.api.base_url") }}';
            const url = baseUrl.endsWith('/') ? `${baseUrl}bed-dryers?user_id=${userId}` : `${baseUrl}/bed-dryers?user_id=${userId}`;
            const response = await fetch(url, {
                headers: {
                    'Authorization': `Bearer ${sanctumToken}`,
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                const err = await response.json().catch(() => ({}));
                throw new Error(err.message || `HTTP ${response.status}: ${response.statusText}`);
            }

            const result = await response.json();
            const dryers = result.data || [];

            if (!Array.isArray(dryers) || dryers.length === 0) {
                dryerSelect.innerHTML = '<option value="" disabled>Tidak ada bed dryer tersedia</option>';
                showNotification('Tidak ada bed dryer tersedia untuk user ini.', 'error');
                return;
            }

            dryerSelect.innerHTML = '<option value="" disabled selected>-- Pilih Bed Dryer --</option>';
            dryers.forEach(dryer => {
                const option = document.createElement('option');
                option.value = dryer.dryer_id;
                const warehouseName = dryer.warehouse ? dryer.warehouse.nama : 'Gudang Default';
                const dryerName = dryer.nama || `Bed Dryer ${dryer.dryer_id}`;
                option.textContent = `${dryerName} - ${warehouseName}`;
                option.dataset.dryerName = dryerName;
                option.dataset.warehouseName = warehouseName;
                dryerSelect.appendChild(option);
            });

            const savedDryerId = localStorage.getItem('selected_dryer_id');
            const savedOption = Array.from(dryerSelect.options).find(opt => opt.value == savedDryerId);

            if (savedOption) {
                dryerSelect.value = savedDryerId;
                updateGlobalDryerId();
            } else if (dryers.length > 0) {
                dryerSelect.value = dryers[0].dryer_id;
                updateGlobalDryerId();
            }

            dryerSelect.disabled = false;

        } catch (err) {
            console.error('Error fetching global dryers:', err);
            dryerSelect.innerHTML = '<option value="" disabled>Gagal memuat bed dryer</option>';
            dryerSelect.disabled = false;
            showNotification(`Gagal memuat daftar dryer: ${err.message}`, 'error');
        }
    }

    // Update global dryer_id
    window.updateGlobalDryerId = function() {
        const dryerSelect = document.getElementById('global_dryer_id');

        if (!dryerSelect) {
            console.warn('Required elements not found');
            return;
        }

        const dryerId = dryerSelect.value;
        const selectedOption = dryerSelect.options[dryerSelect.selectedIndex];

        if (dryerId) {
            dryerSelect.classList.add('dryer-selected');
            localStorage.setItem('selected_dryer_id', dryerId);

            if (selectedOption) {
                selectedDryerName = selectedOption.dataset.dryerName || `Bed Dryer ${dryerId}`;
                selectedWarehouseName = selectedOption.dataset.warehouseName || 'Gudang Utama';
            }

            fetchSensorData(dryerId);
            startWebSocket(dryerId);

        } else {
            localStorage.removeItem('selected_dryer_id');
            dryerSelect.classList.remove('dryer-selected');
            resetUI();
            if (activeChannel) {
                window.Echo.leave(activeChannel);
                activeChannel = null;
            }
            showNotification('Silakan pilih bed dryer untuk melihat data.', 'warning');
        }
    };

    // ===== WebSocket dengan Laravel Echo
    function startWebSocket(dryerId) {
        if (typeof window.Echo === 'undefined') {
            console.error('Echo not loaded. Pastikan app.js diinclude di layout.');
            showError('Gagal memuat WebSocket. Coba refresh halaman.');
            setTimeout(() => startWebSocket(dryerId), 5000);
            return;
        }

        if (!dryerId || dryerId === 'default') {
            console.warn('Invalid or default dryerId:', dryerId);
            showError('Dryer ID tidak valid.');
            return;
        }

        if (currentDryerId && currentDryerId !== dryerId) {
            console.log(`Stopping WebSocket for old channel: drying-process.${currentDryerId}`);
            window.Echo.leave(`drying-process.${currentDryerId}`);
        }

        currentDryerId = dryerId;
        activeChannel = `drying-process.${dryerId}`;
        console.log('Starting WebSocket for channel:', activeChannel);

        window.Echo.channel(activeChannel)
            .subscribed(() => {
                console.log(`✅ SUBSCRIBED to ${activeChannel}`);
                showSuccess(`Sedang aktif data realtime dari ${selectedDryerName} (${selectedWarehouseName})`);
            })
            .listen('.sensor-updated', (event) => {
                console.log("📡 Event received:", JSON.stringify(event, null, 2));
                const data = event.payload || {};

                // Validasi data event
                if (!data.sensors || !data.sensors.data || !Array.isArray(data.sensors.data) || data.sensors.data.length === 0) {
                    console.warn('Empty or invalid sensor data received:', data);
                    showError('Data sensor kosong atau tidak valid dari WebSocket.');
                    showSuccess(`Tidak ada proses pengeringan aktif pada ${selectedDryerName} (${selectedWarehouseName})`);
                    return;
                }

                // Ambil dryer_id dari drying_process jika tersedia
                const dryerId = data.drying_process?.dryer_id || currentDryerId;

                // Iterasi data sensor untuk memperbarui latestSensorData
                data.sensors.data.forEach(sensor => {
                    if (!sensor.device_id) {
                        console.warn('Missing device_id in sensor data:', sensor);
                        return;
                    }

                    latestSensorData[sensor.device_id] = {
                        timestamp: sensor.timestamp || new Date().toISOString(),
                        suhu_pembakaran: parseFloat(sensor.suhu_pembakaran) || null,
                        kadar_air_gabah: parseFloat(sensor.kadar_air_gabah) || null,
                        suhu_gabah: parseFloat(sensor.suhu_gabah) || null,
                        suhu_ruangan: parseFloat(sensor.suhu_ruangan) || null,
                        status_pengaduk: sensor.status_pengaduk ?? null,
                        process_id: sensor.process_id || dryerId,
                        device_name: sensor.device_name || sensor.device_id || 'Unknown Device'
                    };
                });

                // Gunakan rata-rata dari sensors untuk gauge
                const avgGrainTemp = parseFloat(data.sensors.avg_grain_temperature) || null;
                const avgRoomTemp = parseFloat(data.sensors.avg_room_temperature) || null;

                // Update gauge
                if (avgGrainTemp != null && Number.isFinite(avgGrainTemp)) {
                    grainTempGauge.set(avgGrainTemp);
                    document.getElementById('grainTempValue').textContent = avgGrainTemp.toFixed(2) + '°C';
                }
                if (avgRoomTemp != null && Number.isFinite(avgRoomTemp)) {
                    roomTempGauge.set(avgRoomTemp);
                    document.getElementById('roomTempValue').textContent = avgRoomTemp.toFixed(2) + '°C';
                }

                // Ambil data sensor terbaru untuk chart
                const latestSensor = data.sensors.data[0];
                if (!latestSensor) {
                    console.warn('No valid sensor data for chart update');
                    showSuccess(`Tidak ada proses pengeringan aktif pada ${selectedDryerName} (${selectedWarehouseName})`);
                    return;
                }

                const newData = {
                    time: new Date(latestSensor.timestamp).toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        timeZone: 'Asia/Jakarta'
                    }),
                    timestamp: latestSensor.timestamp,
                    burn: parseFloat(latestSensor.suhu_pembakaran) || null,
                    moisture: parseFloat(latestSensor.kadar_air_gabah) || null,
                    grainTemp: parseFloat(latestSensor.suhu_gabah) || null,
                    roomTemp: parseFloat(latestSensor.suhu_ruangan) || null,
                    dryerId: dryerId
                };

                // Cek duplikasi timestamp
                const existing = chartData.find(d => d.timestamp === newData.timestamp);
                if (!existing) {
                    chartData.push(newData);
                    chartData.sort((a, b) => new Date(a.timestamp) - new Date(b.timestamp));
                    chartData = chartData.slice(-MAX_DATA_POINTS);
                    debouncedUpdateCharts();
                }

                showSuccess(`Sedang aktif data realtime dari ${selectedDryerName} (${selectedWarehouseName})`);
                hideError();

                // Jika dryer_id baru, mulai WebSocket baru
                if (dryerId && dryerId !== currentDryerId) {
                    console.log(`New dryer_id detected: ${dryerId}`);
                    startWebSocket(dryerId);
                }
            })
            .error((error) => {
                console.error('WebSocket Error:', JSON.stringify(error, null, 2));
                showError('Gagal terhubung ke WebSocket: ' + (error.message || JSON.stringify(error)));
                showSuccess(`Tidak ada proses pengeringan aktif pada ${selectedDryerName} (${selectedWarehouseName})`);
                setTimeout(() => startWebSocket(dryerId), 5000);
            });
    }

    // Fetch data awal
    function fetchSensorData(dryerId) {
        if (!dryerId) {
            showError('Silakan pilih Bed Dryer terlebih dahulu.');
            showSuccess(`Tidak ada proses pengeringan aktif pada ${selectedDryerName} (${selectedWarehouseName})`);
            return;
        }
        const baseUrl = '{{ config("services.api.base_url") }}';
        const endpoint = baseUrl.endsWith('/') ? `${baseUrl}get_sensor/realtime?dryer_id=${dryerId}` : `${baseUrl}/get_sensor/realtime?dryer_id=${dryerId}`;
        console.log('Fetching initial data from:', endpoint);
        fetch(endpoint, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${sanctumToken}`,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => {
            if (!res.ok) {
                return res.text().then(text => {
                    console.error('Server error at /get_sensor/realtime:', text.substring(0, 200));
                    throw new Error(`HTTP ${res.status}: ${text.substring(0, 100)}`);
                });
            }
            return res.json();
        })
        .then(data => {
            console.log('Initial API Response:', JSON.stringify(data, null, 2));
            const dryerId = data.drying_process?.dryer_id || 'default';

            if (!data.sensors || !data.sensors.data || !data.drying_process) {
                showError(data.message || data.error || 'Tidak ada proses pengeringan aktif untuk dryer ini.');
                showSuccess(`Tidak ada proses pengeringan aktif pada ${selectedDryerName} (${selectedWarehouseName})`);
                resetUI();
                startWebSocket(dryerId);
                return;
            }

            // Update gauge dengan rata-rata awal
            if (data.sensors.avg_grain_temperature != null) {
                const v = parseFloat(data.sensors.avg_grain_temperature);
                if (Number.isFinite(v)) {
                    grainTempGauge.set(v);
                    document.getElementById('grainTempValue').textContent = v.toFixed(2) + '°C';
                }
            }
            if (data.sensors.avg_room_temperature != null) {
                const v = parseFloat(data.sensors.avg_room_temperature);
                if (Number.isFinite(v)) {
                    roomTempGauge.set(v);
                    document.getElementById('roomTempValue').textContent = v.toFixed(2) + '°C';
                }
            }

            // Update chart dengan 10 data terakhir awal
            chartData = (data.sensors.data || [])
                .sort((a, b) => new Date(a.timestamp) - new Date(b.timestamp))
                .slice(-MAX_DATA_POINTS)
                .map(item => ({
                    time: new Date(item.timestamp).toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        timeZone: 'Asia/Jakarta'
                    }),
                    timestamp: item.timestamp,
                    burn: parseFloat(item.suhu_pembakaran) || null,
                    moisture: parseFloat(item.kadar_air_gabah) || null,
                    grainTemp: parseFloat(item.suhu_gabah) || null,
                    roomTemp: parseFloat(item.suhu_ruangan) || null,
                    dryerId: dryerId
                }));

            console.log('Initial Chart Data:', chartData);
            debouncedUpdateCharts();
            showSuccess(`Sedang aktif data realtime dari ${selectedDryerName} (${selectedWarehouseName})`);
            hideError();

            // Mulai WebSocket setelah initial data
            startWebSocket(dryerId);
        })
        .catch((error) => {
            console.error('Error fetching initial sensor data:', error);
            showError('Gagal mengambil data sensor awal: ' + error.message);
            showSuccess(`Tidak ada proses pengeringan aktif pada ${selectedDryerName} (${selectedWarehouseName})`);
            resetUI();
            startWebSocket(dryerId || 'default');
        });
    }

    // ===== Cek role user
    function checkUserRole() {
        if (!sanctumToken) {
            console.error('No sanctum token found, redirecting to login');
            showError('Silakan login terlebih dahulu');
            setTimeout(() => {
                window.location.href = '{{ route("login") }}';
            }, 2000);
            return;
        }
        if (String(userRole).toLowerCase() === 'administrator') {
            console.log('User is administrator, showing admin dashboard');
            document.getElementById('admin-message').style.display = 'block';
            document.getElementById('dashboard-grid').style.display = 'none';
            document.getElementById('global_dryer_id').style.display = 'none';
        } else {
            console.log('User is non-administrator, showing sensor dashboard');
            document.getElementById('admin-message').style.display = 'none';
            document.getElementById('dashboard-grid').style.display = 'grid';
            fetchGlobalDryers();
        }
    }

    // ===== Admin Dashboard Scripts
    document.addEventListener("DOMContentLoaded", function() {
        const token = localStorage.getItem('token') || sanctumToken;
        if (!token) {
            console.error('No token found for admin summary, redirecting to login');
            showError('Silakan login terlebih dahulu');
            setTimeout(() => {
                window.location.href = '{{ route("login") }}';
            }, 2000);
            return;
        }

        const url = '{{ config("services.api.base_url") }}/dashboard/admin-summary';
        console.log('Fetching admin summary from:', url);

        const totalMitraEl = document.getElementById('totalMitra');
        const mitraOngoingListEl = document.getElementById('mitraOngoingList');
        const totalAlatEl = document.getElementById('totalAlat');
        const alatTableBodyEl = document.getElementById('alatTableBody');
        const alatSearchEl = document.getElementById('alatSearch');
        const topMitraBadgeEl = document.getElementById('topMitraBadge');

        let alatDetail = [];
        let donutChart = null;

        function groupByMitra(rows) {
            const map = new Map();
            for (const r of rows) {
                const key = r.mitra || 'Tidak diketahui';
                map.set(key, (map.get(key) || 0) + 1);
            }
            return map;
        }

        function renderSummary(data) {
            totalMitraEl.textContent = data.total_mitra ?? 0;
            totalAlatEl.textContent = data.total_alat ?? 0;

            mitraOngoingListEl.innerHTML = '';
            const arr = Array.isArray(data.mitra_ongoing) ? data.mitra_ongoing : [];
            if (arr.length) {
                arr.forEach(nama => {
                    const li = document.createElement('li');
                    li.textContent = nama;
                    mitraOngoingListEl.appendChild(li);
                });
            } else {
                mitraOngoingListEl.innerHTML = '<li>Tidak ada proses pengeringan berlangsung</li>';
            }
        }

        function renderTable(rows, q = '') {
            const query = q.trim().toLowerCase();
            const grouped = {};
            rows.forEach(r => {
                const mitra = r.mitra || 'Tidak diketahui';
                if (!grouped[mitra]) grouped[mitra] = [];
                grouped[mitra].push(r.device_name || '-');
            });

            const filteredMitra = Object.keys(grouped).filter(m =>
                !query || m.toLowerCase().includes(query)
            );

            alatTableBodyEl.innerHTML = '';
            if (!filteredMitra.length) {
                alatTableBodyEl.innerHTML =
                    '<tr><td class="px-3 py-2 text-gray-500" colspan="2">Tidak ada data</td></tr>';
                return;
            }

            filteredMitra.forEach(mitra => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td class="px-3 py-2 font-medium text-gray-800">${mitra}</td>
                    <td class="px-3 py-2">
                        <button class="text-blue-600 hover:text-blue-800"
                                title="Lihat Detail"
                                onclick="showDetail('${mitra.replace(/'/g, "\\'")}')">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="w-5 h-5 inline-block" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5
                                         c4.477 0 8.268 2.943 9.542 7
                                         -1.274 4.057-5.065 7-9.542 7
                                         -4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </td>
                `;
                alatTableBodyEl.appendChild(tr);
            });

            window.groupedAlatData = grouped;
        }

        window.showDetail = function (mitra) {
            const alatList = window.groupedAlatData?.[mitra] || [];
            document.getElementById('detailModalTitle').textContent = `Alat milik ${mitra}`;
            const listEl = document.getElementById('detailModalList');
            listEl.innerHTML = '';
            if (alatList.length) {
                alatList.forEach(alat => {
                    const li = document.createElement('li');
                    li.textContent = alat;
                    listEl.appendChild(li);
                });
            } else {
                listEl.innerHTML = '<li class="text-gray-500">Tidak ada data alat</li>';
            }
            document.getElementById('detailModal').classList.remove('hidden');
            document.getElementById('detailModal').classList.add('flex');
        };

        window.closeDetailModal = function () {
            const modal = document.getElementById('detailModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        };

        function renderDonut(rows) {
            const grouped = groupByMitra(rows);
            const labels = Array.from(grouped.keys());
            const data = Array.from(grouped.values());

            if (labels.length) {
                const maxIdx = data.indexOf(Math.max(...data));
                topMitraBadgeEl.textContent = `Top: ${labels[maxIdx]} • ${data[maxIdx]} alat`;
                topMitraBadgeEl.classList.remove('hidden');
            } else {
                topMitraBadgeEl.classList.add('hidden');
            }

            const ctx = document.getElementById('alatPerMitraChart').getContext('2d');
            if (donutChart) { donutChart.destroy(); }
            donutChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels,
                    datasets: [{
                        data,
                        backgroundColor: [
                            '#3b82f6','#22c55e','#ef4444','#f59e0b','#8b5cf6',
                            '#06b6d4','#84cc16','#f97316','#e11d48','#0ea5e9'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '60%',
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: {
                            callbacks: {
                                label: (ctx) => {
                                    const total = ctx.dataset.data.reduce((a,b)=>a+b,0) || 1;
                                    const val = ctx.parsed;
                                    const pct = ((val/total)*100).toFixed(1);
                                    return `${ctx.label}: ${val} alat (${pct}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        fetch(url, {
            headers: {
                'Authorization': `Bearer ${token}`,
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(res => {
            if (!res.ok) {
                return res.text().then(text => {
                    console.error('Admin summary error:', text.substring(0, 200));
                    throw new Error(`HTTP ${res.status}: ${text.substring(0, 100)}`);
                });
            }
            return res.json();
        })
        .then(payload => {
            console.log('Admin summary response:', payload);
            if (!payload.success) throw new Error(payload.error || 'Gagal memuat data');
            renderSummary(payload.data || {});
            alatDetail = Array.isArray(payload.data.alat_detail) ? payload.data.alat_detail : [];
            renderTable(alatDetail);
            renderDonut(alatDetail);
        })
        .catch(err => {
            console.error('Admin summary error:', err);
            mitraOngoingListEl.innerHTML = '<li>Gagal memuat data</li>';
            alatTableBodyEl.innerHTML = '<tr><td class="px-3 py-2 text-red-600" colspan="2">Gagal memuat data</td></tr>';
        });

        if (alatSearchEl) {
            alatSearchEl.addEventListener('input', (e) => {
                renderTable(alatDetail, e.target.value || '');
            });
        }
    });

    // Start
    document.addEventListener('DOMContentLoaded', checkUserRole);
    </script>

@endsection
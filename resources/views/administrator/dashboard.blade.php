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
            /* background-color: #f3f4f6; */
            border-radius: 0.5rem;
            margin: 1rem;
        }
    </style>

    <div id="content-container" class="p-6">
        <div id="admin-message">
    <h2 class="text-xl font-bold mb-4">Dashboard Administrator</h2>

    <!-- === Row 1: 3 Card Utama === -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card Total Mitra -->
        <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200">
            <h3 class="text-gray-500 text-sm font-semibold">Total Mitra</h3>
            <p id="totalMitra" class="text-3xl font-bold text-blue-600 mt-2">0</p>
        </div>

        <!-- Card Mitra Sedang Proses -->
        <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200">
            <h3 class="text-gray-500 text-sm font-semibold">Mitra Sedang Proses</h3>
            <ul id="mitraOngoingList" class="mt-2 text-gray-800 list-disc list-inside text-sm">
                <li>Memuat...</li>
            </ul>
        </div>

        <!-- Card Total Alat Terpasang -->
        <div class="bg-white shadow-lg rounded-lg p-6 border border-gray-200">
            <h3 class="text-gray-500 text-sm font-semibold">Total Alat Terpasang</h3>
            <p id="totalAlat" class="text-3xl font-bold text-green-600 mt-2">0</p>
        </div>
    </div>

    <!-- === Row 2: 2 Card Tambahan (Tabel & Donut) === -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
        <!-- Card: Daftar Alat & Mitra -->
<div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200 w-full">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-3">
        <h3 class="text-gray-700 font-semibold text-lg">Daftar Alat & Mitra</h3>
        <input id="alatSearch" type="text" placeholder="Cari mitra..."
            class="w-full sm:w-64 border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none">
    </div>
    <div class="overflow-auto rounded-lg border border-gray-100">
        <table class="min-w-full text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-left px-4 py-2 font-semibold text-gray-600">Mitra</th>
                    <th class="text-left px-4 py-2 font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody id="alatTableBody" class="divide-y divide-gray-100">
                <tr>
                    <td class="px-4 py-2 text-gray-500" colspan="2">Memuat...</td>
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

</div>

<!-- Modal Detail Alat -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
  <div class="bg-white rounded-lg shadow-lg max-w-md w-full">
    <!-- Header -->
    <div class="flex justify-between items-center border-b px-5 py-3">
      <h3 id="detailModalTitle" class="text-lg font-semibold text-gray-800">Detail Alat</h3>
      <button onclick="closeDetailModal()" class="text-gray-500 hover:text-gray-700">&times;</button>
    </div>
    <!-- Body -->
    <div class="p-5">
      <ul id="detailModalList" class="list-disc list-inside space-y-1 text-gray-700">
        <!-- Daftar alat akan diisi lewat JS -->
      </ul>
    </div>
    <!-- Footer -->
    <div class="border-t px-5 py-3 flex justify-end">
      <button onclick="closeDetailModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Tutup</button>
    </div>
  </div>
</div>


<script>
document.addEventListener("DOMContentLoaded", function() {
  const token = localStorage.getItem('token'); // Ambil token login
  const url = '{{ config("services.api.base_url") }}/dashboard/admin-summary';

  // Elemen
  const totalMitraEl = document.getElementById('totalMitra');
  const mitraOngoingListEl = document.getElementById('mitraOngoingList');
  const totalAlatEl = document.getElementById('totalAlat');
  const alatTableBodyEl = document.getElementById('alatTableBody');
  const alatSearchEl = document.getElementById('alatSearch');
  const topMitraBadgeEl = document.getElementById('topMitraBadge');

  // State
  let alatDetail = [];
  let donutChart = null;

  // Helper: group by mitra
  function groupByMitra(rows) {
    const map = new Map();
    for (const r of rows) {
      const key = r.mitra || 'Tidak diketahui';
      map.set(key, (map.get(key) || 0) + 1);
    }
    return map;
  }

  // Render: 3 card atas
  function renderSummary(data) {
    totalMitraEl.textContent = data.total_mitra ?? 0;
    totalAlatEl.textContent = data.total_alat ?? 0;

    // List mitra ongoing
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

// Render: tabel alat (group by mitra)
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

  // simpan data grouped ke global biar bisa diakses dari showDetail()
  window.groupedAlatData = grouped;
}

// Definisikan fungsi ini di global scope
window.showDetail = function (mitra) {
  const alatList = window.groupedAlatData?.[mitra] || [];
  alert(`Alat milik ${mitra}:\n- ${alatList.join('\n- ')}`);
};


  // Render: donut distribusi
  function renderDonut(rows) {
    const grouped = groupByMitra(rows);
    const labels = Array.from(grouped.keys());
    const data = Array.from(grouped.values());

    // Top mitra (terbanyak alat)
    if (labels.length) {
      const maxIdx = data.indexOf(Math.max(...data));
      topMitraBadgeEl.textContent = `Top: ${labels[maxIdx]} • ${data[maxIdx]} alat`;
      topMitraBadgeEl.classList.remove('hidden');
    } else {
      topMitraBadgeEl.classList.add('hidden');
    }

    const ctx = document.getElementById('alatPerMitraChart').getContext('2d');

    // Hancurkan chart lama jika ada
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

  // Fetch
  fetch(url, {
    headers: {
      'Authorization': `Bearer ${token}`,
      'Accept': 'application/json'
    }
  })
  .then(res => {
    if (!res.ok) throw new Error(`HTTP ${res.status}`);
    return res.json();
  })
  .then(payload => {
    if (!payload.success) throw new Error(payload.error || 'Gagal memuat data');

    // 3 card
    renderSummary(payload.data || {});

    // Tabel & Donut
    alatDetail = Array.isArray(payload.data.alat_detail) ? payload.data.alat_detail : [];
    renderTable(alatDetail);
    renderDonut(alatDetail);
  })
  .catch(err => {
    console.error(err);
    mitraOngoingListEl.innerHTML = '<li>Gagal memuat data</li>';
    alatTableBodyEl.innerHTML = '<tr><td class="px-3 py-2 text-red-600" colspan="2">Gagal memuat data</td></tr>';
  });

  // Pencarian tabel
  if (alatSearchEl) {
    alatSearchEl.addEventListener('input', (e) => {
      renderTable(alatDetail, e.target.value || '');
    });
  }
});

// Tampilkan modal detail
window.showDetail = function (mitra) {
  const alatList = window.groupedAlatData?.[mitra] || [];

  // Set judul modal
  document.getElementById('detailModalTitle').textContent = `Alat milik ${mitra}`;

  // Isi daftar alat
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

  // Tampilkan modal
  document.getElementById('detailModal').classList.remove('hidden');
  document.getElementById('detailModal').classList.add('flex');
};

// Tutup modal
window.closeDetailModal = function () {
  const modal = document.getElementById('detailModal');
  modal.classList.add('hidden');
  modal.classList.remove('flex');
};

</script>


        <div id="dashboard-grid" class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="col-span-1 md:col-span-2">
        <div id="error-message" class="bg-white shadow rounded-lg p-4 text-red-600 hidden"></div>
        <div id="success-message" class="bg-white shadow rounded-lg p-4 text-green-600 hidden"></div>
    </div>

        <div class="col-span-1 bg-white shadow rounded-lg p-4 flex flex-col justify-center items-center">
        <h2 class="text-lg font-semibold mb-3">Suhu Gabah</h2>
        <canvas id="gaugeGrainTemp" width="250" height="130"></canvas>
        <div class="gauge-label" id="grainTempValue">0°C</div>
    </div>

    <div class="col-span-1 bg-white shadow rounded-lg p-4 flex flex-col justify-center items-center">
        <h2 class="text-lg font-semibold mb-3">Suhu Ruangan</h2>
        <canvas id="gaugeRoomTemp" width="250" height="130"></canvas>
        <div class="gauge-label" id="roomTempValue">0°C</div>
    </div>
    <div class="col-span-1 bg-white shadow rounded-lg p-4 h-96">
        <h2 class="font-semibold text-lg mb-3">Suhu Pembakaran</h2>
        <div class="h-[calc(100%-2rem)]"><canvas id="burnChart" class="w-full h-full"></canvas></div>
    </div>

    <div class="col-span-1 bg-white shadow rounded-lg p-4 h-96">
        <h2 class="font-semibold text-lg mb-3">Kadar Air Gabah</h2>
        <div class="h-[calc(100%-2rem)]"><canvas id="moistureChart" class="w-full h-full"></canvas></div>
    </div>
</div>
    </div>

    <script>
    // ===== Variabel dari controller web
    const sanctumToken = @json($token ?? '');
    const userRole = @json($role ?? '');

    // ===== Utils
    function showError(message) {
        const el = document.getElementById('error-message');
        el.textContent = message;
        el.style.display = 'block';
    }
    function hideError() { document.getElementById('error-message').style.display = 'none'; }

    function showSuccess(message) {
    const el = document.getElementById('success-message');
    el.textContent = message;
    el.style.display = 'block';
}
function hideSuccess() { document.getElementById('success-message').style.display = 'none'; }

    // ===== Cek role user (tanpa fetch API)
    function checkUserRole() {
        if (!sanctumToken) {
            showError('Silakan login terlebih dahulu');
            window.location.href = '{{ route("login") }}';
            return;
        }
        if (String(userRole).toLowerCase() === 'administrator') {
            document.getElementById('admin-message').style.display = 'block';
            document.getElementById('dashboard-grid').style.display = 'none';
        } else {
            document.getElementById('admin-message').style.display = 'none';
            document.getElementById('dashboard-grid').style.display = 'grid';
            connectToApi();
        }
    }

     // ===== Charts
        // const errorCtx = document.getElementById('errorChart').getContext('2d');
        // const errorChart = new Chart(errorCtx, {
        //     type: 'bar',
        //     data: {
        //         labels: ['Proses 1', 'Proses 2', 'Proses 3', 'Proses 4', 'Proses 5'],
        //         datasets: [{
        //             label: 'Selisih (menit)',
        //             data: [1.5, -0.8, 0.6, -1.2, 1.0],
        //             backgroundColor: (ctx) => (ctx.dataset.data[ctx.dataIndex] >= 0 ? 'rgba(34, 197, 94, 0.7)' : 'rgba(239, 68, 68, 0.7)'),
        //             hoverBackgroundColor: (ctx) => (ctx.dataset.data[ctx.dataIndex] >= 0 ? 'rgba(34, 197, 94, 1)' : 'rgba(239, 68, 68, 1)'),
        //             borderRadius: 6,
        //             barThickness: 20
        //         }]
        //     },
        //     options: {
        //         responsive: true, maintainAspectRatio: false, animation: false, indexAxis: 'y',
        //         scales: {
        //             x: { beginAtZero: true, title: { display: true, text: 'Selisih Durasi (menit)' }, grid: { color: 'rgba(0,0,0,0.05)' } },
        //             y: { grid: { display: false } }
        //         },
        //         plugins: { legend: { display: false } }
        //     }
        // });

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
        let roomTempGauge  = createGauge('gaugeRoomTemp', 'roomTempValue', 0);

        const burnCtx = document.getElementById('burnChart').getContext('2d');
        const burnChart = new Chart(burnCtx, {
            type: 'line',
            data: { labels: [], datasets: [{
                label: 'Suhu Pembakaran', data: [],
                borderColor: '#ef4444', backgroundColor: 'rgb(246 200 200 / 20%)',
                tension: 0.4, fill: true, pointRadius: 0, pointHoverRadius: 5
            }]},
            options: {
                responsive: true, maintainAspectRatio: false, animation: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { mode: 'index', intersect: false,
                        callbacks: { label: (ctx) => {
                            const v = Number(ctx.parsed.y); return 'Suhu: ' + (Number.isFinite(v) ? v.toFixed(2) : '-') + '°C';
                        }}
                    }
                },
                interaction: { mode: 'index', intersect: false },
                scales: {
                    x: { type: 'category', grid: { display: false } },
                    y: { beginAtZero: false, grid: { display: false },
                        ticks: { callback: (value) => {
                            const v = Number(value); return (Number.isFinite(v) ? v.toFixed(2) : value) + '°C';
                        }}
                    }
                }
            }
        });

        const moistureCtx = document.getElementById('moistureChart').getContext('2d');
        const moistureChart = new Chart(moistureCtx, {
            type: 'line',
            data: { labels: [], datasets: [{
                label: 'Kadar Air (%)', data: [],
                borderColor: '#0ea5e9', backgroundColor: 'rgb(177 226 248 / 20%)',
                tension: 0.4, fill: true, pointRadius: 0, pointHoverRadius: 5
            }]},
            options: {
                responsive: true, maintainAspectRatio: false, animation: false,
                plugins: { legend: { display: false }, tooltip: { mode: 'index', intersect: false } },
                interaction: { mode: 'index', intersect: false },
                scales: {
                    x: { type: 'category', grid: { display: false } },
                    y: { beginAtZero: false, grid: { display: false },
                        ticks: { callback: (value) => value + '%' }
                    }
                }
            }
        });

        // ===== Realtime state
        let chartData = [];
        const DATA_UPDATE_INTERVAL = 5000;
        const MAX_DATA_POINTS = 8;
        let lastUpdateTime = 0;
        let rafPending = false;
        let sseSource = null;

        function calculateYScale(data, key, minDefault, maxDefault, marginPercent = 0.1) {
            if (!data || data.length === 0) return { min: minDefault, max: maxDefault };
            const values = data.map(d => Number(d[key])).filter(v => Number.isFinite(v));
            if (values.length === 0) return { min: minDefault, max: maxDefault };
            const min = Math.min(...values), max = Math.max(...values);
            const range = Math.max(max - min, 1);
            const margin = range * marginPercent;
            return { min: Math.max(minDefault, min - margin), max: Math.min(maxDefault, max + margin) };
        }

        function updateCharts() {
            const labels = chartData.map(d => d.time);
            const burnData = chartData.map(d => d.burn);
            const moistureData = chartData.map(d => d.moisture);

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
                });
            }

            if (chartData.length === 0) showError('Tidak ada data sensor valid untuk ditampilkan di grafik.');
            else hideError();
        }


    // ===== SSE
    function startSSE(processId) {
        if (sseSource) { try { sseSource.close(); } catch (e) {} sseSource = null; }
        const url = `{{ config('services.api.base_url') }}/sse/sensor-data/${processId}`;
        const source = new EventSource(url);

        source.addEventListener('sensor-update', (event) => {
            const data = JSON.parse(event.data);
            if (data.error || data.status === 'invalid') { showError(data.error || 'Data tidak valid'); return; }
            const now = Date.now();
            if (now - lastUpdateTime >= DATA_UPDATE_INTERVAL) {
                lastUpdateTime = now;
                chartData.push({
                    time: new Date(data.timestamp).toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit', timeZone: 'Asia/Jakarta' }),
                    burn: parseFloat(data.suhu_pembakaran),
                    moisture: parseFloat(data.kadar_air)
                });
                if (chartData.length > MAX_DATA_POINTS) chartData.shift();

                if (data.suhu_gabah != null) {
                    const v = parseFloat(data.suhu_gabah);
                    if (Number.isFinite(v)) {
                        grainTempGauge.set(v);
                        document.getElementById('grainTempValue').textContent = v.toFixed(2) + '°C';
                    }
                }
                if (data.suhu_ruangan != null) {
                    const v = parseFloat(data.suhu_ruangan);
                    if (Number.isFinite(v)) {
                        roomTempGauge.set(v);
                        document.getElementById('roomTempValue').textContent = v.toFixed(2) + '°C';
                    }
                }
                updateCharts();
            }
        });

        source.addEventListener('notification', (event) => {
            const n = JSON.parse(event.data);
            console.log('SSE Notification:', n);
        });

        source.addEventListener('error', (event) => {
            console.error('SSE Error:', event);
            try { source.close(); } catch (e) {}
            sseSource = null;
            setTimeout(connectToApi, 5000);
        });

        sseSource = source;
    }

    // ===== Ambil proses berjalan
function connectToApi() {
    fetch('{{ config('services.api.base_url') }}/ongoing-process', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${sanctumToken}`,
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        redirect: 'manual'
    })
    .then(res => res.json())
    .then(data => {
        if (!data.success) {
            showError(data.error || 'Tidak ada proses berlangsung');
            hideSuccess();
            setTimeout(connectToApi, 10000);
            return;
        }
        showSuccess(data.message || 'Sedang ada proses pengeringan berlangsung');
        hideError();
        startSSE(data.process_id);
    })
    .catch((error) => {
        console.error('Error fetching ongoing process:', error);
        showError('Gagal mengambil proses berjalan: ' + error.message);
        hideSuccess();
        setTimeout(connectToApi, 10000);
    });
}

    // Start
    document.addEventListener('DOMContentLoaded', checkUserRole);
</script>

@endsection

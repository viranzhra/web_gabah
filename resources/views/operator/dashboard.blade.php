@extends('layout.nav')

@section('content')
    <!-- Notifikasi -->
<div id="notification" class="fixed top-4 right-4 z-50 hidden">
    <div id="notificationMessage" class="px-4 py-2 rounded-lg shadow-lg text-white"></div>
</div>

<!-- Card Tambahan -->
<div class="bg-[#1E3A8A] text-white shadow-lg p-6 mb-6" style="border-radius: 10px;">
    <p class="text-white/85" style="padding-bottom: 8px;">Status Pengeringan</p>
    <h3 id="statusText" class="text-2xl font-bold mb-2 tracking-wide">Nonaktif</h3>

    <!-- Card Kadar Air Gabah -->
    <div class="bg-white/10 text-white h-[48px] flex items-center px-4" style="border-radius: 10px;">
        <svg width="26" height="26" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M18 32.625C24.2135 32.625 28.125 28.7135 28.125 22.5C28.125 15.8323 20.8666 6.83086 18.6413 4.22719C18.562 4.13468 18.4637 4.06042 18.3531 4.0095C18.2425 3.95858 18.1221 3.93222 18.0004 3.93222C17.8786 3.93222 17.7582 3.95858 17.6476 4.0095C17.537 4.06042 17.4387 4.13468 17.3595 4.22719C15.1334 6.83086 7.875 15.8323 7.875 22.5C7.875 28.7135 11.7865 32.625 18 32.625Z"
                stroke="white" stroke-width="1.3" stroke-miterlimit="10" />
            <path
                d="M24.1875 23.0625C24.1875 24.4052 23.6541 25.6928 22.7047 26.6422C21.7553 27.5916 20.4677 28.125 19.125 28.125"
                stroke="white" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <span class="text-white/85" style="padding-left: 6px;">
            Kadar Air Gabah (Rata-rata):
            <span id="kadarAirText">0%</span>
        </span>
    </div>
    <!-- Tombol Start/Stop -->
    <div class="flex justify-center" style="padding-top: 20px;">
        <button type="button" id="toggleButton" data-bs-toggle="modal" data-bs-target="#tambahDataModal"
            class="bg-white/10 text-white font-bold px-4 py-1 text-sm shadow tracking-wide"
            style="border-radius: 10px; padding: 8px; width: 100px;">
            START
        </button>
    </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 400px;">
        <div class="modal-content">
            <div class="modal-header justify-content-center position-relative">
                <h5 class="modal-title text-center w-100" id="tambahDataModalLabel"
                    style="margin-top: 15px; margin-bottom: 5px;">
                    Form Prediksi Pengeringan
                </h5>
                <button type="button" class="btn-close position-absolute end-0 top-0 mt-3 me-3" data-bs-dismiss="modal"
                    aria-label="Tutup"></button>
            </div>
            <div class="modal-body" style="padding: 0 27px 35px 27px;">
                <form id="predictForm">
                    @csrf
                    <div id="errorMessage" class="mt-3 text-danger" style="display: none;"></div>
                    <div class="mb-3">
                        <label for="jenis_gabah" class="form-label">Jenis Gabah</label>
                        <select name="jenis_gabah" id="jenis_gabah" class="form-control" required>
                            <option value="" disabled selected>-- Pilih Jenis Gabah --</option>
                            @foreach ($grainTypes as $grain)
                                <option value="{{ $grain['nama_jenis'] }}">{{ $grain['nama_jenis'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="berat_gabah" class="form-label">Berat Gabah (Kg)</label>
                        <input type="number" name="berat_gabah" id="berat_gabah" class="form-control" step="0.1"
                            required min="0.1" />
                    </div>
                    <div class="mb-3">
                        <label for="kadar_air_target" class="form-label">Target Kadar Air Gabah (%)</label>
                        <input type="number" name="kadar_air_target" id="kadar_air_target" class="form-control"
                            step="0.1" required min="0" max="100" />
                    </div>
                    <div class="mb-3">
                        <label for="suhu_gabah" class="form-label">Suhu Gabah (°C)</label>
                        <input type="number" name="suhu_gabah" id="suhu_gabah" class="form-control" step="0.1"
                            style="background-color: #eceff4;" readonly />
                    </div>
                    <div class="mb-3">
                        <label for="suhu_ruangan" class="form-label">Suhu Ruangan (°C)</label>
                        <input type="number" name="suhu_ruangan" id="suhu_ruangan" class="form-control" step="0.1"
                            style="background-color: #eceff4;" readonly />
                    </div>
                    <div class="mb-3">
                        <label for="kadar_air_gabah" class="form-label">Kadar Air Gabah (%)</label>
                        <input type="number" name="kadar_air_gabah" id="kadar_air_gabah" class="form-control"
                            step="0.1" style="background-color: #eceff4;" readonly />
                    </div>
                    <div style="margin-top: 30px;">
                        <button type="submit" class="btn w-100"
                            style="background-color: #1E3A8A; color: white;">Prediksi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Stop -->
<div class="modal fade" id="confirmStopModal" tabindex="-1" aria-labelledby="confirmStopModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 400px;">
        <div class="modal-content">
            <div class="modal-header justify-content-center position-relative">
                <h5 class="modal-title text-center w-100" id="confirmStopModalLabel"
                    style="margin-top: 15px; margin-bottom: 5px;">
                    Konfirmasi Penghentian
                </h5>
                <button type="button" class="btn-close position-absolute end-0 top-0 mt-3 me-3" data-bs-dismiss="modal"
                    aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center" style="padding: 20px 27px;">
                <p>Apakah Anda yakin ingin menghentikan proses pengeringan?</p>
            </div>
            <div class="modal-footer justify-content-center" style="padding-bottom: 20px;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                    style="width: 100px;">Tidak</button>
                <button type="button" id="confirmStopButton" class="btn"
                    style="background-color: #1E3A8A; color: white; width: 100px;">Ya</button>
            </div>
        </div>
    </div>
</div>

<!-- Grid Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
    <!-- Card 1: Suhu Gabah -->
    <div style="height: 90px;"
        class="bg-[#1E3A8A]/10 text-[#1E3A8A] rounded-[12px] shadow-md p-6 border border-[#A3BFFA]/60 flex items-center cursor-pointer relative"
        onclick="handleCardClick('Suhu Gabah', document.getElementById('suhuGabahText').innerText, '0°C', 'M10 2a8 8 0 108 8 8.01 8.01 0 00-8-8zm1 11H9v-1h2zm0-2H9V7h2z')">
        <svg class="h-8 w-8 mr-4 text-[#1E3A8A]" width="46" height="46" viewBox="0 0 46 46" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M23 42.1666C25.1841 42.167 27.3144 41.489 29.0965 40.2263C30.8785 38.9636 32.2244 37.1785 32.9481 35.1178C33.6717 33.0571 33.7375 30.8225 33.1362 28.7228C32.5349 26.6231 31.2962 24.762 29.5914 23.3967C29.3361 23.2031 29.1278 22.9543 28.9821 22.6688C28.8364 22.3834 28.7571 22.0688 28.75 21.7484V9.58331C28.75 8.05832 28.1442 6.59578 27.0659 5.51745C25.9876 4.43912 24.525 3.83331 23 3.83331C21.475 3.83331 20.0125 4.43912 18.9342 5.51745C17.8558 6.59578 17.25 8.05832 17.25 9.58331V21.7503C17.25 22.3981 16.9146 22.9923 16.4086 23.3986C14.7046 24.7641 13.4667 26.6251 12.8658 28.7244C12.265 30.8237 12.3309 33.0578 13.0545 35.1181C13.7781 37.1784 15.1236 38.9631 16.9051 40.2257C18.6867 41.4883 20.8164 42.1666 23 42.1666Z"
                stroke="#1E3A8A" stroke-width="2" />
            <path
                d="M27.7917 31.625C27.7917 32.8958 27.2869 34.1146 26.3883 35.0132C25.4896 35.9118 24.2709 36.4166 23 36.4166C21.7292 36.4166 20.5104 35.9118 19.6118 35.0132C18.7132 34.1146 18.2084 32.8958 18.2084 31.625C18.2084 30.3542 18.7132 29.1354 19.6118 28.2368C20.5104 27.3381 21.7292 26.8333 23 26.8333C24.2709 26.8333 25.4896 27.3381 26.3883 28.2368C27.2869 29.1354 27.7917 31.625Z"
                stroke="#1E3A8A" stroke-width="2" />
            <path d="M23 26.8333V9.58331" stroke="#1E3A8A" stroke-width="2.2" stroke-linecap="round" />
        </svg>
        <div>
            <h3 class="text-lg -mt-1" style="font-weight: 500;">Suhu Gabah</h3>
            <p id="suhuGabahText" class="text-[#1E3A8A]/80 text-xl" style="font-size: 17px;">0°C</p>
        </div>
    </div>

    <!-- Card 2: Suhu Ruangan -->
    <div style="height: 90px;"
        class="bg-[#1E3A8A]/10 text-[#1E3A8A] rounded-[12px] shadow-md p-6 border border-[#A3BFFA]/60 flex items-center cursor-pointer relative"
        onclick="handleCardClick('Suhu Ruangan', document.getElementById('suhuRuanganText').innerText, '0°C', 'M13 7H7v6h6V7z M5 3a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 2h10v10H5V5z')">
        <svg class="h-7 w-7 mr-4 text-[#1E3A8A]" width="35" height="35" viewBox="0 0 35 35" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_250_268)">
                <path
                    d="M17.5 0.5V35.5M22.707 4.25C21.1355 5.07027 19.3348 5.50254 17.5 5.5C15.6652 5.50254 13.8645 5.07027 12.293 4.25M12.293 31.75C13.8657 30.9321 15.6656 30.5 17.5 30.5C19.3344 30.5 21.1343 30.9321 22.707 31.75M35 9.25L0 26.75M33.8525 15.0312C32.248 14.2606 30.9157 13.1264 29.9986 11.7501C29.0815 10.3739 28.6141 8.80749 28.6465 7.21875M1.14748 20.9688C2.75205 21.7394 4.08425 22.8736 5.00135 24.2499C5.91845 25.6261 6.38588 27.1925 6.35355 28.7812M0 9.25L35 26.75M1.14748 15.0312C2.75205 14.2606 4.08425 13.1264 5.00135 11.7501C5.91845 10.3739 6.38588 8.80749 6.35355 7.21875M33.8525 20.9688C32.248 21.7394 30.9157 22.8736 29.9986 24.2499C29.0815 25.6261 28.6141 27.1925 28.6465 28.7812"
                    stroke="#1E3A8A" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" />
            </g>
            <defs>
                <clipPath id="clip0_250_268">
                    <rect width="35" height="35" fill="white" />
                </clipPath>
            </defs>
        </svg>
        <div>
            <h3 class="text-lg -mt-1" style="font-weight: 500;">Suhu Ruangan</h3>
            <p id="suhuRuanganText" class="text-[#1E3A8A]/80 text-xl" style="font-size: 17px;">0°C</p>
        </div>
    </div>

    <!-- Card 3: Estimasi Waktu Pengeringan -->
    <div style="height: 90px;"
        class="bg-[#1E3A8A]/10 text-[#1E3A8A] rounded-[12px] shadow-md p-6 border border-[#A3BFFA]/60 flex items-center cursor-pointer relative"
        onclick="handleCardClick('Estimasi Waktu Pengeringan', document.getElementById('durasiText').innerText, '0 Menit', 'M3 3a1 1 0 000 2h14a1 1 0 100-2H3zm3 4a1 1 0 000 2h8a1 1 0 100-2H6zm-3 4a1 1 0 000 2h14a1 1 0 100-2H3zm3 4a1 1 0 000 2h8a1 1 0 100-2H6z')">
        <svg class="h-8 w-8 mr-4 text-[#1E3A8A]" width="48" height="48" viewBox="0 0 48 48" fill="none"
            xmlns="http://www.w3.org/2000/svg">
            <path
                d="M24 6C14.0625 6 6 14.0625 6 24C6 33.9375 14.0625 42 24 42C33.9375 42 42 33.9375 42 24C42 14.0625 33.9375 6 24 6Z"
                stroke="#1E3A8A" stroke-width="3" stroke-miterlimit="10" />
            <path d="M24 12V25.5H33" stroke="#1E3A8A" stroke-width="2.5" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
        <div>
            <h3 class="text-lg -mt-1" style="font-weight: 500;">Estimasi Waktu Pengeringan</h3>
            <p id="durasiText" class="text-[#1E3A8A]/80 text-xl" style="font-size: 17px;">0 Menit</p>
        </div>
    </div>
</div>

<!-- Single Modal -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg p-6 max-w-sm w-full relative">
        <button class="absolute top-2 right-2 text-[#1E3A8A] text-2xl font-bold" onclick="closeModal()">×</button>
        <div class="flex items-center mb-4">
            <svg id="modal-icon" xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mr-4 text-[#1E3A8A]"
                viewBox="0 0 20 20" fill="currentColor">
                <path id="modal-icon-path" />
            </svg>
            <h2 id="modal-title" class="text-2xl font-bold text-[#1E3A8A]"></h2>
        </div>
        <p id="modal-initial" class="text-[#1E3A8A]/80 text-lg mb-2"></p>
        <p id="modal-current" class="text-[#1E3A8A]/80 text-lg mb-4"></p>
    </div>
</div>

<script>
// Retrieve Sanctum token from session
const sanctumToken = "{{ session('sanctum_token') ?? '' }}";
const baseUrl = "{{ config('services.api.base_url') }}";
const POLLING_INTERVAL = 60000; // Polling every 60 seconds (change to 1000 for 1-second polling)

// Global variables
let sensorInterval = null;
let statusText, kadarAirText, suhuGabahText, suhuRuanganText, durasiText, toggleButton, suhuGabahInput, suhuRuanganInput, kadarAirGabahInput;

// Fetch sensor data
function fetchSensorData(processId = null) {
    const url = processId ?
        `${baseUrl}/get_sensor/realtime?user_id={{ auth()->id() }}&process_id=${processId}` :
        `${baseUrl}/get_sensor/realtime?user_id={{ auth()->id() }}`;

    return fetch(url, {
            headers: {
                'Authorization': `Bearer ${sanctumToken}`,
                'Accept': 'application/json'
            }
        })
        .then(response => response.ok ? response.json() : Promise.reject(`Failed to fetch sensor data: ${response.status} ${response.statusText}`))
        .then(data => {
            console.log('Sensor data received:', data); // Debug log
            updateUI(data);
            updateModalForm(data.sensors);
            return data;
        })
        // .catch(err => {
        //     console.error('Error fetching sensor data:', err);
        //     showNotification(`Gagal memuat data sensor: ${err.message}`, 'bg-red-500');
        //     // Do not call resetUI to preserve existing sensor data
        //     throw err;
        // });
}

function updateUI(data) {
    const dryingProcess = data.drying_process;
    const sensors = data.sensors;

    // Always update sensor data, even without an ongoing process
    kadarAirText.innerText = sensors && isNumeric(sensors.avg_grain_moisture) ? `${sensors.avg_grain_moisture.toFixed(2)}%` : '0%';
    suhuGabahText.innerText = sensors && isNumeric(sensors.avg_grain_temperature) ? `${sensors.avg_grain_temperature.toFixed(2)}°C` : '0°C';
    suhuRuanganText.innerText = sensors && isNumeric(sensors.avg_room_temperature) ? `${sensors.avg_room_temperature.toFixed(2)}°C` : '0°C';

    // Update process-related UI only for ongoing processes
    if (dryingProcess && dryingProcess.status === 'ongoing') {
        statusText.innerText = 'Aktif';
        toggleButton.innerText = 'STOP';
        toggleButton.removeAttribute('data-bs-toggle');
        toggleButton.removeAttribute('data-bs-target');
        toggleButton.onclick = () => showConfirmStopModal(dryingProcess.process_id);
        durasiText.innerText = `${parseFloat(dryingProcess.durasi_rekomendasi || 0).toFixed(2)} Menit`;

        // Start or update sensor monitoring
        if (!sensorInterval) {
            startSensorMonitoring(dryingProcess.process_id);
        }
    } else {
        // Reset only process-related UI
        statusText.innerText = 'Nonaktif';
        toggleButton.innerText = 'START';
        toggleButton.setAttribute('data-bs-toggle', 'modal');
        toggleButton.setAttribute('data-bs-target', '#tambahDataModal');
        toggleButton.onclick = null;
        durasiText.innerText = '0 Menit';
        suhuGabahInput.value = '';
        suhuRuanganInput.value = '';
        kadarAirGabahInput.value = '';

        // Continue polling sensor data
        if (!sensorInterval) {
            startSensorMonitoring(null);
        }
    }
}

function resetUI() {
    statusText.innerText = 'Nonaktif';
    toggleButton.innerText = 'START';
    toggleButton.setAttribute('data-bs-toggle', 'modal');
    toggleButton.setAttribute('data-bs-target', '#tambahDataModal');
    toggleButton.onclick = null;
    kadarAirText.innerText = '0%';
    suhuGabahText.innerText = '0°C';
    suhuRuanganText.innerText = '0°C';
    durasiText.innerText = '0 Menit';
    suhuGabahInput.value = '';
    suhuRuanganInput.value = '';
    kadarAirGabahInput.value = '';
    if (sensorInterval) {
        clearInterval(sensorInterval);
        sensorInterval = null;
    }
}

function updateModalForm(sensors) {
    suhuGabahInput.value = sensors && isNumeric(sensors.avg_grain_temperature) ? sensors.avg_grain_temperature.toFixed(2) : '';
    suhuRuanganInput.value = sensors && isNumeric(sensors.avg_room_temperature) ? sensors.avg_room_temperature.toFixed(2) : '';
    kadarAirGabahInput.value = sensors && isNumeric(sensors.avg_grain_moisture) ? sensors.avg_grain_moisture.toFixed(2) : '';
}

function startSensorMonitoring(processId) {
    if (sensorInterval) {
        clearInterval(sensorInterval);
    }
    sensorInterval = setInterval(() => {
        fetchSensorData(processId)
            .then(data => {
                const sensors = data.sensors;
                const dryingProcess = data.drying_process;
                if (dryingProcess && dryingProcess.status === 'ongoing' && sensors.target_moisture_achieved) {
                    completeProcess(dryingProcess.process_id);
                    clearInterval(sensorInterval);
                    sensorInterval = null;
                }
            })
            .catch(err => console.error('Polling error:', err));
    }, POLLING_INTERVAL);
}

function showConfirmStopModal(processId) {
    const confirmButton = document.getElementById('confirmStopButton');
    confirmButton.onclick = () => completeProcess(processId);
    const modal = new bootstrap.Modal(document.getElementById('confirmStopModal'));
    modal.show();
}

function completeProcess(processId) {
    const notification = document.getElementById('notification');
    const notificationMessage = document.getElementById('notificationMessage');
    const confirmModalElement = document.getElementById('confirmStopModal');
    const confirmModal = bootstrap.Modal.getInstance(confirmModalElement);

    // Fetch latest sensor data to ensure accurate final values
    fetchSensorData(processId)
        .then(data => {
            const sensors = data.sensors;
            fetch(`${baseUrl}/operator/drying-process/${processId}/complete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${sanctumToken}`,
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        timestamp_selesai: new Date().toISOString(),
                        kadar_air_akhir: parseFloat(sensors.avg_grain_moisture) || 0,
                        suhu_gabah_akhir: parseFloat(sensors.avg_grain_temperature) || 0,
                        suhu_ruangan_akhir: parseFloat(sensors.avg_room_temperature) || 0
                    })
                })
                .then(response => response.ok ? response.json() : Promise.reject(`Gagal menyelesaikan proses: ${response.statusText}`))
                .then(data => {
                    if (data.success) {
                        // Close confirmation modal
                        if (confirmModal) {
                            confirmModal.hide();
                            confirmModalElement.classList.remove('show');
                            confirmModalElement.style.display = 'none';
                            document.querySelector('.modal-backdrop')?.remove();
                            document.body.classList.remove('modal-open');
                            document.body.style.overflow = '';
                            document.body.style.paddingRight = '';
                        }

                        showNotification('Proses pengeringan selesai!', 'bg-green-500');
                        resetUI();
                        $('#data-table').DataTable().ajax.reload(null, false);
                    } else {
                        showNotification('Gagal menyelesaikan proses: ' + (data.error || 'Kesalahan server.'), 'bg-red-500');
                    }
                })
                // .catch(err => showNotification(`Gagal menyelesaikan proses: ${err.message}`, 'bg-red-500'));
        })
        .catch(err => {
            console.error('Error fetching sensor data for completion:', err);
            showNotification('Gagal memuat data sensor untuk menyelesaikan proses.', 'bg-red-500');
        });
}

function showNotification(msg, bgClass) {
    const notification = document.getElementById('notification');
    const notificationMessage = document.getElementById('notificationMessage');
    const modalElement = document.getElementById('tambahDataModal');
    const modal = bootstrap.Modal.getInstance(modalElement);
    const confirmModalElement = document.getElementById('confirmStopModal');
    const confirmModal = bootstrap.Modal.getInstance(confirmModalElement);

    if (modal) {
        modal.hide();
        modalElement.classList.remove('show');
        modalElement.style.display = 'none';
    }
    if (confirmModal) {
        confirmModal.hide();
        confirmModalElement.classList.remove('show');
        confirmModalElement.style.display = 'none';
    }
    document.querySelector('.modal-backdrop')?.remove();
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';

    notificationMessage.innerText = msg;
    notificationMessage.className = `px-4 py-2 rounded-lg shadow-lg text-white ${bgClass}`;
    notification.classList.remove('hidden');

    setTimeout(() => {
        notification.classList.add('hidden');
    }, 5000);
}

function handleCardClick(title, currentValue, initialValue, iconPath) {
    const card = event.currentTarget;
    card.classList.add('scale-105', 'shadow-lg', 'transition-all', 'duration-200');
    setTimeout(() => {
        card.classList.remove('scale-105', 'shadow-lg', 'transition-all', 'duration-200');
    }, 300);
    document.getElementById('modal-title').textContent = `Detail ${title}`;
    document.getElementById('modal-initial').textContent = `${title} Awal: ${initialValue}`;
    document.getElementById('modal-current').textContent = `${title} Saat Ini: ${currentValue}`;
    document.getElementById('modal-icon-path').setAttribute('d', iconPath);
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}

function isNumeric(value) {
    return !isNaN(parseFloat(value)) && isFinite(value);
}

// Initialize UI based on ongoingProcess
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DOM elements
    statusText = document.getElementById('statusText');
    kadarAirText = document.getElementById('kadarAirText');
    suhuGabahText = document.getElementById('suhuGabahText');
    suhuRuanganText = document.getElementById('suhuRuanganText');
    durasiText = document.getElementById('durasiText');
    toggleButton = document.getElementById('toggleButton');
    suhuGabahInput = document.getElementById('suhu_gabah');
    suhuRuanganInput = document.getElementById('suhu_ruangan');
    kadarAirGabahInput = document.getElementById('kadar_air_gabah');

    // Fetch initial sensor data
    fetchSensorData();

    // Update modal form when prediction modal is shown
    document.getElementById('tambahDataModal').addEventListener('show.bs.modal', function() {
        fetchSensorData();
    });
});

// Submit predict form
document.getElementById('predictForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const notification = document.getElementById('notification');
    const notificationMessage = document.getElementById('notificationMessage');
    const modalElement = document.getElementById('tambahDataModal');
    const modal = bootstrap.Modal.getInstance(modalElement);

    // Validate sensor data
    const suhuGabah = parseFloat(suhuGabahInput.value);
    const suhuRuangan = parseFloat(suhuRuanganInput.value);
    const kadarAirGabah = parseFloat(kadarAirGabahInput.value);

    if (!isNumeric(suhuGabah) || !isNumeric(suhuRuangan) || !isNumeric(kadarAirGabah)) {
        showNotification('Data sensor tidak lengkap atau tidak valid.', 'bg-red-500');
        return;
    }

    // Validate form inputs
    const form = e.target;
    if (!form.jenis_gabah.value) {
        showNotification('Jenis gabah harus dipilih.', 'bg-red-500');
        return;
    }
    const beratGabah = parseFloat(form.berat_gabah.value);
    if (!isNumeric(beratGabah) || beratGabah <= 0) {
        showNotification('Berat gabah harus lebih besar dari 0.', 'bg-red-500');
        return;
    }
    const kadarAirTarget = parseFloat(form.kadar_air_target.value);
    if (!isNumeric(kadarAirTarget) || kadarAirTarget < 0 || kadarAirTarget > 100) {
        showNotification('Target kadar air harus di antara 0 dan 100.', 'bg-red-500');
        return;
    }

    // Check Sanctum token
    if (!sanctumToken) {
        showNotification('Anda harus login untuk menyimpan data prediksi.', 'bg-red-500');
        window.location.href = '{{ route('login') }}';
        return;
    }

    // Initialize CSRF token
    fetch('/sanctum/csrf-cookie', {
            method: 'GET'
        })
        .then(() => {
            const data = {
                kadar_air_gabah: kadarAirGabah,
                suhu_gabah: suhuGabah,
                suhu_ruangan: suhuRuangan,
                berat_gabah: beratGabah,
                kadar_air_target: kadarAirTarget
            };

            const timestampMulai = new Date().toISOString();
            fetch("http://192.168.0.9:5000/predict", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.ok ? response.json() : Promise.reject(`Gagal mendapatkan prediksi: ${response.statusText}`))
                .then(data => {
                    const durasiMenit = parseFloat(data.durasi_rekomendasi);

                    const timestampSelesai = new Date(new Date(timestampMulai).getTime() + durasiMenit * 60 * 1000).toISOString();
                    const storeData = {
                        nama_jenis: form.jenis_gabah.value,
                        suhu_gabah: suhuGabah,
                        suhu_ruangan: suhuRuangan,
                        kadar_air_gabah: kadarAirGabah,
                        kadar_air_target: kadarAirTarget,
                        berat_gabah: beratGabah,
                        durasi_rekomendasi: durasiMenit,
                        timestamp_selesai: timestampSelesai
                    };

                    fetch(`${baseUrl}/operator/prediksi/store`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'Authorization': `Bearer ${sanctumToken}`,
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify(storeData)
                        })
                        .then(response => {
                            if (!response.ok) {
                                if (response.status === 401) {
                                    showNotification('Sesi Anda telah berakhir. Silakan login kembali.', 'bg-red-500');
                                    window.location.href = '{{ route('login') }}';
                                    return Promise.reject(new Error('Unauthorized'));
                                }
                                return response.json().then(err => Promise.reject(err.error || `Gagal menyimpan: ${response.statusText}`));
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                const processId = data.data.process_id;
                                toggleButton.onclick = () => showConfirmStopModal(processId);

                                // Fetch real-time sensor data
                                fetchSensorData(processId)
                                    .then(sensorData => {
                                        // Update UI with real-time sensor data
                                        statusText.innerText = sensorData.drying_process.status === 'ongoing' ? 'Aktif' : 'Nonaktif';
                                        toggleButton.innerText = sensorData.drying_process.status === 'ongoing' ? 'STOP' : 'START';
                                        if (sensorData.drying_process.status === 'ongoing') {
                                            toggleButton.removeAttribute('data-bs-toggle');
                                            toggleButton.removeAttribute('data-bs-target');
                                            toggleButton.onclick = () => showConfirmStopModal(sensorData.drying_process.process_id);
                                        } else {
                                            toggleButton.setAttribute('data-bs-toggle', 'modal');
                                            toggleButton.setAttribute('data-bs-target', '#tambahDataModal');
                                            toggleButton.onclick = null;
                                        }

                                        kadarAirText.innerText = sensorData.sensors && isNumeric(sensorData.sensors.avg_grain_moisture) ?
                                            `${sensorData.sensors.avg_grain_moisture.toFixed(2)}%` : '0%';
                                        suhuGabahText.innerText = sensorData.sensors && isNumeric(sensorData.sensors.avg_grain_temperature) ?
                                            `${sensorData.sensors.avg_grain_temperature.toFixed(2)}°C` : '0°C';
                                        suhuRuanganText.innerText = sensorData.sensors && isNumeric(sensorData.sensors.avg_room_temperature) ?
                                            `${sensorData.sensors.avg_room_temperature.toFixed(2)}°C` : '0°C';
                                        durasiText.innerText = `${parseFloat(sensorData.drying_process.durasi_rekomendasi || 0).toFixed(2)} Menit`;

                                        // Close modal
                                        if (modal) {
                                            modal.hide();
                                            modalElement.classList.remove('show');
                                            modalElement.style.display = 'none';
                                            document.querySelector('.modal-backdrop')?.remove();
                                            document.body.classList.remove('modal-open');
                                            document.body.style.overflow = '';
                                            document.body.style.paddingRight = '';
                                        }

                                        showNotification('Prediksi berhasil! Proses pengeringan dimulai.', 'bg-green-500');
                                        $('#data-table').DataTable().ajax.reload(null, false);
                                    })
                                    .catch(err => {
                                        console.error('Error fetching sensor data:', err);
                                        showNotification('Gagal memuat data sensor real-time.', 'bg-red-500');
                                    });
                            } else {
                                showNotification('Gagal menyimpan proses: ' + (data.error || 'Kesalahan server.'), 'bg-red-500');
                            }
                        })
                        .catch(err => {
                            if (err.message !== 'Unauthorized') {
                                showNotification(`Terjadi kesalahan: ${err.message}`, 'bg-red-500');
                            }
                        });
                })
                .catch(error => showNotification(`Gagal menghubungi server ML: ${error.message}`, 'bg-red-500'));
        })
        .catch(err => showNotification('Gagal menginisialisasi CSRF token.', 'bg-red-500'));
});
</script>
@endsection

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
        <div class="bg-white/10 text-white h-[48px] flex items-center px-4 relative" style="border-radius: 10px;"
            onclick="handleCardClick('Kadar Air Gabah', document.getElementById('kadarAirText').innerText, 'M18 32.625C24.2135 32.625 28.125 28.7135 28.125 22.5C28.125 15.8323 20.8666 6.83086 18.6413 4.22719C18.562 4.13468 18.4637 4.06042 18.3531 4.0095C18.2425 3.95858 18.1221 3.93222 18.0004 3.93222C17.8786 3.93222 17.7582 3.95858 17.6476 4.0095C17.537 4.06042 17.4387 4.13468 17.3595 4.22719C15.1334 6.83086 7.875 15.8323 7.875 22.5C7.875 28.7135 11.7865 32.625 18 32.625Z M24.1875 23.0625C24.1875 24.4052 23.6541 25.6928 22.7047 26.6422C21.7553 27.5916 20.4677 28.125 19.125 28.125')">
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
                <span id="kadarAirText">0.00%</span>
            </span>
            <!-- Chevron Icon -->
            <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-white" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
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
                            <input type="number" name="suhu_ruangan" id="suhu_ruangan" class="form-control"
                                step="0.1" style="background-color: #eceff4;" readonly />
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
    <div class="modal fade" id="confirmStopModal" tabindex="-1" aria-labelledby="confirmStopModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="max-width: 400px;">
            <div class="modal-content"
                style="border-radius: 12px; overflow: hidden; box-shadow: 0 4px 16px rgba(0,0,0,0.2);">
                <!-- Header -->
                <div class="modal-header justify-content-center position-relative" style="background-color: #f8f9fa;">
                    <h5 class="modal-title text-center w-100 fw-semibold" id="confirmStopModalLabel"
                        style="padding: 0px; margin: 0;">
                        Konfirmasi Penghentian Proses
                    </h5>
                    {{-- <button type="button" class="btn-close position-absolute end-0 top-0 mt-3 me-3"
                    data-bs-dismiss="modal" aria-label="Tutup"></button> --}}
                </div>

                <!-- Body -->
                <div class="modal-body text-center" style="padding: 25px 30px; font-size: 14px; color: #333;">
                    <p style="margin: 0;">Apakah Anda yakin ingin menghentikan proses pengeringan?</p>
                </div>

                <!-- Footer -->
                <div class="modal-footer justify-content-center" style="padding: 10px;">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"
                        style="width: 100px; border-radius: 6px;">
                        Tidak
                    </button>
                    <button type="button" id="confirmStopButton" class="btn"
                        style="background-color: #1E3A8A; color: white; width: 100px; border-radius: 6px;">
                        Ya
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
        <!-- Card 1: Suhu Gabah -->
        <div style="height: 90px;"
            class="bg-[#1E3A8A]/10 text-[#1E3A8A] rounded-[12px] shadow-md p-6 border border-[#A3BFFA]/60 flex items-center cursor-pointer relative"
            onclick="handleCardClick('Suhu Gabah', document.getElementById('suhuGabahText').innerText, 'M23 42.1666C25.1841 42.167 27.3144 41.489 29.0965 40.2263C30.8785 38.9636 32.2244 37.1785 32.9481 35.1178C33.6717 33.0571 33.7375 30.8225 33.1362 28.7228C32.5349 26.6231 31.2962 24.762 29.5914 23.3967C29.3361 23.2031 29.1278 22.9543 28.9821 22.6688C28.8364 22.3834 28.7571 22.0688 28.75 21.7484V9.58331C28.75 8.05832 28.1442 6.59578 27.0659 5.51745C25.9876 4.43912 24.525 3.83331 23 3.83331C21.475 3.83331 20.0125 4.43912 18.9342 5.51745C17.8558 6.59578 17.25 8.05832 17.25 9.58331V21.7503C17.25 22.3981 16.9146 22.9923 16.4086 23.3986C14.7046 24.7641 13.4667 26.6251 12.8658 28.7244C12.265 30.8237 12.3309 33.0578 13.0545 35.1181C13.7781 37.1784 15.1236 38.9631 16.9051 40.2257C18.6867 41.4883 20.8164 42.1666 23 42.1666Z M27.7917 31.625C27.7917 32.8958 27.2869 34.1146 26.3883 35.0132C25.4896 35.9118 24.2709 36.4166 23 36.4166C21.7292 36.4166 20.5104 35.9118 19.6118 35.0132C18.7132 34.1146 18.2084 32.8958 18.2084 31.625C18.2084 30.3542 18.7132 29.1354 19.6118 28.2368C20.5104 27.3381 21.7292 26.8333 23 26.8333C24.2709 26.8333 25.4896 27.3381 26.3883 28.2368C27.2869 29.1354 27.7917 31.625Z M23 26.8333V9.58331')">
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
            <!-- Chevron Icon -->
            <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-[#1E3A8A]" viewBox="0 0 24 24"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </div>

        <!-- Card 2: Suhu Ruangan -->
        <div style="height: 90px;"
            class="bg-[#1E3A8A]/10 text-[#1E3A8A] rounded-[12px] shadow-md p-6 border border-[#A3BFFA]/60 flex items-center cursor-pointer relative"
            onclick="handleCardClick('Suhu Ruangan', document.getElementById('suhuRuanganText').innerText, 'M17.5 0.5V35.5M22.707 4.25C21.1355 5.07027 19.3348 5.50254 17.5 5.5C15.6652 5.50254 13.8645 5.07027 12.293 4.25M12.293 31.75C13.8657 30.9321 15.6656 30.5 17.5 30.5C19.3344 30.5 21.1343 30.9321 22.707 31.75M35 9.25L0 26.75M33.8525 15.0312C32.248 14.2606 30.9157 13.1264 29.9986 11.7501C29.0815 10.3739 28.6141 8.80749 28.6465 7.21875M1.14748 20.9688C2.75205 21.7394 4.08425 22.8736 5.00135 24.2499C5.91845 25.6261 6.38588 27.1925 6.35355 28.7812M0 9.25L35 26.75M1.14748 15.0312C2.75205 14.2606 4.08425 13.1264 5.00135 11.7501C5.91845 10.3739 6.38588 8.80749 6.35355 7.21875M33.8525 20.9688C32.248 21.7394 30.9157 22.8736 29.9986 24.2499C29.0815 25.6261 28.6141 27.1925 28.6465 28.7812')">
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
            <!-- Chevron Icon -->
            <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-[#1E3A8A]" viewBox="0 0 24 24"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </div>

        <!-- Card 3: Estimasi Waktu Pengeringan -->
        <div style="height: 90px;"
            class="bg-[#1E3A8A]/10 text-[#1E3A8A] rounded-[12px] shadow-md p-6 border border-[#A3BFFA]/60 flex items-center cursor-pointer relative"
            onclick="handleCardClick('Estimasi Waktu Pengeringan', document.getElementById('durasiText').innerText, 'M24 6C14.0625 6 6 14.0625 6 24C6 33.9375 14.0625 42 24 42C33.9375 42 42 33.9375 42 24C42 14.0625 33.9375 6 24 6Z M24 12V25.5H33')">
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
            <!-- Chevron Icon -->
            <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-[#1E3A8A]" viewBox="0 0 24 24"
                fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </div>
    </div>

    <!-- Single Modal -->
    <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-6 max-w-md w-full relative">
            <button class="absolute top-2 right-2 text-[#1E3A8A] text-2xl font-bold" onclick="closeModal()">×</button>
            <div class="flex items-center mb-4">
                <svg id="modal-icon" class="h-8 w-8 mr-4 text-[#1E3A8A]" viewBox="0 0 48 48" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path id="modal-icon-path" stroke="#1E3A8A" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
                <h3 id="modal-title" class="font-bold text-[#1E3A8A]" style="font-size: 20px;"></h3>
            </div>
            <div id="modal-device-data" class="text-[#1E3A8A]/80"></div>
        </div>
    </div>

    <script>
        // Retrieve Sanctum token from session
        const sanctumToken = "{{ session('sanctum_token') ?? '' }}";
        const baseUrl = "{{ config('services.api.base_url') }}";
        const POLLING_INTERVAL = 60000; // Interval polling setiap 60 detik
        const INITIAL_POLLING_INTERVAL = 5000; // Polling lebih cepat untuk load awal (5 detik)
        const MAX_RETRIES = 3; // Jumlah maksimum percobaan ulang untuk mengambil data sensor

        // Global variables
        let sensorInterval = null;
        let statusText, kadarAirText, suhuGabahText, suhuRuanganText, durasiText, toggleButton, suhuGabahInput,
            suhuRuanganInput, kadarAirGabahInput;
        // Store initial and current sensor data per device_id
        let sensorDataByDevice = {};
        let initialData = {
            kadar_air_gabah: 0,
            suhu_gabah: 0,
            suhu_ruangan: 0,
            durasi_rekomendasi: 0,
            kadar_air_target: 0
        };

        // Fetch sensor data with retry mechanism
        async function fetchSensorData(processId = null, retries = MAX_RETRIES) {
            const url = processId ?
                `${baseUrl}/get_sensor/realtime?user_id={{ auth()->id() }}&process_id=${processId}` :
                `${baseUrl}/get_sensor/realtime?user_id={{ auth()->id() }}`;

            console.log('Fetching sensor data from:', url);
            console.log('Using token:', sanctumToken);

            // Set loading state
            kadarAirText.innerText = '...%';
            suhuGabahText.innerText = '...°C';
            suhuRuanganText.innerText = '...°C';

            try {
                const response = await fetch(url, {
                    headers: {
                        'Authorization': `Bearer ${sanctumToken}`,
                        'Accept': 'application/json'
                    }
                });

                if (!response.ok) {
                    throw new Error(`Failed to fetch sensor data: ${response.status} ${response.statusText}`);
                }

                const data = await response.json();
                console.log('Sensor data received:', data);

                // Update initial values if drying process is ongoing
                if (data.drying_process && data.drying_process.status === 'ongoing') {
                    initialData = {
                        kadar_air_gabah: parseFloat(data.drying_process.kadar_air_gabah) || 0,
                        suhu_gabah: parseFloat(data.drying_process.suhu_gabah) || 0,
                        suhu_ruangan: parseFloat(data.drying_process.suhu_ruangan) || 0,
                        durasi_rekomendasi: parseFloat(data.drying_process.durasi_rekomendasi) || 0,
                        kadar_air_target: parseFloat(data.drying_process.kadar_air_target) || 0
                    };
                } else {
                    initialData = {
                        kadar_air_gabah: 0,
                        suhu_gabah: 0,
                        suhu_ruangan: 0,
                        durasi_rekomendasi: 0,
                        kadar_air_target: 0
                    };
                }

                // Update sensor data per device_id
                sensorDataByDevice = {};
                if (data.sensors && data.sensors.data) {
                    data.sensors.data.forEach(sensor => {
                        sensorDataByDevice[sensor.device_name] = {
                            kadar_air_gabah: parseFloat(sensor.kadar_air_gabah) || 0,
                            suhu_gabah: parseFloat(sensor.suhu_gabah) || 0,
                            suhu_ruangan: parseFloat(sensor.suhu_ruangan) || 0,
                            timestamp: sensor.timestamp
                        };
                    });
                }

                updateUI(data);
                updateModalForm(data.sensors);
                return data;
            } catch (err) {
                console.error('Error fetching sensor data:', err);
                if (retries > 0) {
                    console.log(`Retrying... (${MAX_RETRIES - retries + 1}/${MAX_RETRIES})`);
                    await new Promise(resolve => setTimeout(resolve, 2000)); // Wait 2 seconds before retry
                    return fetchSensorData(processId, retries - 1);
                } else {
                    showNotification(`Gagal memuat data sensor: ${err.message}`, 'bg-red-500');
                    kadarAirText.innerText = '0.00%';
                    suhuGabahText.innerText = '0.00°C';
                    suhuRuanganText.innerText = '0.00°C';
                    return {
                        sensors: {
                            data: []
                        },
                        drying_process: null
                    };
                }
            }
        }

        function updateUI(data) {
            const dryingProcess = data.drying_process;
            const sensors = data.sensors || {};

            // Update sensor data (average values)
            kadarAirText.innerText = sensors && isNumeric(sensors.avg_grain_moisture) ?
                `${sensors.avg_grain_moisture.toFixed(2)}%` : '0.00%';
            suhuGabahText.innerText = sensors && isNumeric(sensors.avg_grain_temperature) ?
                `${sensors.avg_grain_temperature.toFixed(2)}°C` : '0.00°C';
            suhuRuanganText.innerText = sensors && isNumeric(sensors.avg_room_temperature) ?
                `${sensors.avg_room_temperature.toFixed(2)}°C` : '0.00°C';

            // Update process-related UI
            if (dryingProcess && dryingProcess.status === 'ongoing') {
                statusText.innerText = 'Aktif';
                toggleButton.innerText = 'STOP';
                toggleButton.removeAttribute('data-bs-toggle');
                toggleButton.removeAttribute('data-bs-target');
                toggleButton.onclick = () => showConfirmStopModal(dryingProcess.process_id);
                durasiText.innerText = `${parseFloat(dryingProcess.durasi_rekomendasi || 0).toFixed(2)} Menit`;

                if (!sensorInterval) {
                    startSensorMonitoring(dryingProcess.process_id);
                }
            } else {
                statusText.innerText = 'Nonaktif';
                toggleButton.innerText = 'START';
                toggleButton.setAttribute('data-bs-toggle', 'modal');
                toggleButton.setAttribute('data-bs-target', '#tambahDataModal');
                toggleButton.onclick = null;
                durasiText.innerText = '0.00 Menit';

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
            kadarAirText.innerText = '0.00%';
            suhuGabahText.innerText = '0.00°C';
            suhuRuanganText.innerText = '0.00°C';
            durasiText.innerText = '0.00 Menit';
            suhuGabahInput.value = '';
            suhuRuanganInput.value = '';
            kadarAirGabahInput.value = '';
            initialData = {
                kadar_air_gabah: 0,
                suhu_gabah: 0,
                suhu_ruangan: 0,
                durasi_rekomendasi: 0,
                kadar_air_target: 0
            };
            sensorDataByDevice = {};
            if (sensorInterval) {
                clearInterval(sensorInterval);
                sensorInterval = null;
            }
        }

        function updateModalForm(sensors) {
            suhuGabahInput.value = sensors && isNumeric(sensors.avg_grain_temperature) ? sensors.avg_grain_temperature
                .toFixed(2) : '';
            suhuRuanganInput.value = sensors && isNumeric(sensors.avg_room_temperature) ? sensors.avg_room_temperature
                .toFixed(2) : '';
            kadarAirGabahInput.value = sensors && isNumeric(sensors.avg_grain_moisture) ? sensors.avg_grain_moisture
                .toFixed(2) : '';
        }

        function startSensorMonitoring(processId) {
            if (sensorInterval) {
                clearInterval(sensorInterval);
            }
            sensorInterval = setInterval(() => {
                fetchSensorData(processId)
                    .then(data => {
                        const sensors = data.sensors || {};
                        const dryingProcess = data.drying_process;
                        if (dryingProcess && dryingProcess.status === 'ongoing' && sensors
                            .target_moisture_achieved) {
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

        async function completeProcess(processId) {
            const confirmModalElement = document.getElementById('confirmStopModal');
            const confirmModal = bootstrap.Modal.getInstance(confirmModalElement);

            const data = await fetchSensorData(processId);
            const sensors = data.sensors || {};

            try {
                const response = await fetch(`${baseUrl}/operator/drying-process/${processId}/complete`, {
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
                });

                if (!response.ok) {
                    throw new Error(`Gagal menyelesaikan proses: ${response.statusText}`);
                }

                const result = await response.json();
                if (result.success) {
                    if (confirmModal) {
                        confirmModal.hide();
                        confirmModalElement.classList.remove('show');
                        confirmModalElement.style.display = 'none';
                        document.querySelector('.modal-backdrop')?.remove();
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                    }

                    showNotification('Proses pengeringan selesai!', 'bg-green-500', true);
                    resetUI();
                } else {
                    showNotification('Gagal menyelesaikan proses: ' + (result.error || 'Kesalahan server.'),
                        'bg-red-500');
                }
            } catch (err) {
                console.error('Error completing process:', err);
                showNotification(`Gagal menyelesaikan proses: ${err.message}`, 'bg-red-500');
            }
        }

        function showNotification(msg, bgClass, reload = false) {
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
                if (reload) {
                    location.reload();
                }
            }, 5000);
        }

        function handleCardClick(title, currentValue, iconPath) {
            const card = event.currentTarget;
            // card.classList.add('scale-105', 'shadow-lg', 'transition-all', 'duration-200');
            // setTimeout(() => {
            //     card.classList.remove('scale-105', 'shadow-lg', 'transition-all', 'duration-200');
            // }, 300);

            // Set modal title and icon
            document.getElementById('modal-title').textContent = `Detail ${title}`;
            document.getElementById('modal-icon-path').setAttribute('d', iconPath);

            // Clear previous modal content
            const modalContent = document.getElementById('modal-device-data');
            modalContent.innerHTML = '';

            // Map title to data key and unit
            const dataKeyMap = {
                'Kadar Air Gabah': {
                    key: 'kadar_air_gabah',
                    unit: '%',
                    avgKey: 'avg_grain_moisture'
                },
                'Suhu Gabah': {
                    key: 'suhu_gabah',
                    unit: '°C',
                    avgKey: 'avg_grain_temperature'
                },
                'Suhu Ruangan': {
                    key: 'suhu_ruangan',
                    unit: '°C',
                    avgKey: 'avg_room_temperature'
                },
                'Estimasi Waktu Pengeringan': {
                    key: 'durasi_rekomendasi',
                    unit: 'Menit',
                    avgKey: null
                }
            };

            const {
                key,
                unit,
                avgKey
            } = dataKeyMap[title] || {
                key: '',
                unit: '',
                avgKey: null
            };

            if (title === 'Kadar Air Gabah' || title === 'Suhu Gabah') {
                // Initial Data Section
                const initialHeader = document.createElement('p');
                initialHeader.className = 'text-[#1E3A8A] text-lg font-bold mb-2';
                initialHeader.textContent = `${title} Awal`;
                modalContent.appendChild(initialHeader);

                const initialAvg = document.createElement('p');
                initialAvg.className = 'text-[#1E3A8A]/80 text-base mb-1 ml-2';
                initialAvg.textContent = `Rata-rata: ${initialData[key].toFixed(2)}${unit}`;
                modalContent.appendChild(initialAvg);

                Object.entries(sensorDataByDevice).forEach(([deviceName, data]) => {
                    const deviceP = document.createElement('p');
                    deviceP.className = 'text-[#1E3A8A]/80 text-base mb-1 ml-2';
                    deviceP.textContent = `${deviceName}: ${data[key].toFixed(2)}${unit}`;
                    modalContent.appendChild(deviceP);
                });

                // Separator
                const hr = document.createElement('hr');
                hr.className = 'my-3 border-[#A3BFFA]/60';
                modalContent.appendChild(hr);

                // Current Data Section
                const currentHeader = document.createElement('p');
                currentHeader.className = 'text-[#1E3A8A] text-lg font-bold mb-2';
                currentHeader.textContent = `${title} Saat Ini`;
                modalContent.appendChild(currentHeader);

                const currentAvg = document.createElement('p');
                currentAvg.className = 'text-[#1E3A8A]/80 text-base mb-1 ml-2';
                currentAvg.textContent =
                    `Rata-rata: ${parseFloat(currentValue) ? parseFloat(currentValue).toFixed(2) : '0.00'}${unit}`;
                modalContent.appendChild(currentAvg);

                Object.entries(sensorDataByDevice).forEach(([deviceName, data]) => {
                    const deviceP = document.createElement('p');
                    deviceP.className = 'text-[#1E3A8A]/80 text-base mb-1 ml-2';
                    deviceP.textContent = `${deviceName}: ${data[key].toFixed(2)}${unit}`;
                    modalContent.appendChild(deviceP);
                });

                if (Object.keys(sensorDataByDevice).length === 0) {
                    const noDataP = document.createElement('p');
                    noDataP.className = 'text-[#1E3A8A]/80 text-base mb-1 ml-2';
                    noDataP.textContent = 'Tidak ada data sensor saat ini.';
                    modalContent.appendChild(noDataP);
                }
            } else if (title === 'Suhu Ruangan') {
                const initialP = document.createElement('p');
                initialP.className = 'text-[#1E3A8A]/80 text-base mb-2';
                initialP.textContent = `${title} Awal: ${initialData[key].toFixed(2)}${unit}`;
                modalContent.appendChild(initialP);

                const currentP = document.createElement('p');
                currentP.className = 'text-[#1E3A8A]/80 text-base mb-2';
                currentP.textContent =
                    `${title} Saat Ini: ${parseFloat(currentValue) ? parseFloat(currentValue).toFixed(2) : '0.00'}${unit}`;
                modalContent.appendChild(currentP);
            } else if (title === 'Estimasi Waktu Pengeringan') {
                const durationP = document.createElement('p');
                durationP.className = 'text-[#1E3A8A]/80 text-base mb-2';
                durationP.textContent = `Estimasi Durasi: ${initialData.durasi_rekomendasi.toFixed(2)} Menit`;
                modalContent.appendChild(durationP);

                const targetP = document.createElement('p');
                targetP.className = 'text-[#1E3A8A]/80 text-base mb-2';
                targetP.textContent = `Target Kadar Air: ${initialData.kadar_air_target.toFixed(2)}%`;
                modalContent.appendChild(targetP);
            }

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
            statusText = document.getElementById('statusText');
            kadarAirText = document.getElementById('kadarAirText');
            suhuGabahText = document.getElementById('suhuGabahText');
            suhuRuanganText = document.getElementById('suhuRuanganText');
            durasiText = document.getElementById('durasiText');
            toggleButton = document.getElementById('toggleButton');
            suhuGabahInput = document.getElementById('suhu_gabah');
            suhuRuanganInput = document.getElementById('suhu_ruangan');
            kadarAirGabahInput = document.getElementById('kadar_air_gabah');

            // Initial fetch with faster polling until data is received
            let initialPollInterval = setInterval(() => {
                fetchSensorData().then(data => {
                    if (data.sensors && isNumeric(data.sensors.avg_grain_moisture)) {
                        clearInterval(
                            initialPollInterval); // Stop polling once valid data is received
                    }
                });
            }, INITIAL_POLLING_INTERVAL);

            document.getElementById('tambahDataModal').addEventListener('show.bs.modal', function() {
                fetchSensorData();
            });
        });

        // Submit predict form
        document.getElementById('predictForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            const modalElement = document.getElementById('tambahDataModal');
            const modal = bootstrap.Modal.getInstance(modalElement);

            const suhuGabah = parseFloat(suhuGabahInput.value);
            const suhuRuangan = parseFloat(suhuRuanganInput.value);
            const kadarAirGabah = parseFloat(kadarAirGabahInput.value);

            if (!isNumeric(suhuGabah) || !isNumeric(suhuRuangan) || !isNumeric(kadarAirGabah)) {
                showNotification('Data sensor tidak lengkap atau tidak valid.', 'bg-red-500');
                return;
            }

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

            if (!sanctumToken) {
                showNotification('Anda harus login untuk menyimpan data prediksi.', 'bg-red-500');
                window.location.href = '{{ route('login') }}';
                return;
            }

            try {
                await fetch('/sanctum/csrf-cookie', {
                    method: 'GET'
                });

                const data = {
                    kadar_air_gabah: kadarAirGabah,
                    suhu_gabah: suhuGabah,
                    suhu_ruangan: suhuRuangan,
                    berat_gabah: beratGabah,
                    kadar_air_target: kadarAirTarget
                };

                const timestampMulai = new Date().toISOString();
                const predictResponse = await fetch("http://192.168.43.142:5000/predict", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                if (!predictResponse.ok) {
                    throw new Error(`Gagal mendapatkan prediksi: ${predictResponse.statusText}`);
                }

                const predictData = await predictResponse.json();
                const durasiMenit = parseFloat(predictData.durasi_rekomendasi);
                const timestampSelesai = new Date(new Date(timestampMulai).getTime() + durasiMenit * 60 * 1000)
                    .toISOString();
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

                // Store initial values
                initialData = {
                    kadar_air_gabah: kadarAirGabah,
                    suhu_gabah: suhuGabah,
                    suhu_ruangan: suhuRuangan,
                    durasi_rekomendasi: durasiMenit,
                    kadar_air_target: kadarAirTarget
                };

                const storeResponse = await fetch(`${baseUrl}/operator/prediksi/store`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'Authorization': `Bearer ${sanctumToken}`,
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(storeData)
                });

                if (!storeResponse.ok) {
                    if (storeResponse.status === 401) {
                        showNotification('Sesi Anda telah berakhir. Silakan login kembali.', 'bg-red-500');
                        window.location.href = '{{ route('login') }}';
                        throw new Error('Unauthorized');
                    }
                    const err = await storeResponse.json();
                    throw new Error(err.error || `Gagal menyimpan: ${storeResponse.statusText}`);
                }

                const storeResult = await storeResponse.json();
                if (storeResult.success) {
                    const processId = storeResult.data.process_id;
                    toggleButton.onclick = () => showConfirmStopModal(processId);

                    // Update UI dengan data dari form
                    statusText.innerText = 'Aktif';
                    toggleButton.innerText = 'STOP';
                    toggleButton.removeAttribute('data-bs-toggle');
                    toggleButton.removeAttribute('data-bs-target');
                    toggleButton.onclick = () => showConfirmStopModal(processId);
                    kadarAirText.innerText = `${kadarAirGabah.toFixed(2)}%`;
                    suhuGabahText.innerText = `${suhuGabah.toFixed(2)}°C`;
                    suhuRuanganText.innerText = `${suhuRuangan.toFixed(2)}°C`;
                    durasiText.innerText = `${durasiMenit.toFixed(2)} Menit`;

                    // Tutup modal
                    if (modal) {
                        modal.hide();
                        modalElement.classList.remove('show');
                        modalElement.style.display = 'none';
                        document.querySelector('.modal-backdrop')?.remove();
                        document.body.classList.remove('modal-open');
                        document.body.style.overflow = '';
                        document.body.style.paddingRight = '';
                    }

                    // Fetch sensor data untuk sinkronisasi
                    await fetchSensorData(processId);

                    showNotification('Prediksi berhasil! Proses pengeringan dimulai.', 'bg-green-500', true);
                } else {
                    showNotification('Gagal menyimpan proses: ' + (storeResult.error || 'Kesalahan server.'),
                        'bg-red-500');
                }
            } catch (err) {
                if (err.message !== 'Unauthorized') {
                    showNotification(`Terjadi kesalahan: ${err.message}`, 'bg-red-500');
                }
            }
        });
    </script>
@endsection

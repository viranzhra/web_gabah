@extends('layout.app')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .icon-spin {
            animation: spin 1s linear infinite;
        }


        @media (max-width: 1024px) {
            body {
                background-size: 80%;
            }
        }

        @media (max-width: 768px) {
            body {
                background-size: 100%;
            }
        }

        .nav-item {
            @apply relative font-medium text-[#1E3A8A] hover:font-bold hover:border-b-2 hover:border-[#1E3A8A] block py-2;
        }

        .nav-item.active {
            font-weight: 700;
            border-bottom: 2px solid #1E3A8A;
        }

        .btn-detail-number {
            background-color: #C4D4FF;
            color: #1E3B8A;
            border-radius: 8px;
            padding: 4px 8px;
            font-weight: bold;
            transition: background-color .3s, transform .2s;
            border: none;
            cursor: pointer
        }

        .btn-detail-number:hover {
            background-color: #A0B8FF;
            transform: scale(1.05)
        }

        .mini-sidebar {
            position: fixed;
            bottom: 0;
            left: 60%;
            transform: translateX(-50%);
            width: 360px;
            height: 95px;
            background: #fff;
            border-top: 1px solid #e5e7eb;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, .1);
            transition: height .3s;
            z-index: 1000;
            overflow: hidden
        }

        .mini-sidebar.expanded {
            height: 330px;
            width: 360px;
        }

        .content-sidebar {
            padding: 8px;
            display: flex;
            flex-direction: column;
            gap: 8px
        }

        .expand-handle {
            width: 40px;
            height: 4px;
            background: #1E3A8A;
            border-radius: 2px;
            margin: 0 auto;
            cursor: pointer
        }

        .duration-option {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 12px;
            background: #1f46811f;
            border-radius: 6px;
            transition: background-color .2s;
            font-size: 18px
        }

        .duration-option:hover {
            background: #1f468133
        }

        .detail-section {
            display: none;
            flex-direction: column;
            gap: 8px;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid #e5e7eb;
            padding-left: 8px
        }

        .expanded .detail-section {
            display: flex
        }

        .no-process {
            color: #6b7280;
            font-size: 13px;
            text-align: center;
            padding: 8px
        }

        h3 {
            font-size: 16px;
            font-weight: 600;
            color: #1e3a8a;
            margin: 0
        }

        p {
            font-size: 15px;
            color: #374151;
            margin: 4px 0
        }

        .span {
            font-weight: 500;
            color: #1e3a8a
        }

        .btn-mulai {
            background: #C4D4FF;
            color: #1E3B8A;
            border-radius: 15px;
            padding: 5px;
            width: 78px;
            font-weight: bold;
            transition: background-color .3s, transform .2s
        }

        .btn-mulai:hover {
            background: #A0B8FF;
            color: #0D2F6A;
            transform: scale(1.05)
        }

        .btn-selesai {
            background: #b8f7c6;
            color: #00791C;
            border-radius: 15px;
            padding: 5px;
            width: 78px;
            font-weight: bold;
            transition: background-color .3s, transform .2s
        }

        .btn-selesai:hover {
            background: #95f4a4;
            color: #005B12;
            transform: scale(1.05)
        }

        .btn-detail {
            background: #89a5d5;
            color: #fff;
            border-radius: 15px;
            padding: 5px 15px;
            font-weight: bold;
            transition: background-color .3s, transform .2s
        }

        .btn-detail:hover {
            background: #C4D4FF;
            transform: scale(1.05)
        }

        /* Notification improvements untuk type 'info' */
        #notification {
            position: fixed;
            top: 20px;
            right: 20px;
            width: 350px;
            max-width: 90vw;
            padding: 16px;
            border-radius: 8px;
            z-index: 9999;
            display: none;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
            opacity: 0;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            cursor: pointer;
            line-height: 1.4;
            white-space: pre-line;
            /* Support line breaks */
            /* font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; */
        }

        #notification.visible {
            display: flex;
            opacity: 1;
            transform: translateY(0);
        }

        #notification:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        #notificationTitle {
            font-weight: 600;
            /* font-size: 14px; */
            margin-bottom: 6px;
            color: inherit;
        }

        #notificationMessage {
            font-size: 14px;
            color: inherit;
            line-height: 1.4;
        }

        /* Success notification */
        #notification.success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            color: #155724;
            border-left: 4px solid #28a745;
        }

        /* Error notification */
        #notification.error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        /* ✅ PERBAIKAN: Info notification */
        #notification.info {
            background: linear-gradient(135deg, #d1ecf1 0%, #bee5eb 100%);
            color: #0c5460;
            border-left: 4px solid #17a2b8;
        }

        #notification.info #notificationTitle {
            color: #0c5460;
        }

        #notification.info #notificationMessage {
            color: #0c5460;
        }

        .modal-detail .modal-content {
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(30, 59, 138, .2);
            border: none
        }

        .modal-detail .modal-header {
            color: black;
            border-radius: 16px 16px 0 0;
            position: relative
        }

        .modal-detail .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            width: 100%;
            text-align: center
        }

        .modal-detail .modal-body {
            padding: 20px
        }

        .modal-detail .btn-close {
            color: #000;
            padding-right: 50px
        }

        .modal-confirm .modal-content {
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(30, 59, 138, .2);
            border: none
        }

        .modal-confirm .modal-header {
            background: linear-gradient(135deg, #dc3545, #ff6666);
            color: #fff;
            border-radius: 16px 16px 0 0
        }

        .modal-confirm .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            width: 100%;
            text-align: center
        }

        .modal-confirm .modal-body {
            padding: 20px;
            font-size: 1rem;
            text-align: center
        }

        .modal-confirm .modal-footer {
            justify-content: center;
            gap: 10px
        }

        .modal-confirm .btn-confirm {
            background: #dc3545;
            color: #fff;
            border-radius: 12px;
            padding: 8px 20px;
            font-weight: 500
        }

        .modal-confirm .btn-cancel {
            background: #6c757d;
            color: #fff;
            border-radius: 12px;
            padding: 8px 20px;
            font-weight: 500
        }

        .modal-manual .modal-content {
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(30, 59, 138, .2);
            border: none
        }

        .modal-manual .modal-header {
            background: linear-gradient(135deg, #1E3B8A, #3B5CBA);
            color: #fff;
            border-radius: 16px 16px 0 0
        }

        .modal-manual .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            width: 100%;
            text-align: center
        }

        .modal-manual .modal-body {
            padding: 20px
        }

        .modal-manual .modal-footer {
            justify-content: center;
            gap: 10px
        }

        .modal-manual .btn-save {
            background: #1E3B8A;
            color: #fff;
            border-radius: 12px;
            padding: 8px 20px;
            font-weight: 500
        }

        .modal-manual .btn-cancel {
            background: #6c757d;
            color: #fff;
            border-radius: 12px;
            padding: 8px 20px;
            font-weight: 500
        }

        .custom-input {
            background: #FDFDFD;
            border: 1px solid #DAD9D9;
            border-radius: 12px;
            padding: 10px;
            color: #989898
        }

        .custom-save-btn {
            background: #1E3B8A;
            color: #fff;
            border-radius: 12px;
            padding: 8px 24px;
            font-weight: 500;
            border: none
        }

        .custom-save-btn:hover {
            background: #163075
        }

        @media (max-width: 1024px) {
            .flex.lg\:flex-row {
                flex-direction: column
            }

            .w-full.lg\:w-1\/2 {
                width: 100%
            }
        }
    </style>

    <div id="notification" class="alert position-fixed top-0 end-0 m-4">
        <div id="notificationTitle" style="font-weight: bold;"></div>
        <div id="notificationMessage"></div>
    </div>

    <!-- === Unified Notification Helper (Global) === -->
    <script>
        window.notify = function({
            title = '',
            message = '',
            type = 'success',
            duration = 5000,
            reload = false
        }) {
            const box = document.getElementById('notification');
            if (!box) return;
            const titleEl = document.getElementById('notificationTitle');
            const msgEl = document.getElementById('notificationMessage');

            // Clear previous classes and timers
            box.classList.remove('success', 'error', 'info', 'visible');
            if (box._hideTimer) clearTimeout(box._hideTimer);
            if (box._reloadTimer) clearTimeout(box._reloadTimer);

            // Set content based on type
            let defaultTitle = '';
            switch (type) {
                case 'success':
                    defaultTitle = 'Berhasil';
                    break;
                case 'error':
                    defaultTitle = 'Gagal';
                    break;
                case 'info':
                    defaultTitle = 'Informasi';
                    break;
                default:
                    defaultTitle = 'Pemberitahuan';
            }

            titleEl.textContent = title || defaultTitle;
            msgEl.textContent = message || '';

            // Add type class
            box.classList.add(type);

            // Show notification
            box.classList.add('visible');

            // Hide timer
            box._hideTimer = setTimeout(() => {
                box.classList.remove('visible');

                // Reload timer with delay
                if (reload) {
                    box._reloadTimer = setTimeout(() => {
                        console.log('🔄 Auto-reloading page...');
                        location.reload();
                    }, 500); // 0.5 detik delay setelah notifikasi hilang
                }
            }, duration);

            // Handle manual close (click notification)
            const handleClose = () => {
                clearTimeout(box._hideTimer);
                clearTimeout(box._reloadTimer);
                box.classList.remove('visible');

                // Reload if needed
                if (reload) {
                    setTimeout(() => {
                        console.log('🔄 Reloading after manual close...');
                        location.reload();
                    }, 300);
                }
            };

            box.onclick = handleClose;

            return box; // Return element untuk manual control
        };

        // Backward compatibility: handle old signatures
        window.showNotification = function(a, b, c) {
            // (title, message, 'success'|'error'|'info')
            if (c === 'success' || c === 'error' || c === 'info') {
                return notify({
                    title: a,
                    message: b,
                    type: c
                });
            }
            // (message, 'bg-green-500'|'bg-red-500'|'bg-blue-500', [reload])
            if (typeof b === 'string' && (b.includes('green') || b.includes('red') || b.includes('blue'))) {
                let type = 'success';
                if (b.includes('green')) type = 'success';
                else if (b.includes('red')) type = 'error';
                else if (b.includes('blue')) type = 'info';

                return notify({
                    title: '',
                    message: a,
                    type,
                    reload: !!c
                });
            }
            // ({...} object)
            if (typeof a === 'object' && a !== null) {
                return notify(a);
            }
            // Default: (title, message)
            return notify({
                title: String(a || ''),
                message: String(b || ''),
                type: 'info' // Default to info
            });
        };

        // ✅ PERBAIKAN: Event listener untuk notification
        document.addEventListener('DOMContentLoaded', function() {
            const notificationBox = document.getElementById('notification');
            if (notificationBox) {
                notificationBox.addEventListener('click', () => {
                    notificationBox.classList.remove('visible');
                });
            }
        });
    </script>

    <!-- Dropdown for Dryer Selection (Ambil dryer_id berdasarkan parameter warehouse_id dan user_id)-->
    <div class="mb-6">
        <label for="global_dryer_id" class="form-label">Pilih Bed Dryer <span class="text-danger">*</span></label>
        <select id="global_dryer_id" class="form-control" onchange="updateGlobalDryerId()" style="background-color: white;"
            required>
            <option value="" disabled selected>-- Pilih Bed Dryer --</option>
            <!-- Opsi dryer akan diisi secara dinamis oleh JavaScript -->
        </select>
        <!-- Info dryer tetap ada tapi hidden -->
        <small id="dryerInfo" class="form-text text-muted" style="display: none;">
            Bed Dryer dipilih: <span id="selectedDryerName">-</span>
        </small>
    </div>

    <!-- Card Tambahan - ✅ PERBAIKAN: Tambahkan dryer info di header -->
    <div class="bg-[#1E3A8A] text-white shadow-lg p-9 mb-6" style="border-radius: 10px;">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center gap-3">
                <p class="text-white/85 mb-0" style="display: inline;">Status Pengeringan</p>
                <!-- ✅ PERBAIKAN: Dryer info di samping status -->
                <span id="statusDryerInfo" class="bg-white/10 px-3 py-1 rounded-full text-sm font-medium text-white/90"
                    style="display: none; min-width: 200px; text-align: center; border: 1px solid rgba(255,255,255,0.2);">
                    <i class="fas fa-spinner fa-spin mr-1" id="dryerLoadingIcon" style="display: none;"></i>
                    <span id="currentDryerDisplay">-</span>
                </span>
            </div>
        </div>

        <h3 id="statusText" class="text-2xl font-bold mb-2 tracking-wide" style="color: white;">Nonaktif</h3>

        <div id="cardKadarAir" class="bg-white/10 text-white h-[48px] flex items-center px-4 relative"
            style="border-radius: 10px; cursor:pointer;">
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
                <span style="color: #ffff" id="kadarAirText">0.00%</span>
            </span>
            <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-white" viewBox="0 0 24 24" fill="none">
                <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
        </div>

        <div class="flex justify-center" style="padding-top: 20px;">
            <button type="button" id="toggleButton" data-bs-toggle="modal" data-bs-target="#tambahDataModal"
                class="bg-white/10 text-white font-bold px-4 py-1 text-sm shadow tracking-wide"
                style="border-radius: 10px; padding: 8px; width: 100px;">
                START
            </button>
        </div>
    </div>

    <script>
        (function() {
            // ====== CONFIG dari blade / global ======
            const API_BASE = (window.baseUrl || "{{ config('services.api.base_url') }}").replace(/\/+$/, '');
            const AUTH_TOKEN = (typeof window.sanctumToken !== 'undefined' && window.sanctumToken) ?
                window.sanctumToken : (localStorage.getItem('token') || '');
            const USER_ID = {{ auth()->id() }};

            // ====== MODAL TEMPLATE (sekali buat) ======
            function ensureMoistureModal() {
                if (document.getElementById('modalKadarAir')) return;
                const html = `
      <div class="modal fade" id="modalKadarAir" tabindex="-1" aria-labelledby="modalKadarAirLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 560px;">
          <div class="modal-content" style="border-radius:16px; border:none; overflow:hidden; box-shadow:0 4px 18px rgba(30,59,138,.2);">
            <div class="modal-header">
              <div class="d-flex align-items-center gap-2">
                <svg width="28" height="28" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M18 32.625C24.2135 32.625 28.125 28.7135 28.125 22.5C28.125 15.8323 20.8666 6.83086 18.6413 4.22719C18.562 4.13468 18.4637 4.06042 18.3531 4.0095C18.2425 3.95858 18.1221 3.93222 18.0004 3.93222C17.8786 3.93222 17.7582 3.95858 17.6476 4.0095C17.537 4.06042 17.4387 4.13468 17.3595 4.22719C15.1334 6.83086 7.875 15.8323 7.875 22.5C7.875 28.7135 11.7865 32.625 18 32.625Z" stroke="#1E3A8A" stroke-width="1.4" stroke-miterlimit="10" />
                  <path d="M24.1875 23.0625C24.1875 24.4052 23.6541 25.6928 22.7047 26.6422C21.7553 27.5916 20.4677 28.125 19.125 28.125" stroke="#1E3A8A" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <h5 class="modal-title" id="modalKadarAirLabel" style="margin:0; color:#1e3b8a; font-weight:700;">Detail Kadar Air Gabah</h5>
              </div>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>

            <div class="modal-body" style="padding:18px 20px;">
              <div style="color:#1e3b8a; font-weight:700;">Kadar Air Gabah Awal</div>
              <hr class="my-2">
              <div class="d-flex justify-content-between py-1">
                <span>Rata-rata awal</span>
                <span id="ka-awal-avg">-</span>
              </div>
              <div id="ka-awal-tombak"></div>

              <hr class="my-3">
              <div style="color:#1e3b8a; font-weight:700;">Kadar Air Gabah Saat Ini</div>
              <hr class="my-2">
              <div class="d-flex justify-content-between py-1">
                <span>Rata-rata saat ini</span>
                <span id="ka-now-avg">-</span>
              </div>
              <div id="ka-now-tombak"></div>

              <hr class="my-3">
              <div class="d-flex justify-content-between py-1">
                <span style="color:#1e3b8a; font-weight:700;">Target Kadar Air</span>
                <span id="ka-target" style="color:#1e3b8a; font-weight:700;">-</span>
              </div>
            </div>

            <div class="modal-footer" style="border-top:none; padding-top:0;">
            </div>
          </div>
        </div>
      </div>
    `;
                const wrap = document.createElement('div');
                wrap.innerHTML = html;
                document.body.appendChild(wrap.firstElementChild);
            }

            // ====== HELPERS ======
            const isNum = (v) => typeof v === 'number' && isFinite(v);
            const toPct = (v) => (isNum(v) ? v.toFixed(2) + '%' : '-');
            const avg = (arr) => arr.length ? (arr.reduce((a, b) => a + b, 0) / arr.length) : NaN;

            function headersAuth(required = false) {
                const h = {
                    Accept: 'application/json'
                };
                if (AUTH_TOKEN) h['Authorization'] = 'Bearer ' + AUTH_TOKEN;
                if (required && !AUTH_TOKEN) throw new Error('Auth token diperlukan untuk endpoint ini.');
                return h;
            }

            function parseTs(ts) {
                if (!ts) return null;
                let d = new Date(ts);
                if (!isNaN(d)) return d;
                d = new Date(String(ts).replace(' ', 'T'));
                return isNaN(d) ? null : d;
            }

            function saneDeviceName(x, idx) {
                if (!x) return `Tombak ${idx+1}`;
                return String(x);
            }

            // ====== API ======
            async function getRealtime(possiblePid) {
                const dryerId = localStorage.getItem('selected_dryer_id') || '';
                let url = `${API_BASE}/get_sensor/realtime?user_id=${encodeURIComponent(USER_ID)}`;
                if (possiblePid) url += `&process_id=${encodeURIComponent(possiblePid)}`;
                if (dryerId) url += `&dryer_id=${encodeURIComponent(dryerId)}`;
                const res = await fetch(url, {
                    headers: headersAuth(false)
                });
                if (!res.ok) throw new Error(`Realtime HTTP ${res.status}`);
                const data = await res.json();
                const dp = data.drying_process || data?.data?.drying_process || null;
                const sensors = data.sensors || {};
                return {
                    dp,
                    sensors
                };
            }
            async function getProcessShow(processId) {
                const url = `${API_BASE}/drying-process/${encodeURIComponent(processId)}`;
                const res = await fetch(url, {
                    headers: headersAuth(false)
                });
                if (!res.ok) throw new Error(`Show HTTP ${res.status}`);
                const j = await res.json();
                return j?.data || null;
            }
            async function getHistorical(processId) {
                const url = `${API_BASE}/historical-sensor-data/${encodeURIComponent(processId)}`;
                const res = await fetch(url, {
                    headers: headersAuth(true)
                });
                if (!res.ok) throw new Error(`Historical HTTP ${res.status}`);
                const j = await res.json();

                // normalisasi ke bentuk {timestamp, device_name, kadar_air_gabah}
                let rows = [];
                if (Array.isArray(j)) rows = j;
                else if (Array.isArray(j?.data)) rows = j.data;
                else if (Array.isArray(j?.sensors?.data)) rows = j.sensors.data;

                return rows.map(r => ({
                    timestamp: r.timestamp,
                    device_name: r.device_name || r.device || r.device_id || r.sensor_id || null,
                    kadar_air_gabah: (r.kadar_air_gabah !== undefined ? r.kadar_air_gabah : r
                        .kadar_air) // backup ke 'kadar_air' kalau saja naming lama
                }));
            }

            // ====== EXTRACT LOGIC ======
            // Filter: hanya record yang punya kadar_air_gabah numeric > 0
            function extractValidMoistureValue(rec) {
                const v = Number(rec?.kadar_air_gabah);
                return (isNum(v) && v > 0) ? v : null;
            }

            // SAAT INI: latest per device (hanya process_id yang sama)
            function latestPerDeviceNow(sensors, processId) {
                const out = [];
                if (!sensors || !Array.isArray(sensors.data)) return {
                    list: [],
                    avg: NaN
                };

                const byDev = new Map();
                for (const row of sensors.data) {
                    // pastikan record untuk process yang sama kalau fieldnya ada
                    if (row.process_id && String(row.process_id) !== String(processId)) continue;

                    const val = extractValidMoistureValue(row);
                    if (val === null) continue; // skip device tanpa moisture valid

                    const name = row.device_name || row.device_id || row.sensor_id || 'Tombak';
                    const ts = parseTs(row.timestamp);
                    if (!ts) continue;

                    const prev = byDev.get(name);
                    if (!prev || ts > prev.ts) byDev.set(name, {
                        ts,
                        value: val,
                        name
                    });
                }
                for (const v of byDev.values()) out.push({
                    name: v.name,
                    value: v.value
                });

                return {
                    list: out,
                    avg: avg(out.map(x => x.value))
                };
            }

            // AWAL: bacaan pertama >= start per device (fallback terdekat)
            function firstAtOrAfterStart(histRows, startTs) {
                const out = [];
                if (!Array.isArray(histRows) || !histRows.length || !startTs) return {
                    list: [],
                    avg: NaN
                };

                const start = parseTs(startTs);
                if (!start) return {
                    list: [],
                    avg: NaN
                };

                const byDev = new Map();
                for (const r of histRows) {
                    const val = extractValidMoistureValue(r);
                    if (val === null) continue;

                    const name = r.device_name || r.device_id || r.sensor_id || 'Tombak';
                    const ts = parseTs(r.timestamp);
                    if (!ts) continue;

                    if (!byDev.has(name)) byDev.set(name, []);
                    byDev.get(name).push({
                        ts,
                        value: val,
                        name
                    });
                }

                for (const [name, arr] of byDev.entries()) {
                    arr.sort((a, b) => a.ts - b.ts);

                    // pilih pertama yang >= start
                    let pick = arr.find(x => x.ts >= start);

                    // fallback: yang paling dekat dengan start (selisih absolut terkecil)
                    if (!pick) {
                        let best = null,
                            bestDiff = Infinity;
                        for (const x of arr) {
                            const d = Math.abs(x.ts - start);
                            if (d < bestDiff) {
                                best = x;
                                bestDiff = d;
                            }
                        }
                        pick = best || null;
                    }

                    if (pick) out.push({
                        name,
                        value: pick.value
                    });
                }

                return {
                    list: out,
                    avg: avg(out.map(x => x.value))
                };
            }

            // ====== RENDER ======
            function renderList(containerId, items) {
                const el = document.getElementById(containerId);
                el.innerHTML = '';
                if (!items || !items.length) {
                    const p = document.createElement('p');
                    p.style.margin = '0';
                    p.style.color = '#1E3A8A99';
                    p.textContent = 'Tidak ada data tombak.';
                    el.appendChild(p);
                    return;
                }
                items.forEach((it, idx) => {
                    const row = document.createElement('div');
                    row.className = 'd-flex justify-content-between py-1';
                    const left = document.createElement('span');
                    left.textContent = saneDeviceName(it.name, idx);
                    const right = document.createElement('span');
                    right.textContent = toPct(it.value);
                    row.appendChild(left);
                    row.appendChild(right);
                    el.appendChild(row);
                });
            }

            // ====== OPEN MODAL FLOW (pakai kadar_air_awal dari drying_process) ======
            async function openMoistureModal() {
                try {
                    ensureMoistureModal();

                    // 1) Realtime: ambil dp & sensors (utamakan process_id yang tersimpan)
                    const maybePid = localStorage.getItem('active_process_id') || '';
                    const {
                        dp,
                        sensors
                    } = await getRealtime(maybePid);
                    if (!dp || dp.status !== 'ongoing') {
                        (window.showNotification ?
                            window.showNotification('Tidak ada proses berjalan.', 'bg-red-500') :
                            alert('Tidak ada proses berjalan.'));
                        return;
                    }
                    const processId = dp.process_id;
                    const target = Number(dp.kadar_air_target ?? 14);

                    // 2) Saat ini → latest per device (filter moisture valid & processId sama)
                    const now = latestPerDeviceNow(sensors, processId);

                    // 3) Ambil nilai awal dari drying_process.kadar_air_awal saja
                    //    - pakai dari objek dp kalau ada
                    //    - fallback /drying-process/{id} kalau kosong
                    let awalAvgVal = (dp.kadar_air_awal != null) ? Number(dp.kadar_air_awal) : NaN;
                    if (!isFinite(awalAvgVal)) {
                        const p = await getProcessShow(processId);
                        awalAvgVal = (p?.kadar_air_awal != null) ? Number(p.kadar_air_awal) : NaN;
                    }

                    // 4) Render ke modal
                    // Target
                    document.getElementById('ka-target').textContent = isFinite(target) ? `${target.toFixed(0)}%` :
                        '-';

                    // Rata-rata saat ini (boleh pilih salah satu)
                    // a) konsisten dengan per-device yang dihitung di sini:
                    document.getElementById('ka-now-avg').textContent = toPct(now.avg);
                    renderList('ka-now-tombak', now.list);

                    // (opsional) kalau mau 100% match angka di card, pakai rata-rata dari API:
                    // document.getElementById('ka-now-avg').textContent = toPct(Number(sensors.avg_grain_moisture));
                    // renderList('ka-now-tombak', now.list);

                    // Rata-rata awal (dari kadar_air_awal tabel drying_process)
                    document.getElementById('ka-awal-avg').textContent = isFinite(awalAvgVal) ? toPct(awalAvgVal) :
                        '-';
                    const awalListEl = document.getElementById('ka-awal-tombak');

                    // 5) Tampilkan modal
                    new bootstrap.Modal(document.getElementById('modalKadarAir')).show();

                } catch (err) {
                    console.error('Gagal buka modal moisture:', err);
                    (window.showNotification ?
                        window.showNotification('Gagal membuka detail kadar air: ' + (err?.message || err),
                            'bg-red-500') :
                        alert('Gagal membuka detail kadar air'));
                }
            }

            // ====== BIND CLICK KE CARD ======
            document.addEventListener('DOMContentLoaded', () => {
                ensureMoistureModal();

                // cari elemen card via ID kadarAirText (ambil parent container)
                let card = null;
                const kadarAirSpan = document.getElementById('kadarAirText');
                if (kadarAirSpan) card = kadarAirSpan.closest('div');
                if (!card) {
                    // fallback: selector tailwind dari card yang kamu kasih
                    card = document.querySelector(
                        '.bg-white\\/10.text-white.h-\\[48px\\].flex.items-center.px-4.relative');
                }
                if (card) {
                    card.style.cursor = 'pointer';
                    card.addEventListener('click', openMoistureModal);
                }
            });
        })();
    </script>


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
                        {{-- <div id="errorMessage" class="mt-3 text-danger" style="display: none;"></div> --}}
                        <div class="mb-3">
                            <label for="jenis_gabah" class="form-label">Jenis Gabah</label>
                            <select name="jenis_gabah" id="jenis_gabah" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Jenis Gabah --</option>
                                @foreach ($grainTypes as $grain)
                                    <option value="{{ $grain['grain_type_id'] }}">{{ $grain['nama_jenis'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="berat_gabah" class="form-label">Berat Gabah (Kg)</label>
                            <input type="number" name="berat_gabah" id="berat_gabah" class="form-control"
                                step="0.1" required min="0.1" />
                        </div>
                        <div class="mb-3">
                            <label for="kadar_air_target" class="form-label">Target Kadar Air Gabah (%)</label>
                            <input type="number" name="kadar_air_target" id="kadar_air_target" class="form-control"
                                value="14" step="0.1" readonly />
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
                        <div class="mb-3">
                            <label for="suhu_pembakaran" class="form-label">Suhu Pembakaran (°C)</label>
                            <input type="number" name="suhu_pembakaran" id="suhu_pembakaran" class="form-control"
                                step="0.1" style="background-color: #eceff4;" readonly />
                        </div>
                        <div style="margin-top: 30px;">
                            <button type="submit" id="predictButton" class="btn w-100"
                                style="background-color: #1E3A8A; color: white;">
                                <span id="predictButtonText">Prediksi</span>
                                <span id="predictButtonLoading" class="spinner-border spinner-border-sm hidden"
                                    role="status" aria-hidden="true"></span>
                            </button>
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
                <div class="modal-header justify-content-center position-relative" style="background-color: #f8f9fa;">
                    <h5 class="modal-title text-center w-100 fw-semibold" id="confirmStopModalLabel"
                        style="padding: 0px; margin: 0;">
                        Konfirmasi Penghentian Proses
                    </h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 mt-3 me-3"
                        data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center" style="padding: 25px 30px; font-size: 14px; color: #333;">
                    <p style="margin: 0;">Apakah Anda yakin ingin menghentikan proses pengeringan?</p>
                </div>
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

    <!-- Grid + Cards -->
    <div class="flex flex-col gap-6 mt-6">
        <div class="w-full">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Card 1 -->
                <div id="cardSuhuGabah"
                    style="height:110px;background-color:rgb(127 144 190 / 16%);border:1px solid #1e3b8a42;"
                    class="text-[#1E3A8A] rounded-[12px] shadow-md p-6 flex items-center cursor-pointer relative">
                    <svg class="h-8 w-8 mr-4 text-[#1E3A8A]" width="46" height="46" viewBox="0 0 46 46"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M23 42.1666C25.1841 42.167 27.3144 41.489 29.0965 40.2263C30.8785 38.9636 32.2244 37.1785 32.9481 35.1178C33.6717 33.0571 33.7375 30.8225 33.1362 28.7228C32.5349 26.6231 31.2962 24.762 29.5914 23.3967C29.3361 23.2031 29.1278 22.9543 28.9821 22.6688C28.8364 22.3834 28.7571 22.0688 28.75 21.7484V9.58331C28.75 8.05832 28.1442 6.59578 27.0659 5.51745C25.9876 4.43912 24.525 3.83331 23 3.83331C21.475 3.83331 20.0125 4.43912 18.9342 5.51745C17.8558 6.59578 17.25 8.05832 17.25 9.58331V21.7503C17.25 22.3981 16.9146 22.9923 16.4086 23.3986C14.7046 24.7641 13.4667 26.6251 12.8658 28.7244C12.265 30.8237 12.3309 33.0578 13.0545 35.1181C13.7781 37.1784 15.1236 38.9631 16.9051 40.2257C18.6867 41.4883 20.8164 42.1666 23 42.1666Z"
                            stroke="#1E3A8A" stroke-width="2" />
                        <path
                            d="M27.7917 31.625C27.7917 32.8958 27.2869 34.1146 26.3883 35.0132C25.4896 35.9118 24.2709 36.4166 23 36.4166C21.7292 36.4166 20.5104 35.9118 19.6118 35.0132C18.7132 34.1146 18.2084 32.8958 18.2084 31.625C18.2084 30.3542 18.7132 29.1354 19.6118 28.2368C20.5104 27.3381 21.7292 26.8333 23 26.8333C24.2709 26.8333 25.4896 27.3381 26.3883 28.2368C27.2869 29.1354 27.7917 31.625"
                            stroke="#1E3A8A" stroke-width="2" />
                        <path d="M23 26.8333V9.58331" stroke="#1E3A8A" stroke-width="2.2" stroke-linecap="round" />
                    </svg>
                    <div>
                        <h3 style="font-weight: 500;font-size: 16px;margin-bottom: 6px;">Suhu Gabah (Rata-rata)</h3>
                        <p id="suhuGabahText" class="text-[#1E3A8A]/80 text-xl" style="font-size: 16px;">0°C</p>
                    </div>
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-[#1E3A8A]" viewBox="0 0 24 24"
                        fill="none">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>

                <!-- Card 2 -->
                <div id="cardSuhuRuangan"
                    style="height:110px;background-color:rgb(127 144 190 / 16%);border:1px solid #1e3b8a42;"
                    class="text-[#1E3A8A] rounded-[12px] shadow-md p-6 flex items-center cursor-pointer relative">
                    <svg class="h-7 w-7 mr-4 text-[#1E3A8A]" width="35" height="35" viewBox="0 0 35 35"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
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
                        <h3 style="font-weight: 500;font-size: 16px;margin-bottom: 6px;">Suhu Ruangan (Rata-rata)</h3>
                        <p id="suhuRuanganText" class="text-[#1E3A8A]/80 text-xl" style="font-size: 16px;">0°C</p>
                    </div>
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-[#1E3A8A]" viewBox="0 0 24 24"
                        fill="none">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>

                <!-- Card 3 -->
                <div id="cardSuhuPembakaran"
                    style="height:110px;background-color:rgb(127 144 190 / 16%);border:1px solid #1e3b8a42;"
                    class="text-[#1E3A8A] rounded-[12px] shadow-md p-6 flex items-center cursor-pointer relative">
                    <svg class="h-8 w-8 mr-4" width="40" height="40" viewBox="0 0 39 39" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M30.264 20.681C29.9325 19.8924 29.5559 18.9991 29.1878 17.8961C28.225 15.0089 31.3012 11.8597 31.3304 11.8304L29.6071 10.1071C29.4365 10.2777 25.4353 14.3459 26.8747 18.6664C27.272 19.8583 27.6693 20.7992 28.0178 21.6279C28.8304 23.2352 29.2525 25.0115 29.25 26.8125C29.1072 28.2643 28.5498 29.6443 27.6444 30.7881C26.7389 31.9319 25.5237 32.7911 24.1434 33.2633C24.5795 31.5543 24.573 29.7623 24.1245 28.0564C23.6761 26.3506 22.8005 24.7871 21.5804 23.5133L20.308 22.241L19.5987 23.8948C17.3611 29.1159 14.6981 31.395 13.132 32.3456C12.1704 31.7571 11.3622 30.9486 10.7742 29.9866C10.1863 29.0246 9.8352 27.9367 9.75 26.8125C9.83331 25.2782 10.218 23.7753 10.8822 22.3897C11.6701 20.7194 12.114 18.9078 12.1875 17.0625V14.8956C13.2527 15.3343 14.625 16.4836 14.625 19.5V22.6736L16.7493 20.3153C20.542 16.1058 19.7511 11.0931 18.2191 7.75247C19.3836 8.14064 20.3836 8.90939 21.0581 9.93496C21.7326 10.9605 22.0424 12.1832 21.9375 13.4062H24.375C24.375 6.65803 18.7943 4.875 15.8438 4.875H13.4062L14.8687 6.82378C15.0357 7.04925 18.3568 11.6098 16.5177 16.1935C16.1089 15.0414 15.359 14.041 14.3678 13.3254C13.3766 12.6098 12.191 12.2129 10.9688 12.1875H9.75V17.0625C9.66669 18.5968 9.28196 20.0997 8.61778 21.4853C7.82992 23.1556 7.38602 24.9672 7.3125 26.8125C7.3125 31.5023 11.9718 36.5625 19.5 36.5625C27.0282 36.5625 31.6875 31.5023 31.6875 26.8125C31.6883 24.6867 31.2013 22.589 30.264 20.681Z"
                            fill="#1E3A8A" />
                    </svg>
                    <div>
                        <h3 style="font-weight: 500;font-size: 16px;margin-bottom: 6px;">Suhu Pembakaran (Rata-rata)</h3>
                        <p id="suhuPembakaranText" class="text-[#1E3A8A]/80 text-xl" style="font-size: 16px;">0°C</p>
                    </div>
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-[#1E3A8A]" viewBox="0 0 24 24"
                        fill="none">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>

                <!-- Card 4 -->
                <div id="cardPengaduk"
                    style="height:110px;background-color:rgb(127 144 190 / 16%);border:1px solid #1e3b8a42;"
                    class="text-[#1E3A8A] rounded-[12px] shadow-md p-6 flex items-center cursor-pointer relative">
                    <i class="fa-solid fa-arrows-rotate text-2xl mr-4 text-[#1E3A8A]"></i>
                    <div>
                        <h3 style="font-weight: 500;font-size: 16px;margin-bottom: 6px;">Status Pengaduk</h3>
                        <p id="statusPengadukText" class="text-[#1E3A8A]/80 text-xl" style="font-size: 16px;">Nonaktif
                        </p>
                    </div>
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-[#1E3A8A]" viewBox="0 0 24 24"
                        fill="none">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <script>
        (() => {
            // ===== CONFIG =====
            const API_BASE = (window.baseUrl || "{{ config('services.api.base_url') }}").replace(/\/+$/, '');
            const AUTH_TOKEN = (typeof window.sanctumToken !== 'undefined' && window.sanctumToken) ?
                window.sanctumToken : (localStorage.getItem('token') || '');
            const USER_ID = (typeof window.userId !== 'undefined' && window.userId !== null) ?
                window.userId : ({{ auth()->id() ?? 1 }});

            // ===== HELPERS =====
            const isNum = (v) => typeof v === 'number' && isFinite(v);
            const fmt = (v, unit = '') => isNum(v) ? `${v.toFixed(2)}${unit}` : '-';
            const avg = (arr) => arr.length ? (arr.reduce((a, b) => a + b, 0) / arr.length) : NaN;
            const hAuth = (need = false) => {
                const h = {
                    Accept: 'application/json'
                };
                if (AUTH_TOKEN) h.Authorization = 'Bearer ' + AUTH_TOKEN;
                if (need && !AUTH_TOKEN) throw new Error('Auth token diperlukan.');
                return h;
            };
            const parseTs = (ts) => {
                if (!ts) return null;
                let d = new Date(ts);
                if (!isNaN(d)) return d;
                d = new Date(String(ts).replace(' ', 'T'));
                return isNaN(d) ? null : d;
            };
            const devName = (x, i) => x ? String(x) : `Tombak ${i + 1}`;
            const statusText = (v) => (v === 1 || v === true || v === 'Aktif') ? 'Aktif' :
                (v === 0 || v === false || v === 'Nonaktif') ? 'Nonaktif' : (v || '-');

            // ===== API =====
            async function getRealtime(possiblePid) {
                const url =
                    `${API_BASE}/get_sensor/realtime?user_id=${encodeURIComponent(USER_ID)}${possiblePid?`&process_id=${encodeURIComponent(possiblePid)}`:''}`;
                const r = await fetch(url, {
                    headers: hAuth(false)
                });
                if (!r.ok) throw new Error(`Realtime HTTP ${r.status}`);
                const j = await r.json();
                return {
                    dp: j.drying_process || j?.data?.drying_process || null,
                    sensors: j.sensors || {}
                };
            }

            async function getProcessShow(processId) {
                const r = await fetch(`${API_BASE}/drying-process/${encodeURIComponent(processId)}`, {
                    headers: hAuth(false)
                });
                if (!r.ok) throw new Error(`Show HTTP ${r.status}`);
                const j = await r.json();
                return j?.data || null;
            }

            async function getProcessStartTime(processId) {
                const data = await getProcessShow(processId);
                return data?.timestamp_mulai || null; // format string "Y-m-d H:i:s"
            }

            async function getDetail(processId) {
                // sesuai controller: method detail($process_id) → data array (terbaru → terlama)
                const r = await fetch(`${API_BASE}/drying-process/detail/${encodeURIComponent(processId)}`, {
                    headers: hAuth(false)
                });
                if (!r.ok) throw new Error(`Detail HTTP ${r.status}`);
                const j = await r.json();
                const arr = Array.isArray(j?.data) ? j.data : [];
                return arr;
            }

            // ===== EXTRACT: NOW (latest per device) by key dari realtime =====
            function latestPerDeviceNowByKey(sensors, processId, key) {
                const out = [];
                if (!sensors || !Array.isArray(sensors.data)) return {
                    list: [],
                    avg: NaN
                };
                const byDev = new Map();
                for (const row of sensors.data) {
                    if (row.process_id && String(row.process_id) !== String(processId)) continue;
                    const val = Number(row?.[key]);
                    if (!isFinite(val) || val <= 0) continue; // skip 0/invalid
                    const name = row.device_name || row.device_id || row.sensor_id || 'Tombak';
                    const ts = parseTs(row.timestamp);
                    if (!ts) continue;
                    const prev = byDev.get(name);
                    if (!prev || ts > prev.ts) byDev.set(name, {
                        ts,
                        name,
                        value: val
                    });
                }
                for (const v of byDev.values()) out.push({
                    name: v.name,
                    value: v.value
                });
                return {
                    list: out,
                    avg: avg(out.map(x => x.value))
                };
            }

            // ===== EXTRACT: AWAL berdasarkan timestamp_mulai terdekat =====
            // Cari item di detail() dengan timestamp terdekat ke timestamp_mulai,
            // lalu ambil hanya kolom sesuai key (mis. suhu_gabah) per tombak/device.
            function findClosestRecords(detailArr, startTimeStr, key) {
                if (!Array.isArray(detailArr) || !detailArr.length || !startTimeStr) return {
                    list: [],
                    avg: NaN,
                    ts: null
                };

                const targetTime = parseTs(startTimeStr);
                if (!targetTime) return {
                    list: [],
                    avg: NaN,
                    ts: null
                };

                let closest = null;
                let minDiff = Infinity;

                for (const item of detailArr) {
                    const ts = parseTs(item?.timestamp);
                    if (!ts) continue;
                    const diff = Math.abs(ts - targetTime);
                    if (diff < minDiff) {
                        minDiff = diff;
                        closest = item;
                    }
                }

                if (!closest) return {
                    list: [],
                    avg: NaN,
                    ts: null
                };

                // key khusus pembakaran ada di level interval, lainnya ada di sensor_data.tombak
                if (key === 'suhu_pembakaran') {
                    const v = Number(closest?.suhu_pembakaran);
                    const list = (isFinite(v) && v > 0) ? [{
                        name: 'Pembakaran',
                        value: v
                    }] : [];
                    return {
                        list,
                        avg: avg(list.map(x => x.value)),
                        ts: closest?.timestamp || null
                    };
                }

                const tombak = closest?.sensor_data?.tombak || [];
                const list = tombak
                    .map((t, idx) => {
                        const val = Number(t?.[key]);
                        if (!isFinite(val) || val <= 0) return null;
                        return {
                            name: devName(t?.device_name, idx),
                            value: val
                        };
                    })
                    .filter(Boolean);

                return {
                    list,
                    avg: avg(list.map(x => x.value)),
                    ts: closest?.timestamp || null
                };
            }

            function ensureNumericModal({
                modalId,
                title,
                iconSvg
            }) {
                if (document.getElementById(modalId)) return;
                const html = `
<div class="modal fade" id="${modalId}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" style="max-width:560px;">
    <div class="modal-content" style="border-radius:16px;border:none;overflow:hidden;box-shadow:0 4px 18px rgba(30,59,138,.2);">
      <div class="modal-header">
        <h5 class="modal-title" style="margin:0;color:#1e3b8a;font-weight:700;display:flex;align-items:center;gap:10px;">
          ${iconSvg}
          <span>Detail ${title}</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body" style="padding:18px 20px;">
        <!-- Hanya bagian SAAT INI -->
        <div style="color:#1e3b8a;font-weight:700;">${title} Saat Ini</div>
        <hr class="my-2">
        <div class="d-flex justify-content-between py-1"><span>Rata-rata saat ini</span><span id="${modalId}-now-avg">-</span></div>
        <div id="${modalId}-now-list"></div>
      </div>
    </div>
  </div>
</div>`;
                const wrap = document.createElement('div');
                wrap.innerHTML = html;
                document.body.appendChild(wrap.firstElementChild);
            }

            async function openNumericModal({
                modalId,
                title,
                unit,
                key,
                iconSvg
            }) {
                try {
                    ensureNumericModal({
                        modalId,
                        title,
                        iconSvg
                    });

                    const maybePid = localStorage.getItem('active_process_id') || '';
                    const {
                        dp,
                        sensors
                    } = await getRealtime(maybePid);
                    if (!dp || !dp.process_id) {
                        (window.showNotification ? window.showNotification('Tidak ada proses berjalan.',
                            'bg-red-500') : alert('Tidak ada proses berjalan.'));
                        return;
                    }
                    const processId = dp.process_id;

                    // Ambil data SAAT INI dari realtime
                    const now = latestPerDeviceNowByKey(sensors, processId, key);

                    // Render hanya SAAT INI
                    document.getElementById(`${modalId}-now-avg`).textContent = fmt(now.avg, unit);
                    renderPairs(`${modalId}-now-list`, now.list, unit);

                    new bootstrap.Modal(document.getElementById(modalId)).show();
                } catch (err) {
                    console.error('openNumericModal error:', err);
                    (window.showNotification ? window.showNotification('Gagal membuka detail: ' + (err?.message ||
                        err), 'bg-red-500') : alert('Gagal membuka detail.'));
                }
            }

            function renderPairs(containerId, items, unit = '') {
                const el = document.getElementById(containerId);
                if (!el) return; // Kalau elemen tidak ada, stop

                el.innerHTML = '';
                if (!items || !items.length) {
                    const p = document.createElement('p');
                    p.style.margin = '0';
                    p.style.color = '#1E3A8A99';
                    p.textContent = 'Tidak ada data tombak.';
                    el.appendChild(p);
                    return;
                }

                items.forEach((it, idx) => {
                    const row = document.createElement('div');
                    row.className = 'd-flex justify-content-between py-1';

                    const left = document.createElement('span');
                    left.textContent = devName(it.name, idx);

                    const right = document.createElement('span');
                    right.textContent = fmt(it.value, unit);

                    row.appendChild(left);
                    row.appendChild(right);
                    el.appendChild(row);
                });
            }


            // ===== Pengaduk (hanya "Status Saat Ini") =====
            function ensurePengadukModal(iconHtml) {
                if (document.getElementById('modalPengaduk')) return;
                const html = `
<div class="modal fade" id="modalPengaduk" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog" style="max-width:520px;">
    <div class="modal-content" style="border-radius:16px;border:none;overflow:hidden;box-shadow:0 4px 18px rgba(30,59,138,.2);">
      <div class="modal-header">
        <h5 class="modal-title" style="margin:0;color:#1e3b8a;font-weight:700;display:flex;align-items:center;gap:10px;">
          ${iconHtml}
          <span>Detail Status Pengaduk</span>
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
      </div>
      <div class="modal-body" style="padding:18px 20px;">
        <div class="d-flex justify-content-between py-1">
          <span>Status Saat Ini</span>
          <span id="pengaduk-now">-</span>
        </div>
      </div>
    </div>
  </div>
</div>`;
                const wrap = document.createElement('div');
                wrap.innerHTML = html;
                document.body.appendChild(wrap.firstElementChild);
            }

            async function openPengadukModal() {
                try {
                    ensurePengadukModal(`<i class="fa-solid fa-arrows-rotate text-lg" style="color:#1E3A8A"></i>`);

                    const maybePid = localStorage.getItem('active_process_id') || '';
                    const {
                        dp,
                        sensors
                    } = await getRealtime(maybePid);

                    if (!dp || !dp.process_id) {
                        (window.showNotification ? window.showNotification('Tidak ada proses berjalan.',
                            'bg-red-500') : alert('Tidak ada proses berjalan.'));
                        return;
                    }

                    // ✅ NOW: langsung pakai `latest_stirrer_status` dari API
                    const nowVal = sensors.latest_stirrer_status;

                    document.getElementById('pengaduk-now').textContent = statusText(nowVal);

                    new bootstrap.Modal(document.getElementById('modalPengaduk')).show();
                } catch (err) {
                    console.error('openPengadukModal error:', err);
                    (window.showNotification ? window.showNotification('Gagal membuka detail pengaduk: ' + (err
                        ?.message || err), 'bg-red-500') : alert('Gagal membuka detail pengaduk.'));
                }
            }


            // ===== ICON SVG untuk header modal =====
            const ICON_SUHU_GABAH = `
<svg class="h-5 w-5" width="20" height="20" viewBox="0 0 46 46" fill="none" xmlns="http://www.w3.org/2000/svg" style="color:#1E3A8A">
  <path d="M23 42.1666C25.1841 42.167 27.3144 41.489 29.0965 40.2263C30.8785 38.9636 32.2244 37.1785 32.9481 35.1178C33.6717 33.0571 33.7375 30.8225 33.1362 28.7228C32.5349 26.6231 31.2962 24.762 29.5914 23.3967C29.3361 23.2031 29.1278 22.9543 28.9821 22.6688C28.8364 22.3834 28.7571 22.0688 28.75 21.7484V9.58331C28.75 8.05832 28.1442 6.59578 27.0659 5.51745C25.9876 4.43912 24.525 3.83331 23 3.83331C21.475 3.83331 20.0125 4.43912 18.9342 5.51745C17.8558 6.59578 17.25 8.05832 17.25 9.58331V21.7503C17.25 22.3981 16.9146 22.9923 16.4086 23.3986C14.7046 24.7641 13.4667 26.6251 12.8658 28.7244C12.265 30.8237 12.3309 33.0578 13.0545 35.1181C13.7781 37.1784 15.1236 38.9631 16.9051 40.2257C18.6867 41.4883 20.8164 42.1666 23 42.1666Z" stroke="#1E3A8A" stroke-width="2"/>
  <path d="M27.7917 31.625C27.7917 32.8958 27.2869 34.1146 26.3883 35.0132C25.4896 35.9118 24.2709 36.4166 23 36.4166C21.7292 36.4166 20.5104 35.9118 19.6118 35.0132C18.7132 34.1146 18.2084 32.8958 18.2084 31.625C18.2084 30.3542 18.7132 29.1354 19.6118 28.2368C20.5104 27.3381 21.7292 26.8333 23 26.8333C24.2709 26.8333 25.4896 27.3381 26.3883 28.2368C27.2869 29.1354 27.7917 31.625" stroke="#1E3A8A" stroke-width="2"/>
  <path d="M23 26.8333V9.58331" stroke="#1E3A8A" stroke-width="2.2" stroke-linecap="round"/>
</svg>`.trim();

            const ICON_SUHU_RUANGAN = `
<svg class="h-5 w-5" width="20" height="20" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg" style="color:#1E3A8A">
  <g clip-path="url(#clip0_250_268)">
    <path d="M17.5 0.5V35.5M22.707 4.25C21.1355 5.07027 19.3348 5.50254 17.5 5.5C15.6652 5.50254 13.8645 5.07027 12.293 4.25M12.293 31.75C13.8657 30.9321 15.6656 30.5 17.5 30.5C19.3344 30.5 21.1343 30.9321 22.707 31.75M35 9.25L0 26.75M33.8525 15.0312C32.248 14.2606 30.9157 13.1264 29.9986 11.7501C29.0815 10.3739 28.6141 8.80749 28.6465 7.21875M1.14748 20.9688C2.75205 21.7394 4.08425 22.8736 5.00135 24.2499C5.91845 25.6261 6.38588 27.1925 6.35355 28.7812M0 9.25L35 26.75M1.14748 15.0312C2.75205 14.2606 4.08425 13.1264 5.00135 11.7501C5.91845 10.3739 6.38588 8.80749 6.35355 7.21875M33.8525 20.9688C32.248 21.7394 30.9157 22.8736 29.9986 24.2499C29.0815 25.6261 28.6141 27.1925 28.6465 28.7812" stroke="#1E3A8A" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
  </g>
  <defs><clipPath id="clip0_250_268"><rect width="35" height="35" fill="white"/></clipPath></defs>
</svg>`.trim();

            const ICON_SUHU_PEMBAKARAN = `
<svg class="h-5 w-5" width="20" height="20" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg" style="color:#1E3A8A">
  <path d="M30.264 20.681C29.9325 19.8924 29.5559 18.9991 29.1878 17.8961C28.225 15.0089 31.3012 11.8597 31.3304 11.8304L29.6071 10.1071C29.4365 10.2777 25.4353 14.3459 26.8747 18.6664C27.272 19.8583 27.6693 20.7992 28.0178 21.6279C28.8304 23.2352 29.2525 25.0115 29.25 26.8125C29.1072 28.2643 28.5498 29.6443 27.6444 30.7881C26.7389 31.9319 25.5237 32.7911 24.1434 33.2633C24.5795 31.5543 24.573 29.7623 24.1245 28.0564C23.6761 26.3506 22.8005 24.7871 21.5804 23.5133L20.308 22.241L19.5987 23.8948C17.3611 29.1159 14.6981 31.395 13.132 32.3456C12.1704 31.7571 11.3622 30.9486 10.7742 29.9866C10.1863 29.0246 9.8352 27.9367 9.75 26.8125C9.83331 25.2782 10.218 23.7753 10.8822 22.3897C11.6701 20.7194 12.114 18.9078 12.1875 17.0625V14.8956C13.2527 15.3343 14.625 16.4836 14.625 19.5V22.6736L16.7493 20.3153C20.542 16.1058 19.7511 11.0931 18.2191 7.75247C19.3836 8.14064 20.3836 8.90939 21.0581 9.93496C21.7326 10.9605 22.0424 12.1832 21.9375 13.4062H24.375C24.375 6.65803 18.7943 4.875 15.8438 4.875H13.4062L14.8687 6.82378C15.0357 7.04925 18.3568 11.6098 16.5177 16.1935C16.1089 15.0414 15.359 14.041 14.3678 13.3254C13.3766 12.6098 12.191 12.2129 10.9688 12.1875H9.75V17.0625C9.66669 18.5968 9.28196 20.0997 8.61778 21.4853C7.82992 23.1556 7.38602 24.9672 7.3125 26.8125C7.3125 31.5023 11.9718 36.5625 19.5 36.5625C27.0282 36.5625 31.6875 31.5023 31.6875 26.8125C31.6883 24.6867 31.2013 22.589 30.264 20.681Z" fill="#1E3A8A"/>
</svg>`.trim();

            // ===== BIND KE CARD =====
            document.addEventListener('DOMContentLoaded', () => {
                const on = (id, fn) => {
                    const el = document.getElementById(id);
                    if (el) {
                        el.style.cursor = 'pointer';
                        el.addEventListener('click', fn);
                    }
                };

                on('cardSuhuGabah', () => openNumericModal({
                    modalId: 'modalSuhuGabah',
                    title: 'Suhu Gabah',
                    unit: '°C',
                    key: 'suhu_gabah',
                    iconSvg: ICON_SUHU_GABAH
                }));

                on('cardSuhuRuangan', () => openNumericModal({
                    modalId: 'modalSuhuRuangan',
                    title: 'Suhu Ruangan',
                    unit: '°C',
                    key: 'suhu_ruangan',
                    iconSvg: ICON_SUHU_RUANGAN
                }));

                on('cardSuhuPembakaran', () => openNumericModal({
                    modalId: 'modalSuhuPembakaran',
                    title: 'Suhu Pembakaran',
                    unit: '°C',
                    key: 'suhu_pembakaran',
                    iconSvg: ICON_SUHU_PEMBAKARAN
                }));

                on('cardPengaduk', () => openPengadukModal());
            });
        })();
    </script>


    <!-- Mini Sidebar -->
    <div class="mini-sidebar" id="miniSidebar" style="border: 1px solid #1e3b8a;">
        <div class="content-sidebar" style="border: 1px solid #c6d0ec;">
            <div class="expand-handle" onclick="toggleSidebar()"></div>
            <div class="duration-option" onclick="toggleSidebar()">
                <span class="span" id="durasiLabel">Estimasi: <span style="font-weight: 800;" id="durasiText">0
                        menit</span></span>
            </div>
            <div class="detail-section">
                <h3>Detail Pengeringan:</h3>
                <p style="display:flex; justify-content:space-between; margin:4px 0;">
                    <span>Jenis Gabah</span>
                    <span style="color: #1e3b8a; font-weight: 600;" id="jenisGabah">Tidak tersedia</span>
                </p>
                <p style="display:flex; justify-content:space-between; margin:4px 0;">
                    <span>Berat Gabah Awal</span>
                    <span style="color: #1e3b8a; font-weight: 600;" id="beratGabahAwal">Tidak tersedia</span>
                </p>
                <p style="display:flex; justify-content:space-between; margin:4px 0;">
                    <span>Target Kadar Air</span>
                    <span style="color: #1e3b8a; font-weight: 600;" id="targetKadarAir">14%</span>
                </p>
                <p style="display:flex; justify-content:space-between; margin:4px 0;">
                    <span>Waktu Dimulai</span>
                    <span style="color: #1e3b8a; font-weight: 600;" id="waktuDimulai">Tidak tersedia</span>
                </p>
                <p style="display:flex; justify-content:space-between; margin:4px 0;">
                    <span>Durasi Terlaksana</span>
                    <span style="color: #1e3b8a; font-weight: 600;" id="durasiTerlaksanaText">Tidak tersedia</span>
                </p>
            </div>
            <div class="no-process" id="noProcessMessage" style="display: none;">
                Tidak ada proses aktif
            </div>
        </div>
    </div>

    <script>
    // Toggle Sidebar - DENGAN STATE MANAGEMENT
    window.toggleSidebar = function() {
        const sidebarEl = document.getElementById('miniSidebar');
        if (!sidebarEl) return;
        
        // Toggle expanded class
        sidebarEl.classList.toggle('expanded');
        
        // Update manual toggle flag
        window.sidebarManualToggle = true;
        
        const isExpanded = sidebarEl.classList.contains('expanded');
        console.log(`👆 Manual sidebar toggle: ${isExpanded ? 'expanded' : 'collapsed'}`);
    };

    // ====== GLOBAL FUNCTIONS - Pindahkan ke luar IIFE ======
    const isNum = (v) => v !== null && v !== '' && !Number.isNaN(Number(v)) && Number.isFinite(parseFloat(v));
    const fmtDur = (m) => {
        const n = parseFloat(m);
        if (!isNum(n) || n <= 0) return '0 menit';
        const h = Math.floor(n / 60);
        const mm = Math.floor(n % 60);
        return h > 0 ? `${h} jam ${mm} menit` : `${mm} menit`;
    };

    const pad2 = (n) => (n < 10 ? `0${n}` : `${n}`);
    const fmtDateTime = (ts) => {
        const d = parseAnyTs(ts);
        if (!d) return 'Tidak tersedia';
        const tanggal = d.toLocaleDateString('id-ID', {
            day: '2-digit',
            month: 'long',
            year: 'numeric'
        });
        const jamMenit = `${pad2(d.getHours())}.${pad2(d.getMinutes())}`;
        return `${jamMenit}, ${tanggal}`;
    };

    // ====== GLOBAL FUNCTION: parseAnyTs - SUPPORT LEBIH BANYAK FORMAT ======
    function parseAnyTs(ts) {
        if (!ts) return null;
        
        // Format ISO dengan timezone
        if (/Z|[+\-]\d{2}:\d{2}$/.test(ts)) {
            const d = new Date(ts.replace(' ', 'T'));
            if (!isNaN(d.getTime())) return d;
        }
        
        // Format Y-m-d H:i:s (standard Laravel)
        let m = String(ts).match(/^(\d{4})-(\d{1,2})-(\d{1,2})[ T](\d{1,2}):(\d{1,2})(?::(\d{1,2}))?$/);
        if (m) {
            const y = +m[1], mo = +m[2] - 1, da = +m[3];
            const hh = +(m[4] || '0'), mm = +(m[5] || '0'), ss = +(m[6] || '0');
            const d = new Date(y, mo, da, hh, mm, ss);
            if (!isNaN(d.getTime())) return d;
        }
        
        // Format Y-m-d H:i (tanpa detik)
        m = String(ts).match(/^(\d{4})-(\d{1,2})-(\d{1,2})[ T](\d{1,2}):(\d{1,2})$/);
        if (m) {
            const y = +m[1], mo = +m[2] - 1, da = +m[3];
            const hh = +m[4], mm = +m[5];
            const d = new Date(y, mo, da, hh, mm, 0);
            if (!isNaN(d.getTime())) return d;
        }
        
        // Fallback ke Date constructor
        const d = new Date(ts);
        if (!isNaN(d.getTime())) return d;
        
        console.warn('⚠️ Failed to parse timestamp:', ts);
        return null;
    }

    // ====== GLOBAL FUNCTION: minutesSince - DENGAN VALIDASI LEBIH BAIK ======
    const minutesSince = (ts) => {
        if (!ts) {
            console.warn('⚠️ No timestamp provided to minutesSince');
            return 0;
        }
        
        const parsed = parseAnyTs(ts);
        if (!parsed || isNaN(parsed.getTime())) {
            console.warn('⚠️ Invalid timestamp parsed:', ts);
            return 0;
        }
        
        const now = new Date();
        const diffMs = now - parsed;
        
        if (diffMs < 0) {
            console.warn('⚠️ Timestamp in future:', ts);
            return 0;
        }
        
        const minutes = Math.floor(diffMs / 60000);
        return Math.max(0, minutes);
    };

    // ====== GLOBAL FUNCTION: showNoProcess - JAGA STATE EXPANDED ======
    window.showNoProcess = function() {
        // ✅ PERBAIKAN: Simpan state expanded sebelum reset
        const sidebarEl = document.getElementById('miniSidebar');
        const wasExpanded = sidebarEl && sidebarEl.classList.contains('expanded');
        
        const durasiEl = document.getElementById('durasiText');
        const jenisEl = document.getElementById('jenisGabah');
        const beratEl = document.getElementById('beratGabahAwal');
        const targetEl = document.getElementById('targetKadarAir');
        const waktuEl = document.getElementById('waktuDimulai');
        const durasiTerEl = document.getElementById('durasiTerlaksanaText');
        const noProcessEl = document.getElementById('noProcessMessage');
        const durationOption = document.querySelector('.duration-option');

        // Update content
        if (durasiEl) durasiEl.innerText = '0 menit';
        if (jenisEl) jenisEl.innerText = 'Tidak tersedia';
        if (beratEl) beratEl.innerText = 'Tidak tersedia';
        if (targetEl) targetEl.innerText = '14%';
        if (waktuEl) waktuEl.innerText = 'Tidak tersedia';
        if (durasiTerEl) durasiTerEl.innerText = 'Tidak tersedia';
        
        if (sidebarEl) sidebarEl.style.display = 'block';
        if (noProcessEl) noProcessEl.style.display = 'block';
        if (durationOption) durationOption.style.display = 'none';
        
        console.log('📋 showNoProcess called, wasExpanded:', wasExpanded);
        
        // ✅ PERBAIKAN: Restore expanded state jika sebelumnya expanded
        if (wasExpanded && sidebarEl) {
            setTimeout(() => {
                sidebarEl.classList.add('expanded');
                console.log('🔄 Sidebar expanded state restored in showNoProcess');
            }, 50);
        }
    };

    let durasiTimer = null,
        lastPid = null,
        lastStartTs = null;

    // ====== GLOBAL FUNCTION: startDurasiTicker - DENGAN DATABASE TIMESTAMP ======
    window.startDurasiTicker = function(tsMulai) {
        // Stop existing timer
        if (durasiTimer) {
            clearInterval(durasiTimer);
            durasiTimer = null;
        }
        
        // Validasi timestamp
        if (!tsMulai) {
            console.warn('⚠️ No valid timestamp for durasi ticker');
            return;
        }
        
        const durasiTerEl = document.getElementById('durasiTerlaksanaText');
        if (!durasiTerEl) {
            console.warn('⚠️ durasiTerlaksanaText element not found');
            return;
        }
        
        console.log('⏰ Starting durasi ticker with timestamp:', tsMulai);
        
        const updateDuration = () => {
            const currentDuration = minutesSince(tsMulai);
            durasiTerEl.innerText = fmtDur(currentDuration);
            
            // Log setiap jam untuk monitoring
            if (currentDuration % 60 === 0 && currentDuration > 0) {
                console.log(`⏱️ Process running for ${currentDuration} minutes`);
            }
        };
        
        // Initial update
        updateDuration();
        
        // Update setiap menit
        durasiTimer = setInterval(updateDuration, 60000);
        
        console.log('✅ Durasi ticker started successfully');
    };

    // ====== GLOBAL FUNCTION: fetchProcessDetail - DENGAN ERROR HANDLING ======
    window.fetchProcessDetail = async function(processId, headers) {
        try {
            console.log('🔍 Fetching process detail for PID:', processId);
            
            const response = await fetch(`${baseUrl}/drying-process/${processId}`, {
                headers: headers || {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${localStorage.getItem('token') || ''}`
                }
            });
            
            if (!response.ok) {
                console.warn(`Process detail fetch failed: ${response.status}`);
                return null;
            }
            
            const result = await response.json();
            const data = result.data || result; // Handle different response formats
            
            if (!data) {
                console.warn('No process data received');
                return null;
            }
            
            // ✅ PERBAIKAN: Pastikan timestamp_mulai ada dan valid
            let timestampMulai = data.timestamp_mulai || data.start_time;
            if (timestampMulai) {
                // Validasi format timestamp
                const testDate = new Date(timestampMulai.replace(' ', 'T'));
                if (isNaN(testDate.getTime())) {
                    console.warn('Invalid timestamp format:', timestampMulai);
                    timestampMulai = null;
                }
            }
            
            const processDetail = {
                nama_jenis: data.nama_jenis || data.grain_type?.nama_jenis || data.grain_type?.nama || data.grain_type?.name || 'Tidak diketahui',
                timestamp_mulai: timestampMulai, // Dari DB - akurat
                berat_gabah_awal: data.berat_gabah_awal || data.berat_gabah || null,
                status: data.status,
                process_id: data.process_id,
                dryer_id: data.dryer_id
            };
            
            console.log('✅ Process detail fetched:', processDetail);
            return processDetail;
            
        } catch (error) {
            console.error('❌ fetchProcessDetail error:', error);
            return null;
        }
    };

    // ====== GLOBAL FUNCTION: updateSidebar - PERBAIKI STATE EXPANDED ======
    window.updateSidebar = async function() {
        try {
            const token = localStorage.getItem('token') || '';
            const headers = {
                Accept: 'application/json'
            };
            if (token) headers['Authorization'] = 'Bearer ' + token;

            const pid = localStorage.getItem('active_process_id') || '';
            const dryerId = localStorage.getItem('selected_dryer_id') || '';
            
            // ✅ PERBAIKAN: Simpan state expanded sebelum update
            const sidebarEl = document.getElementById('miniSidebar');
            const wasExpanded = sidebarEl && sidebarEl.classList.contains('expanded');
            console.log('📋 Sidebar state before update:', { wasExpanded });
            
            // ✅ PERBAIKAN: Langsung ambil dari database jika ada process_id
            let dp = null;
            let tsMulaiFromDB = null;
            
            if (pid) {
                // Prioritas 1: Ambil detail lengkap dari database
                try {
                    console.log('📋 Fetching process detail from DB for PID:', pid);
                    const processResponse = await fetch(`${baseUrl}/drying-process/${pid}`, {
                        headers
                    });
                    
                    if (processResponse.ok) {
                        const processResult = await processResponse.json();
                        dp = processResult.data || null;
                        
                        if (dp && dp.status === 'ongoing') {
                            tsMulaiFromDB = dp.timestamp_mulai;
                            console.log('✅ Process data from DB:', { pid, tsMulaiFromDB, status: dp.status });
                        }
                    } else {
                        console.warn('⚠️ Failed to fetch process detail:', processResponse.status);
                    }
                } catch (dbErr) {
                    console.warn('⚠️ Database fetch error, falling back to realtime:', dbErr);
                }
            }

            // Fallback: Gunakan realtime endpoint jika database gagal
            if (!dp) {
                let url = `${baseUrl}/get_sensor/realtime?user_id={{ auth()->id() ?? 1 }}`;
                if (pid) url += `&process_id=${pid}`;
                if (dryerId) url += `&dryer_id=${dryerId}`;

                const res = await fetch(url, { headers });
                if (!res.ok) throw new Error(`${res.status} ${res.statusText}`);
                
                const data = await res.json();
                dp = data.drying_process || data?.data?.drying_process || null;
                
                console.log('📡 Realtime data:', { pid, dp: !!dp, status: dp?.status });
            }

            // Validasi process
            if (!dp || dp.status !== 'ongoing' || (dryerId && String(dp.dryer_id) !== String(dryerId))) {
                console.log('❌ No valid ongoing process found');
                showNoProcess();
                if (durasiTimer) {
                    clearInterval(durasiTimer);
                    durasiTimer = null;
                }
                lastPid = null;
                lastStartTs = null;
                return;
            }

            console.log('✅ Valid ongoing process found:', { pid: dp.process_id, status: dp.status });

            // Estimasi durasi
            const durasiRekom = isNum(dp.durasi_rekomendasi) ? parseFloat(dp.durasi_rekomendasi) : 0;
            const durasiEl = document.getElementById('durasiText');
            if (durasiEl) durasiEl.innerText = fmtDur(durasiRekom);

            // Nama jenis gabah
            let jenisText = 'Tidak tersedia';
            if (dp.nama_jenis) {
                jenisText = dp.nama_jenis;
            } else {
                // Fallback: fetch detail jika nama_jenis kosong
                const processId = dp.process_id;
                if (processId) {
                    const detail = await fetchProcessDetail(processId, headers);
                    if (detail && detail.nama_jenis) {
                        jenisText = detail.nama_jenis;
                    }
                }
            }
            const jenisEl = document.getElementById('jenisGabah');
            if (jenisEl) jenisEl.innerText = jenisText;

            // Berat gabah awal
            const beratEl = document.getElementById('beratGabahAwal');
            if (beratEl) {
                if (isNum(dp.berat_gabah_awal)) {
                    beratEl.innerText = `${parseFloat(dp.berat_gabah_awal).toLocaleString('id-ID')} kg`;
                } else {
                    beratEl.innerText = 'Tidak tersedia';
                }
            }

            // Target kadar air
            const targetEl = document.getElementById('targetKadarAir');
            if (targetEl) {
                const target = isNum(dp.kadar_air_target) ? dp.kadar_air_target : 14;
                targetEl.innerText = `${parseFloat(target).toFixed(0)}%`;
            }

            // ✅ PERBAIKAN: Timestamp mulai - PRIORITAS DARI DATABASE
            let tsMulai = tsMulaiFromDB || dp.timestamp_mulai;
            
            // Fallback ke cache atau fetch detail
            const cacheKey = 'process_start_ts_' + dp.process_id;
            if (!tsMulai) {
                tsMulai = localStorage.getItem(cacheKey);
            }
            
            if (!tsMulai && dp.process_id) {
                const detail = await fetchProcessDetail(dp.process_id, headers);
                tsMulai = detail?.timestamp_mulai || null;
            }
            
            // Simpan ke cache
            if (tsMulai) {
                localStorage.setItem(cacheKey, tsMulai);
            }

            const waktuEl = document.getElementById('waktuDimulai');
            if (waktuEl) {
                waktuEl.innerText = tsMulai ? fmtDateTime(tsMulai) : 'Tidak tersedia';
            }

            // Update durasi ticker
            if (tsMulai) {
                if (String(lastPid) !== String(dp.process_id) || lastStartTs !== tsMulai) {
                    lastPid = dp.process_id;
                    lastStartTs = tsMulai;
                    startDurasiTicker(tsMulai);
                    console.log('⏰ Started durasi ticker with DB timestamp:', tsMulai);
                } else {
                    // Update current display
                    const durasiTerEl = document.getElementById('durasiTerlaksanaText');
                    if (durasiTerEl) {
                        durasiTerEl.innerText = fmtDur(minutesSince(tsMulai));
                    }
                }
            } else {
                const durasiTerEl = document.getElementById('durasiTerlaksanaText');
                if (durasiTerEl) durasiTerEl.innerText = 'Tidak tersedia';
                if (durasiTimer) {
                    clearInterval(durasiTimer);
                    durasiTimer = null;
                }
                console.warn('⚠️ No valid timestamp_mulai found');
            }

            // ✅ PERBAIKAN: Show sidebar DAN PERBAIKI STATE EXPANDED
            const noProcessEl = document.getElementById('noProcessMessage');
            const durationOption = document.querySelector('.duration-option');
            
            if (sidebarEl) sidebarEl.style.display = 'block';
            if (noProcessEl) noProcessEl.style.display = 'none';
            if (durationOption) durationOption.style.display = 'flex';
            
            // ✅ PERBAIKAN UTAMA: Kembalikan state expanded jika sebelumnya expanded
            if (wasExpanded && sidebarEl && !window.sidebarManualToggle) {
                // Delay sebentar untuk memastikan DOM updated
                setTimeout(() => {
                    sidebarEl.classList.add('expanded');
                    console.log('🔄 Sidebar expanded state restored');
                }, 50);
            } else if (!wasExpanded && sidebarEl && !window.sidebarManualToggle) {
                // Pastikan tidak expanded jika sebelumnya collapsed
                sidebarEl.classList.remove('expanded');
            }
            
            // Reset manual toggle flag
            window.sidebarManualToggle = false;

            console.log('✅ Sidebar updated with DB timestamp:', { 
                pid: dp.process_id, 
                tsMulai, 
                durasiRekom: durasiRekom,
                jenis: jenisText,
                wasExpanded,
                nowExpanded: sidebarEl?.classList.contains('expanded'),
                manualToggle: window.sidebarManualToggle
            });

        } catch (err) {
            console.error('❌ mini-sidebar realtime error:', err);
            
            // ✅ PERBAIKAN: Jaga state expanded saat error juga
            const sidebarEl = document.getElementById('miniSidebar');
            const wasExpanded = sidebarEl && sidebarEl.classList.contains('expanded');
            
            showNoProcess();
            if (durasiTimer) {
                clearInterval(durasiTimer);
                durasiTimer = null;
            }
            lastPid = null;
            lastStartTs = null;
            
            // ✅ PERBAIKAN: Restore expanded state setelah error
            if (wasExpanded && sidebarEl && !window.sidebarManualToggle) {
                setTimeout(() => {
                    sidebarEl.classList.add('expanded');
                    console.log('🔄 Sidebar expanded state restored after error');
                }, 100);
            }
            
            // Reset manual toggle flag
            window.sidebarManualToggle = false;
        }
    };

    // Panggil updateSidebar secara global
    updateSidebar();
    setInterval(updateSidebar, 10000);
</script>

    <!-- Modal Detail (dipertahankan) -->
    <div class="modal fade modal-detail" id="detailDataModal" tabindex="-1" aria-labelledby="detailDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailDataModalLabel">Detail Proses Pengeringan</h5><button
                        type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row g-3">
                            <div class="col-md-3"><strong>Jenis Gabah</strong><br><span id="detail_nama_jenis">-</span>
                            </div>
                            <div class="col-md-3"><strong>Berat Gabah (Kg)</strong><br><span
                                    id="detail_berat_gabah">-</span></div>
                            <div class="col-md-3"><strong>Suhu Gabah Awal (°C)</strong><br><span
                                    id="detail_suhu_gabah_awal">-</span></div>
                            <div class="col-md-3"><strong>Suhu Ruangan Awal (°C)</strong><br><span
                                    id="detail_suhu_ruangan_awal">-</span></div>
                            <div class="col-md-3"><strong>Suhu Pembakaran Awal (°C)</strong><br><span
                                    id="detail_suhu_pembakaran_awal">-</span></div>
                            <div class="col-md-3"><strong>Kadar Air Awal (%)</strong><br><span
                                    id="detail_kadar_air_awal">-</span></div>
                            <div class="col-md-3"><strong>Kadar Air Target (%)</strong><br><span
                                    id="detail_kadar_air_target">-</span></div>
                            <div class="col-md-3"><strong>Suhu Gabah Akhir (°C)</strong><br><span
                                    id="detail_suhu_gabah_akhir">-</span></div>
                            <div class="col-md-3"><strong>Suhu Ruangan Akhir (°C)</strong><br><span
                                    id="detail_suhu_ruangan_akhir">-</span></div>
                            <div class="col-md-3"><strong>Suhu Pembakaran Akhir (°C)</strong><br><span
                                    id="detail_suhu_pembakaran_akhir">-</span></div>
                            <div class="col-md-3"><strong>Kadar Air Akhir (%)</strong><br><span
                                    id="detail_kadar_air_akhir">-</span></div>
                            <div class="col-md-3"><strong>Durasi Rekomendasi</strong><br><span
                                    id="detail_durasi_rekomendasi">-</span></div>
                            <div class="col-md-3"><strong>Durasi Aktual</strong><br><span
                                    id="detail_durasi_aktual">-</span></div>
                            <div class="col-md-3"><strong>Waktu Mulai</strong><br><span
                                    id="detail_timestamp_mulai">-</span></div>
                            <div class="col-md-3"><strong>Waktu Selesai</strong><br><span
                                    id="detail_timestamp_selesai">-</span></div>
                            <div class="col-md-3"><strong>Status</strong><br><span id="detail_status">-</span></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <!-- DataTables CSS/JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <!-- Durasi terlaksana fallback -->
    <script>
        async function fetchDurasiTerlaksana() {
            try {
                const response = await fetch("{{ config('services.api.base_url') }}/drying-process");
                const result = await response.json();
                let data = [];
                if (Array.isArray(result)) data = result;
                else if (Array.isArray(result.data)) data = result.data;
                else if (Array.isArray(result.data?.data)) data = result.data.data;
                else {
                    document.getElementById('durasiTerlaksanaText').textContent = "Tidak tersedia";
                    return;
                }

                const ongoing = data.find(item => item.status === 'ongoing');
                if (!ongoing) {
                    document.getElementById('durasiTerlaksanaText').textContent = "Tidak tersedia";
                    return;
                }

                let totalMenit = 0;
                if (ongoing.durasi_terlaksana) {
                    totalMenit = Math.floor(parseInt(ongoing.durasi_terlaksana) / 60);
                } else if (ongoing.timestamp_mulai) {
                    const mulai = new Date(ongoing.timestamp_mulai);
                    const now = new Date();
                    const selisihMs = now - mulai;
                    totalMenit = Math.floor(selisihMs / (1000 * 60));
                }
                document.getElementById('durasiTerlaksanaText').textContent = `${totalMenit} menit`;
            } catch (error) {
                console.error("Gagal mengambil data durasi:", error);
                document.getElementById('durasiTerlaksanaText').textContent = "...";
            }
        }
        fetchDurasiTerlaksana();
        setInterval(fetchDurasiTerlaksana, 60000);
    </script>

    <script>
        (function($) {
            $(document).ready(function() {
                const sanctumToken = localStorage.getItem('token') ||
                    "{{ session('token') ?? '' }}";

                // === HAPUS duplikasi showNotification di sini; gunakan global ===

                // Selesai button (open modal)
                $(document).on('click', '.btn-selesai', function() {
                    const processId = $(this).data('process-id');
                    $('#confirmCompleteBtn').data('process-id', processId);
                    $('#confirmCompleteBtn').data('triggering-button', this);
                    const confirmModal = new bootstrap.Modal(document.getElementById(
                        'confirmCompleteModal'));
                    confirmModal.show();
                });

                $('#confirmCompleteModal').on('hidden.bs.modal', function() {
                    const triggeringButton = $('#confirmCompleteBtn').data('triggering-button');
                    if (triggeringButton) {
                        $(triggeringButton).focus();
                        $('#confirmCompleteBtn').removeData('triggering-button');
                    }
                });

                $('#confirmCompleteBtn').on('click', function() {
                    const processId = $(this).data('process-id');
                    const confirmModal = bootstrap.Modal.getInstance(document.getElementById(
                        'confirmCompleteModal'));
                    confirmModal.hide();
                    const triggeringButton = $(this).data('triggering-button');
                    completeProcess(processId, triggeringButton);
                });

                async function completeProcess(processId, triggeringButton) {
                    if (!sanctumToken) {
                        showNotification('Autentikasi Gagal', 'Silakan login untuk melanjutkan.', 'error');
                        setTimeout(() => {
                            window.location.href = '{{ route('login') }}';
                        }, 2000);
                        return;
                    }
                    try {
                        const response = await fetch(
                            `{{ config('services.api.base_url') }}/get_sensor/realtime?user_id={{ auth()->id() }}&process_id=${processId}`, {
                                headers: {
                                    'Authorization': `Bearer ${sanctumToken}`,
                                    'Accept': 'application/json'
                                }
                            });
                        if (!response.ok) {
                            if (response.status === 401) {
                                showNotification('Sesi Berakhir', 'Silakan login kembali.', 'error');
                                setTimeout(() => {
                                    window.location.href = '{{ route('login') }}';
                                }, 2000);
                                throw new Error('Unauthorized');
                            }
                            throw new Error(`Gagal mengambil data sensor: ${response.statusText}`);
                        }
                        const sensorData = await response.json();
                        if (!sensorData.sensors || sensorData.sensors.avg_grain_moisture == null) {
                            showNotification('Gagal', 'Data kadar air dari sensor tidak tersedia.',
                                'error');
                            return;
                        }
                        const kadarAirAkhir = parseFloat(sensorData.sensors.avg_grain_moisture);
                        if (isNaN(kadarAirAkhir)) {
                            showNotification('Gagal', 'Data kadar air tidak valid.', 'error');
                            return;
                        }
                        const completeData = {
                            kadar_air_akhir: kadarAirAkhir,
                            // berat_gabah_akhir: null,
                            timestamp_selesai: new Date().toISOString().slice(0, 19).replace('T', ' ')
                        };
                        await sendCompleteRequest(processId, completeData, triggeringButton);
                    } catch (err) {
                        console.error('Error fetching sensor data:', err);
                        showNotification('Gagal Mengambil Data Sensor', err.message, 'error');
                    }
                }

                async function sendCompleteRequest(processId, completeData, triggeringButton) {
                    try {
                        const response = await fetch(
                            `{{ config('services.api.base_url') }}/drying-process/${processId}/complete`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Authorization': `Bearer ${sanctumToken}`,
                                    'Accept': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify(completeData)
                            }
                        );

                        const data = await response.json().catch(() => null);

                        if (!response.ok) {
                            throw new Error(data?.error ||
                                `Gagal menyelesaikan proses: ${response.statusText}`);
                        }

                        if (data && data.success === true) {
                            const d = data.data || {};
                            const durasi = (typeof d.durasi_terlaksana === 'number') ? d.durasi_terlaksana :
                                null;
                            const kadarAkhir = (typeof d.kadar_air_akhir === 'number') ?
                                d.kadar_air_akhir.toFixed(2) :
                                (d.kadar_air_akhir ? Number(d.kadar_air_akhir).toFixed(2) : '-');

                            if (triggeringButton) $(triggeringButton).focus();
                            localStorage.removeItem('active_process_id');

                            showNotification(
                                'success',
                                'Proses Pengeringan Diselesaikan',
                                `Durasi: ${(durasi != null) ? (Math.floor(durasi / 60) + ' jam ' + (durasi % 60) + ' menit') : '-'} dengan Kadar air akhir: ${kadarAkhir}%`
                            );

                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showNotification(
                                'success',
                                'Proses Pengeringan Diselesaikan',
                                `Durasi: ${(durasi != null) ? (Math.floor(durasi / 60) + ' jam ' + (durasi % 60) + ' menit') : '-'} dengan Kadar air akhir: ${kadarAkhir}%`
                            );
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                            // showNotification('error', 'Gagal Menyelesaikan', data?.error || 'Kesalahan server.');
                        }

                    } catch (err) {
                        console.error('Complete process error:', err);
                        showNotification('error', 'Terjadi Kesalahan', err.message);
                        if (err.message.includes('Unauthorized')) {
                            setTimeout(() => {
                                window.location.href = '{{ route('login') }}';
                            }, 2000);
                        }
                    }
                }

            });
        })(jQuery.noConflict(true));
    </script>

    {{-- Modal lama di-comment --}}

    <script>
        // Konfigurasi
        const sanctumToken = "{{ session('sanctum_token') ?? '' }}";
        const baseUrl = "{{ config('services.api.base_url') }}";
        const mlServerUrl = "http://192.168.43.142:5000";
        const userId = {{ auth()->id() ?? 'null' }};
        const POLLING_INTERVAL = 5000;
        const INITIAL_POLLING_INTERVAL = 3000;
        const MAX_RETRIES = 3;

        // Variabel global
        let sensorInterval = null;
        let statusText, kadarAirText, suhuGabahText, suhuRuanganText, suhuPembakaranText, durasiText, toggleButton,
            suhuGabahInput, suhuRuanganInput, kadarAirGabahInput, suhuPembakaranInput;
        let sensorDataByDevice = {};
        let initialData = {
            kadar_air_gabah: 0,
            suhu_gabah: 0,
            suhu_ruangan: 0,
            suhu_pembakaran: 0,
            durasi_rekomendasi: 0,
            kadar_air_target: 14
        };

        const formatDuration = (minutes) => {
            if (isNaN(minutes) || minutes <= 0) return '0 menit';
            const tot = parseFloat(minutes);
            const h = Math.floor(tot / 60),
                m = Math.floor(tot % 60);
            return h > 0 ? `${h} jam ${m} menit` : `${m} menit`;
        };

        // Fungsi untuk cek ketersediaan ML server
        async function checkMLServer() {
            try {
                console.log('🔌 Checking ML server:', mlServerUrl);

                // Coba endpoint health dulu
                const healthResponse = await fetch(`${mlServerUrl}/health`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    },
                    signal: AbortSignal.timeout(5000) // 5 detik timeout
                }).catch(() => null);

                if (healthResponse?.ok) {
                    const healthData = await healthResponse.json();
                    console.log('✅ ML health check passed:', healthData);
                    return true;
                }

                // Fallback ke root endpoint
                const rootResponse = await fetch(`${mlServerUrl}/`, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    },
                    signal: AbortSignal.timeout(3000)
                });

                console.log('📡 ML root check status:', rootResponse.status);
                return rootResponse.ok;

            } catch (err) {
                console.error('❌ ML server check failed:', err.name, err.message);
                return false;
            }
        }

        // Fungsi untuk mengambil daftar dryer dari API /bed-dryers (GLOBAL)
        async function fetchGlobalDryers() {
            const userId = {{ auth()->id() }};
            const dryerSelect = document.getElementById('global_dryer_id');

            if (!dryerSelect) {
                console.warn('Element #global_dryer_id tidak ditemukan');
                return;
            }

            // Loading state
            dryerSelect.innerHTML = '<option value="" disabled selected>-- Memuat Bed Dryer --</option>';
            dryerSelect.disabled = true;

            try {
                const url = `${baseUrl}/bed-dryers?user_id=${userId}`;
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

                // Kosongkan dan isi dropdown
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

                // Auto-select dryer_id yang tersimpan
                const savedDryerId = localStorage.getItem('selected_dryer_id');
                const savedOption = Array.from(dryerSelect.options).find(opt => opt.value == savedDryerId);

                if (savedOption) {
                    dryerSelect.value = savedDryerId;
                    updateGlobalDryerId(); // Auto-update display
                    console.log(`✅ Auto-selected saved dryer: ${savedDryerId}`);
                } else if (dryers.length > 0) {
                    // Pilih yang pertama jika tidak ada yang tersimpan
                    dryerSelect.value = dryers[0].dryer_id;
                    updateGlobalDryerId();
                    console.log(`✅ Auto-selected first dryer: ${dryers[0].dryer_id}`);
                }

                dryerSelect.disabled = false;
                console.log(`Loaded ${dryers.length} dryers`);

            } catch (err) {
                console.error('Error fetching global dryers:', err);
                dryerSelect.innerHTML = '<option value="" disabled>Gagal memuat bed dryer</option>';
                dryerSelect.disabled = false;
                showNotification(`Gagal memuat daftar dryer: ${err.message}`, 'error');
            }
        }

        // Fungsi untuk update dryer_id global
        window.updateGlobalDryerId = function() {
            const dryerSelect = document.getElementById('global_dryer_id');
            const statusDryerInfo = document.getElementById('statusDryerInfo');
            const currentDryerDisplay = document.getElementById('currentDryerDisplay');
            const dryerLoadingIcon = document.getElementById('dryerLoadingIcon');

            if (!dryerSelect || !statusDryerInfo || !currentDryerDisplay) {
                console.warn('Required elements not found');
                return;
            }

            const dryerId = dryerSelect.value;
            const selectedOption = dryerSelect.options[dryerSelect.selectedIndex];

            if (dryerId) {
                // Show loading
                dryerLoadingIcon.style.display = 'inline';
                statusDryerInfo.style.display = 'inline-flex';
                currentDryerDisplay.textContent = 'Memuat...';
                dryerSelect.classList.add('dryer-selected');

                // Save to localStorage
                localStorage.setItem('selected_dryer_id', dryerId);

                // Update display dengan data dari option (instant)
                if (selectedOption) {
                    const dryerName = selectedOption.dataset.dryerName || `Bed Dryer ${dryerId}`;
                    const warehouseName = selectedOption.dataset.warehouseName || 'Gudang Utama';
                    const displayText = `${dryerName} (${warehouseName})`;

                    // Update instant display
                    currentDryerDisplay.textContent = displayText;
                    dryerLoadingIcon.style.display = 'none';

                    console.log(`✅ Instant display updated: ${displayText}`);
                }

                // Trigger sensor data dan sidebar update
                fetchSensorData(null);
                if (window.updateSidebar) window.updateSidebar();

                // Success notification
                // if (selectedOption) {
                //     showNotification(
                //         'Bed Dryer Dipilih',
                //         selectedOption.textContent,
                //         'success',
                //         3000
                //     );
                // }

                console.log(`✅ Dryer selected: ${dryerId}`);

            } else {
                // Reset state
                localStorage.removeItem('selected_dryer_id');
                statusDryerInfo.style.display = 'none';
                dryerSelect.classList.remove('dryer-selected');
                resetUI();

                console.log('❌ No dryer selected');
                showNotification('Pilih Bed Dryer', 'Silakan pilih bed dryer untuk melihat data.', 'bg-warning');
            }
        };

        // Modifikasi fetchSensorData untuk selalu menggunakan dryer_id
        async function fetchSensorData(processId = null, retries = MAX_RETRIES) {
            const userId = {{ auth()->id() }};
            const dryerId = localStorage.getItem('selected_dryer_id') || '';
            let url = `${baseUrl}/get_sensor/realtime?user_id=${userId}`;
            if (processId) url += `&process_id=${processId}`;
            if (dryerId) url += `&dryer_id=${dryerId}`; // Selalu sertakan dryer_id jika ada

            try {
                const response = await fetch(url, {
                    headers: {
                        'Authorization': `Bearer ${sanctumToken}`,
                        'Accept': 'application/json'
                    }
                });
                if (!response.ok) {
                    const err = await response.json().catch(() => ({}));
                    throw new Error(err.error || `HTTP ${response.status}: ${response.statusText}`);
                }

                const data = await response.json();

                // Reset sensorDataByDevice untuk menghindari data lama dari dryer lain
                sensorDataByDevice = {};

                if (data.sensors && data.sensors.data) {
                    data.sensors.data.forEach(sensor => {
                        // Pastikan data sensor sesuai dengan dryer_id
                        if (dryerId && sensor.dryer_id !== dryerId) return; // Skip jika dryer_id tidak cocok
                        sensorDataByDevice[sensor.device_name] = {
                            kadar_air_gabah: parseFloat(sensor.kadar_air_gabah) || 0,
                            suhu_gabah: parseFloat(sensor.suhu_gabah) || 0,
                            suhu_ruangan: parseFloat(sensor.suhu_ruangan) || 0,
                            suhu_pembakaran: parseFloat(sensor.suhu_pembakaran) || 0,
                            timestamp: sensor.timestamp
                        };
                    });
                }

                // Perbarui status pengaduk
                if (data.sensors && "latest_stirrer_status" in data.sensors) {
                    const statusVal = data.sensors.latest_stirrer_status;
                    const elText = document.getElementById("statusPengadukText");
                    const elIcon = document.querySelector("#cardPengaduk i");

                    const statusText = (v) =>
                        (v === 1 || v === true || v === "Aktif") ? "Aktif" :
                        (v === 0 || v === false || v === "Nonaktif") ? "Nonaktif" : "-";

                    elText.innerText = statusText(statusVal);
                    if (statusVal === 1 || statusVal === true || statusVal === "Aktif") {
                        elIcon.classList.add("fa-spin");
                    } else {
                        elIcon.classList.remove("fa-spin");
                    }
                }

                updateUI(data);
                updateModalForm(data.sensors);
                return data;

            } catch (err) {
                if (retries > 0) {
                    await new Promise(r => setTimeout(r, 2000));
                    return fetchSensorData(processId, retries - 1);
                }
                showNotification(`Gagal memuat data sensor: ${err.message}`, 'bg-red-500');
                return {
                    sensors: {
                        data: [],
                        avg_grain_moisture: 0,
                        avg_grain_temperature: 0,
                        avg_room_temperature: 0,
                        avg_combustion_temperature: null,
                        latest_stirrer_status: null
                    },
                    drying_process: null
                };
            }
        }

        // Perbarui startSensorMonitoring untuk menggunakan dryer_id
        function startSensorMonitoring(processId) {
            if (sensorInterval) clearInterval(sensorInterval);
            sensorInterval = setInterval(() => {
                fetchSensorData(processId).then(data => {
                    const sensors = data.sensors || {};
                    const dryingProcess = data.drying_process;
                    if (dryingProcess && dryingProcess.status === 'ongoing' && sensors
                        .target_moisture_achieved) {
                        completeProcess(dryingProcess.process_id);
                        clearInterval(sensorInterval);
                        sensorInterval = null;
                    }
                }).catch(() => {});
            }, POLLING_INTERVAL);
        }

        // Panggil fetchDryers saat halaman dimuat
        document.addEventListener('DOMContentLoaded', () => {
            fetchGlobalDryers();

            console.log('🚀 Starting auto-status polling...');
            setInterval(() => {
                const currentDryerId = localStorage.getItem('selected_dryer_id');
                if (currentDryerId) {
                    fetchSensorData(null).then(data => {
                        console.log('📡 Status poll completed');
                    }).catch(err => {
                        console.error('❌ Status poll error:', err);
                    });
                    // ✅ PERBAIKAN: Juga update sidebar
                    window.updateSidebar();
                }
            }, 5000);
        });

        function updateUI(data) {
            const dryingProcess = data.drying_process;
            const sensors = data.sensors || {};

            console.log('🔍 UI Update Debug:', {
                hasProcess: !!dryingProcess,
                processStatus: dryingProcess?.status,
                currentUserId: {{ auth()->id() }},
                processUserId: dryingProcess?.user_id,
                currentDryerId: localStorage.getItem('selected_dryer_id'),
                processDryerId: dryingProcess?.dryer_id,
                isValid: dryingProcess &&
                    dryingProcess.status === 'ongoing' &&
                    // ✅ PERBAIKAN: Validasi user_id lebih longgar
                    (!dryingProcess.user_id || dryingProcess.user_id === {{ auth()->id() }}) &&
                    (!localStorage.getItem('selected_dryer_id') || String(dryingProcess.dryer_id) === String(
                        localStorage.getItem('selected_dryer_id')))
            });

            // ✅ SELALU UPDATE NILAI SENSOR (bahkan saat nonaktif)
            if (kadarAirText) {
                kadarAirText.innerText = (typeof sensors.avg_grain_moisture === 'number' && sensors.avg_grain_moisture >
                        0) ?
                    `${sensors.avg_grain_moisture.toFixed(2)}%` : '0.00%';
            }
            if (suhuGabahText) {
                suhuGabahText.innerText = (typeof sensors.avg_grain_temperature === 'number' && sensors
                        .avg_grain_temperature > 0) ?
                    `${sensors.avg_grain_temperature.toFixed(2)}°C` : '0.00°C';
            }
            if (suhuRuanganText) {
                suhuRuanganText.innerText = (typeof sensors.avg_room_temperature === 'number' && sensors
                        .avg_room_temperature > 0) ?
                    `${sensors.avg_room_temperature.toFixed(2)}°C` : '0.00°C';
            }
            if (suhuPembakaranText) {
                suhuPembakaranText.innerText = (typeof sensors.avg_combustion_temperature === 'number' && sensors
                        .avg_combustion_temperature > 0) ?
                    `${sensors.avg_combustion_temperature.toFixed(2)}°C` :
                    (sensors.avg_combustion_temperature === null ? 'Data tidak tersedia' : '0.00°C');
            }

            // Update status pengaduk
            const statusPengadukEl = document.getElementById('statusPengadukText');
            const pengadukIcon = document.querySelector('#cardPengaduk i');
            if (statusPengadukEl && pengadukIcon) {
                const statusVal = sensors.latest_stirrer_status;
                const statusStr = (statusVal === 1 || statusVal === true || statusVal === 'Aktif') ? 'Aktif' : 'Nonaktif';
                statusPengadukEl.innerText = statusStr;
                if (statusStr === 'Aktif') {
                    pengadukIcon.classList.add('fa-spin');
                } else {
                    pengadukIcon.classList.remove('fa-spin');
                }
            }

            // CEK APAKAH ADA PROSES ONGOING YANG VALID
            const dryerId = localStorage.getItem('selected_dryer_id') || '';
            const currentUserId = {{ auth()->id() }};
            // ✅ PERBAIKAN: Validasi user_id opsional
            const isValidOngoingProcess = dryingProcess &&
                dryingProcess.status === 'ongoing' &&
                // Jika user_id tidak ada atau cocok dengan current user
                (!dryingProcess.user_id || dryingProcess.user_id === currentUserId) &&
                (!dryerId || String(dryingProcess.dryer_id) === String(dryerId));

            if (!statusText || !toggleButton || !durasiText) {
                console.warn('⚠️ UI elements not found');
                return;
            }

            if (isValidOngoingProcess) {
                // ✅ PROSES ONGOING VALID - UI AKTIF
                console.log('✅ DETECTED VALID ONGOING PROCESS - SETTING UI TO AKTIF');

                statusText.innerText = 'Aktif';
                // toggleButton.innerText = 'STOP';
                // toggleButton.removeAttribute('data-bs-toggle');
                // toggleButton.removeAttribute('data-bs-target');
                // toggleButton.onclick = () => showConfirmStopModal(dryingProcess.process_id);

                // Update toggle button functionality
                toggleButton.innerText = 'STOP';
                toggleButton.removeAttribute('data-bs-toggle');
                toggleButton.removeAttribute('data-bs-target');

                // Set onclick handler dengan processId yang valid
                toggleButton.onclick = function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    showConfirmStopModal(dryingProcess.process_id);
                };

                // Update durasi dari process
                if (dryingProcess.durasi_rekomendasi && dryingProcess.durasi_rekomendasi > 0) {
                    durasiText.innerText = formatDuration(dryingProcess.durasi_rekomendasi);
                } else {
                    durasiText.innerText = '0 menit';
                }

                // Start monitoring untuk auto-complete
                if (!sensorInterval) {
                    startSensorMonitoring(dryingProcess.process_id);
                }

                // Simpan process_id
                localStorage.setItem('active_process_id', String(dryingProcess.process_id));

            } else {
                // ❌ TIDAK ADA PROSES VALID - UI NONAKTIF
                console.log('❌ No valid ongoing process - UI Nonaktif');

                statusText.innerText = 'Nonaktif';
                toggleButton.innerText = 'START';
                toggleButton.setAttribute('data-bs-toggle', 'modal');
                toggleButton.setAttribute('data-bs-target', '#tambahDataModal');
                toggleButton.onclick = null;
                durasiText.innerText = '0 menit';

                // Stop monitoring
                if (sensorInterval) {
                    clearInterval(sensorInterval);
                    sensorInterval = null;
                }

                // Bersihkan active_process_id jika tidak valid
                const savedPid = localStorage.getItem('active_process_id');
                if (savedPid && (!dryingProcess || dryingProcess.process_id !== parseInt(savedPid))) {
                    localStorage.removeItem('active_process_id');
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
            suhuPembakaranText.innerText = '0.00°C';
            durasiText.innerText = '0 menit';
            suhuGabahInput.value = '';
            suhuRuanganInput.value = '';
            kadarAirGabahInput.value = '';
            suhuPembakaranInput.value = '';
            initialData = {
                kadar_air_gabah: 0,
                suhu_gabah: 0,
                suhu_ruangan: 0,
                suhu_pembakaran: 0,
                durasi_rekomendasi: 0,
                kadar_air_target: 14
            };
            sensorDataByDevice = {};
            if (sensorInterval) {
                clearInterval(sensorInterval);
                sensorInterval = null;
            }
        }

        function updateModalForm(sensors) {
            suhuGabahInput.value = (typeof sensors?.avg_grain_temperature === 'number') ? sensors.avg_grain_temperature
                .toFixed(2) : '';
            suhuRuanganInput.value = (typeof sensors?.avg_room_temperature === 'number') ? sensors.avg_room_temperature
                .toFixed(2) : '';
            kadarAirGabahInput.value = (typeof sensors?.avg_grain_moisture === 'number') ? sensors.avg_grain_moisture
                .toFixed(2) : '';
            suhuPembakaranInput.value = (typeof sensors?.avg_combustion_temperature === 'number') ? sensors
                .avg_combustion_temperature.toFixed(2) : '';
        }

        function startSensorMonitoring(processId) {
            if (sensorInterval) clearInterval(sensorInterval);
            sensorInterval = setInterval(() => {
                fetchSensorData(processId).then(data => {
                    const sensors = data.sensors || {};
                    const dryingProcess = data.drying_process;
                    if (dryingProcess && dryingProcess.status === 'ongoing' && sensors
                        .target_moisture_achieved) {
                        completeProcess(dryingProcess.process_id);
                        clearInterval(sensorInterval);
                        sensorInterval = null;
                    }
                }).catch(() => {});
            }, POLLING_INTERVAL);
        }

        // function showConfirmStopModal(processId) {
        //     const confirmButton = document.getElementById('confirmStopButton');
        //     confirmButton.onclick = () => completeProcess(processId);
        //     const modal = new bootstrap.Modal(document.getElementById('confirmStopModal'));
        //     modal.show();
        // }

        function showConfirmStopModal(processId) {
            // Validasi processId
            if (!processId || isNaN(parseInt(processId))) {
                showNotification('Error', 'ID proses tidak valid', 'error');
                return;
            }

            // Set processId ke confirm button
            const confirmButton = document.getElementById('confirmStopButton');
            const modalElement = document.getElementById('confirmStopModal');

            if (!confirmButton || !modalElement) {
                showNotification('Error', 'Elemen modal tidak ditemukan', 'error');
                return;
            }

            // Hapus event listener sebelumnya untuk menghindari multiple bindings
            confirmButton.onclick = null;
            confirmButton.dataset.processId = processId;

            // Set onclick handler baru
            confirmButton.onclick = function() {
                // ✅ PERBAIKAN: Hapus onclick handler setelah di-set
                this.onclick = null;

                // ✅ PERBAIKAN: Dapatkan modal instance dan tutup modal
                const modal = bootstrap.Modal.getInstance(modalElement);
                if (modal) {
                    modal.hide();
                } else {
                    // Fallback: sembunyikan modal secara manual
                    modalElement.classList.remove('show');
                    modalElement.style.display = 'none';
                    document.querySelector('.modal-backdrop')?.remove();
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                }

                // ✅ PERBAIKAN: Delay sebentar untuk memastikan modal tertutup
                setTimeout(() => {
                    completeProcess(processId);
                }, 300);
            };

            // Show modal
            const modal = new bootstrap.Modal(modalElement, {
                backdrop: 'static', // Modal tidak bisa ditutup dengan klik backdrop
                keyboard: false // Modal tidak bisa ditutup dengan ESC
            });
            modal.show();
        }

        async function completeProcess(processId) {
            if (!sanctumToken) {
                showNotification('Autentikasi Gagal', 'Silakan login untuk melanjutkan.', 'error');
                setTimeout(() => {
                    window.location.href = '{{ route('login') }}';
                }, 2000);
                return;
            }

            // ✅ PERBAIKAN: Tampilkan loading notification
            const loadingNotification = showNotification(
                'Menyelesaikan Proses...',
                'Menyimpan data akhir proses pengeringan...',
                'info',
                10000
            );

            try {
                // 1. Validasi processId
                if (!processId || isNaN(parseInt(processId))) {
                    throw new Error('ID proses tidak valid');
                }

                console.log('🔄 Memulai proses complete untuk processId:', processId);

                // 2. Ambil data sensor terbaru untuk kadar_air_akhir
                let kadarAirAkhir = 14.0; // Default fallback
                try {
                    const sensorResponse = await fetch(
                        `${baseUrl}/get_sensor/realtime?user_id=${userId}&process_id=${processId}`, {
                            headers: {
                                'Authorization': `Bearer ${sanctumToken}`,
                                'Accept': 'application/json'
                            }
                        }
                    );

                    if (sensorResponse.ok) {
                        const sensorData = await sensorResponse.json();
                        if (sensorData.sensors && sensorData.sensors.avg_grain_moisture != null) {
                            const sensorKadar = parseFloat(sensorData.sensors.avg_grain_moisture);
                            if (!isNaN(sensorKadar) && sensorKadar >= 0 && sensorKadar <= 100) {
                                kadarAirAkhir = parseFloat(sensorKadar.toFixed(2));
                                console.log('✅ Sensor kadar air:', kadarAirAkhir);
                            }
                        }
                    } else {
                        console.warn('⚠️ Sensor API tidak tersedia, menggunakan default kadar air');
                    }
                } catch (sensorErr) {
                    console.warn('⚠️ Gagal ambil sensor data, menggunakan default 14.0%:', sensorErr);
                }

                // 3. Siapkan data untuk API - HANYA FIELDS YANG VALIDASI
                const completeData = {
                    kadar_air_akhir: parseFloat(kadarAirAkhir.toFixed(2)), // Pastikan numeric
                };

                console.log('📤 Data untuk API complete:', {
                    processId,
                    completeData,
                    kadarAirAkhir: typeof kadarAirAkhir,
                    isValidKadar: (typeof kadarAirAkhir === 'number' && kadarAirAkhir >= 0 && kadarAirAkhir <=
                        100)
                });

                // 4. Kirim request ke API
                const response = await fetch(
                    `${baseUrl}/drying-process/${processId}/complete`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(completeData)
                    }
                );

                console.log('📡 API Response Status:', response.status, response.statusText);

                // 5. Handle response dengan error handling yang lebih baik
                if (!response.ok) {
                    let errorMessage = `HTTP ${response.status}: `;

                    try {
                        const errorData = await response.json();
                        console.error('❌ API Error Data:', errorData);

                        // Extract error message yang lebih spesifik
                        if (errorData.error) {
                            errorMessage = errorData.error;
                        } else if (errorData.message) {
                            errorMessage = errorData.message;
                        } else if (errorData.errors) {
                            // Validation errors
                            const firstError = Object.values(errorData.errors)[0];
                            errorMessage = Array.isArray(firstError) ? firstError[0] : firstError;
                        } else {
                            errorMessage += response.statusText;
                        }

                    } catch (parseErr) {
                        console.error('❌ Failed to parse error response:', parseErr);
                        errorMessage += response.statusText || 'Unknown server error';
                    }

                    // ✅ PERBAIKAN: Tutup loading notification sebelum error
                    if (loadingNotification && loadingNotification._hideTimer) {
                        clearTimeout(loadingNotification._hideTimer);
                        loadingNotification.classList.remove('visible');
                    }

                    throw new Error(errorMessage);
                }

                // 6. Parse successful response
                let result;
                try {
                    result = await response.json();
                    console.log('✅ API Success Response:', result);
                } catch (parseErr) {
                    console.error('❌ Failed to parse success response:', parseErr);
                    throw new Error('Invalid response format from server');
                }

                // 7. Validasi response structure
                if (!result || result.success !== true) {
                    throw new Error(result?.message || result?.error || 'Respons API tidak valid');
                }

                // 8. ✅ PERBAIKAN: Tutup loading notification
                if (loadingNotification && loadingNotification._hideTimer) {
                    clearTimeout(loadingNotification._hideTimer);
                    loadingNotification.classList.remove('visible');
                }

                // 9. Update local storage
                localStorage.removeItem('active_process_id');

                // 10. Buat pesan sukses yang informatif
                const processData = result.data || {};
                let successMessage = `Proses pengeringan berhasil diselesaikan!`;

                // // Durasi
                // if (processData.durasi_terlaksana) {
                //     const totalMinutes = parseInt(processData.durasi_terlaksana);
                //     const hours = Math.floor(totalMinutes / 60);
                //     const minutes = totalMinutes % 60;
                //     const durasiText = hours > 0 ? `${hours} jam ${minutes} menit` : `${minutes} menit`;
                //     successMessage += `\n\n⏱️ Durasi Total: ${durasiText}`;
                // }

                // // Kadar air akhir
                // if (processData.kadar_air_akhir !== null && processData.kadar_air_akhir !== undefined) {
                //     successMessage += `\n💧 Kadar Air Akhir: ${parseFloat(processData.kadar_air_akhir).toFixed(2)}%`;
                // }

                // // Status
                // if (processData.status) {
                //     successMessage += `\n\n📊 Status: ${processData.status.toUpperCase()}`;
                // }

                // // Timestamp selesai
                // if (processData.timestamp_selesai) {
                //     const selesaiDate = new Date(processData.timestamp_selesai);
                //     if (!isNaN(selesaiDate)) {
                //         successMessage += `\n\n📅 Selesai: ${selesaiDate.toLocaleString('id-ID', {
            //             year: 'numeric',
            //             month: 'long', 
            //             day: 'numeric',
            //             hour: '2-digit',
            //             minute: '2-digit'
            //         })}`;
                //     }
                // }

                // ✅ PERBAIKAN: Delay notifikasi sukses untuk memastikan modal tertutup
                setTimeout(() => {
                    // 11. Tampilkan notifikasi sukses dengan auto-reload
                    showNotification(
                        'Berhasil Diselesaikan',
                        successMessage,
                        'success',
                        5000, // Durasi notifikasi 5 detik
                        true // Auto reload setelah notifikasi hilang
                    );
                }, 500);

                // 12. ✅ PERBAIKAN: Update UI SEGERA setelah API success
                setTimeout(() => {
                    console.log('🔄 Updating UI after successful completion...');

                    // Reset status ke Nonaktif
                    if (statusText) {
                        statusText.innerText = 'Nonaktif';
                        statusText.style.color = '#ffffff'; // Reset warna
                    }

                    if (toggleButton) {
                        toggleButton.innerText = 'START';
                        toggleButton.classList.remove('btn-stop'); // Hapus class khusus stop
                        toggleButton.setAttribute('data-bs-toggle', 'modal');
                        toggleButton.setAttribute('data-bs-target', '#tambahDataModal');
                        toggleButton.onclick = null;
                        toggleButton.style.background = ''; // Reset style
                    }

                    // Reset sensor readings
                    if (kadarAirText) kadarAirText.innerText = '0.00%';
                    if (suhuGabahText) suhuGabahText.innerText = '0°C';
                    if (suhuRuanganText) suhuRuanganText.innerText = '0°C';
                    if (suhuPembakaranText) suhuPembakaranText.innerText = '0°C';
                    if (durasiText) durasiText.innerText = '0 menit';

                    // Stop monitoring
                    if (sensorInterval) {
                        clearInterval(sensorInterval);
                        sensorInterval = null;
                        console.log('⏹️ Sensor monitoring stopped');
                    }

                    // Update sidebar
                    if (window.updateSidebar) {
                        window.updateSidebar();
                        console.log('📋 Sidebar updated');
                    }

                    console.log('✅ UI updated successfully');
                }, 100); // Update UI segera setelah API success

                console.log('🎉 Complete process successful:', processData);

            } catch (err) {
                console.error('❌ Complete process error:', err);

                // ✅ PERBAIKAN: Tutup loading notification saat error
                if (loadingNotification && loadingNotification._hideTimer) {
                    clearTimeout(loadingNotification._hideTimer);
                    loadingNotification.classList.remove('visible');
                }

                // Handle specific error cases
                let errorTitle = 'Gagal Menyelesaikan Proses';
                let errorMessage = err.message || 'Terjadi kesalahan yang tidak diketahui';

                // Specific error handling
                if (err.message.includes('401') || err.message.includes('Unauthorized')) {
                    errorTitle = 'Sesi Login Berakhir';
                    errorMessage = 'Silakan login kembali.';
                    setTimeout(() => {
                        window.location.href = '{{ route('login') }}';
                    }, 2000);
                } else if (err.message.includes('404') || err.message.includes('tidak ditemukan')) {
                    errorTitle = 'Proses Tidak Ditemukan';
                    errorMessage = 'Proses yang dimaksud tidak ditemukan atau sudah dihapus.';
                } else if (err.message.includes('422') || err.message.includes('Validasi gagal')) {
                    errorTitle = 'Data Tidak Valid';
                    errorMessage = err.message;
                } else if (err.message.includes('400') || err.message.includes('status tidak valid')) {
                    errorTitle = 'Status Proses Tidak Valid';
                    errorMessage = 'Proses tidak dalam status berjalan.';
                } else if (err.message.includes('500') || err.message.includes('Internal Server Error')) {
                    errorTitle = 'Kesalahan Server';
                    errorMessage = 'Server mengalami masalah. Coba lagi dalam beberapa saat.';
                }

                // Tampilkan error notification
                showNotification(errorTitle, errorMessage, 'error', 6000);

                // ✅ PERBAIKAN: Re-enable monitoring jika masih ada proses ongoing
                const savedPid = localStorage.getItem('active_process_id');
                if (savedPid) {
                    setTimeout(() => {
                        fetchSensorData(savedPid).catch(err => console.warn('Failed to resume monitoring:',
                            err));
                        if (window.updateSidebar) window.updateSidebar();
                    }, 2000);
                }
            }
        }

        function handleCardClick() {
            /* dipertahankan, tidak digunakan */
        }

        function closeModal() {
            document.getElementById('modal')?.classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            statusText = document.getElementById('statusText');
            kadarAirText = document.getElementById('kadarAirText');
            suhuGabahText = document.getElementById('suhuGabahText');
            suhuRuanganText = document.getElementById('suhuRuanganText');
            suhuPembakaranText = document.getElementById('suhuPembakaranText');
            durasiText = document.getElementById('durasiText');
            toggleButton = document.getElementById('toggleButton');
            suhuGabahInput = document.getElementById('suhu_gabah');
            suhuRuanganInput = document.getElementById('suhu_ruangan');
            kadarAirGabahInput = document.getElementById('kadar_air_gabah');
            suhuPembakaranInput = document.getElementById('suhu_pembakaran');

            fetchGlobalDryers().then(() => {
                console.log('Dryers loaded');

                // Auto-select saved dryer
                const savedDryerId = localStorage.getItem('selected_dryer_id');
                const globalDryerSelect = document.getElementById('global_dryer_id');

                if (savedDryerId && globalDryerSelect && globalDryerSelect.value !== savedDryerId) {
                    console.log('Auto-selecting saved dryer:', savedDryerId);
                    globalDryerSelect.value = savedDryerId;
                    updateGlobalDryerId();
                }

                // ✅ PERBAIKAN: Initial call ke global functions
                if (savedDryerId) {
                    fetchSensorData(null);
                    window.updateSidebar(); // Sekarang global
                } else {
                    console.log('No saved dryer, waiting for user selection');
                    showNotification('Pilih Bed Dryer',
                        'Silakan pilih bed dryer untuk melihat data sensor.', 'bg-info');
                }
            }).catch(err => {
                console.error('Failed to load dryers:', err);
                showNotification('Gagal Memuat Bed Dryer', err.message, 'bg-red-500');
            });

            // Initial polling untuk sensor
            let initialPollInterval = setInterval(() => {
                const savedDryerId = localStorage.getItem('selected_dryer_id');
                if (savedDryerId) {
                    fetchSensorData(null).then(data => {
                        if (data.sensors && typeof data.sensors.avg_combustion_temperature ===
                            'number') {
                            clearInterval(initialPollInterval);
                            console.log('Initial sensor polling completed');
                        }
                    });
                }
            }, 3000);

            // Event listener untuk modal
            const modalElement = document.getElementById('tambahDataModal');
            if (modalElement) {
                modalElement.addEventListener('show.bs.modal', () => {
                    const dryerId = localStorage.getItem('selected_dryer_id');
                    if (!dryerId) {
                        showNotification('Pilih Bed Dryer Dulu',
                            'Form prediksi memerlukan bed dryer yang dipilih.', 'bg-warning');
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        if (modal) modal.hide();
                    } else {
                        fetchSensorData(null);
                    }
                });
            }

            console.log('App initialization completed');
        });

        // === SUBMIT PREDIKSI ===
        // === SUBMIT PREDIKSI - DENGAN VALIDASI SENSOR NILAI 0 ===
        document.getElementById('predictForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            // UI elements
            const predictButton = document.getElementById('predictButton');
            const predictButtonText = document.getElementById('predictButtonText');
            const predictButtonLoading = document.getElementById('predictButtonLoading');
            const modalElement = document.getElementById('tambahDataModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            const errorMessageDiv = document.getElementById('errorMessage');

            // Reset error display
            if (errorMessageDiv) {
                errorMessageDiv.style.display = 'none';
                errorMessageDiv.innerHTML = '';
            }

            try {
                // 1. Get form input values
                const grainTypeId = parseInt(document.getElementById('jenis_gabah').value);
                const beratGabah = parseFloat(document.getElementById('berat_gabah').value);
                const kadarAirTarget = parseFloat(document.getElementById('kadar_air_target').value);
                const dryerId = localStorage.getItem('selected_dryer_id');

                console.log('📋 Input values:', {
                    grainTypeId,
                    beratGabah,
                    kadarAirTarget,
                    dryerId
                });

                // 2. Basic validation
                if (!dryerId) {
                    showSensorError('Pilih Bed Dryer Terlebih Dahulu',
                        'Form prediksi memerlukan bed dryer yang dipilih.', 'warning');
                    throw new Error('No dryer selected');
                }

                if (isNaN(grainTypeId) || !grainTypeId) {
                    showSensorError('Pilih Jenis Gabah', 'Jenis gabah harus dipilih dari dropdown.', 'warning');
                    throw new Error('Jenis gabah harus dipilih');
                }

                if (isNaN(beratGabah) || beratGabah < 0.1) {
                    showSensorError('Berat Gabah Tidak Valid', 'Berat gabah harus minimal 0.1 kg.', 'warning');
                    throw new Error('Berat gabah minimal 0.1 kg');
                }

                if (isNaN(kadarAirTarget) || kadarAirTarget < 0 || kadarAirTarget > 100) {
                    showSensorError('Target Kadar Air Tidak Valid', 'Target kadar air harus antara 0-100%.',
                        'warning');
                    throw new Error('Target kadar air 0-100%');
                }

                if (!sanctumToken) {
                    showNotification('Anda harus login untuk menyimpan data prediksi.', 'bg-red-500');
                    setTimeout(() => window.location.href = '{{ route('login') }}', 2000);
                    throw new Error('No sanctum token');
                }

                // 3. Show loading state
                predictButton.disabled = true;
                predictButtonText.classList.add('hidden');
                predictButtonLoading.classList.remove('hidden');

                console.log('📡 Fetching sensor data...');

                // 4. Fetch sensor data
                const sensorData = await fetchSensorData(null);
                console.log('📊 Sensor data received:', sensorData);

                if (!sensorData || !sensorData.sensors) {
                    showSensorError('Sensor Tidak Tersedia',
                        'Gagal mengambil data sensor. Pastikan bed dryer terhubung.', 'error');
                    throw new Error('No sensor data');
                }

                const s = sensorData.sensors;

                // 5. Extract dan validasi sensor values
                const sensorValues = {
                    kadar_air_gabah: typeof s.avg_grain_moisture === 'number' ? parseFloat(s
                        .avg_grain_moisture.toFixed(2)) : null,
                    suhu_gabah: typeof s.avg_grain_temperature === 'number' ? parseFloat(s
                        .avg_grain_temperature.toFixed(2)) : null,
                    suhu_ruangan: typeof s.avg_room_temperature === 'number' ? parseFloat(s
                        .avg_room_temperature.toFixed(2)) : null,
                    suhu_pembakaran: s.avg_combustion_temperature !== null && typeof s
                        .avg_combustion_temperature === 'number' ?
                        parseFloat(s.avg_combustion_temperature.toFixed(2)) :
                        null
                };

                console.log('🔍 Sensor values extracted:', sensorValues);

                // 6. ✅ PERBAIKAN: Validasi sensor tidak boleh 0
                const requiredSensors = {
                    'kadar_air_gabah': {
                        name: 'Kadar Air Gabah',
                        min: 0.1,
                        max: 100
                    },
                    'suhu_gabah': {
                        name: 'Suhu Gabah',
                        min: 10,
                        max: 80
                    },
                    'suhu_ruangan': {
                        name: 'Suhu Ruangan',
                        min: 15,
                        max: 40
                    }
                };

                const invalidSensors = [];

                for (const [key, config] of Object.entries(requiredSensors)) {
                    const value = sensorValues[key];
                    if (value === null || value === 0 || value < config.min || value > config.max) {
                        invalidSensors.push(`${config.name} (${value || 'kosong'})`);
                    }
                }

                if (invalidSensors.length > 0) {
                    const errorMsg =
                        `Sensor berikut tidak valid atau bernilai 0:\n• ${invalidSensors.join('\n• ')}`;
                    showSensorError('Data Sensor Tidak Valid', errorMsg, 'warning');
                    throw new Error('Data sensor bernilai nol');
                }

                // 7. ✅ PERBAIKAN: Validasi suhu_pembakaran (opsional tapi harus > 0 jika ada)
                if (sensorValues.suhu_pembakaran !== null && sensorValues.suhu_pembakaran <= 0) {
                    console.warn('⚠️ Suhu pembakaran <= 0, menggunakan nilai default');
                    sensorValues.suhu_pembakaran = null;
                }

                // 8. Buat payload untuk ML server
                const payloadForFlask = {
                    grain_type_id: String(grainTypeId),
                    dryer_id: String(dryerId),
                    kadar_air_target: String(kadarAirTarget),
                    berat_gabah: String(beratGabah),
                    kadar_air_gabah: String(sensorValues.kadar_air_gabah),
                    suhu_gabah: String(sensorValues.suhu_gabah),
                    suhu_ruangan: String(sensorValues.suhu_ruangan),
                    suhu_pembakaran: sensorValues.suhu_pembakaran ? String(sensorValues.suhu_pembakaran) :
                        '0.00',
                    user_id: String({{ auth()->id() }})
                };

                console.log('🚀 Payload for ML server:', payloadForFlask);

                // 9. Cek koneksi ML server
                const mlAvailable = await checkMLServer();
                if (!mlAvailable) {
                    showSensorError('Server Prediksi Offline',
                        'Server ML sedang tidak tersedia. Coba lagi nanti.', 'error');
                    throw new Error('ML server unavailable');
                }

                // 10. Kirim ke ML server
                const controller = new AbortController();
                const timeoutId = setTimeout(() => controller.abort(), 30000);

                console.log('🌐 Sending request to ML server...');
                const resp = await fetch(`${mlServerUrl}/`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payloadForFlask),
                    mode: 'cors',
                    signal: controller.signal
                });
                clearTimeout(timeoutId);

                console.log('📡 ML server response status:', resp.status);

                if (!resp.ok) {
                    const errorText = await resp.text();
                    console.error('❌ ML server error:', errorText);
                    showSensorError('Server Prediksi Error',
                        `HTTP ${resp.status}: ${errorText.substring(0, 100)}`, 'error');
                    throw new Error(`ML server error: ${resp.status}`);
                }

                let result;
                try {
                    result = await resp.json();
                    console.log('✅ ML server response:', result);
                } catch (parseErr) {
                    console.error('❌ ML response parse error:', parseErr);
                    const rawText = await resp.text();
                    showSensorError('Respons Server Tidak Valid', `Error parsing: ${rawText.substring(0, 100)}`,
                        'error');
                    throw new Error(`Invalid ML response: ${parseErr.message}`);
                }

                // 11. Validasi ML response
                const processId = result.process_id ? parseInt(result.process_id) : null;
                let durasiMenit = null;

                if (typeof result.durasi_rekomendasi === 'number') {
                    durasiMenit = result.durasi_rekomendasi;
                } else if (typeof result.durasi_rekomendasi === 'string') {
                    durasiMenit = parseFloat(result.durasi_rekomendasi);
                }

                console.log('📊 ML result validation:', {
                    processId,
                    durasiMenit
                });

                if (!processId || isNaN(processId) || processId <= 0) {
                    showSensorError('ID Proses Tidak Valid',
                        'ML server tidak mengembalikan ID proses yang valid.', 'error');
                    throw new Error('Invalid process ID from ML server');
                }

                if (!durasiMenit || isNaN(durasiMenit) || durasiMenit <= 0) {
                    showSensorError('Estimasi Durasi Tidak Valid',
                        'ML server tidak mengembalikan estimasi durasi yang valid.', 'error');
                    throw new Error('Invalid duration from ML server');
                }

                // 12. Update UI dan localStorage
                localStorage.setItem('active_process_id', String(processId));

                // Update status
                if (statusText) statusText.innerText = 'Aktif';

                // Update toggle button
                if (toggleButton) {
                    toggleButton.innerText = 'STOP';
                    toggleButton.removeAttribute('data-bs-toggle');
                    toggleButton.removeAttribute('data-bs-target');
                    toggleButton.onclick = () => showConfirmStopModal(processId);
                }

                // Update sensor displays
                if (kadarAirText) kadarAirText.innerText = `${sensorValues.kadar_air_gabah.toFixed(2)}%`;
                if (suhuGabahText) suhuGabahText.innerText = `${sensorValues.suhu_gabah.toFixed(2)}°C`;
                if (suhuRuanganText) suhuRuanganText.innerText = `${sensorValues.suhu_ruangan.toFixed(2)}°C`;
                if (suhuPembakaranText) {
                    suhuPembakaranText.innerText = sensorValues.suhu_pembakaran && sensorValues
                        .suhu_pembakaran > 0 ?
                        `${sensorValues.suhu_pembakaran.toFixed(2)}°C` :
                        'Data tidak tersedia';
                }
                if (durasiText) durasiText.innerText = formatDuration(durasiMenit);

                // Update initial data
                initialData = {
                    kadar_air_gabah: sensorValues.kadar_air_gabah,
                    suhu_gabah: sensorValues.suhu_gabah,
                    suhu_ruangan: sensorValues.suhu_ruangan,
                    suhu_pembakaran: sensorValues.suhu_pembakaran || 0,
                    durasi_rekomendasi: durasiMenit,
                    kadar_air_target: kadarAirTarget
                };

                // 13. Close modal dengan clean up
                if (modal) {
                    modal.hide();
                }
                setTimeout(() => {
                    modalElement.classList.remove('show');
                    modalElement.style.display = 'none';
                    document.querySelector('.modal-backdrop')?.remove();
                    document.body.classList.remove('modal-open');
                    document.body.style.overflow = '';
                    document.body.style.paddingRight = '';
                }, 300);

                // 14. Start monitoring
                startSensorMonitoring(processId);

                // 15. Success notification
                showNotification(
                    'Proses Pengeringan Dimulai',
                    `Estimasi selesai dalam ${formatDuration(durasiMenit)}`,
                    'success',
                    5000
                );

                // 16. Update sidebar
                if (window.updateSidebar) {
                    window.updateSidebar();
                }

                console.log('🎉 Proses pengeringan berhasil dimulai:', {
                    processId,
                    durasiMenit
                });

            } catch (err) {
                console.error('❌ Error (start via ML):', err);

                // Show error dengan detail sensor jika relevan
                if (err.message.includes('Invalid sensor data')) {
                    showSensorError(
                        'Data Sensor Tidak Valid',
                        err.message,
                        'warning'
                    );
                } else {
                    showNotification('Gagal Memulai Proses', err.message, 'error', 6000);
                }
            } finally {
                // Re-enable button
                predictButton.disabled = false;
                predictButtonText.classList.remove('hidden');
                predictButtonLoading.classList.add('hidden');
            }
        });

        // ✅ PERBAIKAN: Fungsi helper untuk error sensor
        function showSensorError(title, message, type = 'error') {
            const errorMessageDiv = document.getElementById('errorMessage');
            if (errorMessageDiv) {
                const alertClass = type === 'warning' ? 'alert-warning' : 'alert-danger';
                errorMessageDiv.innerHTML = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                <strong>${title}</strong>
                <div style="margin-top: 4px; font-size: 13px;">${message}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
                errorMessageDiv.style.display = 'block';
            }

            // Juga tampilkan notification
            showNotification(title, message, type === 'warning' ? 'info' : 'error', 6000);
        }
    </script>
@endsection

@extends('layout.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}

<style>
    .riwayat-card {
        background-color: rgb(127 144 190 / 16%);
        cursor: pointer;
        border: 1px solid #d0d4df;
        border-radius: 15px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 2px 6px rgba(30, 59, 138, 0.1);
    }
    .riwayat-card:hover { transform: scale(1.00); box-shadow: 0 6px 20px rgba(30, 59, 138, 0.25); }
    .btn-simpan { background-color: #1E3B8A; color: #fff; transition: background-color 0.2s ease; }
    .btn-simpan:hover { background-color: #163372; }
    .btn-clear { background-color: #6c757d; color: #fff; transition: background-color 0.2s ease; }
    .btn-clear:hover { background-color: #5a6268; }

    #notification {
            position: fixed;
            top: 10px;
            right: 10px;
            width: 300px;
            padding: 15px;
            border-radius: 5px;
            z-index: 9999;
            display: none;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
            opacity: 0;
            transition: opacity .5s
        }

        #notification.success {
            background: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745
        }

        #notification.error {
            background: #f8d7da;
            color: #721c24;
            border-left: 5px solid #dc3545
        }

        #notification.visible {
            display: flex;
            opacity: 1
        }

        #notificationTitle {
            font-weight: bold;
            margin-bottom: 5px
        }

        #notificationMessage {
            font-size: 14px
        }
</style>

<div class="container mt-4">
    <div id="notification" class="alert position-fixed top-0 end-0 m-4" style="display:none;">
    <div id="notificationTitle" style="font-weight: bold;"></div>
    <div id="notificationMessage"></div>
</div>

    <h2 class="fw-bold mb-3">Riwayat</h2>

    <div class="mb-3 d-flex align-items-end gap-2">
        <div>
            <label for="filterTanggal" class="form-label">Cari Tanggal:</label>
            <input style="background-color:#ffff;" type="date" id="filterTanggal" class="form-control" style="max-width:300px;">
        </div>
        <button id="clearFilter" class="btn btn-clear btn-sm" style="height:36px;">
            <i class="bi bi-x-circle me-1"></i> Reset
        </button>
    </div>

    <div class="mb-4 text-muted fw-semibold" id="currentDate">
        {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
    </div>

    <div class="row" id="riwayatContainer"></div>
</div>

<!-- Modal Validasi: hanya Berat Gabah Akhir -->
<div class="modal fade" id="modalValidasi" tabindex="-1" aria-labelledby="modalValidasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header text-white rounded-top-4">
                <h5 class="modal-title fw-semibold" style="color:#1E3B8A" id="modalValidasiLabel">
                    <i class="bi bi-patch-check-fill me-2"></i> Lengkapi Proses Pengeringan
                </h5>
                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formValidasi" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <input type="hidden" name="process_id" id="processIdInput">
                    <div class="mb-3">
                        <label for="beratAkhir" class="form-label fw-100">Berat Gabah Akhir (kg)</label>
                        <input type="number" class="form-control" id="beratAkhir" name="berat_akhir" step="0.01" min="0" required>
                        <div id="errorBeratAkhir" class="text-danger small mt-1"></div> <!-- Error di sini -->
                    </div>
                </div>
                <div class="modal-footer px-4 pb-4">
                    <button type="submit" class="btn btn-simpan">
                        <i class="bi bi-check-circle me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// ===============================
// Riwayat + Validasi (pakai notifikasi + auto-reload)
// ===============================
document.addEventListener('DOMContentLoaded', function () {
    // --- Element & Konfigurasi ---
    const modal = document.getElementById('modalValidasi');
    const inputProcessId = document.getElementById('processIdInput');
    const form = document.getElementById('formValidasi');
    const apiBaseUrl = "{{ config('services.api.base_url') }}";
    const token = "{{ session('sanctum_token') }}";
    const filterTanggalInput = document.getElementById('filterTanggal');
    const clearFilterButton = document.getElementById('clearFilter');
    const riwayatContainer = document.getElementById('riwayatContainer');

    // Set default filter ke hari ini
    filterTanggalInput.value = new Date().toISOString().split('T')[0];

    // Event: ubah tanggal -> fetch
    filterTanggalInput.addEventListener('change', fetchData);

    // Event: reset -> kembali ke hari ini & fetch
    clearFilterButton.addEventListener('click', function () {
        filterTanggalInput.value = new Date().toISOString().split('T')[0];
        fetchData();
    });

    // Load awal
    fetchData();

    // Saat modal dibuka: set action & process_id
    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const processId = button.getAttribute('data-process-id');
        inputProcessId.value = processId;
        form.action = `${apiBaseUrl}/validasi/${processId}`;
    });

    form.addEventListener('submit', async function (event) {
    event.preventDefault();

    // Kosongkan pesan error dulu
    document.getElementById('errorBeratAkhir').textContent = '';

    if (!token) {
        window.notify?.({
            title: 'Sesi berakhir',
            message: 'Sesi login tidak ditemukan. Kamu akan diarahkan ke halaman login.',
            type: 'error',
            duration: 3000
        });
        setTimeout(() => { window.location.href = '/login'; }, 3000);
        return;
    }

    const beratAkhirInput = document.getElementById('beratAkhir');
    const beratAkhir = parseFloat(beratAkhirInput.value);
    const processId = inputProcessId.value;

    // Ambil berat awal dari card (riwayatContainer)
    const beratAwalEl = document.querySelector(
        `.btn-validasi[data-process-id="${processId}"]`
    )?.closest('.card')?.querySelector('.bi-box-seam')?.parentElement?.nextElementSibling?.textContent;

    let beratAwal = null;
    if (beratAwalEl) {
        beratAwal = parseFloat(beratAwalEl.replace(/[^\d.]/g, '')); // Ambil angka saja
    }

    // Validasi di sisi client
    if (beratAwal !== null && beratAkhir > beratAwal) {
        document.getElementById('errorBeratAkhir').textContent =
            `Berat gabah akhir tidak boleh lebih dari ${beratAwal} kg.`;
        return;
    }

    const payload = {
        process_id: processId,
        berat_akhir: beratAkhir
    };

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        const result = await response.json().catch(() => ({}));

        if (!response.ok) {
            // Kalau dari backend ada error validasi berat
            if (result?.errors?.berat_akhir) {
                document.getElementById('errorBeratAkhir').textContent =
                    result.errors.berat_akhir.join(', ');
                return;
            }
            throw new Error(result?.error || result?.pesan || 'Kesalahan server tidak diketahui');
        }

        window.notify?.({
            title: 'Berhasil',
            message: 'Validasi berhasil disimpan!',
            type: 'success',
            duration: 2500,
            reload: true
        });

        fetchData();

        const modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance?.hide();
        form.reset();

    } catch (error) {
        window.notify?.({
            title: 'Gagal',
            message: `Gagal menyimpan validasi: ${error.message}`,
            type: 'error',
            duration: 4000
        });
    }
});

    // Ambil data riwayat (dengan filter tanggal)
    async function fetchData() {
        if (!token) {
            console.error('Token Sanctum tidak ditemukan');
            riwayatContainer.innerHTML = '<p class="text-danger">Sesi login tidak ditemukan. Silakan <a href="/login">login kembali</a>.</p>';
            window.notify?.({
                title: 'Sesi berakhir',
                message: 'Silakan login kembali.',
                type: 'error',
                duration: 3000
            });
            return;
        }

        riwayatContainer.innerHTML = '<p>Loading...</p>';

        const filterTanggal = filterTanggalInput.value;

        try {
            const url = `${apiBaseUrl}/riwayat-proses${filterTanggal ? `?filter_tanggal=${filterTanggal}` : ''}`;
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });

            if (!response.ok) throw new Error(`HTTP ${response.status}`);

            const result = await response.json();
            const data = result?.data || [];
            riwayatContainer.innerHTML = '';

            if (data.length === 0) {
                const formattedDate = filterTanggal
                    ? new Date(filterTanggal).toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })
                    : 'hari ini';
                riwayatContainer.innerHTML = `<p class="text-muted">Tidak ada data riwayat untuk ${formattedDate}.</p>`;
                return;
            }

            const colClass = data.length === 1 ? 'col-md-12' : (data.length === 2 ? 'col-md-6' : 'col-md-4');

            data.forEach(item => {
                // Status tervalidasi: berdasar adanya berat_gabah_akhir
                const isValidated = item.berat_gabah_akhir !== null && item.berat_gabah_akhir !== '';

                // Waktu selesai (jam:menit:detik) + penanda hari jika beda hari
                let selesaiDisplay = item.timestamp_selesai?.split(' ')[1] ?? '-';
                let selesaiStyle = '';
                let selesaiTooltip = item.timestamp_selesai || '-';

                // Format tanggal mulai & selesai
                let tanggalMulaiFormatted = item.timestamp_mulai_mentah
                    ? new Date(item.timestamp_mulai_mentah).toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })
                    : '-';

                // let tanggalSelesaiFormatted = isValidated
                //     ? new Date(item.timestamp_selesai).toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })
                //     : '-';
                let tanggalSelesaiFormatted = item.timestamp_selesai
                    ? new Date(item.timestamp_selesai).toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' })
                    : '-';

                // Tambahan tanda +xh jika lintas hari
                if (isValidated && item.timestamp_mulai_mentah && item.timestamp_selesai) {
                    const startDate = new Date(item.timestamp_mulai_mentah);
                    const endDate = new Date(item.timestamp_selesai);
                    const timeDiff = endDate - startDate;
                    const dayDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                    if (dayDiff > 0) {
                        selesaiDisplay = `${selesaiDisplay}<span style="font-weight:900;">+${dayDiff}h</span>`;
                        selesaiStyle = 'text-decoration:underline;font-weight:900;margin-left:3px;';
                    }
                    selesaiTooltip = endDate.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });
                }

                const cardHtml = `
                    <div class="col-12 ${colClass} mb-4">
                        <div class="card riwayat-card" onclick="window.location.href='/riwayat/detail/${item.process_id}'">
                            <div class="card-body" style="padding:20px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-seedling me-2" style="color:#1E3B8A;font-size:20px;"></i>
                                        <span class="ms-2 fw-bold" style="letter-spacing:1px;font-size:16px;color:#1E3B8A;">
                                            ${item.nama_jenis ?? '-'}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        ${
                                            isValidated
                                            ? `<span class="fw-semibold d-flex align-items-center" style="color:rgb(49 164 119)">
                                                    <i class="fas fa-check-circle me-1"></i>
                                               </span>`
                                            : `<button class="btn btn-outline-primary btn-sm btn-validasi"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#modalValidasi"
                                                        data-process-id="${item.process_id}"
                                                        onclick="event.stopPropagation()">
                                                    <i class="bi bi-patch-check me-1"></i> Lengkapi
                                               </button>`
                                        }
                                        <span class="ms-2" style="font-size:24px;">&#8250;</span>
                                    </div>
                                </div>

                                <div class="mt-3 d-flex flex-wrap gap-3 text-muted" style="font-size:14px;">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-clock me-1"></i> Mulai: ${item.timestamp_mulai_mentah?.split(' ')[1] ?? '-'}
                                    </div>
                                    |
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-clock me-1"></i>
                                        Selesai:
                                        ${
                                            item.timestamp_selesai
                                            ? `<span class="selesai-time" data-bs-toggle="tooltip" data-bs-placement="top" 
                                                title="${selesaiTooltip}" style="${selesaiStyle}">${selesaiDisplay}</span>`
                                            : '-'
                                        }
                                    </div>
                                </div>

                                <div class="mt-3" style="font-size:14px;">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span><i class="bi bi-calendar me-2"></i> Tanggal Mulai:</span>
                                        <span style="font-weight:900;color:#1E3B8A;">${tanggalMulaiFormatted}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span><i class="bi bi-calendar-check me-2"></i> Tanggal Selesai:</span>
                                        <span style="font-weight:900;color:#1E3B8A;">${tanggalSelesaiFormatted}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span><i class="bi bi-box-seam me-2"></i> Berat Gabah Awal:</span>
                                        <span style="font-weight:900;color:#1E3B8A;">${item.berat_gabah_awal ?? '-'} kg</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span><i class="bi bi-box2-heart me-2"></i> Berat Gabah Akhir:</span>
                                        <span style="font-weight:900;color:#1E3B8A;">${item.berat_gabah_akhir ?? '-' } kg</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span><i class="bi bi-hourglass-split me-2"></i> Estimasi Durasi:</span>
                                        <span style="font-weight:900;color:#1E3B8A;">${item.durasi_rekomendasi ?? '-'}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span><i class="bi bi-stopwatch me-2"></i> Durasi Terlaksana:</span>
                                        <span style="font-weight:900;color:#1E3B8A;">${item.durasi_terlaksana ?? '-'}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                riwayatContainer.insertAdjacentHTML('beforeend', cardHtml);
            });

            // Aktifkan tooltip Bootstrap
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));

        } catch (error) {
            console.error('Error fetching data:', error);
            riwayatContainer.innerHTML = '<p class="text-danger">Gagal memuat data. Silakan <a href="/login">login kembali</a>.</p>';
            window.notify?.({
                title: 'Gagal memuat',
                message: 'Terjadi kendala saat memuat data riwayat.',
                type: 'error',
                duration: 3000
            });
        }
    }
});
</script>

@endsection

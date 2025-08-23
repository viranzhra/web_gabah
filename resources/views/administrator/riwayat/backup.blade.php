@extends('layout.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    .riwayat-card {
        background-color: rgb(127 144 190 / 16%);
        cursor: pointer;
        border: 1px solid #d0d4df;
        border-radius: 15px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        box-shadow: 0 2px 6px rgba(30, 59, 138, 0.1);
    }

    .riwayat-card:hover {
        transform: scale(1.00);
        box-shadow: 0 6px 20px rgba(30, 59, 138, 0.25);
    }

    .btn-simpan {
        background-color: #1E3B8A;
        color: #fff;
        transition: background-color 0.2s ease;
    }

    .btn-simpan:hover {
        background-color: #163372;
    }

    .btn-clear {
        background-color: #6c757d;
        color: #fff;
        transition: background-color 0.2s ease;
    }

    .btn-clear:hover {
        background-color: #5a6268;
    }
</style>

<div class="container mt-4">
    <h2 class="fw-bold mb-3">Riwayat</h2>

    <div class="mb-3 d-flex align-items-end gap-2">
        <div>
            <label for="filterTanggal" class="form-label">Cari Tanggal:</label>
            <input style="background-color: #ffff;" type="date" id="filterTanggal" class="form-control" style="max-width: 300px;">
        </div>
        <button id="clearFilter" class="btn btn-clear btn-sm" style="height: 36px;">
            <i class="bi bi-x-circle me-1"></i> Reset
        </button>
    </div>

    <div class="mb-4 text-muted fw-semibold" id="currentDate">
        {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
    </div>

    <div class="row" id="riwayatContainer"></div>
</div>

<!-- Modal Validasi -->
<div class="modal fade" id="modalValidasi" tabindex="-1" aria-labelledby="modalValidasiLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header text-white rounded-top-4">
                <h5 class="modal-title fw-semibold" style="color: #1E3B8A" id="modalValidasiLabel">
                    <i class="bi bi-patch-check-fill me-2"></i> Validasi Proses Pengeringan
                </h5>
                <button type="button" class="btn-close btn-close-black" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <form id="formValidasi" method="POST">
                @csrf
                <div class="modal-body px-4">
                    <input type="hidden" name="process_id" id="processIdInput">
                    <div class="mb-3">
                        <label for="tanggalSelesai" class="form-label fw-100">Tanggal Selesai</label>
                        <input type="datetime-local" class="form-control" id="tanggalSelesai" name="tanggal_selesai" required>
                    </div>
                    <div class="mb-3">
                        <label for="beratAkhir" class="form-label fw-100">Berat Gabah Akhir (kg)</label>
                        <input type="number" class="form-control" id="beratAkhir" name="berat_akhir" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="modal-footer px-4 pb-4">
                    <button type="submit" class="btn btn-simpan">
                        <i class="bi bi-check-circle me-1"></i> Simpan Validasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modalValidasi');
    const inputProcessId = document.getElementById('processIdInput');
    const form = document.getElementById('formValidasi');
    const apiBaseUrl = "{{ config('services.api.base_url') }}";
    const token = "{{ session('sanctum_token') }}";
    const filterTanggalInput = document.getElementById('filterTanggal');
    const clearFilterButton = document.getElementById('clearFilter');

    // Set default date to today
    filterTanggalInput.value = new Date().toISOString().split('T')[0];

    // Fetch data on date change
    filterTanggalInput.addEventListener('change', fetchData);

    // Clear filter and fetch all data
    clearFilterButton.addEventListener('click', function () {
        filterTanggalInput.value = new Date().toISOString().split('T')[0];
        fetchData();
    });

    fetchData();

    modal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const processId = button.getAttribute('data-process-id');
        inputProcessId.value = processId;
        form.action = `${apiBaseUrl}/validasi/${processId}`;
    });

    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        if (!token) {
            console.error('Token Sanctum tidak ditemukan');
            alert('Sesi login tidak ditemukan. Silakan login kembali.');
            return window.location.href = '/login';
        }

        let tanggalSelesai = document.getElementById('tanggalSelesai').value;
        if (tanggalSelesai && !tanggalSelesai.endsWith(':00')) {
            tanggalSelesai += ':00';
        }

        const payload = {
            process_id: inputProcessId.value,
            tanggal_selesai: tanggalSelesai,
            berat_akhir: document.getElementById('beratAkhir').value
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

            const result = await response.json();
            if (!response.ok) {
                const errorMessage = result.errors
                    ? Object.values(result.errors).flat().join(', ')
                    : result.error || result.pesan || 'Kesalahan server tidak diketahui';
                throw new Error(`HTTP error! Status: ${response.status}, Pesan: ${errorMessage}`);
            }

            alert('Validasi berhasil disimpan!');
            fetchData();
            modal.querySelector('.btn-close').click();
        } catch (error) {
            console.error('Error submitting validation:', error);
            alert(`Gagal menyimpan validasi: ${error.message}. Silakan coba lagi.`);
        }
    });

    async function fetchData() {
        const filterTanggal = filterTanggalInput.value;
        const riwayatContainer = document.getElementById('riwayatContainer');

        if (!token) {
            console.error('Token Sanctum tidak ditemukan');
            riwayatContainer.innerHTML = '<p class="text-danger">Sesi login tidak ditemukan. Silakan <a href="/login">login kembali</a>.</p>';
            return;
        }

        riwayatContainer.innerHTML = '<p>Loading...</p>';

        try {
            const response = await fetch(`${apiBaseUrl}/riwayat-proses${filterTanggal ? `?filter_tanggal=${filterTanggal}` : ''}`, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Authorization': `Bearer ${token}`
                }
            });

            if (!response.ok) throw new Error(`HTTP error! Status: ${response.status}`);

            const result = await response.json();
            const data = result.data || [];
            riwayatContainer.innerHTML = '';

            if (data.length === 0) {
                const formattedDate = filterTanggal ? new Date(filterTanggal).toLocaleDateString('id-ID', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                }) : 'hari ini';
                riwayatContainer.innerHTML = `<p class="text-muted">Tidak ada data riwayat untuk ${formattedDate}.</p>`;
                return;
            }

            const colClass = data.length === 1 ? 'col-md-12' : data.length === 2 ? 'col-md-6' : 'col-md-4';

            data.forEach(item => {
                const isValidated = item.durasi_aktual && item.durasi_aktual !== null && item.durasi_aktual !== '';
                // Calculate day difference for Selesai time
                let selesaiDisplay = item.timestamp_selesai?.split(' ')[1] ?? '-';
                let selesaiStyle = '';
                let selesaiTooltip = item.timestamp_selesai || '-';
                let tanggalMulaiFormatted = item.timestamp_mulai_mentah?.split(' ')[0] ?? '-';
                let tanggalSelesaiFormatted = isValidated ? (item.timestamp_selesai?.split(' ')[0] ?? '-') : '-';
                if (isValidated && item.timestamp_mulai_mentah && item.timestamp_selesai) {
                    const startDate = new Date(item.timestamp_mulai_mentah);
                    const endDate = new Date(item.timestamp_selesai);
                    const timeDiff = endDate - startDate;
                    const dayDiff = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                    if (dayDiff > 0) {
                        selesaiDisplay = `${selesaiDisplay}<span style="font-weight: 900;">+${dayDiff}h</span>`;
                        selesaiStyle = 'text-decoration: underline; font-weight: 900; margin-left: 3px;';
                    }
                    // Format tooltip date as "Hari, tanggal bulan tahun"
                    selesaiTooltip = endDate.toLocaleDateString('id-ID', {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    // Format Tanggal Mulai and Tanggal Selesai
                    tanggalMulaiFormatted = startDate.toLocaleDateString('id-ID', {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    });
                    tanggalSelesaiFormatted = isValidated ? endDate.toLocaleDateString('id-ID', {
                        weekday: 'long',
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    }) : '-';
                }

                const cardHtml = `
                    <div class="col-12 ${colClass} mb-4">
                        <div class="card riwayat-card" onclick="window.location.href='/riwayat/detail/${item.process_id}'">
                            <div class="card-body" style="padding: 20px;">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-seedling me-2" style="color: #1E3B8A; font-size: 20px;"></i>
                                        <span class="ms-2 fw-bold" style="letter-spacing: 1px; font-size: 16px; color: #1E3B8A">
                                            ${item.nama_jenis || '-'}
                                        </span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        ${
                                            isValidated
                                            ? `<span class="fw-semibold d-flex align-items-center" style="color: rgb(49 164 119)">
                                                    <i class="fas fa-check-circle me-1"></i> Tervalidasi
                                                </span>`
                                            : `<button class="btn btn-outline-primary btn-sm btn-validasi" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#modalValidasi"
                                                        data-process-id="${item.process_id}"
                                                        onclick="event.stopPropagation()">
                                                    <i class="bi bi-patch-check me-1"></i> Validasi
                                                </button>`
                                        }
                                        <span class="ms-2" style="font-size: 24px;">&#8250;</span>
                                    </div>
                                </div>
                                <div class="mt-3 d-flex flex-wrap gap-3 text-muted" style="font-size: 14px;">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-clock me-1"></i> Mulai: ${item.timestamp_mulai_mentah?.split(' ')[1] ?? '-'}
                                    </div>
                                    |
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-clock me-1"></i> 
                                        Selesai: 
                                        ${
                                            isValidated && item.timestamp_selesai
                                            ? `<span class="selesai-time" data-bs-toggle="tooltip" data-bs-placement="top" title="${selesaiTooltip}" style="${selesaiStyle}">${selesaiDisplay}</span>`
                                            : '-'
                                        }
                                    </div>
                                </div>
                                <div class="mt-3" style="font-size: 14px;">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span><i class="bi bi-calendar me-2"></i> Tanggal Mulai:</span>
                                        <span style="font-weight: 900; color: #1E3B8A;">${tanggalMulaiFormatted}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span><i class="bi bi-calendar-check me-2"></i> Tanggal Selesai:</span>
                                        <span style="font-weight: 900; color: #1E3B8A;">${tanggalSelesaiFormatted}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span><i class="bi bi-box-seam me-2"></i> Berat Gabah Awal:</span>
                                        <span style="font-weight: 900; color: #1E3B8A;">${item.berat_gabah_awal ?? '-'} kg</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span><i class="bi bi-box2-heart me-2"></i> Berat Gabah Akhir:</span>
                                        <span style="font-weight: 900; color: #1E3B8A;">${item.berat_gabah_akhir ?? '-'} kg</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span><i class="bi bi-hourglass-split me-2"></i> Estimasi Durasi:</span>
                                        <span style="font-weight: 900; color: #1E3B8A;">${item.durasi_rekomendasi ?? '-'}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span><i class="bi bi-stopwatch me-2"></i> Durasi Terlaksana:</span>
                                        <span style="font-weight: 900; color: #1E3B8A;">${item.durasi_terlaksana ?? '-'}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span><i class="bi bi-hourglass me-2"></i> Durasi Aktual:</span>
                                        <span style="font-weight: 900; color: #1E3B8A;">${item.durasi_aktual ?? '-'}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                riwayatContainer.insertAdjacentHTML('beforeend', cardHtml);
            });

            // Initialize Bootstrap tooltips
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            tooltipTriggerList.forEach(tooltipTriggerEl => {
                new bootstrap.Tooltip(tooltipTriggerEl);
            });
        } catch (error) {
            console.error('Error fetching data:', error);
            riwayatContainer.innerHTML = '<p class="text-danger">Gagal memuat data. Silakan <a href="/login">login kembali</a>.</p>';
        }
    }
});
</script>
@endsection
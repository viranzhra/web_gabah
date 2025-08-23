@extends('layout.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="container mt-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div class="d-flex align-items-center">
            <a href="{{ route('riwayat.index') }}" class="btn d-flex align-items-center justify-content-center"
                style="background-color: #1E3B8A; color: white; width: 30px; height: 35px; border-radius: 50px;">
                <i class="bi bi-arrow-left" style="font-size: 18px;"></i>
            </a>
            <h2 class="ms-3" style="font-weight: 600; color: #1E3B8A; margin: 0;">Detail Proses Pengeringan</h2>
        </div>
    </div>

    <div class="mb-3">
        <span class="fw-semibold" style="color: #1E3B8A; font-size: 18px;">Jenis Gabah:</span>
        <span style="color: #1E3B8A; font-size: 18px; font-weight: 800; letter-spacing: 1px;" id="jenisGabah"></span>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h5 style="font-size: 16px; margin-top: 20px;">Data Sensor</h5>
        <button id="toggleMoreBtn" class="btn btn-sm btn-outline-primary">Lihat Selengkapnya</button>
    </div>

    <div id="sensor-data"></div>
    <div id="extra-intervals" class="d-none"></div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const processId = '{{ $process_id }}';
    const apiBaseUrl = "{{ config('services.api.base_url') }}";
    const token = "{{ session('sanctum_token') }}";

    if (!token) {
        document.getElementById('sensor-data').innerHTML = '<p class="text-danger">Sesi login tidak ditemukan. Silakan <a href="/login">login kembali</a>.</p>';
        return;
    }

    fetch(`${apiBaseUrl}/sensor-detail/${processId}`, {
        headers: {
            'Accept': 'application/json',
            'Authorization': `Bearer ${token}`
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status !== 'success') {
            document.getElementById('sensor-data').innerHTML = '<p class="text-danger">Gagal memuat data sensor.</p>';
            return;
        }

        fetch(`${apiBaseUrl}/riwayat-proses?process_id=${processId}`, {
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            }
        })
        .then(response => response.json())
        .then(riwayatData => {
            if (riwayatData.status === 'success' && riwayatData.data.length > 0) {
                document.getElementById('jenisGabah').textContent = riwayatData.data[0].nama_jenis;
            }
        });

        const sensorDataContainer = document.getElementById('sensor-data');
        const extraIntervalsContainer = document.getElementById('extra-intervals');

        data.data.reverse().forEach((item, index) => {
            let kadarAirRata = '-';
            const tombakData = item.sensor_data.tombak;
            if (tombakData.length > 0) {
                const validKadarAir = tombakData
                    .filter(t => t.kadar_air_gabah !== '-' && !isNaN(t.kadar_air_gabah))
                    .map(t => parseFloat(t.kadar_air_gabah));
                kadarAirRata = validKadarAir.length > 0
                    ? (validKadarAir.reduce((a, b) => a + b, 0) / validKadarAir.length).toFixed(2) + ' %'
                    : '-';
            }

            const pembakaranData = item.sensor_data.pembakaran_pengaduk[0] || {
                suhu_pembakaran: '-',
                status_pengaduk: '-'
            };
            const tombak = item.sensor_data.tombak[0] || {
                suhu_ruangan: '-',
                kadar_air_gabah: '-',
                suhu_gabah: '-'
            };

            const timestamp = new Date(item.timestamp).toLocaleString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit' // <-- Perbaikan di sini
            });

            const collapseId = `collapseInterval${index + 1}`;
            const html = `
                <div class="card shadow-sm mb-3" style="background-color: rgb(127 144 190 / 16%); border: 1px solid #d0d4df; border-radius: 15px">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center toggle-header"
                            data-bs-toggle="collapse" href="#${collapseId}" role="button" aria-expanded="false"
                            aria-controls="${collapseId}" style="cursor: pointer;">
                            <div>
                                <h6 style="color: #1E3B8A; font-size: 17px; font-weight: 700 !important; margin-bottom: 12px;">
                                    Interval ${index + 1}</h6>
                                <div><i class="bi bi-droplet me-2"></i>Kadar Air Gabah (rata-rata): <span class="fw-bold">
                                    ${kadarAirRata}</span></div>
                            </div>
                            <i class="bi bi-chevron-right toggle-icon" style="font-size: 15px;"></i>
                        </div>
                        <div class="collapse mt-3" id="${collapseId}">
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="bi bi-clock-history me-2"></i>Timestamp:</span>
                                <span style="font-weight: 800; color: #1E3B8A">${timestamp}</span>
                            </div>
                            <h6 class="mt-3 mb-2" style="color: #1E3B8A; font-size: 17px; font-weight: 700 !important;">Pembakaran & Pengaduk</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="bi bi-fire me-2"></i>Suhu Pembakaran:</span>
                                <span style="font-weight: 800; color: #1E3B8A">${pembakaranData.suhu_pembakaran !== '-' ? pembakaranData.suhu_pembakaran + ' °C' : '-'}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="bi bi-repeat me-2"></i>Status Pengaduk:</span>
                                <span style="font-weight: 800; color: #1E3B8A">${pembakaranData.status_pengaduk}</span>
                            </div>
                            <h6 class="fw-bold mt-3 mb-2" style="color: #1E3B8A; font-size: 17px; font-weight: 700 !important;">Tombak 1</h6>
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="bi bi-thermometer-sun me-2"></i>Suhu Ruangan:</span>
                                <span style="font-weight: 800; color: #1E3B8A">${tombak.suhu_ruangan !== '-' ? tombak.suhu_ruangan + ' °C' : '-'}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span><i class="bi bi-droplet-half me-2"></i>Kadar Air Gabah:</span>
                                <span style="font-weight: 800; color: #1E3B8A">${tombak.kadar_air_gabah !== '-' ? tombak.kadar_air_gabah + ' %' : '-'}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span><i class="bi bi-thermometer-high me-2"></i>Suhu Gabah:</span>
                                <span style="font-weight: 800; color: #1E3B8A">${tombak.suhu_gabah !== '-' ? tombak.suhu_gabah + ' °C' : '-'}</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            const container = index < 3 ? sensorDataContainer : extraIntervalsContainer;
            container.insertAdjacentHTML('beforeend', html);
        });
    })
    .catch(error => {
        console.error('Error fetching sensor data:', error);
        document.getElementById('sensor-data').innerHTML = '<p class="text-danger">Gagal memuat data sensor.</p>';
    });

    document.addEventListener('show.bs.collapse', function(e) {
        const icon = document.querySelector(`[href="#${e.target.id}"] .toggle-icon`);
        if (icon) {
            icon.classList.remove('bi-chevron-right');
            icon.classList.add('bi-chevron-down');
        }
    });

    document.addEventListener('hide.bs.collapse', function(e) {
        const icon = document.querySelector(`[href="#${e.target.id}"] .toggle-icon`);
        if (icon) {
            icon.classList.remove('bi-chevron-down');
            icon.classList.add('bi-chevron-right');
        }
    });

    document.getElementById('toggleMoreBtn').addEventListener('click', function() {
        const extra = document.getElementById('extra-intervals');
        const isHidden = extra.classList.contains('d-none');
        extra.classList.toggle('d-none');
        this.textContent = isHidden ? 'Sembunyikan' : 'Lihat Selengkapnya';
    });
});
</script>
@endsection

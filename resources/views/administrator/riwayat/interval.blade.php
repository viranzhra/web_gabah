<div class="card shadow-sm mb-3" style="background-color: rgb(127 144 190 / 16%); border: 1px solid #d0d4df; border-radius: 15px">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center toggle-header"
            data-bs-toggle="collapse" href="#{{ $collapseId }}" role="button" aria-expanded="false"
            aria-controls="{{ $collapseId }}" style="cursor: pointer;">
            <div>
                <h6 style="color: #1E3B8A; font-size: 17px; font-weight: 700 !important; margin-bottom: 12px;">
                    Interval {{ $data['interval'] }}</h6>
                <div><i class="bi bi-droplet me-2"></i>Kadar Air Gabah (rata-rata): <span class="fw-bold">
                        {{ $data['kadar_air_rata'] }}</span></div>
            </div>
            <i class="bi bi-chevron-right toggle-icon" style="font-size: 15px;"></i>
        </div>

        <div class="collapse mt-3" id="{{ $collapseId }}">
            <div class="d-flex justify-content-between mb-2">
                <span><i class="bi bi-clock-history me-2"></i>Timestamp:</span>
                <span style="font-weight: 800; color: #1E3B8A">{{ \Carbon\Carbon::parse($data['timestamp'])->translatedFormat('d M Y H:i') }}</span>
            </div>

            <h6 class="mt-3 mb-2" style="color: #1E3B8A; font-size: 17px; font-weight: 700 !important;">Pembakaran & Pengaduk</h6>
            <div class="d-flex justify-content-between mb-2">
                <span><i class="bi bi-fire me-2"></i>Suhu Pembakaran:</span>
                <span style="font-weight: 800; color: #1E3B8A">{{ $data['suhu_pembakaran'] }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span><i class="bi bi-repeat me-2"></i>Status Pengaduk:</span>
                <span style="font-weight: 800; color: #1E3B8A">{{ $data['status_pengaduk'] }}</span>
            </div>

            <h6 class="fw-bold mt-3 mb-2" style="color: #1E3B8A; font-size: 17px; font-weight: 700 !important;">Tombak 1</h6>
            <div class="d-flex justify-content-between mb-2">
                <span><i class="bi bi-thermometer-sun me-2"></i>Suhu Ruangan:</span>
                <span style="font-weight: 800; color: #1E3B8A">{{ $data['suhu_ruangan'] }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span><i class="bi bi-droplet-half me-2"></i>Kadar Air Gabah:</span>
                <span style="font-weight: 800; color: #1E3B8A">{{ $data['kadar_air_gabah'] }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span><i class="bi bi-thermometer-high me-2"></i>Suhu Gabah:</span>
                <span style="font-weight: 800; color: #1E3B8A">{{ $data['suhu_gabah'] }}</span>
            </div>
        </div>
    </div>
</div>
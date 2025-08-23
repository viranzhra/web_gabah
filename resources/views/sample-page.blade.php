<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GrainDryer - Monitoring</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- CSS Kustom -->
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .toast {
            min-width: 300px;
        }
        #notificationHistory {
            max-height: 200px;
            overflow-y: auto;
            padding: 10px;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
        }
        .history-item {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .history-item:last-child {
            border-bottom: none;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <div class="card">
            <div class="card-body">
                <h4 class="mb-3">📡 Monitoring Proses Pengeringan</h4>

                <div class="mb-3">
                    <p><strong>Kadar Air (Rata-rata):</strong> <span id="kadar_air">-</span>%</p>
                    <p><strong>Suhu Gabah (Rata-rata):</strong> <span id="suhu_gabah">-</span>°C</p>
                    <p><strong>Suhu Ruangan (Rata-rata):</strong> <span id="suhu_ruangan">-</span>°C</p>
                    <p><strong>Suhu Pembakaran (Rata-rata):</strong> <span id="suhu_pembakaran">-</span>°C</p>
                    <p><strong>Estimasi Durasi:</strong> <span id="estimasi_durasi">-</span> menit</p>
                    <p><strong>Durasi Rekomendasi:</strong> <span id="durasi_rekomendasi">-</span> menit</p>
                    {{-- <p><strong>Durasi Terlaksana:</strong> <span id="durasi_terlaksana">-</span> menit</p> --}}
                    <p id="status_info" class="mt-3 fw-bold text-success"></p>
                </div>
            </div>
        </div>

        <!-- Toast Container -->
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
            <div id="notificationToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
                <div class="toast-header">
                    <strong class="me-auto">Notifikasi Pengeringan</strong>
                    <small class="text-muted">Baru saja</small>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <p id="toastMessage"></p>
                </div>
            </div>
        </div>

        <!-- Notification History -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="mb-3">Riwayat Notifikasi</h5>
                <div id="notificationHistory"></div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Ganti dengan URL API SSE dan riwayat yang sesuai
        const apiBaseUrl = 'http://gabahapi.test';
        const processId = 1;
        const eventSource = new EventSource(`${apiBaseUrl}/api/sse/sensor-data/${processId}`);
        const toastElement = document.getElementById('notificationToast');
        const toastMessage = document.getElementById('toastMessage');
        const toast = new bootstrap.Toast(toastElement);
        const historyContainer = document.getElementById('notificationHistory');
        let lastNotificationTime = 0;
        const notificationInterval = 5 * 60 * 1000;

        // Fungsi untuk memuat riwayat notifikasi dari database
        function loadNotificationHistory() {
            $.ajax({
                url: `${apiBaseUrl}/api/notifications/${processId}`,
                method: 'GET',
                success: function (response) {
                    historyContainer.innerHTML = response.data
                        .map(item => `<div class="history-item">[${item.created_at}] ${item.message}</div>`)
                        .join('');
                },
                error: function (xhr) {
                    console.error('Gagal memuat riwayat notifikasi:', xhr.responseText);
                }
            });
        }

        // Fungsi untuk menyimpan notifikasi ke database
        function saveNotification(message) {
            $.ajax({
                url: `${apiBaseUrl}/api/notifications`,
                method: 'POST',
                data: JSON.stringify({
                    process_id: processId,
                    message: message
                }),
                contentType: 'application/json',
                success: function () {
                    loadNotificationHistory();
                },
                error: function (xhr) {
                    console.error('Gagal menyimpan notifikasi:', xhr.responseText);
                }
            });
        }

        // Muat riwayat saat halaman dibuka
        loadNotificationHistory();

        eventSource.addEventListener("sensor-update", function (event) {
            const data = JSON.parse(event.data);
            console.log('🔁 Data dari SSE:', data);

            // Update text content
            document.getElementById('kadar_air').textContent = data.kadar_air !== null ? data.kadar_air : '-';
            document.getElementById('suhu_gabah').textContent = data.suhu_gabah !== null ? data.suhu_gabah : '-';
            document.getElementById('suhu_ruangan').textContent = data.suhu_ruangan !== null ? data.suhu_ruangan : '-';
            document.getElementById('suhu_pembakaran').textContent = data.suhu_pembakaran !== null ? data.suhu_pembakaran : '-';
            document.getElementById('estimasi_durasi').textContent = data.estimasi_durasi !== null ? data.estimasi_durasi : '-';
            document.getElementById('durasi_rekomendasi').textContent = data.durasi_rekomendasi !== null ? data.durasi_rekomendasi : '-';
            document.getElementById('durasi_terlaksana').textContent = data.durasi_terlaksana !== null ? data.durasi_terlaksana : '-';

            // Status text
            const statusInfo = document.getElementById('status_info');
            if (data.status === 'selesai') {
                statusInfo.textContent = '✅ Proses pengeringan telah selesai. Target kadar air tercapai.';
                const message = `Proses pengeringan selesai! Kadar air: ${data.kadar_air}%.`;
                toastMessage.textContent = message;
                toast.show();
                saveNotification(message);
            } else if (data.status === 'berlangsung') {
                statusInfo.textContent = '⏳ Proses pengeringan sedang berlangsung...';
            } else if (data.status === 'invalid') {
                statusInfo.textContent = '⚠️ Proses tidak valid atau sudah selesai.';
            } else {
                statusInfo.textContent = '';
            }

            // Show notification every 5 minutes for ongoing process
            const currentTime = Date.now();
            if (
                data.status === 'berlangsung' &&
                data.kadar_air !== null &&
                data.durasi_terlaksana !== null &&
                (currentTime - lastNotificationTime >= notificationInterval)
            ) {
                const message = `Update Pengeringan: Kadar air ${data.kadar_air}% dengan durasi terlaksana ${data.durasi_terlaksana} menit.`;
                toastMessage.textContent = message;
                toast.show();
                saveNotification(message);
                lastNotificationTime = currentTime;
            }
        });

        eventSource.onerror = function (error) {
            console.error("❌ SSE Error. Tidak dapat terhubung ke server.", error);
        };
    </script>
</body>
</html>
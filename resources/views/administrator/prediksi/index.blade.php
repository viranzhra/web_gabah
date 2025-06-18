@extends('layout.app')

@section('content')
    <style>
        .add-button {
            display: flex;
            justify-content: flex-end;
            margin-top: 8px;
        }

        .add-button .btn {
            background-color: #1E3B8A;
            color: white;
            font-weight: bold;
            padding: 8px 13px;
            border: none;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 3px;
        }

        .add-button .btn svg {
            width: 24px;
            height: 24px;
            fill: white;
        }

        /* Css Modal Add */
        .custom-input {
            background-color: #FDFDFD;
            border: 1px solid #DAD9D9;
            border-radius: 12px;
            padding: 10px;
            color: #989898;
        }

        .custom-save-btn {
            background-color: #1E3B8A;
            color: white;
            border-radius: 12px;
            padding: 8px 24px;
            font-weight: 500;
            border: none;
        }

        .custom-save-btn:hover {
            background-color: #163075;
        }

        #data-table th,
        #data-table td {
            white-space: nowrap;
            text-align: center;
            vertical-align: middle;
            padding: 8px 12px;
        }

        /* Status dan tombol aksi */
        .status-selesai {
            color: #1CE04A;
            font-weight: bold;
        }

        .status-pending {
            color: #F1B635;
            font-weight: bold;
        }

        .status-proses {
            color: #6D94FF;
            font-weight: bold;
        }

        .btn-mulai {
            background-color: #C4D4FF;
            color: #1E3B8A;
            border-radius: 15px;
            padding: 5px;
            width: 78px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-mulai:hover {
            background-color: #A0B8FF;
            color: #0D2F6A;
            transform: scale(1.05);
        }

        .btn-selesai {
            background-color: #b8f7c6;
            color: #00791C;
            border-radius: 15px;
            padding: 5px;
            width: 78px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-selesai:hover {
            background-color: #95f4a4;
            color: #005B12;
            transform: scale(1.05);
        }

        /* css judul halaman */
        .estetik-card {
            width: 100%;
            border-left: 7px solid #1E3B8A;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(30, 59, 138, 0.07);
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .estetik-card .card-body {
            padding: 20px 24px;
            display: flex;
            align-items: center;
        }

        .estetik-card .icon {
            background-color: #1E3B8A;
            color: #fff;
            border-radius: 50%;
            padding: 10px;
            margin-right: 18px;
            font-size: 15px;
            box-shadow: 0 3px 6px rgba(30, 59, 138, 0.2);
        }

        .estetik-card h4 {
            margin: 0;
            font-size: 18px;
            color: #1E3B8A;
            font-weight: 600;
        }

        .estetik-card .divider {
            height: 2px;
            background: linear-gradient(to right, #1E3B8A, transparent);
            margin-top: 10px;
            border-radius: 2px;
        }
    </style>

    <h4 class="fw-semibold mb-3" style="margin-top: 10px;">Prediksi Pengeringan Gabah</h4>

    <!-- Tombol Tambah Data -->
    <div class="add-button mb-3">
        <button type="button" class="btn btn-primary d-flex align-items-center gap-1" data-bs-toggle="modal"
            data-bs-target="#tambahDataModal" style="background-color: #1E3B8A; border-radius: 12px; border: none;">
            <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                    d="M7.75 15.8229C7.75 15.4412 7.82517 15.0633 7.97122 14.7107C8.11728 14.3581 8.33135 14.0377 8.60122 13.7678C8.87109 13.498 9.19147 13.2839 9.54408 13.1379C9.89668 12.9918 10.2746 12.9166 10.6562 12.9166C11.0379 12.9166 11.4158 12.9918 11.7684 13.1379C12.121 13.2839 12.4414 13.498 12.7113 13.7678C12.9811 14.0377 13.1952 14.3581 13.3413 14.7107C13.4873 15.0633 13.5625 15.4412 13.5625 15.8229C13.5625 16.5937 13.2563 17.3329 12.7113 17.8779C12.1663 18.4229 11.427 18.7291 10.6562 18.7291C9.88546 18.7291 9.14625 18.4229 8.60122 17.8779C8.05619 17.3329 7.75 16.5937 7.75 15.8229ZM10.6562 14.8541C10.3993 14.8541 10.1529 14.9562 9.97124 15.1379C9.78956 15.3195 9.6875 15.5659 9.6875 15.8229C9.6875 16.0798 9.78956 16.3262 9.97124 16.5079C10.1529 16.6896 10.3993 16.7916 10.6562 16.7916C10.9132 16.7916 11.1596 16.6896 11.3413 16.5079C11.5229 16.3262 11.625 16.0798 11.625 15.8229C11.625 15.5659 11.5229 15.3195 11.3413 15.1379C11.1596 14.9562 10.9132 14.8541 10.6562 14.8541ZM14.8542 15.8229C14.8542 15.5659 14.9562 15.3195 15.1379 15.1379C15.3196 14.9562 15.566 14.8541 15.8229 14.8541H19.0521C19.309 14.8541 19.5554 14.9562 19.7371 15.1379C19.9188 15.3195 20.0208 15.5659 20.0208 15.8229C20.0208 16.0798 19.9188 16.3262 19.7371 16.5079C19.5554 16.6896 19.309 16.7916 19.0521 16.7916H15.8229C15.566 16.7916 15.3196 16.6896 15.1379 16.5079C14.9562 16.3262 14.8542 16.0798 14.8542 15.8229ZM7.75 10.0104C7.75 9.75345 7.85206 9.50704 8.03374 9.32537C8.21542 9.14369 8.46182 9.04163 8.71875 9.04163H19.0521C19.309 9.04163 19.5554 9.14369 19.7371 9.32537C19.9188 9.50704 20.0208 9.75345 20.0208 10.0104C20.0208 10.2673 19.9188 10.5137 19.7371 10.6954C19.5554 10.8771 19.309 10.9791 19.0521 10.9791H8.71875C8.46182 10.9791 8.21542 10.8771 8.03374 10.6954C7.85206 10.5137 7.75 10.2673 7.75 10.0104Z"
                    fill="white" />
                <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                    d="M8.07292 3.875C6.95956 3.875 5.8918 4.31728 5.10454 5.10454C4.31728 5.8918 3.875 6.95956 3.875 8.07292V19.6979C3.875 20.8113 4.31728 21.879 5.10454 22.6663C5.8918 23.4536 6.95956 23.8958 8.07292 23.8958H19.6979C20.8113 23.8958 21.879 23.4536 22.6663 22.6663C23.4536 21.879 23.8958 20.8113 23.8958 19.6979V8.07292C23.8958 6.95956 23.4536 5.8918 22.6663 5.10454C21.879 4.31728 20.8113 3.875 19.6979 3.875H8.07292ZM5.8125 8.07292C5.8125 6.82517 6.82517 5.8125 8.07292 5.8125H19.6979C20.9457 5.8125 21.9583 6.82517 21.9583 8.07292V19.6979C21.9594 20.1811 21.8052 20.6517 21.5184 21.0406C21.2317 21.4294 20.8276 21.7158 20.3657 21.8576C20.1539 21.923 19.9313 21.9566 19.6979 21.9583H8.07292C7.47342 21.9583 6.89847 21.7202 6.47456 21.2963C6.05065 20.8724 5.8125 20.2974 5.8125 19.6979V8.07292Z"
                    fill="white" />
                <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                    d="M11.3021 27.125C10.5969 27.1253 9.90304 26.9479 9.28449 26.6093C8.66593 26.2707 8.14265 25.7817 7.76294 25.1875H20.3438C21.6284 25.1875 22.8604 24.6771 23.7688 23.7688C24.6772 22.8604 25.1875 21.6283 25.1875 20.3437V7.76416C25.7817 8.14387 26.2707 8.66715 26.6094 9.28571C26.948 9.90426 27.1253 10.5982 27.125 11.3033V20.345C27.1247 22.1433 26.4101 23.8678 25.1384 25.1392C23.8667 26.4107 22.142 27.125 20.3438 27.125H11.3021Z"
                    fill="white" />
            </svg>
            Form Prediksi
        </button>
    </div>

    <!-- DataTable -->
    <div class="card mt-4">
        <div class="card-body">
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table table-striped table-bordered" id="data-table" style="width: 100%">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Jenis Gabah</th>
                            <th class="text-center">Berat Gabah (Kg)</th>
                            <th class="text-center">Suhu Gabah Awal (°C)</th>
                            <th class="text-center">Suhu Ruangan Awal (°C)</th>
                            <th class="text-center">Kadar Air Awal (%)</th>
                            <th class="text-center">Kadar Air Target (%)</th>
                            <th class="text-center">Suhu Gabah Akhir (°C)</th>
                            <th class="text-center">Suhu Ruangan Akhir (°C)</th>
                            <th class="text-center">Kadar Air Akhir (%)</th>
                            <th class="text-center">Durasi Rekomendasi</th>
                            <th class="text-center">Durasi Aktual</th>
                            <th class="text-center">Durasi Terlaksana</th>
                            <th class="text-center">Waktu Mulai</th>
                            <th class="text-center">Waktu Selesai</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
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
                        <div id="hasilPrediksi" class="mt-4" style="display: none;">
                            <h5>Hasil Prediksi Durasi Pengeringan:</h5>
                            <p id="durasiText" class="fw-bold fs-4 text-success"></p>
                        </div>
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
                            <input type="number" name="suhu_gabah" id="suhu_gabah" class="form-control" step="0.1" style="background-color: #eceff4;"
                                readonly
                                value="{{ $sensorData ? round(collect($sensorData)->avg('suhu_gabah'), 2) : '' }}" />
                        </div>
                        <div class="mb-3">
                            <label for="suhu_ruangan" class="form-label">Suhu Ruangan (°C)</label>
                            <input type="number" name="suhu_ruangan" id="suhu_ruangan" class="form-control"
                                step="0.1" style="background-color: #eceff4;" readonly
                                value="{{ $sensorData ? round(collect($sensorData)->avg('suhu_ruangan'), 2) : '' }}" />
                        </div>
                        <div class="mb-3">
                            <label for="kadar_air_gabah" class="form-label">Kadar Air Gabah (%)</label>
                            <input type="number" name="kadar_air_gabah" id="kadar_air_gabah" class="form-control"
                                step="0.1" style="background-color: #eceff4;" readonly
                                value="{{ $sensorData ? round(collect($sensorData)->avg('kadar_air_gabah'), 2) : '' }}" />
                        </div>
                        <div style="margin-top: 30px;">
                            <button type="submit" class="btn w-100" style="background-color: #1E3A8A; color: white;">Prediksi</button>
                        </div>
                    </form>
                    <script>
                        // Retrieve Sanctum token from session
                        const sanctumToken = "{{ session('sanctum_token') ?? '' }}";

                        document.getElementById('predictForm').addEventListener('submit', function(e) {
                            e.preventDefault();
                            const errorMessageDiv = document.getElementById('errorMessage');
                            const hasilPrediksiDiv = document.getElementById('hasilPrediksi');

                            errorMessageDiv.style.display = 'none';
                            errorMessageDiv.innerText = '';
                            hasilPrediksiDiv.style.display = 'none';

                            // Validasi data sensor
                            const suhuGabah = document.getElementById('suhu_gabah').value;
                            const suhuRuangan = document.getElementById('suhu_ruangan').value;
                            const kadarAirGabah = document.getElementById('kadar_air_gabah').value;

                            if (!suhuGabah || !suhuRuangan || !kadarAirGabah) {
                                showError('Data sensor tidak lengkap. Pastikan semua data sensor tersedia.');
                                return;
                            }

                            // Validasi input form
                            const form = e.target;
                            if (!form.jenis_gabah.value) {
                                showError('Jenis gabah harus dipilih.');
                                return;
                            }
                            const beratGabah = parseFloat(form.berat_gabah.value);
                            if (!beratGabah || beratGabah <= 0) {
                                showError('Berat gabah harus lebih besar dari 0.');
                                return;
                            }
                            const kadarAirTarget = parseFloat(form.kadar_air_target.value);
                            if (!kadarAirTarget || kadarAirTarget < 0 || kadarAirTarget > 100) {
                                showError('Target kadar air harus di antara 0 dan 100.');
                                return;
                            }

                            // Periksa token Sanctum
                            if (!sanctumToken) {
                                showError('Anda harus login untuk menyimpan data prediksi.');
                                window.location.href = '{{ route('login') }}';
                                return;
                            }

                            // Inisialisasi CSRF token
                            fetch('/sanctum/csrf-cookie', {
                                method: 'GET'
                            }).then(() => {
                                const data = {
                                    kadar_air_gabah: parseFloat(kadarAirGabah),
                                    suhu_gabah: parseFloat(suhuGabah),
                                    suhu_ruangan: parseFloat(suhuRuangan),
                                    berat_gabah: beratGabah,
                                    kadar_air_target: kadarAirTarget
                                };

                                const timestampMulai = new Date().toISOString();
                                fetch("http://192.168.0.9:5000/predict", {
                                        method: "POST",
                                        headers: {
                                            "Content-Type": "application/json"
                                        },
                                        body: JSON.stringify(data)
                                    })
                                    .then(response => {
                                        if (!response.ok) {
                                            throw new Error(
                                                `Gagal mendapatkan prediksi dari server ML: ${response.statusText}`);
                                        }
                                        return response.json();
                                    })
                                    .then(data => {
                                        document.getElementById('durasiText').innerText =
                                            `${data.durasi_rekomendasi} menit`;
                                        hasilPrediksiDiv.style.display = 'block';

                                        const durasiMenit = parseFloat(data.durasi_rekomendasi);
                                        const timestampSelesai = new Date(new Date(timestampMulai).getTime() +
                                            durasiMenit * 60 * 1000).toISOString();

                                        const storeData = {
                                            nama_jenis: form.jenis_gabah.value,
                                            suhu_gabah_awal: parseFloat(suhuGabah),
                                            suhu_ruangan_awal: parseFloat(suhuRuangan),
                                            kadar_air_awal: parseFloat(kadarAirGabah),
                                            kadar_air_target: kadarAirTarget,
                                            berat_gabah: beratGabah,
                                            durasi_rekomendasi: durasiMenit,
                                            timestamp_mulai: timestampMulai,
                                            timestamp_selesai: timestampSelesai,
                                            status: 'ongoing'
                                        };

                                        console.log('Data yang dikirim ke /prediksi/store:', storeData);

                                        fetch('{{ config('services.api.base_url') }}/prediksi/store', {
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
                                                console.log('Respons dari /prediksi/store:', response);
                                                if (!response.ok) {
                                                    if (response.status === 401) {
                                                        showError(
                                                            'Sesi Anda telah berakhir. Silakan login kembali.');
                                                        window.location.href = '{{ route('login') }}';
                                                        return Promise.reject(new Error('Unauthorized'));
                                                    }
                                                    return response.json().then(err => {
                                                        throw new Error(err.error || err.message ||
                                                            `Gagal menyimpan ke database Laravel (Status: ${response.status})`
                                                        );
                                                    });
                                                }
                                                return response.json();
                                            })
                                            .then(data => {
                                                if (data.success) {
                                                    $('#tambahDataModal').modal('hide');
                                                    form.reset();
                                                    hasilPrediksiDiv.style.display = 'none';
                                                    document.getElementById('durasiText').innerText = '';
                                                    $('#data-table').DataTable().ajax.reload(null, false);
                                                    alert("Data berhasil disimpan dan proses pengeringan dimulai!");
                                                    startSensorMonitoring(data.data.process_id, sanctumToken);
                                                } else {
                                                    showError('Gagal menyimpan proses: ' + (data.error ||
                                                        'Kesalahan server.'));
                                                }
                                            })
                                            .catch(err => {
                                                if (err.message !== 'Unauthorized') {
                                                    console.error("Error:", err);
                                                    showError(
                                                        `Terjadi kesalahan saat menyimpan ke Laravel: ${err.message}`
                                                    );
                                                }
                                            });
                                    })
                                    .catch(error => {
                                        console.error("Gagal menghubungi server ML:", error);
                                        showError(`Gagal menghubungi server ML: ${error.message}`);
                                    });
                            }).catch(err => {
                                console.error("Gagal menginisialisasi CSRF:", err);
                                showError('Gagal menginisialisasi CSRF token. Silakan coba lagi.');
                            });

                            function showError(msg) {
                                errorMessageDiv.style.display = 'block';
                                errorMessageDiv.innerText = msg;
                            }

                            function startSensorMonitoring(processId, token) {
                                setInterval(function() {
                                    fetch('{{ config('services.api.base_url') }}/get-sensor', {
                                            headers: {
                                                'Authorization': `Bearer ${token}`,
                                                'Accept': 'application/json'
                                            }
                                        })
                                        .then(response => {
                                            if (!response.ok) {
                                                throw new Error(`Gagal mengambil data sensor: ${response.statusText}`);
                                            }
                                            return response.json();
                                        })
                                        .then(sensorData => {
                                            if (sensorData.data && sensorData.data.length > 0) {
                                                const latestSensor = sensorData.data[0];
                                                const currentKadarAir = parseFloat(latestSensor.kadar_air_gabah);

                                                const table = $('#data-table').DataTable();
                                                const row = table.rows().data().toArray().find(r => r.process_id ===
                                                    processId);
                                                if (!row || row.status !== 'ongoing') return;

                                                const kadarAirTarget = parseFloat(row.kadar_air_target);
                                                const startTime = new Date(row.timestamp_mulai);
                                                const now = new Date();
                                                const durasiTerlaksana = Math.floor((now - startTime) / (1000 * 60));

                                                // Update durasi terlaksana
                                                fetch(`{{ config('services.api.base_url') }}/drying-process/${processId}/update-duration`, {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/json',
                                                            'Authorization': `Bearer ${token}`,
                                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                                        },
                                                        body: JSON.stringify({
                                                            durasi_terlaksana: durasiTerlaksana,
                                                            kadar_air_akhir: currentKadarAir,
                                                            suhu_gabah_akhir: parseFloat(latestSensor
                                                                .suhu_gabah),
                                                            suhu_ruangan_akhir: parseFloat(latestSensor
                                                                .suhu_ruangan)
                                                        })
                                                    })
                                                    .then(response => {
                                                        if (!response.ok) {
                                                            throw new Error(
                                                                `Gagal memperbarui durasi: ${response.statusText}`
                                                            );
                                                        }
                                                        return response.json();
                                                    })
                                                    .then(data => {
                                                        if (data.success) {
                                                            table.ajax.reload(null, false);
                                                            if (data.message.includes('selesai secara otomatis')) {
                                                                alert(
                                                                    `Proses ${processId} selesai! Kadar air target tercapai.`
                                                                    );
                                                            }
                                                        }
                                                    })
                                                    .catch(err => console.error('Error updating duration:', err));
                                            }
                                        })
                                        .catch(err => console.error('Error fetching sensor data:', err));
                                }, 60000); // Cek setiap 60 detik
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- Bootstrap JS (untuk modal) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
(function($) {
    $(document).ready(function() {
        // Retrieve Sanctum token from session
        const sanctumToken = "{{ session('sanctum_token') ?? '' }}";
        console.log('Sanctum Token:', sanctumToken ? 'Present' : 'Missing');

        // Initialize DataTable
        const table = $('#data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ config('services.api.base_url') }}/drying-process',
                type: 'GET',
                headers: {
                    'Authorization': `Bearer ${sanctumToken}`,
                    'Accept': 'application/json'
                },
                dataSrc: function(json) {
                    console.log('AJAX Response from /drying-process:', json);
                    if (json.error) {
                        console.error('API Error:', json.error);
                        alert('Gagal memuat data: ' + json.error);
                        return [];
                    }
                    if (!json.data) {
                        console.warn('No data property in response:', json);
                        return [];
                    }
                    return json.data;
                },
                error: function(xhr, error, thrown) {
                    console.error('AJAX Error:', {
                        status: xhr.status,
                        response: xhr.responseJSON,
                        error: thrown
                    });
                    let errorMessage = 'Terjadi kesalahan saat memuat data.';
                    if (xhr.status === 401) {
                        errorMessage = 'Sesi Anda telah berakhir. Silakan login kembali.';
                        window.location.href = '{{ route('login') }}';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Kesalahan server. Silakan coba lagi atau hubungi administrator.';
                    } else if (xhr.status === 0) {
                        errorMessage = 'Tidak dapat terhubung ke server. Periksa koneksi jaringan Anda.';
                    } else {
                        errorMessage = xhr.responseJSON?.error || 'Kesalahan tidak diketahui.';
                    }
                    alert(errorMessage);
                    table.processing(false);
                }
            },
            columns: [
                {
                    data: null,
                    render: function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                { data: 'nama_jenis' },
                {
                    data: 'berat_gabah',
                    render: function(data) {
                        if (data === null || data === undefined) return '-';
                        const value = parseFloat(data);
                        return isNaN(value) ? '-' : value.toFixed(2);
                    }
                },
                {
                    data: 'suhu_gabah_awal',
                    render: function(data) {
                        if (data === null || data === undefined) return '-';
                        const value = parseFloat(data);
                        return isNaN(value) ? '-' : value.toFixed(2);
                    }
                },
                {
                    data: 'suhu_ruangan_awal',
                    render: function(data) {
                        if (data === null || data === undefined) return '-';
                        const value = parseFloat(data);
                        return isNaN(value) ? '-' : value.toFixed(2);
                    }
                },
                {
                    data: 'kadar_air_awal',
                    render: function(data) {
                        if (data === null || data === undefined) return '-';
                        const value = parseFloat(data);
                        return isNaN(value) ? '-' : value.toFixed(2);
                    }
                },
                {
                    data: 'kadar_air_target',
                    render: function(data) {
                        if (data === null || data === undefined) return '-';
                        const value = parseFloat(data);
                        return isNaN(value) ? '-' : value.toFixed(2);
                    }
                },
                {
                    data: 'suhu_gabah_akhir',
                    render: function(data) {
                        if (data === null || data === undefined) return '-';
                        const value = parseFloat(data);
                        return isNaN(value) ? '-' : value.toFixed(2);
                    }
                },
                {
                    data: 'suhu_ruangan_akhir',
                    render: function(data) {
                        if (data === null || data === undefined) return '-';
                        const value = parseFloat(data);
                        return isNaN(value) ? '-' : value.toFixed(2);
                    }
                },
                {
                    data: 'kadar_air_akhir',
                    render: function(data) {
                        if (data === null || data === undefined) return '-';
                        const value = parseFloat(data);
                        return isNaN(value) ? '-' : value.toFixed(2);
                    }
                },
                { data: 'durasi_rekomendasi' },
                {
                    data: 'durasi_aktual',
                    render: function(data) {
                        return data || '-';
                    }
                },
                {
                    data: 'durasi_terlaksana',
                    render: function(data, type, row) {
                        console.log('Durasi terlaksana data:', {
                            data,
                            status: row.status,
                            timestamp_mulai: row.timestamp_mulai
                        });
                        return data || '0 jam 0 menit 0 detik';
                    }
                },
                { data: 'timestamp_mulai' },
                { data: 'timestamp_selesai' },
                { data: 'status' },
                {
                    data: null,
                    render: function(data, type, row) {
                        let buttons = '';
                        if (row.status.includes('Menunggu')) {
                            buttons += `<button class="btn btn-sm btn-success btn-mulai" onclick="startProcess(${row.process_id})">Mulai</button>`;
                        }
                        if (row.status.includes('Berjalan')) {
                            buttons += `<button class="btn btn-sm btn-danger btn-selesai" onclick="completeProcess(${row.process_id})">Selesai</button>`;
                        }
                        return buttons;
                    }
                }
            ],
            order: [[13, 'desc']]
        });

        window.startProcess = function(processId) {
            console.log('Starting process:', processId);
            fetch(`{{ config('services.api.base_url') }}/drying-process/${processId}/start`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${sanctumToken}`,
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => {
                console.log('Start process response:', response);
                if (!response.ok) {
                    throw new Error(`Gagal memulai proses: ${response.statusText}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    table.ajax.reload(null, false);
                    alert('Proses dimulai!');
                } else {
                    alert('Gagal memulai proses: ' + (data.error || 'Kesalahan server.'));
                }
            })
            .catch(err => {
                console.error('Start process error:', err);
                alert('Terjadi kesalahan saat memulai: ' + err.message);
            });
        };

        window.completeProcess = function(processId) {
            console.log('Completing proses:', processId);
            fetch(`{{ config('services.api.base_url') }}/get-sensor?process_id=${processId}`, {
                headers: {
                    'Authorization': `Bearer ${sanctumToken}`,
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                console.log('Sensor response:', response);
                if (!response.ok) {
                    if (response.status === 401) {
                        alert('Sesi Anda telah berakhir. Silakan login.');
                        window.location.href = '{{ route('prediksi.index') }}';
                        return;
                    }
                    throw new Error(`Gagal mengambil data sensor: ${response.statusText}`);
                }
                return response.json();
            })
            .then(sensorData => {
                console.log('Sensor data:', sensorData);
                let completeData;

                if (sensorData.success && sensorData.data && sensorData.data.length > 0) {
                    const latestSensor = sensorData.data[0];
                    const kadarAirAkhir = parseFloat(latestSensor.kadar_air_gabah);
                    const suhuGabahAkhir = parseFloat(latestSensor.suhu_gabah);
                    const suhuRuanganAkhir = parseFloat(latestSensor.suhu_ruangan);

                    if (isNaN(kadarAirAkhir) || isNaN(suhuGabahAkhir) || isNaN(suhuRuanganAkhir)) {
                        throw new Error('Data sensor tidak valid: Nilai kadar air, suhu gabah, atau suhu ruangan tidak valid.');
                    }

                    completeData = {
                        kadar_air_akhir: kadarAirAkhir,
                        suhu_gabah_akhir: suhuGabahAkhir,
                        suhu_ruangan_akhir: suhuRuanganAkhir,
                        timestamp_selesai: new Date().toISOString()
                    };
                } else {
                    // Fallback ke input manual
                    const kadarAirAkhir = prompt('Data sensor tidak tersedia. Masukkan kadar air akhir (%):');
                    const suhuGabahAkhir = prompt('Masukkan suhu gabah akhir (°C):');
                    const suhuRuanganAkhir = prompt('Masukkan suhu ruangan akhir (°C):');

                    if (!kadarAirAkhir || !suhuGabahAkhir || !suhuRuanganAkhir) {
                        alert('Semua data akhir harus diisi untuk menyelesaikan proses.');
                        return;
                    }

                    const kadarAir = parseFloat(kadarAirAkhir);
                    const suhuGabah = parseFloat(suhuGabahAkhir);
                    const suhuRuangan = parseFloat(suhuRuanganAkhir);

                    if (isNaN(kadarAir) || kadarAir < 0 || kadarAir > 100 ||
                        isNaN(suhuGabah) || suhuGabah < 0 ||
                        isNaN(suhuRuangan) || suhuRuangan < 0) {
                        alert('Input tidak valid. Pastikan kadar air (0-100%), suhu gabah, dan suhu ruangan adalah angka positif.');
                        return;
                    }

                    completeData = {
                        kadar_air_akhir: kadarAir,
                        suhu_gabah_akhir: suhuGabah,
                        suhu_ruangan_akhir: suhuRuangan,
                        timestamp_selesai: new Date().toISOString()
                    };
                }

                console.log('Sending complete data:', completeData);

                fetch(`{{ config('services.api.base_url') }}/drying-process/${processId}/complete`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': `Bearer ${sanctumToken}`,
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(completeData)
                })
                .then(response => {
                    console.log('Complete process response:', response);
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.error || `Gagal menyelesaikan proses: ${response.statusText}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        table.ajax.reload(null, false);
                        alert('Proses selesai!');
                    } else {
                        alert('Gagal menyelesaikan proses: ' + (data.error || 'Kesalahan server.'));
                    }
                })
                .catch(err => {
                    console.error('Complete process error:', err);
                    alert('Terjadi kesalahan saat menyelesaikan proses: ' + err.message);
                });
            })
            .catch(err => {
                console.error('Error fetching sensor data:', err);
                alert('Gagal mengambil data sensor: ' + err.message);
            });
        };
    });
})(jQuery.noConflict(true));
</script>
@endsection

@extends('layout.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
    <style>
        /* [CSS sebelumnya tetap sama, hanya ditambahkan styling untuk modal input manual] */
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

        .btn-detail {
            background-color: #89a5d5;
            color: #ffff;
            border-radius: 15px;
            padding: 5px 15px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-detail:hover {
            background-color: #C4D4FF;
            transform: scale(1.05);
        }

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
            transition: opacity 0.5s ease-in-out;
        }

        #notification.success {
            background-color: #d4edda;
            color: #155724;
            border-left: 5px solid #28a745;
        }

        #notification.error {
            background-color: #f8d7da;
            color: #721c24;
            border-left: 5px solid #dc3545;
        }

        #notification.visible {
            display: flex;
            opacity: 1;
        }

        #notificationTitle {
            font-weight: bold;
            margin-bottom: 5px;
        }

        #notificationMessage {
            font-size: 14px;
        }

        /* Styling untuk Modal Detail */
        .modal-detail .modal-content {
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(30, 59, 138, 0.2);
            border: none;
        }

        .modal-detail .modal-header {
            /* background: linear-gradient(135deg, #1E3B8A, #3B5CBA); */
            color: black;
            border-radius: 16px 16px 0 0;
            position: relative;
        }

        .modal-detail .modal-title {
            font-size: 1.5rem;
            font-weight: 600;
            width: 100%;
            text-align: center;
        }

        .modal-detail .modal-body {
            padding: 20px;
            /* background-color: #F9FAFE; */
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #E6E9F5;
        }

        .detail-item:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #1E3B8A;
            flex: 1;
        }

        .detail-value {
            color: #333;
            flex: 1;
            text-align: right;
        }

        .modal-detail .btn-close {
            /* filter: invert(1); */
            color: #000000;
            padding-right: 50px;
        }

        /* Styling untuk Modal Konfirmasi Selesai */
        .modal-confirm .modal-content {
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(30, 59, 138, 0.2);
            border: none;
        }

        .modal-confirm .modal-header {
            background: linear-gradient(135deg, #dc3545, #ff6666);
            color: white;
            border-radius: 16px 16px 0 0;
        }

        .modal-confirm .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            width: 100%;
            text-align: center;
        }

        .modal-confirm .modal-body {
            padding: 20px;
            font-size: 1rem;
            text-align: center;
        }

        .modal-confirm .modal-footer {
            justify-content: center;
            gap: 10px;
        }

        .modal-confirm .btn-confirm {
            background-color: #dc3545;
            color: white;
            border-radius: 12px;
            padding: 8px 20px;
            font-weight: 500;
        }

        .modal-confirm .btn-cancel {
            background-color: #6c757d;
            color: white;
            border-radius: 12px;
            padding: 8px 20px;
            font-weight: 500;
        }

        /* Styling untuk Modal Input Manual */
        .modal-manual .modal-content {
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(30, 59, 138, 0.2);
            border: none;
        }

        .modal-manual .modal-header {
            background: linear-gradient(135deg, #1E3B8A, #3B5CBA);
            color: white;
            border-radius: 16px 16px 0 0;
        }

        .modal-manual .modal-title {
            font-size: 1.25rem;
            font-weight: 600;
            width: 100%;
            text-align: center;
        }

        .modal-manual .modal-body {
            padding: 20px;
        }

        .modal-manual .modal-footer {
            justify-content: center;
            gap: 10px;
        }

        .modal-manual .btn-save {
            background-color: #1E3B8A;
            color: white;
            border-radius: 12px;
            padding: 8px 20px;
            font-weight: 500;
        }

        .modal-manual .btn-cancel {
            background-color: #6c757d;
            color: white;
            border-radius: 12px;
            padding: 8px 20px;
            font-weight: 500;
        }
    </style>

    <div id="notification" class="alert position-fixed top-0 end-0 m-4">
        <div id="notificationTitle" style="font-weight: bold;"></div>
        <div id="notificationMessage"></div>
    </div>

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
                <table class="table table-striped table-bordered" id="data-table" style="width: 100%; font-size: 14px;">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Jenis Gabah</th>
                            <th class="text-center">Berat Gabah (Kg)</th>
                            <th class="text-center">Durasi Rekomendasi</th>
                            <th class="text-center">Durasi Terlaksana</th>
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
                        {{-- <div class="mb-3">
                            <label for="kadar_air_target" class="form-label">Target Kadar Air Gabah (%)</label>
                            <input type="number" name="kadar_air_target" id="kadar_air_target" class="form-control"
                                step="0.1" required min="0" max="100" />
                        </div> --}}
                        <div class="mb-3">
                            <label for="kadar_air_target" class="form-label">Target Kadar Air Gabah (%)</label>
                            <input type="number" name="kadar_air_target" id="kadar_air_target" class="form-control"
                                step="0.1" required min="0" max="100" value="14" readonly
                                style="background-color: #eceff4;" />
                        </div>
                        <div class="mb-3">
                            <label for="suhu_gabah" class="form-label">Suhu Gabah (°C)</label>
                            <input type="number" name="suhu_gabah" id="suhu_gabah" class="form-control" step="0.1"
                                style="background-color: #eceff4;" readonly
                                value="{{ $sensorData ? round(collect($sensorData)->avg('suhu_gabah'), 2) : '' }}" />
                        </div>
                        <div class="mb-3">
                            <label for="suhu_pembakaran" class="form-label">Suhu Pembakaran (°C)</label>
                            <input type="number" name="suhu_pembakaran" id="suhu_pembakaran" class="form-control"
                                step="0.1" style="background-color: #eceff4;" readonly
                                value="{{ $sensorData ? round(collect($sensorData)->avg('suhu_pembakaran'), 2) : '' }}" />
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
                            <button type="submit" class="btn w-100"
                                style="background-color: #1E3A8A; color: white;">Prediksi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail -->
    <div class="modal fade modal-detail" id="detailDataModal" tabindex="-1" aria-labelledby="detailDataModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailDataModalLabel">Detail Proses Pengeringan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <strong>Jenis Gabah</strong><br>
                                <span id="detail_nama_jenis">-</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Berat Gabah (Kg)</strong><br>
                                <span id="detail_berat_gabah">-</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Suhu Gabah Awal (°C)</strong><br>
                                <span id="detail_suhu_gabah_awal">-</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Suhu Ruangan Awal (°C)</strong><br>
                                <span id="detail_suhu_ruangan_awal">-</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Suhu Pembakaran Awal (°C)</strong><br>
                                <span id="detail_suhu_pembakaran_awal">-</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Kadar Air Awal (%)</strong><br>
                                <span id="detail_kadar_air_awal">-</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Kadar Air Target (%)</strong><br>
                                <span id="detail_kadar_air_target">-</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Suhu Gabah Akhir (°C)</strong><br>
                                <span id="detail_suhu_gabah_akhir">-</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Suhu Ruangan Akhir (°C)</strong><br>
                                <span id="detail_suhu_ruangan_akhir">-</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Suhu Pembakaran Akhir (°C)</strong><br>
                                <span id="detail_suhu_pembakaran_akhir">-</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Kadar Air Akhir (%)</strong><br>
                                <span id="detail_kadar_air_akhir">-</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Durasi Rekomendasi</strong><br>
                                <span id="detail_durasi_rekomendasi">-</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Durasi Aktual</strong><br>
                                <span id="detail_durasi_aktual">-</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Waktu Mulai</strong><br>
                                <span id="detail_timestamp_mulai">-</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Waktu Selesai</strong><br>
                                <span id="detail_timestamp_selesai">-</span>
                            </div>
                            <div class="col-md-3">
                                <strong>Status</strong><br>
                                <span id="detail_status">-</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button> -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Selesai -->
    <div class="modal fade modal-confirm" id="confirmCompleteModal" tabindex="-1" aria-labelledby="confirmCompleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmCompleteModalLabel">Konfirmasi Selesai</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menyelesaikan proses pengeringan ini? Data sensor akhir akan disimpan.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-confirm" id="confirmCompleteBtn">Yakin</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Input Manual -->
    <div class="modal fade modal-manual" id="manualInputModal" tabindex="-1" aria-labelledby="manualInputModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="manualInputModalLabel">Masukkan Data Sensor Akhir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="manual_kadar_air_akhir" class="form-label">Kadar Air Akhir (%)</label>
                        <input type="number" id="manual_kadar_air_akhir" class="form-control" step="0.1" min="0" max="100"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="manual_suhu_gabah_akhir" class="form-label">Suhu Gabah Akhir (°C)</label>
                        <input type="number" id="manual_suhu_gabah_akhir" class="form-control" step="0.1" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="manual_suhu_ruangan_akhir" class="form-label">Suhu Ruangan Akhir (°C)</label>
                        <input type="number" id="manual_suhu_ruangan_akhir" class="form-control" step="0.1" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="manual_suhu_pembakaran_akhir" class="form-label">Suhu Pembakaran Akhir (°C)</label>
                        <input type="number" id="manual_suhu_pembakaran_akhir" class="form-control" step="0.1" min="0"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-save" id="saveManualInputBtn">Simpan</button>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function($) {
            $(document).ready(function() {
                // Pemeriksaan pustaka
                if (typeof bootstrap === 'undefined') {
                    console.error('Bootstrap JS tidak dimuat.');
                    showNotification('Kesalahan', 'Bootstrap JS tidak dimuat. Periksa CDN atau file lokal.', 'error');
                    return;
                }
                if (typeof $ === 'undefined') {
                    console.error('jQuery tidak dimuat.');
                    showNotification('Kesalahan', 'jQuery tidak dimuat. Periksa CDN atau file lokal.', 'error');
                    return;
                }
                if (typeof $.fn.DataTable === 'undefined') {
                    console.error('DataTables tidak dimuat.');
                    showNotification('Kesalahan', 'DataTables tidak dimuat. Periksa CDN atau file lokal.', 'error');
                    return;
                }

                // Retrieve Sanctum token
                const sanctumToken = localStorage.getItem('sanctum_token') || "{{ session('sanctum_token') ?? '' }}";
                console.log('Sanctum Token:', sanctumToken ? 'Present' : 'Missing');

                // Global notification function
                function showNotification(title, message, className = 'success') {
                    const notification = document.getElementById('notification');
                    const notificationTitle = document.getElementById('notificationTitle');
                    const notificationMessage = document.getElementById('notificationMessage');

                    notificationTitle.innerText = title;
                    notificationMessage.innerText = message;
                    notification.className = `alert position-fixed top-0 end-0 m-4 ${className}`;
                    notification.classList.add('visible');

                    setTimeout(() => {
                        notification.classList.remove('visible');
                        setTimeout(() => {
                            notificationTitle.innerText = '';
                            notificationMessage.innerText = '';
                            notification.classList.remove(className);
                        }, 500);
                    }, 5000);
                }

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
                                showNotification('Gagal memuat data: ' + json.error, 'error');
                                return [];
                            }
                            if (!json.data || !Array.isArray(json.data)) {
                                console.warn('Invalid data format:', json);
                                showNotification('Data tidak valid atau kosong.', 'error');
                                return [];
                            }
                            return json.data;
                        },
                        error: function(xhr, error, thrown) {
                            console.error('AJAX Error:', { status: xhr.status, response: xhr.responseJSON, error: thrown });
                            let errorMessage = 'Terjadi kesalahan saat memuat data.';
                            if (xhr.status === 401) {
                                errorMessage = 'Sesi Anda telah berakhir. Silakan login kembali.';
                                setTimeout(() => {
                                    window.location.href = '{{ route('login') }}';
                                }, 2000);
                            } else if (xhr.status === 500) {
                                errorMessage = 'Kesalahan server. Silakan coba lagi atau hubungi administrator.';
                            } else if (xhr.status === 0) {
                                errorMessage = 'Tidak dapat terhubung ke server. Periksa koneksi jaringan Anda.';
                            } else {
                                errorMessage = xhr.responseJSON?.error || 'Kesalahan tidak diketahui.';
                            }
                            showNotification(errorMessage, 'error');
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
                        { data: 'nama_jenis', defaultContent: '-' },
                        {
                            data: 'berat_gabah',
                            render: function(data) {
                                if (data === null || data === undefined) return '-';
                                const value = parseFloat(data);
                                return isNaN(value) ? '-' : value.toFixed(2);
                            }
                        },
                        { data: 'durasi_rekomendasi', defaultContent: '-' },
                        {
                            data: 'durasi_terlaksana',
                            render: function(data, type, row) {
                                console.log('Durasi terlaksana data:', { data, status: row.status, timestamp_mulai: row.timestamp_mulai });
                                return data || '0 jam 0 menit 0 detik';
                            }
                        },
                        {
                            data: 'status',
                            render: function(data) {
                                if (!data) return '-';
                                if (data.includes('Selesai')) return '<span class="status-selesai">Selesai</span>';
                                if (data.includes('Menunggu')) return '<span class="status-pending">Menunggu</span>';
                                if (data.includes('Berjalan')) return '<span class="status-proses">Berjalan</span>';
                                return data;
                            }
                        },
                        {
                            data: null,
                            render: function(data, type, row) {
                                let buttons = `<button class="btn btn-sm btn-detail" data-process-id="${row.process_id}">Detail</button>`;
                                if (row.status && row.status.includes('Menunggu')) {
                                    buttons += ` <button class="btn btn-sm btn-mulai" onclick="startProcess(${row.process_id})">Mulai</button>`;
                                } else if (row.status && row.status.includes('Berjalan')) {
                                    buttons += ` <button class="btn btn-sm btn-selesai" data-process-id="${row.process_id}" data-bs-toggle="modal" data-bs-target="#confirmCompleteModal">Selesai</button>`;
                                }
                                return buttons;
                            }
                        }
                    ],
                    order: [[3, 'desc']]
                });

                // Event handler untuk tombol Detail
                $('#data-table').on('click', '.btn-detail', function() {
                    const processId = $(this).data('process-id');
                    console.log('Detail button clicked for process ID:', processId);

                    fetch(`{{ config('services.api.base_url') }}/drying-process/${processId}`, {
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => {
                                    throw new Error(err.error || `Gagal mengambil detail proses: ${response.statusText}`);
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Detail data:', data);
                            if (data.success && data.data) {
                                const row = data.data;
                                $('#detail_nama_jenis').text(row.nama_jenis || '-');
                                const beratGabahStr = row.berat_gabah ? row.berat_gabah.replace(/,/g, '') : null;
                                const beratGabahValue = beratGabahStr && !isNaN(parseFloat(beratGabahStr)) ? parseFloat(beratGabahStr).toFixed(2) : '-';

                                $('#detail_berat_gabah').text(beratGabahValue);
                                $('#detail_suhu_gabah_awal').text(row.suhu_gabah_awal ? parseFloat(row.suhu_gabah_awal).toFixed(2) : '-');
                                $('#detail_suhu_ruangan_awal').text(row.suhu_ruangan_awal ? parseFloat(row.suhu_ruangan_awal).toFixed(2) : '-');
                                $('#detail_suhu_pembakaran_awal').text(row.suhu_pembakaran_awal ? parseFloat(row.suhu_pembakaran_awal).toFixed(2) : '-');
                                $('#detail_kadar_air_awal').text(row.kadar_air_awal ? parseFloat(row.kadar_air_awal).toFixed(2) : '-');
                                $('#detail_kadar_air_target').text(row.kadar_air_target ? parseFloat(row.kadar_air_target).toFixed(2) : '-');
                                $('#detail_suhu_gabah_akhir').text(row.suhu_gabah_akhir ? parseFloat(row.suhu_gabah_akhir).toFixed(2) : '-');
                                $('#detail_suhu_ruangan_akhir').text(row.suhu_ruangan_akhir ? parseFloat(row.suhu_ruangan_akhir).toFixed(2) : '-');
                                $('#detail_suhu_pembakaran_akhir').text(row.suhu_pembakaran_akhir ? parseFloat(row.suhu_pembakaran_akhir).toFixed(2) : '-');
                                $('#detail_kadar_air_akhir').text(row.kadar_air_akhir ? parseFloat(row.kadar_air_akhir).toFixed(2) : '-');
                                $('#detail_durasi_rekomendasi').text(row.durasi_rekomendasi || '-');
                                $('#detail_durasi_aktual').text(row.durasi_aktual || '-');
                                $('#detail_timestamp_mulai').text(row.timestamp_mulai || '-');
                                $('#detail_timestamp_selesai').text(row.timestamp_selesai || '-');

                                function formatStatus(status) {
                                    if (!status) return '-';
                                    if (status.toLowerCase().includes('selesai')) return 'Selesai';
                                    if (status.toLowerCase().includes('pending') || status.toLowerCase().includes('menunggu')) return 'Menunggu';
                                    if (status.toLowerCase().includes('ongoing')) return 'Berjalan';
                                    return status;
                                }

                                $('#detail_status').html(`<span class="status-proses">${formatStatus(row.status)}</span>`);

                                const detailModalElement = document.getElementById('detailDataModal');
                                const detailModal = new bootstrap.Modal(detailModalElement);
                                detailModal.show();
                            } else {
                                showNotification('Gagal Memuat Detail', 'Data tidak ditemukan.', 'error');
                            }
                        })
                        .catch(err => {
                            console.error('Error fetching detail:', err);
                            showNotification('Terjadi Kesalahan', err.message, 'error');
                        });
                });

                window.startProcess = function(processId) {
                    if (!sanctumToken) {
                        showNotification('Autentikasi Gagal', 'Silakan login untuk melanjutkan.', 'error');
                        setTimeout(() => {
                            window.location.href = '{{ route('login') }}';
                        }, 2000);
                        return;
                    }

                    console.log('Starting process:', processId);
                    fetch(`{{ config('services.api.base_url') }}/drying-process/${processId}/start`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => {
                            console.log('Start process response:', response);
                            if (!response.ok) {
                                return response.json().then(err => {
                                    throw new Error(err.error || `Gagal memulai proses: ${response.statusText}`);
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                table.ajax.reload(null, false);
                                showNotification('Proses Dimulai', 'Proses pengeringan dimulai.', 'success');
                            } else {
                                showNotification('Gagal Memulai Proses', data.error || 'Kesalahan server.', 'error');
                            }
                        })
                        .catch(err => {
                            console.error('Start process error:', err);
                            showNotification('Terjadi Kesalahan', err.message, 'error');
                            if (err.message.includes('Unauthorized')) {
                                setTimeout(() => {
                                    window.location.href = '{{ route('login') }}';
                                }, 2000);
                            }
                        });
                };

                // Handle click on Selesai button to show confirmation modal
                $('#data-table').on('click', '.btn-selesai', function() {
                    const processId = $(this).data('process-id');
                    console.log('Selesai button clicked for process ID:', processId);

                    // Store processId in the confirm button's data attribute
                    $('#confirmCompleteBtn').data('process-id', processId);

                    // Store the triggering button to restore focus later
                    $(this).data('triggering-button', this);

                    // Show the confirmation modal
                    const confirmModalElement = document.getElementById('confirmCompleteModal');
                    const confirmModal = new bootstrap.Modal(confirmModalElement);
                    confirmModal.show();
                });

                // Handle modal hidden event to restore focus
                $('#confirmCompleteModal').on('hidden.bs.modal', function() {
                    const triggeringButton = $('#confirmCompleteBtn').data('triggering-button');
                    if (triggeringButton) {
                        $(triggeringButton).focus();
                        $('#confirmCompleteBtn').removeData('triggering-button');
                    }
                });

                // Handle confirmation button click in the modal
                $('#confirmCompleteBtn').on('click', function() {
                    const processId = $(this).data('process-id');
                    const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmCompleteModal'));
                    confirmModal.hide();

                    // Store the triggering button for focus restoration
                    const triggeringButton = $(this).data('triggering-button');
                    completeProcess(processId, triggeringButton);
                });

                function completeProcess(processId, triggeringButton) {
                    if (!sanctumToken) {
                        showNotification('Autentikasi Gagal', 'Silakan login untuk melanjutkan.', 'error');
                        setTimeout(() => {
                            window.location.href = '{{ route('login') }}';
                        }, 2000);
                        return;
                    }

                    console.log('Completing process:', processId);
                    fetch(`{{ config('services.api.base_url') }}/get_sensor/realtime?user_id={{ auth()->id() }}&process_id=${processId}`, {
                        headers: {
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json'
                        }
                    })
                        .then(response => {
                            console.log('Sensor response:', response);
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
                            return response.json();
                        })
                        .then(sensorData => {
                            console.log('Sensor data:', sensorData);
                            // Validasi data sensor
                            if (!sensorData.sensors || 
                                sensorData.sensors.avg_grain_moisture == null || 
                                sensorData.sensors.avg_grain_temperature == null || 
                                sensorData.sensors.avg_room_temperature == null) {
                                showNotification('Gagal', 'Data sensor tidak lengkap atau tidak valid.', 'error');
                                return;
                            }

                            const kadarAirAkhir = parseFloat(sensorData.sensors.avg_grain_moisture);
                            const suhuGabahAkhir = parseFloat(sensorData.sensors.avg_grain_temperature);
                            const suhuRuanganAkhir = parseFloat(sensorData.sensors.avg_room_temperature);
                            const suhuPembakaranAkhir = parseFloat(sensorData.sensors.avg_burn_temperature || 0);

                            console.log('Parsed sensor values:', {
                                kadar_air_akhir: kadarAirAkhir,
                                suhu_gabah_akhir: suhuGabahAkhir,
                                suhu_ruangan_akhir: suhuRuanganAkhir,
                                suhu_pembakaran_akhir: suhuPembakaranAkhir
                            });

                            if (isNaN(kadarAirAkhir) || isNaN(suhuGabahAkhir) || isNaN(suhuRuanganAkhir) || isNaN(suhuPembakaranAkhir)) {
                                showNotification('Gagal', 'Data sensor mengandung nilai tidak valid.', 'error');
                                return;
                            }

                            const completeData = {
                                kadar_air_akhir: kadarAirAkhir,
                                suhu_gabah_akhir: suhuGabahAkhir,
                                suhu_ruangan_akhir: suhuRuanganAkhir,
                                suhu_pembakaran_akhir: suhuPembakaranAkhir,
                                timestamp_selesai: new Date().toISOString()
                            };

                            console.log('Sending complete data:', completeData);
                            sendCompleteRequest(processId, completeData, triggeringButton);
                        })
                        .catch(err => {
                            console.error('Error fetching sensor data:', err);
                            showNotification('Gagal Mengambil Data Sensor', err.message, 'error');
                        });
                }

                function sendCompleteRequest(processId, completeData, triggeringButton) {
                    fetch(`{{ config('services.api.base_url') }}/drying-process/${processId}/complete`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json',
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
                                showNotification('Proses Selesai', 'Proses pengeringan selesai.', 'success');
                                // Restore focus to the triggering button
                                if (triggeringButton) {
                                    $(triggeringButton).focus();
                                }
                            } else {
                                showNotification('Gagal Menyelesaikan', data.error || 'Kesalahan server.', 'error');
                            }
                        })
                        .catch(err => {
                            console.error('Complete process error:', err);
                            showNotification('Terjadi Kesalahan', err.message, 'error');
                            if (err.message.includes('Unauthorized')) {
                                setTimeout(() => {
                                    window.location.href = '{{ route('login') }}';
                                }, 2000);
                            }
                        });
                }

                document.getElementById('predictForm').addEventListener('submit', function(e) {
                    e.preventDefault();
                    const errorMessageDiv = document.getElementById('errorMessage');
                    const form = e.target;

                    // Reset error message
                    errorMessageDiv.style.display = 'none';
                    errorMessageDiv.innerText = '';

                    // Validasi data sensor
                    const suhuGabah = parseFloat(document.getElementById('suhu_gabah').value);
                    const suhuRuangan = parseFloat(document.getElementById('suhu_ruangan').value);
                    const suhuPembakaran = parseFloat(document.getElementById('suhu_pembakaran').value);
                    const kadarAirGabah = parseFloat(document.getElementById('kadar_air_gabah').value);
                    const jenisGabah = document.getElementById('jenis_gabah').value;
                    const beratGabah = parseFloat(document.getElementById('berat_gabah').value);
                    const kadarAirTarget = parseFloat(document.getElementById('kadar_air_target').value);

                    // Validasi input
                    if (isNaN(suhuGabah) || isNaN(suhuRuangan) || isNaN(suhuPembakaran) || isNaN(kadarAirGabah)) {
                        showNotification('Validasi Gagal', 'Data sensor tidak lengkap atau tidak valid.', 'error');
                        return;
                    }
                    if (!jenisGabah) {
                        showNotification('Validasi Gagal', 'Jenis gabah harus diisi.', 'error');
                        return;
                    }
                    if (isNaN(beratGabah) || beratGabah <= 0) {
                        showNotification('Validasi Gagal', 'Berat gabah harus lebih besar dari 0.', 'error');
                        return;
                    }
                    // if (isNaN(kadarAirTarget) || kadarAirTarget < 0 || kadarAirTarget > 100) {
                    //     showNotification('Validasi Gagal', 'Target kadar air harus antara 0-100.', 'error');
                    //     return;
                    // }

                    // Validasi token
                    if (!sanctumToken) {
                        showNotification('Autentikasi Gagal', 'Silakan login untuk melanjutkan.', 'error');
                        setTimeout(() => {
                            window.location.href = '{{ route('login') }}';
                        }, 2000);
                        return;
                    }

                    // Data untuk dikirim ke Flask
                    const data = {
                        nama_jenis: jenisGabah,
                        kadar_air_gabah: kadarAirGabah,
                        suhu_gabah: suhuGabah,
                        suhu_ruangan: suhuRuangan,
                        suhu_pembakaran: suhuPembakaran,
                        berat_gabah: beratGabah,
                        kadar_air_target: kadarAirTarget
                    };

                    console.log('Data yang dikirim ke ML:', JSON.stringify(data, null, 2));

                    // Kirim data ke Flask
                    fetch('http://192.168.43.142:5000/predict', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                        .then(response => {
                            console.log('Respons dari ML:', response);
                            if (!response.ok) {
                                return response.json().then(errorData => {
                                    throw new Error(`Gagal mendapatkan prediksi: ${response.statusText} - ${JSON.stringify(errorData)}`);
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            // Validasi respons Flask
                            if (!data.durasi_rekomendasi || !data.suhu_pembakaran) {
                                throw new Error('Respons Flask tidak lengkap: durasi_rekomendasi atau suhu_pembakaran hilang.');
                            }

                            const durasiMenit = parseFloat(data.durasi_rekomendasi);
                            // Data untuk dikirim ke Laravel
                            const storeData = {
                                nama_jenis: data.nama_jenis,
                                suhu_gabah_awal: data.suhu_gabah,
                                suhu_ruangan_awal: data.suhu_ruangan,
                                suhu_pembakaran_awal: data.suhu_pembakaran,
                                kadar_air_awal: data.kadar_air_gabah,
                                kadar_air_target: data.kadar_air_target,
                                berat_gabah: data.berat_gabah,
                                durasi_rekomendasi: durasiMenit
                            };

                            console.log('Data yang dikirim ke /prediksi/store:', JSON.stringify(storeData, null, 2));

                            // Kirim data ke Laravel
                            fetch('{{ config('services.api.base_url') }}/prediksi/store', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json',
                                    'Authorization': `Bearer ${sanctumToken}`
                                },
                                body: JSON.stringify(storeData)
                            })
                                .then(response => {
                                    console.log('Respons dari /prediksi/store:', response);
                                    if (!response.ok) {
                                        return response.json().then(err => {
                                            throw new Error(err.error || `Gagal menyimpan data (Status: ${response.status})`);
                                        });
                                    }
                                    return response.json();
                                })
                                .then(data => {
                                    if (data.success) {
                                        const modalElement = document.getElementById('tambahDataModal');
                                        const modal = new bootstrap.Modal(modalElement);
                                        modal.hide();
                                        modalElement.addEventListener('hidden.bs.modal', function() {
                                            document.querySelectorAll('.modal-backdrop').forEach(backdrop => backdrop.remove());
                                            document.body.classList.remove('modal-open');
                                            document.body.style.paddingRight = '';
                                            showNotification('Proses Dimulai', `Pengeringan dimulai dengan durasi ${durasiMenit} menit.`, 'success');
                                            form.reset();
                                            table.ajax.reload(null, false);
                                            startSensorMonitoring(data.data.process_id, sanctumToken);
                                        }, { once: true });
                                    } else {
                                        throw new Error(data.error || 'Gagal menyimpan data.');
                                    }
                                })
                                .catch(err => {
                                    console.error('Error:', err);
                                    showNotification('Gagal Memulai Proses', err.message, 'error');
                                    if (err.message.includes('Unauthorized')) {
                                        setTimeout(() => {
                                            window.location.href = '{{ route('login') }}';
                                        }, 2000);
                                    }
                                });
                        })
                        .catch(error => {
                            console.error('ML Error:', error);
                            showNotification('Gagal Prediksi', `Server ML error: ${error.message}`, 'error');
                        });
                });

                function startSensorMonitoring(processId, token) {
                    if (!token) {
                        console.error('No token provided for sensor monitoring');
                        return;
                    }

                    setInterval(function() {
                        fetch(`{{ config('services.api.base_url') }}/get_sensor/realtime?user_id={{ auth()->id() }}&process_id=${processId}`, {
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
                                if (sensorData.success && sensorData.sensors && sensorData.sensors.avg_grain_moisture !== undefined) {
                                    const currentKadarAir = parseFloat(sensorData.sensors.avg_grain_moisture);
                                    const suhuGabahAkhir = parseFloat(sensorData.sensors.avg_grain_temperature);
                                    const suhuRuanganAkhir = parseFloat(sensorData.sensors.avg_room_temperature);
                                    const suhuPembakaranAkhir = parseFloat(sensorData.sensors.avg_burning_temperature || 0);

                                    const table = $('#data-table').DataTable();
                                    const row = table.rows().data().toArray().find(r => r.process_id === processId);
                                    if (!row || row.status !== 'Berjalan') return;

                                    const kadarAirTarget = parseFloat(row.kadar_air_target);
                                    const startTime = new Date(row.timestamp_mulai);
                                    const now = new Date();
                                    const durasiTerlaksana = Math.floor((now - startTime) / (1000 * 60));

                                    fetch(`{{ config('services.api.base_url') }}/drying-process/${processId}/update-duration`, {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'Authorization': `Bearer ${token}`,
                                            'Accept': 'application/json'
                                        },
                                        body: JSON.stringify({
                                            durasi_terlaksana: durasiTerlaksana,
                                            kadar_air_akhir: currentKadarAir,
                                            suhu_gabah_akhir: suhuGabahAkhir,
                                            suhu_ruangan_akhir: suhuRuanganAkhir,
                                            suhu_pembakaran_akhir: suhuPembakaranAkhir
                                        })
                                    })
                                        .then(response => {
                                            if (!response.ok) {
                                                throw new Error(`Gagal memperbarui durasi: ${response.statusText}`);
                                            }
                                            return response.json();
                                        })
                                        .then(data => {
                                            if (data.success) {
                                                table.ajax.reload(null, false);
                                                if (data.message && data.message.includes('selesai secara otomatis')) {
                                                    showNotification('Proses Selesai', `Proses ${processId} selesai! Kadar air target tercapai.`, 'success');
                                                }
                                            }
                                        })
                                        .catch(err => console.error('Error updating duration:', err));
                                }
                            })
                            .catch(err => console.error('Error fetching sensor data:', err));
                    }, 60000);
                }
            });
        })(jQuery.noConflict(true));
    </script>
@endsection
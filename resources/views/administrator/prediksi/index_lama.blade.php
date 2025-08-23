@extends('layout.app')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
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
            /* Warna background biru muda */
            color: #1E3B8A;
            border-radius: 8px;
            padding: 4px 8px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
            border: none;
            cursor: pointer;
        }

        .btn-detail-number:hover {
            background-color: #A0B8FF;
            /* Warna lebih gelap saat hover */
            transform: scale(1.05);
        }

        /* Sidebar Styles */
        /* .sidebar {
                            position: fixed;
                            top: 0;
                            right: 0;
                            height: 100%;
                            width: 300px;
                            background-color: #fff;
                            box-shadow: -2px 0 8px rgba(0, 0, 0, 0.15);
                            transform: translateX(100%);
                            transition: transform 0.3s ease-in-out;
                            z-index: 1000;
                            overflow-y: auto;
                            padding: 20px;
                        }

                        .sidebar.open {
                            transform: translateX(0);
                        }

                        .sidebar-toggle {
                            position: fixed;
                            top: 50%;
                            right: 0;
                            background-color: #1E3A8A;
                            color: white;
                            padding: 10px;
                            border-radius: 8px 0 0 8px;
                            cursor: pointer;
                            transform: translateY(-50%);
                            z-index: 1001;
                            transition: right 0.3s ease-in-out;
                        }

                        .sidebar.open+.sidebar-toggle {
                            right: 300px;
                        }

                        .content-sidebar {
                            margin-top: 20px;
                        }

                        .content-sidebar h3 {
                            font-size: 16px;
                            font-weight: 600;
                            color: #1E3A8A;
                            margin-bottom: 10px;
                        }

                        .content-sidebar p {
                            color: #1E3A8A;
                            opacity: 0.8;
                            margin-bottom: 8px;
                        } */

        .mini-sidebar {
            position: fixed;
            bottom: 0;
            left: 60%;
            transform: translateX(-50%);
            width: 300px;
            height: 95px;
            background-color: #ffffff;
            border-top: 1px solid #e5e7eb;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
            box-shadow: 0 -2px 4px rgba(0, 0, 0, 0.1);
            transition: height 0.3s ease;
            z-index: 1000;
            overflow: hidden;
        }

        .mini-sidebar.expanded {
            height: 250px;
        }

        .content-sidebar {
            padding: 8px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .expand-handle {
            width: 40px;
            height: 4px;
            background-color: #1E3A8A;
            border-radius: 2px;
            margin: 0 auto;
            cursor: pointer;
        }

        .duration-option {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 12px;
            background-color: #1f46811f;
            border-radius: 6px;
            transition: background-color 0.2s;
            font-size: 18px;
        }

        .duration-option:hover {
            background-color: #1f468133;
        }

        .detail-section {
            display: none;
            flex-direction: column;
            gap: 8px;
            margin-top: 8px;
            padding-top: 8px;
            border-top: 1px solid #e5e7eb;
            padding-left: 8px;
        }

        .expanded .detail-section {
            display: flex;
        }

        .no-process {
            color: #6b7280;
            font-size: 13px;
            text-align: center;
            padding: 8px;
        }

        h3 {
            font-size: 16px;
            font-weight: 600;
            color: #1e3a8a;
            margin: 0;
        }

        p {
            font-size: 15px;
            color: #374151;
            margin: 4px 0;
        }

        .span {
            font-weight: 500;
            color: #1e3a8a;
        }
    </style>

    <style>
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
            color: #fff;
            border-radius: 15px;
            padding: 5px 15px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .btn-detail:hover {
            background-color: #C4D4FF;
            transform: scale(1.05);
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
        }

        .modal-detail .btn-close {
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

        /* Responsive layout */
        @media (max-width: 1024px) {
            .flex.lg\:flex-row {
                flex-direction: column;
            }

            .w-full.lg\:w-1\/2 {
                width: 100%;
            }
        }
    </style>

    <div id="notification" class="alert position-fixed top-0 end-0 m-4">
        <div id="notificationTitle" style="font-weight: bold;"></div>
        <div id="notificationMessage"></div>
    </div>

    <!-- Card Tambahan -->
    <div class="bg-[#1E3A8A] text-white shadow-lg p-9 mb-6" style="border-radius: 10px;">
        <p class="text-white/85" style="padding-bottom: 8px;">Status Pengeringan</p>
        <h3 id="statusText" class="text-2xl font-bold mb-2 tracking-wide" style="color: white;">Nonaktif</h3>

        <!-- Card Kadar Air Gabah -->
        <div class="bg-white/10 text-white h-[48px] flex items-center px-4 relative" style="border-radius: 10px;">
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
                                    <option value="{{ $grain['grain_type_id'] }}">{{ $grain['nama_jenis'] }}</option>
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

    <!-- Grid Cards and DataTable Container -->
    <div class="flex flex-col gap-6 mt-6">
        <!-- Grid Cards -->
        <div class="w-full">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Card 1: Suhu Gabah -->
                <div style="    height: 110px;
    background-color: rgb(127 144 190 / 16%);
    border: 1px solid #1e3b8a42;"
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
                        <h3 style="font-weight: 500;
    font-size: 16px;
    margin-bottom: 6px;">Suhu Gabah</h3>
                        <p id="suhuGabahText" class="text-[#1E3A8A]/80 text-xl" style="font-size: 16px;">0°C</p>
                    </div>
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-[#1E3A8A]" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>

                <!-- Card 2: Suhu Ruangan -->
                <div style="    height: 110px;
    background-color: rgb(127 144 190 / 16%);
    border: 1px solid #1e3b8a42;"
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
                        <h3 style="font-weight: 500;
    font-size: 16px;
    margin-bottom: 6px;">Suhu Ruangan</h3>
                        <p id="suhuRuanganText" class="text-[#1E3A8A]/80 text-xl" style="font-size: 16px;">0°C</p>
                    </div>
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-[#1E3A8A]" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>

                <!-- Card 3: Suhu Pembakaran -->
                <div style="    height: 110px;
    background-color: rgb(127 144 190 / 16%);
    border: 1px solid #1e3b8a42;"
                    class="text-[#1E3A8A] rounded-[12px] shadow-md p-6 flex items-center cursor-pointer relative">
                    <svg class="h-8 w-8 mr-4" width="40" height="40" viewBox="0 0 39 39" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M30.264 20.681C29.9325 19.8924 29.5559 18.9991 29.1878 17.8961C28.225 15.0089 31.3012 11.8597 31.3304 11.8304L29.6071 10.1071C29.4365 10.2777 25.4353 14.3459 26.8747 18.6664C27.272 19.8583 27.6693 20.7992 28.0178 21.6279C28.8304 23.2352 29.2525 25.0115 29.25 26.8125C29.1072 28.2643 28.5498 29.6443 27.6444 30.7881C26.7389 31.9319 25.5237 32.7911 24.1434 33.2633C24.5795 31.5543 24.573 29.7623 24.1245 28.0564C23.6761 26.3506 22.8005 24.7871 21.5804 23.5133L20.308 22.241L19.5987 23.8948C17.3611 29.1159 14.6981 31.395 13.132 32.3456C12.1704 31.7571 11.3622 30.9486 10.7742 29.9866C10.1863 29.0246 9.8352 27.9367 9.75 26.8125C9.83331 25.2782 10.218 23.7753 10.8822 22.3897C11.6701 20.7194 12.114 18.9078 12.1875 17.0625V14.8956C13.2527 15.3343 14.625 16.4836 14.625 19.5V22.6736L16.7493 20.3153C20.542 16.1058 19.7511 11.0931 18.2191 7.75247C19.3836 8.14064 20.3836 8.90939 21.0581 9.93496C21.7326 10.9605 22.0424 12.1832 21.9375 13.4062H24.375C24.375 6.65803 18.7943 4.875 15.8438 4.875H13.4062L14.8687 6.82378C15.0357 7.04925 18.3568 11.6098 16.5177 16.1935C16.1089 15.0414 15.359 14.041 14.3678 13.3254C13.3766 12.6098 12.191 12.2129 10.9688 12.1875H9.75V17.0625C9.66669 18.5968 9.28196 20.0997 8.61778 21.4853C7.82992 23.1556 7.38602 24.9672 7.3125 26.8125C7.3125 31.5023 11.9718 36.5625 19.5 36.5625C27.0282 36.5625 31.6875 31.5023 31.6875 26.8125C31.6883 24.6867 31.2013 22.589 30.264 20.681ZM15.6427 33.5473C17.8908 31.6863 19.7069 29.3582 20.9649 26.7247C21.6371 27.8089 22.019 29.0479 22.0738 30.3223C22.1287 31.5968 21.8547 32.864 21.2782 34.0019C20.6888 34.0823 20.0948 34.1235 19.5 34.125C18.192 34.1346 16.8905 33.9397 15.6427 33.5473Z"
                            fill="#1E3A8A" />
                    </svg>
                    <div>
                        <h3 style="font-weight: 500;
    font-size: 16px;
    margin-bottom: 6px;">Suhu Pembakaran</h3>
                        <p id="suhuPembakaranText" class="text-[#1E3A8A]/80 text-xl" style="font-size: 16px;">0°C</p>
                    </div>
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-[#1E3A8A]" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>

                <!-- Card 4: Status Pengaduk -->
                <div style="    height: 110px;
    background-color: rgb(127 144 190 / 16%);
    border: 1px solid #1e3b8a42;"
                    class="text-[#1E3A8A] rounded-[12px] shadow-md p-6 flex items-center cursor-pointer relative">

                    <!-- Ganti SVG dengan Font Awesome -->
                    <i class="fa-solid fa-arrows-rotate text-2xl mr-4 text-[#1E3A8A]"></i>

                    <div>
                        <h3 style="font-weight: 500;
    font-size: 16px;
    margin-bottom: 6px;">Status Pengaduk</h3>
                        <p id="statusPengadukText" class="text-[#1E3A8A]/80 text-xl" style="font-size: 16px;">Nonaktif
                        </p>
                    </div>

                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-[#1E3A8A]" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>

            </div>
        </div>
    </div>

    <div class="mini-sidebar" id="miniSidebar">
        <div class="content-sidebar" style="border: 1px solid #c6d0ec;">
            <!-- Handle di luar dari duration-option -->
            <div class="expand-handle" onclick="toggleSidebar()"></div>

            <div class="duration-option" onclick="toggleSidebar()">
                <span class="span" id="durasiLabel">Estimasi: <span id="durasiText">0 menit</span></span>
            </div>

            <div class="detail-section">
                <h3>Detail Pengeringan:</h3>
                <p>Durasi Terlaksana: <span class="span" id="durasiTerlaksanaText">Tidak tersedia</span></p>
                <p>Kadar Air Saat Ini: <span class="span" id="kadarAirSaatIni">Tidak tersedia</span></p>
                <p>Target Kadar Air: <span class="span" id="targetKadarAir">14%</span></p>
            </div>

            <div class="no-process" id="noProcessMessage" style="display: none;">
                Tidak ada proses aktif
            </div>
        </div>
    </div>

    <script>
        // Toggle Sidebar
        window.toggleSidebar = function() {
            const sidebar = document.getElementById('miniSidebar');
            sidebar.classList.toggle('expanded');
        };

        (function() {
            // ==== Helpers ====
            const isNum = (v) =>
                v !== null && v !== '' && !Number.isNaN(Number(v)) && Number.isFinite(parseFloat(v));

            const fmtPct = (v) => (isNum(v) ? `${parseFloat(v).toFixed(2)}%` : 'Tidak tersedia');

            const fmtDur = (m) => {
                const n = parseFloat(m);
                if (!isNum(n) || n <= 0) return '0 menit';
                const h = Math.floor(n / 60);
                const mm = Math.floor(n % 60);
                return h > 0 ? `${h} jam ${mm} menit` : `${mm} menit`;
            };

            // Parser timestamp robust
            function parseAnyTs(ts) {
                if (!ts) return null;

                // 1) ISO/offset langsung
                let d = new Date(ts);
                if (!isNaN(d.getTime())) return d;

                // 2) Ganti spasi ke 'T'
                d = new Date(String(ts).replace(' ', 'T'));
                if (!isNaN(d.getTime())) return d;

                // 3) Regex fallback (support fraksi detik & offset)
                const m = String(ts).match(
                    /^(\d{4})-(\d{2})-(\d{2})[ T](\d{2}):(\d{2})(?::(\d{2})(?:\.\d{1,6})?)?(Z|[+\-]\d{2}:\d{2})?$/
                );
                if (m) {
                    if (m[7]) {
                        d = new Date(String(ts).replace(' ', 'T'));
                        if (!isNaN(d.getTime())) return d;
                    }
                    const y = parseInt(m[1], 10);
                    const mo = parseInt(m[2], 10) - 1;
                    const da = parseInt(m[3], 10);
                    const hh = parseInt(m[4] || '0', 10);
                    const mm = parseInt(m[5] || '0', 10);
                    const ss = parseInt(m[6] || '0', 10);
                    d = new Date(y, mo, da, hh, mm, ss);
                    if (!isNaN(d.getTime())) return d;
                }
                return null;
            }

            function minutesSince(ts) {
                const start = parseAnyTs(ts);
                if (!start) return 0;
                const now = new Date();
                const diffMin = Math.floor((now.getTime() - start.getTime()) / 60000);
                return Math.max(0, diffMin);
            }

            function showNoProcess() {
                document.getElementById('durasiText').innerText = '0 menit';
                document.getElementById('durasiTerlaksanaText').innerText = 'Tidak tersedia';
                document.getElementById('kadarAirSaatIni').innerText = 'Tidak tersedia';
                document.getElementById('targetKadarAir').innerText = '14%';
                document.getElementById('miniSidebar').style.display = 'block';
                document.getElementById('noProcessMessage').style.display = 'block';
                document.querySelector('.duration-option').style.display = 'none';
                document.getElementById('miniSidebar').classList.remove('expanded');
            }

            // ==== Durasi ticker (update tiap menit tanpa fetch ulang) ====
            let durasiTimer = null;
            let lastPid = null;
            let lastStartTs = null;

            function startDurasiTicker(tsMulai) {
                if (durasiTimer) {
                    clearInterval(durasiTimer);
                    durasiTimer = null;
                }
                const apply = () => {
                    const m = minutesSince(tsMulai);
                    document.getElementById('durasiTerlaksanaText').innerText = fmtDur(m);
                };
                apply(); // set awal
                durasiTimer = setInterval(apply, 60000); // per menit
            }

            // === NEW: ambil timestamp_mulai dari API /drying-process/{process_id} (fallback)
            async function fetchStartTs(processId, headers) {
                try {
                    const res = await fetch(
                        "{{ config('services.api.base_url') }}/drying-process/" + processId, {
                            headers
                        }
                    );
                    if (!res.ok) return null;
                    const j = await res.json();
                    // struktur controller: { data: { timestamp_mulai: "..." } }
                    return j?.data?.timestamp_mulai || null;
                } catch {
                    return null;
                }
            }

            // ==== Fetch & render mini-sidebar ====
            async function updateSidebar() {
                try {
                    const token =
                        (typeof sanctumToken !== 'undefined' && sanctumToken) ?
                        sanctumToken :
                        (localStorage.getItem('sanctum_token') || '');

                    const headers = {
                        Accept: 'application/json'
                    };
                    if (token) headers['Authorization'] = 'Bearer ' + token;

                    const pid = localStorage.getItem('active_process_id') || '';
                    const url =
                        "{{ config('services.api.base_url') }}/get_sensor/realtime?user_id={{ auth()->id() ?? 1 }}" +
                        (pid ? `&process_id=${pid}` : '');

                    const res = await fetch(url, {
                        headers
                    });
                    if (!res.ok) throw new Error(`${res.status} ${res.statusText}`);
                    const data = await res.json();

                    const dp = data.drying_process || data?.data?.drying_process || null;
                    const s = data.sensors || {};

                    if (!dp || dp.status !== 'ongoing') {
                        showNoProcess();
                        if (durasiTimer) {
                            clearInterval(durasiTimer);
                            durasiTimer = null;
                        }
                        lastPid = null;
                        lastStartTs = null;
                        return;
                    }

                    // Estimasi (durasi_rekomendasi) dari DB
                    const durasiRekom = isNum(dp.durasi_rekomendasi) ? parseFloat(dp.durasi_rekomendasi) : 0;
                    document.getElementById('durasiText').innerText = fmtDur(durasiRekom);

                    // Kadar air saat ini (realtime)
                    document.getElementById('kadarAirSaatIni').innerText = fmtPct(s?.avg_grain_moisture);

                    // Target kadar air
                    const target = isNum(dp.kadar_air_target) ? dp.kadar_air_target : 14;
                    document.getElementById('targetKadarAir').innerText = `${parseFloat(target).toFixed(0)}%`;

                    // === FIXED: Durasi Terlaksana → cari timestamp_mulai dari beberapa sumber + fallback API ===
                    const cacheKey = 'process_start_ts_' + dp.process_id;
                    let tsMulai =
                        dp.timestamp_mulai ||
                        dp.timestamp_mulai_mentah ||
                        dp.timestampMulai ||
                        dp.start_time ||
                        localStorage.getItem(cacheKey) ||
                        null;

                    if (!tsMulai) {
                        // fallback ke /drying-process/{process_id}
                        tsMulai = await fetchStartTs(dp.process_id, headers);
                        if (tsMulai) {
                            localStorage.setItem(cacheKey, tsMulai);
                        }
                    }

                    if (tsMulai) {
                        // restart ticker jika process/ts berubah
                        if (String(lastPid) !== String(dp.process_id) || lastStartTs !== tsMulai) {
                            lastPid = dp.process_id;
                            lastStartTs = tsMulai;
                            startDurasiTicker(tsMulai);
                        } else {
                            // refresh sekali saat fetch
                            document.getElementById('durasiTerlaksanaText').innerText = fmtDur(minutesSince(
                                tsMulai));
                        }
                    } else {
                        document.getElementById('durasiTerlaksanaText').innerText = 'Tidak tersedia';
                        if (durasiTimer) {
                            clearInterval(durasiTimer);
                            durasiTimer = null;
                        }
                    }

                    // tampilkan panel
                    document.getElementById('miniSidebar').style.display = 'block';
                    document.getElementById('noProcessMessage').style.display = 'none';
                    document.querySelector('.duration-option').style.display = 'flex';
                } catch (err) {
                    console.error('mini-sidebar realtime error:', err);
                    showNoProcess();
                    if (durasiTimer) {
                        clearInterval(durasiTimer);
                        durasiTimer = null;
                    }
                    lastPid = null;
                    lastStartTs = null;
                }
            }

            // panggil awal & refresh setiap 30 detik
            updateSidebar();
            setInterval(updateSidebar, 30000);
        })();
    </script>


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
    <div class="modal fade modal-confirm" id="confirmCompleteModal" tabindex="-1"
        aria-labelledby="confirmCompleteModalLabel" aria-hidden="true">
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

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        async function fetchDurasiTerlaksana() {
            try {
                const response = await fetch("{{ config('services.api.base_url') }}/drying-process");
                const result = await response.json();

                console.log("Response JSON:", result);

                let data = [];

                // Coba deteksi array data
                if (Array.isArray(result)) {
                    data = result;
                } else if (Array.isArray(result.data)) {
                    data = result.data;
                } else if (Array.isArray(result.data?.data)) {
                    data = result.data.data;
                } else {
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
                    const mulai = new Date(ongoing.timestamp_mulai); // UTC
                    const now = new Date(); // local time
                    const selisihMs = now - mulai;
                    totalMenit = Math.floor(selisihMs / (1000 * 60));
                }

                document.getElementById('durasiTerlaksanaText').textContent = `${totalMenit} menit`;

            } catch (error) {
                console.error("Gagal mengambil data durasi:", error);
                document.getElementById('durasiTerlaksanaText').textContent = "Gagal memuat";
            }
        }

        // Jalankan saat halaman selesai dimuat
        fetchDurasiTerlaksana();

        // Opsional: perbarui setiap 1 menit
        setInterval(fetchDurasiTerlaksana, 60000);
    </script>


    <script>
        (function($) {
            $(document).ready(function() {
                // Retrieve Sanctum token
                const sanctumToken = localStorage.getItem('sanctum_token') ||
                    "{{ session('sanctum_token') ?? '' }}";
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

                // Handle click on Selesai button to show confirmation modal
                $(document).on('click', '.btn-selesai', function() {
                    const processId = $(this).data('process-id');
                    console.log('Selesai button clicked for process ID:', processId);

                    // Store processId in the confirm button's data attribute
                    $('#confirmCompleteBtn').data('process-id', processId);

                    // Store the triggering button to restore focus later
                    $('#confirmCompleteBtn').data('triggering-button', this);

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
                    const confirmModal = bootstrap.Modal.getInstance(document.getElementById(
                        'confirmCompleteModal'));
                    confirmModal.hide();

                    // Store the triggering button for focus restoration
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

                    console.log('Completing process:', processId);
                    try {
                        const response = await fetch(
                            `{{ config('services.api.base_url') }}/get_sensor/realtime?user_id={{ auth()->id() }}&process_id=${processId}`, {
                                headers: {
                                    'Authorization': `Bearer ${sanctumToken}`,
                                    'Accept': 'application/json'
                                }
                            });

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

                        const sensorData = await response.json();
                        console.log('Sensor data:', sensorData);
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
                            berat_gabah_akhir: null,
                            timestamp_selesai: new Date().toISOString().slice(0, 19).replace('T', ' ')
                        };

                        console.log('Sending complete data:', completeData);
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
                            });

                        console.log('Complete process response:', response);
                        if (!response.ok) {
                            const err = await response.json();
                            throw new Error(err.error ||
                                `Gagal menyelesaikan proses: ${response.statusText}`);
                        }

                        const data = await response.json();
                        if (data.success) {
                            showNotification('Proses Selesai', 'Proses pengeringan selesai.', 'success');
                            if (triggeringButton) {
                                $(triggeringButton).focus();
                            }
                            setTimeout(() => {
                                window.location.reload();
                            }, 2000);
                        } else {
                            showNotification('Gagal Menyelesaikan', data.error || 'Kesalahan server.',
                                'error');
                        }
                    } catch (err) {
                        console.error('Complete process error:', err);
                        showNotification('Terjadi Kesalahan', err.message, 'error');
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

    <!-- Single Modal -->
    {{-- <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
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
    </div> --}}

    <script>
        // Konfigurasi
        const sanctumToken = "{{ session('sanctum_token') ?? '' }}";
        const baseUrl = "{{ config('services.api.base_url') }}"; // e.g., http://gabahapi.test/api
        const mlServerUrl = "http://192.168.43.142:5000";
        const userId = {{ auth()->id() ?? 'null' }};
        const POLLING_INTERVAL = 5000; // Polling setiap 5 detik
        const INITIAL_POLLING_INTERVAL = 3000; // Polling awal setiap 3 detik
        const MAX_RETRIES = 3; // Maksimum percobaan ulang

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

        // Fungsi pembantu untuk format durasi
        function formatDuration(minutes) {
            if (!isNumeric(minutes) || minutes <= 0) return '0 menit';
            const totalMinutes = parseFloat(minutes);
            const hours = Math.floor(totalMinutes / 60);
            const minutesPart = Math.floor(totalMinutes % 60);
            return hours > 0 ? `${hours} jam ${minutesPart} menit` : `${minutesPart} menit`;
        }

        // Fungsi pembantu untuk cek nilai numerik
        function isNumeric(value) {
            return !isNaN(parseFloat(value)) && isFinite(value);
        }

        // Cek koneksi ke server ML
        async function checkMLServer() {
            try {
                const response = await fetch(`${mlServerUrl}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                if (!response.ok) throw new Error(`Gagal cek server ML: HTTP ${response.status}`);
                return true;
            } catch (err) {
                console.error('Error cek server ML:', err);
                return false;
            }
        }

        // Ambil data sensor dengan retry
        async function fetchSensorData(processId = null, retries = MAX_RETRIES) {
            const userId = {{ auth()->id() ?? 1 }};
            const url = processId ?
                `${baseUrl}/get_sensor/realtime?user_id=${userId}&process_id=${processId}` :
                `${baseUrl}/get_sensor/realtime?user_id=${userId}`;

            console.log('Mengambil data sensor dari:', url);
            try {
                const response = await fetch(url, {
                    headers: {
                        'Authorization': `Bearer ${sanctumToken}`,
                        'Accept': 'application/json'
                    }
                });
                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(errorData.error || `HTTP ${response.status}: ${response.statusText}`);
                }
                const data = await response.json();
                console.log('Data sensor diterima:', JSON.stringify(data, null, 2));

                if (data.sensors && data.sensors.data) {
                    data.sensors.data.forEach(sensor => {
                        sensorDataByDevice[sensor.device_name] = {
                            kadar_air_gabah: parseFloat(sensor.kadar_air_gabah) || 0,
                            suhu_gabah: parseFloat(sensor.suhu_gabah) || 0,
                            suhu_ruangan: parseFloat(sensor.suhu_ruangan) || 0,
                            suhu_pembakaran: parseFloat(sensor.suhu_pembakaran) || 0,
                            timestamp: sensor.timestamp
                        };
                    });
                }
                updateUI(data);
                updateModalForm(data.sensors);
                return data;
            } catch (err) {
                console.error('Error mengambil data sensor:', err);
                if (retries > 0) {
                    console.log(`Mencoba lagi... (${MAX_RETRIES - retries + 1}/${MAX_RETRIES})`);
                    await new Promise(resolve => setTimeout(resolve, 2000));
                    return fetchSensorData(processId, retries - 1);
                }
                showNotification(`Gagal memuat data sensor: ${err.message}`, 'bg-red-500');
                return {
                    sensors: {
                        data: [],
                        avg_grain_moisture: 0,
                        avg_grain_temperature: 0,
                        avg_room_temperature: 0,
                        avg_combustion_temperature: null
                    },
                    drying_process: null
                };
            }
        }

        // Update UI dengan data sensor
        function updateUI(data) {
            const dryingProcess = data.drying_process;
            const sensors = data.sensors || {};

            kadarAirText.innerText = isNumeric(sensors.avg_grain_moisture) ?
                `${sensors.avg_grain_moisture.toFixed(2)}%` : '0.00%';
            suhuGabahText.innerText = isNumeric(sensors.avg_grain_temperature) ?
                `${sensors.avg_grain_temperature.toFixed(2)}°C` : '0.00°C';
            suhuRuanganText.innerText = isNumeric(sensors.avg_room_temperature) ?
                `${sensors.avg_room_temperature.toFixed(2)}°C` : '0.00°C';
            suhuPembakaranText.innerText = isNumeric(sensors.avg_combustion_temperature) ?
                `${sensors.avg_combustion_temperature.toFixed(2)}°C` :
                sensors.avg_combustion_temperature === null ? 'Data tidak tersedia' : '0.00°C';

            if (dryingProcess && dryingProcess.status === 'ongoing') {
                statusText.innerText = 'Aktif';
                toggleButton.innerText = 'STOP';
                toggleButton.removeAttribute('data-bs-toggle');
                toggleButton.removeAttribute('data-bs-target');
                toggleButton.onclick = () => showConfirmStopModal(dryingProcess.process_id);
                durasiText.innerText = formatDuration(dryingProcess.durasi_rekomendasi);
                if (!sensorInterval) startSensorMonitoring(dryingProcess.process_id);
            } else {
                statusText.innerText = 'Nonaktif';
                toggleButton.innerText = 'START';
                toggleButton.setAttribute('data-bs-toggle', 'modal');
                toggleButton.setAttribute('data-bs-target', '#tambahDataModal');
                toggleButton.onclick = null;
                durasiText.innerText = '0 menit';
                if (!sensorInterval) startSensorMonitoring(null);
            }
        }

        // Reset UI
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

        // Update form modal dengan data sensor
        function updateModalForm(sensors) {
            suhuGabahInput.value = isNumeric(sensors?.avg_grain_temperature) ? sensors.avg_grain_temperature.toFixed(2) :
                '';
            suhuRuanganInput.value = isNumeric(sensors?.avg_room_temperature) ? sensors.avg_room_temperature.toFixed(2) :
                '';
            kadarAirGabahInput.value = isNumeric(sensors?.avg_grain_moisture) ? sensors.avg_grain_moisture.toFixed(2) : '';
            suhuPembakaranInput.value = isNumeric(sensors?.avg_combustion_temperature) ? sensors.avg_combustion_temperature
                .toFixed(2) : '';
        }

        // Mulai pemantauan sensor
        function startSensorMonitoring(processId) {
            if (sensorInterval) clearInterval(sensorInterval);
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
                    .catch(err => console.error('Error polling:', err));
            }, POLLING_INTERVAL);
        }

        // Tampilkan modal konfirmasi stop
        function showConfirmStopModal(processId) {
            const confirmButton = document.getElementById('confirmStopButton');
            confirmButton.onclick = () => completeProcess(processId);
            const modal = new bootstrap.Modal(document.getElementById('confirmStopModal'));
            modal.show();
        }

        // Selesaikan proses pengeringan
        async function completeProcess(processId) {
            const confirmModalElement = document.getElementById('confirmStopModal');
            const confirmModal = bootstrap.Modal.getInstance(confirmModalElement);
            const data = await fetchSensorData(processId);
            const sensors = data.sensors || {};

            try {
                const response = await fetch(`${baseUrl}/drying-process/${processId}/complete`, {
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
                        suhu_ruangan_akhir: parseFloat(sensors.avg_room_temperature) || 0,
                        suhu_pembakaran_akhir: parseFloat(sensors.avg_combustion_temperature) || 0
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({}));
                    throw new Error(errorData.error || `HTTP ${response.status}: ${response.statusText}`);
                }
                const result = await response.json();
                if (result.message === 'Drying process completed successfully') {
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
                    showNotification(`Gagal menyelesaikan proses: ${result.error || 'Kesalahan server.'}`,
                        'bg-red-500');
                }
            } catch (err) {
                console.error('Error menyelesaikan proses:', err);
                showNotification(`Gagal menyelesaikan proses: ${err.message}`, 'bg-red-500');
            }
        }

        // Tampilkan notifikasi
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
                if (reload) location.reload();
            }, 5000);
        }

        // Handle klik kartu untuk detail
        function handleCardClick(title, currentValue, iconPath) {
            const modalContent = document.getElementById('modal-device-data');
            modalContent.innerHTML = '';

            document.getElementById('modal-title').textContent = `Detail ${title}`;
            document.getElementById('modal-icon-path').setAttribute('d', iconPath);

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
                'Suhu Pembakaran': {
                    key: 'suhu_pembakaran',
                    unit: '°C',
                    avgKey: 'avg_combustion_temperature'
                },
                'Estimasi Waktu': {
                    key: 'durasi_rekomendasi',
                    unit: '',
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

            if (['Kadar Air Gabah', 'Suhu Gabah', 'Suhu Pembakaran'].includes(title)) {
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
                    deviceP.textContent =
                        `${deviceName}: ${isNumeric(data[key]) ? data[key].toFixed(2) : '0.00'}${unit}`;
                    modalContent.appendChild(deviceP);
                });

                const hr = document.createElement('hr');
                hr.className = 'my-3 border-[#A3BFFA]/60';
                modalContent.appendChild(hr);

                const currentHeader = document.createElement('p');
                currentHeader.className = 'text-[#1E3A8A] text-lg font-bold mb-2';
                currentHeader.textContent = `${title} Saat Ini`;
                modalContent.appendChild(currentHeader);

                const currentAvg = document.createElement('p');
                currentAvg.className = 'text-[#1E3A8A]/80 text-base mb-1 ml-2';
                currentAvg.textContent =
                    `Rata-rata: ${isNumeric(currentValue) ? parseFloat(currentValue).toFixed(2) : '0.00'}${unit}`;
                modalContent.appendChild(currentAvg);

                Object.entries(sensorDataByDevice).forEach(([deviceName, data]) => {
                    const deviceP = document.createElement('p');
                    deviceP.className = 'text-[#1E3A8A]/80 text-base mb-1 ml-2';
                    deviceP.textContent =
                        `${deviceName}: ${isNumeric(data[key]) ? data[key].toFixed(2) : '0.00'}${unit}`;
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
                    `${title} Saat Ini: ${isNumeric(currentValue) ? parseFloat(currentValue).toFixed(2) : '0.00'}${unit}`;
                modalContent.appendChild(currentP);
            } else if (title === 'Estimasi Waktu') {
                const durationP = document.createElement('p');
                durationP.className = 'text-[#1E3A8A]/80 text-base mb-2';
                durationP.textContent = `Estimasi Durasi: ${formatDuration(initialData.durasi_rekomendasi)}`;
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

        // Inisialisasi UI
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

            // Polling awal hingga data valid diterima
            let initialPollInterval = setInterval(() => {
                fetchSensorData().then(data => {
                    if (data.sensors && isNumeric(data.sensors.avg_combustion_temperature)) {
                        console.log('Suhu pembakaran valid diterima:', data.sensors
                            .avg_combustion_temperature);
                        clearInterval(initialPollInterval);
                    }
                });
            }, INITIAL_POLLING_INTERVAL);

            // Perbaiki event modal untuk menghindari error [object Event]
            document.getElementById('tambahDataModal').addEventListener('show.bs.modal', () => fetchSensorData());
        });

        // Submit form prediksi
        // === GANTI SELURUH HANDLER INI ===
        document.getElementById('predictForm').addEventListener('submit', async function(e) {
            e.preventDefault();

            const modalElement = document.getElementById('tambahDataModal');
            const modal = bootstrap.Modal.getInstance(modalElement);
            const errorMessageDiv = document.getElementById('errorMessage');
            errorMessageDiv.style.display = 'none';
            errorMessageDiv.innerText = '';

            // Ambil input user
            const grainTypeId = parseInt(document.getElementById('jenis_gabah').value);
            const beratGabah = parseFloat(document.getElementById('berat_gabah').value);
            const kadarAirTarget = parseFloat(document.getElementById('kadar_air_target').value);

            // Validasi basic
            if (!isNumeric(beratGabah) || beratGabah < 0.1) {
                errorMessageDiv.innerText = 'Berat gabah harus diisi dan minimal 0.1 kg.';
                errorMessageDiv.style.display = 'block';
                return;
            }
            if (!isNumeric(kadarAirTarget) || kadarAirTarget < 0 || kadarAirTarget > 100) {
                errorMessageDiv.innerText = 'Target kadar air harus di antara 0 dan 100.';
                errorMessageDiv.style.display = 'block';
                return;
            }
            if (!isNumeric(grainTypeId)) {
                errorMessageDiv.innerText = 'Jenis gabah harus dipilih.';
                errorMessageDiv.style.display = 'block';
                return;
            }
            if (!sanctumToken) {
                showNotification('Anda harus login untuk menyimpan data prediksi.', 'bg-red-500');
                setTimeout(() => window.location.href = '{{ route('login') }}', 2000);
                return;
            }

            try {
                // Ambil sensor terbaru
                const sensorData = await fetchSensorData(null);
                if (!sensorData || !sensorData.sensors) {
                    showNotification('Gagal mengambil data sensor untuk prediksi.', 'bg-red-500');
                    return;
                }
                const s = sensorData.sensors;
                const sensorValues = {
                    kadar_air_gabah: isNumeric(s.avg_grain_moisture) ? parseFloat(s.avg_grain_moisture) :
                        null,
                    suhu_gabah: isNumeric(s.avg_grain_temperature) ? parseFloat(s.avg_grain_temperature) :
                        null,
                    suhu_ruangan: isNumeric(s.avg_room_temperature) ? parseFloat(s.avg_room_temperature) :
                        null,
                    // Flask terima kosong / NaN, tapi biar rapi kita kirim '' kalau null
                    suhu_pembakaran: (s.avg_combustion_temperature === null) ?
                        '' : (isNumeric(s.avg_combustion_temperature) ? String(parseFloat(s
                            .avg_combustion_temperature)) : '')
                };

                if (!isNumeric(sensorValues.kadar_air_gabah) || !isNumeric(sensorValues.suhu_gabah) || !
                    isNumeric(sensorValues.suhu_ruangan)) {
                    showNotification('Data sensor tidak lengkap atau tidak valid.', 'bg-red-500');
                    return;
                }

                // === KIRIM KE FLASK (/) — minta durasi_rekomendasi & biarkan Flask start + save ke DB
                const payloadForFlask = {
                    grain_type_id: String(grainTypeId),
                    kadar_air_target: String(kadarAirTarget),
                    berat_gabah: String(beratGabah),
                    kadar_air_gabah: String(sensorValues.kadar_air_gabah),
                    suhu_gabah: String(sensorValues.suhu_gabah),
                    suhu_ruangan: String(sensorValues.suhu_ruangan),
                    suhu_pembakaran: sensorValues.suhu_pembakaran, // '' jika tidak ada
                    user_id: String({{ auth()->id() ?? 1 }}) // wajib sesuai app.py
                };

                // Optional: health check cepat (GET /)
                // kita lewati karena Flask sudah CORS dan POST JSON

                const resp = await fetch(`${mlServerUrl}/`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payloadForFlask),
                    mode: 'cors'
                });

                // Parse response
                let result;
                try {
                    result = await resp.json();
                } catch {
                    throw new Error(`ML server mengembalikan non-JSON (HTTP ${resp.status})`);
                }
                if (!resp.ok || result.error) {
                    throw new Error(result?.error || `ML error (HTTP ${resp.status})`);
                }

                // Harusnya sudah ada: process_id + durasi_rekomendasi
                const processId = result.process_id ? parseInt(result.process_id) : null;
                const durasiMenit = isNumeric(result.durasi_rekomendasi) ? parseFloat(result
                    .durasi_rekomendasi) : null;

                if (!processId || !isNumeric(durasiMenit) || durasiMenit <= 0) {
                    throw new Error('Respons ML tidak lengkap. process_id/durasi_rekomendasi tidak valid.');
                }

                // === Update UI (status, tombol, angka ringkasan)
                statusText.innerText = 'Aktif';
                toggleButton.innerText = 'STOP';
                toggleButton.removeAttribute('data-bs-toggle');
                toggleButton.removeAttribute('data-bs-target');
                toggleButton.onclick = () => showConfirmStopModal(processId);

                kadarAirText.innerText = `${sensorValues.kadar_air_gabah.toFixed(2)}%`;
                suhuGabahText.innerText = `${sensorValues.suhu_gabah.toFixed(2)}°C`;
                suhuRuanganText.innerText = `${sensorValues.suhu_ruangan.toFixed(2)}°C`;
                suhuPembakaranText.innerText =
                    sensorValues.suhu_pembakaran !== '' && !isNaN(parseFloat(sensorValues.suhu_pembakaran)) ?
                    `${parseFloat(sensorValues.suhu_pembakaran).toFixed(2)}°C` :
                    'Data tidak tersedia';
                durasiText.innerText = formatDuration(durasiMenit);

                // Simpan baseline untuk modal detail
                initialData = {
                    kadar_air_gabah: sensorValues.kadar_air_gabah,
                    suhu_gabah: sensorValues.suhu_gabah,
                    suhu_ruangan: sensorValues.suhu_ruangan,
                    suhu_pembakaran: (sensorValues.suhu_pembakaran === '') ? 0 : parseFloat(sensorValues
                        .suhu_pembakaran),
                    durasi_rekomendasi: durasiMenit,
                    kadar_air_target: kadarAirTarget
                };

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

                // Mulai polling realtime PAKAI processId (biar backend ikut kirim drying_process)
                startSensorMonitoring(processId);

                showNotification('Prediksi berhasil! Proses pengeringan dimulai.', 'bg-green-500');

            } catch (err) {
                console.error('Error (start via ML):', err);
                showNotification(`Gagal memulai proses via ML: ${err.message}`, 'bg-red-500');
            }
        });
    </script>
@endsection

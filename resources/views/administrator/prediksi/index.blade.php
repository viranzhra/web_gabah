@extends('layout.app')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>

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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Card 1: Suhu Gabah -->
                <div style="height: 90px; background-color: #fff;"
                    class="text-[#1E3A8A] rounded-[12px] shadow-md p-6 border border-[#A3BFFA]/60 flex items-center cursor-pointer relative"
                    onclick="handleCardClick('Suhu Gabah', document.getElementById('suhuGabahText').innerText, 'M23 42.1666C25.1841 42.167 27.3144 41.489 29.0965 40.2263C30.8785 38.9636 32.2244 37.1785 32.9481 35.1178C33.6717 33.0571 33.7375 30.8225 33.1362 28.7228C32.5349 26.6231 31.2962 24.762 29.5914 23.3967C29.3361 23.2031 29.1278 22.9543 28.9821 22.6688C28.8364 22.3834 28.7571 22.0688 28.75 21.7484V9.58331C28.75 8.05832 28.1442 6.59578 27.0659 5.51745C25.9876 4.43912 24.525 3.83331 23 3.83331C21.475 3.83331 20.0125 4.43912 18.9342 5.51745C17.8558 6.59578 17.25 8.05832 17.25 9.58331V21.7503C17.25 22.3981 16.9146 22.9923 16.4086 23.3986C14.7046 24.7641 13.4667 26.6251 12.8658 28.7244C12.265 30.8237 12.3309 33.0578 13.0545 35.1181C13.7781 37.1784 15.1236 38.9631 16.9051 40.2257C18.6867 41.4883 20.8164 42.1666 23 42.1666Z M27.7917 31.625C27.7917 32.8958 27.2869 34.1146 26.3883 35.0132C25.4896 35.9118 24.2709 36.4166 23 36.4166C21.7292 36.4166 20.5104 35.9118 19.6118 35.0132C18.7132 34.1146 18.2084 32.8958 18.2084 31.625C18.2084 30.3542 18.7132 29.1354 19.6118 28.2368C20.5104 27.3381 21.7292 26.8333 23 26.8333C24.2709 26.8333 25.4896 27.3381 26.3883 28.2368C27.2869 29.1354 27.7917 31.625')">
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
                        <h3 style="font-weight: 500;">Suhu Gabah</h3>
                        <p id="suhuGabahText" class="text-[#1E3A8A]/80 text-xl" style="font-size: 16px;">0°C</p>
                    </div>
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-[#1E3A8A]" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>

                <!-- Card 2: Suhu Ruangan -->
                <div style="height: 90px; background-color: #fff;"
                    class="text-[#1E3A8A] rounded-[12px] shadow-md p-6 border border-[#A3BFFA]/60 flex items-center cursor-pointer relative"
                    onclick="handleCardClick('Suhu Ruangan', document.getElementById('suhuRuanganText').innerText, 'M17.5 0.5V35.5M22.707 4.25C21.1355 5.07027 19.3348 5.50254 17.5 5.5C15.6652 5.50254 13.8645 5.07027 12.293 4.25M12.293 31.75C13.8657 30.9321 15.6656 30.5 17.5 30.5C19.3344 30.5 21.1343 30.9321 22.707 31.75M35 9.25L0 26.75M33.8525 15.0312C32.248 14.2606 30.9157 13.1264 29.9986 11.7501C29.0815 10.3739 28.6141 8.80749 28.6465 7.21875M1.14748 20.9688C2.75205 21.7394 4.08425 22.8736 5.00135 24.2499C5.91845 25.6261 6.38588 27.1925 6.35355 28.7812M0 9.25L35 26.75M1.14748 15.0312C2.75205 14.2606 4.08425 13.1264 5.00135 11.7501C5.91845 10.3739 6.38588 8.80749 6.35355 7.21875M33.8525 20.9688C32.248 21.7394 30.9157 22.8736 29.9986 24.2499C29.0815 25.6261 28.6141 27.1925 28.6465 28.7812')">
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
                        <h3 style="font-weight: 500;">Suhu Ruangan</h3>
                        <p id="suhuRuanganText" class="text-[#1E3A8A]/80 text-xl" style="font-size: 16px;">0°C</p>
                    </div>
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-[#1E3A8A]" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>

                <!-- Card 3: Suhu Pembakaran -->
                <div style="height: 90px; background-color: #fff;"
                    class="text-[#1E3A8A] rounded-[12px] shadow-md p-6 border border-[#A3BFFA]/60 flex items-center cursor-pointer relative"
                    onclick="handleCardClick('Suhu Pembakaran', document.getElementById('suhuPembakaranText').innerText, 'M30.264 20.681C29.9325 19.8924 29.5559 18.9991 29.1878 17.8961C28.225 15.0089 31.3012 11.8597 31.3304 11.8304L29.6071 10.1071C29.4365 10.2777 25.4353 14.3459 26.8747 18.6664C27.272 19.8583 27.6693 20.7992 28.0178 21.6279C28.8304 23.2352 29.2525 25.0115 29.25 26.8125C29.1072 28.2643 28.5498 29.6443 27.6444 30.7881C26.7389 31.9319 25.5237 32.7911 24.1434 33.2633C24.5795 31.5543 24.573 29.7623 24.1245 28.0564C23.6761 26.3506 22.8005 24.7871 21.5804 23.5133L20.308 22.241L19.5987 23.8948C17.3611 29.1159 14.6981 31.395 13.132 32.3456C12.1704 31.7571 11.3622 30.9486 10.7742 29.9866C10.1863 29.0246 9.8352 27.9367 9.75 26.8125C9.83331 25.2782 10.218 23.7753 10.8822 22.3897C11.6701 20.7194 12.114 18.9078 12.1875 17.0625V14.8956C13.2527 15.3343 14.625 16.4836 14.625 19.5V22.6736L16.7493 20.3153C20.542 16.1058 19.7511 11.0931 18.2191 7.75247C19.3836 8.14064 20.3836 8.90939 21.0581 9.93496C21.7326 10.9605 22.0424 12.1832 21.9375 13.4062H24.375C24.375 6.65803 18.7943 4.875 15.8438 4.875H13.4062L14.8687 6.82378C15.0357 7.04925 18.3568 11.6098 16.5177 16.1935C16.1089 15.0414 15.359 14.041 14.3678 13.3254C13.3766 12.6098 12.191 12.2129 10.9688 12.1875H9.75V17.0625C9.66669 18.5968 9.28196 20.0997 8.61778 21.4853C7.82992 23.1556 7.38602 24.9672 7.3125 26.8125C7.3125 31.5023 11.9718 36.5625 19.5 36.5625C27.0282 36.5625 31.6875 31.5023 31.6875 26.8125C31.6883 24.6867 31.2013 22.589 30.264 20.681ZM15.6427 33.5473C17.8908 31.6863 19.7069 29.3582 20.9649 26.7247C21.6371 27.8089 22.019 29.0479 22.0738 30.3223C22.1287 31.5968 21.8547 32.864 21.2782 34.0019C20.6888 34.0823 20.0948 34.1235 19.5 34.125C18.192 34.1346 16.8905 33.9397 15.6427 33.5473Z')">
                    <svg class="h-8 w-8 mr-4" width="40" height="40" viewBox="0 0 39 39" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M30.264 20.681C29.9325 19.8924 29.5559 18.9991 29.1878 17.8961C28.225 15.0089 31.3012 11.8597 31.3304 11.8304L29.6071 10.1071C29.4365 10.2777 25.4353 14.3459 26.8747 18.6664C27.272 19.8583 27.6693 20.7992 28.0178 21.6279C28.8304 23.2352 29.2525 25.0115 29.25 26.8125C29.1072 28.2643 28.5498 29.6443 27.6444 30.7881C26.7389 31.9319 25.5237 32.7911 24.1434 33.2633C24.5795 31.5543 24.573 29.7623 24.1245 28.0564C23.6761 26.3506 22.8005 24.7871 21.5804 23.5133L20.308 22.241L19.5987 23.8948C17.3611 29.1159 14.6981 31.395 13.132 32.3456C12.1704 31.7571 11.3622 30.9486 10.7742 29.9866C10.1863 29.0246 9.8352 27.9367 9.75 26.8125C9.83331 25.2782 10.218 23.7753 10.8822 22.3897C11.6701 20.7194 12.114 18.9078 12.1875 17.0625V14.8956C13.2527 15.3343 14.625 16.4836 14.625 19.5V22.6736L16.7493 20.3153C20.542 16.1058 19.7511 11.0931 18.2191 7.75247C19.3836 8.14064 20.3836 8.90939 21.0581 9.93496C21.7326 10.9605 22.0424 12.1832 21.9375 13.4062H24.375C24.375 6.65803 18.7943 4.875 15.8438 4.875H13.4062L14.8687 6.82378C15.0357 7.04925 18.3568 11.6098 16.5177 16.1935C16.1089 15.0414 15.359 14.041 14.3678 13.3254C13.3766 12.6098 12.191 12.2129 10.9688 12.1875H9.75V17.0625C9.66669 18.5968 9.28196 20.0997 8.61778 21.4853C7.82992 23.1556 7.38602 24.9672 7.3125 26.8125C7.3125 31.5023 11.9718 36.5625 19.5 36.5625C27.0282 36.5625 31.6875 31.5023 31.6875 26.8125C31.6883 24.6867 31.2013 22.589 30.264 20.681ZM15.6427 33.5473C17.8908 31.6863 19.7069 29.3582 20.9649 26.7247C21.6371 27.8089 22.019 29.0479 22.0738 30.3223C22.1287 31.5968 21.8547 32.864 21.2782 34.0019C20.6888 34.0823 20.0948 34.1235 19.5 34.125C18.192 34.1346 16.8905 33.9397 15.6427 33.5473Z"
                            fill="#1E3A8A" />
                    </svg>
                    <div>
                        <h3 style="font-weight: 500;">Suhu Pembakaran</h3>
                        <p id="suhuPembakaranText" class="text-[#1E3A8A]/80 text-xl" style="font-size: 16px;">0°C</p>
                    </div>
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-[#1E3A8A]" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>

                <!-- Card 4: Estimasi Waktu Pengeringan -->
                <div style="height: 90px; background-color: #fff;"
                    class="text-[#1E3A8A] rounded-[12px] shadow-md p-6 border border-[#A3BFFA]/60 flex items-center cursor-pointer relative"
                    onclick="handleCardClick('Estimasi Waktu', document.getElementById('durasiText').innerText, 'M24 6C14.0625 6 6 14.0625 6 24C6 33.9375 14.0625 42 24 42C33.9375 42 42 33.9375 42 24C42 14.0625 33.9375 6 24 6ZM24 12V25.5H33')">
                    <svg class="h-8 w-8 mr-4 text-[#1E3A8A]" width="48" height="48" viewBox="0 0 48 48"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M24 6C14.0625 6 6 14.0625 6 24C6 33.9375 14.0625 42 24 42C33.9375 42 42 33.9375 42 24C42 14.0625 33.9375 6 24 6Z"
                            stroke="#1E3A8A" stroke-width="3" stroke-miterlimit="10" />
                        <path d="M24 12V25.5H33" stroke="#1E3A8A" stroke-width="2.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                    <div>
                        <h3 style="font-weight: 500; font-size: 14px;">Estimasi Waktu</h3>
                        <p id="durasiText" class="text-[#1E3A8A]/80 text-xl" style="font-size: 15px;">0 menit</p>
                    </div>
                    <svg class="absolute right-4 top-1/2 -translate-y-1/2 h-5 w-5 text-[#1E3A8A]" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 18L15 12L9 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- DataTable -->
        <div class="w-full">
            <div class="card mt-4">
                <div class="card-body">
                    <div class="table-responsive" style="overflow-x: auto;">
                        <table class="table table-striped table-bordered" id="data-table"
                            style="width: 100%; font-size: 14px;">
                            <thead class="text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Jenis Gabah</th>
                            <th class="text-center">Berat Gabah Awal (Kg)</th>
                            <th class="text-center">Berat Gabah Akhir (Kg)</th>
                            <th class="text-center">Durasi Rekomendasi</th>
                            <th class="text-center">Durasi Terlaksana</th>
                            <th class="text-center">Status</th>
                            {{-- <th class="text-center">Aksi</th> --}}
                        </tr>
                    </thead>
                </table>
                    </div>
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

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function($) {
            $(document).ready(function() {
                // Pemeriksaan pustaka
                if (typeof bootstrap === 'undefined') {
                    console.error('Bootstrap JS tidak dimuat.');
                    showNotification('Kesalahan', 'Bootstrap JS tidak dimuat. Periksa CDN atau file lokal.',
                        'error');
                    return;
                }
                if (typeof $ === 'undefined') {
                    console.error('jQuery tidak dimuat.');
                    showNotification('Kesalahan', 'jQuery tidak dimuat. Periksa CDN atau file lokal.', 'error');
                    return;
                }
                if (typeof $.fn.DataTable === 'undefined') {
                    console.error('DataTables tidak dimuat.');
                    showNotification('Kesalahan', 'DataTables tidak dimuat. Periksa CDN atau file lokal.',
                        'error');
                    return;
                }
                if (typeof $.fn.dataTable.Responsive === 'undefined') {
                    console.error('DataTables Responsive extension tidak dimuat.');
                    showNotification('Kesalahan',
                        'DataTables Responsive extension tidak dimuat. Periksa CDN atau file lokal.',
                        'error');
                    return;
                }

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

                // Initialize DataTable
                const table = $('#data-table').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
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
                            console.error('AJAX Error:', {
                                status: xhr.status,
                                response: xhr.responseJSON,
                                error: thrown
                            });
                            let errorMessage = 'Terjadi kesalahan saat memuat data.';
                            if (xhr.status === 401) {
                                errorMessage = 'Sesi Anda telah berakhir. Silakan login kembali.';
                                setTimeout(() => {
                                    window.location.href = '{{ route('login') }}';
                                }, 2000);
                            } else if (xhr.status === 500) {
                                errorMessage =
                                    'Kesalahan server. Silakan coba lagi atau hubungi administrator.';
                            } else if (xhr.status === 0) {
                                errorMessage =
                                    'Tidak dapat terhubung ke server. Periksa koneksi jaringan Anda.';
                            } else {
                                errorMessage = xhr.responseJSON?.error ||
                                    'Kesalahan tidak diketahui.';
                            }
                            showNotification(errorMessage, 'error');
                            table.processing(false);
                        }
                    },
                    columns: [
                    {
                        data: null,
                        render: function(data, type, row, meta) {
                            return `<button class="btn btn-sm btn-detail-number" data-process-id="${row.process_id}">${meta.row + meta.settings._iDisplayStart + 1}</button>`;
                        },
                        className: 'text-center'
                    },
                    {
                        data: 'nama_jenis',
                        defaultContent: '-'
                    },
                    {
                        data: 'berat_gabah_awal',
                        render: function(data) {
                            if (data === null || data === undefined) return '-';
                            const value = parseFloat(data);
                            return isNaN(value) ? '-' : value.toFixed(2);
                        }
                    },
                    {
                        data: 'berat_gabah_akhir',
                        render: function(data) {
                            if (data === null || data === undefined) return '-';
                            const value = parseFloat(data);
                            return isNaN(value) ? '-' : value.toFixed(2);
                        }
                    },
                    {
                        data: 'durasi_rekomendasi',
                        render: function(data) {
                            if (!data) return '-';
                            const totalMinutes = parseInt(data);
                            const hours = Math.floor(totalMinutes / 60);
                            const minutes = totalMinutes % 60;
                            return `${hours} jam ${minutes} menit`;
                        },
                        defaultContent: '-'
                    },
                    {
                        data: 'durasi_terlaksana',
                        render: function(data, type, row) {
                            console.log('Durasi terlaksana data:', {
                                data,
                                status: row.status,
                                timestamp_mulai: row.timestamp_mulai
                            });
                            if (row.status === 'ongoing' && row.timestamp_mulai && !data) {
                                const start = new Date(row.timestamp_mulai);
                                const now = new Date();
                                const totalMinutes = Math.floor((now - start) / (1000 * 60));
                                const hours = Math.floor(totalMinutes / 60);
                                const minutes = totalMinutes % 60;
                                return `${hours} jam ${minutes} menit`;
                            }
                            if (data) {
                                const totalMinutes = parseInt(data);
                                const hours = Math.floor(totalMinutes / 60);
                                const minutes = totalMinutes % 60;
                                return `${hours} jam ${minutes} menit`;
                            }
                            return '0 jam 0 menit';
                        },
                        defaultContent: '0 jam 0 menit'
                    },
                    {
                        data: 'status',
                        render: function(data) {
                            if (!data) return '-';
                            if (data.toLowerCase().includes('completed')) {
                                return '<span class="status-selesai">Selesai</span>';
                            }
                            if (data.toLowerCase().includes('pending')) {
                                return '<span class="status-pending">Menunggu</span>';
                            }
                            if (data.toLowerCase().includes('ongoing')) {
                                return '<span class="status-proses">Berjalan</span>';
                            }
                            return data;
                        },
                        defaultContent: '-'
                    },
                    // {
                    //     data: 'status',
                    //     render: function(data, type, row) {
                    //         if (data === 'completed') {
                    //             return '-';
                    //         } else if (data === 'pending') {
                    //             return `<button class="btn btn-sm btn-success btn-mulai" onclick="startProcess(${row.process_id})">Mulai</button>`;
                    //         } else if (data === 'ongoing') {
                    //             return `<button class="btn btn-sm btn-danger btn-selesai" data-process-id="${row.process_id}">Selesai</button>`;
                    //         }
                    //         return '-';
                    //     },
                    //     className: 'text-center'
                    // }
                ],
                    order: [
                        [3, 'desc']
                    ],
                });

                $('#data-table').on('click', '.btn-detail-number', function() {
                    const processId = $(this).data('process-id');
                    console.log('Detail number clicked for process ID:', processId);

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
                                    throw new Error(err.error ||
                                        `Gagal mengambil detail proses: ${response.statusText}`
                                        );
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Detail data:', data);
                            if (data.success && data.data) {
                                const row = data.data;
                                $('#detail_nama_jenis').text(row.nama_jenis || '-');
                                const beratGabahStr = row.berat_gabah ? row.berat_gabah.replace(
                                    /,/g, '') : null;
                                const beratGabahValue = beratGabahStr && !isNaN(parseFloat(
                                    beratGabahStr)) ? parseFloat(beratGabahStr).toFixed(2) : '-';

                                $('#detail_berat_gabah').text(beratGabahValue);
                                $('#detail_suhu_gabah_awal').text(row.suhu_gabah_awal ? parseFloat(
                                    row.suhu_gabah_awal).toFixed(2) : '-');
                                $('#detail_suhu_ruangan_awal').text(row.suhu_ruangan_awal ?
                                    parseFloat(row.suhu_ruangan_awal).toFixed(2) : '-');
                                $('#detail_suhu_pembakaran_awal').text(row.suhu_pembakaran_awal ?
                                    parseFloat(row.suhu_pembakaran_awal).toFixed(2) : '-');
                                $('#detail_kadar_air_awal').text(row.kadar_air_awal ? parseFloat(row
                                    .kadar_air_awal).toFixed(2) : '-');
                                $('#detail_kadar_air_target').text(row.kadar_air_target ?
                                    parseFloat(row.kadar_air_target).toFixed(2) : '-');
                                $('#detail_suhu_gabah_akhir').text(row.suhu_gabah_akhir ?
                                    parseFloat(row.suhu_gabah_akhir).toFixed(2) : '-');
                                $('#detail_suhu_ruangan_akhir').text(row.suhu_ruangan_akhir ?
                                    parseFloat(row.suhu_ruangan_akhir).toFixed(2) : '-');
                                $('#detail_suhu_pembakaran_akhir').text(row.suhu_pembakaran_akhir ?
                                    parseFloat(row.suhu_pembakaran_akhir).toFixed(2) : '-');
                                $('#detail_kadar_air_akhir').text(row.kadar_air_akhir ? parseFloat(
                                    row.kadar_air_akhir).toFixed(2) : '-');
                                $('#detail_durasi_rekomendasi').text(row.durasi_rekomendasi || '-');
                                $('#detail_durasi_aktual').text(row.durasi_aktual || '-');
                                $('#detail_timestamp_mulai').text(row.timestamp_mulai || '-');
                                $('#detail_timestamp_selesai').text(row.timestamp_selesai || '-');

                                function formatStatus(status) {
                                    if (!status) return '-';
                                    if (status.toLowerCase().includes('selesai') || status
                                        .toLowerCase().includes('completed')) return 'Selesai';
                                    if (status.toLowerCase().includes('pending') || status
                                        .toLowerCase().includes('menunggu')) return 'Menunggu';
                                    if (status.toLowerCase().includes('ongoing') || status
                                        .toLowerCase().includes('berjalan')) return 'Berjalan';
                                    return status;
                                }

                                $('#detail_status').html(
                                    `<span class="status-${formatStatus(row.status).toLowerCase()}">${formatStatus(row.status)}</span>`
                                    );

                                const detailModalElement = document.getElementById(
                                    'detailDataModal');
                                const detailModal = new bootstrap.Modal(detailModalElement);
                                detailModal.show();
                            } else {
                                showNotification('Gagal Memuat Detail', 'Data tidak ditemukan.',
                                    'error');
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
                                    throw new Error(err.error ||
                                        `Gagal memulai proses: ${response.statusText}`);
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                table.ajax.reload(null, false);
                                showNotification('Proses Dimulai', 'Proses pengeringan dimulai.',
                                    'success');
                                startSensorMonitoring(data.data.process_id, sanctumToken);
                            } else {
                                showNotification('Gagal Memulai Proses', data.error ||
                                    'Kesalahan server.', 'error');
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
                    const confirmModal = bootstrap.Modal.getInstance(document.getElementById(
                        'confirmCompleteModal'));
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
                                sensorData.sensors.avg_room_temperature == null ||
                                sensorData.sensors.avg_grain_moisture === 0 ||
                                sensorData.sensors.avg_grain_temperature === 0 ||
                                sensorData.sensors.avg_room_temperature === 0) {
                                showNotification('Gagal', 'Data sensor tidak lengkap atau tidak valid.',
                                    'error');
                                // Show manual input modal
                                const manualInputModalElement = document.getElementById('manualInputModal');
                                const manualInputModal = new bootstrap.Modal(manualInputModalElement);
                                manualInputModal.show();

                                // Handle save button for manual input
                                $('#saveManualInputBtn').off('click').on('click', function() {
                                    const kadarAirAkhir = parseFloat($('#manual_kadar_air_akhir')
                                        .val());
                                    const suhuGabahAkhir = parseFloat($('#manual_suhu_gabah_akhir')
                                        .val());
                                    const suhuRuanganAkhir = parseFloat($(
                                        '#manual_suhu_ruangan_akhir').val());
                                    const suhuPembakaranAkhir = parseFloat($(
                                        '#manual_suhu_pembakaran_akhir').val());

                                    if (isNaN(kadarAirAkhir) || isNaN(suhuGabahAkhir) || isNaN(
                                            suhuRuanganAkhir) || isNaN(suhuPembakaranAkhir)) {
                                        showNotification('Gagal',
                                            'Data manual tidak lengkap atau tidak valid.',
                                            'error');
                                        return;
                                    }

                                    const completeData = {
                                        kadar_air_akhir: kadarAirAkhir,
                                        suhu_gabah_akhir: suhuGabahAkhir,
                                        suhu_ruangan_akhir: suhuRuanganAkhir,
                                        suhu_pembakaran_akhir: suhuPembakaranAkhir,
                                        timestamp_selesai: new Date().toISOString()
                                    };

                                    sendCompleteRequest(processId, completeData, triggeringButton);
                                    manualInputModal.hide();
                                });
                                return;
                            }

                            const kadarAirAkhir = parseFloat(sensorData.sensors.avg_grain_moisture);
                            const suhuGabahAkhir = parseFloat(sensorData.sensors.avg_grain_temperature);
                            const suhuRuanganAkhir = parseFloat(sensorData.sensors.avg_room_temperature);
                            const suhuPembakaranAkhir = parseFloat(sensorData.sensors
                                .avg_combustion_temperature || 0);

                            console.log('Parsed sensor values:', {
                                kadar_air_akhir: kadarAirAkhir,
                                suhu_gabah_akhir: suhuGabahAkhir,
                                suhu_ruangan_akhir: suhuRuanganAkhir,
                                suhu_pembakaran_akhir: suhuPembakaranAkhir
                            });

                            if (isNaN(kadarAirAkhir) || isNaN(suhuGabahAkhir) || isNaN(suhuRuanganAkhir) ||
                                isNaN(suhuPembakaranAkhir)) {
                                showNotification('Gagal', 'Data sensor mengandung nilai tidak valid.',
                                    'error');
                                // Show manual input modal
                                const manualInputModalElement = document.getElementById('manualInputModal');
                                const manualInputModal = new bootstrap.Modal(manualInputModalElement);
                                manualInputModal.show();

                                // Handle save button for manual input
                                $('#saveManualInputBtn').off('click').on('click', function() {
                                    const kadarAirAkhir = parseFloat($('#manual_kadar_air_akhir')
                                        .val());
                                    const suhuGabahAkhir = parseFloat($('#manual_suhu_gabah_akhir')
                                        .val());
                                    const suhuRuanganAkhir = parseFloat($(
                                        '#manual_suhu_ruangan_akhir').val());
                                    const suhuPembakaranAkhir = parseFloat($(
                                        '#manual_suhu_pembakaran_akhir').val());

                                    if (isNaN(kadarAirAkhir) || isNaN(suhuGabahAkhir) || isNaN(
                                            suhuRuanganAkhir) || isNaN(suhuPembakaranAkhir)) {
                                        showNotification('Gagal',
                                            'Data manual tidak lengkap atau tidak valid.',
                                            'error');
                                        return;
                                    }

                                    const completeData = {
                                        kadar_air_akhir: kadarAirAkhir,
                                        suhu_gabah_akhir: suhuGabahAkhir,
                                        suhu_ruangan_akhir: suhuRuanganAkhir,
                                        suhu_pembakaran_akhir: suhuPembakaranAkhir,
                                        timestamp_selesai: new Date().toISOString()
                                    };

                                    sendCompleteRequest(processId, completeData, triggeringButton);
                                    manualInputModal.hide();
                                });
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
                            // Show manual input modal
                            const manualInputModalElement = document.getElementById('manualInputModal');
                            const manualInputModal = new bootstrap.Modal(manualInputModalElement);
                            manualInputModal.show();

                            // Handle save button for manual input
                            $('#saveManualInputBtn').off('click').on('click', function() {
                                const kadarAirAkhir = parseFloat($('#manual_kadar_air_akhir')
                            .val());
                                const suhuGabahAkhir = parseFloat($('#manual_suhu_gabah_akhir')
                                .val());
                                const suhuRuanganAkhir = parseFloat($('#manual_suhu_ruangan_akhir')
                                    .val());
                                const suhuPembakaranAkhir = parseFloat($(
                                    '#manual_suhu_pembakaran_akhir').val());

                                if (isNaN(kadarAirAkhir) || isNaN(suhuGabahAkhir) || isNaN(
                                        suhuRuanganAkhir) || isNaN(suhuPembakaranAkhir)) {
                                    showNotification('Gagal',
                                        'Data manual tidak lengkap atau tidak valid.', 'error');
                                    return;
                                }

                                const completeData = {
                                    kadar_air_akhir: kadarAirAkhir,
                                    suhu_gabah_akhir: suhuGabahAkhir,
                                    suhu_ruangan_akhir: suhuRuanganAkhir,
                                    suhu_pembakaran_akhir: suhuPembakaranAkhir,
                                    timestamp_selesai: new Date().toISOString()
                                };

                                sendCompleteRequest(processId, completeData, triggeringButton);
                                manualInputModal.hide();
                            });
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
                                    throw new Error(err.error ||
                                        `Gagal menyelesaikan proses: ${response.statusText}`);
                                });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                table.ajax.reload(null, false);
                                showNotification('Proses Selesai', 'Proses pengeringan selesai.',
                                'success');
                                // Restore focus to the triggering button
                                if (triggeringButton) {
                                    $(triggeringButton).focus();
                                }
                            } else {
                                showNotification('Gagal Menyelesaikan', data.error || 'Kesalahan server.',
                                    'error');
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

                // Sensor monitoring for grid cards
                function startSensorMonitoring(processId, token) {
                    if (!token) {
                        console.error('No token provided for sensor monitoring');
                        return;
                    }

                    setInterval(function() {
                        console.log('Fetching sensor data from:',
                            `{{ config('services.api.base_url') }}/get_sensor/realtime?user_id={{ auth()->id() }}&process_id=${processId}`
                            );
                        fetch(`{{ config('services.api.base_url') }}/get_sensor/realtime?user_id={{ auth()->id() }}&process_id=${processId}`, {
                                headers: {
                                    'Authorization': `Bearer ${token}`,
                                    'Accept': 'application/json'
                                }
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error(
                                        `Gagal mengambil data sensor: ${response.statusText}`);
                                }
                                return response.json();
                            })
                            .then(sensorData => {
                                console.log('Sensor data received:', sensorData);
                                if (sensorData.sensors && sensorData.drying_process) {
                                    const suhuGabah = sensorData.sensors.avg_grain_temperature;
                                    const suhuRuangan = sensorData.sensors.avg_room_temperature;
                                    const suhuPembakaran = sensorData.sensors
                                        .avg_combustion_temperature;
                                    const kadarAir = sensorData.sensors.avg_grain_moisture;
                                    const durasiRekomendasi = sensorData.drying_process
                                        .durasi_rekomendasi;

                                    // Update card values
                                    document.getElementById('suhuGabahText').innerText = suhuGabah ?
                                        `${parseFloat(suhuGabah).toFixed(2)}°C` : '0°C';
                                    document.getElementById('suhuRuanganText').innerText =
                                        suhuRuangan ? `${parseFloat(suhuRuangan).toFixed(2)}°C` :
                                        '0°C';
                                    document.getElementById('suhuPembakaranText').innerText =
                                        suhuPembakaran ?
                                        `${parseFloat(suhuPembakaran).toFixed(2)}°C` : '0°C';

                                    // Update durasiText
                                    if (durasiRekomendasi) {
                                        const hours = Math.floor(durasiRekomendasi / 60);
                                        const minutes = durasiRekomendasi % 60;
                                        document.getElementById('durasiText').innerText =
                                            `${durasiRekomendasi} menit`;
                                    } else {
                                        document.getElementById('durasiText').innerText =
                                            '0 menit';
                                    }

                                    // Update table if process is active
                                    const table = $('#data-table').DataTable();
                                    const row = table.rows().data().toArray().find(r => r
                                        .process_id === processId);
                                    if (!row || (row.status !== 'Berjalan' && row.status !==
                                            'ongoing')) return;

                                    const kadarAirTarget = parseFloat(row.kadar_air_target);
                                    const startTime = new Date(row.timestamp_mulai);
                                    const now = new Date();
                                    const durasiTerlaksana = Math.floor((now - startTime) / (1000 *
                                        60));

                                    fetch(`{{ config('services.api.base_url') }}/drying-process/${processId}/update-duration`, {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'Authorization': `Bearer ${token}`,
                                                'Accept': 'application/json'
                                            },
                                            body: JSON.stringify({
                                                durasi_terlaksana: durasiTerlaksana,
                                                kadar_air_akhir: kadarAir,
                                                suhu_gabah_akhir: suhuGabah,
                                                suhu_ruangan_akhir: suhuRuangan,
                                                suhu_pembakaran_akhir: suhuPembakaran
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
                                                if (data.message && data.message.includes(
                                                        'selesai secara otomatis')) {
                                                    showNotification('Proses Selesai',
                                                        `Proses ${processId} selesai! Kadar air target tercapai.`,
                                                        'success');
                                                }
                                            }
                                        })
                                        .catch(err => console.error('Error updating duration:',
                                            err));
                                } else {
                                    console.warn(
                                    'No active drying process or invalid sensor data.');
                                    // Reset card values if no active process
                                    document.getElementById('suhuGabahText').innerText = '0°C';
                                    document.getElementById('suhuRuanganText').innerText = '0°C';
                                    document.getElementById('suhuPembakaranText').innerText = '0°C';
                                    document.getElementById('durasiText').innerText =
                                        '0 menit';
                                }
                            })
                            .catch(err => {
                                console.error('Error fetching sensor data:', err);
                                // Reset card values on error
                                document.getElementById('suhuGabahText').innerText = '0°C';
                                document.getElementById('suhuRuanganText').innerText = '0°C';
                                document.getElementById('suhuPembakaranText').innerText = '0°C';
                                document.getElementById('durasiText').innerText =
                                    '0 menit';
                            });
                    }, 60000); // Update every 60 seconds
                }

                // Start sensor monitoring for the latest active process
                fetch(`{{ config('services.api.base_url') }}/drying-process`, {
                        headers: {
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.data) {
                            const activeProcess = data.data.find(process => process.status.toLowerCase() ===
                                'berjalan' || process.status.toLowerCase() === 'ongoing');
                            if (activeProcess) {
                                startSensorMonitoring(activeProcess.process_id, sanctumToken);
                            }
                        }
                    })
                    .catch(err => console.error('Error fetching initial drying processes:', err));
            });
        })(jQuery.noConflict(true));

        function handleCardClick(title, value, path) {
            console.log(`Card clicked: ${title}, Value: ${value}, Path: ${path}`);
            // Implement modal or other action if needed
        }

        function showNotification(message, className = 'success', reload = false) {
            const notification = document.getElementById('notification');
            const notificationTitle = document.getElementById('notificationTitle');
            const notificationMessage = document.getElementById('notificationMessage');

            // Set default title based on className
            notificationTitle.innerText = className === 'success' ? 'Berhasil' : 'Gagal';
            notificationMessage.innerText = message;

            // Remove any existing classes
            notification.classList.remove('success', 'error', 'visible', 'bg-green-500', 'bg-red-500');
            notification.classList.add('visible', className);

            // Ensure notification is visible
            notification.style.display = 'flex';

            setTimeout(() => {
                notification.classList.remove('visible');
                notification.classList.add('hidden');
                setTimeout(() => {
                    notificationTitle.innerText = '';
                    notificationMessage.innerText = '';
                    notification.style.display = 'none';
                    if (reload) {
                        location.reload();
                    }
                }, 500);
            }, 5000);
        }
    </script>

    <style>
        /* DataTable Styling */
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

    <!-- Notification HTML -->
    <div id="notification" class="alert position-fixed top-0 end-0 m-4">
        <div id="notificationTitle" style="font-weight: bold;"></div>
        <div id="notificationMessage"></div>
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
        let statusText, kadarAirText, suhuGabahText, suhuRuanganText, suhuPembakaranText, durasiText, toggleButton,
            suhuGabahInput,
            suhuRuanganInput, kadarAirGabahInput, suhuPembakaranInput;
        // Store initial and current sensor data per device_id
        let sensorDataByDevice = {};
        let initialData = {
            kadar_air_gabah: 0,
            suhu_gabah: 0,
            suhu_ruangan: 0,
            suhu_pembakaran: 0,
            durasi_rekomendasi: 0,
            kadar_air_target: 14
        };

        // Helper function to format duration
        function formatDuration(minutes) {
            if (!isNumeric(minutes) || minutes <= 0) {
                return '0 menit';
            }
            const totalMinutes = parseFloat(minutes);
            const totalSeconds = totalMinutes * 60;
            const hours = Math.floor(totalSeconds / 3600);
            const minutesPart = Math.floor((totalSeconds % 3600) / 60);
            const seconds = Math.floor(totalSeconds % 60);
            return `${Math.round(totalMinutes)} menit`;
        }

        // Di dalam fetchSensorData, tambahkan log tambahan
        async function fetchSensorData(processId = null, retries = MAX_RETRIES) {
            const url = processId ?
                `${baseUrl}/get_sensor/realtime?user_id={{ auth()->id() }}&process_id=${processId}` :
                `${baseUrl}/get_sensor/realtime?user_id={{ auth()->id() }}`;

            console.log('Fetching sensor data from:', url);
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
                console.log('Sensor data received:', JSON.stringify(data, null, 2));
                console.log('Average combustion temperature:', data.sensors?.avg_combustion_temperature ??
                    'Not available');
                if (data.sensors && data.sensors.data) {
                    data.sensors.data.forEach(sensor => {
                        console.log(
                            `Device ${sensor.device_name}: suhu_pembakaran = ${sensor.suhu_pembakaran ?? 'Not available'}`
                        );
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
                console.error('Error fetching sensor data:', err);
                if (retries > 0) {
                    console.log(`Retrying... (${MAX_RETRIES - retries + 1}/${MAX_RETRIES})`);
                    await new Promise(resolve => setTimeout(resolve, 2000));
                    return fetchSensorData(processId, retries - 1);
                } else {
                    showNotification(`Gagal memuat data sensor: ${err.message}`, 'bg-red-500');
                    return {
                        sensors: {
                            data: [],
                            avg_grain_moisture: 0,
                            avg_grain_temperature: 0,
                            avg_room_temperature: 0,
                            avg_combustion_temperature: null // Explicitly set to null for clarity
                        },
                        drying_process: null
                    };
                }
            }
        }

        // Di dalam updateUI, perbarui logika suhuPembakaranText
        function updateUI(data) {
            const dryingProcess = data.drying_process;
            const sensors = data.sensors || {};

            kadarAirText.innerText = sensors && isNumeric(sensors.avg_grain_moisture) ?
                `${sensors.avg_grain_moisture.toFixed(2)}%` : '0.00%';
            suhuGabahText.innerText = sensors && isNumeric(sensors.avg_grain_temperature) ?
                `${sensors.avg_grain_temperature.toFixed(2)}°C` : '0.00°C';
            suhuRuanganText.innerText = sensors && isNumeric(sensors.avg_room_temperature) ?
                `${sensors.avg_room_temperature.toFixed(2)}°C` : '0.00°C';
            suhuPembakaranText.innerText = sensors && isNumeric(sensors.avg_combustion_temperature) ?
                `${sensors.avg_combustion_temperature.toFixed(2)}°C` :
                sensors && sensors.avg_combustion_temperature === null ? 'Data tidak tersedia' : '0.00°C';

            // Log untuk debugging
            console.log('Updating suhuPembakaranText with:', sensors.avg_combustion_temperature);

            if (dryingProcess && dryingProcess.status === 'ongoing') {
                statusText.innerText = 'Aktif';
                toggleButton.innerText = 'STOP';
                toggleButton.removeAttribute('data-bs-toggle');
                toggleButton.removeAttribute('data-bs-target');
                toggleButton.onclick = () => showConfirmStopModal(dryingProcess.process_id);
                durasiText.innerText = formatDuration(dryingProcess.durasi_rekomendasi);
                if (!sensorInterval) {
                    startSensorMonitoring(dryingProcess.process_id);
                }
            } else {
                statusText.innerText = 'Nonaktif';
                toggleButton.innerText = 'START';
                toggleButton.setAttribute('data-bs-toggle', 'modal');
                toggleButton.setAttribute('data-bs-target', '#tambahDataModal');
                toggleButton.onclick = null;
                durasiText.innerText = '0 menit';
                if (!sensorInterval) {
                    startSensorMonitoring(null);
                }
            }
        }

        // Reset UI with formatted duration
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

        // Update modal form with sensor data
        function updateModalForm(sensors) {
            suhuGabahInput.value = sensors && isNumeric(sensors.avg_grain_temperature) ? sensors.avg_grain_temperature
                .toFixed(2) : '';
            suhuRuanganInput.value = sensors && isNumeric(sensors.avg_room_temperature) ? sensors.avg_room_temperature
                .toFixed(2) : '';
            kadarAirGabahInput.value = sensors && isNumeric(sensors.avg_grain_moisture) ? sensors.avg_grain_moisture
                .toFixed(2) : '';
            suhuPembakaranInput.value = sensors && isNumeric(sensors.avg_combustion_temperature) ? sensors
                .avg_combustion_temperature.toFixed(2) : '';
        }

        // Start sensor monitoring
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

        // Show confirmation stop modal
        function showConfirmStopModal(processId) {
            const confirmButton = document.getElementById('confirmStopButton');
            confirmButton.onclick = () => completeProcess(processId);
            const modal = new bootstrap.Modal(document.getElementById('confirmStopModal'));
            modal.show();
        }

        // Complete drying process
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
                        suhu_ruangan_akhir: parseFloat(sensors.avg_room_temperature) || 0,
                        suhu_pembakaran_akhir: parseFloat(sensors.avg_combustion_temperature) || 0
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

        // Show notification
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

        // Handle card click with formatted duration in modal
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

            if (title === 'Kadar Air Gabah' || title === 'Suhu Gabah' || title === 'Suhu Pembakaran') {
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
                    `Rata-rata: ${parseFloat(currentValue) ? parseFloat(currentValue).toFixed(2) : '0.00'}${unit}`;
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
                    `${title} Saat Ini: ${parseFloat(currentValue) ? parseFloat(currentValue).toFixed(2) : '0.00'}${unit}`;
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

        function isNumeric(value) {
            return !isNaN(parseFloat(value)) && isFinite(value);
        }

        // Initialize UI
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

            // Initial fetch with faster polling until data is received
            let initialPollInterval = setInterval(() => {
                fetchSensorData().then(data => {
                    if (data.sensors && isNumeric(data.sensors.avg_combustion_temperature)) {
                        console.log('Valid combustion temperature received:', data.sensors
                            .avg_combustion_temperature);
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
            const errorMessageDiv = document.getElementById('errorMessage');

            // Reset error message
            errorMessageDiv.style.display = 'none';
            errorMessageDiv.innerText = '';

            // Validasi data sensor
            const suhuGabah = parseFloat(suhuGabahInput.value);
            const suhuRuangan = parseFloat(suhuRuanganInput.value);
            const kadarAirGabah = parseFloat(kadarAirGabahInput.value);
            const suhuPembakaran = parseFloat(suhuPembakaranInput.value);
            const jenisGabah = document.getElementById('jenis_gabah').value;
            const beratGabah = parseFloat(document.getElementById('berat_gabah').value);
            const kadarAirTarget = parseFloat(document.getElementById('kadar_air_target').value);

            // Validasi input
            if (!isNumeric(suhuGabah) || !isNumeric(suhuRuangan) || !isNumeric(kadarAirGabah) || !isNumeric(
                    suhuPembakaran)) {
                showNotification('Data sensor tidak lengkap atau tidak valid.', 'bg-red-500');
                return;
            }
            if (!jenisGabah) {
                showNotification('Jenis gabah harus dipilih.', 'bg-red-500');
                return;
            }
            if (!isNumeric(beratGabah) || beratGabah <= 0) {
                showNotification('Berat gabah harus lebih besar dari 0.', 'bg-red-500');
                return;
            }
            if (!isNumeric(kadarAirTarget) || kadarAirTarget < 0 || kadarAirTarget > 100) {
                showNotification('Target kadar air harus di antara 0 dan 100.', 'bg-red-500');
                return;
            }

            // Validasi token
            if (!sanctumToken) {
                showNotification('Anda harus login untuk menyimpan data prediksi.', 'bg-red-500');
                setTimeout(() => {
                    window.location.href = '{{ route('login') }}';
                }, 2000);
                return;
            }

            try {
                // Fetch CSRF token
                await fetch('/sanctum/csrf-cookie', {
                    method: 'GET'
                });

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
                const predictResponse = await fetch('http://192.168.43.142:5000/predict', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });

                if (!predictResponse.ok) {
                    return predictResponse.json().then(errorData => {
                        throw new Error(errorData.error ||
                            `Gagal mendapatkan prediksi: ${predictResponse.statusText}`);
                    }).catch(() => {
                        throw new Error(
                            'Tidak dapat terhubung ke server ML. Pastikan server ML berjalan di http://192.168.43.142:5000.'
                        );
                    });
                }

                const predictData = await predictResponse.json();
                console.log('Respons dari ML:', predictData);

                // Validasi respons Flask
                if (!predictData.durasi_rekomendasi || predictData.durasi_rekomendasi < 0) {
                    throw new Error('Respons Flask tidak valid: durasi_rekomendasi tidak valid atau hilang.');
                }

                const durasiMenit = parseFloat(predictData.durasi_rekomendasi);

                // Data untuk dikirim ke Laravel
                const storeData = {
                    nama_jenis: jenisGabah,
                    suhu_gabah_awal: suhuGabah,
                    suhu_ruangan_awal: suhuRuangan,
                    suhu_pembakaran_awal: suhuPembakaran,
                    kadar_air_awal: kadarAirGabah,
                    kadar_air_target: kadarAirTarget,
                    berat_gabah: beratGabah,
                    durasi_rekomendasi: durasiMenit
                };

                console.log('Data yang dikirim ke /operator/prediksi/store:', JSON.stringify(storeData, null,
                    2));

                // Kirim data ke Laravel
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
                        setTimeout(() => {
                            window.location.href = '{{ route('login') }}';
                        }, 2000);
                        throw new Error('Unauthorized');
                    }
                    const err = await storeResponse.json();
                    throw new Error(err.error || `Gagal menyimpan: ${storeResponse.statusText}`);
                }

                const storeResult = await storeResponse.json();
                if (storeResult.success) {
                    const processId = storeResult.data.process_id;
                    toggleButton.onclick = () => showConfirmStopModal(processId);

                    // Update UI dengan data dari respons
                    statusText.innerText = 'Aktif';
                    toggleButton.innerText = 'STOP';
                    toggleButton.removeAttribute('data-bs-toggle');
                    toggleButton.removeAttribute('data-bs-target');
                    toggleButton.onclick = () => showConfirmStopModal(processId);
                    kadarAirText.innerText = `${kadarAirGabah.toFixed(2)}%`;
                    suhuGabahText.innerText = `${suhuGabah.toFixed(2)}°C`;
                    suhuRuanganText.innerText = `${suhuRuangan.toFixed(2)}°C`;
                    suhuPembakaranText.innerText = `${suhuPembakaran.toFixed(2)}°C`;
                    durasiText.innerText = formatDuration(durasiMenit);

                    // Update initialData
                    initialData = {
                        kadar_air_gabah: kadarAirGabah,
                        suhu_gabah: suhuGabah,
                        suhu_ruangan: suhuRuangan,
                        suhu_pembakaran: suhuPembakaran,
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

                    // Fetch sensor data untuk sinkronisasi
                    await fetchSensorData(processId);

                    showNotification('Prediksi berhasil! Proses pengeringan dimulai.', 'bg-green-500', true);
                } else {
                    showNotification('Gagal menyimpan proses: ' + (storeResult.error || 'Kesalahan server.'),
                        'bg-red-500');
                }
            } catch (err) {
                console.error('Error during prediction:', err);
                let errorMessage = err.message;
                if (err.message.includes('Failed to fetch')) {
                    errorMessage =
                        'Tidak dapat terhubung ke server ML. Pastikan server ML berjalan di http://192.168.43.142:5000 dan periksa koneksi jaringan.';
                }
                showNotification(`Gagal Prediksi: ${errorMessage}`, 'bg-red-500');
            }
        });
    </script>
@endsection

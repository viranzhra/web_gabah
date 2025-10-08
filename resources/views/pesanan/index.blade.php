@extends('layout.app')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .table-container {
            margin: 20px;
        }
        .status-select {
            width: 150px;
            padding: 5px;
            border-radius: 8px;
            border: 1px solid #DAD9D9;
        }
        .custom-button {
            background-color: #1E3B8A;
            color: white;
            border-radius: 8px;
            padding: 5px 10px;
            border: none;
        }
        .custom-button:hover {
            background-color: #163075;
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
        .status-pending {
            color: #f1c40f; /* Kuning untuk Pending */
            font-weight: bold;
        }
        .status-confirmed {
            color: #28a745; /* Hijau untuk Confirmed */
            font-weight: bold;
        }
        .status-cancelled {
            color: #dc3545; /* Merah untuk Cancelled */
            font-weight: bold;
        }
        .fa-eye, .fa-edit {
            color: #1E3B8A; /* Warna ikon sama dengan custom-button */
        }
        .fa-eye:hover, .fa-edit:hover {
            color: #163075; /* Warna hover sama dengan custom-button:hover */
        }
    </style>

    <!-- Tambahkan CDN Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <div id="notification" class="alert position-fixed top-0 end-0 m-4" style="z-index: 9999;">
        <div id="notificationTitle" style="font-weight: bold;"></div>
        <div id="notificationMessage"></div>
    </div>

    <!-- DataTable Pesanan -->
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="fw-semibold mb-3">Data Pemesanan Alat IoT</h4>
            <br>
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table table-striped table-bordered" id="pesananTable">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Pelanggan</th>
                            <th class="text-center">Email Pelanggan</th>
                            <th class="text-center">Paket</th>
                            <th class="text-center">Alamat</th>
                            <th class="text-center">Catatan</th>
                            <th class="text-center">Bukti Pembayaran</th>
                            <th class="text-center">Nomor Struk</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <small class="text-muted"><b>Ket:</b> <em>pending</em> (belum dibalas), <em>confirmed</em> (sudah dibalas). || Akan dibalas melalui Email pengguna.</small>
        </div>
    </div>

    <!-- DataTable Paket Harga -->
    <div class="card mt-4">
        <div class="card-body">
            <h4 class="fw-semibold mb-3">Data Paket Harga</h4>
            <br>
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table table-striped table-bordered" id="paketHargaTable">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Paket</th>
                            <th class="text-center">Harga</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Status -->
    <div class="modal fade" id="confirmStatusModal" tabindex="-1" aria-labelledby="confirmStatusModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 390px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmStatusModalLabel">Konfirmasi Perubahan Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin mengubah status pesanan <strong id="statusPesananId"></strong> menjadi <strong id="statusBaru"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn custom-button" id="confirmStatusBtn">Ya</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Paket Harga -->
    <div class="modal fade" id="editPaketModal" tabindex="-1" aria-labelledby="editPaketModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 390px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPaketModalLabel">Edit Paket Harga</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <form id="editPaketForm">
                        <input type="hidden" id="paketId">
                        <div class="mb-3">
                            <label for="namaPaket" class="form-label">Nama Paket</label>
                            <input type="text" class="form-control" id="namaPaket" required>
                        </div>
                        <div class="mb-3">
                            <label for="hargaPaket" class="form-label">Harga (Rp)</label>
                            <input type="number" class="form-control" id="hargaPaket" step="0.01" min="0" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button> --}}
                    <button type="button" class="btn custom-button" id="savePaketBtn">Update</button>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
    (function($) {
        $(document).ready(function() {
            // ====== Helpers Notifikasi ======
            function showNotification(type, title, message) {
                var notification = document.getElementById('notification');
                var titleEl = document.getElementById('notificationTitle');
                var messageEl = document.getElementById('notificationMessage');

                notification.className = 'alert position-fixed top-0 end-0 m-4';
                notification.style.display = 'flex';

                if (type === 'success') notification.classList.add('success');
                else if (type === 'error') notification.classList.add('error');

                titleEl.innerText = title || '';
                messageEl.innerText = message || '';

                setTimeout(function() {
                    notification.style.display = 'none';
                }, 4000);
            }

            // ====== Fungsi Format Rupiah ======
            function formatRupiah(angka) {
                return 'Rp ' + parseFloat(angka).toLocaleString('id-ID', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            // ====== Konfigurasi dasar ======
            const sanctumToken = "{{ session('sanctum_token') ?? '' }}".replace(/[\n\r]+/g, '').trim();
            const API_BASE = @json(config('services.api.base_url'));

            console.log('Sanctum Token:', sanctumToken ? 'Present' : 'Missing');
            console.log('Checking jQuery:', typeof $);
            console.log('Checking DataTable:', typeof $.fn.DataTable);
            console.log('API Base URL:', API_BASE);

            // ====== Inisialisasi DataTable Pesanan ======
            const pesananTable = $('#pesananTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: `${API_BASE}/pesanan`,
                    type: 'GET',
                    headers: {
                        'Authorization': `Bearer ${sanctumToken}`,
                        'Accept': 'application/json'
                    },
                    dataSrc: 'data',
                    error: function(xhr) {
                        console.error('AJAX Error:', xhr);
                        let errorMessage = xhr.responseJSON?.message || 'Gagal memuat data pesanan.';
                        if (xhr.status === 401) {
                            errorMessage = 'Sesi telah berakhir. Silakan login kembali.';
                        } else if (xhr.status === 405) {
                            errorMessage = 'Metode HTTP tidak diizinkan. Pastikan endpoint API benar.';
                        } else if (xhr.status === 0) {
                            errorMessage = 'Gagal terhubung ke server. Periksa koneksi internet atau URL API.';
                        }
                        showNotification('error', 'Gagal!', errorMessage);
                        pesananTable.processing(false);
                    }
                },
                columns: [
                    {
                        data: null,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'user_name', defaultContent: '-' },
                    { data: 'user_email', defaultContent: '-' },
                    { data: 'paket_name', defaultContent: '-' },
                    { data: 'alamat', defaultContent: '-' },
                    { data: 'catatan', defaultContent: '-' },
                    {
                        data: 'bukti_pembayaran',
                        className: 'text-center',
                        render: function(data) {
                            if (!data) return '-';
                            try {
                                new URL(data);
                                return `<a href="${data}" target="_blank" rel="noopener noreferrer" title="Lihat Bukti"><i class="fas fa-eye"></i></a>`;
                            } catch (e) {
                                return `<a href="${API_BASE.replace('/api','')}/${data.replace(/^\/+/,'')}" target="_blank" rel="noopener noreferrer" title="Lihat Bukti"><i class="fas fa-eye"></i></a>`;
                            }
                        }
                    },
                    { data: 'nomor_struk', defaultContent: '-' },
                    {
                        data: 'status',
                        className: 'text-center',
                        render: function(data) {
                            if (data === 'pending') {
                                return `<span class="status-pending">Pending</span>`;
                            } else if (data === 'confirmed') {
                                return `<span class="status-confirmed">Confirmed</span>`;
                            } else if (data === 'cancelled') {
                                return `<span class="status-cancelled">Cancelled</span>`;
                            } else {
                                return '-';
                            }
                        }
                    },
                    { data: 'created_at', defaultContent: '-' },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            const s = row.status || '';
                            if (s === 'cancelled') {
                                return `<span>-</span>`;
                            } else if (s === 'confirmed') {
                                return `
                                    <select class="status-select" onchange="confirmStatus(${row.id}, this.value)">
                                        <option value="confirmed" selected>Confirmed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                `;
                            } else {
                                return `
                                    <select class="status-select" onchange="confirmStatus(${row.id}, this.value)">
                                        <option value="pending" ${s === 'pending' ? 'selected' : ''}>Pending</option>
                                        <option value="confirmed">Confirmed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                `;
                            }
                        }
                    }
                ]
            });

            // ====== Inisialisasi DataTable Paket Harga ======
            const paketHargaTable = $('#paketHargaTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: `${API_BASE}/paket-harga`,
                    type: 'GET',
                    headers: {
                        'Authorization': `Bearer ${sanctumToken}`,
                        'Accept': 'application/json'
                    },
                    dataSrc: '',
                    error: function(xhr) {
                        console.error('AJAX Error:', xhr);
                        let errorMessage = xhr.responseJSON?.message || 'Gagal memuat data paket harga.';
                        if (xhr.status === 401) {
                            errorMessage = 'Sesi telah berakhir. Silakan login kembali.';
                        } else if (xhr.status === 405) {
                            errorMessage = 'Metode HTTP tidak diizinkan. Pastikan endpoint API benar.';
                        } else if (xhr.status === 0) {
                            errorMessage = 'Gagal terhubung ke server. Periksa koneksi internet atau URL API.';
                        }
                        showNotification('error', 'Gagal!', errorMessage);
                        paketHargaTable.processing(false);
                    }
                },
                columns: [
                    {
                        data: null,
                        className: 'text-center',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    { data: 'nama_paket', defaultContent: '-' },
                    {
                        data: 'harga',
                        className: 'text-center',
                        render: function(data) {
                            return data ? formatRupiah(data) : '-';
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            return `
                                <a href="javascript:void(0)" onclick="editPaket(${row.id}, '${row.nama_paket}', ${row.harga})" title="Edit Paket"><i class="fas fa-edit"></i></a>
                            `;
                        }
                    }
                ]
            });

            // ====== Konfirmasi & Update Status Pesanan ======
            window.confirmStatus = function(id, status) {
                $('#statusPesananId').text(id);
                $('#statusBaru').text(status);
                var statusModal = new bootstrap.Modal(document.getElementById('confirmStatusModal'));
                statusModal.show();

                $('#confirmStatusBtn').off('click').on('click', function() {
                    $.ajax({
                        url: `${API_BASE}/pesanan/${id}/status`,
                        method: 'PUT',
                        headers: {
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        data: JSON.stringify({ status }),
                        beforeSend: function() {
                            console.log('PUT', `${API_BASE}/pesanan/${id}/status`, '=>', status);
                        },
                        success: function(response) {
                            statusModal.hide();
                            pesananTable.ajax.reload(null, false);
                            showNotification('success', 'Berhasil!', response.message || 'Status pesanan berhasil diperbarui.');
                        },
                        error: function(xhr) {
                            console.error('Error Perbarui Status:', xhr);
                            let errorMessage = xhr.responseJSON?.message || 'Gagal memperbarui status.';
                            if (xhr.status === 401) errorMessage = 'Sesi telah berakhir. Silakan login kembali.';
                            showNotification('error', 'Gagal!', errorMessage);
                            statusModal.hide();
                        }
                    });
                });
            };

            // ====== Edit Paket Harga ======
            window.editPaket = function(id, namaPaket, harga) {
                $('#paketId').val(id);
                $('#namaPaket').val(namaPaket);
                $('#hargaPaket').val(harga);
                var editModal = new bootstrap.Modal(document.getElementById('editPaketModal'));
                editModal.show();
            };

            $('#savePaketBtn').on('click', function() {
                const id = $('#paketId').val();
                const namaPaket = $('#namaPaket').val();
                const harga = $('#hargaPaket').val();

                if (!namaPaket || !harga) {
                    showNotification('error', 'Gagal!', 'Nama paket dan harga wajib diisi.');
                    return;
                }

                $.ajax({
                    url: `${API_BASE}/paket-harga/${id}`,
                    method: 'PUT',
                    headers: {
                        'Authorization': `Bearer ${sanctumToken}`,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    },
                    data: JSON.stringify({
                        nama_paket: namaPaket,
                        harga: parseFloat(harga)
                    }),
                    beforeSend: function() {
                        console.log('PUT', `${API_BASE}/paket-harga/${id}`, '=>', { nama_paket: namaPaket, harga });
                    },
                    success: function(response) {
                        var editModal = bootstrap.Modal.getInstance(document.getElementById('editPaketModal'));
                        editModal.hide();
                        paketHargaTable.ajax.reload(null, false);
                        showNotification('success', 'Berhasil!', response.message || 'Data paket harga berhasil diperbarui.');
                    },
                    error: function(xhr) {
                        console.error('Error Perbarui Paket:', xhr);
                        let errorMessage = xhr.responseJSON?.message || 'Gagal memperbarui data paket harga.';
                        if (xhr.status === 404) {
                            errorMessage = 'Endpoint tidak ditemukan. Pastikan rute PUT /paket-harga/{id} sudah didefinisikan.';
                        } else if (xhr.status === 401) {
                            errorMessage = 'Sesi telah berakhir. Silakan login kembali.';
                        }
                        showNotification('error', 'Gagal!', errorMessage);
                    }
                });
            });

            // ====== Guard untuk skrip global "GET /api/login" ======
            window.__DISABLE_GLOBAL_LOGIN_PING__ = true;
        });
    })(jQuery.noConflict(true));
</script>

@endsection
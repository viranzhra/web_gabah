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
    </style>

    <div id="notification" class="alert position-fixed top-0 end-0 m-4" style="z-index: 9999;">
        <div id="notificationTitle" style="font-weight: bold;"></div>
        <div id="notificationMessage"></div>
    </div>

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
        </div>
    </div>

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

            // ====== Konfigurasi dasar ======
            const sanctumToken = "{{ session('sanctum_token') ?? '' }}".replace(/[\n\r]+/g, '').trim();
            const API_BASE = @json(config('services.api.base_url'));

            console.log('Sanctum Token:', sanctumToken ? 'Present' : 'Missing');
            console.log('Checking jQuery:', typeof $);
            console.log('Checking DataTable:', typeof $.fn.DataTable);

            // ====== Inisialisasi DataTable (disederhanakan) ======
            const table = $('#pesananTable').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: `${API_BASE}/pesanan`,
                    type: 'GET',
                    headers: {
                        'Authorization': `Bearer ${sanctumToken}`,
                        'Accept': 'application/json'
                    },
                    // DataTables default property untuk mengambil array data
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
                        table.processing(false);
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
                    { data: 'paket_name', defaultContent: '-' },
                    { data: 'alamat', defaultContent: '-' },
                    { data: 'catatan', defaultContent: '-' },
                    {
                        data: 'bukti_pembayaran',
                        className: 'text-center',
                        render: function(data) {
                            if (!data) return '-';
                            // Pastikan absolut URL (opsional)
                            try {
                                new URL(data);
                                return `<a href="${data}" target="_blank" rel="noopener noreferrer">Lihat Bukti</a>`;
                            } catch (e) {
                                return `<a href="${API_BASE.replace('/api','')}/${data.replace(/^\/+/,'')}" target="_blank" rel="noopener noreferrer">Lihat Bukti</a>`;
                            }
                        }
                    },
                    { data: 'nomor_struk', defaultContent: '-' },
                    { data: 'status', defaultContent: '-' },
                    { data: 'created_at', defaultContent: '-' },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: 'text-center',
                        render: function(data, type, row) {
                            const s = row.status || '';
                            return `
                                <select class="status-select" onchange="confirmStatus(${row.id}, this.value)">
                                    <option value="pending" ${s === 'pending' ? 'selected' : ''}>Pending</option>
                                    <option value="confirmed" ${s === 'confirmed' ? 'selected' : ''}>Confirmed</option>
                                    <option value="cancelled" ${s === 'cancelled' ? 'selected' : ''}>Cancelled</option>
                                </select>
                            `;
                        }
                    }
                ],
                // language: {
                //     "decimal": "",
                //     "emptyTable": "Tidak ada data yang tersedia di tabel",
                //     "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                //     "infoEmpty": "Menampilkan 0 sampai 0 dari 0 entri",
                //     "infoFiltered": "(disaring dari _MAX_ total entri)",
                //     "thousands": ",",
                //     "lengthMenu": "Tampilkan _MENU_ entri",
                //     "loadingRecords": "Memuat...",
                //     "processing": "Memproses...",
                //     "search": "Cari:",
                //     "zeroRecords": "Tidak ada catatan yang cocok ditemukan",
                //     "paginate": {
                //         "first": "Pertama",
                //         "last": "Terakhir",
                //         "next": "Selanjutnya",
                //         "previous": "Sebelumnya"
                //     },
                //     "aria": {
                //         "sortAscending": ": aktifkan untuk mengurutkan kolom secara naik",
                //         "sortDescending": ": aktifkan untuk mengurutkan kolom secara turun"
                //     }
                // }
            });

            // ====== Konfirmasi & Update Status ======
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
                            table.ajax.reload(null, false);
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

            // ====== Guard untuk skrip global "GET /api/login" ======
            // Jika ada skrip global yang memanggil /api/login, nonaktifkan di halaman ini:
            window.__DISABLE_GLOBAL_LOGIN_PING__ = true;
        });
    })(jQuery.noConflict(true));
</script>

@endsection
@extends('layout.app')

@section('content')
    <style>
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

        .action-buttons .btn {
            margin-right: 5px;
        }
    </style>

    {{-- <h4 class="fw-semibold mb-3" style="margin-top: 10px;">Data Master</h4> --}}

    @include('administrator.data_master.button')

    <div id="notification" class="alert position-fixed top-0 end-0 m-4" style="z-index: 9999;">
        <div id="notificationTitle" style="font-weight: bold;"></div>
        <div id="notificationMessage"></div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="fw-semibold mb-3">Data Perangkat IoT</h5>
            <br>
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table table-striped table-bordered" id="data-table">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Perangkat</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 330px;">
            <div class="modal-content">
                <div class="modal-header justify-content-center position-relative">
                    <h5 class="modal-title text-center w-100" id="editDataModalLabel"
                        style="margin-top: 15px; margin-bottom: 5px;">Form Edit Data</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 mt-3 me-3"
                        data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body" style="padding: 0 27px 27px 27px;">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="device_id" id="edit_device_id">
                        <div class="mb-3">
                            <label for="edit_nama_perangkat" class="form-label"
                                style="color: #4F4F4F; font-weight: 400">Nama Perangkat</label>
                            <input type="text" name="device_name" id="edit_nama_perangkat"
                                class="form-control custom-input" placeholder="Masukkan nama perangkat" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_deskripsi" class="form-label"
                                style="color: #4F4F4F; font-weight: 400">Deskripsi</label>
                            <input type="text" name="deskripsi" id="edit_deskripsi" class="form-control custom-input"
                                placeholder="Masukkan deskripsi perangkat" required>
                        </div>
                        <div style="margin-top: 30px;">
                            <button style="height: 43px; font-size: 16px; font-weight: 700; letter-spacing: 2px;"
                                type="submit" class="btn custom-save-btn w-100">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        function showNotification(type, title, message) {
            var notification = document.getElementById('notification');
            var titleEl = document.getElementById('notificationTitle');
            var messageEl = document.getElementById('notificationMessage');

            notification.className = 'alert position-fixed top-0 end-0 m-4';
            notification.style.display = 'flex';

            if (type === 'success') {
                notification.classList.add('success');
            } else if (type === 'error') {
                notification.classList.add('error');
            }

            titleEl.innerText = title;
            messageEl.innerText = message;

            setTimeout(function() {
                notification.style.display = 'none';
            }, 4000);
        }

        (function($) {
            $(document).ready(function() {
                const sanctumToken = "{{ session('sanctum_token') ?? '' }}".replace(/[\n\r]+/g, '').trim();
                console.log('Sanctum Token:', sanctumToken ? 'Present' : 'Missing');

                const table = $('#data-table').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: {
                        url: '{{ config('services.api.base_url') }}/devices',
                        type: 'GET',
                        headers: {
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json'
                        },
                        dataSrc: 'data',
                        error: function(xhr) {
                            console.error('AJAX Error:', xhr);
                            let errorMessage = 'Terjadi kesalahan saat memuat data.';
                            if (xhr.status === 401) {
                                errorMessage = 'Sesi telah berakhir. Silakan login kembali.';
                            } else if (xhr.status === 500) {
                                errorMessage = 'Kesalahan server. Silakan coba lagi.';
                            }
                            showNotification('error', 'Gagal!', errorMessage);
                        }
                    },
                    columns: [
                        {
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                            className: 'text-center'
                        },
                        {
                            data: 'device_name',
                            defaultContent: '-'
                        },
                        {
                            data: 'deskripsi',
                            defaultContent: '-'
                        },
                        {
                            data: 'status',
                            render: function(data) {
                                return data === 'aktif' ? 'Aktif' : 'Tidak Aktif';
                            },
                            defaultContent: '-'
                        },
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            className: 'text-center action-buttons',
                            render: function(data, type, row) {
                                return `
                                    <button class="btn btn-sm" style="border: none;" onclick="editData(${row.device_id})" title="Edit">
                                        <i class="fas fa-edit" style="color: green; font-size: 18px;"></i>
                                    </button>`;
                            }
                        }
                    ]
                });

                window.editData = function(id) {
                    console.log('Fetching device with ID:', id);
                    console.log('URL:', '{{ config('services.api.base_url') }}/devices/' + id);
                    console.log('Token:', sanctumToken);
                    $.ajax({
                        url: '{{ config('services.api.base_url') }}/devices/' + id,
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json'
                        },
                        success: function(res) {
                            console.log('Edit Data Response:', res);
                            if (res.status && res.data) {
                                $('#edit_device_id').val(res.data.device_id);
                                $('#edit_nama_perangkat').val(res.data.device_name);
                                $('#edit_deskripsi').val(res.data.deskripsi);
                                var editModal = new bootstrap.Modal(document.getElementById('editDataModal'));
                                editModal.show();
                            } else {
                                showNotification('error', 'Gagal!', 'Data Alat tidak valid.');
                            }
                        },
                        error: function(xhr) {
                            console.error('AJAX Error:', xhr);
                            let errorMessage = xhr.responseJSON?.message || 'Gagal mengambil Data Alat.';
                            if (xhr.status === 404) {
                                errorMessage = 'Perangkat tidak ditemukan.';
                            } else if (xhr.status === 401) {
                                errorMessage = 'Sesi telah berakhir. Silakan login kembali.';
                            } else if (xhr.status === 405) {
                                errorMessage = 'Metode tidak diizinkan. Silakan periksa konfigurasi server.';
                            }
                            showNotification('error', 'Gagal!', errorMessage);
                        }
                    });
                };

                $('#editForm').on('submit', function(e) {
                    e.preventDefault();
                    let id = $('#edit_device_id').val();
                    let data = {
                        device_name: $('#edit_nama_perangkat').val(),
                        deskripsi: $('#edit_deskripsi').val(),
                        _token: $('input[name="_token"]').val()
                    };

                    $.ajax({
                        url: '{{ config('services.api.base_url') }}/devices/' + id,
                        method: 'PUT',
                        headers: {
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json'
                        },
                        data: JSON.stringify(data),
                        contentType: 'application/json',
                        success: function() {
                            var editModalEl = document.getElementById('editDataModal');
                            var editModal = bootstrap.Modal.getInstance(editModalEl) ||
                                new bootstrap.Modal(editModalEl);
                            editModal.hide();
                            table.ajax.reload(null, false);
                            showNotification('success', 'Berhasil!', 'Perangkat berhasil diperbarui.');
                        },
                        error: function(xhr) {
                            console.error('AJAX Error:', xhr);
                            let errorMessage = xhr.responseJSON?.message || 'Gagal memperbarui perangkat.';
                            if (xhr.status === 422) {
                                errorMessage = Object.values(xhr.responseJSON.errors).flat().join(', ');
                            } else if (xhr.status === 401) {
                                errorMessage = 'Sesi telah berakhir. Silakan login kembali.';
                            }
                            showNotification('error', 'Gagal!', errorMessage);
                        }
                    });
                });
            });
        })(jQuery.noConflict(true));
    </script>
@endsection
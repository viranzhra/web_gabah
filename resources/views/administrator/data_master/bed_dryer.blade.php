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

    @include('administrator.data_master.button')

    <div id="notification" class="alert position-fixed top-0 end-0 m-4" style="z-index: 9999;">
        <div id="notificationTitle" style="font-weight: bold;"></div>
        <div id="notificationMessage"></div>
    </div>

    <div class="add-button mb-3">
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#tambahDataModal" style="background-color: #1E3B8A; border-radius: 12px; border: none;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29">
                <path
                    d="M8.4668 14.5C8.4668 14.2597 8.56228 14.0291 8.73223 13.8592C8.90219 13.6892 9.13269 13.5938 9.37305 13.5938H13.5938V9.37305C13.5938 9.13269 13.6892 8.90219 13.8592 8.73223C14.0291 8.56228 14.2597 8.4668 14.5 8.4668C14.7404 8.4668 14.9709 8.56228 15.1408 8.73223C15.3108 8.90219 15.4063 9.13269 15.4063 9.37305V13.5938H19.627C19.8673 13.5938 20.0978 13.6892 20.2678 13.8592C20.4377 14.0291 20.5332 14.2597 20.5332 14.5C20.5332 14.7404 20.4377 14.9709 20.2678 15.1408C20.0978 15.3108 19.8673 15.4063 19.627 15.4063H15.4063V19.627C15.4063 19.8673 15.3108 20.0978 15.1408 20.2678C14.9709 20.4377 14.7404 20.5332 14.5 20.5332C14.2597 20.5332 14.0291 20.4377 13.8592 20.2678C13.6892 20.0978 13.5938 19.8673 13.5938 19.627V15.4063H9.37305C9.13269 15.4063 8.90219 15.3108 8.73223 15.1408C8.56228 14.9709 8.4668 14.7404 8.4668 14.5Z"
                    fill="white" />
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M8.84134 4.55421C12.6022 4.13726 16.3977 4.13726 20.1586 4.55421C22.3662 4.80071 24.1485 6.5395 24.4071 8.75921C24.8542 12.5739 24.8542 16.4273 24.4071 20.242C24.1473 22.4617 22.365 24.1993 20.1586 24.447C16.3977 24.8639 12.6022 24.8639 8.84134 24.447C6.63372 24.1993 4.85143 22.4617 4.59284 20.242C4.14776 16.4273 4.14776 12.5739 4.59284 8.75921C4.85143 6.5395 6.63493 4.80071 8.84134 4.55421ZM19.958 6.35463C16.3304 5.95252 12.6695 5.95252 9.04193 6.35463C8.37039 6.42913 7.74357 6.72785 7.26275 7.20253C6.78193 7.67722 6.47518 8.30014 6.39205 8.97067C5.96228 12.6452 5.96228 16.3572 6.39205 20.0318C6.47543 20.7021 6.78229 21.3247 7.26309 21.7991C7.74389 22.2736 8.37057 22.5721 9.04193 22.6466C12.6391 23.0478 16.3608 23.0478 19.958 22.6466C20.6292 22.5719 21.2556 22.2732 21.7361 21.7988C22.2167 21.3244 22.5234 20.7019 22.6067 20.0318C23.0364 16.3572 23.0364 12.6452 22.6067 8.97067C22.5231 8.30076 22.2163 7.67853 21.7358 7.20435C21.2552 6.73017 20.629 6.43169 19.958 6.35704"
                    fill="white" />
            </svg>
            Tambah Data
        </button>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="fw-semibold mb-3">Data Bed Dryer</h5>
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table table-striped table-bordered" id="data-table">
                    <thead class="text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Bed Dryer</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="editDataModal" tabindex="-1">
        <div class="modal-dialog" style="max-width: 330px;">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h5 class="modal-title">Form Edit Bed Dryer</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 mt-3 me-3"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 0 27px 27px 27px;">
                    <form id="editForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="dryer_id" id="edit_dryer_id">
                        <div class="mb-3">
                            <label for="edit_nama" class="form-label">Nama Bed Dryer</label>
                            <input type="text" name="nama" id="edit_nama" class="form-control custom-input" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" id="edit_deskripsi" class="form-control custom-input"></textarea>
                        </div>
                        <div style="margin-top: 30px;">
                            <button type="submit" class="btn custom-save-btn w-100">Edit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 330px;">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h5 class="modal-title" id="tambahDataLabel">Form Tambah Bed Dryer</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 mt-3 me-3"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 0 27px 27px 27px;">
                    <form id="tambahForm" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="tambah_nama" class="form-label">Nama Bed Dryer</label>
                            <input type="text" id="tambah_nama" name="nama" class="form-control custom-input" required>
                        </div>
                        <div class="mb-3">
                            <label for="tambah_deskripsi" class="form-label">Deskripsi</label>
                            <textarea id="tambah_deskripsi" name="deskripsi" class="form-control custom-input"></textarea>
                        </div>
                        <div style="margin-top: 30px;">
                            <button type="submit" class="btn custom-save-btn w-100">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Hapus --}}
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="max-width: 390px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data <strong id="deleteItemName">nama_bed_dryer</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" style="background-color: #1E3B8A; color: white;"
                        id="confirmDeleteBtn">Ya</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Detail --}}
    <div class="modal fade" id="detailDataModal" tabindex="-1">
        <div class="modal-dialog" style="max-width: 500px;">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h5 class="modal-title">Detail Bed Dryer</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 mt-3 me-3"
                        data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" style="padding: 10px 27px 27px 27px;">
                    <div id="deviceList" class="row g-2"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- DataTables & Script --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        function showNotification(type, title, message) {
            var notification = $('#notification');
            $('#notificationTitle').text(title);
            $('#notificationMessage').text(message);
            notification.removeClass().addClass(type).fadeIn();
            setTimeout(() => notification.fadeOut(), 4000);
        }

        (function($) {
            $(document).ready(function() {
                const sanctumToken = "{{ session('sanctum_token') ?? '' }}".trim();

                const table = $('#data-table').DataTable({
                    ajax: {
                        url: '{{ config('services.api.base_url') }}/bed-dryers',
                        type: 'GET',
                        headers: {
                            'Authorization': `Bearer ${sanctumToken}`
                        },
                        dataSrc: 'data'
                    },
                    columns: [
                        {
                            data: null,
                            render: (data, type, row, meta) => meta.row + 1
                        },
                        { data: 'nama' },
                        { data: 'deskripsi', defaultContent: '-' },
                        {
                            data: null,
                            render: row => `
                            <div class="action-buttons">
                                <button onclick="detailData(${row.dryer_id})" class="btn btn-sm" title="Detail">
                                    <i class="fas fa-info-circle" style="color:#1E3B8A; font-size:18px;"></i>
                                </button>
                                <button onclick="editData(${row.dryer_id})" class="btn btn-sm" title="Edit">
                                    <i class="fas fa-edit" style="color: green; font-size: 18px;"></i>
                                </button>
                                <button onclick="deleteData(${row.dryer_id})" class="btn btn-sm" title="Hapus">
                                    <i class="fas fa-trash-restore" style="color: #b60303; font-size: 18px;"></i>
                                </button>
                            </div>`
                        }
                    ],
                    language: {
                        emptyTable: "Tidak ada data bed dryer yang tersedia."
                    }
                });

                // === CREATE (Tambah) ===
                const tambahModalEl = document.getElementById('tambahDataModal');

                if (tambahModalEl) {
                    // Reset form saat modal dibuka
                    tambahModalEl.addEventListener('shown.bs.modal', function() {
                        if ($('#tambahForm')[0]) $('#tambahForm')[0].reset();
                        $('#tambah_nama').trigger('focus');
                    });

                    $('#tambahForm').on('submit', function(e) {
                        e.preventDefault();

                        const payload = {
                            nama: $('#tambah_nama').val().trim(),
                            deskripsi: $('#tambah_deskripsi').val().trim() || null
                        };

                        $.ajax({
                            url: "{{ config('services.api.base_url') }}/bed-dryers/store",
                            method: "POST",
                            headers: {
                                "Authorization": `Bearer ${sanctumToken}`,
                                "Accept": "application/json",
                                "Content-Type": "application/json"
                            },
                            data: JSON.stringify(payload),
                            success: function() {
                                bootstrap.Modal.getInstance(document.getElementById('tambahDataModal')).hide();
                                table.ajax.reload(null, false);
                                showNotification("success", "Berhasil!", "Bed dryer berhasil ditambahkan.");
                            },
                            error: function(xhr) {
                                let msg = xhr.responseJSON?.message || "Gagal menambah data.";
                                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                                    msg = Object.values(xhr.responseJSON.errors).flat().join(', ');
                                }
                                showNotification("error", "Gagal!", msg);
                            }
                        });
                    });
                }

                // === EDIT ===
                window.editData = function(id) {
                    $.ajax({
                        url: "{{ config('services.api.base_url') }}/bed-dryers/" + id,
                        method: "GET",
                        headers: {
                            "Authorization": `Bearer ${sanctumToken}`,
                            "Accept": "application/json",
                        },
                        success: function(res) {
                            if (res && res.status && res.data?.dryer) {
                                $("#edit_dryer_id").val(res.data.dryer.dryer_id);
                                $("#edit_nama").val(res.data.dryer.nama || "");
                                $("#edit_deskripsi").val(res.data.dryer.deskripsi || "");
                                new bootstrap.Modal(document.getElementById("editDataModal")).show();
                            } else {
                                showNotification("error", "Gagal!", "Data bed dryer tidak valid.");
                            }
                        },
                        error: function(xhr) {
                            let msg = xhr.responseJSON?.message || "Gagal mengambil data bed dryer.";
                            if (xhr.status === 404) msg = "Bed dryer tidak ditemukan.";
                            else if (xhr.status === 401) msg = "Sesi berakhir. Silakan login kembali.";
                            showNotification("error", "Gagal!", msg);
                        },
                    });
                };

                // Submit form edit
                $("#editForm").on("submit", function(e) {
                    e.preventDefault();
                    const id = $("#edit_dryer_id").val();
                    const payload = {
                        nama: $("#edit_nama").val().trim(),
                        deskripsi: $("#edit_deskripsi").val().trim() || null,
                    };

                    $.ajax({
                        url: "{{ config('services.api.base_url') }}/bed-dryers/" + id,
                        method: "PUT",
                        headers: {
                            "Authorization": `Bearer ${sanctumToken}`,
                            "Accept": "application/json",
                            "Content-Type": "application/json",
                        },
                        data: JSON.stringify(payload),
                        success: function() {
                            const editModalEl = document.getElementById("editDataModal");
                            const editModal = bootstrap.Modal.getInstance(editModalEl) || new bootstrap.Modal(editModalEl);
                            editModal.hide();
                            table.ajax.reload(null, false);
                            showNotification("success", "Berhasil!", "Bed dryer berhasil diperbarui.");
                        },
                        error: function(xhr) {
                            let msg = xhr.responseJSON?.message || "Gagal memperbarui bed dryer.";
                            if (xhr.status === 422 && xhr.responseJSON?.errors) {
                                msg = Object.values(xhr.responseJSON.errors).flat().join(", ");
                            } else if (xhr.status === 401) {
                                msg = "Sesi berakhir. Silakan login kembali.";
                            }
                            showNotification("error", "Gagal!", msg);
                        },
                    });
                });

                // === DETAIL ===
                window.detailData = function(id) {
                    $.ajax({
                        url: "{{ config('services.api.base_url') }}/bed-dryers/" + id,
                        method: "GET",
                        headers: {
                            "Authorization": `Bearer ${sanctumToken}`,
                            "Accept": "application/json",
                        },
                        success: function(res) {
                            const devices = res?.data?.devices || [];
                            const $list = $("#deviceList").empty();

                            if (devices.length === 0) {
                                $list.append('<div class="col-12 text-center text-muted">Tidak ada device terhubung.</div>');
                            } else {
                                devices.forEach(d => {
                                    $list.append(`
                                        <div class="col-12">
                                            <div class="card p-2" style="border-left:5px solid ${d.status ? '#28a745' : '#dc3545'};">
                                                <div><strong>${d.device_name}</strong></div>
                                                <div class="text-muted">${d.address}</div>
                                                <div>Status:
                                                    <span class="${d.status ? 'text-success' : 'text-danger'}">
                                                        ${d.status ? 'Aktif' : 'Nonaktif'}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    `);
                                });
                            }
                            new bootstrap.Modal(document.getElementById("detailDataModal")).show();
                        },
                        error: function(xhr) {
                            let msg = xhr.responseJSON?.message || "Gagal mengambil detail bed dryer.";
                            showNotification("error", "Gagal!", msg);
                        }
                    });
                };

                // === DELETE dengan Modal Konfirmasi ===
                let deleteDryerId = null;

                window.deleteData = function(id) {
                    // Ambil nama dari DataTables untuk ditampilkan di modal
                    const rowData = table.rows().data().toArray().find(r => r.dryer_id === id);
                    const nama = rowData ? rowData.nama : "(Tidak diketahui)";

                    deleteDryerId = id;
                    $("#deleteItemName").text(nama);
                    new bootstrap.Modal(document.getElementById("deleteConfirmModal")).show();
                };

                $("#confirmDeleteBtn").on("click", function() {
                    if (!deleteDryerId) return;

                    $.ajax({
                        url: "{{ config('services.api.base_url') }}/bed-dryers/" + deleteDryerId,
                        method: "DELETE",
                        headers: {
                            "Authorization": `Bearer ${sanctumToken}`,
                            "Accept": "application/json",
                        },
                        success: function() {
                            table.ajax.reload(null, false);
                            showNotification("success", "Berhasil!", "Bed dryer berhasil dihapus.");
                        },
                        error: function(xhr) {
                            let msg = xhr.responseJSON?.message || "Gagal menghapus bed dryer.";
                            if (xhr.status === 404) msg = "Bed dryer tidak ditemukan.";
                            else if (xhr.status === 401) msg = "Sesi berakhir. Silakan login kembali.";
                            showNotification("error", "Gagal!", msg);
                        },
                        complete: function() {
                            deleteDryerId = null;
                            bootstrap.Modal.getInstance(document.getElementById("deleteConfirmModal")).hide();
                        }
                    });
                });
            });
        })(jQuery.noConflict(true));
    </script>
@endsection

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
            /* putih sedikit abu-abu */
            border: 1px solid #DAD9D9;
            /* border 1px abu-abu */
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

        /* css judul halaman */
        .estetik-card {
            width: 100%;
            /* background: linear-gradient(135deg, #1441ac1f, #f9fafe); */
            border-left: 7px solid #1E3B8A;
            border-radius: 16px;
            box-shadow: 0 4px 18px rgba(30, 59, 138, 0.07);
            /* animation: float 3s ease-in-out infinite; <-- dihapus */
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

    <h4 class="fw-semibold mb-3" style="margin-top: 10px;">Data Master</h4>

    @include('administrator.data_master.button')

    <!-- Notification Element -->
    <div id="notification" class="alert position-fixed top-0 end-0 m-4" style="z-index: 9999;">
        <div id="notificationTitle" style="font-weight: bold;"></div>
        <div id="notificationMessage"></div>
    </div>


    <!-- Tombol Tambah Data -->
    <div class="add-button mb-3">
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#tambahDataModal" style="background-color: #1E3B8A; border-radius: 12px; border: none;">
            <!-- Icon -->
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

    {{-- DataTable --}}
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="fw-semibold mb-3">Data Jenis Gabah</h5>
            <br>
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table table-striped table-bordered" id="data-table">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Jenis Gabah</th>
                            <th class="text-center">Deskripsi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Data -->
    <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 330px;">
            <div class="modal-content">

                <!-- Header Modal -->
                <div class="modal-header justify-content-center position-relative">
                    <h5 class="modal-title text-center w-100" id="tambahDataModalLabel"
                        style="margin-top: 15px; margin-bottom: 5px;">Form Tambah Data</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 mt-3 me-3" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>

                <!-- Body Modal -->
                <div class="modal-body" style="padding: 0 27px 35px 27px;">
                    <form action="" method="POST">
                        @csrf

                        <!-- Jenis Gabah -->
                        <div class="mb-3">
                            <label for="jenis_gabah" class="form-label" style="color: #4F4F4F; font-weight: 400">Nama Jenis
                                Gabah</label>
                            <input type="text" name="jenis_gabah" id="jenis_gabah" class="form-control custom-input"
                                placeholder="Masukkan jenis gabah">
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label"
                                style="color: #4F4F4F; font-weight: 400">Deskripsi</label>
                            <textarea name="deskripsi" id="deskripsi" class="form-control custom-input" rows="3"
                                placeholder="Masukkan deskripsi"></textarea>
                        </div>

                        <div style="margin-top: 30px;">
                            <button style="height: 43px; font-size: 16px; font-weight: 700; letter-spacing: 2px;"
                                type="submit" class="btn custom-save-btn w-100">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Edit Data -->
    <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 330px;">
            <div class="modal-content">

                <!-- Header Modal -->
                <div class="modal-header justify-content-center position-relative">
                    <h5 class="modal-title text-center w-100" id="editDataModalLabel"
                        style="margin-top: 15px; margin-bottom: 5px;">Form Edit Data</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 mt-3 me-3" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>

                <!-- Body Modal -->
                <div class="modal-body" style="padding: 0 27px 27px 27px;">
                    <form id="editForm">
                        @csrf
                        @method('PUT')

                        <!-- Jenis Gabah -->
                        <div class="mb-3">
                            <label for="edit_jenis_gabah" class="form-label" style="color: #4F4F4F; font-weight: 400">Nama
                                Jenis
                                Gabah</label>
                            <input type="text" name="nama_jenis" id="edit_jenis_gabah" class="form-control custom-input"
                                placeholder="Masukkan jenis gabah" required>
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="edit_deskripsi" class="form-label"
                                style="color: #4F4F4F; font-weight: 400">Deskripsi</label>
                            <textarea name="deskripsi" id="edit_deskripsi" class="form-control custom-input" rows="3"
                                placeholder="Masukkan deskripsi"></textarea>
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

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="max-width: 390px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data <strong id="deleteItemName">nama_jenis</strong>?</p>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Tidak</button> --}}
                    <button type="button" class="btn" style="background-color: #1E3B8A; color: white;"
                        id="confirmDeleteBtn">Ya</button>
                </div>
            </div>
        </div>
    </div>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
(function($) {
    $(document).ready(function() {
        // Retrieve Sanctum token from session
        const sanctumToken = "{{ session('sanctum_token') ?? '' }}".replace(/[\n\r]+/g, '').trim();
        console.log('Sanctum Token:', sanctumToken ? 'Present' : 'Missing');
        console.log('Sanctum Token Value:', sanctumToken);

        // Initialize DataTable
        const table = $('#data-table').DataTable({
            processing: true,
            serverSide: false, // Ubah ke true jika backend mendukung server-side processing
            ajax: {
                url: '{{ config('services.api.base_url') }}/jenis-gabah',
                type: 'GET',
                headers: {
                    'Authorization': `Bearer ${sanctumToken}`,
                    'Accept': 'application/json'
                },
                dataSrc: function(json) {
                    console.log('AJAX Response from /jenis-gabah:', json);
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
                        // window.location.href = '{{ route('login') }}';
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
                    },
                    className: 'text-center'
                },
                {
                    data: 'nama_jenis',
                    name: 'nama_jenis',
                    defaultContent: '-'
                },
                {
                    data: 'deskripsi',
                    name: 'deskripsi',
                    defaultContent: '-'
                },
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: 'text-center',
                    render: function(data, type, row) {
                        return `
                             <button class="btn btn-sm" style="border: none;" onclick="editData(${row.grain_type_id})">
                                <i class="fas fa-edit" style="color: green; font-size: 18px;"></i>
                            </button>
                            <button class="btn btn-sm" style="border: none;" onclick="confirmDelete(${row.grain_type_id})">
                                <i class="fas fa-trash-restore" style="color: #b60303; font-size: 18px;"></i>
                            </button>`;
                    }
                }
            ]
        });

        // Fungsi notifikasi (placeholder, ganti dengan SweetAlert2 jika diperlukan)
        function showNotification(type, title, content) {
            alert(`${title}: ${content}`);
            // Contoh dengan SweetAlert2:
            // Swal.fire({
            //     icon: type,
            //     title: title,
            //     text: content,
            //     timer: 2000,
            //     showConfirmButton: false
            // });
        }

        // Fungsi tambah data
        $('#tambahDataModal form').on('submit', function(e) {
            e.preventDefault();
            let form = $(this);

            let data = {
                nama_jenis: $('#nama_jenis').val(),
                deskripsi: $('#deskripsi').val()
            };

            $.ajax({
                url: '{{ config('services.api.base_url') }}/jenis-gabah',
                method: 'POST',
                headers: {
                    'Authorization': 'Bearer ${sanctumToken}',
                    'Accept': 'application/json'
                },
                data: JSON.stringify(data),
                contentType: 'application/json',
                success: function() {
                    let modalElement = document.getElementById('tambahDataModal');
                    let modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                    modalInstance.hide();

                    table.ajax.reload(null, false);
                    form[0].reset();

                    setTimeout(() => {
                        showNotification('success', 'Berhasil!', 'Data berhasil ditambahkan.');
                    }, 500);
                },
                error: function(xhr) {
                    console.error('AJAX Error (Tambah Data):', {
                        status: xhr.status,
                        response: xhr.responseJSON,
                        error: xhr.statusText
                    });
                    let modalElement = document.getElementById('tambahDataModal');
                    let modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
                    modalInstance.hide();

                    let errorMessage = 'Gagal menambahkan data.';
                    if (xhr.status === 401) {
                        errorMessage = 'Sesi Anda telah berakhir. Silakan login kembali.';
                    }
                    setTimeout(() => {
                        showNotification('error', 'Gagal!', errorMessage);
                    }, 500);
                }
            });
        });

        // Fungsi edit data
        window.editData = function(id) {
            $.ajax({
                url: `{{ config('services.api.base_url') }}/jenis-gabah/${id}`,
                method: 'GET',
                headers: {
                    'Authorization': `Bearer ${sanctumToken}`,
                    'Accept': 'application/json'
                },
                success: function(res) {
                    $('#edit_jenis_gabah').val(res.data.nama_jenis);
                    $('#edit_deskripsi').val(res.data.deskripsi);
                    $('#editForm').data('id', id);

                    var editModal = new bootstrap.Modal(document.getElementById('editDataModal'));
                    editModal.show();
                },
                error: function(xhr) {
                    console.error('AJAX Error (Edit Data):', {
                        status: xhr.status,
                        response: xhr.responseJSON,
                        error: xhr.statusText
                    });
                    let errorMessage = 'Gagal mengambil data untuk diedit.';
                    if (xhr.status === 401) {
                        errorMessage = 'Sesi Anda telah berakhir. Silakan login kembali.';
                    }
                    showNotification('error', 'Gagal!', errorMessage);
                }
            });
        };

        // Submit form edit
        $('#editForm').on('submit', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let data = {
                nama_jenis: $('#edit_jenis_gabah').val(),
                deskripsi: $('#edit_deskripsi').val()
            };

            $.ajax({
                url: `{{ config('services.api.base_url') }}/jenis-gabah/${id}`,
                method: 'PUT',
                headers: {
                    'Authorization': `Bearer ${sanctumToken}`,
                    'Accept': 'application/json'
                },
                data: JSON.stringify(data),
                contentType: 'application/json',
                success: function() {
                    var editModalEl = document.getElementById('editDataModal');
                    var editModal = bootstrap.Modal.getInstance(editModalEl) || new bootstrap.Modal(editModalEl);
                    editModal.hide();

                    table.ajax.reload(null, false);
                    showNotification('success', 'Berhasil!', 'Data berhasil diperbarui.');
                },
                error: function(xhr) {
                    console.error('AJAX Error (Update Data):', {
                        status: xhr.status,
                        response: xhr.responseJSON,
                        error: xhr.statusText
                    });
                    let errorMessage = 'Gagal memperbarui data.';
                    if (xhr.status === 401) {
                        errorMessage = 'Sesi Anda telah berakhir. Silakan login kembali.';
                    }
                    showNotification('error', 'Gagal!', errorMessage);
                }
            });
        });

        // Fungsi konfirmasi hapus
        window.confirmDelete = function(id) {
            let rowData = table.rows().data().toArray().find(item => item.grain_type_id === id);
            $('#deleteItemName').text(rowData.nama_jenis);

            var deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
            deleteModal.show();

            $('#confirmDeleteBtn').off('click').on('click', function() {
                $.ajax({
                    url: `{{ config('services.api.base_url') }}/jenis-gabah/${id}`,
                    method: 'DELETE',
                    headers: {
                        'Authorization': `Bearer ${sanctumToken}`,
                        'Accept': 'application/json'
                    },
                    success: function() {
                        deleteModal.hide();
                        table.ajax.reload(null, false);
                        showNotification('success', 'Berhasil!', 'Data berhasil dihapus.');
                    },
                    error: function(xhr) {
                        console.error('AJAX Error (Delete Data):', {
                            status: xhr.status,
                            response: xhr.responseJSON,
                            error: xhr.statusText
                        });
                        let errorMessage = 'Gagal menghapus data.';
                        if (xhr.status === 401) {
                            errorMessage = 'Sesi Anda telah berakhir. Silakan login kembali.';
                        }
                        deleteModal.hide();
                        showNotification('error', 'Gagal!', errorMessage);
                    }
                });
            });
        };
    });
})(jQuery.noConflict(true));
</script>

    <script>
        function showNotification(type, title, message) {
            var notification = document.getElementById('notification');
            var titleEl = document.getElementById('notificationTitle');
            var messageEl = document.getElementById('notificationMessage');

            // Reset class
            notification.className = 'alert position-fixed top-0 end-0 m-4';
            notification.style.display = 'flex';

            // Tambahkan class berdasarkan tipe
            if (type === 'success') {
                notification.classList.add('success');
            } else if (type === 'error') {
                notification.classList.add('error');
            }

            titleEl.innerText = title;
            messageEl.innerText = ' ' + message;

            setTimeout(function() {
                notification.style.display = 'none';
            }, 4000);
        }

        // Contoh pemanggilan
        // showNotification('success', 'Berhasil!', 'Data telah disimpan.');
    </script>
@endsection

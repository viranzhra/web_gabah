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

        .permission-badge {
            background-color: #1E3B8A;
            color: white;
            padding: 4px 8px;
            border-radius: 10px;
            margin-right: 5px;
            display: inline-block;
            font-size: 11px;
        }
    </style>

    @include('administrator.data_master.button')

    <div id="notification" class="alert position-fixed top-0 end-0 m-4" style="z-index: 9999;">
        <div id="notificationTitle" style="font-weight: bold;"></div>
        <div id="notificationMessage"></div>
    </div>

    <!-- Users DataTable -->
    <div class="add-button mb-3">
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#tambahUserModal" style="background-color: #1E3B8A; border-radius: 12px; border: none;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29">
                <path
                    d="M8.4668 14.5C8.4668 14.2597 8.56228 14.0291 8.73223 13.8592C8.90219 13.6892 9.13269 13.5938 9.37305 13.5938H13.5938V9.37305C13.5938 9.13269 13.6892 8.90219 13.8592 8.73223C14.0291 8.56228 14.2597 8.4668 14.5 8.4668C14.7404 8.4668 14.9709 8.56228 15.1408 8.73223C15.3108 8.90219 15.4063 9.13269 15.4063 9.37305V13.5938H19.627C19.8673 13.5938 20.0978 13.6892 20.2678 13.8592C20.4377 14.0291 20.5332 14.2597 20.5332 14.5C20.5332 14.7404 20.4377 14.9709 20.2678 15.1408C20.0978 15.3108 19.8673 15.4063 19.627 15.4063H15.4063V19.627C15.4063 19.8673 15.3108 20.0978 15.1408 20.2678C14.9709 20.4377 14.7404 20.5332 14.5 20.5332C14.2597 20.5332 14.0291 20.4377 13.8592 20.2678C13.6892 20.0978 13.5938 19.8673 13.5938 19.627V15.4063H9.37305C9.13269 15.4063 8.90219 15.3108 8.73223 15.1408C8.56228 14.9709 8.4668 14.7404 8.4668 14.5Z"
                    fill="white" />
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M8.84134 4.55421C12.6022 4.13726 16.3977 4.13726 20.1586 4.55421C22.3662 4.80071 24.1485 6.5395 24.4071 8.75921C24.8542 12.5739 24.8542 16.4273 24.4071 20.242C24.1473 22.4617 22.365 24.1993 20.1586 24.447C16.3977 24.8639 12.6022 24.8639 8.84134 24.447C6.63372 24.1993 4.85143 22.4617 4.59284 20.242C4.14776 16.4273 4.14776 12.5739 4.59284 8.75921C4.85143 6.5395 6.63493 4.80071 8.84134 4.55421ZM19.958 6.35463C16.3304 5.95252 12.6695 5.95252 9.04193 6.35463C8.37039 6.42913 7.74357 6.72785 7.26275 7.20253C6.78193 7.67722 6.47518 8.30014 6.39205 8.97067C5.96228 12.6452 5.96228 16.3572 6.39205 20.0318C6.47543 20.7021 6.78229 21.3247 7.26309 21.7991C7.74389 22.2736 8.37057 22.5721 9.04193 22.6466C12.6391 23.0478 16.3608 23.0478 19.958 22.6466C20.6292 22.5719 21.2556 22.2732 21.7361 21.7988C22.2167 21.3244 22.5234 20.7019 22.6067 20.0318C23.0364 16.3572 23.0364 12.6452 22.6067 8.97067C22.5231 8.30076 22.2163 7.67853 21.7358 7.20435C21.2552 6.73017 20.629 6.43169 19.958 6.35704"
                    fill="white" />
            </svg>
            Tambah User
        </button>
    </div>
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="fw-semibold mb-3">Data Users</h5>
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table table-striped table-bordered" id="users-table">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama User</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Roles DataTable -->
    <div class="add-button mb-3">
        <button type="button" class="btn btn-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
            data-bs-target="#tambahRoleModal" style="background-color: #1E3B8A; border-radius: 12px; border: none;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 29 29">
                <path
                    d="M8.4668 14.5C8.4668 14.2597 8.56228 14.0291 8.73223 13.8592C8.90219 13.6892 9.13269 13.5938 9.37305 13.5938H13.5938V9.37305C13.5938 9.13269 13.6892 8.90219 13.8592 8.73223C14.0291 8.56228 14.2597 8.4668 14.5 8.4668C14.7404 8.4668 14.9709 8.56228 15.1408 8.73223C15.3108 8.90219 15.4063 9.13269 15.4063 9.37305V13.5938H19.627C19.8673 13.5938 20.0978 13.6892 20.2678 13.8592C20.4377 14.0291 20.5332 14.2597 20.5332 14.5C20.5332 14.7404 20.4377 14.9709 20.2678 15.1408C20.0978 15.3108 19.8673 15.4063 19.627 15.4063H15.4063V19.627C15.4063 19.8673 15.3108 20.0978 15.1408 20.2678C14.9709 20.4377 14.7404 20.5332 14.5 20.5332C14.2597 20.5332 14.0291 20.4377 13.8592 20.2678C13.6892 20.0978 13.5938 19.8673 13.5938 19.627V15.4063H9.37305C9.13269 15.4063 8.90219 15.3108 8.73223 15.1408C8.56228 14.9709 8.4668 14.7404 8.4668 14.5Z"
                    fill="white" />
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M8.84134 4.55421C12.6022 4.13726 16.3977 4.13726 20.1586 4.55421C22.3662 4.80071 24.1485 6.5395 24.4071 8.75921C24.8542 12.5739 24.8542 16.4273 24.4071 20.242C24.1473 22.4617 22.365 24.1993 20.1586 24.447C16.3977 24.8639 12.6022 24.8639 8.84134 24.447C6.63372 24.1993 4.85143 22.4617 4.59284 20.242C4.14776 16.4273 4.14776 12.5739 4.59284 8.75921C4.85143 6.5395 6.63493 4.80071 8.84134 4.55421ZM19.958 6.35463C16.3304 5.95252 12.6695 5.95252 9.04193 6.35463C8.37039 6.42913 7.74357 6.72785 7.26275 7.20253C6.78193 7.67722 6.47518 8.30014 6.39205 8.97067C5.96228 12.6452 5.96228 16.3572 6.39205 20.0318C6.47543 20.7021 6.78229 21.3247 7.26309 21.7991C7.74389 22.2736 8.37057 22.5721 9.04193 22.6466C12.6391 23.0478 16.3608 23.0478 19.958 22.6466C20.6292 22.5719 21.2556 22.2732 21.7361 21.7988C22.2167 21.3244 22.5234 20.7019 22.6067 20.0318C23.0364 16.3572 23.0364 12.6452 22.6067 8.97067C22.5231 8.30076 22.2163 7.67853 21.7358 7.20435C21.2552 6.73017 20.629 6.43169 19.958 6.35704"
                    fill="white" />
            </svg>
            Tambah Role
        </button>
    </div>
    <div class="card mt-4">
        <div class="card-body">
            <h5 class="fw-semibold mb-3">Data Roles</h5>
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table table-striped table-bordered" id="roles-table">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Role</th>
                            <th class="text-center">Hak Akses</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <!-- Role Add Modal -->
    <div class="modal fade" id="tambahRoleModal" tabindex="-1" aria-labelledby="tambahRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 330px;">
            <div class="modal-content">
                <div class="modal-header justify-content-center position-relative">
                    <h5 class="modal-title text-center w-100" id="tambahRoleModalLabel"
                        style="margin-top: 15px; margin-bottom: 5px;">Form Tambah Role</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 mt-3 me-3" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>
                <div class="modal-body" style="padding: 0 27px 35px 27px;">
                    <form id="tambahRoleForm" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_role" class="form-label" style="color: #4F4F4F; font-weight: 400">Nama
                                Role</label>
                            <input type="text" name="name" id="nama_role" class="form-control custom-input"
                                placeholder="Masukkan nama role">
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color: #4F4F4F; font-weight: 400">Hak Akses</label>
                            <div id="permissions-switches"></div>
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

    <!-- Role Edit Modal -->
    <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 330px;">
            <div class="modal-content">
                <div class="modal-header justify-content-center position-relative">
                    <h5 class="modal-title text-center w-100" id="editRoleModalLabel"
                        style="margin-top: 15px; margin-bottom: 5px;">Form Edit Role</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 mt-3 me-3"
                        data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body" style="padding: 0 27px 27px 27px;">
                    <form id="editRoleForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit_nama_role" class="form-label" style="color: #4F4F4F; font-weight: 400">Nama
                                Role</label>
                            <input type="text" name="name" id="edit_nama_role" class="form-control custom-input"
                                placeholder="Masukkan nama role" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="color: #4F4F4F; font-weight: 400">Hak Akses</label>
                            <div id="edit-permissions-switches"></div>
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

    <!-- User Add Modal -->
    <div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="max-width: 330px;">
            <div class="modal-content">
                <div class="modal-header justify-content-center position-relative">
                    <h5 class="modal-title text-center w-100" id="tambahUserModalLabel"
                        style="margin-top: 15px; margin-bottom: 5px;">Form Tambah User</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 mt-3 me-3"
                        data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body" style="padding: 0 27px 35px 27px;">
                    <form id="tambahUserForm" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nama_user" class="form-label" style="color: #4F4F4F; font-weight: 400">Nama
                                User</label>
                            <input type="text" name="name" id="nama_user" class="form-control custom-input"
                                placeholder="Masukkan nama user">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"
                                style="color: #4F4F4F; font-weight: 400">Email</label>
                            <input type="email" name="email" id="email" class="form-control custom-input"
                                placeholder="Masukkan email">
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label"
                                style="color: #4F4F4F; font-weight: 400">Password</label>
                            <input type="text" name="password" id="password" class="form-control custom-input"
                                value="user123" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="role_id" class="form-label"
                                style="color: #4F4F4F; font-weight: 400">Role</label>
                            <select name="role_id" id="role_id" class="form-control custom-input">
                                <option value="">Pilih Role</option>
                            </select>
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

    <!-- User Edit Modal -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="max-width: 330px;">
            <div class="modal-content">
                <div class="modal-header justify-content-center position-relative">
                    <h5 class="modal-title text-center w-100" id="editUserModalLabel"
                        style="margin-top: 15px; margin-bottom: 5px;">Form Edit User</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 mt-3 me-3"
                        data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body" style="padding: 0 27px 27px 27px;">
                    <form id="editUserForm">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="edit_nama_user" class="form-label" style="color: #4F4F4F; font-weight: 400">Nama
                                User</label>
                            <input type="text" name="name" id="edit_nama_user" class="form-control custom-input"
                                placeholder="Masukkan nama user" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_role_id" class="form-label"
                                style="color: #4F4F4F; font-weight: 400">Role</label>
                            <select name="role_id" id="edit_role_id" class="form-control custom-input">
                                <option value="">Pilih Role</option>
                            </select>
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

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" style="max-width: 390px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Konfirmasi Penghapusan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data <strong id="deleteItemName">nama</strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" style="background-color: #1E3B8A; color: white;"
                        id="confirmDeleteBtn">Ya</button>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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

                // Fetch roles for user form dropdown
                function loadRoles(selectElementId) {
                    $.ajax({
                        url: '/roles',
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json'
                        },
                        success: function(response) {
                            let roles = response.data || [];
                            let select = $(`#${selectElementId}`);
                            select.empty().append('<option value="">Pilih Role</option>');
                            roles.forEach(role => {
                                select.append(
                                    `<option value="${role.id}">${role.name}</option>`);
                            });
                        },
                        error: function(xhr) {
                            showNotification('error', 'Gagal!', 'Gagal memuat data roles.');
                        }
                    });
                }

                // Fetch permissions for toggle switches
                function loadPermissions(containerId, selectedPermissions = []) {
                    $.ajax({
                        url: '/permissions',
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json'
                        },
                        success: function(response) {
                            let permissions = response.data || [];
                            let container = $(`#${containerId}`);
                            container.empty();
                            permissions.forEach(perm => {
                                let isChecked = selectedPermissions.includes(perm.id) ? 'checked' : '';
                                container.append(`
                                    <div class="form-check form-switch">
                                        <input type="checkbox" name="permissions[]" value="${perm.id}"
                                            class="form-check-input" ${isChecked}>
                                        <label class="form-check-label">${perm.description}</label>
                                    </div>
                                `);
                            });
                        },
                        error: function(xhr) {
                            showNotification('error', 'Gagal!', 'Gagal memuat data permissions.');
                        }
                    });
                }

                // Roles DataTable
                const rolesTable = $('#roles-table').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: {
                        url: '/roles',
                        type: 'GET',
                        headers: {
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json'
                        },
                        dataSrc: function(json) {
                            if (json.error) {
                                showNotification('error', 'Gagal!', json.error);
                                return [];
                            }
                            return json.data || [];
                        },
                        error: function(xhr) {
                            let errorMessage = 'Terjadi kesalahan saat memuat data.';
                            if (xhr.status === 401) {
                                errorMessage = 'Sesi telah berakhir. Silakan login kembali.';
                            }
                            showNotification('error', 'Gagal!', errorMessage);
                            rolesTable.processing(false);
                        }
                    },
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                            className: 'text-center'
                        },
                        {
                            data: 'name',
                            defaultContent: '-'
                        },
                        {
                            data: 'permissions_display',
                            render: function(data) {
                                if (!data || data.length === 0) return '-';
                                return data.map(perm => `<span class="permission-badge">${perm}</span>`).join(' ');
                            }
                        },
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return `
                                    <button class="btn btn-sm" style="border: none;" onclick="editRole(${row.id})">
                                        <i class="fas fa-edit" style="color: green; font-size: 18px;"></i>
                                    </button>
                                    <button class="btn btn-sm" style="border: none;" onclick="confirmDelete('role', ${row.id}, '${row.name}')">
                                        <i class="fas fa-trash-restore" style="color: #b60303; font-size: 18px;"></i>
                                    </button>`;
                            }
                        }
                    ]
                });

                // Users DataTable
                const usersTable = $('#users-table').DataTable({
                    processing: true,
                    serverSide: false,
                    ajax: {
                        url: '/users',
                        type: 'GET',
                        headers: {
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json'
                        },
                        dataSrc: function(json) {
                            if (json.error) {
                                showNotification('error', 'Gagal!', json.error);
                                return [];
                            }
                            return json.data || [];
                        },
                        error: function(xhr) {
                            let errorMessage = 'Terjadi kesalahan saat memuat data.';
                            if (xhr.status === 401) {
                                errorMessage = 'Sesi telah berakhir. Silakan login kembali.';
                            }
                            showNotification('error', 'Gagal!', errorMessage);
                            usersTable.processing(false);
                        }
                    },
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1;
                            },
                            className: 'text-center'
                        },
                        {
                            data: 'name',
                            defaultContent: '-'
                        },
                        {
                            data: 'email',
                            defaultContent: '-'
                        },
                        {
                            data: 'role',
                            render: function(data) {
                                return data ? data.name : '-';
                            }
                        },
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            className: 'text-center',
                            render: function(data, type, row) {
                                return `
                                    <button class="btn btn-sm" style="border: none;" onclick="editUser(${row.id})">
                                        <i class="fas fa-edit" style="color: green; font-size: 18px;"></i>
                                    </button>
                                    <button class="btn btn-sm" style="border: none;" onclick="confirmDelete('user', ${row.id}, '${row.name}')">
                                        <i class="fas fa-trash-restore" style="color: #b60303; font-size: 18px;"></i>
                                    </button>`;
                            }
                        }
                    ]
                });

                // Load permissions for add role form
                loadPermissions('permissions-switches');

                // Add Role Form Submission
                $('#tambahRoleForm').on('submit', function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let permissions = [];
                    $('#permissions-switches input[name="permissions[]"]:checked').each(function() {
                        permissions.push($(this).val());
                    });
                    let data = {
                        name: $('#nama_role').val(),
                        permissions: permissions,
                        _token: $('input[name="_token"]').val()
                    };

                    $.ajax({
                        url: '/roles',
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json'
                        },
                        data: JSON.stringify(data),
                        contentType: 'application/json',
                        success: function(response) {
                            let modalElement = document.getElementById('tambahRoleModal');
                            let modalInstance = bootstrap.Modal.getInstance(modalElement) ||
                                new bootstrap.Modal(modalElement);
                            modalInstance.hide();

                            rolesTable.ajax.reload(null, false);
                            form[0].reset();
                            loadPermissions('permissions-switches'); // Reset switches
                            showNotification('success', 'Berhasil!',
                                'Role berhasil ditambahkan.');
                        },
                        error: function(xhr) {
                            let errorMessage = xhr.responseJSON?.message ||
                                'Gagal menambahkan role.';
                            if (xhr.status === 401) {
                                errorMessage =
                                'Sesi telah berakhir. Silakan login kembali.';
                            }
                            showNotification('error', 'Gagal!', errorMessage);
                        }
                    });
                });

                // Edit Role
                window.editRole = function(id) {
                    $.ajax({
                        url: `/roles/${id}`,
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json'
                        },
                        success: function(res) {
                            $('#edit_nama_role').val(res.data.name);
                            loadPermissions('edit-permissions-switches', res.data.permissions);
                            $('#editRoleForm').data('id', id);

                            var editModal = new bootstrap.Modal(document.getElementById(
                                'editRoleModal'));
                            editModal.show();
                        },
                        error: function(xhr) {
                            let errorMessage = 'Gagal mengambil data role.';
                            if (xhr.status === 401) {
                                errorMessage = 'Sesi telah berakhir. Silakan login kembali.';
                            }
                            showNotification('error', 'Gagal!', errorMessage);
                        }
                    });
                };

                // Edit Role Form Submission
                $('#editRoleForm').on('submit', function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    let permissions = [];
                    $('#edit-permissions-switches input[name="permissions[]"]:checked').each(function() {
                        permissions.push($(this).val());
                    });
                    let data = {
                        name: $('#edit_nama_role').val(),
                        permissions: permissions,
                        _token: $('input[name="_token"]').val()
                    };

                    $.ajax({
                        url: `/roles/${id}`,
                        method: 'PUT',
                        headers: {
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json'
                        },
                        data: JSON.stringify(data),
                        contentType: 'application/json',
                        success: function() {
                            var editModalEl = document.getElementById('editRoleModal');
                            var editModal = bootstrap.Modal.getInstance(editModalEl) ||
                                new bootstrap.Modal(editModalEl);
                            editModal.hide();

                            rolesTable.ajax.reload(null, false);
                            showNotification('success', 'Berhasil!',
                                'Role berhasil diperbarui.');
                        },
                        error: function(xhr) {
                            let errorMessage = 'Gagal memperbarui role.';
                            if (xhr.status === 401) {
                                errorMessage =
                                'Sesi telah berakhir. Silakan login kembali.';
                            }
                            showNotification('error', 'Gagal!', errorMessage);
                        }
                    });
                });

                // Add User Form Submission
                $('#tambahUserForm').on('submit', function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let data = {
                        name: $('#nama_user').val(),
                        email: $('#email').val(),
                        password: $('#password').val(),
                        role_id: $('#role_id').val(),
                        _token: $('input[name="_token"]').val()
                    };

                    $.ajax({
                        url: '/users',
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json'
                        },
                        data: JSON.stringify(data),
                        contentType: 'application/json',
                        success: function(response) {
                            let modalElement = document.getElementById('tambahUserModal');
                            let modalInstance = bootstrap.Modal.getInstance(modalElement) ||
                                new bootstrap.Modal(modalElement);
                            modalInstance.hide();

                            usersTable.ajax.reload(null, false);
                            form[0].reset();
                            $('#password').val('user123'); // Reset password to default
                            showNotification('success', 'Berhasil!',
                                'User berhasil ditambahkan.');
                        },
                        error: function(xhr) {
                            let errorMessage = xhr.responseJSON?.message ||
                                'Gagal menambahkan user.';
                            if (xhr.status === 401) {
                                errorMessage =
                                'Sesi telah berakhir. Silakan login kembali.';
                            }
                            showNotification('error', 'Gagal!', errorMessage);
                        }
                    });
                });

                // Edit User
                window.editUser = function(id) {
                    $.ajax({
                        url: `/users/${id}`,
                        method: 'GET',
                        headers: {
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json'
                        },
                        success: function(res) {
                            $('#edit_nama_user').val(res.data.name);
                            $('#edit_role_id').val(res.data.role_id);
                            $('#editUserForm').data('id', id);

                            loadRoles('edit_role_id');
                            var editModal = new bootstrap.Modal(document.getElementById(
                                'editUserModal'));
                            editModal.show();
                        },
                        error: function(xhr) {
                            let errorMessage = 'Gagal mengambil data user.';
                            if (xhr.status === 401) {
                                errorMessage = 'Sesi telah berakhir. Silakan login kembali.';
                            }
                            showNotification('error', 'Gagal!', errorMessage);
                        }
                    });
                };

                // Edit User Form Submission
                $('#editUserForm').on('submit', function(e) {
                    e.preventDefault();
                    let id = $(this).data('id');
                    let data = {
                        name: $('#edit_nama_user').val(),
                        role_id: $('#edit_role_id').val(),
                        _token: $('input[name="_token"]').val()
                    };

                    $.ajax({
                        url: `/users/${id}`,
                        method: 'PUT',
                        headers: {
                            'Authorization': `Bearer ${sanctumToken}`,
                            'Accept': 'application/json'
                        },
                        data: JSON.stringify(data),
                        contentType: 'application/json',
                        success: function() {
                            var editModalEl = document.getElementById('editUserModal');
                            var editModal = bootstrap.Modal.getInstance(editModalEl) ||
                                new bootstrap.Modal(editModalEl);
                            editModal.hide();

                            usersTable.ajax.reload(null, false);
                            showNotification('success', 'Berhasil!',
                                'User berhasil diperbarui.');
                        },
                        error: function(xhr) {
                            let errorMessage = 'Gagal memperbarui user.';
                            if (xhr.status === 401) {
                                errorMessage =
                                'Sesi telah berakhir. Silakan login kembali.';
                            }
                            showNotification('error', 'Gagal!', errorMessage);
                        }
                    });
                });

                // Delete Confirmation
                window.confirmDelete = function(type, id, name) {
                    $('#deleteItemName').text(name);
                    var deleteModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
                    deleteModal.show();

                    $('#confirmDeleteBtn').off('click').on('click', function() {
                        let url = type === 'role' ?
                            `/roles/${id}` :
                            `/users/${id}`;

                        $.ajax({
                            url: url,
                            method: 'DELETE',
                            headers: {
                                'Authorization': `Bearer ${sanctumToken}`,
                                'Accept': 'application/json'
                            },
                            success: function() {
                                deleteModal.hide();
                                if (type === 'role') {
                                    rolesTable.ajax.reload(null, false);
                                    loadRoles('role_id');
                                    loadRoles('edit_role_id');
                                } else {
                                    usersTable.ajax.reload(null, false);
                                }
                                showNotification('success', 'Berhasil!',
                                    `Data ${type} berhasil dihapus.`);
                            },
                            error: function(xhr) {
                                let errorMessage = `Gagal menghapus data ${type}.`;
                                if (xhr.status === 401) {
                                    errorMessage =
                                        'Sesi telah berakhir. Silakan login kembali.';
                                }
                                deleteModal.hide();
                                showNotification('error', 'Gagal!', errorMessage);
                            }
                        });
                    });
                };

                // Load roles for add user form
                loadRoles('role_id');
            });
        })(jQuery.noConflict(true));
    </script>
@endsection
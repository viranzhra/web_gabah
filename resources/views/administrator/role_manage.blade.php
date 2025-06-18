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
    </style>

    <h4 class="fw-semibold mb-3" style="margin-top: 10px;">Data Master</h4>

    @include('administrator.data_master.button')

    {{-- Alert --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        <div class="mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#roleModal" id="btnAddRole">
                Tambah Role
            </button>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h4>Data Roles</h4>
                <table class="table table-bordered" id="roles-table">
                    <thead>
                        <tr>
                            <th>Nama Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="col-md-6">
                <h4>Data User</h4>
                <table class="table table-bordered" id="users-table">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user['name'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>
                                    @if (isset($user['roles']) && is_array($user['roles']))
                                        {{ implode(', ', array_column($user['roles'], 'name')) }}
                                    @else
                                        -
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal Create/Edit Role --}}
    <div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form method="POST" id="roleForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="roleId" name="id">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Role</label>
                            <input type="text" class="form-control" name="name" id="roleName" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Permissions</label>
                            <div class="row">
                                @foreach ($permissions as $permission)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input permission-checkbox" type="checkbox"
                                                name="permissions[]" value="{{ $permission['id'] }}"
                                                id="perm-{{ $permission['id'] }}">
                                            <label class="form-check-label" for="perm-{{ $permission['id'] }}">
                                                {{ $permission['name'] }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            // Tabel Roles
            const rolesTable = $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url("/datatable/roles") }}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            // Tabel Users
            const usersTable = $('#users-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url("/datatable/users") }}',
                columns: [
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'roles', name: 'roles', orderable: false, searchable: false }
                ]
            });

            // Tombol Tambah Role
            $('#btnAddRole').on('click', function () {
                $('#roleForm').attr('action', '{{ route('roles.store') }}');
                $('#roleForm').find('input[name="_method"]').remove();
                $('#roleForm')[0].reset();
                $('#roleId').val('');
                $('.permission-checkbox').prop('checked', false);
                $('.modal-title').text('Tambah Role');
            });

            // Tombol Edit Role
            $('#roles-table').on('click', '.btn-edit', function () {
                let roleId = $(this).data('id');
                $.get(`/roles/${roleId}/edit`, function (res) {
                    $('#roleName').val(res.role.name);
                    $('#roleId').val(res.role.id);
                    $('.permission-checkbox').prop('checked', false);
                    res.rolePermissions.forEach(id => {
                        $(`#perm-${id}`).prop('checked', true);
                    });

                    $('#roleForm').attr('action', `/roles/${roleId}`);
                    if (!$('#roleForm input[name="_method"]').length) {
                        $('#roleForm').append(`<input type="hidden" name="_method" value="PUT">`);
                    }
                    $('.modal-title').text('Edit Role');
                    $('#roleModal').modal('show');
                });
            });
        });
    </script>
@endsection

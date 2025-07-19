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

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        .table {
            min-width: 100%;
            /* Ensure consistent minimum width for both tables */
            width: 100%;
        }

        .card {
            width: 100%;
        }

        .btn-toggle {
            transition: background-color 0.3s ease, color 0.3s ease;
            border-radius: 12px;
            padding: 8px 16px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-toggle.completed {
            background-color: #28a745;
            border-color: #28a745;
            color: white;
        }

        .btn-toggle.unvalidated {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }

        .btn-toggle:hover {
            opacity: 0.9;
        }
    </style>

    <h4 class="fw-semibold mb-3" style="margin-top: 10px;">Validasi Pengeringan</h4>

    <!-- Tombol Tambah Data dan Completed -->
    <div class="add-button mb-3 d-flex gap-2">
        <button type="button" class="btn btn-primary d-flex align-items-center gap-1" data-bs-toggle="modal"
            data-bs-target="#tambahDataModal" style="background-color: #1E3B8A; border-radius: 12px; border: none;">
            <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                    d="M7.75 15.8229C7.75 15.4412 7.82517 15.0633 7.97122 14.7107C8.11728 14.3581 8.33135 14.0377 8.60122 13.7678C8.87109 13.498 9.19147 13.2839 9.54408 13.1379C9.89668 12.9918 10.2746 12.9166 10.6562 12.9166C11.0379 12.9166 11.4158 12.9918 11.7684 13.1379C12.121 13.2839 12.4414 13.498 12.7113 13.7678C12.9811 14.0377 13.1952 14.3581 13.3413 14.7107C13.4873 15.0633 13.5625 15.4412 13.5625 15.8229C13.5625 16.5937 13.2563 17.3329 12.7113 17.8779C12.1663 18.4229 11.427 18.7291 10.6562 18.7291C9.88546 18.7291 9.14625 18.4229 8.60122 17.8779C8.05619 17.3329 7.75 16.5937 7.75 15.8229ZM10.6562 14.8541C10.3993 14.8541 10.1529 14.9562 9.97124 15.1379C9.78956 15.3195 9.6875 15.5659 9.6875 15.8229C9.6875 16.0798 9.78956 16.3262 9.97124 16.5079C10.1529 16.6896 10.3993 16.7916 10.6562 16.7916C10.9132 16.7916 11.1596 16.6896 11.3413 16.5079C11.5229 16.3262 11.625 16.0798 11.625 15.8229C11.625 15.5659 11.5229 15.3195 11.3413 15.1379C11.1596 14.9562 10.9132 14.8541 10.6562 14.8541ZM14.8542 15.8229C14.8542 15.5659 14.9562 15.3195 15.1379 15.1379C15.3196 14.9562 15.566 14.8541 15.8229 14.8541H19.0521C19.309 14.8541 19.5554 14.9562 19.7371 15.1379C19.9188 15.3195 20.0208 15.5659 20.0208 15.8229C20.0208 16.0798 19.9188 16.3262 19.7371 16.5079C19.5554 16.6896 19.309 16.7916 19.0521 16.7916H15.8229C15.566 16.7916 15.3196 16.6896 15.1379 16.5079C14.9562 16.3262 14.8542 15.8229 14.8542 15.8229ZM7.75 10.0104C7.75 9.75345 7.85206 9.50704 8.03374 9.32537C8.21542 9.14369 8.46182 9.04163 8.71875 9.04163H19.0521C19.309 9.04163 19.5554 9.14369 19.7371 9.32537C19.9188 9.50704 20.0208 9.75345 20.0208 10.0104C20.0208 10.2673 19.9188 10.5137 19.7371 10.6954C19.5554 10.8771 19.309 10.9791 19.0521 10.9791H8.71875C8.46182 10.9791 8.21542 10.8771 8.03374 10.6954C7.85206 10.5137 7.75 10.2673 7.75 10.0104Z"
                    fill="white" />
                <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                    d="M8.07292 3.875C6.95956 3.875 5.8918 4.31728 5.10454 5.10454C4.31728 5.8918 3.875 6.95956 3.875 8.07292V19.6979C3.875 20.8113 4.31728 21.879 5.10454 22.6663C5.8918 23.4536 6.95956 23.8958 8.07292 23.8958H19.6979C20.8113 23.8958 21.879 23.4536 22.6663 22.6663C23.4536 21.879 23.8958 20.8113 23.8958 19.6979V8.07292C23.8958 6.95956 23.4536 5.8918 22.6663 5.10454C21.879 4.31728 20.8113 3.875 19.6979 3.875H8.07292ZM5.8125 8.07292C5.8125 6.82517 6.82517 5.8125 8.07292 5.8125H19.6979C20.9457 5.8125 21.9583 6.82517 21.9583 8.07292V19.6979C21.9594 20.1811 21.8052 20.6517 21.5184 21.0406C21.2317 21.4294 20.8276 21.7158 20.3657 21.8576C20.1539 21.923 19.9313 21.9566 19.6979 21.9583H8.07292C7.47342 21.9583 6.89847 21.7202 6.47456 21.2963C6.05065 20.8724 5.8125 20.2974 5.8125 19.6979V8.07292Z"
                    fill="white" />
                <path fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"
                    d="M11.3021 27.125C10.5969 27.1253 9.90304 26.9479 9.28449 26.6093C8.66593 26.2707 8.14265 25.7817 7.76294 25.1875H20.3438C21.6284 25.1875 22.8604 24.6771 23.7688 23.7688C24.6772 22.8604 25.1875 21.6283 25.1875 20.3437V7.76416C25.7817 8.14387 26.2707 8.66715 26.6094 9.28571C26.948 9.90426 27.1253 10.5982 27.125 11.3033V20.345C27.1247 22.1433 26.4101 23.8678 25.1384 25.1392C23.8667 26.4107 22.142 27.125 20.3438 27.125H11.3021Z"
                    fill="white" />
            </svg>
            Form Validasi
        </button>
        <button type="button" class="btn btn-toggle completed d-flex align-items-center gap-1" id="completedButton">
            <i class="fas fa-check-circle"></i>
            Completed
        </button>
    </div>

    <!-- DataTable -->
    <div class="card mt-4">
        <div class="card-body">
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table table-striped table-bordered" id="data-table">
                    <thead class="text-center">
                        <tr>
                            <th rowspan="2" class="text-center">No</th>
                            <th rowspan="2" class="text-center">Durasi Terlaksana IoT (Menit)</th>
                            <th colspan="2" class="text-center">Waktu Pengeringan Berakhir</th>
                            <th rowspan="2" class="text-center">Validasi Durasi Aktual (Menit)</th>
                            <th rowspan="2" class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                        <tr>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Jam</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- DataTable untuk Completed Data -->
    <div class="card mt-4 d-none" id="completedTableContainer">
        <div class="card-body">
            <div class="table-responsive" style="overflow-x: auto;">
                <table class="table table-striped table-bordered" id="completed-data-table">
                    <thead class="text-center">
                        <tr>
                            <th rowspan="2" class="text-center">No</th>
                            <th rowspan="2" class="text-center">Durasi Terlaksana IoT (Menit)</th>
                            <th colspan="2" class="text-center">Waktu Pengeringan Berakhir</th>
                            <th rowspan="2" class="text-center">Validasi Durasi Aktual (Menit)</th>
                            <th rowspan="2" class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                        <tr>
                            <th class="text-center">Tanggal</th>
                            <th class="text-center">Jam</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
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
                        style="margin-top: 15px; margin-bottom: 5px;">Form Validasi</h5>
                    <button type="button" class="btn-close position-absolute end-0 top-0 mt-3 me-3" data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
                </div>
                <form id="formTambahData" action="/training-data" method="POST">
                    @csrf
                    <div class="modal-body" style="padding: 20px 27px 40px 27px;">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="durasi_iot" class="form-label" style="color: #4F4F4F; font-weight: 400">Durasi
                                    Terlaksana IoT (Menit)</label>
                                <input type="number" step="any" class="form-control custom-input" name="DryingTime"
                                    id="durasi_iot" required>
                            </div>
                            <div class="col-md-12">
                                <label for="waktu_berakhir" class="form-label"
                                    style="color: #4F4F4F; font-weight: 400">Waktu Pengeringan Berakhir</label>
                                <input type="datetime-local" class="form-control custom-input" name="EndTime"
                                    id="waktu_berakhir" required>
                            </div>
                            <div class="col-md-12">
                                <label for="durasi_validasi" class="form-label"
                                    style="color: #4F4F4F; font-weight: 400">Validasi Durasi Aktual (Menit)</label>
                                <input type="number" step="any" class="form-control custom-input"
                                    name="DryingTimeValidated" id="durasi_validasi" required>
                            </div>
                            <div style="margin-top: 30px;">
                                <button style="height: 43px; font-size: 16px; font-weight: 700; letter-spacing: 2px;"
                                    type="submit" class="btn custom-save-btn w-100">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        jQuery(document).ready(function($) {
            // Initialize main DataTable (unvalidated data)
            let mainTable = $('#data-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '/validasi',
                    data: {
                        is_validated: false
                    },
                    dataSrc: function(json) {
                        if (json.error || !json.data) {
                            console.warn('Failed to fetch training data: ' + (json.error || 'No data'));
                            return [];
                        }
                        return json.data;
                    }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'durasi_iot',
                        name: 'durasi_iot',
                        defaultContent: '-'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        defaultContent: '-'
                    },
                    {
                        data: 'jam',
                        name: 'jam',
                        defaultContent: '-'
                    },
                    {
                        data: 'durasi_validasi',
                        name: 'durasi_validasi',
                        defaultContent: '-'
                    },
                    {
                        data: null,
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                            <button class="btn btn-sm" style="border: none;" onclick="validateData('${row.id}')">
                                <i class="fas fa-check" style="color: #28a745; font-size: 18px;"></i>
                            </button>
                            <button class="btn btn-sm" style="border: none;" onclick="editData('${row.id}')">
                                <i class="fas fa-edit" style="color: green; font-size: 18px;"></i>
                            </button>
                            <button class="btn btn-sm" style="border: none;" onclick="deleteData('${row.id}')">
                                <i class="fas fa-trash-restore" style="color: #b60303; font-size: 18px;"></i>
                            </button>`;
                        }
                    }
                ]
            });

            // Initialize completed DataTable (validated data)
            let completedTable = $('#completed-data-table').DataTable({
                processing: true,
                serverSide: false,
                ajax: {
                    url: '/validasi',
                    data: {
                        is_validated: true
                    },
                    dataSrc: function(json) {
                        if (json.error || !json.data) {
                            console.warn('Failed to fetch completed training data: ' + (json.error ||
                                'No data'));
                            return [];
                        }
                        return json.data;
                    }
                },
                columns: [{
                        data: null,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        },
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'durasi_iot',
                        name: 'durasi_iot',
                        defaultContent: '-'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        defaultContent: '-'
                    },
                    {
                        data: 'jam',
                        name: 'jam',
                        defaultContent: '-'
                    },
                    {
                        data: 'durasi_validasi',
                        name: 'durasi_validasi',
                        defaultContent: '-'
                    },
                    {
                        data: null,
                        name: 'aksi',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return `
                            <button class="btn btn-sm" style="border: none;" onclick="editData('${row.id}')">
                                <i class="fas fa-edit" style="color: green; font-size: 18px;"></i>
                            </button>
                            <button class="btn btn-sm" style="border: none;" onclick="deleteData('${row.id}')">
                                <i class="fas fa-trash-restore" style="color: #b60303; font-size: 18px;"></i>
                            </button>`;
                        }
                    }
                ]
            });

            // Load saved state from localStorage
            let isShowingCompleted = localStorage.getItem('isShowingCompleted') === 'true';
            const completedButton = $('#completedButton');
            if (isShowingCompleted) {
                $('#data-table').closest('.card').addClass('d-none');
                $('#completedTableContainer').removeClass('d-none');
                completedButton.removeClass('completed').addClass('unvalidated');
                completedButton.html(`<i class="fas fa-times-circle"></i> Unvalidated`);
                completedTable.ajax.reload();
            } else {
                $('#completedTableContainer').addClass('d-none');
                $('#data-table').closest('.card').removeClass('d-none');
                completedButton.removeClass('unvalidated').addClass('completed');
                completedButton.html(`<i class="fas fa-check-circle"></i> Completed`);
                mainTable.ajax.reload();
            }

            // Toggle between main and completed tables
            completedButton.on('click', function() {
                isShowingCompleted = !isShowingCompleted;
                localStorage.setItem('isShowingCompleted', isShowingCompleted);
                if (isShowingCompleted) {
                    $('#data-table').closest('.card').addClass('d-none');
                    $('#completedTableContainer').removeClass('d-none');
                    $(this).removeClass('completed').addClass('unvalidated');
                    $(this).html(`<i class="fas fa-times-circle"></i> Unvalidated`);
                    completedTable.ajax.reload();
                } else {
                    $('#completedTableContainer').addClass('d-none');
                    $('#data-table').closest('.card').removeClass('d-none');
                    $(this).removeClass('unvalidated').addClass('completed');
                    $(this).html(`<i class="fas fa-check-circle"></i> Completed`);
                    mainTable.ajax.reload();
                }
            });

            // Handle form submission via AJAX
            $('#formTambahData').on('submit', function(e) {
                e.preventDefault();
                let formData = $(this).serializeArray();
                let endDateTime = new Date(formData.find(item => item.name === 'EndTime')?.value);
                let data = {
                    id: new Date().getTime().toString(), // Generate a temporary ID
                    durasi_iot: formData.find(item => item.name === 'DryingTime')?.value || '-',
                    tanggal: endDateTime ? endDateTime.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric'
                    }) : '-',
                    jam: endDateTime ? endDateTime.toLocaleTimeString('id-ID', {
                        hour: '2-digit',
                        minute: '2-digit'
                    }) : '-',
                    durasi_validasi: formData.find(item => item.name === 'DryingTimeValidated')
                        ?.value || '-',
                    is_validated: isShowingCompleted // Assign validation status based on current view
                };
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $('#tambahDataModal').modal('hide');
                        $('#formTambahData')[0].reset();
                        if (isShowingCompleted) {
                            completedTable.row.add(data).draw();
                        } else {
                            mainTable.row.add(data).draw();
                        }
                        alert('Data saved successfully!');
                    },
                    error: function(xhr) {
                        alert('Failed to save data: ' + (xhr.responseJSON?.error ||
                            'Unknown error'));
                    }
                });
            });

            // Function to validate data
            window.validateData = function(id) {
                if (confirm('Apakah Anda yakin ingin memvalidasi data ini?')) {
                    $.ajax({
                        url: '/validasi/' + id + '/validate',
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            // Find the row in the unvalidated table
                            let rowData;
                            mainTable.rows().every(function() {
                                if (this.data().id === id) {
                                    rowData = this.data();
                                    this.remove();
                                }
                            });
                            mainTable.draw();

                            // Add to completed table
                            if (rowData) {
                                rowData.is_validated = true;
                                completedTable.row.add(rowData).draw();
                            }
                            alert('Data berhasil divalidasi!');
                        },
                        error: function(xhr) {
                            alert('Gagal memvalidasi data: ' + (xhr.responseJSON?.error ||
                                'Unknown error'));
                        }
                    });
                }
            };

            // Placeholder edit and delete functions
            window.editData = function(id) {
                alert('Edit functionality not implemented. ID: ' + id);
                // TODO: Fetch data by ID and populate modal for editing
            };

            window.deleteData = function(id) {
                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    $.ajax({
                        url: '/training-data/' + id,
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function() {
                            if (isShowingCompleted) {
                                completedTable.rows().every(function() {
                                    if (this.data().id === id) {
                                        this.remove();
                                    }
                                });
                                completedTable.draw();
                            } else {
                                mainTable.rows().every(function() {
                                    if (this.data().id === id) {
                                        this.remove();
                                    }
                                });
                                mainTable.draw();
                            }
                            alert('Data deleted successfully!');
                        },
                        error: function(xhr) {
                            alert('Failed to delete data: ' + (xhr.responseJSON?.error ||
                                'Unknown error'));
                        }
                    });
                }
            };
        });
    </script>
@endsection

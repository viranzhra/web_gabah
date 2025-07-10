@extends('layout.app')

@section('content')
    <style>
        .table-responsive {
            overflow-x: auto;
        }
        /* Memastikan semua judul kolom rata tengah */
        #riwayatTable thead th {
            text-align: center;
            vertical-align: middle;
            background-color: #f8f9fa;
            font-weight: 600;
            color: #333;
        }
        /* Styling untuk baris tabel */
        #riwayatTable tbody tr {
            cursor: pointer;
            transition: background-color 0.2s;
        }
        #riwayatTable tbody tr:hover {
            background-color: #e9f7ff;
        }
        .filter-group {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }
        .filter-group label {
            margin-bottom: 5px;
            font-weight: 500;
            color: #4F4F4F;
        }
        .filter-group input {
            border-radius: 8px;
            border: 1px solid #DAD9D9;
            padding: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: border-color 0.2s;
        }
        .filter-group input:focus {
            border-color: #1E3B8A;
            outline: none;
            box-shadow: 0 0 8px rgba(30, 59, 138, 0.3);
        }
        .card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
        }
        .card-body {
            padding: 20px;
        }
        .filter-group .btn-reset {
            border-radius: 8px;
            background-color: #dc3545;
            color: white;
            padding: 8px 16px;
            border: none;
            align-self: flex-end;
        }
        .filter-group .btn-reset:hover {
            background-color: #c82333;
        }
    </style>

    <h4 class="fw-semibold mb-3" style="margin-top: 10px;">Riwayat Kegiatan Pengeringan</h4>
    <div class="card mt-4">
        <div class="card-body">
            <div class="filter-group">
                <div>
                    <label for="filter_datetime_mulai">Tanggal & Jam Mulai</label>
                    <input type="datetime-local" id="filter_datetime_mulai" class="form-control">
                </div>
                <div>
                    <label for="filter_datetime_berakhir">Tanggal & Jam Berakhir</label>
                    <input type="datetime-local" id="filter_datetime_berakhir" class="form-control">
                </div>
                <div>
                    <label>&nbsp;</label>
                    <button id="reset_filter_btn" class="btn btn-reset">Reset Filter</button>
                </div>
            </div>
            <div class="table-responsive">
                <table id="riwayatTable" class="table table-bordered table-striped">
                    <thead class="text-center">
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Jenis Gabah</th>
                            <th colspan="2">Tanggal</th>
                            <th colspan="2">Jam</th>
                            <th colspan="2">Massa Gabah (Kg)</th>
                            <th rowspan="2">Durasi Terlaksana IoT (Menit)</th>
                            <th rowspan="2">Durasi Hasil Validasi (Menit)</th>
                            <th rowspan="2">Durasi Model ML (Menit)</th>
                        </tr>
                        <tr>
                            <th>Mulai</th>
                            <th>Berakhir</th>
                            <th>Mulai</th>
                            <th>Berakhir</th>
                            <th>Awal</th>
                            <th>Akhir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan diisi oleh DataTables via AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        (function($) {
            $(document).ready(function() {
                var table = $('#riwayatTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route("riwayat.data") }}',
                        type: 'GET',
                        data: function(d) {
                            d.datetime_mulai = $('#filter_datetime_mulai').val();
                            d.datetime_berakhir = $('#filter_datetime_berakhir').val();
                        },
                        dataSrc: 'data',
                        error: function(xhr) {
                            console.error('AJAX Error:', xhr);
                            alert('Terjadi kesalahan saat memuat data: ' + (xhr.status === 500 ?
                                'Kesalahan server. Silakan coba lagi.' :
                                'Terjadi kesalahan.'));
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
                            data: 'jenis_gabah',
                            defaultContent: '-'
                        },
                        {
                            data: 'tanggal_mulai',
                            defaultContent: '-'
                        },
                        {
                            data: 'tanggal_berakhir',
                            defaultContent: '-'
                        },
                        {
                            data: 'jam_mulai',
                            defaultContent: '-'
                        },
                        {
                            data: 'jam_berakhir',
                            defaultContent: '-'
                        },
                        {
                            data: 'massa_awal',
                            defaultContent: '-'
                        },
                        {
                            data: 'massa_akhir',
                            defaultContent: '-'
                        },
                        {
                            data: 'durasi_iot',
                            defaultContent: '-'
                        },
                        {
                            data: 'durasi_validasi',
                            defaultContent: '-'
                        },
                        {
                            data: 'durasi_ml',
                            defaultContent: '-'
                        }
                    ]
                });

                // Event untuk otomatis filter saat Tanggal & Jam Mulai diubah
                $('#filter_datetime_mulai').on('change', function() {
                    table.ajax.reload();
                });

                // Event untuk otomatis filter saat Tanggal & Jam Berakhir diubah
                $('#filter_datetime_berakhir').on('change', function() {
                    table.ajax.reload();
                });

                // Event untuk klik baris
                $('#riwayatTable tbody').on('click', 'tr', function() {
                    var data = table.row(this).data();
                    if (data && data.id) {
                        window.location.href = '{{ route("riwayat.detail", ":id") }}'.replace(':id', data.id);
                    }
                });

                // Event untuk reset filter
                $('#reset_filter_btn').on('click', function() {
                    $('#filter_datetime_mulai').val('');
                    $('#filter_datetime_berakhir').val('');
                    table.ajax.reload();
                });
            });
        })(jQuery.noConflict(true));
    </script>

@endsection
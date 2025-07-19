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
            /* background-color: #f8f9fa; */
            font-weight: 600;
            color: #333;
        }

        /* Styling untuk baris tabel */
        #riwayatTable tbody tr {
            cursor: pointer;
            transition: background-color 0.2s;
        }

        #riwayatTable tbody tr:hover {
            /* background-color: #e9f7ff; */
        }

        .filter-group {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
            align-items: flex-end;
            /* Menyelaraskan elemen ke bawah */
        }

        .filter-item {
            flex: 1;
            min-width: 200px;
            /* Minimal lebar untuk mencegah input terlalu kecil */
        }

        .filter-item label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.25rem;
        }

        .filter-item input.form-control {
            width: 100%;
            padding: 0.5rem;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            height: 2.5rem;
            /* Tinggi sama dengan tombol */
            font-size: 0.875rem;
            transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            background-color: white;
        }

        .filter-item input.form-control:focus {
            outline: none;
            border-color: #1e3a8a;
            /* Warna biru sesuai tema Anda */
            box-shadow: 0 0 0 2px rgba(30, 58, 138, 0.2);
        }

        .filter-item.filter-button {
            flex: 0 0 auto;
            /* Tombol tidak mengambil ruang flex penuh */
        }

        .filter-item button.btn-reset {
            padding: 0.5rem 1rem;
            background-color: #e5e7eb;
            color: #374151;
            border: none;
            border-radius: 0.375rem;
            height: 2.5rem;
            /* Tinggi sama dengan input */
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
            min-width: 30px;
            /* Lebar minimal untuk konsistensi */
        }

        .filter-item button.btn-reset:hover {
            background-color: #d1d5db;
        }

        /* Responsivitas */
        @media (max-width: 768px) {
            .filter-group {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-item {
                min-width: 100%;
            }

            .filter-item.filter-button {
                display: flex;
                justify-content: flex-end;
                /* Tombol tetap di kanan pada layar kecil */
            }

            .filter-item button.btn-reset {
                width: 100%;
                /* Tombol penuh pada layar kecil */
            }
        }

        .btn-number {
            background-color: #bfdbfe;
            /* bg-blue-100 */
            color: #1e3a8a;
            /* text-blue-900 */
            font-weight: 600;
            padding: 4px 8px;
            border-radius: 0.375rem;
            border: none;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
            font-size: 12px;
        }

        .btn-number:hover {
            background-color: #A0B8FF;
            /* Warna lebih gelap saat hover */
        }
    </style>

    <h4 class="fw-semibold mb-3" style="margin-top: 10px;">Riwayat Kegiatan Pengeringan</h4>
    <div class="filter-group">
        <div class="filter-item">
            <label for="filter_datetime_mulai">Waktu Mulai</label>
            <input type="datetime-local" id="filter_datetime_mulai" class="form-control">
        </div>
        <div class="filter-item">
            <label for="filter_datetime_berakhir">Waktu Berakhir</label>
            <input type="datetime-local" id="filter_datetime_berakhir" class="form-control">
        </div>
        <div class="filter-item filter-button">
            <label>&nbsp;</label> <!-- Placeholder untuk menjaga keselarasan -->
            <button id="reset_filter_btn"
                class="btn btn-reset w-full md:w-auto bg-gray-200 text-gray-700 px-4 py-2 rounded-md h-10 hover:bg-gray-300 transition flex items-center justify-center gap-2">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-body">
            <div class="table-responsive" style="overflow-x: auto;">
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
                        url: '{{ route('riwayat.data') }}',
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
                    columns: [{
                            data: null,
                            render: function(data, type, row, meta) {
                                return `<button class="btn-number bg-blue-100 text-blue-900 font-semibold py-1 px-3 rounded-md hover:bg-blue-200 transition ease-in-out duration-200" data-id="${row.id}" aria-label="Lihat detail untuk nomor ${meta.row + meta.settings._iDisplayStart + 1}">${meta.row + meta.settings._iDisplayStart + 1}</button>`;
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

                // Event untuk klik tombol nomor
                $('#riwayatTable').on('click', '.btn-number', function() {
                    var id = $(this).data('id');
                    if (id) {
                        window.location.href = '{{ route('riwayat.detail', ':id') }}'.replace(':id',
                            id);
                    }
                });

                // Event untuk klik baris (opsional, jika masih ingin baris dapat diklik)
                $('#riwayatTable tbody').on('click', 'tr', function(e) {
                    if ($(e.target).is('.btn-number'))
                        return; // Hindari double trigger jika klik tombol
                    var data = table.row(this).data();
                    if (data && data.id) {
                        window.location.href = '{{ route('riwayat.detail', ':id') }}'.replace(':id',
                            data.id);
                    }
                });

                // Event untuk otomatis filter saat Tanggal & Jam Mulai diubah
                $('#filter_datetime_mulai').on('change', function() {
                    table.ajax.reload();
                });

                // Event untuk otomatis filter saat Tanggal & Jam Berakhir diubah
                $('#filter_datetime_berakhir').on('change', function() {
                    table.ajax.reload();
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

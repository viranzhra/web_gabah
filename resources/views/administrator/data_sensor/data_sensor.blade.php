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

        /* Styling untuk Select2 agar lebih bagus */
        .select2-container--default .select2-selection--single {
            border: 1px solid #1E3B8A;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(30, 59, 138, 0.1);
            transition: all 0.3s ease;
        }

        .select2-container--default .select2-selection--single:hover {
            box-shadow: 0 4px 12px rgba(30, 59, 138, 0.15);
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #1E3B8A;
            font-weight: 500;
            padding-left: 12px;
            padding-right: 24px;
            line-height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
            right: 10px;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #1E3B8A;
            border-radius: 6px;
            padding: 6px;
            font-size: 14px;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #1E3B8A;
            color: white;
        }

        .select2-container--default .select2-results__option {
            padding: 8px 12px;
            font-size: 14px;
        }

        #process_id.select2-hidden-accessible + .select2-container {
            margin-left: 20px;
        }

    </style>

    <h4 class="fw-semibold mb-3" style="margin-top: 10px;">Data Sensor</h4>

    <!-- CSS untuk Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <div class="btn-group mt-3" role="group" aria-label="Data Sensor Device Buttons">
    @if ($deviceNames->isEmpty())
        <div class="alert alert-warning">Tidak ada device yang ditemukan.</div>
    @else
        <select name="device_id" id="device_id" class="form-select select2" style="width: 200px;">
            <option value="">-- Pilih Device --</option>
            @foreach ($deviceNames as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
        <select name="process_id" id="process_id" class="form-select select2" style="width: 250px; margin-left: 10px;">
            <option value="">-- Pilih Proses Pengeringan --</option>
            <!-- Diisi via AJAX -->
        </select>
    @endif
</div>
<br>
<div class="card mt-4">
    <div class="card-body">
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="table table-striped table-bordered" id="data-table">
                <thead class="text-center">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center process-id-column">Proses Pengeringan</th>
                        <th class="text-center device-name-column">Nama Device</th>
                        <th class="text-center">Waktu Pencatatan</th>
                        <th class="text-center">Kadar Air Gabah</th>
                        <th class="text-center">Suhu Gabah</th>
                        <th class="text-center">Suhu Ruangan</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
(function($) {
    $(document).ready(function() {
        const sanctumToken = "{{ session('sanctum_token') ?? '' }}".replace(/\n|\r/g, '').trim();

        $('#device_id').select2({
            placeholder: "-- Pilih Device --",
            allowClear: true,
            width: 'resolve',
            minimumResultsForSearch: 1
        });

        $('#process_id').select2({
            placeholder: "-- Pilih Proses Pengeringan --",
            allowClear: true,
            width: 'resolve',
            minimumResultsForSearch: 1
        });

        // Load proses pengeringan
        $.ajax({
            url: '{{ config('services.api.base_url') }}/get_sensor/realtime',
            type: 'GET',
            headers: {
                'Authorization': `Bearer ${sanctumToken}`,
                'Accept': 'application/json'
            },
            success: function(json) {
                if (json.all_processes && json.all_processes.length > 0) {
                    json.all_processes.forEach(function(process) {
                        $('#process_id').append(
                            `<option value="${process.process_id}">Proses ${process.process_id} (${process.status})</option>`
                        );
                    });
                } else {
                    $('#process_id').append(
                        `<option value="" disabled>Tidak ada proses tersedia</option>`
                    );
                }
            },
            error: function(xhr) {
                $('#process_id').append(
                    `<option value="" disabled>Gagal memuat proses</option>`
                );
            }
        });

        let table;

        function loadData(deviceId, processId) {
            if (table) table.destroy();

            const showDeviceColumn = !deviceId;
            const showProcessColumn = !processId;

            table = $('#data-table').DataTable({
                ajax: {
                    url: '{{ config('services.api.base_url') }}/get_sensor/realtime',
                    data: function(d) {
                        if (deviceId) d.device_id = deviceId;
                        if (processId) d.process_id = processId;
                    },
                    headers: {
                        'Authorization': `Bearer ${sanctumToken}`,
                        'Accept': 'application/json'
                    },
                    dataSrc: function(json) {
                        $('.alert-info, .alert-warning, .alert-danger').remove();

                        if (json.error) {
                            $('#data-table').before(`<div class="alert alert-danger">${json.error}</div>`);
                            return [];
                        }

                        if (json.message) {
                            $('#data-table').before(`<div class="alert alert-info">${json.message}</div>`);
                        }

                        return json.data || [];
                    }
                },
                columns: [
                    {
                        data: null,
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    {
                        data: 'process_id',
                        className: 'text-center process-id-column',
                        visible: showProcessColumn,
                        render: function(data) {
                            return data ? `Proses ${data}` : '-';
                        }
                    },
                    {
                        data: 'device_name',
                        className: 'text-center device-name-column',
                        visible: showDeviceColumn,
                        defaultContent: '-'
                    },
                    { data: 'timestamp', className: 'text-center' },
                    { data: 'kadar_air_gabah', className: 'text-center' },
                    { data: 'suhu_gabah', className: 'text-center' },
                    { data: 'suhu_ruangan', className: 'text-center' }
                ],
                order: [[3, 'desc']],
                drawCallback: function() {
                    $('.device-name-column').toggle(showDeviceColumn);
                    $('.process-id-column').toggle(showProcessColumn);
                }
            });
        }

        // Load awal
        loadData('', '');

        // Filter Select2
        $('#device_id, #process_id').on('select2:select select2:clear', function() {
            loadData($('#device_id').val(), $('#process_id').val());
        });
    });
})(jQuery.noConflict(true));
</script>


@endsection

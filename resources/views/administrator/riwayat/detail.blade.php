@extends('layout.app')

@section('content')
    <style>
        .detail-card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 20px;
            background-color: #fff;
        }
        .detail-card h4 {
            color: #1E3B8A;
            margin-bottom: 20px;
        }
        .detail-card .row {
            margin-bottom: 15px;
        }
        .detail-card .label {
            font-weight: 500;
            color: #4F4F4F;
        }
        .detail-card .value {
            color: #333;
        }
        .btn-back {
            border-radius: 8px;
            background-color: #1E3B8A;
            color: white;
            padding: 8px 16px;
            border: none;
        }
        .btn-back:hover {
            background-color: #163075;
        }
        .table-responsive {
            overflow-x: auto;
        }
        #sensorTable {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }
        #sensorTable th, #sensorTable td {
            font-size: 14px;
            text-align: center;
            vertical-align: middle;
            padding: 8px;
            border: 1px solid #e5e7eb; /* border-gray-200 */
        }
        #sensorTable th {
            color: #1E3B8A;
            font-weight: 600;
        }
        #sensorTable tbody tr:hover {
            background-color: #f3f4f6; /* bg-gray-50 */
        }
        #sensorTable tfoot td {
            background-color: #f1f5f9; /* bg-gray-100 */
            font-weight: 600;
            color: #1E3B8A;
        }
        #sensorTable .interval-link {
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
        #sensorTable .interval-link:hover {
            background-color: #93c5fd;
        }

        .modal-content {
            border-radius: 8px;
        }
        .modal-header {
            /* background-color: #1E3B8A; */
            color: white;
        }
        .modal-body p {
            margin: 8px 0;
            color: #333;
        }
        .modal-body strong {
            color: #1E3B8A;
        }
    </style>

    <h4 class="fw-semibold mb-3" style="margin-top: 10px;">Detail Riwayat Kegiatan Pengeringan</h4>
        <a href="{{ route('riwayat.index') }}" class="btn btn-back mt-3" aria-label="Kembali ke daftar riwayat">Kembali</a>

    <div class="card mt-4">
        <div class="card-body">
            <h4>Data Sensor (ID: {{ $data['id'] ?? 'Tidak tersedia' }})</h4>
            <div class="table-responsive">
                <table id="sensorTable" class="table table-bordered table-striped" aria-label="Tabel data sensor untuk proses pengeringan ID {{ $data['id'] ?? 'Tidak tersedia' }}">
                    <thead>
                        <tr>
                            <th rowspan="2">Interval</th>
                            <th rowspan="2">Waktu</th>
                            <th rowspan="2">Suhu Pembakaran</th>
                            <th colspan="4">Suhu Ruangan</th>
                            <th colspan="4">Suhu Gabah</th>
                            <th colspan="4">Kadar Air Gabah</th>
                        </tr>
                        <tr>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan diisi oleh DataTables via AJAX -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">Rata-rata Keseluruhan</td>
                            <td id="avgSuhuPembakaran">-</td>
                            <td colspan="4" id="avgSuhuRuangan">-</td>
                            <td colspan="4" id="avgSuhuGabah">-</td>
                            <td colspan="4" id="avgKadarAirGabah">-</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal untuk menampilkan rata-rata per interval -->
    <div class="modal fade" id="averageModal" tabindex="-1" aria-labelledby="averageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="averageModalLabel">Rata-rata Sensor Interval</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Rata-rata Suhu Ruangan:</strong> <span id="modalAvgSuhuRuangan">-</span></p>
                    <p><strong>Rata-rata Suhu Gabah:</strong> <span id="modalAvgSuhuGabah">-</span></p>
                    <p><strong>Rata-rata Kadar Air Gabah:</strong> <span id="modalAvgKadarAirGabah">-</span></p>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-back" data-bs-dismiss="modal">Tutup</button> --}}
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap CSS -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function() {
            // Check if Bootstrap is loaded
            if (typeof bootstrap === 'undefined') {
                console.error('Bootstrap is not loaded.');
                alert('Gagal memuat Bootstrap. Periksa koneksi jaringan atau CDN.');
                return;
            }

            var table = $('#sensorTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('riwayat.sensor', $data['id']) }}',
                    type: 'GET',
                    dataSrc: function(json) {
                        console.log('API Response:', json); // Debugging
                        if (!json || !json.data) {
                            console.error('Invalid or empty JSON response');
                            return [];
                        }
                        return json.data;
                    },
                    error: function(xhr) {
                        console.error('AJAX Error:', xhr.responseText);
                        alert('Terjadi kesalahan saat memuat data sensor: ' + (xhr.status === 500 ?
                            'Kesalahan server. Silakan coba lagi.' :
                            'Terjadi kesalahan.'));
                    }
                },
                columns: [
                    {
                        data: 'interval',
                        defaultContent: '-',
                        render: function(data, type, row) {
                            if (type === 'display') {
                                return '<a href="#" class="interval-link" ' +
                                       'data-interval="' + (data || '-') + '" ' +
                                       'data-avg-suhu-ruangan="' + (row.avg_suhu_ruangan || '-') + '" ' +
                                       'data-avg-suhu-gabah="' + (row.avg_suhu_gabah || '-') + '" ' +
                                       'data-avg-kadar-air-gabah="' + (row.avg_kadar_air_gabah || '-') + '">' +
                                       (data || '-') + '</a>';
                            }
                            return data;
                        }
                    },
                    { data: 'waktu', defaultContent: '-' },
                    { data: 'suhu_pembakaran', defaultContent: '-' },
                    { data: 'suhu_ruangan_1', defaultContent: '-' },
                    { data: 'suhu_ruangan_2', defaultContent: '-' },
                    { data: 'suhu_ruangan_3', defaultContent: '-' },
                    { data: 'suhu_ruangan_4', defaultContent: '-' },
                    { data: 'suhu_gabah_1', defaultContent: '-' },
                    { data: 'suhu_gabah_2', defaultContent: '-' },
                    { data: 'suhu_gabah_3', defaultContent: '-' },
                    { data: 'suhu_gabah_4', defaultContent: '-' },
                    { data: 'kadar_air_gabah_1', defaultContent: '-' },
                    { data: 'kadar_air_gabah_2', defaultContent: '-' },
                    { data: 'kadar_air_gabah_3', defaultContent: '-' },
                    { data: 'kadar_air_gabah_4', defaultContent: '-' }
                ],
                order: [[0, 'asc']],
                language: {
                    processing: 'Memuat data...',
                    emptyTable: 'Tidak ada data sensor untuk proses ini.',
                    info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ entri',
                    infoEmpty: 'Menampilkan 0 sampai 0 dari 0 entri',
                    lengthMenu: 'Tampilkan _MENU_ entri',
                    search: 'Cari:',
                    paginate: {
                        first: 'Pertama',
                        last: 'Terakhir',
                        next: 'Selanjutnya',
                        previous: 'Sebelumnya'
                    }
                },
                footerCallback: function(row, data, start, end, display) {
                    var api = this.api();
                    var json = api.ajax.json();
                    if (json && json.averages) {
                        $('#avgSuhuPembakaran').text(json.averages.suhu_pembakaran || '-');
                        $('#avgSuhuRuangan').text(json.averages.suhu_ruangan || '-');
                        $('#avgSuhuGabah').text(json.averages.suhu_gabah || '-');
                        $('#avgKadarAirGabah').text(json.averages.kadar_air_gabah || '-');
                    } else {
                        console.error('No averages data in JSON response');
                        $('#avgSuhuPembakaran').text('-');
                        $('#avgSuhuRuangan').text('-');
                        $('#avgSuhuGabah').text('-');
                        $('#avgKadarAirGabah').text('-');
                    }
                }
            });

            // Event handler untuk klik pada tautan interval
            $('#sensorTable').on('click', '.interval-link', function(e) {
                e.preventDefault();
                var interval = $(this).data('interval');
                var avgSuhuRuangan = $(this).data('avg-suhu-ruangan');
                var avgSuhuGabah = $(this).data('avg-suhu-gabah');
                var avgKadarAirGabah = $(this).data('avg-kadar-air-gabah');

                // Validasi data
                if (!interval || avgSuhuRuangan === '-' || avgSuhuGabah === '-' || avgKadarAirGabah === '-') {
                    console.error('Invalid interval data:', {
                        interval: interval,
                        avgSuhuRuangan: avgSuhuRuangan,
                        avgSuhuGabah: avgSuhuGabah,
                        avgKadarAirGabah: avgKadarAirGabah
                    });
                    alert('Data rata-rata untuk interval ini tidak tersedia.');
                    return;
                }

                // Update konten modal
                $('#averageModalLabel').text('Rata-rata Sensor Interval ' + interval);
                $('#modalAvgSuhuRuangan').text(avgSuhuRuangan + ' °C');
                $('#modalAvgSuhuGabah').text(avgSuhuGabah + ' °C');
                $('#modalAvgKadarAirGabah').text(avgKadarAirGabah + ' %');

                // Tampilkan modal
                try {
                    var modal = new bootstrap.Modal(document.getElementById('averageModal'), {});
                    modal.show();
                } catch (error) {
                    console.error('Error showing modal:', error);
                    alert('Gagal menampilkan modal. Pastikan Bootstrap dimuat dengan benar.');
                }
            });
        });
    </script>
@endsection
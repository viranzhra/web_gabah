<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function data(Request $request)
    {
        // Data dummy (tidak diubah)
        $dummyData = [
            [
                'id' => 1,
                'jenis_gabah' => 'IR64',
                'tanggal_mulai' => '2025-07-01',
                'tanggal_berakhir' => '2025-07-02',
                'jam_mulai' => '08:00',
                'jam_berakhir' => '16:00',
                'massa_awal' => 1000,
                'massa_akhir' => 950,
                'durasi_iot' => 480,
                'durasi_validasi' => 450,
                'durasi_ml' => 420
            ],
            [
                'id' => 2,
                'jenis_gabah' => 'Ciherang',
                'tanggal_mulai' => '2025-07-03',
                'tanggal_berakhir' => '2025-07-04',
                'jam_mulai' => '09:00',
                'jam_berakhir' => '17:00',
                'massa_awal' => 1200,
                'massa_akhir' => 1150,
                'durasi_iot' => 510,
                'durasi_validasi' => 480,
                'durasi_ml' => 468
            ],
            [
                'id' => 3,
                'jenis_gabah' => 'Inpari 32',
                'tanggal_mulai' => '2025-07-05',
                'tanggal_berakhir' => '2025-07-06',
                'jam_mulai' => '07:30',
                'jam_berakhir' => '15:30',
                'massa_awal' => 800,
                'massa_akhir' => 750,
                'durasi_iot' => 450,
                'durasi_validasi' => 420,
                'durasi_ml' => 408
            ]
        ];

        // Server-side processing parameters
        $draw = $request->input('draw');
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $search = $request->input('search.value');
        $datetime_mulai = $request->input('datetime_mulai');
        $datetime_berakhir = $request->input('datetime_berakhir');

        // Filter data berdasarkan pencarian global
        $filteredData = $dummyData;
        if (!empty($search) && $search !== '') {
            $filteredData = array_filter($dummyData, function ($item) use ($search) {
                return stripos($item['jenis_gabah'], $search) !== false ||
                       stripos($item['tanggal_mulai'], $search) !== false ||
                       stripos($item['tanggal_berakhir'], $search) !== false ||
                       stripos($item['jam_mulai'], $search) !== false ||
                       stripos($item['jam_berakhir'], $search) !== false ||
                       stripos((string)$item['massa_awal'], $search) !== false ||
                       stripos((string)$item['massa_akhir'], $search) !== false ||
                       stripos((string)$item['durasi_iot'], $search) !== false ||
                       stripos((string)$item['durasi_validasi'], $search) !== false ||
                       stripos((string)$item['durasi_ml'], $search) !== false;
            });
            $filteredData = array_values($filteredData);
        }

        // Filter berdasarkan datetime mulai
        if (!empty($datetime_mulai)) {
            $filterStart = strtotime($datetime_mulai);
            $filteredData = array_filter($filteredData, function ($item) use ($filterStart) {
                $itemStart = strtotime($item['tanggal_mulai'] . ' ' . $item['jam_mulai']);
                return $itemStart >= $filterStart;
            });
            $filteredData = array_values($filteredData);
        }

        // Filter berdasarkan datetime berakhir
        if (!empty($datetime_berakhir)) {
            $filterEnd = strtotime($datetime_berakhir);
            $filteredData = array_filter($filteredData, function ($item) use ($filterEnd) {
                $itemEnd = strtotime($item['tanggal_berakhir'] . ' ' . $item['jam_berakhir']);
                return $itemEnd <= $filterEnd;
            });
            $filteredData = array_values($filteredData);
        }

        // Urutkan data
        $order = $request->input('order.0.column', 0);
        $dir = $request->input('order.0.dir', 'asc');
        $columnMap = [
            1 => 'jenis_gabah',
            2 => 'tanggal_mulai',
            3 => 'tanggal_berakhir',
            4 => 'jam_mulai',
            5 => 'jam_berakhir',
            6 => 'massa_awal',
            7 => 'massa_akhir',
            8 => 'durasi_iot',
            9 => 'durasi_validasi',
            10 => 'durasi_ml'
        ];

        if (isset($columnMap[$order])) {
            usort($filteredData, function ($a, $b) use ($columnMap, $order, $dir) {
                $key = $columnMap[$order];
                return $dir === 'asc' ? strcmp($a[$key], $b[$key]) : strcmp($b[$key], $a[$key]);
            });
        }

        // Paginasi
        $totalRecords = count($dummyData);
        $totalFiltered = count($filteredData);
        $paginatedData = array_slice($filteredData, $start, $length);

        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $paginatedData
        ]);
    }

    public function detail($id)
    {
        // Data dummy untuk simulasi halaman detail
        $dummyData = [
            1 => [
                'id' => 1,
                'jenis_gabah' => 'IR64',
                'tanggal_mulai' => '2025-07-01',
                'tanggal_berakhir' => '2025-07-02',
                'jam_mulai' => '08:00',
                'jam_berakhir' => '16:00',
                'massa_awal' => 1000,
                'massa_akhir' => 950,
                'durasi_iot' => 480,
                'durasi_validasi' => 450,
                'durasi_ml' => 420
            ],
            2 => [
                'id' => 2,
                'jenis_gabah' => 'Ciherang',
                'tanggal_mulai' => '2025-07-03',
                'tanggal_berakhir' => '2025-07-04',
                'jam_mulai' => '09:00',
                'jam_berakhir' => '17:00',
                'massa_awal' => 1200,
                'massa_akhir' => 1150,
                'durasi_iot' => 510,
                'durasi_validasi' => 480,
                'durasi_ml' => 468
            ],
            3 => [
                'id' => 3,
                'jenis_gabah' => 'Inpari 32',
                'tanggal_mulai' => '2025-07-05',
                'tanggal_berakhir' => '2025-07-06',
                'jam_mulai' => '07:30',
                'jam_berakhir' => '15:30',
                'massa_awal' => 800,
                'massa_akhir' => 750,
                'durasi_iot' => 450,
                'durasi_validasi' => 420,
                'durasi_ml' => 408
            ]
        ];

        // Cari data berdasarkan ID
        $data = $dummyData[$id] ?? null;

        if (!$data) {
            abort(404, 'Data tidak ditemukan');
        }

        return view('administrator.riwayat.detail', compact('data'));
    }

    public function sensor($id, Request $request)
    {
        // Data dummy untuk sensor berdasarkan ID
        $dummySensorData = [
            1 => [
                [
                    'interval' => 1,
                    'waktu' => '2025-07-01 08:00:00',
                    'suhu_pembakaran' => 50.5,
                    'suhu_ruangan_1' => 25.0,
                    'suhu_ruangan_2' => 25.2,
                    'suhu_ruangan_3' => 24.8,
                    'suhu_ruangan_4' => 25.1,
                    'suhu_gabah_1' => 30.0,
                    'suhu_gabah_2' => 30.5,
                    'suhu_gabah_3' => 29.8,
                    'suhu_gabah_4' => 30.2,
                    'kadar_air_gabah_1' => 14.5,
                    'kadar_air_gabah_2' => 14.3,
                    'kadar_air_gabah_3' => 14.7,
                    'kadar_air_gabah_4' => 14.4
                ],
                [
                    'interval' => 2,
                    'waktu' => '2025-07-01 08:30:00',
                    'suhu_pembakaran' => 51.0,
                    'suhu_ruangan_1' => 25.5,
                    'suhu_ruangan_2' => 25.7,
                    'suhu_ruangan_3' => 25.0,
                    'suhu_ruangan_4' => 25.4,
                    'suhu_gabah_1' => 31.0,
                    'suhu_gabah_2' => 31.2,
                    'suhu_gabah_3' => 30.9,
                    'suhu_gabah_4' => 31.1,
                    'kadar_air_gabah_1' => 14.2,
                    'kadar_air_gabah_2' => 14.0,
                    'kadar_air_gabah_3' => 14.4,
                    'kadar_air_gabah_4' => 14.1
                ]
            ],
            2 => [
                [
                    'interval' => 1,
                    'waktu' => '2025-07-03 09:00:00',
                    'suhu_pembakaran' => 49.8,
                    'suhu_ruangan_1' => 24.5,
                    'suhu_ruangan_2' => 24.7,
                    'suhu_ruangan_3' => 24.3,
                    'suhu_ruangan_4' => 24.6,
                    'suhu_gabah_1' => 29.5,
                    'suhu_gabah_2' => 29.8,
                    'suhu_gabah_3' => 29.3,
                    'suhu_gabah_4' => 29.6,
                    'kadar_air_gabah_1' => 15.0,
                    'kadar_air_gabah_2' => 14.8,
                    'kadar_air_gabah_3' => 15.2,
                    'kadar_air_gabah_4' => 14.9
                ]
            ],
            3 => [
                [
                    'interval' => 1,
                    'waktu' => '2025-07-05 07:30:00',
                    'suhu_pembakaran' => 48.5,
                    'suhu_ruangan_1' => 23.8,
                    'suhu_ruangan_2' => 24.0,
                    'suhu_ruangan_3' => 23.6,
                    'suhu_ruangan_4' => 23.9,
                    'suhu_gabah_1' => 28.5,
                    'suhu_gabah_2' => 28.8,
                    'suhu_gabah_3' => 28.3,
                    'suhu_gabah_4' => 28.6,
                    'kadar_air_gabah_1' => 15.5,
                    'kadar_air_gabah_2' => 15.3,
                    'kadar_air_gabah_3' => 15.7,
                    'kadar_air_gabah_4' => 15.4
                ]
            ]
        ];

        // Cari data sensor berdasarkan ID
        $sensorData = $dummySensorData[$id] ?? [];

        // Hitung rata-rata per interval dan rata-rata keseluruhan
        $averages = [
            'suhu_pembakaran' => 0,
            'suhu_ruangan' => 0,
            'suhu_gabah' => 0,
            'kadar_air_gabah' => 0
        ];
        $count = count($sensorData);

        if ($count > 0) {
            $sumSuhuPembakaran = 0;
            $sumSuhuRuangan = 0;
            $sumSuhuGabah = 0;
            $sumKadarAirGabah = 0;

            foreach ($sensorData as &$row) {
                // Hitung rata-rata per interval untuk digunakan di frontend (modal)
                $row['avg_suhu_ruangan'] = round(
                    ($row['suhu_ruangan_1'] + $row['suhu_ruangan_2'] + $row['suhu_ruangan_3'] + $row['suhu_ruangan_4']) / 4,
                    2
                );
                $row['avg_suhu_gabah'] = round(
                    ($row['suhu_gabah_1'] + $row['suhu_gabah_2'] + $row['suhu_gabah_3'] + $row['suhu_gabah_4']) / 4,
                    2
                );
                $row['avg_kadar_air_gabah'] = round(
                    ($row['kadar_air_gabah_1'] + $row['kadar_air_gabah_2'] + $row['kadar_air_gabah_3'] + $row['kadar_air_gabah_4']) / 4,
                    2
                );

                // Akumulasi untuk rata-rata keseluruhan
                $sumSuhuPembakaran += $row['suhu_pembakaran'];
                $sumSuhuRuangan += $row['avg_suhu_ruangan'];
                $sumSuhuGabah += $row['avg_suhu_gabah'];
                $sumKadarAirGabah += $row['avg_kadar_air_gabah'];
            }
            unset($row); // Lepaskan referensi

            $averages['suhu_pembakaran'] = round($sumSuhuPembakaran / $count, 2);
            $averages['suhu_ruangan'] = round($sumSuhuRuangan / $count, 2);
            $averages['suhu_gabah'] = round($sumSuhuGabah / $count, 2);
            $averages['kadar_air_gabah'] = round($sumKadarAirGabah / $count, 2);
        }

        // Server-side processing parameters
        $draw = $request->input('draw');
        $start = $request->input('start', 0);
        $length = $request->input('length', 10);
        $search = $request->input('search.value');

        // Filter data berdasarkan pencarian global
        $filteredData = $sensorData;
        if (!empty($search) && $search !== '') {
            $filteredData = array_filter($sensorData, function ($item) use ($search) {
                return stripos((string)$item['interval'], $search) !== false ||
                       stripos($item['waktu'], $search) !== false ||
                       stripos((string)$item['suhu_pembakaran'], $search) !== false ||
                       stripos((string)$item['suhu_ruangan_1'], $search) !== false ||
                       stripos((string)$item['suhu_ruangan_2'], $search) !== false ||
                       stripos((string)$item['suhu_ruangan_3'], $search) !== false ||
                       stripos((string)$item['suhu_ruangan_4'], $search) !== false ||
                       stripos((string)$item['suhu_gabah_1'], $search) !== false ||
                       stripos((string)$item['suhu_gabah_2'], $search) !== false ||
                       stripos((string)$item['suhu_gabah_3'], $search) !== false ||
                       stripos((string)$item['suhu_gabah_4'], $search) !== false ||
                       stripos((string)$item['kadar_air_gabah_1'], $search) !== false ||
                       stripos((string)$item['kadar_air_gabah_2'], $search) !== false ||
                       stripos((string)$item['kadar_air_gabah_3'], $search) !== false ||
                       stripos((string)$item['kadar_air_gabah_4'], $search) !== false ||
                       stripos((string)$item['avg_suhu_ruangan'], $search) !== false ||
                       stripos((string)$item['avg_suhu_gabah'], $search) !== false ||
                       stripos((string)$item['avg_kadar_air_gabah'], $search) !== false;
            });
            $filteredData = array_values($filteredData);
        }

        // Paginasi
        $totalRecords = count($sensorData);
        $totalFiltered = count($filteredData);
        $paginatedData = array_slice($filteredData, $start, $length);

        // Format respons untuk DataTables
        return response()->json([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $paginatedData,
            'averages' => $averages
        ]);
    }
}